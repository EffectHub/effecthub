<?php $this->load->view('header') ?>
<div id="content" class="group">

<div id="main">
	
<ul class="tabs">
	<li class="selected"><a href="#" class="selected"><?= $this->lang->line('groupedit_edit'); ?></a></li>
	<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('group')?>"><?= $this->lang->line('groupcreate_back'); ?></a>
</ul>

	<div class="session-form alt" id="profile">
		<form action="<?=site_url('group/update')?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
		<div class="form-field">
		<fieldset>
                <label for="title"><?= $this->lang->line('groupcreate_name'); ?></label> 
		            <input type="text" class="signin_input txt" id="title" name="name" placeholder="" value="<?php echo $group['group_name']; ?>">
		            <span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('groupcreate_error'); ?></span>
		            </fieldset></div>
           <div class="form-field"> 
            <fieldset>
                <label for="desc"><?= $this->lang->line('groupcreate_description'); ?></label>
		            <textarea name="desc" id="desc" class="signin_input txt"  style="height: 270px; "  placeholder=""/><?php echo preg_replace('=<br */?>=i', "",$group['group_desc']); ?></textarea>
		            <span id="descError" class="formErrorContent drop-shadow"><?= $this->lang->line('groupcreate_error'); ?></span>
		            </fieldset></div>
<div class="form-field">
			<fieldset>
                <label for="type"><?= $this->lang->line('groupcreate_type'); ?></label>
		            <select name="type" class="support-select" id="type">
						<?php foreach($group_type_list as $_group_type): ?>
						<option value="<?php echo $_group_type['id']; ?>" <?php echo $_group_type['id']==$group['group_type']?'selected="selected"':'';?>><?php echo $_group_type['type_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </fieldset></div>
            <div class="form-field">
            <fieldset>
                <label for="url"><?= $this->lang->line('groupcreate_icon'); ?></label>
                    <div style="padding-bottom:5px">
                    	<input type="text" readonly style="width:220px;display:auto" value="<?php echo $group['group_pic']; ?>" name="upfile" id="upfile" class="txt create_input">  
						<input type="button" class="form-btn" value="<?= $this->lang->line('groupcreate_browse'); ?>" onclick="url.click()">  
						<input type="hidden" name="last_pic" value="<?php echo $group['group_pic']; ?>"/>
						<input type="file" id="url" name="url" style="display:none" onchange="upfile.value=this.value" value="<?php echo $group['group_pic']; ?>">
						<span id="iconError" class="formErrorContent drop-shadow"><?= $this->lang->line('groupcreate_error'); ?></span>
					</div>
		   	</fieldset></div>
		             <div class="form-field">
		    <fieldset>
                <label for="private"><?= $this->lang->line('groupcreate_private'); ?></label>
                    <input type="checkbox" <?php echo $group['is_private']=='on'?'checked':'' ?> name="private" id="private" style="display:inline"> <br /><br />
		            </fieldset>
</div>

			<div class="form-btns">
			<input type="hidden" name="group" value="<?php echo $group['id']?>"/>
				<input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('groupedit_update'); ?>" onclick="checkgroup()">
			</div>
</form>	</div>



</div>
</div>
<?php $this->load->view('footer') ?>
