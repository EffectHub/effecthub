<?php
class search_model extends CI_Model
{
	var $id;
	var $content;
	var $count;
	var $last_search;
	var $first_search;
	var $user_id;
	function __construct()
	{
		parent::__construct();
	}
	//--------------------------------------------------
	
	
	//
	// search the content of the string
	// note: by design the result must be a single row
	function search($str,$userid)
	{
		$query = null;
		if (!$userid){
			$query = $this->db->get_where('game_search',array('user_id' => '0','content' => $str));		
		}		
		else {
			$query = $this->db->get_where('game_search',array('user_id' => $userid,'content' => $str));
		}		
		return $query->row();
	}
	
	//
	// update existed search item, changed the columns are last_search and count
	// 
	function update($id,$count)
	{	
		
		$data = array(
				'id' => $id,
				'count' => $count,
				'last_search' => date('Y-m-d H:i:s')
		);
		
		$this->db->where('id', $id);
		$this->db->update('game_search', $data);
	}
	
	
	//
	// insert a new search item
	//
	function insert_new($content,$userid)
	{		
		$data = array(
				'content' => $content ,
				'user_id' => $userid,
				'count' => '1',
				'last_search' => date('Y-m-d H:i:s'),
				'first_search' => date('Y-m-d H:i:s')
		);
		
		$this->db->insert('game_search', $data);
	}
}