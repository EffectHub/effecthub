<?php
/**
 * 品牌
 *
 *
 */
class item_comment_model extends CI_Model
{

    var $content;
    
	var $create_date;

	var $author_id;
	
	var $parent_id;

	var $item_id;
    
    var $parent_item_comment_id;

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

        $query = $this->db->get_where('item_comment',array('id' => $id));

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
    function find_item_comments($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_item_comments($options);

        $rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
        	
        	if ($row['parent_id']>0) {
        		$parent = $this->db->get_where('item_comment',array('id'=>$row['parent_id']))->row_array();
        		$parent_user = $this->db->get_where('user',array('id' => $parent['author_id']))->row_array();
        		$row['parent_user'] = $parent_user['displayName'];
        		$row['parent_date'] = $parent['create_date'];
        		$row['parent_content'] = $parent['content'];
        	}
        	
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
	function _query_item_comments($options = null)
    {
        $this->db->from('item_comment as b');
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        if (!empty($options['item'])){
            $this->db->where('item_id',$options['item']);
        }
        
        if (!empty($options['author_id'])){
            $this->db->where('author_id',$options['author_id']);
        }
        
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
        } else {
            $this->db->order_by('b.id desc'); 
        }

        return $this->db->get();
    }
    
	// --------------------------------------------------------------------

	/**
	 * 总数
	 *
	 *
	 */	
	function count_item_comments($options = null)
    {
        $this->db->select('COUNT(DISTINCT(b.id)) as total');
        
        $query = $this->_query_item_comments($options);
        
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
	
    function create()
    { 
		$datetime = date('Y-m-d H:i:s');

        $this->db->set('content', $this->content);
		$this->db->set('author_id', $this->author_id);				
		$this->db->set('item_id', $this->item_id);
		$this->db->set('parent_id', $this->parent_id);
		$this->db->set('create_date', $datetime);
            
        return $this->db->insert('item_comment');
    }
    
    function delete($item_comment_id)
    {        
		$this->db->where('id', $item_comment_id);
        return $this->db->delete('item_comment'); 
    }   
}