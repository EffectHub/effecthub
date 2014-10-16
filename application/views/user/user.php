<?php $this->load->view('header') ?>
<!--
<script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAT68YBldHJ2B05MT05QsDNeXBmuz3p_90&sensor=true&language=en">
    </script>
    <script type="text/javascript">
      var map;
      var marker;
      var currentLocation;
      function initialize() {
         var geocoder = new google.maps.Geocoder();
         var mapOptions = {
            zoom: 4,
            mapTypeId: google.maps.MapTypeId.ROADMAP
         }
         map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
 
         marker = new google.maps.Marker ({
         	 map: map,
             title: "Author's Location"
         });
         if($('#logineduser').attr('name') == "myself"){
         	marker.setDraggable(true);
         	marker.setTitle("You can drag this icon to change your location");
         }
         
         var lat = $('#userLatitude').attr('name');
         var lon = $('#userLongitude').attr('name');
         if(lat != null && lon != null && lat != "" && lon != ""){
         	var myLatlng = new google.maps.LatLng(lat*1,lon*1);
         	marker.setPosition(myLatlng);
         	map.setCenter(myLatlng);
         	currentLocation = marker.getPosition();
         }else{
         var address = $('#countryCode').attr('name');
         geocoder.geocode( { 'address': address}, function(results, status) {
         if (status == google.maps.GeocoderStatus.OK) {
           map.setCenter(results[0].geometry.location);
           /*marker = new google.maps.Marker({
             map: map,
             position: results[0].geometry.location,
             draggable:true
           });*/
           marker.setPosition(results[0].geometry.location);
           currentLocation = marker.getPosition();
         }else {
          alert('Geocode was not successful for the following reason: ' + status);
         }
        });
       } 
       
        google.maps.event.addListener(marker, 'dragend', function(e) {
            var point = marker.getPosition();
            map.panTo(point);
        });
     }
     
     function getLocation() {
         var point = marker.getPosition();
         //alert("lng is:" + point.lng() + ",lat is:" + point.lat());
         var userID = $('#userid').attr('name');
         $.ajax({  
             type:"GET" 
             ,url:"<?php echo site_url('user/saveuserlocation')?>/"+userID  
             ,data:{latitude:point.lat(), longitude:point.lng()}                                
             ,contentType:'text/html;charset=utf-8'//编码格式   
             ,success:function(data){  
                 alert("Save Location Successfully!");  
             }//请求成功后  
             ,error:function(data){  
                
             }//请求错误  
          });
        currentLocation = point;
     }
     
     function cancelDrag(){
     	marker.setPosition(currentLocation);
     	map.panTo(currentLocation);
     }   
     
     google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    -->
<div id="content" class="group">


<div class="profile-actions group">
	<ul class="profile-tabs">
		<li class="followers">
	
		<a href="<?=site_url('user/showfollowers/'.$user['id'])?>">		<span class="count"><?php echo $user['follower_num']; ?></span>
		<span class="meta"><?= $this->lang->line('user_followers');?></span>
</a>
</li>
		
		<li class="following">
	
		<a href="<?=site_url('user/showfollowing/'.$user['id'])?>">		<span class="count"><?php echo $user['follow_num']; ?></span>
		<span class="meta"><?= $this->lang->line('user_followings');?></span>
</a>
</li>
		
		<li class="listed">
	
		<a href="<?=site_url('user/'.$user['id'])?>">		<span class="count"><?php echo $works_num; ?></span>
		<span class="meta"><?= $this->lang->line('user_works');?></span>
</a>
</li>


	</ul>
</div>


