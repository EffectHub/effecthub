<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="Effecthub, AwayEffect, Sparticle, Dragonbones, Away3D, Gaming artist, Game designer, Gaming social comunity, Game developer, HTML5, 3D, Flash, Unity, Unity3D, WebGL, iOS, iPhone, iPad, iPod, interactive 3D, high-end, interactive, design, director" /> 
	<meta name="description" content="<?= $this->lang->line('header_description'); ?>">
	<title><?php echo isset($title)?$title: $this->lang->line('header_title'); ?></title>
	<meta property="wb:webmaster" content="77bb2cf13b1a69d9" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	<!--[if gte IE 7]><!-->
	<link href="<?=base_url()?>css/main.css" media="screen, projection" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>css/master-min.css" media="screen, projection" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="<?=base_url()?>player/flash/swfobject.js"></script>
	<script src="<?php echo base_url()?>js/jquery-1.8.3.min.js"></script>
	<script src="<?=base_url()?>js/jquery.leanModal.min.js"></script>
	<script src="<?=base_url()?>js/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/uploadify.css">
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
			<form id="search" action="<?=site_url('item/particleSearch')?>" method="post">
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
			<p title="<?= $this->lang->line('header_coin_hint'); ?>"><img src="<?= base_url('images/icon-coin.png') ?>" height="15px" width="15px" /> <?= $this->session->userdata('point') ?></p>
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
			<a href="<?=site_url('item/featured/MostRecent')?>" class="has-sub"><?= $this->lang->line('header_explore');?></a>
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
			<a href="<?php echo $this->session->userdata('id')?site_url('task/mytask'):site_url('task')?>" class="has-sub"><?= $this->lang->line('header_tasks');?>
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
		<a class="form-sub tagline-action" style="margin-left:20px;float:right;color:#FFF;padding:10px" href="<?php echo site_url('item/create')?>"  onclick="_gaq.push(['_trackEvent', 'createbtn', 'clicked', 'Click Create in Header'])"><?= $this->lang->line('header_create');?></a>
	
		</li>
		<?php  }?>
		
	</ul>
</div></div> <!-- /header -->

<hr>

<div id="wrap" style="width:100%;height: 100%;"><div id="wrap-inner"  style="width:100%;height: 100%;padding:0">

<div id="content" class="group"  style="width:100%;max-width:100%;height:100%">

