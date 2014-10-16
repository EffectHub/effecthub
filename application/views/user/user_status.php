<?php $this->load->view('header') ?>

<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="<?=base_url()?>js/jquery.leanModal.min.js"></script>

<div id="content" class="group">
<div id="main" class="main">
	<?php if (!$this->session->userdata('id')){  ?>
<div class="full full-pitch group">
	<h1 class="compact">
		<strong>EffectHub is connecting the world's gaming designers and developers.</strong>
		
		<a href="<?=site_url('register')?>" class="form-sub tagline-action">Sign up</a>
		<a rel="tipsy" original-title="Sign up with your Twitter account" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Facebook account" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Google account" class="auth-google tagline-action" href="<?=site_url('login/google')?>"></a>
		<!--<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>-->
	</h1>
</div>
<?php  }?>
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

<?php if ($this->session->userdata('id')&&$user['follow_num']<1&&$feature!='Happening'){  ?>
<div class="null-message">
			<?= $this->lang->line('userstatus_none'); ?>
	</div>
<?php  }?>
	<ol class="effecthubs group">
	<?php foreach($status_list as $_status): ?>
                   <div class='commentitem'>
                            <div class="commentimg">
                                <a href="<?=site_url('user/'.$_status['user_id'])?>"><img src='<?php echo $_status['author_pic']; ?>' style='width:60px;max-height:60px'></a>
                            </div>
                            <div>
                                <div class='paragraphstyle'><a href="<?=site_url('user/'.$_status['user_id'])?>"><b style='color:#ddd;font-size:15px;'><?php echo $_status['author_name']; ?></b></a> 
                                	<div style='float:right; font-size: 12px; color: #999;'><?php echo tranTime(strtotime($_status['timestamp'])); ?></div>
                                </div>
                                
                                <div class="commenttext">
                                
                                	<div>
                                	<?php if ($_status['status_type']==1) { 
	                                	echo $this->lang->line('userstatus_type1'); ?>
                                		<a href="<?= site_url('user/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                		<div>
                                	<a href="<?= site_url('user/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php  }?>
                                	<?php } else if ($_status['status_type']==2) {
                                		echo $this->lang->line('userstatus_type2'); ?>
                                		<a href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                	<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('item/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php  }?>
                                	<?php } else if ($_status['status_type']==3) {
                                		echo $this->lang->line('userstatus_type3'); ?>
                                		<a href="<?= site_url('topic/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if (isset($_status['content_name'])){  ?>
                                		<div style="margin-top:5px">
                                	<a style="color:#888;font-size:12px;" href="<?= site_url('group/'.$_status['content_id']) ?>"><?= $_status['content_name'] ?></a>
                                	
                                	</div>
                                	<?php  }?>
                                	<?php } else if ($_status['status_type']==4) {
                                		echo $this->lang->line('userstatus_type4'); ?>
                                		<a href="<?= site_url('team/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('team/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php  }?>
                                		
                                	<?php } else if ($_status['status_type']==5) {
                                		echo $this->lang->line('userstatus_type5'); ?>
                                		<a href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('item/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	
                                	</div>
                                	<?php  }?>
                                	<?php if (isset($_status['content_content'])){?>
                                		<p class="content-content">
                                		<?= $_status['content_content']; ?>
                                		</p>
                                		 <?php }?>
                                		
                                	<?php } else if ($_status['status_type']==6) {
                                		echo $this->lang->line('userstatus_type6'); ?>
                                		<a href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('item/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php  }?>
                                		
                                	<?php } else if ($_status['status_type']==7) {
                                		echo $this->lang->line('userstatus_type7'); ?>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('user/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php  }?>
                                	<?php } else if ($_status['status_type']==8) {
                                		echo $this->lang->line('userstatus_type8'); ?>
                                		<a href="<?= site_url('topic/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                		<?php if (isset($_status['content_content'])){?>
                                		<p class="content-content">
                                		<?= $_status['content_content']; ?>
                                		</p>
                                		 <?php }?>
                                	<?php } else if ($_status['status_type']==9) {
                                		echo $this->lang->line('userstatus_type9'); ?>
                                		<a href="<?= site_url('collection/show/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('collection/show/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php  }?>
                                		<?php if (isset($_status['content_content'])){?>
                                		<p class="content-content">
                                		<?= $_status['content_content']; ?>
                                		</p>
                                		 <?php }?>
                                	<?php } else if ($_status['status_type']==10) {
                                		echo $this->lang->line('userstatus_type10'); ?>
                                		<a href="<?= site_url('collection/show/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('item/'.$_status['content_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php  }?>
                                		
                                	<?php } else if ($_status['status_type']==11) {
                                		echo $this->lang->line('userstatus_type11'); ?>
                                		<a href="<?= site_url('collection/show/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('collection/show/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php  }?>
                                		
                                		
                                	<?php } else if ($_status['status_type']==12) {
                                		echo $this->lang->line('userstatus_type12'); ?>
                                		<a href="<?= site_url('folder/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<div>
                                	<a href="<?= site_url('folder/'.$_status['target_id']) ?>">
                                	<img src='<?php echo base_url('images/cloud/folder.png') ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	
                                		
                                	<?php } else if ($_status['status_type']==13) {
                                		echo $this->lang->line('userstatus_type13'); ?>
                                		<a href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('item/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php }?>
                                		
                                	<?php } else if ($_status['status_type']==14) {
                                		echo $this->lang->line('userstatus_type14'); ?>
                                		<a href="<?= site_url('folder/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<div>
                                	<a href="<?= site_url('item/'.$_status['target_id']) ?>">
                                	<img src='<?php echo base_url('images/cloud/folder.png') ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	
                                		
                                	<?php } else if ($_status['status_type']==15) {
                                		echo $this->lang->line('userstatus_type15'); ?>
                                		<a href="<?= site_url('group/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('group/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:100px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php  }?>
                                		
                                	<?php } else if ($_status['status_type']==16) {
                                		echo $this->lang->line('userstatus_type16'); ?>
                                		<a href="<?= site_url('group/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('group/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:100px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php  }?>
                                		
                                		
                                	<?php } else if ($_status['status_type']==17) {
                                		echo $this->lang->line('userstatus_type17'); ?>
                                		<a href="<?= site_url('folder/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('folder/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php  }?>
                                		
                                	<?php } else if ($_status['status_type']==18) {
                                		echo $this->lang->line('userstatus_type18'); ?>
                                		<a href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('item/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php  }?>
                                		
                                	<?php } else if ($_status['status_type']==19) {
                                		echo $this->lang->line('userstatus_type19'); ?>
                                		<a href="<?= site_url('task/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('folder/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php  }?>
                                		
                                	<?php } else if ($_status['status_type']==20) {
                                		echo $this->lang->line('userstatus_type20'); ?>
                                		<a href="<?= site_url('task/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('folder/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php  }?>
                                		
                                	<?php } else if ($_status['status_type']==21) {
                                		echo $this->lang->line('userstatus_type21'); ?>
                                		<a href="<?= site_url('task/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('folder/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php  }?>
                                		
                                	<?php } else if ($_status['status_type']==22) {
                                		echo $this->lang->line('userstatus_type22'); ?>
                                		<a href="<?= site_url('tool/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<div>
                                	<a href="<?= site_url('tool/'.$_status['target_id']) ?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:48px;margin-top:10px;border-radius:5px;'></a>
                                	</div>
                                	<?php  }?>
                                		
                                	<?php } ?>
                                	</div>
                                </div>
                                
                                <!-- 
                                
                                <?php if (!strpos($_status['content'],'avatar')){  ?>
                                <div class="commenttext">
                                	<div><?php echo $_status['action']; ?> 
                                		<?php if ($_status['content']!=''&&$_status['content']!=null){  ?>
                                		<?php echo $_status['content']; ?>
                                		<?php  }else{?>
                                		<a href="<?php echo $_status['target_url']?>"><?php echo $_status['target_name']?></a>
                                		<?php  }?>
                                	</div>
                                	<?php if ($_status['pic_url']!=null&&$_status['pic_url']!=''){  ?>
                                	<a href="<?php echo $_status['target_url']?>">
                                	<img src='<?php echo $_status['pic_url'] ?>'  style='width:120px;margin-top:10px;border-radius:5px;'></a>
                                	<?php  }?>
                                </div>
                                <?php  }else{?>
                                	<div class="commenttext">changed his avatar  <br/>
                                	 <img src='<?php echo current(array_slice(explode("'",$_status['content']),1,-1)); ?>'  style='width:150px;margin-top:10px;border-radius: 5px;'></div>
                                   
                                <?php  }?>
                                
                                 -->
                            </div>
                   </div>
                <?php endforeach; ?>
                
	  

	</ol>

	
<div class="page">
	<?php echo $this->pagination->create_links(); ?>
</div>



</div> <!-- /main -->

<div class="secondary">

<div class="profile vcard group " style="width:100%">
	<div data-picture="" data-alt="<?php echo $user['displayName']; ?>" data-class="photo">
	<a href="<?=site_url('account/settings')?>" title="Update my Avatar"><img alt="<?php echo $user['displayName']; ?>" class="photo" style="width:80px;max-height:150px" src="<?php echo $user['pic_url']; ?>"></a>	</div>
	<h2>
		<span class="fn edit">
			<a href="<?=site_url('user/'.$user['id'])?>"><?php echo $user['displayName']; ?></a>
			
		</span>
	</h2>

	<ul class="profile-details">
		<li>
			<a href="javascript:" rel="tipsy" original-title="Top 3 works's respective owners every month could be EffectHub MVP." class="badge-link">
	          <span class="badge badge-pro">
	          <?php echo get_level($user['level'],$user['point']); ?>
	          </span>
  </a> &nbsp;<br/><span style="font-size:12px;color:#DDD;font-weight:bold">
                         <?php echo $this->session->userdata('point');?> <?= strtolower($this->lang->line('user_coins'));?>
                       </span>
		</li>
	</ul>
	</div>
<!-- <h3>Get The Most Out Of EffectHub <span class="meta"></span></h3> -->


                       	<div class="group-list">
                       <ul>
                   		<li><a href="<?=site_url('account/social')?>" class="form-btn" onclick="_gaq.push(['_trackEvent', 'LinkBtn', 'clicked', 'Click Link Social Accounts in Home'])"><?= $this->lang->line('userstatus_link_social');?></a>
                         </li>
                         
                          <li><a href="<?=site_url('invite')?>" class="form-btn" onclick="_gaq.push(['_trackEvent', 'InviteBtn', 'clicked', 'Click Invite My Friends in Home'])"><?= $this->lang->line('userstatus_invite_friends');?></a>
                         </li>
                   		<?php if ($this->session->userdata('id')&&$this->session->userdata('pic_url')=='http://www.effecthub.com/images/blank.jpg'){  ?>
                  		<li><a href="<?=site_url('account/settings')?>" class="form-btn"><?= $this->lang->line('userstatus_change_avatar');?></a> </li>
                       	<?php }  ?>
                       	
                       	<?php if ($this->session->userdata('id')&&$this->session->userdata('countryCode')=='CN'){  ?>
                  		<li><a target="_blank" href="http://wp.qq.com/wpa/qunwpa?idkey=24c44bad5e4bae329911fb38adece9156ba6784f6bf83a00d0d1e6c04f5340b8"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="EffectHub官方群" title="EffectHub官方群"></a></li>
                       	<?php }  ?>
	</ul></div><br/><br/>
	<!--	
	<h3>Popular Topics <span class="meta"></span></h3>
	
	<div class="group-list">
                       <ul>
<?php foreach($topic_list as $_topic): ?>
 <li style="padding:0">
  <div style="float:left;text-align:center;margin-right:8px;">
<div style="font-size:14px;background:#bbb; display:inline; padding:2px 8px; color:#fff;"> <?php echo $_topic['comment_num']; ?>
</div>
</div>
 <a href="<?php echo site_url('topic/'.$_topic['id'])?>" style="color:#aaa"><?php echo $_topic['topic_title']; ?></a></li>
<?php endforeach; ?>
 </ul></div>
 
 <br/><br/>-->
<h3><?= $this->lang->line('userstatus_authors_recommendation');?> <span class="meta"></span></h3>
	
	<div class="group-list">
                       <ul>
<?php foreach($user_list as $_user): ?>
 <li>
<a href="<?php echo site_url('user/'.$_user['id'])?>"><img src="<?php echo $_user['pic_url']; ?>" class="group-img"></a>
<p>
<a href="<?php echo site_url('user/'.$_user['id'])?>" class="group-title"><?php echo $_user['displayName']; ?></a>
 <br><span class="group-count"><a href="<?=site_url('user/showfollowers/'.$_user['id'])?>"><?php echo $_user['follower_num']; ?> <?= $this->lang->line('user_followers');?></a><br>
 <a href="<?=site_url('author/countrySearch/'.$_user['countryCode'])?>" class="locality"><?php echo $_user['country_name']; ?></a></span>
</p>
<a class="form-sub tagline-action" style="float:right" href="<?=site_url('user/follow/'.$_user['id'])?>"><?= $this->lang->line('user_follow');?></a>
 </li>
                   <?php endforeach; ?>
 </ul></div><br/><br/>
 
 
 <div class="what-is-pro-search">
		<h3><?= $this->lang->line('userstatus_search_friends');?></h3>

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
 
 </div>

</div> <!-- /content -->

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


</div></div> <!-- /wrap -->
<?php $this->load->view('footer') ?>
