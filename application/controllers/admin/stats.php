<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stats extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        
		if($this->session->userdata('language')) {
			$lang = $this->session->userdata('language');
		} else {
			$language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
			if (preg_match("/zh-c/i", $language)||$language=='cn'){
				$lang = 2;
			} else {
				$lang = 1;
			}
			
		}
        if ($lang==2)
        {
        	$this->lang->load('header','chinese');
        	$this->lang->load('footer','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        }
    }
    
    public function index()
	{
		$this->load->model('stats_model');
		$data['file_count'] = $this->stats_model->file_stats(array());
		
		$sql_pre = 'SELECT count(*) as count FROM game_user WHERE ';
		$data['user_count'] = $this->stats_model->sql_stats($sql_pre.'1=1');
		$data['user_active_count'] = $this->stats_model->sql_stats($sql_pre.'active !=0');
		date_default_timezone_set('Etc/GMT-8'); 
		$last_day = date('Y-m-d H:i:s', time() - 60*60*24*30);
        $msql = $sql_pre.'active !=0 and last_login_time > \''.$last_day.'\'';
	    $data['user_active_month_count'] = $this->stats_model->sql_stats($msql);
		//$data['user_active_month_count'] = $this->stats_model->sql_stats($sql_pre.'active !=0 and last_login_time > \'2014-04-29 00:00:00\';');
		$data['user_verified'] = $this->stats_model->sql_stats($sql_pre.'verified !=0;');
		$data['user_upload'] = $this->stats_model->sql_stats('SELECT count(distinct(author_id)) as count FROM game_item');
		$data['user_action'] = $this->stats_model->sql_stats('SELECT COUNT(DISTINCT(user_id)) as count FROM game_user_status');
		
		$this->load->view('admin/stats_general',$data);
	}
	
	public function user_stats()
	{
		$this->load->model('stats_model');
		$sql_pre = 'SELECT count(*) as count FROM game_user WHERE ';
		$data['user_count'] = $this->stats_model->sql_stats($sql_pre.'1=1');
		$data['user_active_count'] = $this->stats_model->sql_stats($sql_pre.'active !=0');
		date_default_timezone_set('Etc/GMT-8'); 
		$last_day = date('Y-m-d H:i:s', time() - 60*60*24*30);
        $msql = $sql_pre.'active !=0 and last_login_time > \''.$last_day.'\'';
	    $data['user_active_month_count'] = $this->stats_model->sql_stats($msql);
		$data['user_verified'] = $this->stats_model->sql_stats($sql_pre.'verified !=0;');
		$data['user_upload'] = $this->stats_model->sql_stats('SELECT count(distinct(author_id)) as count FROM game_item');
		$data['user_action'] = $this->stats_model->sql_stats('SELECT COUNT(DISTINCT(user_id)) as count FROM game_user_status');
		
		$this->load->view('admin/stats_user',$data);
	}
	
	public function user_chart()
	{
		$this->load->model('stats_model');
		$sql_chart_pre = 'SELECT DATE_FORMAT( create_time, "%Y-%m" ) month,count(*) total FROM game_user a WHERE ';
		$sql_chart_order = ' GROUP BY DATE_FORMAT( create_time, "%Y-%m" )';
		$data['user_chart'] = $this->stats_model->list_stats($sql_chart_pre.'active=1'.$sql_chart_order);
		echo json_encode($data['user_chart']);
	}
	
	public function file_stats()
	{
		$this->load->model('stats_model');
		$sql_pre = 'SELECT count(*) as count,sum(view_num) as view_count,count(distinct(author_id)) as user_count, sum(fav_num) as fav_count,sum(comment_num) as comment_count,sum(watch_num) as watch_count,sum(download_num) as download_count FROM game_item WHERE ';
		$data['file_count'] = $this->stats_model->file_stats(array());
		$data['file_upload_count'] = $this->stats_model->sql_stats($sql_pre.'folder_id !=0');
		$data['work_count'] = $this->stats_model->sql_stats($sql_pre.'work_id !=0;');
		$data['public_count'] = $this->stats_model->sql_stats($sql_pre.'is_private !=1;');
		$data['fork_count'] = $this->stats_model->sql_stats($sql_pre.'parent_id !=0;');
		
		$sql_pre_folder = 'SELECT count(*) as count,count(distinct(user_id)) as user_count, sum(watch_num) as watch_count,sum(view_num) as view_count FROM game_user_folder WHERE ';
		$data['folder_count'] = $this->stats_model->sql_stats($sql_pre_folder.'1=1');
		
		$this->load->view('admin/stats_file',$data);
	}
	
	public function file_chart()
	{
		$this->load->model('stats_model');
		$sql_chart_pre = 'SELECT DATE_FORMAT( create_date, "%Y-%m" ) month,count(*) total FROM game_item a WHERE ';
		$sql_chart_order = ' GROUP BY DATE_FORMAT( create_date, "%Y-%m" )';
		$data['file_chart'] = $this->stats_model->list_stats($sql_chart_pre.'1=1'.$sql_chart_order);
		echo json_encode($data['file_chart']);
	}
	
	public function project_stats()
	{
		$this->load->model('stats_model');
		$data['sparticle_count'] = $this->stats_model->file_stats(array('from'=>'particle'));
		$data['db_count'] = $this->stats_model->file_stats(array('from'=>'dragonbones'));
		$data['as_count'] = $this->stats_model->file_stats(array('from'=>'aseditor'));
		$data['html_count'] = $this->stats_model->file_stats(array('from'=>'htmleditor'));
		
		$sql_pre = 'SELECT count(*) as count,sum(view_num) as view_count,sum(fav_num) as fav_count,sum(comment_num) as comment_count,sum(watch_num) as watch_count,sum(download_num) as download_count FROM game_item a WHERE ';
		$data['sparticle_fork_count'] = $this->stats_model->sql_stats($sql_pre.'parent_id !=0 and a.from=\'particle\';');
		$data['db_fork_count'] = $this->stats_model->sql_stats($sql_pre.'parent_id !=0 and a.from=\'dragonbones\';');
		$data['as_fork_count'] = $this->stats_model->sql_stats($sql_pre.'parent_id !=0 and a.from=\'aseditor\';');
		$data['html_fork_count'] = $this->stats_model->sql_stats($sql_pre.'parent_id !=0 and a.from=\'htmleditor\';');
		$this->load->view('admin/stats_project',$data);
	}
	
	public function project_chart()
	{
		$this->load->model('stats_model');
		$sql_chart_pre = 'SELECT DATE_FORMAT( create_date, "%Y-%m" ) month,count(*) total FROM game_item a WHERE ';
		$sql_chart_order = ' GROUP BY DATE_FORMAT( create_date, "%Y-%m" )';
		$data['file_chart'] = $this->stats_model->list_stats($sql_chart_pre.'folder_id=0 and work_id=0'.$sql_chart_order);
		echo json_encode($data['file_chart']);
	}
	
	public function group_stats()
	{
		$this->load->model('stats_model');
		$sql_pre = 'SELECT count(*) as count,sum(member_num) as member_count FROM game_group WHERE ';
		$data['group_count'] = $this->stats_model->sql_stats($sql_pre.'1=1');
		$sql_pre1 = 'SELECT count(*) as count,sum(view_num) as view_count FROM game_topic WHERE ';
		$data['topic_count'] = $this->stats_model->sql_stats($sql_pre1.'1=1');
		$sql_pre2 = 'SELECT count(*) as count FROM game_topic_comment WHERE ';
		$data['topic_comment_count'] = $this->stats_model->sql_stats($sql_pre2.'1=1');
		$this->load->view('admin/stats_group',$data);
	}
	
	public function topic_chart()
	{
		$this->load->model('stats_model');
		$sql_chart_pre = 'SELECT DATE_FORMAT( create_date, "%Y-%m" ) month,count(*) total FROM game_topic a WHERE ';
		$sql_chart_order = ' GROUP BY DATE_FORMAT( create_date, "%Y-%m" )';
		$data['topic_chart'] = $this->stats_model->list_stats($sql_chart_pre.'1=1'.$sql_chart_order);
		echo json_encode($data['topic_chart']);
	}
	
	public function task_stats()
	{
		$this->load->model('stats_model');
		$sql_pre = 'SELECT count(*) as count,count(distinct(author_id)) as user_count,sum(response_num) as response_count,sum(view_num) as view_count FROM game_task WHERE ';
		$data['task_count'] = $this->stats_model->sql_stats($sql_pre.'1=1');
		$sql_pre2 = 'SELECT count(*) as count FROM game_task_file WHERE ';
		$data['task_assets_count'] = $this->stats_model->sql_stats($sql_pre2.'1=1');
		$sql_pre2 = 'SELECT count(*) as count FROM game_bid_file WHERE ';
		$data['bid_assets_count'] = $this->stats_model->sql_stats($sql_pre2.'1=1');
		$this->load->view('admin/stats_task',$data);
	}
	
	public function task_chart()
	{
		$this->load->model('stats_model');
		$sql_chart_pre = 'SELECT DATE_FORMAT( create_date, "%Y-%m" ) month,count(*) total FROM game_task a WHERE ';
		$sql_chart_order = ' GROUP BY DATE_FORMAT( create_date, "%Y-%m" )';
		$data['task_chart'] = $this->stats_model->list_stats($sql_chart_pre.'1=1'.$sql_chart_order);
		echo json_encode($data['task_chart']);
	}
	
	public function tool_stats()
	{
		$this->load->model('stats_model');
		$sql_pre = 'SELECT count(*) as count,count(distinct(author_id)) as user_count,sum(view_num) as view_count FROM game_task WHERE ';
		$data['tool_count'] = $this->stats_model->sql_stats($sql_pre.'1=1');
		$sql_pre2 = 'SELECT count(*) as count,sum(open_num) as link_open_count FROM game_url WHERE ';
		$data['tool_url_count'] = $this->stats_model->sql_stats($sql_pre2.'1=1');
		$this->load->view('admin/stats_tool',$data);
	}
	
	public function tool_chart()
	{
		$this->load->model('stats_model');
		$sql_chart_pre = 'SELECT DATE_FORMAT( create_date, "%Y-%m" ) month,count(*) total FROM game_tool a WHERE ';
		$sql_chart_order = ' GROUP BY DATE_FORMAT( create_date, "%Y-%m" )';
		$data['tool_chart'] = $this->stats_model->list_stats($sql_chart_pre.'1=1'.$sql_chart_order);
		echo json_encode($data['tool_chart']);
	}
	
	public function team_stats()
	{
		$this->load->model('stats_model');
		$sql_pre = 'SELECT count(*) as count,count(distinct(author_id)) as user_count,sum(view_num) as view_count,sum(people_num) as member_count,sum(project_num) as project_count,sum(work_num) as work_count FROM game_team WHERE ';
		$data['team_count'] = $this->stats_model->sql_stats($sql_pre.'1=1');
		$sql_pre2 = 'SELECT count(*) as count FROM game_team_comment WHERE ';
		$data['team_comment_count'] = $this->stats_model->sql_stats($sql_pre2.'1=1');
		$this->load->view('admin/stats_team',$data);
	}
	
	public function team_chart()
	{
		$this->load->model('stats_model');
		$sql_chart_pre = 'SELECT DATE_FORMAT( create_date, "%Y-%m" ) month,count(*) total FROM game_team a WHERE ';
		$sql_chart_order = ' GROUP BY DATE_FORMAT( create_date, "%Y-%m" )';
		$data['team_chart'] = $this->stats_model->list_stats($sql_chart_pre.'1=1'.$sql_chart_order);
		echo json_encode($data['team_chart']);
	}
}