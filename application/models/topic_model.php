<?php
/**
 * 品牌
 *
 *
 */
class topic_model extends CI_Model
{
	var $id;

    var $topic_title;
    
	var $topic_content;
	
	var $pic_url;

	var $author_id;

	var $comment_num;
	
	var $view_num;	
    
    var $group_id;
    
    var $item_id;
    
    var $topic_language;

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

        $query = $this->db->get_where('topic',array('id' => $id));

        if ($row = $query->row_array()){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$group = $this->db->get_where('group',array('id' => $row['group_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
        	$row['group_name'] = $group['group_name'];
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
    function find_topics($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count>0){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_topics($options);

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
	function _query_topics($options = null)
    {
        $this->db->from('topic as b');
       
		if (!empty($options['conditions'])){
            $this->db->where('group_id',$options['conditions']);
        }
        
        if (!empty($options['author_id'])){
            $this->db->where('author_id',$options['author_id']);
        }
        if (isset($options['topic_language'])){
            $this->db->where('topic_language',$options['topic_language']);
        }
        if (!empty($options['key'])){
            $this->db->like('topic_title',$options['key']);
        }
        if (isset($options['item_id'])){
            $this->db->where_not_in('item_id',$options['item_id']);
        }
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
        }else if (isset($options['rand'])){
            $this->db->order_by('rand()');
        } else {
            $this->db->order_by('b.last_comment_time desc');
        }
        if (isset($options['language'])) {
        	$this->db->where('topic_language',$options['language']);
        }

        return $this->db->get();
    }
    
	// --------------------------------------------------------------------

	/**
	 * 总数
	 *
	 *
	 */	
	function count_topics($group_id,$options)
    {
    	$this->db->select('COUNT(DISTINCT(b.id)) as total');       
        $query = $this->_query_topics($options);
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
    
    function create()
    { 
		$datetime = date('Y-m-d H:i:s');
		$this->db->set('id', $this->id);
        $this->db->set('topic_title', $this->topic_title);
		$this->db->set('topic_content', $this->topic_content);
		$this->db->set('author_id', $this->author_id);		
		$this->db->set('item_id', $this->item_id);				
		$this->db->set('comment_num', $this->comment_num);
		$this->db->set('pic_url', $this->pic_url);
		$this->db->set('group_id', $this->group_id);
		$this->db->set('topic_language',$this->topic_language);
		$this->db->set('create_date', $datetime);
		$this->db->set('update_time', $datetime);
        $this->db->set('last_comment_time', $datetime);    
        return $this->db->insert('topic');
    }
    
    function update($id)
    {
		$datetime = date('Y-m-d H:i:s');

        $this->db->set('topic_title', $this->topic_title);
		$this->db->set('topic_content', $this->topic_content);
		$this->db->set('pic_url', $this->pic_url);
		$this->db->set('topic_language',$this->topic_language);
		$this->db->set('update_time', $datetime);
        $this->db->where('id', $id);
        return $this->db->update('topic');
    }   
    
    function updateNum($id)
    { 				
		$this->db->set('comment_num', $this->comment_num);
        $this->db->where('id', $id);    
        return $this->db->update('topic');
    }
    
    function updateViewNum($id)
    { 				
		$this->db->set('view_num', $this->view_num);
        $this->db->where('id', $id);    
        return $this->db->update('topic');
    }  
    
    function updateCommentTime($id)
    { 				
    	$datetime = date('Y-m-d H:i:s');
        $this->db->set('last_comment_time', $datetime);
        $this->db->where('id', $id);    
        return $this->db->update('topic');
    }    
    
    function delete($id)
    {        
		$this->db->where('id', $id);
        return $this->db->delete('topic'); 
    }  
    //search item --local search
    function particle_search($str)
    {
    	$array = array('topic_title'=>$str);
    	$this->db->or_like($array);
    	$query = $this->db->get('game_topic');
    	return $query->result_array();
    }
    //search item with offset--local search
    function particle_search_offset($str,$num,$offset)
    {
    	$array = array('topic_title'=>$str);
    	$this->db->or_like($array);
    	$this->db->select('*');//select('id as id,group_name as title, group_desc as desc, pic_url as pic_url');
    	$query = $this->db->get('game_topic',$num,$offset);
    	return $query->result_array();
    }
	
    
}
