<?php $this->load->view('header') ?>

<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
<div id="content" class="group">
    <div id="main">
        <ul class="tabs">
            <?php if ($this->session->userdata('id')){  ?>
            <li class="groups <?php echo $feature=='mygroup'?'active':'' ?>"><a href="<?php echo site_url('group/mygroup')?>"><?= $this->lang->line('header_groups_my_groups'); ?></a></li>
            <?php  }?>        
            <li class="groups <?php echo $feature=='groups'?'active':'' ?>"> <a href="<?=site_url('group/')?>"><span class="meta"><?= $this->lang->line('header_groups_explore_groups'); ?></span> <span class="count"></span> </a> </li>
			<?php if ($this->session->userdata('id')){  ?>
            <a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('group/create')?>"><?= $this->lang->line('groupall_create_group'); ?></a>
            <?php  }?> 
        </ul>
        
        <div class="group-main">
        	
        	<div class="group-header">
        		<h3><?= $this->lang->line('grouphome_usually'); ?></h3>
        	</div>
        	<div class="group-viewmine">
        		<a href="<?=site_url('group/showmygroup') ?>"><?= $this->lang->line('grouphome_see_all_groups'); ?></a>
        	</div>
        	<div class="group-hot">
        		<?php if ($my_hot_groups) {
        			foreach ($my_hot_groups as $groups):?>
        		<div class="group-item">
        			<div class="group-icon">
        				<?php if ($groups['private'] =='on' ) {?>
    						<img class="private" src="<?= base_url().'images/icon-lock.png' ?>" title="<?= $this->lang->line('grouphome_private'); ?>"/>
    					<?php }?>
        			
        				<a href="<?= site_url('group/'.$groups['group_id'])?>" title="<?= $groups['group_name'] ?>">
        					<img width="100px" height="100px" src="<?= $groups['group_pic'] ?>" />
        					<h5><?= $groups['group_name'] ?></h5>
        				</a>
        			</div>
        			<div class="group-topic">
        				<?php foreach ($groups['topic'] as $topic):?>
        				<div class="group-topic-single">
        					<a href="<?= site_url('topic/'.$topic['id']) ?>" title="View comments of this topic"><span class="t-comment-num"><?= $topic['comment_num'] ?></span></a>
        					<span class="t-link">
        						<a href="<?= site_url('topic/'.$topic['id']) ?>" title="<?=$topic['topic_title'] ?>"><?=$topic['topic_title'] ?></a>
        					</span>
        					<span class="t-reply-time"><?= tranTime(strtotime($topic['last_comment_time'])) ?></span>
        				</div>
        				<?php endforeach;?>
        			</div>
        			
        			<div class="view-topic">
        				<a href="<?= site_url('group/'.$groups['group_id'])?>"><?= $this->lang->line('grouphome_enter'); ?></a>
        			</div>
        			
        		</div>
        		<?php endforeach;
        		} else {?>
        		
        		<p><?= $this->lang->line('grouphome_no_groups'); ?></p>
				<?php }?>
        	</div>
        	
        	<div class="group-header">
        		<h3><?= $this->lang->line('grouphome_published_topics'); ?></h3>
        	</div>
          	<div class="group-viewmine">
        		<a href="<?=site_url('topic/showmytopic') ?>"><?= $this->lang->line('grouphome_see_all_topics'); ?></a>
        	</div>
        	
        	<div class="my-topic">
        		<?php if ($my_topics) {
        			foreach ($my_topics as $topics):?>
        		<div class="topic-item">
        			<a href="<?= site_url('topic/'.$topics['id']) ?>" title="View comments of this topic"><span class="t-comment-num"><?= $topics['comment_num'] >99?'99+':$topics['comment_num'] ?></span></a>
        			<span class="t-link">
        				<a href="<?= site_url('topic/'.$topics['id']) ?>" title="<?=$topics['topic_title'] ?>"><?=$topics['topic_title'] ?></a>
        			</span>
        			<span class="t-reply-time"><?= $topics['comment_num']>0? $this->lang->line('groupexplore_last_replied'):''; ?> <?= tranTime(strtotime($topics['last_comment_time'])) ?></span>
        			<span class="t-group"><a href="<?= site_url('group/'.$topics['group_id']) ?>" title="<?=$topics['group_name'] ?>"><?= $topics['group_name'] ?></a></span>
        		</div>
        		<?php endforeach;
        		} else {?>
        		
        		<p><?= $this->lang->line('grouphome_no_topics'); ?></p>
				<?php }?>

        	</div>
        	
        </div>
        
        
    </div>
    
    
    <div class="secondary my-group">
		<a href="<?=site_url('account/settings')?>" title="Update my Avatar"><img alt="<?php echo $user['displayName']; ?>" class="photo" style="width:80px;max-height:150px;margin-bottom:5px;border-radius:5px;" src="<?php echo $user['pic_url']; ?>"></a>
		<h3>
			<a href="<?=site_url('user/'.$user['id'])?>"><?php echo $user['displayName']; ?></a>	
		</h3>
		
		<p>
			<?= $this->lang->line('groupexplore_my_groups'); ?> <a href="<?=site_url('group/showmygroup') ?>"><?= $group_num ?></a>
		</p>
		<p>
			<?= $this->lang->line('groupexplore_my_topics'); ?> <a href="<?=site_url('topic/showmytopic') ?>"><?= $topic_num ?></a>
		</p>
		
	</div>
</div>
	
	<script>

		var item;
		var topic;
		var width;
		var twidth;
		$().ready(function(){
			item = $(".group-item");
			width = item.width() - 130;
			$('.group-topic').css('width',width);
			twidth = width - 180;
			if (twidth < 100 ) twidth = 100;
			$('div.group-topic-single span.t-link').css('width',twidth);
			
			topic = $(".topic-item");
			width = topic.width() - 180;
			if (width < 100 ) width = 100;
			$('div.topic-item span.t-link').css('width',width);
		});

		$(window).resize(function(){
			item = $(".group-item");
			width = item.width() - 130;
			$('.group-topic').css('width',width);
			twidth = width - 180;
			if (twidth < 100 ) twidth = 100;
			$('div.group-topic-single span.t-link').css('width',twidth);

			topic = $(".topic-item");
			width = topic.width() - 180;
			if (width < 100 ) width = 100;
			$('div.topic-item span.t-link').css('width',width);
		});


	</script>

<?php $this->load->view('footer') ?>
