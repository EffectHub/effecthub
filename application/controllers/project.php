<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {
	
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
        	$this->lang->load('pop','chinese');
        	$this->lang->load('file','chinese');
        	
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('user','english');
        	$this->lang->load('pop','english');
        	$this->lang->load('file','english');
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
	
	public function index()
	{
		$userid =$this->session->userdata('id');
    	$data['nav']= 'works';
    	$data['feature']= 'projects';
    	
		$this->load->model('item_model');
		
		$count= $this->item_model->count_items(array('order'=>'update_date','folder_id'=>0,'user'=>$userid,'work_id'=>0),0);
		$data['works_num']= $count;
		
        $this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'project/index/';//设置分页的url路径
        $config['total_rows'] = $count;//得到数据库中的记录的总条数
        $config['uri_segment'] = 3;
        $config['per_page'] = '8';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $data['project_list'] = $this->item_model->find_items(array('order'=>'update_date','folder_id'=>0,'user'=>$userid,'work_id'=>0),$config['per_page'],$this->uri->segment(3));//得到数据库记录
        
		
		$this->load->view('project/project_list',$data);
	}
	
	public function files($id=0)
	{
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
		if (preg_match("/zh-c/i", $lang)||$lang=='cn') {
			$data['lang'] = 'cn';
		} else {
			$data['lang'] = 'en';
		}
        $this->load->model('item_model');
		$this->load->model('user_model');
		$userid =$this->session->userdata('id');
    	$user = $this->user_model->load($userid);
    	
    	$data['user']= $user;
    	$data['nav']= 'works';
    	$data['feature']= 'assets';
    	
    	$data['item'] = $this->item_model->load($id);
    	if($data['item']==null){
   			redirect('item/none');
			exit();
   		}
    	if($data['item']['is_private']==1&&($this->session->userdata('id')!=$data['item']['user_id'])){
   			redirect('item/forbidden');
			exit();
   		}
    	$this->load->model('item_type_model');
    	$data['item_type_list'] = $this->item_type_model->find_item_types(array('fileable'=>1));
		$typeobj = $this->item_type_model->load($data['item']['type']);
		if ($data['lang'] == 1) $data['type_name'] = $typeobj['name_cn'];
		else $data['type_name'] = $typeobj['name'];
		$data['type'] = $typeobj['id'];
        if($id!=0){
        	
        		$data['item_list'] = $this->item_model->find_items(array('is_private'=>0,'work_id'=>$id,'order'=>'update_date','download'=>1));
        		$data['item_count'] = $this->item_model->count_items(array('is_private'=>0,'work_id'=>$id,'order'=>'update_date','download'=>1));
        	
        }
        //$data['folder_size'] = $this->item_model->get_sum_filesize($id);
		
			$data['follow'] = null;
			$data['watch'] = null;
			if ($this->session->userdata('id')!=null){
				$this->load->model('user_follow_model');
				$this->load->model('user_watch_model');
	   			$data['follow'] = $this->user_follow_model->loadByUserAndFav($data['item']['author_id'],$this->session->userdata('id'));
	   			$data['watch'] = $this->user_watch_model->loadByUserAndWatch($this->session->userdata('id'),$id,1);
	   		}
	   		$this->item_model->view_num = $data['item']['view_num']+1;
	        $this->item_model->updateViewNum($id);
	        
	   		$data['public_folder_list'] = $this->item_model->find_items(array('rand'=>1,'folder_id'=>0,'work_id'=>0,'is_private'=>0),4);
	   		$data['user_list'] = $this->user_model->find_users(array('rand'=>1,'active'=>1), 4, 0);
			$data['nav']= 'explore';
			$data['user']= $this->user_model->load($data['item']['author_id']);;
			$this->load->view('file/project',$data);
	}
}