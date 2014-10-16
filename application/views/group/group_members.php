<?php $this->load->view('header') ?>
<div id="content" class="group">
<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png?1376325170" width="15">
	</a>
</div>

<div class="full">
	<div class="group">
		<h1 class="alt"><img src="<?php echo $group['group_pic']; ?>" class="group-img"> <?php echo $group['group_name']; ?> <?= $this->lang->line('groupmembers_group'); ?></h1>
		<div style="margin-top:5px;"><a href="<?php echo site_url('group/allgroup/'.$group['group_type'])?>" title="group type"><?php echo $group['type_name']; ?></a></div>
	</div>
</div>

<div id="main">
		
	<div class="cates-list-info">
		<h3><?= $this->lang->line('groupmembers_members'); ?> (<?= $group['member_num']?>)</h3>
	</div>
		
	<div class="hotest">
	<?php foreach($user_list as $member): ?>
		<div class="group-icon" style="float:left;height:120px;width:120px">
			<a href="<?= site_url('user/'.$member['user_id'])?>" title="<?= $member['user_name'] ?>">
        		<img width="40px" height="40px" style="margin-left:40px;" src="<?= $member['user_pic'] ?>" />
       			<h5><?= $member['user_name'] ?></h5>
        	</a>
		</div>
	<?php endforeach;?>
	</div>		
	
	<div class="page" style="clear:both;">
		<?php echo $this->pagination->create_links();?>
	</div>
	
</div>


<div class="secondary">
<h3><?= $this->lang->line('groupmembers_about'); ?> <span class="meta"></span></h3>
<div style="line-height:20px;font-size:14px">
<p><?php echo $group['group_desc']; ?></p>
<br />
<p><?= $this->lang->line('groupmembers_administrator'); ?> <a href="<?=site_url('user/'.$group['admin_id'])?>"><?php echo $group['author_name']; ?></a></p>
</div>
<br/>
<a href="<?= site_url('group/'.$group['id']) ?>">>><?= $this->lang->line('groupmembers_back'); ?> <?= $group['group_name'] ?> <?= strtolower($this->lang->line('groupmembers_group')); ?></a>

</div>


</div>
<?php $this->load->view('footer') ?>
