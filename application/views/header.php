<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="<?= $this->lang->line('header_keywords'); ?>" /> 
	<meta name="description" content="<?= $this->lang->line('header_description'); ?>">
	<title><?php echo isset($title)?$title: $this->lang->line('header_title'); ?></title>
	<meta property="wb:webmaster" content="77bb2cf13b1a69d9" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	<!--[if gte IE 7]><!-->
	<link href="<?=base_url()?>css/main.css" media="screen, projection" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>css/master-min.css" media="screen, projection" rel="stylesheet" type="text/css">
	
	<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
	
	<link href="<?=base_url()?>css/adapt.css" media="screen, projection" rel="stylesheet" type="text/css">
	<!-- <![endif]-->
	<link href="<?=base_url()?>css/print.css" media="print" rel="stylesheet" type="text/css">
	
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/uploadify.css">
	<!--
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	-->
	<script src="<?php echo base_url()?>js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.tmpl.min.js"></script>
	<script src="<?=base_url()?>js/jquery.uploadify.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.idTabs.min.js"></script>
	<script src="<?=base_url()?>js/jquery.leanModal.min.js"></script>
	<script src="<?=base_url()?>js/main.js" type="text/javascript"></script>
	<link href="<?=base_url()?>images/favicon.ico" rel="Effecthub icon" type="image/x-icon" />
</head>

<body id="<?php echo isset($nav)?$nav:'works' ?>">

