<?php
class Collection_work_model extends CI_Model 
{
	
	var $work_id;
	var $collection_id;

	var $owner_id;
	var $add_time;
	
	function __construct()
	{	
		parent::__construct();
	}


	
	// add a work to a collection
	function add_work($id)
    { 
    	
    	$this->db->set('work_id',$this->work_id);
    	$this->db->set('collection_id',$this->collection_id);
    	$this->db->set('owner_id',$id);
    	$this->db->set('add_time',$this->add_time);
    	
    	$this->db->insert('collection_work');

    	
    	return;
    	
	} 
	

	
	/*
	 * load collection works by options, detail represents that if it is 1, we need more details of these works,
	 * if it is 0, we only load the data in the table collection_work,
	 * if it is 2, we need more details of these collections 
	 */
	function find_works($options = array(), $detail=1, $count=10, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        
        if ($count>0){
            $this->db->limit((int)$count, (int)$offset);
        }

		$query = $this->_query_items($options, $detail);
		
		if ($detail == 1){
			
			$rows = array();
			
			foreach ($query->result_array() as $row){
				$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
				$type = $this->db->get_where('item_type',array('id' => $row['type']))->row_array();
				if($row['tool']>0){
					$tool = $this->db->get_where('tool',array('id' => $row['tool']))->row_array();
					$row['tool_name'] = $tool['name'];
					$row['tool_domain'] = $tool['domain'];
					$row['tool_pic'] = $tool['thumb_url'];
				}
				if($row['platform']>0){
					$platform = $this->db->get_where('platform',array('id' => $row['platform']))->row_array();
					$row['platform_name'] = $platform['name'];
					$row['platform_pic'] = $platform['pic_url'];
				}
				$row['author_name'] = $user['displayName'];
				$row['type_name'] = $type['name'];
				$row['author_pic'] = $user['pic_url'];
				$row['author_level'] = $user['level'];
				$row['author_point'] = $user['point'];
				$rows[] = $row;
			}
			
			
			return $rows;
		}
		
		return $query->result_array();

        
		
	}
	
	
	//private function
	function _query_items($options = null, $detail=0)
	{
		$this->db->from('collection_work');
		if (!empty($options['work_id'])) {
			$this->db->where('work_id',$options['work_id']);
		}
		if (!empty($options['owner_id'])) {
			$this->db->where('owner_id',$options['owner_id']);
		}
		if (!empty($options['collection_id'])) {
			$this->db->where('collection_id',$options['collection_id']);
		}
		
		if (isset($options['order'])){
			$this->db->order_by($options['order'],'desc');
		}
		
		if ($detail == 1) {
			$this->db->join('item','collection_work.work_id=item.id','left');
		}

		if ($detail == 2) {
			$this->db->join('collection','collection_work.collection_id=collection.id','left');
		}
		
		return $this->db->get();
	}
	
	function delete($collection,$item=null)
	{
		$this->db->where('collection_id',$collection);
		if ($item!=null) $this->db->where('work_id',$item);
		return $this->db->delete('collection_work');
	}
	
	
	
}


