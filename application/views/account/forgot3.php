<?php $this->load->view('header') ?>
    <div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="<?=base_url()?>images/icon-x-30-white.png" width="15">
	</a>
</div>

<div class="full">
	<h1 class="alt"><?= $this->lang->line('forgot_retrieve'); ?></h1>
</div>

<div id="main" class="site">
<div class="col-about col-about-full under-hero">
<h2 class="section"><?= $this->lang->line('step'); ?></h2>

<p><?= $this->lang->line('forgot_change_password'); ?></p>
<form id="signin_form" style="height:270px;font-size:14px" class="gen-form" method="post" action="<?=site_url('user/reset_password')?>" method="post">
						<fieldset class="user_email">
						<label><?= $this->lang->line('forgot_new_password'); ?></label>
						<input type="password" name="new_password" size="55"/>
						</fieldset>
						<fieldset class="user_email">
						<label><?= $this->lang->line('forgot_confirm_password'); ?></label>
						<input type="password" name="confirm_password" size="55"/>
						</fieldset>
					    <fieldset>
					    <label></label>
					    <input type="hidden" name="uid" value="<?php echo $uid?>"/>
					        <input type="hidden" name="token" value="<?php echo $token?>"/>
					        <input type="submit" id="change_pwd_btn" class="form-sub" value="<?= $this->lang->line('forgot_submit'); ?>">
					        <span id="passwordsuccess" class="formSuccessContent drop-shadow" style="margin-left:0px;margin-bottom:10px;"><?= $this->lang->line('forgot_successful'); ?></span>
					    </fieldset>
					</form>
</div>
</div>

</div>
<?php $this->load->view('footer') ?>