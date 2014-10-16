<?php
/**
 * 品牌
 *
 *
 */
class task_response_model extends CI_Model
{

    var $comment_content;
    
	var $create_date;

	var $author_id;

	var $topic_id;
    
    var $parent_comment_id;
    
    var $root_comment_id;
    
    var $root_author_id;
    
    var $parent_author_id;

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

        $query = $this->db->get_where('task_response',array('id' => $id));

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
        	$task = $this->db->get_where('task',array('id' => $row['task_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
        	$row['task'] = $task;
        	
        	if ($row['parent_comment_id']!=0&&$row['parent_comment_id']!=null) {
        		$comment = $this->db->get_where('task_response',array('id'=>$row['parent_comment_id']))->row_array();
        		$parent_user = $this->db->get_where('user',array('id'=>$comment['author_id']))->row_array();
        	
        		$row['parent_content'] = $comment['comment_content'];
        		$row['parent_comment_date'] = $comment['create_date'];
        		$row['parent_user'] = $parent_user['displayName'];
        	
        	}
        	else
        	{
        		$rows[] = $row;
        	}            
        }
        return $rows;
       
	}
    
	// --------------------------------------------------------------------
	/**
	 * Get all reply for a special root_comment_id
	 * Difference between reply and comments
	 */
	function find_replies($options = array(), $count=20,$offset=0)
	{
		if (!is_array($options)){
			return array();
		}
		if ($count){
			$this->db->limit((int)$count, (int)$offset);
		}
		
		$query = $this->_query_comments($options);
		
		$rows = array();
		foreach ($query->result_array() as $row){
			$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();			
			$row['author_name'] = $user['displayName'];
			$row['author_pic'] = $user['pic_url'];			
			$rows[] = $row;			
		}
		return $rows;
	}	
	// --------------------------------------------------------------------
	function getall()
	{
		$this->db->select('*');
		//         file_put_contents('d:\\tmp\\tmp.log',$options['root_comment_id'],FILE_APPEND);
		$this->db->from('task_response');
		$query = $this->db->get();
		$list = $query->row_array();
		$rows = array();
// 		foreach($query->result_array() as $row)
// 		{
// 			if(is_array($row))
// 			{
// 				$parent_row = $this->db->get_where('task_response',array('id'=>$row['parent_comment_id']))->row_array();
// // 				$row['parent_author_id'] = $parent_row['author_id'];
// // 				$row['root_comment_id'] = $row['parent_comment_id'];
// // 				$row['root_author_id'] = $parent_row['author_id'];
// // 				$rows[] = $row;
// 			}
// 		}
		return $query->result_array();
	}
	function tmpupdate($id)
	{				
		$this->db->set('parent_author_id', $this->parent_author_id);
		$this->db->set('root_comment_id', $this->root_comment_id);
		$this->db->set('root_author_id', $this->root_author_id);
		$this->db->where('id', $id);
		$this->db->update('task_response');
	
		return $this->db->affected_rows();
	}
	function find_authorid_by_comment_id($comment_id)
	{
		$options = array('id'=>$comment_id);
		$query = $this->_query_comments($options);
		$result = null;
		$rows = array();
		foreach ($query->result_array() as $row){
			$result = $row['author_id'];
			break;		
		}
		return $result;
	}	
	// --------------------------------------------------------------------

    /**
	 * 私有函数
	 *
	 *
	 */
	function _query_comments($options = null)
    {
        $this->db->from('task_response as b');
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        if (!empty($options['task'])){
            $this->db->where('task_id',$options['task']);
        }
        if (isset($options['is_best'])){
            $this->db->where('is_best',$options['is_best']);
        }
        
        if (!empty($options['author_id'])){
            $this->db->where('author_id',$options['author_id']);
        }
        if (isset($options['root_comment_id'])){
        	$this->db->where('root_comment_id',$options['root_comment_id']);        	
        }
       
        if (!empty($options['id'])){
        	$this->db->where('id',$options['id']);
        }
    	if (isset($options['parent_comment_id'])){
        	$this->db->where('parent_comment_id',$options['parent_comment_id']);
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
//         file_put_contents('d:\\tmp\\tmp.log',$options['root_comment_id'],FILE_APPEND);
        $query = $this->_query_comments($options);
        
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
	function count_reply($root_comment_id)
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
		$this->db->set('task_id', $this->task_id);
		$this->db->set('create_date', $datetime);
		$this->db->set('update_date', $datetime);
		if(isset($this->root_comment_id)&&$this->root_comment_id!=null)
		$this->db->set('root_comment_id', $this->root_comment_id);		
		if(isset($this->root_author_id)&&$this->root_author_id!=null)
		$this->db->set('root_author_id', $this->root_author_id);
		if(isset($this->parent_author_id)&&$this->parent_author_id!=null)
		$this->db->set('parent_author_id', $this->parent_author_id);
		

		$this->db->insert('task_response');
		return $this->db->insert_id();		

	}
    function create_()
    { 
		$datetime = date('Y-m-d H:i:s');

        $this->db->set('comment_content', $this->comment_content);
		$this->db->set('author_id', $this->author_id);					
		$this->db->set('parent_comment_id', $this->parent_comment_id);
		$this->db->set('task_id', $this->task_id);
		$this->db->set('create_date', $datetime);
		$this->db->set('update_date', $datetime);
            
        $this->db->insert('task_response');
        
        return $this->db->affected_rows();
    }
    
    function update($id)
    { 
		$datetime = date('Y-m-d H:i:s');

        $this->db->set('comment_content', $this->comment_content);
		$this->db->set('task_id', $this->task_id);
		$this->db->set('update_date', $datetime);
            
        $this->db->where('id', $id);
        $this->db->update('task_response');
        
        return $this->db->affected_rows();
    }
    
    function updateBest($id)
    { 				
		$this->db->set('is_best', $this->is_best);
        $this->db->where('id', $id);    
        return $this->db->update('task_response');
    }
    
    function updateUsefulCount($id,$count)
    {
    	$this->db->trans_start();
    	$this->db->set('useful_count', $count);
    	$this->db->where('id', $id);
   		$this->db->update('task_response');
    	$this->db->trans_complete();
    	return $this->db->trans_status();
    	
    }
    
    function delete($comment_id)
    {        
		$this->db->where('id', $comment_id);
        return $this->db->delete('task_response'); 
    }   
}


