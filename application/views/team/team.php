<?php $this->load->view('header') ?>
<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="<?=base_url()?>js/jquery.leanModal.min.js"></script>
<div id="content" class="group">


<div class="profile-actions group">
	<ul class="profile-tabs">
		
		<li>
			<span class="count"><?php echo $team['view_num']; ?></span>
			<span class="meta"><?= $this->lang->line('team_views'); ?></span>
		</li>
		
		
		<li>
			<a href="<?= site_url('team/shares/'.$team['team_id']); ?>">
				<span class="count"><?php echo $team['work_num']; ?></span>
				<span class="meta"><?= $this->lang->line('team_works'); ?></span>
			</a>
		</li>
		
		<li>
			<a href="<?= site_url('team/members/'.$team['team_id']); ?>">
				<span class="count"><?php echo $team['people_num']; ?></span>
				<span class="meta"><?= $this->lang->line('team_members'); ?></span>
			</a>
		</li>
			
	</ul>
</div>


<div class="full">
	<div class="profile vcard group ">
		<img alt="<?php echo $team['team_name']; ?>" class="photo" src="<?php echo $team['pic_url']; ?>">
		<h1><?= $this->lang->line('team_team'); ?> <?php echo $team['team_name']; ?></h1>
		
		<?php if (!empty($team['description'])) {?>
		<p class="description">
			<?= $this->lang->line('team_description'); ?> <?php echo $team['description']?>
		</p>
		<?php }?>
	</div>

</div>

