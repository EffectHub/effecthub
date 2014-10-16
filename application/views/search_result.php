<?php $this->load->view('header') ?>
<div id="content" class="group">


<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png?1376311488" width="15">
	</a>
</div>

	<?php if (!$this->session->userdata('id')){  ?>
<div class="full full-pitch group">
	<h1 class="compact">
		<strong><?= $this->lang->line('userinvite_userlogin_slogan'); ?></strong>
		
		<a href="<?=site_url('register')?>" class="form-sub tagline-action"><?= $this->lang->line('header_sign_up'); ?></a>
		<a rel="tipsy" original-title=<?= $this->lang->line('pop_sign_up_twitter'); ?> class="auth-twitter tagline-action" href="<?=site_url('login/twitter')?>"></a>
		<a rel="tipsy" original-title=<?= $this->lang->line('pop_sign_up_facebook'); ?> class="auth-facebook tagline-action" href="<?=site_url('login/facebook')?>"></a>
		<a rel="tipsy" original-title=<?= $this->lang->line('pop_sign_up_weibo'); ?> class="auth-weibo tagline-action" href="<?=site_url('login/sina')?>"></a>
	</h1>
</div>
<?php  }?>
<div id="main" class="main-full">
<ul class="tabs">
<li class="<?php echo $seach_active_tag=='item'?'active':'' ?>">
<a href="<?=site_url('item/search?keyword='.$input_str);?>"><?= $this->lang->line('tab_item'); ?></a>
</li>
<li class="<?php echo $seach_active_tag=='group'?'active':'' ?>">
<a href="<?=site_url('group/search?keyword='.$input_str);?>"><?= $this->lang->line('tab_group'); ?></a>
</li>
<li class="<?php echo $seach_active_tag=='topic'?'active':'' ?>">
<a href="<?=site_url('topic/search?keyword='.$input_str);?>"><?= $this->lang->line('tab_topic'); ?></a>
</li>
<li class="<?php echo $seach_active_tag=='task'?'active':'' ?>">
<a href="<?=site_url('task/search?keyword='.$input_str);?>"><?= $this->lang->line('tab_task'); ?></a>
</li>
<li class="<?php echo $seach_active_tag=='tool'?'active':'' ?>">
<a href="<?=site_url('tool/search?keyword='.$input_str);?>"><?= $this->lang->line('tab_tools'); ?></a>
</li>
</ul>
</div>
<div class="secondary">
	

<a href="#options" id="options-toggle" class="">
	<img alt="Icon-search-expanded-2x" src="/images/icon-search-expanded-2x.png?1376311488" width="16">
</a>


	<div class="what-is-pro-search">
		<h3><?= $this->lang->line('globalsearch_authors'); ?></h3>

		<form name="author_search_form" class="gen-form" action="<?=site_url('author/authorSearch')?>" method="post" onkeydown="if(event.keyCode==13){document.author_search_form.submit();}">
                    <div id='main-search' class='clearfix'>
                       <div id='main-search-box' class='clearfix'>
                           <fieldset>
                           <input type="text" style="background: rgba(255, 255, 255, 1);" id='particle_search_field' name="search" onblur="if (this.value == '') {this.value = 'Search author';}" onfocus="if (this.value == 'Search author') {this.value = '';}" value="Search author" x-webkit-speech="" speech="">
                       		</fieldset>
                       </div>
                    </div>
                  </form>
	</div>
	<h3><?= $this->lang->line('globalsearch_pop'); ?></h3>
	<div class="group-list">
   <ul>
	<a href="<?=site_url('item/search?keyword=fire')?>" class="tagsbutton" style="color:#999;margin-right:5px;">fire</a>
	<a href="<?=site_url('item/search?keyword=light')?>" class="tagsbutton" style="color:#999;margin-right:5px;">light</a>
	<a href="<?=site_url('item/search?keyword=rain')?>" class="tagsbutton" style="color:#999;margin-right:5px;">rain</a>
	<a href="<?=site_url('item/search?keyword=fog')?>" class="tagsbutton" style="color:#999;margin-right:5px;">fog</a>
	<a href="<?=site_url('item/search?keyword=wind')?>" class="tagsbutton" style="color:#999;margin-right:5px;">wind</a>
	<a href="<?=site_url('item/search?keyword=smoke')?>" class="tagsbutton" style="color:#999;margin-right:5px;">smoke</a>
	<a href="<?=site_url('item/search?keyword=water')?>" class="tagsbutton" style="color:#999;margin-right:5px;">water</a>
	<a href="<?=site_url('item/search?keyword=snow')?>" class="tagsbutton" style="color:#999;margin-right:5px;">snow</a>
	<a href="<?=site_url('item/search?keyword=explosion')?>" class="tagsbutton" style="color:#999;margin-right:5px;">explosion</a>
	<a href="<?=site_url('item/search?keyword=electricity')?>" class="tagsbutton" style="color:#999;margin-right:5px;">electricity</a>
	<a href="<?=site_url('item/search?keyword=star')?>" class="tagsbutton" style="color:#999;margin-right:5px;">star</a>
	<a href="<?=site_url('item/search?keyword=bubble')?>" class="tagsbutton" style="color:#999;margin-right:5px;">bubble</a>
	<a href="<?=site_url('item/search?keyword=dust')?>" class="tagsbutton" style="color:#999;margin-right:5px;">dust</a>
	<a href="<?=site_url('item/search?keyword=storm')?>" class="tagsbutton" style="color:#999;margin-right:5px;">storm</a>
	<a href="<?=site_url('item/search?keyword=wave')?>" class="tagsbutton" style="color:#999;margin-right:5px;">wave</a>
	<a href="<?=site_url('item/search?keyword=glow')?>" class="tagsbutton" style="color:#999;margin-right:5px;">glow</a>
	<a href="<?=site_url('item/search?keyword=trail')?>" class="tagsbutton" style="color:#999;margin-right:5px;">trail</a>
	<a href="<?=site_url('item/search?keyword=portal')?>" class="tagsbutton" style="color:#999;margin-right:5px;">portal</a>
	<a href="<?=site_url('item/search?keyword=laser')?>" class="tagsbutton" style="color:#999;margin-right:5px;">laser</a>
	<a href="<?=site_url('item/search?keyword=sunshine')?>" class="tagsbutton" style="color:#999;margin-right:5px;">sunshine</a>
	<a href="<?=site_url('item/search?keyword=fractal')?>" class="tagsbutton" style="color:#999;margin-right:5px;">fractal</a>
   </ul></div>
