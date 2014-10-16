<?php $this->load->view('header') ?>
<div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="http://effecthub.com/#" class="close">
		<img alt="Icon-x-30-white" src="<?=base_url()?>images/icon-x-30-white.png" width="15">
	</a>
</div>
<div id="main" class="main">
	<?php if (!$this->session->userdata('id')){  ?>
<div class="full full-pitch group">
	<h1 class="compact">
		<strong>EffectHub is connecting the world's gaming designers and developers.</strong>
		
		<a href="<?=site_url('register')?>" class="form-sub tagline-action">Sign up</a>
		<a rel="tipsy" original-title="Sign up with your Twitter account" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Facebook account" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>
	</h1>
</div>
<?php  }?>
<ul class="tabs">
<?php if ($this->session->userdata('id')){  ?>
			<?php if ($nav=='works'){  ?>
				<li class="<?php echo $feature=='assets'?'active':'' ?>">
		<a href="<?=site_url('disk')?>" class="has-dd"><?= $this->lang->line('header_home_files'); ?></a>
	</li>
	
	<li class="<?php echo $feature=='projects'?'active':'' ?>">
		<a href="<?=site_url('project')?>" class="has-dd"><?= $this->lang->line('header_home_projects'); ?></a>
	</li>
	<li class="<?php echo $feature=='following'?'active':'' ?>">
		<a href="<?=site_url('home/newsfeed')?>" class="has-dd"><?= $this->lang->line('header_home_following'); ?></a>

	</li>

		<li class="<?php echo $feature=='Suggestions'?'active':'' ?>">
			<a href="<?=site_url('home/suggestion')?>"><?= $this->lang->line('header_home_suggestions'); ?></a>
		</li>
	<li class="<?php echo $feature=='Watching'?'active':'' ?>">
		<a href="<?=site_url('item/mywatch/'.$this->session->userdata('id'))?>"><?= $this->lang->line('header_home_watching'); ?></a>
	</li>
	<li class="<?php echo $feature=='Happening'?'active':'' ?>">
		<a href="<?=site_url('home/happening')?>"><?= $this->lang->line('header_home_happening'); ?></a>
	</li>
	<!--
	<li class="">
		<a href="<?=site_url('item/mylike/'.$this->session->userdata('id'))?>">Favorite</a>
	</li>
	<li class="">
		<a href="<?=site_url('user/'.$this->session->userdata('id'))?>">Own</a>
	</li>
	-->
<?php  }?>
		<?php  }?>
			<?php if ($nav=='explore'){  ?>
	<li class="<?php echo $feature=='MostAppreciated'?'active':'' ?>">
		<a href="<?=site_url('item/featured/MostAppreciated')?>"><?= $this->lang->line('header_explore_picks');?></a>
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
	<!--
	<li class="<?php echo $feature=='tag'?'active':'' ?>">
		<a href="<?=site_url('tag')?>">Tags</a>
	</li>-->
	<li class="<?php echo $feature=='author'?'active':'' ?>">
		<a href="<?=site_url('author')?>"><?= $this->lang->line('header_explore_authors');?></a>
	</li>
	<li class="<?php echo $feature=='collection'?'active':'' ?>">
		<a href="<?=site_url('collection/explore/top')?>"><?= $this->lang->line('header_explore_collections');?></a>
	</li>
	<?php  }?>
</ul>

<?php if ($this->session->userdata('id')&&count($watch_list)<1){  ?>
<div class="null-message">
			<?= $this->lang->line('itemhistory_empty'); ?>
	</div>
<?php  }?>

	<ol class="effecthubs group">
	<div style="width:620px;margin-bottom:10px">
               				<?php foreach($watch_list as $_item): ?>
                                <div class="commenttext" style='margin-top:10px;width:200px;overflow:hidden;float:left;margin-right:10px;margin-bottom:25px;margin-left:30px'><b><a href="<?=site_url(($_item['is_folder']==0?'item/':'folder/').$_item['item_id'])?>"><p style='color:#ddd;'><?php echo $_item['title']; ?></p></a></b></div>
                             <?php endforeach; ?></div>
                   <?php foreach($item_history_list as $_item_history): ?>
                   <div class='commentitem' style='border-bottom: 1px dashed #CDCDCD;padding-bottom:15px;margin-bottom:15px;clear:both;'>
                            <div class="commentimg">
                                <a href="<?=site_url(($_item_history['is_folder']==0?'item/':'folder/').$_item_history['item_id'])?>"><img src='<?php echo $_item_history['item_pic']; ?>' style='width:60px;height:60px;'></a>
                            </div>
                            <div>
                                <div class='paragraphstyle'><a href="<?=site_url(($_item_history['is_folder']==0?'item/':'folder/').$_item_history['item_id'])?>"><b style='color:#ddd;'><?php echo $_item_history['item_title']; ?></b></a> </div>  
                                <div class="commenttext" style='margin-top:21px;margin-left:90px'><?php echo $_item_history['action']; ?> <?php echo $_item_history['content']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo tranTime(strtotime($_item_history['timestamp'])); ?></div>	
                            </div>
                   </div> 
                <?php endforeach; ?>

	</ol>



	
<div class="page">
	<?php echo $this->pagination->create_links();?>
</div>



</div> <!-- /main -->

<div class="secondary">
 
<h3><?= $this->lang->line('userlist_popular_authors'); ?> <span class="meta"></span></h3>
	<div class="group-list">
                       <ul>
<?php foreach($user_list as $_user): ?>
 <li>
<a href="<?php echo site_url('user/'.$_user['id'])?>"><img src="<?php echo $_user['pic_url']; ?>" class="group-img"></a>
<p>
<a href="<?php echo site_url('user/'.$_user['id'])?>" class="group-title"><?php echo $_user['displayName']; ?></a>
 <br><span class="group-count"><a href="<?=site_url('user/showfollowers/'.$_user['id'])?>"><?php echo $_user['follower_num']; ?> <?= $this->lang->line('user_followers'); ?></a><br>
 <a href="<?=site_url('author/countrySearch/'.$_user['countryCode'])?>" class="locality"><?php echo $_user['country_name']; ?></a></span>
</p>
<a class="form-sub tagline-action" style="float:right" href="<?=site_url('user/follow/'.$_user['id'])?>"><?= $this->lang->line('user_follow'); ?></a>
 </li>
                   <?php endforeach; ?>
 </ul></div><br/><br/>
 <!--
 <h3><?= $this->lang->line('itemhistory_popular_tags'); ?> <span class="meta"></span></h3>
	
	<div class="group-list">
                       <ul>
<?php foreach($tags as $tag): ?>
                     <a href="<?=site_url('item/tagSearch/'.$tag)?>" class='tagsbutton' style="color:#777;"><?php echo $tag; ?></a>
			          <?php endforeach; ?>
 </ul></div>
 -->
 </div>

</div> <!-- /content -->

</div></div> <!-- /wrap -->
<?php $this->load->view('footer') ?>