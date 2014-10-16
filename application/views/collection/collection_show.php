<?php $this->load->view('header') ?>
<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="<?=base_url()?>js/jquery.leanModal.min.js"></script>
<div id="content" class="group">


<div class="profile-actions group">
	<ul class="profile-tabs">
		<li>
			<span class="count"><?php echo $collection['view_num']; ?></span>
			<span class="meta"><?= $this->lang->line('collectionshow_views'); ?></span>
		</li>
		
		<li>
			<span class="count" id="collectlike"><?php echo $collection['like_num']; ?></span>
			<span class="meta"><?= $this->lang->line('collectionshow_likes'); ?></span>
		</li>
		
		<li>
			<span class="count"><?php echo $collection['comment_num']; ?></span>
			<span class="meta"><?= $this->lang->line('collectionshow_comments'); ?></span>
		</li>
			
	</ul>
</div>


<div class="full">
	<div class="profile vcard group ">
		<img alt="<?php echo $collection['title']; ?>" class="photo" src="<?php echo $collection['pic_url']; ?>">
		<h1><?= $this->lang->line('collectionshow_collection'); ?> <?php echo $collection['title']; ?></h1>
		<p class="ctime"><a href="<?php echo site_url('user/'.$user['id'])?>"><?php echo $user['displayName']?></a> <?= $this->lang->line('collectionshow_created_at'); ?> <?php echo tranTime(strtotime($collection['create_date'])); ?></p>
		<?php if (!empty($collection['description'])) {?>
		<p class="description">
			<?= $this->lang->line('collectionshow_description'); ?> <?php echo $collection['description']?>
		</p>
		<?php }?>
	</div>

</div>

<div id="main">
	
	<ul class="tabs collection">
		<li class="c-num">
				<span class="c-count"><?php echo $collection['works_num']; ?></span>
				<span><?= $this->lang->line('collectionexplore_collect'); ?></span>
		</li>


		<?php if (($this->session->userdata('id')!='')&&($this->session->userdata('id')!='null')) {?>
		<?php if ($this->session->userdata('id')==$collection['author_id']) {?>
		<li>
			<a href="<?=site_url('collection/edit/'.$collection['id'])?>"><?= $this->lang->line('collectionshow_edit'); ?></a>
		</li>
		<li>
			<a href="<?= site_url('collection/delete_collection/'.$collection['id'])?>" onclick="return confirm('<?= $this->lang->line("collectionshow_delete_slogan"); ?>')"><?= $this->lang->line('collectionshow_delete'); ?></a>
		</li>
		<?php }?>
		<li style="display:<?php echo $this->session->userdata('id')==$collection['author_id']?'none':'block';?>">
			<?php if ($like==null) {?>
			<a href="javascript:" id="likecollect" name="<?php echo $collection['id']?>" href=""><?= $this->lang->line('collectionshow_like'); ?></a>
			<input type="hidden" id="like" value="0" />
			<?php } else {?>
			<a href="javascript:" id="likecollect" name="<?php echo $collection['id']?>" href=""><?= $this->lang->line('collectionshow_unlike'); ?></a>
			<input type="hidden" id="like" value="1" />
			<?php }?>
		</li>
		<script type="text/javascript">
		$('#likecollect').click(function() {  	
			var itemID = $(this).attr('name');
			
			if ($('#like').val() == 0) {

				$.ajax({
					type:"GET"
		        	,url:"http://www.effecthub.com/collection/like/" + itemID
					,contentType:'text/html;charset=utf-8'//编码格式   
					,success:function(data){
						$('#likecollect').html('<?= $this->lang->line('collectionshow_unlike'); ?>');
					}//请求成功后 

					,error:function(data){  
						$('#likecollect').html('<?= $this->lang->line('collectionshow_like_fail'); ?>'); 
					}//请求错误  
				});	
			} else {
				$.ajax({
					type:"GET"
		        	,url:"http://www.effecthub.com/collection/unlike/" + itemID
					,contentType:'text/html;charset=utf-8'//编码格式   
					,success:function(data){
						$('#likecollect').html('<?= $this->lang->line('collectionshow_like'); ?>');
					}//请求成功后  

					,error:function(data){  
						$('#likecollect').html('<?= $this->lang->line('collectionshow_unlike_fail'); ?>.'); 
					}//请求错误  
				});	
			}
		}); 	
		</script>
	
		<?php }?>	
	
	</ul>
	

		<ol class="effecthubs group">
		<?php foreach($items as $_user_item): ?>
		
		<li id="screenshot-1085677" class="group">
	<div class="effecthub">
		<div class="effecthub-shot">
			<div class="effecthub-img">
	<a href="<?=site_url('item/'.$_user_item['id'])?>" class="effecthub-link"><div data-picture="" data-alt="<?php echo $_user_item['title']; ?>">
	<?php if($_user_item['thumb_url']!=null||$_user_item['pic_url']!=null){ ?>
  <img width="220px" height="145px" alt="<?php echo $_user_item['title']; ?>" src="<?php echo $_user_item['thumb_url']; ?>">
  <?php  }else{?>
  	<iframe src="<?=site_url('item/preview_html/'.$_user_item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 300px; height: 200px;padding:0px;margin:0px;"></iframe>
  <?php  }?>
