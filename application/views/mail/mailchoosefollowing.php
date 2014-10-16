<?php $this->load->view('header') ?>

<div id="content" class="group">

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
		<a href="<?=site_url('user/'.$this->session->userdata('id'))?>" class="has-dd">My Profile</a>
	</li>
	<li class="<?php echo $feature=='Mailbox'?'active':'' ?>">
		<a href="<?=site_url('user/checkmail/'.$this->session->userdata('id'))?>" class="has-dd">My Mail Box</a>
	</li>
	<li class="<?php echo $feature=='Notification'?'active':'' ?>">
		<a href="<?=site_url('user/notice/'.$this->session->userdata('id'))?>" class="has-dd">Notification</a>
	</li>
</ul>
<div style="margin-top:20px; font-size:18px; font-weight:bold; color:#ccc">Choose my following to write mail
</div>
	
	<ol class="effecthubs group" style="margin-top:10px">
                   <div class="mailstyle" name="<?php echo $this->session->userdata('id')?>">
                      <div class="mailmain" style="background:#FFF;padding:20px; border-radius:5px;">
                          <?php foreach($following_list as $_following): ?>
                   <div class='followingitem' style="border:0">
                         <a href="<?=site_url('user/writemail/'.$_following['id'])?>"><img src='<?php echo $_following['pic_url']; ?>' style='width:88px;height:88px;'></a>
                         <p><a href="<?=site_url('user/writemail/'.$_following['id'])?>"><?php echo $_following['displayName']; ?></a></p>
                   </div> 
                  <?php endforeach; ?>
                      </div>
                   </div>
                
	  

	</ol>

	
<div class="page">
	
</div>



</div> <!-- /main -->

<div class="secondary">
 
<h3>Popular Authors <span class="meta"></span></h3>
	<div class="group-list">
                       <ul>
<?php foreach($user_list as $_user): ?>
 <li>
<a href="<?php echo site_url('user/'.$_user['id'])?>"><img src="<?php echo $_user['pic_url']; ?>" class="group-img"></a>
<p>
<a href="<?php echo site_url('user/'.$_user['id'])?>" class="group-title"><?php echo $_user['displayName']; ?></a>
 <br><span class="group-count"><a href="<?=site_url('user/showfollowers/'.$_user['id'])?>"><?php echo $_user['follower_num']; ?> Followers</a><br>
 <a href="<?=site_url('author/countrySearch/'.$_user['countryCode'])?>" class="locality"><?php echo $_user['country_name']; ?></a></span>
</p>
<a class="form-sub tagline-action" style="float:right" href="<?=site_url('user/follow/'.$_user['id'])?>">Follow</a>
 </li>
                   <?php endforeach; ?>
 </ul></div><br/><br/>
 <h3>Popular Tags <span class="meta"></span></h3>
	
	<div class="group-list">
                       <ul>
<?php foreach($tags as $tag): ?>
                     <a href="<?=site_url('item/tagSearch/'.$tag)?>" class='tagsbutton' style="color:#777;"><?php echo $tag; ?></a>
			          <?php endforeach; ?>
 </ul></div>
 
 </div>

</div> <!-- /content -->

</div></div> <!-- /wrap -->
<?php $this->load->view('footer') ?>
