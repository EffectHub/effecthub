<?php
/**
 * 品牌
 *
 *
 */
class user_folder_model extends CI_Model
{

    var $name;
    
	var $byname;

	var $desc;

	var $logo_path;
    
    var $website;

	var $sort_order;

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

        $query = $this->db->get_where('user_folder',array('id' => $id));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }
    
    function loadbyname($uid,$name,$parent)
    {
        if (!$uid){
            return array();
        }

        $query = $this->db->get_where('user_folder',array('parent_folder' => $parent, 'folder_name' => $name,'user_id' => $uid));

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
    function find_user_folders($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_user_folders($options);

        $rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['user_id']))->row_array();
        	$type = $this->db->get_where('item_type',array('id' => $row['type']))->row_array();
        	$row['user_name'] = $user['displayName'];
        	$row['typeobj'] = $type;
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
	function _query_user_folders($options = null)
    {
        $this->db->from('user_folder as b');
       
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        if (!empty($options['parent_folder'])){
            $this->db->where('parent_folder',$options['parent_folder']);
        }
        if (!empty($options['user_id'])){
            $this->db->where('user_id',$options['user_id']);
        }
        if (isset($options['is_private'])){
            $this->db->where('is_private',$options['is_private']);
        }
        if (isset($options['type'])){
            $this->db->where('type',$options['type']);
        }
        if (!empty($options['typein'])){
        	$this->db->where_in('type', $options['typein']);
        }
        if (isset($options['order'])){
        	if ($options['order']=='top'){
				$this->db->order_by('watch_num','desc');
			}else{
            	$this->db->order_by($options['order'],'desc');
        	}
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
	function count_user_folders($options = array())
    {
        $this->db->select('COUNT(DISTINCT(b.id)) as total');
        
        $query = $this->_query_user_folders($options);
        
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
		$this->db->set('folder_name', $this->folder_name);
		$this->db->set('parent_folder', $this->parent_folder);
		$this->db->set('type', $this->type);
		$this->db->set('real_path', $this->real_path);
		$this->db->set('create_date', $datetime);
		$this->db->set('update_date', $datetime);
            
        return $this->db->insert('user_folder');
    } 
    
    function update($id)
    { 
		$datetime = date('Y-m-d H:i:s');

		$this->db->set('folder_name', $this->folder_name);
		$this->db->set('update_date', $datetime);
        $this->db->where('id', $id);    
        return $this->db->update('user_folder');
    } 
    
    function updatePrivate($id,$password)
    { 				
    	$datetime = date('Y-m-d H:i:s');
		$this->db->set('is_private', $this->is_private);
		$this->db->set('password', $this->password);
		$this->db->set('update_date', $datetime);
        $this->db->where('id', $id);    
        return $this->db->update('user_folder');
    }
    
    function updateViewNum($id)
    { 				
		$this->db->set('view_num', $this->view_num);
        $this->db->where('id', $id);    
        return $this->db->update('user_folder');
    }  
    
    function updateWatchNum($id)
    { 				
		$this->db->set('watch_num', $this->watch_num);
        $this->db->where('id', $id);    
        return $this->db->update('user_folder');
    }    
    
    function get_sum_filesize($folder_id)
    {
    	$this->db->select_sum('file_size','total');
    	$this->db->where('folder_id',$folder_id);
        $query = $this->db->get('game_item');
        $total = 0;
        if ($row = $query->row_array()){
             $total = (int)$row['total'];
        }
        return $total;
    }
    
    function delete($id)
    {        
		$this->db->where('id', $id);
        return $this->db->delete('user_folder'); 
    } 
    
    function total_num()
	{
		return $this->db->count_all('user_folder');
	}
	
    
}