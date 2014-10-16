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
	 
	
	<div class="team-subtitle"><h5><?= $this->lang->line('teamcomments_comment_title'); ?></h5></div>
	
		<?php if (!$comments) { ?>
			
		<p class="no-share"><?= $this->lang->line('team_no_comment'); ?></p>
			
		<?php } else { ?>
		
		
		<div class="page">
			<?php echo $this->pagination->create_links();?>
		</div>
			
			<?php foreach ($comments as $_comment): ?>
		<div class="single-comment">
			<div class="comment-user">
				<a class="comment-img" href="<?= site_url('user/'.$_comment['user_id']); ?>"><img src="<?= $_comment['user_pic'] ?>" /></a>
				<div class="comment-username">
					<a href="<?= site_url('user/'.$_comment['user_id']); ?>"><?= $_comment['user_name']; ?></a>
					<span><?= trantime(strtotime($_comment['comment_date'])); ?></span>
					<?php if ($this->session->userdata('id')&&($this->session->userdata('id')!=$_comment['user_id'])&&($priority==1)) {?><a id="comment-reply"><?= $this->lang->line('team_reply') ?></a><?php } ?>
				
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
							location.href="<?= site_url('team/comments/'.$team['team_id']); ?>";
						} else {

							alert('<?= $this->lang->line('team_comment_fail'); ?>');
						}
					}

				);
				
			});
			
		</script>
		
		
		
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
							
							location.href="<?= site_url('team/comments/'.$team['team_id']); ?>";
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
		
		<div class="page">
			<?php echo $this->pagination->create_links();?>
		</div>
		

</div> <!-- /main -->

<div class="secondary">

	<p style="font-size:18px;color:#bbb;"><?= $comment_num.' '.$this->lang->line('teamcomments_comment_num'); ?></p>
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