<div id="header" class="group"><div id="header-inner" class="group">

	<div id="logo">
	<?php if ($this->session->userdata('id')){  ?>
		<a href="<?=site_url('home/suggestion')?>" style="margin-top:3px"><img alt="effecthub" src="<?=base_url()?>images/logo-bw.gif"></a>
	<?php }else{  ?>
		<a href="<?=site_url('home')?>" style="margin-top:3px"><img alt="effecthub" src="<?=base_url()?>images/logo-bw.gif"></a>
	<?php }  ?>
	</div>

	<a href="<?=base_url()?>#nav" id="toggle-nav">Toggle navigation</a>

	<ul id="nav">
		<li id="t-search">
			<form id="search" action="<?=site_url('item/search')?>" method="post">
				<input class="search-text placeholder" type="text" name="search" placeholder="<?= $this->lang->line('header_search');?>" value=""/>
				
			</form>
		</li>
		<?php if ($this->session->userdata('id')){  ?>
		<li id="t-profile" style="position:relative;">
			<a href="<?=site_url('user/'.$this->session->userdata('id'))?>" class="has-sub">
				<img style="padding:1px;border:1px #999 solid" alt="<?php echo $this->session->userdata('displayName'); ?>" height="22px" src="<?php echo $this->session->userdata('pic_url'); ?>" width="22px" >
				<span class="profile-name"><?php echo $this->session->userdata('displayName'); ?>
				</span>
			</a>
			<?php if ($this->session->userdata('mail_count')>0||$this->session->userdata('notice_count')>0) { ?>
			<img src="<?= base_url('images/icon-notice.png') ?>" width="12px" height="12px" style="position:absolute;top:-3px;right:-2px;" />
			<?php } ?>
			<ul class="tabs">
				<li><a href="<?=site_url('user/'.$this->session->userdata('id'))?>"><?= $this->lang->line('header_my_profile');?></a></li>
				<li><a href="<?=site_url('account/settings')?>"><?= $this->lang->line('header_account_settings');?></a></li>
				<li><a href="<?=site_url('account/payment')?>"><?= $this->lang->line('header_account_recharge');?></a></li>
				<li><a href="<?=site_url('user/checkmail/'.$this->session->userdata('id'))?>">
					<?= $this->lang->line('header_mailbox');?>
					<span class="num1" style="display:<?php echo $this->session->userdata('mail_count')>0?'':'none'; ?>"><?php echo $this->session->userdata('mail_count')>99?'99+':$this->session->userdata('mail_count'); ?></span>
					</a>
				</li>
				<li>
					<a href="<?=site_url('user/notice/'.$this->session->userdata('id'))?>">
					<?= $this->lang->line('header_notice');?>
					<span class="num1" style="display:<?php echo $this->session->userdata('notice_count')>0?'':'none'; ?>"><?php echo $this->session->userdata('notice_count')>99?'99+':$this->session->userdata('notice_count'); ?></span>
					</a>
				</li>
				<li><a href="<?=site_url('login/logout')?>" data-method="delete" rel="nofollow"><?= $this->lang->line('header_sign_out');?></a></li>
			</ul>
		</li>
		
		<li id="t-coin">
			<p title="<?= $this->lang->line('header_coin_hint'); ?>">
			<img src="<?= base_url('images/icon-coin.png') ?>" height="12px" width="12px" /> 
			<?= $this->session->userdata('point') ?>&nbsp;&nbsp;
			<?= $this->session->userdata('balance')>0?'￥'.round($this->session->userdata('balance'),2):'' ?> &nbsp;&nbsp;
			<?= $this->session->userdata('balance_usd')>0?'$'.round($this->session->userdata('balance_usd'),2):'' ?>
			</p>
		</li>
		
		<?php  }else{?>
		
		<li id="t-signup"><a href="<?=site_url('register')?>"><?= $this->lang->line('header_sign_up');?></a></li>
		<li id="t-signin"><a href="<?=site_url('login')?>"><?= $this->lang->line('header_log_in');?></a></li>
		<?php  }?>
		<?php if ($this->session->userdata('id')){  ?>
		<li id="t-works">
			<a href="<?=site_url('home/suggestion')?>" class="has-sub"><?= $this->lang->line('header_home');?></a>
			<ul class="tabs">
			<?php if ($this->session->userdata('level')>0){  ?>
			<li class="">
		<a href="<?=site_url('disk')?>" class="has-dd"><?= $this->lang->line('header_home_files'); ?></a>

	</li><?php  }?>
	<li class="active">
		<a href="<?=site_url('project')?>" class="has-dd"><?= $this->lang->line('header_home_projects');?></a>

	</li>
	<li class="active">
		<a href="<?=site_url('home')?>" class="has-dd"><?= $this->lang->line('header_home_following');?></a>

	</li>

		<li class="">
			<a href="<?=site_url('home/suggestion')?>"><?= $this->lang->line('header_home_suggestions');?></a>
		</li>
	<li class="">
		<a href="<?=site_url('item/mywatch/'.$this->session->userdata('id'))?>"><?= $this->lang->line('header_home_watching');?></a>
	</li>
	<li class="">
		<a href="<?=site_url('home/happening')?>"><?= $this->lang->line('header_home_happening');?></a>
	</li>
	<!--
	<li class="">
		<a href="<?=site_url('item/mylike/'.$this->session->userdata('id'))?>">Favorite</a>
	</li>
	<li class="">
		<a href="<?=site_url('user/'.$this->session->userdata('id'))?>">Own</a>
	</li>
	-->
</ul>
		</li>
		<?php  }?>
		<li id="t-explore" style="position:relative;">
			<a href="<?=$this->session->userdata('id')?site_url('item/featured/MostRecent'):site_url('item/featured/MostAppreciated')?>" class="has-sub"><?= $this->lang->line('header_explore');?></a>
			<?php if ($this->session->userdata('item_notice')>0) { ?>
			<img src="<?= base_url('images/icon-notice.png') ?>" width="10px" height="10px" style="position:absolute;top:-3px;right:-2px;" />
			<?php } ?>
			<ul class="tabs">
	<li>
		<a href="<?=site_url('item/featured/ThisMonth')?>"><?= $this->lang->line('header_explore_picks');?></a>
	</li>
	<li>
		<a href="<?=site_url('item/featured/MostAppreciated')?>"><?= $this->lang->line('header_explore_top');?></a>
	</li>
	<li>
		<a href="<?=site_url('item/featured/MostDownloaded')?>"><?= $this->lang->line('header_explore_popular');?></a>
	</li>
	<li>
		<a href="<?=site_url('item/featured/MostRecent')?>"><?= $this->lang->line('header_explore_recent');?></a>
	</li>
	<li>
		<a href="<?=site_url('folder/explore/top')?>"><?= $this->lang->line('header_explore_folders'); ?></a>
	</li>
	<li>
		<a href="<?=site_url('collection/explore/top')?>"><?= $this->lang->line('header_explore_collections');?></a>
	</li>
	
	<!--
	<li>
		<a href="<?=site_url('tag')?>">Tags</a>
	</li> -->
	<li>
		<a href="<?=site_url('author')?>"><?= $this->lang->line('header_explore_authors');?></a>
	</li>