</div></a>
	<a href="<?=site_url('item/'.$_user_item['id'])?>" class="effecthub-over" style="opacity: 0;">		<strong><?php echo $_user_item['title']; ?></strong>
		<span class="comment"><?php echo msubstr($_user_item['desc'],0,100).'...'; ?></span>

		<em class="timestamp">added at <?php echo $_user_item['add_time']; ?></em>
</a></div>
		
			<ul class="tools group" style="visibility: visible;">
	<li style="display:<?php echo $this->session->userdata('id')==$collection['author_id']?'block':'none'; ?>">
		<a href="<?= site_url('collection/delete/'.$_user_item['id'].'/'.$collection['id'])?>" title="<?= $this->lang->line('collectionshow_delete_single'); ?>" onclick="return confirm('<?= $this->lang->line('collectionshow_delete_single_slogan'); ?>')"><img src="<?= base_url()?>images/icon-delete.png" height="16px" width="16px"/></a>
	</li>
	<?php if ($this->session->userdata('id')!=$collection['author_id']) {?>
	<li class="fav">
		<a href="<?=site_url('item/'.$_user_item['id'])?>" title="<?= $this->lang->line('work_likes'); ?>"><?php echo $_user_item['fav_num']; ?></a>
	</li>
	<li class="cmnt">
		<a href="<?=site_url('item/'.$_user_item['id'])?>#comments" title="<?= $this->lang->line('work_comments'); ?>"><?php echo $_user_item['comment_num']; ?></a>
	</li>
	<li class="views"><?php echo $_user_item['view_num']; ?></li>
	<?php }?>
	
</ul>

		</div>
		<div class="extras">
	      <?php if($_user_item['parent_id']!=0&&$_user_item['parent_id']!=null){ ?>
				<a href="<?=site_url('item/'.$_user_item['parent_id'])?>" style="display: inline;"><span rel="tipsy" class="rebound-mark is-rebound" style="display: inline;" original-title="<?= $this->lang->line('work_fork'); ?>">
					<img alt="Rebound" height="16" src="<?=base_url()?>images/icon-rebound-2x.png" width="16">
				</span></a>
				<?php  }?>
				<?php if($_user_item['platform']>0){ ?>
     			<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_platform_first'); ?> <?php echo $_user_item['platform_name']; ?> <?= $this->lang->line('work_platform'); ?>">
				<img alt="Attachments" height="16" src="<?php echo $_user_item['platform_pic']; ?>" width="16">
				</span>
				<?php  }?>
				<?php if($_user_item['tool']>0){ ?>
     			<a target="_blank" href="<?=site_url('t/'.$_user_item['tool_domain'])?>" style="display: inline;">
     			<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_tool_first'); ?> <?php echo $_user_item['tool_name']; ?><?= $this->lang->line('work_tool'); ?>">
				<img alt="Attachments" height="16" src="<?php echo $_user_item['tool_pic']; ?>" width="16">
				</span>
				</a>
				<?php  }?>
				<?php if($_user_item['from']=='htmleditor'){ ?>
     			<a href="<?=site_url('item/fork/'.$_user_item['id'])?>" style="display: inline;"><span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_html'); ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/code.png" width="16">
				</span></a>
				<?php  }?>
				<?php if($_user_item['from']=='aseditor'){ ?>
     			<a href="<?=site_url('item/fork/'.$_user_item['id'])?>" style="display: inline;"><span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_actionscript'); ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/code.png" width="16">
				</span></a>
				<?php  }?>
				<?php if($_user_item['is_private']>0){ ?>
     			<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_private'); ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/icon-lock.png" width="16">
				</span>
				<?php  }?>
				<?php if($_user_item['contest_id']==0&&$_user_item['is_private']==0&&($_user_item['download_url']!=0||$_user_item['download_url']!=null)){ ?>
     			<a target="_blank" href="<?=site_url('item/download/'.$_user_item['id'])?>" style="display: inline;"><span rel="tipsy" class="attachments-mark" style="display: inline;" original-title="<?= $this->lang->line('work_download'); ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/icon-attach-16-2x.png" width="16"></a>
			</span>
			<?php  }?>
		</div>
	</div>

	<h2>
		<span class="attribution-user">
			<a href="<?=site_url('user/'.$_user_item['author_id'])?>" class="url" rel="contact" title="<?php echo $_user_item['author_name']; ?>"><img alt="<?php echo $_user_item['author_name']; ?>" class="photo" src="<?php echo $_user_item['author_pic']; ?>"> <?php echo $_user_item['author_name']; ?></a>
			
		</span>
	</h2>
