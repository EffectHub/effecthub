<?php
class Collection_comment_model extends CI_Model 
{
	
	var $comment_id;
	var $collection_id;
	var $author_id;
	var $create_date;
	var $content;
	var $parent_id;
	
	function __construct()
	{	
		parent::__construct();
	}


	//load by collection id
	function load($id)
	{
		if (!$id){
			return array();
		}
	
		$query = $this->db->get_where('collection_comment',array('id' => $id));
		
		if ($row = $query->row_array()){
		
			return $row;
		}
		
		return array();
	}

	
	//load collection comments by collection id
	function find_comments($id)
	{
		$this->db->where('collection_id',$id);
		$this->db->order_by('create_date','desc');
		$this->db->from('collection_comment');
		$query = $this->db->get();
		
		$rows = array();
		foreach ($query->result_array() as $row){
			$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
            $rows[] = $row;
		}
		return $rows;	
		
	}
		
	function create()
	{
		$datetime = date('Y-m-d H:i:s');
		
		$this->db->set('content', $this->content);
		$this->db->set('author_id', $this->author_id);
		$this->db->set('collection_id', $this->collection_id);
		$this->db->set('parent_id', $this->parent_id);
		$this->db->set('create_date', $datetime);
		
		return $this->db->insert('collection_comment');
		
	}
	
	//delete comments by collection id
	function delete($id)
	{
		$this->db->where('collection_id',$id);
		return $this->db->delete('collection_comment');
	}
	
		

	
}


