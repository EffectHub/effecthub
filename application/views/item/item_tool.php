<?php $this->load->view('header') ?>

<div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="http://effecthub.com/#" class="close">
		<img alt="Icon-x-30-white" src="<?=base_url()?>images/icon-x-30-white.png" width="15">
	</a>
</div>
<div id="main" class="main-full">
	<?php if (!$this->session->userdata('id')){  ?>
<div class="full full-pitch group">
	<h1 class="compact">
		<strong style="font-size:15px">GET INSPIRED Working With Global Top Game Artists at EffectHub.com!</strong>
		<a href="<?=site_url('register')?>" class="form-sub tagline-action">Sign up</a>
		<a rel="tipsy" original-title="Sign up with your Twitter account" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="Sign up with your Facebook account" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
		<!--<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>-->
	</h1>
</div>
<?php  }?>
<ul class="tabs">
	<li class="active">
		<a href="<?=site_url('tool/'.$tool['id'])?>">Works Created by <?php echo $tool['name']; ?></a>
	</li>
	<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('item/create')?>">Submit my Demos</a>
	<a class="form-sub tagline-action" style="float:right" href="<?=site_url('tool/'.$tool['id'])?>">← Back to <?php echo $tool['name']; ?></a>
</ul>
<ul class="tabs">
			<?php if ($nav=='explore'){  ?>
	<li class="<?php echo $feature=='MostAppreciated'?'active':'' ?>">
		<a href="<?=site_url('item/tool/'.$tool['domain'].'/MostAppreciated')?>">Top</a>
	</li>
	<li class="<?php echo $feature=='MostDiscussed'?'active':'' ?>">
		<a href="<?=site_url('item/tool/'.$tool['domain'].'/MostDiscussed')?>">Popular</a>
	</li>
	<li class="<?php echo $feature=='MostRecent'?'active':'' ?>">
		<a href="<?=site_url('item/tool/'.$tool['domain'].'/MostRecent')?>">Recent</a>
	</li>
	<?php  }?>
</ul>
	<ol class="effecthubs group">
	<?php foreach($item_list as $_item): ?>
                   
                   <li id="work-<?php echo $_item['id']; ?>" class="group ">
	    <div class="effecthub">
	      <div class="effecthub-shot">
	        <div class="effecthub-img">
	          <a href="<?=site_url('item/'.$_item['id'])?>" class="effecthub-link"><div data-picture="" data-alt="<?php echo $_item['title']; ?>">
  <?php if($_item['thumb_url']!=null||$_item['pic_url']!=null){ ?>
  <img width="300px" height="200px" alt="<?php echo $_item['title']; ?>" src="<?php echo $_item['thumb_url']; ?>">
  <?php  }else{?>
  	<iframe src="<?=site_url('item/preview_html/'.$_item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 300px; height: 200px;padding:0px;margin:0px;"></iframe>
  <?php  }?>	
  </div></a>
	          <a href="<?=site_url('item/'.$_item['id'])?>" class="effecthub-over" style="opacity: 0;">		<strong><?php echo $_item['type_name']; ?> - <?php echo $_item['title']; ?></strong>
	            <span class="comment"><?php echo msubstr(auto_link($_item['desc'], 'both', TRUE),0,200); ?></span>
	            
	            <em class="timestamp"><?php echo tranTime(strtotime($_item['create_date'])); ?></em>
  </a></div>
	        <ul class="tools group" style="visibility: visible;">
	          <li class="fav">
	            <a href="<?=site_url('item/'.$_item['id'])?>" title="See fans of this work"><?php echo $_item['fav_num']; ?></a>
	            </li>
	          <li class="cmnt">
	            <a href="<?=site_url('item/'.$_item['id'])?>#comments" title="View comments on this work"><?php echo $_item['comment_num']; ?></a>
	            </li>
	          <li class="views"><?php echo $_item['view_num']; ?></li>
  </ul>
	        
	        </div>
	      <div class="extras">
	      <?php if($_item['parent_id']!=0&&$_item['parent_id']!=null){ ?>
				<a href="<?=site_url('item/'.$_item['parent_id'])?>" style="display: inline;"><span rel="tipsy" class="rebound-mark is-rebound" style="display: inline;" original-title="This work forked from another work. The icon links to the original.">
					<img alt="Rebound" height="16" src="<?=base_url()?>images/icon-rebound-2x.png" width="16">
				</span></a>
				<?php  }?>
				
				<?php if($_item['platform']>0){ ?>
     			<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="This work created for <?php echo $_item['platform_name']; ?> platform">
				<img alt="Attachments" height="16" src="<?php echo $_item['platform_pic']; ?>" width="16">
				</span>
				<?php  }?>
				<?php if($_item['tool']>0){ ?>
     			<a href="<?=site_url('t/'.$_item['tool_domain'])?>" style="display: inline;">
     			<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="This work created using <?php echo $_item['tool_name']; ?>">
				<img alt="Attachments" height="16" src="<?php echo $_item['tool_pic']; ?>" width="16">
				</span>
				</a>
				<?php  }?>
				<?php if($_item['from']=='htmleditor'||$_item['from']=='aseditor'){ ?>
     			<a href="<?=site_url('item/fork/'.$_item['id'])?>" style="display: inline;"><span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="This work created by code editor">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/code.png" width="16">
				</span></a>
				<?php  }?>
				<?php if($_item['download_url']!=0||$_item['download_url']!=null){ ?>
     			<a href="<?=site_url('item/download/'.$_item['id'])?>" style="display: inline;"><span rel="tipsy" class="attachments-mark" style="display: inline;" original-title="This work can be download (<?php echo $_item['price']; ?> coins)">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/icon-attach-16-2x.png" width="16"></a>
			</span>
			<?php  }?>
		</div>
	      </div>
	    
	    <h2>
	      <span class="attribution-user">
	        <a href="<?=site_url('user/'.$_item['author_id'])?>" class="url" rel="contact" title="<?php echo $_item['author_name']; ?>"><img alt="<?php echo $_item['author_name']; ?>" class="photo" src="<?php echo $_item['author_pic']; ?>"> <?php echo $_item['author_name']; ?></a>
	        <a href="javascript:" rel="tipsy" original-title="Top 3 works's respective owners every month could be EffectHub MVP." class="badge-link">
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
<!--
	<a href="http://effecthub.com/effecthub/works/following.rss" class="rss">RSS</a>

-->

</div> <!-- /main -->



</div> <!-- /content -->

</div></div> <!-- /wrap -->
<?php $this->load->view('footer') ?>