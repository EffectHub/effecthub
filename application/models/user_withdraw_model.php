<?php
/**
 * 品牌
 *
 *
 */
class user_withdraw_model extends CI_Model
{

    var $user_withdraw_name;
    
	var $user_withdraw_desc;

	var $user_withdraw_type;

	var $member_num;
    
    var $topic_num;

	var $user_id;
	
	var $user_withdraw_id;
	
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
	 function loadCountByUser($id,$user_withdraw)
    {
         $this->db->select('COUNT(*) as total');
        $this->db->where('user_id', $id);
		$this->db->where('user_withdraw_id', $user_withdraw);
        $query = $this->db->get_where('user_withdraw');
        
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
    
    function loadByUseruser_withdraw($id,$user_withdraw)
    {
    	return $this->db->get_where('user_withdraw',array('user_id'=>$id,'user_withdraw_id'=>$user_withdraw))->row_array();
    }
    
    function loadByUser($id)
    {
        if (!$id){
            return array();
        }
		$rows = array();
        $query = $this->db->get_where('user_withdraw',array('user_id' => $id));
		foreach ($query->result_array() as $row){
        	$user_withdraw = $this->db->get_where('user_withdraw',array('id' => $row['user_withdraw_id']))->row_array();
        	$row['user_withdraw_name'] = $user_withdraw['user_withdraw_name'];
        	$row['user_withdraw_pic'] = $user_withdraw['user_withdraw_pic'];
        	$row['user_withdraw_type'] = $user_withdraw['user_withdraw_type'];
        	$row['private'] = $user_withdraw['is_private'];
        	$row['member_num'] = $user_withdraw['member_num'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    function loadByuser_withdraw($id, $limit = 12, $offset=0)
    {
        if (!$id){
            return array();
        }
        if ($limit>0){
			$this->db->limit($limit, $offset);
        }
        $rows = array();
        $this->db->from('user_withdraw as b');
        $this->db->where('b.user_withdraw_id',$id);
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
    function find_user_withdraws($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_user_withdraws($options);

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
	function _query_user_withdraws($options = null)
    {
        $this->db->from('user_withdraw as b');
       
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        if (!empty($options['type'])){
            $this->db->where('user_withdraw_type',$options['type']);
            $this->db->order_by('rand()');
            return $this->db->get();
        }
        if (!empty($options['user_id'])){
        	$this->db->where('user_id',$options['user_id']);
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
	function count_user_withdraws($options = array())
    {
        $this->db->select('COUNT(DISTINCT(b.id)) as total');
        
        $query = $this->_query_user_withdraws($options);
        
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
		$this->db->set('withdraw_name', $this->withdraw_name);
		$this->db->set('withdraw_email', $this->withdraw_email);
		$this->db->set('withdraw_amount', $this->withdraw_amount);
		$this->db->set('withdraw_time', $datetime);
            
        return $this->db->insert('user_withdraw');
    } 
    
    function delete($user_id,$user_withdraw_id)
    {        
		$this->db->where('user_id', $user_id);
		$this->db->where('user_withdraw_id', $user_withdraw_id);
        return $this->db->delete('user_withdraw'); 
    }
    
    function update($id)
    { 

        $datetime = date('Y-m-d H:i:s');

		$this->db->set('withdraw_name', $this->withdraw_name);
		$this->db->set('withdraw_email', $this->withdraw_email);
		$this->db->set('withdraw_amount', $this->withdraw_amount);
		$this->db->set('update_time', $datetime);
		
        $this->db->where('id', $id);    
        return $this->db->update('user_withdraw');
    }   
	
    function updateStatus($id)
    { 				
		$this->db->set('status', $this->status);
        $this->db->where('id', $id);    
        return $this->db->update('user_withdraw');
    }
    
    
    //every visit or comment in a user_withdraw makes visit_hot increase which caculate the user_withdraws I usually visit.
    function update_hot($id)
    {
    	$this->db->set('visit_hot',$this->visit_hot);
    	$this->db->where(array('user_withdraw_id'=>$id,'user_id'=>$this->session->userdata('id')));
    	$this->db->update('user_withdraw');
    }
    
    //my joined user_withdraws number
    function user_withdraw_num($id)
    {
    	$query = $this->db->get_where('user_withdraw',array('user_id'=>$id));
    	return count($query->result_array());
    }
    
    
}


