<?php $this->load->view('header') ?>
<div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png" width="15">
	</a>
</div>


<div id="main">
	
<ul class="tabs">
	<li class="selected"><a href="#" class="selected"><?= $this->lang->line('itemcreate_title'); ?></a></li>
</ul>
<div class="hero" style="background:none">
<div class="hero-btn" style="margin:20px">
<div class="col-about col-about-full under-hero" style="height:100px;padding:15px;background:#eee;color:#444">
<label><h3 id="effecthub-newsletter"><?= $this->lang->line('itemcreate_game_artist'); ?></h3></label>
			<a href="<?php echo site_url('item/new_content/particle')?>" style="float:left;margin:20px"  onclick="_gaq.push(['_trackEvent', 'create', 'online particle', 'Click online sparticle to create item'])">
				<strong class="title"><?= $this->lang->line('itemcreate_online'); ?></strong> <?= $this->lang->line('itemcreate_online_slogan'); ?>
			</a>
			<a href="<?php echo site_url('disk/1')?>" style="float:left;margin:20px"  onclick="_gaq.push(['_trackEvent', 'create', 'upload work', 'Click upload work to create item'])">
				<strong class="title"><?= $this->lang->line('itemcreate_upload'); ?></strong> <?= $this->lang->line('itemcreate_upload_slogan'); ?>
			</a>
			<!--
			<?php if ($this->session->userdata('level')=='11'){  ?>
			<a target="_blank" href="http://sea3d.poonya.com/studio/" style="float:left;margin:20px">
				<strong class="title">Open Online Model Editor</strong>Support 3D Model/Texture
			</a>
			<?php }  ?>
			-->
</div>
<div class="col-about col-about-full under-hero" style="height:100px;padding:15px;background:#eee;color:#444">
<label><h3 id="effecthub-newsletter"><?= $this->lang->line('itemcreate_game_developer'); ?></h3></label>
			<a href="<?php echo site_url('item/new_content/htmleditor')?>" style="float:left;margin:20px"  onclick="_gaq.push(['_trackEvent', 'create', 'Html5 editor', 'Click html5 editor to create item'])">
				<strong class="title"><?= $this->lang->line('itemcreate_html5'); ?></strong> <?= $this->lang->line('itemcreate_html5_slogan'); ?>
			</a>
			<a href="<?php echo site_url('item/new_content/aseditor')?>" style="float:left;margin:20px"  onclick="_gaq.push(['_trackEvent', 'create', 'AS editor', 'Click as editor to create item'])">
				<strong class="title"><?= $this->lang->line('itemcreate_actionscript'); ?></strong> <?= $this->lang->line('itemcreate_actionscript_slogan'); ?>
			</a>
			<!--
			<a href="<?php echo site_url('tool/submit')?>" style="float:left;margin:20px;margin-top:10px"  onclick="_gaq.push(['_trackEvent', 'create', 'submit tool', 'Click submit tool in create page'])">
				<strong class="title"><?= $this->lang->line('itemcreate_tool'); ?></strong> <?= $this->lang->line('itemcreate_tool_slogan'); ?>
			</a>
			-->
</div>
<div class="col-about col-about-full under-hero" style="height:100px;padding:15px;background:#eee;color:#444">
<label><h3 id="effecthub-newsletter"><?= $this->lang->line('itemcreate_share'); ?></h3></label>
			<a href="<?php echo site_url('item/share')?>" style="float:left;margin:20px"  onclick="_gaq.push(['_trackEvent', 'create', 'share URL', 'Click share URL to share item'])">
				<strong class="title"><?= $this->lang->line('itemcreate_internet'); ?></strong> <?= $this->lang->line('itemcreate_internet_slogan'); ?>
			</a>
			</div>
		</div>
</div>

</div>


<div class="secondary">

	<h3 id="effecthub-newsletter"><?= $this->lang->line('itemcreate_install'); ?><span class="meta"></span> </h3>

<p class="info">
<iframe src="http://www.effecthub.com/update/badage/index.html" frameborder="0" scrolling="no" width="215" height="180"></iframe>
</p>

</div>
</div>
<?php $this->load->view('footer') ?>