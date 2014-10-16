<!DOCTYPE html>
<!--[if lte IE 9]>
<html class="ie" lang="en">
<![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en">
<!--<![endif]-->

<head>
  <meta charset="UTF-8">
	<title>EffectHub.com: your best source for gaming</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	<script type="text/javascript" src="<?=base_url()?>player/flash/swfobject.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<style>html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed,
figure, figcaption, footer, header, hgroup,
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
  margin: 0;
  padding: 0;
  border: 0;
  font-size: 100%;
  font: inherit;
  vertical-align: baseline;
}
/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure,
footer, header, hgroup, menu, nav, section {
  display: block;
}
body {
  line-height: 1;
}
ol, ul {
  list-style: none;
}
blockquote, q {
  quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
  content: '';
  content: none;
}
table {
  border-collapse: collapse;
  border-spacing: 0;
}</style>

  <style>body{
  background:#000;
}</style>

  <script>
    window.confirm = function(){};
    window.prompt  = function(){};
    window.open    = function(){};
    window.print   = function(){};
    // Support hover state for mobile.
    if (false) {
      window.ontouchstart = function(){};
    }
  </script>
    <style type="text/css">
    	<?php echo $item_code['item_css']?>
    </style>
</head>

<body>
<?php if($item['from']=='aseditor'){ ?>
<object type="application/x-shockwave-flash" name="as_preview" data="<?php echo $item['preview_url']?>" width="100%" height="100%" id="as_preview" style="visibility: visible;"><param name="bgcolor" value="#000000"><param name="allowfullscreen" value="true"><param name="wmode" value="direct"><param name="allowscriptaccess" value="always"></object>
<?php  }else if($item['from']=='htmleditor'){?>
	<?php echo $item_code['item_html']?>
    <script type="text/javascript">
    	<?php echo $item_code['item_js']?>
    </script>
    <?php  }else if($item['extension']=='swf'){?>
 <object type="application/x-shockwave-flash" name="as_preview" data="<?php echo $item['download_url']?>" width="100%" height="100%" id="as_preview" style="visibility: visible;"><param name="bgcolor" value="#000000"><param name="allowfullscreen" value="true"><param name="wmode" value="direct"><param name="allowscriptaccess" value="always"></object>   	
    <?php  }else{?>
    <span class="item_image_wrap" width="100%" height="100%" alt="<?php echo $item['title']; ?>">
        <img src="<?php echo $item['type_pic']; ?>" style="width: 256px; height: 256px;">
  </span>	
    <?php  }?>	
</body>
</html>
