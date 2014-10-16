<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {
	
	public function __construct(){
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('cookie');
        if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
        if($this->session->userdata('id')==null) {
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
        	$this->lang->load('account','chinese');
        	$this->lang->load('pop','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('account','english');
        	$this->lang->load('pop','english');
        }
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
		$data['nav']= 'account';
		$this->load->model('item_model');
		$this->load->model('user_model');
		$this->load->model('user_social_model');
		$this->load->model('country_model');
		$data['country_list'] = $this->country_model->find_countrys(array(), 300, 0);
		$data['error_msg'] = $this->uri->segment(4, 0);
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$data['user'] = $this->user_model->load($this->session->userdata('id'));
		$data['social_list'] = $this->user_social_model->loadByUser($this->session->userdata('id'));
		
		if($this->session->userdata('language')) {
			$data['lang'] = $this->session->userdata('language')-1;
		} else {
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
			if (preg_match("/zh-c/i", $lang)||$lang=='cn') $data['lang'] = 1;
			else $data['lang'] = 0;
				
		}
		
		$this->load->view('account/settings',$data);
	}
	
	public function subscribe()
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
        	$this->lang->load('account','chinese');
        	$this->lang->load('pop','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('account','english');
        	$this->lang->load('pop','english');
        }
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}

		$this->load->model('user_model');
		
		$this->user_model->consent = $this->input->post('consent');
		$this->user_model->message = $this->input->post('message');
		$this->user_model->followme = $this->input->post('followme');
		$this->user_model->invite = $this->input->post('invite');
		$this->user_model->comment = $this->input->post('comment');
		$this->user_model->update_subscribe($this->session->userdata('id'));
		
		$user = $this->user_model->load($this->session->userdata('id'));
		$this->session->set_userdata($user);

	}
	
	/*
	public function info()
	{
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
		$data['nav']= 'account';
		$this->load->model('user_model');

	$olduser = $this->user_model->load($this->session->userdata('id'));
		if(($olduser['email']!=$this->input->post('email'))&&$this->user_model->check_email($this->input->post('email'))){
			redirect('account/settings/index/email');
		}

		$this->user_model->name = trim($this->input->post('urlname'));
		$this->user_model->displayName = $this->input->post('displayName');
		$this->user_model->countryCode = $this->input->post('country');
		$this->user_model->homepage = $this->input->post('homepage');
		$this->user_model->desc = $this->input->post('desc');
		$this->user_model->updateinfo($this->session->userdata('id'));

	if($olduser['email']!=$this->input->post('email')){
			$this->user_model->updateVerified($this->session->userdata('id'),0);
			$this->load->model('email_model');
			if($olduser['token']){
				$url = 'http://www.effecthub.com/user/confirm_email/'.$olduser['id'].'/'.$olduser['token'];
			}else{
				$token = create_guid();
				$this->user_model->updateToken($olduser['id'],$token);
				$url = 'http://www.effecthub.com/user/confirm_email/'.$olduser['id'].'/'.$token;
			}
			$this->email_model->send_email_confirm($this->input->post('email'),$url);
		}

		$user = $this->user_model->load($this->session->userdata('id'));
		$this->session->set_userdata($user);
		redirect(site_url('account/settings/index/info')); 
	}	
	*/
	
	public function initPassword()
	{
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
		$data['nav']= 'account';
		$new_pwd = $this->input->post('new_password');

		$this->load->model('user_model'); 
		if ($this->user_model->update_pwd($this->session->userdata('id'),$new_pwd)){
			    echo "<script>alert('Change password successful.');location.href='".site_url('account/settings')."';</script>";
			   //redirect('account/settings');
		}
	}
	
	public function savepassword($pswd,$old_pswd)
	{
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
				
		$this->load->model('user_model');
		$v = $this->user_model->check_pwd($this->session->userdata('id'),$old_pswd);
		
		if ($v == true){
			$this->load->model('user_model'); 
			$this->user_model->update_pwd($this->session->userdata('id'),$pswd);
		}
		
		echo $v;
	}
	
	public function avatar()
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
        	$this->lang->load('account','chinese');
        	$this->lang->load('pop','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('account','english');
        	$this->lang->load('pop','english');
        }
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
		$data['nav']= 'account';
		$this->load->model('user_model');
		$id = $this->input->post('userid');
		if($_FILES["url"]["size"] !== 0)
		{
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
					$upload_dir = 'avatar';
					$dir = UploadPath($upload_dir);
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
				$config['width'] = 100;
				$config['height'] = 100;
				
				$this->load->library('image_lib', $config); 
				
				$this->image_lib->resize();
				$s_pic_path = base_url().'uploads/'.$upload_dir.'/'.$user_id.'_thumb.jpg';
	    		$this->user_model->updatePic($id,$s_pic_path,$pic_path);
				
	    		$this->load->model('user_status_model');	
		        $this->user_status_model->user_id = $this->session->userdata('id');
		        $this->user_status_model->status_type = 7;
		        $this->user_status_model->target_id = $this->session->userdata('id');
		        $this->user_status_model->pic_url = $pic_path;
		    	//$this->user_status_model->content = "changed <a href='".$pic_path."'>avatar</a>";
				
		        $this->user_status_model->insertData();
				$this->session->set_userdata('pic_url',$pic_path);
	    	}
		}
		
		redirect(site_url('account/settings/index/avatar')); 
	}
	
	public function verifypassword($pswd)
	{
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}		
		$this->load->model('user_model');
		$v = $this->user_model->check_pwd($this->session->userdata('id'),$pswd);
		echo $v;
	}
	
	public function verifyuser($name)
	{
		$this->load->model('user_model');
		$v = $this->user_model->verify_username(trim($name));
		if ($v == null){
			echo true;
		} else 
			echo false;
	}
	
	public function savesettings(){
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
		
		$this->load->model('user_model');
		$v = $this->user_model->verify_username(trim($this->input->post('username')));
				
		if ($v != null and sizeof($v) > 0)
		{			
			echo false;		
		} 
		else
		{
			$this->user_model->name = trim(htmlspecialchars(trim($this->input->post('username'))));
			$this->user_model->displayName = htmlspecialchars(trim($this->input->post('displayname')));
			$this->user_model->countryCode = $this->input->post('country');
			$this->user_model->homepage = $this->input->post('userurl');
			$this->user_model->desc = htmlspecialchars(trim($this->input->post('description')));
			$this->user_model->updateinfo($this->session->userdata('id'));
				
			$user = $this->user_model->load($this->session->userdata('id'));
			$this->session->set_userdata($user);
			
			echo true;	
		}		

	}
	
}


