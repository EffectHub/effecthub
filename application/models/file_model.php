<?php
class file_model extends CI_Model
{
    var $title;
    
	var $desc;

	var $download_url;

	var $preview_url;
    
    var $pic_url;
    var $thumb_url;

	var $tags;
	
	var $type;
	
	var $share;
	
	var $price;	
	
	var $platform;	
	
	var $view_num;
	
	var $comment_num;
	
	var $fav_num;
	
	var $watch_num;
	
	var $download_num;
	
	var $size;
	
	var $file_size;
	
	var $file_name;
	
	var $folder_id;
	
	var $author_id;
	
	var $version;
	
	var $parent_id;
	var $from;
	var $tool;
	var $extension;
	
	var $work_id;
	var $create_date;
	var $price_type;
	var $contest_id;

	function __construct()
    {
        parent::__construct();
    }

    
	// --------------------------------------------------------------------

    /**
	 * 私有函数
	 *
	 *
	 */
	function _query_items($options = null)
    {
        $this->db->from('item as b');
       
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        
        if (!empty($options['type'])){
            $this->db->where('type',$options['type']);
        }
        
        if (!empty($options['user'])){
            $this->db->where('author_id',$options['user']);
        }
        
        if (!empty($options['prev'])){
            $this->db->where('id <',$options['prev']);
        }
        
        if (!empty($options['next'])){
            $this->db->where('id >',$options['next']);
        }
        
        if (!empty($options['date'])){
            $this->db->where('create_date',$options['date']);
        }
        
        if (!empty($options['tag'])){
            $this->db->like('tags',$options['tag']);
        }
        
        if (!empty($options['extension'])){
            $this->db->where('extension',$options['extension']);
        }
        
        if (!empty($options['parent_id'])){
            $this->db->where('parent_id',$options['parent_id']);
        }
        if (isset($options['work_id'])){
            $this->db->where('work_id',$options['work_id']);
        }
        
        if (!empty($options['from'])){
            $this->db->where('from',$options['from']);
        }
        if (isset($options['is_private'])){
            $this->db->where('is_private',$options['is_private']);
        }
        if (isset($options['folder_id'])){
            $this->db->where('folder_id',$options['folder_id']);
        }
        
        if (!empty($options['tool'])){
            $this->db->where('tool',$options['tool']);
        }
        
        if (!empty($options['contest'])){
            $this->db->where('contest_id',$options['contest']);
        }
        
        if (!empty($options['download'])){
            $this->db->where('download_url !=','null');
            $this->db->where('download_url !=','');
        }
        if (!empty($options['in'])){
        	$this->db->where_in('id', $options['in']);
        }
        if (!empty($options['notin'])){
        	$this->db->where_not_in('id', $options['notin']);
        }
        if (!empty($options['typein'])){
        	$this->db->where_in('type', $options['typein']);
        }
        if (!empty($options['typenotin'])){
        	$this->db->where_not_in('type', $options['typenotin']);
        }
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
        }else if (isset($options['rand'])){
            $this->db->order_by('rand()');
        }else if (isset($options['orderby'])){
        	$this->db->order_by($options['orderby']);
        } else {
            $this->db->order_by('b.fav_num desc');
        }

