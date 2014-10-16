<?php $this->load->view('header') ?>

<?php if (!$this->session->userdata('id')){  ?>
<style>

.layer-beforelogin {
color: white;
display: none;
position: fixed;
left: 0;
bottom: 0;
width: 100%;
height: 56px;
line-height: 56px;
z-index: 1000;
background: url(<?=base_url()?>images/g_footer_layer_bg.png);
font-family: "Microsoft YaHei","WenQuanYi Micro Hei",SimHei,tahoma,sans-serif;
}
.layer-beforelogin .layer-bl-con {
width: 960px;
margin: 0 auto;
position: relative;
text-align: left;
}
.layer-beforelogin .layer-slogan {
float: left;
width: 420px;
font-size: 18px;
color: #bababa;
}
.layer-beforelogin .layer-bl-btn, .layer-beforelogin .layer-bl-reg {
float: left;
margin-top: 18px;
}
.gclear {
display: block;
min-height: 1%;
}
.layer-beforelogin .beforelogin-close {
position: absolute;
right: 10px;
top: 10px;
width: 22px;
height: 22px;
}
.layer-beforelogin .beforelogin-close a {
background: url(/skin/imgs/g_footer_layer_btn.png) no-repeat;
background-position: -132px 7px;
display: block;
text-indent: -9999px;
width: 22px;
height: 22px;
}
.layer-beforelogin .layer-bl-reg a {
color: white;
}
.layer-beforelogin .layer-bl-reg {
margin: 0 10px 0 10px;
text-align:left;
}
.layer-beforelogin {
	line-height: 56px;
	font-size: 14px;
}
</style>
<div class="layer-beforelogin" style="display: block;">
<div class="layer-bl-con">
<div class="layer-slogan"><?= $this->lang->line('topic_bottom_title'); ?></div>
<div class="layer-bl-btn"><a class="addthis_login_twitter" href="<?=site_url('login/twitter')?>"><span id="twitter-connect" class="ssi-button"></span></a></div>
<div class="layer-bl-btn"><a class="addthis_login_facebook" href="<?=site_url('login/facebook')?>"><span id="facebook-connect" class="ssi-button"></span></a></div>
<div class="layer-bl-btn"><a class="addthis_login_weibo" href="<?=site_url('login/sina')?>"><span id="weibo-connect" class="ssi-button"></span></a></div>
<div class="layer-bl-reg"><a rel="leanModal" type="button" name="login" href="#login"  onclick="_gaq.push(['_trackEvent', 'topicbtn', 'clicked', 'Click Login to Login Topic'])"><?= $this->lang->line('pop_login'); ?></a><span>&nbsp;&nbsp;&nbsp;&nbsp;or</span></div>
<div class="layer-bl-reg"><a rel="leanModal" type="button" name="login" href="#login"  onclick="_gaq.push(['_trackEvent', 'topicbtn', 'clicked', 'Click Sign Up to Register Topic'])"><?= $this->lang->line('pop_sign_up'); ?></a></div>
<div class="gclear"></div></div>
<div class="beforelogin-close"><a href="javascript:void(0)">关闭</a></div></div>
<?php }?>
	<link href="<?=base_url()?>css/popup.css" media="screen, projection" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>css/main2.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="<?=base_url()?>js/jquery.leanModal.min.js"></script>
    <div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="<?=base_url()?>images/icon-x-30-white.png" width="15">
	</a>
</div>

