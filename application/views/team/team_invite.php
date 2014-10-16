<?php $this->load->view('header') ?>
<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
<div id="content" class="group">
	
	<div id="main">
	
        	<ul class="tabs">
				<li class="selected"><a href="#" class="selected"><?= $this->lang->line('teaminvite_title'); ?></a></li>
			</ul>
        	
        	<div class="session-form alt" id="profile">
           		<form accept-charset="UTF-8" action="<?=site_url('team/invite_done/'.$team) ?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
         		<div style="min-height:400px;">
           			<h3 style="color:#111;margin-left:5%;"><?= $this->lang->line('teaminvite_following') ?></h3>
           		
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
                    <input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('teaminvite_finish'); ?>" onclick="teaminvite()">
                    <a href="<?=site_url('team/'.$team) ?>"><?= $this->lang->line('teaminvite_back') ?></a>
                    <input type="hidden" value="<?= $team; ?>" name="newteam" id="newteam">
                </div>
            
                </form>
        	</div>
        
    </div>
</div>
<?php $this->load->view('footer') ?>


