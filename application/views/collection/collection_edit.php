<?php $this->load->view('header') ?>

<div id="content" class="group">
	
	<div id="main">
		<ul class="tabs">
			<li class="selected"><a href="#" class="selected"><?= $this->lang->line('collectionedit_edit_collection'); ?></a></li>
			<a class="form-sub tagline-action" style="float:right" href="<?= site_url('collection/show/'.$collect['id'])?>"><?= $this->lang->line('collectioncreate_back'); ?></a>
		</ul>
		<div class="session-form alt" id="profile">
            <form action="<?=site_url('collection/update')?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">
                <div class="form-field">
                    <fieldset>
                        <label for="title"><?= $this->lang->line('collectioncreate_name'); ?></label>
                        <input type="text" class="signin_input txt" id="title" name="name" placeholder="" value="<?php echo $collect['title'];?>">
                        <span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('collectioncreate_error'); ?></span>
                    </fieldset>
                </div>
                <div class="form-field">
                    <fieldset>
                        <label for="desc"><?= $this->lang->line('collectioncreate_description'); ?></label>
                        <textarea name="desc" id="desc" class="signin_input txt"  style="height: 220px; "  placeholder=""/><?php echo preg_replace('=<br */?>=i', "",$collect['description']); ?></textarea>
                    </fieldset>
                </div>
                <div class="form-field">
                    <fieldset>
                        <label for="url"><?= $this->lang->line('collectioncreate_cover_image'); ?></label>
                        <div style="padding-bottom:5px">
                        	<input type="text" readonly style="width:220px;display:auto" value="<?php echo $collect['pic_url']; ?>" name="upfile" id="upfile" class="txt create_input">  
                            <input type="button" class="form-btn" value="<?= $this->lang->line('collectioncreate_browse'); ?>" onclick="url.click()">  
							<input type="hidden" name="last_pic" value="<?php echo $collect['pic_url']; ?>"/>
							<input type="file" id="url" name="url" style="display:none" onchange="upfile.value=this.value" value="<?php echo $collect['pic_url']; ?>">
                            <span id="iconError" class="formErrorContent drop-shadow"><?= $this->lang->line('collectioncreate_error'); ?></span>
                        </div>
                    </fieldset>
                </div>
      
                <div class="form-btns">
                	<input type="hidden" name="collection" value="<?php echo $collect['id']?>"/>
                    <input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('collectionedit_update'); ?>" onclick="checkcollection()">
                </div>
            </form>
            
            
            
        </div>
    </div>
</div>
<?php $this->load->view('footer') ?>


