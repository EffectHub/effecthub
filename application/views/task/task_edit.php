<?php $this->load->view('header') ?>

	<script src="<?=base_url()?>js/jquery.uploadify.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.tagsinput.js" type="text/javascript"></script>
	
<script type="text/javascript" src="<?php echo base_url().'editor/ueditor/ueditor.config.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'editor/ueditor/ueditor.all.min.js';?>"></script>
	
	
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/uploadify.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jquery.tagsinput.css">
<style>
form.gen-form label {
	width:15%;
}
</style>
<div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png" width="15">
	</a>
</div>


<div id="main" style="width:100%">
	
<ul class="tabs">
	<li class="selected"><a href="#" class="selected"><?= $this->lang->line('taskedit_edit_task'); ?> </a></li>
	<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('task/'.$task['id'])?>"><?= $this->lang->line('taskcreate_back'); ?></a>
</ul>

	<div id="profile">
		<form action="<?=site_url('task/update')?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
		<div class="session-form alt" id="infoform" style="display:block;float:left;width:65%">
		<div class="form-field">
			<fieldset>
			<label for="ask1"></label>
                <input type="radio" id="ask1" <?php echo $task['task_type']==1?'checked':''?> name="task_type" value="1"><label for="ask1" style="float:none;display:inline;width:50px"><?= $this->lang->line('taskcreate_ask1'); ?></label>
		            
		            <input type="radio" id="ask2" <?php echo $task['task_type']==2?'checked':''?> name="task_type" value="2"><label for="ask2" style="float:none;display:inline;width:50px"><?= $this->lang->line('taskcreate_ask2'); ?></label>
		            
                
                    </fieldset>
                    
                    </div>
		<div class="form-field">
			<fieldset>
                <label for="type"><?= $this->lang->line('taskcreate_type'); ?></label>
		            <select name="type" class="support-select category" id="type" placeholder="Item Type">
						<?php foreach($item_type_list as $_item_type): ?>
						<option <?php echo $_item_type['id']==$task['type']?'selected="selected"':'';?> value="<?php echo $_item_type['id']; ?>" ><?php echo $lang==2?$_item_type['name_cn']:$_item_type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </fieldset>
                    
                    </div>
<div class="form-field">
		<fieldset>
                <label for="title"><?= $this->lang->line('taskcreate_title'); ?></label> 
		            <input type="text" class="signin_input txt" id="title" name="title" placeholder="" value="<?php echo $task['title']?>">
		            <span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('itemshare_error'); ?></span>
		            </fieldset>
		            
		            </div>
           <div class="form-field"> 
            <fieldset>
                <label for="desc"><?= $this->lang->line('taskcreate_desc'); ?></label>
                <div style="width:81.5%;float:right">
		            <textarea name="desc" id="desc"  style="height: 200px; "  placeholder=""/><?php echo $task['desc']; ?></textarea>
		            <script type="text/javascript">
			    
			    window.UEDITOR_HOME_URL = "<?php echo base_url().'editor/ueditor/';?>";
			    var editor = new UE.ui.Editor();
			    editor.render("desc");
			</script>
			</div>
		            <span id="descError" class="formErrorContent drop-shadow"><?= $this->lang->line('itemshare_error'); ?></span>
		            </fieldset></div>
		            <div class="form-field">
		<fieldset>
                <label for="tag"><?= $this->lang->line('taskcreate_tag'); ?></label> 
		            <input type="text" class="signin_input txt" id="tag" name="task_tag" placeholder="" value="<?php echo $task['task_tag']?>">
		            <span id="tagError" class="formErrorContent drop-shadow"><?= $this->lang->line('bidcreate_error'); ?></span>
		            </fieldset>
		            
		            </div>
		            <div class="form-field">
		<fieldset>
                <label for="price"><?= $this->lang->line('taskcreate_price'); ?></label> 
		            <input type="text" <?php echo $task['response_num']>1?'readonly':'readonly'?> class="signin_input txt" style="width:100px" id="price" name="price" placeholder="" value="<?php echo $task['price']?>">
		            <input type="radio" id="coin" <?php echo $task['price_type']==1?'checked':''?> name="price_type" value="1"><label for="coin" style="float:none;display:inline;width:50px"><?= $this->lang->line('taskcreate_coin'); ?></label>
		            <!--
		            <input type="radio" id="cash" <?php echo $task['price_type']==2?'checked':''?> name="price_type" value="2"><label for="cash" style="float:none;display:inline;width:50px"><?= $this->lang->line('taskcreate_cash'); ?></label>
		            -->
		            <span id="priceError" class="formErrorContent drop-shadow"><?= $this->lang->line('itemshare_error'); ?></span>
		            </fieldset>
		            
		            </div>
		
		    <div class="form-btns">
			<input type="hidden" name="task" value="<?php echo $task['id']?>"/>
				<input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('taskedit_update'); ?>" onclick="checktask()">
				<span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('taskcreate_error'); ?></span>
			</div>
			</div>

<div class="session-form alt" id="picform" style="display:block;float:right;width:30%">
			<div id="piclist" style="float:left;width:100%;height:auto;display:block;clear:both;">
			<?php foreach ($task_files as $_source_file): ?>
				<a target="_blank" href="<?=$_source_file['download_url']?>">
				<?=$_source_file['title']?></a><br/>
				<?php endforeach; ?>
			</div>
            <div class="form-field">
            <fieldset>
                <label for="url" style="width:30%"><?= $this->lang->line('taskcreate_attachments'); ?></label>
                    <div style="padding-bottom:5px">
                    
			<div style="width:100%;display:block;float:left">
			<div id="filequeue"></div>
			<input id="file_upload" name="file_upload" type="file" multiple="true">
			</div>
                    </div>
		            </fieldset>
		            <p class="message" style="margin-left:0px"></p>
		            </div>
		            
		            
	</div>
	
</form>	</div>

</div>

</div>
</div>
<script type="text/javascript">
		<?php $timestamp = time();?>
		
		$('#tag').tagsInput({
   "width": "370px",
		        	"height": "34px",
		        	'defaultText':''
});
		$(function() {
			$('#file_upload').uploadify({
				'formData'     : {
					'method'   : 'post',
					'type' : $('#type').attr('value'),
					'folder' : '<?php echo isset($folder)?$folder['id']:'0';?>',
					'type_name' : 'Other',
					'queueID'  : 'filequeue',
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'buttonClass' : 'disk-upload-button',
				'buttonText' : '<?= $this->lang->line('taskcreate_attachments') ?>',
				'swf'      : '<?=base_url()?>swf/uploadify.swf',
				'uploader' : '<?=site_url('disk/uploadFile')?>',
				'onUploadSuccess' : function(file, data, response) {
						var filedata = JSON.parse(data);
						var pichtml = "<a href='"+filedata.download_url+"' target='_blank'>"+filedata.title+"</a><br/>"
						$('#piclist').prepend(pichtml);
						var hiddenfield = '<input type="hidden" name="taskfile[]" value="'+filedata.id+'"/>';
				        var a = $('.uploadify-queue').html();
				        $('.uploadify-queue').html(a+hiddenfield);
					
			    }
			});
		});
	</script>
<?php $this->load->view('footer') ?>