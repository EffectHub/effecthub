<?php
/**
 * 品牌
 *
 *
 */
class log_model extends CI_Model
{
    
	var $content;
	
	var $from;
	
	var $isguest;
	
	var $user_id;

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

        $query = $this->db->get_where('log',array('id' => $id));

        if ($row = $query->row_array()){
        	$user = $this->db->get_where('user',array('id' => $row['user_id']))->row_array();
        	$row['author_name'] = $user['name'];
        	$row['author_pic'] = $user['pic_url'];
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
    function find_logs($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_logs($options);

		$rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['user_id']))->row_array();
        	$row['author_name'] = $user['name'];
        	$row['author_pic'] = $user['pic_url'];
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
	function _query_logs($options = null)
    {
        $this->db->from('log as b');
       
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        
        if (!empty($options['from'])){
            $this->db->where('from',$options['from']);
        }
        
        if (!empty($options['user'])){
            $this->db->where('user_id',$options['user']);
        }
        
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
        }else if (isset($options['rand'])){
            $this->db->order_by('rand()');
        } else {
            $this->db->order_by('b.id desc');
        }

        return $this->db->get();
    }
    
	function count_logs($options = array())
    {
        $this->db->select('COUNT(DISTINCT(b.id)) as total');
        
        $query = $this->_query_logs($options);
        
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }    
    
    function create()
    { 
		$this->db->set('content', $this->content);
		$this->db->set('from', $this->from==null?'1':$this->from);
		$this->db->set('is_guest', $this->isguest);
		$this->db->set('user_id', $this->user_id);
        return $this->db->insert('log');
    }
}