<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Online-Editor</title>
<link rel="stylesheet" media="screen, projection" href="online-editor.css" />
<script src="jquery/jquery-1.10.2.js" ></script>


</head>

<body>
	<div id="header">
       	<div id="header-inner">
			<div id="logo">
				<a href="http://www.awayeffect.com/home" style="margin-top:3px"><img alt="awayeffect" src="http://www.awayeffect.com/img/logo.jpg"></a>
			</div>
				
			<a href="http://www.awayeffect.com/#nav" id="toggle-nav">Toggle navigation</a>

			<ul id="nav">
				<li id="t-search">
					<form id="search" action="http://www.awayeffect.com/item/particleSearch">
						<input class="search-text placeholder" type="text" name="search" placeholder="Search " value="">
					</form>
				</li>
			
           		
			
           		<li id="t-works"><a href="http://www.awayeffect.com/home" class="has-sub">Home</a>
					<ul class="tabs">
						<li class=" active"><a href="http://www.awayeffect.com/home" class="has-dd">Following</a></li>
						<li class=""><a href="http://www.awayeffect.com/item/inspired/1000235">Suggestions</a></li>
						<li class=""><a href="http://www.awayeffect.com/item/mywatch/1000235">Watching</a></li>
						<li class=""><a href="http://www.awayeffect.com/item/mylike/1000235">Favorite</a></li>
						<li class=""><a href="http://www.awayeffect.com/user/1000235">Own</a></li>
					</ul>
				</li>
				
               	<li id="t-explore">
					<a href="http://www.awayeffect.com/item/featured/MostAppreciated" class="has-sub">Explore</a>
					<ul class="tabs">
						<li><a href="http://www.awayeffect.com/item/featured/MostAppreciated">Picks</a></li>
						<li><a href="http://www.awayeffect.com/item/featured/MostDiscussed">Popular</a></li>
						<li><a href="http://www.awayeffect.com/item/featured/MostRecent">Recent</a></li>
						<li><a href="http://www.awayeffect.com/tag">Tags</a></li>
						<li><a href="http://www.awayeffect.com/author">Authors</a></li>
					</ul>
				</li>
					
				<li id="t-groups">
					<a href="http://www.awayeffect.com/group" class="has-sub">Groups</a>
					<ul class="tabs">
						<li class=""><a href="http://www.awayeffect.com/group">All Groups</a></li>
						<li class=""><a href="http://www.awayeffect.com/group/showmygroup/1000235">My Groups</a></li>
						<li class=""><a href="http://www.awayeffect.com/topic/showmytopic/1000235">My Topics</a></li>
					</ul>
				</li>
					
				<li id="t-teams">
					<a href="http://www.awayeffect.com/download" class="has-sub">Downloads</a>
				</li>
			</ul>
		</div>
	</div> <!-- /header -->

	<div id="content">
    	<div id="content-inner">
        	
            <div class="contentTitle">
        		<h5>AS Online Editor</h5>
			</div>
        
        	<div class="boxCodeInner">
            	<div id="showFiles">
                	<p class="fTitle">Files:</p>
                    <div class="Folders">
                    	
                    </div>
                
                </div>
            
  				<div class="code">
                	<p class="fTitle">Code:</p>
                	<div id="code_container">
      					<textarea id="asCode" name="as" cols="2000">
							package {
	import flash.geom.Rectangle;
	import flash.display.Bitmap;
	import flash.display.BitmapData;
	import flash.display.BlendMode;
	import flash.display.Graphics;
	import flash.display.Loader;
	import flash.display.Sprite;
	import flash.display.StageQuality;
	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.filters.ColorMatrixFilter;
	import flash.filters.DisplacementMapFilter;
	import flash.geom.Matrix;
	import flash.geom.Point;
	import flash.media.Sound;
	import flash.media.SoundLoaderContext;
	import flash.media.SoundMixer;
	import flash.net.URLRequest;
	import flash.text.TextField;
	import flash.text.TextFieldAutoSize;
	import flash.text.TextFormat;
	import flash.utils.ByteArray;
     //    import net.hires.debug.Stats;
    [SWF(width="465", height="465", backgroundColor="0x000000", frameRate="30")]
    public class LiquidVideo extends Sprite
    {
        //CLASS CONSTANTS
        private const MAP_WIDTH:Number        = 465;
        private const MAP_HEIGHT:Number       = 465;
        private const MAP_GRID_SIZE:Number    = 20;
        private const MAP_FLOW_SIZE:Number    = 2;
        private const MAP_INTENSITY:Number    = 0.25;
        private const MAP_SCALE:Number        = 150;
        private const MAP_USE_DECAY:Boolean   = true;
        private const MAP_BLUR_INTENSITY:uint = 32;
        private const MAP_BLUR_QUALITY:uint   = 2;
        
        private const ZERO_POINT:Point = new Point(0,0);
        
        //VARIABLES
        private var _container:Sprite;
        
        private var _canvas:BitmapData;
        private var _canvasTone:ColorMatrixFilter;
        
        private var _fluidMap:FluidMap;
        
        private var _m
						</textarea>
					</div>
                    <div class="play_button"><p>Preview</p>
                    </div>
				</div>


				<div class="codeswf">
                	<p class="fTitle">Preview:</p>
                	<div id="swf_container">
                    	<div id="swf">
							
						</div>
  					</div>
				</div>
			</div>
            
		</div>
	</div>


	
    
    
    <div id="footer">
    	<div id="footer-inner">
			<div class="group">
				<div class="footer-links">
					<p class="logo"><a href="http://www.awayeffect.com/home"><img alt="awayeffect" src="http://www.awayeffect.com/img/logo.jpg"></a><br>WE FOCUS ON GAMING</p>

					<p>Awayeffect is a community to connect the world's gaming designers and developers to enable them to be more productive and successful.</p>
				</div>
		
    	    	<div class="footer-links">
					<h3>More</h3>
					<ul>
						<li><a href="http://www.awayeffect.com/about" id="f-home">About</a></li>
						<li><a href="mailto:awayeffect.com@gmail.com">Contact</a></li>
						<li><a href="http://www.awayeffect.com/terms">Terms</a></li>
						<li><a href="http://www.awayeffect.com/privacy">Privacy</a></li>
					</ul>
				</div>

				<div class="footer-links">
					<h3>Social</h3>
					<ul>
						<li><a target="_blank" href="http://twitter.com/awayeffect">Twitter</a></li>
						<li><a target="_blank" href="http://facebook.com/awayeffect">Facebook</a></li>
						<li><a target="_blank" href="http://weibo.com/awayeffect">Weibo</a></li>
						<li><a target="_blank" href="http://t.qq.com/awayeffect">Tencent</a></li>
					</ul>
				</div>
		
        		<div class="footer-links">
					<h3>Connect</h3>
					<ul>
						<li><a href="http://www.awayeffect.com/links">Links</a></li>
                		<li><a href="http://www.awayeffect.com/group">Groups</a></li>
                <!--<li><a href="http://www.awayeffect.com/doc">API</a></li>-->
					</ul>
				</div>

			</div>

			<p>Copyright © 2013 AwayEffect.com. </p>
	
		</div>
	</div> <!-- /footer -->

	<script src="http://www.awayeffect.com/js/jquery.touchSwipe.js" type="text/javascript"></script>
	<script src="http://www.awayeffect.com/js/jquery.tipsy.js" type="text/javascript"></script>
	<script src="http://www.awayeffect.com/js/matchMedia.js" type="text/javascript"></script>
	<script src="http://www.awayeffect.com/js/application.js" type="text/javascript"></script>
	<script src="http://www.awayeffect.com/js/list.js" type="text/javascript"></script>

	<div id="backtop" class="backTop" style="display: block;"><a href="javascript:" id="toTop" class="goTop" title="" onclick="window.scrollTo(0,0);return false" style="display: none;"></a></div>
	<script>

		var ie6 = navigator.appVersion.indexOf('MSIE 6.0') != -1 ? true : false;

		function topFixed(){
			document.documentElement.scrollTop + document.body.scrollTop > 400 ? document.getElementById("toTop").style.display = "block" : document.getElementById("toTop").style.display = "none";
	
			if(ie6) {
				document.getElementById("toTop").style.top = document.documentElement.clientHeight + document.documentElement.scrollTop - document.getElementById("toTop").clientHeight - 45 + "px";
			}
		}

		window.onscroll = function(){ topFixed() }
	</script>
	
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
		ga('create', 'UA-40602328-2', 'awayeffect.com');
		ga('send', 'pageview');

	</script>


</body>
</html>