</ul>

		</li>
		<li id="t-groups">
			<a href="<?php echo $this->session->userdata('id')?site_url('group/mygroup'):site_url('group')?>" class="has-sub"><?= $this->lang->line('header_groups');?></a>
			<ul class="tabs">
			<?php if ($this->session->userdata('id')){  ?>
				<li class="">
					<a href="<?php echo site_url('group/mygroup')?>"><?= $this->lang->line('header_groups_my_groups');?></a>
				</li>
			<?php  }?>
				<li class="">
					<a href="<?=site_url('group')?>"><?= $this->lang->line('header_groups_explore_groups');?></a>
				</li>
	
			</ul>

		</li>
		
		<li id="t-tasks" style="position: relative;">
			<a href="<?php echo $this->session->userdata('id')?site_url('task'):site_url('task')?>" class="has-sub"><?= $this->lang->line('header_tasks');?>
			</a>
		<img style="top:0px;left:40px;position:absolute;" src="<?=base_url()?>images/new_menu.gif">
			<ul class="tabs">
			<?php if ($this->session->userdata('id')){  ?>
				<li class="">
					<a href="<?php echo site_url('task/mytask')?>"><?= $this->lang->line('header_tasks_my_tasks');?></a>
				</li>
				<li class="">
					<a href="<?php echo site_url('task/mybid')?>"><?= $this->lang->line('header_tasks_my_responses');?></a>
				</li>
			<?php  }?>
				<li class="">
					<a href="<?=site_url('task')?>"><?= $this->lang->line('header_tasks_explore_tasks');?></a>
				</li>
	
			</ul>

		</li>
		<!--
		<li id="t-teams" style="position:relative;">
			<a href="<?php echo $this->session->userdata('id')?site_url('team/myteam'):site_url('team/explore')?>" class="has-sub"   onclick="_gaq.push(['_trackEvent', 'teamNav', 'clicked', 'Click Team Nav'])"><?= $this->lang->line('header_teams');?></a>
			
			<?php if ($this->session->userdata('team_notice')>0) { ?>
			<img src="<?= base_url('images/icon-notice.png') ?>" width="10px" height="10px" style="position:absolute;top:-3px;right:-2px;" />
			<?php } ?>
			
			<ul class="tabs">
			<?php if ($this->session->userdata('id')){  ?>
				<li class="">
					<a href="<?php echo site_url('team/myteam')?>"  onclick="_gaq.push(['_trackEvent', 'teamNav', 'clicked', 'Click Team Nav'])"><?= $this->lang->line('header_teams_my_teams');?></a>
				</li>
			<?php  }?>
				<li class="">
					<a href="<?=site_url('team/explore')?>"   onclick="_gaq.push(['_trackEvent', 'teamNav', 'clicked', 'Click Team Nav'])"><?= $this->lang->line('header_teams_explore_teams');?></a>
				</li>
	
			</ul>

		</li>
		-->
		<!-- 
		
		<li id="t-contest" style="position: relative;">
			<a href="<?=site_url('contest')?>" class="has-sub"><?= $this->lang->line('header_contest');?></a>
		</li>
		-->
		<li id="t-jobs">
			<a href="<?=site_url('tool')?>" class="has-sub"><?= $this->lang->line('header_tools');?></a>
		</li>
		<!--
		<li id="t-help">
			<a href="<?=site_url('group/2')?>" class="has-sub">Help</a>
			<ul class="tabs">
				<li>
					<a href="<?=site_url('topic/54')?>">Basic Sparticle Tutorial</a>
				</li>
				<li>
					<a href="<?=site_url('topic/92')?>">Advanced Sparticle Tutorial</a>
				</li>
			</ul>
			
		</li>
		-->
		<!--
		<li id="t-teams">
			<a href="<?=site_url('download')?>" class="has-sub">Downloads</a>
		</li>-->
		<?php if ($this->session->userdata('id')&&(isset($nav)&&($nav=='works'||$nav=='explore'))){  ?>
		<li>
		<a class="form-sub tagline-action" rel="leanModal" type="button" name="share" href="#share" style="margin-left:20px;float:right;color:#FFF;padding:10px"  onclick="_gaq.push(['_trackEvent', 'createbtn', 'clicked', 'Click Create in Header']);mixpanel.track('Click Share In Header');"><?= $this->lang->line('header_create');?></a>
	
		</li>
		<?php  }?>
		
	</ul>
</div></div> <!-- /header -->

<hr>
<!--
<?php if (isset($lang)&&$lang=='2'){  ?>
<div class="ajax notice">
	<h2><a href="<?=site_url('turing')?>">EffectHub & 图灵图书 移动游戏分享大赛: 分享好玩游戏即能赢取最新版Kindle以及移动游戏开发图书！</a></h2>
</div>
<?php  }?>
-->
<?php if ($this->session->userdata('id')&&$this->session->userdata('verified')==0&&$this->session->userdata('email')!=null&&$this->session->userdata('email')!=''){  ?>
  <div class="notice info">
    <h2><?= $this->lang->line('header_confirm_email_first'); ?> <?php echo $this->session->userdata('email'); ?>. <a href="<?=site_url('email/confirm')?>"><?= $this->lang->line('header_confirm_email'); ?></a></h2>
  </div>
<?php  }?>



