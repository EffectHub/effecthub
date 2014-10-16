<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Author extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        
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
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('user','english');
        }
    }
	
	public function index()
	{
		$this->load->model('item_model');
		$this->load->model('user_model');
		$data['user_list'] = $this->user_model->order_popular_author();
		$data['new_user_list'] = $this->user_model->order_new_author();
		//$res= $this->user_model->find_allusers();
		$user_count = $this->user_model->count_users();
		$data['user_count'] = $user_count;
        $this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'author/index';//设置分页的url路径
        $config['total_rows'] = $user_count;//得到数据库中的记录的总条数
        $config['uri_segment']=3;
        $config['per_page'] = '20';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $data['author_list']= $this->user_model->find_users(array('active'=>1),$config['per_page'],$this->uri->segment(3));//得到数据库记录		
		$data['nav']= 'explore';
		$data['feature']= 'author';
		//$data['author_list'] =$this->user_model->find_users(array(), 100, 0);
		$data['item_list_everyauthor'] = array();
		foreach ($data['author_list'] as $v1)   
        {  
        	$data['item_list_'.$v1['id']] = $this->item_model->find_item_by_authorid($v1['id']);
        	$data['item_list_everyauthor'][$v1['id']] = $data['item_list_'.$v1['id']];
        }
		$this->load->view('user/author_list',$data);
	}
	
	function authorSearch($key=null)
	{
		/*$this->load->model('item_model');
		$data['item_list'] = $this->item_model->find_items(array(), 100, 0);
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array(), 100, 0);
		$taglist = Array();
		foreach($data['item_list'] as $item){
			$tok = strtok($item['tags']," ,"); 
			while($tok !== false){
				    if(!in_array($tok,$taglist)){
					   if($tok!='')
					   array_push($taglist,$tok);
				    }
				    $tok = strtok(" ,"); 
			} 
		}
		
		$data['tags'] = $this->user_model->order_popular_tag($taglist);*/
		$data['nav']= 'explore';
		$data['feature']= 'author';
		$this->load->model('user_model');
		$data['user_list'] = $this->user_model->order_popular_author();
		$data['new_user_list'] = $this->user_model->order_new_author();
		//$res= $this->user_model->find_allusers();
		$user_count = $this->user_model->count_users();
		$data['user_count'] = $user_count;
		
		$input_str = $this->input->post('search');
		if(!$input_str)$input_str = $key;
		else $key = $input_str;
		$res =$this->user_model->find_user_by_name($input_str);
		$this->load->model('item_model');
		$this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'index.php/author/authorSearch/'.$key;//设置分页的url路径
        $config['total_rows'] = count($res);//得到数据库中的记录的总条数
        $config['per_page'] = '20';//每页记录数
        $config['uri_segment']=4;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $data['author_list']= $this->user_model->find_user_by_name_offset($input_str,$config['per_page'],$this->uri->segment(4));//得到数据库记录	
        
		$data['item_list_everyauthor'] = array();
		foreach ($data['author_list'] as $v1)   
        {  
        	$data['item_list_'.$v1['id']] = $this->item_model->find_item_by_authorid($v1['id']);
        	$data['item_list_everyauthor'][$v1['id']] = $data['item_list_'.$v1['id']];
        }
        
        $data['input_str'] = $input_str;
        
		$this->load->view('user/author_list',$data);
	}
	
	function countrySearch($countrycode)
	{
		$this->load->model('item_model');
		$this->load->model('user_model');
		$data['user_list'] = $this->user_model->order_popular_author();
		$data['new_user_list'] = $this->user_model->order_new_author();
		//$res= $this->user_model->find_allusers();
		$user_count = $this->user_model->count_users();
		$data['user_count'] = $user_count;
		$data['nav']= 'explore';
		$data['feature']= 'author';
		$res =$this->user_model->find_user_by_country($countrycode);
		
		$this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'index.php/author/countrySearch/'.$countrycode;//设置分页的url路径
        $config['total_rows'] = count($res);//得到数据库中的记录的总条数
        $config['per_page'] = '20';//每页记录数
        $config['first_link'] = 'First';
        $config['uri_segment']=4;
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $data['author_list']= $this->user_model->find_user_by_country_offset($countrycode,$config['per_page'],$this->uri->segment(4));//得到数据库记录	
        
		$data['item_list_everyauthor'] = array();
		foreach ($data['author_list'] as $v1)   
        {  
        	$data['item_list_'.$v1['id']] = $this->item_model->find_item_by_authorid($v1['id']);
        	$data['item_list_everyauthor'][$v1['id']] = $data['item_list_'.$v1['id']];
        }
		$this->load->view('user/author_list',$data);
	}
	
	function levelSearch($level)
	{
		$this->load->model('item_model');
		$this->load->model('user_model');
		$data['user_list'] = $this->user_model->order_popular_author();
		$data['new_user_list'] = $this->user_model->order_new_author();
		//$res= $this->user_model->find_allusers();
		$user_count = $this->user_model->count_users();
		$data['user_count'] = $user_count;
		$data['nav']= 'explore';
		$data['feature']= 'author';
		$res =$this->user_model->find_user_by_level($level);
		
		$this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'index.php/author/levelSearch/'.$level;//设置分页的url路径
        $config['total_rows'] = count($res);//得到数据库中的记录的总条数
        $config['per_page'] = '20';//每页记录数
        $config['first_link'] = 'First';
        $config['uri_segment']=4;
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $data['author_list']= $this->user_model->find_user_by_level_offset($level,$config['per_page'],$this->uri->segment(4));//得到数据库记录	
        
		$data['item_list_everyauthor'] = array();
		foreach ($data['author_list'] as $v1)   
        {  
        	$data['item_list_'.$v1['id']] = $this->item_model->find_item_by_authorid($v1['id']);
        	$data['item_list_everyauthor'][$v1['id']] = $data['item_list_'.$v1['id']];
        }
		$this->load->view('user/author_list',$data);
	}
}
