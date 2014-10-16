<?php $this->load->view('header') ?>
	<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>css/task.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="<?=base_url()?>js/jquery.leanModal.min.js"></script>
	<script src="<?=base_url()?>js/task.js"></script>
	<style>
	div.t-content p {
	color: #444;
}
div.parent-comment {
background: #fff;
border: 1px solid #aaa;
color: #444;
font-style:normal;
}
div.single-comment div.comment-user div.comment-username a#comment-reply {
color: #444;
}
	</style>	
    <div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="<?=base_url()?>images/icon-x-30-white.png" width="15">
	</a>
</div>

<div id="main" class="site" style="width:72%" task_id="<?php echo $task['id']; ?>">
<div class="col-about col-about-full under-hero" style="color:#444;word-wrap:break-word;">	
	<h1 class="about" style="font-weight:bold;">
	<?php echo $task['title']; ?></h1>
	<div style="margin-top:5px;font-size:12px">
	<a href="<?= site_url('task/type/'.$task['type']) ?>"><?=$lang==2?$task['type_name_cn']:$task['type_name'] ?></a></div>
	<?php if ($this->session->userdata('id')==$task['author_id']){  ?>
  	<a href="<?php echo site_url('task/edit/'.$task['id'])?>" rel="<?php echo $task['id']; ?>"  class="form-sub tagline-action" style="float:right"><?= $this->lang->line('task_edit'); ?></a>&nbsp;&nbsp;
	<a href="<?php echo site_url('task/del/'.$task['id'])?>" onclick="return confirm('Are you sure you want to delete this task?')" rel="<?php echo $task['id']; ?>"  class="form-sub tagline-action" style="float:right"><?= $this->lang->line('task_delete'); ?></a>
 	<?php  }?>
	<br/><br/>
	<p class="callout"><?php echo auto_link($task['desc'], 'both', TRUE); ?></p>
	<?php if(count($task_files)>0){ ?>
					<div class="parent-comment">
				<?= $this->lang->line('taskcreate_attachments'); ?><br/>
				<?php foreach ($task_files as $_task_file): ?>
				<a target="_blank" href="<?=$_task_file['download_url']?>">
				<img width="100px" src="<?=$_task_file['thumb_url']?>"/>
				<?=$_task_file['title']?>
				</a>&nbsp;&nbsp;
				<?php endforeach; ?>
				</div>
				<?php } ?>
				
				
	<div class="tags" style="font-size:14px">
				<p><span style="float:left;"><?= $this->lang->line('taskcreate_tag'); ?></span>
				<span>
					<?php foreach($tags as $tag): ?>
							<a href="<?=site_url('task/tagSearch?tag='.$tag)?>" rel="tag" class="tag"><strong><?php echo $tag; ?></strong></a>
					<?php endforeach; ?>
				</span>
				</p>
	</div>
	</div>
	
	<div id="comments-section" style="width:100%">
	<h2 class="count section ">
	<span><?php echo $task['view_num']; ?> <em><?= $this->lang->line('task_views'); ?></em> </span>&nbsp;&nbsp;
	<span><?php echo $task['response_num']; ?> <em><?= $this->lang->line('task_comments'); ?></em> </span>
	</h2>
	<?php if ($task['status']==0){  ?>
                       <?php if ($this->session->userdata('id')){  ?>
                       	<?php if ($this->session->userdata('id')!=$task['author_id']){  ?>
	<div  style="padding-bottom:20px;margin-bottom:20px">
		               	<a style="cursor:pointer;width:100%" class="form-sub" href="<?php echo site_url('task/placebid/'.$task['id'])?>"><?= $this->lang->line('task_place_bid'); ?></a>
		              </div>
		              <?php  }?>
		               <?php  }else{?>
		               	
	<div  style="padding-bottom:20px;margin-bottom:20px">
                       
                       <p class='paragraphstyle' style="color:#ddd">
                       <a class="form-sub" rel="leanModal" type="button" name="login" href="#login"><?= $this->lang->line('task_place_bid'); ?></a></p>
                       <a rel="leanModal" id="hiddenlink" href="#login" style="display:none"></a>
                       </div>
                       <?php  }?>
    <?php  }?>            
    
    
    
	<?php if (isset($best_answer)) {
	foreach ($best_answer as $_comment): ?>
	
	<div class="col-about col-about-full under-hero" style="color:#444;word-wrap:break-word;">	
		<div class="single-comment" comment_id=<?= $_comment['id'];?> style="border-bottom:2px solid #ddd;">
			<div class="comment-user">
				<a class="comment-img" href="<?= site_url('user/'.$_comment['author_id']); ?>"><img src="<?= $_comment['author_pic'] ?>" /></a>
				<div class="comment-username">
					<a href="<?= site_url('user/'.$_comment['author_id']); ?>"><?= $_comment['author_name']; ?></a>					
				</div>
			
			<?php if ($this->session->userdata('id')==$task['author_id']&&$task['status']==0&&$_comment['parent_comment_id']==0){  ?>
		               	<a style="cursor:pointer;float:right" class="form-sub" href="<?php echo site_url('task/acceptbid/'.$_comment['id'])?>"><?= $this->lang->line('task_best_bid'); ?></a>
		               <?php  }?>
		          
		          <?php if ($task['status']==1&&$_comment['is_best']==1){  ?>     
		          <span style="float:right;border-radius:5px;padding:3px 10px;background:#618FB9;color:#FFF"><?= $this->lang->line('task_best_bid'); ?></span>
		          <?php  }?>     
			</div>			
			<div class="t-content">
				<div class="useful-show" useful-level=<?= $_comment['useful_level'];?>>
					<?php if($_comment['useful_level'] == 1){?>					
						<!-- 
						<img class="up-img" style="background-color:green" src="<?=base_url()?>images/task/uparrow.png"/>
						 -->
						 <img class="up-img" src="<?=base_url()?>images/task/up-clicked.png"/>
					<?php }else{?>
						<!-- 
						<img class="up-img" src="<?=base_url()?>images/task/uparrow.png"/>
						 -->
						 <img class="up-img" src="<?=base_url()?>images/task/up-original.png"/>
					<?php }?>
					<br/>				
					<p class="useful-count"><?= $_comment['useful_count'];?></p>
					<br/>	
					<?php if($_comment['useful_level'] == -1){?>				
						<!--  
						<img class="down-img" style="background-color:red" src="<?=base_url()?>images/task/downarrow.png"/>
						-->
						<img class="down-img" src="<?=base_url()?>images/task/down-clicked.png"/>
					<?php }else{?>
						<!--  
						<img class="down-img" src="<?=base_url()?>images/task/downarrow.png"/>
						-->
						<img class="down-img" src="<?=base_url()?>images/task/down-original.png"/>
					<?php }?>
				</div>
				<?php if ($_comment['parent_comment_id']!=0&&$_comment['parent_comment_id']!=null) { ?>
				
				<div class="parent-comment">
					
					<span><?= $_comment['parent_user']; ?> <?= trantime(strtotime($_comment['parent_comment_date'])); ?></span>
					<p><?= $_comment['parent_content']; ?></p>
					
				</div>
				
				<?php } ?>
				
				<p><?php echo auto_link($_comment['comment_content'], 'both', TRUE); ?></p>
				<?php if(count($_comment['bid_files'])>0){ ?>
					<div class="parent-comment">
					<?php if ($task['task_type']==1||$this->session->userdata('id')==$task['author_id']||$this->session->userdata('id')==$_comment['author_id']){  ?>
				<?= $this->lang->line('bidcreate_attachments'); ?><br/>
				<?php foreach ($_comment['bid_files'] as $_bid_file): ?>
				<a target="_blank" href="<?=$_bid_file['download_url']?>">
				<img width="100px" src="<?=$_bid_file['thumb_url']?>"/>
				<?=$_bid_file['title']?>
				</a>&nbsp;&nbsp;
				<?php endforeach; ?>
				<?php }else{ ?>
				<?= $this->lang->line('file_forbidden'); ?>
				<?php } ?>
				</div>
				<?php }else{ ?>
					<?php if(count($_comment['source_files'])==1){ ?>
						<iframe id="item-preview" width="100%" height="300px" src="<?=site_url('item/embed/'.$_comment['source_files'][0]['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0"></iframe>
					<?php } ?>
				<?php } ?>
				
				<?php if(count($_comment['source_files'])>0){ ?>
					<div class="parent-comment">
					<?php if (($this->session->userdata('id')==$task['author_id']&&$_comment['is_best']==1)||$this->session->userdata('id')==$_comment['author_id']){  ?>
				<?= $this->lang->line('bidcreate_source'); ?><br/>
				<?php foreach ($_comment['source_files'] as $_source_file): ?>
				<a target="_blank" href="<?=$_source_file['download_url']?>">
				<img width="100px" src="<?=$_source_file['thumb_url']?>"/>
				<?=$_source_file['title']?>
				</a>&nbsp;&nbsp;
				<?php endforeach; ?>
				<?php }else{ ?>
				<?= $this->lang->line('file_best'); ?>
				<?php } ?>
				</div>
				<?php } ?>
				<p style="color:#aaa;font-size:12px"><?= trantime(strtotime($_comment['update_date'])); ?>				
				&nbsp;&nbsp;&nbsp;&nbsp;<a id="answer-comments" style="cursor:pointer;"><?= $_comment['reply_count'].' '. $this->lang->line('task_reply_comments') ?></a>
				
				
				</p>
			</div>
			<div id=<?= "reply-box".$_comment['id']?> ></div>
			<div id="reply-area">
				<textarea rows="1" name="reply-content" class="reply-content"></textarea>
				<a style="cursor:pointer;" class="reply-content form-sub" name="<?php echo $_comment['id']; ?>"><?= $this->lang->line('task_reply'); ?></a>
			</div>
			
		
		</div>
		</div>
		<?php endforeach; ?>
           <?php }?>

	<?php if (isset($comment_list)) {
	foreach ($comment_list as $_comment): ?>
	<div class="col-about col-about-full under-hero" style="color:#444;word-wrap:break-word;">	
		<div class="single-comment" comment_id=<?= $_comment['id'];?> style="border:0">
			<div class="comment-user">
				<a class="comment-img" href="<?= site_url('user/'.$_comment['author_id']); ?>"><img src="<?= $_comment['author_pic'] ?>" /></a>
				<div class="comment-username">
					<a href="<?= site_url('user/'.$_comment['author_id']); ?>"><?= $_comment['author_name']; ?></a>				
				</div>
			
			<?php if ($this->session->userdata('id')==$task['author_id']&&$task['status']==0&&$_comment['parent_comment_id']==0){  ?>
		               	<a style="cursor:pointer;float:right" class="form-sub" href="<?php echo site_url('task/acceptbid/'.$_comment['id'])?>"><?= $this->lang->line('task_best_bid'); ?></a>
		               <?php  }?>
		          
		          <?php if ($task['status']==1&&$_comment['is_best']==1){  ?>     
		          <span style="float:right;border-radius:5px;padding:3px 10px;background:#618FB9;color:#FFF"><?= $this->lang->line('task_best_bid'); ?></span>
		          <?php  }?>     
			</div>
			
			
			<div class="t-content">
				<div class="useful-show" useful-level=<?= $_comment['useful_level'];?>>
					<?php if($_comment['useful_level'] == 1){?>					
						<!-- 
						<img class="up-img" style="background-color:green" src="<?=base_url()?>images/task/uparrow.png"/>
						 -->
						 <img class="up-img" src="<?=base_url()?>images/task/up-clicked.png"/>
					<?php }else{?>
						<!-- 
						<img class="up-img" src="<?=base_url()?>images/task/uparrow.png"/>
						 -->
						 <img class="up-img" src="<?=base_url()?>images/task/up-original.png"/>
					<?php }?>
					<br/>				
					<p class="useful-count"><?= $_comment['useful_count'];?></p>
					<br/>	
					<?php if($_comment['useful_level'] == -1){?>				
						<!--  
						<img class="down-img" style="background-color:red" src="<?=base_url()?>images/task/downarrow.png"/>
						-->
						<img class="down-img" src="<?=base_url()?>images/task/down-clicked.png"/>
					<?php }else{?>
						<!--  
						<img class="down-img" src="<?=base_url()?>images/task/downarrow.png"/>
						-->
						<img class="down-img" src="<?=base_url()?>images/task/down-original.png"/>
					<?php }?>
				</div>
				<?php if ($_comment['parent_comment_id']!=0&&$_comment['parent_comment_id']!=null) { ?>
				
				<div class="parent-comment">
					
					<span><?= $_comment['parent_user']; ?> <?= trantime(strtotime($_comment['parent_comment_date'])); ?></span>
					<p><?= $_comment['parent_content']; ?></p>
					
				</div>
				
				<?php } ?>
				
				<p><?php echo auto_link($_comment['comment_content'], 'both', TRUE); ?></p>
				<?php if(count($_comment['bid_files'])>0){ ?>
					<div class="parent-comment">
					<?php if ($task['task_type']==1||$this->session->userdata('id')==$task['author_id']||$this->session->userdata('id')==$_comment['author_id']){  ?>
				<?= $this->lang->line('bidcreate_attachments'); ?><br/>
				<?php foreach ($_comment['bid_files'] as $_bid_file): ?>
				<a target="_blank" href="<?=$_bid_file['download_url']?>">
				<img width="100px" src="<?=$_bid_file['thumb_url']?>"/>
				<?=$_bid_file['title']?>
				</a>&nbsp;&nbsp;
				<?php endforeach; ?>
				<?php }else{ ?>
				<?= $this->lang->line('file_forbidden'); ?>
				<?php } ?>
				</div>
				<?php }else{ ?>
					<?php if(count($_comment['source_files'])==1){ ?>
						<iframe id="item-preview" width="100%" height="300px" src="<?=site_url('item/embed/'.$_comment['source_files'][0]['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0"></iframe>
					<?php } ?>
				<?php } ?>
				
				<?php if(count($_comment['source_files'])>0){ ?>
					<div class="parent-comment">
					<?php if (($this->session->userdata('id')==$task['author_id']&&$_comment['is_best']==1)||$this->session->userdata('id')==$_comment['author_id']){  ?>
				<?= $this->lang->line('bidcreate_source'); ?><br/>
				<?php foreach ($_comment['source_files'] as $_source_file): ?>
				<a target="_blank" href="<?=$_source_file['download_url']?>">
				<img width="100px" src="<?=$_source_file['thumb_url']?>"/>
				<?=$_source_file['title']?></a>&nbsp;&nbsp;
				<?php endforeach; ?>
				<?php }else{ ?>
				<?= $this->lang->line('file_best'); ?>
				<?php } ?>
				</div>
				<?php } ?>
				<p style="color:#aaa;font-size:12px"><?= trantime(strtotime($_comment['update_date'])); ?>					
					&nbsp;&nbsp;&nbsp;&nbsp;<a id="answer-comments" style="cursor:pointer;" ><?= $_comment['reply_count'].' '. $this->lang->line('task_reply_comments') ?></a>				
									
				</p>
			</div>		
			<div id=<?= "reply-box".$_comment['id']?> ></div>	
			<div id="reply-area">
				<textarea rows="1" name="reply-content" class="reply-content"></textarea>
				<a style="cursor:pointer;" class="reply-content form-sub" name="<?php echo $_comment['id']; ?>"><?= $this->lang->line('task_reply'); ?></a>
			</div>
			
		
		</div>
		</div>
		<?php endforeach; ?>
		
		<script>
			var blank = '<?= $this->lang->line('task_input_blank'); ?>';
			var task_commenting = '<?= $this->lang->line('task_commenting') ?>';
			var lang_reply = '<?= $this->lang->line('task_reply_comments')?>';
			var user_id = '<?= $this->session->userdata('id') ?>';		
			if(typeof user_id === 'undefined')
			{
				user_id = null;
			}
			var lang_reply_call = '<?=$this->lang->line('reply_call')?>';
			var base_url = '<?=base_url()?>';
			$('#comment-reply').live('click',function(){
				
				//var obj = $(this).parent().parent('.comment-user').next().next('#reply-area');
				var obj = $(this).parent().next('#reply-area');
				if (obj.css('display')=='block') {
					obj.css('display','none');	
				} else {
					obj.css('display','block');
				}	
			});

			$('a.reply-content').click(function(){
				var content = $(this).prev('.reply-content').val();
				var parent = $(this).attr('name');
				var task = <?= $task['id'] ?>;

				if (content==null||content==''){
					alert('<?= $this->lang->line('task_input_blank'); ?>');
            		return;
            	}

				$(this).html('<?= $this->lang->line('task_commenting') ?>');
				
				$.post(
					"<?= site_url('task/savebid')?>",
					{
						desc: content,
						parent: parent,
						task: task
					},
					function(data,status) {
						if (status == 'success') {
							
							location.href="<?= site_url($this->uri->uri_string()); ?>";
						} else {
							alert('<?= $this->lang->line('task_comment_fail'); ?>');
						}
					}

				);
				
			});
			
		</script>
	


	<div class="page">
		<?php echo $this->pagination->create_links();?>
	</div>
		<?php }?>
