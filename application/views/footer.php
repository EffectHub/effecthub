</div></div>
<hr>
<?php 
	if (!$this->session->userdata('language')){
	
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
	
		if (preg_match("/zh-c/i", $lang)||$lang=='cn')
		{
			$this->session->set_userdata('language',2);
		}else{
			$this->session->set_userdata('language',1);
		}
	}

?>
<div id="footer"><div id="footer-inner">

	<div class="group">
		<div class="footer-links">
			<p class="logo"><a href="<?=site_url('home')?>"><img alt="effecthub" src="http://www.effecthub.com/img/logo.jpg"></a><br><?= $this->lang->line('footer_slogan');?></p>
			<p><?= $this->lang->line('footer_language') ?></p> 
			<select class="footer-language">
				<option value="1" <?php if ($this->session->userdata('language')&&$this->session->userdata('language')==1) echo "selected='selected'" ?>>English</option>
				<option value="2" <?php if ($this->session->userdata('language')&&$this->session->userdata('language')==2) echo "selected='selected'" ?>>简体中文</option>
			</select>
		</div>
		<div class="footer-links">
			<h3><?= $this->lang->line('footer_more');?></h3>
			<ul>
				<li><a href="<?=site_url('about')?>" id="f-home"><?= $this->lang->line('footer_about');?></a></li>
				<li><a href="mailto:effecthub.com@gmail.com"><?= $this->lang->line('footer_contact');?></a></li>
				<li><a href="<?=site_url('terms')?>"><?= $this->lang->line('footer_terms');?></a></li>
				<li><a href="<?=site_url('privacy')?>"><?= $this->lang->line('footer_privacy');?></a></li>
                <li><a href="<?=site_url('api')?>">API</a></li>
			</ul>
		</div>

		<div class="footer-links">
			<h3><?= $this->lang->line('footer_social');?></h3>
			<ul>
				<li><a target="_blank" href="http://twitter.com/effecthub"><?= $this->lang->line('footer_twitter');?></a></li>
				<li><a target="_blank" href="http://facebook.com/effecthub"><?= $this->lang->line('footer_facebook');?></a></li>
				<li><a target="_blank" href="http://weibo.com/effecthub"><?= $this->lang->line('footer_weibo');?></a></li>
			</ul>
		</div>
		<div class="footer-links">
			<h3><?= $this->lang->line('footer_connect');?></h3>
			<ul>
				<li><a href="<?=site_url('links')?>"><?= $this->lang->line('footer_links');?></a></li>
                <!--<li><a href="<?=site_url('download')?>"><?= $this->lang->line('footer_downloads');?></a></li>-->
                <li><a href="<?=site_url('topic/2')?>"><?= $this->lang->line('footer_feedback');?></a></li>
                <li><a href="<?=site_url('donate')?>"><?= $this->lang->line('footer_donate');?></a></li>
                <li><a href="<?=site_url('rss')?>">RSS</a></li>
			</ul>
		</div>

	</div>

	<p><?= $this->lang->line('footer_copyright');?></p>
	
</div></div> <!-- /footer -->

<script src="<?=base_url()?>js/jquery.touchSwipe.js" type="text/javascript"></script>
<script src="<?=base_url()?>js/jquery.tipsy.js" type="text/javascript"></script>
<script src="<?=base_url()?>js/matchMedia.js" type="text/javascript"></script>
<script src="<?=base_url()?>js/application.js" type="text/javascript"></script>
<script src="<?=base_url()?>js/list.js" type="text/javascript"></script>
<!--
<link href="<?=base_url()?>css/jquery.feedback_me.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="<?=base_url()?>js/jquery.feedback_me.js" type="text/javascript"></script>
-->

<div id="backtop" class="backTop" style="display: block;"><a href="javascript:" id="toTop" class="goTop" title="" onclick="window.scrollTo(0,0);return false" style="display: none;"></a></div>
	<script>
	
	/*
$(document).ready(function(){
    //set up some basic options for the feedback_me plugin
    fm_options = {
        position: "right-bottom",
        name_required: true,
        show_email: false,
        email_required: false,
        name_label: "<?= $this->lang->line('footer_feedback_name');?>",
    	message_label: "<?= $this->lang->line('footer_feedback_message');?>",
        submit_label: "<?= $this->lang->line('footer_feedback_send');?>",
    	title_label: "",
    	trigger_label: "<?= $this->lang->line('footer_feedback_trigger');?>",
        message_placeholder: "<?= $this->lang->line('footer_feedback_placeholder');?>",
        message_required: true,
        show_asterisk_for_required: true,
        feedback_url: "<?=site_url('feedback/send')?>",
        custom_params: {
            csrf: "my_secret_token",
            user_id: "john_doe",
            feedback_type: "clean"
        },
        delayed_options: {
        	sending : "<?= $this->lang->line('footer_feedback_sending');?>",
            send_fail : "<?= $this->lang->line('footer_feedback_failed');?>",
            send_success : "<?= $this->lang->line('footer_feedback_success');?>"
        }
    };
    //init feedback_me plugin
    fm.init(fm_options);
});
*/
var ie6 = navigator.appVersion.indexOf('MSIE 6.0') != -1 ? true : false;

function topFixed(){
	document.documentElement.scrollTop + document.body.scrollTop > 400 ? document.getElementById("toTop").style.display = "block" : document.getElementById("toTop").style.display = "none";
	
	if(ie6) {
		document.getElementById("toTop").style.top = document.documentElement.clientHeight + document.documentElement.scrollTop - document.getElementById("toTop").clientHeight - 45 + "px";
	}
}

window.onscroll = function(){ topFixed() }
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

<script>
$('.footer-language').change(function(){

	$.post(
		"<?= site_url('language/select') ?>",
		{ language: $('.footer-language').val() },
		function(data,status){
			document.location.reload();
		});
});
</script>

</body></html>