</div>

<div id="main" class="main-search">
	<div class="results-pane" style="opacity: 1;">
	<h2><?= $this->lang->line('globalsearch_result'); ?>"<?php echo $input_str;?>"</h2>
<ol class="group-cards">
	<?php foreach($results as $_result): ?>
                   <div class='commentitem' style='border-bottom: 1px solid #CDCDCD;padding-bottom:15px;padding-top:15px;'>
                            <div class="commentimg">
                            	<?php if($seach_active_tag=='item' || $seach_active_tag=='tool' ) {?>
                                <a target="_blank" href="<?=site_url($seach_active_tag.'/'.$_result['id'])?>">
                                	<img src='<?php echo $_result['thumb_url']==null?$_result['pic_url']:$_result['thumb_url']; ?>' style='width:60px;height:60px;'>
                                </a>
                                <?php } ?>
                                <?php if($seach_active_tag=='group') {?>
                                <a target="_blank" href="<?=site_url($seach_active_tag.'/'.$_result['id'])?>">
                                	<img src='<?php echo $_result['group_pic']; ?>' style='width:60px;height:60px;'>
                                </a>
                                <?php } ?>
                            </div>
                            <div>
                            	<?php if($seach_active_tag=='group') {?>
	                                <div class='paragraphstyle'>                                	
	                                	<a target="_blank" href="<?=site_url($seach_active_tag.'/'.$_result['id'])?>">                                		
				                            <b>
	                                			<?php echo $_result['group_name']; ?>
	                                		</b>                                		
	                                	</a> 
	                                </div>
	                                <div class="commenttext" style='margin-top:21px;margin-left:90px'>
	                                	<?php echo $_result['group_desc']; ?>
	                                </div>
	                            <?php }elseif($seach_active_tag=='topic') {?>
	                                <div class='paragraphstyle' style='margin-top:21px;margin-left:10px'>                                	
	                                	<a target="_blank" href="<?=site_url($seach_active_tag.'/'.$_result['id'])?>">                                		
				                            <b>
	                                			<?php echo $_result['topic_title']; ?>
	                                		</b>                                		
	                                	</a> 
	                                </div>	                                
	                            <?php }elseif($seach_active_tag=='tool') {?>
	                                <div class='paragraphstyle'>                                	
	                                	<a target="_blank" href="<?=site_url($seach_active_tag.'/'.$_result['id'])?>">                                		
				                            <b>
	                                			<?php echo $_result['name']; ?>
	                                		</b>                                		
	                                	</a> 
	                                </div>
	                                <div class="commenttext" style='margin-top:21px;margin-left:90px'>
	                                	<?php echo $_result['desc']; ?>
	                                </div>
                                <?php } else {?>
                                	<div class='paragraphstyle' style='margin-top:21px;margin-left:10px'>                                	
	                                	<a target="_blank" href="<?=site_url($seach_active_tag.'/'.$_result['id'])?>">                                		
				                            <b>
	                                			<?php echo $_result['title']; ?>
	                                		</b>                                		
	                                	</a> 
	                                </div>
	                                <div class="commenttext" style='margin-top:21px;margin-left:10px'>
	                                	<?php echo $_result['desc']; ?>
	                                </div>
                                <?php }?>
                            </div>
                   </div>    
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
