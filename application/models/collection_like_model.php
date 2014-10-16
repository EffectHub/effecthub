<?php
class Collection_like_model extends CI_Model 
{
	
	var $user_id;
	var $collection_id;
	var $like_date;
	
	function __construct()
	{	
		parent::__construct();
	}


	//load by collection_id or by collection_id and user_id
	function load($id=null,$user=null)
	{
	
		if ($id!=null) {
			$this->db->where('collection_id',$id);
		}
		if ($user!=null) {
			$this->db->where('user_id',$user);
		}
		$this->db->from('collection_like');
		$query = $this->db->get();
	
		return $query->result_array();
	}
	
	// like a collection
	function like()
    { 
    	$datetime = date('Y-m-d H:i:s');
    	
    	$this->db->set('user_id',$this->user_id);
    	$this->db->set('collection_id',$this->collection_id);
    	$this->db->set('like_date',$datetime);
    	
    	return $this->db->insert('collection_like');
    	
	}
	
	
	function unlike($collect,$user)
	{
		return $this->db->delete('collection_like',array('user_id'=>$user,'collection_id'=>$collect));
	}
	
	//delete likes by collection id
	function delete($id)
	{
		$this->db->where('collection_id',$id);
		return $this->db->delete('collection_like');
	}

	
}