<div class="full">
	<div class="profile vcard group ">
	<div data-picture="" data-alt="<?php echo $user['displayName']; ?>" data-class="photo">
	<img alt="<?php echo $user['displayName']; ?>" class="photo" src="<?php echo $user['pic_url']; ?>">	</div>
	<h1>
		<span class="fn edit">
			<a href="<?=site_url('user/'.$user['id'])?>"><?php echo $user['displayName']; ?></a>
			<span class="badge badge-pro">
	          <?php echo get_level($user['level'],$user['point']); ?>
	          </span>
		</span>
	</h1>

	<ul class="profile-details">
		<li>
			<a href="<?=site_url('author/countrySearch/'.$user['countryCode'])?>" class="locality"><?php echo $country_name; ?></a>
		</li>
		<?php if ($user['homepage']!=null){  ?>
		<li><a href="<?php echo $user['homepage']; ?>" class="url" rel="me" target="_blank"><?php echo $user['homepage']; ?></a></li>
		<?php  }?>
		<?php foreach($social_list as $social): ?>
                         		<?php if( $social['type']=='twitter'){ ?>
			                     <li><a class="twitter-player-link" target="_blank" href="<?php echo $social['link']; ?>"><img class="ico_twitter"/></a></li>&nbsp;
						         <?php } ?>
						         <?php if( $social['type']=='facebook'){ ?>
			                     <li><a target="_blank" href="<?php echo $social['link']; ?>"><img class="ico_facebook"/></a></li>&nbsp;
						         <?php } ?>
						         <?php if( $social['type']=='sina'){ ?>
			                     <li><a target="_blank" href="<?php echo $social['link']; ?>"><img class="ico_sina"/></a></li>&nbsp;
						         <?php } ?>
						         <?php if( $social['type']=='google'){ ?>
			                     <li><a target="_blank" href="<?php echo $social['link']; ?>"><img class="ico_google"/></a></li>&nbsp;
						         <?php } ?>
						         <?php if( $social['type']=='behance'){ ?>
			                     <li><a target="_blank" href="<?php echo $social['link']; ?>"><img class="ico_behance"/></a></li>&nbsp;
						         <?php } ?>
						          <?php endforeach; ?>
	</ul>

	

	
	


	<?php if ($this->session->userdata('id')&&$this->session->userdata('id')!=$user['id']){  ?>
	<div class="follow-prompt">
		<?php if ($follow!=null){  ?>
		<a href="<?=site_url('user/unfollow/'.$user['id'])?>" class="unfollow" style="display:block;float:right"><?= $this->lang->line('user_unfollow');?></a>
		<?php  }else{?>
		<a href="<?=site_url('user/follow/'.$user['id'])?>" class="follow" style="display:block;float:right"><?= $this->lang->line('user_follow');?></a>
		<?php  }?>
	</div>
	<?php  }?>
	<?php if ($this->session->userdata('id')&&$this->session->userdata('id')==$user['id']){ ?>
		<?php if($feature=='collection'){?>
		<a class="form-sub tagline-action" style="float:right" href="<?php echo site_url('collection/create')?>"><?= $this->lang->line('user_create_collection');?></a>
		<?php } else{ ?>
		<?php } ?>
	<?php  }?>



<div class="member-actions">
	 <?php if ($this->session->userdata('id')&&$this->session->userdata('id')!=$user['id']){  ?>
                        <div style="padding-top:10px">
                            <a href="<?=site_url('user/writemail/'.$user['id'])?>"><div class="iconimg">
                               <img src="<?=base_url()?>images/message.jpg"> <?= $this->lang->line('user_send_message');?>
                            </div></a>
                        </div>
                        <?php  }?>
</div>


	
</div>

</div>

<div id="main">
	
	<ul class="tabs">
		<li class="<?php echo $feature=='works'?'active':'' ?>">
	
		<a href="<?=site_url('user/'.$user['id'])?>">		<span class="meta"><?= $this->lang->line('user_works');?></span>
		<span class="count"></span>
</a>
</li>


	<li class="<?php echo $feature=='likes'?'active':'' ?>">
	
		<a href="<?=site_url('item/mylike/'.$user['id'])?>">		<span class="meta"><?= $this->lang->line('user_likes');?></span>
		<span class="count"></span>
</a>
</li>
	<li class="<?php echo $feature=='collection'?'active':'' ?>">
	
		<a href="<?=site_url('collection/index/'.$user['id'])?>">		<span class="meta"><?= $this->lang->line('user_collections');?></span>
		<span class="count"></span>
