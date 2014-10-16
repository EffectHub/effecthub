<?php
/**
 * 品牌
 *
 *
 */
class user_group_model extends CI_Model
{

    var $group_name;
    
	var $group_desc;

	var $group_type;

	var $member_num;
    
    var $topic_num;

	var $user_id;
	
	var $group_id;
	
	var $role;
	
	var $visit_hot;
	
	var $hot;
	
	function __construct()
    {
        parent::__construct();
    }

	// --------------------------------------------------------------------

    /**
	 * load by id
	 *
	 *
	 */	
	 function loadCountByUser($id,$group)
    {
         $this->db->select('COUNT(*) as total');
        $this->db->where('user_id', $id);
		$this->db->where('group_id', $group);
        $query = $this->db->get_where('user_group');
        
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
    
    function loadByUserGroup($id,$group)
    {
    	return $this->db->get_where('user_group',array('user_id'=>$id,'group_id'=>$group))->row_array();
    }
    
    function loadByUser($id)
    {
        if (!$id){
            return array();
        }
		$rows = array();
        $query = $this->db->get_where('user_group',array('user_id' => $id));
		foreach ($query->result_array() as $row){
        	$group = $this->db->get_where('group',array('id' => $row['group_id']))->row_array();
        	$row['group_name'] = $group['group_name'];
        	$row['group_pic'] = $group['group_pic'];
        	$row['group_type'] = $group['group_type'];
        	$row['private'] = $group['is_private'];
        	$row['member_num'] = $group['member_num'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    function loadByGroup($id, $limit = 12, $offset=0)
    {
        if (!$id){
            return array();
        }
        if ($limit>0){
			$this->db->limit($limit, $offset);
        }
        $rows = array();
        $this->db->from('user_group as b');
        $this->db->where('b.group_id',$id);
        $this->db->order_by('b.timestamp desc');
        $query = $this->db->get();
		foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['user_id']))->row_array();
        	$row['user_name'] = $user['displayName'];
        	$row['user_pic'] = $user['pic_url'];
            $rows[] = $row;
        }
        return $rows;
    }
    
	// --------------------------------------------------------------------

    /**
	 * 结果集
	 *
	 *
	 */	
    function find_groups($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_groups($options);

        $rows = array();
        foreach ($query->result_array() as $row){
            $rows[] = $row;
        }
        return $rows;
       
	}
    
	// --------------------------------------------------------------------

    /**
	 * 私有函数
	 *
	 *
	 */
	function _query_groups($options = null)
    {
        $this->db->from('group as b');
       
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        if (!empty($options['type'])){
            $this->db->where('group_type',$options['type']);
            $this->db->order_by('rand()');
            return $this->db->get();
        }
        if (!empty($options['author_id'])){
        	$this->db->where('author_id',$options['author_id']);
        	return $this->db->get();
        }
        
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
        }else if (isset($options['rand'])){
            $this->db->order_by('rand()');
        } else {
            $this->db->order_by('b.id');
        }

        return $this->db->get();
    }
    
	// --------------------------------------------------------------------

	/**
	 * 总数
	 *
	 *
	 */	
	function count_groups($options = array())
    {
        $this->db->select('COUNT(DISTINCT(b.id)) as total');
        
        $query = $this->_query_groups($options);
        
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
    
    function create()
    { 
		$datetime = date('Y-m-d H:i:s');

		$this->db->set('user_id', $this->user_id);
		$this->db->set('group_id', $this->group_id);
		$this->db->set('role', $this->role);
		$this->db->set('timestamp', $datetime);
            
        return $this->db->insert('user_group');
    } 
    
    function delete($user_id,$group_id)
    {        
		$this->db->where('user_id', $user_id);
		$this->db->where('group_id', $group_id);
        return $this->db->delete('user_group'); 
    }
    
    function update($id)
    { 

        $this->db->set('group_name', $this->group_name);
		$this->db->set('group_desc', $this->group_desc);
		$this->db->set('group_type', $this->group_type);
		$this->db->set('group_pic', $this->group_pic);
		$this->db->set('group_weibo_id', $this->group_weibo_id);
        $this->db->where('id', $id);    
        return $this->db->update('group');
    }   
	
    function updateNum($id)
    { 				
		$this->db->set('topic_num', $this->topic_num);
        $this->db->where('id', $id);    
        return $this->db->update('group');
    }
    
    
    //every visit or comment in a group makes visit_hot increase which caculate the groups I usually visit.
    function update_hot($id)
    {
    	$this->db->set('visit_hot',$this->visit_hot);
    	$this->db->where(array('group_id'=>$id,'user_id'=>$this->session->userdata('id')));
    	$this->db->update('user_group');
    }
    
    //my joined groups number
    function group_num($id)
    {
    	$query = $this->db->get_where('user_group',array('user_id'=>$id));
    	return count($query->result_array());
    }
    
    
}


