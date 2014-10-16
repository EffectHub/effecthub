<?php $this->load->view('header') ?>

<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="<?=base_url()?>js/jquery.leanModal.min.js"></script>
<link href="<?=base_url()?>css/file.css" media="screen, projection" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>css/share.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="<?=base_url()?>js/file.js"></script>
	<script src="<?=base_url()?>js/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/uploadify.css">
<div id="content" class="group">
<div id="main" class="full-800">
	<?php if (!$this->session->userdata('id')){  ?>
<div class="full full-pitch group">
	<h1 class="compact">
		<strong>EffectHub is connecting the world's gaming designers and developers.</strong>
		
		<a href="<?=site_url('register')?>" class="form-sub tagline-action">Sign up</a>
		<a rel="tipsy" original-title="Sign up with your Twitter account" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Facebook account" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Google account" class="auth-google tagline-action" href="<?=site_url('login/google')?>"></a>
		<!--<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>-->
	</h1>
</div>
<?php  }?>
<ul class="tabs">
<?php if ($this->session->userdata('id')){  ?>
			<?php if ($nav=='works'){  ?>
	<li class="<?php echo $feature=='assets'?'active':'' ?>">
		<a href="<?=site_url('disk')?>" class="has-dd"><?= $this->lang->line('header_home_files'); ?></a>
	</li>
	
	<li class="<?php echo $feature=='projects'?'active':'' ?>">
		<a href="<?=site_url('project')?>" class="has-dd"><?= $this->lang->line('header_home_projects'); ?></a>
	</li>
	<li class="<?php echo $feature=='following'?'active':'' ?>">
		<a href="<?=site_url('home/newsfeed')?>" class="has-dd"><?= $this->lang->line('header_home_following'); ?></a>

	</li>

		<li class="<?php echo $feature=='Suggestions'?'active':'' ?>">
			<a href="<?=site_url('home/suggestion')?>"><?= $this->lang->line('header_home_suggestions'); ?></a>
		</li>
	<li class="">
		<a href="<?=site_url('item/mywatch/'.$this->session->userdata('id'))?>"><?= $this->lang->line('header_home_watching'); ?></a>
	</li>
	<li class="<?php echo $feature=='Happening'?'active':'' ?>">
		<a href="<?=site_url('home/happening')?>"><?= $this->lang->line('header_home_happening'); ?></a>
	</li>
	<!--
	<li class="">
		<a href="<?=site_url('item/mylike/'.$this->session->userdata('id'))?>">Favorite</a>
	</li>
	<li class="">
		<a href="<?=site_url('user/'.$this->session->userdata('id'))?>">Own</a>
	</li>
	-->
<?php  }?>
		<?php  }?>
			<?php if ($nav=='explore'){  ?>
	<li class="<?php echo $feature=='MostAppreciated'?'active':'' ?>">
		<a href="<?=site_url('item/featured/MostAppreciated')?>"><?= $this->lang->line('header_explore_picks'); ?></a>
	</li>
	<li class="<?php echo $feature=='MostDiscussed'?'active':'' ?>">
		<a href="<?=site_url('item/featured/MostDiscussed')?>"><?= $this->lang->line('header_explore_popular'); ?></a>
	</li>
	<li class="<?php echo $feature=='MostRecent'?'active':'' ?>">
		<a href="<?=site_url('item/featured/MostRecent')?>"><?= $this->lang->line('header_explore_recent'); ?></a>
	</li>
	<!--
	<li class="<?php echo $feature=='tag'?'active':'' ?>">
		<a href="<?=site_url('tag')?>">Tags</a>
	</li>-->
	<li class="<?php echo $feature=='author'?'active':'' ?>">
		<a href="<?=site_url('author')?>"><?= $this->lang->line('header_explore_authors'); ?></a>
	</li>
	<?php  }?>
	<a class="form-sub tagline-action" style="float:right;margin-bottom:5px" href="<?php echo site_url('invite/email')?>"><?= $this->lang->line('header_invite'); ?></a>
</ul>
<section class="main clearfix" style="background-color:#FFF;font-size:12px;border-radius: 5px;">
<section class="aside" style="margin-left:0px;">
                       
                       <ul class="b-list-3" id="aside-menu">
                         <li class="b-list-item"><a class="sprite2 <?php echo $type=='all'?'on':'' ?>" style="margin:0" hidefocus="true" href="<?=site_url('disk')?>" id="tab-home" unselectable="on"><span class="text1"><span class="img-ico aside-disk"></span><?= $this->lang->line('file_all_files'); ?></span></a></li>
                        <?php foreach($item_type_list as $_type): ?>
                     <li class="b-list-item"><a cat="2" class="b-no-ln type-a-pic <?php echo $type==$_type['id']?'on':'' ?>" style="margin:0;font-weight:normal;color:#666" hidefocus="true" href="<?=site_url('disk/'.$_type['id'])?>"><span class="text1"><span class="img-ico aside-m<?php echo $_type['icon']; ?>"></span><?php echo $lang == '2'?$_type['name_cn']:$_type['name']; ?></span></a></li>
                       <?php endforeach; ?>
                       <li class="b-list-item separator-1"></li>
                       <li class="b-list-item"><a class="sprite2 b-no-ln" hidefocus="true" target="_blank" href="<?=site_url('user/'.$this->session->userdata('id'))?>" id="tab-share" unselectable="on"><span class="text1"><span class="img-ico aside-share"></span><?= $this->lang->line('file_my_share'); ?></span></a></li>
                       <li class="b-list-item separator-1"></li>
                       
</ul>
<div class="clearfix my-share" id="awardBubbleP" style="margin-left: 28px;">
<ul>
<li class="clearfix hidden">
<em class="gt sprite-ic"></em><span class="pay-quota">Out of Date</span><a class="pay-quota" href="#" target="_blank">View</a>
</li>
<li class="clearfix relative">
<div class="remainingSpaceUi">
<span class="remainingSpaceUi_span" id="remainingSpaceUi_tail" style="width: <?php echo $percent ?>px; background-color: rgb(52, 130, 218); background-position: initial initial; background-repeat: initial initial;"></span>
</div>
<div class="remainingSpace">
<span id="remainingSpace"><?php echo getRealSize($total_size) ?></span><span>/<?php echo getRealSize($space) ?></span>
</div>
</li>

