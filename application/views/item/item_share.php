<?php $this->load->view('header') ?>
<div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png" width="15">
	</a>
</div>


<div id="main" style="width:100%">
	
<ul class="tabs">
	<li class="selected"><a href="#" class="selected"><?= $this->lang->line('itemshare_share'); ?></a></li>
</ul>

	<div class="session-form alt" id="profile">
		<form action="<?=site_url('item/save')?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
		<div id="left" style="float:left;width:50%">
		<div class="form-field">
		<fieldset>
                <label for="title"><?= $this->lang->line('itemshare_title'); ?></label> 
		            <input type="text" class="signin_input txt" id="title" name="title" placeholder="" value="<?php echo isset($item)?$item['title']:''; ?>">
		            <span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('itemshare_error'); ?></span>
		            </fieldset>
		            
		            </div>
           <div class="form-field"> 
            <fieldset>
                <label for="desc"><?= $this->lang->line('itemshare_description'); ?></label>
		            <textarea name="desc" id="desc" class="signin_input txt"  style="height: 200px; "  placeholder=""/></textarea>
		            <span id="descError" class="formErrorContent drop-shadow"><?= $this->lang->line('itemshare_error'); ?></span>
		            </fieldset></div>
		    <div class="form-field"> 
            <fieldset>
                <label for="desc"><?= $this->lang->line('itemshare_tags'); ?></label>
		            <input type="text" class="signin_input txt" name="tags" placeholder=""/>
		            </fieldset>
		            <p class="message"><?= $this->lang->line('itemshare_tags_slogan'); ?></p>
		            </div>
		            </div>
		            <div id="right" style="float:right;width:50%">
<div class="form-field">
			<fieldset>
                <label for="type"><?= $this->lang->line('itemshare_category'); ?></label>
		            <select name="type" class="support-select category" id="type" placeholder="Item Type">
						<?php foreach($item_type_list as $_item_type): ?>
						<option <?php echo $_item_type['id']==12?'selected="selected"':'';?> value="<?php echo $_item_type['id']; ?>" name="<?= $_item_type['toolable']?>"><?php echo $lang==2?$_item_type['name_cn']:$_item_type['name']; ?></option>
                        <?php endforeach; ?>
                    </select><br/></fieldset></div>
		            <div class="form-field">
				<fieldset>
                <label for="type"><?= $this->lang->line('itemshare_platform_tool'); ?></label>
                <select name="platform" class="support-select" style="width:29%" id="platform" placeholder="Item Platform">
						<?php foreach($platform_list as $_platform): ?>
						<option value="<?php echo $_platform['id']; ?>" ><?php echo $_platform['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
		            <select name="tool" class="support-select tools" style="width:30%" id="tool" placeholder="Item Tool Used">
						<option value="0" ><?= $this->lang->line('itemshare_none'); ?></option>
						<?php foreach($tool_list as $_tool): ?>
						<option value="<?php echo $_tool['id']; ?>" name="<?=$_tool['type']?>"><?php echo $_tool['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </fieldset>
                    
                    </div>
            <div class="form-field">
            <fieldset>
                <label for="url"><?= $this->lang->line('itemshare_screenshot'); ?></label>
                    <div style="padding-bottom:5px"><input type="text" readonly style="width:200px;display:auto" value="" name="upfile" id="upfile" class="txt create_input">  
						<input type="button" class="form-sub" value="<?= $this->lang->line('item_browse'); ?>" onclick="url.click()"> 
						<input type="file" id="url" name="url" style="display:none" onchange="upfile.value=this.value" value="">
						<span id="screenshotError" class="formErrorContent drop-shadow"><?= $this->lang->line('itemshare_error'); ?></span></div>
		            </fieldset>
		            <p class="message"><?= $this->lang->line('itemshare_screenshot_description'); ?></p>
		            </div>
		            <div class="form-field">
		<fieldset>
                <label for="title"><?= $this->lang->line('itemshare_URL'); ?></label> 
		            <input type="text" class="signin_input txt" id="preview" name="preview" placeholder="" value="<?php echo isset($item)?$item['url']:''; ?>">
		            <span id="previewError" class="formErrorContent drop-shadow"><?= $this->lang->line('itemshare_error'); ?></span>
		            </fieldset>
		            
		            </div>
		            <!--
		            <div class="form-field">
		<fieldset>
                <label for="title"><?= $this->lang->line('item_download_url'); ?></label> 
		            <input type="text" class="signin_input txt" id="download" name="download" placeholder="" value="">
		            <span id="downloadError" class="formErrorContent drop-shadow"><?= $this->lang->line('itemshare_error'); ?></span>
		            </fieldset>
		            
		            </div>
		            -->
		             <div class="form-field">
		    <fieldset>
                <label for="private"><!--<?= $this->lang->line('itemshare_share_out'); ?>--></label>
                    <input value="twitter" <?php echo $this->session->userdata('token_twitter')==null?'disabled':'checked' ?> id="bc_mb_sn" name="socialBind[]" type="checkbox" class="sent_sync_2">
                    <span title="Twitter<?php echo $this->session->userdata('token_twitter')==null?'(Not Connected)':'' ?>" class="ico_twitter"></span>
<input value="facebook" <?php echo $this->session->userdata('token_facebook')==null?'disabled':'checked' ?> id="bc_mb_db" name="socialBind[]" type="checkbox" class="sent_sync_4">
<span title="Facebook<?php echo $this->session->userdata('token_facebook')==null?'(Not Connected)':'' ?>" class="ico_facebook"></span>
<input value="sina" <?php echo $this->session->userdata('token_sina')==null?'disabled':'checked' ?> id="bc_mb_tc" name="socialBind[]" type="checkbox" class="sent_sync_1">
<span title="Weibo<?php echo $this->session->userdata('token_sina')==null?'(Not Connected)':'' ?>" class="ico_sina"></span>
	            </fieldset>
</div>

<div class="form-field">
		    <fieldset>
		    <label for=""></label>
		    </fieldset>
</div>
<div class="form-field">
		    <fieldset>
		    <label for=""></label>
		    </fieldset>
</div>
		    
</div>
			<div class="form-btns" style="text-align:center">
			<input type="hidden" name="share" value="1"/>
				<input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('itemshare_save'); ?>" onclick="checkshare()">
			</div>
</form>	</div>


</div>

<script src="<?=base_url()?>js/category.js" type="text/javascript"></script>
</div>
<?php $this->load->view('footer') ?>