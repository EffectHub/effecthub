<?php
class Collection_model extends CI_Model 
{
	
	var $collection_id;
	
	var $author_id;
	var $title;
	var $description;
	var $pic_url;
	var $view_num;
	var $like_num;
	var $works_num;
	var $comment_num;
	var $create_date;
	var $update_date;
	
	
	function __construct()
	{	
		parent::__construct();
	}
	
	
	
	//load collection by collection id
	function load($id) 
	{
		$query = $this->db->get_where('collection',array('id'=>$id));
		return $query->row_array();
		
	}
	
	// create a new collection
	function create()
    { 
		$datetime = date('Y-m-d H:i:s');
		
        $this->db->set('title', $this->title);
        if ($this->description!=''&&$this->description!=null) {
        	$this->db->set('description', $this->description);
        }
		
        if ($this->pic_url!=''&&$this->pic_url!=null) {
        	$this->db->set('pic_url',$this->pic_url);
        }
		$this->db->set('author_id', $this->author_id);
		$this->db->set('create_date', $datetime);
        $this->db->set('update_date', $datetime);
        
        return $this->db->insert('collection');
	} 
	
	//update collection information, not update the works in collection.
	function update($id)
	{
	
		$this->db->set('title', $this->title);
		$this->db->set('description', $this->description);
		$this->db->set('pic_url', $this->pic_url);
		$this->db->where('id', $id);
		
		return $this->db->update('collection');
	}
	
	
	//load collection by options,$detail=1 load the author name of the collection
	function find_collections($options = array(), $detail = 0, $count=10, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        
        if ($count>0){
            $this->db->limit((int)$count, (int)$offset);
        }

		$query = $this->_query_items($options);
		
		if ($detail == 1) {
			
			$rows = array();
				
			foreach ($query->result_array() as $row){
				$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
				$row['author_name'] = $user['displayName'];

				$rows[] = $row;
			}
			return $rows;
		}

        return $query->result_array();
		
	}
	
	
	//private function
	function _query_items($options = null)
	{
		$this->db->from('collection');
		if (!empty($options['user'])) {
			$this->db->where('author_id',$options['user']);
		}
		
		// find active collections use this parameter
		if (!empty($options['works_num'])) {
			$this->db->where('works_num >',0);
		}
		if (isset($options['order'])){
			if ($options['order']=='update_date'){
				$this->db->order_by($options['order'],'desc');
			}
			else if ($options['order']=='top'){
				$this->db->order_by('like_num','desc');
			}

		}
		return $this->db->get();
	}
	
	function update_works_num($id)
	{
		$this->db->where('id',$id);
		$this->db->set('works_num', $this->works_num);
		$this->db->update('collection');
	}
	
	function update_view_num($id)
	{
		$this->db->where('id',$id);
		$this->db->set('view_num',$this->view_num);
		$this->db->update('collection');
	}
	
	function update_like_num($id)
	{
		$this->db->where('id',$id);
		$this->db->set('like_num',$this->like_num);
		$this->db->update('collection');
	}
	
	function update_comment_num($id)
	{
		$this->db->where('id',$id);
		$this->db->set('comment_num',$this->comment_num);
		$this->db->update('collection');
	}
	
	function update_pic($id)
	{
		$this->db->set('pic_url', $this->pic_url);
		$this->db->where('id', $id);
		
		return $this->db->update('collection');
		
	}
	
	function update_add_time($id)
	{
		$this->db->set('update_date',$this->update_date);
		$this->db->where('id',$id);
		
		return $this->db->update('collection');
		
	}
	
	function delete($id)
	{
		return $this->db->delete('collection',array('id'=>$id));
	}
	
	function total_num()
	{
		return $this->db->count_all('collection');
	}
	
	
}


