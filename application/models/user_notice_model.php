<?php
/**
 *  用户状态模型
 *
 *
 */
class user_notice_model extends CI_Model
{
	var $user_id;
	
	var $action;
    
	var $content;
	
	var $timestamp;
	
	function __construct()
    {
        parent::__construct();
    }

	// --------------------------------------------------------------------
	
	//向game_user_notice表中插入新数据
	function insertData()
	{
		$datetime = date('Y-m-d H:i:s');

		$this->db->set('user_id', $this->user_id);
		$this->db->set('action', $this->action);
		$this->db->set('content', $this->content);
		$this->db->set('timestamp', $datetime);
		
		return $this->db->insert('game_user_notice');
	}
	
	function update_read($id)
    {
		$this->db->set('read','1');	
        $this->db->where('user_id', $id);
        return $this->db->update('game_user_notice');
    }
	
	function find_unread_count($myid)
	{
		$this->db->select('count(*) total');
        $this->db->from('game_user_notice');
        $this->db->where('game_user_notice.user_id',$myid);
        $this->db->where('game_user_notice.read','0');
        $this->db->order_by("game_user_notice.timestamp", "desc");
    	$query = $this->db->get();
    	if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
	}
	
	function count_notice($myid)
	{
		$this->db->select('count(*) total');
        $this->db->from('game_user_notice');
        $this->db->where('game_user_notice.user_id',$myid);
        $query = $this->db->get();
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
	}
	
	//查找用户的最新状态
	function find_notice($myid,$num,$offset)
	{
		$this->db->select('game_user_notice.user_id,game_user_notice.action,game_user_notice.content,game_user_notice.timestamp');
        $this->db->from('game_user_notice');
        $this->db->where('game_user_notice.user_id',$myid);
        $this->db->order_by("game_user_notice.timestamp", "desc");
        $this->db->limit((int)$num, (int)$offset);
    	$query = $this->db->get();
    	
    	$rows = array();
        foreach ($query->result_array() as $row){
            $rows[] = $row;
        }
        return $rows;
	}
	
	function find_all_notice($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_status($options);

        return $query->result_array();
       
	}
    
    function _query_status($options = null)
    {
        $this->db->from('user_notice as b');
       
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        if (!empty($options['user'])){
            $this->db->where('user_id',$options['user']);
        }
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
        }else {
            $this->db->order_by('b.id desc');
        }

        return $this->db->get();
    }
	
	function updateNotice($id)
    {
    	$this->db->set('content', $this->content);
    	$this->db->set('timestamp', $this->timestamp);
        $this->db->where('id', $id);
        return $this->db->update('user_notice');
    }
	
}
