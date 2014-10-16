<?php $this->load->view('header') ?>

<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
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
		<strong><?= $this->lang->line('folderexplore_unlogin'); ?></strong>
		
		<a href="<?=site_url('register')?>" class="form-sub tagline-action"><?= $this->lang->line('folderexplore_sign_up'); ?></a>
		<a rel="tipsy" original-title="Sign up with your Twitter account" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Facebook account" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Google account" class="auth-google tagline-action" href="<?=site_url('login/google')?>"></a>
		<!--<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>-->
	</h1>
</div>
<?php  }?>
<ul class="tabs">
	<li class="<?php echo $feature=='assets'?'active':'' ?>">
		<a href="<?=site_url('item/'.$item['id'])?>"><?= $this->lang->line('folder_assets'); ?> <?php echo $item['title']; ?></a>
	</li>
	<a class="form-sub tagline-action" style="float:right" href="<?=site_url('item/'.$item['id'])?>"><?= $this->lang->line('folder_assets_return'); ?></a>
	
</ul>
<section class="main clearfix" style="background-color:#FFF;font-size:12px;border-radius: 5px;">
<section class="aside" style="margin-left:0px;">

<aside class="properties" id="share_aside">
<dl class="property-list">
<dt class="clearfix">
<div class="thumb b-fl">
<a class="pic-frm thumb-pic-frm b-bdr-slv2" href="<?=site_url('user/'.$user['id'])?>" target="_blank" title="">
<img alt="<?php echo $user['displayName']; ?>" class="pic-frm-pic" src="<?php echo $user['pic_url']; ?>" style="width:100%">
</a>
<p class="b-fl share-frm-lbl cc-ct-b">
<a class="link-usern ellipsis" href="<?=site_url('user/'.$user['id'])?>" target="_blank" title=""><?php echo $user['displayName']; ?></a>
<!--<a class="concern-btn followed" data="{}" hidefocus="hideFocus" href="javascript:;">
<em></em>
<span class="follow">已关注</span>
<span class="defollow">取消关注</span>
</a>-->
<?php if ($this->session->userdata('id')&&$this->session->userdata('id')!=$user['id']){  ?>
<div class="follow-prompt">
		<?php if ($follow!=null){  ?>
		<a href="<?=site_url('user/unfollow/'.$user['id'])?>" class="unfollow" style="display:block;margin-left:10px"><?= $this->lang->line('user_unfollow');?></a>
		<?php  }else{?>
		<a href="<?=site_url('user/follow/'.$user['id'])?>" class="follow" style="display:block;margin-left:10px"><?= $this->lang->line('user_follow');?></a>
		<?php  }?>
</div>
<?php  }?>
</p>
</div>
</dt>
</dl>
<dl class="hotrec-ele hot interestrec-tit"><div class="hr"></div>
<dt class="clearfix"><span class="hotrec-tit ellipsis"><?= $this->lang->line('folder_may_interet'); ?></span><a class="hotrec-chg" style="display:none" href="javascript:;">Refresh</a></dt>
<?php foreach($public_folder_list as $_folder): ?>
<dd class="ellipsis hotrec-dd" title="<?php echo $_folder['title']; ?>"><a href="<?=site_url('item/'.$_folder['id'])?>" class="hotrec-link"><span class="hotrec-txt"><?php echo $_folder['title']; ?></span></a></dd>
<?php endforeach; ?>
<div class="hr"></div><dt class="clearfix"><span class="hotrec-tit interestrec"><?= $this->lang->line('folder_find_friends'); ?></span>
<a class="interestrec-chg" style="display:none" href="javascript:;">Refresh</a></dt></dl>
<dl id="interestRect">
<?php foreach($user_list as $_user): ?>
<li class="share-personage-item fl interest-personage-item"><div class="share-personage-header interest-personage-header cc-ct-m"><div></div><a class="share-personage-face share-owner fl" href="<?php echo site_url('user/'.$_user['id'])?>"><img src="<?php echo $_user['pic_url']; ?>"></a><div class="share-personage-con fl"><a class="share-personage-name share-owner" style="width:100px;" href="<?php echo site_url('user/'.$_user['id'])?>"><?php echo $_user['displayName']; ?></a><p class="share-personage-msg"><a href="<?=site_url('user/showfollowers/'.$_user['id'])?>"><b><?php echo $_user['follower_num']; ?></b> <?= $this->lang->line('user_followers');?></a></p></div></div></li>
<?php endforeach; ?>
</dl></aside>
	                   
