<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Disk extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('time');
		$this->load->helper('my_form');
		$this->load->helper('cookie');
		$this->load->library('encrypt');
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
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
    
    public function extractFile($id=0)
    {
    	/*
    	$this->load->model('item_model');
    	//if($id!=0){
    	$this->load->helper('my_form');
    	$data['item_list'] = $this->item_model->find_items(array('from'=>'particle','order'=>'id','download'=>1),1000);
    	foreach($data['item_list'] as $item): 
			$guid = create_guid();
			UploadPath('extract',$guid);
    		//$item = $this->item_model->load($id);
    		$realpath = str_replace("http://www.effecthub.com",$_SERVER['DOCUMENT_ROOT'],$item['download_url']);
			$realpath = str_replace('\\', '/', $realpath);
			//$size = filesize($realpath);
			//$realpath = 'C:\Users\xirao\Downloads\44FB5405-77AF-6F25-D53E-22BFC72CA16C.zip';
			//$folder_path = str_replace('.zip','',$realpath);
			//echo $folder_path;
			//$this->load->library('unzip');
			//$unzip = $this->unzip->extract($realpath,$folder_path);
			$extract_path = $_SERVER['DOCUMENT_ROOT'].'/uploads/extract/'.$guid;
			$zipresult = exec('unzip -d '.$extract_path.' '.$realpath);
			//echo $zipresult;
			$this->load->helper('file');
			$folder_files = get_dir_file_info($extract_path);
			//print_r($folder_files);
			
			foreach($folder_files as $file): 
				$targetFile = $file['server_path'];
				$item_download_url = base_url() . 'uploads/extract/'.$guid.'/'. $file['name'];
				$item_extension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
				$fileTypes = array('jpg','jpeg','gif','png','JPG','PNG','GIF','JPEG');
				$textureTypes = array('jpg','png','atf','dds','bmp','jpeg','gif');
				$modelTypes = array('awd','obj','3ds','md2','dae','md5mesh','md5anim');
				
				$this->load->model('item_model');
				if(!$this->item_model->loadbydownloadurl($item_download_url)){
					$this->item_model->pic_url = '';
					$this->item_model->thumb_url = '';
					$this->item_model->author_id = $item['author_id'];
					$this->item_model->title = $file['name'];
					$this->item_model->desc =  $file['name'];
					$this->item_model->file_name = $file['name'];
					$this->item_model->work_id = $item['id'];
					$this->item_model->folder_id = 0;
					$this->item_model->price = $item['price'];
					$this->item_model->share = 0;
					$this->item_model->platform = 0;
					if(in_array($item_extension,$textureTypes)){
						$this->item_model->pic_url = $item_download_url;
						$this->item_model->thumb_url = $item_download_url;
						$this->item_model->type = 3;
					}else if(in_array($item_extension,$modelTypes)){
						$this->item_model->type = 2;
					}else if($item_extension=='amf'){
						$this->item_model->type = 9;
						$this->item_model->platform = 1;
					}else if($item_extension=='awp'){
						$this->item_model->type = 1;
						$this->item_model->platform = 1;
					}else{
						$this->item_model->type = 13;
					}
					if($item_extension=='awd'){
						$this->item_model->platform = 1;
					}
					$this->item_model->extension = $item_extension;
					$this->item_model->download_url = $item_download_url;
					$this->item_model->contest_id = 0;
					$this->item_model->create_date = $item['update_date'];
					$this->item_model->file_size = $file['size'];
					$this->item_model->is_private = $item['is_private'];
			        $this->item_model->create();
					$item_id = $this->db->insert_id();
					echo 'create item '.$file['name'].' successfully'.'<br/>';
				}
			endforeach; 
			echo 'finish work '.$item['id'].' successfully'.'<br/>'.'<br/>';
		endforeach;	
    	//}else{
    		
    	//}
    	 * 
    	 */
    }
    
    public function updateFileSize()
    {
    	$this->load->model('item_model');
		$item_list = $this->item_model->find_items(array(), 1000, 0);
		foreach($item_list as $item): 
			if($item['download_url']!=''&&$item['download_url']!=null){
				$realpath = str_replace("http://www.effecthub.com",$_SERVER['DOCUMENT_ROOT'],$item['download_url']);
				$realpath = str_replace('\\', '/', $realpath);
				$size = filesize($realpath);
				echo 'size of '.$item['id'].': '.$size.'<br/>';
				$this->item_model->size = $size;
		        $this->item_model->updateFileSize($item['id']);
		        echo 'updated '.$item['id'].'<br/>';
			}
		endforeach; 
    }
	
	public function index($type='all')
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
        if ($lang==2)
        {
        	$this->lang->load('header','chinese');
        	$this->lang->load('footer','chinese');
        	$this->lang->load('user','chinese');
        	$this->lang->load('file','chinese');
        	$this->lang->load('pop','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('user','english');
        	$this->lang->load('file','english');
        	$this->lang->load('pop','english');
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
        }
        
		$this->load->model('user_model');
		$userid =$this->session->userdata('id');
		$this->load->model('user_notice_model');
		$notice_count = $this->user_notice_model->find_unread_count($userid);
		$this->session->set_userdata('notice_count',$notice_count);
		$this->load->model('user_mail_model');
		$mail_count =$this->user_mail_model->find_unread_count($userid);
		$this->session->set_userdata('mail_count',$mail_count);
    	$user = $this->user_model->load($userid);
    	$this->session->set_userdata('point',$user['point']);
    	
    	$data['user']= $user;
    	$data['nav']= 'works';
    	$data['feature']= 'assets';
    	    
        $this->load->model('country_model');
		$country = $this->country_model->load($data['user']['countryCode']);
		$data['country_name'] = $country['full_name'];
		$this->load->model('item_type_model');
        $data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1,'order'=>'order','fileable'=>1));
		$data['type'] = $type;
		$typeobj = $this->item_type_model->load($type);
		if($type!='all') {
			if ($data['lang'] == 2) $data['type_name'] = $typeobj['name_cn'];
			else $data['type_name'] = $typeobj['name'];
		} else $data['type_name'] = $this->lang->line('file_all_files');
        $this->load->model('item_model');
        if($type!='all'){
        	$data['item_list'] = $this->item_model->find_items(array('type'=>$type,'folder_id'=>0,'order'=>'update_date','download'=>1,'user'=>$userid));
			$this->load->model('user_folder_model');
			$type_folder = $this->user_folder_model->loadbyname($userid,$typeobj['name'],0);
			if($type_folder){
				$data['type_item_list'] = $this->item_model->find_items(array('type'=>$type,'folder_id'=>$type_folder['id'],'order'=>'update_date','download'=>1,'user'=>$userid),100);
				$data['folder_list'] = $this->user_folder_model->find_user_folders(array('parent_folder'=>$type_folder['id']),100);
				$data['item_list'] = array_merge($data['type_item_list'],$data['item_list']);
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
        }else{
        	$this->load->model('user_status_model');
        	if($user['follow_num']>1){
					$data['status_list'] = $this->user_status_model->find_status_by_myfollow_offset($userid,10,0);
			}else{
					$data['status_list'] = $this->user_status_model->find_status_offset(10,0);
			}
        }
		$data['total_size'] = $this->item_model->get_sum_filesize($userid);
		$data['space'] = $user['space'];
		$data['percent'] = ($data['total_size']/$data['space'])*100;
		
		$this->load->model('team_member_model','t_member');
		$data['team_list'] = $this->t_member->load_user_teams($this->session->userdata('id'));
		
		
		$this->load->view('file/user_file',$data);
	}
	
	public function uploadFile()
	{
		$this->load->helper('my_form');
		$dir = $_POST['type_name'];
		$type_id = $_POST['type'];
		$folder_id = $_POST['folder'];
		$userid =$this->session->userdata('id');
		$this->load->model('user_folder_model');
		if($folder_id==0){
			$targetPath = DiskPath($userid,$dir);
			$folder = $this->user_folder_model->loadbyname($userid,$dir,0);
			if(!$folder){
				$this->user_folder_model->user_id = $userid;
				$this->user_folder_model->folder_name = $dir;
				$this->user_folder_model->parent_folder =  0;
				$this->user_folder_model->type = $type_id;
				$this->user_folder_model->real_path = $userid.'/'.$dir;
				$this->user_folder_model->create();
				$folder_id = $this->db->insert_id();
			}else{
				$folder_id = $folder['id'];
			}
		}
		$folder = $this->user_folder_model->load($folder_id);
		//$targetPath = rtrim($_SERVER['DOCUMENT_ROOT'],'/') . '/effecthub/disk/'.$folder['real_path'];
		$targetPath = rtrim($_SERVER['DOCUMENT_ROOT'],'/') . '/disk/'.$folder['real_path'];
		$item_type = $_POST['type'];
		$verifyToken = md5('unique_salt' . $_POST['timestamp']);
		if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$item_name = $_FILES['Filedata']['name'];
			//$item_name = iconv("UTF-8","gb2312", $_FILES['Filedata']['name']);
			//$targetPath = iconv("UTF-8","gb2312", $targetPath);
			$targetFile = rtrim($targetPath,'/') . '/' . $item_name;
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			move_uploaded_file($tempFile,$targetFile);
			//$targetPath = iconv("gb2312","UTF-8", $targetPath);
			//$item_name = iconv("gb2312","UTF-8", $item_name);
			$item_download_url = base_url() . 'disk/'.$folder['real_path'].'/'. $item_name;
			$item_extension = $fileParts['extension'];
			$file_size = filesize($targetFile);
			$fileTypes = array('jpg','jpeg','gif','png','JPG','PNG','GIF','JPEG');
			
			$this->load->model('item_model');
			if(!$this->item_model->loadbydownloadurl($item_download_url)){
				$this->item_model->author_id = $userid;
				$this->item_model->title = $item_name;
				$this->item_model->desc =  $item_name;
				$this->item_model->file_name = $item_name;
				$this->item_model->folder_id = $folder_id;
				$this->item_model->price_type = 1;
				$this->item_model->price = 0;
				$this->item_model->share = 0;
				$this->item_model->platform = 0;
				$this->item_model->type = $item_type;
				$this->item_model->extension = $item_extension;
				$this->item_model->download_url = $item_download_url;
				$this->item_model->contest_id = 0;
				$this->item_model->file_size = $file_size;
				$this->item_model->is_private = $folder['is_private'];
		        $this->item_model->create();
				$id = $this->db->insert_id();
				if($item_extension=='bmp'||$item_extension=='BMP'){
					$this->item_model->pic_url = $item_download_url;
					$this->item_model->thumb_url = $item_download_url;
					$this->item_model->updateNew($id);
				}
				if(in_array($item_extension,$fileTypes)){
		    		$config['image_library'] = 'gd2';
					$config['source_image'] = $targetFile;
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 400;
					$config['height'] = 320;
					
					$this->load->library('image_lib', $config); 
					
					$this->image_lib->resize();
					
		    		$targetFile = str_replace('.'.$item_extension,'',$targetFile);
		    		$currentThumbFile = $targetFile.'_thumb.'.$item_extension;
		    		//echo $currentThumbFile.' ';
		    		//$targetThumbFile = rtrim($_SERVER['DOCUMENT_ROOT'],'/') . '/effecthub/uploads/item/' . $id.'_thumb.'.$item_extension;
		    		$targetThumbFile = rtrim($_SERVER['DOCUMENT_ROOT'],'/') . '/uploads/item/' . $id.'_thumb.'.$item_extension;
		    		//echo $targetThumbFile.' ';
		    		rename($currentThumbFile,$targetThumbFile);
		    		$this->item_model->thumb_url = base_url().'uploads/item/'.$id.'_thumb.'.$item_extension;
		    		$this->item_model->pic_url = $this->item_model->thumb_url;
		    		$this->item_model->updateNew($id);
		    	}
				echo json_encode($this->item_model->load($id));
			}
		}
	}
	
	public function getMyAssets($type)
	{
		$userid =$this->session->userdata('id');
		$count = $_POST['count'];
		$this->load->model('item_model');
		echo json_encode($this->item_model->find_items(array('user'=>$userid,'order'=>'id','type'=>$type),$count));
	}
	
	public function uploadShareFile()
	{
		$this->load->helper('my_form');
		$this->load->model('item_model');
		$verifyToken = md5('unique_salt' . $_POST['timestamp']);
		if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$item_name = $_FILES['Filedata']['name'];
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			$item_extension = strtolower($fileParts['extension']);
			$fileTypes = array('jpg','jpeg','gif','png','JPG','PNG','GIF','JPEG');
			$textureTypes = array('jpg','png','atf','dds','bmp','jpeg','gif');
			$modelTypes = array('awd','obj','3ds','md2','dae','md5mesh','md5anim');
			$audioTypes = array('mp3','ogg','wav','mid','wma','ape','aiff','aac','eaac');
			$videoTypes = array('mp4','avi','rmvb','mov','mpeg','flv','wmv');
			$animationTypes = array('swf','fla','gif','u3d');
			$drawTypes = array('psd','ai','eps','tga','cdr','rif');
			$gameTypes = array('apk','ipa','exe','dmg','unity3d');
			
			if(in_array($item_extension,$textureTypes)){
				$item_type = 3;
				$item_type_name = 'Texture';
			}else if(in_array($item_extension,$modelTypes)){
				$item_type = 2;
				$item_type_name = 'Model';
			}else if(in_array($item_extension,$audioTypes)){
				$item_type = 8;
				$item_type_name = 'Audio';
			}else if(in_array($item_extension,$videoTypes)){
				$item_type = 5;
				$item_type_name = 'Video';
			}else if(in_array($item_extension,$animationTypes)){
				$item_type = 6;
				$item_type_name = 'Animation';
			}else if(in_array($item_extension,$drawTypes)){
				$item_type = 7;
				$item_type_name = 'ConceptArt';
			}else if(in_array($item_extension,$gameTypes)){
				$item_type = 12;
				$item_type_name = 'Game';
			}else{
				$item_type = 13;
				$item_type_name = 'Other';
			}
			
			$dir = $item_type_name;
			$type_id = $item_type;
			$folder_id = 0;
			$userid =$this->session->userdata('id');
			$this->load->model('user_folder_model');
			if($folder_id==0){
				$targetPath = DiskPath($userid,$dir);
				$folder = $this->user_folder_model->loadbyname($userid,$dir,0);
				if(!$folder){
					$this->user_folder_model->user_id = $userid;
					$this->user_folder_model->folder_name = $dir;
					$this->user_folder_model->parent_folder =  0;
					$this->user_folder_model->type = $type_id;
					$this->user_folder_model->real_path = $userid.'/'.$dir;
					$this->user_folder_model->create();
					$folder_id = $this->db->insert_id();
				}else{
					$folder_id = $folder['id'];
				}
			}
			$folder = $this->user_folder_model->load($folder_id);
			
			//$targetPath = rtrim($_SERVER['DOCUMENT_ROOT'],'/') . '/effecthub/disk/'.$folder['real_path'];
			$targetPath = rtrim($_SERVER['DOCUMENT_ROOT'],'/') . '/disk/'.$folder['real_path'];
		
			$targetFile = rtrim($targetPath,'/') . '/' . $item_name;
			move_uploaded_file($tempFile,$targetFile);
			
			$item_download_url = base_url() . 'disk/'.$folder['real_path'].'/'. $item_name;
			$file_size = filesize($targetFile);
			
			if(!$this->item_model->loadbydownloadurl($item_download_url)){
				$this->item_model->author_id = $userid;
				$this->item_model->title = $item_name;
				$this->item_model->desc =  $item_name;
				$this->item_model->file_name = $item_name;
				$this->item_model->folder_id = $folder_id;
				$this->item_model->price = 0;
				$this->item_model->price_type = 1;
				$this->item_model->share = 0;
				$this->item_model->platform = 0;
				$this->item_model->type = $item_type;
				$this->item_model->extension = $item_extension;
				$this->item_model->download_url = $item_download_url;
				$this->item_model->contest_id = 0;
				$this->item_model->file_size = $file_size;
				$this->item_model->is_private = 1;
		        $this->item_model->create();
				$id = $this->db->insert_id();
				if($item_extension=='bmp'||$item_extension=='BMP'){
					$this->item_model->pic_url = $item_download_url;
					$this->item_model->thumb_url = $item_download_url;
					$this->item_model->updateNew($id);
				}
				if(in_array($item_extension,$fileTypes)){
		    		$config['image_library'] = 'gd2';
					$config['source_image'] = $targetFile;
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 400;
					$config['height'] = 320;
					
					$this->load->library('image_lib', $config); 
					
					$this->image_lib->resize();
					
		    		$targetFile = str_replace('.'.$item_extension,'',$targetFile);
		    		$currentThumbFile = $targetFile.'_thumb.'.$item_extension;
		    		//echo $currentThumbFile.' ';
		    		//$targetThumbFile = rtrim($_SERVER['DOCUMENT_ROOT'],'/') . '/effecthub/uploads/item/' . $id.'_thumb.'.$item_extension;
		    		$targetThumbFile = rtrim($_SERVER['DOCUMENT_ROOT'],'/') . '/uploads/item/' . $id.'_thumb.'.$item_extension;
		    		//echo $targetThumbFile.' ';
		    		rename($currentThumbFile,$targetThumbFile);
		    		$this->item_model->thumb_url = base_url().'uploads/item/'.$id.'_thumb.'.$item_extension;
		    		$this->item_model->pic_url = $this->item_model->thumb_url;
		    		$this->item_model->updateNew($id);
		    	}
				echo json_encode($this->item_model->load($id));
			}else{
				echo json_encode($this->item_model->loadbydownloadurl($item_download_url));
			}
		}
	}
	
	public function recycleFile($itemid)
	{
		$this->load->model('item_model');
        $data = array();
        if($itemid!=null&&$itemid!=0){
        	$data['item'] = $this->item_model->load($itemid);
        }
        if ($this->session->userdata('id')!=$data['item']['author_id']){         		
			redirect('home');
			exit();
		}
		if($itemid!=null&&$itemid!=0){
			$this->item_model->active = 0;
		    $this->item_model->updateActive($itemid);
		    echo 1;
		}else{
			echo 0;
		}
	}
	
	public function activeFile($itemid)
	{
		$this->load->model('item_model');
        $data = array();
        if($itemid!=null&&$itemid!=0){
        	$data['item'] = $this->item_model->load($itemid);
        }
        if ($this->session->userdata('id')!=$data['item']['author_id']){         		
			redirect('home');
			exit();
		}
		if($itemid!=null&&$itemid!=0){
			$this->item_model->active = 1;
		    $this->item_model->updateActive($itemid);
		    echo 1;
		}else{
			echo 0;
		}
	}
	
	public function deleteFile($itemid)
	{
		$this->load->model('item_model');
        $data = array();
        if($itemid!=null&&$itemid!=0){
        	$data['item'] = $this->item_model->load($itemid);
        }
        if ($this->session->userdata('id')!=$data['item']['author_id']){         		
			redirect('home');
			exit();
		}
		if($itemid!=null&&$itemid!=0){
		    $this->item_model->delete_item($itemid);
		    $realpath = str_replace("http://www.effecthub.com",$_SERVER['DOCUMENT_ROOT'],$data['item']['download_url']);
			$realpath = str_replace('/', '\\', $realpath);
		    if(file_exists($realpath)){
			   unlink($realpath);
			 }
			echo 1;
		}else{
			echo 0;
		}
	}
	
	public function shareFile($itemid)
	{
		$this->load->model('item_model');
        $data = array();
        if($itemid!=null&&$itemid!=0){
        	$data['item'] = $this->item_model->load($itemid);
        }
        if ($this->session->userdata('id')!=$data['item']['author_id']){         		
			redirect('home');
			exit();
		}
		if($itemid!=null&&$itemid!=0){
			$this->item_model->is_private = 0;
			$this->item_model->password = $_GET['password'];
		    $this->item_model->updatePrivate($itemid);
		    
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
				foreach ($teamlist as $teamid) {
					$this->team_share_model->user_id = $this->session->userdata('id');
					$this->team_share_model->item_id = $itemid;
					$this->team_share_model->folder_id = 0;
					$this->team_share_model->team_id = $teamid;
					$this->team_share_model->create();
				}
		    }
		    $this->load->model('user_status_model','u_status');
		    /*	
	        $this->user_status_model->user_id = $this->session->userdata('id');
	        $this->user_status_model->action = "shared a new work";
	    	if($data['item']['thumb_url']!=''&&$data['item']['thumb_url']!=null){
				$this->user_status_model->pic_url = $data['item']['thumb_url'];
	    	}
	    	$this->user_status_model->target_url = site_url('item/'.$data['item']['id']);
			$this->user_status_model->target_name = $data['item']['title'];
			*/
		    if($data['item']['thumb_url']!=''&&$data['item']['thumb_url']!=null){
		    	$this->u_status->pic_url = $data['item']['thumb_url'];
		    }
		    $this->u_status->target_name = $data['item']['title'];
		    $this->u_status->user_id = $this->session->userdata('id');
		    $this->u_status->status_type = 13;
		    $this->u_status->target_id = $data['item']['id'];
		    
			$this->u_status->insertData();
			/*
			$user_id = $this->session->userdata('id');
			$this->load->model('user_model');
			$user = $this->user_model->load($user_id);
			$user_point = $user['point'] + 10;
			$this->user_model->update_point($user_id,$user_point);
			*/
			echo 1;
		}else{
			echo 0;
		}
	}
	 
	public function unshareFile($itemid)
	{
		$this->load->model('item_model');
        $data = array();
        if($itemid!=null&&$itemid!=0){
        	$data['item'] = $this->item_model->load($itemid);
        }
        if ($this->session->userdata('id')!=$data['item']['author_id']){         		
			redirect('home');
			exit();
		}
		if($itemid!=null&&$itemid!=0){
			$this->item_model->is_private = 1;
			$this->item_model->password = $_GET['password'];;
		    $this->item_model->updatePrivate($itemid);
		    /*
		    $user_id = $this->session->userdata('id');
			$this->load->model('user_model');
			$user = $this->user_model->load($user_id);
			$user_point = $user['point'] - 10;
			$this->user_model->update_point($user_id,$user_point);
			*/
			echo 1;
		}else{
			echo 0;
		}
	}
}
