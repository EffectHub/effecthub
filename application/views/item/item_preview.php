<?php if((isset($item['from'])&&$item['from']!=null&&$item['from']=='htmleditor')){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php } ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" >
	<meta name="keywords" content="Effecthub, AwayEffect, Sparticle, Dragonbones, Away3D, Gaming artist, Game designer, Gaming social comunity, Game developer, HTML5, 3D, Flash, Unity, Unity3D, WebGL, iOS, iPhone, iPad, iPod, interactive 3D, high-end, interactive, design, director" /> 
	<meta name="description" content="EffectHub is a social network to connect the world's gaming artists and developers to enable them to be more productive and successful.">
	<title><?php echo isset($title)?$title:'EffectHub.com: your best source for gaming'?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	<!--[if gte IE 7]><!-->
</head>

<body id="<?php echo isset($nav)?$nav:'works' ?>">
<style type="text/css">
    	body{
    		padding:0px;
    		margin:0px;
    	}
    	#preview-footer #logo {
float:left;
width: 140px;
height: 26px;
margin-top:8px;
background: url(http://www.effecthub.com/img/logo.jpg) no-repeat 0 0;
-webkit-transition: opacity 0.2s ease;
-moz-transition: opacity 0.2s ease;
-o-transition: opacity 0.2s ease;
transition: opacity 0.2s ease;
}
    	#preview-footer {
