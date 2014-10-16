<!DOCTYPE html>
<html class=''>
<head><meta charset='UTF-8'><meta name="robots" content="noindex">
<style>
	<?php echo isset($item_code['item_css'])?$item_code['item_css']:''?>
</style>
</head>

<body>
<?php if($item['from']=='aseditor'){ ?>
	<script type="text/javascript" src="<?=base_url()?>player/flash/swfobject.js"></script>
<object type="application/x-shockwave-flash" name="as_preview" data="<?php echo $item['preview_url']?>" width="100%" height="100%" id="as_preview" style="visibility: visible;"><param name="bgcolor" value="#000000"><param name="allowfullscreen" value="true"><param name="wmode" value="direct"><param name="allowscriptaccess" value="always"></object>
<?php  }else if($item['from']=='htmleditor'){?>
	<link rel='stylesheet' href='<?php echo base_url()?>css/reset.css'><script src='<?php echo base_url()?>js/prefixfree.min.js'></script>
<script src="<?php echo base_url()?>js/jquery-1.8.3.min.js"></script>
	<?php echo $item_code['item_html']?>
	<script>
    	<?php echo $item_code['item_js']?>
    </script>
    <?php  }else if($item['extension']=='swf'){?>
 <object type="application/x-shockwave-flash" name="as_preview" data="<?php echo $item['download_url']?>" width="100%" height="100%" id="as_preview" style="visibility: visible;"><param name="bgcolor" value="#000000"><param name="allowfullscreen" value="true"><param name="wmode" value="direct"><param name="allowscriptaccess" value="always"></object>   
 <?php  }else if($item['extension']=='plist'&&$item['type']==1){?>
  <canvas id="gameCanvas" width="100%" height="100%" ></canvas>
<script type="text/javascript">
var currentFile = '<?php echo $item['download_url']; ?>';
var currentTexture = '';
</script>
<script src="<?php echo base_url()?>js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>player/cocos2d/effect/Cocos2d.js"></script>

 <?php  }else{?>
    <span class="item_image_wrap" width="600" height="600" alt="<?php echo $item['title']; ?>">
        <img src="<?php echo $item['type_pic']; ?>" style="width: 256px; height: 256px;">
  </span>	
    <?php  }?>	
<script>
</script>
</body>
</html>