        return $this->db->get();
    }
    	
    
	function count_items()
    {
    	$sql = 'SELECT COUNT(DISTINCT(id)) AS total FROM (( '
    				.'SELECT `game_item`.id AS id FROM `game_item` WHERE `game_item`.folder_id = 0) '
					.'UNION ' 
					.'(SELECT `game_user_folder`.id  FROM `game_user_folder`) ) t';
        $query = $this->db->query($sql);
        
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }       
    //order items by feature such as most appreciated,most viewed
    function count_item_by_feature($featurename,$typename)
    {
    	$filter = '';
    	if($typename != 'all')
    	{
    		$filter = 'WHERE name LIKE "'.$typename.'"';
    	}
    	$sql = 'SELECT COUNT(*) AS total FROM ((( SELECT `game_item`.id AS id,`game_item`.type AS type FROM `game_item` WHERE `game_item`.folder_id = 0  and `game_item`.is_private = 0 and `game_item`.work_id = 0) '
				.'UNION ' 
				.'(SELECT `game_user_folder`.id , `game_user_folder`.type AS type FROM `game_user_folder`)) t1 '
				.'INNER JOIN ' 
				.'(SELECT id AS type_id FROM `game_item_type` '
				.$filter.') t2 ON t1.type = t2.type_id)';
    	$query = $this->db->query($sql);
    	
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
    
    function order_item_by_feature_offset($featurename,$typename,$num,$offset)
    {
    	
    	$limit = ' LIMIT '.(int)$offset.', '.(int)$num.' ';
    	
    	$filter = '';
    	if($typename != 'all')
    	{
    		$filter = 'WHERE name LIKE "'.$typename.'" ';
    	}
    	$thismonth = '';
    	if($featurename=='ThisMonth')
    	{
    		$beginThismonth = mktime(0, 0, 0, date("m")-1, 1, date("Y"));//本月起点
    		$endThismonth = mktime(23, 59, 59, date("m"), date("t"), date("Y"));//本月终点
    		$thismonth = 'create_date between \''.date("Y-m-d H:i:s",$beginThismonth).'\' and \''.date("Y-m-d H:i:s",$endThismonth).'\'';
    	}
    	$sql = 'SELECT * FROM ((( SELECT `game_item`.id AS id, `game_item`.file_type AS file_type,`game_item`.view_num AS view_num, `game_item`.folder_id AS folder_id,`game_item`.fav_num AS fav_num,`game_item`.comment_num AS comment_num,`game_item`.type AS type, `game_item`.pic_url AS pic_url, `game_item`.thumb_url AS thumb_url, `game_item`.title AS title, `game_item`.from AS `from`, `game_item`.extension AS extension, `game_item`.desc AS `desc`, `game_item`.contest_id AS contest_id, `game_item`.create_date AS create_date, `game_item`.update_date AS update_date, `game_item`.is_private AS is_private, `game_item`.parent_id AS parent_id, `game_item`.platform AS platform, `game_item`.tool AS tool, `game_item`.download_url AS download_url, `game_item`.author_id AS author_id  FROM `game_item` WHERE `game_item`.folder_id = 0 and `game_item`.is_private = 0 and `game_item`.work_id = 0 ) '
				.'UNION '
				.'(SELECT `game_user_folder`.id, `game_user_folder`.file_type AS file_type ,`game_user_folder`.view_num AS view_num, `game_user_folder`.id AS folder_id,`game_user_folder`.fav_num AS fav_num,`game_user_folder`.comment_num AS comment_num, `game_user_folder`.type AS type, `game_user_folder`.pic_url AS pic_url, `game_user_folder`.thumb_url AS thumb_url, `game_user_folder`.folder_name AS title, `game_user_folder`.from AS `from`, `game_user_folder`.extension AS extension, `game_user_folder`.desc AS `desc`, `game_user_folder`.contest_id AS contest_id, `game_user_folder`.create_date AS create_date, `game_user_folder`.update_date AS update_date, `game_user_folder`.is_private AS is_private, `game_user_folder`.parent_folder AS parent_id, `game_user_folder`.platform AS platform, `game_user_folder`.tool AS tool, `game_user_folder`.real_path AS download_url, `game_user_folder`.user_id AS author_id FROM `game_user_folder` WHERE `game_user_folder`.is_private = 0)) t1 '
				.'INNER JOIN ' 
				.'(SELECT id AS type_id FROM `game_item_type` '
				.$filter.') t2 ON t1.type = t2.type_id)'				
    			.' ORDER BY update_date DESC'
    			.$limit;
    	$this->db->limit((int)$num, (int)$offset);
    	$query = $this->db->query($sql);
        
//         $rows = array();                 
//         foreach ($query->result_array() as $row){
//         	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
//         	//In debug, sometime the first time query, the result is null
//         	//So add following logic to fix it.
//         	if($user == null|| $user['displayName'] == null | $user['displayName'] == '')
//         	{
//         		$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
//         	}
//         	$type = $this->db->get_where('item_type',array('id' => $row['type']))->row_array();
//         	if($row['file_type'] == 1)
//         	{
//         		//this is a folder item
        		
//         	}
//         	else
//         	{
// 	        	$folder = $this->db->get_where('user_folder',array('id' => $row['folder_id']))->row_array();
// 	        	if($folder&&$folder['parent_folder']>0){
// 	        		$row['folder_name'] = $folder['folder_name'];
// 	        	}
//         	}
//         	if($row['tool']>0){
//         		$tool = $this->db->get_where('tool',array('id' => $row['tool']))->row_array();
//         		$row['tool_name'] = $tool['name'];
// 	        	$row['tool_domain'] = $tool['domain'];
// 	        	$row['tool_pic'] = $tool['thumb_url'];
//         	}
//         	if($row['platform']>0){
//         		$platform = $this->db->get_where('platform',array('id' => $row['platform']))->row_array();
// 	        	$row['platform_name'] = $platform['name'];
// 	        	$row['platform_key'] = $platform['key'];
// 	        	$row['platform_pic'] = $platform['pic_url'];
//         	}
//         	$row['author_name'] = $user['displayName'];
        	
//         	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
//         	if (preg_match("/zh-c/i", $lang)||$lang=='cn') {
//         		$row['type_name'] = $type['name_cn'];
//         	} else {
//         		$row['type_name'] = $type['name'];
//         	}
        	
//         	$row['author_pic'] = $user['pic_url'];
//         	$row['author_level'] = $user['level'];
//         	$row['author_point'] = $user['point'];        	
//             $rows[] = $row;
//         }
//         return $rows;
		return $query->result_array();
    }
    
}
