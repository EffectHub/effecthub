<?php $this->load->view('header') ?>
    
    <div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="<?=base_url()?>images/icon-x-30-white.png" width="15">
	</a>
</div>

	<?php if (!$this->session->userdata('id')){  ?>
<div class="full full-pitch group">
	<h1 class="compact">
		<strong style="font-size:20px">GET INSPIRED</strong>
		<strong style="font-size:14px">Working With Global Top Game Artists at EffectHub.com!</strong>
		<a href="<?=site_url('register')?>" class="form-sub tagline-action">Sign up</a>
		<a rel="tipsy" original-title="Sign up with your Twitter account" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Facebook account" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
		<!--<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>-->
	</h1>
</div>
<?php  }?>

<div id="main" class="site">
	<div class="col-about col-about-full under-hero">
	<h1 class="about">Download Sparticle And Parser For Free!</h1>
	<p class="callout">

    <h2 id="pocket-portfolio"><a href="http://get.adobe.com/air/" style="color:#000;font-weight:bold;text-decoration:underline" target="_blank">Adobe AIR Runtime Needed</a></h2>
      <br />
    <p>Sparticle: A powerful GUI editor for authoring incredible effect easily!</p>
    <a id="free-download" class="form-sub" target="_blank" href="<?=site_url('download/software/sparticle')?>">Download Editor</a>
    <a id="free-download" class="form-sub" target="_blank" href="<?=site_url('item/new_content/particle')?>">Open Online Editor</a>
    <br /><br />
    <p>Sparticle Parser: The source code library for parsing and loading effects into your projects!</p>
    <a id="free-download" class="form-sub" target="_blank" href="<?=site_url('download/software/sparticleparser')?>">Download Parser</a><br /><br />
    <p>Template/Samples: Some sample effects for a quick start about the tool and A simple Flash Builder project guiding you how to use the parser to load assets.</p>
    <a id="free-download" class="form-sub" target="_blank" href="<?=site_url('download/software/templateproject')?>">Download Template/Samples</a>
    <br /><br />
    <p>Sparticle Tutorial</p>
    <a id="free-download" class="form-sub" target="_blank" href="http://www.effecthub.com/download/software/c6c6d17f0eacaa2ade1de9a29d6c946d">Sparticle Tutorial</a>
        <br /><br />
          <p></p>
    <a id="free-download" class="form-sub" target="_blank" href="http://www.effecthub.com/download/software/32dddc0edf1361f7f69f05cae4d70127">Sparticle Tutorial (Chinese)</a>
        <br /><br />
    
     </div>
	<!--
	<div class="col-about col-about-full under-hero">
	<h1 class="about">Download DragonBones</h1>
	<p class="callout">
    <p>DragonBones: The Open Source 2D skeleton animation solution for Flash!</p>
    <a id="free-download" class="form-sub" target="_blank" href="<?=site_url('download/software/dragonbones')?>">Download</a>
    <a id="free-download" class="form-sub" target="_blank" href="http://dragonbones.github.io/help.html">Help</a>
    <br /><br />
    <p>Template/Samples: Demo projects show how to use DragonBones.</p>
    <a id="free-download" class="form-sub" target="_blank" href="<?=site_url('download/software/dragonbonessamples')?>">Download Template/Samples</a>
    <br /><br /> 
    
</div>
-->
</div>

<div class="secondary">

	<h3 id="effecthub-newsletter">Install <span class="meta">Sparticle</span> </h3>

<p class="info">
<iframe src="http://www.effecthub.com/update/badage/index.html" frameborder="0" scrolling="no" width="215" height="180"></iframe>
</p>

<h3 id="effecthub-newsletter">Share <span class="meta">Sparticle</span> </h3>

<p class="info">
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
<!-- AddThis Button END --><br />
<!-- Baidu Button BEGIN -->
<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
<a class="bds_qzone"></a>
<a class="bds_tsina"></a>
<a class="bds_tqq"></a>
<a class="bds_renren"></a>
<a class="bds_t163"></a>
<span class="bds_more"></span>
<a class="shareCount"></a>
</div>
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=2188230" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script>
<!-- Baidu Button END -->
</p>

</div>


</div>

<?php $this->load->view('footer') ?>
