<?php
/**
 * 品牌
 *
 *
 */
class item_download_model extends CI_Model
{

    var $item_download_name;
    
	var $item_download_desc;

	var $item_download_type;

	var $member_num;
    
    var $topic_num;

	var $user_id;
	
	var $item_download_id;
	
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
	 function loadByUserAndDownload($id,$item_id)
    {
        $this->db->where('user_id', $id);
		$this->db->where('item_id', $item_id);
        $query = $this->db->get_where('item_download');
        
        return $query->row_array();
    }
    
    function loadByUser($id)
    {
        if (!$id){
            return array();
        }
		$rows = array();
        $query = $this->db->get_where('item_download',array('user_id' => $id));
		foreach ($query->result_array() as $row){
			if($row['fav_type']==1){
	        	$app = $this->db->get_where('app',array('id' => $row['item_id']))->row_array();
	        	$row['topic_title'] = $app['app_name'];
			}
			if($row['fav_type']==2){
	        	$topic = $this->db->get_where('topic',array('id' => $row['item_id']))->row_array();
	        	$row['topic_title'] = $topic['topic_title'];
			}
			if($row['fav_type']==4){
	        	$note = $this->db->get_where('user_note',array('id' => $row['item_id']))->row_array();
	        	$row['topic_title'] = $note['title'];
			}
			if($row['fav_type']==5){
	        	$note = $this->db->get_where('subject',array('id' => $row['item_id']))->row_array();
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
        $query = $this->db->get_where('item_download');
		foreach ($query->result_array() as $row){
			$user = $this->db->get_where('customer',array('id' => $row['item_id']))->row_array();
	        $row['user_name'] = $user['name'];
        	$row['user_pic'] = $user['pic_url'];
            $rows[] = $row;
        }
        return $rows;
    }    
    
    function loadByItem($id)
    {
        if (!$id){
            return array();
        }
		$this->db->limit(18, 0);
        $rows = array();
        $this->db->order_by('timestamp desc');
        $query = $this->db->get_where('item_download',array('item_id' => $id));
		foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['user_id']))->row_array();
        	$row['user_name'] = $user['displayName'];
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
    function find_item_downloads($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_item_downloads($options);

        $rows = array();
        foreach ($query->result_array() as $row){
        	$item = $this->db->get_where('item',array('id' => $row['item_id']))->row_array();
        	$row['item_name'] = $item['title'];
        	$row['item_pic'] = $item['thumb_url'];
        	$row['download_url'] = $item['download_url'];
        	if($row['price_type']==2)$row['price_type']='￥';
        	else if($row['price_type']==3)$row['price_type']='$';
        	else $row['price_type']=null;
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
	function _query_item_downloads($options = null)
    {
        $this->db->from('item_download as b');
       
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        if (!empty($options['type'])){
            $this->db->where('item_download_type',$options['type']);
            $this->db->order_by('rand()');
            return $this->db->get();
        }
        if (!empty($options['uid'])){
            $this->db->where('user_id',$options['uid']);
        }
        
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
        }else if (isset($options['rand'])){
            $this->db->order_by('rand()');
        } else {
           
        }

        return $this->db->get();
    }
    
	// --------------------------------------------------------------------

	/**
	 * 总数
	 *
	 *
	 */	
	function count_item_downloads($options = array())
    {
        $this->db->select('COUNT(*) as total');
        
        $query = $this->_query_item_downloads($options);
        
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
		$this->db->set('price_type', $this->price_type);
		$this->db->set('price', $this->price);
		$this->db->set('timestamp', $datetime);
            
        return $this->db->insert('item_download');
    } 
    
    function delete($user_id,$item_id)
    {        
		$this->db->where('user_id', $user_id);
		$this->db->where('item_id', $item_id);
        return $this->db->delete('item_download'); 
    } 
}