<?php $this->load->view('header') ?>

	<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="<?=base_url()?>js/jquery.leanModal.min.js"></script>
<div id="content" class="group">
	<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>css/task.css" media="screen, projection" rel="stylesheet" type="text/css">
<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png?1376325170" width="15">
	</a>
</div>
	<?php if (!$this->session->userdata('id')){  ?>
<div class="full full-pitch group">
	<h1 class="compact">
		<?= $this->lang->line('taskexplore_unlogin'); ?>
		<a rel="leanModal" type="button" name="login" href="#login" class="form-sub tagline-action"><?= $this->lang->line('taskexplore_sign_up'); ?></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('taskexplore_sign_up_twitter'); ?>" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('taskexplore_sign_up_facebook'); ?>" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('taskexplore_sign_up_google'); ?>" class="auth-google tagline-action" href="<?=site_url('login/google')?>"></a>
		<!--<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>-->
	</h1>
</div>
<?php  }?>

<div id="main">
	<ul class="tabs">
		<?php if ($this->session->userdata('id')){  ?>
		<li class="groups <?php echo $feature=='mytask'?'active':'' ?>"><a href="<?php echo site_url('task/mytask')?>"><?= $this->lang->line('header_tasks_my_tasks'); ?></a></li>
		<?php  }?> 
		<?php if ($this->session->userdata('id')){  ?>
		<li class="groups <?php echo $feature=='mybid'?'active':'' ?>"><a href="<?php echo site_url('task/mybid')?>"><?= $this->lang->line('header_tasks_my_responses'); ?></a></li>
		<?php  }?>       
		<li class="groups <?php echo $feature=='tasks'?'active':'' ?>"> <a href="<?=site_url('task/')?>"><span class="meta"><?= $this->lang->line('header_tasks_explore_tasks'); ?></span> <span class="count"></span></a></li>
		<?php if ($this->session->userdata('id')){  ?>
		<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('task/create')?>"><?= $this->lang->line('taskcreate_create_task'); ?></a>
		<?php  }?>
	</ul>
	<div class="group-main">
		<div class="group-header">
        	<h3>
        	<?= isset($tag)?$this->lang->line('taskcreate_tag').': '.$tag:$this->lang->line('taskexplore_popular_responses'); ?>
        	</h3>
        </div>
        	
        <div class="hot-topic">
        	<?php foreach($task_list as $_task): ?>
        	
        	<div class="question-summary narrow">
    <div onclick="window.location.href='<?= site_url('task/'.$_task['id']) ?>'" class="cp">
        <div class="votes">
            <div class="mini-counts"><span title="<?=$_task['price']?>"><?=$_task['price']?></span></div>
            <div><?php if($_task['price_type']=='1'){
					if($lang==2){
						echo '金币';
					}else{
						 echo 'coins';
					}
				}else{
					if($lang==2){
						echo '人民币';
					}else{
						 echo 'cash';
					}
				}
				?></div>
        </div>
        <div class="status <?=$_task['response_num']>0?'answered':''?><?=$_task['status']==1?'-accepted':''?>">
            <div class="mini-counts"><span title="<?=$_task['response_num']?>"><?=$_task['response_num']?></span></div>
            <div><?= $this->lang->line('task_answers'); ?></div>
        </div>
        <div class="views">
            <div class="mini-counts"><span title="<?=$_task['view_num']?>"><?=$_task['view_num']?></span></div>
            <div><?= $this->lang->line('task_views'); ?></div>
        </div>
    </div>
    <div class="summary">
        
                    <h3>
                    <a href="<?= site_url('task/'.$_task['id']) ?>" class="question-hyperlink" title="<?=$_task['title'] ?>"><?=$_task['title'] ?></a>
                    <?php if ($_task['status']==1) {?>
                    <img style="float:right;margin-left:10px;" title="<?= $this->lang->line('task_finished'); ?>" src="<?=base_url()?>images/finish.png" width="16px"/>
                    <?php }?>
                    <?php if ($_task['task_type']==1) {?>
                    <!--<img style="float:right;margin-left:10px;" title="<?= $this->lang->line('task_question'); ?>" src="<?=base_url()?>images/question.png" width="16px"/>-->
                    <?php }?>
                    
                    </h3>
        <div class="tag t-mysql">
            <a href="<?= site_url('task/type/'.$_task['type']) ?>" class="post-tag" title="<?=$lang==2?$_task['type_name_cn']:$_task['type_name'] ?>" rel="tag"><?=$lang==2?$_task['type_name_cn']:$_task['type_name'] ?></a> 
        
        <?php
        if($_task['task_tag']!=''){
        		$tags = preg_split('/[\s,;]+/',$_task['task_tag']);
        	}else{
        		$tags = array();
        	}
         foreach($tags as $tag): ?>
							<a href="<?=site_url('task/tagSearch?tag='.$tag)?>" rel="tag" class="post-tag"><strong><?php echo $tag; ?></strong></a>
					<?php endforeach; ?>
        </div>
        <div class="started">
            <a href="<?= site_url('task/'.$_task['id']) ?>" class="started-link"><?= $_task['response_num']>0? $this->lang->line('taskexplore_last_replied'):''; ?>  <span title="<?= $_task['last_response_time'] ?>" class="relativetime"><?= tranTime(strtotime($_task['last_response_time'])) ?></span></a>
            <a href="<?= site_url('user/'.$_task['author_id']) ?>"><?=$_task['author_name'] ?></a> <span class="reputation-score" title="reputation score " dir="ltr"></span>
        </div>
    </div>
