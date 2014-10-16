<?php $this->load->view('header') ?>
<div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png?1376325170" width="15">
	</a>
</div>
	<?php if (!$this->session->userdata('id')){  ?>
<div class="full full-pitch group">
	<h1 class="compact">
		<strong style="font-size:20px"><?= $this->lang->line('toollist_unlogin_first'); ?></strong>
		<strong style="font-size:14px"><?= $this->lang->line('toollist_unlogin'); ?></strong>
		<a href="<?=site_url('register')?>" class="form-sub tagline-action"><?= $this->lang->line('toollist_sign_up'); ?></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('toollist_sign_up_twitter'); ?>" class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('toollist_sign_up_facebook'); ?>" class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
		<a rel="tipsy" original-title="<?= $this->lang->line('toollist_sign_up_google'); ?>" class="auth-google tagline-action" href="<?=site_url('login/google')?>"></a>
		<!--<a rel="tipsy" original-title="Sign up with your Weibo account" class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>-->
	</h1>
</div>
<?php  }?>

<div id="main" class="main-full">
<ul class="tabs">
	<li class="<?php echo $feature=='MostAppreciated'?'active':'' ?>">
		<a href="<?=site_url('tool/featured/MostAppreciated')?>"><?= $this->lang->line('toollist_top'); ?></a>
	</li>
	<li class="<?php echo $feature=='MostDiscussed'?'active':'' ?>">
		<a href="<?=site_url('tool/featured/MostDiscussed')?>"><?= $this->lang->line('toollist_popular'); ?></a>
	</li>
	<li class="<?php echo $feature=='MostRecent'?'active':'' ?>">
		<a href="<?=site_url('tool/featured/MostRecent')?>"><?= $this->lang->line('toollist_recent'); ?></a>
	</li>
	<?php if ($this->session->userdata('id')){  ?>
<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('tool/submit')?>" onclick="_gaq.push(['_trackEvent', 'tool', 'submit tool', 'Click submit tool in tool list page'])"><?= $this->lang->line('toollist_submit'); ?></a>
<?php  }?>
</ul>
<ul class="tabs">
		<li class="tools <?php echo $type=='all'?'active':'' ?>">
		<a href="<?=site_url('tool/featured/'.$feature.'/all')?>"		<span class="meta"><?= $this->lang->line('toollist_all'); ?></span>
		<span class="count"></span></a></li>
		<?php foreach($item_type_list as $_item_type): ?>
               		<li class="<?php echo $type==$_item_type['name']?'active':'' ?>"><a href="<?=site_url('tool/featured/'.$feature.'/'.$_item_type['name'])?>"><?= ($lang == 2)?$_item_type['name_cn']:$_item_type['name']; ?></a></li>
        <?php endforeach; ?>
</ul>
<ol class="effecthubs group">
	<?php foreach($tool_list as $_item): ?>
                   
                   <li id="work-<?php echo $_item['id']; ?>" class="group ">
	    <div class="effecthub">
	      <div class="effecthub-shot">
	      <h5 style="margin-bottom:10px"><?php echo $_item['name']; ?></h5>
	        <div class="effecthub-img">
	          <a href="<?=site_url('t/'.$_item['domain'])?>" class="effecthub-link"><div data-picture="" data-alt="<?php echo $_item['name']; ?>">
   <img width="300px" height="200px" alt="<?php echo $_item['name']; ?>" src="<?php echo $_item['pic_url']; ?>">
 	
  </div></a>
	          <a href="<?=site_url('t/'.$_item['domain'])?>" class="effecthub-over" style="opacity: 0;">		<strong><?php echo $_item['type_name']; ?> - <?php echo $_item['name']; ?></strong>
	            <span class="comment"><?php echo msubstr(auto_link($_item['desc'], 'both', TRUE),0,200); ?></span>
	            
	            <em class="timestamp"><?php echo tranTime(strtotime($_item['create_date'])); ?></em>
  </a></div>
	        <ul class="tools group" style="visibility: visible;">
	          <li class="fav">
	            <a href="<?=site_url('group/'.$_item['group_id'])?>" title="<?= $this->lang->line('toollist_members'); ?>"><?php echo $_item['fav_num']; ?></a>
	            </li>
	          <li class="cmnt">
	            <a href="<?=site_url('group/'.$_item['group_id'])?>" title="<?= $this->lang->line('toollist_topics'); ?>"><?php echo $_item['comment_num']; ?></a>
	            </li>
	          <li class="views"><?php echo $_item['view_num']; ?></li>
  </ul>
	        
	        </div>
	      <div class="extras">
	      <?php if($_item['platform']==1){ ?>
				<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('toollist_flash'); ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/flash.png" width="16">
				</span>
				<?php  }?>
				<?php if($_item['platform']==2){ ?>
     			<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('toollist_html5'); ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/html5.png" width="16">
				</span>
				<?php  }?>
				<?php if($_item['platform']==3){ ?>
     			<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('toollist_unity'); ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/unity.png" width="16">
				</span>
				<?php  }?>
				<?php if($_item['github_url']!=null){ ?>
     			<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('toollist_opensource'); ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/opensource.png" width="16">
				</span>
				<?php  }?>
		</div>
	      </div>
	    
	    <h2>
	      <span class="attribution-user">
	      <?= $this->lang->line('toollist_submitter'); ?> 
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
</div>


</div>
<?php $this->load->view('footer') ?>
