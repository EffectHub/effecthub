<?php if((isset($item['from'])&&$item['from']!=null&&$item['from']=='htmleditor')||($item['is_share']==1)){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php }else{ ?>
<!DOCTYPE html>	
<?php } ?>
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
	
	<link href="<?=base_url()?>css/adapt.css" media="screen, projection" rel="stylesheet" type="text/css">
	<!-- <![endif]-->
	<link href="<?=base_url()?>css/print.css" media="print" rel="stylesheet" type="text/css">
	
	<script src="<?php echo base_url()?>js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.tmpl.min.js"></script>
	<script src="<?php echo base_url()?>js/jquery.idTabs.min.js"></script>
	<script src="<?=base_url()?>js/main.js" type="text/javascript"></script>
	
	
</head>
<script type="text/javascript">
        function setContentHeight() {
            document.getElementById("mainFrame").style.height = document.body.clientHeight - 60 + "px";
        }
</script>
<style>
html,body{height:100%}
</style>
<body id="<?php echo isset($nav)?$nav:'works' ?>"  onload="setContentHeight();" style="overflow: hidden;">

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



<div id="wrap" style="width:100%;height:100%;background:#FFF"><div id="wrap-inner"  style="width:100%;height:100%;padding:0">

<div id="content" class="group"  style="width:100%;max-width:100%;height:100%">

