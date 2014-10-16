<?php $this->load->view('header') ?>
<div id="content" class="group">


	<?php if (!$this->session->userdata('id')){  ?>
<div class="full full-pitch group">
	<h1 class="compact">
		<strong><?= $this->lang->line('collectionexplore_unlogin'); ?></strong>
		
		<a href="<?=site_url('register')?>" class="form-sub tagline-action"><?= $this->lang->line('collectionexplore_sign_up'); ?></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('collectionexplore_sign_up_twitter'); ?>" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('collectionexplore_sign_up_facebook'); ?>" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
	<a rel="tipsy" original-title="<?= $this->lang->line('collectionexplore_sign_up_google'); ?>" class="auth-google tagline-action" href="<?=site_url('login/google')?>"></a>
		<!--<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>-->
	</h1>
</div>
<?php  }?>

<div id="main" class="main-search">
	<div class="results-pane" style="opacity: 1;">
		<ul class="tabs">
			<?php if ($nav=='explore'){  ?>
	<li class="<?php echo $feature=='ThisMonth'?'active':'' ?>">
		<a href="<?=site_url('item/featured/ThisMonth')?>"><?= $this->lang->line('header_explore_picks'); ?></a>
	</li>
	<li class="<?php echo $feature=='MostAppreciated'?'active':'' ?>">
		<a href="<?=site_url('item/featured/MostAppreciated')?>"><?= $this->lang->line('header_explore_top'); ?></a>
	</li>
	<li class="<?php echo $feature=='MostDiscussed'?'active':'' ?>">
		<a href="<?=site_url('item/featured/MostDiscussed')?>"><?= $this->lang->line('header_explore_popular'); ?></a>
	</li>
	<li class="<?php echo $feature=='MostRecent'?'active':'' ?>">
		<a href="<?=site_url('item/featured/MostRecent')?>"><?= $this->lang->line('header_explore_recent'); ?></a>
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
		<a href="<?=site_url('author')?>"><?= $this->lang->line('header_explore_authors'); ?></a>
	</li>
	<?php if ($this->session->userdata('id')){ ?>
		<?php if($feature=='collection'){?>

		<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('collection/create')?>" onclick="_gaq.push(['_trackEvent', 'collection', 'create collection', 'Click create collection in collection list page'])"><?= $this->lang->line('collectioncreate_create_collection'); ?></a>

		<?php } ?>
	<?php  }?>
	<?php  }?>
</ul>

	<ol class="effecthubs group">
		<?php foreach($collection_list as $_collect): ?>
		
		<li id="screenshot-1085677" style="margin:0 10px 10px 0;">
			<div class="effecthub c-explore">
				
				
				<div style="padding:10px;height:100px;width:100px">
				<a href="<?=site_url('collection/show/'.$_collect['id'])?>">
					<img style="width:100px;height:80px;" alt="<?= $_collect['title']; ?>" src="<?= $_collect['pic_url']; ?>">
				</a>
				</div>
					
				<div class="collect">
					<a href="<?=site_url('collection/show/'.$_collect['id'])?>" class="c-title"><strong><?=msubstr($_collect['title'],0,50);?></strong></a>
					<br>
					<a href="<?=site_url('user/'.$_collect['author_id'])?>" class="c-name"><?= msubstr($_collect['author_name'],0,50); ?></a>
				</div>
				<ul class="c-data">
					<li class="like"><?= $_collect['like_num']; ?></li>
					<li class="cmt"><?= $_collect['comment_num']; ?></li>
					<li class="views"><?= $_collect['view_num']; ?></li>
				</ul>
				
				<div class="collect-pick">
					<?php foreach($collection_works[$_collect['id']] as $_item): ?>
					<a href="<?=site_url('item/'.$_item['id'])?>" title="<?php echo $_item['title']; ?>">
	  					<?php if($_item['thumb_url']!=null||$_item['pic_url']!=null){ ?>
  						<img alt="<?php echo $_item['title']; ?>" src="<?php echo $_item['thumb_url']; ?>">
  						<?php  }else{?>
  						<iframe src="<?=site_url('item/preview_html/'.$_item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width:80px;height:60px;margin:0px;"></iframe>
  						<?php  }?>
					</a>
					<?php endforeach; ?>
				</div>
				
				<div class="c-works"><?=$_collect['works_num']?> <?= $this->lang->line('collectionexplore_collect'); ?></div>
				
				
			</div>
		</li>
		
		<?php endforeach; ?>

	</ol>



<div class="page">
<?php echo $this->pagination->create_links();?>
</div>


	</div>

	<div class="processing processing-results hide" style="display: none;"><?= $this->lang->line('collectionexplore_finding_collections'); ?></div>
</div>


<div class="secondary">
	
	<h3><?= $this->lang->line('collectionexplore_active_collections'); ?><span class="meta"></span></h3>
	<div class="group-list">
		<ul>
		<?php foreach($new_collection as $_list): ?>
 			<li>
				<a href="<?php echo site_url('collection/show/'.$_list['id'])?>"><img src="<?php echo $_list['pic_url']; ?>" class="group-img"></a>
				<p>
					<a href="<?php echo site_url('collection/show/'.$_list['id'])?>" class="group-title"><?php echo msubstr($_list['title'],0,50); ?></a>
 					<br><span class="group-count"><?php echo $_list['works_num']; ?> <?= $this->lang->line('collectionexplore_collect'); ?><br>
 					<a href="<?=site_url('user/'.$_list['author_id'])?>"><?php echo $_list['author_name']; ?></a></span>
				</p>
 			</li>
                   <?php endforeach; ?>
 		</ul>
	</div>

</div>



</div>



<?php $this->load->view('footer') ?>
