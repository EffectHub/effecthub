<?php $this->load->view('header') ?>
<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
<div id="content" class="group">
	
	<div id="main">
	<?php if ($step == 1) {?>
	
		<ul class="tabs">
			<li class="selected"><a href="#" class="selected"><?= $this->lang->line('teamcreate_title').$this->lang->line('teamcreate_step_one'); ?></a></li>
			<a class="form-sub tagline-action" style="float:right" href="<?=site_url('team/myteam'); ?>"><?= $this->lang->line('teamcreate_back'); ?></a>
		</ul>
		<div class="session-form alt" id="profile">
            <form action="<?=site_url('team/save')?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">
                <div class="form-field">
                    <fieldset>
                        <label for="title"><?= $this->lang->line('teamcreate_name'); ?></label>
                        <input type="text" class="signin_input txt" id="title" name="name" placeholder="" value="">
                        <span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('teamcreate_error'); ?></span>
                    </fieldset>
                </div>
                <div class="form-field">
                    <fieldset>
                        <label for="desc"><?= $this->lang->line('teamcreate_description'); ?></label>
                        <textarea name="desc" id="desc" class="signin_input txt"  style="height: 220px; "  placeholder=""/></textarea>
                    </fieldset>
                </div>
                <div class="form-field">
                    <fieldset>
                        <label for="url"><?= $this->lang->line('teamcreate_cover_image'); ?></label>
                        <div style="padding-bottom:5px">
                            <input type="text" readonly style="width:220px;display:auto" value="" name="upfile" id="upfile" class="txt create_input">
                            <input type="button" class="form-btn" value="<?= $this->lang->line('teamcreate_browse'); ?>" onclick="url.click()">
                            <input type="file" id="url" name="url" style="display:none" onchange="upfile.value=this.value" value="">
                        </div>
                    </fieldset>
                </div>
                
                <div class="form-field">
                    <fieldset>
                        <label for="upper"><?= $this->lang->line('teamcreate_upper_limit'); ?></label>
                       	<select name="upper" class="support-select" id="upper" placeholder="Team upper">
						
							<option value="5">5</option>
							<option value="10">10</option>
                        	<option value="20">20</option>
                        	<option value="50">50</option>
                        	<option value="100" selected="selected">100</option>
                        	<option value="200">200</option>
                        	<option value="500">500</option>
                        	<option value="1000">1000</option>
                        	<option value="0"><?= $this->lang->line('teamcreate_no_limit') ?></option>
                        	
                    	</select>
                        
                    </fieldset>
                </div>
                
                <div class="form-field">
                    <fieldset>
                        <label for="priority"><?= $this->lang->line('teamcreate_priority'); ?></label>
                       	<select name="priority" class="support-select" id="priority" placeholder="Team priority">
						
							<option value="1"><?= $this->lang->line('teamcreate_priority_one'); ?></option>
							<option value="2" selected="selected"><?= $this->lang->line('teamcreate_priority_two'); ?></option>
                        	<option value="3"><?= $this->lang->line('teamcreate_priority_three'); ?></option>
                        	
                    	</select>
                        
                    </fieldset>
                </div>
                
                
           
                <div class="form-btns">
                    <input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('teamcreate_next'); ?>" onclick="checkteam()">
                </div>
            </form>
                
        </div>
        
        <?php } else if ($step == 2) { ?>
        	<ul class="tabs">
				<li class="selected"><a href="#" class="selected"><?= $this->lang->line('teamcreate_title').$this->lang->line('teamcreate_step_two'); ?></a></li>
			</ul>
        	
        	<div class="session-form alt" id="profile">
           		<form accept-charset="UTF-8" action="<?=site_url('team/create/3') ?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
         		<div style="min-height:400px;">
           			<h3 style="color:#111;margin-left:5%;"><?= $this->lang->line('teamcreate_choose_following') ?></h3>
           		
           			<?php if ($following_list==null) { ?>
           			
			        <p style="color:#333;margin: 10px 0 0 10%;"><?= $this->lang->line('teamcreate_no_following'); ?></p>
           				
           			<?php } else { ?> 
           			<br/>	
           			<div class="select-all">
           				<a href="#" class="team-pick-all form-sub"><?= $this->lang->line('teaminvite_select_all') ?></a> &nbsp;&nbsp;
						<a href="#" class="team-drop-all form-sub"><?= $this->lang->line('teaminvite_select_none') ?></a>	
           			</div>
           			
           			<ul class="following">
           			<?php foreach ($following_list as $_user): ?>
                		
                		<li class="following">
                			
	                		<label>
	                			<img title="<?= $_user['displayName'] ?>" src="<?= $_user['pic_url']; ?>" />
	                			<input type="checkbox" name="choose-following" value="<?= $_user['id'] ?>" id="team-invite"/>  
	                			<p title="<?= $_user['displayName'] ?>"><?= $_user['displayName'] ?></p>
	                		
	                		</label>
                			          			
                		</li>
                		
                	<?php endforeach; } ?>
                	</ul>
                		
           		</div>
           			
                <div class="form-btns">
                    <input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('teamcreate_finish'); ?>" onclick="teaminvite()">
                    <a href="<?=site_url('team/create/3') ?>"><?= $this->lang->line('teamcreate_skip') ?></a>
                    <input type="hidden" value="<?= get_cookie('new_team'); ?>" name="newteam" id="newteam">
                </div>
            
                </form>
        	</div>
        
        
        <?php } else if ($step == 3) {?>
        	<ul class="tabs">
				<li class="selected"><a href="#" class="selected"><?= $this->lang->line('teamcreate_title').$this->lang->line('teamcreate_complete'); ?></a></li>
			</ul>
        	
        	<div class="session-form alt" id="profile">
        		<form accept-charset="UTF-8" action="<?=site_url('team/'.get_cookie('new_team')); ?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
         			<div style="min-height:200px;">
           				<h3 style="color:#111;margin-left:5%;"><?= $this->lang->line('teamcreate_success') ?></h3>
           			</div>
           			
                	<div class="form-btns">
                    	<input class="form-sub" name="commit" type="submit" value="<?= $this->lang->line('teamcreate_view_new_team'); ?>">
                	</div>
            
                </form>
        	</div>
        
        
        <?php }?>
    </div>
</div>
<?php $this->load->view('footer') ?>