<div id="main" style="width:100%;height:100%">
                 <div style="width: 100%; height: 100%;padding:0px;margin:0px">
                 
                 <?php if($item['is_share']==1){ ?>
                 <?php if(!strpos($item['preview_url'],'unity3d')){ ?>
                 <iframe src="<?php echo $item['preview_url']?>" name="mainFrame" id="mainFrame" onload="SetCwinHeight(this)" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 100%; height: 100%;padding:0px;margin:0px;"></iframe>
				 <?php }else{ ?>
				 <embed src="<?php echo $item['preview_url']?>" type="application/vnd.unity" width="100%" height="100%" firstframecallback="UnityObject2.instances[0].firstFrameCallback();" style="display: block; width: 100%; height: 100%;">
				 <?php } ?>
				 <?php }else if($item['extension']=='swf'){ ?>
		        	<object type="application/x-shockwave-flash" name="as_preview" data="<?php echo $item['download_url']?>" width="100%" height="100%" id="as_preview" style="visibility: visible;"><param name="allowfullscreen" value="true"><param name="wmode" value="direct"><param name="allowscriptaccess" value="always"></object> 
		         <?php }else if(isset($item['from'])&&$item['from']!=null&&($item['from']=='dragonbones'||stristr($item['tags'],'dragonbones'))){ ?>
                 <object type="application/x-shockwave-flash" name="design_panel_demo" data="<?=base_url()?>player/dragonbones/SkeletonAnimationDesignPanel.swf" width="100%" height="100%" id="design_panel_demo" style="visibility: visible;"><param name="allowfullscreen" value="true"><param name="wmode" value="transparent"><param name="allowscriptaccess" value="always"><param name="flashvars" value="__objectID=design_panel_demo&amp;data=<?php echo $item['download_url']?>"></object>
        		 <?php }else if(isset($item['from'])&&$item['from']!=null&&$item['from']=='htmleditor'){ ?>
        		 	<iframe src="<?=site_url('item/preview_html/'.$item['id'])?>" name="mainFrame" id="mainFrame" onload="SetCwinHeight(this)" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 100%; height: 100%;padding:0px;margin:0px;"></iframe>
        		 <?php }else if(isset($item['from'])&&$item['from']!=null&&$item['from']=='unity'){ ?>
        		 	<embed src="<?php echo $item['preview_url']?>" type="application/vnd.unity" width="100%" height="100%" firstframecallback="UnityObject2.instances[0].firstFrameCallback();" style="display: block; width: 100%; height: 100%;">
        		 <?php }else if(isset($item['from'])&&$item['from']!=null&&$item['from']=='sea3d'){ ?>
        		 <script type="text/javascript" src="<?=base_url()?>player/flash/swfobject.js"></script>
        <script type="text/javascript">
            // For version detection, set to min. required Flash Player version, or 0 (or 0.0.0), for no version detection. 
            var swfVersionStr = "11.4.0";
            // To use express install, set to playerProductInstall.swf, otherwise the empty string. 
            var xiSwfUrlStr = "<?=base_url()?>player/flash/playerProductInstall.swf";
            var flashvars = {url:'<?php echo $item['download_url']?>'};
            var params = {};
            params.quality = "high";
            params.bgcolor = "#333333";
            params.allowscriptaccess = "sameDomain";
            params.allowfullscreen = "true";
            params.wmode="direct";
            var attributes = {};
            attributes.id = "SEA3DPlayer";
            attributes.name = "SEA3DPlayer";
            attributes.align = "middle";
            swfobject.embedSWF(
                "<?=base_url()?>player/sea3d/SEA3DPlayer.swf", "flashContent", 
                "100%", "100%", 
                swfVersionStr, xiSwfUrlStr, 
                flashvars, params, attributes);
            // JavaScript enabled so display the flashContent div in case it is not replaced with a swf object.
            swfobject.createCSS("#flashContent", "display:block;text-align:left;");
        </script>
		  <div id="flashContent">
            <p>
                To view this page ensure that Adobe Flash Player version 
                11.4.0 or greater is installed. 
            </p>
            <script type="text/javascript"> 
                var pageHost = ((document.location.protocol == "https:") ? "https://" : "http://"); 
                document.write("<a href='http://www.adobe.com/go/getflashplayer'><img src='" 
                                + pageHost + "www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a>" ); 
            </script> 
        </div>
        
        <noscript>
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="1024" height="632" id="SEA3DPlayer">
                <param name="movie" value="<?=base_url()?>player/sea3d/SEA3DPlayer.swf" />
                <param name="quality" value="high" />
                <param name="bgcolor" value="#333333" />
                <param name="allowScriptAccess" value="sameDomain" />
                <param name="allowFullScreen" value="true" />
                <param name="wmode" value="direct" />
                <!--[if !IE]>-->
                <object type="application/x-shockwave-flash" data="<?=base_url()?>player/sea3d/SEA3DPlayer.swf" width="1024" height="632">
                    <param name="quality" value="high" />
                    <param name="bgcolor" value="#333333" />
                    <param name="allowScriptAccess" value="sameDomain" />
                    <param name="allowFullScreen" value="true" />
                <!--<![endif]-->
                <!--[if gte IE 6]>-->
                    <p> 
                        Either scripts and active content are not permitted to run or Adobe Flash Player version
                        11.4.0 or greater is not installed.
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
        		 
        		 <?php }else if(isset($item['from'])&&$item['from']!=null&&$item['from']=='particle'){ ?>
        		 <script type="text/javascript" src="<?=base_url()?>player/particle/swfobject.js"></script>
		        <script type="text/javascript">
		            // For version detection, set to min. required Flash Player version, or 0 (or 0.0.0), for no version detection. 
		            var swfVersionStr = "11.2.0";
		            // To use express install, set to playerProductInstall.swf, otherwise the empty string. 
		            var xiSwfUrlStr = "<?=base_url()?>player/particle/PreLoader.swf";
		            var flashvars = {"asset":"<?=site_url('download/data/'.$item['id'])?>"};
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
		                "<?=base_url()?>player/particle/PreLoader.swf", "flashContent", 
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
		                <param name="movie" value="<?=base_url()?>editor/particle/PreLoader.swf" />
		                <param name="quality" value="high" />
		                <param name="bgcolor" value="#333333" />
		                <param name="allowScriptAccess" value="sameDomain" />
		                <param name="allowFullScreenInteractive" value="true" />
		                <param name="allowFullScreen" value="true" />
		                <!--[if !IE]>-->
		                <object type="application/x-shockwave-flash" data="<?=base_url()?>player/particle/PreLoader.swf" width="100%" height="100%">
		                    <param name="quality" value="high" />
		                    <param name="bgcolor" value="#333333" />
		                    <param name="allowScriptAccess" value="sameDomain" />
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
        		 <?php }else{ ?>
                 <iframe src="<?php echo $item['preview_url']?>" scrolling="no" name="mainFrame" id="mainFrame" onload="SetCwinHeight(this)"  frameborder="NO" border="0" framespacing="0" style="width: 100%; height: 100%;padding:0px;margin:0px;"></iframe>
				 <?php } ?>
        </div></div>
           </div>
           
           
           
</div>
<script type="text/javascript">
function SetCwinHeight(obj) {
    var cwin = obj;
    if (document.getElementById) {
        if (cwin && !window.opera) {
            if (cwin.contentDocument && cwin.contentDocument.body.offsetHeight)
                cwin.height = cwin.contentDocument.body.offsetHeight + 20; //FF NS
            else if (cwin.Document && cwin.Document.body.scrollHeight)
                cwin.height = cwin.Document.body.scrollHeight + 10; //IE
        }
        else {
            if (cwin.contentWindow.document && cwin.contentWindow.document.body.scrollHeight)
                cwin.height = cwin.contentWindow.document.body.scrollHeight; //Opera
        }
    }
}
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-40602328-2', 'effecthub.com');
  ga('send', 'pageview');

</script>
</div></div>
</body>
</html>