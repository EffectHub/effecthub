<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="Effecthub, AwayEffect, Sparticle, Dragonbones, Away3D, Gaming artist, Game designer, Gaming social comunity, Game developer, HTML5, 3D, Flash, Unity, Unity3D, WebGL, iOS, iPhone, iPad, iPod, interactive 3D, high-end, interactive, design, director" /> 
	<meta name="description" content="EffectHub is a social network to connect the world's gaming artists and developers to enable them to be more productive and successful.">
	<title><?php echo isset($title)?$title:'EffectHub&Sparticle Particle Effect Contest: Enter to Win a 16GB iPad Air!'?></title>
	<meta property="wb:webmaster" content="77bb2cf13b1a69d9" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	<!--[if gte IE 7]><!-->
	<link href="<?=base_url()?>css/main.css" media="screen, projection" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>css/master-min.css" media="screen, projection" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="<?=base_url()?>player/flash/swfobject.js"></script>
	<script src="<?=base_url()?>js/jquery.min.js"></script>
	<script src="<?=base_url()?>js/jquery.leanModal.min.js"></script>
	<script src="<?=base_url()?>js/jquery.uploadify.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.idTabs.min.js"></script>
	<script src="<?=base_url()?>js/main.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/uploadify.css">

		<script type="text/javascript">
			$(function() {
    			$('input[rel*=leanModal]').leanModal({ top : 200, closeButton: ".modal_close" });
    			$("#hiddenlink").click();		
			});
		</script>
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-40602328-2']);
_gaq.push(['_setDomainName', '.effecthub.com']);

_gaq.push(['_trackPageview']);
_gaq.push(['_trackPageLoadTime']);

window._ga_init = function() {
    var ga = document.createElement('script');
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    ga.setAttribute('async', 'true');
    document.documentElement.firstChild.appendChild(ga);
};
if (window.addEventListener) {
    window.addEventListener('load', _ga_init, false);
} else {
    window.attachEvent('onload', _ga_init);
}
</script>
</head>

<body id="<?php echo isset($nav)?$nav:'explore' ?>">

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
		<?php if ($this->session->userdata('id')){  ?>
		<li>
		<a class="form-sub tagline-action" style="margin-left:20px;float:right;color:#FFF;padding:10px" href="<?php echo site_url('item/create')?>"  onclick="_gaq.push(['_trackEvent', 'createbtn', 'clicked', 'Click Create in Header'])"><?= $this->lang->line('header_create');?></a>
	
		</li>
		<?php  }?>
		
	</ul>
</div></div> <!-- /header -->

<hr>



<link href="<?=base_url()?>css/contest.css" rel="stylesheet" type="text/css">
<div id="wrap" style="width:100%"><div id="wrap-inner"  style="width:100%;padding:0">

<div id="content" class="group"  style="width:100%;max-width:100%;height:100%;">

