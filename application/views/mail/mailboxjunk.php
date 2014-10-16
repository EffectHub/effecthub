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
	<form method="post" action="<?=site_url('user/operatechosedmail/0')?>">
                   <div class="mailstyle" name="<?php echo $this->session->userdata('id')?>">
                      <div class="aside" style="width:100%">
                          <a class="form-sub" href="<?=site_url('user/choosefollowing/'.$this->session->userdata('id'))?>">Write letter to my following</a>
                          <a class="form-sub" href="<?=site_url('user/showfollowing/'.$this->session->userdata('id'))?>">Go to list of my following</a>    
                      </div>
                      <div class="mailmain" style="margin-top:30px">
                          <div class="tabs">
                             <a href="<?=site_url('user/checkmail/'.$this->session->userdata('id'))?>" class="junkmailstyle">Inbox(<?php echo $unreadcount; ?> unread)</a>
                             <a href="<?=site_url('user/checkjunkmail/'.$this->session->userdata('id'))?>" class="inboxstyle">Junk mail(<?php echo $unreadjunkcount; ?> unread)</a>
                             <a href="<?=site_url('user/checksendmail/'.$this->session->userdata('id'))?>" class="junkmailstyle">Outbox</a>
                             <!--<div style="float: right;position: relative;">
                             Select:
                             <select id="mailcatagory" name="mailcatagory">
                                 <option value="all" selected="selected">All Mail</option>
                                 <option value="Unread">Unread Mail</option>
                                 <option value="read">Read Mail</option>
                             </select>
                             </div>-->
                          </div>
                          <?php if ($unreadjunkcount >0){  ?>
                          <div  class="allmailoperate"><a href="<?=site_url('user/markallread/1')?>">Mark all as Read</a></div>
                          <?php  }?>
                          <div class="mailcontent">
<ul>
 <?php foreach($mail_list as $_mail): ?>
  <li style="background-color:<?php echo $_mail['read']==0?'#FFFFC6':''; ?>" id="<?php echo $_mail['id']; ?>">    
  <div class="picture">
        <a href="<?=site_url('user/'.$_mail['sender_id'])?>"><img src="<?php echo $_mail['author_pic']; ?>" width="45px" height="45px"></a>
  </div>
  <div class="title">
    <div class="sender">
      <span class="time"><?php echo tranTime(strtotime($_mail['timestamp'])); ?></span>
      <span class="from"><a href="<?=site_url('user/readmail/'.$_mail['id'].'/sender_id')?>" style="color:#ddd"><?php echo $_mail['author_name']; ?></a></span>
    </div>
    <div class="sender">
       <span class="time">  
         <a rel="direct" title="Move to Junk Mail?" class="operate_link" href="<?=site_url('user/movemail/'.$_mail['id'].'/0')?>">Move to Inbox</a>
         <a title="Are you sure to delete this mail?" class="operate_link" href="<?=site_url('user/deletemail/'.$_mail['id'].'/1')?>" >Delete</a>
         <input type="checkbox" name="choosemail[]" value="<?php echo $_mail['id']; ?>">
       </span>
       <span class="from"><a href="<?=site_url('user/readmail/'.$_mail['id'].'/sender_id')?>" class="url"><?php echo $_mail['content']; ?></a></span>
    </div>
  </div> 
  </li>
  <?php endforeach; ?>
</ul>
<div class='paragraphstyle' style='font-weight: bold;font-size:16px;padding:10px;margin-bottom:20px'><?php echo $this->pagination->create_links();?></div>
                          </div>
                          <div class="mailoperate"> 
                             <input type="submit" name="deletechosedmail" class="btn" onclick="return confirm('Are you sure to delete choosed mail?')" value="Delete">
                             <input type="submit" name="movechosedmail" class="btn" value="Move to Inbox">
                             <input type="submit" name="markchosedmail" class="btn" value="Mark as Read">
                             <!--<a href="<?=site_url('user/markallread/1')?>" style="margin-left:22px;">Mark all as Read</a>-->
                          </div>
                      </div>
                   </div>
                   </form>
                
	  

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