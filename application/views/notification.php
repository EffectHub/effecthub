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
	
</head>

<body>
	<p>总共 <?= $count ?> 条记录，已执行了 <?= $start+1; ?> 至  <?= $end>$count?$count:$end; ?> 条记录，
	<?php if ($end >=$count) {?> 已全部执行完毕，<a href="<?= site_url('home') ?>">返回网站</a>
	<?php } else {?>
	<a href="<?= site_url('notification/index/'.$end.'/'.($end+500)) ?>">继续执行下500条记录</a>
	<a href="<?= site_url('home') ?>">返回网站</a>
	<?php }?>


</body>