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
<h2 class="section"><?= $this->lang->line('emailcon_step'); ?></h2>

<p><?= $this->lang->line('forgot_content1'); ?></p>
    
    <form id="signin_form" style="height:270px;font-size:14px" class="gen-form" method="post" action="<?=site_url('user/password')?>" method="post">
						<fieldset class="user_email">
						<label><?= $this->lang->line('forgot_enter_email'); ?></label>
						<input type="text" name="email" size="55"/>
						</fieldset>
					    <fieldset>
					    <label></label>
					        <input type="submit" id="change_pwd_btn" class="form-sub" value="<?= $this->lang->line('forgot_submit'); ?>">
					        <span id="emailError" class="formErrorContent drop-shadow" style="visibility:<?php echo $msg=='invalid'?'visible':'hidden' ?>"><?= $this->lang->line('forgot_email_error'); ?></span>
					    </fieldset>
					</form>
</div>
</div>

</div>
<?php $this->load->view('footer') ?>