<div id="main" style="width:100%;margin-bottom:20px;">
	<div id="contest" class="contestShow">
		<div id="contestLayoutHeader">
			<div id="contestBillboard">
				<img alt="Dmx-1400x600" src="<?=base_url()?>images/bg.jpg">
				<div id="contestTitle">
					<div class="container">
					<h3>Sparticle</h3>
					<h2>Particle Effect Contest</h2>
					</div>
				</div>
				<div id="contestTitleBackground"></div>
			</div>
		</div>
		<div id="idtabs"> 
		<div class="withBillboard" id="contestMenu">
			<ul class="contestMenu container">
			<li><a href="#contestContent">Project Brief</a></li>
			<li><a href="#contestInfo">More Info</a></li>
			<li><a href="#contestEnter">Enter This Contest</a></li>
			<li><a href="#contestEntry">See All Entries</a></li>
			<li><a href="#winnerEntry" class="selected">Winners</a></li>
			</ul>
		</div>
		
		<div id="contestContent">
		<div id="projectBrief">
			<div id="details">
				<div class="detailBox">
				<div class="detailIcon">
				<img alt="Deadline" src="<?=base_url()?>images/icons/deadline.png?1333627650">
				</div>
				<h3>Deadline of Submit Entries</h3>
				<div class="detailDetails">
				<span class="endDate">Server Time March 1, 2014</span>
				11:59 P.M
				</div>
				</div>
				
				<div class="detailBox">
				<div class="detailIcon">
				<img alt="Deadline" src="<?=base_url()?>images/icons/deadline.png?1333627650">
				</div>
				<h3>Deadline of Vote Entries</h3>
				<div class="detailDetails">
				<span class="endDate">Server Time March 15, 2014</span>
				11:59 P.M
				</div>
				</div>
				
				<div class="detailBox">
				<div class="detailIcon">
				<img alt="Share_this_contest" src="<?=base_url()?>images/icons/share_this_contest.png?1333627650">
				</div>
				<h3>Share This Contest</h3>
				<div class="detailDetails">
				<ul class="socialLinks">
				<!-- AddThis Button BEGIN -->
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
<!-- AddThis Button END --><br/>
				<div class="clear"></div>
				</ul>
				</div>
				</div>
				
				<div class="detailBox">
				<div class="detailIcon">
				<img alt="Cash_award" src="<?=base_url()?>images/icons/cash_award.png?1333627650">
				</div>
				<div class="detailDetails" style="font-size:14px;font-weight:normal;width:80%">
