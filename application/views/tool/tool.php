<?php $this->load->view('header') ?>
<style>
.meta {
	font-size:12px;
}
</style>
<div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png?1376325170" width="15">
	</a>
</div>

<div class="full">
	<div class="group">
		<h1 class="alt"><img src="<?php echo $tool['thumb_url']; ?>" class="group-img"><?php echo $tool['name']; ?></h1>
		<div style="margin-top:5px;"><a href="<?php echo site_url('tool/featured/MostAppreciated/'.$tool['type_link'])?>" title="tool type"><?php echo $tool['type_name']; ?></a></div>
	</div>
	
</div>



<div id="main">

<div id="idtabs"> 
  <div class="apps-type"> 	
	<ul class="tabs">
		<li><a href="#about" class="selected"><?= $this->lang->line('tool_about'); ?></a></li>
		<li><a href="#demo"><?= $this->lang->line('tool_top_demos'); ?></a></li>
		<li><a href="#showcase"><?= $this->lang->line('tool_top_showcases'); ?></a></li>
		<li><a href="#topic"><?= $this->lang->line('tool_recent_topics'); ?></a></li>
		<li><a href="#related"><?= $this->lang->line('tool_related_tools'); ?></a></li>
		
<div style="float:right;padding-bottom:10px">
<?php if (($this->session->userdata('id')&&$this->session->userdata('id')==$tool['admin_id'])||$this->session->userdata('id')=='1000001'){  ?>
<a class="form-sub tagline-action" href="<?php echo site_url('tool/edit/'.$tool['id'])?>"><?= $this->lang->line('tool_edit'); ?></a>
<a class="form-sub tagline-action" href="<?php echo site_url('tool/addlink/'.$tool['id'])?>"><?= $this->lang->line('tool_add_link'); ?></a>
<?php  }?>
	<?php if ($isin!=null&&$isin>0){  ?>
		<?php if ($tool['admin_id'] == $this->session->userdata('id')) {?>
			<a class="form-sub tagline-action" onclick='alert("You are administrator of the group. You can not quit now. ");' href="javascript:"><?= $this->lang->line('tool_quit_group'); ?></a>
		<?php } else {?>
			<a class="form-sub tagline-action" href="<?php echo site_url('group/quit/'.$tool['group_id'])?>"><?= $this->lang->line('tool_quit_group'); ?></a>
		<?php }?>
	
	<?php  }else{?>
	<a class="form-sub tagline-action" href="<?php echo site_url('group/join/'.$tool['group_id'])?>"><?= $this->lang->line('tool_join_group'); ?></a>
	<?php  }?>

