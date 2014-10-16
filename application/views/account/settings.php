<?php $this->load->view('header') ?>
<div id="content" class="group">
	<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="<?=base_url()?>js/jquery.leanModal.min.js"></script>

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png" width="15">
	</a>
</div>


<div class="group">
	<div class="full">
		<h1 class="alt"><?= $this->lang->line('settings_settings'); ?>
                        <span class="sep"></span></h1>
		<p><?= $this->lang->line('settings_settings_slogan'); ?></p>
	</div>
</div>



<div id="main">

<div id="idtabs"> 
  <div class="apps-type"> 	
<ul class="tabs">
	<li><a href="#profile" class="selected"><?= $this->lang->line('settings_profile'); ?></a></li>
	<li><a href="#password"><?= $this->lang->line('settings_password'); ?></a></li>
	<li><a href="#notifications"><?= $this->lang->line('settings_notification'); ?></a></li>
	<div style="float:right;padding-bottom:5px">
	<a class="form-sub tagline-action" style="margin-bottom:5px" href="<?php echo site_url('account/social')?>"><?= $this->lang->line('settings_social'); ?></a>
	</div>
</ul>
</div>

	<div class="session-form alt" id="profile">
		<form accept-charset="UTF-8" class="gen-form with-messages" id="signin_form" method="post">	
			<div class="form-field">
				<fieldset class="user_name">
					<label for="user_name"><?= $this->lang->line('settings_display_name'); ?></label>
					<input id="full_name" name="displayName" value="<?php echo $user['displayName']; ?>" size="30" type="text">
				</fieldset>
				<p class="message" id="display-message" style="border-radius:3px;width:57%;padding:5px;"><?= $this->lang->line('settings_display_name_slogan'); ?></p>
			</div>

			<div class="form-field">
				
				<fieldset class="user_login">
					<label for="user_login"><?= $this->lang->line('settings_user_name'); ?></label>
					<input autocapitalize="off" autocorrect="off" id="user_name" label="Username" value="<?php echo $user['name']; ?>" name="urlname" size="30" type="text">
				</fieldset>
				<p class="message" id="user-message" style="border-radius:3px;width:57%;padding:5px;">
					<?= $this->lang->line('settings_user_name_slogan'); ?><strong><span id="username"><?php echo $user['name']; ?></span></strong>
				</p>
			</div>
			
<div class="form-field">
	<fieldset class="user_location">
		<label for="country"><?= $this->lang->line('settings_country'); ?></label>
		<select id="country" class="support-select" name="country" required="required">
    <option value=""><?= $this->lang->line('settings_select'); ?></option>
	<?php foreach($country_list as $_country): ?>
						<option value="<?php echo $_country['key']; ?>" <?php echo $_country['key']==$user['countryCode']?'selected="selected"':'';?>><?php echo $_country['full_name']; ?></option>
                        <?php endforeach; ?>
            </select>
	</fieldset>
	</fieldset>
</div>


<div class="form-field">
	<fieldset class="user_url"><label for="user_url"><?= $this->lang->line('settings_website'); ?></label><input id="user_url" label="Your Website" name="homepage" value="<?php echo $user['homepage']; ?>" size="30" type="text"></fieldset>
	<p class="message"><?= $this->lang->line('settings_website_slogan'); ?></p>
</div>

<div class="form-field form-field-bio">
	<fieldset class="user_bio"><label for="user_bio"><?= $this->lang->line('settings_description'); ?></label><textarea class="bio" cols="40" id="user_bio" label="Bio" name="desc" rows="20"><?php echo $user['desc']; ?></textarea><span class="counter"></span></fieldset>
	<p class="message"><?= $this->lang->line('settings_description_slogan'); ?></p>
</div>


			<div class="form-btns" style="margin-bottom:20px;">
				<a href="javascript:" id="save_settings" class="form-sub" name="commit"><?= $this->lang->line('settings_update_settings'); ?></a>
			</div>
			<p class="message" id="save-settings-message" style="display:none;border-radius:3px;width:57%;padding:5px;color:#eee;background:#0a0;font-weight:bold;"><?= $this->lang->line('settings_saving_settings_successfully'); ?></p>
</form>	</div>



<div class="session-form alt" id="password">
<?php if ($user['password']!=null&&$user['password']!=''){  ?>
		<form accept-charset="UTF-8" class="gen-form with-messages" id="signin_form" method="post">	

			<div class="form-field">
<fieldset class="user_name"><label for="user_name"><?= $this->lang->line('settings_current_password'); ?></label><input id="current_password" name="old_password" value="" size="30" type="password"></fieldset>
<p class="message" id="c-password-message" style="visibility:hidden;border-radius:3px;width:57%;padding:5px;font-weight:bold;"><?= $this->lang->line('settings_current_password_error'); ?></p>
</div>

<fieldset id="set_password">
			<div class="form-field">
				<label for="user_login"><?= $this->lang->line('settings_new_password'); ?></label>
				<input autocapitalize="off" autocorrect="off" id="new_password" label="Username" value="" name="new_password" size="30" type="password">
			</div>
			<p class="message" id="n-password-message" style="visibility:hidden;border-radius:3px;width:57%;padding:5px;color:#e00;font-weight:bold;"><?= $this->lang->line('settings_new_password_error'); ?></p>
			<div class="form-field">
				<fieldset class="user_email"><label for="user_email"><?= $this->lang->line('settings_confirm_password'); ?></label><input id="confirm_password" label="Email" name="confirm_password" size="30" type="password" value=""></fieldset>			
			</div>
</fieldset>
			<div class="form-btns" style="margin-bottom:20px;">
				<a href="javascript:" id="change_password" class="form-sub" name="commit"><?= $this->lang->line('settings_change_password'); ?></a>
			</div>
			<p class="message" id="save-password" style="display:none;border-radius:3px;width:57%;padding:5px;color:#eee;font-weight:bold;"></p>
			
</form>
<?php  }else{?>
		<form accept-charset="UTF-8" action="<?=site_url('account/settings/initPassword')?>" class="gen-form with-messages" id="signin_form" method="post">	

			<div class="form-field">
				
<fieldset class="user_login"><label for="user_login"><?= $this->lang->line('settings_set_password'); ?></label><input autocapitalize="off" autocorrect="off" id="user_login" label="Username" value="" name="new_password" size="30" type="password"></fieldset>
<p class="message">
</p>
			</div>

			<div class="form-btns">
				<input class="form-sub" name="commit" type="submit" value="<?= $this->lang->line('settings_set_a_password'); ?>">
			</div>
</form>	
<?php  }?>
	</div>