<div id="share" class="pop">
        
				<div id="register-header" class="pop-header">
					<h2><?= $this->lang->line('head_share_title'); ?></h2>
					<p><?= $this->lang->line('head_share_description');?></p>
					<a class="modal_close" href="javascript:"></a>
				</div>
        <div id="sharetabs"> 
  <div class="apps-type"> 	
<ul class="tabs">
	<li style="margin:20px 0 0 20px;"><a href="#onlinecreate-ct" style="color:#000"><?= $this->lang->line('header_create_online_title'); ?></a></li>
	<li style="margin:20px 0 0 20px;"><a href="#sharework-ct" class="selected" style="color:#000"><?= $this->lang->line('header_share_work_title'); ?></a></li>
	<li style="margin:20px 0 0 20px;display:none"><a href="#sharefile-ct" style="color:#000"><?= $this->lang->line('header_share_file_title'); ?></a></li>
	<li style="margin:20px 0 0 20px;display:none"><a href="#sharecode-ct" style="color:#000"><?= $this->lang->line('header_share_code_title'); ?></a></li>
	<li style="margin:20px 0 0 20px"><a href="#shareurl-ct" style="color:#000"><?= $this->lang->line('header_share_url_title'); ?></a></li>
</ul>
</div>

	
	<div id="onlinecreate-ct">
	<form class="gen-form with-messages">
	<div class="form-field">
            <fieldset>
                    <div>
						<div style="margin-left:40px;margin-bottom:25px;width:100%;display:block;float:left">
			<a style="float:left;" target="_blank" href="<?php echo site_url('particle2dx')?>"><div  onclick="mixpanel.track('Click Create 2D Effect In Header');" class="uploadify-button disk-upload-button" style="height: 30px; line-height: 30px; width: 150px;margin:-1px 0 0 0;"><span class="uploadify-button-text"><?= $this->lang->line('header_create_online_2d'); ?></span></div></a>  
			<a style="float:left;margin-left:20px;" href="<?php echo site_url('item/new_content/particle')?>"><div  onclick="mixpanel.track('Click Create 3D Effect In Header');" class="uploadify-button disk-upload-button" style="height: 30px; line-height: 30px; width: 150px;margin:-1px 0 0 0;"><span class="uploadify-button-text"><?= $this->lang->line('header_create_online_3d'); ?></span></div></a>
			</div>
			<div style="margin-left:40px;margin-bottom:25px;width:100%;display:block;float:left">
			<a style="float:left;" href="<?php echo site_url('item/new_content/htmleditor')?>"><div  onclick="mixpanel.track('Click Write HTML In Header');" class="uploadify-button disk-upload-button" style="height: 30px; line-height: 30px; width: 150px;margin:-1px 0 0 0;"><span class="uploadify-button-text"><?= $this->lang->line('header_share_code_html'); ?></span></div></a>  
			<a style="float:left;margin-left:20px;" href="<?php echo site_url('item/new_content/aseditor')?>"><div  onclick="mixpanel.track('Click Write AS In Header');" class="uploadify-button disk-upload-button" style="height: 30px; line-height: 30px; width: 150px;margin:-1px 0 0 0;"><span class="uploadify-button-text"><?= $this->lang->line('header_share_code_as'); ?></span></div></a>
	</div>
                    </div>
            </fieldset>
            <p class="message" style="margin:0 20px;font-size:12px;color:#444"><?= $this->lang->line('header_share_work_msg'); ?></p>
    </div>
	</form>
	</div>	
	
	<div id="sharework-ct">
	<form class="gen-form with-messages">
	<div class="form-field">
            <fieldset>
                    <div>
						<div style="margin-left:100px;margin-bottom:25px;width:100%;display:block;float:left">
			<a style="float:left;margin-left:20px;" href="<?php echo site_url('item/upload')?>"><div  onclick="mixpanel.track('Click Upload Work In Header');" class="uploadify-button disk-upload-button" style="height: 30px; line-height: 30px; width: 120px;margin:-1px 0 0 0;"><span class="uploadify-button-text"><?= $this->lang->line('header_share_work'); ?></span></div></a>
	</div>
                    </div>
            </fieldset>
            <p class="message" style="margin:0 20px;font-size:12px;color:#444"><?= $this->lang->line('header_share_work_msg'); ?></p>
    </div>
	</form>
	</div>	

	<div id="sharefile-ct">
	<form class="gen-form with-messages">
	<div class="form-field">
            <fieldset>
                    <div>
						<div style="margin-left:100px;margin-bottom:25px;width:100%;display:block;float:left">
						<div id="sharequeue"></div>
						<input id="share_upload" name="share_upload" type="file" multiple="true">
						</div>
            <div id="sharelist" style="margin-left:20px;margin-bottom:20px;font-size:12px;color:#444;float:left;width:100%;height:auto;display:block;clear:both;">
			</div>
                    </div>
            </fieldset>
            <p class="message" style="margin-left:20px;font-size:12px;color:#444"><?= $this->lang->line('header_share_upload_msg'); ?></p>
    </div>
	</form>			  
	</div>


	<div id="sharecode-ct">
	<form class="gen-form with-messages">
	<div class="form-field">
            <fieldset>
                    <div>
						<div style="margin-left:60px;margin-bottom:25px;width:100%;display:block;float:left">
			<a style="float:left;" href="<?php echo site_url('item/new_content/htmleditor')?>"><div  onclick="mixpanel.track('Click Write HTML In Header');" class="uploadify-button disk-upload-button" style="height: 30px; line-height: 30px; width: 120px;margin:-1px 0 0 0;"><span class="uploadify-button-text"><?= $this->lang->line('header_share_code_html'); ?></span></div></a>  
			<a style="float:left;margin-left:20px;" href="<?php echo site_url('item/new_content/aseditor')?>"><div  onclick="mixpanel.track('Click Write AS In Header');" class="uploadify-button disk-upload-button" style="height: 30px; line-height: 30px; width: 120px;margin:-1px 0 0 0;"><span class="uploadify-button-text"><?= $this->lang->line('header_share_code_as'); ?></span></div></a>
	</div>
                    </div>
            </fieldset>
            <p class="message" style="margin-left:20px;font-size:12px;color:#444"><?= $this->lang->line('header_share_code_msg'); ?></p>
    </div>
	</form>
	</div>	

	<div id="shareurl-ct">
	<form id="shareURLForm" action="<?=site_url('item/share')?>" class="gen-form with-messages">
	<div class="form-field">
            <fieldset>
                    <div>
                    <div class="txt-fld" style="padding-top:0">
				    <input style="width:95%;height:30px;margin-right:10px;" id="" name="share_url" type="text"/>

				  </div>
						<div style="margin-left:120px;margin-top:10px;margin-bottom:25px;width:100%;display:block;float:left">
						
						<a style="float:left;" href="javascript:shareURLForm.submit()"><div  onclick="mixpanel.track('Click Share URL In Header');" class="uploadify-button disk-upload-button" style="height: 30px; line-height: 30px; width: 120px;margin:-1px 0 0 0;"><span class="uploadify-button-text"><?= $this->lang->line('header_share_url_btn'); ?></span></div></a>  
						</div>
                    </div>
            </fieldset>
            <p class="message" style="margin-left:20px;font-size:12px;color:#444"><?= $this->lang->line('header_share_url_msg'); ?></p>
    </div>
	</form>
	</div>	
	