</div>

        	<?php endforeach; ?>
        	
        	<div class="question-summary narrow" style="border:0px">
        	
		<div class="page">
	<?php echo $this->pagination->create_links();?>
</div>
        	</div>
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
		<?= $this->lang->line('taskexplore_my_tasks'); ?> <a href="<?=site_url('task/mytask') ?>"><?= $task_num ?></a>
	</p>
	<p>
		<?= $this->lang->line('taskexplore_my_responses'); ?> <a href="<?=site_url('task/mybid') ?>"><?= $response_num ?></a>
	</p>
	<?php }?>

 	<div class="group-type">
		<h4><?= $this->lang->line('taskexplore_view_tasks'); ?></h4>

    	<ul>
    	<?php if ($type == 'all') { ?>
				<li class="type-selected"><< <?= ($lang == 2)?'所有':'All'; ?></li>
				<?php } else {?>
			<li> 
				<a href="<?= site_url('task/type/all') ?>"><?= ($lang == 2)?'所有':'All'; ?></a>
			</li>
			<?php }?>
		<?php foreach ($item_type_list as $_types): ?>
		<?php if ($type == $_types['id']) { ?>
				<li class="type-selected"><< <?= ($lang == 2)?$_types['name_cn']:$_types['name']; ?></li>
				<?php } else {?>
			<li> 
				<a href="<?= site_url('task/type/'.$_types['id']) ?>"><?= ($lang == 2)?$_types['name_cn']:$_types['name']; ?></a>
			</li>
			<?php }?>
		<?php endforeach;?>
		</ul>
	</div>
	
	<div style="width:100%;background:#212121;background: #618fb9 url(<?=base_url()?>images/alert-lines.png) repeat top left;border-radius:10px;margin-top:20px;padding:15px;height:60px;text-align:center">
	<h1 style="font-size:14px"><strong><?= $this->lang->line('task_ipad'); ?><br/><br/>
	<?= $this->lang->line('task_golive'); ?></strong></h1>
	</div>
 
 
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
					<input type="hidden" name="redirectURL" value="<?=site_url('task/create')?>"/>
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
					<input type="hidden" name="redirectURL" value="<?=site_url('task/create')?>"/>
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
