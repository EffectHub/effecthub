<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once( APPPATH.'/libraries/behance/config.php' );
require_once( APPPATH.'/libraries/behance/Api.php' );
require_once( APPPATH.'/libraries/facebook/Facebook.php' );
require_once( APPPATH.'/libraries/twitter/config.php' );
require_once( APPPATH.'/libraries/twitter/Twitter.php' );
include_once( APPPATH.'/libraries/weibo/config.php' );
include_once( APPPATH.'/libraries/weibo/SaeTOAuthV2.php' );
include_once( APPPATH.'/libraries/qq/config.php' );
include_once( APPPATH.'/libraries/google/Google_Client.php' );
include_once( APPPATH.'/libraries/google/contrib/Google_Oauth2Service.php' );
class Callback extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('rest');
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
        	$this->lang->load('account','chinese');
        	$this->lang->load('footer','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('account','english');
        	$this->lang->load('footer','english');
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
	}
	
	public function behance()
	{
		$this->load->model('item_model');
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$api = new Be_Api( BE_AKEY , BE_SKEY );
		if (isset($_REQUEST['code'])) {
			$keys = array();
			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = BE_CALLBACK_URL;
			try {
				$token = $api->exchangeCodeForToken( $keys['code'], $keys['redirect_uri'], $_REQUEST['state'], 'authorization_code') ;
				if ($token) {
					$user = $api->getAuthenticatedUser();
					$this->load->model('user_social_model');
					$social = $this->user_social_model->loadByUid($user->id);
					if($social)
					{
						$user_id = $social['user_id'];
						$this->load->model('user_model');
						$user = $this->user_model->load($user_id);
						if($user){
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
							$this->session->set_userdata($user);
							redirect(site_url('home')); 
						}else{
							redirect(site_url('login')); 
						}
					}else{
						$data['social'] = array(
									   'token'  => $token,
									   'token_secret'  => '',
									   'name'  => $user->username,
									   'uid' => $user->id,
									   'link' => $user->url,
									   'avatar' => '',
									   'type' => 'behance'
						);
						if ($this->session->userdata('id')!=null){
							$this->user_social_model->token = $data['social']['token'];
							$this->user_social_model->token_secret = $data['social']['token_secret'];
							$this->user_social_model->social_id = $data['social']['uid'];
							$this->user_social_model->name = $data['social']['name'];
							$this->user_social_model->avatar = $data['social']['avatar'];
							$this->user_social_model->type = $data['social']['type'];
							$this->user_social_model->outlink = $data['social']['link'];
							$this->user_social_model->user_id = $this->session->userdata('id');
							$this->user_social_model->create();
							$this->session->set_userdata('token_behance',1);
							redirect(site_url('account/social')); 
						}else{
							$this->load->view('account/callback',$data);
						}
					}
				}else{
					redirect(site_url('login')); 
				}
			} catch (OAuthException $e) {
					redirect(site_url('login')); 
					echo $e;
			}
		}else{
			redirect(site_url('login')); 
		}
	}
	
	public function twitter()
	{
		$this->load->model('item_model');
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$api = new Twitter( TT_AKEY , TT_SKEY );
		$response = $api->oAuthAccessToken( $_REQUEST['oauth_token'], $_REQUEST['oauth_verifier']);
// 		print_r($response);
		if (isset($response['user_id'])) {
			$this->load->model('user_social_model');
			$social = $this->user_social_model->loadByUid($response['user_id']);
			if($social)
			{
				$user_id = $social['user_id'];
				$this->load->model('user_model');
				$user = $this->user_model->load($user_id);
				if($user){
					$social_list = $this->user_social_model->loadByUser($user['id']);
					foreach($social_list as $social): 
						if( $social['type']=='twitter'){ 
							$user['token_twitter'] = $social['token'];
							$user['token_secret_twitter'] = $social['token_secret'];
							$user['twitter_id'] = $social['social_id'];
						}
						if( $social['type']=='facebook'){ 
							$user['token_facebook'] = $social['token'];
							$user['facebook_id'] = $social['social_id'];
						}
						if( $social['type']=='sina'){ 
							$user['token_sina'] = $social['token'];
							$user['sina_id'] = $social['social_id'];
						}	
						if( $social['type']=='google'){ 
							$user['token_google'] = $social['token'];
							$user['google_id'] = $social['social_id'];
						}
						if( $social['type']=='behance'){ 
							$user['token_behance'] = $social['token'];
						}
					endforeach; 
					$cookie = array(
					    'name'   => 'effecthub_user',
					    'value'  => $this->encrypt->encode($user['id']),
					    'expire' => '2595000',
					    'domain' => '.effecthub.com'
					);
	            	set_cookie($cookie);
	            	$cookie = array(
	            		'name' => 'effecthub_password',
	            		'value' => $this->encrypt->encode($user['password']),
	            		'expire' => '2595000',
	            		'domain' => '.effecthub.com'
	            	);
	            	set_cookie($cookie);
					$this->session->set_userdata($user);
					if($this->session->userdata('redirectURL')){
						redirect($this->session->userdata('redirectURL')); 
					}else{
						redirect(site_url('home')); 
					}
				}else{
					redirect(site_url('login')); 
				}
			}else{
				$data['user'] = $api->usersShow($response['user_id']);
// 				print_r($data['user']);
				$data['social'] = array(
							   'token'  => $response['oauth_token'],
							   'token_secret'  => $response['oauth_token_secret'],
							   'name'  => $data['user']['name'],
							   'link'  => 'https://twitter.com/'.$response['screen_name'],
							   'uid' => $response['user_id'],
							   'avatar' => $data['user']['profile_image_url'],
							   'type' => 'twitter',
								'social_id' => $response['user_id']
				);
				if ($this->session->userdata('id')!=null){
					$this->user_social_model->token = $data['social']['token'];
					$this->user_social_model->token_secret = $data['social']['token_secret'];
					$this->user_social_model->social_id = $data['social']['uid'];
					$this->user_social_model->name = $data['social']['name'];
					$this->user_social_model->avatar = $data['social']['avatar'];
					$this->user_social_model->type = $data['social']['type'];
					$this->user_social_model->outlink = $data['social']['link'];
					$this->user_social_model->user_id = $this->session->userdata('id');
					$this->user_social_model->create();
					$this->session->set_userdata('token_twitter',$data['social']['token']);
					$this->session->set_userdata('token_secret_twitter',$data['social']['token_secret']);
					$this->session->set_userdata('twitter_id',$data['social']['uid']);
					redirect(site_url('account/social')); 
				}else{
					$this->load->view('account/callback',$data);
				}
			}
		}else{
			redirect(site_url('login')); 
		}
	}
	
	public function sina()
	{
		$this->load->model('item_model');
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
		if (isset($_REQUEST['code'])) {
			$keys = array();
			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = WB_CALLBACK_URL;
			try {
				$token = $o->getAccessToken( 'code', $keys ) ;
				if ($token) {
					$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $token['access_token'] );
					$ret_sina = $c->get_uid();
					setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
					if ( isset($ret_sina['uid']) && $ret_sina['uid'] > 0 ) {
						$this->load->model('user_social_model');
						$social = $this->user_social_model->loadByUid($ret_sina['uid']);
						if($social)
						{
							$user_id = $social['user_id'];
							$this->load->model('user_model');
							$user = $this->user_model->load($user_id);
							if($user){
								$social_list = $this->user_social_model->loadByUser($user['id']);
								foreach($social_list as $social): 
									if( $social['type']=='twitter'){ 
										$user['token_twitter'] = $social['token'];
										$user['token_secret_twitter'] = $social['token_secret'];
										$user['twitter_id'] = $social['social_id'];
									}
									if( $social['type']=='facebook'){ 
										$user['token_facebook'] = $social['token'];
										$user['facebook_id'] = $social['social_id'];
									}
									if( $social['type']=='sina'){ 
										$user['token_sina'] = $social['token'];
										$user['sina_id'] = $social['social_id'];
									}	
									if( $social['type']=='google'){ 
										$user['token_google'] = $social['token'];
										$user['google_id'] = $social['social_id'];
									}
									if( $social['type']=='behance'){ 
										$user['token_behance'] = $social['token'];
									}
								endforeach; 
								$cookie = array(
								    'name'   => 'effecthub_user',
								    'value'  => $this->encrypt->encode($user['id']),
								    'expire' => '2595000',
								    'domain' => '.effecthub.com'
								);
				            	set_cookie($cookie);
				            	$cookie = array(
				            		'name' => 'effecthub_password',
				            		'value' => $this->encrypt->encode($user['password']),
				            		'expire' => '2595000',
				            		'domain' => '.effecthub.com'
				            	);
				            	set_cookie($cookie);
								$this->session->set_userdata($user);
								if($this->session->userdata('redirectURL')){
								redirect($this->session->userdata('redirectURL')); 
								}else{
									redirect(site_url('home')); 
								}
							}else{
								redirect(site_url('login')); 
							}
						}else{
							$user = $c->show_user_by_id($ret_sina['uid']);
							$data['user'] = $user;
							$pic = str_replace('/50/','/180/',$user["profile_image_url"]);
							$link = $user['domain']?'http://www.weibo.com/'.$user['domain']:'http://www.weibo.com/'.$ret_sina['uid'];
							$data['social'] = array(
										   'token'  => $token['access_token'],
										   'token_secret'  => '',
										   'name'  => $user["name"],
										   'link'  => $link,
										   'uid' => $ret_sina['uid'],
										   'avatar' => $pic,
										   'type' => 'sina'
							);
							if ($this->session->userdata('id')!=null){
								$this->user_social_model->token = $data['social']['token'];
								$this->user_social_model->token_secret = $data['social']['token_secret'];
								$this->user_social_model->social_id = $data['social']['uid'];
								$this->user_social_model->name = $data['social']['name'];
								$this->user_social_model->avatar = $data['social']['avatar'];
								$this->user_social_model->type = $data['social']['type'];
								$this->user_social_model->outlink = $data['social']['link'];
								$this->user_social_model->user_id = $this->session->userdata('id');
								$this->user_social_model->create();
								$this->session->set_userdata('token_sina',1);
								redirect(site_url('account/social')); 
							}else{
								$this->load->view('account/callback',$data); 
							}
						}
					}
				}else{
					redirect(site_url('login')); 
				}
			} catch (OAuthException $e) {
					redirect(site_url('login')); 
					echo $e;
			}
		}else{
			redirect(site_url('login')); 
		}
	}	
	
	public function facebook()
	{
		$this->load->model('item_model');
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$api = new Facebook(array());
		if (isset($_REQUEST['code'])) {
			$keys = array();
			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = 'http://www.effecthub.com/callback/facebook';
			try {
				$token = $api->getAccessTokenFromCode( $keys['code'], $keys['redirect_uri'] ) ;
				if ($token) {
					$api->setAccessToken($token);
					$user = $api->api('/me');
// 					print_r($user);
					$this->load->model('user_social_model');
						$this->load->model('user_model');
					$social = $this->user_social_model->loadByUid($user['id']);
					if($social)
					{
						$user_id = $social['user_id'];
						$user = $this->user_model->load($user_id);
						if($user){
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
							$cookie = array(
							    'name'   => 'effecthub_user',
							    'value'  => $this->encrypt->encode($user['id']),
							    'expire' => '2595000',
							    'domain' => '.effecthub.com'
							);
			            	set_cookie($cookie);
			            	$cookie = array(
			            		'name' => 'effecthub_password',
			            		'value' => $this->encrypt->encode($user['password']),
			            		'expire' => '2595000',
			            		'domain' => '.effecthub.com'
			            	);
			            	set_cookie($cookie);
							$this->session->set_userdata($user);
							if($this->session->userdata('redirectURL')){
								redirect($this->session->userdata('redirectURL')); 
							}else{
								redirect(site_url('home')); 
							}
						}else{
							redirect(site_url('login')); 
						}
					}else{
						$data['social'] = array(
									   'token'  => $token,
									   'token_secret'  => '',
									   'name'  => $user["name"],
									   'uid' => $user['id'],
									   'avatar' => '',
									   'link'  => $user["link"],
									   'type' => 'facebook',
										'email'=> $user['email']
						);
						if ($this->session->userdata('id')!=null){
							$this->user_social_model->token = $data['social']['token'];
							$this->user_social_model->token_secret = $data['social']['token_secret'];
							$this->user_social_model->social_id = $data['social']['uid'];
							$this->user_social_model->name = $data['social']['name'];
							$this->user_social_model->avatar = $data['social']['avatar'];
							$this->user_social_model->type = $data['social']['type'];
							$this->user_social_model->outlink = $data['social']['link'];
							$this->user_social_model->user_id = $this->session->userdata('id');
							$this->user_social_model->create();
							$this->session->set_userdata('token_facebook',1);
							redirect(site_url('account/social')); 
						}else{
							//$this->load->view('account/callback',$data); 
							if($this->user_model->check_email($data['social']['email'])){
								$mailurl = str_replace('@','AT',$data['social']['email']);
								redirect('register/index/customer/'.$mailurl);
							}
							$this->user_model->name = trim($data['social']['name']);
							$this->user_model->displayName = $data['social']['name'];
							$this->user_model->from = $data['social']['type'];
							$this->user_model->email = $data['social']['email'];
							$this->user_model->countryCode = 'US';
							$this->user_model->consent = 'on';
							$this->user_model->pic_url=$data['social']['avatar'];
							if($this->user_model->pic_url==null||$this->user_model->pic_url==''){
								$this->user_model->pic_url='http://www.effecthub.com/images/blank.jpg';
							}
							$this->user_model->create();
							$id = $this->db->insert_id();
							
							$this->user_social_model->user_id = $id;
							$this->user_social_model->token = $data['social']['token'];
							$this->user_social_model->token_secret = $data['social']['token_secret'];
							$this->user_social_model->social_id = $data['social']['uid'];
							$this->user_social_model->name = $data['social']['name'];
							$this->user_social_model->avatar = $data['social']['avatar'];
							$this->user_social_model->type = $data['social']['type'];
							$this->user_social_model->outlink = $data['social']['link'];
							$this->user_social_model->create();
							
							$user = $this->user_model->load($id);
							$this->user_model->update_last_login($user['id']);
							$this->user_model->update_last_ip($user['id']);
							$user['token_facebook'] = $data['social']['token'];
							$user['facebook_id']=$data['social']['uid'];
							$this->session->set_userdata($user);
			
							$this->load->model('email_model');
							$token = create_guid();
							$this->user_model->updateToken($user['id'],$token);
							$url = 'http://www.effecthub.com/user/confirm_email/'.$user['id'].'/'.$token;
							$this->email_model->send_welcome($user['email'],$url);
							
							if($this->input->post('type')=='facebook'){
								$api = new Facebook(array());
								$api->setAccessToken($this->session->userdata('token_facebook'));
								$api->api('/me/feed', 'POST',
				                                    array(
				                                      'link' => site_url('register'),
				                                      'message' => 'I joined EffectHub.com just now: your best source for gaming. '
				                                 ));
							}
						
			                if($this->session->userdata('redirectURL')){
								redirect($this->session->userdata('redirectURL')); 
							}else{
								redirect(site_url('account/settings'));
							}
						}
					}
				}else{
					//redirect(site_url('login')); 
				}
			} catch (OAuthException $e) {
					//redirect(site_url('login')); 
					echo $e;
			}
		}else{
			redirect(site_url('login')); 
		}
	}
	
	public function google()
	{
		$this->load->model('item_model');
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$api = new Google_Client();
		$scope = array(
              'https://www.googleapis.com/auth/userinfo.profile',
              'https://www.googleapis.com/auth/userinfo.email',
				"http://www.google.com/m8/feeds/",
          );
		$api->setScopes($scope);
		$oauth2 = new Google_Oauth2Service($api);
		if (isset($_REQUEST['code'])) {
			$api->authenticate($_REQUEST['code']);
			try {
				$token = $api->getAccessToken();
				print $token;
				if ($token) {
					$api->setAccessToken($token);
					$user = $oauth2->userinfo->get();
					$name = $user['name'];
					$email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
					$img = '';
					$url = '';
					if(isset($user['picture'])){
						$img = filter_var($user['picture'], FILTER_VALIDATE_URL);
					}
					if(isset($user['link']))$url = filter_var($user['link'], FILTER_VALIDATE_URL);
					$this->load->model('user_social_model');
					$this->load->model('user_model');
					$social = $this->user_social_model->loadByUid($user['id']);
					if($social)
					{
						$user_id = $social['user_id'];
						$user = $this->user_model->load($user_id);
						if($user){
							$social_list = $this->user_social_model->loadByUser($user['id']);
							foreach($social_list as $social): 
								if( $social['type']=='twitter'){ 
									$user['token_twitter'] = $social['token'];
									$user['token_secret_twitter'] = $social['token_secret'];
									$user['twitter_id'] = $social['social_id'];
								}
								if( $social['type']=='facebook'){ 
									$user['token_facebook'] = $social['token'];
									$user['facebook_id'] = $social['social_id'];
								}
								if( $social['type']=='sina'){ 
									$user['token_sina'] = $social['token'];
									$user['sina_id'] = $social['social_id'];
								}	
								if( $social['type']=='google'){ 
									$user['token_google'] = $token;//$social['token'];
									$user['google_id'] = $social['social_id'];
									$this->user_social_model->updateToken($social['id'],$token);
								}
								if( $social['type']=='behance'){ 
									$user['token_behance'] = $social['token'];
								}
							endforeach; 
							$cookie = array(
							    'name'   => 'effecthub_user',
							    'value'  => $this->encrypt->encode($user['id']),
							    'expire' => '2595000',
							    'domain' => '.effecthub.com'
							);
			            	set_cookie($cookie);
			            	$cookie = array(
			            		'name' => 'effecthub_password',
			            		'value' => $this->encrypt->encode($user['password']),
			            		'expire' => '2595000',
			            		'domain' => '.effecthub.com'
			            	);
			            	set_cookie($cookie);
							$this->session->set_userdata($user);
							if($this->session->userdata('redirectURL')){
								redirect($this->session->userdata('redirectURL')); 
							}else{
								redirect(site_url('home')); 
							}
						}else{
							redirect(site_url('login')); 
						}
					}else{
						$data['social'] = array(
									   'token'  => $token,
									   'token_secret'  => '',
									   'name'  => $name,
									   'link'  => $url,
									   'uid' => $user['id'],
									   'avatar' => $img,
									   'type' => 'google',
										'email' => $email
						);
						if ($this->session->userdata('id')!=null){
							$this->user_social_model->token = $data['social']['token'];
							$this->user_social_model->token_secret = $data['social']['token_secret'];
							$this->user_social_model->social_id = $data['social']['uid'];
							$this->user_social_model->name = $data['social']['name'];
							$this->user_social_model->avatar = $data['social']['avatar'];
							$this->user_social_model->type = $data['social']['type'];
							$this->user_social_model->outlink = $data['social']['link'];
							$this->user_social_model->user_id = $this->session->userdata('id');
							$this->user_social_model->create();
							$this->session->set_userdata('token_google',$data['social']['token']);
							$this->session->set_userdata('google_id',$data['social']['uid']);
							redirect(site_url('account/social')); 
						}else{
							//$this->load->view('account/callback',$data); 
							if($this->user_model->check_email($data['social']['email'])){
								$mailurl = str_replace('@','AT',$data['social']['email']);
								redirect('register/index/customer/'.$mailurl);
							}
							$urlname = $data['social']['name'];
							$this->user_model->name = trim($urlname);
							$this->user_model->displayName = $urlname;
							$this->user_model->from = $data['social']['type'];
							$this->user_model->email = $data['social']['email'];
							$this->user_model->countryCode = 'US';
							$this->user_model->consent = 'on';
							$this->user_model->pic_url=$data['social']['avatar'];
							if($this->user_model->pic_url==null||$this->user_model->pic_url==''){
								$this->user_model->pic_url='http://www.effecthub.com/images/blank.jpg';
							}
							$this->user_model->create();
							$id = $this->db->insert_id();
							
							$this->user_social_model->user_id = $id;
							$this->user_social_model->token = $data['social']['token'];
							$this->user_social_model->token_secret = $data['social']['token_secret'];
							$this->user_social_model->social_id = $data['social']['uid'];
							$this->user_social_model->name = $data['social']['name'];
							$this->user_social_model->avatar = $data['social']['avatar'];
							$this->user_social_model->type = $data['social']['type'];
							$this->user_social_model->outlink = $data['social']['link'];
							$this->user_social_model->create();
							
							$user = $this->user_model->load($id);
							$this->user_model->update_last_login($user['id']);
							$this->user_model->update_last_ip($user['id']);
							$user['token_google'] = $data['social']['token'];
							$user['google_id']=$data['social']['uid'];
							$this->session->set_userdata($user);
			
							$this->load->model('email_model');
							$token = create_guid();
							$this->user_model->updateToken($user['id'],$token);
							$url = 'http://www.effecthub.com/user/confirm_email/'.$user['id'].'/'.$token;
							$this->email_model->send_welcome($user['email'],$url);
							
			                if($this->session->userdata('redirectURL')){
								redirect($this->session->userdata('redirectURL')); 
							}else{
								redirect(site_url('account/settings'));
							}
						}
					}
				}else{
					redirect(site_url('login')); 
				}
			} catch (OAuthException $e) {
					redirect(site_url('login')); 
					echo $e;
			}
		}else{
			redirect(site_url('login')); 
		}
	}
	
    function qq()
    { 
    	$this->load->model('item_model');
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
	$sUrl = "https://graph.qq.com/oauth2.0/token";
	$aGetParam = array(
		"grant_type"    =>    "authorization_code",
		"client_id"        =>    QQ_AKEY,
		"client_secret"    =>    QQ_SKEY,
		"code"            =>    $_REQUEST['code'],
		//"state"            =>    $_GET["state"],
		"redirect_uri"    =>    QQ_CALLBACK_URL
	);
	$sContent = get($sUrl,$aGetParam);
	if($sContent!==FALSE){
		$aTemp = explode("&", $sContent);
		$aParam = array();
		foreach($aTemp as $val){
			$aTemp2 = explode("=", $val);
			$aParam[$aTemp2[0]] = $aTemp2[1];
		}
		//$_SESSION["access_token"] = $aParam["access_token"];
		$token = $aParam["access_token"];
		$sUrl = "https://graph.qq.com/oauth2.0/me";
		$aGetParam = array(
			"access_token"    => $aParam["access_token"]
		);
		$sContent = get($sUrl, $aGetParam);
		if($sContent!==FALSE){
			$aTemp = array();
			preg_match('/callback\(\s+(.*?)\s+\)/i', $sContent,$aTemp);
			$aResult = json_decode($aTemp[1],true);
			$openid = $aResult["openid"];
			//原始版本简化版本到此结束
			//get_user_info 拿过来
			$sUrl = "https://graph.qq.com/user/get_user_info";
			$aGetParam = array(
					"access_token" => $token,
					"oauth_consumer_key"    =>    QQ_AKEY,
					"openid"                =>    $openid,
					"format"                =>    "json"
			);
			$sContent = get($sUrl,$aGetParam);
			if($sContent!==FALSE){
				$aResult = json_decode($sContent,true);
				if($aResult["ret"]==0){
					$pic_s = $aResult["figureurl"].'d';
					$pic = strtr($pic_s,'30d','100');
					$this->load->model('user_social_model');
					$social = $this->user_social_model->loadByUid($openid);
					if($social)
					{
						$user_id = $social['user_id'];
						$this->load->model('user_model');
						$user = $this->user_model->load($user_id);
						if($user){
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
								if( $social['type']=='qq'){ 
									$user['token_qq'] = $social['token'];
								}
							endforeach; 
							$this->session->set_userdata($user);
							redirect(site_url('home')); 
						}else{
							redirect(site_url('login')); 
						}
					}else{
						$data['social'] = array(
									   'token'  => $token,
									   'token_secret'  => '',
									   'name'  => $aResult["nickname"],
									   'link'  => '',
									   'uid' => $openid,
									   'avatar' => $pic,
									   'type' => 'qq'
						);
						if ($this->session->userdata('id')!=null){
							$this->user_social_model->token = $data['social']['token'];
							$this->user_social_model->token_secret = $data['social']['token_secret'];
							$this->user_social_model->social_id = $data['social']['uid'];
							$this->user_social_model->name = $data['social']['name'];
							$this->user_social_model->avatar = $data['social']['avatar'];
							$this->user_social_model->type = $data['social']['type'];
							$this->user_social_model->outlink = $data['social']['link'];
							$this->user_social_model->user_id = $this->session->userdata('id');
							$this->user_social_model->create();
							$this->session->set_userdata('token_qq',1);
							redirect(site_url('account/social')); 
						}else{
							$this->load->view('account/callback',$data); 
						}
					}
					
					
				}else{
					redirect(site_url('login')); 
				}
			}else{
				redirect(site_url('login')); 
			}
		}
	}	
    }	
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}		
}
