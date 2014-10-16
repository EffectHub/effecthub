<?php $this->load->view('header') ?>
<div id="content" class="group">
	<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="<?=base_url()?>js/jquery.leanModal.min.js"></script>
<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png?1376325170" width="15">
	</a>
</div>

<div class="full">
	<div class="group">
		<h1 class="alt"><img src="<?php echo $group['group_pic']; ?>" class="group-img"> <?php echo $group['group_name']; ?> <?= $this->lang->line('groupmembers_group'); ?></h1>
		<div style="margin-top:5px;"><a href="<?php echo site_url('group/allgroup/'.$group['group_type'])?>" title="group type"><?= $this->session->userdata('language')==1?$group['type_name']:$group['type_name_cn']; ?></a></div>
	</div>
	
	
</div>


<div id="main">
<ul class="tabs">
<p style="float:left;margin:20px 0 0 10px;font-size:16px;"><?= $group['topic_num'] ?> <?= $this->lang->line('group_topics'); ?></p>
<div style="float:right;padding:20px">

<?php if (($this->session->userdata('id')&&$this->session->userdata('id')==$group['admin_id'])||$this->session->userdata('id')=='1000001'){  ?>
<a class="form-sub tagline-action" href="<?php echo site_url('group/edit/'.$group['id'])?>"><?= $this->lang->line('group_edit'); ?></a>
<?php  }?>
<?php if ($isin!=null&&$isin>0){  ?>
<?php if ($group['admin_id'] == $this->session->userdata('id')) {?>
	<a class="form-sub tagline-action" onclick='alert("You are administrator of the group. You can not quit now. ");' href="javascript:"><?= $this->lang->line('group_quit'); ?></a>

	<?php } else {?>
<a class="form-sub tagline-action" href="<?php echo site_url('group/quit/'.$group['id'])?>"><?= $this->lang->line('group_quit'); ?></a>
<?php }?>
<a class="form-sub tagline-action" href="<?php echo site_url('topic/create/'.$group['id'])?>"><?= $this->lang->line('group_create_topic'); ?></a>
<?php if ($this->session->userdata('id')&&$this->session->userdata('follower_num')>0){  ?>
<a class="form-sub tagline-action" href="<?php echo site_url('group/invite/'.$group['id'])?>"><?= $this->lang->line('group_invite'); ?></a>
<?php  }?>	
<?php  }else{?>
	<?php if ($group['is_private']!='on'){  ?>
		<?php if ($this->session->userdata('id')){  ?>
<a class="form-sub tagline-action" href="<?php echo site_url('group/join/'.$group['id'])?>"><?= $this->lang->line('group_join'); ?></a>
<?php  }else{?>
<a  rel="leanModal" name="login" href="#login" class="form-sub tagline-action"><?= $this->lang->line('group_join'); ?></a>
<?php  }?>	

<?php  }else{?>
	<?php if ($invite!=null&&$invite>0){  ?>
		<a class="form-sub tagline-action" href="<?php echo site_url('group/accept/'.$group['id'])?>"><?= $this->lang->line('group_accept'); ?></a>
		<a class="form-sub tagline-action" href="<?php echo site_url('group/decline/'.$group['id'])?>"><?= $this->lang->line('group_decline'); ?></a>
	<?php  }else{?>	
	<h5 style="float:right;margin:0px"><?= $this->lang->line('need_invitation'); ?></h5>
	<?php  }?>
<?php  }?>	
<?php  }?>
</div>
</ul>


<div class="tabs" style="border-bottom: 1px solid #999;">
<div style="line-height:20px;font-size:14px">
<p><?php echo auto_link($group['group_desc'], 'both', TRUE); ?></p>
</div>
</div>
<div class="hot-topic topic-mine">
		
<ul class="tabs" style="border-bottom: 0px;">
		<li class="groups <?php echo $local==1?'active':'' ?>"><a href="<?php echo site_url('group/'.$group['id'].'/1')?>"><?= $this->session->userdata('language')==1?$this->lang->line('group_english_topic'):$this->lang->line('group_chinese_topic'); ?></a></li>       
		<li class="groups <?php echo $local==2?'active':'' ?>"> <a href="<?=site_url('group/'.$group['id'].'/2')?>"><span class="meta"><?= $this->lang->line('group_all_topic'); ?></span> <span class="count"></span></a></li>
		
	</ul>

        	<?php if ($topic_list) {
        			foreach ($topic_list as $topics):?>
        	<div class="topic-item">
        		<a href="<?= site_url('topic/'.$topics['id']) ?>" title="View comments of this topic"><span class="t-comment-num"><?= $topics['comment_num'] >99?'99+':$topics['comment_num'] ?></span></a>
        		<span class="t-link">
        			<a href="<?= site_url('topic/'.$topics['id']) ?>" title="<?=$topics['topic_title'] ?>"><?=$topics['topic_title'] ?></a>
        		</span>
        		<span class="t-reply-time"><?= $topics['comment_num']>0? $this->lang->line('groupexplore_last_replied'):''; ?> <?= tranTime(strtotime($topics['last_comment_time'])) ?></span>
        		<span class="t-group"><a href="<?= site_url('user/'.$topics['author_id']) ?>" title="<?=$topics['author_name'] ?>"><?= $topics['author_name'] ?></a></span>
        	</div>
        	<?php endforeach;
        	}?>
        </div>
        
<div class="page">
	<?php echo $this->pagination->create_links();?>