<div class="session-form alt" id="notifications" style="color:#000;padding-left:20px">
		<form accept-charset="UTF-8" class="gen-form plain" id="signin_form" method="post">	
			<h2><?= $this->lang->line('settings_would_like'); ?></h2>
			<fieldset>
					<label>
						<input type="checkbox" <?php echo $user['consent']=='on'?'checked':'' ?> name="consent" id="consent" style="">
						<?= $this->lang->line('settings_stay_informed'); ?>
					</label>
			</fieldset>
			<br/>
			<h2><?= $this->lang->line('settings_email_me'); ?></h2>
			<fieldset>
					<label>
						<input type="checkbox" <?php echo $user['noti_message']=='on'?'checked':'' ?> name="message" id="notimessage" style="">
						<?= $this->lang->line('settings_send_message'); ?>
					</label>
			</fieldset>
			<fieldset>
					<label>
						<input type="checkbox" <?php echo $user['noti_followme']=='on'?'checked':'' ?> name="followme" id="followme" style="">
						<?= $this->lang->line('settings_follow_me'); ?>
					</label>
			</fieldset>
			<fieldset>
					<label>
						<input type="checkbox" <?php echo $user['noti_invite']=='on'?'checked':'' ?> name="invite" id="invite" style="">
						<?= $this->lang->line('settings_invite_me'); ?>
					</label>
			</fieldset>
			<fieldset>
					<label>
						<input type="checkbox" <?php echo $user['noti_comment']=='on'?'checked':'' ?> name="comment" id="comment" style="">
						<?= $this->lang->line('settings_comment_me'); ?>
					</label>
			</fieldset>

			<div class="form-btns" style="margin-bottom:20px;">
				<a href="javascript:" id="notice_setting" class="form-sub" name="commit"><?= $this->lang->line('settings_save'); ?></a>
				<p class="message" id="notice-settings-message" style="display:none;border-radius:3px;width:57%;padding:5px;color:#eee;font-weight:bold;"><?= $this->lang->line('settings_saving_notice_successfully'); ?></p>
			</div>
			
</form>	</div>



</div>

</div>

<div class="secondary">
	<h3><?= $this->lang->line('settings_avatar'); ?></h3>

	<div id="avatar-preview" class="group">
		<form accept-charset="UTF-8" action="<?=site_url('account/settings/avatar')?>" class="edit_user" id="delete-avatar-form" method="post">
					<div data-picture="" data-alt="<?php echo $user['displayName']; ?>" data-class="photo">
	
<img alt="<?php echo $user['displayName']; ?>" class="photo" src="<?php echo $user['pic_url']; ?>"></div>
			
			
</form>
		<form accept-charset="UTF-8" action="<?=site_url('account/settings/avatar')?>" class="gen-form" enctype="multipart/form-data" id="avatar-form" method="post">
			<fieldset id="upload">
				<input type="text" readonly value="<?php echo $user['pic_url']; ?>" name="upfile" id="upfile">  
						<br/>
						<input type="button" class="form-btn" value="<?= $this->lang->line('settings_browse'); ?>" onclick="url.click()">  
						<input type="file" name="url" style="display:none" value="<?php echo $user['pic_url']; ?>" onchange="upfile.value=this.value"/>
			            <input type="hidden" name="userid" value="<?php echo $this->session->userdata('id') ?>" />
				<p class="info"><?= $this->lang->line('settings_browse_slogan'); ?></p>
			</fieldset>

			<div id="add-btn">
				<input class="form-sub" name="commit" type="submit" value="<?= $this->lang->line('settings_upload'); ?>">
				<a href="#canel-avatar" class="form-btn" id="cancel-avatar"><?= $this->lang->line('settings_cancel'); ?></a>
			</div>
</form>	</div>

	
	

</div>


</div>
<script type="text/javascript"> 
  $("#idtabs div").idTabs(); 
</script>
<script type="text/javascript">
var msg = '<?php echo $error_msg; ?>';
$(document).ready(function() {
	if (msg != 0){
		switch (msg){
			case 'avatar' : $('#avatarsuccess').css('display','inline');break;
			case 'info' : $('#infosuccess').css('display','inline');break;
			default : break;
		}
	}
	setTimeout(function(){
			  $('.formSuccessContent').css('display','none');
		   }, 3000 );	
});
</script>
	<?php if ($lang == 0) { ?>
	<script src="<?=base_url()?>js/settings_en.js"></script>
<?php } else { ?>
	<script src="<?=base_url()?>js/settings_cn.js"></script>
<?php }?>
<?php $first = get_cookie('first_login');
	if (isset($first)&&($first!= null)&&($first == 1)) {

		$this->load->view('first_login');
	
 		$cookie = array(
			'name'   => 'first_login',
			'value'  => 0,
			'expire' => '5',
		);

		set_cookie($cookie);
	
	 }?>


<?php $this->load->view('footer') ?>
