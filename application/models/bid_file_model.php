<?php
/**
 *  用户状态模型
 *
 *
 */
class bid_file_model extends CI_Model
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
		$this->db->set('bid_id', $this->bid_id);
		$this->db->set('type', $this->type);
		$this->db->set('timestamp', $datetime);
		
		return $this->db->insert('game_bid_file');
	}
	
	function load($id)
    {
        if (!$id){
            return array();
        }

        $query = $this->db->get_where('bid_file',array('id' => $id));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }
	
	 /* load by id
	 *
	 *
	 */	
    function loadbybid($bid_id)
    {
        if (!$bid_id){
            return array();
        }
        $this->db->from('game_bid_file');
        $this->db->join('game_item', 'game_item.id = game_bid_file.item_id');
        $this->db->where('bid_id',$bid_id);
        $this->db->where('game_bid_file.type',0);
        $this->db->order_by("game_bid_file.timestamp", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function loadsourcebybid($bid_id)
    {
        if (!$bid_id){
            return array();
        }
        $this->db->from('game_bid_file');
        $this->db->join('game_item', 'game_item.id = game_bid_file.item_id');
        $this->db->where('bid_id',$bid_id);
        $this->db->where('game_bid_file.type',1);
        $this->db->order_by("game_bid_file.timestamp", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }
	
}