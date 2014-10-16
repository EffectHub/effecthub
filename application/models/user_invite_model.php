<?php
/**
 * 品牌
 *
 *
 */
class user_invite_model extends CI_Model
{

    var $group_name;
    
	var $group_desc;

	var $group_type;

	var $member_num;
    
    var $topic_num;

	var $user_id;
	
	var $inviter_id;
	
	var $group_id;
	
	var $role;

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
		$this->db->where('status', 0);
        $query = $this->db->get_where('user_invite');
        
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
    
    function loadByUser($id)
    {
        if (!$id){
            return array();
        }
		$rows = array();
        $query = $this->db->get_where('user_invite',array('user_id' => $id));
		foreach ($query->result_array() as $row){
        	$group = $this->db->get_where('group',array('id' => $row['group_id']))->row_array();
        	$row['group_name'] = $group['group_name'];
        	$row['group_pic'] = $group['group_pic'];
        	$row['group_type'] = $group['group_type'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    function loadByGroup($id)
    {
        if (!$id){
            return array();
        }
		$this->db->limit(20, 0);
        $rows = array();
        $this->db->from('user_invite as b');
        $this->db->where('b.group_id',$id);
        $this->db->order_by('b.timestamp desc');
        $query = $this->db->get();
		foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['inviter_id']))->row_array();
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
		$this->db->set('inviter_id', $this->inviter_id);
		$this->db->set('group_id', $this->group_id);
		$this->db->set('timestamp', $datetime);
            
        return $this->db->insert('user_invite');
    } 
    
    function delete($id)
    {        
		$this->db->where('id', $id);
        return $this->db->delete('user_invite'); 
    }
    
    function update($uid,$group_id)
    { 
		$this->db->set('status', $this->status);
        $this->db->where('user_id', $uid);  
        $this->db->where('group_id', $group_id);   
        return $this->db->update('user_invite');
    }   
	
    function updateNum($id)
    { 				
		$this->db->set('topic_num', $this->topic_num);
        $this->db->where('id', $id);    
        return $this->db->update('group');
    }
}