<div class="clearfix my-share" id="awardBubbleP" style="margin-left: 28px;">

</div>
</section>
<section class="pan" id="subwindowContainer" style="margin-left: 209px;">
<div class="pan-inner b-bdr-2" id="panInner">
<section class="fns">
<div id="header-shaw">
<div class="location clearfix b-header b-bdr-7">
<ul class="bar-cmd-view-list clearfix">
<li><a href="javascript:;" id="barCmdViewList" title="View By List"><span></span></a></li>
<li class="end"><a class="select" href="javascript:;" id="barCmdViewSmall" title="View By Thumbnail"><span></span></a></li>
</ul>
<ul class="b-list-2 bar-cmd-list" style="color:#000;width:300px">
<li class="b-list-item" style="color:#000;width:300px">
<?php if ($lang=='cn') {?>
		<!-- Baidu Button BEGIN -->
<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
<a class="bds_qzone"></a>
<a class="bds_tsina"></a>
<a class="bds_tqq"></a>
<a class="bds_renren"></a>
<a class="bds_t163"></a>
<span class="bds_more"></span>
</div>
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=2188230" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script>
<!-- Baidu Button END --><br/><br/>
<?php }else {?>
                        <!-- AddThis Button BEGIN -->
                        <!--
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5146e5b61a736647"></script>
-->
<!-- AddThis Button END --><br/>

<?php }?>
</li>
</ul>
</div>
<div class="list-loc dir-path clearfix" label="All Files">
<li><a class="a-back disabled" href="javascript:;" id="parentDir" title="Return"></a></li>
<li id="dirPath">
<!--
<a class="b-no-ln" href="<?=site_url('disk/'.$type)?>" id="dirRoot">All</a>-->
<?php if (isset($parent_folder)){  ?>
	<a class="b-no-ln" deep="1" href="<?=site_url('item/'.$parent_folder['id'])?>"><?=$parent_folder['folder_name'] ?></a>
<?php }  ?>	
<?php if (isset($item)){  ?>
	<span class="gray">&nbsp;&nbsp;&gt;&nbsp;&nbsp;</span>
	<span class="last" style="color:#000;max-width:300"><?=$item['title'] ?></span>
<?php }  ?>	
<span id="dirLocation"> </span>
</li>
<li id="dirData">
<span><span class="loadedDate" style="color:#000">
<?=$item['watch_num'] ?> <?= $this->lang->line('folder_audience'); ?> <?=$item['view_num'] ?> <?= $this->lang->line('folder_view'); ?> <?=isset($item_count)?$item_count:'' ?> <?= $this->lang->line('folder_files'); ?> <?php echo isset($item_size)?getRealSize($item_size):'' ?></span></span>
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
<span class="b-fl input-cbx selectionArbitrate" style="display:none"><dfn><s class="sprite"></s></dfn></span>
<span id="file_action_word"></span>
<span class="clearfix" id="file_action_buttons">
<a class="bbtn none disabled" hidefocus="true" href="javascript:;" id="barCmdPlayAll" _i="9"><em class="icon-play-music"></em><b><?= $this->lang->line('file_play'); ?></b></a>
<a class="bbtn" hidefocus="true" href="javascript:;" id="barCmdDownload" _i="8"><em class="icon-download"></em><b><?= $this->lang->line('file_download'); ?></b></a>
<a class="bbtn disabled" hidefocus="true" href="javascript:;" id="barCmdSave" _i="8"><em class="icon-tomyram"></em><b><?= $this->lang->line('file_save'); ?></b></a>
<a class="bbtn disabled" hidefocus="true" href="javascript:;" id="barCmdPrint" _i="14"><em class="icon-print"></em><b><?= $this->lang->line('file_print'); ?></b></a>
<a class="bbtn disabled" hidefocus="true" href="javascript:;" id="barCmdRevision" _i="15"><em class="icon-revision"></em><b><?= $this->lang->line('file_history'); ?></b></a>
</span>
</p>
</header>
<header class="files-header b-header b-bdr-7" id="fileThumbHeader">
<p>
<span class="b-fl input-cbx selectionArbitrate" style="display:none"><dfn><s class="sprite"></s></dfn></span>
</p>
</header>
<header class="files-header b-header b-bdr-7" id="sortColsHeader" style="display: block;">
<div class="clearfix">
<div class="c1 col">
<a class="indicator b-ig-ln indicator-name asc" hidefocus="true" href="javascript:;" id="nameCompareTrigger">
<s class="indicator-cols clearfix">
<span class="b-fl input-cbx selectionArbitrate" style="display:none"><dfn><s class="sprite"></s></dfn></span>
<span class="itt-10" style="margin-left:5px"><?= $this->lang->line('file_name'); ?></span>
<span class="b-in-blk sprite-ic action-dd"></span>
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
<span><?= $this->lang->line('file_download'); ?></span>
<span class="b-in-blk sprite-ic action-dd"></span>
</s>
</a>
</div>
</div>
</header>
</div>
<div class="center loading-data clearfix" id="inifiniteListViewEmptyNote" style="display: none;"><?= $this->lang->line('file_no_data'); ?></div>
<form action="javascript:void(0)" class="file-list b-rlv" id="fileList" method="get" name="fileList" onsubmit="return false" unselectable="on" _install_drag_selection="1">
<dl class="infinite-listview" id="infiniteListView" style="margin-top: 0px;display:none">
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
<a hidefocus="true" unselectable="on" class="file-handler b-no-ln dir-handler" href="<?=site_url('disk/'.$_type['id'])?>" title="<?php echo $lang == 1?$_type['name_cn']:$_type['name']; ?>" _position="1" _installed="1" style="color: rgb(0, 0, 0); cursor: pointer;"><?php echo $lang == 1?$_type['name_cn']:$_type['name']; ?></a>
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
<div class="pathing-col col" style="display:block"><a hidefocus="true" unselectable="on" class="path-handler b-no-ln dir-handler" href="javascript:;" _position="8" title="<?php echo $_item['download_num']; ?>"><?php echo $_item['download_num']; ?></a></div></dd>
	
