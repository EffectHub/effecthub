<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="Effecthub, AwayEffect, Sparticle, Dragonbones, Away3D, Gaming artist, Game designer, Gaming social comunity, Game developer, HTML5, 3D, Flash, Unity, Unity3D, WebGL, iOS, iPhone, iPad, iPod, interactive 3D, high-end, interactive, design, director" /> 
	<meta name="description" content="EffectHub is a social network to connect the world's gaming artists and developers to enable them to be more productive and successful.">
	<title><?php echo isset($title)?$title:'EffectHub & 图灵图书 移动游戏分享大赛: 参加即能赢取最新版Kindle以及移动游戏开发图书!'?></title>
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
		<!--
		<li>
		<a class="form-sub tagline-action" style="margin-left:20px;float:right;color:#FFF;padding:10px" href="<?php echo site_url('item/create')?>"  onclick="_gaq.push(['_trackEvent', 'createbtn', 'clicked', 'Click Create in Header'])"><?= $this->lang->line('header_create');?></a>
	
		</li>
		-->
		<?php  }?>
		
	</ul>
</div></div> <!-- /header -->

<hr>



<link href="<?=base_url()?>css/contest.css" rel="stylesheet" type="text/css">

<STYLE type=text/css>
p,h3,h2,#descriptions li {
	FONT-FAMILY: 'Microsoft Yahei';
	font-size: 14px;
}
form.gen-form label {
	width:10%;
	font-size: 14px;
}
.form-sub {
	font-size: 14px;
}
</STYLE>
<div id="wrap" style="width:100%"><div id="wrap-inner"  style="width:100%;padding:0">

<div id="content" class="group"  style="width:100%;max-width:100%;height:100%;">

<div id="main" style="width:100%;margin-bottom:20px;">
	<div id="contest" class="contestShow">
		<div id="contestLayoutHeader">
			<div id="contestBillboard" style="background-color:#fff">
				<img alt="Dmx-1400x600" src="<?=base_url()?>images/turing.jpg">
				<div id="contestTitle">
					<div class="container">
					<h3>EffectHub & 图灵图书</h3>
					<h2>移动游戏分享大赛</h2>
					</div>
				</div>
				<div id="contestTitleBackground"></div>
			</div>
		</div>
		<div id="idtabs"> 
		<div class="withBillboard" id="contestMenu">
			<ul class="contestMenu container">
			<li><a class="selected" href="#contestContent">活动简介</a></li>
			<li><a href="#contestInfo">详细信息</a></li>
			<li><a href="#contestEnter">立即参加</a></li>
			<li><a href="#contestEntry">分享列表</a></li>
			<li><a href="#winnerEntry">获奖结果</a></li>
			</ul>
		</div>
		
		<div id="contestContent">
		<div id="projectBrief">
			<div id="details">
				<div class="detailBox">
				<div class="detailIcon">
				<img alt="Deadline" src="<?=base_url()?>images/icons/deadline.png?1333627650">
				</div>
				<h3>游戏分享截止日期</h3>
				<div class="detailDetails">
				<span class="endDate">2014年6月20日</span>
				23时59分59秒
				</div>
				</div>
				
				<div class="detailBox">
				<div class="detailIcon">
				<img alt="Deadline" src="<?=base_url()?>images/icons/deadline.png?1333627650">
				</div>
				<h3>分享投票截止日期</h3>
				<div class="detailDetails">
				<span class="endDate">2014年6月30日</span>
				23时59分59秒
				</div>
				</div>
				
				<div class="detailBox">
				<div class="detailIcon">
				<img alt="Share_this_contest" src="<?=base_url()?>images/icons/share_this_contest.png?1333627650">
				</div>
				<h3>分享本次活动</h3>
				<div class="detailDetails">
				<ul class="socialLinks">
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
<!-- Baidu Button END -->
				<div class="clear"></div>
				</ul>
				</div>
				</div>
				
				<div class="detailBox">
				<div class="detailIcon">
				<img alt="Cash_award" src="<?=base_url()?>images/icons/cash_award.png?1333627650">
				</div>
				<div class="detailDetails" style="font-size:14px;font-weight:normal;width:80%">
				
				<h2>
					分享移动游戏 轻松获取移动游戏开发图书!</h2>
				<p>想学习移动游戏开发，投身移动互联网热潮，却苦于没有优秀的中文学习资料？</p><br/>
				<p>
					EffectHub.com网站与图灵图书合作，举办移动游戏分享大赛！</p>
				<p><br/>
					非常简单，您只需把您觉得好的手机游戏或平板游戏截个图，填写游戏和下载地址，即可参加本次比赛。我们为比赛准备了数十本琳琅满目的图书，包括Cocos2d-x，Unity3D等游戏开发相关书籍。</p>
				</div>
				</div>
				
				<div class="detailBox">
				<div class="detailIcon">
				<img alt="File_specs" src="<?=base_url()?>images/icons/file_specs.png?1333627650">
				</div>
				<h3>比赛规格</h3>
				<div class="detailDetails">
				<div style="margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px;">
					<ul>
						<li style="list-style-type: disc; margin: 0px 0px 0px 18px; padding: 0px 0px 0px 0px; font-size: 12px;">
							可以是自己开发的游戏，也可以是其他人开发的游戏</li>
						<li style="list-style-type: disc; margin: 0px 0px 0px 18px; padding: 0px 0px 0px 0px; font-size: 12px;">
							分享的时候需要填写下载地址和上传截图</li>
					</ul>
					
				<div class="briefBlock">
				<h3>意见反馈</h3>
				<ul class="designDos defaultContestStyles">
				<li><a href="<?=site_url('topic/319')?>">点击这里</a></li>
				</ul>
				<br/>
				<h2>当前服务器时间: <?php echo $showtime=date("Y-m-d H:i:s");?></h2>
				</div>
				</div>
				</div>
				
				</div>
			</div>
			
			<div id="descriptions">
				<div class="briefBlock defaultContestStyles">
