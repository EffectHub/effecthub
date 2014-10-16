<?php
/**
 * 品牌
 *
 *
 */
class user_watch_model extends CI_Model
{

    var $group_name;
    
	var $group_desc;

	var $group_type;

	var $member_num;
    
    var $topic_num;

	var $user_id;
	
	var $group_id;
	
	var $role;

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
	 function loadByUserAndWatch($id,$item_id,$is_folder=0)
    {
        $this->db->where('user_id', $id);
		$this->db->where('item_id', $item_id);
		$this->db->where('is_folder', $is_folder);
        $query = $this->db->get_where('user_watch');
        
        return $query->row_array();
    }
    
    function loadByUser($id)
    {
        if (!$id){
            return array();
        }
		$rows = array();
        $query = $this->db->get_where('user_watch',array('user_id' => $id));
		foreach ($query->result_array() as $row){
			if($row['is_folder']==0){
				$item = $this->db->get_where('item',array('id' => $row['item_id']))->row_array();
		        $row['title'] = $item['title'];
        	}else{
        		$item = $this->db->get_where('user_folder',array('id' => $row['item_id']))->row_array();
	        	$row['title'] = $item['folder_name'];
        	}
			
            $rows[] = $row;
        }
        return $rows;
    }
    
    function loadUserFollow($id)
    {
        if (!$id){
            return array();
        }
		$rows = array();
		$this->db->where('user_id', $id);
		$this->db->where('fav_type', 3);
        $query = $this->db->get_where('user_watch');
		foreach ($query->result_array() as $row){
			$user = $this->db->get_where('customer',array('id' => $row['item_id']))->row_array();
	        $row['user_name'] = $user['name'];
        	$row['user_pic'] = $user['pic_url'];
            $rows[] = $row;
        }
        return $rows;
    }    
    
    function loadByGroup($id)
    {
        if (!$id){
            return array();
        }
		$this->db->limit(20, 0);
        $rows = array();
        $query = $this->db->get_where('user_watch',array('group_id' => $id));
		foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('customer',array('id' => $row['user_id']))->row_array();
        	$row['user_name'] = $user['name'];
        	$row['user_pic'] = $user['pic_url'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    function loadByApp($id)
    {
        if (!$id){
            return array();
        }
		$this->db->limit(20, 0);
        $rows = array();
        $this->db->from('user_watch');
        $this->db->where(array('item_id' => $id,'fav_type' => 1));
         $this->db->order_by('timestamp desc');
        $query = $this->db->get();
		foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('customer',array('id' => $row['user_id']))->row_array();
        	$row['user_name'] = $user['name'];
        	$row['user_pic'] = $user['pic_url'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    function loadBySubject($id)
    {
        if (!$id){
            return array();
        }
		$this->db->limit(20, 0);
        $rows = array();
        $this->db->from('user_watch');
        $this->db->where(array('item_id' => $id,'fav_type' => 5));
         $this->db->order_by('timestamp desc');
        $query = $this->db->get();
		foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('customer',array('id' => $row['user_id']))->row_array();
        	$row['user_name'] = $user['name'];
        	$row['user_pic'] = $user['pic_url'];
            $rows[] = $row;
        }
        return $rows;
    }    
    
    function loadByShop($id)
    {
        if (!$id){
            return array();
        }
		$this->db->limit(20, 0);
        $rows = array();
        $query = $this->db->get_where('user_watch',array('item_id' => $id,'fav_type' => 3));
		foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('customer',array('id' => $row['user_id']))->row_array();
        	$row['user_name'] = $user['name'];
        	$row['user_pic'] = $user['pic_url'];
            $rows[] = $row;
        }
        return $rows;
    }    
    
	// --------------------------------------------------------------------

    /**
	 * 结果集
	 *
	 *
	 */	
    function find_groups($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_groups($options);

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
	function _query_groups($options = null)
    {
        $this->db->from('group as b');
       
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        if (!empty($options['type'])){
            $this->db->where('group_type',$options['type']);
            $this->db->order_by('rand()');
            return $this->db->get();
        }
        
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
        }else if (isset($options['rand'])){
            $this->db->order_by('rand()');
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
	function count_groups($options = array())
    {
        $this->db->select('COUNT(DISTINCT(b.id)) as total');
        
        $query = $this->_query_groups($options);
        
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
    
    function create()
    { 
		$datetime = date('Y-m-d H:i:s');

		$this->db->set('user_id', $this->user_id);
		$this->db->set('item_id', $this->item_id);
		$this->db->set('is_folder', $this->is_folder);
		$this->db->set('timestamp', $datetime);
            
        return $this->db->insert('user_watch');
    } 
    
    function delete($user_id,$item_id, $is_folder=0)
    {        
		$this->db->where('user_id', $user_id);
		$this->db->where('item_id', $item_id);
		$this->db->where('is_folder', $is_folder);
        return $this->db->delete('user_watch'); 
    } 
    
    //find item history by mywatch
    function find_history_by_mywatch($myid)
    {
    	$this->db->select('game_item_history.is_folder,game_item_history.item_id,game_item_history.action,game_item_history.content,game_item_history.timestamp');
        $this->db->from('game_item_history');
        $this->db->join('game_user_watch', 'game_user_watch.item_id = game_item_history.item_id');
        $this->db->where('game_user_watch.user_id',$myid);
        $this->db->order_by("game_item_history.timestamp", "desc");
    	$query = $this->db->get();
    	
    	$rows = array();
        foreach ($query->result_array() as $row){
        	if($row['is_folder']==0){
	        	$item = $this->db->get_where('game_item',array('id' => $row['item_id']))->row_array();
	        	$row['item_title'] = $item['title'];
	        	$row['item_pic'] = $item['pic_url'];
        	}else{
        		$item = $this->db->get_where('game_user_folder',array('id' => $row['item_id']))->row_array();
	        	$row['item_title'] = $item['folder_name'];
	        	$row['item_pic'] = 'http://www.effecthub.com/images/cloud/folder.png';
        	}
            $rows[] = $row;
        }
        return $rows;
    }
    
    function find_history_by_mywatch_offset($myid,$num,$offset)
    {
    	$this->db->select('game_item_history.is_folder,game_item_history.item_id,game_item_history.action,game_item_history.content,game_item_history.timestamp');
        //$this->db->from('game_item_history');
        $this->db->join('game_user_watch', 'game_user_watch.item_id = game_item_history.item_id');
        $this->db->where('game_user_watch.user_id',$myid);
        $this->db->order_by("game_item_history.timestamp", "desc");
    	$query = $this->db->get('game_item_history',$num,$offset);
    	
    	$rows = array();
        foreach ($query->result_array() as $row){
        	if($row['is_folder']==0){
	        	$item = $this->db->get_where('game_item',array('id' => $row['item_id']))->row_array();
	        	$row['item_title'] = $item['title'];
	        	$row['item_pic'] = $item['pic_url'];
        	}else{
        		$item = $this->db->get_where('game_user_folder',array('id' => $row['item_id']))->row_array();
	        	$row['item_title'] = $item['folder_name'];
	        	$row['item_pic'] = 'http://www.effecthub.com/images/cloud/folder.png';
        	}
            $rows[] = $row;
        }
        return $rows;
    }
}