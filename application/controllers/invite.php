<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once( APPPATH.'/libraries/facebook/Facebook.php' );
require_once( APPPATH.'/libraries/twitter/config.php' );
require_once( APPPATH.'/libraries/twitter/Twitter.php' );
include_once( APPPATH.'/libraries/google/Google_Client.php' );
include_once( APPPATH.'/libraries/weibo/config.php' );
include_once( APPPATH.'/libraries/weibo/SaeTOAuthV2.php' );
class Invite extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		
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
        	$this->lang->load('user','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('user','english');
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
	
	
	public function index(){
		if ($this->session->userdata ( 'sina_id' )) {
			redirect(site_url('invite/weibo'));
		}else if ($this->session->userdata ( 'twitter_id' )) {
			redirect(site_url('invite/twitter'));
		}else if ($this->session->userdata ( 'google_id' )) {
			redirect(site_url('invite/google'));
		}else {
			redirect(site_url('invite/email'));
		}
	}
	
	public function email($first = null){
		if (! $this->session->userdata ( 'id' )) {
			redirect ( 'login' );
			exit ();
		}
		
		$this->load->model('group_model');
		$this->load->model('group_type_model');
		//$data ['group_type_list'] = $this->group_type_model->find_group_types ( array (), 100, 0 );
		$data ['hot_groups'] = $this->group_model->find_groups ( array (
				'rand' => '1'
		), 5, 0 );
		$data['first']=$first;
		$data['type']='email';
		$this->load->view ( 'user/user_invite', $data );
	}
	
	public function weibo($first = null){
		if (! $this->session->userdata ( 'id' )) {
			redirect ( 'login' );
			exit ();
		}
		
		$this->load->model('user_model');
		$token = $this->session->userdata('token_sina');
		$userId = $this->session->userdata('sina_id');
		if($token==null||$userId==null){
			$data ['following_list'] = array();
			$data ['friends_list'] = array();
		}else{
			$api = new SaeTClientV2( WB_AKEY , WB_SKEY , $token );
			
			try {
				$getFriends = $api->bilateral($userId);
				$getFriends = $getFriends['users'];
			} catch (Exception $e) {
				print '<script>alert("Load weibo follower error! It\'s possible that the token is out of date. Please link your account with Weibo again.");location.href="'.site_url('home').'"</script>';
				return;
			}
			
			$friends = array();
			$possiblefriends = array();
			if($getFriends!=null){
				foreach ($getFriends as $item){
					$oneFriend['pic_url']=$item['profile_image_url'];
					$oneFriend['displayName']=$item['name'];
					$oneFriend['id']=$item['id'];
					$oneFriend['weibo_id']=$item['status']['id'];
					$oneFriend['screen_name']=$item['domain'];
					$oneFriend['is_in']=0;
					$friend = $this->user_model->loadBySocial($item['id']);
					if(count($friend)>0){
						$oneFriend['is_in']=1;
						array_push($possiblefriends,$friend);
					}
					
					array_push($friends,$oneFriend);
					
				}
			}
			$data ['following_list'] = $friends;
			$data ['friends_list'] = $possiblefriends;
		}
		
		$this->load->model('group_model');
		$this->load->model('group_type_model');
		$data ['hot_groups'] = $this->group_model->find_groups ( array (
				'rand' => '1'
		), 5, 0 );
		$data['first']=$first;
		$data['type']='weibo';
		$this->load->view ( 'user/user_invite', $data );
	}
	
	public function twitter($first = null){
		if (! $this->session->userdata ( 'id' )) {
			redirect ( 'login' );
			exit ();
		}
		
		$this->load->model('user_model');
		$token = $this->session->userdata('token_twitter');
		$tokenSecret = $this->session->userdata('token_secret_twitter');
		$userId = $this->session->userdata('twitter_id');
		if($token==null||$tokenSecret==null||$userId==null){
			$data ['following_list'] = array();
			$data ['friends_list'] = array();
		}else{
			$api = new Twitter( TT_AKEY , TT_SKEY );
			$api->setOAuthToken($token);
			$api->setOAuthTokenSecret($tokenSecret);
			
			try {
				$getFriends = $api->followersList($userId);
				$getFriends = $getFriends['users'];
			} catch (Exception $e) {
				print '<script>alert("Load twitter follower error! It\'s possible that the token is out of date. Please link your account with Twitter again.");location.href="'.site_url('home').'"</script>';
				return;
			}
			// 		$getFriends = $api->friendsList($userId)['users'];
			// 		print_r($getFriends[0]);
			$friends = array();
			$possiblefriends = array();
			if($getFriends!=null){
				foreach ($getFriends as $item){
					$oneFriend['pic_url']=$item['profile_image_url'];
					$oneFriend['displayName']=$item['name'];
					$oneFriend['id']=$item['id'];
					$oneFriend['screen_name']=$item['screen_name'];
					$oneFriend['is_in']=0;
					$friend = $this->user_model->loadBySocial($item['id']);
					if(count($friend)>0){
						$oneFriend['is_in']=1;
						array_push($possiblefriends,$friend);
					}
					array_push($friends,$oneFriend);
					
				}
			}
			$data ['following_list'] = $friends;
			$data ['friends_list'] = $possiblefriends;
		}
		
		$this->load->model('group_model');
		$this->load->model('group_type_model');
		//$data ['group_type_list'] = $this->group_type_model->find_group_types ( array (), 100, 0 );
		$data ['hot_groups'] = $this->group_model->find_groups ( array (
				'rand' => '1'
		), 5, 0 );
		$data['first']=$first;
		$data['type']='twitter';
		$this->load->view ( 'user/user_invite', $data );
	}
	
	public function google($first = null){
		if (! $this->session->userdata ( 'id' )) {
			redirect ( 'login' );
			exit ();
		}
		$this->load->model('user_model');
		$token = $this->session->userdata('token_google');
		$userId = $this->session->userdata('google_id');
// 		print $token;
// 		print $userId;
		if($token==null||$userId==null){
			//print '<script>alert("You have to login with google first");location.href="'.site_url('login/google').'"</script>';
			//return;
			$data ['following_list'] = array();
			$data ['friends_list'] = array();
		}else{
			$api = new Google_Client();
			$scope = array(
					'https://www.googleapis.com/auth/userinfo.profile',
					'https://www.googleapis.com/auth/userinfo.email',
					'https://www.google.com/m8/feeds/',
			);
			try {
				$api->setScopes($scope);
				$api->setAccessToken($token);
				$req = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/default/full?max-results=250");
				$val = $api->getIo()->authenticatedRequest($req);
				
				  $response = json_encode(simplexml_load_string($val->getResponseBody()));  
				  $nameArray = array();  
				  $responseArray = json_decode($response, true);  
				  if (isset($responseArray["entry"])){  
				    $entry = $responseArray["entry"];  
				    foreach ($entry as $item){  
				        if(isset($item["title"])&&!is_array($item["title"])){  
				            array_push($nameArray,$item["title"]);  
				        }else {  
				            array_push($nameArray,"##");  
				        }  
				    }  
				  }
				//	print $val->getResponseBody();
				// The contacts api only heturns XML responses.
				//print_r($val->getResponseBody());
				//$q   = json_encode(simplexml_load_string($val->getResponseBody()));
				//print_r($q);
				//print "<pre>" . print_r(json_decode($q, true), true) . "</pre>";
				//$getFriends = json_decode($q, true);
				//$getFriends = $getFriends['entry'];
				//$getFriends = simplexml_load_string($val->getResponseBody());
				//$search=array('<gd:','</gd:');
				//$replace=array('<gd','</gd');
				/*Create json object from $google_contacts(atom xml string)
				by replacing "gd:" to "gd"*/
				//$response = json_encode(str_replace($search, $replace,$val->getResponseBody()));
				//$getFriends = json_decode($response, true);
				//$getFriends = $getFriends['entry'];
				  $emailArray = array();  
				  $xml=  new SimpleXMLElement($val->getResponseBody());  
				  $xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');  
				  $result = $xml->xpath('//gd:email');  
				  foreach ($result as $title) {  
				     $email = $title->attributes()->address;  
				     if (!empty($email)){  
				         array_push($emailArray,$email."");  
				     }  
				  }
		
			} catch (Exception $e) {
				print '<script>alert("Load google contacts error! It\'s possible that the token is out of date. Please link your account with Google again.");location.href="'.site_url('login/google').'"</script>';
				return;
			}
			
			$friends = array();
			$possiblefriends = array();
			if($emailArray!=null){
				for ($i=0;$i<count($emailArray);$i++){  
				      $user = array();  
				      $name = "##";  
				      $email = $emailArray[$i];
				      if($email=='') continue;
				      if ($name == "##"){  
				        $name = strstr($email, '@', true);   
				      }  
				      $user["displayName"] = $name;  
				      $user["email"] = $email;  
				      $user['pic_url']='http://www.effecthub.com/images/social/googleplus.png';
					  $user['id']=$i;
					  $user['is_in']=0;
					  $user['screen_name']=$email;
						$friend = $this->user_model->loadByEmail($email);
						if(count($friend)>0){
							$user['is_in']=1;
							array_push($possiblefriends,$friend);
						}
				      array_push($friends,$user);  
				      
				  }
				/*foreach ($getFriends as $item){
					$oneFriend = array();
					foreach ($item as $key => $value) { 
				          switch ($key) {
				            case 'title':
				            	$oneFriend['displayName']=$value;
              					break;
				          }
					}
					$gd = $item->children('gd', true);
					$oneFriend['displayName']=$gd->email['address'];
              	    $oneFriend['phoneNumber']=$gd->phoneNumber;	
              	    
              	    $oneFriend['displayName']=$item['title'];
              	    $oneFriend['email']=$item['gdemail'];
					$oneFriend['pic_url']='';
					$oneFriend['id']=$item['id'];
					$oneFriend['screen_name']='';
					array_push($friends,$oneFriend);
				}*/
			}
			$data ['following_list'] = $friends;
			$data ['friends_list'] = $possiblefriends;
		}
		
		$this->load->model('group_model');
		$this->load->model('group_type_model');
		//$data ['group_type_list'] = $this->group_type_model->find_group_types ( array (), 100, 0 );
		$data ['hot_groups'] = $this->group_model->find_groups ( array (
				'rand' => '1'
		), 5, 0 );
		$data['first']=$first;
		$data['type']='google';
		$this->load->view ( 'user/user_invite', $data );
	}

	
	public function send_invite($type) {
		if($type=='twitter'){
			$ids = $this->input->post('uid');
			$first = $this->input->post('first');
			$token = $this->session->userdata('token_twitter');
			$tokenSecret = $this->session->userdata('token_secret_twitter');
			$userId = $this->session->userdata('social_id');
			$api = new Twitter( TT_AKEY , TT_SKEY );
			$api->setOAuthToken($token);
			$api->setOAuthTokenSecret($tokenSecret);
			$msg = $this->input->post('desc');
			// 		$msg = urlencode($msg);
			for($i = 0; $i < count ( $ids ); $i ++) {
				if ($ids [$i] != '') {
					$api->directMessagesNew($ids[$i],'',$msg);
				}
			}
			print '<script>alert("You have sent message successfully");</script>';
			if($first!=null&&$first!=''){
				redirect(site_url('account/settings'));
				print '<script>location.href="'.site_url('account/settings').'"</script>';
			}else{
				print '<script>location.href="'.site_url('home').'"</script>';
			}
		}else if($type=='weibo'){
			$ids = $this->input->post('uid');
			$first = $this->input->post('first');
			$token = $this->session->userdata('token_sina');
			$userId = $this->session->userdata('sina_id');
			$api = new SaeTClientV2( WB_AKEY , WB_SKEY , $token );
			$msg = $this->input->post('desc');
			// 		$msg = urlencode($msg);
			$url = 'http://www.effecthub.com/register';
			for($i = 0; $i < count ( $ids ); $i ++) {
				if ($ids [$i] != '') {
					$api->send_comment($ids[$i],$msg.$url);
				}
			}
			print '<script>alert("You have sent message successfully");</script>';
			if($first!=null&&$first!=''){
				redirect(site_url('account/settings'));
				print '<script>location.href="'.site_url('account/settings').'"</script>';
			}else{
				print '<script>location.href="'.site_url('home').'"</script>';
			}
		}else if($type=='google'){
			$this->load->model('email_model');
        	$this->load->model('user_model');
        	$first = $this->input->post('first');
			$emails = $this->input->post('uid');
			$msg = $this->input->post('desc');
			$user = $this->user_model->load($this->session->userdata('id'));
	        $title = $this->session->userdata('displayName').' has sent you a invitation on EffectHub.com';
	        $url = 'http://www.effecthub.com/register';
	        $content = $this->input->post('desc').' <a href="'.$url.'" target="_blank">'.$url.'</a>';
			for($i = 0; $i < count ( $emails ); $i ++) {
				if ($emails [$i] != '') {
					$this->email_model->send_notification($emails[$i],$title,$content);
				}
			}
			print '<script>alert("You have sent message successfully");</script>';
			if($first!=null&&$first!=''){
				redirect(site_url('account/settings'));
				print '<script>location.href="'.site_url('account/settings').'"</script>';
			}else{
				print '<script>location.href="'.site_url('home').'"</script>';
			}
		}else if($type=='email'){
			$this->load->model('email_model');
        	$this->load->model('user_model');
			$first = $this->input->post('first');
			$emails = $this->input->post('uid');
			$msg = $this->input->post('desc');
			$user = $this->user_model->load($this->session->userdata('id'));
	        $title = $this->session->userdata('displayName').' has sent you a invitation on EffectHub.com';
	        $url = 'http://www.effecthub.com/register';
	        $content = $this->input->post('desc').' <a href="'.$url.'" target="_blank">'.$url.'</a>';
			for($i = 0; $i < count ( $emails ); $i ++) {
				if ($emails [$i] != '') {
					$this->email_model->send_notification($emails[$i],$title,$content);
				}
			}
			print '<script>alert("You have sent message successfully");</script>';
			if($first!=null&&$first!=''){
				redirect(site_url('account/settings'));
				print '<script>location.href="'.site_url('account/settings').'"</script>';
			}else{
				print '<script>location.href="'.site_url('home').'"</script>';
			}
		}
	}
}

?>