<strong>所有分享中获得喜欢数最多（与图书奖品叠加）</strong> <br/><p>全新 Kindle Paperwhite (或者 价值120美元的亚马逊礼品卡)（一名）</p>
<img alt="" src="http://g-ecx.images-amazon.com/images/G/31/kindle/dp/2012/KC/KC-slate-03-lg._V369950680_.jpg" style="width: 150px;">
<br/>
<strong>所有分享中随机抽取</strong> <br/>
<div>
<p>《通关-游戏设计之道》（一名）</p>
<a href="http://item.jd.com/11349833.html" target="_blank">
<img alt="" src="http://img11.360buyimg.com/n1/g14/M07/04/10/rBEhV1KdQmcIAAAAAAH-_R3WjCsAAGXxwHJil0AAf8V832.jpg" style="width: 150px; ">
</a>
</div>
<br/>

<strong>分享Cocos2d-x游戏获得喜欢数最多前六名</strong> <br/>
<div style="float:left">
<p>《Cocos2d-x高级开发教程》(三名)</p>
<a href="http://item.jd.com/11242111.html" target="_blank">
<img alt="" src="http://img11.360buyimg.com/n1/g12/M00/09/02/rBEQYVGcmT0IAAAAAAnRU72bucUAABxZwOjC7YACdFr385.jpg" style="width: 150px; ">
</a>
</div>
<div>
<p>《Cocos2d-x手机游戏开发》(三名)</p>
<a href="http://item.jd.com/10896657.html" target="_blank">
<img alt="" src="http://img11.360buyimg.com/n1/19157/ce8d6768-779c-4b6b-b899-4acc371dac32.jpg" style="width: 150px; ">
</a>
</div>
<br/>	

