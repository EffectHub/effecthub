<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
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
        	$this->lang->load('group','chinese');
        	$this->lang->load('single_work','chinese');
        	$this->lang->load('other','chinese');
        	$this->lang->load('pop','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('user','english');
        	$this->lang->load('group','english');
        	$this->lang->load('single_work','english');
        	$this->lang->load('other','english');
        	$this->lang->load('pop','english');
        }
        
        
		$subdomain_arr = explode('.', $_SERVER['HTTP_HOST'], 2);
		
        $subdomain_name = $subdomain_arr[0];
        if($subdomain_name=='effecthub'){
        	redirect('http://www.effecthub.com');
        }
        
        if($this->session->userdata('id')) {
			$userid =$this->session->userdata('id');

        	$this->load->model('user_notice_model');
    	    $notice_count = $this->user_notice_model->find_unread_count($userid);
        	$this->session->set_userdata('notice_count',$notice_count);
        	$this->load->model('user_mail_model');
        	$mail_count =$this->user_mail_model->find_unread_count($userid);
	        $this->session->set_userdata('mail_count',$mail_count);
	        $this->load->model('user_model');
    	    $user = $this->user_model->load($userid);
        	$this->session->set_userdata('point',$user['point']);
        	$this->session->set_userdata('balance',$user['balance']);
        	$this->session->set_userdata('balance_usd',$user['balance_usd']);
        
        	$this->load->model('team_notice_model','t_notice');
        	$team_notice = count($this->t_notice->load(array('user_id'=>$this->session->userdata('id'),'read'=>0),0,0,0));
        	$this->session->set_userdata('team_notice',$team_notice);
        } else {
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
	
	public function newsfeed($function=null,$parameter=null)
	{
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
		$data['lang']= $lang;
		$subdomain_arr = explode('.', $_SERVER['HTTP_HOST'], 2);
		
        $subdomain_name = $subdomain_arr[0];
		$this->load->model('tool_model');
		$this->load->model('user_model');
		/*if($subdomain_name==''||$subdomain_name==null||$subdomain_name=='effecthub'){
			redirect('home');
		}
        $data['tool'] = $this->tool_model->loadByKey($subdomain_name);
	   	if($data['tool']!=null){
	   		if($subdomain_name=='dragonbones'){
   				echo '<BASE HREF="'.base_url().'template/dragonbones/"/>';
	   			$this->load->file('template/dragonbones/index.html');
	   		}else{
	   			redirect(site_url('t/'.$data['tool']['domain'])); 
	   		}
	   	}else{
	   		$data['user'] = $this->user_model->loadByName($subdomain_name);
	   		if($data['user']!=null){
	   			redirect(site_url('people/'.$data['user']['name'])); 
	   		}else{
	   		*/
	   			$this->load->model('user_social_model');
				if ($this->session->userdata('id')!=null){
					$userid =$this->session->userdata('id');
			    	$user = $this->user_model->load($userid);
			    	
			    	$data['user']= $user;
		        	$data['nav']= 'works';
		        	$data['feature']= 'following';
		        	
			        $this->load->model('user_status_model');       
					if($user['follow_num']>5){
			        	$data['user_list'] = $this->user_model->find_users(array('rand'=>1,'active'=>1), 5, 0);
					}else{
						$user_list = $this->user_status_model->find_status_user();
						$data['user_list'] = $this->user_model->find_users(array('rand'=>1,'in'=>$user_list), 5, 0);
					}
			        $this->load->model('country_model');
					$country = $this->country_model->load($data['user']['countryCode']);
					$data['country_name'] = $country['full_name'];
					
					$res= $this->user_status_model->find_status_by_myfollow($userid);
			        $this->load->library('pagination');//加载分页类
			        $config['base_url'] = base_url().'home/index';//设置分页的url路径
			        $config['total_rows'] = $res;//得到数据库中的记录的总条数
			        $config['uri_segment'] = 3;
			        $config['per_page'] = '20';//每页记录数
			        $config['first_link'] = 'First';
			        $config['last_link'] = 'Last';
			        $config['full_tag_open'] = '<p>';
			 	    $config['full_tag_close'] = '</p>'; 
			        $this->pagination->initialize($config);//分页的初始化
			        
			        
			        $data['status_list']= $this->user_status_model->find_status_by_myfollow_offset($userid,$config['per_page'],$this->uri->segment(3));//得到数据库记录
					
					//$this->load->model('topic_model');
					//$data['topic_list'] = $this->topic_model->find_topics(array('order'=>'comment_num'), 6, 0);
					//$data['new_topics'] = $this->topic_model->find_topics(array('order'=>'id'), 5, 0);
					$this->load->view('user/user_status',$data);
				}else{
					$data['nav']= 'explore';
					$data['type']= 'all';
					$data['feature']= 'ThisMonth';
					$this->load->model('user_model');
					$this->load->model('item_model');
					$data['item_num'] = $this->item_model->count_items(array());
					$data['item_count'] = $this->item_model->count_items(array());
			        $user_count = $this->user_model->count_users();
					$data['user_count'] = $user_count;
			        $this->load->library('pagination');//加载分页类
			        $config['base_url'] = base_url().'item/featured/ThisMonth/all';//设置分页的url路径
			        $config['total_rows'] = $data['item_num'];//得到数据库中的记录的总条数
			        $config['uri_segment'] = 5;
			        $config['per_page'] = '12';//每页记录数
			        $config['first_link'] = 'First';
			        $config['last_link'] = 'Last';
			        $config['full_tag_open'] = '<p>';
			 	    $config['full_tag_close'] = '</p>'; 
			        $this->pagination->initialize($config);//分页的初始化
			        $this->load->model('item_type_model');
			        $data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1,'order'=>'order'));
					$this->load->model('item_model');
					$data['item_list'] = $this->item_model->order_item_by_feature_offset('ThisMonth','all',$config['per_page'],$this->uri->segment(5));
					$this->load->view('index',$data);
				}
	}
	
	public function happening()
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->model('user_model');
		//if ($this->session->userdata('id')!=null){
			$userid =$this->session->userdata('id');
	    	$user = $this->user_model->load($userid);
	    	
	    	$data['user']= $user;
        	$data['nav']= 'works';
        	$data['feature']= 'Happening';
        	
			$this->load->model('topic_model');
			$data['new_topics'] = $this->topic_model->find_topics(array('order'=>'id'), 5, 0);
			$data['topic_list'] = $this->topic_model->find_topics(array('order'=>'comment_num'), 6, 0);
			$this->load->model('user_model');
	        $data['user_list'] = $this->user_model->find_users(array('rand'=>1,'active'=>1), 5, 0);
	        $this->load->model('country_model');
			$country = $this->country_model->load($data['user']['countryCode']);
			$data['country_name'] = $country['full_name'];
	        $this->load->model('user_status_model');       
			$res= $this->user_status_model->count_status();
	        $this->load->library('pagination');//加载分页类
	        $config['base_url'] = base_url().'home/happening';//设置分页的url路径
	        $config['total_rows'] = $res;//得到数据库中的记录的总条数
	        $config['uri_segment'] = 3;
	        $config['per_page'] = '20';//每页记录数
	        $config['first_link'] = 'First';
	        $config['last_link'] = 'Last';
	        $config['full_tag_open'] = '<p>';
	 	    $config['full_tag_close'] = '</p>'; 
	        $this->pagination->initialize($config);//分页的初始化
	        $data['status_list']= $this->user_status_model->find_status_offset($config['per_page'],$this->uri->segment(3));//得到数据库记录
			$this->load->view('user/user_status',$data);
		//}else{
		//	redirect(site_url('home')); 
		//}
	}
	
	public function suggestion()
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
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
		$data['lang']= $lang;
		$this->load->model('user_model');
		$userid =$this->session->userdata('id');
    	$user = $this->user_model->load($userid);
    	
    	
		$this->load->model('job_type_model');
		$jobtypeid =$this->session->userdata('job_type');
    	$job = $this->job_type_model->load($jobtypeid);
    	
    	$data['user']= $user;
    	$data['nav']= 'works';
    	$data['feature']= 'Suggestions';
    	
    	$itemtypelist = Array();
		$tok = strtok($job['item_type'],","); 
		while($tok !== false){
			if(!in_array($tok,$itemtypelist)){
				if($tok!='')
				array_push($itemtypelist,$tok);
			}
			$tok = strtok(","); 
		}
    	
		$this->load->model('user_folder_model','folder');
		$folder_list = $this->folder->find_user_folders(array('rand'=>'1','is_private'=>'0','typein'=>$itemtypelist),4);
		$this->load->model('item_model','item');
		$data['folder_list'] = array();
		foreach ($folder_list as $list){
			$data['folder_items'][$list['id']] = $this->item->find_items(array('folder_id'=>$list['id'],'order'=>'update_date'),2,0);
			$list['works_num'] = $this->item->count_items(array('folder_id'=>$list['id'],'order'=>'update_date'));
			array_push($data['folder_list'],$list);
		}
		$data['item_list'] = $this->item->find_items(array('rand'=>'1','typein'=>$itemtypelist,'folder_id'=>0,'work_id'=>0),4,0);
		
		$this->load->model('user_status_model');
    	if($user['follow_num']>1){
				$data['status_list'] = $this->user_status_model->find_status_by_myfollow_offset($userid,10,0);
		}else{
				$data['status_list'] = $this->user_status_model->find_status_offset(10,0);
		}
		
		if($user['job_type']!=0)
    	$data['job_type'] = $this->job_type_model->load($user['job_type']);
    	else $data['job_type'] = $this->job_type_model->load(1);
		$data['job_type_list'] = $this->job_type_model->find_job_types(array('parent_id'=>'0'),10,0);
		
		$this->load->model('task_model');
		$data['task_list'] = $this->task_model->find_tasks(array('typein'=>$itemtypelist,'rand'=>'1','status'=>'0','language'=>$lang),4,0);
		
		$this->load->model('topic_model');
		$data['topic_list'] = $this->topic_model->find_topics(array('rand'=>'1','topic_language'=>$lang),5,0);
		
		$this->load->model('group_model');
		$data['group_list'] = $this->group_model->find_groups(array('rand'=>'1','in'=>$data['job_type']['group_type']), 4, 0);
		$this->load->view('file/suggestion',$data);
	}
	
	public function index()
	{
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
		$data['lang']= $lang;
		
    	$data['nav']= 'works';
    	$data['feature']= 'Suggestions';
    	
    	$this->load->model('user_model');
		$this->load->model('item_model');
		$data['item_count'] = $this->item_model->count_items(array());
        $data['user_count'] = $this->user_model->count_users();
			        
		$this->load->model('user_folder_model','folder');
		$folder_list = $this->folder->find_user_folders(array('rand'=>'1','is_private'=>'0'),4);
		$this->load->model('item_model','item');
		$data['folder_list'] = array();
		foreach ($folder_list as $list){
			$data['folder_items'][$list['id']] = $this->item->find_items(array('folder_id'=>$list['id'],'order'=>'update_date'),2,0);
			$list['works_num'] = $this->item->count_items(array('folder_id'=>$list['id'],'order'=>'update_date'));
			array_push($data['folder_list'],$list);
		}
		$data['item_list'] = $this->item->find_items(array('rand'=>'1','folder_id'=>0,'work_id'=>0),4,0);
		
		$this->load->model('user_status_model');
    	$data['status_list'] = $this->user_status_model->find_status_offset(10,0);
		
		$this->load->model('task_model');
		$data['task_list'] = $this->task_model->find_tasks(array('rand'=>'1','status'=>'0','language'=>$lang),4,0);
		
		$this->load->model('topic_model');
		$data['topic_list'] = $this->topic_model->find_topics(array('rand'=>'1','topic_language'=>$lang),5,0);
		
		$this->load->model('tool_model');
		$data['tool_list'] = $this->tool_model->find_tools(array('rand'=>'1','notin'=>array(1,94)),2,0);
		
		/*$this->load->model('group_model');
		$data['group_list'] = $this->group_model->find_groups(array('rand'=>'1','notin'=>array(6,13)),4, 0);
		*/
		$this->load->view('home',$data);
	}
	
	//see more particles of all users on home page --asynchronous loading
	function seemore()
	{
		$num_load_everytime =24; // 每滚动一次鼠标,加载的particle个数
        $scrollNum = $_GET['id'];
        $data = array();
        $this->load->model('item_model');
		$data['item_list'] = $this->item_model->find_items(array(), $num_load_everytime, $num_load_everytime*$scrollNum);
			
		foreach($data['item_list'] as $_user_item){
				$output ="<div id='item' class='clearfix'>
                       <a href='".site_url('item/'.$_user_item['id'])."'><img id='item-img' src='";
                       
                       if($_user_item['thumb_url']==null)$output = $output.$_user_item['pic_url'];
                       else $output = $output.$_user_item['thumb_url'];
                       $output = $output."' class='image' /></a>
                       <div id='item-desc' class='clearfix'>
                           <p style='height:70px'>
                           ".$_user_item['desc']."
                           </p>
                           <span>By <a href='".site_url('user/'.$_user_item['author_id'])."'>".$_user_item['author_name']."</a></span>
                       </div> 
                       <div id='item-tag' class='clearfix'>
                           ".$_user_item['tags']."
                       </div>
                       <div id='item-info' class='clearfix'> 
                           <img src='".base_url()."img/viewsicon.jpg'>&nbsp;&nbsp;
                            <b>".$_user_item['view_num']."</b>&nbsp;&nbsp;&nbsp;&nbsp;
                            <img src='".base_url()."img/appreciationsicon.jpg'>&nbsp;&nbsp;
                            <b>".$_user_item['fav_num']."</b>&nbsp;&nbsp;&nbsp;&nbsp;
                            <img src='".base_url()."img/commentsicon.jpg'>&nbsp;&nbsp;
                            <b>".$_user_item['comment_num']."</b>
                       </div>
                   </div> ";
				echo $output; 	
		}
		
		//判断是否加载完全
		$particle_count = $this->item_model->count_items(array());
		if($particle_count/$num_load_everytime==$scrollNum+1){
			$loadcompletely = "<div style='margin-left:30px;'>Load Completely!</div>";
			//echo $loadcompletely;
		}
	}	
}
