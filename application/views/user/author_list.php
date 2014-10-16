<?php $this->load->view('header') ?>
<div id="content" class="group">


	<?php if (!$this->session->userdata('id')){  ?>
<div class="full full-pitch group">
	<h1 class="compact">
		<strong><?= $this->lang->line('userlist_signup_slogan');?></strong>
		
		<a href="<?=site_url('register')?>" class="form-sub tagline-action"><?= $this->lang->line('header_sign_up');?></a>
		<a rel="tipsy" original-title="Sign up with your Twitter account" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Facebook account" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
	<a rel="tipsy" original-title="Sign up with your Google account" class="auth-google tagline-action" href="<?=site_url('login/google')?>"></a>
		<!--<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>-->
	</h1>
</div>
<?php  }?>
<div class="secondary">
	

<a href="#options" id="options-toggle" class="">
	<img alt="Icon-search-expanded-2x" src="/images/icon-search-expanded-2x.png?1376311488" width="16">
</a>


	<div class="what-is-pro-search">
		<h3><?= $this->lang->line('userlist_search_authors');?></h3>

		<form name="author_search_form" class="gen-form" action="<?=site_url('author/authorSearch')?>" method="post" onkeydown="if(event.keyCode==13){document.author_search_form.submit();}">
                    <div id='main-search' class='clearfix'>
                       <div id='main-search-box' class='clearfix'>
                           <fieldset>
                           <input type="text" style="background: rgba(255, 255, 255, 1);" id='particle_search_field' name="search" onblur="if (this.value == '') {this.value = '<?= $this->lang->line('userstatus_search_authors');?>';}" onfocus="if (this.value == '<?= $this->lang->line('userstatus_search_authors');?>') {this.value = '';}" value="<?= $this->lang->line('userstatus_search_authors');?>" x-webkit-speech="" speech="">
                       		</fieldset>
                       </div>
                    </div>
                  </form>
	</div>
	
	
<h3><?= $this->lang->line('userlist_popular_authors');?> <span class="meta"></span></h3>
	<div class="group-list">
                       <ul>
<?php foreach($user_list as $_user): ?>
 <li>
<a href="<?php echo site_url('user/'.$_user['id'])?>"><img src="<?php echo $_user['pic_url']; ?>" class="group-img"></a>
<p>
<a href="<?php echo site_url('user/'.$_user['id'])?>" class="group-title"><?php echo $_user['displayName']; ?></a>
 <br><span class="group-count"><a href="<?=site_url('user/showfollowers/'.$_user['id'])?>"><?php echo $_user['follower_num']; ?> <?= strtolower($this->lang->line('user_followers'));?></a><br>
 <a href="<?=site_url('author/countrySearch/'.$_user['countryCode'])?>" class="locality"><?php echo $_user['country_name']; ?></a></span>
</p>
<a class="form-sub tagline-action" style="float:right" href="<?=site_url('user/follow/'.$_user['id'])?>"><?= $this->lang->line('user_follow');?></a>
 </li>
                   <?php endforeach; ?>
 </ul></div><br/><br/>
 <h3><?= $this->lang->line('userlist_new_authors');?> <span class="meta"></span></h3>
	<div class="group-list">
                       <ul>
<?php foreach($new_user_list as $_user): ?>
 <li>
<a href="<?php echo site_url('user/'.$_user['id'])?>"><img src="<?php echo $_user['pic_url']; ?>" class="group-img"></a>
<p>
<a href="<?php echo site_url('user/'.$_user['id'])?>" class="group-title"><?php echo $_user['displayName']; ?></a>
 <br><span class="group-count"><a href="<?=site_url('user/showfollowers/'.$_user['id'])?>"><?php echo $_user['follower_num']; ?> <?= strtolower($this->lang->line('user_followers'));?></a><br>
 <a href="<?=site_url('author/countrySearch/'.$_user['countryCode'])?>" class="locality"><?php echo $_user['country_name']; ?></a></span>
</p>
<a class="form-sub tagline-action" style="float:right" href="<?=site_url('user/follow/'.$_user['id'])?>"><?= $this->lang->line('user_follow');?></a>
 </li>
                   <?php endforeach; ?>
 </ul></div><br/><br/>
</div>