position: fixed;
bottom: -50px;
left: 0;
width: 100%;
padding: 0 10px;
height: 30px;
color: #eeeeee;
text-align:right;
background-color: #000;
border-top: 1px solid black;
border-bottom: 1px solid black;
box-shadow: inset 0 1px 0 #6e6e6e,0 2px 2px rgba(0,0,0,0.4);
font: 12px/30px "Lucida Grande","Lucida Sans Unicode",Tahoma,sans-serif;
}
#preview-footer a{
color: #eeeeee;
font: 12px/30px "Lucida Grande","Lucida Sans Unicode",Tahoma,sans-serif;
}
    </style>

               <div id='left' class='clearfix' style="width: 100%; height: 100%;padding:0px;margin:0px">
                   
                 <div style="width: 100%; height: 100%;padding:0px;margin:0px;overflow-y: auto;">
                 <?php if($item['is_share']==1&&$item['preview_url']!='0'&&$item['preview_url']!=''&&$item['preview_url']!=null){ ?>
                 <?php if(!strpos($item['preview_url'],'unity3d')){ ?>
                 <iframe width="100%" height="100%" style="width: 100%; height: 100%;padding:0px;margin:0px;" src="<?php echo $item['preview_url']?>" scrolling="no"   frameborder="NO" border="0" framespacing="0"></iframe>
				 <?php }else{ ?>
				 <embed src="<?php echo $item['preview_url']?>" type="application/vnd.unity" width="100%" height="100%" firstframecallback="UnityObject2.instances[0].firstFrameCallback();" style="display: block; width: 100%; height: 100%;">
				 <?php } ?>
				 <?php }else if($item['extension']=='swf'){ ?>
		        	<object type="application/x-shockwave-flash" name="as_preview" data="<?php echo $item['download_url']?>" width="100%" height="100%" id="as_preview" style="visibility: visible;"><param name="allowfullscreen" value="true"><param name="wmode" value="direct"><param name="allowscriptaccess" value="always"></object> 
		         <?php }else if(isset($item['from'])&&$item['from']!=null&&($item['from']=='dragonbones'||stristr($item['tags'],'dragonbones'))){ ?>
                 <object type="application/x-shockwave-flash" name="design_panel_demo" data="<?=base_url()?>player/dragonbones/SkeletonAnimationDesignPanel.swf" width="100%" height="100%" id="design_panel_demo" style="visibility: visible;"><param name="allowfullscreen" value="true"><param name="wmode" value="direct"><param name="allowscriptaccess" value="always"><param name="flashvars" value="__objectID=design_panel_demo&amp;data=<?php echo $item['download_url']?>"></object>
        		 <?php }else if(isset($item['from'])&&$item['from']!=null&&$item['from']=='htmleditor'){ ?>
        		 	<iframe width="100%" height="100%" style="width: 100%; height: 100%;min-height:600px;" src="<?=site_url('item/preview_html/'.$item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" onload=' this.style.height=Math.max(this.contentWindow.document.body.scrollHeight,this.contentWindow.document.documentElement.scrollHeight,200)+"px";  '></iframe>
        		 <?php }else if(isset($item['extension'])&&$item['extension']!=null&&$item['extension']=='plist'&&$item['type']==1){ ?>
        		 	<iframe width="100%" height="100%" style="width: 100%; height: 100%;min-height:600px;" src="<?=site_url('item/preview_html/'.$item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" onload=' this.style.height=Math.max(this.contentWindow.document.body.scrollHeight,this.contentWindow.document.documentElement.scrollHeight,200)+"px";  '></iframe>
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
		            params.allowFullScreenInteractive = "true";
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
            swfobject.createCSS("#flashContent", "width:100%;height:100%;display:block;text-align:left;");
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
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%" id="SEA3DPlayer">
                <param name="movie" value="<?=base_url()?>player/sea3d/SEA3DPlayer.swf" />
                <param name="quality" value="high" />
                <param name="bgcolor" value="#333333" />
                <param name="allowScriptAccess" value="sameDomain" />
                <param name="allowFullScreen" value="true" />
                <param name="wmode" value="direct" />
                <!--[if !IE]>-->
                <object type="application/x-shockwave-flash" data="<?=base_url()?>player/sea3d/SEA3DPlayer.swf" width="100%" height="100%">
                    <param name="quality" value="high" />
                    <param name="bgcolor" value="#333333" />
                    <param name="allowScriptAccess" value="sameDomain" />
                    <param name="allowFullScreen" value="true" />
                    <param name="allowFullScreenInteractive" value="true" />
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
        <?php }else if(isset($item['type_name'])&&$item['type_name']!=null&&$item['type_name']=='Audio'){ ?>
        	<audio controls="" autoplay="" name="media" style="width:100%;height:50%">
        	<source src="<?php echo $item['download_url']?>" type="audio/mpeg">
        	</audio>
        <?php }else if(isset($item['type_name'])&&$item['type_name']!=null&&$item['type_name']=='Video'){ ?>
        	<video controls="" autoplay="" name="media" style="width:100%;height:100%">
        	<source src="<?php echo $item['download_url']?>" type="audio/mpeg">
        	</video>
        		 <?php }else if(isset($item['type_name'])&&$item['type_name']!=null&&$item['type_name']=='Model'&&$item['extension']=='zip'){ ?>
        		 <script type="text/javascript" src="<?=base_url()?>player/particle/swfobject.js"></script>
		        <script type="text/javascript">
		            // For version detection, set to min. required Flash Player version, or 0 (or 0.0.0), for no version detection. 
		            var swfVersionStr = "11.2.0";
		            // To use express install, set to playerProductInstall.swf, otherwise the empty string. 
		            var xiSwfUrlStr = "<?=base_url()?>player/flash/playerProductInstall.swf";
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
		                "<?=base_url()?>player/model/modelplayer.swf", "flashContent", 
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
		                <param name="movie" value="<?=base_url()?>player/model/modelplayer.swf" />
		                <param name="quality" value="high" />
		                <param name="bgcolor" value="#333333" />
		                <param name="allowScriptAccess" value="sameDomain" />
		                <param name="allowFullScreenInteractive" value="true" />
		                <param name="allowFullScreen" value="true" />
		                <!--[if !IE]>-->
		                <object type="application/x-shockwave-flash" data="<?=base_url()?>player/model/modelplayer.swf" width="100%" height="100%">
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
		        <?php }else if(isset($item['from'])&&$item['from']!=null&&$item['from']=='particle'){ ?>
        		 <script type="text/javascript" src="<?=base_url()?>player/particle/swfobject.js"></script>
		        <script type="text/javascript">
		            // For version detection, set to min. required Flash Player version, or 0 (or 0.0.0), for no version detection. 
		            var swfVersionStr = "11.2.0";
		            // To use express install, set to playerProductInstall.swf, otherwise the empty string. 
		            var xiSwfUrlStr = "<?=base_url()?>player/flash/playerProductInstall.swf";
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
		                "<?=base_url()?>player/particle/PreLoader.swf?3", "flashContent", 
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
		                <param name="movie" value="<?=base_url()?>player/particle/PreLoader.swf?3" />
		                <param name="quality" value="high" />
		                <param name="bgcolor" value="#333333" />
		                <param name="allowScriptAccess" value="sameDomain" />
		                <param name="allowFullScreenInteractive" value="true" />
		                <param name="allowFullScreen" value="true" />
		                <!--[if !IE]>-->
		                <object type="application/x-shockwave-flash" data="<?=base_url()?>player/particle/PreLoader.swf?3" width="100%" height="100%">
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
		        <?php }else if(isset($item['from'])&&$item['from']!=null&&$item['from']=='aseditor'){ ?>
<object type="application/x-shockwave-flash" name="as_preview" data="<?php echo $item['preview_url']?>?<?php echo rand()?>" width="100%" height="100%" id="as_preview" style="visibility: visible;"><param name="bgcolor" value="#000000"><param name="allowfullscreen" value="true"><param name="wmode" value="direct"><param name="allowscriptaccess" value="always"></object>
		        <?php }else if(isset($item['extension'])&&$item['extension']!='zip'&&$item['extension']=='aaa'){ ?>
		        	<iframe src="https://render.github.com/view/3d/?url=<?php echo $item['download_url']?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 100%; height: 100%;padding:0px;margin:0px;"></iframe>
		        <?php }else if($item['preview_url']=='0'||$item['preview_url']==null){ ?>
		        	<img width="100%" alt="<?php echo $item['title']?>" src="<?php echo $item['pic_url']?>">
        		 <?php }else{ ?>
                 <iframe src="<?php echo $item['preview_url']?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 100%; height: 100%;padding:0px;margin:0px;"></iframe>
				 <?php } ?>
        </div></div>
           </div>
           <script type="text/javascript">
