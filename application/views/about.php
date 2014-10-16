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

	<h1 class="about"><?= $this->lang->line('about_about') ?></h1>
	<img alt="icons" class="about-ball" style="border-radius:8px;"  src="http://www.effecthub.com/img/default.jpg" width="80">
	<p class="callout"><?= $this->lang->line('about_desc') ?></p>
	</div>
	<div class="col-about col-about-full under-hero">
	<h1 class="about"><?= $this->lang->line('about_history') ?></h1>
	<p class="callout"><?= $this->lang->line('about_history_desc') ?>          
	</p>
	</div>
	<!--
	<h2 class="section">Our Team <span class="meta"></span></h2>

	<ul class="slats">
		<li class="group">
			<div class="meta">
				<img alt="avatar" class="avatar" src="http://www.effecthub.com/uploads/avatar/1000002_thumb.jpg">
				<span class="links">
					<a href="http://www.disound.com" rel="tipsy" original-title="Disound's Blog"><img alt="Blog" src="<?=base_url()?>images/icon-team-blog.png"></a>
					<a href="http://twitter.com/disound" rel="tipsy" original-title="Disound on Twitter"><img alt="Twitter" src="<?=base_url()?>images/icon-team-twitter.png"></a>
					<a href="http://facebook.com/disound" rel="tipsy" original-title="Disound on Facebook"><img alt="GitHub" src="<?=base_url()?>images/icon-team-facebook.png"></a>
				</span>
			</div>

			<h3><a href="people/disound">disound</a></h3>

			<h4>Co-Founder</h4>

			<p></p>

			<p></p>
		</li>
	</ul>
	-->
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