<strong>分享HTML5移动游戏获得喜欢数最多前六名</strong> <br/>
<div style="float:left;margin-right:10px">
<p>《HTML5游戏开发》(三名)</p>
<a href="http://item.jd.com/1152679285.html" target="_blank">
<img alt="" src="http://www.ituring.com.cn/bookcover/730.jpg" style="width: 150px; ">
</a>
</div>
<div>
<p>Adobe PhoneGap团队限量T恤(三名)</p>
<img alt="" src="https://pbs.twimg.com/media/BMv7GJBCEAAvre_.jpg" style="width: 150px; ">
</div>
<br/>
<strong>分享原生开发游戏获得喜欢数最多前四名</strong> <br/>
<div style="float:left">
<p>《网络游戏核心技术与实战》（两名）</p>
<a href="http://item.jd.com/11437469.html" target="_blank">
<img alt="" src="http://img11.360buyimg.com/n1/g10/M00/1D/08/rBEQWVNfFLUIAAAAAAMPbDT6d4gAAFvEgB5QOsAAw-E494.jpg" style="width: 150px; ">
</a>
</div>
<div>
<p>《神作之路：卓越游戏设计剖析》（两名）</p>
<a href="http://item.jd.com/11172120.html" target="_blank">
<img alt="" src="http://img10.360buyimg.com/n1/g10/M00/02/00/rBEQWFEI7e8IAAAAAAE14hl0FXcAAAZFwPI8h8AATX6592.jpg" style="width: 150px; ">
</a>
</div>
<br/>

<strong>分享Unity3D游戏获得喜欢数最多前三名</strong> <br/>
<p>《Unity3D游戏开发》(三名)</p>
<a href="http://item.jd.com/11016776.html" target="_blank">
<img alt="" src="http://img10.360buyimg.com/n1/g5/M01/02/0E/rBEDik_Rc3UIAAAAAAC3q-SL-o0AAAevAA2cmIAALfD392.jpg" style="width: 150px; ">
</a>
<br/>				
				
				</div>
				</div>
				
				
		</div>
		</div>
		
		<div id="contestInfo">
		<div id="main" class="site">
<div class="col-about col-about-full under-hero" style="border-radius:0px">
<h2 class="section">参与资格</h2>
<p>本次比赛向全中国的游戏爱好者开放.  </p>
<p>为了比赛的公平公正，EffectHub.com的工作人员和其亲属不能参加本次比赛.</p>
<h2 class="section">作品提交</h2>
<p>移动游戏必须通过EffectHub网站进行分享. </p>
<p>一个人可以分享多个游戏，以票数最高的那个游戏作为比赛评判标准. </p>
<p>获奖作者必须在比赛结束后保持Email可联系. 获奖作者必须提供正确的邮寄地址，以便我们邮寄奖品。</p>
<h2 class="section">比赛时间以及评奖标准</h2>
<p>如无变化, 比赛将于2014年5月20日开始，2014年6月20日截止. 参赛作品必须在2014年5月20日0点之后，2014年6月20日晚上23点59分59秒之前提交. </p>
<p>2014年6月20日晚上23点59分59秒之后，比赛进入投票期，投票截止日期为2014年6月30日晚上23点59分59秒。
<p>我们将以作品获取的EffectHub有效账户在2014年6月30日晚上23点59分59秒之前点击的喜欢数量作为评判标准, 为了比赛的公平公正，如果我们发现欺诈行为，该项作品将被取消参加资格， 例如，由机器人或僵尸账户点击喜欢按钮来增加喜欢数量，有效账户必须经过Email验证。
<p>获奖作者将在比赛结束后的两周内收到邮件通知. 如果获奖作者在三周内仍联系不上，或者作者表示放弃获奖资格, 我们将按照喜欢数量顺序依次从剩余的作品中选择获奖作者.</p>
</div>
</div>
		<div class="secondary" style="color:#ddd">

	<h3 id="effecthub-newsletter"> <span class="meta">EffectHub特效大赛优秀作品欣赏</span> </h3>