<li class="clearfix b-rlv"><a class="b-no-ln b-rlv" href="http://www.effecthub.com/topic/222" target="_blank"><?= $this->lang->line('file_upgrade'); ?></a></li>

</ul>
</div>
</section>
<section class="pan" id="subwindowContainer" style="margin-left: 209px;">
<div class="pan-inner b-bdr-2" id="panInner">
<section class="fns">
<div id="header-shaw">
<div class="location clearfix b-header b-bdr-7">
<ul class="bar-cmd-view-list clearfix">
<li><a class="select" href="javascript:;" id="barCmdViewList" title="View By List"><span></span></a></li>
<li class="end"><a href="javascript:;" id="barCmdViewSmall" title="View By Thumbnail"><span></span></a></li>
</ul>
<?php if ($type=='all'){  ?>
<ul class="line"> 
<?php foreach($status_list as $_status): ?>
<li style="margin-top: 0px;color:#333" class="status">
<a target="_blank" href="<?=site_url('user/'.$_status['user_id'])?>"><?php echo $_status['author_name']; ?></a>

<?php if ($_status['status_type']==1) { 
	                                	echo $this->lang->line('userstatus_type1'); ?>
                                		<a target="_blank" href="<?= site_url('user/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==2) {
                                		echo $this->lang->line('userstatus_type2'); ?>
                                		<a target="_blank" href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                	
                                	<?php } else if ($_status['status_type']==3) {
                                		echo $this->lang->line('userstatus_type3'); ?>
                                		<a target="_blank" href="<?= site_url('topic/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==4) {
                                		echo $this->lang->line('userstatus_type4'); ?>
                                		<a target="_blank" href="<?= site_url('team/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                		
                                	<?php } else if ($_status['status_type']==5) {
                                		echo $this->lang->line('userstatus_type5'); ?>
                                		<a target="_blank" href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==6) {
                                		echo $this->lang->line('userstatus_type6'); ?>
                                		<a target="_blank" href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==7) {
                                		echo $this->lang->line('userstatus_type7'); ?>
                                		
                                	<?php } else if ($_status['status_type']==8) {
                                		echo $this->lang->line('userstatus_type8'); ?>
                                		<a target="_blank" href="<?= site_url('topic/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==9) {
                                		echo $this->lang->line('userstatus_type9'); ?>
                                		<a target="_blank" href="<?= site_url('collection/show/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==10) {
                                		echo $this->lang->line('userstatus_type10'); ?>
                                		<a target="_blank" href="<?= site_url('collection/show/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==11) {
                                		echo $this->lang->line('userstatus_type11'); ?>
                                		<a target="_blank" target="_blank" href="<?= site_url('collection/show/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==12) {
                                		echo $this->lang->line('userstatus_type12'); ?>
                                		<a target="_blank" href="<?= site_url('folder/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                		
                                	<?php } else if ($_status['status_type']==13) {
                                		echo $this->lang->line('userstatus_type13'); ?>
                                		<a target="_blank" href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==14) {
                                		echo $this->lang->line('userstatus_type14'); ?>
                                		<a target="_blank" href="<?= site_url('folder/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==15) {
                                		echo $this->lang->line('userstatus_type15'); ?>
                                		<a target="_blank" href="<?= site_url('group/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==16) {
                                		echo $this->lang->line('userstatus_type16'); ?>
                                		<a target="_blank" href="<?= site_url('group/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==17) {
                                		echo $this->lang->line('userstatus_type17'); ?>
                                		<a target="_blank" href="<?= site_url('folder/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==18) {
                                		echo $this->lang->line('userstatus_type18'); ?>
                                		<a target="_blank" href="<?= site_url('folder/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==19) {
                                		echo $this->lang->line('userstatus_type19'); ?>
                                		<a target="_blank" href="<?= site_url('task/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==20) {
                                		echo $this->lang->line('userstatus_type20'); ?>
                                		<a target="_blank" href="<?= site_url('task/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==21) {
                                		echo $this->lang->line('userstatus_type21'); ?>
                                		<a target="_blank" href="<?= site_url('task/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } ?>
<span style="color:#999;margin-left:20px"><?php echo tranTime(strtotime($_status['timestamp'])); ?></span>

<!-- 
<?php echo $_status['action']; ?> 
                                <?php if ($_status['content']!=''&&$_status['content']!=null){  ?>
                                <?php echo $_status['content']; ?>
                                <?php  }else{?>
                                <a target="_blank" href="<?php echo $_status['target_url']?>"><?php echo $_status['target_name']?></a>	
                                <?php  }?>	 <span style="color:#999;margin-left:20px"><?php echo tranTime(strtotime($_status['timestamp'])); ?></span>
    -->                             
</li>
 <?php endforeach; ?>
</ul><?php  }?>
<div style="display:<?php echo $type=='all'?'none':'' ?>;float:left"   onclick="_gaq.push(['_trackEvent', 'uploadBtn', 'clicked', 'Click Upload Button'])">
<input id="file_upload" name="file_upload" type="file" multiple="true">
</div>
<ul class="b-list-2 bar-cmd-list" style="display:<?php echo $type=='all'?'none':'' ?>;margin-left:20px">
<li class="b-list-item">
<a href="javascript:" id="barCmdNewFolder"   onclick="_gaq.push(['_trackEvent', 'folderBtn', 'clicked', 'Click New Folder Button'])"><div id="file_upload-button" class="uploadify-button disk-upload-button" style="height: 30px; line-height: 30px; width: 120px;margin:-1px 0 0 0;"><span class="uploadify-button-text"><?= $this->lang->line('folder_new'); ?></span></div></a></li>
<!--
<li class="b-list-item b-rlv">
		<a class="lbtn icon-pl35" href="javascript:;" id="barCmdUpload" _i="6"><em class="icon-update"></em><b>Upload</b></a><form class="html5-uploader-ctrl" action="javascript:;" method="post"><input multiple="" accept="*/*" id="_disk_id_8" type="file" name="html5uploader" class="html5-uploader-ctrl-fld"></form>
		</li>

<li class="b-list-item">
<a class="icon-btn-download" style="display:none" hidefocus="true" href="javascript:;" id="barCmdOffline" title="Download" _i="11">Download</a>
</li>
<li class="b-list-item b-rlv" style="display:none">
<em class="new sellfile"></em>
<a class="icon-btn-sellfile" hidefocus="true" href="javascript:;" id="barCmdSellFile" title="Sale" _i="18">Sale</a></li>
-->
</ul>

</div>
<div class="list-loc dir-path clearfix" label="All Files">
<li><a class="a-back disabled" href="javascript:;" id="parentDir" title="Return"></a></li>
<li id="dirPath">
<?php if ($this->session->userdata('id')&&$this->session->userdata('verified')==0&&$this->session->userdata('email')!=null&&$this->session->userdata('email')!=''){  ?>
<div style="color: #000;display:<?php echo $type=='all'?'':'none' ?>;float:left">
<h2><?= $this->lang->line('file_upgrade_slogan'); ?></h2>
</div>
<?php  }?>
<!--
<a class="b-no-ln" href="<?=site_url('disk/'.$type)?>" id="dirRoot">All</a>-->
<?php if (isset($parent_folder)){  ?>
	<a class="b-no-ln" deep="1" href="<?=site_url('folder/'.$parent_folder['id'])?>"><?=$parent_folder['folder_name'] ?></a>
<?php }  ?>	
<?php if (isset($folder)){  ?>
	<span class="gray">&nbsp;&nbsp;&gt;&nbsp;&nbsp;</span>
	<span class="last" style="color:#000"><?=$folder['folder_name'] ?></span>
<?php }  ?>	
<span id="dirLocation"> </span>
</li>
<li id="dirData">
<span><span class="loadedDate" style="color:#000"><?=isset($folder_count)?$folder_count. ' Folders':'' ?> <?=isset($item_count)?$item_count. ' Files':'' ?> <?php echo isset($folder_size)?getRealSize($folder_size):'' ?></span></span>
</li>
<li id="dirData" style="display:none">
<span><span class="loadedDate"><?= $this->lang->line('file_loading'); ?></span></span>
</li>
</div>
</div>
<div class="b-rlv share-line clearfix">
<div class="property-trs clearfix" id="propertyFilePathContainer" style="display:none">
<span class="property-spans property-stable"><?= $this->lang->line('file_path'); ?></span>
<span class="property-spans property-data" id="property-file-path" style="work-break:break-all;width:140px;word-wrap:break-word"></span>
</div>
<section class="files">
<header id="netdiskTips">
<div class="close-tips"></div>
<div class="tips"><em class="sprite-ic"></em>test<a href="javascript:;" id="share_tips_show">test</a></div>
</header>
<div class="all-files-headers">
<header class="files-header b-header b-bdr-7" id="fileActionHeader" style="display: none;">
<p>
<span style="display:none" class="b-fl input-cbx selectionArbitrate"><dfn><s class="sprite"></s></dfn></span>
<span id="file_action_word"></span>
<span class="clearfix" id="file_action_buttons">
<a class="bbtn none disabled" hidefocus="true" href="javascript:;" id="barCmdPlayAll" _i="9"><em class="icon-play-music"></em><b><?= $this->lang->line('file_play'); ?></b></a>
<a class="bbtn" hidefocus="true" href="javascript:;" id="barCmdShareAll" _i="2"><em class="icon-share"></em><b><?= $this->lang->line('file_share'); ?></b></a>
<a class="bbtn" hidefocus="true" href="javascript:;" id="barCmdCancelShare" _i="0"><em class="icon-share-cancle"></em><b><?= $this->lang->line('file_unshare'); ?></b></a>
<a class="bbtn" hidefocus="true" href="javascript:;" id="barCmdDownload" _i="8"><em class="icon-download"></em><b><?= $this->lang->line('file_download'); ?></b></a>
<a class="bbtn" hidefocus="true" href="javascript:;" id="barCmdDelete" _i="1"><em class="icon-clear-file"></em><b><?= $this->lang->line('file_delete'); ?></b></a>
<a class="bbtn disabled" hidefocus="true" href="javascript:;" id="barCmdPrint" _i="14"><em class="icon-print"></em><b><?= $this->lang->line('file_print'); ?></b></a>
<a class="bbtn disabled" hidefocus="true" href="javascript:;" id="barCmdRevision" _i="15"><em class="icon-revision"></em><b><?= $this->lang->line('file_history'); ?></b></a>
<a class="bbtn" hidefocus="true" href="javascript:;" id="barCmdEdit" _i="13"><em class="icon-edit-pic prettify"></em><b><?= $this->lang->line('file_edit'); ?></b></a>
<a class="bbtn barSellFile" hidefocus="true" href="javascript:;" id="barSellFile" _i="17" style="display: none;"><em class="icon-edit-pic icon-sellfile"></em><b><?= $this->lang->line('file_sale'); ?></b></a>
<a class="mbtn disabled" hidefocus="true" href="javascript:;" id="barDropdownTriggerMore"><em class="icon-more"></em><b><?= $this->lang->line('file_more'); ?></b></a>
</span>
</p>
<ul class="pull-down-menu" style="display:none">
<li><a _data="rename" href="javascript:;" id="barCmdRename" _i="0" class="disabled"><?= $this->lang->line('file_rename'); ?></a></li>
<li><a _data="copy" href="javascript:;" id="barCmdCopy" _i="4" class="disabled"><?= $this->lang->line('file_copy'); ?></a></li>
<li><a _data="move" href="javascript:;" id="barCmdMove" _i="5" class="disabled"><?= $this->lang->line('file_move'); ?></a></li>
</ul>
</header>
<header class="files-header b-header b-bdr-7" id="fileThumbHeader" style="display: none;">
<p>
<span style="display:none" class="b-fl input-cbx selectionArbitrate"><dfn><s class="sprite"></s></dfn></span>
</p>
</header>
<header class="files-header b-header b-bdr-7" id="sortColsHeader" style="display: block;">
<div class="clearfix">
<div class="c1 col">
<a class="indicator b-ig-ln indicator-name asc" hidefocus="true" href="javascript:;" id="nameCompareTrigger">
<s class="indicator-cols clearfix">
<span style="display:none" class="b-fl input-cbx selectionArbitrate"><dfn><s class="sprite"></s></dfn></span>
<span class="itt-10" style="margin-left:5px"><?= $this->lang->line('file_name'); ?></span>
<span class="b-in-blk sprite-ic action-dd" style="display:none"></span>
</s>
</a>
</div>
<div class="c2 col">
<a class="indicator b-ig-ln" hidefocus="true" href="javascript:;" id="sizeCompareTrigger">
<s class="indicator-cols clearfix">
<span class="itt-10"><?= $this->lang->line('file_size'); ?></span>
<span class="b-in-blk sprite-ic action-dd"></span>
</s>
</a>
</div>
<div class="c3 col">
<a class="indicator b-ig-ln" hidefocus="true" href="javascript:;" id="timeCompareTrigger">
<s class="indicator-cols clearfix">
<span><?= $this->lang->line('file_modified'); ?></span>
<span class="b-in-blk sprite-ic action-dd"></span>
</s>
</a>
</div>
<div class="c4 col" style="display:block">
<a class="indicator b-ig-ln" hidefocus="true" href="javascript:;" id="remainingCompareTrigger">
<s class="indicator-cols clearfix">
<span><?= $this->lang->line('file_extension'); ?></span>
<span class="b-in-blk sprite-ic action-dd"></span>
</s>
</a>
</div>
</div>
</header>
</div>
<div class="center loading-data clearfix" id="inifiniteListViewEmptyNote" style="display: none;"><?= $this->lang->line('file_no_data'); ?></div>
<form action="javascript:void(0)" class="file-list b-rlv" id="fileList" method="get" name="fileList" onsubmit="return false" unselectable="on" _install_drag_selection="1">
<dl class="infinite-listview" id="infiniteListView" style="margin-top: 0px;">
<?php if ($type=='all'){  ?>
<?php foreach($item_type_list as $key=>$_type): ?>
<dd class="clearfix file-item" folder="1" _cmd_installed="1">
<div class="file-col col" title="<?php echo $_type['name']; ?>">
<span class="inline-commands b-btn clearfix" style="visibility: hidden;">
<div class="more-btn">
<ul>
<li class="sell-sfile" title="Sale" style="display: none;"><em class="icon-item-sellfile" _i="16"></em></li>
<li class="user-public" title="Share"><em class="icon-share" _i="2"></em></li>
<li class="down-sfile" title="Download"><em class="icon-download" _i="8"></em></li>
<li class="more-sfile" title="More"><em class="icon-more-sfile"></em><div class="more-sfile-menu" title="More"><div class="more-sfile-inner"><div class="icon-move-sfile" _i="5" _data="move" title="Move"><?= $this->lang->line('file_move'); ?></div><div class="icon-copy-sfile" _i="4" _data="copy" title="Duplicate"><?= $this->lang->line('file_copy'); ?></div><div class="icon-rename-sfile" _i="0" title="Rename"><?= $this->lang->line('file_rename'); ?></div><div class="icon-delete-sfile" _i="1" title="Delete"><?= $this->lang->line('file_delete'); ?></div></div></div></li>
</ul>
</div>
</span>
<span class="inline-file-col">
<a style="display:none" hidefocus="true" unselectable="on" href="javascript:;" class="b-in-blk input-cbx" _position="1">
<dfn><s class="sprite"></s></dfn></a>
<span class="b-in-blk sprite-list-ic b-ic-book" _position="1" style="cursor: pointer; background-position: 0px 0px;">
<s></s></span>
<a hidefocus="true" unselectable="on" class="file-handler b-no-ln dir-handler" href="<?=site_url('disk/'.$_type['id'])?>" title="<?php echo $lang == 2?$_type['name_cn']:$_type['name']; ?>" _position="1" _installed="1" style="color: rgb(0, 0, 0); cursor: pointer;"><?php echo $lang == 2?$_type['name_cn']:$_type['name']; ?></a>
</span>
</div>
<div class="size-col col">
<span style="line-height: 37px;">-</span>
</div>
<div class="time-col col">
<span style="line-height: 37px;">-</span>
</div>
<div class="pathing-col col">
<a hidefocus="true" unselectable="on" class="path-handler b-no-ln dir-handler" href="javascript:;" _position="1" title="/All Files"><?= $this->lang->line('file_all_files'); ?></a>
</div></dd>
<?php endforeach; ?>
<?php  }else{?>



<dd class="clearfix auto" id="createFolder" style="display:none">
<div class="file-col col">
<span class="inline-file-col d" style="margin-left:10px"><span class="b-in-blk sprite-list-ic b-ic-book list-icon-fix"></span>
<div action="javascript:;" method="get" name="folderGeneratorForm" id="folderGeneratorFormId" class="folder-generator file-handler" style="">
<input id="folderGeneratorHandler" autocomplete="off" spellcheck="false" type="text" name="generator" size="35">
<a title="OK" class="b-in-blk img-ico ic-chname-ok" href="javascript:;"></a>
<a title="Cancel" class="b-in-blk img-ico ic-chname-failure" href="javascript:;"></a>
</div></span></div><div class="size-col col"><span>-</span></div>
<div class="time-col col"><span>-</span></div></dd>


<?php foreach($item_list as $key=>$_item): ?>
	
<dd class="clearfix file-item" title="<?php echo $_item['title']; ?>" folder="<?php echo $_item['is_folder']; ?>" private="<?php echo $_item['is_private']; ?>" data="<?php echo $_item['id']; ?>" _position="<?php echo $key ?>" _cmd_installed="1">
<div class="file-col col" title="<?php echo $_item['title']; ?>">
<span class="inline-commands b-btn clearfix" style="visibility: hidden;">
<div class="more-btn">
<ul>
<li class="sell-sfile" title="Sale" style="display: none;"><em class="icon-item-sellfile" _i="16"></em></li>
<li class="user-public" title="Share"><em class="icon-share" _i="2"></em></li>
<li class="down-sfile" title="Download"><em class="icon-download" _i="8"></em></li>
<li class="more-sfile" title="More"><em class="icon-more-sfile"></em><div class="more-sfile-menu" title="More"><div class="more-sfile-inner"><div class="icon-move-sfile" _i="5" _data="move" title="Move"><?= $this->lang->line('file_move'); ?></div><div class="icon-copy-sfile" _i="4" _data="copy" title="Duplicate"><?= $this->lang->line('file_copy'); ?></div><div class="icon-rename-sfile" _i="0" title="Rename"><?= $this->lang->line('file_rename'); ?></div><div class="icon-delete-sfile" _i="1" title="Delete"><?= $this->lang->line('file_delete'); ?></div></div></div></li>
</ul>
</div>
</span>
<span class="inline-file-col">
<a hidefocus="true" unselectable="on" href="javascript:;" class="b-in-blk input-cbx" _position="8"><dfn><s class="sprite"></s></dfn></a>
<em class="b-in-blk share-type-ic share-type-private" style="display:<?php echo $_item['is_private']?'':'none'; ?>" title="Private File"></em>
<span class="b-in-blk sprite-list-ic b-ic-book" _position="8" style="cursor: pointer; background-position: -<?php echo isset($_item['extension_bg_thumb'])?$_item['extension_bg_thumb']:416; ?>px -<?php echo isset($_item['extension_bg_thumb_y'])?$_item['extension_bg_thumb_y']:80; ?>px;"><s></s></span>
<a hidefocus="true" unselectable="on" class="file-handler b-no-ln dir-handler" href="<?=site_url(($_item['is_folder']==1?'folder/':'item/').$_item['id'])?>" title="<?php echo $_item['title']; ?>" _position="8" _installed="1" style="color: rgb(0, 0, 0); cursor: pointer;"><?php echo $_item['title']; ?> <?php echo $_item['password']?'(Password:'.$_item['password'].')':''; ?></a>
</span>
</div>
<div class="size-col col"><span style="line-height: 37px;"><?php echo getRealSize($_item['file_size']); ?></span></div>
<div class="time-col col"><span style="line-height: 37px;"><?php echo $_item['update_date']; ?></span></div>
<div class="pathing-col col" style="display:block"><a hidefocus="true" unselectable="on" class="path-handler b-no-ln dir-handler" href="javascript:;" _position="8" title="<?php echo $_item['extension']; ?>"><?php echo $_item['extension']; ?></a></div></dd>
	
<?php endforeach; ?>
<?php  }?>
</dl>
<dl class="infinite-gridview" id="infiniteGridView" style="display:none">
<dd class="center loading-data" style="display:none"><?= $this->lang->line('file_loading'); ?></dd>
<?php if ($type=='all'){  ?>

<?php for($i=0;$i<count($item_type_list);$i++){ 
	$_type = $item_type_list[$i];
	if($i%5==0){
	?><dd class="clearfix">
	<?php } ?>
	<div class="clearfix icon-item" folder="1" _position="1" _installed="1" style="display: block;">
	<div class="thumb-holder tl-folder" title="<?php echo $_type['name']; ?>" style="background-position: 0px 0px;">
	<div class="thumb-large" style="cursor: pointer;"><em class="ic-shr-plc"></em><s class="file-3-party"></s></div>
	<div class="file-name"><a hidefocus="true" unselectable="on" href="<?=site_url('disk/'.$_type['id'])?>" class="b-in-blk input-cbx" _position="1"><dfn><s class="sprite"></s></dfn></a>
	<a class="b-no-ln file-handler" href="<?=site_url('disk/'.$_type['id'])?>" _position="1" style="cursor: pointer;"><?php echo $lang == 2?$_type['name_cn']:$_type['name']; ?></a>
	</div></div></div>
<?php } ?>

<?php  }else{?>

<?php for($i=0;$i<count($item_list);$i++){ 
	$_item = $item_list[$i];
	if($i%5==0){
	?><dd class="clearfix">
	<?php } ?>
<div class="clearfix icon-item" title="<?php echo $_item['title']; ?>" folder="<?php echo $_item['is_folder']; ?>" private="<?php echo $_item['is_private']; ?>" data="<?php echo $_item['id']; ?>" _position="<?php echo $i ?>" style="display: block;">
<?php if($_item['is_folder']==1){ ?>
	<div class="thumb-holder tl-folder" title="<?php echo $_item['title']; ?>" style="background-position: 0px 0px;">
	<div class="thumb-large" style="cursor: pointer;">
<?php  }else{?>	
	<div class="thumb-holder" title="<?php echo $_item['title']; ?>">
	<?php if($_item['thumb_url']!=''&&$_item['thumb_url']!=null){ ?>
	<div class="thumb-grid tl-file f3" style="background-image: url(<?php echo $_item['thumb_url']; ?>); width: 94px; height: 94px; cursor: pointer; background-position: 50% 50%; background-repeat: no-repeat no-repeat;">
	<?php  }else{?>
	<div class="thumb-grid tl-file f3" style="cursor: pointer; background-position: -<?php echo isset($_item['extension_bg'])?$_item['extension_bg']:0; ?>px 0px;">	
	<?php } ?>	
<?php } ?>	
<em class="ic-shr-plc"></em><s class="file-3-party"></s></div>
<div class="file-name" style="border-color: rgb(190, 190, 190);"><a hidefocus="true" unselectable="on" href="javascript:;" class="b-in-blk input-cbx" _position="8"><dfn><s class="sprite"></s></dfn></a>
<a class="b-no-ln file-handler" href="<?=site_url(($_item['is_folder']==1?'folder/':'item/').$_item['id'])?>" _position="8" style="cursor: pointer;"><?php echo $_item['title']; ?></a>
</div></div></div>
<?php if($i%5==4){
	?></dd>
	<?php } ?>
<?php } ?>

<?php  }?>	
</dl>

</form>
</section>
</div>
</section>
</div>
</section>
</section>	
<div class="page">
</div>


</div> <!-- /main -->


</div> <!-- /content -->
<script type="text/x-jquery-tmpl" id="iconItem">
   <li id="weekListli${id}" data-id="${id}"> 
		<a href="">
			<h3 class="ui-li-heading">${title}</h3>
		</a> 
   </li>
</script>
<script type="text/x-jquery-tmpl" id="fileItem">
<dd class="clearfix file-item" data="${id}" _position="" _cmd_installed="1">
<div class="file-col col" title="${title}">
<span class="inline-commands b-btn clearfix" style="visibility: hidden;">
<div class="more-btn">
<ul>
<li class="sell-sfile" title="Sale" style="display: none;"><em class="icon-item-sellfile" _i="16"></em></li>
<li class="user-public" title="Share"><em class="icon-share" _i="2"></em></li>
<li class="down-sfile" title="Download"><em class="icon-download" _i="8"></em></li>
<li class="more-sfile" title="More"><em class="icon-more-sfile"></em><div class="more-sfile-menu" title="More"><div class="more-sfile-inner"><div class="icon-move-sfile" _i="5" _data="move" title="Move">Move</div><div class="icon-copy-sfile" _i="4" _data="copy" title="Duplicate">Duplicate</div><div class="icon-rename-sfile" _i="0" title="Rename">Rename</div><div class="icon-delete-sfile" _i="1" title="Delete">Delete</div></div></div></li>
</ul>
</div>
</span>
<span class="inline-file-col">
<a hidefocus="true" unselectable="on" href="javascript:;" class="b-in-blk input-cbx" _position="8"><dfn><s class="sprite"></s></dfn></a><span class="b-in-blk sprite-list-ic b-ic-book" _position="8" style="cursor: pointer; background-position: -<?php echo isset($_item['extension_bg_thumb'])?$_item['extension_bg_thumb']:416; ?>px -80px;"><s></s></span>
<a hidefocus="true" unselectable="on" class="file-handler b-no-ln dir-handler" target="_blank" href="<?=site_url('item/')?>/${id}" title="${title}" _position="8" _installed="1" style="color: rgb(0, 0, 0); cursor: pointer;">${title}</a>
</span>
</div>
<div class="size-col col"><span style="line-height: 37px;">${file_size}</span></div>
<div class="time-col col"><span style="line-height: 37px;">${update_date}</span></div>
<div class="pathing-col col" style="display:block"><a hidefocus="true" unselectable="on" class="path-handler b-no-ln dir-handler" href="javascript:;" _position="8" title="${extension}">${extension}</a></div></dd>
</script>
 <script type="text/javascript">
 $(function(){
	var _wrap=$('ul.line');//定义滚动区域
	var _interval=3000;//定义滚动间隙时间
	var _moving;//需要清除的动画
	_wrap.hover(function(){
		clearInterval(_moving);//当鼠标在滚动区域中时,停止滚动
	},function(){
		_moving=setInterval(function(){
			var _field=_wrap.find('li:first');//此变量不可放置于函数起始处,li:first取值是变化的
			var _h=_field.height();//取得每次滚动高度(多行滚动情况下,此变量不可置于开始处,否则会有间隔时长延时)
			_field.animate({marginTop:-_h+'px'},600,function(){//通过取负margin值,隐藏第一行
				_field.css('marginTop',0).appendTo(_wrap);//隐藏后,将该行的margin值置零,并插入到最后,实现无缝滚动
			})
		},_interval)//滚动间隔时间取决于_interval
	}).trigger('mouseleave');//函数载入时,模拟执行mouseleave,即自动滚动
});

 		var currentType = '<?php echo $type;?>';
 		var currentFolder = <?php echo isset($folder)?$folder['id']:'0';?>;
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadify({
				'formData'     : {
					'method'   : 'post',
					'type' : '<?php echo $type;?>',
					'folder' : '<?php echo isset($folder)?$folder['id']:'0';?>',
					'type_name' : '<?php echo $type_name;?>',
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'buttonClass' : 'disk-upload-button',
				'buttonText' : '<?= $this->lang->line('file_upload') ?> <?php echo $type_name;?>',
				'swf'      : '<?=base_url()?>swf/uploadify.swf',
				'uploader' : '<?=site_url('disk/uploadFile')?>',
				'onUploadSuccess' : function(file, data, response) {
					if(data!='Invalid file type.'){
						//alert(data);
						/*var newList = $("#infiniteListView");
						var newitem = $("#fileItem").tmpl(JSON.parse(data));
						newitem.prependTo(newList);*/
					}else{
						//var a = $('.uploadify-queue').html();
				       // $('.uploadify-queue').html(a+'<br/>'+'Invalid file type.');
					}
			    },
			    'onQueueComplete' : function(queueData) {
		            //alert(queueData.uploadsSuccessful + ' files were successfully uploaded.');
		            if(currentFolder==0){
		            	window.location.href = '<?=site_url('disk/'.$type)?>';
		            }else{
		            	var folderURL = "http://www.effecthub.com/folder/complete/"+currentFolder;
		            	$.ajax({  
				           type:"GET" 
				           ,url:folderURL
				           ,data:{count:queueData.uploadsSuccessful}                              
				           ,contentType:'text/html;charset=utf-8'//编码格式   
				           ,success:function(data){  
		            			window.location.href = '<?=site_url('folder/')?>/'+currentFolder;
				           }//请求成功后  
				           ,error:function(data){ 
		            			window.location.href = '<?=site_url('folder/')?>/'+currentFolder;
				           }//请求错误  
				        });
		            }
		        }
			});
		});
	</script>  
