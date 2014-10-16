<!DOCTYPE html>
<html>
    <head>
	<link rel="stylesheet" href="<?=base_url()?>css/boilerplate.css" />
	<link rel="stylesheet" href="<?=base_url()?>css/reflow.css" />
    <script>var __adobewebfontsappname__ = "code"</script>
    <script src="http://use.edgefonts.net/passion-one:n9,n7,n4:all.js"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
    <script
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"
	type="text/javascript"></script>
	<script type="text/javascript" src="<?=base_url()?>js/main.js"></script>
    </head>
    <body>
	<div id="primaryContainer" class="primaryContainer clearfix">
                 <div id='header' class='clearfix'>
           <div id='logo' class='clearfix'>
               <a href="<?=site_url('home')?>"><img id="logoimg" src="<?=base_url()?>img/logo.jpg" class="image"></a>
               <ul class="mainmenu">
                <li><a href="<?=site_url('home')?>">Explore</a></li>
                <!--
                <li><a href="<?=site_url('courses')?>">Courses</a></li>
                <li><a href="<?=site_url('questions')?>">Questions</a></li>
                <li><a href="<?=site_url('jobs')?>">Jobs</a></li>
                -->
                <li><a href="<?=site_url('download')?>">Downloads</a></li>
               <form name="global_search_form" action="<?=site_url('item/globalSearch')?>" method="post" onKeyDown="if(event.keyCode==13){document.global_search_form.submit();}">
                <li class="my" style="width:275px">
                <?php if ($this->session->userdata('id')){  ?>
                <span class="no-login" id="usershow"><a href="<?=site_url('user/'.$this->session->userdata('id'))?>">Welcome, <?php echo $this->session->userdata('displayName');?></a></span>
                <ul class="userpanel" style="display: none; ">
               		<li class="type"><a href="<?=site_url('user/'.$this->session->userdata('id'))?>">My Profile</a></li>
               		<li class="type"><a href="<?=site_url('account/settings')?>">Account Settings</a></li>
               		<li class="type"><a href="<?=site_url('login/logout')?>">Log Out</a></li>
               </ul>
                <?php  }else{?>
                <span class="no-login"><a href="<?=site_url('register')?>">Sign Up </a> <a href="<?=site_url('login')?>">Login</a></span>	
                <?php  }?>	         
                   
                   </li> 
                 </form>
                </ul>
            </div>
       </div>
       <div id='content' class='clearfix'>
       	   <div class='contentTitle'>
               <h5>
               <a href="<?=site_url('home')?>">All Catagory</a>
               <a href="<?=site_url('home')?>">Featured</a>
               <a href="<?=site_url('author')?>">Author</a>
               <?php if ($this->session->userdata('id')){  ?>
               	<a href="<?=site_url('item/inspired/'.$this->session->userdata('id'))?>">Inspired</a>
                <a href="<?=site_url('item/myfollow/'.$this->session->userdata('id'))?>">My follow</a>
                <a href="<?=site_url('item/mywatch/'.$this->session->userdata('id'))?>">My watch</a>
                <?php  }?>
               </h5>
               <?php if ($this->session->userdata('id')){  ?>
               <div class='backstyle'><a href="<?=site_url('item/upload')?>">Upload</a></div>
               <?php  }?>
           </div>
           <div id='main' class='clearfix'>
                 <div class="search-field">
                   <form action="globalSearch" method="post">                    
                     <input type="text" name="search" class="input-text" id="" value="">	     
				     <input type="submit" class="search-btn" value="搜 索">			    
				   </form>
                  </div>
                   <?php foreach($results[0] as $_result): ?>
                   <div class='commentitem' style='border-bottom: 1px solid #CDCDCD;padding-bottom:30px;'>
                            <div class="commentimg">
                                <a href="<?=site_url('item/'.$_result['id'])?>"><img src='<?php echo $_result['thumb_url']==null?$_result['pic_url']:$_result['thumb_url']; ?>' style='width:60px;height:60px;'></a>
                            </div>
                            <div>
                                <div class='paragraphstyle'><b><?php echo $_result['title']; ?></b> </div>
                                <div class="commenttext" style='margin-top:21px;'><?php echo $_result['desc']; ?></div>
                            </div>
                   </div>    
                 <?php endforeach; ?>               
                  
                  <?php foreach($results[1] as $_result): ?>
                   <div style='border-bottom: 1px solid #CDCDCD;padding-bottom:30px;'>  
                            <div>
                                <div class='paragraphstyle'><b>someone's comment</b> </div>
                                <div class="commenttext" style='margin-top:21px;margin-left:30px;'><?php echo $_result['content']; ?></div>
                            </div>
                   </div>    
                 <?php endforeach; ?>  
               
           </div>
       </div>
<?php $this->load->view('footer') ?>