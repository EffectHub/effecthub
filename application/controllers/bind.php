<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bind extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		
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
			
		
        $this->load->helper('url');
        $this->load->helper('rest');
        
        
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
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        }
    }
	
	public function index()
	{
	}
	
	public function cancel($type)
	{
		$user_id = $this->session->userdata('id');
    	$this->load->model('user_social_model');
    	if($type=='twitter'){
    		$this->session->unset_userdata('token_twitter');
    		$this->user_social_model->deleteSocial($user_id,'twitter');
    	}
        if($type=='facebook'){
        	$this->session->unset_userdata('token_facebook');
        	$this->user_social_model->deleteSocial($user_id,'facebook');
        }
        if($type=='sina'){
        	$this->session->unset_userdata('token_sina');
        	$this->user_social_model->deleteSocial($user_id,'sina');
        }
        if($type=='google'){
        	$this->session->unset_userdata('token_google');
        	$this->user_social_model->deleteSocial($user_id,'google');
        }
        if($type=='behance'){
        	$this->session->unset_userdata('token_behance');
        	$this->user_social_model->deleteSocial($user_id,'behance');
        }
        if($type=='qq'){
        	$this->session->unset_userdata('token_qq');
        	$this->user_social_model->deleteSocial($user_id,'qq');
        }
	   redirect(site_url('account/settings')); 
	}	
}