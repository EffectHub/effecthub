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
        
        
        <div class="cates-show">
			<div class="cates-list">
			
				
				
				<div class="cates-list-info">
					<h3><?= $this->lang->line('groupmine_my_joined_groups'); ?> ( <span class="numbers"><?= count($my_joined_group) ?></span> )</h3>
				</div>
				
				<div class="hotest">
				<?php foreach($my_joined_group as $j_group): ?>
					<div class="hot-group">
					<?php if ($j_group['private'] =='on' ) {?>
    					<img class="private" src="<?= base_url().'images/icon-lock.png' ?>" title="This is a private group"/>
    				<?php }?>
						<a href="<?= site_url('group/'.$j_group['group_id'])?>" title="<?= $j_group['group_name']?>"><img src="<?= $j_group['group_pic']?>"/></a>
						<a class="hot-group-title" href="<?= site_url('group/'.$j_group['group_id'])?>" title="<?= $j_group['group_name']?>"><?= $j_group['group_name']?></a>
						<span class="mem-num"><?= $j_group['member_num']?> <?= $this->lang->line('groupexplore_members'); ?></span>
						
					</div>
			
				<?php endforeach;?>
				</div>
				
		
				
				<div class="cates-list-info">
					<h3><?= $this->lang->line('groupmine_my_managing_groups'); ?> ( <span class="numbers"><?= count($my_managing_group) ?></span> )</h3>
				</div>
				
				
				<div class="hotest">
				<?php foreach($my_managing_group as $m_group): ?>
					<div class="hot-group">
					<?php if ($m_group['is_private'] =='on' ) {?>
    					<img class="private" src="<?= base_url().'images/icon-lock.png' ?>" title="This is a private group"/>
    				<?php }?>
						<a href="<?= site_url('group/'.$m_group['id'])?>" title="<?= $m_group['group_name']?>"><img src="<?= $m_group['group_pic']?>"/></a>
						<a class="hot-group-title" href="<?= site_url('group/'.$m_group['id'])?>" title="<?= $m_group['group_name']?>"><?= $m_group['group_name']?></a>
						<span class="mem-num"><?= $m_group['member_num']?> member<?= $m_group['member_num']>1?'s':'' ?></span>
						
					</div>
			
				<?php endforeach;?>
				</div>
				
				
				
			</div>	
		</div>
        
    </div>
    
    
    <div class="secondary my-group">
		<a href="<?=site_url('account/settings')?>" title="Update my Avatar"><img alt="<?php echo $user['displayName']; ?>" class="photo" style="width:80px;max-height:150px;margin-bottom:5px;border-radius:5px;" src="<?php echo $user['pic_url']; ?>"></a>
		<h3>
			<a href="<?=site_url('user/'.$user['id'])?>"><?php echo $user['displayName']; ?></a>	
		</h3>
		
		<p><span class="numbers"><?= count($my_managing_group) ?></span> <?= $this->lang->line('groupmine_managing_groups'); ?></p>
		<p><span class="numbers"><?= count($my_joined_group) ?></span> <?= $this->lang->line('groupmine_joined_groups'); ?></p>
		
		<a href="<?=site_url('topic/showmytopic') ?>"><?= $this->lang->line('groupmine_all_topics'); ?></a>
	</div>
</div>
	

<?php $this->load->view('footer') ?>