</li>
		<?php endforeach; ?>

	</ol>

	
	<div class="page">
		<?php echo $this->pagination->create_links();?>
	</div>

	<div id="comments-section">
	
	<div  style="padding-bottom:20px;border-bottom:1px #555 solid;margin-bottom:20px">
	<?php if ($this->session->userdata('id')){  ?>
		<div id="signin_form" class="gen-form">
			<textarea id="contentarea" name="content" class="comment-content"  style="height: 80px; width:99%;background:rgba(255, 255, 255, 1);margin-bottom:15px;" /></textarea>
			<input type="hidden" value="0" name="parentid" id="parentid">
			<a style="cursor:pointer;" id="c-comment" class="form-sub" name="<?php echo $collection['id']; ?>"><?= $this->lang->line('collectionshow_post_comment'); ?></a>
        </div>
        
        <script>
        $('#c-comment').click(function(){ 
     	   var collectID = $(this).attr('name');
     	   var commentcontent = $('#contentarea').attr("value");
     	   var parentid = $('#parentid').attr("value");
     	   $.ajax({  
                type:"GET" 
                ,url:"http://www.effecthub.com/collection/savecomment"  
                ,data:{collect_id:collectID,content:commentcontent,parent_id:parentid}                              
                ,contentType:'text/html;charset=utf-8'//编码格式   
                ,success:function(data){
                  $('.comments').prepend(data);
                  $('#contentarea').attr("value",'');
                  earnremind();
                }	//请求成功后  
                ,error:function(data){  
                   $('.comments').prepend('<?= $this->lang->line('collectionshow_comment_fail'); ?>')   
                }	//请求错误  
             }); 
        });
        </script>
	<?php  }else{?>
		<p class='paragraphstyle'><?= $this->lang->line('collectionshow_unlogin'); ?></p>
	<?php  }?>
	</div>
	
	<ol id="comments" class="comments">
	
	<?php foreach($item_comment_list as $_user_item_comment): ?>  
	
	<li id="comment-<?php echo $_user_item_comment['id']; ?>" class="response comment group " data-user-id="<?php echo $_user_item_comment['author_id']; ?>">
	<h2>
		<a href="<?=site_url('user/'.$_user_item_comment['author_id'])?>" id="cu-<?php echo $_user_item_comment['id']; ?>" class="url" rel="<?php echo $_user_item_comment['author_name']; ?>" title="<?php echo $_user_item_comment['author_name']; ?>"><img alt="<?php echo $_user_item_comment['author_name']; ?>" class="photo" src="<?php echo $_user_item_comment['author_pic']; ?>"><?php echo $_user_item_comment['author_name']; ?></a>
	</h2>
	<div class="comment-body">
		<p><?php echo $_user_item_comment['content']; ?></p>
	</div>
	<p class="comment-meta">
	<?php echo tranTime(strtotime($_user_item_comment['create_date'])); ?>
	<?php if ($this->session->userdata('id')){  ?>
		<span class="sep">|</span><a href="javascript:;" rel="<?php echo $_user_item_comment['id']; ?>" class="reply_link">&nbsp;&nbsp;&nbsp;&nbsp;<?= $this->lang->line('collectionshow_reply'); ?></a>
		
	<?php  }?>
	</p>
	</li>
	
	<?php endforeach; ?>

	</ol>


	</div>

</div> <!-- /main -->

