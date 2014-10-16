<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class People extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('time');
        $this->load->helper('my_form');
        $this->load->helper('cookie');
        $this->load->library('encrypt');
        
		if($this->session->userdata('language')) {
			$lang = $this->session->userdata('language');
		} else {
			$language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
			if (preg_match("/zh-c/i", $language)||$language=='cn'){
				$lang = 2;
			} else {
				$lang = 1;
			}
			
		}
        if ($lang==2)
        {
        	$this->lang->load('header','chinese');
        	$this->lang->load('footer','chinese');
        	$this->lang->load('user','chinese');
        	$this->lang->load('account','chinese');
        	$this->lang->load('single_work','chinese');
        	$this->lang->load('pop','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('user','english');
        	$this->lang->load('account','english');
        	$this->lang->load('single_work','english');
        	$this->lang->load('pop','english');
        }
        
		if ($this->session->userdata('id')==null) {
        	if (get_cookie('effecthub_user')&&get_cookie('effecthub_password')) {
        		$user = $this->encrypt->decode(get_cookie('effecthub_user'));
        		$password = $this->encrypt->decode(get_cookie('effecthub_password'));
        		$this->load->model('user_model');
        		$this->user_model->id = $user;
        		$this->user_model->password = $password;
        		$valid_user = $this->user_model->check_user_login();
        		if ($valid_user!==null) {
        			$this->session->set_userdata($valid_user);
        		}
        	}
        }
        
        
    }
	
	public function index($name)
	{
		$this->load->model('user_model');
        $data = array();
        	$this->load->model('user_social_model');
        	$data['user'] = $this->user_model->loadByName($name);
        	$data['social_list'] = $this->user_social_model->loadByUser($data['user']['id']);
        	$this->load->model('item_fav_model');
        	$data['likes_num'] = $this->item_fav_model->count_item_favs(array('uid'=>$data['user']['id']));
        	
        	$this->load->model('item_model');      
			$res= $this->item_model->find_items(array('user'=>$data['user']['id'],'order'=>'update_date'),0);
			$data['works_num']= count($res);
			
	        $this->load->library('pagination');//加载分页类
	        $config['base_url'] = base_url().'user/index/'.$data['user']['id'];//设置分页的url路径
	        $config['total_rows'] = count($res);//得到数据库中的记录的总条数
	        $config['uri_segment'] = 4;
	        $config['per_page'] = '9';//每页记录数
	        $config['first_link'] = 'First';
	        $config['last_link'] = 'Last';
	        $config['full_tag_open'] = '<p>';
	 	    $config['full_tag_close'] = '</p>'; 
	        $this->pagination->initialize($config);//分页的初始化
	        $data['user_item_list'] = $this->item_model->find_items(array('user'=>$data['user']['id'],'order'=>'update_date'),$config['per_page'],$this->uri->segment(4));//得到数据库记录
	        
			$taglist = Array();
			foreach($data['user_item_list'] as $item){
				$tok = strtok($item['tags']," ,"); 
				while($tok !== false){
					if(!in_array($tok,$taglist)){
						if($tok!='')
						array_push($taglist,$tok);
					}
					$tok = strtok(" ,"); 
				}
			}
			$data['tags'] = $taglist;
			$this->load->model('user_follow_model');
			if ($this->session->userdata('id')!=null){
	   			$data['follow'] = $this->user_follow_model->loadByUserAndFav($data['user']['id'],$this->session->userdata('id'));
	   		}
	   		$data['nav']= 'profile';
        $data['feature']= 'works';
        $this->load->model('country_model');
		$country = $this->country_model->load($data['user']['countryCode']);
		$data['country_name'] = $country['full_name'];
		$this->load->model('user_status_model');       
		$data['activity_list']= $this->user_status_model->find_status(array('user'=>$data['user']['id']),5);
        $this->load->model('item_model');
        $data['view_num'] = $this->item_model->get_sum_viewnum($data['user']['id']);
        $data['fav_num'] = $this->item_model->get_sum_favnum($data['user']['id']);
		$this->load->view('user/user',$data);
	}
	
}