</div>

</div>

<div class="secondary" style="width:25%">

<div class='headimgitem' style="min-height:60px;padding:0px;border:0px;">
                            <div class="headimg">
                                <a href="<?=site_url('user/'.$task['author_id'])?>"><img width="50px" height="50px" src="<?php echo $task['author_pic']; ?>"></a>
                            </div>
                            <div class='desctext'>
                                <b><a href="<?=site_url('user/'.$task['author_id'])?>"><?php echo $task['author_name']; ?></a></b> <br/><br/>
                                <span style="color:#999;"><?php echo tranTime(strtotime($task['update_date'])); ?></span>
                            </div>
                   </div>
                   <div style="width:70%;background:#212121;border-radius:10px;margin:20px;margin-left:0px;padding:10px;text-align:left">
	<h1 style="font-size:14px"><strong>
	<?php if ($task['task_type']==1) {?>
                    <?= $this->lang->line('task_question'); ?>
                    <?php }else{?>
                    	<?= $this->lang->line('task_askasset'); ?>
                    <?php }?>
                    <br/><br/>
          <?= $this->lang->line('task_couldget'); ?> 
	<span style="color:#FFCC66">  
	<?php if($task['price_type']=='1'){
					echo '<img src="'.base_url('images/icon-coin.png').'" height="12px" width="12px" />'.' '.$task['price'];
				}else{
					if($lang==2){
						echo '￥'.$task['price'];
					}else{
						 echo '$'.$task['price'];
					}
				}       
				?></span>
                    </strong></h1>
	</div>
	
                   <?php if ($this->session->userdata('id')&&$this->session->userdata('id')!=$task['author_id']){  ?>
                        <div style="padding-top:10px">
                            <a href="<?=site_url('user/writemail/'.$task['author_id'])?>"><div class="iconimg">
                               <img src="<?=base_url()?>images/message.jpg"> <?= $this->lang->line('user_send_message');?>
                            </div></a>
                        </div>
                   <br/>
                   <br/>
                        <?php  }?>
                        <?php if ($task['status']==1){  ?>     
		          <span style="border-radius:5px;padding:3px 10px;background:#618FB9"><?= $this->lang->line('task_finished'); ?></span>
		          <br/><br/><br/>
		          <?php  }?>