<p class="info">
	<ol class="prevnext group" style="margin-top:25px">
	<?php foreach($hot_item_list as $_hot_item): ?>
                        <li>
		<a title="<?php echo $_hot_item['title']; ?>" href="<?=site_url('item/'.$_hot_item['id'])?>" style="margin-right:15px">
		<?php if($_hot_item['thumb_url']!=null||$_hot_item['pic_url']!=null){ ?>
  <img width="90px" height="72px" alt="<?php echo $_hot_item['title']; ?>" src="<?php echo $_hot_item['thumb_url']; ?>">
  <?php  }else{?>
  	<iframe src="<?=site_url('item/preview_html/'.$_hot_item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 78px; height: 60px;padding:6px;margin:0px;background:#212121"></iframe>
  <?php  }?>
		</a>
                        <?php endforeach; ?>
</ol>
</p>
		</div>
		</div>
		
		<div id="contestEnter">
		<div id="main" class="site">
<div class="col-about col-about-full under-hero" style="border-radius:0px">
<?php if (!$this->session->userdata('id')){  ?>
<h2 class="section">第一步</h2>
<p><a rel="leanModal" type="button" name="login" href="#login"  onclick="_gaq.push(['_trackEvent', 'turingbtn', 'clicked', 'Click Sign Up to enter Turing'])">注册</a> 成为 EffectHub.com 的成员.</p>
<h2 class="section">第二步</h2>
<p>使用您刚刚注册的账户登录 EffectHub.com，</p>
<h2 class="section">第三步</h2>
<p>填写必要信息，上传截图，分享移动游戏到 EffectHub.com.</p>
<?php  }else{?>
<form action="<?=site_url('item/save')?>" enctype="multipart/form-data" class="gen-form with-messages" id="signin_form" method="post">	
<div class="form-field">
		<fieldset>
                <label for="title">游戏名称</label> 
		            <input type="text" class="signin_input txt" id="title" name="title" placeholder="" value="">
		            <span id="titleError" class="formErrorContent drop-shadow"><?= $this->lang->line('itemshare_error'); ?></span>
		            </fieldset>
		            
		            </div>
           <div class="form-field"> 
            <fieldset>
                <label for="desc">游戏简介</label>
		            <textarea name="desc" id="desc" class="signin_input txt"  style="height: 200px; "  placeholder=""/></textarea>
		            <span id="descError" class="formErrorContent drop-shadow"><?= $this->lang->line('itemshare_error'); ?></span>
		            </fieldset></div>
		    <div class="form-field"> 
            <fieldset>
                <label for="tags">游戏标签</label>
		            <input type="text" class="signin_input txt" name="tags" placeholder=""/>
		            </fieldset>
		            <p class="message"><?= $this->lang->line('itemshare_tags_slogan'); ?></p>
		            </div>
		            <div class="form-field">
            <fieldset>
                <label for="url">游戏截图</label>
                    <div style="padding-bottom:5px"><input type="text" readonly style="width:200px;display:auto" value="" name="upfile" id="upfile" class="txt create_input">  
						<input type="button" class="form-sub" value="<?= $this->lang->line('item_browse'); ?>" onclick="url.click()"> 
						<input type="file" id="url" name="url" style="display:none" onchange="upfile.value=this.value" value="">
						<span id="screenshotError" class="formErrorContent drop-shadow"><?= $this->lang->line('itemshare_error'); ?></span></div>
		            </fieldset>
		            </div>
		            <div class="form-field">
		<fieldset>
                <label for="preview">下载地址</label> 
		            <input type="text" class="signin_input txt" id="preview" name="download_url" placeholder="" value="">
		            <span id="previewError" class="formErrorContent drop-shadow"><?= $this->lang->line('itemshare_error'); ?></span>
		            </fieldset>
		            
		            </div>
		            <div class="form-btns">
<input value="sina" <?php echo $this->session->userdata('token_sina')==null?'disabled':'checked' ?> id="bc_mb_tc" name="socialBind[]" type="checkbox" class="sent_sync_1">
<span title="Weibo<?php echo $this->session->userdata('token_sina')==null?'(Not Connected)':'' ?>" class="ico_sina"></span>
			<input type="hidden" name="share" value="1"/>
			<input type="hidden" name="type" value="12"/>
			<input type="hidden" name="contest_id" value="2"/>
				<input class="form-sub" name="commit" type="button" value="<?= $this->lang->line('itemshare_save'); ?>" onclick="checkshare()">
			</div>
</form>
<?php  }?>
</div>
</div>
		<div class="secondary">

	<h3 id="effecthub-newsletter"> <span class="meta">EffectHub特效大赛优秀作品欣赏</span> </h3>

