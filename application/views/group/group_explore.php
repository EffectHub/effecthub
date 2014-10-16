<?php $this->load->view('header') ?>
<div id="content" class="group">

	<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="<?=base_url()?>js/jquery.leanModal.min.js"></script>
	
<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png?1376325170" width="15">
	</a>
</div>
	<?php if (!$this->session->userdata('id')){  ?>
<div class="full full-pitch group">
	<h1 class="compact">
		<?= $this->lang->line('groupexplore_unlogin'); ?>
		<a rel="leanModal" type="button" name="login" href="#login" class="form-sub tagline-action"><?= $this->lang->line('groupexplore_sign_up'); ?></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('groupexplore_sign_up_twitter'); ?>" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('groupexplore_sign_up_facebook'); ?>" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('groupexplore_sign_up_google'); ?>" class="auth-google tagline-action" href="<?=site_url('login/google')?>"></a>
		<!--<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>-->
	</h1>
</div>
<?php  }?>

<div id="main">
	<ul class="tabs">
		<?php if ($this->session->userdata('id')){  ?>
		<li class="groups <?php echo $feature=='mygroup'?'active':'' ?>"><a href="<?php echo site_url('group/mygroup')?>"><?= $this->lang->line('header_groups_my_groups'); ?></a></li>
		<?php  }?>        
		<li class="groups <?php echo $feature=='groups'?'active':'' ?>"> <a href="<?=site_url('group/')?>"><span class="meta"><?= $this->lang->line('header_groups_explore_groups'); ?></span> <span class="count"></span></a></li>
		<?php if ($this->session->userdata('id')){  ?>
		<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('group/create')?>"><?= $this->lang->line('groupall_create_group'); ?></a>
		<?php  }?>
	</ul>
	<div class="group-main">
		<div class="group-header">
			<h3><?= $this->lang->line('groupexplore_hotest_groups'); ?></h3>
		</div>
        
		<div class="hotest">
			<?php $j = rand(0,29);
				for ($i = 0; $i < 9; $i++) {
				$j = $j + rand(1,3);
				if ($j > 29) $j = $j - 30;?>
			<div class="hot-group">
				<a href="<?= site_url('g/'.$hot_groups[$j]['key'])?>" title="<?= $hot_groups[$j]['group_name']?>"><img src="<?= $hot_groups[$j]['group_pic']?>"/></a>
				<a class="hot-group-title" href="<?= site_url('g/'.$hot_groups[$j]['key'])?>" title="<?= $hot_groups[$j]['group_name']?>"><?= $hot_groups[$j]['group_name']?></a>
				<span class="mem-num"><?= $hot_groups[$j]['member_num']?> <?= $this->lang->line('groupexplore_members'); ?></span>
				<span class="topic-num"><?= $hot_groups[$j]['topic_num']?> <?= $this->lang->line('groupexplore_topics'); ?></span>
			</div>
			
			<?php }?>
		</div>
		
		<div class="group-header">
        	<h3><?= $this->lang->line('groupexplore_popular_topics'); ?></h3>
        </div>
        	
        <div class="hot-topic">
        	<?php $j = rand(0,29);
        		for ($i = 0; $i < 10; $i++) {
					$j = $j + rand(1,5);
					if ($j > 29) $j = $j - 30;?>
        	<div class="topic-item">
        		<a href="<?= site_url('topic/'.$hot_topics[$j]['id']) ?>" title="<?= $this->lang->line('groupexplore_view_comments'); ?>"><span class="t-comment-num"><?= $hot_topics[$j]['comment_num'] >99?'99+':$hot_topics[$j]['comment_num'] ?></span></a>
        		<span class="t-link">
        			<a href="<?= site_url('topic/'.$hot_topics[$j]['id']) ?>" title="<?=$hot_topics[$j]['topic_title'] ?>"><?=$hot_topics[$j]['topic_title'] ?></a>
        		</span>
        		<span class="t-reply-time"><?= $hot_topics[$j]['comment_num']>0? $this->lang->line('groupexplore_last_replied'):''; ?> <?= tranTime(strtotime($hot_topics[$j]['last_comment_time'])) ?></span>
        		<span class="t-group"><a href="<?= site_url('group/'.$hot_topics[$j]['group_id']) ?>" title="<?=$hot_topics[$j]['group_name'] ?>"><?= $hot_topics[$j]['group_name'] ?></a></span>
        	</div>
        	<?php } ?>
        </div>
		
					
	</div>
</div>


<div class="secondary my-group">
	<?php if ($this->session->userdata('id')) {?>
	<a href="<?=site_url('account/settings')?>" title="Update my Avatar"><img alt="<?php echo $user['displayName']; ?>" class="photo" style="width:80px;max-height:150px;margin-bottom:5px;border-radius:5px;" src="<?php echo $user['pic_url']; ?>"></a>
	<h3>
		<a href="<?=site_url('user/'.$user['id'])?>"><?php echo $user['displayName']; ?></a>	
	</h3>
		
	<p>
		<?= $this->lang->line('groupexplore_my_groups'); ?> <a href="<?=site_url('group/showmygroup') ?>"><?= $group_num ?></a>
	</p>
	<p>
		<?= $this->lang->line('groupexplore_my_topics'); ?> <a href="<?=site_url('topic/showmytopic') ?>"><?= $topic_num ?></a>
	</p>
	<?php }?>

 	<div class="group-type">
		<h4><?= $this->lang->line('groupexplore_view_groups'); ?></h4>

    	<ul>
		<?php foreach ($group_type as $_types): ?>
			<li> 
				<a href="<?= site_url('group/allgroup/'.$_types['id']) ?>"><?= ($lang == 2)?$_types['name_cn']:$_types['type_name']; ?></a>
			</li>
		<?php endforeach;?>
		</ul>
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
					<input type="hidden" name="redirectURL" value="<?=site_url('group/create')?>"/>
					</form>
				</div>


	<div id="register-ct">
	<div class="txt-fld" style="padding:0px 20px 35px 20px">
				    <a class="addthis_login_twitter" title="<?= $this->lang->line('pop_sign_up_twitter'); ?>" href="<?=site_url('login/twitter')?>"><span id="twitter-connect" class="ssi-button"></span></a>
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
					  <label for="remember_me" style="display:inline;color:#000"><?= $this->lang->line('pop_sign_up_stay_informed'); ?>
				    <input type="checkbox" checked name="consent" id="consent"/></label>
					    <input class="save-btn" name="commit" type="button" value="<?= $this->lang->line('pop_sign_up_free'); ?>" onclick="checksignup();_gaq.push(['_trackEvent', 'signup', 'clicked', 'Click Sign Up Button In task Page'])">
					</div>
					<input type="hidden" name="redirectURL" value="<?=site_url('group/create')?>"/>
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
</div>

<script>

	var item;
	var topic;
	var width;
	var twidth;
	$().ready(function(){

		topic = $(".topic-item");
		width = topic.width() - 180;
		if (width < 100 ) width = 100;
		$('div.topic-item span.t-link').css('width',width);
	});

	$(window).resize(function(){

		topic = $(".topic-item");
		width = topic.width() - 180;
		if (width < 100 ) width = 100;
		$('div.topic-item span.t-link').css('width',width);
	});

</script>

</div>
<?php $this->load->view('footer') ?>