<?php if ($tool['github_url']!=null&&$tool['github_url']!=''){  ?>
<a target="_blank" class="form-sub tagline-action" href="<?php echo $tool['github_url']?>">Fork</a>	
<?php  }?>
</div>
	</ul>
	
	</div>

	<div class="site" id="about">
		<div class="col-about col-about-full under-hero">
			<h1 class="about"><?= $this->lang->line('tool_about'); ?> <?php echo $tool['name']; ?></h1>
			<p class="callout">
		
		    <p><?php echo auto_link($tool['desc'], 'both', TRUE); ?></p>
		</div>
		    
		<div class="col-about col-about-full under-hero">
			<h1 class="about"><?= $this->lang->line('tool_useful_link'); ?></h1>
			<p class="callout">
		
		      <?php foreach($urls as $_url): ?>
		      <p><?php echo $_url['desc']; ?></p>
		    <a id="free-download" class="form-sub" target="_blank" href="<?=site_url('download/software/'.$_url['key'])?>"><?php echo $_url['title']; ?></a>
		    <?php if (($this->session->userdata('id')&&$this->session->userdata('id')==$tool['admin_id'])||$this->session->userdata('id')=='1000001'){  ?>
		    <a href="<?=site_url('tool/editlink/'.$_url['id'])?>"><?= $this->lang->line('tool_edit'); ?></a>
		    <?php  }?>
		    <br /><br />
		    <?php endforeach; ?>
		 </div>
		
	</div>
	
	<div class="" id="demo">
		<h3 class="more-from more-from-player"><?= $this->lang->line('tool_top_demos'); ?> <span class="meta">
		 <a href="<?=site_url('item/demo/'.$tool['domain'].'')?>"><?= $this->lang->line('tool_more'); ?></a></span>
		 &nbsp;&nbsp;
		 <?php if ($this->session->userdata('id')){  ?>
	<a href="<?php echo site_url('item/submitdemo/'.$tool['id'])?>"><?= $this->lang->line('tool_submit_demo'); ?></a>
	<?php  }else{?>
	<a rel="leanModal" type="button" name="login" href="#login"><?= $this->lang->line('tool_submit_demo'); ?></a>
	<?php  }?>
		 </h3>
			<br/>
			<ol class="effecthubs group">
	<?php foreach($hot_item_list as $_item): ?>
                   
                   <li id="work-<?php echo $_item['id']; ?>" class="group ">
	    <div class="effecthub">
	      <div class="effecthub-shot">
	        <div class="effecthub-img">
	          <a href="<?=site_url('item/'.$_item['id']).'?tool='.$tool['id']?>" class="effecthub-link"><div data-picture="" data-alt="<?php echo $_item['title']; ?>">
  <?php if($_item['thumb_url']!=null||$_item['pic_url']!=null){ ?>
  	<span class="item_image_wrap" alt="<?php echo $_item['title']; ?>">
                        <span class="item_image" style="background-image:url(<?php echo $_item['thumb_url']; ?>)"></span>
  </span>
  <?php  }else{?>
  	<iframe src="<?=site_url('item/preview_html/'.$_item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 300px; height: 200px;padding:0px;margin:0px;"></iframe>
  <?php  }?>	
  </div></a>
	          <a href="<?=site_url('item/'.$_item['id']).'?tool='.$tool['id']?>" class="effecthub-over" style="opacity: 0;">		<strong><?php echo $_item['type_name']; ?> - <?php echo $_item['title']; ?></strong>
	            <span class="comment"><?php echo msubstr(auto_link($_item['desc'], 'both', TRUE),0,200); ?></span>
	            
	            <em class="timestamp"></em>
  </a></div>
	        <ul class="tools group" style="visibility: visible;">
	          <li class="fav">
	            <a href="<?=site_url('item/'.$_item['id']).'?tool='.$tool['id']?>" title="See fans of this work"><?php echo $_item['fav_num']; ?></a>
	            </li>
	          <li class="cmnt">
	            <a href="<?=site_url('item/'.$_item['id']).'?tool='.$tool['id']?>#comments" title="View comments on this work"><?php echo $_item['comment_num']; ?></a>
	            </li>
	          <li class="views"><?php echo $_item['view_num']; ?></li>
  </ul>
	        
	        </div>
	      <div class="extras">
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
	</div>
	
	<div class="" id="showcase">
	<h3 class="more-from more-from-player"><?= $this->lang->line('tool_top_showcases'); ?> <span class="meta">
		 <a href="<?=site_url('item/showcase/'.$tool['domain'].'')?>"><?= $this->lang->line('tool_more'); ?></a></span>
		 
		 &nbsp;&nbsp;
		 <?php if ($this->session->userdata('id')){  ?>
	<a href="<?php echo site_url('item/submitshowcase/'.$tool['id'])?>"><?= $this->lang->line('tool_submit_showcase'); ?></a>
	<?php  }else{?>
	<a rel="leanModal" type="button" name="login" href="#login"><?= $this->lang->line('tool_submit_showcase'); ?></a>
	<?php  }?>
		 </h3>
		 <br/>
		 <ol class="effecthubs group">
	<?php foreach($hot_showcase_list as $_item): ?>
                   
                   <li id="work-<?php echo $_item['id']; ?>" class="group ">
	    <div class="effecthub">
	      <div class="effecthub-shot">
	        <div class="effecthub-img">
	          <a href="<?=site_url('item/'.$_item['id']).'?tool='.$tool['id']?>" class="effecthub-link"><div data-picture="" data-alt="<?php echo $_item['title']; ?>">
  <?php if($_item['thumb_url']!=null||$_item['pic_url']!=null){ ?>
  	<span class="item_image_wrap" alt="<?php echo $_item['title']; ?>">
                        <span class="item_image" style="background-image:url(<?php echo $_item['thumb_url']; ?>)"></span>
  </span>
  <?php  }else{?>
  	<iframe src="<?=site_url('item/preview_html/'.$_item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 300px; height: 200px;padding:0px;margin:0px;"></iframe>
  <?php  }?>	
  </div></a>
	          <a href="<?=site_url('item/'.$_item['id']).'?tool='.$tool['id']?>" class="effecthub-over" style="opacity: 0;">		<strong><?php echo $_item['type_name']; ?> - <?php echo $_item['title']; ?></strong>
	            <span class="comment"><?php echo msubstr(auto_link($_item['desc'], 'both', TRUE),0,200); ?></span>
	            
	            <em class="timestamp"></em>
  </a></div>
	        <ul class="tools group" style="visibility: visible;">
	          <li class="fav">
	            <a href="<?=site_url('item/'.$_item['id']).'?tool='.$tool['id']?>" title="See fans of this work"><?php echo $_item['fav_num']; ?></a>
	            </li>
	          <li class="cmnt">
	            <a href="<?=site_url('item/'.$_item['id']).'?tool='.$tool['id']?>#comments" title="View comments on this work"><?php echo $_item['comment_num']; ?></a>
	            </li>
	          <li class="views"><?php echo $_item['view_num']; ?></li>
  </ul>
	        
	        </div>
	      <div class="extras">
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
	</div>
	
	<div class="" id="topic">
		<h3><?= $this->lang->line('tool_recent_topics'); ?> <span class="meta"><a href="<?=site_url('group/'.$tool['group_id'])?>"><?= $this->lang->line('tool_more'); ?></a></span>
		&nbsp;&nbsp;
		<?php if ($this->session->userdata('id')){  ?>
	<a href="<?php echo site_url('topic/create/'.$tool['group_id'])?>"><?= $this->lang->line('tool_submit_topic'); ?></a>
	<?php  }else{?>
	<a rel="leanModal" type="button" name="login" href="#login"><?= $this->lang->line('tool_submit_topic'); ?></a>
	<?php  }?>
		</h3>
			<br/>
			<div class="group-list">
		                       <ul>
		<?php foreach($topic_list as $_topic): ?>
		 <li>
		  <div style="width:40px;float:left;text-align:center;margin-right:8px;">
		<div style="width:30px;font-size:14px;background:#bbb; display:inline; padding:2px 8px; color:#fff;"> <?php echo $_topic['comment_num']; ?>
		</div>
		</div>
		 <a href="<?php echo site_url('topic/'.$_topic['id'])?>" target="_blank" style="color:#aaa"><?php echo $_topic['topic_title']; ?></a></li>
		<?php endforeach; ?>
		 </ul></div>
	</div>
	
	<div class="" id="related">
		<h3><?= $this->lang->line('tool_related_tools'); ?> <span class="meta">
		<a href="<?php echo site_url('tool/featured/MostAppreciated/'.$tool['type_name'])?>"><?= $this->lang->line('tool_more'); ?></a>
		</span></h3>
			<br/>
			<div class="group-list">
		                       <ul>
		<?php foreach($hot_tools as $_group): ?>
		 <li style="width:33%;float:left">
		<a href="<?php echo site_url('t/'.$_group['domain'])?>"><img src="<?php echo $_group['pic_url']; ?>" class="group-img"></a>
		<p>
		<a href="<?php echo site_url('t/'.$_group['domain'])?>" class="group-title"><?php echo $_group['name']; ?></a>
		 <br><span class="group-count"><?php echo $_group['fav_num']; ?> <?= $this->lang->line('tool_members'); ?><br><?php echo $_group['comment_num']; ?> <?= $this->lang->line('tool_topics'); ?></span>
		</p>
		 
		
		 </li>
		<?php endforeach; ?>
		 </ul></div>
	</div>

