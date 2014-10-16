<?php $this->load->view('header') ?>
<script type="text/javascript" src="<?php echo base_url().'editor/ueditor/ueditor.config.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'editor/ueditor/ueditor.all.min.js';?>"></script>
<div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png" width="15">
	</a>
</div>


<div id="main-800">
	
<ul class="tabs">
	<li class="selected"><a href="#" class="selected"><?= $this->lang->line('topicedit_edit_topic'); ?> </a></li>
	<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('group/'.$group['id'])?>"><?= $this->lang->line('topiccreate_back'); ?></a>
</ul>

	<div class="session-form alt" id="profile">
		<form action="<?=site_url('topic/update')?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
		<div class="form-field">
		<fieldset>
                <label for="title"><?= $this->lang->line('topiccreate_title'); ?></label> 
		            <input type="text" class="signin_input txt" id="title" name="name" placeholder="" value="<?php echo $topic['topic_title']?>">
		            
		            </fieldset></div>
           <div class="form-field"> 
		    <textarea name="desc" id="desc" style="color:black;"><?php echo preg_replace('=<br */?>=i', "",$topic['topic_content']); ?></textarea>
			<script type="text/javascript">
				window.UEDITOR_HOME_URL = "<?php echo base_url().'editor/ueditor/';?>";
			    var editor = new UE.ui.Editor();
			    editor.render("desc");
			</script>
			<div class="form-btns">
			<input type="hidden" name="group" value="<?php echo $group['id']?>"/>
			<input type="hidden" name="topic" value="<?php echo $topic['id']?>"/>
				<input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('topicedit_update'); ?>" onclick="checktopic()">
				<span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('topiccreate_error'); ?></span>
			</div>

</form>	</div>

</div>

</div>
</div>
<?php $this->load->view('footer') ?>