<?php endforeach; ?>
<?php  }?>
</dl>
<dl class="infinite-gridview" id="infiniteGridView">
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
	<a class="b-no-ln file-handler" href="<?=site_url('disk/'.$_type['id'])?>" _position="1" style="cursor: pointer;"><?php echo $lang == 1?$_type['name_cn']:$_type['name']; ?></a>
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
 		var currentType = <?php echo $type;?>;
 		var currentFolder = <?php echo isset($item)?$item['id']:'0';?>;
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadify({
				'formData'     : {
					'method'   : 'post',
					'type' : '<?php echo $type;?>',
					'folder' : '<?php echo isset($item)?$item['id']:'0';?>',
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
		            if(currentFolder==0)
		            window.location.href = '<?=site_url('disk/'.$type)?>';
		            else window.location.href = '<?=site_url('item/')?>/'+currentFolder;
		        }
			});
		});
	</script>  
	
	
<div id="login" class="pop">
        
				<div id="register-header" class="pop-header">
					<h2><?= $this->lang->line('pop_title_join'); ?></h2>
				</div>
        <div id="idtabs"> 
  <div class="apps-type"> 	
<ul class="tabs">
	<li style="margin:20px 0 0 20px"><a href="#login-ct" style="color:#000"><?= $this->lang->line('pop_login'); ?></a></li>
	<li style="margin:20px 0 0 20px"><a href="#register-ct" class="selected" style="color:#000"><?= $this->lang->line('pop_sign_up'); ?></a></li>
