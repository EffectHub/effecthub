<?php $this->load->view('header') ?>

<div id="content" class="group">


<div id="main" class="main-full">
	<?php if (!$this->session->userdata('id')){  ?>
<div class="full full-pitch group">
	<h1 class="compact">
		<strong style="font-size:20px"><?= $this->lang->line('index_slogan_title'); ?></strong>
		<strong style="font-size:18px"><?= $user_count ?> </strong>
		<strong style="font-size:14px"><?= $this->lang->line('index_slogan'); ?></strong>
		<strong style="font-size:18px"><?= $item_count ?> </strong>
		<strong style="font-size:14px"><?= $this->lang->line('index_slogan1'); ?></strong>
		<a href="<?=site_url('register')?>" class="form-sub tagline-action" onclick="_gaq.push(['_trackEvent', 'registerbtn', 'clicked', 'Click Get Assets Box'])"><?= $this->lang->line('index_sign_up'); ?></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('index_sign_up_twitter'); ?>" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('index_sign_up_facebook'); ?>" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('index_sign_up_google'); ?>" class="auth-google tagline-action" href="<?=site_url('login/google')?>"></a>
		<!--<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>-->
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
		<a href="<?=site_url('home/newsfeed')?>" class="has-dd"><?= $this->lang->line('header_home_following');?></a>

	</li>

		<li class="<?php echo $feature=='Suggestions'?'active':'' ?>">
			<a href="<?=site_url('home/suggestion')?>"><?= $this->lang->line('header_home_suggestions');?></a>
		</li>
	<li class="">
		<a href="<?=site_url('item/mywatch/'.$this->session->userdata('id'))?>"><?= $this->lang->line('header_home_watching');?></a>
	</li>
	<li class="<?php echo $feature=='Happening'?'active':'' ?>">
		<a href="<?=site_url('home/happening')?>"><?= $this->lang->line('header_home_happening');?></a>
	</li>
<?php  }?>
		<?php  }?>
			<?php if ($nav=='explore'){  ?>
	<li class="<?php echo $feature=='ThisMonth'?'active':'' ?>">
		<a href="<?=site_url('item/featured/ThisMonth')?>"><?= $this->lang->line('header_explore_picks');?></a>
	</li>
	<li class="<?php echo $feature=='MostAppreciated'?'active':'' ?>">
		<a href="<?=site_url('item/featured/MostAppreciated')?>"><?= $this->lang->line('header_explore_top');?></a>
	</li>
	<li class="<?php echo $feature=='MostDownloaded'?'active':'' ?>">
		<a href="<?=site_url('item/featured/MostDownloaded')?>"><?= $this->lang->line('header_explore_popular');?></a>
	</li>
	<li class="<?php echo $feature=='MostRecent'?'active':'' ?>">
		<a href="<?=site_url('item/featured/MostRecent')?>"><?= $this->lang->line('header_explore_recent');?></a>
	</li>
	<li class="<?php echo $feature=='folder'?'active':'' ?>">
		<a href="<?=site_url('folder/explore/top')?>"  onclick="_gaq.push(['_trackEvent', 'folderLink', 'clicked', 'Click Folder List Link'])"><?= $this->lang->line('header_explore_folders'); ?></a>
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
	<li style="float:right;">
		<a href="<?=site_url('rss')?>" onclick="_gaq.push(['_trackEvent', 'RssBtn', 'clicked', 'Click RSS in Index page'])" title="<?= $this->lang->line('index_rss'); ?>"><img style="height:20px;width:20px" src="<?php echo base_url().'images/icon-rss.png'?>"/></a>
	</li>
</ul>
<?php if($feature!='Suggestions'&&$feature!='ThisMonth'){ ?>
<ul class="tabs">
<li class="<?php echo $type=='all'?'active':'' ?>">
		<a href="<?=site_url('item/featured/'.$feature.'/all')?>"><?= $this->lang->line('index_all'); ?></a>
	</li>
<?php foreach($item_type_list as $_item_type): ?>
               		<li class="<?php echo $type==$_item_type['name']?'active':'' ?>"><a href="<?=site_url('item/featured/'.$feature.'/'.$_item_type['name'])?>"><?php echo $lang=='2'?$_item_type['name_cn']:$_item_type['name']; ?></a></li>
               <?php endforeach; ?>
</ul>
  <?php  }?>
	<ol class="effecthubs group">
	<?php foreach($item_list as $_item): ?>
                   
                   <li id="work-<?php echo $_item['id']; ?>" class="group ">
	    <div class="effecthub">
	      <div class="effecthub-shot">
	      	<h5 style="margin-bottom:10px"><?php echo $_item['title']; ?></h5>
	        <?php if($_item['file_type'] == 1|| $_item['thumb_url']!=null||$_item['pic_url']!=null||$_item['from']=='htmleditor'||$_item['from']=='aseditor'||$_item['extension']=='swf'){ ?>
	        	
	        <div class="effecthub-img">
	        <?php if($_item['file_type'] == 0){?>
	          <a href="<?=site_url('item/'.$_item['id'])?>" class="effecthub-link"><div data-picture="" data-alt="<?php echo $_item['title']; ?>">
	          <?php }else{?>
	          <a href="<?=site_url('folder/'.$_item['id'])?>" class="effecthub-link"><div data-picture="" data-alt="<?php echo $_item['title']; ?>">
	          <?php }?>
  <?php if($_item['thumb_url']!=null||$_item['pic_url']!=null){ ?>
  <span class="item_image_wrap" alt="<?php echo $_item['title']; ?>">
                        <span class="item_image" style="background-image:url(<?php echo $_item['thumb_url']; ?>)"></span>
  </span>
  <?php if ($_item['contest_id']==3){  ?>
                    <a title="EffectHub & 图灵图书 移动游戏分享大赛: 参加即能赢取最新版Kindle以及移动游戏开发图书!" href="<?=site_url('turing')?>"><span class="tag_box" style="background:url(<?=base_url()?>images/contest.png) no-repeat 0 0;_background-image:none;_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=base_url()?>images/soldout.png',sizingMethod='noscale');"></span></a>
                    <?php  }?>
                    <?php }elseif($_item['file_type'] == 1){?>
                    <!-- This is a folder  used for effecthub-link and back-ground -->
                    <span class="item_image_wrap" alt="<?php echo $_item['title']; ?>">                        
                        <?php if($_item['img_count'] > 0){?>                                                
	                        <?php foreach ($_item['folder_items'] as $folder_item){?>
	                        		<?php if($folder_item['pic_url'] != null){?>
	                        		<span class="item_image" style="background-image:url(<?php echo $folder_item['pic_url']; ?>)"></span>
	                      			
	                      			<?php }else{?>
	                      			<iframe id="<?= $folder_item['id']?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="position:relative; width:48%; height:48%; margin:2% float:left;"></iframe>	                      			
	                      			<?php }?>
	                        <?php }?>	                       
                        <?php }else{?>
                        	<!-- <img id="<?= $_item['id']?>" src="<?php echo $_item['folder_img']; ?>"/> -->
                        	<span class="item_image" style="background-color:gray;">
                        		<img id="<?= $_item['id']?>" src="<?=base_url()?>images/item/new-folder.png" style="display:block;margin-left: auto;margin-right: auto;"/>
                        	</span>
                        <?php }?>
                        
  					</span>
  					<?php if ($_item['contest_id']==3){  ?>
                    		<a title="EffectHub & 图灵图书 移动游戏分享大赛: 参加即能赢取最新版Kindle以及移动游戏开发图书!" href="<?=site_url('turing')?>"><span class="tag_box" style="background:url(<?=base_url()?>images/contest.png) no-repeat 0 0;_background-image:none;_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=base_url()?>images/soldout.png',sizingMethod='noscale');"></span></a>
                    <?php  }?>
                    
  <?php  }else{?>
  	<iframe src="<?=site_url('item/preview_html/'.$_item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 300px; height: 200px;padding:0px;margin:0px;"></iframe>
  <?php  }?>	
  </div></a>
  <?php if($_item['file_type'] == 1){?>  
	  <a href="<?=site_url('folder/'.$_item['id'])?>" class="effecthub-over" style="opacity: 0;">
	  <strong><?php echo isset($_item['folder_name'])?$_item['folder_name'].' - ':''; ?> <?php echo $_item['title']; ?></strong>
		            <span class="comment"><?php echo msubstr($_item['desc'],0,200); ?></span>
  <?php  }else{?>
  <a href="<?=site_url('item/'.$_item['id'])?>" class="effecthub-over" style="opacity: 0;">
  <strong><?php echo isset($_item['folder_name'])?$_item['folder_name'].' - ':''; ?> <?php echo $_item['title']; ?></strong>
	            <span class="comment"><?php echo msubstr($_item['desc'],0,200); ?></span>	      
  <?php  }}else{?>
  	
	        <div class="effecthub-img">
  <a href="<?=site_url('item/'.$_item['id'])?>" class="effecthub" style="opacity: 0.8;">	
  <strong><?php echo isset($_item['folder_name'])?$_item['folder_name'].' - ':''; ?> <?php echo $_item['title']; ?></strong>
	     <iframe src="<?=site_url('item/preview_html/'.$_item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 300px; height: 200px;padding:0px;margin:0px;"></iframe>
  	<?php  }?>
	            <em class="timestamp"><?php echo tranTime(strtotime($_item['create_date'])); ?></em>
  </a></div>
	        <ul class="tools group" style="visibility: visible;">
	        
	          <li class="fav">
	            <a href="<?=site_url('item/'.$_item['id'])?>" title="<?= $this->lang->line('work_likes') ?>"><?php echo $_item['fav_num']; ?></a>
	            </li>
	          <li class="cmnt">
	            <a href="<?=site_url('item/'.$_item['id'])?>#comments" title="<?= $this->lang->line('work_comments') ?>"><?php echo $_item['comment_num']; ?></a>
	            </li>
	            <?php if($_item['is_private']==0){ ?>
	          <li class="views"><?php echo $_item['view_num']; ?></li>
	          <?php  }?>
  </ul>
	        
	        </div>
	      <div class="extras">
	      <?php if($_item['file_type'] == 0){?>  
	      <?php if($_item['parent_id']!=0&&$_item['parent_id']!=null){ ?>
				<a href="<?=site_url('item/'.$_item['parent_id'])?>" style="display: inline;"><span rel="tipsy" class="rebound-mark is-rebound" style="display: inline;" original-title="<?= $this->lang->line('work_fork') ?>">
					<img alt="Rebound" height="16" src="<?=base_url()?>images/icon-rebound-2x.png" width="16">
				</span></a>
				<?php  }?>
				<?php  }?>
				<?php if($_item['platform']>0){ ?>
				<a href="<?=site_url('item/platform/'.$_item['platform_key'])?>" style="display: inline;">
     			<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_platform_first') ?> <?php echo $_item['platform_name']; ?> <?= $this->lang->line('work_platform') ?>">
				<img alt="Attachments" height="16" src="<?php echo $_item['platform_pic']; ?>" width="16">
				</span>
				</a>
				<?php  }?>
				<?php if($_item['tool']>0){ ?>
     			<a target="_blank" href="<?=site_url('t/'.$_item['tool_domain'])?>" style="display: inline;">
     			<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_tool_first') ?> <?php echo $_item['tool_name']; ?><?= $this->lang->line('work_tool') ?>">
				<img alt="Attachments" height="16" src="<?php echo $_item['tool_pic']; ?>" width="16">
				</span>
				</a>
				<?php  }?>
				<?php if($_item['from']=='htmleditor'){ ?>
     			<a href="<?=site_url('item/fork/'.$_item['id'])?>" style="display: inline;"><span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_html') ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/code.png" width="16">
				</span></a>
				<?php  }?>
				<?php if($_item['from']=='aseditor'){ ?>
     			<a href="<?=site_url('item/fork/'.$_item['id'])?>" style="display: inline;"><span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_actionscript') ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/code.png" width="16">
				</span></a>
				<?php  }?>
				<?php if($_item['is_private']>1){ ?>
     			<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_private') ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/icon-lock.png" width="16">
				</span>
				<?php  }?>
				<?php if($_item['file_type'] == 0){?>  
				<?php if($_item['is_private']==0&&($_item['download_url']!=0||$_item['download_url']!=null)){ ?>
     			<a target="_blank" href="<?=site_url('item/download/'.$_item['id'])?>" style="display: inline;"><span rel="tipsy" class="attachments-mark" style="display: inline;" original-title="<?= $this->lang->line('work_download') ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/icon-attach-16-2x.png" width="16">
				</span></a>
				<?php  }?>
				<?php  }else{?>
				<span rel="tipsy" class="attachments-mark" style="display: inline;" original-title="<?= $this->lang->line('work_folder') ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/item/new-folder.png" width="16">
				</span>
				<?php  }?>
		</div>
	      </div>
	    
	    <h2>
	      <span class="attribution-user">
	        <a href="<?=site_url('user/'.$_item['author_id'])?>" class="url" rel="contact" title="<?php echo $_item['author_name']; ?>"><img alt="<?php echo $_item['author_name']; ?>" class="photo" src="<?php echo $_item['author_pic']; ?>"> <?php echo $_item['author_name']; ?></a>
	        <a href="javascript:" rel="tipsy" original-title="<?= $this->lang->line('work_mvp'); ?>" class="badge-link">
	          <span class="badge badge-pro">
	          <?php echo get_level($_item['author_level'],$_item['author_point']); ?>
	          </span>
  </a>
	        </span>
	      </h2>
</li>
                   
                <?php endforeach; ?>
                
	  

	</ol>
<div class="page">
	<?php echo $this->pagination->create_links();?>
</div>


</div> <!-- /main -->



</div> <!-- /content -->

</div></div> <!-- /wrap -->
<?php $this->load->view('footer') ?>