<div id="main" class="main-search">
	<div class="results-pane" style="opacity: 1;">
		<ul class="tabs">
			<?php if ($nav=='explore'){  ?>
	<li class="<?php echo $feature=='ThisMonth'?'active':'' ?>">
		<a href="<?=site_url('item/featured/ThisMonth')?>"><?= $this->lang->line('header_explore_picks');?></a>
	</li>
	<li class="<?php echo $feature=='MostAppreciated'?'active':'' ?>">
		<a href="<?=site_url('item/featured/MostAppreciated')?>"><?= $this->lang->line('header_explore_top');?></a>
	</li>
	<li class="<?php echo $feature=='MostDiscussed'?'active':'' ?>">
		<a href="<?=site_url('item/featured/MostDiscussed')?>"><?= $this->lang->line('header_explore_popular');?></a>
	</li>
	<li class="<?php echo $feature=='MostRecent'?'active':'' ?>">
		<a href="<?=site_url('item/featured/MostRecent')?>"><?= $this->lang->line('header_explore_recent');?></a>
	</li>
	<li class="<?php echo $feature=='folder'?'active':'' ?>">
		<a href="<?=site_url('folder/explore/top')?>"><?= $this->lang->line('header_explore_folders'); ?></a>
		<!--	<img style="top:-8px;right:0px;position:absolute;" src="<?=base_url()?>images/new_menu.gif"> -->
	</li>
	<li class="<?php echo $feature=='collection'?'active':'' ?>">
		<a href="<?=site_url('collection/explore/top')?>"><?= $this->lang->line('header_explore_collections'); ?></a>
	</li>
	
	<!--
	<li class="<?php echo $feature=='tag'?'active':'' ?>">
		<a href="<?=site_url('tag')?>">Tags</a>
	</li>-->
	<li class="<?php echo $feature=='author'?'active':'' ?>">
		<a href="<?=site_url('author')?>"><?= $this->lang->line('header_explore_authors');?></a>
	</li>
	<?php  }?>
</ul>
<?php if (!empty($input_str)) {?>
<h2 style="margin-bottom:20px;">"<?php echo $input_str;?>" <?= $this->lang->line('userlist_searching_title');?></h2>
<?php } ?>
<ol class="group-cards">
	<?php foreach($author_list as $_author): ?>	
		<li class="user-row-2645 group group ">
	<div class="group-info">
		<h2 class="vcard">
			<a href="<?=site_url('user/'.$_author['id'])?>" class="url" rel="contact" title="<?php echo $_author['displayName']; ?>"><div data-picture="" data-alt="<?php echo $_author['displayName']; ?>" data-class="photo">
	
<img alt="<?php echo $_author['displayName']; ?>" class="photo" src="<?php echo $_author['pic_url']; ?>">

</div> <?php echo $_author['displayName']; ?></a>

			<span class="meta">
					<a href="<?=site_url('author/countrySearch/'.$_author['countryCode'])?>" class="locality"><?php echo $_author['country_name']; ?></a>
			</span>

		</h2>
<div class="follow-prompt">
	<a href="<?=site_url('user/follow/'.$_author['id'])?>" class="follow">
		<span>Follow</span>
</a>
</div>
		<ul class="group-stats group">
	<li class="stat-works">
		<a href="<?=site_url('user/showfollowing/'.$_author['id'])?>"><?php echo $_author['follow_num']; ?>
			<span class="meta"><?= strtolower($this->lang->line('user_followings'));?></span>
</a>	</li>

	<li class="stat-followers">
		<a href="<?=site_url('user/showfollowers/'.$_author['id'])?>"><?php echo $_author['follower_num']; ?>
			<span class="meta"><?= strtolower($this->lang->line('user_followers'));?></span>
</a>	</li>
</ul>

	</div>

	<div class="works">
	<?php foreach($item_list_everyauthor[$_author['id']] as $_item): ?>
	<a href="<?=site_url('item/'.$_item['id'])?>" title="<?php echo $_item['title']; ?>">
	  <?php if($_item['thumb_url']!=null||$_item['pic_url']!=null){ ?>
  <img alt="<?php echo $_item['title']; ?>" src="<?php echo $_item['thumb_url']; ?>">
  <?php  }else{?>
  	<iframe src="<?=site_url('item/preview_html/'.$_item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 20.648648648649%;height:80px;padding:6px;margin:0px;background:#212121"></iframe>
  <?php  }?>
</a>
	<?php endforeach; ?></div>

</li>
<?php endforeach; ?>


</ol>



<div class="page">
<?php echo $this->pagination->create_links();?>
</div>


	</div>

	<div class="processing processing-results hide" style="display: none;">Finding designers…</div>
</div>

</div>



<?php $this->load->view('footer') ?>
