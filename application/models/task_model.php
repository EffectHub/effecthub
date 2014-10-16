<?php
/**
 * 品牌
 *
 *
 */
class task_model extends CI_Model
{
	var $id;

    var $task_title;
    
	var $task_content;
	
	var $pic_url;

	var $author_id;

	var $comment_num;
	
	var $view_num;	
    
    var $group_id;
    
    var $item_id;
    
    var $task_language;

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

        $query = $this->db->get_where('task',array('id' => $id));

        if ($row = $query->row_array()){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$type = $this->db->get_where('item_type',array('id' => $row['type']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['type_name'] = $type['name'];
        	$row['type_name_cn'] = $type['name_cn'];
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
    function find_tasks($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count>0){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_tasks($options);

        $rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$type = $this->db->get_where('item_type',array('id' => $row['type']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['type_name'] = $type['name'];
        	$row['type_name_cn'] = $type['name_cn'];
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
	function _query_tasks($options = null)
    {
        $this->db->from('task as b');
       
		if (!empty($options['conditions'])){
            $this->db->where('group_id',$options['conditions']);
        }
        
        if (!empty($options['author_id'])){
            $this->db->where('author_id',$options['author_id']);
        }
        if (!empty($options['type'])){
            $this->db->where('type',$options['type']);
        }
        if (isset($options['language'])){
            $this->db->where('language',$options['language']);
        }
        if (isset($options['status'])){
            $this->db->where('status',$options['status']);
        }
        if (!empty($options['key'])){
            $this->db->like('title',$options['key']);
        }
        if (!empty($options['tag'])){
            $this->db->like('task_tag',$options['tag']);
        }
        if (!empty($options['typein'])){
        	$this->db->where_in('type', $options['typein']);
        }
        if (isset($options['item_id'])){
            $this->db->where_not_in('item_id',$options['item_id']);
        }
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
        }else if (isset($options['rand'])){
            $this->db->order_by('rand()');
        } else {
            $this->db->order_by('b.last_response_time desc');
        }
        if (isset($options['language'])) {
        	$this->db->where('language',$options['language']);
        }

        return $this->db->get();
    }
    
	// --------------------------------------------------------------------

	/**
	 * 总数
	 *
	 *
	 */	
	function count_tasks($options)
    {
    	$this->db->select('COUNT(DISTINCT(b.id)) as total');       
        $query = $this->_query_tasks($options);
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
        $this->db->set('title', $this->title);
		$this->db->set('desc', $this->desc);
		$this->db->set('author_id', $this->author_id);
		$this->db->set('language',$this->language);
		$this->db->set('type',$this->type);
		$this->db->set('price',$this->price);
		$this->db->set('price_type',$this->price_type);
		$this->db->set('task_type',$this->task_type);
		$this->db->set('task_tag',$this->task_tag);
		$this->db->set('create_date', $datetime);
		$this->db->set('update_date', $datetime);  
		$this->db->set('last_response_time', $datetime);  
        return $this->db->insert('task');
    }
    
    function update($id)
    {
		$datetime = date('Y-m-d H:i:s');

        $this->db->set('title', $this->title);
		$this->db->set('desc', $this->desc);
		$this->db->set('language',$this->language);
		$this->db->set('type',$this->type);
		$this->db->set('price',$this->price);
		$this->db->set('price_type',$this->price_type);
		$this->db->set('task_tag',$this->task_tag);
		$this->db->set('status',$this->status);
		$this->db->set('update_date', $datetime);
        $this->db->where('id', $id);
        return $this->db->update('task');
    }   
    
    function updateNum($id)
    { 				
		$this->db->set('response_num', $this->response_num);
        $this->db->where('id', $id);    
        return $this->db->update('task');
    }
    
    function updateStatus($id)
    { 				
		$this->db->set('status', $this->status);
        $this->db->where('id', $id);    
        return $this->db->update('task');
    }
    
    function updateViewNum($id)
    { 				
		$this->db->set('view_num', $this->view_num);
        $this->db->where('id', $id);    
        return $this->db->update('task');
    }  
    
    function updateCommentTime($id)
    { 				
    	$datetime = date('Y-m-d H:i:s');
        $this->db->set('last_response_time', $datetime);
        $this->db->where('id', $id);    
        return $this->db->update('task');
    }    
    
    function delete($id)
    {        
		$this->db->where('id', $id);
        return $this->db->delete('task'); 
    } 
    //search item --local search
    function particle_search($str)
    {
    	$array = array('title'=>$str,'desc'=>$str,'task_tag'=>$str);
    	$this->db->or_like($array);    
    	$query = $this->db->get('game_task');
    	return $query->result_array();
    }
    //search item with offset--local search
    function particle_search_offset($str,$num,$offset)
    {
    	$array = array('title'=>$str,'desc'=>$str,'task_tag'=>$str);
    	$this->db->or_like($array);    	
    	$this->db->select('*');
    	$query = $this->db->get('game_task',$num,$offset);
    	return $query->result_array();
    } 
	
    
}