</div>
</div>


<div class="secondary">
<?php if ($tool){  ?>
<h3 class="more-from more-from-player"><?= $this->lang->line('group_tool'); ?><span class="meta"></span></h3>
	<ol class="prevnext group" style="margin-top:25px">
	<li>
		<a title="<?php echo $tool['name']; ?>" href="<?=site_url('t/'.$tool['domain'])?>">
		<?php if($tool['thumb_url']!=null||$tool['pic_url']!=null){ ?>
  <img width="60px" height="60px" alt="<?php echo $tool['name']; ?>" src="<?php echo $tool['thumb_url']; ?>">
  <?php  }?>
		</a>
           
</ol>
<?php  }?>
<h3><?= $this->lang->line('group_recent_members'); ?> <span class="meta"></span></h3>
<div>
<?php foreach($group_user_list as $_group_user): ?>
<a href="<?php echo site_url('user/'.$_group_user['user_id']).'/'?>" style="margin:2px"><img height="30px" width="30px" title="<?php echo $_group_user['user_name']; ?>" src="<?php echo $_group_user['user_pic']; ?>" alt="<?php echo $_group_user['user_name']; ?>"></a>
<?php endforeach; ?>
<p style="padding-top:10px"><?= $this->lang->line('groupmembers_administrator'); ?> <a href="<?=site_url('user/'.$group['admin_id'])?>"><?php echo $group['author_name']; ?></a></p>
</div>
<br/>
<a href="<?= site_url('group/members/'.$group['id']) ?>"><?= $this->lang->line('group_all_members'); ?>(<?= $group['member_num'] ?>)</a>

<br/><br/>
<?php if ($popular_list) {?>
 <h3><?= $this->lang->line('group_popular_topics'); ?> <span class="meta"></span></h3>
	
	<div class="group-list">
                       <ul>
<?php foreach($popular_list as $_topic): ?>
 <li style="padding:0">
  <div style="float:left;text-align:center;margin-right:8px;">
<div style="font-size:14px;background:#bbb; display:inline; padding:2px 8px; color:#fff;"> <?php echo $_topic['comment_num']; ?>
</div>
</div>
 <a href="<?php echo site_url('topic/'.$_topic['id'])?>" style="color:#aaa"><?php echo $_topic['topic_title']; ?></a></li>
<?php endforeach; ?>
 </ul></div>
 <br/><br/>
<?php }?>

<h3><?= $this->lang->line('groupinvite_explore_groups'); ?> <span class="meta"></span></h3>
	
	<div class="group-list">
                       <ul>
<?php foreach($hot_groups as $_group): ?>
 <li>
<a href="<?php echo site_url('group/'.$_group['id'])?>"><img src="<?php echo $_group['group_pic']; ?>" class="group-img"></a>
<p>
<a href="<?php echo site_url('group/'.$_group['id'])?>" class="group-title"><?php echo $_group['group_name']; ?></a>
 <br><span class="group-count"><?php echo $_group['member_num']; ?> <?= $this->lang->line('groupexplore_members'); ?><br><?php echo $_group['topic_num']; ?> <?= $this->lang->line('groupexplore_topics'); ?></span>
</p>
 
<a class="group-follow" href="<?php echo site_url('group/index/'.$_group['id'])?>"><?= $this->lang->line('group_join'); ?></a>
 </li>
<?php endforeach; ?>
 </ul></div>
 
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
				    <a class="addthis_login_twitter" title=<?= $this->lang->line('pop_login_twitter'); ?> href="<?=site_url('login/twitter')?>"><span id="twitter-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_facebook" title=<?= $this->lang->line('pop_login_facebook'); ?> href="<?=site_url('login/facebook')?>"><span id="facebook-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_google" title=<?= $this->lang->line('pop_login_google'); ?> href="<?=site_url('login/google')?>"><span id="google-connect" class="ssi-button"></span></a>
						            
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
					    <input class="save-btn" name="commit" type="submit" value="Sign In">
					   <!-- <a style="float:right;margin-top:10px;margin-right:10px;" target="_blank" href="<?=site_url('register')?>">Sign Up &raquo;</a>&nbsp;&nbsp;&nbsp;&nbsp;-->
					</div>
					<input type="hidden" name="redirectURL" value="<?=site_url('group/join/'.$group['id'])?>"/>
					
					
					</form>
				</div>


	<div id="register-ct">
	<div class="txt-fld" style="padding:0px 20px 35px 20px">
				    <a class="addthis_login_twitter" title=<?= $this->lang->line('pop_sign_up_twitter'); ?> href="<?=site_url('login/twitter')?>"><span id="twitter-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_facebook" title=<?= $this->lang->line('pop_sign_up_facebook'); ?> href="<?=site_url('login/facebook')?>"><span id="facebook-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_google" title=<?= $this->lang->line('pop_sign_up_google'); ?> href="<?=site_url('login/google')?>"><span id="google-connect" class="ssi-button"></span></a>
						            
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
					    <input class="save-btn" name="commit" type="button" value="<?= $this->lang->line('pop_sign_up_free'); ?>" onclick="checksignup();_gaq.push(['_trackEvent', 'signup', 'clicked', 'Click Sign Up Button In Item Page'])">
					</div>
						<input type="hidden" name="redirectURL" value="<?=site_url('group/join/'.$group['id'])?>"/>
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
    			$("#hiddenlink").click();	
			});
		</script>
		
</div>
<?php $this->load->view('footer') ?>
