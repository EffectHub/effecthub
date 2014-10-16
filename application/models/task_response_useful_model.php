<?php
/**
 * mark comment whether useful
 *
 *
 */
class task_response_useful_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function load($user_id, $comment_id)
	{
		$query = $this->db->get_where('task_response_useful',array('user_id' => $user_id, 'comment_id' => $comment_id));
		if($row = $query->row_array() )
		{
			return $row;
		}
		return array();
	}
	//--------------------------------------------------------------
	/**
	 * create a line of record if the record does not exist, else update it 
	 */

	function update($user_id, $comment_id, $useful_level)
	{
		$query = $this->load($user_id,$comment_id);
		$datetime = date('Y-m-d H:i:s');
		if(empty($query))
		{
			//insert new line record			
			$this->db->set('user_id', $user_id);
			$this->db->set('comment_id', $comment_id);
			$this->db->set('update_time', $datetime);
			$this->db->set('useful_level', $useful_level);		
			
			$this->db->insert('task_response_useful');
			
		}
		else
		{			
			$this->db->set('update_time', $datetime);
			$this->db->set('useful_level', $useful_level);
			
			$this->db->where('user_id', $user_id);
			$this->db->where('comment_id', $comment_id);
			
			$this->db->update('task_response_useful');			
		}
		return $this->db->affected_rows();
	}
	
	
	
}