</a>
</li>

	<li class="total-num">
		<?php if ($feature=='works') {
			echo $works_num; ?> <?php echo strtolower($this->lang->line('user_works'));
		} else if ($feature=='likes') {
	echo $likes_num; ?> <?php echo strtolower($this->lang->line('user_likes'));
		} else if ($feature=='collection') {
	echo $collections_num; ?> <?php echo strtolower($this->lang->line('user_collections'));
		}?>
			
	</li>
	


</ul>
	

		<ol class="effecthubs group">
		<?php foreach($user_item_list as $_user_item): ?>
		
		<li id="screenshot-1085677" class="group ">
	<div class="effecthub">
		<div class="effecthub-shot">
			<div class="effecthub-img">
	<a href="<?=site_url('item/'.$_user_item['id'])?>" class="effecthub-link"><div data-picture="" data-alt="<?php echo $_user_item['title']; ?>">
	<?php if($_user_item['thumb_url']!=null||$_user_item['pic_url']!=null){ ?>
  <span class="item_image_wrap" alt="<?php echo $_user_item['title']; ?>">
                        <span class="item_image" style="background-image:url(<?php echo $_user_item['thumb_url']; ?>)"></span>
  </span>
 <?php  }else{?>
  	<iframe src="<?=site_url('item/preview_html/'.$_user_item['id'])?>" scrolling="no"   frameborder="NO" border="0" framespacing="0" style="width: 300px; height: 200px;padding:0px;margin:0px;"></iframe>
  <?php  }?>
</div></a>
	<a href="<?=site_url('item/'.$_user_item['id'])?>" class="effecthub-over" style="opacity: 0;">		<strong><?php echo $_user_item['title']; ?></strong>
		<span class="comment"><?php echo msubstr($_user_item['desc'],0,200).'...'; ?></span>

		<em class="timestamp"><?php echo $_user_item['create_date']; ?></em>
</a></div>
			<ul class="tools group" style="visibility: visible;">
	<li class="fav">
		<a href="<?=site_url('item/'.$_user_item['id'])?>" title="<?= $this->lang->line('work_likes') ?>"><?php echo $_user_item['fav_num']; ?></a>
	</li>
	<li class="cmnt">
		<a href="<?=site_url('item/'.$_user_item['id'])?>#comments" title="<?= $this->lang->line('work_comments') ?>"><?php echo $_user_item['comment_num']; ?></a>
	</li>
	<li class="views"><?php echo $_user_item['view_num']; ?></li>
