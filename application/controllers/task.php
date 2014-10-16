<?php
/**
 * 首页
 *
 *
 */
class Task extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
        $this->load->helper('time');
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
        	$this->lang->load('task','chinese');
        	$this->lang->load('pop','chinese');
        	$this->lang->load('other','chinese');
        	$this->lang->load('user','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('task','english');
        	$this->lang->load('pop','english');
        	$this->lang->load('other','english');
        	$this->lang->load('user','english');
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
   

    function index($id=0,$pnum=0)
    {    
       	$data = array();
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
		$data['lang'] = $lang;		
       	$this->load->model('task_model');
       	$this->load->model('task_response_model');
       	$data['nav']= 'tasks';
		$data['feature']= 'tasks';
	   	$data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/main.css'>";
	   	if($id!=null&&$id!=0){
	   		/*if ($this->session->userdata('id')){
	   			$this->load->model('user_fav_model');
	   			$data['fav'] = $this->user_fav_model->loadByUserAndFav($this->session->userdata('id'),$id,2);
	   		}*/
	   		$this->load->helper('url');	
	   		$data['task'] = $this->task_model->load($id);
	   		if($data['task']==null){
	   			redirect(site_url('home')); 
	   		}else{
	   			$this->session->set_userdata('redirectURL',site_url('task/'.$data['task']['id']));
	   		}
	   		if ($this->session->userdata('id')!=$data['task']['author_id']){
		        $this->task_model->view_num = $data['task']['view_num']+1;
		        $this->task_model->updateViewNum($id);
	        }
	        if($data['task']['task_tag']!=''){
        		//$data['tags'] = explode(" ",$data['task']['task_tag']);
        		$data['tags'] = preg_split('/[\s,;]+/',$data['task']['task_tag']);
        	}else{
        		$data['tags'] = array();
        	}
	   		$data['title'] = $data['task']['title'];
	   		$options = array('task' => $id,'root_comment_id' => 0,'is_best' => 0);
			$data['total'] = $this->task_response_model->count_comments($options);			
		    //分页配置
			$this->config->set_item('enable_query_strings',FALSE) ;
	        $config = $this->config->item('pagination');
			$config['uri_segment'] = '3';
			$config['total_rows'] = $data['total'];
			$config['per_page'] = '20';	
			$config['base_url'] = site_url('task') .'/'.$id.'/';
	
			//生成分页
	        $this->load->library('pagination');
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
	        
			$page = $this->uri->segment(3);
			if (!empty($page) && (int)$page>0){
				$page_offset = (int)$page;
	        } else {
	            $page_offset = 0;
	        }
	        
	        
			$this->load->model('task_file_model');
			$data['task_files'] = $this->task_file_model->loadbybid($id);
					
			$this->load->model('bid_file_model');
			$options = array('task' => $id,'is_best' => 0);
	   		$comment_list = $this->task_response_model->find_comments($options, $config['per_page'],$page_offset);
	   		$data['task_list'] = $this->task_model->find_tasks(array('language' => $lang,'type' => $data['task']['type']), 5, 0);
	   		$user_id = 0;
	   		$this->load->model('task_response_useful_model');
	   		if($this->session->userdata('id'))
	   		{	   			
	   			$user_id = $this->session->userdata('id');// performance consider
	   		}
	   		$useful_level = 0;
	   		$data['best_answer'] = $this->task_response_model->find_comments(array('task' => $id,'is_best' => 1), 5, 0);	   		
	   		if($data['best_answer']){	   		
		   		$replyoptions=array('root_comment_id'=>$data['best_answer'][0]['id']);
				$data['best_answer'][0]['bid_files'] = $this->bid_file_model->loadbybid($data['best_answer'][0]['id']);
				$data['best_answer'][0]['source_files'] = $this->bid_file_model->loadsourcebybid($data['best_answer'][0]['id']);
				$data['best_answer'][0]['reply_count'] =  $this->task_response_model->count_comments($replyoptions);
				if($user_id != 0)
				{
					$row = $this->task_response_useful_model->load($user_id,$data['best_answer'][0]['id']);
					if(!empty($row))
					{
						$useful_level = $row['useful_level'];
					}
				}
				$data['best_answer'][0]['useful_level'] = $useful_level;
	   		}	
	   		
	   		
			$data['comment_list'] = array();
			foreach ($comment_list as $list){
					$replyoptions=array('root_comment_id'=>$list['id']);
					$list['bid_files'] = $this->bid_file_model->loadbybid($list['id']);
					$list['source_files'] = $this->bid_file_model->loadsourcebybid($list['id']);					
					$list['reply_count'] =  $this->task_response_model->count_comments($replyoptions);
					if($user_id != 0)
					{
						$row = $this->task_response_useful_model->load($user_id,$list['id']);
						if(!empty($row))
						{
							$useful_level = $row['useful_level'];
						}
					}
					$list['useful_level'] = $useful_level;
					array_push($data['comment_list'],$list);
			}
	   		
	   		$this->load->view('task/task',$data);
	   	}else{
			$this->load->model('user_model');
			
		$data['type']= 'all';
			$data['user'] = $this->user_model->load($this->session->userdata('id'));
	   		$this->load->model('task_model');
			$res = $this->task_model->count_tasks(array('language' => $lang));
			$this->load->library('pagination');
			$config = $this->config->item('pagination');
			$config['uri_segment'] = '3';
			$config['total_rows'] = $res;
			$config['per_page'] = '10';
			$config['base_url'] = site_url('task/type/all/');
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '</p>';
			$this->pagination->initialize($config);//分页的初始化
			
			$data['task_list'] = $this->task_model->find_tasks(array('language' => $lang), 10, $this->uri->segment(3));
			
			$this->load->model('task_response_model');
			$data['response_num'] = $this->task_response_model->count_comments(array('author_id'=>$this->session->userdata('id')),0,0);
			 
			$data['task_num'] = $this->task_model->count_tasks(array('author_id'=>$this->session->userdata('id')));
			 
	   		
			$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1,'order'=>'order'));
	   		$this->load->view('task/task_explore',$data);
	   	}
    }
    
    function type($type)
    {
    	$data = array();
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
		$data['lang'] = $lang;
       	$data['nav']= 'tasks';
		$data['feature']= 'tasks';
		$data['type']= $type;
    	$this->load->model('user_model');
		$data['user'] = $this->user_model->load($this->session->userdata('id'));
   		$this->load->model('task_model');
   		if($type!='all')
		$res = $this->task_model->count_tasks(array('language' => $lang,'type'=>$type));
		else $res = $this->task_model->count_tasks(array('language' => $lang));
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['uri_segment'] = '4';
		$config['total_rows'] = $res;
		$config['per_page'] = '10';
		$config['base_url'] = site_url('task/type/'.$type.'/');
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$this->pagination->initialize($config);//分页的初始化
		
   		if($type!='all')
   		$data['task_list'] = $this->task_model->find_tasks(array('language' => $lang,'type'=>$type), 10, $this->uri->segment(4));
   		else
		$data['task_list'] = $this->task_model->find_tasks(array('language' => $lang), 10, $this->uri->segment(4));
		
		$this->load->model('task_response_model');
		$data['response_num'] = $this->task_response_model->count_comments(array('author_id'=>$this->session->userdata('id')),0,0);
		 
		$data['task_num'] = $this->task_model->count_tasks(array('author_id'=>$this->session->userdata('id')));
		 
   		
		$this->load->model('item_type_model');
		if($type!='all')
		$data['type_obj'] = $this->item_type_model->load($type);
		$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1,'order'=>'order'), 100, 0);
   		$this->load->view('task/task_explore',$data);
    }
    
    function create($item_id=0)
    {    
    	if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
       $data = array();
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
		$data['lang'] = $lang;
		$data['nav']= 'tasks';
		$data['feature']= 'tasks';
       $this->load->model('topic_model');
       $this->load->model('group_model');
       if($item_id>0){
       		$this->load->model('item_model');
       		$data['item'] = $this->item_model->load($item_id);
       }
       
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1,'order'=>'order'));
	   $data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/main.css'>";
	   $this->load->view('task/task_create',$data);
    }
    
    function edit($id)
    {
    	if (!$this->session->userdata('id')){          		
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
		$data['lang'] = $lang;
		$data['nav']= 'tasks';
		$data['feature']= 'tasks';
    	$data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/main.css'>";
    	$this->load->model('task_model');
    	$data['task'] = $this->task_model->load($id);
    	
    	
		$this->load->model('task_file_model');
		$data['task_files'] = $this->task_file_model->loadbybid($id);
		
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1,'order'=>'order'));
    	$this->load->view('task/task_edit',$data);
    }
    
    function save()
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$this->load->model('task_model');
		
		$title = htmlspecialchars($this->input->post('title'),ENT_QUOTES);
		$content = $this->input->post('desc');
		
        $this->task_model->title = $title;
    	$this->task_model->desc = $content;
    	$this->task_model->type = $this->input->post('type');
    	$this->task_model->price = $this->input->post('price');
    	$this->task_model->price_type = $this->input->post('price_type');
    	$this->task_model->task_type = $this->input->post('task_type');
    	$this->task_model->task_tag = $this->input->post('task_tag');
    	$user_id = $this->session->userdata('id');
		$this->task_model->author_id = $user_id;
		
		if (preg_match('/[\x7f-\xff]/',$title)||preg_match('/[\x7f-\xff]/',$content)) {
			$this->task_model->language = 2;
		} else {
			$this->task_model->language = 1;
		}
		
		$task = $this->task_model->create();
		
		
		$new_task_id = $this->db->insert_id();
		
		$taskfilelist = $this->input->post('taskfile');
        if($taskfilelist){
        	$taskfilelist = array_unique($taskfilelist);
	        $this->load->model('task_file_model');
	        foreach($taskfilelist as $taskfile): 
				$this->task_file_model->item_id = $taskfile;
				$this->task_file_model->task_id = $new_task_id;
				$this->task_file_model->type = 0;
		        $this->task_file_model->insertData();
			endforeach; 
        }
		
		
		$this->load->model('user_model');
		$user = $this->user_model->load($user_id);
		$user_point = $user['point'] - $this->task_model->price;
		$this->user_model->update_point($user_id,$user_point);
        $this->session->set_userdata('point',$user_point);
		
		
		$this->load->model('user_status_model');	
        $this->user_status_model->user_id = $this->session->userdata('id');
        $this->user_status_model->action = "create a task";
		$this->user_status_model->target_url = site_url('task/'.$new_task_id);
		$this->user_status_model->target_name = $this->task_model->title;
		$this->user_status_model->target_id = $new_task_id;
	    $this->user_status_model->status_type = 19;
		$this->user_status_model->insertData();
		
		
		redirect(site_url('task/'.$new_task_id));
	}
	
	function update()
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		
		$taskid = $this->input->post('task');
		$this->load->model('task_model');
		
		$title = htmlspecialchars($this->input->post('title'),ENT_QUOTES);
		$content = $this->input->post('desc');
		
        $this->task_model->title = $title;
    	$this->task_model->desc = $content;
    	$this->task_model->type = $this->input->post('type');
    	$this->task_model->price = $this->input->post('price');
    	$this->task_model->task_tag = $this->input->post('task_tag');
    	$this->task_model->task_type = $this->input->post('task_type');
    	$this->task_model->price_type = $this->input->post('price_type');
    	
    	if (preg_match('/[\x7f-\xff]/',$title)||preg_match('/[\x7f-\xff]/',$content)) {
    		$this->task_model->language = 2;
    	} else {
    		$this->task_model->language = 1;
    	}
    	
		$topic = $this->task_model->update($taskid);
		redirect(site_url('task/'.$taskid)); 
	}
	
	function fav($id)
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$this->load->model('user_fav_model');
		
        $this->user_fav_model->user_id = $this->session->userdata('id');
    	$this->user_fav_model->fav_id = $id;
    	$this->user_fav_model->fav_type = 2;
		$this->user_fav_model->create();
		redirect(site_url('topic/'.$id)); 
	}
	
	function delfav($topicid)
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$this->load->model('user_fav_model');
		$this->user_fav_model->delete($this->session->userdata('id'),$topicid,2);
		redirect(site_url('topic/'.$topicid)); 
	}	
	
	function del($id)
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$this->load->model('task_model');
		$task = $this->task_model->load($id);
		
		if ($this->session->userdata('id')==$task['author_id']){
			
			$this->task_model->delete($id);
			
			redirect(site_url('task/mytask')); 
		}else{
			redirect(site_url('task/'.$task['id']));
			exit();
		}
		
	}
	
	public function placebid($task_id)
	{
		if (!$this->session->userdata('id')){          		
			return;
		}
		$data = array();
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
		$data['lang'] = $lang;
		$data['nav']= 'tasks';
		$data['feature']= 'tasks';
       if($task_id>0){
       		$this->load->model('task_model');
       		$data['task'] = $this->task_model->load($task_id);
       }
       
	   $this->load->view('task/bid_create',$data);
	}
	
	public function editbid($bid_id)
	{
		if (!$this->session->userdata('id')){          		
			return;
		}
		$data = array();
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
		$data['lang'] = $lang;
		$data['nav']= 'tasks';
		$data['feature']= 'tasks';
       if($bid_id>0){
       		$this->load->model('task_response_model');
       		$data['bid'] = $this->task_response_model->load($bid_id);
       		
       		$this->load->model('bid_file_model');
			$data['bid_files'] = $this->bid_file_model->loadbybid($bid_id);
			$data['source_files'] = $this->bid_file_model->loadsourcebybid($bid_id);
			
       		$this->load->model('task_model');
       		$data['task'] = $this->task_model->load($data['bid']['task_id']);
       }
       
	   $this->load->view('task/bid_edit',$data);
	}
	
	public function savereply()
	{
		if (!$this->session->userdata('id')){
			return;
		}
		
		$this->load->model('task_response_model','t_comment');
		$this->t_comment->comment_content = $this->input->post('desc');
		$this->t_comment->task_id = $this->input->post('task');
		$this->t_comment->author_id = $this->session->userdata('id');
		$this->t_comment->parent_comment_id = $this->input->post('parent');
		
		$this->t_comment->parent_author_id = $this->input->post('parent_author_id');
		$this->t_comment->root_comment_id = $this->input->post('root_comment_id');
		$this->t_comment->root_author_id = $this->input->post('root_author_id');
				
		
		$parent = $this->input->post('parent');
		$id = $this->input->post('task');
		$savedid = $this->t_comment->create();		
		$output = array('comment_content'=>$this->input->post('desc'),
				'author_id' => $this->session->userdata('id'),
				'parent_comment_id' => $this->input->post('parent'),
				'parent_author_id' => $this->input->post('parent_author_id'),
				'root_comment_id' => $this->input->post('root_comment_id'),
				'root_author_id' => $this->input->post('root_author_id')
		);
		
		
		$this->load->model('user_model');
		if($savedid != 0)
		{
			// get the row just created			
			$output['comment_id'] =$savedid;						
			$user = $this->user_model->load($this->session->userdata('id'));
			$output['author_pic'] = $user['pic_url'];
			$output['author_name'] = $user['name'];
			$datetime = date('Y-m-d H:i:s');
			$output['update_date'] = $datetime;
			$user = $this->user_model->load($this->input->post('parent_author_id'));
			$output['parent_author_name'] = $user['name'];
		}		
	
		$comment = $this->t_comment->load($this->input->post('parent'));
	
		$this->load->model('task_model');
		$this->load->model('user_notice_model');
	
		$task = $this->task_model->load($this->input->post('task'));
	
		if($task['author_id']!=$this->session->userdata('id')){
			$this->user_notice_model->user_id = $task['author_id'];
			$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> commented your task <a href='".site_url('task/'.$id)."'>".$task['title']."</a>";
			$this->user_notice_model->insertData();
	
			$this->load->model('email_model');
			$user = $this->user_model->load($task['author_id']);
			$title = $this->session->userdata('displayName').' commented your task '.$task['title'].' on EffectHub.com';
			$content = $this->user_notice_model->content;
			$this->email_model->send_notification($user['email'],$title,$content);
		}
	
		if($comment){
			$this->user_notice_model->user_id = $comment['author_id'];
			$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> replyed your comment in <a href='".site_url('task/'.$id)."'>".$task['title']."</a>";
			$this->user_notice_model->insertData();
	
			$this->load->model('email_model');
			$user = $this->user_model->load($comment['author_id']);
			$title = $this->session->userdata('displayName').' replyed your comment in '.$task['title'].' on EffectHub.com';
			$content = $this->user_notice_model->content;
			$this->email_model->send_notification($user['email'],$title,$content);
		}
	
		$this->task_model->response_num = $task['response_num'] + 1;
		$this->task_model->updateNum($id);
		$this->task_model->updateCommentTime($id);
	
		$this->load->model('user_status_model');
		$this->user_status_model->user_id = $this->session->userdata('id');
		//$this->user_status_model->content = "commented the topic  <a href='".site_url('topic/'.$topicid)."'>".$topic['topic_title']."</a>\n comment content: ".$content;
		$this->user_status_model->action = "placed a bid to task";
		$this->user_status_model->target_url = site_url('task/'.$id);
		$this->user_status_model->target_name = $task['title'];
		$this->user_status_model->target_id = $id;
		$this->user_status_model->status_type = 20;
		$this->user_status_model->insertData();
	
		//
		// return result
		//
		$result = json_encode($output);
		//file_put_contents('d:\\tmp\\tmp.log',$result,FILE_APPEND);
		echo $result;
		exit();
		
	
	}
	
	public function savebid()
	{
		if (!$this->session->userdata('id')){          		
			return;
		}	
		
		$this->load->model('task_response_model','t_comment');
		$this->t_comment->comment_content = $this->input->post('desc');
		$this->t_comment->task_id = $this->input->post('task');
		$this->t_comment->author_id = $this->session->userdata('id');
		$this->t_comment->parent_comment_id = $this->input->post('parent');
		$parent = $this->input->post('parent');
		$id = $this->input->post('task');
		$save = $this->t_comment->create();
		
		$new_bid_id = $this->db->insert_id();
		
		$bidfilelist = $this->input->post('bidfile');
        if($bidfilelist){
        	$bidfilelist = array_unique($bidfilelist);
	        $this->load->model('bid_file_model');
	        foreach($bidfilelist as $bidfile): 
				$this->bid_file_model->item_id = $bidfile;
				$this->bid_file_model->bid_id = $new_bid_id;
				$this->bid_file_model->type = 0;
		        $this->bid_file_model->insertData();
			endforeach; 
        }
        
        $sourcefilelist = $this->input->post('sourcefile');
        if($sourcefilelist){
        	$sourcefilelist = array_unique($sourcefilelist);
	        $this->load->model('bid_file_model');
	        foreach($sourcefilelist as $sourcefile): 
				$this->bid_file_model->item_id = $sourcefile;
				$this->bid_file_model->bid_id = $new_bid_id;
				$this->bid_file_model->type = 1;
		        $this->bid_file_model->insertData();
			endforeach; 
        }
		
		$comment = $this->t_comment->load($this->input->post('parent'));
		
		$this->load->model('task_model');
		$this->load->model('user_model');
		$this->load->model('user_notice_model');
		
		$task = $this->task_model->load($this->input->post('task'));
		
		if($task['author_id']!=$this->session->userdata('id')){
			$this->user_notice_model->user_id = $task['author_id'];
			$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> commented your task <a href='".site_url('task/'.$id)."'>".$task['title']."</a>";
			$this->user_notice_model->insertData();
			 
			$this->load->model('email_model');
			$user = $this->user_model->load($task['author_id']);
			$title = $this->session->userdata('displayName').' commented your task '.$task['title'].' on EffectHub.com';
			$content = $this->user_notice_model->content;
			$this->email_model->send_notification($user['email'],$title,$content);
		}
		
		if($comment){
			$this->user_notice_model->user_id = $comment['author_id'];
			$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> replyed your comment in <a href='".site_url('task/'.$id)."'>".$task['title']."</a>";
			$this->user_notice_model->insertData();
			 
			$this->load->model('email_model');
			$user = $this->user_model->load($comment['author_id']);
			$title = $this->session->userdata('displayName').' replyed your comment in '.$task['title'].' on EffectHub.com';
			$content = $this->user_notice_model->content;
			$this->email_model->send_notification($user['email'],$title,$content);
		}
		
		$this->task_model->response_num = $task['response_num'] + 1;
		$this->task_model->updateNum($id);
		$this->task_model->updateCommentTime($id);
		
		$this->load->model('user_status_model');
		$this->user_status_model->user_id = $this->session->userdata('id');
		//$this->user_status_model->content = "commented the topic  <a href='".site_url('topic/'.$topicid)."'>".$topic['topic_title']."</a>\n comment content: ".$content;
		$this->user_status_model->action = "placed a bid to task";
		$this->user_status_model->target_url = site_url('task/'.$id);
		$this->user_status_model->target_name = $task['title'];
		$this->user_status_model->target_id = $id;
	    $this->user_status_model->status_type = 20;
		$this->user_status_model->insertData();
		
		redirect(site_url('task/'.$id));
			exit();
		
	}
	
	
	public function updatebid($id)
	{
		if (!$this->session->userdata('id')){          		
			return;
		}	
		
		$this->load->model('task_response_model','t_comment');
		$this->t_comment->comment_content = $this->input->post('desc');
		$this->t_comment->task_id = $this->input->post('task');
		$this->t_comment->author_id = $this->session->userdata('id');
		$task_id = $this->input->post('task');
		$save = $this->t_comment->update($id);
		
		$new_bid_id = $this->db->insert_id();
		
		$bidfilelist = $this->input->post('bidfile');
        if($bidfilelist){
        	$bidfilelist = array_unique($bidfilelist);
	        $this->load->model('bid_file_model');
	        foreach($bidfilelist as $bidfile): 
				$this->bid_file_model->item_id = $bidfile;
				$this->bid_file_model->bid_id = $new_bid_id;
				$this->bid_file_model->type = 0;
		        $this->bid_file_model->insertData();
			endforeach; 
        }
        
        $sourcefilelist = $this->input->post('sourcefile');
        if($sourcefilelist){
        	$sourcefilelist = array_unique($sourcefilelist);
	        $this->load->model('bid_file_model');
	        foreach($sourcefilelist as $sourcefile): 
				$this->bid_file_model->item_id = $sourcefile;
				$this->bid_file_model->bid_id = $new_bid_id;
				$this->bid_file_model->type = 1;
		        $this->bid_file_model->insertData();
			endforeach; 
        }
		
		redirect(site_url('task/'.$task_id));
			exit();
		
	}
	
	function acceptbid($bidid)
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$this->load->model('task_response_model');
		$this->load->model('task_model');
		$bid = $this->task_response_model->load($bidid);
		$task = $this->task_model->load($bid['task_id']);
		if($this->session->userdata('id')!=$task['author_id']){
			redirect('task/'.$task['id']);
			exit();
		}else{
			$this->task_model->status = 1;
			$this->task_model->updateStatus($task['id']);
			$this->task_response_model->is_best = 1;
			$this->task_response_model->updateBest($bid['id']);
			
			
			$this->load->model('user_status_model');
			$this->user_status_model->user_id = $bid['author_id'];
			$this->user_status_model->action = "finished task";
			$this->user_status_model->target_url = site_url('task/'.$task['id']);
			$this->user_status_model->target_name = $task['title'];
			$this->user_status_model->target_id = $task['id'];
	    	$this->user_status_model->status_type = 21;
			$this->user_status_model->insertData();
			
			$this->load->model('user_notice_model');
			$this->user_notice_model->user_id = $bid['author_id'];
			$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> marked your comment the best answer in <a href='".site_url('task/'.$task['id'])."'>".$task['title']."</a>";
			$this->user_notice_model->insertData();
			
			
			$this->load->model('user_model');
			$user = $this->user_model->load($bid['author_id']);
			$user_point = $user['point'] + $task['price'];
			$this->user_model->update_point($bid['author_id'],$user_point);
			 
			$this->load->model('email_model');
			$user = $this->user_model->load($bid['author_id']);
			$title = $this->session->userdata('displayName').' marked your comment the best answer in '.$task['title'].' on EffectHub.com';
			$content = $this->user_notice_model->content;
			$this->email_model->send_notification($user['email'],$title,$content);
			
			redirect('task/'.$task['id']);
		}
	}

	
	function delcomment($commentid)
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$this->load->model('topic_comment_model');
		$comment = $this->topic_comment_model->load($commentid);	
		
		$this->load->model('topic_model');
		$topic = $this->topic_model->load($comment['topic_id']);
		
		if (($this->session->userdata('id')==$comment['author_id'])||($this->session->userdata('id')==$topic['author_id'])){			
			$this->topic_comment_model->delete($commentid);
			
			$this->topic_model->comment_num = $topic['comment_num'] - 1;
			$this->topic_model->updateNum($topic['id']);
			
			$user_id = $this->session->userdata('id');
			$this->load->model('user_model');
			$user = $this->user_model->load($user_id);
			$user_point = $user['point'] - 1;
			$this->user_model->update_point($user_id,$user_point);
		
			redirect(site_url('topic/'.$topic['id'])); 
		}else{
			redirect(site_url('topic/'.$topic['id']));
			exit();
		}
		
	}
	
	function tagSearch()
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
		$data['lang'] = $lang;
    	$data['nav']= 'tasks';
		$data['feature']= 'tasks';
		
		
	    parse_str($_SERVER['QUERY_STRING'], $_GET);
		$tag = $this->input->get('tag');
		$data['tag'] = $tag;
		
		$id = $this->session->userdata('id');
		$this->load->model('user_model');
		$data['user'] = $this->user_model->load($id);
		
	   		$this->load->model('task_model');
			$res = $this->task_model->count_tasks(array('tag'=>$tag));
			$this->load->library('pagination');
			$config = $this->config->item('pagination');
			$config['uri_segment'] = '3';
			$config['total_rows'] = $res;
			$config['per_page'] = '10';
			$config['base_url'] = site_url('task/mytask/');
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '</p>';
			$this->pagination->initialize($config);//分页的初始化
			
			$data['task_list'] = $this->task_model->find_tasks(array('tag'=>$tag), 10, $this->uri->segment(3));
			
			$this->load->model('task_response_model');
				$data['response_num'] = $this->task_response_model->count_comments(array('author_id'=>$this->session->userdata('id')),0,0);
			 
				$data['task_num'] = $this->task_model->count_tasks(array('author_id'=>$this->session->userdata('id')),0,0);
			 
		$this->load->model('item_type_model');
		$data['type'] = 'all';
		$data['item_type_list'] = $this->item_type_model->find_item_types(array(), 100, 0);
		$this->load->view('task/task_explore',$data);
    }
	
	function mytask()
    {
    	
    	if (!$this->session->userdata('id')){
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
		$data['lang'] = $lang;
    	$data['nav']= 'tasks';
		$data['feature']= 'mytask';
		
		$id = $this->session->userdata('id');
		$this->load->model('user_model');
		$data['user'] = $this->user_model->load($id);
		
	   		$this->load->model('task_model');
			$res = $this->task_model->count_tasks(array('author_id'=>$id));
			$this->load->library('pagination');
			$config = $this->config->item('pagination');
			$config['uri_segment'] = '3';
			$config['total_rows'] = $res;
			$config['per_page'] = '10';
			$config['base_url'] = site_url('task/mytask/');
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '</p>';
			$this->pagination->initialize($config);//分页的初始化
			
			$data['task_list'] = $this->task_model->find_tasks(array('author_id'=>$id), 10, $this->uri->segment(3));
			
			$this->load->model('task_response_model');
				$data['response_num'] = $this->task_response_model->count_comments(array('author_id'=>$this->session->userdata('id')),0,0);
			 
				$data['task_num'] = $this->task_model->count_tasks(array('author_id'=>$this->session->userdata('id')),0,0);
			 
	   		
		$this->load->view('task/task_mine',$data);
    }    
	/**
	 * get all the replies' information for special comment_id as the root_comment_id	 
	 */
	public function find_replies($comment_id)
	{		
		$root_comment_id = $comment_id;
		$options = array('root_comment_id'=>$root_comment_id);
		$this->load->model('task_response_model');		
		$this->load->model('user_model');
		
		$replylist = $this->task_response_model->find_replies($options);
		
		$root_user_id = $this->task_response_model->find_authorid_by_comment_id($root_comment_id);
		$root_user = $this->user_model->load($root_user_id);
		$root_user_info = array('root_comment_id'=>$root_comment_id, 'root_author_id'=>$root_user['id']);
					
		$output = array();				
		array_push($output,$root_user_info);
		foreach ($replylist as $list){
			if($list['parent_comment_id'] != $list['root_comment_id'])
			{				
				$parent_author_id = $this->task_response_model->find_authorid_by_comment_id($list['parent_comment_id']);				
				$list['parent_user'] = $this->user_model->load($parent_author_id);
			}
		
// 			$list['user'] = $this->user_model->load($list['author_id']);
			array_push($output,$list);			
		}
		$result = json_encode($output);
// 		file_put_contents('d:\\tmp\\tmp.log',$result,FILE_APPEND);
		echo $result;
	}
	/**
	 * 
	 */
	public function update_useful_record()
	{
		$this->load->model('task_response_model');
		$this->load->model('task_response_useful_model');		
		$user_id = $this->session->userdata('id');
		$comment_id = $this->input->post('comment_id');
		$useful_count = $this->input->post('useful_count');
		$useful_level = $this->input->post('useful_level');
		$result = $this->task_response_model->updateUsefulCount($comment_id,$useful_count);
// 		file_put_contents('d:\\tmp\\tmp.log',$result,FILE_APPEND);
		$result = $this->task_response_useful_model->update($user_id,$comment_id,$useful_level);
// 		file_put_contents('d:\\tmp\\tmp.log',';'.$result,FILE_APPEND);
		echo 'pass';
	}
	
	public function updateall()
	{
		$this->load->model('task_response_model');
		$options = array('order'=>'id');
		$count = $this->task_response_model->count_comments($options);
		echo 'count'.$count.'   ';
		$commentlist = $this->task_response_model->getall();
		echo 'sizeof($commentlist):'. sizeof($commentlist) . '   ';
		for($index = 0; $index < sizeof($commentlist); $index++ )
		{
			echo '{$index:'.$index;
			if($commentlist[$index]['parent_comment_id'] != 0)
			{ 
				$parent_author_id = $this->task_response_model->find_authorid_by_comment_id($commentlist[$index]['parent_comment_id']);
				$commentlist[$index]['parent_author_id'] = $parent_author_id;
				$commentlist[$index]['root_comment_id'] = $commentlist[$index]['parent_comment_id'];
				$commentlist[$index]['root_author_id'] = $parent_author_id;
			}
			$this->task_response_model->parent_author_id = $commentlist[$index]['parent_author_id'];
			$this->task_response_model->root_comment_id =$commentlist[$index]['root_comment_id'];
			$this->task_response_model->root_author_id = $commentlist[$index]['root_author_id'];
			$this->task_response_model->tmpupdate($commentlist[$index]['id']);
			$str = 'id:'.$commentlist[$index]['id']
					.'; parent_comment_id:'.$commentlist[$index]['parent_comment_id']
					.'; root_comment_id:'.$commentlist[$index]['root_comment_id']
					.'; parent_author_id:'.$commentlist[$index]['parent_author_id']
					.'; root_author_id:'.$commentlist[$index]['root_author_id'];
			echo $str.'}<br>';
			
		}		
	}
    function mybid()
    {
    	
    	if (!$this->session->userdata('id')){
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
		$data['lang'] = $lang;
    	$data['nav']= 'tasks';
		$data['feature']= 'mybid';
		
		$this->load->helper('my_form');
		$id = $this->session->userdata('id');
		$this->load->model('user_model');
		$data['user'] = $this->user_model->load($id);
		
	   		$this->load->model('task_model');
			$this->load->model('task_response_model');
			
			$res = $this->task_response_model->count_comments(array('author_id'=>$id));
			$this->load->library('pagination');
			$config = $this->config->item('pagination');
			$config['uri_segment'] = '3';
			$config['total_rows'] = $res;
			$config['per_page'] = '10';
			$config['base_url'] = site_url('task/mybid/');
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '</p>';
			$this->pagination->initialize($config);//分页的初始化
			
			$data['task_list'] = $this->task_response_model->find_comments(array('author_id'=>$id), 10, $this->uri->segment(3));
			
				$data['response_num'] = $this->task_response_model->count_comments(array('author_id'=>$this->session->userdata('id')),0,0);
			 
				$data['task_num'] = $this->task_model->count_tasks(array('author_id'=>$this->session->userdata('id')),0,0);
			 
	   		
		$this->load->view('task/bid_mine',$data);
    }
    //search item --local search
    function search()
    {
    	$this->load->model('task_model');    	
    	    	
    	$input_str = trim($this->input->post('search'));
    	if(!$input_str){
    		parse_str($_SERVER['QUERY_STRING'], $_GET);
    		$input_str = trim($this->input->get('keyword'));
    	}
    
    
    	//search estimate
    	//update the search table for future user action estimate
    	$this->load->model('search_model');
    	$userid = '0'; // default $userid is 0, which is a anonymouse user, it does not exist in user table
    	if ($this->session->userdata('id')!=null){
    		$userid = $this->session->userdata('id');
    	}    	
    
    	$res= $this->task_model->particle_search($input_str);
    
    	$this->load->library('pagination');//加载分页类
    	$config['base_url'] = base_url().'task/search?keyword='.$input_str;//设置分页的url路径
    	$config['total_rows'] = count($res);//得到数据库中的记录的总条数
    	$config['per_page'] = '10';//每页记录数
    	$config['first_link'] = 'First';
    	$config['last_link'] = 'Last';
    	$config['full_tag_open'] = '<p>';
    	$config['full_tag_close'] = '</p>';
    	$config['page_query_string'] = TRUE;
    	$this->pagination->initialize($config);//分页的初始化
    	$data['results']= $this->task_model->particle_search_offset($input_str,$config['per_page'],$this->uri->segment(3));//得到数据库记录
    	$data['seach_active_tag'] = 'task';
    
    	$data['input_str'] = $input_str;
    	$this->load->view('search_result',$data);
    }    

}

?>
