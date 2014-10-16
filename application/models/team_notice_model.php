<?php
class Team_notice_model extends CI_Model 
{
	
	var $notice_id;
	var $notice_type;
	var $user_id;
	var $producer_id;
	var $team_id;
	var $create_date;
	var $read;
	var $target_id;
	
	function __construct()
	{	
		parent::__construct();
	}
	
	
	function create() 
	{
		
		$this->db->set('notice_type',$this->notice_type);
		$this->db->set('user_id',$this->user_id);
		$this->db->set('producer_id',$this->producer_id);
		$this->db->set('team_id',$this->team_id);
		$this->db->set('target_id',$this->target_id);
		
		$now = date('Y-m-d H:i:s');
		
		$this->db->set('create_date',$now);
		$this->db->set('read',0);
		
		return $this->db->insert('team_notice');
	}
	
	function load_by_id($id=0) {
		if ($id>0) {
			return $this->db->get_where('team_notice',array('notice_id'=>$id))->row_array();
		}
	}
	
	//$read=0, load unread ones; $read=1, load all notices
	function load($options = array(),$limit=10,$offset=0)
	{
		$this->db->order_by('create_date','desc');

		if ($limit>0){
			$this->db->limit($limit,$offset);
		}
		
		$query = $this->_option_query($options);
		
		$rows = array();
		
		foreach ($query->result_array() as $row) {
			
			$producer = $this->db->get_where('user',array('id'=>$row['producer_id']))->row_array();
			$team = $this->db->get_where('team',array('team_id'=>$row['team_id']))->row_array();
			
			$row['producer_name'] = $producer['displayName'];
			$row['team_name'] = $team['team_name'];
			
			$rows[] = $row;
		}
		
		return $rows;
		
	}
	
	//multi-query private function
	function _option_query($options = null) 
	{
		$this->db->from('team_notice');
		
		if (isset($options['read'])) {
			if (isset($options['read'])) {
				if ($options['read']==0) {
					$this->db->where('read',$options['read']);
				} else {
					$this->db->where('read >',0);
				}
			}
		}
		
		if (isset($options['user_id'])) {
			$this->db->where('user_id',$options['user_id']);
		}
		
		if (isset($options['team_id'])) {
			$this->db->where('team_id',$options['team_id']);
		}
		
		if (isset($options['producer_id'])) {
			$this->db->where('producer_id',$options['producer_id']);
		}
		
		if (isset($options['type'])) {
			$this->db->where('notice_type',$options['type']);
		}
		
		return $this->db->get();
		
	}
	
	function read($options,$read)
	{
		$this->db->where($options);
		$this->db->set('read',$read);
		$this->db->update('team_notice');
		
		return $this->db->affected_rows();
		
	}
	
		
	
	
}