function onMouseScroll(e){
 //alert(document.activeElement==document.getElementById("flashContent"));
 if(document.activeElement==document.getElementById("flashContent")){
	e = e||window.event;
	
	if (e.preventDefault) e.preventDefault();
	else e.returnValue = false;
 }
}
function changeFocus(){ 
 if(window.addEventListener){ 
  window.addEventListener("DOMMouseScroll",onMouseScroll,true);
  window.onscroll=function(){document.getElementById("flashContent").blur(); };
 }else{
  document.onmousewheel=onMouseScroll;
 }  
}
</script>
<?php if(isset($is_embed)&&$is_embed==1){ ?>

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
<div id="preview-footer" style="bottom: 0px;">

  <a title="View on EffectHub" href="<?=site_url('item/'.$item['id'])?>" target="_blank" id="logo">
  </a>
<?php if($item['from']=='aseditor'||$item['from']=='htmleditor'){ ?>
  <a id="edit_link" href="<?=site_url('item/fork/'.$item['id'])?>" target="_blank" onclick="_gaq.push(['_trackEvent', 'viewcode', 'clicked', 'Click View Code On EffectHub'])">View Code On EffectHub</a>
  &nbsp;&nbsp;&nbsp;&nbsp;
<?php }else{ ?>
 <a id="edit_link" style="margin-right:15px;" href="<?=site_url('item/'.$item['id'])?>" target="_blank" onclick="_gaq.push(['_trackEvent', 'viewcode', 'clicked', 'Click View On EffectHub'])">View On EffectHub</a>
<?php } ?>
</div>
<?php } ?>
</body></html>