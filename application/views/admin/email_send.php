<?php $this->load->view('header') ?>
<script type="text/javascript" src="<?php echo base_url().'editor/ueditor/ueditor.config.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'editor/ueditor/ueditor.all.min.js';?>"></script>
	
<style>
form.gen-form label {
	width:15%;
}
</style>
<div id="content" class="group">


<div id="main" style="width:100%">
	
<ul class="tabs">
	<li><a href="<?php echo site_url('admin/stats')?>">Stats</a></li>
	<li class="selected"><a href="<?php echo site_url('admin/email')?>" class="selected">Email</a></li>
	<li><a href="<?php echo site_url('admin/feedback')?>">Feedback</a></li>
	<li><a href="<?php echo site_url('admin/user')?>">User</a></li>
	<li><a href="<?php echo site_url('admin/content')?>">Content</a></li>
</ul>

	<div id="profile">
	
	<form action="<?=site_url('admin/email/send')?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
	<div class="session-form alt" id="infoform" style="display:block;float:left;width:65%">
	
	<div class="form-field">
			<fieldset>
				<label for="ask1"></label>
                <input type="radio" id="ask1" checked name="send_type" value="1"><label for="ask1" style="float:none;display:inline;width:50px">All Active Users</label>
		        <input type="radio" id="ask2" name="send_type" value="2"><label for="ask2" style="float:none;display:inline;width:50px">All China Users</label>
		        <input type="radio" id="ask3" name="send_type" value="3"><label for="ask3" style="float:none;display:inline;width:50px">All MVP Users</label>
		     </fieldset>
                    
                    </div>
                    
<div class="form-field">
		<fieldset>
                <label for="title">Title</label> 
		            <input type="text" class="signin_input txt" id="title" name="title" placeholder="" value="">
		            <span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('bidcreate_error'); ?></span>
		            </fieldset>
		            
		            </div>
           <div class="form-field"> 
            <fieldset>
		            <div style="float:right">
		            <textarea name="desc" id="desc"  style="height: 200px; "  placeholder=""/></textarea>
		            <script type="text/javascript">
			    
			    window.UEDITOR_HOME_URL = "<?php echo base_url().'editor/ueditor/';?>";
			    var editor = new UE.ui.Editor();
			    editor.render("desc");
			</script>
			</div>
		            <span id="descError" class="formErrorContent drop-shadow"><?= $this->lang->line('bidcreate_error'); ?></span>
		            </fieldset></div>
		            <div class="form-btns"><input class="form-sub" name="commit" type="button" value="Send Email" onclick="checktask()">
			</div>
			</div>
			
			<div class="session-form alt" id="picform" style="display:block;float:right;width:30%">
			 <div class="form-field">
            <fieldset>
                <label for="url" style="width:100%">Email Sended</label>
                    
		            </fieldset>
		            <p class="message" style="margin-left:0px"></p>
		            </div>
		            
		            
	</div>
</form>

	</div>


</div>
</div>
</div>
<?php $this->load->view('footer') ?>
