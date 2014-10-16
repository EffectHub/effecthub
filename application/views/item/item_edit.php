<?php $this->load->view('header') ?>
<style>
form.gen-form p.message {
	font-size:12px;
}
</style>
<div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png" width="15">
	</a>
</div>

<div id="main" style="width:100%">
	
<ul class="tabs">
	<li class="selected"><a href="#" class="selected"><?= $this->lang->line('itemedit_modify_works'); ?></a></li>
<a class="form-sub tagline-action" style="float:right;" href="<?php echo site_url('item/'.$item['id'])?>"><?= $this->lang->line('item_return'); ?></a>

</ul>
	<div class="session-form alt" id="profile">
		<form action="<?=site_url('item/modify/'.$item['id'])?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
		<div id="left" style="float:left;width:50%">
		<div class="form-field">
		<fieldset>
                <label for="title"><?= $this->lang->line('itemedit_title'); ?></label> 
		            <input type="text" class="signin_input txt" id="title" name="title" placeholder="" value="<?php echo $item['title']; ?>">
		            <span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('itemedit_error'); ?></span>
		            </fieldset>
		            
		            </div>
           <div class="form-field"> 
            <fieldset>
                <label for="desc"><?= $this->lang->line('itemedit_description'); ?></label>
		            <textarea name="desc" id="desc" class="signin_input txt"  style="height: 200px; "  placeholder=""/><?php echo preg_replace('=<br */?>=i', "",$item['desc']); ?></textarea>
		            <span id="descError" class="formErrorContent drop-shadow"><?= $this->lang->line('itemedit_error'); ?></span>
		            </fieldset></div>
		    <div class="form-field"> 
            <fieldset>
                <label for="desc"><?= $this->lang->line('itemedit_tags'); ?></label>
		            <input type="text" class="signin_input txt" name="tags" placeholder="" value="<?php echo $item['tags']; ?>"/>
		            </fieldset>
		            <p class="message"><?= $this->lang->line('itemedit_tags_description'); ?></p>
		            </div>
		</div>
		<div id="right" style="float:right;width:50%">
		     <div class="form-field"> 
            <fieldset>
                <label for="desc"><?= $this->lang->line('itemedit_price'); ?></label>
		            <input type="text" class="signin_input txt" style="width:30%" name="price" placeholder="" value="<?php echo $item['price']; ?>"/>
		           <?php if($this->session->userdata('level')>0){ ?>
		            <select name="price_type" id="price_type" class="support-select" style="width:20%"  placeholder="Price Type" title="<?php echo $item['price_type']; ?>">
						<option <?php echo $item['price_type']==1?'selected="selected"':'';?> value="1" ><?= $this->lang->line('item_pricetype1'); ?></option>
						<option <?php echo $item['price_type']==2?'selected="selected"':'';?> value="2" ><?= $this->lang->line('item_pricetype2'); ?></option>
						<option <?php echo $item['price_type']==3?'selected="selected"':'';?> value="3" ><?= $this->lang->line('item_pricetype3'); ?></option>
                    </select>
                    <?php }else{ ?>
                    <span style="color:#333"><?= $this->lang->line('item_coins'); ?></span>
                    <?php } ?>
		            </fieldset>
		            <p class="message"><?= $this->lang->line('itemedit_price_description'); ?></p>
		            </div>
