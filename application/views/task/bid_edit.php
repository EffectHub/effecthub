<?php $this->load->view('header') ?>
	<script src="<?=base_url()?>js/jquery.uploadify.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url().'editor/ueditor/ueditor.config.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'editor/ueditor/ueditor.all.min.js';?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/uploadify.css">
<div id="content" class="group">


<div id="main" style="width:100%">
	
<ul class="tabs">
	<li class="selected"><a href="<?php echo isset($item)?site_url('item/'.$item['id']):'#'?>" class="selected">
	<?= $this->lang->line('bidcreate_edit_bid'); ?>
	</a></li>
	<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('task/'.$task['id'])?>"><?= $this->lang->line('taskcreate_back'); ?></a>
</ul>

	<div id="profile">
	
	<form action="<?=site_url('task/updatebid/'.$bid['id'])?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
<div class="session-form alt" id="infoform" style="display:block;float:left;width:65%">
           <div class="form-field"> 
            <fieldset>
                <div style="width:100%;float:right">
		            <textarea name="desc" id="desc"  style="height: 200px; "  placeholder=""/><?php echo $bid['comment_content']; ?></textarea>
		            <script type="text/javascript">
			    
			    window.UEDITOR_HOME_URL = "<?php echo base_url().'editor/ueditor/';?>";
			    var editor = new UE.ui.Editor();
			    editor.render("desc");
			</script>
			</div>
		            <span id="descError" class="formErrorContent drop-shadow"><?= $this->lang->line('bidcreate_error'); ?></span>
		            </fieldset></div>
		            
		            
			<input type="hidden" name="task" value="<?php echo $task['id']?>"/>
		            <div class="form-btns"><input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('taskedit_update'); ?>" onclick="checkbid()">
			</div>
			
		         </div>   
		            <div class="session-form alt" id="picform" style="display:block;float:right;width:30%">
			<div id="piclist" style="float:left;width:100%;height:auto;display:block;clear:both;">
			<?php foreach ($bid_files as $_bid_file): ?>
				<a target="_blank" href="<?=$_bid_file['download_url']?>">
				<?=$_bid_file['title']?>
				</a><br/>
				<?php endforeach; ?>
			</div>
            <div class="form-field">
            <fieldset>
                <label for="url" style="width:30%"><?= $this->lang->line('bidcreate_attachments'); ?></label>
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
	
		            <?php if ($task['task_type']==2){  ?>
		            <div class="session-form alt" id="sourceform" style="display:block;float:right;width:30%;margin-top:15px">
			<div id="sourcelist" style="float:left;width:100%;height:auto;display:block;clear:both;">
			<?php foreach ($source_files as $_source_file): ?>
				<a target="_blank" href="<?=$_source_file['download_url']?>">
				<?=$_source_file['title']?></a><br/>
				<?php endforeach; ?>
			</div>
            <div class="form-field">
            <fieldset>
                <label for="url" style="width:30%"><?= $this->lang->line('bidcreate_source'); ?></label>
                    <div style="padding-bottom:5px">
                    
			<div style="width:100%;display:block;float:left">
			<div id="sourcequeue"></div>
			<input id="source_upload" name="source_upload" type="file" multiple="true">
			</div>
                    </div>
		            </fieldset>
		            <p class="message" style="margin-left:0px"></p>
		            </div>
		            
	</div>
		            <?php  }?> 
</form>

	</div>


</div>
</div>
</div>
<script type="text/javascript">
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadify({
				'formData'     : {
					'method'   : 'post',
					'type' : '<?php echo $task['type']?>',
					'folder' : '<?php echo isset($folder)?$folder['id']:'0';?>',
					'type_name' : '<?php echo $task['type_name']?>',
					'queueID'  : 'filequeue',
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'buttonClass' : 'disk-upload-button',
				'buttonText' : '<?= $this->lang->line('file_upload') ?>',
				'swf'      : '<?=base_url()?>swf/uploadify.swf',
				'uploader' : '<?=site_url('disk/uploadFile')?>',
				'onUploadSuccess' : function(file, data, response) {
						var filedata = JSON.parse(data);
						var pichtml = "<a href='"+filedata.download_url+"' target='_blank'>"+filedata.title+"</a><br/>"
						$('#piclist').prepend(pichtml);
						var hiddenfield = '<input type="hidden" name="bidfile[]" value="'+filedata.id+'"/>';
				        var a = $('.uploadify-queue').html();
				        $('.uploadify-queue').html(a+hiddenfield);
					
			    }
			});
		});
	</script>
<script type="text/javascript">
		$(function() {
			$('#source_upload').uploadify({
				'formData'     : {
					'method'   : 'post',
					'type' : '<?php echo $task['type']?>',
					'folder' : '<?php echo isset($folder)?$folder['id']:'0';?>',
					'type_name' : '<?php echo $task['type_name']?>',
					'queueID'  : 'sourcequeue',
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'buttonClass' : 'disk-upload-button',
				'buttonText' : '<?= $this->lang->line('source_upload') ?>',
				'swf'      : '<?=base_url()?>swf/uploadify.swf',
				'uploader' : '<?=site_url('disk/uploadFile')?>',
				'onUploadSuccess' : function(file, data, response) {
						var filedata = JSON.parse(data);
						var sourcehtml = "<a href='"+filedata.download_url+"' target='_blank'>"+filedata.title+"</a><br/>"
						$('#sourcelist').prepend(sourcehtml);
						var hiddenfield = '<input type="hidden" name="sourcefile[]" value="'+filedata.id+'"/>';
				        var a = $('.uploadify-queue').html();
				        $('.uploadify-queue').html(a+hiddenfield);
					
			    }
			});
		});
	</script>
<?php $this->load->view('footer') ?>