<?php $first = get_cookie('first_login');
		if (isset($first)&&($first!= null)&&($first == 1)) {

	$this->load->view('first_login');
	
 	$cookie = array(
			'name'   => 'first_login',
			'value'  => 0,
			'expire' => '5',
		);
		set_cookie($cookie);
	
	 }?>


</div></div> <!-- /wrap -->
<div class="b-panel b-dialog toast-dialog toast-content b-bdr-6 bdr-rnd-3 box-shadow" style="display: none; left: 739px; top: 152px;"><div class="toast-outer"><div id="_disk_id_2" class="toast-msg ellipsis"><em class="sprite-ic b-in-blk b-ic-dimen-1 ic-mini-ok"></em>Deleted to Recycle bin successfully.<em class="close-tips" style="display: none;"> </em></div></div></div>

<div class="b-panel b-dialog alert-dialog" style="display: none; left: 492px; top: 127px;"><div class="dlg-hd b-rlv"><div title="Close" id="_disk_id_19" class="dlg-cnr dlg-cnr-r"></div><h3 id="_disk_id_17">Confirm Delete</h3></div><div class="dlg-bd"><div id="_disk_id_18" class="alert-dialog-msg center">Are you sure to delete this file?<br>(The file will be deleted permanently.)</div></div><div class="dlg-ft b-rlv"><div class="alert-dialog-commands clearfix center"><a href="javascript:;" class="sbtn okay"><b>OK</b></a><a href="javascript:;" class="dbtn cancel"><b>Cancel</b></a></div><div class="clearfix alert-dialog-commands-plus"><a href="javascript:;" class="dbtn okay"><b>Close</b></a></div></div></div>

