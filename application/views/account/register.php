<?php $this->load->view('header') ?>

    <div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="<?=base_url()?>images/icon-x-30-white.png" width="15">
	</a>
</div>



<div id="main" class="site">
<div class="col-about col-about-full under-hero">
	<h1 class="about"><?= $this->lang->line('register_title'); ?></h1>
	<p class="callout">
						            <a class="addthis_login_twitter" href="<?=site_url('login/twitter')?>"><span id="twitter-connect" class="ssi-button"></span></a>
								            <a class="addthis_login_facebook" href="<?=site_url('login/facebook')?>"><span id="facebook-connect" class="ssi-button"></span></a>
								            <a class="addthis_login_weibo" href="<?=site_url('login/sina')?>"><span id="weibo-connect" class="ssi-button"></span></a>
								            <a class="addthis_login_google" href="<?=site_url('login/google')?>"><span id="google-connect" class="ssi-button"></span></a>
								            <!--<a class="addthis_login_behance" href="<?=site_url('login/behance')?>"><span id="behance-connect" class="ssi-button"></span></a>
								            <a class="addthis_login_qq" href="<?=site_url('login/qq')?>"><span id="qq-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_adobe"><span id="adobe-connect" class="ssi-button"></span></a>-->
						</p><br/><br/>
	</div>
	<div class="col-about col-about-full under-hero">
<span id="registerError" class="formErrorContent drop-shadow" style="margin-left:0px;margin-bottom:10px;display:none"><?= $this->lang->line('register_register_error'); ?></span>
<span id="spamError" class="formErrorContent drop-shadow" style="margin-left:0px;margin-bottom:10px;display:none"><?= $this->lang->line('register_spam_error'); ?></span>
<span id="ipError" class="formErrorContent drop-shadow" style="margin-left:0px;margin-bottom:10px;display:none"><?= $this->lang->line('register_ip_error'); ?></span>
<span id="robotError" class="formErrorContent drop-shadow" style="margin-left:0px;margin-bottom:10px;display:none"><?= $this->lang->line('register_robot_error'); ?></span>
<span id="verifierError" class="formErrorContent drop-shadow" style="margin-left:0px;margin-bottom:10px;display:none"><?= $this->lang->line('register_verify_error'); ?></span>
	<h1 class="about"><?= $this->lang->line('register_with_email'); ?></h1>
	<form id="signin_form" accept-charset="UTF-8" action="<?=site_url('register/save')?>" class="gen-form" method="post"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="✓"><input name="authenticity_token" type="hidden" value="grxFTrgfi6jApRb6hC0z7JLvh4PZrCg99Xog6oIWWpw="></div>
	
	<fieldset>
		<label for="login"><?= $this->lang->line('callback_email'); ?></label>
		<input autocapitalize="off" autocorrect="off" class="text-input" id="email_address" name="email_address" tabindex="1" type="text" value="" />
	</fieldset>
	<fieldset>
		<span id="emailError" class="formErrorContent"><?= $this->lang->line('callback_email_error'); ?></span>
	</fieldset>

	<fieldset>
		<label for="password"><?= $this->lang->line('callback_password'); ?></label>
		<input class="text-input" id="register_password" name="password" tabindex="2" type="password" value="" />
	</fieldset>
	<fieldset>
		<span id="passwordError" class="formErrorContent"><?= $this->lang->line('callback_password_error'); ?></span>
	</fieldset>
	<!--
	<fieldset>
		<label for="full_name">Full Name</label>
		<input class="text-input" id="full_name" name="full_name" tabindex="2" type="text" value="">
	</fieldset>
	<fieldset>
		<label></label><span id="nameError" class="formErrorContent drop-shadow">This field is required</span>
	</fieldset>
	
	<fieldset>
		<label for="full_name">Verification Code</label>
		<input class="text-input" id="verifier" name="verifier" tabindex="2" type="text" value="" style="width:30%">
		<img src="<?php echo site_url('register/yzm_img')?>" id="ivrRegisterVerifier" onclick="change_yzm(this)" />
	</fieldset>
	
	<fieldset>
		<label></label><span id="verifierError" class="formErrorContent drop-shadow">This field is required</span>
	</fieldset>
	-->
	<fieldset>
		<label for="consent" style="vertical-align:middle;line-height:30px;"><?= $this->lang->line('callback_stay_informed'); ?> <input type="checkbox" checked name="consent" id="consent"/></label>
		<input class="form-sub" type="button" value="<?= $this->lang->line('register_get_started'); ?>" tabindex="3" onclick="checksignup()">
	</fieldset>
	
	</form>

	</div>
	

</div>

<div class="secondary">

	<h3><?= $this->lang->line('login_follow_effecthub'); ?></span></h3>

<ul class="follow">
		<li class="group"><a href="http://twitter.com/effecthub"><img alt="Twitter" src="<?=base_url()?>images/icon-team-twitter.png"> <?= $this->lang->line('login_effecthub_twitter'); ?></a></li>
		<li class="group"><a href="http://facebook.com/effecthub"><img alt="Facebook" src="<?=base_url()?>images/icon-team-facebook.png"> <?= $this->lang->line('login_effecthub_facebook'); ?></a></li>
		<li class="group"><a href="http://weibo.com/effecthub"><img alt="Weibo" src="<?=base_url()?>images/icon-team-weibo.png"> <?= $this->lang->line('login_effecthub_weibo'); ?></a></li>
	</ul>

</div>


</div>

<script type="text/javascript">
var msg = '<?php echo $error_msg; ?>';
$(document).ready(function() {
	if (msg != 0){
		switch (msg){
			case 'customer' : $('#registerError').css('visibility','visible').css('display','');break;
			case 'spam' : $('#spamError').css('visibility','visible').css('display','');break;
			case 'ip' : $('#ipError').css('visibility','visible').css('display','');break;
			case 'robot' : $('#robotError').css('visibility','visible').css('display','');break;
			case 'verifier' : $('#verifierError').css('visibility','visible').css('display','');break;
			default : break;
		}
	}	
});

function change_yzm(obj)
{

    $(obj).attr('src','<?php echo site_url('register/yzm_img')?>'+'/'+Math.random());
}
</script>    
<?php $this->load->view('footer') ?>
