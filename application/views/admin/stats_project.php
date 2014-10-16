<?php $this->load->view('header') ?>
<script type="text/javascript" src="<?=base_url()?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqplot.json2.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqplot.cursor.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqplot.dateAxisRenderer.min.js"></script>
<link rel="stylesheet" type="text/css" hrf="<?=base_url()?>js/jquery.jqplot.min.css" />
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
<script>
$(document).ready(function(){
	$.ajax({  
             type:"GET" 
             ,url:"<?=base_url()?>index.php/admin/stats/project_chart/1"  
             ,data:{id:1}                                
             ,contentType:'text/html;charset=utf-8'//编码格式   
             ,success:function(data){  
			  var chartdata=JSON.parse(data);
			  var arr = new Array();
			  var arr1 = new Array();
			  for(var i in chartdata) {
		      	arr.push([chartdata[i].month, parseInt(chartdata[i].total)]);
			  }
			  var plot2 = $.jqplot('chart2', [arr], {
			  	seriesColors: ["rgba(78, 135, 194, 0.7)", "rgb(211, 235, 59)"],
			    title:'Projects Growth Trend Tracking By Month',
			    axes:{
			      xaxis:{
			        renderer:$.jqplot.DateAxisRenderer,
			          tickOptions:{
			            formatString:'%b&nbsp;%#d'
			          }
			      }
			    },
			    legend: {
            show: true,
            location: 'sw',
            showSwatches: true,
            placement: 'outsideGrid'
        },
        seriesDefaults: {
            rendererOptions: {
                smooth: true,
                animation: {
                    show: true
                }
            },
            showMarker: false
        },
        series: [
            {
                fill: false,
                label: 'Count'
            }
        ],
			    highlighter: {
            show: true,
            sizeAdjust: 7.5,
            tooltipOffset: 9
        },
		      seriesDefaults: { 
		        showMarker:true,
		        pointLabels: { show:false } 
		      },
		      cursor: {
		        show: false
		      }
			  }); 
             }//请求成功后  
             ,error:function(data){  
                
             }//请求错误  
          }); 
});
</script>
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
	<div class="col-about col-about-full under-hero" style="color:#000">
	<h1 class="about">Projects Chart</h1>
	<p class="callout">
	<div id="chart2" style="height:100%; width:100%;"></div>
	</p>
	</div>
	
	<div class="col-about col-about-full under-hero">
	<h1 class="about">Project By Sparticle</h1>
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
	      <td><?php echo $sparticle_count['count'] ?></td>						
	      <td><?php echo $sparticle_count['view_count'] ?></td>
	      <td><?php echo $sparticle_count['fav_count'] ?></td>
	      <td><?php echo $sparticle_count['comment_count'] ?></td>				
	      <td><?php echo $sparticle_count['watch_count'] ?></td>		
	      <td><?php echo $sparticle_count['download_count'] ?></td>				
	  </tr>
	</tbody></table>
	</p>
	<h1 class="about">Project Forked By Sparticle</h1>
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
	      <td><?php echo $sparticle_fork_count['count'] ?>(<?php echo (round($sparticle_fork_count['count']/$sparticle_count['count'],2)*100).'%' ?>)</td>						
	      <td><?php echo $sparticle_fork_count['view_count'] ?></td>
	      <td><?php echo $sparticle_fork_count['fav_count'] ?></td>
	      <td><?php echo $sparticle_fork_count['comment_count'] ?></td>				
	      <td><?php echo $sparticle_fork_count['watch_count'] ?></td>		
	      <td><?php echo $sparticle_fork_count['download_count'] ?></td>				
	  </tr>
	</tbody></table>
	</p>
	</div>
	
	<div class="col-about col-about-full under-hero">
	<h1 class="about">Project By DragonBones</h1>
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
	      <td><?php echo $db_count['count'] ?></td>						
	      <td><?php echo $db_count['view_count'] ?></td>
	      <td><?php echo $db_count['fav_count'] ?></td>
	      <td><?php echo $db_count['comment_count'] ?></td>				
	      <td><?php echo $db_count['watch_count'] ?></td>		
	      <td><?php echo $db_count['download_count'] ?></td>				
	  </tr>
	</tbody></table>
	</p>
	<h1 class="about">Project Forked By DragonBones</h1>
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
	      <td><?php echo $db_fork_count['count'] ?>(<?php echo (round($db_fork_count['count']/$db_count['count'],2)*100).'%' ?>)</td>						
	      <td><?php echo $db_fork_count['view_count'] ?></td>
	      <td><?php echo $db_fork_count['fav_count'] ?></td>
	      <td><?php echo $db_fork_count['comment_count'] ?></td>				
	      <td><?php echo $db_fork_count['watch_count'] ?></td>		
	      <td><?php echo $db_fork_count['download_count'] ?></td>				
	  </tr>
	</tbody></table>
	</p>
	</div>
	
	<div class="col-about col-about-full under-hero">
	<h1 class="about">Project By HTML5</h1>
	<p class="callout">
	<table class="dataintable browsersupport">
	  <tbody><tr>
	      <th>Total</th>
	      <th>View</th>
	      <th>Fav</th>
	      <th>Comment</th>
	      <th>Watch</th>
	  </tr>
	  <tr>
	      <td><?php echo $html_count['count'] ?></td>						
	      <td><?php echo $html_count['view_count'] ?></td>
	      <td><?php echo $html_count['fav_count'] ?></td>
	      <td><?php echo $html_count['comment_count'] ?></td>				
	      <td><?php echo $html_count['watch_count'] ?></td>						
	  </tr>
	</tbody></table>
	</p>
	<h1 class="about">Project Forked By HTML5</h1>
	<p class="callout">
	<table class="dataintable browsersupport">
	  <tbody><tr>
	      <th>Total</th>
	      <th>View</th>
	      <th>Fav</th>
	      <th>Comment</th>
	      <th>Watch</th>
	  </tr>
	  <tr>
	      <td><?php echo $html_fork_count['count'] ?>(<?php echo (round($html_fork_count['count']/$html_count['count'],2)*100).'%' ?>)</td>						
	      <td><?php echo $html_fork_count['view_count'] ?></td>
	      <td><?php echo $html_fork_count['fav_count'] ?></td>
	      <td><?php echo $html_fork_count['comment_count'] ?></td>				
	      <td><?php echo $html_fork_count['watch_count'] ?></td>				
	  </tr>
	</tbody></table>
	</p>
	</div>
	
	<div class="col-about col-about-full under-hero">
	<h1 class="about">Project By ActionScript</h1>
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
	      <td><?php echo $as_count['count'] ?></td>						
	      <td><?php echo $as_count['view_count'] ?></td>
	      <td><?php echo $as_count['fav_count'] ?></td>
	      <td><?php echo $as_count['comment_count'] ?></td>				
	      <td><?php echo $as_count['watch_count'] ?></td>		
	      <td><?php echo $as_count['download_count'] ?></td>				
	  </tr>
	</tbody></table>
	</p>
	<h1 class="about">Project Forked By ActionScript</h1>
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
	      <td><?php echo $as_fork_count['count'] ?>(<?php echo (round($as_fork_count['count']/$as_count['count'],2)*100).'%' ?>)</td>						
	      <td><?php echo $as_fork_count['view_count'] ?></td>
	      <td><?php echo $as_fork_count['fav_count'] ?></td>
	      <td><?php echo $as_fork_count['comment_count'] ?></td>				
	      <td><?php echo $as_fork_count['watch_count'] ?></td>		
	      <td><?php echo $as_fork_count['download_count'] ?></td>				
	  </tr>
	</tbody></table>
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