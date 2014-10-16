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

	<h1 class="about"><?php echo $social['name']; echo $this->lang->line('callback_last_step'); ?></h1>
	<form id="signin_form" accept-charset="UTF-8" action="<?=site_url('register/save')?>" class="gen-form" method="post"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="✓"><input name="authenticity_token" type="hidden" value="grxFTrgfi6jApRb6hC0z7JLvh4PZrCg99Xog6oIWWpw="></div>
	<span id="loginError" class="formErrorContent drop-shadow" style="margin-left:0px;margin-bottom:10px;"><?= $this->lang->line('callback_error'); ?></span>
	<fieldset>
		<label for="login"><?= $this->lang->line('callback_email'); ?></label>
		<input autocapitalize="off" autocorrect="off" class="text-input" id="email_address" name="email_address" tabindex="1" type="text" value="<?php if(isset($social['email'])){echo $social['email'];}?>">
	</fieldset>
	<fieldset>
		<label></label><span id="emailError" class="formErrorContent drop-shadow"><?= $this->lang->line('callback_email_error'); ?></span>
	</fieldset>

	<fieldset>
		<label for="password"><?= $this->lang->line('callback_password'); ?></label>
		<input class="text-input" id="password" name="password" tabindex="2" type="password" value="">
	</fieldset>
	<fieldset>
		<label></label><span id="passwordError" class="formErrorContent drop-shadow"><?= $this->lang->line('callback_password_error'); ?></span>
	</fieldset>
	
	<fieldset style="display:none">
	<?php if( $social['type']=='sina'||$social['type']=='twitter'||$social['type']=='facebook'){?>
    	<input type="checkbox" checked name="share" id="share">
        <label for="share"><?= $this->lang->line('callback_share'); ?></label>
    	<?php }?>
    </fieldset>
	<fieldset>
		<label for="consent" style="vertical-align:middle;line-height:30px;display:none"><?= $this->lang->line('callback_stay_informed'); ?> <input type="checkbox" checked name="consent" id="consent"/></label>
		<label for=""> </label>
		<input type="hidden" name="token" value='<?php echo $social['token']?>'/>
    <input type="hidden" name="token_secret" value="<?php echo $social['token_secret']?>"/>
    <input type="hidden" name="uid" value="<?php echo $social['uid']?>"/>
    <input type="hidden" name="name" value="<?php echo $social['name']?>"/>
    <input type="hidden" name="avatar" value="<?php echo $social['avatar']?>"/>
    <input type="hidden" name="outlink" value="<?php echo $social['link']?>"/>
    <input type="hidden" name="type" value="<?php echo $social['type']?>"/>
		<input class="form-sub" type="button" value="<?= $this->lang->line('register_get_started'); ?>" tabindex="3" onclick="checksignup()">
	</fieldset>
	
	</form>

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

<script type="text/javascript">
var msg = '<?php echo $error_msg; ?>';
$(document).ready(function() {
	if (msg != 0){
		switch (msg){
			case 'customer' : $('#registerError').css('display','block');break;
			default : break;
		}
	}	
});
</script>    
<?php $this->load->view('footer') ?>