</div>
    
</div>


<div class="secondary">
<?php if ($tool['donate']){  ?>
<h3 class="more-from more-from-player"><?= $this->lang->line('tool_donate'); ?><span class="meta"></span></h3>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?php echo $tool['donate']; ?>">
<input type="hidden" name="item_name" value="<?php echo $tool['name']; ?>">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="amount" value="">
<input type="hidden" name="return" value="<?php echo site_url('t/'.$tool['domain'])?>">
<input type="hidden" name="cancel_return" value="<?php echo site_url('t/'.$tool['domain'])?>">
<input type="hidden" name="image_url" value="<?php echo $tool['pic_url']; ?>">
<input type="hidden" name="cbt" value="Return to <?php echo $tool['name']; ?> to Request Your Rewards">

</form><br/>
<?php  }?>
<?php if ($tool['online_install']){  ?>
<h3 class="more-from more-from-player"><?= $this->lang->line('tool_online_install'); ?><span class="meta"></span></h3>
<p class="info">
<iframe src="<?php echo $tool['online_install']; ?>" frameborder="0" scrolling="no" width="215" height="180"></iframe>
</p>
<?php  }?>
<!--
<?php if ($group){  ?>
<h3 class="more-from more-from-player"><?= $this->lang->line('tool_group'); ?><span class="meta"></span></h3>
	<ol class="prevnext group" style="margin-top:25px">
	<li>
		<a title="<?php echo $group['group_name']; ?>" href="<?=site_url('g/'.$group['key'])?>">
		<?php if($group['group_pic']!=null||$group['group_pic']!=null){ ?>
  <img width="60px" height="60px" alt="<?php echo $group['group_name']; ?>" src="<?php echo $group['group_pic']; ?>">
  <?php  }?>
		</a>
           
</ol>
<?php  }?>
-->
<?php if ($tool['parent_id']>0){  ?>
<h3 class="more-from more-from-player"><?= $this->lang->line('tool_parent_tool'); ?><span class="meta"></span></h3>
	<ol class="prevnext group" style="margin-top:25px">
	<li>
		<a title="<?php echo $parent['name']; ?>" href="<?=site_url('t/'.$parent['domain'])?>">
		<?php if($parent['thumb_url']!=null||$parent['pic_url']!=null){ ?>
  <img width="60px" height="60px" alt="<?php echo $parent['name']; ?>" src="<?php echo $parent['thumb_url']; ?>">
  <?php  }?>
		</a>
           
</ol>
<?php  }?>
<?php if (count($subtool_list)>0){  ?>
<h3 class="more-from more-from-player"><span class="meta"><?php echo count($subtool_list); ?></span> <?= $this->lang->line('tool_sub_tools'); ?> </h3>
	<ol class="prevnext group" style="margin-top:25px">
	<?php foreach($subtool_list as $_hot_item): ?>
                        <li>
		<a title="<?php echo $_hot_item['name']; ?>" href="<?=site_url('t/'.$_hot_item['domain'])?>"><img style="width:60px;height:60px" src="<?php echo $_hot_item['thumb_url']==null?$_hot_item['pic_url']:$_hot_item['thumb_url']; ?>"></a>
                        <?php endforeach; ?>
</ol>
<?php  }?>
<h3><?= $this->lang->line('tool_submitter'); ?> <span class="meta"></span></h3>
<div style="line-height:15px;font-size:14px">

