<?php $this->load->view('header') ?>
<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
<div id="content" class="group">
	
	<div id="main">
	
		<ul class="tabs">
			<li class="selected"><a href="#" class="selected"><?= $this->lang->line('teamcreate_title'); ?></a></li>
			<a class="form-sub tagline-action" style="float:right" href="<?=site_url('team/'.$team['team_id']); ?>"><?= $this->lang->line('teamcreate_back'); ?></a>
		</ul>
		<div class="session-form alt" id="profile">
            <form action="<?=site_url('team/update/'.$team['team_id'])?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">
                <div class="form-field">
                    <fieldset>
                        <label for="title"><?= $this->lang->line('teamcreate_name'); ?></label>
                        <input type="text" class="signin_input txt" id="title" name="name" placeholder="" value="<?= $team['team_name']; ?>">
                        <span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('teamcreate_error'); ?></span>
                    </fieldset>
                </div>
                <div class="form-field">
                    <fieldset>
                        <label for="desc"><?= $this->lang->line('teamcreate_description'); ?></label>
                        <textarea name="desc" id="desc" class="signin_input txt"  style="height: 220px; "  placeholder=""/><?= $team['description']; ?></textarea>
                    </fieldset>
                </div>
                <div class="form-field">
                    <fieldset>
                        <label for="url"><?= $this->lang->line('teamcreate_cover_image'); ?></label>
                        <div style="padding-bottom:5px">
                            <input type="text" readonly style="width:220px;display:auto" value="<?= $team['pic_url']; ?>" name="upfile" id="upfile" class="txt create_input">
                            <input type="button" class="form-btn" value="<?= $this->lang->line('teamcreate_browse'); ?>" onclick="url.click()">
                            <input type="hidden" name="last_pic" value="<?php echo $team['pic_url']; ?>"/>
                            <input type="file" id="url" name="url" style="display:none" onchange="upfile.value=this.value" value="<?= $team['pic_url']; ?>">
                        </div>
                    </fieldset>
                </div>
                
                <div class="form-field">
                    <fieldset>
                        <label for="upper"><?= $this->lang->line('teamcreate_upper_limit'); ?></label>
                       	<select name="upper" class="support-select" id="upper" placeholder="Team upper">
						
							<option value="5" <?php if ($team['upper_limit']==5){ ?>selected="selected"<?php }?>>5</option>
							<option value="10" <?php if ($team['upper_limit']==10){ ?>selected="selected"<?php }?>>10</option>
                        	<option value="20" <?php if ($team['upper_limit']==20){ ?>selected="selected"<?php }?>>20</option>
                        	<option value="50" <?php if ($team['upper_limit']==50){ ?>selected="selected"<?php }?>>50</option>
                        	<option value="100" <?php if ($team['upper_limit']==100){ ?>selected="selected"<?php }?>>100</option>
                        	<option value="200" <?php if ($team['upper_limit']==200){ ?>selected="selected"<?php }?>>200</option>
                        	<option value="500" <?php if ($team['upper_limit']==500){ ?>selected="selected"<?php }?>>500</option>
                        	<option value="1000" <?php if ($team['upper_limit']==1000){ ?>selected="selected"<?php }?>>1000</option>
                        	<option value="0" <?php if ($team['upper_limit']==0){ ?>selected="selected"<?php }?>><?= $this->lang->line('teamcreate_no_limit') ?></option>
                        	
                    	</select>
                        
                    </fieldset>
                </div>
                
                <div class="form-field">
                    <fieldset>
                        <label for="priority"><?= $this->lang->line('teamcreate_priority'); ?></label>
                       	<select name="priority" class="support-select" id="priority" placeholder="Team priority">
						
							<option value="1" <?php if ($team['priority']==1){ ?>selected="selected"<?php }?>><?= $this->lang->line('teamcreate_priority_one'); ?></option>
							<option value="2" <?php if ($team['priority']==2){ ?>selected="selected"<?php }?>><?= $this->lang->line('teamcreate_priority_two'); ?></option>
                        	<option value="3" <?php if ($team['priority']==3){ ?>selected="selected"<?php }?>><?= $this->lang->line('teamcreate_priority_three'); ?></option>
                        	
                    	</select>
                        
                    </fieldset>
                </div>
                
           
                <div class="form-btns">
                    <input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('teamedit_finish'); ?>" onclick="checkteam()">
                </div>
            </form>
                
        </div>
        
    </div>
</div>
<?php $this->load->view('footer') ?>