<strong>1st Prize</strong> <br/>
<p>A brand new 16GB Wi-Fi iPad Air (or $500 in Amazon Gift Card)</p>
<img alt="" src="http://store.storeimages.cdn-apple.com/3726/as-images.apple.com/is/image/AppleInc/ipad-air-step1-black-2013?wid=150&hei=195&fmt=png-alpha&qlt=95&.v=1383180934388" style="width: 200px; ">
<br/>
<strong>2nd Prize</strong> <br/>
<p>A brand new 16GB Nexus 5 (or $350 in Amazon Gift Card)</p>
<img alt="" src="https://www.google.com/nexus/images/nexus-5-new/learn_buy_1200.jpg" style="width: 200px; ">
<br/>
<strong>3rd Prize</strong> <br/>
<p>A brand new Kindle Paperwhite (or $120 in Amazon Gift Card)</p>
<img alt="" src="http://g-ecx.images-amazon.com/images/G/31/kindle/dp/2012/KC/KC-slate-03-lg._V369950680_.jpg" style="width: 200px;">

				</div>
				</div>
				
				<div class="detailBox">
				<div class="detailIcon">
				<img alt="File_specs" src="<?=base_url()?>images/icons/file_specs.png?1333627650">
				</div>
				<h3>Poster Specs</h3>
				<div class="detailDetails">
				<div style="margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px;">
					<ul>
						<li style="list-style-type: disc; margin: 0px 0px 0px 18px; padding: 0px 0px 0px 0px; font-size: 12px;">
							Accepted file formats: .zip, .awp</li>
						<li style="list-style-type: disc; margin: 0px 0px 0px 18px; padding: 0px 0px 0px 0px; font-size: 12px;">
							Max file size is 20mb</li>
					</ul>
				</div>
				</div>
				</div>
			</div>
			
			<div id="descriptions">
				<div class="briefBlock defaultContestStyles">
				<h2>Current Server Time: <?php echo $showtime=date("Y-m-d H:i:s");?></h2><br/>
				<h2>
					Enter Contest to Win iPad Air!</h2>
				<p>The holidays are almost here and that means it’s time to hold a contest to celebrate!</p><br/>
				<p>
					Sparticle is a profession GUI tool, based on one of the most popular 3D engines in Flash, Away 3D. This high-performance and GPU-accelerated tool is ideal for game-effect designers who want to develop complex 3D effects for their games.</p>
				<p><br/>
					The latest version of Sparticle is available&nbsp;<a href="<?=site_url('t/sparticle')?>" target="_blank">here</a>.&nbsp;</p>
				<h2>
					Sparticle Tutorial</h2>
				<p>
					<a href="<?=site_url('topic/54')?>">Basic Sparticle Tutorial</a><br/>
					<a href="<?=site_url('topic/92')?>">Advanced Sparticle Tutorial</a>
					</p>
					
				<h2>
					Get Inspired &amp; Guidelines</h2>
				<p>
					You can only create and upload particle effect by Sparticle (online version or desktop version).&nbsp;</p>
					
				<p><br/>
					You can get inspired from existing particles in EffectHub.com. E.g. Check out these top designs:</p>
				<p><br/>
					<a target="_blank" href="http://www.effecthub.com/item/99"><img alt="" src="http://www.effecthub.com/uploads/item/99_thumb.jpg" style="width: 215px; height: 170px;"></a>
					<a target="_blank" href="http://www.effecthub.com/item/101"><img alt="" src="http://www.effecthub.com/uploads/item/101_thumb.jpg" style="width: 215px; height: 170px;"></a>
					<a target="_blank" href="http://www.effecthub.com/item/36"><img alt="" src="http://www.effecthub.com/uploads/item/20582889-581E-9E68-BD57-D9121AFA11FE_thumb.jpg" style="width: 215px; height: 170px;"></a>
					<a target="_blank" href="http://www.effecthub.com/item/80"><img alt="" src="http://www.effecthub.com/uploads/item/58124D73-8002-840D-7FAE-96D04D1CB04B_thumb.jpg" style="width: 215px; height: 170px;"></a>
				</p>
				
				</div>
				<div class="briefBlock">
				<h3>Things You Need To Include</h3>
				<ul class="designDos defaultContestStyles">
				<li>Required: check the "contest" checkbox when upload. </li>
				</ul>
				</div>
				<div class="briefBlock">
				<h3>Things You Should Avoid</h3>
				<ul class="designDos defaultContestStyles">
				<li>DO NOT use ActionScript code.</li>
				<li>Respect copyright. DO NOT submit copyrighted work.</li>
				</ul>
				</div>
				<div class="briefBlock">
				<h3>Feedback</h3>
				<ul class="designDos defaultContestStyles">
				<li><a href="<?=site_url('topic/115')?>">click here</a></li>
				</ul>
				</div>
				</div>
				
				
		</div>
		</div>
		
		<div id="contestInfo">
		<div id="main" class="site">
