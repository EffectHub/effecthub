<?php
/**
 * 品牌
 *
 *
 */
class item_type_model extends CI_Model
{

    var $name;
    
	var $byname;

	var $desc;

	var $logo_path;
    
    var $website;

	var $sort_order;

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

        $query = $this->db->get_where('item_type',array('id' => $id));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }
    
	// --------------------------------------------------------------------

    /**
	 * 结果集
	 *
	 *
	 */	
    function find_item_types($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_item_types($options);

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
	function _query_item_types($options = null)
    {
        $this->db->from('item_type as b');
       
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        if (!empty($options['fileable'])){
            $this->db->where('fileable',$options['fileable']);
        }
        if (isset($options['active'])){
            $this->db->where('active',$options['active']);
        }
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
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
	function count_item_types($options = array())
    {
        $this->db->select('COUNT(DISTINCT(b.id)) as total');
        
        $query = $this->_query_item_types($options);
        
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
	
    
}