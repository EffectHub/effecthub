<?php
class Team_member_model extends CI_Model 
{
	
	var $member_id;
	var $team_id;
	var $position;
	var $position_name;
	
	
	function __construct()
	{	
		parent::__construct();
	}
	
	
	function load_user_teams($id,$team=0, $offset = 0, $count = 10) 
	{
		if (!$id) {
			return array();
		}
		
		if ($count>0) {
			$this->db->limit($count,$offset);
		}
		
		if ($team>0){
			$this->db->where('team_member.team_id',$team);
		}
		
		$this->db->order_by('team_member.create_date','desc');
		$this->db->from('team_member');
		$this->db->where('member_id',$id);
		$this->db->join('team','team.team_id = team_member.team_id');
		
		$query = $this->db->get();
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
		
	}
	
	function count_my_team($id)
	{
		if (!$id) {
			return array();
		}
		
		$query = $this->db->get_where('team_member',array('member_id'=>$id))->result_array();
		return count($query);
	}
	
	function load_team_member($id,$limit=0,$offset=0) 
	{
		if ($id==0||$id==null) return array();
		
		if ($limit>0) {
			$this->db->limit($limit,$offset);
		}
		
		$this->db->order_by('create_date','desc');
		$query = $this->db->get_where('team_member',array('team_id' => $id))->result_array();
		
		$rows = array();
		
		foreach ($query as $row) {
			$user = $this->db->get_where('user',array('id' => $row['member_id']))->row_array();
			$row['displayName'] = $user['displayName'];
			$row['pic_url'] = $user['pic_url'];
			
			$rows[] = $row;
		}
		
		return $rows;
			
	}
	
	
	function create() {
		$datetime = date('Y-m-d H:i:s');
		
		$this->db->set('member_id',$this->member_id);
		$this->db->set('team_id',$this->team_id);
		$this->db->set('position',$this->position);
		$this->db->set('position_name',$this->position_name);
		$this->db->set('create_date',$datetime);
		$this->db->set('update_date',$datetime);
		
		$this->db->insert('team_member');
		
		return $this->db->affected_rows();
		
	}
	
	function delete($member_id,$team_id)
	{
		
		$this->db->delete('team_member',array('member_id'=>$member_id,'team_id'=>$team_id));
		
		return $this->db->affected_rows();
	}
	
	function update_position($team,$member)
	{	
		$datetime = date('Y-m-d H:i:s');
		
		$this->db->set('position',$this->position);
		$this->db->set('position_name',$this->position_name);
		$this->db->set('update_date',$datetime);
		
		$this->db->where(array('team_id'=>$team,'member_id'=>$member));
		$this->db->update('team_member');
		
		return;
	}
	
	function load_member($member,$team)
	{
		return $this->get_where('team_member',array('member_id'=>$member,'team_id'=>$team))->row_array();
		
		
	}
	
	
	
	
	
}