<div class="col-about col-about-full under-hero" style="border-radius:0px">
<h2 class="section">ELIGIBILITY</h2>
<p>This contest is open to worldwide natural persons who, at the time of entry, are legal residents of their countries. Void where prohibited by law.  </p>
<p>Team members of EffectHub.com and Sparticle, and their immediate families (e.g., parents, children, siblings, spouse), including any other persons with whom they are domiciled, are not eligible to enter or participate.</p>
<h2 class="section">ENTRY</h2>
<p>Entrants may enter the contest by fully completing and submitting the work by Sparticle. </p>
<p>Entrants can create and upload the work by online version or desktop version of Sparticle. </p>
<p>Multiple entries per person/e-mail address or postal address are allowed. </p>
<p>Winners must be available to via Email address after the contest. Winners will receive corresponding Amazon Gift Card code via Email if their postal address is undeliverable. </p>
<h2 class="section">WINNER SELECTION AND CONTEST DATES</h2>
<p>Except as hereinafter provided, the contest will begin on January 15, 2014 and will end on March 1, 2014. Entries for all prizes must be received by 11:59PM, CST. </p>
<p>Then these entries will be voted by EffectHub.com members in next 14 days, from March 2, 2014 00:00 P.M. PDT to March 15, 2014 11:59 P.M. PDT.</p>
<p>Potential prize winners are selected by appreciation count which liked by verified EffectHub.com account before March 15, 2014 11:59 P.M. PDT.</p>
<p>The entry will not eligible if we found fraudulent conduct e.g. click the like button by robots or "zombie" accounts.</p>
<p>Potential prize winners will be notified by email within fourteen (14) days after selection. If winner is unreachable after 21 days, or if winner is unavailable for prize fulfillment, an alternate winner will be selected from all remaining eligible entries received. Any attempted prize notification which is returned as undeliverable may result in disqualification, in which case a selection of another winner will take place. Odds of winning depend on the number of eligible entries received.</p>
<h2 class="section">PRIZES</h2>
<strong>1st Prize</strong> <br/>
<p>A brand new 16GB Wi-Fi iPad Air (or $500 in Amazon Gift Card)</p>
<img alt="" src="http://store.storeimages.cdn-apple.com/3726/as-images.apple.com/is/image/AppleInc/ipad-air-step1-black-2013?wid=150&hei=195&fmt=png-alpha&qlt=95&.v=1383180934388" style="width: 215px; ">
<br/>
<strong>2nd Prize</strong> <br/>
<p>A brand new 16GB Nexus 5 (or $350 in Amazon Gift Card)</p>
<img alt="" src="https://www.google.com/nexus/images/nexus-5-new/learn_buy_1200.jpg" style="width: 215px; ">
<br/>
<strong>3rd Prize</strong> <br/>
<p>A brand new Kindle Paperwhite (or $120 in Amazon Gift Card)</p>
<img alt="" src="http://g-ecx.images-amazon.com/images/G/31/kindle/dp/2012/KC/KC-slate-03-lg._V369950680_.jpg" style="width: 215px;">

</div>
</div>
		<div class="secondary" style="color:#ddd">

	<h3 id="effecthub-newsletter"> <span class="meta">Install Sparticle</span> </h3>

<p class="info">
<iframe src="http://www.effecthub.com/update/badage/index.html" frameborder="0" scrolling="no" width="215" height="180"></iframe>
</p>
		</div>
		</div>
		
		<div id="contestEnter">
		<div id="main" class="site">
<div class="col-about col-about-full under-hero" style="border-radius:0px">
<h2 class="section">STEP 1</h2>
<p><a rel="leanModal" type="button" name="login" href="#login"  onclick="_gaq.push(['_trackEvent', 'contestbtn', 'clicked', 'Click Sign Up to enter Contest'])">Sign Up</a> as EffectHub.com member.</p>
<h2 class="section">STEP 2 (2 options)</h2>
<p>1. Install <a href="<?=site_url('t/sparticle')?>" target="_blank">Sparticle</a> and log in Sparticle with your email address.</p>
<p>2. Log in EffectHub.com with your email address, open <a href="<?=site_url('item/new_content/particle')?>" target="_blank">Sparticle Online</a></p>
<h2 class="section">STEP 3</h2>
<p>Upload your particle effect to EffectHub.com with Sparticle.</p>
<p><strong>Required</strong>: check the "contest" checkbox when upload. </p>
</div>
</div>
		<div class="secondary">

	<h3 id="effecthub-newsletter"> <span class="meta">Install Sparticle</span> </h3>