</ul>

		</div>
		<div class="extras">
			<?php if($_user_item['parent_id']!=0&&$_user_item['parent_id']!=null){ ?>
				<a href="<?=site_url('item/'.$_user_item['parent_id'])?>" style="display: inline;"><span rel="tipsy" class="rebound-mark is-rebound" style="display: inline;" original-title="<?= $this->lang->line('work_fork') ?>">
					<img alt="Rebound" height="16" src="<?=base_url()?>images/icon-rebound-2x.png" width="16">
				</span></a>
				<?php  }?>
				<?php if($_user_item['platform']>0){ ?>
     			<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_platform_first') ?> <?php echo $_user_item['platform_name']; ?> <?= $this->lang->line('work_platform') ?>">
				<img alt="Attachments" height="16" src="<?php echo $_user_item['platform_pic']; ?>" width="16">
				</span>
				<?php  }?>
				<?php if($_user_item['tool']>0){ ?>
     			<a href="<?=site_url('t/'.$_user_item['tool_domain'])?>" style="display: inline;">
     			<span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_tool_first') ?> <?php echo $_user_item['tool_name']; ?><?= $this->lang->line('work_tool') ?>">
				<img alt="Attachments" height="16" src="<?php echo $_user_item['tool_pic']; ?>" width="16">
				</span>
				</a>
				<?php  }?>
				<?php if($_user_item['from']=='htmleditor'){ ?>
     			<a href="<?=site_url('item/fork/'.$_user_item['id'])?>" style="display: inline;"><span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_html') ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/code.png" width="16">
				</span></a>
				<?php  }?>
				<?php if($_user_item['from']=='aseditor'){ ?>
     			<a href="<?=site_url('item/fork/'.$_user_item['id'])?>" style="display: inline;"><span rel="tipsy" class="rebound-mark" style="display: inline;" original-title="<?= $this->lang->line('work_actionscript') ?>">
				<img alt="Attachments" height="16" src="<?=base_url()?>images/code.png" width="16">
				</span></a>
				<?php  }?>
				<?php if($_user_item['download_url']!=0||$_user_item['download_url']!=null){ ?>
     			<a target="_blank" href="<?=site_url('item/download/'.$_user_item['id'])?>" style="display: inline;"><span rel="tipsy" class="attachments-mark" style="display: inline;" original-title="<?= $this->lang->line('work_download') ?>">
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



</div> <!-- /main -->

<div class="secondary">

<?php if ($user['desc']!=null) {?>
	<h3><?= $this->lang->line('user_introduction') ?></h3>
	
	
	<div class="profile-data">
		<p class="copy">
			<?php echo $user['desc']; ?>
		</p>

	</div>
	<?php }?>
	<!--
	<h3><?= $this->lang->line('user_location') ?></h3>
	<div id="userLatitude" name="<?php echo $user['latitude']; ?>"></div>
           <div id="userLongitude" name="<?php echo $user['longitude']; ?>"></div>
               <div id="countryCode" name="<?php echo $country_name; ?>"></div>
	
	<div class='floatleft' id="map_canvas" style="width:225px; height:140px;margin-right:5px;">
                    </div>
                    <?php if ($this->session->userdata('id')&&$this->session->userdata('id')==$user['id']){  ?>
                    <div class='floatleft smallgrayword' style="padding-top:15px" id="logineduser" name="myself">
                         
                         <b><?= $this->lang->line('user_location') ?>:</b> <a class="btn-green btn-small" style="color:#ddd" href="#" onclick="getLocation()">Save</a> <a class="btn-green btn-small" style="color:#ddd" href="#" onclick="cancelDrag()">Cancel</a>
                     </div>
                     <?php  }?>	
                     
	
<br><br>
	-->

<!--
	<h3>Recent <span class="meta">Activity</span></h3>
<ul class="activity-mini">
		<li class="followed">
	<strong>Followed</strong> <a href="/theGoldenWest" class="url" rel="contact">Bret Baker</a>.
	<em class="time">5 days ago</em>
</li>

	<li class="followed">
	<strong>Followed</strong> <a href="/humcreative" class="url" rel="contact">Hum Creative</a>.
	<em class="time">6 days ago</em>
</li>
</ul>
-->

<h3><?= $this->lang->line('user_statistics');?> <span class="meta"></span></h3>
<ol id="tags" class="tags group">
	<div style="font-size:11px">
	<?= $this->lang->line('user_coins');?>: <?php echo $user['point']; ?> <br/><br/>
	<?= $this->lang->line('user_works_views');?> <?php echo $view_num; ?> <br/><br/>
	<?= $this->lang->line('user_appreciations');?> <?php echo $fav_num; ?> <br/><br/>
	<?= $this->lang->line('user_member_since');?> <?php echo $user['create_time']; ?><br/>
</div>
	</ol>

<h3><?= $this->lang->line('user_tags');?> <span class="meta"></span></h3>
<ol id="tags" class="tags group">
	<?php foreach($tags as $tag): ?>
	<li id="tag-li-<?php echo $tag; ?>" class="tag" style="float:left">
	<em></em>
	<a href="<?=site_url('item/tagSearch/'.$tag)?>" rel="tag"><strong><?php echo $tag; ?></strong>
	</a>
	</li>
	<?php endforeach; ?>
</ol>
	
<h3><?= $this->lang->line('user_recent_activity');?> <span class="meta"></span></h3>
<ol class="effecthubs group">
	<?php foreach($activity_list as $_status): ?>
                   <div class='commentitem' style='font-size:11px;border-bottom: 1px dashed #CDCDCD;padding-bottom:10px;'>
                            
                            <div>
                                
                                	<div class="commenttext">
                                	<?php if ($_status['status_type']==1) { 
	                                	echo $this->lang->line('userstatus_type1'); ?>
                                		<a href="<?= site_url('user/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==2) {
                                		echo $this->lang->line('userstatus_type2'); ?>
                                		<a href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                	
                                	<?php } else if ($_status['status_type']==3) {
                                		echo $this->lang->line('userstatus_type3'); ?>
                                		<a href="<?= site_url('topic/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==4) {
                                		echo $this->lang->line('userstatus_type4'); ?>
                                		<a href="<?= site_url('team/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                		
                                	<?php } else if ($_status['status_type']==5) {
                                		echo $this->lang->line('userstatus_type5'); ?>
                                		<a href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==6) {
                                		echo $this->lang->line('userstatus_type6'); ?>
                                		<a href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==7) {
                                		echo $this->lang->line('userstatus_type7'); ?>
                                		
                                	<?php } else if ($_status['status_type']==8) {
                                		echo $this->lang->line('userstatus_type8'); ?>
                                		<a href="<?= site_url('topic/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==9) {
                                		echo $this->lang->line('userstatus_type9'); ?>
                                		<a href="<?= site_url('collection/show/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==10) {
                                		echo $this->lang->line('userstatus_type10'); ?>
                                		<a href="<?= site_url('collection/show/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==11) {
                                		echo $this->lang->line('userstatus_type11'); ?>
                                		<a href="<?= site_url('collection/show/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==12) {
                                		echo $this->lang->line('userstatus_type12'); ?>
                                		<a href="<?= site_url('folder/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                		
                                	<?php } else if ($_status['status_type']==13) {
                                		echo $this->lang->line('userstatus_type13'); ?>
                                		<a href="<?= site_url('item/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==14) {
                                		echo $this->lang->line('userstatus_type14'); ?>
                                		<a href="<?= site_url('folder/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==15) {
                                		echo $this->lang->line('userstatus_type15'); ?>
                                		<a href="<?= site_url('group/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==16) {
                                		echo $this->lang->line('userstatus_type16'); ?>
                                		<a href="<?= site_url('group/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==17) {
                                		echo $this->lang->line('userstatus_type17'); ?>
                                		<a href="<?= site_url('folder/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==18) {
                                		echo $this->lang->line('userstatus_type18'); ?>
                                		<a href="<?= site_url('folder/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==19) {
                                		echo $this->lang->line('userstatus_type19'); ?>
                                		<a href="<?= site_url('task/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==20) {
                                		echo $this->lang->line('userstatus_type20'); ?>
                                		<a href="<?= site_url('task/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==21) {
                                		echo $this->lang->line('userstatus_type21'); ?>
                                		<a href="<?= site_url('task/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } else if ($_status['status_type']==22) {
                                		echo $this->lang->line('userstatus_type22'); ?>
                                		<a href="<?= site_url('tool/'.$_status['target_id']) ?>"><?= $_status['target_name'] ?></a>
                                		
                                	<?php } ?>                                	</div>
                                	 <p style="color:#777;"><?php echo tranTime(strtotime($_status['timestamp'])); ?></p>
                                </div>
                            
                            
                            <!-- 
                            
                            <div>
                                <?php if (!strpos($_status['content'],'avatar')){  ?>
                                <div class="commenttext" style='font-size:12px;margin-top:10px;'><?php echo $_status['action']; ?> 
                                <?php if ($_status['content']!=''&&$_status['content']!=null){  ?>
                                <?php echo $_status['content']; ?>
                                <?php  }else{?>
                                <a href="<?php echo $_status['target_url']?>"><?php echo $_status['target_name']?></a>	
                                <?php  }?>	
                               
                                </div>
                                
                                <?php  }else{?>
                                	<div class="commenttext" style='font-size:12px;margin-top:10px;'>changed his avatar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo tranTime(strtotime($_status['timestamp'])); ?></div><br/>
                                    
                                <?php  }?>
                            </div>
                            
                             -->
                   </div> 
                <?php endforeach; ?>
                
	  

	</ol>

</div> <!-- /secondary -->



</div>






<?php $this->load->view('footer') ?>
