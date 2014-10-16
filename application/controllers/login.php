<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once( APPPATH.'/libraries/behance/config.php' );
require_once( APPPATH.'/libraries/behance/Api.php' );
require_once( APPPATH.'/libraries/facebook/Facebook.php' );
require_once( APPPATH.'/libraries/twitter/config.php' );
require_once( APPPATH.'/libraries/twitter/Twitter.php' );
include_once( APPPATH.'/libraries/weibo/config.php' );
include_once( APPPATH.'/libraries/weibo/SaeTOAuthV2.php' );
include_once( APPPATH.'/libraries/google/Google_Client.php' );
include_once( APPPATH.'/libraries/qq/config.php' );
include_once( APPPATH.'/libraries/sso/config.php');
include_once( APPPATH.'/libraries/sso/function.php');
class Login extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('rest');
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
        
       
	
    }
	
	public function index()
	{
		if ($this->session->userdata('id')) {
			redirect('home');
		}
		/*if ($this->session->userdata('id')==null) {
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
        } */
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$redirectURL = $this->input->get('redirectURL');
		$data['redirectURL'] = $redirectURL;
		$this->load->model('item_model');
		$data['error_msg'] = $this->uri->segment(3, 0);
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$this->load->view('account/login',$data);
	}
	
	public function check()
	{
		
		$redirectURL = $this->input->post('redirectURL');
		$this->load->model('user_model');
		$this->load->model('user_social_model');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$remember = $this->input->post('remember_me');
		$this->user_model->email = $email;
		$this->user_model->password = $password;
		$user = $this->user_model->check_user();
		if($user){
			$id = $user['id'];
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
					$user['sina_id'] = $social['social_id'];
					$user['token_sina'] = $social['token'];
				}	
				if( $social['type']=='google'){ 
					$user['google_id'] = $social['social_id'];
					$user['token_google'] = $social['token'];
				}
				if( $social['type']=='behance'){ 
					$user['token_behance'] = $social['token'];
				}
			endforeach; 
			if($remember){
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
            }
			$this->session->set_userdata($user);
			$group = array();
			if($user['name']=='disound'||$user['name']=='zhonghcc'){
				$group = array('admin');
			}else{
				$group = array('user');
			}
			encodeCookie($user['id'],$user['name'],$user['displayName'],
			$user['email'],array('user','admin'));
			

			// judge whether this login is the first login of this day
			//$user = $this->user_model->load($id);
			$now_date = date('Y-m-d');
			$last_login_date = date('Y-m-d',strtotime($user['last_login_time']));
				
			if ($last_login_date != $now_date){
				$cookie = array(
						'name'   => 'first_login',
						'value'  => 1,
						'expire' => '300',
				);
				set_cookie($cookie);
			
				//$this->load->model('user_model');
				//$user = $this->user_model->load($id);
				$user_point = $user['point'] + 1;
				$this->user_model->update_point($id,$user_point);
			}
			
			$this->user_model->update_last_login($id);
			$this->user_model->update_last_ip($id);
			
			$this->load->model('user_notice_model');
			
			$notice_count = $this->user_notice_model->find_unread_count($id);
			$this->session->set_userdata('notice_count',$notice_count);
			$this->load->model('user_mail_model');
			$mail_count =$this->user_mail_model->find_unread_count($id);
			$this->session->set_userdata('mail_count',$mail_count);
			$user = $this->user_model->load($id);
			
			$this->session->set_userdata('point',$user['point']);
			$this->session->set_userdata('language',$user['language']);
				
			$this->load->model('team_notice_model','t_notice');
			$team_notice = count($this->t_notice->load(array('user_id'=>$this->session->userdata('id'),'read'=>0),0,0,0));
			$this->session->set_userdata('team_notice',$team_notice);
			
			$this->session->set_userdata('item_notice',2);
			if($redirectURL){
				//redirect($redirectURL); 
				echo '<script language="JavaScript">window.top.location.href="'.$redirectURL.'"</script>;';
			}else{
	        	/*if($user['pic_url']=='http://www.effecthub.com/images/blank.jpg'){
	        		redirect(site_url('account/settings')); 
	        	}else{*/
					redirect(site_url('home/suggestion')); 
	        	//}
			}
		}else{
			redirect('login/index/customer');
		}
	}
	
	public function behance()
	{
		$api = new Be_Api( BE_AKEY , BE_SKEY );
		$scope = array(0=>"collection_write",1=>"wip_write");
	    $api->authenticate( BE_CALLBACK_URL, $scope);
	}
	
	public function twitter()
	{
		$api = new Twitter( TT_AKEY , TT_SKEY );
		$response = $api->oAuthRequestToken( TT_CALLBACK_URL);
		$api->oAuthAuthorize($response['oauth_token']);
	}
	
	public function sina()
	{
		$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
	    $code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
	    redirect($code_url);
	}
	
	public function facebook()
	{
		$api = new Facebook(array());
		$userId = $api->getUser();

		// If user is not yet authenticated, the id will be zero
		if($userId == 0){
			// Generate a login url
// 			print $api->getLoginUrl(array('scope'=>'email,read_stream,create_note,export_stream,publish_actions,publish_stream,share_item,status_update'));
			redirect($api->getLoginUrl(array('scope'=>'email,read_stream,create_note,export_stream,publish_actions,publish_stream,share_item,status_update'))); 
		} else {
			// Get user's data and print it
			$user = $this->facebook->api('/me');
			print_r($user);
		}
	}
	
	public function google()
	{
		$client = new Google_Client();
		$scope = array(
              'https://www.googleapis.com/auth/userinfo.profile',
              'https://www.googleapis.com/auth/userinfo.email',
				"https://www.google.com/m8/feeds/",
          );
		$client->setScopes($scope);
		$authUrl = $client->createAuthUrl();
		redirect($authUrl);
	}
	
	public function qq()
	{
		$sUri = "http://www.effecthub.com/callback/qq";
	    $_SESSION["URI"] = $sUri;
	    $aParam = array(
	    	"response_type"    => "code",
	    	"client_id"        =>    QQ_AKEY,
	    	"redirect_uri"    =>    $sUri,
	    	"scope"            =>   QQ_SCOPE,
	    );
	    $aGet = array();
	    foreach($aParam as $key=>$val){
	        $aGet[] = $key."=".urlencode($val);
	    }
	    $sUrl = "https://graph.qq.com/oauth2.0/authorize?";
	    $sUrl .= join("&",$aGet);
	    header("location:".$sUrl);
	}
	
	public function logout()
	{
		//if(isset($_COOKIE["ci_session"]) && !empty($_COOKIE["ci_session"])){
		//	SetCookie("ci_session", false, time()+ (365 * 24 * 60 * 60),'/','www.effecthub.com');
		//}
		$this->session->sess_destroy();
		
		//delete_cookie("effecthubcookie");
		
		delete_cookie('effecthub_user');
		delete_cookie('effecthub_password');
		delete_cookie('effecthub_user','.effecthub.com');
		delete_cookie('effecthub_password','.effecthub.com');
		deleteSSOCookie();
		redirect('login');
	}

	public function autocheck($id,$password,$url)
	{
		$this->load->model('user_model');
		$this->user_model->id = $id;
		$this->user_model->password = $password;
		$user = $this->user_model->check_user_login();
		
	}
	
}