<a href="<?php echo site_url('task')?>"><?= $this->lang->line('task_back'); ?><?= $this->lang->line('task_list'); ?></a>                   
  <br/><br/><br/>
  
  
	<?php if ($task['status']==0){  ?>
                       <?php if ($this->session->userdata('id')){  ?>
                       	<?php if ($this->session->userdata('id')!=$task['author_id']){  ?>               
		<h3><?= $this->lang->line('task_want_bid'); ?> <span class="meta"></span></h3>                 
		<a style="cursor:pointer;" class="form-sub" href="<?php echo site_url('task/placebid/'.$task['id'])?>"><?= $this->lang->line('task_place_bid'); ?></a>
		<br/><br/><br/>
		<?php  } ?>
<?php  }else{ ?>
<h3><?= $this->lang->line('task_want_bid'); ?> <span class="meta"></span></h3>                 
		<a class="form-sub" rel="leanModal" type="button" name="login" href="#login"><?= $this->lang->line('task_place_bid'); ?></a>
		<br/><br/><br/>
<?php  } ?>
<?php  } ?>
	<h3><?= $this->lang->line('task_latest_tasks'); ?> <span class="meta"></span></h3>

	<div class="group-list">
                       <ul>
<?php foreach($task_list as $_task): ?>
 <li style="padding:0"><a href="<?php echo site_url('task/'.$_task['id'])?>" style="color:#aaa"><?php echo $_task['title']; ?></a></li>