<div id="main">
	<!--  
	<ul class="tabs team-tab">

		<?php if (($this->session->userdata('id')!='')&&($this->session->userdata('id')!='null')) {?>
		<?php if ($this->session->userdata('id')==$team['leader_id']||$this->session->userdata('id')==$team['manager_id']) {?>
		<li>
			<a href="<?=site_url('team/edit/'.$team['team_id'])?>"><?= $this->lang->line('team_edit'); ?></a>
		</li>

		<?php } ?>
		
		<li><a href="<?=site_url('team/quit/'.$team['team_id'])?>"><?= $this->lang->line('team_quit'); ?></a>
		</li>
	
	
		<?php }?>	
	
	</ul>
	-->
	<?php if ($invite>0) { ?>
	<div style="padding:0 0 20px 20px;">
		<p><?= $this->lang->line('teamforbidden_invite') ?>  
			<a class="form-sub" href="<?= site_url('team/accept') ?>"><?= $this->lang->line('teamforbidden_accept') ?></a>    
			<a class="form-sub" href="<?= site_url('team/ignore') ?>"><?= $this->lang->line('teamforbidden_ignore') ?></a>
		</p>
	</div>
	<?php }?>
	
	<div class="team-subtitle"><h5><?= $this->lang->line('team_share_title'); ?></h5></div>
		<?php if (!$shares) { ?>
			<p class="no-share" ><?= $this->lang->line('team_no_share'); ?></p>
		
		<?php } else {?>

		<ol class="effecthubs group">
		<?php foreach($shares as $_item): ?>
		
		<li id="screenshot-1085677" class="group">
	<div class="effecthub">
		<div class="effecthub-shot">
			<div class="effecthub-img">
			<?php if ($_item['item_id']!=null&&$_item['item_id']!=''&&$_item['item_id']!=0) { ?>
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

	</ol>
	
	<div class="team-subtitle"><h5><?= $this->lang->line('team_comment_title'); ?></h5></div>
	
		<?php if (!$comments) { ?>
			
		<p class="no-share"><?= $this->lang->line('team_no_comment'); ?></p>
			
		<?php } else { 
		
		foreach ($comments as $_comment): ?>
		<div class="single-comment">
			<div class="comment-user">
				<a class="comment-img" href="<?= site_url('user/'.$_comment['user_id']); ?>"><img src="<?= $_comment['user_pic'] ?>" /></a>
				<div class="comment-username">
					<a href="<?= site_url('user/'.$_comment['user_id']); ?>"><?= $_comment['user_name']; ?></a>
					<span><?= trantime(strtotime($_comment['comment_date'])); ?></span>
					<?php if ($this->session->userdata('id')&&(($this->session->userdata('id')!=$_comment['user_id']))&&(($team['priority']==1)||($is_member==1))) {?><a id="comment-reply"><?= $this->lang->line('team_reply') ?></a><?php } ?>
				
				</div>
			</div>
			
			<div id="reply-area">
				<textarea rows="1" name="reply-content" class="reply-content"></textarea>
				<a style="cursor:pointer;" class="reply-content form-sub" name="<?php echo $_comment['comment_id']; ?>"><?= $this->lang->line('team_reply'); ?></a>
			</div>
			
			<div class="t-content">
				<?php if ($_comment['parent_id']!=0&&$_comment['parent_id']!=null) { ?>
				
				<div class="parent-comment">
					
					<span><?= $_comment['parent_user']; ?> <?= trantime(strtotime($_comment['parent_comment_date'])); ?></span>
					<p><?= $_comment['parent_content']; ?></p>
					
				</div>
				
				<?php } ?>
				
				<p><?= $_comment['content']; ?></p>
				
			</div>
			
			
			
		
		</div>
		<?php endforeach; }?>
		
		<script>
			$('#comment-reply').live('click',function(){
				
				var obj = $(this).parent().parent('.comment-user').next('#reply-area');
				if (obj.css('display')=='block') {
					obj.css('display','none');	
				} else {
					obj.css('display','block');
				}	
			});

			$('a.reply-content').click(function(){
				var content = $(this).prev('.reply-content').val();
				var parent = $(this).attr('name');
				var team = <?= $team['team_id'] ?>;

				if (content==null||content==''){
					alert('your input should not be blank.');
            		return;
            	}
				
				$.post(
					"<?= site_url('team/save_comment')?>",
					{
						content: content,
						parent: parent,
						team: team
					},
					function(data,status) {
						if (status == 'success') {
							
							location.href="<?= site_url('team/'.$team['team_id']); ?>";
						} else {
							alert('<?= $this->lang->line('team_comment_fail'); ?>');
						}
					}

				);
				
			});
			
		</script>
		
		<a href="<?= site_url('team/comments/'.$team['team_id']); ?>" style="float:right; margin: 20px 20px 20px 0;"><?= $this->lang->line('team_all_comments') ?></a>
		
		<?php if ($this->session->userdata('id')) {
			if ($priority == 1) { ?>
			
			<div id="signin_form" class="gen-form">
			<textarea id="contentarea" name="content" class="comment-content"  style="height: 80px; width:99%;background:rgba(255, 255, 255, 1);margin-bottom:15px;"></textarea>
			
			<a style="cursor:pointer;" id="t-comment" class="form-sub" name="<?php echo $team['team_id']; ?>"><?= $this->lang->line('team_post_comment'); ?></a>
        </div>
        
        <script type="text/javascript">

        	$('#t-comment').click(function(){
        		var team = $(this).attr('name');
        		var content = $('#contentarea').val();
        		var parent = 0;

        		if (content==null||content==''){
					alert('<?= $this->lang->line('team_input_blank'); ?>');
            		return;
            	}
        	
        		$.post(
        			"<?= site_url('team/save_comment')?>",
        			{
        				team: team,
      	  				content: content,
        				parent: parent
        			},
        			function (data,status){
        				if (status == 'success') {
							
							location.href="<?= site_url('team/'.$team['team_id']); ?>";
						} else {

							alert('<?= $this->lang->line('team_comment_fail'); ?>');
						}
        			}
        		);
			});
			
        </script>
				
			<?php }	else { ?>
			
			<p class="no-share"><?= $this->lang->line('team_no_priority_comment'); ?></p>
		
		<?php } 
		
		
		} else { ?>
			
		
		
		
		<?php } ?>
		

</div> <!-- /main -->

<div class="secondary">
	
	<?php if ($this->session->userdata('id')) {?>
	<?php if ($is_member == 1) { ?>
	
	<p>
	<?php if ($position!=99) {
		echo $this->lang->line('team_position') ?> <?= $this->lang->line('teammember_position'.$position); 
	
		} else {
		echo $this->lang->line('team_position') ?> <?=$position_name;
		}?>
	</p>	
	<br/>
	<?php if ($this->session->userdata('id')!=$team['leader_id']) { ?>
		
	<a class="form-sub" href="<?= site_url('team/quit/'.$team['team_id']); ?>" onclick="confirm('<?=$this->lang->line('team_quit_confirm'); ?>')"><?= $this->lang->line('team_quit'); ?></a>
	
	<?php } else if ($this->session->userdata('id')==$team['leader_id']) { ?>
		<a class="form-sub" href="<?= site_url('team/edit/'.$team['team_id']); ?>"><?= $this->lang->line('team_edit'); ?></a>
		<a class="form-sub" href="<?= site_url('team/team_invite/'.$team['team_id']); ?>"><?= $this->lang->line('team_invite'); ?></a>
	
	<?php } ?>
	<br/><br/><br/>
	<?php } else if ($apply == 0){ ?>
	<a class="form-sub tagline-action" href="<?= site_url('team/apply/'.$team['team_id']) ?>"><?= $this->lang->line('teamforbidden_apply') ?></a>
	<br/><br/>
	<?php } else { ?>
		<p><?= $this->lang->line('teamforbidden_already_apply'); ?></p>
		<br/>
	<?php } 

	
	}?>
	
	<h3><?= $this->lang->line('team_recent_members'); ?></h3>
	<div>
	<?php foreach ($members as $_member): ?>
		<a title="<?= $_member['displayName']; ?>" href="<?= site_url('user/'.$_member['member_id']) ?>" style="margin: 2px;"><img src="<?= $_member['pic_url']; ?>" width="30px" height="30px" /></a>
	<?php endforeach; ?>
	</div> <br/>
	<p><?= $this->lang->line('team_leader'); ?> <?php if ($team['leader_id']!=null&&$team['leader_id']!=0) {?><a href="<?= site_url('user/'.$team['leader_id']) ?>"><?= $team['leader_name']; ?></a><?php } else {
		echo $this->lang->line('teammine_no_leader');
	}?>
	</p><br/>
	<a href="<?= site_url('team/members/'.$team['team_id']) ?>"><?= $this->lang->line('team_all_members') ?></a>
	<br/><br/>
	<a href="<?= site_url('team/shares/'.$team['team_id']) ?>"><?= $this->lang->line('team_all_shares') ?></a>

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

<?php if ($this->session->userdata('id')){  ?>		
	<div class="remind" id="earn">
		<p>+1 <?= $this->lang->line('pop_coin'); ?></p>
	</div>

	<script>
		
		$(function(){
			var height = $(window).height();
			var width = $(window).width();
			var left = (width - $('.remind').width())/2;
			var top = (height - $('.remind').height())/2;
			if (left < 0) left = 0;
			if (top < 0) top = 0;
			$('.remind').css('left',left);
			$('.remind').css('top',top);
		});

		function earnremind(){

			var remind = $('#earn');
			remind.css('display','block');
			remind.animate({opacity:'1'},1000);
			remind.animate({opacity:'1'},2000);
			remind.animate({opacity:'0'},1000,function(){
				$('#earn').css('display','none');
			});
			
		}

		$(window).resize(function(){
			var height = $(window).height();
			var width = $(window).width();
			var left = (width - $('.remind').width())/2;
			var top = (height - $('.remind').height())/2;
			if (left < 0) left = 0;
			if (top < 0) top = 0;
			$('.remind').css('left',left);
			$('.remind').css('top',top);
		});
	</script>
	<?php 
	
	$first = get_cookie('first_login');
	
		if (isset($first)&&($first!= null)&&($first == 1)) {?>
		 
		<div class="remind" id="first-login">
			<p><span style='font-size:16px;color:#bbb;'><?= $this->lang->line('pop_everyday_login'); ?></span> +1 <?= $this->lang->line('pop_coin'); ?></p>
		</div>
		<script>
			
			$(function(){
	
				var remind = $('#first-login');
				remind.css('display','block');
				remind.animate({opacity:'1'},1500);
				remind.animate({opacity:'1'},3000);
				remind.animate({opacity:'0'},1500,function(){
					$('#first-login').css('display','none');
				});
				
			});
	
		</script>
		 
		 <?php $cookie = array(
		 			'name'   => 'first_login',
		 			'value'  => 0,
		 			'expire' => '5',
		 	);
		 	
		 set_cookie($cookie);
		
		}


}?>	

<?php $this->load->view('footer') ?>