<a href="<?=site_url('user/'.$tool['author_id'])?>"><?php echo $tool['author_name']; ?></a> <?= $this->lang->line('tool_submitted_at'); ?> <span class='group-count'><?= $tool['create_date']; ?></span>

 </div>
 <br/><br/>
 <h3><?= $this->lang->line('tool_recent_members'); ?> <span class="meta"></span></h3>
                   <div>
<?php foreach($group_user_list as $_group_user): ?>
 <a href="<?php echo site_url('user/'.$_group_user['user_id']).'/'?>" style="margin:2px"><img height="30px" width="30px" title="<?php echo $_group_user['user_name']; ?>" src="<?php echo $_group_user['user_pic']; ?>" alt="<?php echo $_group_user['user_name']; ?>"></a>
<?php endforeach; ?>
 </div>
 <br/><br/>
 
 
 <br/><br/>

 
</div>



</div>


<div id="login" class="pop">
        
				<div id="register-header" class="pop-header">
					<h2><?= $this->lang->line('pop_title_join'); ?></h2>
				</div>
        <div id="idtabs1"> 
  <div class="apps-type"> 	
<ul class="tabs">
	<li style="margin:20px 0 0 20px"><a href="#login-ct" style="color:#000"><?= $this->lang->line('pop_login'); ?></a></li>
	<li style="margin:20px 0 0 20px"><a href="#register-ct" class="selected" style="color:#000"><?= $this->lang->line('pop_sign_up'); ?></a></li>
