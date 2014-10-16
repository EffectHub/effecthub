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

	<ol class="effecthubs group" style="margin-top:30px">
<!-- <form method="post" class="gen-form" action="<?=site_url('user/operatechosedmail/0')?>"> -->	
                   <div class="mailstyle" name="<?php echo $this->session->userdata('id')?>">
                      <div class="aside" style="width:100%">
                          <a class="form-sub" href="<?=site_url('user/choosefollowing/'.$this->session->userdata('id'))?>">Write letter to my following</a>
                          <a class="form-sub" href="<?=site_url('user/showfollowing/'.$this->session->userdata('id'))?>">Go to list of my following</a>    
                      </div>
                      <div class="mailmain" style="margin-top:30px">
                          <div class='commentitem' style="border:0">
                            <div class="commentimg">
                                <a href="<?=site_url('user/'.$maildetail[$author_id])?>"><img height="50px" width="50px" src="<?php echo $maildetail['author_pic']; ?>"></a>
                            </div>
                            <div>
                                <div class='paragraphstyle'>
                                    <b><a href="<?=site_url('user/'.$maildetail[$author_id])?>"><?php echo $maildetail['author_name']; ?></a> </b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo tranTime(strtotime($maildetail['timestamp'])); ?>
                                </div>
                                <div class="commenttext"><?php echo auto_link($maildetail['content'], 'both', TRUE); ?></div>
                            </div>
                         </div>  
                         <div class="mailreply" style="background:#FFF;padding:20px;border-radius: 5px;">
                             <form class="gen-form" action="<?=site_url('user/sendMail/'.$maildetail[$author_id])?>" method="post">
	                             <fieldset><textarea name="m_text" rows="8" cols="62" autocomplete="off"></textarea></fieldset>
	                             <fieldset><input class="form-sub" name="m_submit" type="submit" value="Reply"/></fieldset>
                                
                             </form>
                         </div>
                      </div>
                   </div>
  <!--         </form> -->
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