<?php endforeach; ?>
 </ul></div><br/><br/>


	<h3 id="effecthub-newsletter"><?= $this->lang->line('task_share'); ?> <span class="meta"></span> </h3>
		<?php if ($lang=='2') {?>
					<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_douban" data-cmd="douban" title="分享到豆瓣网"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{},"image":{"viewList":["qzone","tsina","tqq","weixin","douban"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","weixin","douban"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<br/>
<?php }else {?>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5146e5b61a736647"></script>
<!-- AddThis Button END -->
<?php }?>
</div>


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
					<input type="hidden" name="redirectURL" value="<?=site_url('task/placebid/'.$task['id'])?>"/>
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
					<input type="hidden" name="redirectURL" value="<?=site_url('task/placebid/'.$task['id'])?>"/>
					</form>
				</div>	

</div>
<script type="text/javascript"> 
  $("#idtabs div").idTabs(); 
</script>

		</div>
		
		<script type="text/javascript">
			$(function() {
    			$('a[rel*=leanModal]').leanModal({ top : 150, closeButton: ".modal_close" });	
    			$("#hiddenlink").click();	
			});
		</script>

	<?php if ($this->session->userdata('id')) {?>
	
		<div class="remind" id="earn">
			<p>+1 <?= $this->lang->line('task_coin'); ?></p>
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
		
		
		
	<?php $new = get_cookie('new_task');
		if (isset($new)&&($new!= null)&&($new == 1)) {?>

	<div class="remind" id="new-earn">
		<p>+5 <?= $this->lang->line('task_coins'); ?></p>
	</div>

	<script>
		
		$(function(){
			var remind = $('#new-earn');
			remind.css('display','block');
			remind.animate({opacity:'1'},1000);
			remind.animate({opacity:'1'},2000);
			remind.animate({opacity:'0'},1000,function(){
				$('#new-earn').css('display','none');
			});
			
		});

	</script>

<?php 	$cookie = array(
			'name'   => 'new_task',
			'value'  => 0,
			'expire' => '5',
		);
		set_cookie($cookie);
}
	
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

</div>
<?php $this->load->view('footer') ?>
