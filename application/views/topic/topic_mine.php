<?php $this->load->view('header') ?>
<div id="content" class="group">

<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png?1376325170" width="15">
	</a>
</div>


<div id="main" >
	<ul class="tabs">
		<?php if ($this->session->userdata('id')){  ?>
		<li class="groups <?php echo $feature=='mygroup'?'active':'' ?>"><a href="<?php echo site_url('group/mygroup')?>"><?= $this->lang->line('header_groups_my_groups'); ?></a></li>
        <?php  }?>
        <li class="groups <?php echo $feature=='groups'?'active':'' ?>"> <a href="<?=site_url('group/')?>"><span class="meta"><?= $this->lang->line('header_groups_explore_groups'); ?></span> <span class="count"></span> </a> </li>
        
	</ul>
	
	<div class="group-header">
		<h3><?= $this->lang->line('topicmine_all_topics'); ?></h3>
	</div>

	<div class="my-topic topic-mine">
        <?php if ($topic_list) {
        foreach ($topic_list as $topics):?>
        <div class="topic-item">
			<a href="<?= site_url('topic/'.$topics['id']) ?>" title="View comments of this topic"><span class="t-comment-num"><?= $topics['comment_num'] >99?'99+':$topics['comment_num'] ?></span></a>
			<span class="t-link"><a href="<?= site_url('topic/'.$topics['id']) ?>" title="<?=$topics['topic_title'] ?>"><?=$topics['topic_title'] ?></a></span>
        	<span class="t-reply-time"><?= $topics['comment_num']>0? $this->lang->line('topicmine_last_replied'):''; ?> <?= tranTime(strtotime($topics['last_comment_time'])) ?></span>
        	<span class="t-group"><a href="<?= site_url('group/'.$topics['group_id']) ?>" title="<?=$topics['group_name'] ?>"><?= $topics['group_name'] ?></a></span>
        </div>
        <?php endforeach;
       	} else {?>	
        <p><?= $this->lang->line('topicmine_none'); ?></p>
		<?php }?>
	</div>
	   	
	<div class="page">
		<?php echo $this->pagination->create_links();?>
	</div>
	
</div>


<div class="secondary my-group">
 
	<a href="<?=site_url('account/settings')?>" title="Update my Avatar"><img alt="<?php echo $user['displayName']; ?>" class="photo" style="width:80px;max-height:150px;margin-bottom:5px;border-radius:5px;" src="<?php echo $user['pic_url']; ?>"></a>
	<h3>
		<a href="<?=site_url('user/'.$user['id'])?>"><?php echo $user['displayName']; ?></a>	
	</h3>
		
	<p><span class="numbers"><?= $topic_num ?></span> <?= $this->lang->line('topicmine_topics'); ?></p>
		
	<a href="<?=site_url('group/showmygroup') ?>"><?= $this->lang->line('topicmine_see_all_groups'); ?></a>
 
</div>
<script>

		var topic;
		var width;
		var twidth;
		$().ready(function(){
			
			topic = $(".topic-item");
			width = topic.width() - 180;
			if (width < 100 ) width = 100;
			$('div.topic-item span.t-link').css('width',width);

			$('div.topic-item span.t-link a').css('max-width',width);
			
		});

		$(window).resize(function(){
			
			topic = $(".topic-item");
			width = topic.width() - 180;
			if (width < 100 ) width = 100;
			$('div.topic-item span.t-link').css('width',width);

			$('div.topic-item span.t-link a').css('max-width',width);
		});


	</script>


</div>
<?php $this->load->view('footer') ?>