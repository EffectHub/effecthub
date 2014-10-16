<?php $this->load->view('header') ?>
<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="<?=base_url()?>js/jquery.leanModal.min.js"></script>
<div id="content" class="group">


<div class="full">
	<div class="profile vcard group ">
		<img alt="<?php echo $team['team_name']; ?>" class="photo" src="<?php echo $team['pic_url']; ?>">
		<h1><?= $this->lang->line('team_team'); ?> <?php echo $team['team_name']; ?></h1>
		
	</div>

</div>

<div id="main">
	
	
	<div class="team-subtitle"><h5><?= $this->lang->line('teamshares_share_title'); ?></h5></div>
	
		<?php if (!$shares) { ?>
			<p class="no-share" ><?= $this->lang->line('team_no_share'); ?></p>
		
		<?php } else {?>

		<ol class="effecthubs group">
		<?php foreach($shares as $_item): ?>
		
		<li id="screenshot-1085677" class="group">
	<div class="effecthub">
		<div class="effecthub-shot">
			<div class="effecthub-img">
			<?php if ($_item['item_id']!=null&&$_item['item_id']!='') { ?>
	<a href="<?=site_url('item/'.$_item['item_id'])?>" class="effecthub-link"><div data-picture="" data-alt="<?php echo $_item['name']; ?>">
	<?php if ($_item['pic_url']!=null){ ?>
  <img width="220px" height="150px" alt="<?php echo $_item['name']; ?>" src="<?php echo $_item['pic_url']; ?>">
  <?php  }else{?>
  	<iframe src="<?=site_url('item/preview_html/'.$_item['item_id'])?>" scrolling="no" frameborder="NO" border="0" framespacing="0" style="width: 300px; height: 200px;padding:0px;margin:0px;"></iframe>
  <?php  }?>
</div></a>
	<a href="<?=site_url('item/'.$_item['item_id'])?>" class="effecthub-over" style="opacity: 0;">	<strong><?php echo $_item['name']; ?></strong>

		<em class="timestamp"><?= $this->lang->line('team_added_at') ?> <?php echo $_item['share_time']; ?></em>
</a>
		<?php } else { ?>
		
			<a href="<?=site_url('folder/'.$_item['folder_id'])?>" class="effecthub-link"><div data-picture="" data-alt="<?php echo $_item['name']; ?>">
	
  <img width="220px" height="150px" alt="<?php echo $_item['name']; ?>" src="<?php echo $_item['pic_url']; ?>">
 
  	
</div></a>
	<a href="<?=site_url('folder/'.$_item['folder_id'])?>" class="effecthub-over" style="opacity: 0;">	<strong><?php echo $_item['name']; ?></strong>

		<em class="timestamp"><?= $this->lang->line('team_added_at') ?> <?php echo $_item['share_time']; ?></em>
</a>
		<?php } ?>
		</div>
		

		<h2>
		<span class="attribution-user">
			<a href="<?=site_url('user/'.$_item['user_id'])?>" class="url" rel="contact" title="<?php echo $_item['user_name']; ?>"><img alt="<?php echo $_item['user_name']; ?>" class="photo" src="<?php echo $_item['user_pic']; ?>"> <?php echo $_item['user_name']; ?></a>
		</span>
	</h2>

		
		</div>
		
	</div>

	
</li>
		<?php endforeach; } ?>
	
		
		<div class="page">
			<?php echo $this->pagination->create_links();?>
		</div>
		

</div> <!-- /main -->

<div class="secondary">

	<p style="font-size:18px;color:#bbb;"><?= $share_num.$this->lang->line('teamshares_share_num'); ?></p>
	<br/>
	<a href="<?= site_url('team/'.$team['team_id']) ?>"><?= $this->lang->line('teamcomments_back'); ?></a>
	
</div> <!-- /secondary -->



</div>


 <div id="login" class="pop">
        
				<div id="register-header" class="pop-header">
					<h2><?= $this->lang->line('pop_title_join'); ?></h2>
				</div>
        <div id="idtabs"> 
  <div class="apps-type"> 	
<ul class="tabs">
	<li style="margin:20px 0 0 20px"><a href="#login-ct" style="color:#000"><?= $this->lang->line('pop_login'); ?></a></li>
	<li style="margin:20px 0 0 20px"><a href="#register-ct" class="selected" style="color:#000"><?= $this->lang->line('pop_sign_up'); ?></a></li>
