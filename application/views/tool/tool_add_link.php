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
	<li class="selected"><a href="#" class="selected"> <?php echo $tool['name']; ?>: <?= $this->lang->line('tooladdlink_add_link') ?></a></li>
	<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('tool/'.$tool['id'])?>"><?= $this->lang->line('tooladdlink_back') ?></a>
</ul>

	<div class="session-form alt" id="profile">
		<form action="<?=site_url('tool/savelink')?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
		<div class="form-field">
		<fieldset>
                <label for="title"><?= $this->lang->line('tooladdlink_link_name') ?></label> 
		            <input type="text" class="signin_input txt" id="title" name="name" placeholder="" value="">
		            <span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('tooladdlink_error') ?></span>
		            </fieldset></div>
		 <div class="form-field">
		<fieldset>
                <label for="title"><?= $this->lang->line('tooladdlink_url') ?></label> 
		            <input type="text" class="signin_input txt" id="url" name="url" placeholder="" value="">
		            <span id="urlError" class="formErrorContent drop-shadow"><?= $this->lang->line('tooladdlink_error') ?></span>
		            </fieldset>
		            <p class="message">
	<?= $this->lang->line('tooladdlink_url_slogan') ?>
</p>
		            </div>
           <div class="form-field"> 
            <fieldset>
                <label for="desc"><?= $this->lang->line('tooladdlink_description') ?></label>
		            <textarea name="desc" id="desc" class="signin_input txt"  style="height: 180px; "  placeholder=""/></textarea>
		            <span id="descError" class="formErrorContent drop-shadow"><?= $this->lang->line('tooladdlink_error') ?></span>
		            </fieldset>
		            <p class="message">
	<?= $this->lang->line('tooladdlink_description_slogan') ?>
</p>
		            </div>

			<div class="form-btns">
			<input type="hidden" name="tool" value="<?php echo $tool['id']?>"/>
				<input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('tooladdlink_save') ?>" onclick="checklink()">
			</div>
</form>	</div>



</div>
</div>
<?php $this->load->view('footer') ?>