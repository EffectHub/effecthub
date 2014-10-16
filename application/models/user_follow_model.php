<?php
/**
 * 品牌
 *
 *
 */
class user_follow_model extends CI_Model
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
	 function loadByUserAndFav($id,$follower_id)
    {
        $this->db->where('user_id', $id);
		$this->db->where('follower_id', $follower_id);
        $query = $this->db->get_where('user_follow');
        
        return $query->row_array();
    }
    
    function loadByUser($id)
    {
        if (!$id){
            return array();
        }
		$rows = array();
        $query = $this->db->get_where('user_follow',array('user_id' => $id));
		foreach ($query->result_array() as $row){
			if($row['fav_type']==1){
	        	$app = $this->db->get_where('app',array('id' => $row['follower_id']))->row_array();
	        	$row['topic_title'] = $app['app_name'];
			}
			if($row['fav_type']==2){
	        	$topic = $this->db->get_where('topic',array('id' => $row['follower_id']))->row_array();
	        	$row['topic_title'] = $topic['topic_title'];
			}
			if($row['fav_type']==4){
	        	$note = $this->db->get_where('user_note',array('id' => $row['follower_id']))->row_array();
	        	$row['topic_title'] = $note['title'];
			}
			if($row['fav_type']==5){
	        	$note = $this->db->get_where('subject',array('id' => $row['follower_id']))->row_array();
	        	$row['topic_title'] = $note['subject_name'];
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
        $query = $this->db->get_where('user_follow');
		foreach ($query->result_array() as $row){
			$user = $this->db->get_where('customer',array('id' => $row['follower_id']))->row_array();
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
        $query = $this->db->get_where('user_follow',array('group_id' => $id));
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
        $this->db->from('user_follow');
        $this->db->where(array('follower_id' => $id,'fav_type' => 1));
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
        $this->db->from('user_follow');
        $this->db->where(array('follower_id' => $id,'fav_type' => 5));
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
        $query = $this->db->get_where('user_follow',array('follower_id' => $id,'fav_type' => 3));
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
		$this->db->set('follower_id', $this->follower_id);
		$this->db->set('timestamp', $datetime);
            
        return $this->db->insert('user_follow');
    } 
    
    function delete($user_id,$follower_id)
    {        
		$this->db->where('user_id', $user_id);
		$this->db->where('follower_id', $follower_id);
        return $this->db->delete('user_follow'); 
    } 
    
    function findUserFollower($id)
    {
        if (!$id){
            return array();
        }
		$rows = array();
		$this->db->where('user_id', $id);
		$this->db->order_by("timestamp", "desc");
        $query = $this->db->get('game_user_follow');
		foreach ($query->result_array() as $row){
			$user = $this->db->get_where('game_user',array('id' => $row['follower_id']))->row_array();
	        $row['user_name'] = $user['name'];
        	$row['user_pic'] = $user['pic_url'];
            $rows[] = $row;
        }
        return $rows;
    }    
}