<p class="info">
<iframe src="http://www.effecthub.com/update/badage/index.html" frameborder="0" scrolling="no" width="215" height="180"></iframe>
</p>
</div>
		</div>
		
		
		
		
		<div id="contestEntry">
		
		<ol class="effecthubs group">
	<?php foreach($item_list as $_item): ?>
                   
                   <li id="work-<?php echo $_item['id']; ?>" class="group ">
	    <div class="effecthub">
	      <div class="effecthub-shot">
	        <div class="effecthub-img">
	          <a href="<?=site_url('item/'.$_item['id'])?>" class="effecthub-link"><div data-picture="" data-alt="<?php echo $_item['title']; ?>">
  <?php if($_item['thumb_url']!=null||$_item['pic_url']!=null){ ?>
  <span class="item_image_wrap" alt="<?php echo $_item['title']; ?>">
                        <span class="item_image" style="background-image:url(<?php echo $_item['thumb_url']; ?>)"></span>
  </span>
  <?php if ($_item['contest_id']>0){  ?>
                    <a title="EffectHub Particle Effect Contest: Enter to Win a 16GB iPad Air!" href="<?=site_url('contest')?>"><span class="tag_box" style="background:url(<?=base_url()?>images/contest.png) no-repeat 0 0;_background-image:none;_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=base_url()?>images/soldout.png',sizingMethod='noscale');"></span></a>
                    <?php  }?>
  <?php  }else{?>
  	<iframe src="<?=site_url('item/preview_html/'.$_item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 300px; height: 200px;padding:0px;margin:0px;"></iframe>
  <?php  }?>	
  </div></a>
	          <a href="<?=site_url('item/'.$_item['id'])?>" class="effecthub-over" style="opacity: 0;">		<strong><?php echo $_item['title']; ?></strong>
	            <span class="comment"><?php echo msubstr($_item['desc'],0,200); ?></span>
	            
	            <em class="timestamp"><?php echo tranTime(strtotime($_item['create_date'])); ?></em>
  </a></div>
	        <ul class="tools group" style="visibility: visible;">
	        
	          <li class="fav">
	            <a href="<?=site_url('item/'.$_item['id'])?>" title="<?= $this->lang->line('work_likes') ?>"><?php echo $_item['fav_num']; ?></a>
	            </li>
	          <li class="cmnt">
	            <a href="<?=site_url('item/'.$_item['id'])?>#comments" title="<?= $this->lang->line('work_comments') ?>"><?php echo $_item['comment_num']; ?></a>
	            </li>
	            <?php if($_item['is_private']==0){ ?>
	          <li class="views"><?php echo $_item['view_num']; ?></li>
	          <?php  }?>
  </ul>
	        
	        </div>
	      <div class="extras">
	      <?php if($_item['parent_id']!=0&&$_item['parent_id']!=null){ ?>
				<a href="<?=site_url('item/'.$_item['parent_id'])?>" style="display: inline;"><span rel="tipsy" class="rebound-mark is-rebound" style="display: inline;" original-title="<?= $this->lang->line('work_fork') ?>">
					<img alt="Rebound" height="16" src="<?=base_url()?>images/icon-rebound-2x.png" width="16">
				</span></a>
				<?php  }?>
				<?php if($_item['platform']>0){ ?>
     			<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_platform_first') ?> <?php echo $_item['platform_name']; ?> <?= $this->lang->line('work_platform') ?>">
				<img alt="Attachments" height="16" src="<?php echo $_item['platform_pic']; ?>" width="16">
				</span>
				<?php  }?>
				<?php if($_item['tool']>0){ ?>
     			<a target="_blank" href="<?=site_url('t/'.$_item['tool_domain'])?>" style="display: inline;">
     			<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_tool_first') ?> <?php echo $_item['tool_name']; ?><?= $this->lang->line('work_tool') ?>">
				<img alt="Attachments" height="16" src="<?php echo $_item['tool_pic']; ?>" width="16">
				</span>
				</a>
				<?php  }?>
				<?php if($_item['from']=='htmleditor'){ ?>
     			<a href="<?=site_url('item/fork/'.$_item['id'])?>" style="display: inline;"><span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_html') ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/code.png" width="16">
				</span></a>
				<?php  }?>
				<?php if($_item['from']=='aseditor'){ ?>
     			<a href="<?=site_url('item/fork/'.$_item['id'])?>" style="display: inline;"><span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_actionscript') ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/code.png" width="16">
				</span></a>
				<?php  }?>
				<?php if($_item['is_private']>0){ ?>
     			<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_private') ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/icon-lock.png" width="16">
				</span>
				<?php  }?>
				<?php if($_item['contest_id']==0&&$_item['is_private']==0&&($_item['download_url']!=0||$_item['download_url']!=null)){ ?>
     			<a target="_blank" href="<?=site_url('item/download/'.$_item['id'])?>" style="display: inline;"><span rel="tipsy" class="attachments-mark" style="display: inline;" original-title="<?= $this->lang->line('work_download') ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/icon-attach-16-2x.png" width="16"></a>
			</span>
			<?php  }?>
		</div>
	      </div>
	    
	    <h2>
	      <span class="attribution-user">
	        <a href="<?=site_url('user/'.$_item['author_id'])?>" class="url" rel="contact" title="<?php echo $_item['author_name']; ?>"><img alt="<?php echo $_item['author_name']; ?>" class="photo" src="<?php echo $_item['author_pic']; ?>"> <?php echo $_item['author_name']; ?></a>
	        <a href="javascript:" rel="tipsy" original-title="<?= $this->lang->line('work_mvp'); ?>" class="badge-link">
	          <span class="badge badge-pro">
	          <?php echo get_level($_item['author_level'],$_item['author_point']); ?>
	          </span>
  </a>
	        </span>
	      </h2>
