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
		<?= $this->lang->line('teamexplore_unlogin'); ?>
		<a href="<?=site_url('register')?>" class="form-sub tagline-action"><?= $this->lang->line('teamexplore_sign_up'); ?></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('teamexplore_sign_up_twitter'); ?>" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('teamexplore_sign_up_facebook'); ?>" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('teamexplore_sign_up_google'); ?>" class="auth-google tagline-action" href="<?=site_url('login/google')?>"></a>
		<!--<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>-->
	</h1>
</div>
<?php  }?>

<div id="main">
	<ul class="tabs">
		<?php if ($this->session->userdata('id')){  ?>
		<li class="groups <?php echo $feature=='myteam'?'active':'' ?>"><a href="<?php echo site_url('team/myteam')?>"><?= $this->lang->line('header_teams_my_teams'); ?></a></li>
		<?php  }?>        
		<li class="groups <?php echo $feature=='teams'?'active':'' ?>"> <a href="<?=site_url('team/explore')?>"><span class="meta"><?= $this->lang->line('header_teams_explore_teams'); ?></span> <span class="count"></span></a></li>
		<?php if ($this->session->userdata('id')){  ?>
		<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('team/create/1')?>"><?= $this->lang->line('teamexplore_create_team'); ?></a>
		<?php  }?>
	</ul>
	<div class="team-main">
		<?php if ($team_list == null) {?>
			
		<p class="no-team"><?= $this->lang->line('teammine_no_team') ?></p>
		
		<?php } else  
		
		foreach ($team_list as $_team):?>
		
			<div class="single-team">
				<a class="team-link" href="<?= site_url('team/'.$_team['team_id']); ?>" title="<?= $_team['team_name']; ?>">
					<img src="<?= $_team['pic_url']; ?>" />
					<div class="team-name"><h3><?= $_team['team_name']; ?></h3></div>
				</a>
				<div class="team-leader"><?= $this->lang->line('teammine_leader'); ?> 
					<?php if ($_team['leader_id'] == null||$_team['leader_id'] == 0) { 
						echo $this->lang->line('teammine_no_leader');
					} else { ?>
					<a href="<?= site_url('user/'.$_team['leader_id']) ?>" title="<?= $_team['leader_name'] ?>"><?= $_team['leader_name'] ?></a> 
					<?php } ?>
				</div>
				<div class="team-member"><?php echo $_team['people_num'].' '.$this->lang->line('teammine_members'); ?></div>
				<div class="team-share"><?php echo $_team['work_num'].' '.$this->lang->line('teammine_shares'); ?></div>
				<div class="team-view"><?= $_team['view_num'] ?><img src="<?= base_url('images/icon-views-sm.png'); ?>" /></div>
			</div>
		
		<?php endforeach; ?>
					
	</div>
	
	<div class="page">
		<?php echo $this->pagination->create_links();?>
	</div>
	
	
	
</div>


<div class="secondary">
	<a href="<?=site_url('account/settings')?>" title="Update my Avatar"><img alt="<?php echo $user['displayName']; ?>" class="photo" style="width:80px;max-height:150px;margin-bottom:5px;border-radius:5px;" src="<?php echo $user['pic_url']; ?>"></a>
		<h3>
			<a href="<?=site_url('user/'.$user['id'])?>"><?php echo $user['displayName']; ?></a>	
		</h3>
		
		<p><span class="numbers"><?= $team_count; ?></span> <?= $this->lang->line('teammine_team_count'); ?></p>
		<br/>
		<p><span class="numbers"><a href="<?= site_url('team/notice/0'); ?>"><?= $notice_count; ?></a></span> <?= $this->lang->line('teammine_team_notice'); ?></p>
		
		<?php if ($notice) {?>
		<div>
		<?php foreach ($notice as $item): ?>
		
		<div class="notice-single">
			<?php if ($item['notice_type']==1) { ?>
			
			<a href="<?= site_url('user/'.$item['producer_id']); ?>"><?= $item['producer_name'] ?></a> <?= $this->lang->line('teamnotice_invite'); ?> <a href="<?= site_url('team/'.$item['team_id']) ?>"><?= $item['team_name'] ?></a> 
			
			<?php } else if ($item['notice_type']==2) {?>
			<a href="<?= site_url('user/'.$item['producer_id']); ?>"><?= $item['producer_name'] ?></a> <?= $this->lang->line('teamnotice_comment1'); ?> <a href="<?= site_url('team/get_comment/'.$item['notice_id']) ?>"><?= $item['team_name'] ?></a> <?= $this->lang->line('teamnotice_comment2'); ?>
			
			<?php } else if ($item['notice_type']==4) {?>
			<a href="<?= site_url('user/'.$item['producer_id']) ?>"><?= $item['producer_name'] ?></a> <?= $this->lang->line('teamnotice_apply_team'); ?> <a href="<?= site_url('team/'.$item['team_id']); ?>"><?= $item['team_name'] ?></a> <a href="<?= site_url('team/accept_join/'.$item['notice_id']); ?>"><?= $this->lang->line('teamnotice_accept'); ?></a> <a href="<?= site_url('team/deny_join/'.$item['notice_id']); ?>"><?= $this->lang->line('teamnotice_deny'); ?></a>
			
			<?php } else if ($item['notice_type']==5) {?>
			<a href="<?= site_url('team/join_notice/'.$item['notice_id']); ?>"><?= $item['team_name'] ?></a> <?= $this->lang->line('teamnotice_join_success'); ?>
			
			<?php } else if ($item['notice_type']==6) {?>
			<a href="<?= site_url('team/join_notice/'.$item['notice_id']); ?>"><?= $item['team_name'] ?></a> <?= $this->lang->line('teamnotice_join_fail'); ?>
			
			<?php } else if ($item['notice_type']==3) {?>
			<a href="<?= site_url('team/join_notice/'.$item['notice_id']); ?>"><?= $item['team_name'] ?></a> <?= $this->lang->line('teamnotice_delete'); ?>
			
			<?php } else if ($item['notice_type']==8) {?>
			<a href="<?= site_url('team/join_notice/'.$item['notice_id']); ?>"><?= $item['team_name'] ?></a> <?= $this->lang->line('teamnotice_position_change'); ?>
			
			<?php } ?>
			
		</div>
		
		<?php endforeach; ?>
 		
 		</div>
 		<?php } ?>
 		<br/>
 		<a href="<?= site_url('team/notice/0'); ?>" style="font-size:12px;"><?= $this->lang->line('teammine_all_notice') ?></a>
 		
</div>


</div>
<?php $this->load->view('footer') ?>
