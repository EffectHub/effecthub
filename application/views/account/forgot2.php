<?php $this->load->view('header') ?>
    <div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="<?=base_url()?>images/icon-x-30-white.png" width="15">
	</a>
</div>

<div class="full">
	<h1 class="alt"><?= $this->lang->line('forgot_retrieve'); ?></h1>
</div>

<div id="main" class="site">
<div class="col-about col-about-full under-hero">
<h2 class="section"><?= $this->lang->line('emailconf_step'); ?></h2>

<p><?= $this->lang->line('forgot_content2'); ?></p>
    
</div>
</div>

</div>
<?php $this->load->view('footer') ?>