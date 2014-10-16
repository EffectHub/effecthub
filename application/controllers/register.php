<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once( APPPATH.'/libraries/twitter/config.php' );
require_once( APPPATH.'/libraries/twitter/Twitter.php' );
include_once( APPPATH.'/libraries/weibo/config.php' );
include_once( APPPATH.'/libraries/weibo/SaeTOAuthV2.php' );
require_once( APPPATH.'/libraries/facebook/Facebook.php' );
class Register extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
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
        	$this->lang->load('account','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('account','english');
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
	
	public function index()
	{
		if ($this->session->userdata('id')) {
			redirect('home');
		}
		
		$this->load->model('item_model');
		$data['error_msg'] = $this->uri->segment(3, 0);
		$data['detail'] = $this->uri->segment(4, 0);
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$this->load->view('account/register',$data);
	}
	
	function yzm_img()
	{
		$this->load->helper('captcha');
		code();
	}
	
	public function savebytool()
	{
		$this->load->model('user_model');
		$client_id = $this->input->post('client_id');
		
		$this->user_model->name = $client_id;
		$this->user_model->displayName = $client_id;
		$this->user_model->pic_url='http://www.effecthub.com/images/blank.jpg';
		
		$this->user_model->consent = 'on';
		$this->user_model->from = $this->input->post('from');
		$this->user_model->countryCode = 'US';
		$this->user_model->create();
		$id = $this->db->insert_id();
	}
	
	public function save()
	{
		$this->load->model('user_model');
		$this->load->model('user_social_model');
		$email = $this->input->post('email_address');
		
		$password = $this->input->post('password');
		$name = trim($this->input->post('full_name'));
		$displayName = $this->input->post('full_name');
		
		if(!$email){
			if($this->input->post('redirectURL')){
				redirect($this->input->post('redirectURL')); 
			}else{
				redirect(site_url('login')); 
			}
		}
		if($this->input->post('country')=='------------'){
			redirect(site_url('login')); 
		}
		
		/*$ip = $this->input->ip_address();
		$user_count = $this->user_model->count_users();
		$latest_user = $this->user_model->load(1000000+$user_count);
		if($latest_user['last_login_ip']==$ip){
			redirect('register/index/robot');
		}
		$latest_user_1 = $this->user_model->load(1000000+$user_count-1);
		if($latest_user_1['last_login_ip']==$ip){
			redirect('register/index/robot');
		}
		
		$this->load->model('spam_model');
		$spam_email_list = $this->spam_model->find_spams(array('type'=>'1'));
		foreach($spam_email_list as $spam): 
			if( strpos($email,$spam['name'])){ 
				redirect('register/index/spam');
			}
		endforeach; 
		$spam_name_list = $this->spam_model->find_spams(array('type'=>'3'));
		foreach($spam_name_list as $spam): 
			if( $name==$spam['name']){ 
				redirect('register/index/spam');
			}
		endforeach; 
		*/
		/*$spam_ip_list = $this->spam_model->find_spams(array('type'=>'2'));
		foreach($spam_ip_list as $spam_ip): 
			if( strpos($ip,$spam_ip['name'])){ 
				redirect('register/index/ip');
			}
		endforeach; */
		
		if(!$displayName){
			$namelist = explode("@",$email);
			$name = $namelist[0];
			$displayName = $namelist[0];
		}
		$this->user_model->name = $name;
		$this->user_model->password = md5($this->input->post('password'));
		$this->user_model->email = $email;
		$this->user_model->countryCode = $this->input->post('country');
		if(!$this->input->post('country')){
			$this->user_model->countryCode = 'US';
		}
		$language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
		if (preg_match("/zh-c/i", $language)||$language=='cn'){
			$this->user_model->countryCode = 'CN';
		}
		$this->user_model->consent = $this->input->post('consent');
		$this->user_model->from = $this->input->post('from');
		$this->user_model->displayName = $displayName;
		if($this->input->post('token')){
			$this->user_social_model->token = $this->input->post('token');
			$this->user_social_model->token_secret = $this->input->post('token_secret');
			$this->user_social_model->social_id = $this->input->post('uid');
			$this->user_social_model->name = $this->input->post('name');
			$this->user_model->name = $this->input->post('name');
			$this->user_model->displayName = $this->input->post('name');
			$this->user_social_model->avatar = $this->input->post('avatar');
			$this->user_model->pic_url = $this->input->post('avatar');
			$this->user_social_model->type = $this->input->post('type');
			$this->user_social_model->outlink = $this->input->post('outlink');
			$this->user_model->from = $this->input->post('type');
			$this->user_social_model->expires_in = $this->input->post('expires_in');
			$this->user_social_model->refresh_token = $this->input->post('refresh_token');
		}else{
			/*session_start();
			$Verifier = $this->input->post('verifier');
	        if ($_SESSION['verify'] == $Verifier){
				//
			}else{
				redirect('register/index/verifier');
			}*/
		}
		if($this->user_model->pic_url==null||$this->user_model->pic_url==''){
			$this->user_model->pic_url='http://www.effecthub.com/images/blank.jpg';
		}
		if($this->user_model->check_email($email)){
			$mailurl = str_replace('@','AT',$email);
			redirect('register/index/customer/'.$mailurl);
		}else{
			$this->user_model->create();
			$id = $this->db->insert_id();
			if($this->input->post('token')){
				$this->user_social_model->user_id = $id;
				$this->user_social_model->create();
			}
			$user = $this->user_model->load($id);
			$this->user_model->update_last_login($user['id']);
			$this->user_model->update_last_ip($user['id']);
			if( $this->input->post('type')=='twitter'){ 
				$user['token_twitter'] = $this->input->post('token');
				$user['token_secret_twitter'] = $this->input->post('token_secret');
				$user['twitter_id'] = $this->input->post('uid');
			}
			if( $this->input->post('type')=='facebook'){ 
				$user['token_facebook'] = $this->input->post('token');
				$user['facebook_id'] = $this->input->post('uid');
			}
			if( $this->input->post('type')=='sina'){ 
				$user['token_sina'] = $this->input->post('token');
				$user['sina_id'] = $this->input->post('uid');
			}	
			if( $this->input->post('type')=='google'){ 
				$user['token_google'] = $this->input->post('token');
				$user['google_id'] = $this->input->post('uid');
			}
			if( $this->input->post('type')=='behance'){ 
				$user['token_behance'] = $this->input->post('token');
			}
			$this->session->set_userdata($user);
			
			$this->load->model('email_model');
			if($user['token']){
				$url = 'http://www.effecthub.com/user/confirm_email/'.$user['id'].'/'.$user['token'];
			}else{
				$token = create_guid();
				$this->user_model->updateToken($user['id'],$token);
				$url = 'http://www.effecthub.com/user/confirm_email/'.$user['id'].'/'.$token;
			}
			$this->email_model->send_welcome($user['email'],$url);
			/*
			$this->load->model('country_model');
			$country = $this->country_model->load($user['countryCode']);
			$country_name = $country['full_name'];
			$this->load->model('group_model');
			if(!$this->group_model->check_name($country_name)){
				$this->group_model->group_name = $country_name;
		    	$this->group_model->group_desc = $country_name;
				$this->group_model->group_type = 6;
				$this->group_model->member_num = 1;
			    $this->group_model->topic_num = 0;
			    $this->group_model->is_private = '0';
				$this->group_model->admin_id = $user['id'];
				$this->group_model->group_pic = 'http://www.effecthub.com/uploads/group/1.jpg';
				$this->group_model->group_weibo_id = '';
				$this->group_model->create();
				$new_group_id = $this->db->insert_id();
				$this->load->model('user_group_model');
		    	$this->user_group_model->user_id = $user['id'];
				$this->user_group_model->group_id = $new_group_id;
				$this->user_group_model->role = 0;
		    	$this->user_group_model->create();
			}
			*/
			if($this->input->post('share')){
				if($this->input->post('type')=='sina'){
					$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $this->session->userdata('token_sina') );
					$c->update('我刚刚加入了EffectHub社区--与全球的游戏设计师一起工作，发现和分享精彩作品！ '.site_url('register'));
				}
				if($this->input->post('type')=='twitter'){
					$api = new Twitter( TT_AKEY , TT_SKEY );
					$api->setOAuthToken($this->session->userdata('token_twitter'));
					$api->setOAuthTokenSecret($this->session->userdata('token_secret_twitter'));
					$api->statusesUpdate('I joined EffectHub.com just now: your best source for gaming. '.site_url('register'));
				}
				if($this->input->post('type')=='facebook'){
					$api = new Facebook(array());
					$api->setAccessToken($this->session->userdata('token_facebook'));
					$api->api('/me/feed', 'POST',
	                                    array(
	                                      'link' => site_url('register'),
	                                      'message' => 'I joined EffectHub.com just now: your best source for gaming. '
	                                 ));
				}
			}
			if($this->input->post('redirectURL')){
				//redirect($this->input->post('redirectURL')); 
				echo '<script language="JavaScript">window.top.location.href="'.$this->input->post('redirectURL').'"</script>;';
			}else{
				if($this->input->post('type')=='twitter'){
					redirect(site_url('user/invite/first/1'));
				}else{
					redirect(site_url('account/settings')); 
				}
			}
		}
	}
}
