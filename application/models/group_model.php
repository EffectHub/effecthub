<?php
/**
 * 品牌
 *
 *
 */
class group_model extends CI_Model
{

    var $group_name;
    
	var $group_desc;

	var $group_type;

	var $member_num;
    
    var $topic_num;

	var $admin_id;
	
	var $group_pic;
	
	var $is_private;
	
	var $group_weibo_id;

	var $visit_hot;
	
	var $hot;
	
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

        $query = $this->db->get_where('group',array('id' => $id));

        if ($row = $query->row_array()){
        	$type = $this->db->get_where('group_type',array('id' => $row['group_type']))->row_array();
        	$user = $this->db->get_where('user',array('id' => $row['admin_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['type_name'] = $type['type_name'];
        	$row['type_name_cn'] = $type['name_cn'];
            return $row;
        }

        return array();
    }
    
    function loadbykey($id)
    {
        if (!$id){
            return array();
        }

        $query = $this->db->get_where('group',array('key' => $id));

        if ($row = $query->row_array()){
        	$type = $this->db->get_where('group_type',array('id' => $row['group_type']))->row_array();
        	$user = $this->db->get_where('user',array('id' => $row['admin_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['type_name'] = $type['type_name'];
        	$row['type_name_cn'] = $type['name_cn'];
            return $row;
        }

        return array();
    }
    
    function check_name($name)
	{
		$query = $this->db->get_where('group',array('group_name' => $name));
		
        if ($row = $query->row_array()){
            return true;
        }
        return false;
	}
    
	// --------------------------------------------------------------------

    /**
	 * 结果集
	 *
	 *
	 */	
    function find_groups($options = array(), $count=20, $offset=0, $private=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count > 0){
            $this->db->limit((int)$count, (int)$offset);
        }
        
        if ($private == 1) {
        	$this->db->not_like('is_private','on');
        }
		//brand
		$this->db->select('b.*');

		$query = $this->_query_groups($options);

        return $query->result_array();
       
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
        if (!empty($options['admin'])){
            $this->db->where('admin_id',$options['admin']);
        }
        if (!empty($options['type'])){
            $this->db->where('group_type',$options['type']);

            return $this->db->get();
        }
        if (!empty($options['private'])){
            $this->db->where('is_private',$options['private']);
        }
        if (!empty($options['in'])){
            $this->db->where_in('group_type',$options['in']);
        }
        if (!empty($options['notin'])){
            $this->db->where_not_in('group_type',$options['notin']);
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

        $this->db->set('group_name', $this->group_name);
		$this->db->set('group_desc', $this->group_desc);
		$this->db->set('group_type', $this->group_type);
		$this->db->set('key', $this->group_key);					
		$this->db->set('member_num', $this->member_num);
		$this->db->set('topic_num', $this->topic_num);
		$this->db->set('admin_id', $this->admin_id);
		$this->db->set('group_pic', $this->group_pic);
		$this->db->set('is_private', $this->is_private);
		$this->db->set('group_weibo_id', $this->group_weibo_id);
		$this->db->set('create_date', $datetime);
            
        return $this->db->insert('group');
    } 
    
    function update($id)
    { 

        $this->db->set('group_name', $this->group_name);
		$this->db->set('group_desc', $this->group_desc);
		$this->db->set('key', $this->group_key);		
		$this->db->set('group_type', $this->group_type);
		$this->db->set('group_pic', $this->group_pic);
		$this->db->set('is_private', $this->is_private);
		$this->db->set('group_weibo_id', $this->group_weibo_id);
        $this->db->where('id', $id);    
        return $this->db->update('group');
    }   
    
    function updatePic($id)
    { 				
		$this->db->set('group_pic', $this->group_pic);
        $this->db->where('id', $id);    
        return $this->db->update('group');
    }
	
    function updateNum($id)
    { 				
		$this->db->set('topic_num', $this->topic_num);
        $this->db->where('id', $id);    
        return $this->db->update('group');
    }
    
    function updateAdmin($id)
    { 				
		$this->db->set('admin_id', $this->admin_id);
        $this->db->where('id', $id);    
        return $this->db->update('group');
    }
    
    function updateMemberNum($id)
    { 				
		$this->db->set('member_num', $this->member_num);
        $this->db->where('id', $id);    
        return $this->db->update('group');
    }
    
    function update_hot($id)
    {
    	$this->db->set('visit_hot',$this->visit_hot);
    	$this->db->where('id',$id);
    	$this->db->update('group');
    }
    
    function recommendation(){
    	$res = $this->db->get_where('user_group',array('user_id'=>$this->session->userdata('id')))->result_array();
    	if (!$res) {
    		$res = $this->db->get_where('user_follow',array('user_id'=>$this->session->userdata('id')))->result_array();
    		
    		if ($res) {
    			for ($i=0;$i<count($res);$i++){
    				
    			}
    		}
    		
    	}
    	
    	
    	
    }
    //search item --local search
    function particle_search($str)
    {
    	$array = array('group_name'=>$str,'group_desc'=>$str);
    	$this->db->or_like($array);
    	$query = $this->db->get('game_group');
    	return $query->result_array();
    }
    //search item with offset--local search
    function particle_search_offset($str,$num,$offset)
    {
    	$array = array('group_name'=>$str,'group_desc'=>$str);
    	$this->db->or_like($array);
    	$this->db->select('*');//select('id as id,group_name as title, group_desc as desc, pic_url as pic_url');
    	$query = $this->db->get('game_group',$num,$offset);
    	return $query->result_array();
    }
      
}