<div id="main" style="width:100%;height: 100%;">
                 <div style="width: 100%; height: 100%;padding:0px;margin:0px">
                 
                 <?php if($type=='dragonbones'){ ?>
                 <object type="application/x-shockwave-flash" name="design_panel_demo" data="<?=base_url()?>player/dragonbones/SkeletonAnimationDesignPanel.swf" width="100%" height="100%" id="design_panel_demo" style="visibility: visible;"><param name="allowfullscreen" value="true"><param name="wmode" value="transparent"><param name="allowscriptaccess" value="always"><param name="flashvars" value="__objectID=design_panel_demo&amp;data=<?php echo $item['download_url']?>"></object>
        		 <?php }else if($type=='particle'){ ?>
        		 <script type="text/javascript" src="<?=base_url()?>player/particle/swfobject.js"></script>
		        <script type="text/javascript">
		            // For version detection, set to min. required Flash Player version, or 0 (or 0.0.0), for no version detection. 
		            var swfVersionStr = "11.2.0";
		            // To use express install, set to playerProductInstall.swf, otherwise the empty string. 
		            var xiSwfUrlStr = "<?=base_url()?>player/particle/playerProductInstall.swf";
		            var flashvars = {"token":"<?php echo $user['token']?>","uid":"<?php echo $user['id']?>"};
		            var params = {};
		            params.quality = "high";
		            params.bgcolor = "#333333";
		            params.allowscriptaccess = "sameDomain";
		            params.allowfullscreen = "true";
		            params.allowFullScreenInteractive = "true";
		            params.wmode="direct";
		            var attributes = {};
		            attributes.id = "PreLoader";
		            attributes.name = "PreLoader";
		            attributes.align = "middle";
		            swfobject.embedSWF(
		                "<?=base_url()?>editor/particle/EffectHubWebEditor.swf?1", "flashContent", 
		                "100%", "100%", 
		                swfVersionStr, xiSwfUrlStr, 
		                flashvars, params, attributes);
		            // JavaScript enabled so display the flashContent div in case it is not replaced with a swf object.
		            swfobject.createCSS("#flashContent", "display:block;text-align:left;");
		        </script>
		        <div id="flashContent">
            <p>
                To view this page ensure that Adobe Flash Player version 
                11.6.0 or greater is installed. 
            </p>
            <script type="text/javascript"> 
                var pageHost = ((document.location.protocol == "https:") ? "https://" : "http://"); 
                document.write("<a href='http://www.adobe.com/go/getflashplayer'><img src='" 
                                + pageHost + "www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a>" ); 
            </script> 
        </div>
        		 <noscript>
		            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%" id="PreLoader">
		                <param name="movie" value="<?=base_url()?>editor/particle/EffectHubWebEditor.swf?1" />
		                <param name="quality" value="high" />
		                <param name="bgcolor" value="#333333" />
		                <param name="allowScriptAccess" value="sameDomain" />
		                <param name="allowFullScreen" value="true" />
		                <!--[if !IE]>-->
		                <object type="application/x-shockwave-flash" data="<?=base_url()?>player/particle/EffectHubWebEditor.swf" width="100%" height="100%">
		                    <param name="quality" value="high" />
		                    <param name="bgcolor" value="#333333" />
		                    <param name="allowScriptAccess" value="sameDomain" />
		                    <param name="allowFullScreenInteractive" value="true" />
		                    <param name="allowFullScreen" value="true" />
		                <!--<![endif]-->
		                <!--[if gte IE 6]>-->
		                    <p> 
		                        Either scripts and active content are not permitted to run or Adobe Flash Player version
		                        11.6.0 or greater is not installed.
		                    </p>
		                <!--<![endif]-->
		                    <a href="http://www.adobe.com/go/getflashplayer">
		                        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash Player" />
		                    </a>
		                <!--[if !IE]>-->
		                </object>
		                <!--<![endif]-->
		            </object>
		        </noscript>  
		        <?php }else if($type=='htmleditor'){ ?>
		        <form action="<?=site_url('item/savecode/1')?>" id="signin_form" method="post">	
                	<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/htmlEditor.css"/>
<link rel="stylesheet" href="<?=base_url()?>css/codemirror.css"/>
<link rel="stylesheet" href="<?=base_url()?>css/show-hint.css"/>
<link rel=stylesheet href="<?=base_url()?>css/docs.css"/>
<script type="text/javascript" src="<?=base_url()?>js/htmlEditor.js"></script>
<script src="<?=base_url()?>js/codemirror.js"></script>
<script src="<?=base_url()?>js/show-hint.js"></script>
<script src="<?=base_url()?>js/html-hint.js"></script>
<script src="<?=base_url()?>js/javascript.js"></script>
<script src="<?=base_url()?>js/css.js"></script>
<script src="<?=base_url()?>js/htmlmixed.js"></script>
<script src="<?=base_url()?>js/xml-hint.js"></script>	
<script src="<?=base_url()?>js/xml.js"></script>	
<script src="<?=base_url()?>js/mark-selection.js"></script>
<style type=text/css>
      .CodeMirror {
        float: left;
        width: 99%;
		height:88%;
		background-color:transparent;
		color:#FFF;
        border: 0px;
      }
      .CodeMirror-selected  { background-color: #09F !important; }
      .CodeMirror-selectedtext { color: white; }
    </style>
                	<div id="inner">
    	
    	<div class="side-content" id="side1">
    			<h6><?= $this->lang->line('itemeditcontent_recommendation');?></h6>
    			<?php foreach ($recommend as $items) {?>
    			
    			<div class="recommend-item" id="items">
    			<?php if($items['thumb_url']!=null||$items['pic_url']!=null){ ?>
  <span class="item_image_wrap" alt="<?php echo $items['title']; ?>" style="margin:0 0 8px 8px;height:100px;width:100%">
                        <span class="item_image" style="background-image:url(<?php echo $items['thumb_url']; ?>)"></span>
  </span>
  <?php  }else{?>
    				<iframe src="<?=site_url('item/preview_html/'.$items['id'])?>" scrolling="no" frameborder="NO" border="0" framespacing="0"></iframe>
    				<?php } ?>
    				<a href="<?=site_url('item/'.$items['id'])?>" title='<?= $items['title'] ?>'></a>
    			</div>
    			<?php } ?>
    			<a href="<?=site_url('item/featured/ThisMonth')?>" target="_blank"><?= $this->lang->line('itemeditcontent_more_effects');?></a>
    		</div>
    		
    		<div class="side-button" id="side2"></div>
    		
        <div id="editor">
            
            <div id="js-box">
                <div class="js-filling">
                    <div>JS</div>
                </div>                 
                <textarea  id="code_js" name="code_js"></textarea>
            </div>
            <div id="css-box">
                <div class="css-filling">
                    <div>CSS</div>
                </div>
                <textarea  id="code_css" name="code_css"></textarea>
            </div>
            <div id="html-box">
                <div class="html-filling">
                    <div>HTML</div>
                </div>
               <textarea  id="code" name="code"></textarea>
               
            </div>
            
        </div><!--div editor end-->
        <div id="div_Iframe">
        <iframe src="javascript:''" name='resultFrame' id='preview' frameBorder=0  width='100%' height='100%' scrolling="auto" style="background-color: #FFF" marginheight="1px"  allowfullscreen="true" sandbox="allow-scripts allow-pointer-lock allow-same-origin allow-popups allow-forms" allowtransparency="true">    
    	</iframe>
        </div>
    </div>
    <div id="footer">
        <div style="width:100%;display:inline;text-align:center;padding-right:50px">
    <input class="form-sub" rel="leanModal" type="button" name="file" href="#file" value="<?= $this->lang->line('itemeditcontent_add_file');?>">
		
    <input class="form-sub" rel="leanModal" type="button" name="signup" href="#signup" value="<?= $this->lang->line('itemeditcontent_save');?>">
    
    
    
    <div id="file" class="pop">
			<div id="file-ct">
				<div id="file-header" class="pop-header">
					<h2><?= $this->lang->line('itemeditcontent_add_file_title');?></h2>
					<p><?= $this->lang->line('itemeditcontent_add_file_description');?></p>
					<a class="modal_close" href="javascript:"></a>
				</div>
				 <div class="txt-fld">
				   <div id="queue"></div>
		<input id="file_upload" name="file_upload" type="file" multiple="true">
		</div>
			<!--	  <div class="btn-fld">
				  
    <input class="save-btn" name="commit" type="button" value="Finish &raquo;">
    
</div>-->
			</div>
		</div>
		<div id="signup" class="pop">
			<div id="signup-ct">
				<div id="signup-header" class="pop-header">
					<h2><?= $this->lang->line('itemfork_publish_title');?></h2>
					<!--<p><?= $this->lang->line('itemeditcontent_make_social');?></p>-->
					<a class="modal_close" href="javascript:"></a>
				</div>
				
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('itemeditcontent_title');?></label>
				    <input id="" name="title" type="text" />

				  </div>
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('itemeditcontent_description');?></label>
				    <textarea name="desc" id="desc" style="height: 80px; "  placeholder=""/></textarea>
				  </div>
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('itemedit_category'); ?></label>
				    <select name="type" class="support-select category" style="width:72%" id="type" placeholder="Item Type">
						<?php foreach($item_type_list as $_item_type): ?>
						<option value="<?php echo $_item_type['id']; ?>" name="<?= $_item_type['toolable']?>"><?php echo $lang==2?$_item_type['name_cn']:$_item_type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
				  </div>
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('itemeditcontent_tags');?></label>
				    <input id="" name="tags" type="text" />

				  </div>
				  <div class="btn-fld">
				  
        <input type="hidden" id="platform" name="platform" value="2"/>
    <input class="save-btn" name="commit" type="submit" value="<?= $this->lang->line('itemfork_publish');?> &raquo;">
</div>
			</div>
		</div>
    </div>
    <!--
        <button id="layout_l2r" onClick="layout_l2r()"></button>   	
        <button id="layout_t2b" onClick="layout_t2b()"></button>
        <button id="layout_r2l" onClick="layout_r2l()"></button>
        <button id="fenge1" onClick="fenge1()"></button>
        <button id="fenge2" onClick="fenge2()"></button>-->
    </div>
    <script type="text/javascript">
    function layout(){    
		var myDiv1 = document.getElementById("header");//根据id获取这个div
		var myDiv2 = document.getElementById("inner");
		var myDiv3 = document.getElementById("footer");
		myDiv1.style.height= 65+"px" ;
		myDiv2.style.height= window.document.body.clientHeight-100+"px" ;
		myDiv3.style.height= 35+"px" ;
		document.body.parentNode.style.overflow="hidden";
 }
	layout();
	window.onresize =layout;
 
 
	CodeMirror.commands.autocomplete = function(cm) {
        CodeMirror.showHint(cm, CodeMirror.hint.html);
		CodeMirror.showHint(cm, CodeMirror.hint.css);
		CodeMirror.showHint(cm, CodeMirror.hint.javascript);
 	}
 	var delay;
      // Initialize CodeMirror editor with a nice html5 canvas demo.
    var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
        mode: 'text/html',
		lineNumbers: true,
		lineWrapping: true,
        tabMode: 'indent',
		styleSelectedText: true,
        extraKeys: {"Ctrl-/": "autocomplete"}
      });
      editor.on("change", function() {
        clearTimeout(delay);
        delay = setTimeout(updatePreview, 150);
      });
	  var editor_css = CodeMirror.fromTextArea(document.getElementById('code_css'), {
        mode: 'css',
		lineNumbers: true,
		lineWrapping: true,
        tabMode: 'indent',
		styleSelectedText: true,
        extraKeys: {"Ctrl-/": "autocomplete"}
      });
      editor_css.on("change", function() {
        clearTimeout(delay);
        delay = setTimeout(updatePreview, 150);
      });
	  
	  var editor_js = CodeMirror.fromTextArea(document.getElementById('code_js'), {
        mode: 'javascript',
		lineNumbers: true,
		lineWrapping: true,
        tabMode: 'indent',
		styleSelectedText: true,
        extraKeys: {"Ctrl-/": "autocomplete"}
      });
      editor_js.on("change", function() {
        clearTimeout(delay);
        delay = setTimeout(updatePreview, 150);
      });
	  
      
      function updatePreview() {
        var previewFrame = document.getElementById('preview');
        var preview =  previewFrame.contentDocument ||  previewFrame.contentWindow.document;
        preview.open();
        var header = '<!DOCTYPE html><html class=\'\'><head><meta charset=\'UTF-8\'>';
        var footer = '<body>'+editor.getValue()+'<script> '+editor_js.getValue()+' <\/script></body><\/html>';
        preview.write(header);
        preview.write('<link rel="stylesheet" href="<?php echo base_url()?>css/reset.css"><script src="<?php echo base_url()?>js/prefixfree.min.js"><\/script>');
        preview.write('<script src="<?php echo base_url()?>js/jquery-1.8.3.min.js"><\/script>');
        preview.write(' <style> '+editor_css.getValue()+' <\/style> ');
        preview.write(footer);
        preview.close();
      }
     // setTimeout(updatePreview, 150);  
    </script>
