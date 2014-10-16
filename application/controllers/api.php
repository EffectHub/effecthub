<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class API extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('rest');
        $this->load->helper('time');
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
        	$this->lang->load('api','chinese');
        	$this->lang->load('footer','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('api','english');
        	$this->lang->load('footer','english');
        }
		$data = array();
		$this->load->view('api',$data);
	}
	
	public function test($id)
	{
		$private = $this->input->get('private');
		$this->load->model('item_model');
		$this->item_model->is_private = $private;
		$this->item_model->update($id);
		echo 1;
	}
	
	public function feedback()
	{
		header('Content-Type: application/json;');
		$this->load->model('feedback_model');
		if($this->input->post('email')){
			$this->feedback_model->name = $this->input->post('name');
			$this->feedback_model->email = $this->input->post('email');
			$this->feedback_model->comment = $this->input->post('comment');
			$this->feedback_model->subscribe = $this->input->post('subscribe');
			$this->feedback_model->donate = $this->input->post('donate');
			$this->feedback_model->attend = $this->input->post('attend');
			$this->feedback_model->tool = $this->input->post('tool');
			$this->feedback_model->from = $this->input->post('from');
			$this->feedback_model->create();
			$id = $this->db->insert_id();
			echo json_encode($id);
		}else{
			$msg = array('Result' => 'error');
			echo json_encode($msg);
		}
	}
	
	public function server($function,$parameter=0)
	{
		header('Content-Type: application/json;');
		if($function=='time'){
			//$datetime = date('Y-m-d H:i:s');
			$datetime = date('2013-8-31 24:59:59');
			echo json_encode($datetime);
		}else if($function=='about'){
			echo "<img src=\"http://www.effecthub.com/img/title.jpg\">
<br/><br/>Download Samples <font color=\"#ff0000\"><a href=\"http://www.effecthub.com/samples.zip\">here</a></font>.<br/><br/>
Welcome to give us feedback by email <font color=\"#ffff00\"><a href=\"mailto:effecthub.com@gmail.com\">effecthub.com@gmail.com</a></font><br/><br/>";
		}else if($function=='contest'){
			echo 0;
		}else if($function=='interval'){
			echo 15;
		}else if($function=='news'){
			echo 15;
		}
	}
	
	public function logs($function,$parameter=0)
	{
		header('Content-Type: application/json;');
		$msg = array('Result' => 'error');
		$this->load->model('log_model');
		if($function=='create'){
			if($this->input->post('userid')==0||$this->input->post('content')==''){
				echo json_encode($msg);
			}
			$this->log_model->user_id = $this->input->post('userid');
			$this->log_model->content = $this->input->post('content');
			$this->log_model->from = $this->input->post('from');
			$this->log_model->isguest = $this->input->post('isguest');
	        $this->log_model->create();
			$id = $this->db->insert_id();
			echo json_encode($id);
		}
	}		
	
	public function user($function,$parameter=0)
	{
		header('Content-Type: application/json;');
		$msg = array('Result' => 'error');
		$this->load->model('user_model');
		if($function=='load'){
			$user = $this->user_model->load($parameter);
			$user['token'] = '';
			$user['password'] = '';
			$user['email'] = '';
			echo json_encode($user);
		}else if($function=='loadlatesttoken'){
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			if($username==null){
				echo json_encode($msg);
				return;
			}
			$this->user_model->email = $username;
			$this->user_model->password = $password;
			$user = $this->user_model->check_user_api();
			if($user){
				echo $user['token'];
			}else{
				echo json_encode($msg);
				return;
			}
		}else if($function=='mail'){
			$this->load->model('user_mail_model');
			$token = $this->input->post('token');
			$user_id = $parameter;
			$user = $this->user_model->load($user_id);
			if($token==$user['token']){
				$mail_count =$this->user_mail_model->find_unread_count($user_id);
				if($mail_count>1){
					echo json_encode($this->user_mail_model->find_mail_offset($user_id,false,$mail_count,0));
				}else{
					echo json_encode($this->user_mail_model->find_mail_offset($user_id,false,5,0));
				}
			}else{
				echo json_encode($msg);
			}
		}else if($function=='notification'){
			$this->load->model('user_notice_model');
			$token = $this->input->post('token');
			$user_id = $parameter;
			$user = $this->user_model->load($user_id);
			if($token==$user['token']){
				$notice_count = $this->user_notice_model->find_unread_count($user_id);
				if($notice_count>1){
					echo json_encode($this->user_notice_model->find_notice($user_id,$notice_count));
				}else{
					echo json_encode($this->user_notice_model->find_notice($user_id,5));
				}
			}else{
				echo json_encode($msg);
			}
		}else if($function=='myfollow'){
			$this->load->model('user_status_model');
			$token = $this->input->post('token');
			$user_id = $parameter;
			$user = $this->user_model->load($user_id);
			if($token==$user['token']){
				if($user['follow_num']>1){
					echo json_encode($this->user_status_model->find_status_by_myfollow_offset($parameter,5,0));
				}else{
					echo json_encode($this->user_status_model->find_status_offset(5,0));
				}
			}else{
				echo json_encode($msg);
			}
		}else if($function=='login'){
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			if($username==null){
				echo json_encode($msg);
				return;
			}
			$this->user_model->email = $username;
			$this->user_model->password = $password;
			$user = $this->user_model->check_user_api();
			if($user){
				$this->user_model->update_last_login($user['id']);
				$token = create_guid();
				$this->user_model->updateToken($user['id'],$token);
				$user['token'] = $token;
				$user['password'] = '';
				//if($user['level']>=10){
					$user['is_saler'] = 1;
				//}else{
				//	$user['is_saler'] = 0;
				//}
				$this->load->model('user_social_model');
				$social_list = $this->user_social_model->loadByUser($user['id']);
				foreach($social_list as $social): 
					if( $social['type']=='twitter'){ 
						$user['token_twitter'] = $social['token'];
						$user['token_secret_twitter'] = $social['token_secret'];
					}
					if( $social['type']=='facebook'){ 
						$user['token_facebook'] = $social['token'];
					}
					if( $social['type']=='sina'){ 
						$user['token_sina'] = $social['token'];
					}	
					if( $social['type']=='google'){ 
						$user['token_google'] = $social['token'];
					}
					if( $social['type']=='behance'){ 
						$user['token_behance'] = $social['token'];
					}
				endforeach; 
				echo json_encode($user); 
			}else{
				echo json_encode($msg);
			}
		}else if($function=='register'){
			$this->load->model('user_model');
			$email = $this->input->post('email_address');
			if($email){
				$namelist = explode("@",$email);
				$name = $namelist[0];
				$displayName = $namelist[0];
			}
			$this->user_model->name = $name;
			$this->user_model->password = md5($this->input->post('password'));
			$this->user_model->email = $email;
			if(!$this->input->post('country')){
				$this->user_model->countryCode = 'US';
			}
			$this->user_model->consent = 'on';
			$this->user_model->from = $this->input->post('from');
			if(!$this->input->post('from')){
				$this->user_model->from = 'sparticle';
			}
			$this->user_model->displayName = $displayName;
			$this->user_model->client_id = '';
			if($this->user_model->check_email($email)){
				echo json_encode($msg);
			}else{
				$this->user_model->create();
				$id = $this->db->insert_id();
				$user = $this->user_model->load($id);
				$token = create_guid();
				$this->user_model->updateToken($user['id'],$token);
				$user['token'] = $token;
				echo json_encode($user); 
			}
		}else if($function=='registerbytool'){
			$client_id = $this->input->post('clientid');
			$from = $this->input->post('from');
			if($client_id==null||$from==null){
				echo json_encode($msg);
				return;
			}else{
				$this->user_model->name = $client_id;
				$this->user_model->displayName = $client_id;
				$this->user_model->client_id = $client_id;
				$this->user_model->pic_url='http://www.effecthub.com/images/blank.jpg';
				$this->user_model->password = create_password();
				$this->user_model->consent = 'on';
				$this->user_model->from = $from;
				$this->user_model->countryCode = 'US';
				$this->user_model->create();
				$id = $this->db->insert_id();
				$user = $this->user_model->load($id);
				$token = create_guid();
				$this->user_model->updateToken($user['id'],$token);
				$user['token'] = $token;
				echo json_encode($user); 
			}
		}else if($function=='loginbytool'){
			$client_id = $this->input->post('clientid');
			$password = $this->input->post('password');
			if($client_id==null||$password==null){
				echo json_encode($msg);
				return;
			}
			$this->user_model->client_id = $client_id;
			$this->user_model->password = $password;
			$user = $this->user_model->check_user_client_id();
			if($user){
				$this->user_model->update_last_login($user['id']);
				$token = create_guid();
				$this->user_model->updateToken($user['id'],$token);
				$user['token'] = $token;
				$user['password'] = '';
				$user['is_saler'] = 1;
				echo json_encode($user); 
			}else{
				echo json_encode($msg);
			}
		}else if($function=='updatebytool'){
			$userid = $this->input->post('userid');
			$password = $this->input->post('password');
			if($userid==null||$password==null){
				echo json_encode($msg);
				return;
			}
			$user = $this->user_model->load($userid);
			if($password==$user['password']){
				$email = $this->input->post('email_address');
				$new_password = md5($this->input->post('new_password'));
				$this->user_model->name = $this->input->post('name');
				$this->user_model->displayName = $this->input->post('displayName');
				$this->user_model->pic_url=$this->input->post('pic_url');
				$this->user_model->email = $email;
				$this->user_model->password = $new_password;
				$this->user_model->consent = 'on';
				$this->user_model->countryCode = 'US';
				$this->user_model->update($userid);
				$user = $this->user_model->load($userid);
				echo json_encode($user);
			}else{
				$msg = array('Result' => 'password not correct');
				echo json_encode($msg);
			}
		}else if($function=='popular'){
			echo json_encode($this->user_model->order_popular_author());
		}
	}
	
	public function item($function,$parameter=0,$parameter1='particle')
	{
		header('Content-Type: application/json;');
		$msg = array('Result' => 'error');
		$success = array('Result' => 'success');
		$this->load->model('user_model');
		$this->load->model('item_model');
		if($function=='load'){
			$user_id = $this->input->post('userid');
			if($user_id==0||$user_id==null||$user_id=='')$user_id = $this->session->userdata('id');
			if($user_id==0||$user_id==''||$user_id==null){
				//echo json_encode($msg);
				$item = $this->item_model->load($parameter);
				$item['download_url']='';
				$item['password']='';
				echo json_encode($item);
				return;
			}
			$token = $this->input->post('token');
			$user = $this->user_model->load($user_id);
			if($user==null){
				$item = $this->item_model->load($parameter);
				$item['download_url']='';
				$item['password']='';
				echo json_encode($item);
				return;
			}
			if($token!=$user['token']){
				$item = $this->item_model->load($parameter);
				$item['download_url']='';
				$item['password']='';
				echo json_encode($item);
				return;
			}
			$item = $this->item_model->load($parameter);
			$this->load->model('item_download_model');
			$download = $this->item_download_model->loadByUserAndDownload($user_id,$parameter);
			if(!$download&&$item['author_id']!=$user_id){
				$item['download_url']='';
				$item['password']='';
			}
			echo json_encode($item);
		}else if($function=='loadbytool'){
			if($parameter==null){
				echo json_encode($msg);
				return;
			}
			$extension = $this->input->get('extension');
			$count = $this->input->get('count');
			$offset = $this->input->get('offset');
			echo json_encode($this->item_model->find_items(array('tool'=>$parameter,'extension'=>$extension,'download'=>'1','api'=>'1'),$count,$offset));
		}else if($function=='loadbytype'){
			if($parameter==null){
				echo json_encode($msg);
				return;
			}
			echo json_encode($this->item_model->find_items(array('type'=>$parameter,'download'=>'1','api'=>'1')));
		}else if($function=='loadbyuser'){
			if($parameter==null){
				echo json_encode($msg);
				return;
			}
			$tool = $this->input->get('tool');
			if($tool==null)$tool = 1;
			$token = $this->input->post('token');
			$user = $this->user_model->load($parameter);
			if($token!=$user['token']){
				echo json_encode($this->item_model->find_items(array('user'=>$parameter,'order'=>'update_date','download'=>'1','api'=>'1','tool'=>$tool)));
			}else{
				echo json_encode($this->item_model->find_items(array('user'=>$parameter,'order'=>'update_date','download'=>'1','tool'=>$tool)));
			}
		}else if($function=='download'){
			$token = $this->input->post('token');
			$userid = $this->input->post('userid');
			if($token==null){
				echo json_encode($msg);
				return;
			}
			$user = $this->user_model->load($userid);
			if($token!=$user['token']){
				echo json_encode($msg);
				return;
			}else{
				$item = $this->item_model->load($parameter);
				$user_id = $user['id'];
				if($user_id==$item['author_id']){
					echo $item['download_url'];
					return;
				}
				$author = $this->user_model->load($item['author_id']);
				$this->load->model('item_download_model');
				$download = $this->item_download_model->loadByUserAndDownload($this->session->userdata('id'),$parameter);
				if(!$download){
					if($user['point']>=$item['price']){
						$user_point = $user['point'] - $item['price'];
						$this->user_model->update_point($user_id,$user_point);
						$author_point = $author['point'] + $item['price'];
						$this->user_model->update_point($item['author_id'],$author_point);
						
				        $this->item_download_model->user_id = $this->session->userdata('id');
				    	$this->item_download_model->item_id = $parameter;
						$this->item_download_model->create();
						
						$this->load->model('item_model');
					    $item = $this->item_model->load($parameter);
					    $this->item_model->download_num = $item['download_num'] + 1;
					    $this->item_model->updateDownloadNum($parameter);
					    
						echo $item['download_url'];
					}else{
						echo "No enough coins. You can upload works or leave comments to earn coins:)";
					}
				}else{
					echo $item['download_url'];
				}
			}
		}else if($function=='upload_pic'){
			$this->load->helper('my_form');
			$item_id = create_guid();
			$input = file_get_contents('php://input');
			$data = $input;
			$upload_dir = 'item';
			$dir = UploadPath($upload_dir);
			$file_name=$dir.'/'.$item_id.'.jpg';
			@file_put_contents($file_name, $data);
			$pic_path = base_url().'uploads/'.$upload_dir.'/'.$item_id.'.jpg';

			$config['image_library'] = 'gd2';
			$config['source_image'] = $file_name;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 200;
			$config['height'] = 160;

			$this->load->library('image_lib', $config); 

			$this->image_lib->resize();

			echo $pic_path;
		}else if($function=='upload_attachment'){
			$this->load->helper('my_form');
			$item_id = create_guid();
			$input = file_get_contents('php://input');
			$data = $input;
			$upload_dir = 'attachment';
			$dir = UploadPath($upload_dir);
			$file_name=$dir.'/'.$item_id.'.zip';
			@file_put_contents($file_name, $data);
			$pic_path = base_url().'uploads/'.$upload_dir.'/'.$item_id.'.zip';
			echo $pic_path;
		}else if($function=='upload_preview'){
			$this->load->helper('my_form');
			$item_id = create_guid();
			$input = file_get_contents('php://input');
			$data = $input;
			$upload_dir = 'preview';
			$dir = UploadPath($upload_dir);
			$file_name=$dir.'/'.$item_id.'.zip';
			@file_put_contents($file_name, $data);
			$pic_path = base_url().'uploads/'.$upload_dir.'/'.$item_id.'.zip';
			echo $pic_path;
		}else if($function=='delete'){
			$user_id = $this->input->post('userid');
			if($user_id==0||$user_id==null||$user_id=='')$user_id = $this->session->userdata('id');
			if($user_id==0||$user_id==null||$this->input->post('id')==null){
				echo json_encode($msg);
				return;
			}
			$token = $this->input->post('token');
			$user = $this->user_model->load($user_id);
			if($user==null){
				echo json_encode($msg);
				return;
			}
			if($token!=$user['token']){
				echo json_encode($msg);
				return;
			}
			$id = $this->input->post('id');
	    	if($id!=null&&$id!=''&&$id!=0){
	    		$item = $this->item_model->load($id);
	    		if($item['author_id']==$user_id){
	    			$this->item_model->delete_item($id);
	    			echo json_encode($success);
					return;
	    		}else{
	    			echo json_encode($msg);
					return;
	    		}
	    	}else{
	    		echo json_encode($msg);
				return;
	    	}
		}else if($function=='save'){
			$user_id = $this->input->post('userid');
			if($user_id==0||$user_id==null||$user_id=='')$user_id = $this->session->userdata('id');
			if($user_id==0||$user_id==null||trim($this->input->post('title')=='')){
				echo json_encode($msg);
				return;
			}
			$token = $this->input->post('token');
			$user = $this->user_model->load($user_id);
			if($user==null){
				echo json_encode($msg);
				return;
			}
			if($token!=$user['token']){
				echo json_encode($msg);
				return;
			}
			$this->item_model->author_id = $user_id;
			$this->item_model->title = $this->input->post('title');
			$this->item_model->desc = nl2br($this->input->post('desc'));
			$this->item_model->tags = $this->input->post('tags');
			$this->item_model->price = $this->input->post('price');
			$this->item_model->price_type = $this->input->post('price_type');
			$this->item_model->preview_url = $this->input->post('preview');
			$this->item_model->type = $this->input->post('type');
			$this->item_model->version = $this->input->post('version');
			$this->item_model->from = $this->input->post('from');
			$this->item_model->extension = $this->input->post('extension');
			$this->item_model->is_private = $this->input->post('is_private');
			$this->item_model->contest_id = $this->input->post('contest_id');
			$this->item_model->tool = $this->input->post('tool');
			$this->item_model->platform = 0;
			if($this->item_model->from=='particle'){
				$this->item_model->tool = 1;
				$this->item_model->extension = 'zip';
				$this->item_model->share = 0;
				$this->item_model->platform = 1;
	    		$this->item_model->folder_id = 0;
	    		$this->item_model->work_id = 0;
	    		$this->item_model->file_name = '';
			}
			$this->item_model->parent_id = $this->input->post('parent_id');
			$pic_path = $this->input->post('pic');
	    	if($pic_path!=''&&$pic_path!=null){
	    		$this->item_model->pic_url = $pic_path;
	    		$this->item_model->thumb_url = str_replace('.jpg','_thumb.jpg',$pic_path);
	    	}else{
	    		echo json_encode($msg);
				return;
	    	}
	    	$attachment_path = $this->input->post('attachment');
	    	$realpath = '';
	    	if($attachment_path!=''&&$attachment_path!=null){
	    		$this->item_model->download_url = $attachment_path;
	    		$realpath = str_replace("http://www.effecthub.com",$_SERVER['DOCUMENT_ROOT'],$attachment_path);
				$realpath = str_replace('\\', '/', $realpath);
				$size = filesize($realpath);
				$this->item_model->file_size = $size;
	    	}else{
	    		echo json_encode($msg);
				return;
	    	}
				
	    	$id = $this->input->post('id');
	    	if($id!=null&&$id!=''&&$id!=0){
	    		$olditem = $this->item_model->load($id);
		        $this->item_model->update($id);
		        
		        $this->load->model('item_history_model');	
		        $this->item_history_model->item_id = $id;
		        $this->item_history_model->action = "modify";
		        $content = '';
		        if($olditem['title']!=$this->item_model->title){
		        	$content = $content."title to ".$this->item_model->title;
		        }
		        if($olditem['desc']!=$this->item_model->desc){
		        	if($content=='')
		        	$content = "description to ".$this->item_model->desc;
		        	else $content = $content."; description to ".$this->item_model->desc;
		        }
		        if($olditem['download_url']!=$this->item_model->download_url){
		        	if($content=='')
		        	$content = "attachment updated";
		        	else $content = $content."; attachment updated";
					$this->item_history_model->download_url = $this->item_model->download_url;
		        }
				if($content!=''){
					$this->item_history_model->is_folder = 0;
					$this->item_history_model->content = $content;
					$this->item_history_model->download_url = $attachment_path;
					$this->item_history_model->insertData();
				}
				
				$item = $this->item_model->load($id);
	    	}else{
	    		$this->item_model->create();
				$id = $this->db->insert_id();
				
				$item = $this->item_model->load($id);
				//auto extract in server side
				if($realpath!=''){
					$this->load->helper('my_form');
					$guid = create_guid();
					UploadPath('extract',$guid);
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
						
						if(!$this->item_model->loadbydownloadurl($item_download_url)){
							$this->item_model->pic_url = '';
							$this->item_model->thumb_url = '';
							$this->item_model->author_id = $item['author_id'];
							$this->item_model->title = $file['name'];
							$this->item_model->desc =  $file['name'];
							$this->item_model->file_name = $file['name'];
							$this->item_model->work_id = $item['id'];
							$this->item_model->price = $item['price'];
							$this->item_model->price_type = $item['price_type'];
							$this->item_model->share = 0;
							$this->item_model->tool = 0;
							$this->item_model->from = 0;
							$this->item_model->folder_id = 0;
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
							$this->item_model->file_size = $file['size'];
							$this->item_model->is_private = $item['is_private'];
					        $this->item_model->create();
							//echo 'create item '.$file['name'].' successfully'.'<br/>';
						}
					endforeach; 
				}
				
				$this->load->model('user_model');
				
				$this->load->model('user_status_model');
		        $this->user_status_model->user_id = $user_id;
		        $this->user_status_model->action = "created a new work";
		        
		    	//$this->user_status_model->content = " named  <a href='".site_url('item/'.$id)."'>".$this->input->post('title')."</a>";
				if($item['thumb_url']!=''&&$item['thumb_url']!=null){
					$this->user_status_model->pic_url = $item['thumb_url'];
		    	}
		    	$this->user_status_model->target_url = site_url('item/'.$id);
		    	$this->user_status_model->target_name = $this->input->post('title');
        		$this->user_status_model->status_type = 2;
        		$this->user_status_model->target_id = $id;
				$this->user_status_model->insertData();
				
				
				$this->load->model('user_notice_model');
				if($this->input->post('parent_id')!=null&&$this->input->post('parent_id')!='0'){
					$parent_item = $this->item_model->load($this->input->post('parent_id'));
			        $this->user_notice_model->user_id = $parent_item['author_id'];
			    	$this->user_notice_model->content = "<a href='".site_url('user/'.$user_id)."'>".$user['displayName']."</a> forked your work <a href='".site_url('item/'.$parent_item['id'])."'>".$parent_item['title']."</a>";
					$this->user_notice_model->insertData();
					
					$this->load->model('email_model');
		            $parent_user = $this->user_model->load($parent_item['author_id']);
		            $title = $user['displayName'].' forked your work '.$parent_item['title'].' on EffectHub.com';
		            $content = $this->user_notice_model->content;
					$this->email_model->send_notification($parent_user['email'],$title,$content);
				}
				
				$user_point = $user['point'] + 10;
				$this->user_model->update_point($user_id,$user_point);
				
				$this->load->model('item_history_model');	
		        $this->item_history_model->item_id = $id;
		        $this->item_history_model->is_folder = 0;
		        $this->item_history_model->action = "create";
		        $content = ' '.$this->input->post('title');
				if($content!=''){
					$this->item_history_model->content = $content;
					$this->item_history_model->download_url = $attachment_path;
					$this->item_history_model->insertData();
				}
	    	}
			echo json_encode($item);
		}
	}	
}
