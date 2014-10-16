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
		<h1 class="alt"><?= $this->lang->line('social_title'); ?><span class="sep"></span></h1>
	</div>
</div>



<div id="main">

<div id="idtabs"> 
  <div class="apps-type"> 	
<ul class="tabs">
	<li><a href="#social" class="selected"><?= $this->lang->line('social_linked_accounts'); ?></a></li>
	<div style="float:right;">
	<a class="form-sub tagline-action" style="float:right;" href="<?php echo site_url('account/settings')?>"><?= $this->lang->line('settings_settings'); ?></a>
	</div>
</ul>
</div>

<div class="session-form alt" id="social" style="color:#000">
		<form accept-charset="UTF-8" action="<?=site_url('account/settings/password')?>" class="gen-form with-messages" id="signin_form" method="post">	
<?php
						$twitter = 0;
						$facebook = 0;
						$sina = 0;
						$google = 0;
						$renren = 0;
						$behance = 0;
						foreach($social_list as $social): 
							if( $social['type']=='twitter'){ 
								$twitter = 1;
							}
							if( $social['type']=='facebook'){ 
								$facebook = 1;
							}
							if( $social['type']=='sina'){ 
								$sina = 1;
							}
							if( $social['type']=='google'){ 
								$google = 1;
							}
							if( $social['type']=='behance'){ 
								$renren = 1;
							}
							if( $social['type']=='renren'){ 
								$renren = 1;
							}
							if( $social['type']=='qq'){ 
								$qq = 1;
							}		
						endforeach; 
						?>
							<?php if( $twitter ==1){ ?>
								<div class="accountBindItem" src="#">
				                <img style="float:left;" src="<?=base_url()?>images/social/twitter.png">
				                                	<span class="accountBindItemText">&nbsp;&nbsp;<?= $this->lang->line('social_linked'); ?></span>
				                	&nbsp;&nbsp;<a class="cancelBind" href="<?=site_url('bind/cancel/twitter')?>">
				                        &gt; <?= $this->lang->line('social_disconnect'); ?>
				                    </a>
				                </div>
				             <?php }else{ ?>
				             	<div class="accountBindItem" src="#">
				                <img style="float:left;" src="<?=base_url()?>images/social/twitter.png">
				                <a class="accountBindItemText" href="<?=site_url('login/twitter')?>">&gt;<?= $this->lang->line('social_connect'); ?></a>
				                </div>
				             <?php } ?>
				             <?php if( $facebook ==1){ ?>
								<div class="accountBindItem" src="#">
				                <img style="float:left;" src="<?=base_url()?>images/social/facebook.png">
				                                	<span class="accountBindItemText">&nbsp;&nbsp;<?= $this->lang->line('social_linked'); ?></span>
				                	&nbsp;&nbsp;<a class="cancelBind" href="<?=site_url('bind/cancel/facebook')?>">
				                        &gt; <?= $this->lang->line('social_disconnect'); ?>
				                    </a>
				                </div>
				             <?php }else{ ?>
				             	<div class="accountBindItem" src="#">
				                <img style="float:left;" src="<?=base_url()?>images/social/facebook.png">
				                <a class="accountBindItemText" href="<?=site_url('login/facebook')?>">&gt;<?= $this->lang->line('social_connect'); ?></a>
				                </div>
				             <?php } ?>
				             <?php if( $sina ==1){ ?>
								<div class="accountBindItem" src="#">
				                <img style="float:left;" src="<?=base_url()?>images/social/sina.png">
				                                	<span class="accountBindItemText">&nbsp;&nbsp;<?= $this->lang->line('social_linked'); ?></span>
				                	&nbsp;&nbsp;<a class="cancelBind" href="<?=site_url('bind/cancel/sina')?>">
				                        &gt; <?= $this->lang->line('social_disconnect'); ?>
				                    </a>
				                </div>
				             <?php }else{ ?>
				             	<div class="accountBindItem" src="#">
				                <img style="float:left;" src="<?=base_url()?>images/social/sina.png">
				                <a class="accountBindItemText" href="<?=site_url('login/sina')?>">&gt;<?= $this->lang->line('social_connect'); ?></a>
				                </div>
				             <?php } ?>
				             <?php if( $google ==1){ ?>
								<div class="accountBindItem" src="#">
				                <img style="float:left;" src="<?=base_url()?>images/social/google.png">
				                                	<span class="accountBindItemText">&nbsp;&nbsp;<?= $this->lang->line('social_linked'); ?></span>
				                	&nbsp;&nbsp;<a class="cancelBind" href="<?=site_url('bind/cancel/google')?>">
				                        &gt; <?= $this->lang->line('social_disconnect'); ?>
				                    </a>
				                </div>
				             <?php }else{ ?>
				             	<div class="accountBindItem" src="#">
				                <img style="float:left;" src="<?=base_url()?>images/social/google.png">
				                <a class="accountBindItemText" href="<?=site_url('login/google')?>">&gt;<?= $this->lang->line('social_connect'); ?></a>
				                </div>
				             <?php } ?>
				             <?php if( $behance ==1){ ?>
								<div class="accountBindItem" src="#">
				                <img style="float:left;" src="<?=base_url()?>images/social/behance.png">
				                                	<span class="accountBindItemText">&nbsp;&nbsp;<?= $this->lang->line('social_linked'); ?></span>
				                	&nbsp;&nbsp;<a class="cancelBind" href="<?=site_url('bind/cancel/behance')?>">
				                        &gt; <?= $this->lang->line('social_disconnect'); ?>
				                    </a>
				                </div>
				             <?php }else{ ?>
				             	<div class="accountBindItem" src="#">
				                <img style="float:left;" src="<?=base_url()?>images/social/behance.png">
				                <a class="accountBindItemText" href="<?=site_url('login/behance')?>">&gt;<?= $this->lang->line('social_connect'); ?></a>
				                </div>
				             <?php } ?>
				             <!--
				             <?php if( $qq ==1){ ?>
								<div class="accountBindItem" src="#">
				                <img style="float:left;" src="<?=base_url()?>images/social/qq.png">
				                                	<span class="accountBindItemText">&nbsp;&nbsp;Linked</span>
				                	&nbsp;&nbsp;<a class="cancelBind" href="<?=site_url('bind/cancel/qq')?>">
				                        &gt; Disconnect
				                    </a>
				                </div>
				             <?php }else{ ?>
				             	<div class="accountBindItem" src="#">
				                <img style="float:left;" src="<?=base_url()?>images/social/qq.png">
				                <a class="accountBindItemText" href="<?=site_url('login/qq')?>">&gt;Connect</a>
				                </div>
				             <?php } ?>
				             -->
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
	<script src="<?=base_url()?>js/settings.js"></script>

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
