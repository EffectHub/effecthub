<?php $this->load->view('header') ?>
<script type="text/javascript" src="<?php echo base_url().'editor/ueditor/ueditor.config.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'editor/ueditor/ueditor.all.min.js';?>"></script>
<div id="content" class="group">


<div id="main-800">
	
<ul class="tabs">
	<li class="selected"><a href="<?php echo isset($item)?site_url('item/'.$item['id']):'#'?>" class="selected">
	<?php if (isset($item)){  ?>
	<?= $this->lang->line('topiccreate_process'); ?> <?php echo $item['title']; ?>
	<?php  }else{?>
	<?= $this->lang->line('topiccreate_create_topic'); ?>
	<?php  }?>
	</a></li>
	<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('group/'.$group['id'])?>"><?= $this->lang->line('topiccreate_back'); ?></a>
</ul>

	<div class="session-form alt" id="profile">
		<form action="<?=site_url('topic/save')?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
		<div class="form-field">
		<fieldset>
		            <input type="text" class="signin_input txt" style="width:98%" id="title" name="name" placeholder="<?= $this->lang->line('topiccreate_title'); ?>" value="<?php echo isset($item)?'My Creative Process For My Work: '.$item['title']:''?>">
		           
		            </fieldset></div>
           <div class="form-field"> 
			<textarea name="desc" id="desc" style="color:black;"></textarea>
			<script type="text/javascript">
			    
			    window.UEDITOR_HOME_URL = "<?php echo base_url().'editor/ueditor/';?>";
			    var editor = new UE.ui.Editor();
			    editor.render("desc");
			</script>
			<div class="form-btns" style="padding-left:50%">
			<input type="hidden" name="group" value="<?php echo $group['id']?>"/>
			<input type="hidden" name="item" value="<?php echo isset($item)?$item['id']:0?>"/>
				<input class="form-sub" style="font-size:1em" name="commit" type="button" value="<?= $this->lang->line('topiccreate_create'); ?>" onclick="checktopic()">
				 <span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('topiccreate_error'); ?></span>
			</div>
</form>	</div>


</div>
</div>
</div>
<?php $this->load->view('footer') ?>
