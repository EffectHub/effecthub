<?php $this->load->view('header') ?>

<div id="content" class="group">
	
	<div id="main">
		<ul class="tabs">
			<li class="selected"><a href="#" class="selected"><?= $this->lang->line('collectioncreate_create_collection'); ?></a></li>
			<a class="form-sub tagline-action" style="float:right" href="<?=site_url('collection/'.$userid)?>"><?= $this->lang->line('collectioncreate_back'); ?></a>
		</ul>
		<div class="session-form alt" id="profile">
            <form action="<?=site_url('collection/save')?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">
                <div class="form-field">
                    <fieldset>
                        <label for="title"><?= $this->lang->line('collectioncreate_name'); ?></label>
                        <input type="text" class="signin_input txt" id="title" name="name" placeholder="" value="">
                        <span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('collectioncreate_error'); ?></span>
                    </fieldset>
                </div>
                <div class="form-field">
                    <fieldset>
                        <label for="desc"><?= $this->lang->line('collectioncreate_description'); ?></label>
                        <textarea name="desc" id="desc" class="signin_input txt"  style="height: 220px; "  placeholder=""/></textarea>
                    </fieldset>
                </div>
                <div class="form-field">
                    <fieldset>
                        <label for="url"><?= $this->lang->line('collectioncreate_cover_image'); ?></label>
                        <div style="padding-bottom:5px">
                            <input type="text" readonly style="width:220px;display:auto" value="" name="upfile" id="upfile" class="txt create_input">
                            <input type="button" class="form-btn" value="<?= $this->lang->line('collectioncreate_browse'); ?>" onclick="url.click()">
                            <input type="file" id="url" name="url" style="display:none" onchange="upfile.value=this.value" value="">
                            <span id="iconError" class="formErrorContent drop-shadow"><?= $this->lang->line('collectioncreate_error'); ?></span></div>
                    </fieldset>
                </div>
           
                <div class="form-btns">
                    <input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('collectioncreate_create'); ?>" onclick="checkcollection()">
                </div>
            </form>
            
            
            
        </div>
    </div>
</div>
<?php $this->load->view('footer') ?>


