<?php
/**
 * 首页
 *
 *
 */
class Topic extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
        $this->load->helper('my_form');
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
        	$this->lang->load('topic','chinese');
        	$this->lang->load('pop','chinese');
        	$this->lang->load('other','chinese');
        	$this->lang->load('user','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('topic','english');
        	$this->lang->load('pop','english');
        	$this->lang->load('other','english');
        	$this->lang->load('user','english');
        }
        
        if($userid=$this->session->userdata('id')) {
        	$this->load->model('user_model');
        	$this->load->model('user_notice_model');
        	$notice_count = $this->user_notice_model->find_unread_count($userid);
        	$this->session->set_userdata('notice_count',$notice_count);
        	$this->load->model('user_mail_model');
        	$mail_count =$this->user_mail_model->find_unread_count($userid);
        	$this->session->set_userdata('mail_count',$mail_count);
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
		$data['lang']= $lang;
       	$this->load->model('topic_model');
       	$this->load->model('topic_comment_model');
       	$data['nav']= 'groups';
		$data['feature']= 'mygroup';
	   	$data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/main.css'>";
	   	if($id!=null&&$id!=0){
	   		/*if ($this->session->userdata('id')){
	   			$this->load->model('user_fav_model');
	   			$data['fav'] = $this->user_fav_model->loadByUserAndFav($this->session->userdata('id'),$id,2);
	   		}*/
	   		$this->load->helper('url');	
	   		$data['topic'] = $this->topic_model->load($id);
	   		if($data['topic']==null){
	   			redirect(site_url('home')); 
	   		}else{
	   			$this->session->set_userdata('redirectURL',site_url('topic/'.$data['topic']['id']));
	   		}
	   		if ($this->session->userdata('id')!=$data['topic']['author_id']){
		        $this->topic_model->view_num = $data['topic']['view_num']+1;
		        $this->topic_model->updateViewNum($id);
	        }
	        if($data['topic']['item_id']>0){
	        	$this->load->model('item_model');
	        	$data['item'] = $this->item_model->load($data['topic']['item_id']);
	        }
	   		$data['title'] = $data['topic']['topic_title'];
	   		$options = array('topic' => $id);
			$data['total'] = $this->topic_comment_model->count_comments($options); 
		    //分页配置
			$this->config->set_item('enable_query_strings',FALSE) ;
	        $config = $this->config->item('pagination');
			$config['uri_segment'] = '3';
			$config['total_rows'] = $data['total'];
			$config['per_page'] = '20';	
			$config['base_url'] = site_url('topic') .'/'.$id.'/';
	
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
	   		$data['comment_list'] = $this->topic_comment_model->find_comments($options, $config['per_page'],$page_offset);
	   		$data['topic_list'] = $this->topic_model->find_topics(array('conditions' => $data['topic']['group_id']), 5, 0);

	   		
	   		$this->load->model('user_group_model','u_group');
	   		$data['isin'] = $this->u_group->loadCountByUser($this->session->userdata('id'),$data['topic']['group_id']);
	   		
	   		// the parameter visit_hot is set to calculate the popular groups of all and the most usually visit groups of one user
	   		if ($this->session->userdata('id')) {
	   			$this->load->model('user_group_model','u_group');
        		$e = $this->u_group->loadByUserGroup($this->session->userdata('id'),$data['topic']['group_id']);
        		if ($e!=null){
        			$this->u_group->visit_hot = $e['visit_hot'] + 1;
        			$this->u_group->update_hot($data['topic']['group_id']);
        		}
        		
        		$this->load->model('group_model');
        		$group = $this->group_model->load($data['topic']['group_id']);
        		$this->group_model->visit_hot = $group['visit_hot'] + 1;
        		$this->group_model->update_hot($data['topic']['group_id']);
	   		}
        
        	
			$this->load->model('task_model');
			$this->load->model('item_model');
			$data['task_list'] = $this->task_model->find_tasks(array('rand'=>'1','status'=>'0','language'=>$lang),5,0);
			$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1','folder_id'=>0,'work_id'=>0), 4, 0);
        	
	   		$this->load->view('topic/topic',$data);
	   	}else{
	   	
	   	}
    }
    
    function create($group_id,$item_id=0)
    {    
    	if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$data['nav']= 'groups';
		$data['feature']= 'groups';
       $this->load->model('topic_model');
       $this->load->model('group_model');
       $data = array();
       if($item_id>0){
       		$this->load->model('item_model');
       		$data['item'] = $this->item_model->load($item_id);
       }
	   $data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/main.css'>";
	   $data['topic_list'] = $this->topic_model->find_topics(array('conditions' => $group_id), 10, 0);
	   $data['group'] = $this->group_model->load($group_id);
	   $this->load->view('topic/topic_create',$data);
    }
    
    function edit($id)
    {
    	if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$data['nav']= 'groups';
		$data['feature']= 'groups';
    	$data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/main.css'>";
    	$this->load->model('topic_model');
        $this->load->model('group_model');
    	$data['topic'] = $this->topic_model->load($id);
    	$data['topic_list'] = $this->topic_model->find_topics(array('conditions' => $data['topic']['group_id']), 10, 0);
	    $data['group'] = $this->group_model->load($data['topic']['group_id']);
    	$this->load->view('topic/topic_edit',$data);
    }
    
    function save()
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$groupid = $this->input->post('group');
		$this->load->model('topic_model');
		$this->load->model('group_model');
		$group = $this->group_model->load($groupid);
		
		$title = htmlspecialchars($this->input->post('name'),ENT_QUOTES);
		$content = $this->input->post('desc');
		
        $this->topic_model->topic_title = $title;
    	$this->topic_model->topic_content = $content;
    	$this->topic_model->item_id = $this->input->post('item');
    	$user_id = $this->session->userdata('id');
		$this->topic_model->author_id = $user_id;
		$this->topic_model->comment_num = 0;
		$this->topic_model->group_id = $groupid;
		
		if (preg_match('/[\x7f-\xff]/',$title)||preg_match('/[\x7f-\xff]/',$content)) {
			$this->topic_model->topic_language = 2;
		} else {
			$this->topic_model->topic_language = 1;
		}
		
		$topic = $this->topic_model->create();
		
		
		$new_topic_id = $this->db->insert_id();
		
		if($this->topic_model->item_id>0){
			$this->load->model('item_model');	
			$this->item_model->topic_id = $new_topic_id;
			$this->item_model->updateTopic($this->topic_model->item_id);
		}
		
		$this->load->model('user_status_model','u_status');	
		/*
        $this->user_status_model->user_id = $this->session->userdata('id');
        $this->user_status_model->action = "created a topic";
    	$this->user_status_model->content = "create a topic  <a href='".site_url('topic/'.$new_topic_id)."'>".$this->topic_model->topic_title."</a>";
		$this->user_status_model->target_url = site_url('topic/'.$new_topic_id);
		$this->user_status_model->target_name = $this->topic_model->topic_title;
		*/
		$this->u_status->user_id = $this->session->userdata('id');
		$this->u_status->status_type = 3;
		$this->u_status->target_id = $new_topic_id;
		$this->u_status->content_id = $groupid;
		$this->u_status->target_name = $this->topic_model->topic_title;
		
		$this->u_status->insertData();
		
    	$pic_path = '';
    	/*if ((($_FILES["url"]["type"] == "image/gif")
		|| ($_FILES["url"]["type"] == "image/jpeg")
		|| ($_FILES["url"]["type"] == "image/pjpeg"))
		&& ($_FILES["url"]["size"] < 2000000))
		  {
		  if ($_FILES["url"]["error"] > 0)
		    {
		    echo "Return Code: " . $_FILES["url"]["error"] . "<br />";
		    }
		  else
		    {
		    	$this->load->helper('my_form');
				$base_url=$this->config->item('base_url');
				$user_id = $new_topic_id;
				$rs = array();
				$input = file_get_contents($_FILES["url"]["tmp_name"]);
				$data = $input;
				//设置上传目录
				$upload_dir = 'topic';
				$dir = UploadPath($upload_dir);
				//大图
				$file_name=$dir.'/'.$user_id.'.jpg';
		
				@file_put_contents($file_name, $data);
				$pic_path = base_url().'uploads/'.$upload_dir.'/'.$user_id.'.jpg';
				$rs['status'] = 1;		
		    }
		  }
    	if($pic_path!=''&&$pic_path!=null){
    		$this->topic_model->pic_url = $pic_path;
    		$this->topic_model->update($new_topic_id);
    	}*/
    	
		$this->group_model->topic_num = $group['topic_num'] + 1;
		$this->group_model->updateNum($groupid);
		$this->load->model('user_model');
		
		$user = $this->user_model->load($user_id);
		$user_point = $user['point'] + 5;
		$this->user_model->update_point($user_id,$user_point);
		
		$cookie = array(
				'name'   => 'new_topic',
				'value'  => 1,
				'expire' => '300',
		);
		set_cookie($cookie);
		
		// the parameter visit_hot is set to calculate the popular groups of all and the most usually visit groups of one user
		$this->load->model('user_group_model','u_group');
		$e = $this->u_group->loadByUserGroup($this->session->userdata('id'),$groupid);
		if ($e!=null){
			$this->u_group->visit_hot = $e['visit_hot'] + 3;
			$this->u_group->update_hot($groupid);
		}
		
		
		
		redirect(site_url('topic/'.$new_topic_id));
	}
	
	function update()
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		
		$topicid = $this->input->post('topic');
		$pic_path = '';
    	/*if ((($_FILES["url"]["type"] == "image/gif")
		|| ($_FILES["url"]["type"] == "image/jpeg")
		|| ($_FILES["url"]["type"] == "image/pjpeg"))
		&& ($_FILES["url"]["size"] < 2000000))
		  {
		  if ($_FILES["url"]["error"] > 0)
		    {
		    echo "Return Code: " . $_FILES["url"]["error"] . "<br />";
		    }
		  else
		    {
		    	$this->load->helper('my_form');
				$base_url=$this->config->item('base_url');
				$user_id = $topicid;
				$rs = array();
				$input = file_get_contents($_FILES["url"]["tmp_name"]);
				$data = $input;
				//设置上传目录
				$upload_dir = 'topic';
				$dir = UploadPath($upload_dir);
				//大图
				$file_name=$dir.'/'.$user_id.'.jpg';
		
				@file_put_contents($file_name, $data);
				$pic_path = base_url().'uploads/'.$upload_dir.'/'.$user_id.'.jpg';
				$rs['status'] = 1;		
		    }
		  }
    	$this->load->model('topic_model');
    	if($pic_path!=''&&$pic_path!=null){
    		$this->topic_model->pic_url = $pic_path;
    	}else{
    		$this->topic_model->pic_url = $this->input->post('last_pic');
    	}*/
		$this->load->model('topic_model');
		
		$title = htmlspecialchars($this->input->post('name'),ENT_QUOTES);
		$content = $this->input->post('desc');
		
        $this->topic_model->topic_title = $title;
    	$this->topic_model->topic_content = $content;
    	
    	if (preg_match('/[\x7f-\xff]/',$title)||preg_match('/[\x7f-\xff]/',$content)) {
    		$this->topic_model->topic_language = 2;
    	} else {
    		$this->topic_model->topic_language = 1;
    	}
    	
		$topic = $this->topic_model->update($topicid);
		redirect(site_url('topic/'.$topicid)); 
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
		$this->load->model('topic_model');
		$topic = $this->topic_model->load($id);
		
		if ($this->session->userdata('id')==$topic['author_id']){
			$topic = $this->topic_model->load($id);
			if ($topic['item_id'] > 0){
				$this->load->model('item_model');
				$this->item_model->topic_id = 0;
				$this->item_model->updateTopic($topic['item_id']);
			}
			$this->topic_model->delete($id);
			
			$this->load->model('group_model');
			$group = $this->group_model->load($topic['group_id']);
			
			$this->group_model->topic_num = $group['topic_num'] - 1;
			$this->group_model->updateNum($group['id']);
			
			$user_id = $this->session->userdata('id');
			$this->load->model('user_model');
			$user = $this->user_model->load($user_id);
			$user_point = $user['point'] - 5;
			$this->user_model->update_point($user_id,$user_point);
		
			redirect(site_url('group/'.$group['id'])); 
		}else{
			redirect(site_url('topic/'.$topic['id']));
			exit();
		}
		
	}
	
	/*
	function savecomment()
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		
		$this->load->model('topic_model');
		$this->load->model('user_model');
		$this->load->model('topic_comment_model');
		$this->load->model('user_notice_model');
		
        $this->load->helper('my_form');
		
        $id = $_GET['topic_id'];
		
		$this->topic_comment_model->author_id = $this->session->userdata('id');
		$this->topic_comment_model->topic_id = $_GET['topic_id'];
		$this->topic_comment_model->parent_comment_id = $_GET['parent_id'];
        $comment = $this->topic_comment_model->load($_GET['parent_id']);
        
		$content = $_GET['content'];
		if($comment){
			$reply_user = $this->user_model->load($comment['author_id']);
			$content = str_replace('@'.$reply_user['displayName'],"<a href='".site_url('user/'.$reply_user['id'])."'>".'@'.$reply_user['displayName']."</a>",$content);
		}
		$this->topic_comment_model->comment_content = $content;
        $this->topic_comment_model->create();

        $topic = $this->topic_model->load($id);
        
        if($topic['author_id']!=$this->session->userdata('id')){
        	$this->user_notice_model->user_id = $topic['author_id'];
        	$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> commented your topic <a href='".site_url('topic/'.$id)."'>".$topic['topic_title']."</a>";
        	$this->user_notice_model->insertData();
        	
        	$this->load->model('email_model');
            $user = $this->user_model->load($topic['author_id']);
            $title = $this->session->userdata('displayName').' commented your topic '.$topic['topic_title'].' on EffectHub.com';
            $content = $this->user_notice_model->content;
			$this->email_model->send_notification($user['email'],$title,$content);
        }
        
        if($comment){
        	$this->user_notice_model->user_id = $comment['author_id'];
        	$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> replyed your comment in <a href='".site_url('topic/'.$id)."'>".$topic['topic_title']."</a>";
        	$this->user_notice_model->insertData();
        	
        	$this->load->model('email_model');
            $user = $this->user_model->load($comment['author_id']);
            $title = $this->session->userdata('displayName').' replyed your comment in '.$topic['topic_title'].' on EffectHub.com';
            $content = $this->user_notice_model->content;
			$this->email_model->send_notification($user['email'],$title,$content);
        }
        
        $this->load->model('topic_model');
        $this->topic_model->comment_num = $topic['comment_num'] + 1;
        $this->topic_model->updateNum($id);
        $this->topic_model->updateCommentTime($id);
        
        $this->load->model('user_status_model');
        $this->user_status_model->user_id = $this->session->userdata('id');
        //$this->user_status_model->content = "commented the topic  <a href='".site_url('topic/'.$topicid)."'>".$topic['topic_title']."</a>\n comment content: ".$content;
        $this->user_status_model->action = "commented the topic";
        $this->user_status_model->target_url = site_url('topic/'.$id);
        $this->user_status_model->target_name = $topic['topic_title'];
        $this->user_status_model->insertData();
        
        $user_id = $this->session->userdata('id');
        $this->load->model('user_model');
        $user = $this->user_model->load($user_id);
        $user_point = $user['point'] + 1;
        $this->user_model->update_point($user_id,$user_point);
        
        // the parameter visit_hot is set to calculate the popular groups of all and the most usually visit groups of one user
        $this->load->model('user_group_model','u_group');
        $e = $this->u_group->loadByUserGroup($this->session->userdata('id'),$topic['group_id']);
        if ($e!=null){
        	$this->u_group->visit_hot = $e['visit_hot'] + 2;
        	$this->u_group->update_hot($topic['group_id']);
        }
        
        $this->load->model('group_model');
        $group = $this->group_model->load($topic['group_id']);
        $this->group_model->visit_hot = $group['visit_hot'] + 2;
        $this->group_model->update_hot($topic['group_id']);
        
		$datetime = date('Y-m-d H:i:s');
		$output = '<li class="response comment group " data-user-id="'.$user['id'].'">
	<h2>
		<a href="'.site_url('user/'.$user_id).'" class="url" title="'.$user['displayName'].'"><img alt="'.$user['displayName'].'" class="photo" src="'.$user['pic_url'].'">&nbsp&nbsp'.$user['displayName'].'</a>
	</h2>
	<div class="comment-body">
		<p style="color:#ddd;width:100%">'.$_GET['content'].'</p>
	</div>
	<p class="comment-meta">
	'.tranTime(strtotime($datetime)).'
	</p>
	</li>';
		/*$output = "<div class='commentitem'>
                            <div class='commentimg'>
                                <a href='".site_url('user/'.$userid)."'><img width='50px' src='".$user['pic_url']."'></a>
                            </div>
                            <div>
                                <div class='paragraphstyle'><b><a href='".site_url('user/'.$userid)."'>".$user['displayName']."</a></b>". tranTime(strtotime($datetime)). "</div>
                                <div class='commenttext'>".$_GET['content']."</div>
                            </div>
                   </div>";*/
	/*
		echo $output; 	
        //redirect(site_url('item/'.$id)); 
	}
	
*/
	public function save_comment()
	{
		if (!$this->session->userdata('id')){          		
			return;
		}	
		
		$this->load->model('topic_comment_model','t_comment');
		$this->t_comment->comment_content = nl2br($this->input->post('content'));
		$this->t_comment->topic_id = $this->input->post('topic');
		$this->t_comment->author_id = $this->session->userdata('id');
		$this->t_comment->parent_comment_id = $this->input->post('parent');
		$parent = $this->input->post('parent');
		$id = $this->input->post('topic');
		$save = $this->t_comment->create();
		$topic_id = $this->db->insert_id();
		$comment = $this->t_comment->load($this->input->post('parent'));
		
		$this->load->model('topic_model');
		$this->load->model('user_model');
		$this->load->model('user_notice_model');
		
		$topic = $this->topic_model->load($this->input->post('topic'));
		
		if($topic['author_id']!=$this->session->userdata('id')){
			$this->user_notice_model->user_id = $topic['author_id'];
			$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> commented your topic <a href='".site_url('topic/'.$id)."'>".$topic['topic_title']."</a>";
			$this->user_notice_model->insertData();
			 
			$this->load->model('email_model');
			$user = $this->user_model->load($topic['author_id']);
			$title = $this->session->userdata('displayName').' commented your topic '.$topic['topic_title'].' on EffectHub.com';
			$content = $this->user_notice_model->content;
			$this->email_model->send_notification($user['email'],$title,$content);
		}
		
		if($comment){
			$this->user_notice_model->user_id = $comment['author_id'];
			$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> replyed your comment in <a href='".site_url('topic/'.$id)."'>".$topic['topic_title']."</a>";
			$this->user_notice_model->insertData();
			 
			$this->load->model('email_model');
			$user = $this->user_model->load($comment['author_id']);
			$title = $this->session->userdata('displayName').' replyed your comment in '.$topic['topic_title'].' on EffectHub.com';
			$content = $this->user_notice_model->content;
			$this->email_model->send_notification($user['email'],$title,$content);
		}
		
		$this->topic_model->comment_num = $topic['comment_num'] + 1;
		$this->topic_model->updateNum($id);
		$this->topic_model->updateCommentTime($id);
		
		$this->load->model('user_status_model');
		$this->user_status_model->user_id = $this->session->userdata('id');
		//$this->user_status_model->content = "commented the topic  <a href='".site_url('topic/'.$topicid)."'>".$topic['topic_title']."</a>\n comment content: ".$content;
		//$this->user_status_model->action = "commented the topic";		
		$this->user_status_model->status_type = 8;
		$this->user_status_model->target_id = $id;
		$this->user_status_model->content_id = $topic_id;
		$this->user_status_model->target_name = $topic['topic_title'];
		$this->user_status_model->insertData();
		
		$user_id = $this->session->userdata('id');
		$this->load->model('user_model');
		$user = $this->user_model->load($user_id);
		$user_point = $user['point'] + 1;
		$this->user_model->update_point($user_id,$user_point);
		
		// the parameter visit_hot is set to calculate the popular groups of all and the most usually visit groups of one user
		$this->load->model('user_group_model','u_group');
		$e = $this->u_group->loadByUserGroup($this->session->userdata('id'),$topic['group_id']);
		if ($e!=null){
			$this->u_group->visit_hot = $e['visit_hot'] + 2;
			$this->u_group->update_hot($topic['group_id']);
		}
		
		$this->load->model('group_model');
		$group = $this->group_model->load($topic['group_id']);
		$this->group_model->visit_hot = $group['visit_hot'] + 2;
		$this->group_model->update_hot($topic['group_id']);
		
		
		return;
		
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
	
	function showmytopic()
    {
    	
    	if (!$this->session->userdata('id')){
    		redirect('login');
    		exit();
    	}
    	
    	$data['nav']= 'groups';
		$data['feature']= 'mygroup';
		
		$id = $this->session->userdata('id');
		$this->load->model('user_model');
		$data['user'] = $this->user_model->load($id);
		
		$this->load->model('topic_model');
		$res = count($this->topic_model->find_topics(array('author_id' => $id), 0, 0));
		$this->load->library('pagination');
		$config = $this->config->item('pagination');
		$config['uri_segment'] = '3';
		$config['total_rows'] = $res;
		$config['per_page'] = '10';
		$config['base_url'] = site_url('topic/showmytopic');
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$this->pagination->initialize($config);//分页的初始化
		
		$data['topic_list'] = $this->topic_model->find_topics(array('author_id' => $id), 10, $this->uri->segment(3));
		
    	$this->load->model('group_model');
    	$data['hot_groups'] = $this->group_model->find_groups(array('rand'=>'1'), 5, 0);

    	$data['topic_num'] = count($this->topic_model->find_topics(array('author_id'=>$this->session->userdata('id')),0,0));
	   	$this->load->view('topic/topic_mine',$data);
    }
    //search item --local search
    function search()
    {
    	$this->load->model('topic_model');
    
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
    
    	$res= $this->topic_model->particle_search($input_str);
    
    	$this->load->library('pagination');//加载分页类
    	$config['base_url'] = base_url().'topic/search?keyword='.$input_str;//设置分页的url路径
    	$config['total_rows'] = count($res);//得到数据库中的记录的总条数
    	$config['per_page'] = '10';//每页记录数
    	$config['first_link'] = 'First';
    	$config['last_link'] = 'Last';
    	$config['full_tag_open'] = '<p>';
    	$config['full_tag_close'] = '</p>';
    	$config['page_query_string'] = TRUE;
    	$this->pagination->initialize($config);//分页的初始化
    	$data['results']= $this->topic_model->particle_search_offset($input_str,$config['per_page'],$this->uri->segment(3));//得到数据库记录
    	$data['seach_active_tag'] = 'topic';
    
    	$data['input_str'] = $input_str;
    	$this->load->view('search_result',$data);
    }

}

?>
