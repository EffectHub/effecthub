<?php $this->load->view('header') ?>
<style>
	ol.group-cards li ul.group-stats li:last-child,ol.group-cards li ul.group-stats li {
		list-style: none;
	}
</style>
    <div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="<?=base_url()?>images/icon-x-30-white.png" width="15">
	</a>
</div>



<div id="main" class="site">
	<div class="col-about col-about-full under-hero">

	<h1 class="about"><?= $this->lang->line('donate_title') ?></h1>
	<img alt="icons" class="about-ball" style="border-radius:8px;" src="http://www.effecthub.com/img/default.jpg" width="80">
	<p class="callout"><?= $this->lang->line('donate_desc') ?></p>
	</div>
	<div class="col-about col-about-full under-hero">
	<h1 class="about"><?= $this->lang->line('donate_how') ?></h1>
	<p class="callout">
	PayPal:
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="disound@gmail.com">
<input type="hidden" name="item_name" value="EffectHub">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="amount" value="">
<input type="hidden" name="return" value="http://www.effecthub.com/donate">
<input type="hidden" name="cancel_return" value="http://www.effecthub.com/donate">
<input type="hidden" name="image_url" value="http://www.effecthub.com/img/default.jpg">
<input type="hidden" name="cbt" value="Return to EffectHub to Request Your Rewards">

</form><br/>
</p>
<p class="callout">
Alipay (支付宝):
effecthub.com@gmail.com
	</p>
	</div>
	<div class="col-about col-about-full under-hero">

	<h1 class="about"><?= $this->lang->line('donate_backer') ?></h1>
	<p class="callout">
	<ol class="group-cards">
		<?php foreach($users as $_author): ?>	
		<li class="user-row-2645 group group ">
	<div class="group-info">
		<h2 class="vcard">
			<a href="<?=site_url('user/'.$_author['id'])?>" class="url" rel="contact" title="<?php echo $_author['displayName']; ?>"><div data-picture="" data-alt="<?php echo $_author['displayName']; ?>" data-class="photo">
	
<img alt="<?php echo $_author['displayName']; ?>" class="photo" src="<?php echo $_author['pic_url']; ?>"></div> <?php echo $_author['displayName']; ?></a>

			<span class="meta">
					<a href="<?=site_url('author/countrySearch/'.$_author['countryCode'])?>" class="locality"><?php echo $_author['country_name']; ?></a>
			</span>

		</h2>
<div class="follow-prompt" style="padding:10px">
	￥300
</div>

	</div>


</li>
<?php endforeach; ?>

	</ol>
	</p>
	</div>
</div>

<div class="secondary">

	<h3>Follow <span class="meta">EffectHub</span></h3>

	<ul class="follow">
		<li class="group"><a href="http://twitter.com/effecthub"><img alt="Twitter" src="<?=base_url()?>images/icon-team-twitter.png"> EffectHub on Twitter</a></li>
		<li class="group"><a href="http://facebook.com/effecthub"><img alt="Facebook" src="<?=base_url()?>images/icon-team-facebook.png"> EffectHub on Facebook</a></li>
		<li class="group"><a href="http://weibo.com/effecthub"><img alt="Weibo" src="<?=base_url()?>images/icon-team-weibo.png"> EffectHub on Weibo</a></li>
	</ul>
<!--
	<h3 id="effecthub-newsletter">Subscribe <span class="meta">EffectHub</span> </h3>

<p class="info">Sign up for our newsletter to receive periodic news, updates, featured content, and more.</p>

<form action="" method="post" id="subForm" class="gen-form">
	<fieldset>
		<input type="text" style="background: rgba(255, 255, 255, 1);" placeholder="Enter email" class="placeholder">
		<input type="submit" value="Subscribe" class="form-sub">
	</fieldset>
</form>
-->
</div>


</div>
<?php $this->load->view('footer') ?>