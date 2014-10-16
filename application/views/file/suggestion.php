<?php $this->load->view('header') ?>

<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>css/file.css" media="screen, projection" rel="stylesheet" type="text/css">
<div id="content" class="group">


	<?php if (!$this->session->userdata('id')){  ?>
<div class="full full-pitch group">
	<h1 class="compact">
		<strong><?= $this->lang->line('folderexplore_unlogin'); ?></strong>
		
		<a href="<?=site_url('register')?>" class="form-sub tagline-action"><?= $this->lang->line('folderexplore_sign_up'); ?></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('folderexplore_sign_up_twitter'); ?>" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('folderexplore_sign_up_facebook'); ?>" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
	<a rel="tipsy" original-title="<?= $this->lang->line('folderexplore_sign_up_google'); ?>" class="auth-google tagline-action" href="<?=site_url('login/google')?>"></a>
		<!--<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>-->
	</h1>
</div>
<?php  }?>

<div id="main" class="main-full">
	<div class="results-pane" style="opacity: 1;">
<ul class="tabs">
<?php if ($this->session->userdata('id')){  ?>
			<?php if ($nav=='works'){  ?>
				<?php if ($this->session->userdata('level')>0){  ?>
				<li class="<?php echo $feature=='assets'?'active':'' ?>">
		<a href="<?=site_url('disk')?>" class="has-dd"><?= $this->lang->line('header_home_files');?></a>
	</li><?php  }?>
	
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

<div style="float:left;position:relative;width:48%;">
<!--
<h2 style="margin-bottom:15px;border-bottom:1px solid #999;padding-bottom:10px"><?= $this->lang->line('user_job') ?>&nbsp;&nbsp;
<select name="job_type" class="support-select category" id="job_type" placeholder="Job Type" style="background-color:#dedede;font-size:100%;width:auto;padding:0 15px 0 10px">
						<?php foreach($job_type_list as $_job_type): ?>
						<option value="<?php echo $_job_type['id']; ?>" <?php echo $_job_type['id']==$this->session->userdata('job_type')?'selected="selected"':'';?> name="<?= $_job_type['id']?>"><?php echo $lang==2?$_job_type['name_cn']:$_job_type['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
<a style="float:right;" title="Refresh Content" href="javascript:document.location.reload();"><img src="<?=base_url()?>images/refresh.png"/></a>
</h2>
-->
<h2 style="margin-bottom:10px;width:100%"><?= $this->lang->line('user_may_work') ?>&nbsp;&nbsp;
<a style="font-size:12px;float:right" href="<?php echo site_url('item/featured/MostAppreciated')?>">more>>></a>
<a class="form-sub tagline-action" style="float:right;display:none" href="<?php echo site_url('disk/')?>"><?= $this->lang->line('user_upload_work') ?></a>
</h2>
<ol class="effecthubs group">
	<?php foreach($item_list as $_item): ?>
                   
                   <li id="work-<?php echo $_item['id']; ?>" class="group " style="float:left;position:relative;width:50%;margin:0 0px 15px 0">
	    <div class="effecthub">
	      <div class="effecthub-shot">
	        <div class="effecthub-img">
	        <?php if($_item['thumb_url']!=null||$_item['pic_url']!=null||$_item['from']=='htmleditor'||$_item['from']=='aseditor'||$_item['extension']=='swf'){ ?>
	          <a target="_blank" href="<?=site_url('item/'.$_item['id'])?>" class="effecthub-link"><div data-picture="" data-alt="<?php echo $_item['title']; ?>">
  <?php if($_item['thumb_url']!=null||$_item['pic_url']!=null){ ?>
  <span class="item_image_wrap" alt="<?php echo $_item['title']; ?>">
                        <span class="item_image" style="background-image:url(<?php echo $_item['thumb_url']; ?>)"></span>
  </span>
  <?php if ($_item['contest_id']==3&&$lang=='3'){  ?>
                    <a title="EffectHub & 图灵图书 移动游戏分享大赛: 参加即能赢取最新版Kindle以及移动游戏开发图书!" href="<?=site_url('turing')?>"><span class="tag_box" style="background:url(<?=base_url()?>images/contest.png) no-repeat 0 0;_background-image:none;_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=base_url()?>images/soldout.png',sizingMethod='noscale');"></span></a>
                    <?php  }?>
  <?php  }else{?>
  	<iframe src="<?=site_url('item/preview_html/'.$_item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 300px; height: 200px;padding:0px;margin:0px;"></iframe>
  <?php  }?>	
  </div></a>
  <a target="_blank" href="<?=site_url('item/'.$_item['id'])?>" class="effecthub-over" style="opacity: 0;">
  <?php  }else{?>
  <a target="_blank" href="<?=site_url('item/'.$_item['id'])?>" class="effecthub" style="opacity: 0.8;">	
  	<?php  }?>
	          		<strong><?php echo $_item['type_name']; ?> <?php echo isset($_item['folder_name'])?'- '.$_item['folder_name']:''; ?> - <?php echo $_item['title']; ?></strong>
	            <span class="comment"><?php echo msubstr($_item['desc'],0,200); ?></span>
	            
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
	      <?php if($_item['parent_id']!=0&&$_item['parent_id']!=null){ ?>
				<a href="<?=site_url('item/'.$_item['parent_id'])?>" style="display: inline;"><span rel="tipsy" class="rebound-mark is-rebound" style="display: inline;" original-title="<?= $this->lang->line('work_fork') ?>">
					<img alt="Rebound" height="16" src="<?=base_url()?>images/icon-rebound-2x.png" width="16">
				</span></a>
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
				<?php if($_item['is_private']==0&&($_item['download_url']!=0||$_item['download_url']!=null)){ ?>
     			<a target="_blank" href="<?=site_url('item/download/'.$_item['id'])?>" style="display: inline;"><span rel="tipsy" class="attachments-mark" style="display: inline;" original-title="<?= $this->lang->line('work_download') ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/icon-attach-16-2x.png" width="16"></a>
			</span>
			<?php  }?>
		</div>
	      </div>
	    
	    <h2>
	      <span class="attribution-user">
	        <a target="_blank" href="<?=site_url('user/'.$_item['author_id'])?>" class="url" rel="contact" title="<?php echo $_item['author_name']; ?>"><img alt="<?php echo $_item['author_name']; ?>" class="photo" src="<?php echo $_item['author_pic']; ?>"> <?php echo $_item['author_name']; ?></a>
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
	
<h2 style="margin-bottom:10px;width:100%"><?= $this->lang->line('user_may_folder') ?>&nbsp;&nbsp;
<a style="font-size:12px;float:right" href="<?php echo site_url('folder/explore/top/')?>">more>>></a>
<a class="form-sub tagline-action" style="float:right;display:none" href="<?php echo site_url('disk/')?>"><?= $this->lang->line('user_upload_folder') ?></a>
</h2>
	<ol class="effecthubs group">
		<?php foreach($folder_list as $_collect): ?>
		
		<li id="screenshot-1085677" style="float:left;position:relative;width:100%;margin:0 15px 15px 0">
			<div class="effecthub c-explore">
				
				
				<div style="padding:10px;height:100px;width:100px">
				<a target="_blank" href="<?=site_url('folder/'.$_collect['id'])?>">
					<img style="width:100px;height:80px;" alt="<?= $_collect['folder_name']; ?>" src="http://www.effecthub.com/images/cloud/folder.png">
				</a>
				</div>
					
				<div class="collect">
					<a target="_blank" href="<?=site_url('folder/'.$_collect['id'])?>" class="c-title"><strong><?=msubstr($_collect['folder_name'],0,50);?></strong></a>
					<br>
					<a target="_blank" href="<?=site_url('user/'.$_collect['user_id'])?>" class="c-name"><?= msubstr($_collect['user_name'],0,50); ?></a>
				</div>
				<ul class="c-data">
					<li class="like"><?= $_collect['watch_num']; ?></li>
					<li class="views"><?= $_collect['view_num']; ?></li>
				</ul>
				
				<div class="collect-pick">
					<?php foreach($folder_items[$_collect['id']] as $_item): ?>
					<a target="_blank" href="<?=site_url('item/'.$_item['id'])?>" title="<?php echo $_item['title']; ?>">
	  					<?php if($_item['thumb_url']!=null||$_item['pic_url']!=null){ ?>
  						<img alt="<?php echo $_item['title']; ?>" src="<?php echo $_item['thumb_url']; ?>" style="height:auto;max-height:60px">
  						<?php  }?>
					</a>
					<?php endforeach; ?>
				</div>
				
				<div class="c-works"><?=$_collect['works_num']?> <?= $this->lang->line('folderexplore_collect'); ?></div>
				
				
			</div>
		</li>
		
		<?php endforeach; ?>

	</ol>
	</div>
<div style="position:relative;float:right;width:48%">
<ul class="line" style="position:relative;background-color:#212121;border-color:#000;width:100%;margin: 0 15px 15px 0;"> 
<?php foreach($status_list as $_status): ?>
<li style="margin-top: 0px;" class="status">
<a target="_blank" href="<?=site_url('user/'.$_status['user_id'])?>"><?php echo $_status['author_name']; ?></a>
<?php if ($_status['status_type']==1) { 
	                                	echo $this->lang->line('userstatus_type1'); ?>
                                		<a target="_blank" href="<?= site_url('user/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==2) {
                                		echo $this->lang->line('userstatus_type2'); ?>
                                		<a target="_blank" href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                	
                                	<?php } else if ($_status['status_type']==3) {
                                		echo $this->lang->line('userstatus_type3'); ?>
                                		<a target="_blank" href="<?= site_url('topic/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==4) {
                                		echo $this->lang->line('userstatus_type4'); ?>
                                		<a target="_blank" href="<?= site_url('team/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                		
                                	<?php } else if ($_status['status_type']==5) {
                                		echo $this->lang->line('userstatus_type5'); ?>
                                		<a target="_blank" href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==6) {
                                		echo $this->lang->line('userstatus_type6'); ?>
                                		<a target="_blank" href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==7) {
                                		echo $this->lang->line('userstatus_type7'); ?>
                                		
                                	<?php } else if ($_status['status_type']==8) {
                                		echo $this->lang->line('userstatus_type8'); ?>
                                		<a target="_blank" href="<?= site_url('topic/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==9) {
                                		echo $this->lang->line('userstatus_type9'); ?>
                                		<a target="_blank" href="<?= site_url('collection/show/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==10) {
                                		echo $this->lang->line('userstatus_type10'); ?>
                                		<a target="_blank" href="<?= site_url('collection/show/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==11) {
                                		echo $this->lang->line('userstatus_type11'); ?>
                                		<a target="_blank" target="_blank" href="<?= site_url('collection/show/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==12) {
                                		echo $this->lang->line('userstatus_type12'); ?>
                                		<a target="_blank" href="<?= site_url('folder/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                		
                                	<?php } else if ($_status['status_type']==13) {
                                		echo $this->lang->line('userstatus_type13'); ?>
                                		<a target="_blank" href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==14) {
                                		echo $this->lang->line('userstatus_type14'); ?>
                                		<a target="_blank" href="<?= site_url('folder/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==15) {
                                		echo $this->lang->line('userstatus_type15'); ?>
                                		<a target="_blank" href="<?= site_url('group/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==16) {
                                		echo $this->lang->line('userstatus_type16'); ?>
                                		<a target="_blank" href="<?= site_url('group/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==17) {
                                		echo $this->lang->line('userstatus_type17'); ?>
                                		<a target="_blank" href="<?= site_url('folder/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==18) {
                                		echo $this->lang->line('userstatus_type18'); ?>
                                		<a target="_blank" href="<?= site_url('folder/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==19) {
                                		echo $this->lang->line('userstatus_type19'); ?>
                                		<a target="_blank" href="<?= site_url('task/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==20) {
                                		echo $this->lang->line('userstatus_type20'); ?>
                                		<a target="_blank" href="<?= site_url('task/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==21) {
                                		echo $this->lang->line('userstatus_type21'); ?>
                                		<a target="_blank" href="<?= site_url('task/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==22) {
                                		echo $this->lang->line('userstatus_type22'); ?>
                                		<a target="_blank" href="<?= site_url('tool/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } ?> <span style="color:#999;margin-left:20px"><?php echo tranTime(strtotime($_status['timestamp'])); ?></span></li>
 <?php endforeach; ?>
</ul>

<h2 style="margin-bottom:10px;width:100%"><?= $this->lang->line('user_may_help') ?>&nbsp;&nbsp;
<a style="font-size:12px;float:right" href="<?php echo site_url('task/')?>">more>>></a>
<a class="form-sub tagline-action" style="float:right;display:none" href="<?php echo site_url('task/create/')?>"><?= $this->lang->line('user_request') ?></a>
</h2>
<ol class="effecthubs group">
		<?php foreach($task_list as $_task): ?>
		
		<li id="screenshot-1085677" style="float:right;position:relative;width:100%;margin:0 0px 15px 0">
			<div class="effecthub c-explore">
				
					
				<div class="collect" style="left:10px;width:97.5%">
					<a target="_blank" href="<?=site_url('task/'.$_task['id'])?>" class="c-title"><strong><?= msubstr($_task['title'],0,100); ?></strong></a>
					<br>
					<a target="_blank" href="<?=site_url('task/type/'.$_task['type'])?>" class="c-name"><?=$lang==2?$_task['type_name_cn']:$_task['type_name'] ?></a>
					
				
				</div>
				<ul class="c-data" style="left:0px;">
				
				
					<li class="views"><?= $_task['view_num']; ?></li>
					<li class="cmt"><?= $_task['response_num']; ?></li>
					<li>&nbsp;&nbsp;&nbsp;&nbsp;<a target="_blank" href="<?=site_url('user/'.$_task['author_id'])?>" class="c-name"><?= msubstr($_task['author_name'],0,50); ?></a></li>
					
				</ul>
				
				<div class="collect-pick">
				</div>
				
				<div class="c-works">
				<?php if($_task['price_type']=='1'){
					echo '<img src="'.base_url('images/icon-coin.png').'" height="12px" width="12px" />'.' '.$_task['price'];
				}else{
					if($lang==2){
						echo '￥'.$_task['price'];
					}else{
						 echo '$'.$_task['price'];
					}
				}
				?></div>
				
				
			</div>
		</li>
		
		<?php endforeach; ?>

	</ol>
	
<h2 style="margin-bottom:10px;width:100%"><?= $this->lang->line('user_may_process') ?>&nbsp;&nbsp;
<a style="font-size:12px;float:right" href="<?php echo site_url('group/')?>">more>>></a>
	<!--
<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('topic/create/')?>"><?= $this->lang->line('user_write_process') ?></a>
-->
</h2>
<?php foreach ($topic_list as $topics):?>
        	<div class="topic-item">
        		<a target="_blank" href="<?= site_url('topic/'.$topics['id']) ?>" title="View comments of this topic"><span class="t-comment-num"><?= $topics['comment_num'] >99?'99+':$topics['comment_num'] ?></span></a>
        		<span class="t-link">
        			<a target="_blank" href="<?= site_url('topic/'.$topics['id']) ?>" title="<?=$topics['topic_title'] ?>"><?=$topics['topic_title'] ?></a>
        		</span>
        		<span class="t-reply-time"><?= $topics['comment_num']>0? $this->lang->line('groupexplore_last_replied'):''; ?> <?= tranTime(strtotime($topics['last_comment_time'])) ?>
        		<a target="_blank" href="<?= site_url('user/'.$topics['author_id']) ?>" title="<?=$topics['author_name'] ?>"><?= $topics['author_name'] ?></a></span>
        	</div>
        	<?php endforeach; ?>
        	
        	<br/>
<h2 style="margin-bottom:10px;width:100%"><?= $this->lang->line('user_may_group') ?>&nbsp;&nbsp;
<a style="font-size:12px;float:right" href="<?php echo site_url('group/')?>">more>>></a>
</h2>        	
<?php foreach($group_list as $group): ?>
					<div class="hot-group">
						<a target="_blank" href="<?= site_url('g/'.$group['key'])?>" title="<?= $group['group_name']?>"><img src="<?= $group['group_pic']?>"/></a>
						<a target="_blank" class="hot-group-title" href="<?= site_url('g/'.$group['key'])?>" title="<?= $group['group_name']?>"><?= $group['group_name']?></a>
						<span class="mem-num"><?= $group['member_num']?> <?= $this->lang->line('groupexplore_members'); ?></span>
						<span class="topic-num"><?= $group['topic_num']?> <?= $this->lang->line('groupexplore_topics'); ?></span>
					</div>
			
				<?php endforeach;?>
</div>
<div class="page">
</div>


	</div>

	<div class="processing processing-results hide" style="display: none;"><?= $this->lang->line('folderexplore_finding_folders'); ?></div>
</div>

<!--
<div class="secondary">
	
	<h3><?= $this->lang->line('folderexplore_active_folders'); ?><span class="meta"></span></h3>
	<div class="group-list">
		<ul>
		<?php foreach($new_folder as $_list): ?>
 			<li>
				<a href="<?php echo site_url('folder/'.$_list['id'])?>"><img src="http://www.effecthub.com/images/cloud/folder.png" class="group-img"></a>
				<p>
					<a href="<?php echo site_url('folder/'.$_list['id'])?>" class="group-title"><?php echo msubstr($_list['folder_name'],0,50); ?></a>
 					<br><span class="group-count"><?php echo $_list['works_num']; ?> <?= $this->lang->line('folderexplore_collect'); ?><br>
 					<a href="<?=site_url('user/'.$_list['user_id'])?>"><?php echo $_list['user_name']; ?></a></span>
				</p>
 			</li>
                   <?php endforeach; ?>
 		</ul>
	</div>

</div>

-->

</div>

 <script type="text/javascript">
 $(function(){
	var _wrap=$('ul.line');//定义滚动区域
	var _interval=3000;//定义滚动间隙时间
	var _moving;//需要清除的动画
	_wrap.hover(function(){
		clearInterval(_moving);//当鼠标在滚动区域中时,停止滚动
	},function(){
		_moving=setInterval(function(){
			var _field=_wrap.find('li:first');//此变量不可放置于函数起始处,li:first取值是变化的
			var _h=_field.height();//取得每次滚动高度(多行滚动情况下,此变量不可置于开始处,否则会有间隔时长延时)
			_field.animate({marginTop:-_h+'px'},600,function(){//通过取负margin值,隐藏第一行
				_field.css('marginTop',0).appendTo(_wrap);//隐藏后,将该行的margin值置零,并插入到最后,实现无缝滚动
			})
		},_interval)//滚动间隔时间取决于_interval
	}).trigger('mouseleave');//函数载入时,模拟执行mouseleave,即自动滚动
});
</script>
<script>
$('#job_type').change(function(){

	$.post(
		"<?= site_url('user/changejobtype') ?>",
		{ job_type: $('#job_type').val() },
		function(data,status){
			document.location.reload();
		});
});
</script>
<?php $first = get_cookie('first_login');
		if (isset($first)&&($first!= null)&&($first == 1)) {

	$this->load->view('first_login');
	
 	$cookie = array(
			'name'   => 'first_login',
			'value'  => 0,
			'expire' => '5',
		);
		set_cookie($cookie);
	
	 }?>
<?php $this->load->view('footer') ?>