<div class="form-field">
			<fieldset>
                <label for="type"><?= $this->lang->line('itemedit_category'); ?></label>
		            <select name="type" class="support-select category" id="type" placeholder="Item Type">
						<?php foreach($item_type_list as $_item_type): ?>
						<option <?php echo $_item_type['id']==$item['type']?'selected="selected"':'';?> value="<?php echo $_item_type['id']; ?>" name="<?= $_item_type['toolable']?>"><?php echo $lang==2?$_item_type['name_cn']:$_item_type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </fieldset>
                    
                    </div>
                    
                    <div class="form-field">
				<fieldset>
                <label for="type"><?= $this->lang->line('itemedit_platform_tool'); ?></label>
                <select name="platform" class="support-select" style="width:29%" id="platform" placeholder="Item Platform">
						<option value="0" name="0"><?= $this->lang->line('itemedit_crossplatform'); ?></option>
						<?php foreach($platform_list as $_platform): ?>
						<option <?php echo $_platform['id']==$item['platform']?'selected="selected"':'';?> value="<?php echo $_platform['id']; ?>" ><?php echo $_platform['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span id="itemtool" name="<?php echo $item['tool']?>" style="display:none"></span>
		            <select name="tool" class="support-select tools" style="width:30%" id="tool" placeholder="Item Tool Used">
						<option value="0" name="0">None</option>
						<?php foreach($tool_list as $_tool): ?>
						<option <?php echo $_tool['id']==$item['tool']?'selected="selected"':'';?> value="<?php echo $_tool['id']; ?>" name="<?=$_tool['type']?>"><?php echo $_tool['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </fieldset>
                    
                    </div>
                    
            <div class="form-field">
            <fieldset>
                <label for="url"><?= $this->lang->line('itemedit_screenshot'); ?></label>
                    <div style="padding-bottom:5px"><input type="text" readonly style="width:200px;display:auto" value="<?php echo $item['pic_url']; ?>" name="upfile" id="upfile" class="txt create_input">  
						<input type="button" class="form-btn" value="<?= $this->lang->line('item_browse'); ?>" onclick="url.click()">  
						<input type="file" id="url" name="url" style="display:none" value="<?php echo $item['pic_url']; ?>" onchange="upfile.value=this.value"/>
					</fieldset>
		            <p class="message"><?= $this->lang->line('itemedit_screenshot_description'); ?></p>
		            </div>
		            <?php if ($item['is_share']!=1){  ?>
		     <div class="form-field">
            <fieldset>
                <label for="attach"><?= $this->lang->line('itemedit_attachments'); ?></label>
                    <div style="padding-bottom:5px"><input type="text" readonly style="width:200px;display:auto" value="<?php echo $item['download_url']; ?>" name="upfile1" id="upfile1" class="txt create_input">  
						<input type="button" class="form-btn" value="<?= $this->lang->line('item_browse'); ?>" onclick="attach.click()">  
						<input type="file" id="attach" name="attach" style="display:none" value="<?php echo $item['download_url']; ?>" onchange="upfile1.value=this.value"/>
					</fieldset>
		            <p class="message"><?= $this->lang->line('itemedit_attachements_description'); ?></p>
		            </div>
		             <div class="form-field">
		    <fieldset>
		     <label for="private"></label>
                    <input id="private" <?php echo $item['is_private']==1?'checked':'' ?> value="1" name="is_private" type="checkbox">
                    
                <label for="private" style="display:inline;float:none"><?= $this->lang->line('itemedit_private'); ?></label>
		             </fieldset><p class="message"><?= $this->lang->line('itemedit_private_description'); ?></p>
               
</div>
<?php  }else{?>
	<div class="form-field">
		<fieldset>
                <label for="title"><?= $this->lang->line('itemshare_URL'); ?></label> 
		            <input type="text" class="signin_input txt" id="preview" name="preview" placeholder="" value="<?php echo isset($item)?$item['preview_url']:''; ?>">
		            <span id="previewError" class="formErrorContent drop-shadow"><?= $this->lang->line('itemshare_error'); ?></span>
		            </fieldset>
		            
		            </div>
	<?php  }?>

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

			<div class="form-btns" style="text-align:center;padding-left:42%">
				<input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('itemedit_modify'); ?>" onclick="checkedit()">
			</div>
</form>	</div>


</div>

</div>

<script src="<?=base_url()?>js/category.js" type="text/javascript"></script>

<?php $this->load->view('footer') ?>
