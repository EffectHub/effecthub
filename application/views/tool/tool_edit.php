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
	<li class="selected"><a href="#" class="selected"><?= $this->lang->line('tooledit_title') ?> <?php echo $tool['name']; ?></a></li>
	<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('tool/'.$tool['id'])?>"><?= $this->lang->line('toolcreate_back') ?></a>
</ul>

	<div class="session-form alt" id="profile">
		<form action="<?=site_url('tool/update')?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
		<div class="form-field">
		<fieldset>
                <label for="title"><?= $this->lang->line('toolcreate_tool_name') ?></label> 
		            <input type="text" class="signin_input txt" id="title" name="name" placeholder="" value="<?php echo $tool['name']; ?>">
		            <span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('tooladdlink_error') ?></span>
		            </fieldset></div>
		 <div class="form-field">
		<fieldset>
                <label for="title"><?= $this->lang->line('toolcreate_url_name') ?></label> 
		            <input type="text" class="signin_input txt" id="domain" name="domain" placeholder="" value="<?php echo $tool['domain']; ?>">
		            <span id="domainError" class="formErrorContent drop-shadow"><?= $this->lang->line('tooladdlink_error') ?></span>
		            </fieldset>
		            <p class="message">
	<?= $this->lang->line('toolcreate_url_name_slogan') ?><strong><span id="username">urlname</span></strong>
</p>
		            </div>
           <div class="form-field"> 
            <fieldset>
                <label for="desc"><?= $this->lang->line('toolcreate_tool_description') ?></label>
		            <textarea name="desc" id="desc" class="signin_input txt"  style="height: 180px; "  placeholder=""/><?php echo preg_replace('=<br */?>=i', "",$tool['desc']); ?></textarea>
		            <span id="descError" class="formErrorContent drop-shadow"><?= $this->lang->line('tooladdlink_error') ?></span>
		            </fieldset></div>
<div class="form-field">
			<fieldset>
                <label for="type"><?= $this->lang->line('toolcreate_platform_type') ?></label>
                <select name="platform" class="support-select" style="width:29%" id="platform" placeholder="Item Platform">
						<option value="0" ><?= $this->lang->line('toolcreate_platform_independent') ?></option>
						<?php foreach($platform_list as $_platform): ?>
						<option value="<?php echo $_platform['id']; ?>" <?php echo $_platform['id']==$tool['platform']?'selected="selected"':'';?>><?php echo $_platform['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
		            <select name="type" class="support-select" style="width:30%" id="type">
						<?php foreach($item_type_list as $_item_type): ?>
						<option value="<?php echo $_item_type['id']; ?>" <?php echo $_item_type['id']==$tool['type']?'selected="selected"':'';?>><?php echo $_item_type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </fieldset></div>
            <div class="form-field">
            <fieldset>
                <label for="url"><?= $this->lang->line('toolcreate_logo') ?></label>
                    <div style="padding-bottom:5px"><input type="text" readonly style="width:220px;display:auto" value="<?php echo $tool['pic_url']; ?>" name="upfile" id="upfile" class="txt create_input">  
						<input type="button" class="form-btn" value="browse" onclick="url.click()">  
						<input type="hidden" name="last_pic" value="<?php echo $tool['pic_url']; ?>"/>
						<input type="file" id="url" name="url" style="display:none" onchange="upfile.value=this.value" value="<?php echo $tool['pic_url']; ?>">
						<span id="iconError" class="formErrorContent drop-shadow"><?= $this->lang->line('tooladdlink_error') ?></span></div>
		            </fieldset></div>
            <div class="form-field">
            <fieldset>
                <label for="url"><?= $this->lang->line('toolcreate_repository_url') ?></label>
                    <input type="text" class="signin_input txt" id="github" name="github" placeholder="" value="<?php echo $tool['github_url']; ?>">
		            <span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('tooladdlink_error') ?></span>
		            </fieldset>
		            <p class="message"><?= $this->lang->line('toolcreate_repository_slogan') ?></p>
		            </div>

			<div class="form-btns">
			<input type="hidden" name="tool" value="<?php echo $tool['id']?>"/>
				<input class="form-sub" name="commit" type="button" value="Submit" onclick="checktool()">
			</div>
</form>	</div>



</div>
</div>
<?php $this->load->view('footer') ?>