<div class="b-panel b-dialog share-dialog" style="display: none; left: 407px; top: 0px;"><div class="dlg-hd b-rlv"><span title="Close" id="_disk_id_24" class="dlg-cnr dlg-cnr-r"></span><h3><span>Share File To</span></h3></div>
<div id="idtabs" class="dlg-bd clearfix">
<div class="tab-host b-rlv">
<ul id="_disk_id_20" class="tab-indicators clearfix">
<li _idx="0" class=""><a href="#public-content" class="sprite-2 b-ig-ln selected"><span class="sprite-2"><?= $this->lang->line('file_public'); ?></span></a></li>
<li _idx="1" class=""><a href="#private-content" class="sprite-2 b-ig-ln"><span class="sprite-2"><?= $this->lang->line('file_private'); ?></span></a></li>
<li _idx="2" class=""><a href="#firend-content" class="sprite-2 b-ig-ln"><span class="sprite-2"><?= $this->lang->line('file_team'); ?></span></a></li>
</ul></div>
<div id="public-content" class="public-content share-content clearfix" style="display: block;">
<div class="share-explain"><?= $this->lang->line('file_public_slogan'); ?><a class="to-sharehome" hidefocus="" target="_blank" href="<?=site_url('user/'.$this->session->userdata('id'))?>"><?= $this->lang->line('file_share_page'); ?>&gt;&gt;</a></div>
</div>
<div  id="private-content" style="display: none;" class="private-content share-content clearfix">
<div class="share-explain"><?= $this->lang->line('file_private_slogan'); ?></div>
<div id="link_share_disk_id_27" class="share-link clearfix b-rlv" style="display: block;padding-bottom:0">
<div class="share-link-cnt clearfix" style="margin-bottom:0;">
<form id="_disk_id_27" onsubmit="return false" name="search" method="get" class="b-input b-fl b-holder-off" action="">
<p class="link-address view-passport" style="display: block;margin-left:17px;"><?= $this->lang->line('file_set_password'); ?></p>
<input class="link-address" id="link-password" type="text" style="display: block;margin-top:0;width:100px">
</form>
</div></div>
</div>
<div class="rnd-pettle" style="display: block;">
<div class="rnd-pettle-bd" style="height: 150px;">
<div class="tab-content-outer clearfix" style="height: 90px;">
<div  style="display: none;">
<span class="tab-content-link"><?= $this->lang->line('file_share_public'); ?></span><a href="javascript:;" class="sbtn re-x b-ig-ln b-fr create-share-link" id="_disk_id_26"><b><?= $this->lang->line('file_share'); ?></b></a>
</div>
<span id="share-link-alert-panl" style="clear: both; display: block;"></span><span class="link-notice" style="clear:both;top:60px"><?= $this->lang->line('file_share_link_slogan'); ?></span>
<div id="link_share_disk_id_27" class="share-link clearfix b-rlv" style="display: block;">
<div class="share-link-cnt clearfix">
<p class="link-address" style="color: rgb(51, 51, 51); display: block;"><?= $this->lang->line('file_share_link'); ?></p>
<input class="share-link-input public-link share-n" id="_disk_id_29" spellingcheck="false" autocomplete="false" type="text" name="publicLink">
<!--
<br/><br/>
<p class="link-address" style="color: rgb(51, 51, 51); display: block;">Access URL</p>
<input class="share-link-input access-url share-n" id="_disk_id_29" spellingcheck="false" autocomplete="false" type="text" name="accessURL">
-->
</div></div></div>
<div style="display: none;" class="share-icons clearfix">

