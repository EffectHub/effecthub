<?php $this->load->view('header') ?>

<div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="http://effecthub.com/#" class="close">
		<img alt="Icon-x-30-white" src="<?=base_url()?>images/icon-x-30-white.png" width="15">
	</a>
</div>
<div id="main" class="main">
	<?php if (!$this->session->userdata('id')){  ?>
<div class="full full-pitch group">
	<h1 class="compact">
		<strong>EffectHub is connecting the world's gaming designers and developers.</strong>
		
		<a href="<?=site_url('register')?>" class="form-sub tagline-action">Sign up</a>
		<a rel="tipsy" original-title="Sign up with your Twitter account" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Facebook account" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>
	</h1>
</div>
<?php  }?>
<ul class="tabs">
	<li class="<?php echo $feature=='Profile'?'active':'' ?>">
		<a href="<?=site_url('user/'.$this->session->userdata('id'))?>" class="has-dd"><?= $this->lang->line('notification_profile'); ?></a>
	</li>
	<li class="<?php echo $feature=='Mailbox'?'active':'' ?>">
		<a href="<?=site_url('user/checkmail/'.$this->session->userdata('id'))?>" class="has-dd"><?= $this->lang->line('notification_mailbox'); ?></a>
	</li>
	<li class="<?php echo $feature=='Notification'?'active':'' ?>">
		<a href="<?=site_url('user/notice/'.$this->session->userdata('id'))?>" class="has-dd"><?= $this->lang->line('notification_notification'); ?></a>
	</li>
</ul>

	<ol class="effecthubs group">
	<?php foreach($notice_list as $_notice): ?>
                   <div class='commentitem' style='border-bottom: 1px dashed #CDCDCD;padding-bottom:30px; position:relative'>
                         <div class="commenttext" style='margin-top:21px;'><?php echo $_notice['action']; ?> <?php echo $_notice['content']; ?>
                         	<div style='float:right; color:#999; font-size:12px'><?php echo tranTime(strtotime($_notice['timestamp'])); ?></div>
                         </div>
                   </div> 
                <?php endforeach; ?>
                
	  

	</ol>

<div class="page">
	<?php echo $this->pagination->create_links();?>
</div>



</div> <!-- /main -->

<div class="secondary">
 
<h3><?= $this->lang->line('notification_popular_authors'); ?><span class="meta"></span></h3>
	<div class="group-list">
                       <ul>
<?php foreach($user_list as $_user): ?>
 <li>
<a href="<?php echo site_url('user/'.$_user['id'])?>"><img src="<?php echo $_user['pic_url']; ?>" class="group-img"></a>
<p>
<a href="<?php echo site_url('user/'.$_user['id'])?>" class="group-title"><?php echo $_user['displayName']; ?></a>
 <br><span class="group-count"><a href="<?=site_url('user/showfollowers/'.$_user['id'])?>"><?php echo $_user['follower_num']; ?> <?= $this->lang->line('notification_followers'); ?></a><br>
 <a href="<?=site_url('author/countrySearch/'.$_user['countryCode'])?>" class="locality"><?php echo $_user['country_name']; ?></a></span>
</p>
<a class="form-sub tagline-action" style="float:right" href="<?=site_url('user/follow/'.$_user['id'])?>"><?= $this->lang->line('notification_follow'); ?></a>
 </li>
                   <?php endforeach; ?>
 </ul></div><br/><br/>
 
 </div>

</div> <!-- /content -->

</div></div> <!-- /wrap -->
<?php $this->load->view('footer') ?>