<p class="info">
	<ol class="prevnext group" style="margin-top:25px">
	<?php foreach($hot_item_list as $_hot_item): ?>
                        <li>
		<a title="<?php echo $_hot_item['title']; ?>" href="<?=site_url('item/'.$_hot_item['id'])?>" style="margin-right:15px">
		<?php if($_hot_item['thumb_url']!=null||$_hot_item['pic_url']!=null){ ?>
  <img width="90px" height="72px" alt="<?php echo $_hot_item['title']; ?>" src="<?php echo $_hot_item['thumb_url']; ?>">
  <?php  }else{?>
  	<iframe src="<?=site_url('item/preview_html/'.$_hot_item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 78px; height: 60px;padding:6px;margin:0px;background:#212121"></iframe>
  <?php  }?>
		</a>
                        <?php endforeach; ?>
</ol>

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
  <?php if ($_item['contest_id']==2){  ?>
                    <a title="EffectHub & 图灵图书 移动游戏分享大赛: 参加即能赢取最新版Kindle以及移动游戏开发图书!" href="<?=site_url('turing')?>"><span class="tag_box" style="background:url(<?=base_url()?>images/contest.png) no-repeat 0 0;_background-image:none;_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=base_url()?>images/soldout.png',sizingMethod='noscale');"></span></a>
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
				<?php if($_item['download_url']!=0||$_item['download_url']!=null){ ?>
     			<a target="_blank" href="<?=site_url('item/download/'.$_item['id'])?>" style="display: inline;">
     			<span rel="tipsy" class="attachments-mark" style="display: inline;" original-title="<?= $this->lang->line('work_download') ?>">
				<?php echo $_item['title']; ?>
			</span></a>
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
	      		   <div class="effecthub-shot" style="color:#ddd;height:170px;over-flow:hidden">
                   <h1>随机抽取奖项 </h1>网友Hannibal获得图书《通关-游戏设计之道》<br/>
                   </div>
                   </div>
                   </li>
                   <li style="width:65.2%;position: relative;float:left;">
                   <div class="effecthub">
	      		   <div class="effecthub-shot" style="color:#ddd;height:170px;over-flow:hidden">
                   <h1>一等奖</h1>
                   <ul style="margin:6px;padding:6px;margin-top:0px;line-height:23px">
                   <li>网友15397113768获得全新 Kindle Paperwhite + 《网络游戏核心技术与实战》</li>
                   </ul>
                   </div>
                   </div>
                   </li>
                   </div>
	<?php 
	
	$i = 1;
	foreach($winner_list as $key=>$_item): 
	if($i<21){
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
if($i==1)$zui = '一等奖';
if($i==2)$zui = '二等奖';
if($i==3)$zui = '三等奖';
if($i>3)$zui = 'No.';
 ?>
<h1 style="color:#ddd"><?php echo $i<4?$zui:'第'.$i.'名' ?>&nbsp; <?php echo $_item['title']; ?> by <?php echo $_item['author_name']; ?> (<?php echo $_item['fav_count']; ?> 有效票数)</h1>
<div style="width:100%;height:100%;margin-top:10px">
<h2>他们在2014-03-15 11:59 PM之前投了票 (通过了邮箱验证)</h2>
<?php foreach($_item['fav_list'] as $_user): ?>
			<a href="<?php echo site_url('user/'.$_user['user_id']).'/'?>" style="margin:1px"><img height="30px" width="30px" title="<?php echo $_user['user_name']; ?> 投票于 <?php echo $_user['timestamp']; ?>" src="<?php echo $_user['user_pic']; ?>" alt="<?php echo $_user['user_name']; ?>"></a>
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
                
	  

	</ol></div>
		
		</div>
		<script type="text/javascript"> 
		  $("#idtabs div").idTabs(); 
		</script>
		
	</div>
</div>


</div>

<div id="login" class="pop">
        
				<div id="register-header" class="pop-header">
					<h2>加入 EffectHub.com</h2>
				</div>
        <div id="idtabs1"> 
  <div class="apps-type"> 	
<ul class="tabs">
	<li style="margin:20px 0 0 20px"><a href="#login-ct" style="color:#000">登录</a></li>
	<li style="margin:20px 0 0 20px"><a href="#register-ct" class="selected" style="color:#000">注册</a></li>
</ul>
</div>

	<div id="login-ct">
	<div class="txt-fld" style="padding:0px 20px 35px 20px">
				    <a class="addthis_login_twitter" title="Login with Twitter" href="<?=site_url('login/twitter')?>"><span id="twitter-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_weibo" title="Login with Weibo" href="<?=site_url('login/sina')?>"><span id="weibo-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_google" title="Login with Google" href="<?=site_url('login/google')?>"><span id="google-connect" class="ssi-button"></span></a>
						            
				  </div>
				  <br/>
				<form action="<?=site_url('login/check')?>" method="post">
				  <div class="txt-fld">
				    <label for="">邮箱</label>
				    <input id="" name="email" type="text"/>

				  </div>
				  <div class="txt-fld">
				    <label for="">密码</label>
				    <input id="" name="password" type="password"/>
				  </div>
				  
				  <div class="btn-fld" style="padding-left:20px;padding-right:20px;width:350px;vertical-align:center">
					  <label for="remember_me" style="display:inline;color:#000">记住我
				    <input type="checkbox" checked name="remember_me" id="remember_me"/></label>
					    <input class="save-btn" name="commit" type="submit" value="登录">
					   <!-- <a style="float:right;margin-top:10px;margin-right:10px;" target="_blank" href="<?=site_url('register')?>">Sign Up &raquo;</a>&nbsp;&nbsp;&nbsp;&nbsp;-->
					</div>
					<input type="hidden" name="redirectURL" value="<?=site_url('turing')?>"/>
					
					
					</form>
				</div>


	<div id="register-ct">
	<div class="txt-fld" style="padding:0px 20px 35px 20px">
				    <a class="addthis_login_twitter" title="Sign Up with Twitter" href="<?=site_url('login/twitter')?>"  onclick="_gaq.push(['_trackEvent', 'signup', 'clicked', 'Click twitter signup Button In turing cn Page'])"><span id="twitter-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_facebook" title="Sign Up with Weibo" href="<?=site_url('login/sina')?>"  onclick="_gaq.push(['_trackEvent', 'signup', 'clicked', 'Click weibo signup Button In turing cn Page'])"><span id="weibo-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_google" title="Sign Up with Google" href="<?=site_url('login/google')?>"  onclick="_gaq.push(['_trackEvent', 'signup', 'clicked', 'Click google signup Button In turing cn Page'])"><span id="google-connect" class="ssi-button"></span></a>
						            
				  </div>
				  <br/>
				<form id="signin_form" action="<?=site_url('register/save')?>" method="post">
				  <div class="txt-fld">
				    <label for="">邮箱</label>
				    <input id="email_address" name="email_address" type="text" value=""/>
<span id="emailError" class="formErrorContent drop-shadow">This field must contain a valid email</span>
				  </div>
				  <div class="txt-fld">
				    <label for="">设定密码</label>
				    <input id="password" name="password" type="password" value=""/>
				    <span id="passwordError" class="formErrorContent drop-shadow">This field is required</span>
				  </div>
				  
				  <div class="btn-fld" style="padding-left:20px;padding-right:20px;width:350px;vertical-align:center">
					  <label for="remember_me" style="display:inline;color:#000">有消息时通知我
				    <input type="checkbox" checked name="consent" id="consent"/></label>
					    <input class="save-btn" name="commit" type="button" value="免费注册" onclick="checksignup();_gaq.push(['_trackEvent', 'signup', 'clicked', 'Click Sign Up Button In contest Page'])">
					</div>
						<input type="hidden" name="redirectURL" value="<?=site_url('turing')?>"/>
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