</form>
<script type="text/javascript">
			$(function() {
    			$('input[rel*=leanModal]').leanModal({ top : 100, closeButton: ".modal_close" });		
			});
		</script>
<?php }else if($type=='aseditor'){ ?>
	<form action="<?=site_url('item/savecode/2')?>" id="signin_form" method="post">	
                	<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/htmlEditor.css"/>
<link rel="stylesheet" href="<?=base_url()?>css/codemirror.css"/>
<link rel="stylesheet" href="<?=base_url()?>css/show-hint.css"/>
<link rel=stylesheet href="<?=base_url()?>css/docs.css"/>
<script type="text/javascript" src="<?=base_url()?>js/asEditor.js"></script>
<script src="<?=base_url()?>js/codemirror.js"></script>
<script src="<?=base_url()?>js/show-hint.js"></script>
<script src="<?=base_url()?>js/html-hint.js"></script>
<script src="<?=base_url()?>js/javascript.js"></script>
<script src="<?=base_url()?>js/css.js"></script>
<script src="<?=base_url()?>js/htmlmixed.js"></script>
<script src="<?=base_url()?>js/xml-hint.js"></script>	
<script src="<?=base_url()?>js/xml.js"></script>	
<script src="<?=base_url()?>js/mark-selection.js"></script>
<style type=text/css>
      .CodeMirror {
        float: left;
        width: 99%;
		height:88%;
		background-color:transparent;
		color:#FFF;
        border: 0px;
      }
      .CodeMirror-selected  { background-color: #09F !important; }
      .CodeMirror-selectedtext { color: white; }
    </style>
                	<div id="inner">
    	<div class="side-content" id="side1">
    			<h6><?= $this->lang->line('itemeditcontent_recommendation');?></h6>
    			<?php foreach ($recommend as $items) {?>
    			
    			<div class="recommend-item" id="items">
    				<?php if($items['thumb_url']!=null||$items['pic_url']!=null){ ?>
  <span class="item_image_wrap" alt="<?php echo $items['title']; ?>" style="margin:0 0 8px 8px;height:100px;width:100%">
                        <span class="item_image" style="background-image:url(<?php echo $items['thumb_url']; ?>)"></span>
  </span>
  <?php  }else{?>
    				<iframe src="<?=site_url('item/preview_html/'.$items['id'])?>" scrolling="no" frameborder="NO" border="0" framespacing="0"></iframe>
    				<?php } ?>
    				<a href="<?=site_url('item/'.$items['id'])?>" title='<?= $items['title'] ?>'></a>
    			</div>
    			<?php } ?>
    			<a href="<?=site_url('item/featured/ThisMonth')?>" target="_blank"><?= $this->lang->line('itemeditcontent_more_effects');?></a>
    		</div>
    		
    		<div class="side-button" id="side2"></div>
        
        <div id="div_Iframe">
                      
                <div id="codeswf" class="codeswf" style="width:100%;height:100%">
                	<div id="swf_container" style="width:100%;height:100%">
                    	<div id="swf" style="width:100%;height:100%">
                                                    
						</div>
  					</div>
				</div>
        </div>
        <div id="editor">
            <div id="html-box" style="width:100%">
                <div class="html-filling">
                    <div>ActionScript</div>
                </div>
               <textarea id="asCode" name="as" cols="2000" ><?=trim($src['code']);?></textarea>
               
            </div>
        </div><!--div editor end-->
        
    </div>
    <div id="footer">
        <div style="width:100%;display:inline;text-align:center;padding-right:50px">
        <input type="hidden" id="download_url" name="download_url" value=""/>
        <input type="hidden" id="preview_url" name="preview_url" value=""/>
        <input type="hidden" id="key" name="key" value="<?=$src['id']?>"/>
    <input class="form-sub" rel="leanModal" type="button" name="file" href="#file" value="<?= $this->lang->line('itemeditcontent_add_file');?>">
    <input class="play_button form-sub" type="button" value="<?= $this->lang->line('itemeditcontent_preview');?>">
    <input class="form-sub" rel="leanModal" type="button" name="signup" href="#signup" value="<?= $this->lang->line('itemeditcontent_save');?>">
    
    
    <div id="file" class="pop">
			<div id="file-ct">
				<div id="file-header" class="pop-header">
					<h2><?= $this->lang->line('itemeditcontent_add_file_title');?></h2>
					<p><?= $this->lang->line('itemeditcontent_add_file_description');?></p>
					<a class="modal_close" href="javascript:"></a>
				</div>
				 <div class="txt-fld">
				   <div id="queue"></div>
		<input id="file_upload" name="file_upload" type="file" multiple="true">
		</div>
			</div>
		</div>
    
		<div id="signup" class="pop">
			<div id="signup-ct">
				<div id="signup-header" class="pop-header">
					<h2><?= $this->lang->line('itemfork_publish_title');?></h2>
					<!--<p><?= $this->lang->line('itemeditcontent_make_social');?></p>-->
					<a class="modal_close" href="javascript:"></a>
				</div>
				
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('itemeditcontent_title');?></label>
				    <input id="" name="title" type="text" />

				  </div>
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('itemeditcontent_description');?></label>
				    <textarea name="desc" id="desc" style="height: 100px; "  placeholder=""/></textarea>
				  </div>
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('itemedit_category'); ?></label>
				    <select name="type" class="support-select category" style="width:72%" id="type" placeholder="Item Type">
						<?php foreach($item_type_list as $_item_type): ?>
						<option value="<?php echo $_item_type['id']; ?>" name="<?= $_item_type['toolable']?>"><?php echo $lang==2?$_item_type['name_cn']:$_item_type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
				  </div>
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('itemeditcontent_tags');?></label>
				    <input id="" name="tags" type="text" />

				  </div>
				  <div class="btn-fld">
				  
        <input type="hidden" id="platform" name="platform" value="1"/>
				    <input class="save-btn" name="commit" type="submit" value="<?= $this->lang->line('itemfork_publish');?> &raquo;">
				</div>
			</div>
		</div>
    
    </div>
    <!--
        <button id="layout_l2r" onClick="layout_l2r()"></button>   	
        <button id="layout_t2b" onClick="layout_t2b()"></button>
        <button id="layout_r2l" onClick="layout_r2l()"></button>
        <button id="fenge1" onClick="fenge1()"></button>
        <button id="fenge2" onClick="fenge2()"></button>-->
    </div>
    <script type="text/javascript">
     $(document).ready(function(){
			$(".play_button").click(function(){
				var code = editor_js.getValue();
				if(code==''){
					alert("<?= $this->lang->line('itemfork_input_code');?>");
					return;
				}
				//$('#ShowProcess').fadeTo("slow").fadeIn().hstml("Compling,Please wait");
                $(".play_button").attr("value","<?= $this->lang->line('itemfork_compiling');?>");
				$.ajax({
					type:"post",
					data:{pid:'<?=$src['id']?>',pcode:code},
					url:"<?=site_url('result/compile')?>",
					datatype:"json",
					success:function(result)
					{
						//alert(result);
						var jsonObj=$.parseJSON(result);
                        
                        
                        var attributes ={
                        };
                        attributes.align="middle";
                        attributes.allowfullscreen ="true";
                        attributes.wmode="opaque";
                        var flashvars=false;
                        var params={
                        };
                        
                        if (jsonObj.statue)
                        {
                            //swfobject.embedSWF(jsonObj.content, "swf", "100%", "100%", "11.2.0",flashvars,params,attributes);
                            //swfobject.createCSS("#swf", "display:block;text-align:left;");
                            $("#swf").empty();
                            var c = document.getElementById("swfcontent");
                                if (!c) {
                                    var d = document.createElement("div");
                                    d.setAttribute("id", "swfcontent");
                                    document.getElementById("swf").appendChild(d);
                                }
                                // create SWF
                                var params = {};
					            params.quality = "high";
					            params.bgcolor = "#000000";
					            params.allowscriptaccess = "sameDomain";
					            params.allowfullscreen = "true";
					            params.allowFullScreenInteractive = "true";
					            params.wmode="opaque";
                                var att = { data:jsonObj.content, width:"100%", height:"100%" };
                                var par = { menu:"false" };
                                var id = "swfcontent";
                                swfobject.createSWF(att, params, id);
                                $("#download_url").attr("value",jsonObj.source);
                                $("#preview_url").attr("value",jsonObj.content);
                                $("#key").attr("value",jsonObj.key);
                                // rotate SWFs
                                //var s = swfs.shift();
                                //swfs.push(s);
                        }
                        else
                        {
                            $("#swf").empty();
                            swfobject.removeSWF("swfcontent");
                            $("#swf").text(jsonObj.content);
                        };
                        $(".play_button").attr("value","<?= $this->lang->line('itemeditcontent_preview');?>");
					},
					error:function()
					{
						alert("ajax error");
						//$('#ShowProcess').hide();
                        $(".play_button").text("<?= $this->lang->line('itemeditcontent_preview');?>");
					}				
				
				});
			
			});		
		});
	</script>	
    <script type="text/javascript">
    function layout(){    
		var myDiv1 = document.getElementById("header");//根据id获取这个div
		var myDiv2 = document.getElementById("inner");
		var myDiv3 = document.getElementById("footer");
		myDiv1.style.height= 65+"px" ;
		myDiv2.style.height= window.document.body.clientHeight-100+"px" ;
		myDiv3.style.height= 35+"px" ;
		document.body.parentNode.style.overflow="hidden";
 	}
	layout();
	window.onresize =layout;
 
   layout_l2r();
 
	CodeMirror.commands.autocomplete = function(cm) {
        CodeMirror.showHint(cm, CodeMirror.hint.html);
		CodeMirror.showHint(cm, CodeMirror.hint.css);
		CodeMirror.showHint(cm, CodeMirror.hint.actionscript);
 	}
 	var delay;
      // Initialize CodeMirror editor with a nice html5 canvas demo.
	  var editor_js = CodeMirror.fromTextArea(document.getElementById('asCode'), {
        mode: 'javascript',
		lineNumbers: true,
		lineWrapping: true,
        tabMode: 'indent',
		styleSelectedText: true,
        extraKeys: {"Ctrl-/": "autocomplete"}
      });
     /* editor_js.on("change", function() {
        clearTimeout(delay);
        delay = setTimeout(updatePreview, 150);
      });*/
    </script>
</form>
<script type="text/javascript">
			$(function() {
    			$('input[rel*=leanModal]').leanModal({ left:100,top : 100, closeButton: ".modal_close" });		
			});
		</script>
        		 <?php } ?>
        		 
        		 
        </div></div>
           </div>
           
         
    <script type="text/javascript">
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadify({
				'formData'     : {
					'method'   : 'post',
					'folder'   :  '<?=isset($src)?$src['id']:'0'?>',
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'swf'      : '<?=base_url()?>swf/uploadify.swf',
				'uploader' : '<?=site_url('item/uploadCodeFile')?>',
				'onUploadSuccess' : function(file, data, response) {
					if(data!='Invalid file type.'){
						var hiddenfield = '<input type="hidden" name="codefile[]" value="'+data+'"/>';
				        var a = $('.uploadify-queue').html();
				        $('.uploadify-queue').html(a+'<br/>'+'Upload successful. Access URL:<br/><a href="'+data+'" target="_blank">'+data+'</a>'+hiddenfield);
					}else{
						var a = $('.uploadify-queue').html();
				        $('.uploadify-queue').html(a+'<br/>'+'Invalid file type.');
					}
			    }
			});
		});
	</script>  
          
          
          
           
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-40602328-2', 'effecthub.com');
  ga('send', 'pageview');

