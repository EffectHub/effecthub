<?php $this->load->view('header') ?>
<style type="text/css">
table.dataintable {
margin-top: 10px;
border-collapse: collapse;
border: 1px solid #aaa;
width: 100%;
}
table.browsersupport th {
padding: 3px;
height: 15px;
vertical-align: middle;
text-align: center;
background-color: #efefef;
border: 1px solid #c3c3c3;
}
table.dataintable td {
vertical-align: text-top;
padding: 5px 15px 5px 5px;
background-color: #fff;
border: 1px solid #aaa;
}
table.browsersupport {
margin-top: 15px;
border-collapse: collapse;
width: 100%;
}
table{
	color:#333;
}
</style>
    <div id="content" class="group">

<div class="notice-alert">
	<h3><!-- message goes here --></h3>
	<a href="#" class="close">
		<img alt="Icon-x-30-white" src="<?=base_url()?>images/icon-x-30-white.png" width="15">
	</a>
</div>

<ul class="tabs">
	<li class="selected"><a href="<?php echo site_url('admin/stats')?>" class="selected">Stats</a></li>
	<li><a href="<?php echo site_url('admin/email')?>">Email</a></li>
	<li><a href="<?php echo site_url('admin/feedback')?>">Feedback</a></li>
	<li><a href="<?php echo site_url('admin/user')?>">User</a></li>
	<li><a href="<?php echo site_url('admin/content')?>">Content</a></li>
</ul>

<div id="main" class="site">
	<div class="col-about col-about-full under-hero">
	<h1 class="about">User Total</h1>
	<p class="callout">
	<table class="dataintable browsersupport">
	  <tbody><tr>
	      <th>Total</th>
	      <th>Active</th>
	      <th style="width:120px">Active (30 Days)</th>
	      <th>Verified</th>
	      <th style="width:120px">Have Action</th>
	      <th style="width:120px">Upload Assets</th>
	  </tr>
	  <tr>
	      <td><?php echo $user_count['count'] ?></td>						
	      <td><?php echo $user_active_count['count'] ?>(<?php echo (round($user_active_count['count']/$user_count['count'],2)*100).'%' ?>)</td>
	      <td><?php echo $user_active_month_count['count'] ?>(<?php echo (round($user_active_month_count['count']/$user_count['count'],2)*100).'%' ?>)</td>
	      <td><?php echo $user_verified['count'] ?>(<?php echo (round($user_verified['count']/$user_count['count'],2)*100).'%' ?>)</td>				
	      <td><?php echo $user_action['count'] ?>(<?php echo (round($user_action['count']/$user_active_count['count'],2)*100).'%' ?>)</td>		
	      <td><?php echo $user_upload['count'] ?>(<?php echo (round($user_upload['count']/$user_active_count['count'],2)*100).'%' ?>)</td>				
	  </tr>
	</tbody></table>
	</p>
	</div>
	
	<div class="col-about col-about-full under-hero">
	<h1 class="about">Assets Total</h1>
	<p class="callout">
	<table class="dataintable browsersupport">
	  <tbody><tr>
	      <th>Total</th>
	      <th>View</th>
	      <th>Fav</th>
	      <th>Comment</th>
	      <th>Watch</th>
	      <th>Download</th>
	  </tr>
	  <tr>
	      <td><?php echo $file_count['count'] ?></td>						
	      <td><?php echo $file_count['view_count'] ?></td>
	      <td><?php echo $file_count['fav_count'] ?></td>
	      <td><?php echo $file_count['comment_count'] ?></td>				
	      <td><?php echo $file_count['watch_count'] ?></td>		
	      <td><?php echo $file_count['download_count'] ?></td>				
	  </tr>
	</tbody></table>
	</p>
	</div>
	
	<div class="col-about col-about-full under-hero">
	<h1 class="about">Alexa Traffic Rank</h1>
	<p class="callout">
	<A href="http://www.alexa.com/siteinfo/www.effecthub.com"><SCRIPT type='text/javascript' language='JavaScript' 
src='http://xslt.alexa.com/site_stats/js/s/a?url=www.effecthub.com'></SCRIPT></A>
	Link: <a target="_blank" href="http://alexa.chinaz.com/?domain=effecthub.com">http://alexa.chinaz.com/?domain=effecthub.com</a>
	</p>
	</div>
	
	<div class="col-about col-about-full under-hero">
	<h1 class="about">Google Page Rank</h1>
	<p class="callout">
	Link: <a target="_blank" href="http://pr.chinaz.com/?PRAddress=www.effecthub.com">http://pr.chinaz.com/?PRAddress=www.effecthub.com</a>
	</p>
	</div>
	
</div>

<div class="secondary">

	<h3>Stats <span class="meta">Nav</span></h3>

	<ul class="follow">
		<li class="group"><a href="<?=site_url('admin/stats')?>">General Stats</a></li>
		<li class="group"><a href="<?=site_url('admin/stats/user_stats')?>">User Stats</a></li>
		<li class="group"><a href="<?=site_url('admin/stats/file_stats')?>">Assets Stats</a></li>
		<li class="group"><a href="<?=site_url('admin/stats/project_stats')?>">Project Stats</a></li>
		<li class="group"><a href="<?=site_url('admin/stats/group_stats')?>">Group Stats</a></li>
		<li class="group"><a href="<?=site_url('admin/stats/task_stats')?>">Task Stats</a></li>
		<li class="group"><a href="<?=site_url('admin/stats/tool_stats')?>">Tool Stats</a></li>
		<li class="group"><a href="<?=site_url('admin/stats/team_stats')?>">Team Stats</a></li>
	</ul>
	
</div>


</div>
<?php $this->load->view('footer') ?>