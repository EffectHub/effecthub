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
<script language="javascript" type="text/javascript" >
       $(document).ready(function(){
       var htmlAddr = "<iframe src=\"<?=site_url('item/preview/'.$item['id'])?>\"><\iframe>";
       $("#edit_html_addr").val(htmlAddr.replace(/\'/g,'"').replace("><",' width="450px" height="450px" allowfullscreen><'));
       $("#edit_html_addr").on("click",function(){$(this).select()});
       });
     </script>
<div id="content" class="group">
<?php if ($item['contest_id']==1){  ?>
                    <a title="EffectHub&Sparticle Particle Effect Contest" href="<?=site_url('contest')?>"><span class="tag_box" style="background:url(<?=base_url()?>images/contest.png) no-repeat 0 0;_background-image:none;_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=base_url()?>images/soldout.png',sizingMethod='noscale');"></span></a>
                    <?php  }?>
<?php if ($item['contest_id']==2&&$lang=='2'){  ?>
                    <a title="EffectHub & 图灵图书 移动游戏分享大赛" href="<?=site_url('turing')?>"><span class="tag_box" style="background:url(<?=base_url()?>images/contest.png) no-repeat 0 0;_background-image:none;_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=base_url()?>images/soldout.png',sizingMethod='noscale');"></span></a>
                    <?php  }?>
<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="/images/icon-x-30-white.png" width="15">
	</a>
</div>

<div id="main" class="full-800">
	
	<div id="screenshot-title-section" class="title" name='<?php echo $item['price'];?>'>
		<div class="single-title vcard group">
			<a href="<?=site_url('user/'.$item['author_id'])?>" class="url" rel="contact" title="<?php echo $item['author_name']; ?>"><div data-picture="" data-alt="<?php echo $item['author_name']; ?>" data-class="photo">

<img alt="<?php echo $item['author_name']; ?>" class="photo" src="<?php echo $item['author_pic']; ?>"></div></a>
			<h1 id="screenshot-title">
			<a href="<?=site_url('item/featured/MostRecent/'.$item['type_link'])?>">
			<?php echo $lang==2?$item['type_name_cn']:$item['type_name']; ?></a>
			 - <a href="<?=site_url('folder/'.$item['folder_id'])?>"><?php echo isset($item['folder_name'])?$item['folder_name']:''; ?></a>
			 - <?php echo $item['title']; ?>
               <?php if ($item['is_share']==1){  ?>
               		(<?= $this->lang->line('item_shared_from_internet'); ?>)
               	<?php  }?>
               <?php if ($item['is_private']==1){  ?>
               		(<?= $this->lang->line('item_private'); ?>)
               	<?php  }?>
               	<?php if (count($work_file_list)>0){  ?>
               		(<a href="<?=site_url('project/files/'.$item['id'])?>"><?php echo count($work_file_list); ?> <?= $this->lang->line('item_files'); ?></a>)
               	<?php  }?>	
               	
               	
		<div class="hero" style="float:right;display:none">
		
		<div class="hero-btn">
		<?php if($item['from']=='particle'){ ?>
				<?php if ($this->session->userdata('id')&&$this->session->userdata('id')!=$item['author_id']){  ?>
									<?php if($item['contest_id']>2){ ?>
									
									<?php  }else{?>
			                         <a target="_blank" <?php if(!$download){ ?>
			                       		 onclick="javascript: return cost();"
			                       	<?php  } ?> href="<?=site_url('item/fork/'.$item['id'].'/'.$item['price'])?>" style="width:120px">
			                         <strong class="title">Fork</strong>
			                        </a>
			                        <?php  }?>
	                         <?php  }else if(!$this->session->userdata('id')){?>
	                         	<?php if($item['contest_id']>2){ ?>
									
									<?php  }else{?>
			                        <a rel="leanModal" name="login" href="#login" class='buttonstyle' style="width:120px"><strong class="title">Fork</strong>
			                        </a>
			                        <?php  }?>
	                        <?php  }?>
                <?php }else if($item['from']=='htmleditor'||$item['from']=='aseditor'){ ?>
                	<a target="_blank" href="<?=site_url('item/fork/'.$item['id'])?>" style="width:120px">
                 <strong class="title"><?= $this->lang->line('item_view_code'); ?></strong>
                </a>
                 <?php  }else{?>
                         
						<?php if($item['download_url']!=0||$item['download_url']!=null){ ?>
							<?php if ($this->session->userdata('id')){  ?>
		                       <a target="_blank" <?php if(!$download){ ?>
		                       		 onclick="javascript: return cost();"
		                       	<?php  } ?> href="<?=site_url('item/download/'.$item['id'])?>" style="width:120px">
		                       <strong class="title"><?= $this->lang->line('item_download'); ?></strong>
		                        </a>
		                         <?php  }else{?>
		                        <a rel="leanModal" name="login" href="#login" class='buttonstyle' style="width:120px"><strong class="title">Download</strong>
		                        </a>
		                        <?php  }?>
		                        
		                        <?php  }?>
                         <?php  }?>
				
		</div>
		</div>
               	
               	
               	<div style="float:right;width:250px;padding-top:5px">
<?php if ($lang=='2') {?>
<div class="bdsharebuttonbox"><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_more" data-cmd="more"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"","viewSize":"16"}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script><br/>
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
<!-- AddThis Button END --><br/>
<?php }?>
</div>
               	</h1>
               	
			<div class="shot-byline">
				<div class="attribution ">
					<span class="shot-byline-user">
						<a href="<?=site_url('user/'.$item['author_id'])?>" class="url" rel="contact"><?php echo $item['author_name']; ?></a>
					</span>
					<div class="follow-prompt">
</div>

				</div>


				<span class="screenshot-dash">
					<?php echo tranTime(strtotime($item['create_date'])); ?>
				</span>
				
			</div>
		</div>
	</div>
	
	<div class="the-shot">


		
		<?php if(($item['pic_url']!=null&&$item['pic_url']!='')||($item['extension']=='swf')||($item['type']==8&&$item['extension']!='zip')||($item['type']==2&&$item['extension']=='zip')||$item['from']=='htmleditor'||($item['preview_url']!='0'&&$item['preview_url']!=null)||$item['from']=='particle'||$item['from']=='dragonbones'||$item['from']=='sea3d'){ ?>
<div class="single" style="padding:10px;position:relative;">

<iframe id="item-preview" width="100%" height="600px" src="<?=site_url('item/embed/'.$item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0">aasdsd</iframe>
<?php  }else{?>
<div class="single" style="height:50px;min-height:50px;padding:10px">
<?php  }?>

			<div style="margin:20px 10px 0 10px">
				
				<ul class="itemoperation">
	<?php if(($item['type']==2&&$item['extension']=='zip')||$item['from']=='htmleditor'||($item['preview_url']!='0'&&$item['preview_url']!=null)||$item['from']=='dragonbones'){ ?>
                       <li><a target="_blank" href="<?=site_url('item/fullscreen/'.$item['id'])?>" class='buttonstyle'><?= $this->lang->line('item_fullscreen'); ?></a></li>
                       <?php  }?>
                       
                       <?php if($item['from']=='particle'){ ?>
                       <?php if ($this->session->userdata('id')&&$this->session->userdata('id')!=$item['author_id']){  ?>
									<?php if($item['contest_id']>2){ ?>
									
									<?php  }else{?>
			                         <li><a target="_blank" <?php if(!$download){ ?>
			                       		 onclick="javascript: return cost();"
			                       	<?php  } ?> href="<?=site_url('item/fork/'.$item['id'].'/'.$item['price'])?>" class='buttonstyle'>
			                         <strong class="title">Fork</strong>
			                        </a></li>
			                        <?php  }?>
	                         <?php  }else if(!$this->session->userdata('id')){?>
	                         	<?php if($item['contest_id']>2){ ?>
									
									<?php  }else{?>
			                        <li><a rel="leanModal" name="login" href="#login" class='buttonstyle' class='buttonstyle'><strong class="title">Fork</strong>
			                        </a></li>
			                        <?php  }?>
	                        <?php  }?>
                <?php }else if($item['from']=='htmleditor'||$item['from']=='aseditor'){ ?>
                	<?php if ($this->session->userdata('id')!=$item['author_id']){  ?>
                	<li><a target="_blank" href="<?=site_url('item/fork/'.$item['id'])?>" class='buttonstyle'>
                 <strong class="title"><?= $this->lang->line('item_view_code'); ?></strong>
                </a></li>
                <?php  }?>
                       <?php  }?>
                       
                       
                       
                       
                       <?php if($item['contest_id']>2){ ?>
                       		
                       		<?php  }else{?>
                       			
                       <?php if($item['download_url']!=0||$item['download_url']!=null){ ?>
                       	<?php if ($this->session->userdata('id')){  ?>
                       		
                       <li><a target="_blank" <?php if(!$download){ ?>
                       		 onclick="javascript: return cost();"
                       	<?php  } ?> href="<?=site_url('item/download/'.$item['id'])?>"  class='buttonstyle'><?= $this->lang->line('item_download'); ?>
                       <?php if ($item['author_id']!=$this->session->userdata('id')){  ?>
	                       	<?php if (!$download){  ?>
		                       <?php if ($item['price']>0){  ?>
		                       	<?php if ($item['price_type']==1){  ?>
		                        (<?php echo $item['price'].' '.$this->lang->line('item_coins'); ?> )
		                        <?php  }else if ($item['price_type']==2){ ?>
		                        (￥ <?php echo $item['price'].' '?>)
		                        <?php  }else if ($item['price_type']==3){ ?>
		                        ($ <?php echo $item['price'].' '?>)
		                        	<?php  } ?><?php  } ?>
		                        <?php  } ?>
                       	<?php  } ?>
                        </a></li>
                        
                        
                         <?php  }else{?>
                        <li><a rel="leanModal" name="login" href="#login" class='buttonstyle'><?= $this->lang->line('item_download'); ?></a></li>
                        <?php  }?>
                        <?php  }?>
                       <?php  }?>
                   		
                   			<?php if ($this->session->userdata('id')){  ?>
                   			<li>
                   			<?php if ($fav!=null){  ?>
<a href="javascript:" class='buttonstyle' id='likeOrdislike' name="<?php echo $item['id']; ?>"><?= $this->lang->line('item_unlike'); ?></a>
<input type="hidden" id="like" value="1" />
<?php  }else{?>
<a href="javascript:" class='buttonstyle' id='likeOrdislike' name="<?php echo $item['id']; ?>"><?= $this->lang->line('item_like'); ?></a>
<input type="hidden" id="like" value="0" />
<?php  }?>
</li>
<li>
<?php if ($watch!=null){  ?>
<a href="javascript:" class='buttonstyle' id='watchOrunwatch' name="<?php echo $item['id']; ?>"><?= $this->lang->line('item_unwatch'); ?></a>
<input type="hidden" id="watch" value="1" />
<?php  }else{?>
<a href="javascript:" class='buttonstyle' id='watchOrunwatch' name="<?php echo $item['id']; ?>"><?= $this->lang->line('item_watch'); ?></a>
<input type="hidden" id="watch" value="0" />
<?php  }?>
</li>
                   		  <?php  }else if(!$this->session->userdata('id')){?>
                   		  	<?php if ($item['contest_id']>2){  ?>
                    <li><a rel="leanModal" name="login" href="#login" class='buttonstyle'><?= $this->lang->line('item_vote'); ?></a></li>
                    <span style="color: #aaa;">(<?= $this->lang->line('item_tips'); ?>)</a>
                    <?php  }else{?>
                    
			                        <li><a rel="leanModal" name="login" href="#login" class='buttonstyle' class='buttonstyle'><strong class="title"><?= $this->lang->line('item_like'); ?></strong>
			                        </a></li>
                   		  <?php  }?>
                   		  <?php  }?>
                   <?php if ($this->session->userdata('id')&&($this->session->userdata('id')==$item['author_id'])){  ?>
                   		<li>
                   	<?php if($item['from']=='htmleditor'||$item['from']=='aseditor'){ ?>
                   			<a href="<?=site_url('item/edit_content/'.$item['id'])?>" class='buttonstyle'><?= $this->lang->line('item_edit_code'); ?></a>
                   	<?php  }?>
                   		
                   	<?php if($item['from']=='particle'){ ?>
                   			<a href="<?=site_url('item/edit_content/'.$item['id'])?>" class='buttonstyle'><?= $this->lang->line('item_edit_online'); ?></a>
                   			<a href="<?=site_url('item/edit/'.$item['id'])?>" class='buttonstyle'><?= $this->lang->line('item_edit_info'); ?></a>
                   	<?php  }else{?>
                   			<a href="<?=site_url('item/edit/'.$item['id'])?>" class='buttonstyle'><?= $this->lang->line('item_edit_info'); ?></a>
                   	<?php  } ?>
                   	</li>
					<?php } ?>
                   	<?php if ($this->session->userdata('id')&&($this->session->userdata('id')==$item['author_id'])){  ?>
                   			<li><a target="_blank" href="<?=site_url('item/delete/'.$item['id'])?>" class='buttonstyle' onclick="return confirm(<?= $this->lang->line('item_delete_tips'); ?>)"><?= $this->lang->line('item_delete'); ?></a></li>
                   	<?php  }?>
                   	<?php if($this->session->userdata('id')) { ?>
                   			<li class="collection">
                   				<a href="javascript:" class='buttonstyle' id='collect' title="<?= $this->lang->line('item_collect_tips'); ?>"><?= $this->lang->line('item_collect'); ?></a>
                   				<ul class="items" id="c-collect">
                   					
                   					<li class="c-create">
                   						<input id="c-text" type="text" value=""/>
                   						<a href="javascript:;" id='c-submit'><?= $this->lang->line('item_collect_create'); ?></a>
                   						<p id="c-remind"><?= $this->lang->line('item_collect_create_tips'); ?></p>
                   					</li>
                   					<?php if ($my_collections) {
                   					foreach($my_collections as $collection): ?>
                   					<li class="addcollect" name="<?= $collection['id']; ?>">
                   						<span class="c-title"><?= msubstr($collection['title'],0,50); ?></span>
                   						<?php foreach ($work_in_my_collection as $works){
                   							if ($collection['id'] == $works['collection_id']){ ?>
                   						<span class="c-added"><?= $this->lang->line('item_added'); ?></span>
                   						<?php } } ?>          						
                   					</li>
                   					<?php endforeach; }?>
                   				</ul>
                   			</li>
                   	<script type="text/javascript">
						$('#collect').click(function(){  
     	 					if ($('.items').css('display') == 'none'){
     	 						$('.items').css('display','block');
         	 				} else {
         	 					$('.items').css('display','none');
         	 				}
						});

						$('.addcollect').live('click',function() {  
							var collectID = $(this).attr('name');
							var itemID = $('#likeOrdislike').attr('name');

							$.ajax({
									type:"GET" 
					 			,url:"http://www.effecthub.com/collection/add/" + itemID +"/" + collectID
					 			,contentType:'text/html;charset=utf-8'//编码格式   
								,success:function(data){
					   			$('.items').css('display','none');
									$('#collect').html('<?=$this->lang->line('item_collected') ?>');
									var t = setTimeout("$('#collect').html('<?=$this->lang->line('item_collect') ?>')",3000);
					 			}//请求成功后  
					 			,error:function(data){ 
					   			$('.items').css('display','none'); 
									$('#collect').html('<?=$this->lang->line('item_failed_to_collect') ?>');
									var t = setTimeout("$('#collect').html('<?=$this->lang->line('item_collect') ?>')",3000);
					 			}//请求错误
							});  
						});  
						
					</script>
					
					
					 
					<script>
						document.onclick = function (event) {     
			            	var e = event||window.event;  
			            	var elem = e.srcElement||e.target;  
			                  
			                if((elem.id != "c-collect")&&(elem.id != "collect")&&(elem.id != "c-text")&&(elem.id != "c-submit")) {  
         	 						$('.items').css('display','none');
			                }        

			        	} 
					</script>

					<?php } ?>
						
				</ul>
			</div>
		</div>
		
	</div>
	
	<div class="item-info">
		<div class="intro">
			<div class="description">
			<?php if ($item['desc']!=null) {
			 	echo auto_link($item['desc'], 'both', TRUE);
			} else {?>
			<span style="color:#777"><?= $this->lang->line('item_no_description'); ?></span>
			<?php }?>
			<br/><br/>
			<div style="font-size:12px">
			.<?php echo $item['extension']; ?>&nbsp;&nbsp;
			<?php echo getRealSize($item['file_size']); ?>
			</div>
			</div>
			
			<div class="tags">
				<p><span style="float:left;"><?= $this->lang->line('item_tags'); ?></span>
				<span>
					<?php foreach($tags as $tag): ?>
							<a href="<?=site_url('item/tagSearch/'.$tag)?>" rel="tag" class="tag"><strong><?php echo $tag; ?></strong></a>
					<?php endforeach; ?>
				</span>
				</p>
			</div>
			
			<div class="process">
		
			<?php if ($this->session->userdata('id')!=$item['author_id']){  ?>
					<a target="_blank" href="<?=site_url('user/writemail/'.$item['author_id'])?>">
    					<h3 class="more-from more-from-player"><?= $this->lang->line('item_ask'); ?></h3>
					</a>
			<?php  }?>

				<?php if ($item['topic_id']>0){  ?>
					<a target="_blank" href="<?=site_url('topic/'.$item['topic_id'])?>">
    					<h3 class="more-from more-from-player"><?= $this->lang->line('item_view_process'); ?></h3>
					</a>
				<?php  }else if ($item['tool']>0&&$item['is_share']!=1&&$this->session->userdata('id')&&($this->session->userdata('id')==$item['author_id'])){  ?>
					<a target="_blank" href="<?=site_url('topic/create/'.$tool['group_id'].'/'.$item['id'])?>">
    					<h3 class="more-from more-from-player"><?= $this->lang->line('item_write_process'); ?></h3>
					</a>
				<?php  }?>

			</div>
			
		</div>
		
		<div class="properties">
		<?php if ($item['tool']>0){  ?>
			<div class="using-tool">
				<h3 class="more-from more-from-player"><?= $this->lang->line('item_created_using'); ?></h3>
				<a title="<?php echo $tool['name']; ?>" href="<?=site_url('t/'.$tool['domain'])?>" style>
					<img width="60px" height="60px" alt="<?php echo $tool['name']; ?>" src="<?php echo $tool['thumb_url']; ?>">
  				</a>
  				
			</div>
		<?php }?>
			<div class="history">
				<h3 class="more-from more-from-player"><?= $this->lang->line('item_history'); ?></h3>
				<?php if ($item_history!=null) {?>
				<div class="history-text">
				<?php foreach($item_history as $_history): ?>
					<div style="border-bottom: 1px solid #d0d5cb;line-height:25px;">
						<?php echo $_history['action']; ?> <?php echo $_history['content']; ?>&nbsp;&nbsp;
						<?php if ($this->session->userdata('id')&&($this->session->userdata('id')==$item['author_id'])){  ?>
							<br/><a style="display:<?php echo $_history['download_url']?'':'none'; ?>" href="<?php echo $_history['download_url']; ?>">Rollback URL</a>
						<?php  }?>
						<a style="display:<?php echo $_history['download_url']?'':'none'; ?>" href="<?=site_url('item/history_preview/'.$_history['id'])?>">Preview</a>
						<br/><?php echo tranTime(strtotime($_history['timestamp'])); ?>
					</div>
				<?php endforeach; ?>
				</div>
				<?php }?>
			</div>
		
		
		</div>
	</div>

	
	<div id="comments-section">
	
	<?php if ($item_fav_list != null) {?>
	<div>
	<h3><?= $this->lang->line('item_fans'); ?><span class="meta"></span></h3>
 	<ol class="prevnext group" style="margin-top:10px;margin-bottom:20px">
 		<div class="fans">
		<?php foreach($item_fav_list as $_user): ?>
			<a href="<?php echo site_url('user/'.$_user['user_id']).'/'?>" style="margin:1px"><img height="30px" width="30px" title="<?php echo $_user['user_name']; ?>" src="<?php echo $_user['user_pic']; ?>" alt="<?php echo $_user['user_name']; ?>"></a>
		<?php endforeach; ?>
 		</div>
 	</ol>
 	</div>
	<?php }?>
	
	<h2 class="count section ">
	<div><span id="download-num"><?php echo $item['download_num']; ?></span> <em><?= $this->lang->line('item_downloads'); ?></em>&nbsp&nbsp&nbsp&nbsp<span id="comment-num"><?php echo $comments_num; ?></span> <em><?= $this->lang->line('item_comments'); ?></em>&nbsp&nbsp&nbsp&nbsp<?php echo $item['view_num']; ?> <em><?= $this->lang->line('item_views'); ?></em>&nbsp&nbsp&nbsp&nbsp<?php echo $item['fav_num']; ?> <em><?= $this->lang->line('item_likes'); ?></em></div>
	</h2>
	<div  style="padding-bottom:20px;border-bottom:1px #555 solid;margin-bottom:20px">
                       	<?php if ($this->session->userdata('id')){  ?>
                       	<div id="signin_form" class="gen-form">
		            	<textarea id="contentarea" name="content" class="comment-content"  style="height: 80px; width:99%;background:rgba(255, 255, 255, 1);margin-bottom:15px;" /></textarea>
		            	<a style="cursor:pointer" id="postcomment" class="form-sub" name="<?php echo $item['id']; ?>"><?= $this->lang->line('item_post_comment'); ?></a>
        		       </div>
        		       <?php  }else{?>
		             <p class='paragraphstyle'><?= $this->lang->line('item_you_must'); ?><a rel="leanModal" type="button" name="login" href="#login"  onclick="_gaq.push(['_trackEvent', 'itembtn', 'clicked', 'Click Sign Up to Comment Item'])"><?= $this->lang->line('header_log_in'); ?></a><?= $this->lang->line('item_after_login'); ?></p>
                     <a rel="leanModal" id="hiddenlink" href="#login" style="display:none"></a>
                      <?php  }?>
                       </div>
	<div id="comments" class="comments" name="<?php echo $comments_num; ?>">
	
	
	
	
	
	<?php foreach($item_comment_list as $_comment): ?>  
	
	<div class="single-comment">
			<div class="comment-user">
				<a class="comment-img" href="<?= site_url('user/'.$_comment['author_id']); ?>"><img src="<?= $_comment['author_pic'] ?>" /></a>
				<div class="comment-username">
					<a href="<?= site_url('user/'.$_comment['author_id']); ?>"><?= $_comment['author_name']; ?></a>
					<span><?= trantime(strtotime($_comment['create_date'])); ?></span>
					<?php if ($this->session->userdata('id')) {?><a id="comment-reply"><?= $this->lang->line('item_reply') ?></a><?php } ?>
				
				</div>
			</div>
			
			<div id="reply-area">
				<textarea rows="1" name="reply-content" class="reply-content"></textarea>
				<a style="cursor:pointer;" class="reply-content form-sub" name="<?php echo $_comment['id']; ?>"><?= $this->lang->line('item_reply'); ?></a>
			</div>
			
			<div class="t-content">
				<?php if ($_comment['parent_id']!=0&&$_comment['parent_id']!=null) { ?>
				
				<div class="parent-comment">
					
					<span><?= $_comment['parent_user']; ?> <?= trantime(strtotime($_comment['parent_date'])); ?></span>
					<p><?= $_comment['parent_content']; ?></p>
					
				</div>
				
				<?php } ?>
				
				<p><?= $_comment['content']; ?></p>
				
			</div>
		
		</div>
                  
        <?php endforeach; ?>
		
		<?php if ($this->session->userdata('id')) {?>
		<script>
			$('#comment-reply').live('click',function(){
				
				var obj = $(this).parent().parent('.comment-user').next('#reply-area');
				if (obj.css('display')=='block') {
					obj.css('display','none');	
				} else {
					obj.css('display','block');
				}	
			});

			$('a.reply-content').live('click',function(){
				var itemID = $('#postcomment').attr('name');
				var content = $(this).prev('.reply-content').val();
				var parent = $(this).attr('name');
				
				var reply = $(this).parent('#reply-area');
				
				if (content=="") {
					return;
				}
				
				$.post(

			       "<?= site_url('item/savecomment'); ?>",
			       {
			    		item_id:itemID,
			        	content:content,
			        	parent_id:parent
			       },
			       function(data,status){  
			       		location.href= "<?= site_url('item/'.$item['id']) ?>";
			       }
			   ); 
				
			});
			
		</script>
	<?php } ?>

	</div>
	
	<?php if ($more_comments == 1) {?>
	
	<div class="more-comments" name="<?php echo $item['id']; ?>"> <?= $this->lang->line('item_more_comments'); ?> </div>
	
	<script>
		$('.more-comments').click(function() {

			$('.more-comments').css('background','#222');
			
			$('.more-comments').html('<?= $this->lang->line('item_loading_comments'); ?>');

			var offset = $('div.single-comment').length;

			$.post(
				"<?= site_url('item/more_comments') ?>",
				{
					itemID: $(this).attr('name'),
					offset: offset
				},
				function(data,status){
					if (status == 'success' ){
						$('div#comments').append(data);

						$('.more-comments').css('background','#555');
						
						offset = $('div.single-comment').length;
						var count = $('.comments').attr('name');
						if (offset >= count){
							$('.more-comments').css('display','none');
						} else {
							$('.more-comments').html('<?= $this->lang->line('item_more_comments'); ?>');
						}
					}
				}
			);

		});
		
	</script>
	
	<?php }?>
</div>

<div class="screenshot-meta item-second">

<?php if ($item['work_id']>0){  ?>
<h3 class="more-from more-from-player"><?= $this->lang->line('item_assets_of'); ?><span class="meta"></span></h3>
	<ol class="prevnext group" style="margin-top:10px">
	<li>
		<a title="<?php echo $work['title']; ?>" href="<?=site_url('item/'.$work['id'])?>">
		<?php if($work['thumb_url']!=null||$work['pic_url']!=null){ ?>
  <img width="90px" height="72px" alt="<?php echo $work['title']; ?>" src="<?php echo $work['thumb_url']; ?>">
  <?php  }else{?>
  	<iframe src="<?=site_url('item/preview_html/'.$work['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 78px; height: 60px;padding:6px;margin:0px;background:#333"></iframe>
  <?php  }?>
		</a>
           
</ol>
<?php  }?>	
<!--
<?php if (count($work_file_list)>0){  ?>
<h3 class="more-from more-fro m-player"><span class="meta"><?php echo count($work_file_list); ?></span> <?= $this->lang->line('item_files'); ?></h3>
	<ol class="prevnext group" style="margin-top:10px">
	<?php foreach($work_file_list as $_hot_item): ?>
                        <li>
		<a title="<?php echo $_hot_item['title']; ?>" href="<?=site_url('item/'.$_hot_item['id'])?>"><?php echo $_hot_item['title']; ?></a>
                        <?php endforeach; ?>
</ol>
<?php  }?>	
-->
<h3 class="more-from more-from-player"><?= $this->lang->line('item_embed'); ?></h3>
<input id="edit_html_addr" class="edit_addr" style="margin:10px;margin-left:0;height:30px;width:100%"><br/>	
<br/>
<h3 class="more-from more-from-player"><?= $this->lang->line('item_qrcode'); ?><span class="meta"></span></h3>
<ol class="prevnext group" style="margin-top:10px">
<li>
<?php if ($lang==2){  ?>
<img width="100px" height="100px" alt="<?php echo $item['title']; ?>" src="http://qr.liantu.com/api.php?&bg=ffffff&fg=000000&w=200&h=200&text=<?php echo site_url('item/download/'.$item['id']) ?>">
<?php  }else{?>
<img width="100px" height="100px" alt="<?php echo $item['title']; ?>" src="https://chart.googleapis.com/chart?cht=qr&chs=200x200&choe=UTF-8&chld=L|4&chl=<?php echo site_url('item/download/'.$item['id']) ?>">
<?php  }?>	
</li>
</ol><br/>

<?php if ($item['parent_id']>0){  ?>
<h3 class="more-from more-from-player"><?= $this->lang->line('item_forked_from'); ?><span class="meta"></span></h3>
	<ol class="prevnext group" style="margin-top:10px">
	<li>
		<a title="<?php echo $parent['title']; ?>" href="<?=site_url('item/'.$parent['id'])?>">
		<?php if($parent['thumb_url']!=null||$parent['pic_url']!=null){ ?>
  <img width="90px" height="72px" alt="<?php echo $parent['title']; ?>" src="<?php echo $parent['thumb_url']; ?>">
  <?php  }else{?>
  	<iframe src="<?=site_url('item/preview_html/'.$parent['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 78px; height: 60px;padding:6px;margin:0px;background:#333"></iframe>
  <?php  }?>
		</a>
           
</ol>
<?php  }?>

<?php if (count($fork_list)>0){  ?>
<h3 class="more-from more-fro m-player"><span class="meta"><?php echo count($fork_list); ?></span> <?= $this->lang->line('item_branches'); ?></h3>
	<ol class="prevnext group" style="margin-top:10px">
	<?php foreach($fork_list as $_hot_item): ?>
                        <li>
		<a title="<?php echo $_hot_item['title']; ?>" href="<?=site_url('item/'.$_hot_item['id'])?>"><img style="width:90px;height:72px" src="<?php echo $_hot_item['thumb_url']==null?$_hot_item['pic_url']:$_hot_item['thumb_url']; ?>"></a>
                        <?php endforeach; ?>
</ol>
<?php  }?>
 	<?php if($in_collections != null) {?>
 <h3 class="more-from more-from-player"><?= $this->lang->line('item_collected_in'); ?><span class="meta"></span></h3>
	<ol class="prevnext group" style="margin-top:10px">

	<?php foreach($in_collections as $_collect): ?>
                        <li>
		<a title="<?php echo $_collect['title']; ?>" href="<?=site_url('collection/show/'.$_collect['id'])?>">
		<?php echo $_collect['title']; ?>
  <!--<img width="90px" height="72px" alt="<?php echo $_collect['title']; ?>" src="<?php echo $_collect['pic_url']; ?>">-->
		</a>
                        <?php endforeach; ?>
</ol>
 <?php }?>
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
	<h3 class="more-from more-from-player"><a href="<?=site_url('user/'.$item['author_id'])?>"><?php echo $item['author_name']; ?></a><?= $this->lang->line('item_more_works'); ?></h3>
	<ol class="prevnext group" style="margin-top:10px">
	<?php foreach($user_item_list as $_user_item): ?>
                        <li>
		<a title="<?php echo $_user_item['title']; ?>" href="<?=site_url('item/'.$_user_item['id'])?>">
		<?php if($_user_item['thumb_url']!=null||$_user_item['pic_url']!=null){ ?>
  <img width="90px" height="72px" alt="<?php echo $_user_item['title']; ?>" src="<?php echo $_user_item['thumb_url']; ?>">
  <?php  }else{?>
  	<iframe src="<?=site_url('item/preview_html/'.$_user_item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 78px; height: 60px;padding:6px;margin:0px;background:#333"></iframe>
  <?php  }?>
		
		</a>	</li>
                        <?php endforeach; ?>
</ol>
<?php if(($item['pic_url']!=null&&$item['pic_url']!='')){ ?>
<h3 class="more-from more-from-player"><?= $this->lang->line('item_screenshot'); ?><span class="meta"></span></h3>
<ol class="prevnext group" style="margin-top:10px">
<li>	<img alt="<?php echo $item['title']; ?>" style="width:200px;" src="<?php echo $item['thumb_url']; ?>"></li>
</ol><br/>
<?php  }?>


<h3 class="more-from more-from-player"><?= $this->lang->line('item_ads'); ?><span class="meta"></span></h3>
<ol class="prevnext group" style="margin-top:10px">
<li><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Effecthub -->
<ins class="adsbygoogle"
     style="display:inline-block;width:200px;height:200px"
     data-ad-client="ca-pub-2434823751262999"
     data-ad-slot="7085536553"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></li>
</ol><br/>
</div> <!-- /secondary -->

	<div class="screenshot-meta">
	</div>
</div> <!-- /main -->


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
				    <a class="addthis_login_twitter" title=<?= $this->lang->line('pop_login_twitter'); ?> href="<?=site_url('login/twitter')?>"><span id="twitter-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_facebook" title=<?= $this->lang->line('pop_login_facebook'); ?> href="<?=site_url('login/facebook')?>"><span id="facebook-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_google" title=<?= $this->lang->line('pop_login_google'); ?> href="<?=site_url('login/google')?>"><span id="google-connect" class="ssi-button"></span></a>
						            
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
					    <input class="save-btn" name="commit" type="submit" value="Sign In">
					   <!-- <a style="float:right;margin-top:10px;margin-right:10px;" target="_blank" href="<?=site_url('register')?>">Sign Up &raquo;</a>&nbsp;&nbsp;&nbsp;&nbsp;-->
					</div>
					<input type="hidden" name="redirectURL" value="<?=site_url('item/'.$item['id'])?>"/>
					
					
					</form>
				</div>


	<div id="register-ct">
	<div class="txt-fld" style="padding:0px 20px 35px 20px">
				    <a class="addthis_login_twitter" title=<?= $this->lang->line('pop_sign_up_twitter'); ?> href="<?=site_url('login/twitter')?>"><span id="twitter-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_facebook" title=<?= $this->lang->line('pop_sign_up_facebook'); ?> href="<?=site_url('login/facebook')?>"><span id="facebook-connect" class="ssi-button"></span></a>
						            <a class="addthis_login_google" title=<?= $this->lang->line('pop_sign_up_google'); ?> href="<?=site_url('login/google')?>"><span id="google-connect" class="ssi-button"></span></a>
						            
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
					    <input class="save-btn" name="commit" type="button" value="<?= $this->lang->line('pop_sign_up_free'); ?>" onclick="checksignup();_gaq.push(['_trackEvent', 'signup', 'clicked', 'Click Sign Up Button In Item Page'])">
					</div>
						<input type="hidden" name="redirectURL" value="<?=site_url('item/'.$item['id'])?>"/>
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
	
	<?php if ($item['price']>0) {?>

	<?php if (isset($download)&&(!$download)) {?>	
	
	<div class="remind" id="enough">
		<p>-<?php echo $item['price']?> 
		
		<?php
		if($item['price_type']==1)echo $this->lang->line('item_pricetype1');
		if($item['price_type']==2)echo $this->lang->line('item_pricetype2');
		if($item['price_type']==3)echo $this->lang->line('item_pricetype3');
		  ?></p>
	</div>
	
	<div class="remind" id="not-enough">
		<p><?= $this->lang->line('item_coin_hint'); ?></p>
	</div>

	<script>
		var dwld = 0;
		

		// judge whether the coin is enough to download
		function cost(){
			
			var enough = false;
			
			var price = $('#screenshot-title-section').attr('name');
			var itemID = $('#likeOrdislike').attr('name');
			
			$.ajax({
				type:"GET" 
		        ,url:"http://www.effecthub.com/item/enough/"+itemID
		        ,contentType:'text/html;charset=utf-8'//编码格式
				,async:false
				,success:function(data){
					var point = parseInt(data);  

			        if (point ==1) {
						costremind();
						enough = true;
				    }
			        else {
				        emptyremind();
				        enough = false;
			        }
			    
		        }//请求成功后  
			});
			return enough;
		}
		
		function costremind(){
			if (dwld == 0) {	
				dwld = 1;
				var remind = $('#enough');
				remind.css('display','block');
				remind.animate({opacity:'1'},1500);
				remind.animate({opacity:'1'},3000);
				remind.animate({opacity:'0'},1500,function(){
					$('#enough').css('display','none');
				});

			}
		}

		function emptyremind(){

			var remind = $('#not-enough');
			remind.css('display','block');
			remind.animate({opacity:'1'},1000);
			remind.animate({opacity:'1'},2000);
			remind.animate({opacity:'0'},1000,function(){
				$('#not-enough').css('display','none');
			});

		}


	</script>

	
	<?php }}?>
	
	<?php $comment = get_cookie('new_comment'); 
	if (isset($comment)&&($comment!= null)&&($comment == 1)) {?>

	<div class="remind" id="earn">
		<p>+1 <?= $this->lang->line('item_coin'); ?></p>
	</div>
	
	<script>

	$(function(){

		var remind = $('#earn');
		remind.css('display','block');
		remind.animate({opacity:'1'},1000);
		remind.animate({opacity:'1'},2000);
		remind.animate({opacity:'0'},1000,function(){
			$('#earn').css('display','none');
		});

	});

	</script>
	
	<?php $cookie = array(
			'name'   => 'new_comment',
			'value'  => 0,
			'expire' => '5',
		);
		set_cookie($cookie);
		} ?>
	
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
	
	
	
	
	
	<?php $new = get_cookie('new_item');
		if (isset($new)&&($new!= null)&&($new == 1)) {?>

	<div class="remind" id="new-earn">
		<p>+10 <?= $this->lang->line('item_coins'); ?></p>
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
			'name'   => 'new_item',
			'value'  => 0,
			'expire' => '5',
		);
		set_cookie($cookie);
	
	}

	$first = get_cookie('first_login');

	if (isset($first)&&($first!= null)&&($first == 1)) {?>
	 
	<div class="remind" id="first-login">
		<p><span style='font-size:16px;color:#bbb;'><?= $this->lang->line('pop_everyday_login'); ?></span> +1 <?= $this->lang->line('item_coin'); ?></p>
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
	
	
	<script type="text/javascript">

		var firefox = navigator.userAgent.indexOf('Firefox') != -1;

		function stopscroll(e){
			e = e||window.event;
			if (e.stopPropagation) e.stopPropagation();
			else e.cancelBubble = true;
			if (e.preventDefault) e.preventDefault();
			else e.returnValue = false;

		}
		
		window.onload = function(){

			var item = document.getElementById('item-preview');
			
			firefox ? item.addEventListener('DOMMouseScroll', stopscroll, false) : (item.onmousewheel = stopscroll);

		}
	

	</script>
	  
	
</div>



<?php $this->load->view('footer') ?>
