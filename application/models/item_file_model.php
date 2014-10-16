<?php
/**
 *  用户状态模型
 *
 *
 */
class item_file_model extends CI_Model
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
		$this->db->set('download_url', $this->download_url);
		$this->db->set('timestamp', $datetime);
		
		return $this->db->insert('game_item_file');
	}
	
	function load($id)
    {
        if (!$id){
            return array();
        }

        $query = $this->db->get_where('item_file',array('id' => $id));

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
        $this->db->from('game_item_file');
        $this->db->where('item_id',$item_id);
        $this->db->order_by("game_item_file.timestamp", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }
	
}