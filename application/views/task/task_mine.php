<?php $this->load->view('header') ?>
<div id="content" class="group">
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
		<?= $this->lang->line('taskexplore_unlogin'); ?>
		<a href="<?=site_url('register')?>" class="form-sub tagline-action"><?= $this->lang->line('taskexplore_sign_up'); ?></a>
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
			<h3><?= $this->lang->line('taskmine_all_tasks'); ?></h3>
		</div>
        
        <div class="hot-topic">
        	<?php foreach($task_list as $_task): ?>
        	<div class="topic-item">
        		<a href="<?= site_url('task/'.$_task['id']) ?>" title="<?= $this->lang->line('taskexplore_view_comments'); ?>"><span class="t-comment-num"><?= $_task['response_num'] >99?'99+':$_task['response_num'] ?></span></a>
        		<span class="t-link">
        			<a href="<?= site_url('task/'.$_task['id']) ?>" style="text-decoration:<?php echo $_task['status']==1?'line-through':'';?>" title="<?=$_task['title'] ?>">
        			[<?=$lang==2?$_task['type_name_cn']:$_task['type_name'] ?>]
        			[<?=$_task['price']?>
				<?php if($_task['price_type']=='1'){
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
				?>]
        			<?=$_task['title'] ?></a>
        		</span>
        		<span class="t-reply-time"><?= $_task['response_num']>0? $this->lang->line('taskexplore_last_replied'):''; ?> <?= tranTime(strtotime($_task['last_response_time'])) ?></span>
        		<span class="t-group"><a href="<?= site_url('user/'.$_task['author_id']) ?>" title="<?=$_task['author_name'] ?>"><?= $_task['author_name'] ?></a></span>
        	</div>
        	<?php endforeach; ?>
        </div>
		
				<div class="page">
	<?php echo $this->pagination->create_links();?>
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
