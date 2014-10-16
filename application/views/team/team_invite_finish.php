<?php $this->load->view('header') ?>
<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
<div id="content" class="group">
	
	<div id="main">
	
        	<ul class="tabs">
				<li class="selected"><a href="#" class="selected"><?= $this->lang->line('teaminvite_title'); ?></a></li>
			</ul>
        	
        	<div class="session-form alt" id="profile">
        		<form accept-charset="UTF-8" action="<?=site_url('team/'.$team); ?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
         			<div style="min-height:200px;">
           				<h3 style="color:#111;margin-left:5%;"><?= $this->lang->line('teaminvite_success') ?></h3>
           			</div>
           			
                	<div class="form-btns">
                    	<input class="form-sub" name="commit" type="submit" value="<?= $this->lang->line('teaminvite_back'); ?>">
                	</div>
            
                </form>
        	</div>

    </div>
</div>
<?php $this->load->view('footer') ?>