</div></div></div>
<div id="firend-content" style="display: none;" class="firend-content share-content clearfix">
<div id="sharefriendBox" class="share-friend-box" style="margin-top:0">
<ul>
<?php foreach ($team_list as $_team): ?>
		            <li class="mp-member-item" style="margin:0 10px;width:80px;float:left" title="<?php echo $_team['team_name']; ?>">
    <label for="teamid<?php echo $_team['team_id']; ?>" style="cursor:pointer;float:none;width:60px;margin:0"><img src='<?php echo $_team['pic_url']; ?>' style='width:50px;height:50px;margin:8px 8px 0 8px;border-radius: 5px;'></label>
    <div style="padding-top:5px">
      <input type="checkbox" name="teamid" value="<?php echo $_team['team_id']; ?>" id="teamid<?php echo $_team['team_id']; ?>" style="display:inline"> <a href="<?php echo site_url('team/'.$_team['team_id'])?>" target="_blank"><?php echo $_team['team_name']; ?></a>
    </div>
    <span class="text-supple"></span>
  </li>
<?php endforeach;  ?>
</ul>
<!--
<p class="desc-box"><textarea id="desc" class="desc" maxlength="500"><?= $this->lang->line('file_description'); ?></textarea></p>
-->
</div></div>
<div class="dlg-ft b-rlv">
<div class="alert-dialog-commands b-rlv clearfix">
<a href="javascript:;" class="abtn re-x b-ig-ln b-fr" id="_disk_id_25"><b><?= $this->lang->line('file_close'); ?></b></a>
<a href="javascript:;" class="sbtn re-x b-ig-ln b-fr" id="to-share" style="display: block;"><b><?= $this->lang->line('file_share'); ?></b></a>
<div class="verify-code" id="share-verify" style="display: none;">
<div class="verify-body"><?= $this->lang->line('file_verify_code'); ?> <input type="text" maxlength="4">
<img src="" width="100" height="30" alt="Getting Verify Code"><a href="#2" class="underline"><?= $this->lang->line('file_change'); ?></a>
</div>
<div class="verify-error"></div></div></div></div></div></div>
<script type="text/javascript"> 
  $("#idtabs div").idTabs(); 
