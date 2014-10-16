<?php $this->load->view('header') ?>
    <div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="<?=base_url()?>images/icon-x-30-white.png" width="15">
	</a>
</div>



<div id="main" class="site">
	<div class="col-about col-about-full under-hero">

	<h1 class="about"><?= $this->lang->line('teamforbidden_title'); ?></h1>
	<p class="callout"><?= $this->lang->line('teamforbidden_forbidden'); ?>
	<br/><br/>
	<a class="form-sub tagline-action" href="<?php echo site_url('team/myteam')?>"><?= $this->lang->line('teamnone_return'); ?></a>
	</p>
	<?php if ($this->session->userdata('id')) { 
		if ($invite>0) { ?>
	
	<p><?= $this->lang->line('teamforbidden_invite') ?>  
	<a class="form-sub" href="<?= site_url('team/accept') ?>"><?= $this->lang->line('teamforbidden_accept') ?></a>    
	<a class="form-sub" href="<?= site_url('team/ignore') ?>"><?= $this->lang->line('teamforbidden_ignore') ?></a>
	</p>
	
	<?php } else if ($apply == 0){ ?>
	<a class="form-sub tagline-action" href="<?= site_url('team/apply/'.$team) ?>"><?= $this->lang->line('teamforbidden_apply') ?></a>
	
	<?php } else { ?>
		<p><?= $this->lang->line('teamforbidden_already_apply'); ?></p>
		
	<?php } }?>
	</div>
	
</div>

<div class="secondary">

	<h3>Follow <span class="meta">EffectHub</span></h3>

	<ul class="follow">
		<li class="group"><a href="http://twitter.com/effecthub"><img alt="Twitter" src="<?=base_url()?>images/icon-team-twitter.png"> EffectHub on Twitter</a></li>
		<li class="group"><a href="http://facebook.com/effecthub"><img alt="Facebook" src="<?=base_url()?>images/icon-team-facebook.png"> EffectHub on Facebook</a></li>
		<li class="group"><a href="http://weibo.com/effecthub"><img alt="Weibo" src="<?=base_url()?>images/icon-team-weibo.png"> EffectHub on Weibo</a></li>
	</ul>
<!--
	<h3 id="effecthub-newsletter">Subscribe <span class="meta">EffectHub</span> </h3>

<p class="info">Sign up for our newsletter to receive periodic news, updates, featured content, and more.</p>

<form action="" method="post" id="subForm" class="gen-form">
	<fieldset>
		<input type="text" style="background: rgba(255, 255, 255, 1);" placeholder="Enter email" class="placeholder">
		<input type="submit" value="Subscribe" class="form-sub">
	</fieldset>
</form>
-->
</div>


</div>
<?php $this->load->view('footer') ?>