</ul>
</div>

	<div id="login-ct">
	<div class="txt-fld" style="padding:0px 20px 35px 20px">
				    <a class="addthis_login_twitter" title=<?= $this->lang->line('pop_login_twitter'); ?> href="<?=site_url('login/twitter')?>"><span id="twitter-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_facebook" title=<?= $this->lang->line('pop_login_facebook'); ?> href="<?=site_url('login/facebook')?>"><span id="facebook-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_google" title=<?= $this->lang->line('pop_login_google'); ?> href="<?=site_url('login/google')?>"><span id="google-connect" class="ssi-button"></span></a>
						            
				  </div>
				  <br/>
				<span style="margin-left:20px;color:#333"><?= $this->lang->line('pop_login_email_title'); ?></span>
				<form action="<?=site_url('login/check')?>" method="post">
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('pop_login_email'); ?></label>
				    <input id="" name="email" type="text"/>

				  </div>
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('pop_login_password'); ?></label>
				    <input id="" name="password" type="password"/>
				  </div>
				  
				  <div class="btn-fld" style="padding-left:20px;padding-right:20px;width:350px;vertical-align:center">
					  <label for="remember_me" style="display:inline;color:#000"><?= $this->lang->line('pop_remember'); ?>
				    <input type="checkbox" checked name="remember_me" id="remember_me"/></label>
					    <input class="save-btn" name="commit" type="submit" value="Sign In">
					   <!-- <a style="float:right;margin-top:10px;margin-right:10px;" target="_blank" href="<?=site_url('register')?>">Sign Up &raquo;</a>&nbsp;&nbsp;&nbsp;&nbsp;-->
					</div>
					<input type="hidden" name="redirectURL" value="<?=site_url('item/'.$item['id'])?>"/>
					
					
					</form>
				</div>


	<div id="register-ct">
	<div class="txt-fld" style="padding:0px 20px 35px 20px">
				    <a class="addthis_login_twitter" title=<?= $this->lang->line('pop_sign_up_twitter'); ?> href="<?=site_url('login/twitter')?>"><span id="twitter-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_facebook" title=<?= $this->lang->line('pop_sign_up_facebook'); ?> href="<?=site_url('login/facebook')?>"><span id="facebook-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_google" title=<?= $this->lang->line('pop_sign_up_google'); ?> href="<?=site_url('login/google')?>"><span id="google-connect" class="ssi-button"></span></a>
						            
				  </div>
				  <br/>
				<span style="margin-left:20px;color:#333"><?= $this->lang->line('pop_sign_up_email_title'); ?></span>
				<form id="signin_form" action="<?=site_url('register/save')?>" method="post">
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('pop_sign_up_email'); ?></label>
				    <input id="email_address" name="email_address" type="text" value=""/>
<span id="emailError" class="formErrorContent drop-shadow"><?= $this->lang->line('pop_email_error'); ?></span>
				  </div>
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('pop_sign_up_password'); ?></label>
				    <input id="password" name="password" type="password" value=""/>
				    <span id="passwordError" class="formErrorContent drop-shadow"><?= $this->lang->line('pop_password_error'); ?></span>
				  </div>
				  
				  <div class="btn-fld" style="padding-left:20px;padding-right:20px;width:350px;vertical-align:center">
					  <label for="remember_me" style="display:inline;color:#000"><?= $this->lang->line('pop_sign_up_stay_informed'); ?>
				    <input type="checkbox" checked name="consent" id="consent"/></label>
					    <input class="save-btn" name="commit" type="button" value="<?= $this->lang->line('pop_sign_up_free'); ?>" onclick="checksignup();_gaq.push(['_trackEvent', 'signup', 'clicked', 'Click Sign Up Button In Item Page'])">
					</div>
						<input type="hidden" name="redirectURL" value="<?=site_url('item/'.$item['id'])?>"/>
						</form>
					</div>	

</div>
<script type="text/javascript"> 
  $("#idtabs div").idTabs(); 
</script>

		</div>
		
		<script type="text/javascript">
			$(function() {
    			$('a[rel*=leanModal]').leanModal({ top : 200, closeButton: ".modal_close" });
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


<?php $this->load->view('footer') ?>