</ul>
</div>

	<div id="login-ct">
	<div class="txt-fld" style="padding:0px 20px 35px 20px">
				    <a class="addthis_login_twitter" title="<?= $this->lang->line('pop_login_twitter'); ?>" href="<?=site_url('login/twitter')?>"><span id="twitter-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_facebook" title="<?= $this->lang->line('pop_login_facebook'); ?>" href="<?=site_url('login/facebook')?>"><span id="facebook-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_google" title="<?= $this->lang->line('pop_login_google'); ?>" href="<?=site_url('login/google')?>"><span id="google-connect" class="ssi-button"></span></a>
						            
				  </div>
				  <br/>
				<span style="margin-left:20px;color:#333"><?= $this->lang->line('pop_login_email_title'); ?></span>
				<form action="<?=site_url('login/check')?>" method="post">
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('pop_login_email'); ?></label>
				    <input id="" name="email" type="text"/>

				  </div>
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('pop_login_password'); ?></label>
				    <input id="" name="password" type="password"/>
				  </div>
				  
				  <div class="btn-fld" style="padding-left:20px;padding-right:20px;width:350px;vertical-align:center">
					  <label for="remember_me" style="display:inline;color:#000"><?= $this->lang->line('pop_remember'); ?>
				    <input type="checkbox" checked name="remember_me" id="remember_me"/></label>
					    <input class="save-btn" name="commit" type="submit" value="<?= $this->lang->line('pop_login'); ?>">
					   <!-- <a style="float:right;margin-top:10px;margin-right:10px;" target="_blank" href="<?=site_url('register')?>">Sign Up &raquo;</a>&nbsp;&nbsp;&nbsp;&nbsp;-->
					</div>
					<input type="hidden" name="redirectURL" value="<?=site_url('t/'.$tool['domain'])?>"/>
					</form>
				</div>


	<div id="register-ct">
	<div class="txt-fld" style="padding:0px 20px 35px 20px">
				    <a class="addthis_login_twitter" title="<?= $this->lang->line('pop_sign_up_twitter'); ?>" href="<?=site_url('login/twitter')?>"><span id="twitter-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_facebook" title="<?= $this->lang->line('pop_sign_up_facebook'); ?>" href="<?=site_url('login/facebook')?>"><span id="facebook-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_google" title="<?= $this->lang->line('pop_sign_up_google'); ?>" href="<?=site_url('login/google')?>"><span id="google-connect" class="ssi-button"></span></a>
						            
				  </div>
				  <br/>
				<span style="margin-left:20px;color:#333"><?= $this->lang->line('pop_sign_up_email_title'); ?></span>
				<form id="signin_form" action="<?=site_url('register/save')?>" method="post">
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('pop_sign_up_email'); ?></label>
				    <input id="email_address" name="email_address" type="text" value=""/>
<span id="emailError" class="formErrorContent drop-shadow"><?= $this->lang->line('pop_email_error'); ?></span>
				  </div>
				  <div class="txt-fld">
				    <label for=""><?= $this->lang->line('pop_sign_up_password'); ?></label>
				    <input id="password" name="password" type="password" value=""/>
				    <span id="passwordError" class="formErrorContent drop-shadow"><?= $this->lang->line('pop_password_error'); ?></span>
				  </div>
				  
				  <div class="btn-fld" style="padding-left:20px;padding-right:20px;width:350px;vertical-align:center">
					  <label for="remember_me" style="display:inline;color:#000"><?= $this->lang->line('pop_sign_up_stay_informed'); ?>
				    <input type="checkbox" checked name="consent" id="consent"/></label>
					    <input class="save-btn" name="commit" type="button" value="<?= $this->lang->line('pop_sign_up_free'); ?>" onclick="checksignup();_gaq.push(['_trackEvent', 'signup', 'clicked', 'Click Sign Up Button In task Page'])">
					</div>
					<input type="hidden" name="redirectURL" value="<?=site_url('t/'.$tool['domain'])?>"/>
					</form>
				</div>	

</div>
<script type="text/javascript"> 
  $("#idtabs div").idTabs();   
</script>
<script type="text/javascript"> 
  $("#idtabs1 div").idTabs();   
  $("#login").hide();
</script>

		</div>
		
		<script type="text/javascript">
			$(function() {
    			$('a[rel*=leanModal]').leanModal({ top : 150, closeButton: ".modal_close" });
			});
		</script>
<?php $this->load->view('footer') ?>
