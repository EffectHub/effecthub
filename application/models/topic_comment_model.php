<?php
/**
 * 品牌
 *
 *
 */
class topic_comment_model extends CI_Model
{

    var $comment_content;
    
	var $create_date;

	var $author_id;

	var $topic_id;
    
    var $parent_comment_id;

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

        $query = $this->db->get_where('topic_comment',array('id' => $id));

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
    function find_comments($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_comments($options);

        $rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
        	
        	if ($row['parent_comment_id']!=0&&$row['parent_comment_id']!=null) {
        		$comment = $this->db->get_where('topic_comment',array('id'=>$row['parent_comment_id']))->row_array();
        		$parent_user = $this->db->get_where('user',array('id'=>$comment['author_id']))->row_array();
        	
        		$row['parent_content'] = $comment['comment_content'];
        		$row['parent_comment_date'] = $comment['create_date'];
        		$row['parent_user'] = $parent_user['displayName'];
        	
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
	function _query_comments($options = null)
    {
        $this->db->from('topic_comment as b');
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        if (!empty($options['topic'])){
            $this->db->where('topic_id',$options['topic']);
        }
        
        if (!empty($options['author_id'])){
            $this->db->where('author_id',$options['author_id']);
        }
        
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
        } else {
            $this->db->order_by('b.create_date desc'); 
        }

        return $this->db->get();
    }
    
	// --------------------------------------------------------------------

	/**
	 * 总数
	 *
	 *
	 */	
	function count_comments($options = null)
    {
        $this->db->select('COUNT(DISTINCT(b.id)) as total');
        
        $query = $this->_query_comments($options);
        
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
	
    function create()
    { 
		$datetime = date('Y-m-d H:i:s');

        $this->db->set('comment_content', $this->comment_content);
		$this->db->set('author_id', $this->author_id);					
		$this->db->set('parent_comment_id', $this->parent_comment_id);
		$this->db->set('topic_id', $this->topic_id);
		$this->db->set('create_date', $datetime);
            
        $this->db->insert('topic_comment');
        
        return $this->db->affected_rows();
    }
    
    function delete($comment_id)
    {        
		$this->db->where('id', $comment_id);
        return $this->db->delete('topic_comment'); 
    }   
}


