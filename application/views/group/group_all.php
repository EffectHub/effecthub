<?php $this->load->view('header') ?>

<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
<div id="content" class="group">

 
    <div class="secondary my-group">	
    	
    	<div class="group-type">
    		<h4><?= $this->lang->line('groupall_select_type'); ?></h4>
    		<ul>
			<?php foreach ($group_type as $_types): ?>
				<?php if ($type == $_types['id']) { ?>
				<li class="type-selected"><< <?= ($lang == 2)?$_types['name_cn']:$_types['type_name']; ?></li>
				<?php } else {?>
				<li> 
					<a href="<?= site_url('group/allgroup/'.$_types['id']) ?>"><?= ($lang == 2)?$_types['name_cn']:$_types['type_name']; ?></a>
				</li>
				<?php }?>
			<?php endforeach;?>
			</ul>
		</div>
		
	</div>

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
					<h3><?= ($lang == 2)?$type_name['name_cn']:$type_name['type_name']; ?></h3>
				</div>
				
				<div class="hotest">
				<?php foreach($groups as $group): ?>
					<div class="hot-group">
						<a href="<?= site_url('group/'.$group['id'])?>" title="<?= $group['group_name']?>"><img src="<?= $group['group_pic']?>"/></a>
						<a class="hot-group-title" href="<?= site_url('g/'.$group['key'])?>" title="<?= $group['group_name']?>"><?= $group['group_name']?></a>
						<span class="mem-num"><?= $group['member_num']?> <?= $this->lang->line('groupexplore_members'); ?></span>
						<span class="topic-num"><?= $group['topic_num']?> <?= $this->lang->line('groupexplore_topics'); ?></span>
					</div>
			
				<?php endforeach;?>
				</div>
				
				
			</div>	
		</div>
        
    </div>
    
   
</div>
	

<?php $this->load->view('footer') ?>
