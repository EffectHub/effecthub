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


<div id="main" style="width:100%">
	
<ul class="tabs">
	<li class="selected"><a href="<?php echo isset($item)?site_url('item/'.$item['id']):'#'?>" class="selected">
	<?= $this->lang->line('taskcreate_create_task'); ?>
	</a></li>
	<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('task')?>"><?= $this->lang->line('taskcreate_back'); ?></a>
</ul>

	<div id="profile">
	
	<form action="<?=site_url('task/save')?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
	 <div class="session-form alt" id="typeform" style="display:block;float:left;width:100%">
	<div class="form-field">
			<fieldset>
			<label for="ask1" style="margin-top:5px"><?= $this->lang->line('taskcreate_want'); ?></label>
			
                <input type="radio" id="ask1" checked name="task_type" value="1"><label for="ask1" style="float:none;display:inline;width:50px"><?= $this->lang->line('taskcreate_ask1'); ?></label>
		            
		            <input type="radio" id="ask2" name="task_type" value="2"><label for="ask2" style="float:none;display:inline;width:50px"><?= $this->lang->line('taskcreate_ask2'); ?></label>
		            
                <input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('taskcreate_next'); ?>" onclick="next()">
                    </fieldset>
                    
                    </div>
                     </div>
                    <div class="session-form alt" id="infoform" style="display:none;float:left;width:65%">
	
		            <div class="form-field">
			<fieldset>
                <label for="type"><?= $this->lang->line('taskcreate_type'); ?></label>
		            <select name="type" class="support-select category" id="type" placeholder="Item Type">
						<?php foreach($item_type_list as $_item_type): ?>
						<option value="<?php echo $_item_type['id']; ?>" name="<?= $_item_type['toolable']?>"><?php echo $lang==2?$_item_type['name_cn']:$_item_type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </fieldset>
                    
                    </div>
<div class="form-field">
		<fieldset>
                <label for="title"><?= $this->lang->line('taskcreate_title'); ?></label> 
		            <input type="text" class="signin_input txt" id="title" name="title" placeholder="" value="">
		            <span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('bidcreate_error'); ?></span>
		            </fieldset>
		            
		            </div>
           <div class="form-field"> 
            <fieldset>
                <label for="desc"><?= $this->lang->line('taskcreate_desc'); ?></label>
		            <div style="width:81.5%;float:right">
		            <textarea name="desc" id="desc"  style="height: 200px; "  placeholder=""/></textarea>
		            <script type="text/javascript">
			    
			    window.UEDITOR_HOME_URL = "<?php echo base_url().'editor/ueditor/';?>";
			    var editor = new UE.ui.Editor();
			    editor.render("desc");
			</script>
			</div>
		            <span id="descError" class="formErrorContent drop-shadow"><?= $this->lang->line('bidcreate_error'); ?></span>
		            </fieldset></div>
		            <div class="form-field">
		<fieldset>
                <label for="tag"><?= $this->lang->line('taskcreate_tag'); ?></label> 
		            <input type="text" class="signin_input txt" id="tag" name="task_tag" placeholder="" value="">
		            <span id="tagError" class="formErrorContent drop-shadow"><?= $this->lang->line('bidcreate_error'); ?></span>
		            </fieldset>
		            
		            </div>
		            <div class="form-field">
		<fieldset>
                <label for="price"><?= $this->lang->line('taskcreate_price'); ?></label> 
		            <input type="text" class="signin_input txt" style="width:100px" id="price" name="price" placeholder="" value="10">
		            <input type="radio" id="coin" checked name="price_type" value="1"><label for="coin" style="float:none;display:inline;width:50px"><?= $this->lang->line('taskcreate_coin'); ?></label>
		            <!--
		            <input type="radio" id="cash" name="price_type" value="2"><label for="cash" style="float:none;display:inline;width:50px"><?= $this->lang->line('taskcreate_cash'); ?></label>
		            -->
		            <font color="#999">(<?= $this->lang->line('taskcreate_have'); ?> <span id="totalCoin"><?= $this->session->userdata('point') ?></span> <?= $this->lang->line('taskcreate_coin'); ?> <span id="totalCash"><?= $this->session->userdata('balance') ?></span> <?= $this->lang->line('taskcreate_cash'); ?>)</font>
		            <span id="priceEnoughError" class="formErrorContent drop-shadow"><?= $this->lang->line('task_not_enough'); ?></span>
		            <span id="priceError" class="formErrorContent drop-shadow"><?= $this->lang->line('bidcreate_error'); ?></span>
		            </fieldset>
		            
		            </div>
		            <!--
		            <div class="form-field">
            <fieldset>
                <label for="url"><?= $this->lang->line('bidcreate_attachments'); ?></label>
                    <div style="padding-bottom:5px"><input type="text" readonly style="width:200px;display:auto" name="upfile1" id="upfile1" class="txt create_input">  
						<input type="button" class="form-sub" value="<?= $this->lang->line('attachments_browse'); ?>" onclick="attach.click()">  
						<input type="file" id="attach" name="attach" style="display:none" onchange="upfile1.value=this.value"/>
						<span id="attachError" class="formErrorContent drop-shadow"><?= $this->lang->line('bidcreate_error'); ?></span></div>
		            </fieldset>
		            <p class="message"><?= $this->lang->line('itemedit_attachements_description'); ?></p>
		            </div>
		            -->
		            <div class="form-btns"><input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('taskcreate_create'); ?>" onclick="checktask()">
			</div>
			</div>
			
			<div class="session-form alt" id="picform" style="display:none;float:right;width:30%">
			<div id="piclist" style="float:left;width:100%;height:auto;display:block;clear:both;">
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
</form>

	</div>


</div>
</div>
</div>
<script type="text/javascript">

function next()
{
	if($('#ask1').attr("checked")){
		$("#typeform").css('display','none');
		$("#infoform").css('display','block');
	}else{
		$("#typeform").css('display','none');
		$("#infoform").css('display','block');
		$("#picform").css('display','block');
	}
}
		<?php $timestamp = time();?>
		
		$('#tag').tagsInput({
   "width": "400px",
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
