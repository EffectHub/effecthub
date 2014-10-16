<?php
/**
 *  用户状态模型
 *
 *
 */
class item_code_model extends CI_Model
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
		$this->db->set('download_url', $this->download_url);
		$this->db->set('timestamp', $datetime);
		
		return $this->db->insert('game_item_code');
	}
	
	function create()
    { 
		$datetime = date('Y-m-d H:i:s');
			
		$this->db->set('item_id', $this->item_id);
		$this->db->set('item_html', $this->item_html);
		$this->db->set('item_css', $this->item_css);
		$this->db->set('item_js', $this->item_js);
		$this->db->set('item_as', $this->item_as);
		$this->db->set('item_key', $this->item_key);
		$this->db->set('create_date', $datetime);
		$this->db->set('update_date', $datetime);
            
        return $this->db->insert('item_code');
    }
    
    function update($id)
    { 
		$datetime = date('Y-m-d H:i:s');
			
		$this->db->set('item_html', $this->item_html);
		$this->db->set('item_css', $this->item_css);
		$this->db->set('item_js', $this->item_js);
		$this->db->set('item_as', $this->item_as);
		$this->db->set('update_date', $datetime);
        $this->db->where('id', $id);
        return $this->db->update('item_code');
    }
	
	function load($id)
    {
        if (!$id){
            return array();
        }

        $query = $this->db->get_where('item_code',array('id' => $id));

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
        $this->db->from('game_item_code');
        $this->db->where('item_id',$item_id);
        $this->db->order_by("game_item_code.update_date", "desc");
        $query = $this->db->get();
        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }
	
}