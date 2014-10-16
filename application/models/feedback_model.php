<?php
/**
 * 品牌
 *
 *
 */
class feedback_model extends CI_Model
{
	var $id;

    var $name;
    
	var $email;
	
	var $comment;

	var $subscribe;

	var $donate;
	
	var $attend;	
    
    var $tool;
    
    var $from;

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

        $query = $this->db->get_where('feedback',array('id' => $id));

        if ($row = $query->row_array()){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
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
    function find_feedbacks($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_feedbacks($options);

        $rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$group = $this->db->get_where('group',array('id' => $row['group_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['group_name'] = $group['group_name'];
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
	function _query_feedbacks($options = null)
    {
        $this->db->from('feedback as b');
       
		if (!empty($options['conditions'])){
            $this->db->where('group_id',$options['conditions']);
        }
        
        if (!empty($options['author_id'])){
            $this->db->where('author_id',$options['author_id']);
        }
        if (!empty($options['key'])){
            $this->db->like('feedback_title',$options['key']);
        }
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
        } else {
            $this->db->order_by('b.last_comment_time desc');
        }

        return $this->db->get();
    }
    
	// --------------------------------------------------------------------

	/**
	 * 总数
	 *
	 *
	 */	
	function count_feedbacks($group_id,$options)
    {
    	$this->db->select('COUNT(DISTINCT(b.id)) as total');       
        $query = $this->_query_feedbacks($options);
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
    
    function create()
    { 
		$datetime = date('Y-m-d H:i:s');
        $this->db->set('name', $this->name);
		$this->db->set('email', $this->email);
		$this->db->set('comment', $this->comment);					
		$this->db->set('subscribe', $this->subscribe);
		$this->db->set('donate', $this->donate);
		$this->db->set('attend', $this->attend);
		$this->db->set('tool', $this->tool);
		$this->db->set('from', $this->from);
        $this->db->set('create_date', $datetime);    
        return $this->db->insert('feedback');
    }
    
    function update($id)
    {
		$datetime = date('Y-m-d H:i:s');

        $this->db->set('feedback_title', $this->feedback_title);
		$this->db->set('feedback_content', $this->feedback_content);
		$this->db->set('pic_url', $this->pic_url);
		$this->db->set('update_time', $datetime);
        $this->db->where('id', $id);
        return $this->db->update('feedback');
    }   
    
    function updateNum($id)
    { 				
		$this->db->set('comment_num', $this->comment_num);
        $this->db->where('id', $id);    
        return $this->db->update('feedback');
    }
    
    function updateCommentTime($id)
    { 				
    	$datetime = date('Y-m-d H:i:s');
        $this->db->set('last_comment_time', $datetime);
        $this->db->where('id', $id);    
        return $this->db->update('feedback');
    }    
    
    function delete($id)
    {        
		$this->db->where('id', $id);
        return $this->db->delete('feedback'); 
    }   
	
    
}