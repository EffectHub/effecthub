<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js" ><!--<![endif]-->
<head>
    <title><?php echo $tool['name']; ?> Demos</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $tool['desc']; ?>">
    <meta http-equiv="cleartype" content="on">
    <link href="<?=base_url()?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>css/bootstrap-responsive.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
</head>
<body data-spy="scroll" data-target=".navbar">
    <div id="content">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="well">
                    <ul class="thumbnails">
                    <?php foreach($item_list as $_item): ?>
                    <li class="span6">
                        <div class="thumbnail">
                            <div class="caption">
                                <h3><?php echo $_item['title']; ?></h3>
                                <p><?php echo $_item['desc']; ?></p>
                                 <a target="_blank" href="<?=site_url('item/'.$_item['id'])?>"><img style="width:400px;height:300px" src="<?php echo $_item['pic_url']; ?>" alt=""></a>
                            </div>
                        </div>
                      </li>
                    <?php endforeach; ?>
                    </ul>
                    
                    
<div class="page" style="width:100%;text-align:center;">
	<?php echo $this->pagination->create_links();?>
</div>
                </div>
             </div>
        </div>
    </div>
    
</body>

<script src="<?=base_url()?>js/jquery-1.8.3.min.js"></script>
<script src="<?=base_url()?>js/bootstrap.min.js"></script>
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
</html>