</script>

		<link rel="stylesheet" href="<?=base_url()?>css/main2.css"/>

<?php if ($this->session->userdata('id')) {?>
	<script>
		$(function(){

			$('.side-content').css('left','-150px');
			$('.side-button').css({
				'left':'0px',
				'background-image':'url(<?=base_url()?>images/icon-open.png)'
			});
			
		});
	</script>
	<?php } else {?>

	<script>
		$(function(){

			$('#side1').animate({opacity:'1'},1500);
			$('#side2').animate({opacity:'1'},1500);
			$('#side1').animate({left:'-150px'},1000);
			$('#side2').animate({left:'0px'},1000,function(){
				$('#side2').css('background','#1a1a1a url(<?=base_url()?>images/icon-open.png) 50% 50% no-repeat');
			});
			
		});
	</script>
	
	<?php }?>
	
	<script>	
	
		$('.side-button').click(function(){
			if ( $('.side-button').css('left') == '0px' ){
				$('.side-content').css('left','0px');
				$('.side-button').css({
					'left':'150px',
					'background-image':'url(<?=base_url()?>images/icon-close.png)'
				});
			} else {
				$('.side-content').css('left','-150px');
				$('.side-button').css({
					'left':'0px',
					'background-image':'url(<?=base_url()?>images/icon-open.png)'
				});
			}
		});

		
		/*
		document.onclick = function (event) {     
        	var e = event||window.event;  
        	var elem = e.srcElement||e.target;  
              
            if((elem.id != "side1")&&(elem.id != "side2")&&(elem.id != "items")) {  
            	$('.side-content').css('left','-150px');
				$('.side-button').css('left','0px');
				$('.side-button').css('background-image','url("../images/icon-close.png")');
            }        

    	} 
		*/
		
	</script>
	


</div></div>
