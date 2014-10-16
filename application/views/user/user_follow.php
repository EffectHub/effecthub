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

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="<?=base_url()?>images/icon-x-30-white.png" width="15">
	</a>
</div>



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
			                     <li><a target="_blank" href="<?php echo $social['link']; ?>"><img class="ico_twitter"/></a></li>&nbsp;
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

	

	
	

	
<div class="follow-prompt">
<?php if ($this->session->userdata('id')&&$this->session->userdata('id')!=$user['id']){  ?>
                            <?php if ($follow!=null){  ?>
<a href="<?=site_url('user/unfollow/'.$user['id'])?>" class="unfollow" style="display:block;float:right"><?= $this->lang->line('user_unfollow');?></a>
<?php  }else{?>
<a href="<?=site_url('user/follow/'.$user['id'])?>" class="follow" style="display:block;float:right"><?= $this->lang->line('user_follow');?></a>
<?php  }?><?php  }else{?>
	
	<?php  }?>
</div>


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
		<li class="<?php echo $feature=='following'?'active':'' ?>">
	
		<a href="<?=site_url('user/showfollowing/'.$user['id'])?>">		<span class="meta"><?= $this->lang->line('user_followings');?></span>
		<span class="count"></span>
</a>
</li>


	<li class="<?php echo $feature=='follower'?'active':'' ?>">
	
		<a href="<?=site_url('user/showfollowers/'.$user['id'])?>">		<span class="meta"><?= $this->lang->line('user_followers');?></span>
		<span class="count"></span>
</a>
</li>


</ul>
	

		<ol class="group-cards">
	<?php foreach($users as $_author): ?>	
		<li class="user-row-2645 group group ">
	<div class="group-info">
		<h2 class="vcard">
			<a href="<?=site_url('user/'.$_author['id'])?>" class="url" rel="contact" title="<?php echo $_author['displayName']; ?>"><div data-picture="" data-alt="<?php echo $_author['displayName']; ?>" data-class="photo">
	
<img alt="<?php echo $_author['displayName']; ?>" class="photo" src="<?php echo $_author['pic_url']; ?>"></div> <?php echo $_author['displayName']; ?></a>

			<span class="meta">
					<a href="<?=site_url('author/countrySearch/'.$_author['countryCode'])?>" class="locality"><?php echo $_author['country_name']; ?></a>
			</span>

		</h2>
<div class="follow-prompt">
	<a href="<?=site_url('user/follow/'.$_author['id'])?>" class="follow">
		<span><?= $this->lang->line('user_follow');?></span>
</a>
</div>
		<ul class="group-stats group">
	<li class="stat-works">
		<a href="<?=site_url('user/showfollowing/'.$_author['id'])?>"><?php echo $_author['follow_num']; ?>
			<span class="meta"><?= strtolower($this->lang->line('user_followings'));?></span>
</a>	</li>

	<li class="stat-followers">
		<a href="<?=site_url('user/showfollowers/'.$_author['id'])?>"><?php echo $_author['follower_num']; ?>
			<span class="meta"><?= strtolower($this->lang->line('user_followers'));?></span>
</a>	</li>
</ul>

	</div>


</li>
<?php endforeach; ?>

	</ol>

	
<div class="page">
</div>



</div> <!-- /main -->

<div class="secondary">

	<h3><?= $this->lang->line('user_about');?> <span class="meta"><?php echo $user['displayName']; ?></span></h3>
	
	<div id="userLatitude" name="<?php echo $user['latitude']; ?>"></div>
           <div id="userLongitude" name="<?php echo $user['longitude']; ?>"></div>
               <div id="countryCode" name="<?php echo $country_name; ?>"></div>
	<!--
	<div class='floatleft' id="map_canvas" style="width:225px; height:140px;margin-right:5px;">
                    </div>
                    <?php if ($this->session->userdata('id')&&$this->session->userdata('id')==$user['id']){  ?>
                    <div class='floatleft smallgrayword' style="padding-top:15px" id="logineduser" name="myself">
                         
                         <b><?= $this->lang->line('user_location');?></b> <a class="btn-green btn-small" style="color:#ddd" href="#" onclick="getLocation()">Save</a> <a class="btn-green btn-small" style="color:#ddd" href="#" onclick="cancelDrag()">Cancel</a>
                     </div>
                     <?php  }?>	
                     -->
	<div class="profile-data">
		<p class="copy">
			<?php echo $user['desc']; ?>
		</p>

	</div>
	

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

</div> <!-- /secondary -->



</div>






<?php $this->load->view('footer') ?>
