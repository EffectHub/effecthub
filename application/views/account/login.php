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

	<h1 class="about"><?= $this->lang->line('login_with_email'); ?></h1>
	<form id="signin_form" accept-charset="UTF-8" action="<?=site_url('login/check')?>" class="gen-form" method="post"><div style="margin:0;padding:0;display:inline"></div>
	<fieldset>
		<label for="login"><?= $this->lang->line('login_email'); ?></label>
		<input autocapitalize="off" autocorrect="off" class="text-input" id="email" name="email" tabindex="1" type="text" value="">
	</fieldset>
	<fieldset>
		<span id="emailError" class="formErrorContent"><?= $this->lang->line('login_email_error'); ?></span>
	</fieldset>

	<fieldset>
		<label for="password"><?= $this->lang->line('login_password'); ?> <a href="<?=site_url('user/forgot')?>"><?= $this->lang->line('login_forgot'); ?></a></label>
		<input class="text-input" id="password" name="password" tabindex="2" type="password" value="">
	</fieldset>
	<fieldset>
		<span id="passwordError" class="formErrorContent"><?= $this->lang->line('login_password_error'); ?></span>
	</fieldset>
	<fieldset>
		<label for="remember_me" style="vertical-align:middle;line-height:30px;"><?= $this->lang->line('login_remember'); ?> <input type="checkbox" checked name="remember_me" id="remember_me"/></label>
		<input class="form-sub" type="button" value="<?= $this->lang->line('login_sign_in'); ?>" tabindex="3" onclick="checklogin()">
	</fieldset>
	<input type="hidden" name="redirectURL" value="<?=$redirectURL?>"/>
	</form>

	</div>
	<div class="col-about col-about-full under-hero">
	<h1 class="about"><?= $this->lang->line('login_other_services'); ?></h1>
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

</div>

<div class="secondary">

	<h3><?= $this->lang->line('login_follow_effecthub'); ?></h3>

<ul class="follow">
		<li class="group"><a href="http://twitter.com/effecthub"><img alt="Twitter" src="<?=base_url()?>images/icon-team-twitter.png"> <?= $this->lang->line('login_effecthub_twitter'); ?></a></li>
		<li class="group"><a href="http://facebook.com/effecthub"><img alt="Facebook" src="<?=base_url()?>images/icon-team-facebook.png"> <?= $this->lang->line('login_effecthub_facebook'); ?></a></li>
		<li class="group"><a href="http://weibo.com/effecthub"><img alt="Weibo" src="<?=base_url()?>images/icon-team-weibo.png"> <?= $this->lang->line('login_effecthub_weibo'); ?></a></li>
	</ul>

</div>


</div>
<script src="<?=base_url()?>js/settings.js"></script>

<script type="text/javascript">
var msg = '<?php echo $error_msg; ?>';
$(document).ready(function() {
	if (msg != 0){
		switch (msg){
			case 'customer' : 
				$('#passwordError').css('visibility','visible');
				$('#passwordError').html('<?= $this->lang->line('login_mismatch'); ?>');
				break;
			default : break;
		}
	}
	$('#password').keydown(function(e) {
	 if (e.keyCode == 13) {
	     checklogin();
	 }
	});
});
</script>
<?php $this->load->view('footer') ?>
