<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Folder extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('time');
		$this->load->helper('my_form');
		$this->load->helper('cookie');
		$this->load->library('encrypt');
		
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
    
    public function forbidden($id=0)
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
        if ($lang==2)
        {
        	$this->lang->load('header','chinese');
        	$this->lang->load('footer','chinese');
        	$this->lang->load('item','chinese');
        	$this->lang->load('user','chinese');
        	$this->lang->load('pop','chinese');
        	$this->lang->load('file','chinese');
        	$this->lang->load('other','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('item','english');
        	$this->lang->load('user','english');
        	$this->lang->load('pop','english');
        	$this->lang->load('file','english');
        	$this->lang->load('other','english');
        }
        
		$this->load->model('item_model');
		$this->load->model('user_folder_model');
		$data = array();
		$data['folder'] = $this->user_folder_model->load($id);
		if($id!=0){
			$data['item_list'] = $this->item_model->find_items(array('folder_id'=>$id,'order'=>'update_date','download'=>1),3,0);
		}
		$this->load->view('file/folder_private',$data);
	}
	
	public function password($folder_id,$msg='')
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
        if ($lang==2)
        {
        	$this->lang->load('header','chinese');
        	$this->lang->load('footer','chinese');
        	$this->lang->load('item','chinese');
        	$this->lang->load('user','chinese');
        	$this->lang->load('pop','chinese');
        	$this->lang->load('file','chinese');
        	$this->lang->load('other','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('item','english');
        	$this->lang->load('user','english');
        	$this->lang->load('pop','english');
        	$this->lang->load('file','english');
        	$this->lang->load('other','english');
        }
		$data['msg'] = $msg;
		$data['folder_id'] = $folder_id;
		$this->load->view('file/folder_password',$data);
	}
    
	public function index($id=0)
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
        if ($lang==2)
        {
        	$this->lang->load('header','chinese');
        	$this->lang->load('footer','chinese');
        	$this->lang->load('item','chinese');
        	$this->lang->load('user','chinese');
        	$this->lang->load('pop','chinese');
        	$this->lang->load('file','chinese');
        	$this->lang->load('other','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('item','english');
        	$this->lang->load('user','english');
        	$this->lang->load('pop','english');
        	$this->lang->load('file','english');
        	$this->lang->load('other','english');
        }
        $data['lang'] = $lang;
		$this->load->model('user_folder_model');
			
		$this->load->model('user_model');
		$userid =$this->session->userdata('id');
    	$user = $this->user_model->load($userid);
    	
    	$data['user']= $user;
    	$data['nav']= 'works';
    	$data['feature']= 'assets';
    	
    	$data['folder'] = $this->user_folder_model->load($id);
    	if($data['folder']==null){
   			redirect('item/none');
			exit();
   		}
    	if($data['folder']['is_private']==1&&($this->session->userdata('id')!=$data['folder']['user_id'])){
   			redirect('folder/forbidden/'.$id);
			exit();
   		}else if($data['folder']['password']&&($this->session->userdata('id')!=$data['folder']['user_id'])){
   			if($data['folder']['password']==$this->input->post('password')){
   			
   			}else{
   				if($this->input->post('password')){
		   			redirect('folder/password/'.$id.'/invalid');
					exit();
   				}else{
   					redirect('folder/password/'.$id);
					exit();
   				}
   			}
    	}
    	if($data['folder']['parent_folder']!=0)
    	$data['parent_folder'] = $this->user_folder_model->load($data['folder']['parent_folder']);
    	$this->load->model('item_type_model');
    	$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1,'order'=>'order','fileable'=>1));
		$typeobj = $this->item_type_model->load($data['folder']['type']);
		if ($data['lang'] == 2) $data['type_name'] = $typeobj['name_cn'];
		else $data['type_name'] = $typeobj['name'];
		$data['type'] = $typeobj['id'];
        $this->load->model('item_model');
        if($id!=0){
        	if ($this->session->userdata('id')==null||$this->session->userdata('id')!=$data['folder']['user_id']){
        		$data['item_count'] = $this->item_model->count_items(array('is_private'=>0,'folder_id'=>$id,'order'=>'update_date','download'=>1));
        		
        		$this->load->library('pagination');//加载分页类
		        $config['base_url'] = base_url().'folder/'.$id;//设置分页的url路径
		        $config['total_rows'] = $data['item_count'];
		        $config['uri_segment'] = 3;
		        $config['per_page'] = '12';//每页记录数
		        $config['first_link'] = 'First';
		        $config['last_link'] = 'Last';
		        $config['full_tag_open'] = '<p>';
		 	    $config['full_tag_close'] = '</p>'; 
		        $this->pagination->initialize($config);//分页的初始化
				$data['item_list'] = $this->item_model->find_items(array('is_private'=>0,'folder_id'=>$id,'order'=>'update_date','download'=>1),$config['per_page'],$this->uri->segment(3));
        		
        		$data['folder_count'] = $this->user_folder_model->count_user_folders(array('is_private'=>0,'parent_folder'=>$id));
				$data['folder_list'] = $this->user_folder_model->find_user_folders(array('is_private'=>0,'parent_folder'=>$id),50);
        	}else{
        		$data['item_list'] = $this->item_model->find_items(array('folder_id'=>$id,'order'=>'update_date','download'=>1,'user'=>$userid));
				$data['item_count'] = $this->item_model->count_items(array('folder_id'=>$id,'order'=>'update_date','download'=>1,'user'=>$userid));
				$data['folder_list'] = $this->user_folder_model->find_user_folders(array('parent_folder'=>$id),50);
				$data['folder_count'] = $this->user_folder_model->count_user_folders(array('parent_folder'=>$id));
        	}
			foreach($data['folder_list'] as $folder){
				$temp_folder = array(
					"id"    =>    $folder['id'],
					"title"        =>    $folder['folder_name'],
					"update_date"    =>    $folder['update_date'],
					"is_private"            =>    $folder['is_private'],
					"password"            =>    $folder['password'],
					"file_size"            =>    0,
					"extension"            =>    '',
					"is_folder"            =>    1,
					"extension_bg_thumb"   =>    0,
					"extension_bg_thumb_y"   =>    0,
					"thumb_url"   =>    0
				);
				if(!in_array($temp_folder,$data['item_list'])){
						array_unshift($data['item_list'],$temp_folder);
				}
			}
        }
        $data['folder_size'] = $this->user_folder_model->get_sum_filesize($id);
		$this->load->model('team_member_model','t_member');
		$data['team_list'] = $this->t_member->load_user_teams($this->session->userdata('id'));
		if ($this->session->userdata('id')==null||$this->session->userdata('id')!=$data['folder']['user_id']){  
			$data['follow'] = null;
			$data['watch'] = null;
			if ($this->session->userdata('id')!=null){
				$this->load->model('user_follow_model');
				$this->load->model('user_watch_model');
	   			$data['follow'] = $this->user_follow_model->loadByUserAndFav($data['folder']['user_id'],$this->session->userdata('id'));
	   			$data['watch'] = $this->user_watch_model->loadByUserAndWatch($this->session->userdata('id'),$id,1);
	   		}
	   		$this->user_folder_model->view_num = $data['folder']['view_num']+1;
	        $this->user_folder_model->updateViewNum($id);
	        /*
	   		$data['public_folder_list'] = $this->user_folder_model->find_user_folders(array('rand'=>1,'is_private'=>0),4);
	   		$data['user_list'] = $this->user_model->find_users(array('rand'=>1,'active'=>1), 4, 0);
	   		*/
        	$data['title'] = $data['folder']['folder_name'].' '.$data['type_name'];
			$data['nav']= 'explore';
			$data['user']= $this->user_model->load($data['folder']['user_id']);
			$data['user_folder_list'] = $this->user_folder_model->find_user_folders(array('rand'=>1,'user_id'=>$this->session->userdata('id'),'type'=>$data['folder']['type'],'is_private'=>0),100);
	   		
			$this->load->view('item/item_folder',$data);
		}else{
			$data['total_size'] = $this->item_model->get_sum_filesize($userid);
			$data['space'] = $user['space'];
			$data['percent'] = ($data['total_size']/$data['space'])*100;
			$this->load->view('file/user_file',$data);
		}
		
	}
	
	public function createFolder($type)
	{
        $data = array();
        if (!$this->session->userdata('id')){         		
			redirect('login');
			exit();
		}
		$this->load->model('user_folder_model');
		$userid =$this->session->userdata('id');
		$dir = $_GET['folder_name'];
		if($userid!=null&&$userid!=0&&trim($dir)!=''){
			$this->load->model('item_type_model');
			$typeobj = $this->item_type_model->load($type);
			$type_name = $typeobj['name'];
			DiskPath($userid,$type_name);
			$type_folder = $this->user_folder_model->loadbyname($userid,$type_name,0);
			if(!$type_folder){
				$this->user_folder_model->user_id = $userid;
				$this->user_folder_model->folder_name = $type_name;
				$this->user_folder_model->is_private =  1;
				$this->user_folder_model->parent_folder =  0;
				$this->user_folder_model->type = $type;
				$this->user_folder_model->real_path = $userid.'/'.$type_name;
				$this->user_folder_model->create();
				$parent_folder = $this->db->insert_id();
			}else{
				$parent_folder = $type_folder['id'];
			}
			$parent_folder_id = $_GET['folder_id'];
			$this->user_folder_model->is_private = 1;
			if($parent_folder_id!=0){
				$parent_folder = $parent_folder_id;
				$parent = $this->user_folder_model->load($parent_folder);
				$this->user_folder_model->is_private = $parent['is_private'];
				$parent_path = $parent['real_path'];
				//$dir = iconv("UTF-8","gb2312", $dir);
				//$parent_path = iconv("UTF-8","gb2312", $parent_path);
				$targetPath = DiskParentPath($dir,$parent_path);
				//$dir = iconv("gb2312","UTF-8", $dir);
			}else{
				//$dir = iconv("UTF-8","gb2312", $dir);
				$targetPath = DiskPath($userid,$dir,$type_name);
				//$dir = iconv("gb2312","UTF-8", $dir);
			}
			
			$folder = $this->user_folder_model->loadbyname($userid,$dir,$parent_folder);
			if(!$folder){
				$this->user_folder_model->user_id = $userid;
				$this->user_folder_model->folder_name = $dir;
				$this->user_folder_model->type = $type;
				if($parent_folder_id!=0){
					$this->user_folder_model->real_path = $parent['real_path'].'/'.$dir;
				}else{
					$this->user_folder_model->real_path = $userid.'/'.$type_name.'/'.$dir;
				}
				$this->user_folder_model->parent_folder =  $parent_folder;
				$this->user_folder_model->create();
				$folder_id = $this->db->insert_id();
			}else{
				$folder_id = $folder['id'];
			}
			echo 1;
		}else{
			echo 0;
		}
	}
	
	public function editFolder($folderid)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->model('user_folder_model');
        $data = array();
        if($folderid!=null&&$folderid!=0){
        	$data['folder'] = $this->user_folder_model->load($folderid);
        }
        if ($this->session->userdata('id')!=$data['folder']['user_id']){         		
			redirect('home');
			exit();
		}
		if($folderid!=null&&$folderid!=0){
			$this->user_folder_model->folder_name = $_GET['folder_name'];
		    $this->user_folder_model->update($folderid);
			echo 1;
		}else{
			echo 0;
		}
	}
	
	public function deleteFolder($folderid)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->model('user_folder_model');
        $data = array();
        if($folderid!=null&&$folderid!=0){
        	$data['folder'] = $this->user_folder_model->load($folderid);
        }
        if ($this->session->userdata('id')!=$data['folder']['user_id']){         		
			redirect('home');
			exit();
		}
		if($folderid!=null&&$folderid!=0){
		    $this->user_folder_model->delete($folderid);
		    //$realpath = rtrim($_SERVER['DOCUMENT_ROOT'],'/') . '/effecthub/disk/'.$data['folder']['real_path'];
		    $realpath = rtrim($_SERVER['DOCUMENT_ROOT'],'/') . '/disk/'.$data['folder']['real_path'];
		    if(file_exists($realpath)){
			   unlink($realpath);
			 }
			echo 1;
		}else{
			echo 0;
		}
	}
	
	public function shareFolder($folderid)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->model('user_folder_model');
        $data = array();
        if($folderid!=null&&$folderid!=0){
        	$data['folder'] = $this->user_folder_model->load($folderid);
        }
        if ($this->session->userdata('id')!=$data['folder']['user_id']){         		
			redirect('home');
			exit();
		}
		if($folderid!=null&&$folderid!=0){
			$this->user_folder_model->is_private = 0;
			$this->user_folder_model->password = $_GET['password'];;
		    $this->user_folder_model->updatePrivate($folderid);
		    
			$user_id = $this->session->userdata('id');
			
		    $this->load->model('user_status_model');	
	        $this->user_status_model->user_id = $user_id;
	        $this->user_status_model->target_id = $data['folder']['id'];
	        $this->user_status_model->target_name = $data['folder']['folder_name'];
	        $this->user_status_model->status_type = 12;
	        
	        //$this->user_status_model->action = "shared a folder";
	    	//$this->user_status_model->target_url = site_url('folder/'.$data['folder']['id']);
			//$this->user_status_model->target_name = $data['folder']['folder_name'];
			$this->user_status_model->insertData();
			
			$this->load->model('item_model');
			$item_list = $this->item_model->find_items(array('folder_id'=>$folderid,'order'=>'update_date','download'=>1,'user'=>$user_id));
			
			$count = 0;
			foreach($item_list as $item){
				if($item['is_private']==1){
					$count = $count + 1;
					$this->item_model->is_private = 0;
					$this->item_model->password = $_GET['password'];;
				    $this->item_model->updatePrivate($item['id']);
				}
			}
			
			$teamstr = $_GET['team'];
		    if($teamstr!=''){
			    $teamlist = array();
			    $tok = strtok($teamstr,","); 
				while($tok !== false){
					if($tok!='')
					array_push($teamlist,$tok);
					$tok = strtok(" ,"); 
				}
				
				$this->load->model('team_share_model');
				$this->load->model('team_model');
				foreach ($teamlist as $teamid) {
					$this->team_share_model->user_id = $this->session->userdata('id');
					$this->team_share_model->item_id = 0;
					$this->team_share_model->folder_id = $folderid;
					$this->team_share_model->team_id = $teamid;
					$this->team_share_model->create();
					
					$team = $this->team_model->load($teamid);
					$this->team_model->work_num = $team['work_num'] + 1;
					$this->team_model->update_work_num($teamid);
				}
		    }
		    /*
			$this->load->model('user_model');
			$user = $this->user_model->load($user_id);
			$user_point = $user['point'] + 10*$count;
			$this->user_model->update_point($user_id,$user_point);
			*/
			echo 1;
		}else{
			echo 0;
		}
	}
	
	public function unshareFolder($folderid)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->model('user_folder_model');
        $data = array();
        if($folderid!=null&&$folderid!=0){
        	$data['folder'] = $this->user_folder_model->load($folderid);
        }
        if ($this->session->userdata('id')!=$data['folder']['user_id']){         		
			redirect('home');
			exit();
		}
		if($folderid!=null&&$folderid!=0){
			$this->user_folder_model->is_private = 1;
			$this->user_folder_model->password = $_GET['password'];
		    $this->user_folder_model->updatePrivate($folderid);
		    
			$user_id = $this->session->userdata('id');
			
		    $this->load->model('item_model');
			$item_list = $this->item_model->find_items(array('folder_id'=>$folderid,'order'=>'update_date','download'=>1,'user'=>$user_id));
			
			$count = 0;
			foreach($item_list as $item){
				if($item['is_private']==0){
					$count = $count + 1;
					$this->item_model->is_private = 1;
					$this->item_model->password = $_GET['password'];;
				    $this->item_model->updatePrivate($item['id']);
				}
			}
			/*
			$this->load->model('user_model');
			$user = $this->user_model->load($user_id);
			$user_point = $user['point'] - 10*$count;
			$this->user_model->update_point($user_id,$user_point);
			*/
			echo 1;
		}else{
			echo 0;
		}
	}
	
	function watch($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->model('user_watch_model');
		
        $this->user_watch_model->user_id = $this->session->userdata('id');
    	$this->user_watch_model->item_id = $id;
    	$this->user_watch_model->is_folder = 1;
		$this->user_watch_model->create();
		
			
		$this->load->model('user_folder_model');
	    $item = $this->user_folder_model->load($id);
	    
	    $this->load->model('user_status_model');	
        $this->user_status_model->user_id = $this->session->userdata('id');
        $this->user_status_model->target_id = $id;
        $this->user_status_model->target_name = $item['folder_name'];
        $this->user_status_model->status_type = 17;
        
        //$this->user_status_model->action = "watched a folder";
    	//$this->user_status_model->target_url = site_url('folder/'.$id);
		//$this->user_status_model->target_name = $item['folder_name'];
		$this->user_status_model->insertData();
		
		$this->load->model('user_notice_model');	
		if($item['user_id']!=$this->session->userdata('id')){
	        $this->user_notice_model->user_id = $item['user_id'];
	    	$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> watched your folder <a href='".site_url('folder/'.$id)."'>".$item['folder_name']."</a>";
			$this->user_notice_model->insertData();
		}
	
	    $this->user_folder_model->watch_num = $item['watch_num'] + 1;
	    $this->user_folder_model->updateWatchNum($id);
		echo $this->lang->line('file_unwatch');
	}
	
	function unwatch($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->model('user_watch_model');
		$this->user_watch_model->delete($this->session->userdata('id'),$id,1);
		$this->load->model('user_folder_model');
	    $item = $this->user_folder_model->load($id);
	    $this->user_folder_model->watch_num = $item['watch_num'] - 1;
	    $this->user_folder_model->updateWatchNum($id);
		echo $this->lang->line('file_watch');
	}
	
	public function complete($folderid)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->model('user_folder_model');
        $data = array();
        if($folderid!=null&&$folderid!=0){
        	$data['folder'] = $this->user_folder_model->load($folderid);
        }
        if ($this->session->userdata('id')!=$data['folder']['user_id']){         		
			redirect('home');
			exit();
		}
		if($folderid!=null&&$folderid!=0){
			$this->load->model('item_history_model');	
	        $this->item_history_model->item_id = $folderid;
	        $this->item_history_model->is_folder = 1;
	        $this->item_history_model->action = "upload";
	        if($_GET['count']>1)
	        $content = ' '.$_GET['count'].' files to '.$data['folder']['folder_name'];
	        else $content = ' '.$_GET['count'].' file to '.$data['folder']['folder_name'];
			if($content!=''){
				$this->item_history_model->content = $content;
				$this->item_history_model->insertData();
			}
			
			$this->load->model('user_status_model');	
	        $this->user_status_model->user_id = $this->session->userdata('id');
	        $this->user_status_model->target_id = $data['folder']['id'];
	        $this->user_status_model->target_name = $data['folder']['folder_name'];
	        $this->user_status_model->status_type = 14;
	        
	        //$this->user_status_model->action = 'upload files to';
	    	//$this->user_status_model->target_url = site_url('folder/'.$data['folder']['id']);
			//$this->user_status_model->target_name = $data['folder']['folder_name'];
			$this->user_status_model->insertData();
		}
	}
	
	public function download($folderid)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->library('zip');
		$this->load->model('user_folder_model');
		$folder = $this->user_folder_model->load($folderid);
		if($folder==null){
   			redirect('item/none');
			exit();
   		}
    	if($folder['is_private']==1&&($this->session->userdata('id')!=$folder['user_id'])){
   			redirect('item/forbidden');
			exit();
   		}
		$this->load->model('item_model');
		if ($this->session->userdata('id')!=$folder['user_id']){
			$data['item_count'] = $this->item_model->count_items(array('is_private'=>0,'folder_id'=>$folderid,'order'=>'update_date','download'=>1));
			$data['item_list'] = $this->item_model->find_items(array('is_private'=>0,'folder_id'=>$folderid,'order'=>'update_date','download'=>1),$data['item_count']);
			$coins = 0;
			$user_id = $this->session->userdata('id');
			$this->load->model('user_model');
			$user = $this->user_model->load($user_id);
			$author = $this->user_model->load($folder['user_id']);
			$item_list = array();
			$this->load->model('item_download_model');
			foreach($data['item_list'] as $item){
				$download = $this->item_download_model->loadByUserAndDownload($this->session->userdata('id'),$item['id']);
				if(!$download){
					$coins += $item['price'];
					$item['is_download']=0;
				}else{
					$item['is_download']=1;
				}
				array_push($item_list,$item);
			}
			if($user['point']>=$coins){
				$user_point = $user['point'] - $coins;
				$this->user_model->update_point($user_id,$user_point);
				$author_point = $author['point'] + $coins;
				$this->user_model->update_point($item['author_id'],$author_point);
				foreach($item_list as $item){
					if($item['is_download']==0){
				        $this->item_download_model->user_id = $this->session->userdata('id');
				    	$this->item_download_model->item_id = $item['id'];
						$this->item_download_model->create();
						
						$this->load->model('item_model');
					    $item = $this->item_model->load($item['id']);
					    $this->item_model->download_num = $item['download_num'] + 1;
					    $this->item_model->updateDownloadNum($item['id']);
					}
				}
				$targetPath = rtrim($_SERVER['DOCUMENT_ROOT'],'/') . '/disk/'.$folder['real_path'].'/';
				//$targetPath = iconv("UTF-8","gb2312", $targetPath);
				$this->zip->read_dir($targetPath, FALSE); 
				//echo $folder['folder_name'];
				$this->zip->download($folder['folder_name'].'.zip');
			}else{
				echo "<script>alert('No enough coins. You can share game assets to earn coins:)');</script>";
				redirect('folder/'.$folderid);
				exit();
			}
		}else{
			//$targetPath = rtrim($_SERVER['DOCUMENT_ROOT'],'/') . '/effecthub/disk/'.$folder['real_path'].'/';
			$targetPath = rtrim($_SERVER['DOCUMENT_ROOT'],'/') . '/disk/'.$folder['real_path'].'/';
			//$targetPath = iconv("UTF-8","gb2312", $targetPath);
			$this->zip->read_dir($targetPath, FALSE); 
			//echo $folder['folder_name'];
			$this->zip->download($folder['folder_name'].'.zip');
		}
	}
	
	public function explore($option,$type='all')
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
        if ($lang==2)
        {
        	$this->lang->load('header','chinese');
        	$this->lang->load('footer','chinese');
        	$this->lang->load('item','chinese');
        	$this->lang->load('user','chinese');
        	$this->lang->load('pop','chinese');
        	$this->lang->load('file','chinese');
        	$this->lang->load('other','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('item','english');
        	$this->lang->load('user','english');
        	$this->lang->load('pop','english');
        	$this->lang->load('file','english');
        	$this->lang->load('other','english');
        }
        $data['lang']= $lang;
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1,'order'=>'order'));
		
	    
		$this->load->model('user_folder_model','folder');
		if($type!='all')
		$count = $this->folder->count_user_folders(array('type'=>$type));
		else
		$count = $this->folder->count_user_folders(array());
		$this->load->library('pagination');		//加载分页类
		$config['base_url'] = base_url().'folder/explore/'.$option.'/'.$type;		//设置分页的url路径
		$config['total_rows'] = $count;		//得到数据库中的记录的总条数
		$config['uri_segment'] = 5;
		$config['per_page'] = '12';//每页记录数
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$this->pagination->initialize($config);//分页的初始化
		
		if($type!='all')
		$folder_list = $this->folder->find_user_folders(array('type'=>$type,'order'=>$option),$config['per_page'],$this->uri->segment(5));
		else
		$folder_list = $this->folder->find_user_folders(array('order'=>$option),$config['per_page'],$this->uri->segment(5));
		$data['folder_list'] = array();
		$data['type'] = $type;
		$data['option'] = $option;
		
		$this->load->model('item_model','item');
		foreach ($folder_list as $list){
			$data['folder_items'][$list['id']] = $this->item->find_items(array('folder_id'=>$list['id'],'order'=>'update_date'),2,0);
			$list['works_num'] = $this->item->count_items(array('folder_id'=>$list['id'],'order'=>'update_date'));
			array_push($data['folder_list'],$list);
		}
		
		//collections order by update-date
		$new_folder = $this->folder->find_user_folders(array('is_private'=>'0','order'=>'update_date','works_num'=>'yes'),10,0);
		$data['new_folder'] = array();
		foreach ($new_folder as $list){
			$list['works_num'] = $this->item->count_items(array('is_private'=>'0','folder_id'=>$list['id'],'order'=>'update_date'));
			array_push($data['new_folder'],$list);
		}
		
		$data['nav']= 'explore';
		$data['feature']= 'folder';
		
		$this->load->view('file/folder_explore',$data);
		
	}
}
