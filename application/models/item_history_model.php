<?php
/**
 *  用户状态模型
 *
 *
 */
class item_history_model extends CI_Model
{
	var $item_id;
    var $action;
	var $content;
	var $download_url;
	
	function __construct()
    {
        parent::__construct();
    }

	// --------------------------------------------------------------------
	
	//向game_status表中插入新数据
	function insertData()
	{
		$datetime = date('Y-m-d H:i:s');

		$this->db->set('item_id', $this->item_id);
		$this->db->set('action', $this->action);
		$this->db->set('content', $this->content);
		$this->db->set('is_folder', $this->is_folder);
		$this->db->set('download_url', $this->download_url);
		$this->db->set('timestamp', $datetime);
		
		return $this->db->insert('game_item_history');
	}
	
	//查找myfollow 的用户的最新状态
	function find_status_by_myfollow($myid)
	{
		$this->db->select('game_item_history.item_id,game_item_history.content,game_item_history.timestamp');
        $this->db->from('game_item_history');
        $this->db->join('game_user_follow', 'game_user_follow.item_id = game_item_history.item_id');
        $this->db->where('game_user_follow.follower_id',$myid);
        $this->db->order_by("game_item_history.timestamp", "desc");
    	$query = $this->db->get();
    	
    	$rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('game_user',array('id' => $row['item_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
            $rows[] = $row;
        }
        return $rows;
	}
	
	function load($id)
    {
        if (!$id){
            return array();
        }

        $query = $this->db->get_where('item_history',array('id' => $id));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }
	
	 /* load by id
	 *
	 *
	 */	
    function loadbyitem($item_id)
    {
        if (!$item_id){
            return array();
        }
        $this->db->from('game_item_history');
        $this->db->where('item_id',$item_id);
        $this->db->order_by("game_item_history.timestamp", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }
	
}