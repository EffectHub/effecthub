<?php
class Team_model extends CI_Model 
{
	
	var $team_id;
	
	var $team_name;
	var $author_id;
	var $manager_id;
	var $people_num;
	var $status;
	var $description;
	var $project_num;
	var $leader_id;
	var $create_date;
	var $work_num;
	var $pic_url;
	var $priority;
	var $view_num;
	var $upper_limit;
	
	
	function __construct()
	{	
		parent::__construct();
	}
	
	
	
	//load collection by collection id
	//$detail为0，不加载leader name
	function load($id,$detail=0) 
	{
		$query = $this->db->get_where('team',array('team_id'=>$id))->row_array();
		
		if ($query['leader_id']!=null&&$query['leader_id']!=0) {
			if ($detail == 1){
				$user = $this->db->get_where('user',array('id'=>$query['leader_id']))->row_array();
				$query['leader_name'] = $user['displayName'];
			}
		}
		
		return $query;
		
	}
	
	
	// detail = 0, not much information about the team; = 1,show detailed information of the team
	function find_teams($options = array(), $detail = 0, $offset = 0, $count = 10) 
	{
		
		if (!is_array($options)){
			return array();
		}
		
		if ($count>0) {
			$this->db->limit($count,$offset);
		}
		
		
		$query = $this->_query_items($options);
		
		if ($detail == 1) {
			$rows = array();
		
			foreach ($query->result_array() as $row) {
				if ($row['leader_id'] == null||$row['leader_id'] ==0 ) {
					$row['leader_name'] = '';
				} else {
					$user = $this->db->get_where('user',array('id' => $row['leader_id']))->row_array();
					$row['leader_name'] = $user['displayName'];
				}
				
				
				
				$rows[] = $row;
				
			}

		return $rows;
		} else {
			return $query-result_array();
			
		}
		
		
	}
	
	
	// 认真回顾这一块儿的逻辑！！！		3.17 18:40
	
	function _query_items($options = array())
	{
		
		$this->db->from('team');
		
		if (isset($options['order'])) {
			if ($options['order'] == 'hot') {
				
				$now = time();
				
				//尤其是这里的算法
				$this->db->select("('SELECT (float)((team.view_num + team.work_num * 2 + team.people_num * 3)/((int)((".$now." - strtotime(team.create_date))/(24*60*60)) + 1)) FROM team') AS hot",FALSE);
				$this->db->select('team_id,team_name,people_num,status,description,leader_id,work_num,pic_url,priority,view_num');
				
				$this->db->order_by('hot','desc');
				$this->db->order_by('create_date','desc');
				
			}
			
		}
		
		return $this->db->get();
		
	}
	
	function create(){
		
		$datetime = date('Y-m-d H:i:s');
		
		$this->db->set('team_name', $this->team_name);
		if ($this->description!=''&&$this->description!=null) {
			$this->db->set('description', $this->description);
		}
		
		if ($this->pic_url!=''&&$this->pic_url!=null) {
			$this->db->set('pic_url',$this->pic_url);
		}
		$this->db->set('author_id', $this->author_id);
		$this->db->set('leader_id', $this->leader_id);
		$this->db->set('status', $this->status);
		$this->db->set('priority',$this->priority);
		$this->db->set('upper_limit',$this->upper_limit);
		$this->db->set('people_num',$this->people_num);
		$this->db->set('project_num',$this->project_num);
		$this->db->set('work_num',$this->work_num);
		$this->db->set('view_num',$this->view_num);
		
		$this->db->set('create_date', $datetime);
		
		return $this->db->insert('team');
	
	}
	
	
	
	
	function update($id)
	{
	
		$this->db->set('team_name', $this->team_name);
		$this->db->set('description', $this->description);
		$this->db->set('pic_url', $this->pic_url);
		$this->db->set('status', $this->status);
		$this->db->set('priority',$this->priority);
		$this->db->set('upper_limit',$this->upper_limit);
		
		$this->db->where('team_id', $id);
		return $this->db->update('team');
		
	}
	
	function count_team()
	{
		$query = $this->db->get('team')->result_array();
		return count($query);
		
	}
	
	function update_people_num($id)
	{
		$this->db->set('people_num', $this->people_num);
		$this->db->where('team_id',$id);
		$this->db->update('team');
		return $this->db->affected_rows();
		
	}
	
	function update_view_num($id)
	{
		$this->db->set('view_num',$this->view_num);
		$this->db->where('team_id',$id);
		$this->db->update('team');
		return $this->db->affected_rows();
	}
	
	function update_work_num($id)
	{
		$this->db->set('work_num',$this->work_num);
		$this->db->where('team_id',$id);
		$this->db->update('team');
		return $this->db->affected_rows();
	}
	
	function update_pic($id)
	{

		$this->db->set('pic_url', $this->pic_url);
	
		$this->db->where('team_id', $id);
		return $this->db->update('team');
	
	}
	
	
	
}


