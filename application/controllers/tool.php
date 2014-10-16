<?php
/**
 * 首页
 *
 *
 */
class Tool extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
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
        	$this->lang->load('tool','chinese');
        	$this->lang->load('pop','chinese');
        	$this->lang->load('single_work','chinese');
        	$this->lang->load('other','chinese');
        	$this->lang->load('user','chinese');
        	
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('tool','english');
        	$this->lang->load('pop','english');
        	$this->lang->load('single_work','english');
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
   

    function index($id=null,$pnum=0)
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
	   $this->load->model('tool_model');
       $data = array();
       $data['lang'] = $lang;
	   $data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/main.css'>";
	   $data['nav']= 'jobs';
		$data['feature']= 'jobs';
	   if($id!=null){
	   		$this->load->helper('time');
	   		$this->load->helper('date');
	   		$data['tool'] = $this->tool_model->loadByKey($id);
	   		if($data['tool']==null){
	   			$data['tool'] = $this->tool_model->load($id);
	   		}
	   		if($data['tool']==null){
	   			redirect(site_url('home')); 
	   		}
	   		$data['isin'] = 0;
	   		$id = $data['tool']['id'];
	   			$this->load->model('user_group_model');
	   		if ($this->session->userdata('id')){
	   			$data['isin'] = $this->user_group_model->loadCountByUser($this->session->userdata('id'),$data['tool']['group_id']);
	   		}
	   		
	   		if ($this->session->userdata('id')!=$data['tool']['author_id']){
		        $this->tool_model->view_num = $data['tool']['view_num']+1;
		        $this->tool_model->updateViewNum($id);
	        }
	        
	   		$this->load->model('topic_model');
	   		$this->load->model('group_model');
	   		$this->load->model('item_model');
	   		$data['title'] = $data['tool']['name'];
	   		$this->load->model('url_model');
	   		$data['group'] = $this->group_model->load($data['tool']['group_id']);
	   		$data['urls'] = $this->url_model->find_urls(array('tool'=>$id), 50, 0);
	   		$options = array('conditions' => $data['tool']['group_id'],'topic_language'=>$lang);
	   		$data['group_user_list'] = $this->user_group_model->loadByGroup($data['tool']['group_id']);
			$data['topic_list'] = $this->topic_model->find_topics($options, 10,0);
	   		$data['hot_tools'] = $this->tool_model->find_tools(array('rand'=>'1','type'=>$data['tool']['type']), 6, 0);
	   		$data['hot_item_list'] = $this->item_model->find_items(array('typenotin'=>12,'tool'=>$data['tool']['id']), 12, 0);
	   		$data['hot_showcase_list'] = $this->item_model->find_items(array('type'=>12,'tool'=>$data['tool']['id']), 12, 0);
	   		$data['parent'] = $this->tool_model->load($data['tool']['parent_id']);
	   		$data['subtool_list'] = $this->tool_model->find_tools(array('parent_id'=>$data['tool']['id']), 100, 0);
	   		$this->load->view('tool/tool',$data);
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
	   	
			$data['title'] = 'EffectHub.com Tools & Framewroks';
			$data['nav']= 'jobs';
			$data['type']= 'all';
			$data['feature']= 'MostAppreciated';
	        $this->load->model('tool_type_model');
	        $data['item_type_list'] = $this->tool_type_model->find_tool_types();
	        
	        $this->load->model('tool_model');
			$data['tool_num'] = $this->tool_model->count_tools(array());
	        
	        $this->load->library('pagination');//加载分页类
	        $config['base_url'] = base_url().'index.php/tool/featured/MostAppreciated/all';//设置分页的url路径
	        $config['total_rows'] = $data['tool_num'];//得到数据库中的记录的总条数
	        $config['uri_segment'] = 5;
	        $config['per_page'] = '12';//每页记录数
	        $config['first_link'] = 'First';
	        $config['last_link'] = 'Last';
	        $config['full_tag_open'] = '<p>';
	 	    $config['full_tag_close'] = '</p>'; 
	        $this->pagination->initialize($config);//分页的初始化
			$data['tool_list'] = $this->tool_model->order_tool_by_feature_offset('MostAppreciated','all',$config['per_page'],$this->uri->segment(5));
			
		    $this->load->view('tool/tool_list',$data);
	   }
    }
    
    function featured($featurename,$type='all')
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
		 
		$data['nav']= 'jobs';
		$data['type']= 'all';
		$this->load->model('tool_model');
		$data['tool_num'] = $this->tool_model->count_tool_by_feature($featurename,$type);
		$data['feature'] = $featurename;
        $data['type'] = $type;
        $this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'index.php/tool/featured/'.$featurename.'/'.$type;//设置分页的url路径
        $config['total_rows'] = $data['tool_num'];//得到数据库中的记录的总条数
        $config['uri_segment'] = 5;
        $config['per_page'] = '12';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $this->load->model('tool_type_model');
	    $data['item_type_list'] = $this->tool_type_model->find_tool_types();
		$data['tool_list'] = $this->tool_model->order_tool_by_feature_offset($featurename,$type,$config['per_page'],$this->uri->segment(5));
		$this->load->view('tool/tool_list',$data);
	}
    
    function edit($id)
    {
    	if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$data['nav']= 'jobs';
		$data['feature']= 'groups';
    	$data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/main.css'>";
    	$this->load->model('tool_model');
    	$this->load->model('platform_model');
		$data['platform_list'] = $this->platform_model->find_platforms(array(), 100, 0);
	        $this->load->model('tool_type_model');
	        $data['item_type_list'] = $this->tool_type_model->find_tool_types();
    	$data['tool'] = $this->tool_model->load($id);
    	$this->load->view('tool/tool_edit',$data);
    }
    
    function submit()
    {
    	if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$data['nav']= 'jobs';
		$data['feature']= 'groups';
       $data = array();
	   $data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/main.css'>";
	   $data['title'] = 'Submit Tool & Framework';
	   $this->load->model('platform_model');
		$data['platform_list'] = $this->platform_model->find_platforms(array(), 100, 0);
	        $this->load->model('tool_type_model');
	        $data['item_type_list'] = $this->tool_type_model->find_tool_types();
	   $this->load->view('tool/tool_create',$data);
    }
    
    function addlink($id)
    {
    	if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$data['nav']= 'jobs';
		$data['feature']= 'groups';
    	$data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/main.css'>";
    	$this->load->model('tool_model');
    	$data['tool'] = $this->tool_model->load($id);
    	$this->load->view('tool/tool_add_link',$data);
    }
    
    function editlink($id)
    {
    	if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$data['nav']= 'jobs';
		$data['feature']= 'groups';
    	$data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/main.css'>";
    	$this->load->model('url_model');
    	$data['url'] = $this->url_model->load($id);
    	$this->load->view('tool/tool_edit_link',$data);
    }
    
    function savelink()
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$this->load->model('url_model');
        $this->url_model->title = $this->input->post('name');
        $this->url_model->url = $this->input->post('url');
    	$this->url_model->desc = nl2br($this->input->post('desc'));
		$this->url_model->tool_id = $this->input->post('tool');
		$this->url_model->create();
		redirect(site_url('tool/'.$this->input->post('tool'))); 
	}
	
	function updatelink()
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$this->load->model('url_model');
        $this->url_model->title = $this->input->post('name');
        $this->url_model->url = $this->input->post('url');
    	$this->url_model->desc = nl2br($this->input->post('desc'));
		$this->url_model->update($this->input->post('urlid'));
		redirect(site_url('tool/'.$this->input->post('tool'))); 
	}
	
	function createFromGroup($group_id)
	{
		$this->load->model('group_model');
		$group = $this->group_model->load($group_id);
		
		$group_type_id = $group['group_type'];
		$this->load->model('group_type_model');
		$group_type = $this->group_type_model->load($group_type_id);
		
		$this->load->model('tool_model');
        $this->tool_model->name = $group['group_name'];
        $this->tool_model->domain = $group['key'];
    	$this->tool_model->desc = $group['group_desc'];;
    	$this->tool_model->platform = 0;
		$this->tool_model->type = $group_type['tool_type'];
		$this->tool_model->author_id = $group['admin_id'];
		$this->tool_model->create();
		
		$new_tool_id = $this->db->insert_id();
		
		$this->tool_model->pic_url = $group['group_pic'];
		$this->tool_model->thumb_url = $group['group_pic'];
		$this->tool_model->updatePic($new_tool_id);
		
		$this->tool_model->group_id = $group_id;
		$this->tool_model->updateGroup($new_tool_id);
		
		redirect(site_url('tool/'.$new_tool_id)); 
	}
    
    function save()
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		
		$this->load->model('tool_model');
        $this->tool_model->name = $this->input->post('name');
        $this->tool_model->domain = $this->input->post('domain');
    	$this->tool_model->desc = nl2br($this->input->post('desc'));
    	$this->tool_model->platform = $this->input->post('platform');
		$this->tool_model->type = $this->input->post('type');
		$this->tool_model->github_url = $this->input->post('github');
		$this->tool_model->author_id = $this->session->userdata('id');
		$this->tool_model->create();
		$new_tool_id = $this->db->insert_id();
		
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
				$user_id = $new_tool_id;
				$rs = array();
				$input = file_get_contents($_FILES["url"]["tmp_name"]);
				$data = $input;
				//设置上传目录
				$upload_dir = 'tool';
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
			$config['width'] = 60;
			$config['height'] = 60;
			
			$this->load->library('image_lib', $config); 
			
			$this->image_lib->resize();
			
			$this->tool_model->pic_url = base_url().'uploads/'.$upload_dir.'/'.$user_id.'.jpg';
    		$this->tool_model->thumb_url = base_url().'uploads/'.$upload_dir.'/'.$user_id.'_thumb.jpg';
    		$this->tool_model->updatePic($new_tool_id);
    	}else{
    		$this->tool_model->pic_url = 'http://www.effecthub.com/img/default.jpg';
    		$this->tool_model->thumb_url = 'http://www.effecthub.com/img/default.jpg';
    		$this->tool_model->updatePic($new_tool_id);
    	}
    	
    	$tool_type_id = $this->input->post('type');
		$this->load->model('tool_type_model');
		$tool_type = $this->tool_type_model->load($tool_type_id);
		
		$this->load->model('group_model');
        $this->group_model->group_name = $this->input->post('name');
    	$this->group_model->group_desc = nl2br($this->input->post('desc'));
		$this->group_model->group_key = $this->input->post('domain');
		$this->group_model->group_type = $tool_type['group_type'];
		$this->group_model->is_private = 0;
		$this->group_model->member_num = 1;
	    $this->group_model->topic_num = 0;
		$this->group_model->admin_id = $this->session->userdata('id');
		$this->group_model->group_pic = $this->tool_model->thumb_url;
		$this->group_model->create();
		
		$new_group_id = $this->db->insert_id();
		
		$this->tool_model->group_id = $new_group_id;
		$this->tool_model->updateGroup($new_tool_id);
		
		$this->load->model('user_group_model');
    	$this->user_group_model->user_id = $this->session->userdata('id');
		$this->user_group_model->group_id = $new_group_id;
		$this->user_group_model->role = 0;
    	$this->user_group_model->create();
    	
    	$this->load->model('user_status_model');	
        $this->user_status_model->user_id = $this->session->userdata('id');
    	$this->user_status_model->action = "submitted tool";
		$this->user_status_model->pic_url = $this->group_model->group_pic;
    	$this->user_status_model->target_url = site_url('tool/'.$new_tool_id);
		$this->user_status_model->target_name = $this->group_model->group_name;
		$this->user_status_model->target_id = $new_tool_id;
	    $this->user_status_model->status_type = 22;
		$this->user_status_model->insertData();
    	
		redirect(site_url('tool/'.$new_tool_id)); 
	}
	
	function update()
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$this->load->model('tool_model');
        $this->tool_model->name = $this->input->post('name');
        $this->tool_model->domain = $this->input->post('domain');
    	$this->tool_model->desc = nl2br($this->input->post('desc'));
    	$this->tool_model->platform = $this->input->post('platform');
		$this->tool_model->type = $this->input->post('type');
		$this->tool_model->github_url = $this->input->post('github');
		$this->tool_model->author_id = $this->session->userdata('id');
		$this->tool_model->pic_url = $this->input->post('last_pic');
		$id =  $this->input->post('tool');
		$this->tool_model->update($id);
		
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
				$upload_dir = 'tool';
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
			$config['width'] = 60;
			$config['height'] = 60;
			
			$this->load->library('image_lib', $config); 
			
			$this->image_lib->resize();
			
			$this->tool_model->pic_url = base_url().'uploads/'.$upload_dir.'/'.$user_id.'.jpg';
    		$this->tool_model->thumb_url = base_url().'uploads/'.$upload_dir.'/'.$user_id.'_thumb.jpg';
    		$this->tool_model->updatePic($id);
    	}
    	
		$toola = $this->tool_model->load($id);
    	$this->load->model('group_model');
        $this->group_model->group_name = $this->input->post('name');
    	$this->group_model->group_desc = nl2br($this->input->post('desc'));
		$this->group_model->group_pic = $toola['thumb_url'];
		$this->group_model->group_type = 2;
		$this->group_model->update($toola['group_id']);
    	
		redirect(site_url('tool/'.$id)); 
	}

    function showmygroup($id)
    {
    	if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		$data['nav']= 'groups';
		$data['feature']= 'mygroup';
    	$this->load->model('user_group_model');
    	$data['my_group_list'] =$this->user_group_model->loadByUser($id);
    	$this->load->model('group_type_model');
    	$this->load->model('group_model');
    	$data['group_type_list'] = $this->group_type_model->find_group_types(array(), 100, 0);
    	$this->load->model('topic_model');
    	$data['admin_groups'] = $this->group_model->find_groups(array('admin'=>$id), 100, 0);
    	$data['admin_private_groups'] = $this->group_model->find_groups(array('admin'=>$id,'private'=>'on'), 100, 0);
		$data['new_groups'] = $this->group_model->find_groups(array('order'=>'id'), 5, 0);
		$data['topic_list'] = $this->topic_model->find_topics(array('order'=>'comment_num'), 10, 0);
		$this->load->view('group/group_mine',$data);
    }
    //search item --local search
    function search()
    {
    	$this->load->model('tool_model');
    
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
    
    	$res= $this->tool_model->particle_search($input_str);
    
    	$this->load->library('pagination');//加载分页类
    	$config['base_url'] = base_url().'tool/search?keyword='.$input_str;//设置分页的url路径
    	$config['total_rows'] = count($res);//得到数据库中的记录的总条数
    	$config['per_page'] = '10';//每页记录数
    	$config['first_link'] = 'First';
    	$config['last_link'] = 'Last';
    	$config['full_tag_open'] = '<p>';
    	$config['full_tag_close'] = '</p>';
    	$config['page_query_string'] = TRUE;
    	$this->pagination->initialize($config);//分页的初始化
    	$data['results']= $this->tool_model->particle_search_offset($input_str,$config['per_page'],$this->uri->segment(3));//得到数据库记录
    	$data['seach_active_tag'] = 'tool';
    
    	$data['input_str'] = $input_str;
    	$this->load->view('search_result',$data);
    }
}

?>
