<?php
/**
 * 首页
 *
 *
 */
class Group extends CI_Controller
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
			
			$this->session->set_userdata('language',$lang);
			
		}
        if ($lang==2)
        {
        	$this->lang->load('header','chinese');
        	$this->lang->load('pop','chinese');
        	$this->lang->load('footer','chinese');
        	$this->lang->load('group','chinese');
        	$this->lang->load('other','chinese');
        	$this->lang->load('user','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('pop','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('group','english');
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
   

    function index($id=0,$local=1)
    {    
    	$this->load->model('topic_model');
	   	$this->load->model('group_model');
	   	$this->load->model('group_type_model');
       	$data = array();
	   	$data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/main.css'>";
	   	$data['nav']= 'groups';
		$data['feature']= 'groups';
	   	if($id!=null){
	   		$this->load->helper('time');
	   		$this->load->helper('date');
	   		$this->load->model('user_group_model');
	   		$this->load->model('tool_model');
	   		$this->load->model('user_invite_model');
	   		$data['group'] = $this->group_model->loadbykey($id);
	   		if($data['group']==null){
	   			$data['group'] = $this->group_model->load($id);
	   		}
	   		if($data['group']==null){
	   			redirect(site_url('home')); 
	   		}
	   		$data['tool'] = $this->tool_model->loadByGroup($id);
	   		$id = $data['group']['id'];
	   		$data['title'] = $data['group']['group_name'].' group';
	   		$data['group_user_list'] = $this->user_group_model->loadByGroup($id);
	   		$data['isin'] = 0;
	   		$data['invite'] = 0;
	   		if ($this->session->userdata('id')){
	   			$data['isin'] = $this->user_group_model->loadCountByUser($this->session->userdata('id'),$id);
	   			$data['invite'] = $this->user_invite_model->loadCountByUser($this->session->userdata('id'),$id);
	   			
	   			// visit_hot is set to calculate popular groups
	   			$this->group_model->visit_hot = $data['group']['visit_hot'] + 1;
	   			$this->group_model->update_hot($id);
	   			
	   			$mygroup = $this->user_group_model->loadByUserGroup($this->session->userdata('id'),$id);
	   			if ($mygroup){
	   				$this->user_group_model->visit_hot = $mygroup['visit_hot'] + 1;
	   				$this->user_group_model->update_hot($id);
	   			}
	   		}
	   		
	   		$data['local'] = $local;
			$options = array('conditions' => $id);
			$data['total'] = $this->topic_model->count_topics($id,$options); 		
			
			if ($local == 2) {
				$local_total = $data['total'];
			} else {	
				$local_total = $this->topic_model->count_topics($id,array('conditions'=>$id,'language'=>$this->session->userdata('language')));
			
			}
		    //分页配置
			$this->config->set_item('enable_query_strings',FALSE) ;
	        $config = $this->config->item('pagination');
			$config['uri_segment'] = '5';
			$config['total_rows'] = $local_total;
			$config['per_page'] = '20';	
			$config['base_url'] = site_url('group/index/'.$id.'/'.$local);
	
			//生成分页
	        $this->load->library('pagination');
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
	        
			$page = $this->uri->segment(5);
			if (!empty($page) && (int)$page>0){
				$page_offset = (int)$page;
	        } else {
	            $page_offset = 0;
	        }
	        if ($local == 1) {
	   			$data['topic_list'] = $this->topic_model->find_topics(array('conditions'=>$id,'language'=>$this->session->userdata('language')), $config['per_page'],$page_offset);
	        } else {
	        	$data['topic_list'] = $this->topic_model->find_topics($options, $config['per_page'],$page_offset);
	        }
	   		$data['popular_list'] = $this->topic_model->find_topics(array('conditions' => $id,'order'=>'comment_num'), 5, 0);
	  		$data['hot_groups'] = $this->group_model->find_groups(array('rand'=>'1','type'=>$data['group']['group_type']), 5, 0);
	   		$this->load->view('group/group',$data);
	   }else{
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
			//load hotest groups
			$groups = $this->group_model->find_groups(array(),0,0,1);
			
			$now = time();
			for ($i = 0; $i < count($groups); $i++) {
				$t = strtotime($groups[$i]['create_date']);
				$day = (int)(($now - $t)/(24*60*60)) + 1;
				$groups[$i]['hot'] = (float)(($groups[$i]['visit_hot'] + $groups[$i]['topic_num'] * 3 + $groups[$i]['member_num'] * 5)/$day);
			}
			 
			$data['hot_groups'] = array();
			$hot_group = array();
			
			// exchange range and select 30 hot groups of all
			for ($i = 0; $i < 30; $i++){
				$temp = $i;
				for ($j = ($i + 1); $j < (count($groups)); $j++) {
					if ($groups[$j]['hot'] > $groups[$temp]['hot']) $temp = $j;
				}
			
				$data['hot_groups'][$i] = $groups[$temp];
			
				$hot_group = $groups[$i];
				$groups[$i] = $groups[$temp];
				$groups[$temp] = $hot_group;
			}
			
			//load hotest topics
			$topics = $this->topic_model->find_topics(array('order'=>'view_num','topic_language'=>$lang),1000,0);
			
			for ($i = 0; $i < count($topics); $i++) {
				$t = strtotime($topics[$i]['create_date']);
				$day = (int)(($now - $t)/(24*60*60)) + 1;
				$topics[$i]['hot'] = (float)(($topics[$i]['comment_num'] * 3 + $topics[$i]['view_num'])/$day);
			}
			
			$data['hot_topics'] = array();
			$hot_topic = array();
			
			// exchange range and select 30 hot topics of all
			for ($i = 0; $i < 30; $i++){
				$temp = $i;
				for ($j = ($i + 1); $j < (count($topics)); $j++) {
					if ($topics[$j]['hot'] > $topics[$temp]['hot']) $temp = $j;
				}
					
				$data['hot_topics'][$i] = $topics[$temp];
					
				$hot_topic = $topics[$i];
				$topics[$i] = $topics[$temp];
				$topics[$temp] = $hot_topic;
			}

			$this->load->model('group_type_model');
			
			$data['group_type'] = $this->group_type_model->find_types(array('order'=>'order'),20,0);
			
			if ($this->session->userdata('id')) {
				$this->load->model('user_group_model');
				$data['group_num'] = $this->user_group_model->group_num($this->session->userdata('id'));
			 
				$data['topic_num'] = count($this->topic_model->find_topics(array('author_id'=>$this->session->userdata('id')),0,0));
			 
				$this->load->model('user_model');
				$data['user'] = $this->user_model->load($this->session->userdata('id'));
			}
	
		    $this->load->view('group/group_explore',$data);
	   }
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
    	$this->load->model('group_model');
    	$this->load->model('group_type_model');
    	$data['group'] = $this->group_model->load($id);
    	$data['group_type_list'] = $this->group_type_model->find_types(array(), 100, 0);
    	$data['hot_groups'] = $this->group_model->find_groups(array('rand'=>'1'), 5, 0);
    	$this->load->view('group/group_edit',$data);
    }
    
    function accept($id)
    {
    	if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$this->load->model('user_invite_model');
		$is_send = $this->user_invite_model->loadCountByUser($this->session->userdata('id'),$id);
		if($is_send>0){
			$this->user_invite_model->status = 1;
		    $this->user_invite_model->update($this->session->userdata('id'),$id);
		    
		    $this->load->model('user_group_model');
	    	$this->user_group_model->user_id = $this->session->userdata('id');
			$this->user_group_model->group_id = $id;
			$this->user_group_model->role = 0;
	    	$this->user_group_model->create();
	    	
	    	$this->load->model('group_model');
			$group = $this->group_model->load($id);
	    	$this->group_model->member_num = $group['member_num'] + 1;
			$this->group_model->updateMemberNum($id);
			
			$this->load->model('user_status_model');	
	        $this->user_status_model->user_id = $this->session->userdata('id');
	    	//$this->user_status_model->action = "joined group";
			$this->user_status_model->pic_url = $group['group_pic'];
	    	$this->user_status_model->target_id = $id;
	    	$this->user_status_model->target_name = $group['group_name'];
	        $this->user_status_model->status_type = 15;
	    	
	    	//$this->user_status_model->target_url = site_url('group/'.$id);
			//$this->user_status_model->target_name = $group['group_name'];
			
			$this->user_status_model->insertData();
		}
		redirect(site_url('group/'.$id)); 
    }
    
    function decline($id)
    {
    	if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$this->load->model('user_invite_model');
		$is_send = $this->user_invite_model->loadCountByUser($this->session->userdata('id'),$id);
		if($is_send>0){
			$this->user_invite_model->status = 2;
		    $this->user_invite_model->update($this->session->userdata('id'),$id);
		}
		redirect(site_url('group/'.$id)); 
    }
    
    function invite($id)
    {
    	if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$data['nav']= 'groups';
		$data['feature']= 'groups';
    	$data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/main.css'>";
    	$this->load->model('group_model');
    	$this->load->model('group_type_model');
    	$data['group'] = $this->group_model->load($id);
    	$this->load->model('user_model');
    	$data['following_list'] = $this->user_model->find_followers($this->session->userdata('id'));
    	$data['hot_groups'] = $this->group_model->find_groups(array('rand'=>'1'), 5, 0);
    	$this->load->view('group/group_invite',$data);
    }
    
    function inviteFollow($id)
    {
    	if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$data['nav']= 'groups';
		$data['feature']= 'groups';
    	$data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/main.css'>";
    	$this->load->model('group_model');
    	$this->load->model('group_type_model');
    	$data['group'] = $this->group_model->load($id);
    	$this->load->model('user_model');
    	$data['following_list'] = $this->user_model->find_following($this->session->userdata('id'));
    	$data['hot_groups'] = $this->group_model->find_groups(array('rand'=>'1'), 5, 0);
    	$this->load->view('group/group_invite',$data);
    }
    
    function send_invite()
    {
    	
	    $this->load->model('user_mail_model');

        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('group_model');
        $this->load->model('user_invite_model');
        $this->load->model('user_group_model');
        $group = $this->group_model->load($this->input->post('group'));
    	$ids = $this->input->post('uid');
    	for ($i=0; $i<count($ids); $i++)
		{
		  if($ids[$i]!=''){
		  		$is_in = $this->user_group_model->loadCountByUser($ids[$i],$this->input->post('group'));
		  		if($is_in<1){
				  	$this->user_mail_model->receiver_id = $ids[$i];
				    $this->user_mail_model->sender_id = $this->session->userdata('id');
				    $this->user_mail_model->content = $this->input->post('desc').' '.site_url('group/'.$group['id']);
			        $this->user_mail_model->insertData();
			        
			        
			        $is_send = $this->user_invite_model->loadCountByUser($ids[$i],$this->input->post('group'));
			        if($is_send<1){
				    	$this->user_invite_model->user_id = $ids[$i];
				    	$this->user_invite_model->inviter_id = $this->session->userdata('id');
						$this->user_invite_model->group_id = $this->input->post('group');
				    	$this->user_invite_model->create();
			        }
			        
			        $user = $this->user_model->load($ids[$i]);
			        $title = $this->session->userdata('displayName').' has sent you a invitation on EffectHub.com';
			        $url = site_url('group/'.$group['id']);
			        $content = $this->input->post('desc').' <a href="'.$url.'" target="_blank">'.$url.'</a>';
					$this->email_model->send_notification($user['email'],$title,$content);
		  		}
		  }
		}
		redirect(site_url('group'));
    }
    
    function join($id)
    {
    	if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
    	$this->load->model('user_group_model');
    	$this->user_group_model->user_id = $this->session->userdata('id');
		$this->user_group_model->group_id = $id;
		$this->user_group_model->role = 0;
    	$this->user_group_model->create();
    	
    	
    	$this->load->model('group_model');
		$group = $this->group_model->load($id);
    	$this->group_model->member_num = $group['member_num'] + 1;
		$this->group_model->updateMemberNum($id);
		
		
    	$this->load->model('user_status_model');	
        $this->user_status_model->user_id = $this->session->userdata('id');
    	//$this->user_status_model->action = "joined group";
		$this->user_status_model->pic_url = $group['group_pic'];
	   	$this->user_status_model->target_id = $id;
	   	$this->user_status_model->target_name = $group['group_name'];
	    $this->user_status_model->status_type = 15;
	    	
	    //$this->user_status_model->target_url = site_url('group/'.$id);
		//$this->user_status_model->target_name = $group['group_name'];
			
		$this->user_status_model->insertData();
		
    	redirect(site_url('group/'.$id)); 
    }
    
    function quit($id)
    {
    	if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
    	$this->load->model('user_group_model');
    	$this->user_group_model->delete($this->session->userdata('id'),$id);
    	$this->load->model('group_model');
		$group = $this->group_model->load($id);
		
    	/*if($this->session->userdata('id')==$group['admin_id']){
    		$this->group_model->admin_id = null;
    		$this->group_model->updateAdmin($id);
    	}*/
    	$this->group_model->member_num = $group['member_num'] - 1;
		$this->group_model->updateMemberNum($id);
    	redirect(site_url('group/'.$id)); 
    }    
    
    function create()
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
      	$data = array();
		$data['lang'] = $lang;
       	$this->load->model('group_type_model');
       	$this->load->model('group_model');
	   	$data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/main.css'>";
	   	$data['title'] = 'Create Group';
	   	$data['group_type_list'] = $this->group_type_model->find_types(array(), 100, 0);
	   	$data['hot_groups'] = $this->group_model->find_groups(array('rand'=>'1'), 5, 0);
	   	$this->load->view('group/group_create',$data);
    }
    
    function save()
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$this->load->model('group_model');
        $this->group_model->group_name = htmlspecialchars($this->input->post('name'),ENT_QUOTES);
    	$this->group_model->group_desc = htmlspecialchars(nl2br($this->input->post('desc')),ENT_QUOTES);
		$this->group_model->group_type = $this->input->post('type');
		$this->group_model->group_key = strtolower(trim($this->group_model->group_name));
		$this->group_model->is_private = $this->input->post('private');
		$this->group_model->member_num = 1;
	    $this->group_model->topic_num = 0;
		$this->group_model->admin_id = $this->session->userdata('id');
		$this->group_model->group_pic = 'http://www.effecthub.com/uploads/group/1.jpg';
		$this->group_model->group_weibo_id = $this->input->post('weibo');
		
		$this->group_model->create();
		$new_group_id = $this->db->insert_id();
		$this->load->model('user_group_model');
    	$this->user_group_model->user_id = $this->session->userdata('id');
		$this->user_group_model->group_id = $new_group_id;
		$this->user_group_model->role = 0;
    	$this->user_group_model->create();
		
		$pic_path = '';
    	if ((($_FILES["url"]["type"] == "image/gif")
		|| ($_FILES["url"]["type"] == "image/jpeg")
		|| ($_FILES["url"]["type"] == "image/pjpeg")
		|| ($_FILES["url"]["type"] == "image/png")
		|| ($_FILES["url"]["type"] == "image/bmp")
		|| ($_FILES["url"]["type"] == "image/tiff"))
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
				$user_id = $new_group_id;
				$rs = array();
				$input = file_get_contents($_FILES["url"]["tmp_name"]);
				$data = $input;
				//设置上传目录
				$upload_dir = 'group';
				$dir = UploadPath($upload_dir);
				//大图
				$file_name=$dir.'/'.$user_id.'.jpg';
		
				@file_put_contents($file_name, $data);
				$pic_path = base_url().'uploads/'.$upload_dir.'/'.$user_id.'.jpg';
				$rs['status'] = 1;		
			}
		}
		if($pic_path!=''&&$pic_path!=null){
    		$config['image_library'] = 'gd2';
			$config['source_image'] = $file_name;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 80;
			$config['height'] = 80;
			
			$this->load->library('image_lib', $config); 
			
			$this->image_lib->resize();
			
    		$this->group_model->group_pic = base_url().'uploads/'.$upload_dir.'/'.$user_id.'_thumb.jpg';
    		$this->group_model->update($new_group_id);
    	}
    	
    	
    	$this->load->model('user_status_model');	
        $this->user_status_model->user_id = $this->session->userdata('id');
        
		$this->user_status_model->pic_url = $this->group_model->group_pic;
    	//$this->user_status_model->action = "joined group";
	    $this->user_status_model->target_id = $new_group_id;
	    $this->user_status_model->target_name = $this->group_model->group_name;
	    $this->user_status_model->status_type = 16;
	    	
	    //$this->user_status_model->target_url = site_url('group/'.$id);
		//$this->user_status_model->target_name = $group['group_name'];
			
		$this->user_status_model->insertData();
    	
		redirect(site_url('group/'.$new_group_id)); 
	}
	
	function update()
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$this->load->model('group_model');
        $this->group_model->group_name = $this->input->post('name');
    	$this->group_model->group_desc = nl2br($this->input->post('desc'));
		$this->group_model->group_key = strtolower(trim($this->group_model->group_name));
		$this->group_model->group_type = $this->input->post('type');
		$this->group_model->group_pic = $this->input->post('last_pic');
		$this->group_model->is_private = $this->input->post('private');
		$this->group_model->group_weibo_id = $this->input->post('weibo');
		$id =  $this->input->post('group');
		$this->group_model->update($id);
		$pic_path = '';
    	if ((($_FILES["url"]["type"] == "image/gif")
		|| ($_FILES["url"]["type"] == "image/jpeg")
		|| ($_FILES["url"]["type"] == "image/pjpeg")
		|| ($_FILES["url"]["type"] == "image/png")
		|| ($_FILES["url"]["type"] == "image/bmp")
		|| ($_FILES["url"]["type"] == "image/tiff"))
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
				$user_id = $id;
				$rs = array();
				$input = file_get_contents($_FILES["url"]["tmp_name"]);
				$data = $input;
				//设置上传目录
				$upload_dir = 'group';
				$dir = UploadPath($upload_dir);
				//大图
				$file_name=$dir.'/'.$user_id.'.jpg';
		
				@file_put_contents($file_name, $data);
				$pic_path = base_url().'uploads/'.$upload_dir.'/'.$user_id.'.jpg';
				$rs['status'] = 1;		
		    }
		  }
    	if($pic_path!=''&&$pic_path!=null){
    		$config['image_library'] = 'gd2';
			$config['source_image'] = $file_name;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 80;
			$config['height'] = 80;
			
			$this->load->library('image_lib', $config); 
			
			$this->image_lib->resize();
			
    		$this->group_model->group_pic = base_url().'uploads/'.$upload_dir.'/'.$user_id.'_thumb.jpg';
    		$this->group_model->updatePic($id);
    	}
		redirect(site_url('group/'.$id)); 
	}

    function mygroup()
    {
    	if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		
		$id = $this->session->userdata('id');
		$data['nav']= 'groups';
		$data['feature']= 'mygroup';
    	$this->load->model('user_group_model');
    	
    	//calculate the groups I usually visit
    	$groups = $this->user_group_model->loadByUser($id);
    	$now = time();
    	for ($i = 0; $i < count($groups); $i++) {
    		$t = strtotime($groups[$i]['timestamp']);
    		$day = (int)(($now - $t)/(24*60*60)) + 1;
    		$groups[$i]['hot'] = (float)($groups[$i]['visit_hot']/$day);
    	}
    	
    	$data['my_hot_groups'] = array();
    	$hot_group = array();
    	
    	$this->load->model('topic_model','tmodel');
    	// exchange range and select 5 hot groups I visit
    	if(count($groups)>0){
    		$total = count($groups);
    		if(count($groups)>5)$total=5;
	    	for ($i = 0; $i < $total; $i++){
	    		$temp = $i;
	    		for ($j = ($i + 1); $j < (count($groups)); $j++){
	    			if ($groups[$j]['hot'] > $groups[$temp]['hot']) $temp = $j;
	    		}
	    		
	    		$data['my_hot_groups'][$i] = $groups[$temp];
	    		
	    		$data['my_hot_groups'][$i]['topic'] = $this->tmodel->find_topics(array('conditions'=>$groups[$temp]['group_id'],'order'=>'last_comment_time'), 3, 0);
	    		
	    		$hot_group = $groups[$i];
	    		$groups[$i] = $groups[$temp];
				$groups[$temp] = $hot_group;
	    	}
    	}
    	
    	$data['group_num'] = $this->user_group_model->group_num($this->session->userdata('id'));
    	
    	$data['topic_num'] = count($this->tmodel->find_topics(array('author_id'=>$this->session->userdata('id')),0,0));
    	
    	$this->load->model('user_model');
    	$data['user'] = $this->user_model->load($id);
		
    	$data['my_topics'] = $this->tmodel->find_topics(array('order'=>'last_comment_time','author_id'=>$this->session->userdata('id')),10,0);
    	
		$this->load->view('group/group_home',$data);
    }
    
    function showmygroup()
    {
    	if (!$this->session->userdata('id')){
    		redirect('login');
    		exit();
    	}
    	
    	$id = $this->session->userdata('id');
    	$data['nav']= 'groups';
    	$data['feature']= 'mygroup';
    	
    	$this->load->model('user_model');
    	$data['user'] = $this->user_model->load($id);
    	
    	$this->load->model('group_model','group');
    	$data['my_managing_group'] = $this->group->find_groups(array('admin'=>$this->session->userdata('id')),0,0);
    	
    	$this->load->model('user_group_model','u_group');
    	$data['my_joined_group'] = $this->u_group->loadByUser($this->session->userdata('id'));
    	
    	$this->load->view('group/group_mine',$data);
    	
    }
    
    function allgroup($type = 4)
    {
	   	$data['nav']= 'groups';
		$data['feature']= 'groups';
		
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
		$this->load->model('group_type_model');
		$data['type'] = $type;
    	$data['type_name'] = $this->group_type_model->load($type);

    	$data['group_type'] = $this->group_type_model->find_types(array('order'=>'order'),20,0);
    	
    	$this->load->model('group_model');
    	$data['groups'] = $this->group_model->find_groups(array('type'=>$type,'order'=>'member_num'),0,0,1);

    	$this->load->view('group/group_all',$data);
    	
    }
    
    function members($id)
    {
    	$this->load->model('user_group_model');
    	$res = $this->user_group_model->loadByGroup($id,0);
    	
    	$this->load->library('pagination');//加载分页类
    	$config['base_url'] = site_url('group/members/'.$id);//设置分页的url路径
    	$config['total_rows'] = count($res);//得到数据库中的记录的总条数
    	$config['uri_segment'] = 4;
    	$config['per_page'] = '30';//每页记录数
    	$config['first_link'] = 'First';
    	$config['last_link'] = 'Last';
    	$config['full_tag_open'] = '<p>';
    	$config['full_tag_close'] = '</p>';
    	$this->pagination->initialize($config);//分页的初始化
    	
    	$data['user_list'] = $this->user_group_model->loadByGroup($id,$config['per_page'],$this->uri->segment(4));	   
    	
    	$this->load->model('group_model');
    	$data['group'] = $this->group_model->load($id);
    	
    	$this->load->view('group/group_members',$data);
    }
    function search()
    {
    	$this->load->model('group_model');
    
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
    
    	$res= $this->group_model->particle_search($input_str);
    
    	$this->load->library('pagination');//加载分页类
    	$config['base_url'] = base_url().'group/search?keyword='.$input_str;//设置分页的url路径
    	$config['total_rows'] = count($res);//得到数据库中的记录的总条数
    	$config['per_page'] = '10';//每页记录数
    	$config['first_link'] = 'First';
    	$config['last_link'] = 'Last';
    	$config['full_tag_open'] = '<p>';
    	$config['full_tag_close'] = '</p>';
    	$config['page_query_string'] = TRUE;
    	$this->pagination->initialize($config);//分页的初始化
    	$data['results']= $this->group_model->particle_search_offset($input_str,$config['per_page'],$this->uri->segment(3));//得到数据库记录
    	$data['seach_active_tag'] = 'group';
    
    	$data['input_str'] = $input_str;
    	$this->load->view('search_result',$data);
    }
    
}

