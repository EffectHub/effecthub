<?php $this->load->view('header') ?>
<div id="content" class="group">
<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">

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
	
	<h3><?php if ($read==0) {
	 		echo $notice_count.' '.$this->lang->line('teamnotice_unread_title');
		} else {
			echo $notice_count.' '.$this->lang->line('teamnotice_read_title');
		} ?>
	</h3>
	
	<?php if ($notice) {?>
	<div class="team-notice">
		
		<?php foreach ($notice as $item): ?>
		
		<div class="notice-single">
			<?php if ($item['notice_type']==1) { 
			if ($read==0) {?>
			<a href="<?= site_url('user/'.$item['producer_id']); ?>"><?= $item['producer_name'] ?></a> <?= $this->lang->line('teamnotice_invite'); ?> <a href="<?= site_url('team/'.$item['team_id']) ?>"><?= $item['team_name'] ?></a> 
			<?php } else { 
				if ($item['read']==1) {
					echo $this->lang->line('teamnotice_invite_success'); ?> <a href="<?= site_url('team/'.$item['team_id']) ?>"><?= $item['team_name'] ?></a>
					<?php } else { 
					echo $this->lang->line('teamnotice_invite_ignore'); ?> <a href="<?= site_url('team/'.$item['team_id']) ?>"><?= $item['team_name'] ?></a>
			<?php } }

			} else if ($item['notice_type']==2) {?>
			<a href="<?= site_url('user/'.$item['producer_id']); ?>"><?= $item['producer_name'] ?></a> <?= $this->lang->line('teamnotice_comment1'); ?> <a href="<?= $read==0?site_url('team/get_comment/'.$item['notice_id']):site_url('team/'.$item['team_id']) ?>"><?= $item['team_name'] ?></a> <?= $this->lang->line('teamnotice_comment2'); ?>
			
			<?php } else if ($item['notice_type']==4) {
				if ($read==0) {?>
			<a href="<?= site_url('user/'.$item['producer_id']) ?>"><?= $item['producer_name'] ?></a> <?= $this->lang->line('teamnotice_apply_team'); ?> <a href="<?= site_url('team/'.$item['team_id']); ?>"><?= $item['team_name'] ?></a> <a href="<?= site_url('team/accept_join/'.$item['notice_id'].'/1'); ?>"><?= $this->lang->line('teamnotice_accept'); ?></a> <a href="<?= site_url('team/deny_join/'.$item['notice_id'].'/1'); ?>"><?= $this->lang->line('teamnotice_deny'); ?></a>
			<?php } else {
				echo $item['read']==1?$this->lang->line('teamnotice_apply_success1'):$this->lang->line('teamnotice_apply_fail') ?> <a href="<?= site_url('user/'.$item['producer_id']) ?>"><?= $item['producer_name'] ?></a> <?= $this->lang->line('teamnotice_apply_success2') ?> <a href="<?= site_url('team/'.$item['team_id']) ?>"><?= $item['team_name'] ?></a> <?= $this->lang->line('teamnotice_apply_tail');
				 
			} } else if ($item['notice_type']==5) {?>
			<a href="<?= $read==0?site_url('team/join_notice/'.$item['notice_id']):site_url('team/'.$item['team_id']); ?>"><?= $item['team_name'] ?></a> <?= $this->lang->line('teamnotice_join_success'); ?>
			
			<?php } else if ($item['notice_type']==6) {?>
			<a href="<?= $read==0?site_url('team/join_notice/'.$item['notice_id']):site_url('team/'.$item['team_id']); ?>"><?= $item['team_name'] ?></a> <?= $this->lang->line('teamnotice_join_fail'); ?>
			
			<?php } else if ($item['notice_type']==3) {?>
			<a href="<?= $read==0?site_url('team/join_notice/'.$item['notice_id']):site_url('team/'.$item['team_id']); ?>"><?= $item['team_name'] ?></a> <?= $this->lang->line('teamnotice_delete'); ?>
			
			<?php } else if ($item['notice_type']==8) {?>
			<a href="<?= $read==0?site_url('team/join_notice/'.$item['notice_id']):site_url('team/'.$item['team_id']); ?>"><?= $item['team_name'] ?></a> <?= $this->lang->line('teamnotice_position_change'); ?>
			
			<?php } ?>
			<div style='float:right; color:#999; font-size:12px'><?php echo tranTime(strtotime($item['create_date'])); ?></div>
		</div>
		
		<?php endforeach; ?>
 		
 		<div class="page">
			<?php echo $this->pagination->create_links();?>
		</div>
 		
 	</div>
 	<?php } ?>
	
</div>


<div class="secondary my-group">
	<a href="<?=site_url('account/settings')?>" title="Update my Avatar"><img alt="<?php echo $user['displayName']; ?>" class="photo" style="width:80px;max-height:150px;margin-bottom:5px;border-radius:5px;" src="<?php echo $user['pic_url']; ?>"></a>
	<h3>
		<a href="<?=site_url('user/'.$user['id'])?>"><?php echo $user['displayName']; ?></a>	
	</h3>
	<br/>
	
	<div>
	<?php if ($read==0) {?>
	<a href="<?= site_url('team/notice/1') ?>"><?= $this->lang->line('teamnotice_view_read') ?></a>
	<?php } else { ?>
	<a href="<?= site_url('team/notice/0') ?>"><?= $this->lang->line('teamnotice_view_unread') ?></a>
	<?php } ?>
	<br/><br/>
	<a href="<?= site_url('team/myteam') ?>"><?= $this->lang->line('teamnotice_back') ?></a>
	</div>
		
 
</div>



</div>
<?php $this->load->view('footer') ?>
