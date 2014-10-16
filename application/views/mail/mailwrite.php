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
		<a href="<?=site_url('user/'.$this->session->userdata('id'))?>" class="has-dd">My Profile</a>
	</li>
	<li class="<?php echo $feature=='Mailbox'?'active':'' ?>">
		<a href="<?=site_url('user/checkmail/'.$this->session->userdata('id'))?>" class="has-dd">My Mail Box</a>
	</li>
	<li class="<?php echo $feature=='Notification'?'active':'' ?>">
		<a href="<?=site_url('user/notice/'.$this->session->userdata('id'))?>" class="has-dd">Notification</a>
	</li>
</ul>
<h5>Write mail to <?php echo $user['displayName']; ?></h5> 
	<ol class="effecthubs group">
                   <div class="mailstyle" name="<?php echo $this->session->userdata('id')?>">
                      <div class="mailmain" style="background:#FFF;padding:20px;margin:0px;border-radius: 5px;">
                          <form method="post" class="gen-form" style="margin:0" name="sendmailform" action="<?=site_url('user/sendMail/'.$user['id'])?>">
                   <div class='pic'>
                         <a target="_blank" href="<?=site_url('user/'.$user['id'])?>"><img src='<?php echo $user['pic_url']; ?>' style='width:88px;'></a>
                   </div> 
                   <div class="panel">
                      <input name="to" type="hidden" value="2677601"/>
                      <fieldset><textarea id="m_text" name="m_text" rows="50" style="height:300px"></textarea></fieldset>
                       <div class="item-submit">
                          <input class="form-sub" name="m_submit" type="submit" value="Send"/>
                          <input class="form-sub" name="m_cancel" type="submit" value="Cancel" />
                       </div>
                   </div>
                   </form>
                      </div>
                   </div>
                
	  

	</ol>

	
<div class="page">
	
</div>



</div> <!-- /main -->

<div class="secondary">
 <div class="what-is-pro-search">
		<h3>Search <span class="meta">Authors</span></h3>

		<form name="author_search_form" class="gen-form" action="<?=site_url('author/authorSearch')?>" method="post" onkeydown="if(event.keyCode==13){document.author_search_form.submit();}">
                    <div id='main-search' class='clearfix'>
                       <div id='main-search-box' class='clearfix'>
                           <fieldset>
                           <input type="text" style="background: rgba(255, 255, 255, 1);" id='particle_search_field' name="search" onblur="if (this.value == '') {this.value = 'Search author';}" onfocus="if (this.value == 'Search author') {this.value = '';}" value="Search author" x-webkit-speech="" speech="">
                       		</fieldset>
                       </div>
                    </div>
                  </form>
	</div>
 
 </div>

</div> <!-- /content -->

</div></div> <!-- /wrap -->
<?php $this->load->view('footer') ?>