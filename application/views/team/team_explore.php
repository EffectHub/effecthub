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
	
	<div class="team-explore">
		<?php foreach ($team_list as $_team):?>
		
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
				
				<div class="team-description"><?= $_team['description']; ?></div>
				
				<div class="team-member"><?= $this->lang->line('teammine_members').'('.$_team['people_num'].')'; ?>
					<div class="team-single">
					<?php foreach ($team_member[$_team['team_id']] as $_member): ?>
						<a href="<?= site_url('user/'.$_member['member_id']) ?>"><img src="<?= $_member['pic_url']; ?>" title="<?= $_member['displayName']; ?>" /></a>
					<?php endforeach; ?>
					</div>
				</div>
				
				<div class="team-share"><?php echo $_team['work_num'].' '.$this->lang->line('teammine_shares'); ?></div>
				
				<div class="team-view"><?= $_team['view_num'] ?><img src="<?= base_url('images/icon-views-sm.png'); ?>" /></div>
				
			</div>
		
		<?php endforeach;  ?>
					
	</div>
	
	<div class="page">
		<?php echo $this->pagination->create_links();?>
	</div>
</div>


<div class="secondary my-group">
	
	
	<p><span class="numbers" style="font-size:35px;"><?= $team_count; ?></span> <?= $this->lang->line('teamexplore_team_count'); ?></p>
	<br/>
 
</div>



</div>
<?php $this->load->view('footer') ?>