</ul>
</div>

	<div id="login-ct">
	<div class="txt-fld" style="padding:0px 20px 35px 20px">
				    <a class="addthis_login_twitter" title="<?= $this->lang->line('pop_login_twitter'); ?>" href="<?=site_url('login/twitter')?>"><span id="twitter-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_facebook" title="<?= $this->lang->line('pop_login_facebook'); ?>" href="<?=site_url('login/facebook')?>"><span id="facebook-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_google" title="<?= $this->lang->line('pop_login_google'); ?>" href="<?=site_url('login/google')?>"><span id="google-connect" class="ssi-button"></span></a>
						            
				  </div>
				  <br/>
				<span style="margin-left:20px;color:#333"><?= $this->lang->line('pop_login_email_title'); ?></span>
				<form action="<?=site_url('login/check')?>" method="post">
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('pop_login_email'); ?></label>
				    <input id="" name="email" type="text"/>

				  </div>
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('pop_login_password'); ?></label>
				    <input id="" name="password" type="password"/>
				  </div>
				  
				  <div class="btn-fld" style="padding-left:20px;padding-right:20px;width:350px;vertical-align:center">
					  <label for="remember_me" style="display:inline;color:#000"><?= $this->lang->line('pop_remember'); ?>
				    <input type="checkbox" checked name="remember_me" id="remember_me"/></label>
					    <input class="save-btn" name="commit" type="submit" value="<?= $this->lang->line('pop_login'); ?>">
					   <!-- <a style="float:right;margin-top:10px;margin-right:10px;" target="_blank" href="<?=site_url('register')?>">Sign Up &raquo;</a>&nbsp;&nbsp;&nbsp;&nbsp;-->
					</div>
					<input type="hidden" name="redirectURL" value="<?=site_url('team/'.$team['team_id'])?>"/>
					</form>
				</div>


	<div id="register-ct">
	<div class="txt-fld" style="padding:0px 20px 35px 20px">
				    <a class="addthis_login_twitter" title="<?= $this->lang->line('pop_sign_twitter'); ?>" href="<?=site_url('login/twitter')?>"><span id="twitter-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_facebook" title="<?= $this->lang->line('pop_sign_up_facebook'); ?>" href="<?=site_url('login/facebook')?>"><span id="facebook-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_google" title="<?= $this->lang->line('pop_sign_up_google'); ?>" href="<?=site_url('login/google')?>"><span id="google-connect" class="ssi-button"></span></a>
						            
				  </div>
				  <br/>
				<span style="margin-left:20px;color:#333"><?= $this->lang->line('pop_sign_up_email_title'); ?></span>
				<form id="signin_form" action="<?=site_url('register/save')?>" method="post">
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('pop_sign_up_email'); ?></label>
				    <input id="email_address" name="email_address" type="text" value=""/>
<span id="emailError" class="formErrorContent drop-shadow"><?= $this->lang->line('pop_email_error'); ?></span>
				  </div>
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('pop_sign_up_password'); ?></label>
				    <input id="password" name="password" type="password" value=""/>
				    <span id="passwordError" class="formErrorContent drop-shadow"><?= $this->lang->line('pop_password_error'); ?></span>
				  </div>
				  
				  <div class="btn-fld" style="padding-left:20px;padding-right:20px;width:350px;vertical-align:center">
					  <label for="remember_me" style="display:inline;color:#000"><?= $this->lang->line('pop_sign_up_stay_informd'); ?>
				    <input type="checkbox" checked name="consent" id="consent"/></label>
					    <input class="save-btn" name="commit" type="button" value="<?= $this->lang->line('pop_sign_up_free'); ?>" onclick="checksignup()">
					</div>
						<input type="hidden" name="redirectURL" value="<?=site_url('team/'.$team['team_id'])?>"/>
						</form>
					</div>	

</div>
<script type="text/javascript"> 
  $("#idtabs div").idTabs(); 
</script>

		</div>
		
		<script type="text/javascript">
			$(function() {
    			$('a[rel*=leanModal]').leanModal({ top : 200, closeButton: ".modal_close" });		
			});
		</script>


<?php $this->load->view('footer') ?>

