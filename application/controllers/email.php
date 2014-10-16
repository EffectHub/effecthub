<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends CI_Controller {
	
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
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
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
	
	public function index()
	{
		$this->load->model('item_model');
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$this->load->view('about',$data);
	}
	
	public function sendchina()
	{
		$this->load->model('user_model');
		$this->load->model('item_model');
		$this->load->model('email_model');
		$title = '移动游戏分享大赛投票阶段！投票即可赢取游戏开发图书！';
		$content = '<ul style="margin-bottom:0">';
		$content = $content.'<li>想学习移动游戏开发，却苦于没有优秀的中文学习资料？</li>';
		$content = $content.'<li>EffectHub.com与图灵图书合作，举办移动游戏分享大赛！</li>';
		$content = $content.'<li>我们为比赛准备了Kindle阅读器和数十本琳琅满目的图书，包括Cocos2d-x，Unity3D等热门技术相关书籍。</li>';
		$content = $content.'<li>每一个投票者都有机会获取图书！</li>';
		$content = $content.'<li>投票方法：选择你喜欢的游戏，打开然后点击喜欢按钮即可。</li>';
		$content = $content.'<li>投票地址: <a target="_blank" href="http://www.effecthub.com/turing">点击此处</a></li>';
		$content = $content.'<li>我们的QQ群：316012384</li>';
		$content = $content.'</ul>';
		$userlist = $this->user_model->find_users(array('active'=>'1','countryCode'=>'CN'),500,1500);
		//echo $this->email_model->send_notification('binzhu_006@163.com',$title,$content);
		/*foreach ($userlist as $user)
		{
				$is_valid = $this->email_model->send_notification($user['email'],$title,$content);
				if($is_valid=='failed'){
					$this->user_model->email_valid = 0;
					$this->user_model->updatevalid($user['id']);
				}
				echo $user['email'].' '.$is_valid.'<br/>';
		}*/
	}
	
	public function sendall()
	{
		$this->load->model('user_model');
		$this->load->model('item_model');
		$this->load->model('email_model');
		$title = 'Congratulations to winners of Sparticle Particle Effect Contest!';
		$content = '<ul style="margin-bottom:0">';
		$content = $content.'<li>Check out these awesome entries here: <a target="_blank" href="http://www.effecthub.com/contest">http://www.effecthub.com/contest</a></li>';
		$content = $content.'<li>These respective artists will be EffectHub MVP and receive prizes in two month.</li>';
		$content = $content.'<li>All the entries of contest will open for download and fork from today.</li>';
		$content = $content.'<li>Welcome to donate for Sparticle Editor: <a target="_blank" href="http://www.effecthub.com/t/sparticle">Click Here</a></li>';
		$content = $content.'<li>With your support, we can add more features and hold next contest.</li>';
		$content = $content.'</ul>';
		$userlist = $this->user_model->find_users(array('active'=>'1'),200,800);
		//$this->email_model->send_notification('effecthub.com@gmail.com',$title,$content);
		/*foreach ($userlist as $user)
		{
			$this->email_model->send_notification($user['email'],$title,$content);
			echo $user['email'].' send finished <br/>';
		}*/
	}
	
	public function monthly()
	{
		$this->load->model('user_model');
		$this->load->model('item_model');
		$this->load->model('email_model');
		$title = 'Top 3 effects of EffectHub.com in August 2014';
		$itemlist = $this->item_model->find_items(array('in'=>array('12351','12260','12410')));
		$content = '<ul style="margin-bottom:0">';
		foreach ($itemlist as $item)
		{
			$content = $content.'<li><img style="width:30px;height:30px;" src="' .$item['thumb_url'].'"><a href="http://www.effecthub.com/item/'.$item['id'].'" target="_blank"> '.$item['title'].'</a> created by <a href="http://www.effecthub.com/user/'.$item['author_id'].'" target="_blank">'.$item['author_name'].'</a>' .
					' ( '.$item['view_num'].' views '.$item['fav_num'].' appreciations '.$item['comment_num'].' comments )'.
					'</li>';
		}
		$content = $content.'</ul>';
		
		$content = $content.'<h4>These respective artists will be EffectHub MVP:</h4>';
		$content = $content.'<ul style="margin-bottom:0">';
		$content = $content.'<li>Premium features of editor and website will be enabled.</li>';
		$content = $content.'<li>Get invitation to join MVP private group.</li>';
		$content = $content.'<li>Experience for prerelease version.</li>';
		$content = $content.'<li>EffectHub Game Assets Box will upgrade to 10Gb.</li>';
		$content = $content.'</ul>';
		$content = $content.'<h4>Welcome to try out EffectHub Cocos2d-x effect editor: <a target="_blank" href="http://www.effecthub.com/particle2dx">Click Here</a></h4>';
		$userlist = $this->user_model->find_users(array('active'=>'1','verified'=>'0'),1000,7000);
		//$this->email_model->send_notification('flexer@163.com',$title,$content);
		foreach ($userlist as $user)
		{
			$this->email_model->send_notification($user['email'],$title,$content);
			echo $user['email'].' send finished <br/>';
			//sleep(1);
		}
	}
	
	public function confirm()
	{
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
        if (preg_match("/zh-c/i", $lang)||$lang=='cn')
        {
        	$this->lang->load('header','chinese');
        	$this->lang->load('footer','chinese');
        	$this->lang->load('user','chinese');
        	$this->lang->load('account','chinese');
        	$this->lang->load('other','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('user','english');
        	$this->lang->load('account','english');
        	$this->lang->load('other','english');
        }
		$this->load->model('user_model');
		$id = $this->session->userdata('id');
		if($id==null){
			redirect(site_url('home')); 
		}
		$user = $this->user_model->load($id);
		$this->load->model('email_model');
		if($user['token']){
			$url = 'http://www.effecthub.com/user/confirm_email/'.$user['id'].'/'.$user['token'];
		}else{
			$token = create_guid();
			$this->user_model->updateToken($user['id'],$token);
			$url = 'http://www.effecthub.com/user/confirm_email/'.$user['id'].'/'.$token;
		}
		$this->email_model->send_email_confirm($user['email'],$url);
		$this->load->model('item_model');
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$this->load->view('account/email_confirm',$data);
	}	
	
	public function test()
	{
		$this->email->from('message@effecthub.com', 'EffectHub.com');
		$this->email->to('disound@gmail.com'); 
		//$this->email->cc('effecthub.com@gmail.com'); 
		//$this->email->bcc('admin@effecthub.com'); 
		
		$this->email->subject('Welcome to EffectHub.com!');
		//$this->email->message('中文 Testing the email class <a href="http://www.effecthub.com">click</a>.'); 
		$content = '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
		<tbody><tr>
			<td align="center" valign="top">
				
				<table border="0" cellpadding="10" cellspacing="0" width="600">
					<tbody><tr>
						<td valign="top">

							

						</td>
					</tr>
				</tbody></table>
				
				<table border="0" cellpadding="0" cellspacing="0" width="600">
					<tbody><tr>
						<td align="center" valign="top">
							
							<table border="0" cellpadding="0" cellspacing="0" width="600">
								<tbody><tr>
									<td>
										
										<img src="http://www.effecthub.com/title.jpg" style="max-width:600px">
										

									</td>
								</tr>
							</tbody></table>
							
						</td>
					</tr>
					<tr>
						<td align="center" valign="top">
							
							<table border="0" cellpadding="0" cellspacing="0" width="600">
								<tbody><tr>
									<td valign="top">

										
										<table border="0" cellpadding="20" cellspacing="0" width="100%">
											<tbody><tr>
												<td valign="top">
													<div>
														<h1>Welcome to EffectHub.com!</h1>
														<h4>Please confirm your email address.</h4>
														You\'re almost there!  Please click the link below to create your EffectHub.com account.
														<br><br>
														<center><a href="http://www.effecthub/register/36EC41C4-FA3E-32EA-B15FE88C51981875" target="_blank">Confirm my email and create my account! »</a></center>

														<br>
														<p>
															Here are a few things to help you get started:
														</p>
														<ul style="margin-bottom:0">
															<li><a href="http://www.effecthub.com/download" target="_blank">Download EffectHub Editor</a></li>
															<li><a href="http://www.effecthub.com/group" target="_blank">Create group or join group you may interested with</a></li>
														</ul>
													</div>
												</td>
											</tr>
										</tbody></table>
										

									</td>
								</tr>
							</tbody></table>
							
						</td>
					</tr>

					<tr>
						<td align="center" valign="top">
							
							<table border="0" cellpadding="10" cellspacing="0" width="600">
								<tbody><tr>
									<td valign="top">

										<table border="0" cellpadding="10" cellspacing="0" width="100%">
											<tbody><tr>
												<td valign="top">
													<div>
														Having trouble? Please <a href="mailto:support@effecthub.com" target="_blank">email</a>
														or join <a href="http://www.effecthub.com/group/1">EffectHub Group</a>.
													</div>
												</td>
											</tr>
										</tbody></table>

									</td>
								</tr>
							</tbody></table>
							
						</td>
					</tr> 


				</tbody></table>
				<br>
			</td>
		</tr>
	</tbody></table>';
		$this->email->message($content);
		$this->email->send();
		
		echo $this->email->print_debugger();
	}
}