</script>

<div class="b-panel b-dialog move-dialog" style="display: none; left: 411.5px; top: 32px;"><div class="dlg-hd b-rlv"><span title="关闭" id="_disk_id_7" class="dlg-cnr dlg-cnr-r"></span> <h3><strong id="_disk_id_11" class="f333">保存到</strong></h3></div><div class="dlg-bd"><div id="_disk_id_6" class="dlg-inner-bd b-bdr-1">

<!--
<iframe id="_disk_id_5" frameborder="none" style="border:0 none;width:100%;height:196px;" src="/share/selectdir"></iframe>
-->
<div id="contentId" style="height:196px;overflow:auto"><ul class="treeview treeview-content treeview-ancestor"><li><div class="treeview-node treeview-root _minus" _pl="0px" style="padding-left: 0px;"><span class="treeview-node-handler"><em class="b-in-blk plus sprite-ic2 minus"></em><dfn class="b-in-blk treeview-ic"></dfn><span class="treeview-txt">全部文件</span></span></div>
<ul class="treeview treeview-content">
<li><div class="treeview-node" _pl="15px" style="padding-left: 15px;"><span class="treeview-node-handler"><em class="b-in-blk plus sprite-ic2"></em><dfn class="b-in-blk treeview-ic"></dfn><span class="treeview-txt">我的应用数据</span></span></div><ul class="treeview treeview-content treeview-collapse"></ul></li>
<li><div class="treeview-node treenode-empty" _pl="15px" style="padding-left: 15px;"><span class="treeview-node-handler"><em class="b-in-blk plus sprite-ic2"></em><dfn class="b-in-blk treeview-ic"></dfn><span class="treeview-txt">我的视频</span></span></div><ul class="treeview treeview-content treeview-collapse"></ul></li>
<li><div class="treeview-node treenode-empty" _pl="15px" style="padding-left: 15px;"><span class="treeview-node-handler"><em class="b-in-blk plus sprite-ic2"></em><dfn class="b-in-blk treeview-ic"></dfn><span class="treeview-txt">我的文档</span></span></div><ul class="treeview treeview-content treeview-collapse"></ul></li><li>
<div class="treeview-node" _pl="15px" style="padding-left: 15px;"><span class="treeview-node-handler"><em class="b-in-blk plus sprite-ic2"></em><dfn class="b-in-blk treeview-ic"></dfn><span class="treeview-txt">我的音乐</span></span></div>
<ul class="treeview treeview-content treeview-collapse">
<li><div class="treeview-node treenode-empty treeview-node-on treeview-node-hover" _pl="30px" style="padding-left: 30px;"><span class="treeview-node-handler"><em class="b-in-blk plus sprite-ic2"></em><dfn class="b-in-blk treeview-ic"></dfn><span class="treeview-txt">新建文件夹</span></span></div><ul class="treeview treeview-content treeview-collapse"></ul></li>
<li><div class="treeview-node treenode-empty treeview-node-on treeview-node-hover" _pl="30px" style="padding-left: 30px;"><span class="treeview-node-handler"><em class="b-in-blk plus sprite-ic2"></em><dfn class="b-in-blk treeview-ic"></dfn><span class="treeview-txt">新建文件夹1</span></span></div><ul class="treeview treeview-content treeview-collapse"></ul></li>
</ul></li>
<li><div class="treeview-node treenode-empty" _pl="15px" style="padding-left: 15px;"><span class="treeview-node-handler"><em class="b-in-blk plus sprite-ic2"></em><dfn class="b-in-blk treeview-ic"></dfn><span class="treeview-txt">我的照片</span></span></div><ul class="treeview treeview-content treeview-collapse"></ul></li>
<li><div class="treeview-node" _pl="15px" style="padding-left: 15px;"><span class="treeview-node-handler"><em class="b-in-blk plus sprite-ic2"></em><dfn class="b-in-blk treeview-ic"></dfn><span class="treeview-txt">新建文件夹</span></span></div><ul class="treeview treeview-content treeview-collapse"></ul></li>
<li><div class="treeview-node" _pl="15px" style="padding-left: 15px;"><span class="treeview-node-handler"><em class="b-in-blk plus sprite-ic2"></em><dfn class="b-in-blk treeview-ic"></dfn><span class="treeview-txt">游戏</span></span></div><ul class="treeview treeview-content treeview-collapse"></ul></li>
</ul></li></ul></div>

</div></div><div class="dlg-ft b-rlv"><div class="alert-dialog-commands clearfix"><a id="_disk_id_10" href="javascript:void(0)" class="ibtn b-fl"><em class="icon-creat-file"></em><b>新建文件夹</b></a><a id="_disk_id_8" href="javascript:;" class="abtn b-fr"><b>取消</b></a><a id="_disk_id_9" href="javascript:;" class="sbtn b-fr"><b>确定</b></a></div></div></div>

<?php $this->load->view('footer') ?>
