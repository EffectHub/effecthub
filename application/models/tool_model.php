<?php
class tool_model extends CI_Model
{
    var $tool;
    
    var $key;
	
	var $active;	
	
	var $open_num;

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

        $query = $this->db->get_where('tool',array('id' => $id));

        if ($row = $query->row_array()){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$type = $this->db->get_where('tool_type',array('id' => $row['type']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['type_name'] = $type['name'];
        	$row['type_link'] = $type['name'];
        	$row['author_pic'] = $user['pic_url'];
            return $row;
        }

        return array();
    }
    
    /**
	 * load by key
	 *
	 *
	 */	
    function loadByKey($key)
    {
        if (!$key){
            return array();
        }

        $query = $this->db->get_where('tool',array('domain' => $key));

        if ($row = $query->row_array()){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$type = $this->db->get_where('tool_type',array('id' => $row['type']))->row_array();
        	$group = $this->db->get_where('group',array('id' => $row['group_id']))->row_array();
        	$row['admin_id'] = $group['admin_id'];
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
        	$row['type_link'] = $type['name'];
        	
        	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
        	if (preg_match("/zh-c/i", $lang)||$lang=='cn') {
        		$row['type_name'] = $type['name_cn'];
        	} else {
        		$row['type_name'] = $type['name'];
        	}
            
        	return $row;
        }

        return array();
    }  
    
    function loadByGroup($group)
    {
    	if (!$group){
            return array();
        }

        $query = $this->db->get_where('tool',array('group_id' => $group));

        if ($row = $query->row_array()){
        	return $row;
        }

        return array();
    }  
    
	// --------------------------------------------------------------------

    /**
	 * 缁撴灉闆�
	 *
	 *
	 */	
    function find_tools($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_tools($options);

		$rows = array();
        foreach ($query->result_array() as $row){
        	$group = $this->db->get_where('game_group',array('id' => $row['group_id']))->row_array();
        	$row['fav_num'] = $group['member_num'];
        	$row['comment_num'] = $group['topic_num'];
            $rows[] = $row;
        }
        return $rows;
       
	}
    
	// --------------------------------------------------------------------

    /**
	 * 绉佹湁鍑芥暟
	 *
	 *
	 */
	function _query_tools($options = null)
    {
        $this->db->from('tool as b');
       
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        if (!empty($options['type'])){
            $this->db->where('type',$options['type']);
        }
        if (!empty($options['parent_id'])){
            $this->db->where('parent_id',$options['parent_id']);
        }
        if (!empty($options['notin'])){
            $this->db->where_not_in('id',$options['notin']);
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
    
    
    function count_tool_by_feature($featurename,$typename)
    {
    	$this->db->select('count(*) total');
        $this->db->from('game_tool');
        if($typename!='all'){
	    	$this->db->join('game_tool_type', 'game_tool_type.id = game_tool.type');
	        $this->db->where('game_tool_type.name',$typename);
    	}
    	$this->db->join('game_group', 'game_group.id = game_tool.group_id');
        $array =array('MostAppreciated'=>'game_group.member_num' ,'MostViewed'=>'view_num' ,'MostDiscussed'=>'game_group.topic_num' ,'MostRecent'=>'game_tool.update_date');
    	$this->db->order_by($array[$featurename], "desc");
    	$query = $this->db->get();
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
    
    function order_tool_by_feature_offset($featurename,$typename,$num,$offset)
    {
    	$this->db->select('game_tool.*');
    	$this->db->from('game_tool');
    	if($typename!='all'){
	    	$this->db->join('game_tool_type', 'game_tool_type.id = game_tool.type');
	        $this->db->where('game_tool_type.name',$typename);
    	}
    	$this->db->join('game_group', 'game_group.id = game_tool.group_id');
        $this->db->limit((int)$num, (int)$offset);
    	$array =array('MostAppreciated'=>'game_group.member_num' ,'MostViewed'=>'view_num' ,'MostDiscussed'=>'game_group.topic_num' ,'MostRecent'=>'game_tool.update_date');
    	$this->db->order_by($array[$featurename], "desc");
    	$query = $this->db->get();
        
        $rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$type = $this->db->get_where('tool_type',array('id' => $row['type']))->row_array();
        	$group = $this->db->get_where('game_group',array('id' => $row['group_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	
        	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
        	if (preg_match("/zh-c/i", $lang)||$lang=='cn') {
        		$row['type_name'] = $type['name_cn'];
        	} else {
        		$row['type_name'] = $type['name'];
        	}
        	
        	$row['fav_num'] = $group['member_num'];
        	$row['comment_num'] = $group['topic_num'];
        	$row['author_pic'] = $user['pic_url'];
        	$row['author_level'] = $user['level'];
        	$row['author_point'] = $user['point'];
            $rows[] = $row;
        }
        return $rows;
    }
    
	// --------------------------------------------------------------------

	/**
	 * 鎬绘暟
	 *
	 *
	 */	
	function count_tools($options = array())
    {
        $this->db->select('count(b.id) as total');
        
        $query = $this->_query_tools($options);
        
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
        $this->db->set('domain', $this->domain);
        $this->db->set('desc', $this->desc);
        $this->db->set('type', $this->type);
        $this->db->set('platform', $this->platform);
        $this->db->set('github_url', $this->github_url);
        $this->db->set('author_id', $this->author_id);
        $this->db->set('admin_id', $this->author_id);
		$this->db->set('create_date', $datetime);
		$this->db->set('update_date', $datetime);
        return $this->db->insert('tool');
    } 
    
    function update($id)
    { 
		$datetime = date('Y-m-d H:i:s');
        $this->db->set('name', $this->name);
        $this->db->set('domain', $this->domain);
        $this->db->set('desc', $this->desc);
        $this->db->set('type', $this->type);
        $this->db->set('platform', $this->platform);
        $this->db->set('github_url', $this->github_url);
        $this->db->set('author_id', $this->author_id);
        $this->db->set('admin_id', $this->author_id);
		$this->db->set('update_date', $datetime);
        $this->db->where('id', $id);
        return $this->db->update('tool');
    }
    
    function updatePic($id)
    { 				
		$this->db->set('pic_url', $this->pic_url);
		$this->db->set('thumb_url', $this->thumb_url);
        $this->db->where('id', $id);    
        return $this->db->update('tool');
    }
    
    function updateViewNum($id)
    { 				
		$this->db->set('view_num', $this->view_num);
        $this->db->where('id', $id);    
        return $this->db->update('tool');
    }  
    
    function updateGroup($id)
    { 				
		$this->db->set('group_id', $this->group_id);
        $this->db->where('id', $id);    
        return $this->db->update('tool');
    }
    //search item --local search
    function particle_search($str)
    {
    	$array = array('name'=>$str,'desc'=>$str);
    	$this->db->or_like($array);
    	$query = $this->db->get('game_tool');
    	return $query->result_array();
    }
    //search item with offset--local search
    function particle_search_offset($str,$num,$offset)
    {
    	$array = array('name'=>$str,'desc'=>$str);
    	$this->db->or_like($array);
    	$this->db->select('*');
    	$query = $this->db->get('game_tool',$num,$offset);
    	return $query->result_array();
    }    
}
