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

	<h1 class="about"><?= $this->lang->line('itemprivate_title'); ?></h1>
	<p class="callout"><?= $this->lang->line('itemprivate_set'); ?>
	<br/><br/>
	<?php if(($item['pic_url']!=null&&$item['pic_url']!='')){ ?>
<h3 class="more-from more-from-player"><?= $this->lang->line('itemprivate_screenshot'); ?><span class="meta"></span></h3>
<ol class="prevnext group" style="margin-top:10px">
<li>	<img alt="<?php echo $item['title']; ?>" style="width:300px;" src="<?php echo $item['thumb_url']; ?>"></li>
</ol><br/>
<?php  }?>
	<a class="form-sub tagline-action" href="<?php echo site_url('home')?>"><?= $this->lang->line('itemnone_return'); ?></a>
	<a class="form-sub tagline-action" href="<?php echo site_url('user/writemail/'.$item['author_id'])?>"><?= $this->lang->line('itemprivate_contact'); ?></a>
	</p>
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