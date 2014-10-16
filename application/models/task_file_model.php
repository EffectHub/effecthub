<?php
/**
 *  用户状态模型
 *
 *
 */
class task_file_model extends CI_Model
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
		$this->db->set('task_id', $this->task_id);
		$this->db->set('type', $this->type);
		$this->db->set('timestamp', $datetime);
		
		return $this->db->insert('game_task_file');
	}
	
	function load($id)
    {
        if (!$id){
            return array();
        }

        $query = $this->db->get_where('task_file',array('id' => $id));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }
	
	 /* load by id
	 *
	 *
	 */	
    function loadbybid($task_id)
    {
        if (!$task_id){
            return array();
        }
        $this->db->from('game_task_file');
        $this->db->join('game_item', 'game_item.id = game_task_file.item_id');
        $this->db->where('task_id',$task_id);
        $this->db->where('game_task_file.type',0);
        $this->db->order_by("game_task_file.timestamp", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }
	
}