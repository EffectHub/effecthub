<?php
class platform_model extends CI_Model
{
    var $platform;
    
    var $key;
	
	var $active;	
	
	var $open_num;

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
    function load($id)
    {
        if (!$id){
            return array();
        }

        $query = $this->db->get_where('platform',array('id' => $id));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }
    
    /**
	 * load by key
	 *
	 *
	 */	
    function loadByKey($key)
    {
        if (!$key){
            return array();
        }

        $query = $this->db->get_where('platform',array('key' => $key));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }    
    
	// --------------------------------------------------------------------

    /**
	 * 缁撴灉闆�
	 *
	 *
	 */	
    function find_platforms($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_platforms($options);

		$rows = array();
        foreach ($query->result_array() as $row){
            $rows[] = $row;
        }
        return $rows;
       
	}
    
	// --------------------------------------------------------------------

    /**
	 * 绉佹湁鍑芥暟
	 *
	 *
	 */
	function _query_platforms($options = null)
    {
        $this->db->from('platform as b');
       
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
        }else {
            $this->db->order_by('b.id');
        }

        return $this->db->get();
    }
    
	// --------------------------------------------------------------------

	/**
	 * 鎬绘暟
	 *
	 *
	 */	
	function count_platforms_download($options = array())
    {
        $this->db->select('sum(b.count) as total');
        
        $query = $this->_query_platforms($options);
        
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }    
    
    function create()
    { 
		$datetime = date('Y-m-d H:i:s');

        $this->db->set('platform', $this->platform);
        $this->db->set('key', md5($this->platform));
		$this->db->set('create_date', $datetime);
		$this->db->set('update_date', $datetime);
        $this->db->set('expire_date', $this->expire_date);
        $this->db->set('active', $this->active);
        return $this->db->insert('platform');
    } 
    
    function update($id)
    { 
		$datetime = date('Y-m-d H:i:s');
        $this->db->set('platform', $this->platform);
        $this->db->set('key', md5($this->platform));
		$this->db->set('expire_date', $this->expire_date);
		$this->db->set('update_date', $datetime);
		$this->db->set('active', $this->active);
        $this->db->where('id', $id);
        return $this->db->update('platform');
    }
    
    function updateOpenNum($id)
    { 				
		$this->db->set('open_num', $this->open_num);
        $this->db->where('id', $id);    
        return $this->db->update('platform');
    }    
}