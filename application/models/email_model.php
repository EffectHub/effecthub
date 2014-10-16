<?php
/**
 * 品牌
 *
 *
 */
class email_model extends CI_Model
{
	
	var $email_header;
													
	var $email_footer;

	function __construct()
    {
        parent::__construct();
        $this->load->library('email');
        $email_header = '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
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
													<div>';
													
	$email_footer = '</div>
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
    }

	// --------------------------------------------------------------------
	function send_reset_password($email,$url)
	{
		$this->email->from('message@effecthub.com', 'EffectHub.com');
		$this->email->to($email); 
		//$this->email->cc('effecthub.com@gmail.com'); 
		//$this->email->bcc('admin@effecthub.com'); 
		$this->email->subject('EffectHub.com Password Reset Notification ('.$email.')');
		$content = $this->email_header.'<h1>Password Reset Notification</h1>
														<h4>Your account info:</h4>
														'.$email.'
														<br><br>
														<center><a href="'.$url.'" target="_blank">Please click here to verify your e-mail and get started →</a></center>

														<br>
														<p>
															Here are a few things to help you get started:
														</p>
														<ul style="margin-bottom:0">
															<li><a href="http://www.effecthub.com/tool" target="_blank">Make your tools social!</a></li>
															<li><a href="http://www.effecthub.com/group" target="_blank">Join group you may interested with</a></li>
														</ul>
													'.$this->email_footer;
		$this->email->message($content);
		$this->email->send();
		//echo $this->email->print_debugger();
	}
	
	function send_email_confirm($email,$url)
	{
		$this->email->from('message@effecthub.com', 'EffectHub.com');
		$this->email->to($email); 
		//$this->email->cc('effecthub.com@gmail.com'); 
		//$this->email->bcc('admin@effecthub.com'); 
		$this->email->subject('EffectHub.com Email Confirmation');
		$content = $this->email_header.'<h1>Welcome to EffectHub.com!</h1>
														<h4>Please confirm your email address.</h4>
														You\'re almost there!  Please click the link below to verify your EffectHub.com account.
														<br><br>
														<center><a href="'.$url.'" target="_blank">Confirm my email and verify my account! »</a></center>

														<br>
														<p>
															Here are a few things to help you get started:
														</p>
														<ul style="margin-bottom:0">
															<li><a href="http://www.effecthub.com/tool" target="_blank">Make your tools social!</a></li>
															<li><a href="http://www.effecthub.com/group" target="_blank">Join group you may interested with</a></li>
														</ul>
													'.$this->email_footer;
		$this->email->message($content);
		$this->email->send();
		//echo $this->email->print_debugger();
	}
	
	function send_notification($email,$title,$content)
	{
		$this->email->clear();
		
		$this->email->from('message@effecthub.com', 'EffectHub.com');
		$this->email->to($email); 
		$this->email->subject($title);
		$content = $this->email_header.'<h1>'.$title.'</h1>
														<h4>Content:</h4>
														'.$content.'
														<br><br>
														<center><a href="'.'http://www.effecthub.com/login'.'" target="_blank">Log in EffectHub.com to view detail information »</a></center>

														<br>
														<p>
															Here are a few things to help you get started:
														</p>
														<ul style="margin-bottom:0">
															<li><a href="http://www.effecthub.com/tool" target="_blank">Make your tools social!</a></li>
															<li><a href="http://www.effecthub.com/group" target="_blank">Join group you may interested with</a></li>
														</ul>
													'.$this->email_footer;
		$this->email->message($content);
		if ( ! $this->email->send())
		{
		    return 'failed';
		}else{
			return 'success';
		}
		//echo $this->email->print_debugger();
	}
	
	function send_welcome($email,$url)
	{
		$this->email->from('message@effecthub.com', 'EffectHub.com');
		$this->email->to($email); 
		//$this->email->cc('effecthub.com@gmail.com'); 
		//$this->email->bcc('admin@effecthub.com'); 
		$this->email->subject('Welcome to EffectHub.com!');
		$content = $this->email_header.'<h1>Welcome to EffectHub.com!</h1>
														<h4>EffectHub is a social network to connect the world\'s gaming artists and developers to enable them to be more productive and successful.</h4>
														Now you\'re almost there!  Please click the link below to create your EffectHub.com account.
														<br><br>
														<center><a href="'.$url.'" target="_blank">Confirm my email and create my account! »</a></center>

														<br>
														<p>
															Here are a few things to help you get started:
														</p>
														<ul style="margin-bottom:0">
															<li><a href="http://www.effecthub.com/tool" target="_blank">Make your tools social!</a></li>
															<li><a href="http://www.effecthub.com/group" target="_blank">Join group you may interested with</a></li>
														</ul>
													'.$this->email_footer;
		$this->email->message($content);
		$this->email->send();
		//echo $this->email->print_debugger();
	}
}