</li>
                   
                <?php endforeach; ?>
                
	  

	</ol>
	</div>
		
		
		
		
		
		
		
		
		
		
		<div id="winnerEntry">
		
		
		
		<ol class="effecthubs group">
		
		
		<div  style="width:100%;display:block;position: relative;float:left">
                   <li id="work-<?php echo $_item['id']; ?>" class="group ">
                   <div class="effecthub">
	      		   <div class="effecthub-shot" style="color:#ddd;height:160px;over-flow:hidden">
                   <h1>1st Prize </h1>A brand new 16GB Wi-Fi iPad Air<br/>
                   <h1>2nd Prize </h1>A brand new 16GB Nexus 5<br/>
                   <h1>3rd Prize </h1>A brand new Kindle Paperwhite
                   </div>
                   </div>
                   </li>
                   <li style="width:65.2%;position: relative;float:left;">
                   <div class="effecthub">
	      		   <div class="effecthub-shot" style="color:#ddd;height:160px;over-flow:hidden">
                   <h1>Top 10 entries's author will be EffectHub MVP: </h1>
                   <ul style="margin:6px;padding:6px;margin-top:0px;line-height:23px">
                   <li>Premium features of editor and website will be enabled.</li>
                   <li>Get invitation to join MVP private group.</li>
                   <li>Experience for prerelease version.</li>
                   <li>Get 10Gb EffectHub Game Box.</li>
                   <li>No.4 - No.6 will get $100 amazon gift card, No.7 - No.10 will get $50 amazon gift card.</li>
                   <li></li>
                   </ul>
                   
                   </div>
                   </div>
                   </li>
                   </div>
	<?php 
	
	$i = 1;
	foreach($winner_list as $key=>$_item): 
	if($i<11){
	?>
                   <div  style="width:100%;display:block;position: relative;float:left">
                   <li id="work-<?php echo $_item['id']; ?>" class="group ">
	    <div class="effecthub">
	      <div class="effecthub-shot">
	        <div class="effecthub-img">
	          <a href="<?=site_url('item/'.$_item['id'])?>" class="effecthub-link"><div data-picture="" data-alt="<?php echo $_item['title']; ?>">
  <span class="item_image_wrap" alt="<?php echo $_item['title']; ?>">
                        <span class="item_image" style="background-image:url(<?php echo $_item['thumb_url']; ?>)"></span>
  </span>
  </div></a>
	          <a href="<?=site_url('item/'.$_item['id'])?>" class="effecthub-over" style="opacity: 0;"><?php echo $_item['title']; ?></strong>
	            <span class="comment"><?php echo msubstr($_item['desc'],0,200); ?></span>
	            
	            <em class="timestamp"><?php echo tranTime(strtotime($_item['create_date'])); ?></em>
  </a></div>
	        <ul class="tools group" style="visibility: visible;">
	          <li class="fav">
	            <a href="<?=site_url('item/'.$_item['id'])?>" title="See fans of this work"><?php echo $_item['fav_num']; ?></a>
	            </li>
	          <li class="cmnt">
	            <a href="<?=site_url('item/'.$_item['id'])?>#comments" title="View comments on this work"><?php echo $_item['comment_num']; ?></a>
	            </li>
	          <li class="views"><?php echo $_item['view_num']; ?></li>
  </ul>
	        
	        </div>
	      <div class="extras">
		</div>
	      </div>
	    
	    <h2>
	      <span class="attribution-user">
	        <a href="<?=site_url('user/'.$_item['author_id'])?>" class="url" rel="contact" title="<?php echo $_item['author_name']; ?>"><img alt="<?php echo $_item['author_name']; ?>" class="photo" src="<?php echo $_item['author_pic']; ?>"> <?php echo $_item['author_name']; ?></a>
	        <a href="javascript:" rel="tipsy" original-title="Top 3 works's respective owners every month could be EffectHub MVP." class="badge-link">
	          <span class="badge badge-pro">
	          <?php echo get_level($_item['author_level'],$_item['author_point']); ?>
	          </span>
  </a>
	        </span>
	      </h2>
</li>
<li style="width:65.2%;position: relative;float:left;">
<div class="effecthub">
<div class="effecthub-shot">
<?php 
$zui = '';
if($i==1)$zui = 'st Prize';
if($i==2)$zui = 'nd Prize';
if($i==3)$zui = 'rd Prize';
if($i>3)$zui = 'No.';
 ?>
<h1 style="color:#ddd"><?php echo $i>3?$zui.$i:$i.$zui ?>&nbsp; <?php echo $_item['title']; ?> by <?php echo $_item['author_name']; ?> (<?php echo $_item['fav_count']; ?> Verified Votes)</h1>
<div style="width:100%;height:100%;margin-top:10px">
<h2>They voted for this entry before 2014-03-15 11:59 PM (Verified Email Address)</h2>
<?php foreach($_item['fav_list'] as $_user): ?>
			<a href="<?php echo site_url('user/'.$_user['user_id']).'/'?>" style="margin:1px"><img height="30px" width="30px" title="<?php echo $_user['user_name']; ?> voted in <?php echo $_user['timestamp']; ?>" src="<?php echo $_user['user_pic']; ?>" alt="<?php echo $_user['user_name']; ?>"></a>
<?php endforeach; ?>

<?php $i++; ?>
<div>
</div></div>
</li>
                   </div>
                   
                <?php 
	}
                endforeach; 
                ?>
                
	  

	</ol>
		
		
		
		
		
		
		
		
		
		
		
		
		</div>
		
		</div>
		<script type="text/javascript"> 
		  $("#idtabs div").idTabs(); 
		</script>
		
	</div>