<div id="main" class="site" style="width:72%">
	<div class="col-about col-about-full under-hero" style="color:#444;word-wrap:break-word;">	
	<h1 class="about" style="font-weight:bold;"><?php echo $topic['topic_title']; ?></h1>
	<?php if ($this->session->userdata('id')==$topic['author_id']){  ?>
  	<a href="<?php echo site_url('topic/edit/'.$topic['id'])?>" rel="<?php echo $topic['id']; ?>"  class="form-sub tagline-action" style="float:right"><?= $this->lang->line('topic_edit'); ?></a>&nbsp;&nbsp;
	<a href="<?php echo site_url('topic/del/'.$topic['id'])?>" onclick="return confirm('Are you sure you want to delete this topic?')" rel="<?php echo $topic['id']; ?>"  class="form-sub tagline-action" style="float:right"><?= $this->lang->line('topic_delete'); ?></a>
 	<?php  }?>
	
	<div class='authorImg' style="display:<?php echo $topic['pic_url']?'':'none'; ?>">
                      <img data-src="<?php echo $topic['pic_url']; ?>" width="450px" alt="<?php echo $topic['topic_title']; ?>" src="<?php echo $topic['pic_url']; ?>">
                   </div>
	<div class="callout">
	<?php if ($this->session->userdata('id')){  ?>
	<?php echo $topic['topic_content'] ?>
	<?php  }else{?>
	<?php echo msubstr($topic['topic_content'],0,10000).'...'; ?><br/><br/>
	<p class='paragraphstyle' style="border-top:1px dashed #999;padding-top:10px;color:#666"><?= $this->lang->line('topic_you_must'); ?> <a rel="leanModal" type="button" name="login" href="#login"  onclick="_gaq.push(['_trackEvent', 'topicbtn', 'clicked', 'Click Sign Up to Comment Topic'])"><?= $this->lang->line('topic_sign_up'); ?></a> <?= $this->lang->line('topic_see_article'); ?></p>
	<?php  } ?>
	</div>
	</div>
	
	<div id="comments-section" style="width:100%">
	<h2 class="count section ">
	<span><?php echo $topic['view_num']; ?> <em><?= $this->lang->line('topic_views'); ?></em> </span>&nbsp;&nbsp;
	<span><?php echo $topic['comment_num']; ?> <em><?= $this->lang->line('topic_comments'); ?></em> </span>
	</h2>
	<div  style="padding-bottom:20px;border-bottom:1px #555 solid;margin-bottom:20px">
                       <?php if ($this->session->userdata('id')){  ?>
		               	<div id="signin_form" class="gen-form">
			<textarea id="contentarea" name="content" class="comment-content"  style="height: 80px; width:99%;background:rgba(255, 255, 255, 1);margin-bottom:15px;"></textarea>
			
			<a style="cursor:pointer;" id="t-comment" class="form-sub" name="<?php echo $topic['id']; ?>"><?= $this->lang->line('topic_post_comment'); ?></a>
        </div>
        
        <script type="text/javascript">

        	$('#t-comment').click(function(){
        		var topic = $(this).attr('name');
        		var content = $('#contentarea').val();
        		var parent = 0;

        		if (content==null||content==''){
					alert('<?= $this->lang->line('topic_input_blank'); ?>');
            		return;
            	} else {

            		$(this).html('<?= $this->lang->line('topic_commenting') ?>');
        			
        			$.post(

                		"<?= site_url('topic/save_comment'); ?>",
        				{
        					topic: topic,
      	  					content: content,
        					parent: parent
        				},
        				function (data,status) {

        					if (status == 'success') {
								location.href = "<?= site_url($this->uri->uri_string()); ?>";
							} else {
								alert('<?= $this->lang->line('topic_comment_fail'); ?>');
							}
        				}
        			);
            	}
			});
			
        </script>
		               <?php  }else{?>
                       <p class='paragraphstyle' style="color:#ddd"><?= $this->lang->line('topic_you_must'); ?> <a rel="leanModal" type="button" name="login" href="#login"  onclick="_gaq.push(['_trackEvent', 'topicbtn', 'clicked', 'Click Sign Up to Comment Topic'])"><?= $this->lang->line('topic_sign_up'); ?></a> <?= $this->lang->line('topic_join_effecthub'); ?></p>
                       <a rel="leanModal" id="hiddenlink" href="#login" style="display:none"></a>
                       <?php  }?>
                       </div>

	<?php if (isset($comment_list)) {
	foreach ($comment_list as $_comment): ?>
		<div class="single-comment">
			<div class="comment-user">
				<a class="comment-img" href="<?= site_url('user/'.$_comment['author_id']); ?>"><img src="<?= $_comment['author_pic'] ?>" /></a>
				<div class="comment-username">
					<a href="<?= site_url('user/'.$_comment['author_id']); ?>"><?= $_comment['author_name']; ?></a>
					<span><?= trantime(strtotime($_comment['create_date'])); ?></span>
					<?php if ($this->session->userdata('id')&&($this->session->userdata('id')!=$_comment['author_id'])) {?><a id="comment-reply"><?= $this->lang->line('topic_reply') ?></a><?php } ?>
				
				</div>
			</div>
			
			<div id="reply-area">
				<textarea rows="1" name="reply-content" class="reply-content"></textarea>
				<a style="cursor:pointer;" class="reply-content form-sub" name="<?php echo $_comment['id']; ?>"><?= $this->lang->line('topic_reply'); ?></a>
			</div>
			
			<div class="t-content">
				<?php if ($_comment['parent_comment_id']!=0&&$_comment['parent_comment_id']!=null) { ?>
				
				<div class="parent-comment">
					
					<span><?= $_comment['parent_user']; ?> <?= trantime(strtotime($_comment['parent_comment_date'])); ?></span>
					<p><?= $_comment['parent_content']; ?></p>
					
				</div>
				
				<?php } ?>
				
				<p><?= $_comment['comment_content']; ?></p>
				
			</div>
			
			
			
		
		</div>
		<?php endforeach; ?>
		
		<script>
			$('#comment-reply').live('click',function(){
				
				var obj = $(this).parent().parent('.comment-user').next('#reply-area');
				if (obj.css('display')=='block') {
					obj.css('display','none');	
				} else {
					obj.css('display','block');
				}	
			});

			$('a.reply-content').click(function(){
				var content = $(this).prev('.reply-content').val();
				var parent = $(this).attr('name');
				var topic = <?= $topic['id'] ?>;

				if (content==null||content==''){
					alert('<?= $this->lang->line('topic_input_blank'); ?>');
            		return;
            	}

				$(this).html('<?= $this->lang->line('topic_commenting') ?>');
				
				$.post(
					"<?= site_url('topic/save_comment')?>",
					{
						content: content,
						parent: parent,
						topic: topic
					},
					function(data,status) {
						if (status == 'success') {
							
							location.href="<?= site_url($this->uri->uri_string()); ?>";
						} else {
							alert('<?= $this->lang->line('topic_comment_fail'); ?>');
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

<div class='headimgitem' style="min-height:80px;height:80px;padding:0px;border:0px;">
                            <div class="headimg">
                                <a href="<?=site_url('user/'.$topic['author_id'])?>"><img width="50px" height="50px" src="<?php echo $topic['author_pic']; ?>"></a>
                            </div>
                            <div class='desctext'>
                                <b><a href="<?=site_url('user/'.$topic['author_id'])?>"><?php echo $topic['author_name']; ?></a></b> <br/><br/>
                                <span style="color:#999;"><?php echo tranTime(strtotime($topic['create_date'])); ?></span>
                            </div>
                   </div>
                   
       <a href="<?php echo site_url('group/'.$topic['group_id'])?>"><?= $this->lang->line('topic_back'); ?><?php echo $topic['group_name']; ?> <?= $this->lang->line('topic_group'); ?></a>
 <br/><br/><br/>
                   
    <?php if ($topic['item_id']>0){  ?>
<h3 class="more-from more-from-player"><?= $this->lang->line('topic_related_work'); ?><span class="meta"></span></h3>
	<ol class="prevnext group" style="margin-top:25px">
	<li>
		<a title="<?php echo $item['title']; ?>" href="<?=site_url('item/'.$item['id'])?>">
<img width="60px" height="60px" alt="<?php echo $item['title']; ?>" src="<?php echo $item['thumb_url']; ?>">
  
		</a>
           
</ol>
<?php  }?>       



	<h3><?= $this->lang->line('topic_latest_topics'); ?> <span class="meta"></span></h3>

	<div class="group-list">
                       <ul>
<?php foreach($topic_list as $_topic): ?>
 <li style="padding:0"><a href="<?php echo site_url('topic/'.$_topic['id'])?>" style="color:#aaa"><?php echo $_topic['topic_title']; ?></a></li>
<?php endforeach; ?>
 </ul></div><br/><br/>
 
 <h3><?= $this->lang->line('topic_tasks'); ?> <span class="meta"></span></h3>

	<div class="group-list">
                       <ul>
<?php foreach($task_list as $_task): ?>
 <li style="padding:0"><a href="<?php echo site_url('task/'.$_task['id'])?>" style="color:#aaa"><?php echo $_task['title']; ?></a></li>
<?php endforeach; ?>
 </ul></div><br/><br/>
 
 <h3 class="more-from more-from-player"><?= $this->lang->line('item_guess'); ?><span class="meta"></span></h3>
	<ol class="prevnext group" style="margin-top:10px">
	<?php foreach($hot_item_list as $_hot_item): ?>
                        <li>
		<a title="<?php echo $_hot_item['title']; ?>" href="<?=site_url('item/'.$_hot_item['id'])?>">
		<?php if($_hot_item['thumb_url']!=null||$_hot_item['pic_url']!=null){ ?>
  <img width="90px" height="72px" alt="<?php echo $_hot_item['title']; ?>" src="<?php echo $_hot_item['thumb_url']; ?>">
  <?php  }else{?>
  	<iframe src="<?=site_url('item/preview_html/'.$_hot_item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 78px; height: 60px;padding:6px;margin:0px;background:#333"></iframe>
  <?php  }?>
		</a></li>
                        <?php endforeach; ?>
</ol>


	<h3 id="effecthub-newsletter"><?= $this->lang->line('topic_share'); ?> <span class="meta"></span> </h3>
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
					<input type="hidden" name="redirectURL" value="<?=site_url('topic/'.$topic['id'])?>"/>
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
					    <input class="save-btn" name="commit" type="button" value="<?= $this->lang->line('pop_sign_up_free'); ?>" onclick="checksignup();_gaq.push(['_trackEvent', 'signup', 'clicked', 'Click Sign Up Button In Topic Page'])">
					</div>
					<input type="hidden" name="redirectURL" value="<?=site_url('topic/'.$topic['id'])?>"/>
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
    			$("#hiddenlink").click();	
			});
		</script>

	<?php if ($this->session->userdata('id')) {?>
	
		<div class="remind" id="earn">
			<p>+1 <?= $this->lang->line('topic_coin'); ?></p>
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
		
		
		
	<?php $new = get_cookie('new_topic');
		if (isset($new)&&($new!= null)&&($new == 1)) {?>

	<div class="remind" id="new-earn">
		<p>+5 <?= $this->lang->line('topic_coins'); ?></p>
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
			'name'   => 'new_topic',
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
	 
	 <?php delete_cookie('first_login'); } }?>

</div>
<?php $this->load->view('footer') ?>