<div class="secondary">

	<a href="<?php echo site_url('collection/back/'.$collection['id'].'/'.$collection['author_id'])?>"><?= $this->lang->line('collectionshow_back_to'); ?> <?php echo $user['displayName']?><?= $this->lang->line('collectionshow_all_collections'); ?></a><br/><br/><br/><br/>


	<h3><span class="meta"><?=$user['displayName']?><?= $this->lang->line('collectionshow_more_collections'); ?></span></h3>
	<div class="group-list">
		<ul>
		<?php foreach($collections as $_collect): ?>
			<li>
				<a href="<?php echo site_url('collection/show/'.$_collect['id'])?>"><img src="<?php echo $_collect['pic_url']; ?>" class="collect-img"></a>
				<p>
					<a href="<?php echo site_url('collection/show/'.$_collect['id'])?>" class="group-title"><?php echo msubstr($_collect['title'],0,50); ?></a>
 					<br><span class="group-count"><?php echo $_collect['works_num']; ?> <?= $this->lang->line('collectionexplore_collect'); ?></span>
				</p>
			</li>
		<?php endforeach; ?>
 		</ul>
 	</div>



</div> <!-- /secondary -->



</div>


 <div id="login" class="pop">
        
				<div id="register-header" class="pop-header">
					<h2><?= $this->lang->line('pop_title_join'); ?></h2>
				</div>
        <div id="idtabs"> 
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
					<input type="hidden" name="redirectURL" value="<?=site_url('collection/show/'.$collection['id'])?>"/>
					</form>
				</div>


	<div id="register-ct">
	<div class="txt-fld" style="padding:0px 20px 35px 20px">
				    <a class="addthis_login_twitter" title="<?= $this->lang->line('pop_sign_twitter'); ?>" href="<?=site_url('login/twitter')?>"><span id="twitter-connect" class="ssi-button"></span></a>
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
					  <label for="remember_me" style="display:inline;color:#000"><?= $this->lang->line('pop_sign_up_stay_informd'); ?>
				    <input type="checkbox" checked name="consent" id="consent"/></label>
					    <input class="save-btn" name="commit" type="button" value="<?= $this->lang->line('pop_sign_up_free'); ?>" onclick="checksignup()">
					</div>
						<input type="hidden" name="redirectURL" value="<?=site_url('collection/show/'.$collection['id'])?>"/>
						</form>
					</div>	

</div>
<script type="text/javascript"> 
  $("#idtabs div").idTabs(); 
</script>

		</div>
		
		<script type="text/javascript">
			$(function() {
    			$('a[rel*=leanModal]').leanModal({ top : 200, closeButton: ".modal_close" });		
			});
		</script>

<?php if ($this->session->userdata('id')){  ?>		
	<div class="remind" id="earn">
		<p>+1 <?= $this->lang->line('pop_coin'); ?></p>
	</div>

	<script>
		
		$(function(){
			var height = $(window).height();
			var width = $(window).width();
			var left = (width - $('.remind').width())/2;
			var top = (height - $('.remind').height())/2;
			if (left < 0) left = 0;
			if (top < 0) top = 0;
			$('.remind').css('left',left);
			$('.remind').css('top',top);
		});

		function earnremind(){

			var remind = $('#earn');
			remind.css('display','block');
			remind.animate({opacity:'1'},1000);
			remind.animate({opacity:'1'},2000);
			remind.animate({opacity:'0'},1000,function(){
				$('#earn').css('display','none');
			});
			
		}

		$(window).resize(function(){
			var height = $(window).height();
			var width = $(window).width();
			var left = (width - $('.remind').width())/2;
			var top = (height - $('.remind').height())/2;
			if (left < 0) left = 0;
			if (top < 0) top = 0;
			$('.remind').css('left',left);
			$('.remind').css('top',top);
		});
	</script>
	<?php 
	
	$first = get_cookie('first_login');
	
		if (isset($first)&&($first!= null)&&($first == 1)) {?>
		 
		<div class="remind" id="first-login">
			<p><span style='font-size:16px;color:#bbb;'><?= $this->lang->line('pop_everyday_login'); ?></span> +1 <?= $this->lang->line('pop_coin'); ?></p>
		</div>
		<script>
			
			$(function(){
	
				var remind = $('#first-login');
				remind.css('display','block');
				remind.animate({opacity:'1'},1500);
				remind.animate({opacity:'1'},3000);
				remind.animate({opacity:'0'},1500,function(){
					$('#first-login').css('display','none');
				});
				
			});
	
		</script>
		 
		 <?php $cookie = array(
		 			'name'   => 'first_login',
		 			'value'  => 0,
		 			'expire' => '5',
		 	);
		 	
		 set_cookie($cookie);
		
		}


}?>	

<?php $this->load->view('footer') ?>

