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
	<li class="selected"><a href="#" class="selected">Upload your works</a></li>
</ul>

	<div class="session-form alt" id="profile">
		<form action="<?=site_url('item/save')?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
		<div class="form-field">
		<fieldset>
                <label for="title">Title (Required)</label> 
		            <input type="text" class="signin_input txt" id="title" name="title" placeholder="" value="">
		            <span id="titleError" class="formErrorContent drop-shadow">This field is required</span>
		            </fieldset>
		            
		            </div>
           <div class="form-field"> 
            <fieldset>
                <label for="desc">Description</label>
		            <textarea name="desc" id="desc" class="signin_input txt"  style="height: 200px; "  placeholder=""/></textarea>
		            <span id="descError" class="formErrorContent drop-shadow">This field is required</span>
		            </fieldset></div>
		    <div class="form-field"> 
            <fieldset>
                <label for="desc">Tags</label>
		            <input type="text" class="signin_input txt" name="tags" placeholder=""/>
		            </fieldset>
		            <p class="message">Item Tags, seperated by blank.</p>
		            </div>
		     <div class="form-field"> 
            <fieldset>
                <label for="desc">Price</label>
		            <input type="text" class="signin_input txt" name="price" placeholder=""/>
		            </fieldset>
		            <p class="message">Item Price (You can earn coins by sell your works)</p>
		            </div>
<div class="form-field">
			<fieldset>
                <label for="type">Category</label>
		            <select name="type" class="support-select" id="type" placeholder="Item Type">
						<?php foreach($item_type_list as $_item_type): ?>
						<option value="<?php echo $_item_type['id']; ?>" ><?php echo $_item_type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </fieldset>
                    
                    </div>
                    
                    <div class="form-field">
				<fieldset>
                <label for="type">Platform/Tool</label>
                <select name="platform" class="support-select" style="width:29%" id="platform" placeholder="Item Platform">
						<option value="0" >Platform-independent</option>
						<?php foreach($platform_list as $_platform): ?>
						<option value="<?php echo $_platform['id']; ?>" ><?php echo $_platform['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
		            <select name="tool" class="support-select" style="width:30%" id="tool" placeholder="Item Tool Used">
						<option value="0" >None</option>
						<?php foreach($tool_list as $_tool): ?>
						<option value="<?php echo $_tool['id']; ?>" ><?php echo $_tool['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </fieldset>
                    
                    </div>
                    
            <div class="form-field">
            <fieldset>
                <label for="url">ScreenShot (Required)</label>
                    <div style="padding-bottom:5px"><input type="text" readonly style="width:220px;display:auto" value="" name="upfile" id="upfile" class="txt create_input">  
						<input type="button" class="form-sub" value="browse" onclick="url.click()"> 
						<input type="file" id="url" name="url" style="display:none" onchange="upfile.value=this.value" value="">
						<span id="screenshotError" class="formErrorContent drop-shadow">This field is required</span></div>
		            </fieldset>
		            <p class="message">JPG, GIF or PNG. Max size of 2M.</p>
		            </div>
		     <div class="form-field">
            <fieldset>
                <label for="url">Attachments</label>
                    <div style="padding-bottom:5px"><input type="text" readonly style="width:220px;display:auto" name="upfile1" id="upfile1" class="txt create_input">  
						<input type="button" class="form-sub" value="browse" onclick="attach.click()">  
						<input type="file" id="attach" name="attach" style="display:none" onchange="upfile1.value=this.value"/>
						<span id="attachError" class="formErrorContent drop-shadow">This field is required</span></div>
		            </fieldset>
		            <p class="message">zip file only.</p>
		            </div>
		             <div class="form-field">
		    <fieldset>
                <label for="private">Share to my friends!</label>
                    <input value="twitter" <?php echo $this->session->userdata('token_twitter')==null?'disabled':'checked' ?> id="bc_mb_sn" name="socialBind[]" type="checkbox" class="sent_sync_2">
                    <span title="Twitter<?php echo $this->session->userdata('token_twitter')==null?'(Not Connected)':'' ?>" class="ico_twitter"></span>
<input value="facebook" <?php echo $this->session->userdata('token_facebook')==null?'disabled':'checked' ?> id="bc_mb_db" name="socialBind[]" type="checkbox" class="sent_sync_4">
<span title="Facebook<?php echo $this->session->userdata('token_facebook')==null?'(Not Connected)':'' ?>" class="ico_facebook"></span>
<input value="sina" <?php echo $this->session->userdata('token_sina')==null?'disabled':'checked' ?> id="bc_mb_tc" name="socialBind[]" type="checkbox" class="sent_sync_1">
<span title="Weibo<?php echo $this->session->userdata('token_sina')==null?'(Not Connected)':'' ?>" class="ico_sina"></span>
	            </fieldset>
</div>

			<div class="form-btns">
				<input class="form-sub" name="commit" type="button" value="Upload" onclick="checkupload()">
			</div>
</form>	</div>


</div>


<div class="secondary">

	<h3 id="effecthub-newsletter">Install Desktop Editor to Upload<span class="meta"></span> </h3>

<p class="info">
<iframe src="http://www.effecthub.com/update/badage/index.html" frameborder="0" scrolling="no" width="215" height="180"></iframe>
</p>

<h3 id="effecthub-newsletter">Use Online Editor to Create<span class="meta"></span> </h3>

<a class="form-sub" href="<?php echo site_url('item/new_content/particle')?>">Create</a>
</div>
</div>
<?php $this->load->view('footer') ?>