</div>


</div>

<div id="login" class="pop">
        
				<div id="register-header" class="pop-header">
					<h2>Join EffectHub.com</h2>
					<p> Working With Global Top Game Artists!</p>
				</div>
        <div id="idtabs1"> 
  <div class="apps-type"> 	
<ul class="tabs">
	<li style="margin:20px 0 0 20px"><a href="#login-ct" style="color:#000">Login</a></li>
	<li style="margin:20px 0 0 20px"><a href="#register-ct" class="selected" style="color:#000">Sign Up</a></li>
</ul>
</div>

	<div id="login-ct">
	<div class="txt-fld" style="padding:0px 20px 35px 20px">
				    <a class="addthis_login_twitter" title="Login with Twitter" href="<?=site_url('login/twitter')?>"><span id="twitter-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_facebook" title="Login with Facebook" href="<?=site_url('login/facebook')?>"><span id="facebook-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_google" title="Login with Google" href="<?=site_url('login/google')?>"><span id="google-connect" class="ssi-button"></span></a>
						            
				  </div>
				  <br/>
				<span style="margin-left:20px;color:#333">Or Login with your Email Address:</span>
				<form action="<?=site_url('login/check')?>" method="post">
				  <div class="txt-fld">
				    <label for="">Email</label>
				    <input id="" name="email" type="text"/>

				  </div>
				  <div class="txt-fld">
				    <label for="">Password</label>
				    <input id="" name="password" type="password"/>
				  </div>
				  
				  <div class="btn-fld" style="padding-left:20px;padding-right:20px;width:350px;vertical-align:center">
					  <label for="remember_me" style="display:inline;color:#000">Remember
				    <input type="checkbox" checked name="remember_me" id="remember_me"/></label>
					    <input class="save-btn" name="commit" type="submit" value="Sign In">
					   <!-- <a style="float:right;margin-top:10px;margin-right:10px;" target="_blank" href="<?=site_url('register')?>">Sign Up &raquo;</a>&nbsp;&nbsp;&nbsp;&nbsp;-->
					</div>
					<input type="hidden" name="redirectURL" value="<?=site_url('contest')?>"/>
					
					
					</form>
				</div>


	<div id="register-ct">
	<div class="txt-fld" style="padding:0px 20px 35px 20px">
				    <a class="addthis_login_twitter" title="Sign Up with Twitter" href="<?=site_url('login/twitter')?>"  onclick="_gaq.push(['_trackEvent', 'signup', 'clicked', 'Click twitter signup Button In contest Page'])"><span id="twitter-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_facebook" title="Sign Up with FaceBook" href="<?=site_url('login/facebook')?>"  onclick="_gaq.push(['_trackEvent', 'signup', 'clicked', 'Click facebook signup Button In contest Page'])"><span id="facebook-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_google" title="Sign Up with Google" href="<?=site_url('login/google')?>"  onclick="_gaq.push(['_trackEvent', 'signup', 'clicked', 'Click google signup Button In contest Page'])"><span id="google-connect" class="ssi-button"></span></a>
						            
				  </div>
				  <br/>
				<span style="margin-left:20px;color:#333">Or Sign Up Using your Email Address:</span>
				<form id="signin_form" action="<?=site_url('register/save')?>" method="post">
				  <div class="txt-fld">
				    <label for="">Your Email</label>
				    <input id="email_address" name="email_address" type="text" value=""/>
<span id="emailError" class="formErrorContent drop-shadow">This field must contain a valid email</span>
				  </div>
				  <div class="txt-fld">
				    <label for="">Set Password</label>
				    <input id="password" name="password" type="password" value=""/>
				    <span id="passwordError" class="formErrorContent drop-shadow">This field is required</span>
				  </div>
				  
				  <div class="btn-fld" style="padding-left:20px;padding-right:20px;width:350px;vertical-align:center">
					  <label for="remember_me" style="display:inline;color:#000">Stay informed via email
				    <input type="checkbox" checked name="consent" id="consent"/></label>
					    <input class="save-btn" name="commit" type="button" value="Sign Up For Free" onclick="checksignup();_gaq.push(['_trackEvent', 'signup', 'clicked', 'Click Sign Up Button In contest Page'])">
					</div>
						<input type="hidden" name="redirectURL" value="<?=site_url('contest')?>"/>
						</form>
					</div>	

</div>
<script type="text/javascript"> 
  $("#idtabs1 div").idTabs(); 
</script>

		</div>
		
		<script type="text/javascript">
			$(function() {
    			$('a[rel*=leanModal]').leanModal({ top : 200, closeButton: ".modal_close" });
			});
		</script>
<?php $this->load->view('footer') ?>