</div>
<script type="text/javascript"> 
  $("#sharetabs div").idTabs(); 
</script>

		</div>
		
		<script type="text/javascript">
			$(function() {
    			$('a[rel*=leanModal]').leanModal({ top : 150, closeButton: ".modal_close" });
			});
		</script>

<script type="text/javascript">
<?php $timestamp = time();?>
		$(function() {
			$('#share_upload').uploadify({
				'formData'     : {
					'method'   : 'post',
					'queueID'  : 'sharequeue',
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'buttonClass' : 'disk-upload-button',
				'buttonText' : '<?= $this->lang->line('header_share_upload') ?>',
				'swf'      : '<?=base_url()?>swf/uploadify.swf',
				'uploader' : '<?=site_url('disk/uploadShareFile')?>',
				'onUploadSuccess' : function(file, data, response) {
						var filedata = JSON.parse(data);
						var sourcehtml = "<a href='"+'<?=site_url('item')?>'+"/"+filedata.id+"' target='_blank'>"+filedata.title+"</a>&nbsp;&nbsp;<a href='"+'<?=site_url('item/edit')?>'+"/"+filedata.id+"' target='_blank'>"+'<?= $this->lang->line('header_share_file_edit') ?>'+"</a><br/>"
						$('#sharelist').prepend(sourcehtml);
					
			    }
			});
		});
	</script>

<div id="wrap"><div id="wrap-inner">

