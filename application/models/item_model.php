<?php
class item_model extends CI_Model
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
	 * load by id
	 *
	 *
	 */	
    function load($id)
    {
        if (!$id){
            return array();
        }

        $query = $this->db->get_where('item',array('id' => $id));

        if ($row = $query->row_array()){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$type = $this->db->get_where('item_type',array('id' => $row['type']))->row_array();
        	$folder = $this->db->get_where('user_folder',array('id' => $row['folder_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['type_link'] = $type['name'];
        	
        	//$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
        	//if (preg_match("/zh-c/i", $lang)||$lang=='cn') {
        	//	$row['type_name'] = $type['name_cn'];
        	//} else {
        		$row['type_name'] = $type['name'];
        		$row['type_name_cn'] = $type['name_cn'];
        	//}
        	$row['type_pic'] = $type['default_pic'];
        	$row['author_pic'] = $user['pic_url'];
        	if($folder&&$folder['parent_folder']>0)$row['folder_name'] = $folder['folder_name'];
            return $row;
        }

        return array();
    }
    
    function loadbydownloadurl($download_url)
    {
        if (!$download_url){
            return array();
        }

        $query = $this->db->get_where('item',array('download_url' => $download_url));

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
    function find_items($options = array(), $count=50, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count>0){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_items($options);

		$rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$type = $this->db->get_where('item_type',array('id' => $row['type']))->row_array();
        	$row['type_name'] = $type['name'];
        	$row['type_name_cn'] = $type['name_cn'];
        	if (!empty($options['api'])){
        		$row['download_url'] = '';
        	}
        	$row['is_folder'] = 0;
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
        	$row['author_level'] = $user['level'];
        	$row['author_point'] = $user['point'];
        	if($row['tool']>0){
        		$tool = $this->db->get_where('tool',array('id' => $row['tool']))->row_array();
        		$row['tool_name'] = $tool['name'];
	        	$row['tool_domain'] = $tool['domain'];
	        	$row['tool_pic'] = $tool['thumb_url'];
        	}
        	if($row['platform']>0){
        		$platform = $this->db->get_where('platform',array('id' => $row['platform']))->row_array();
	        	$row['platform_name'] = $platform['name'];
	        	$row['platform_pic'] = $platform['pic_url'];
	        	$row['platform_key'] = $platform['key'];
        	}
        	if($row['extension']!=null){
        		$extension = $this->db->get_where('file_extension',array('name' => $row['extension']))->row_array();
	        	if($extension){
		        	$row['extension_bg'] = $extension['background_x'];
		        	$row['extension_bg_thumb'] = $extension['background_thumb_x'];
		        	$row['player'] = $extension['player_url'];
        		}
        	}
            $rows[] = $row;
        }
        return $rows;
       	
	}
	
	
	function recommend_items($options=array(),$count=5)
	{
		
		$this->db->select('b.*');
		
		$query = $this->_query_items($options)->result_array();
		
		$now = time();
		for ($i = 0; $i < count($query); $i ++){
			$t = strtotime($query[$i]['create_date']);
			$day = (int)(($now - $t)/(24*60*60)) + 1;
			
			$query[$i]['hot'] = (float)(($query[$i]['view_num'] + $query[$i]['comment_num'] * 5 + $query[$i]['fav_num'] * 20)/$day);
		}
		
		$recommend = array();
		
		for ($i = 0; $i < $count; $i ++){
			
			$temp = $i;
			for ($j = ($i + 1); $j < (count($query)); $j++) {
				if ($query[$j]['hot'] > $query[$temp]['hot']) $temp = $j;
			}
				
			$recommend[$i] = $query[$temp];
				
			$temp_item = $query[$i];
			$query[$i] = $query[$temp];
			$query[$temp] = $temp_item;
			
		}
		
		return $recommend;
		
		
		
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
        if (isset($options['pic'])){
        	$this->db->where($options['pic'].' !=','null');        	
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
    
	// --------------------------------------------------------------------

	/**
	 * 总数
	 *
	 *
	 */	
	function count_items_download($options = array())
    {
        $this->db->select('sum(b.comment_num) as total');
        
        $query = $this->_query_items($options);
        
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
    
	function count_items($options = array())
    {
        $this->db->select('COUNT(DISTINCT(b.id)) as total');
        
        $query = $this->_query_items($options);
        
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }    
    
    function create()
    { 
		$datetime = date('Y-m-d H:i:s');

        $this->db->set('title', $this->title);
		$this->db->set('desc', $this->desc);
		if($this->download_url!=''&&$this->download_url!=null){
			$this->db->set('download_url', $this->download_url);
		}					
		if($this->preview_url!=''&&$this->preview_url!=null){
			$this->db->set('preview_url', $this->preview_url);
		}
		if($this->pic_url!=''&&$this->pic_url!=null){
			$this->db->set('pic_url', $this->pic_url);
		}
		if($this->thumb_url!=''&&$this->thumb_url!=null){
			$this->db->set('thumb_url', $this->thumb_url);
		}
		if($this->tags!=''){
			$this->db->set('tags', $this->tags);
		}
		if($this->share!=''&&$this->share!=null){
			$this->db->set('is_share', '1');
		}
		$this->db->set('platform', $this->platform);
		if($this->is_private!=''&&$this->is_private!=null){
			$this->db->set('is_private', $this->is_private);
		}
		if($this->contest_id!=''&&$this->contest_id!=null){
			$this->db->set('contest_id', $this->contest_id);
		}
		if($this->work_id!=null){
			$this->db->set('work_id', $this->work_id);
		}
		$this->db->set('type', $this->type==null?'1':$this->type);
		$this->db->set('author_id', $this->author_id);
		if($this->create_date!=null){
			$this->db->set('create_date', $this->create_date);
	        $this->db->set('update_date', $this->create_date);
		}else{
			$this->db->set('create_date', $datetime);
	        $this->db->set('update_date', $datetime);
		}
        $this->db->set('price', $this->price);
        if($this->version!=''&&$this->version!=null){
        	$this->db->set('version', $this->version);
        }
        if($this->price_type!=''&&$this->price_type!=null){
        	$this->db->set('price_type', $this->price_type);
        }
        if($this->parent_id!=''&&$this->parent_id!=null){
        	$this->db->set('parent_id', $this->parent_id);
        }
        if($this->from!=''&&$this->from!=null){
			$this->db->set('from', $this->from);
        }
        if($this->download_url!=''&&$this->download_url!=null){
			$this->db->set('download_url', $this->download_url);
        }
        if($this->tool!=''&&$this->tool!=null){
			$this->db->set('tool', $this->tool);
        }
        if($this->folder_id!=''&&$this->folder_id!=null){
			$this->db->set('folder_id', $this->folder_id);
        }
        if($this->file_name!=''&&$this->file_name!=null){
			$this->db->set('file_name', $this->file_name);
        }
        if($this->extension!=''&&$this->extension!=null){
			$this->db->set('extension', $this->extension);
        }
        if($this->file_size!=''&&$this->file_size!=null){
			$this->db->set('file_size', $this->file_size);
        }
        return $this->db->insert('item');
    } 
    
    function update($id)
    { 
		$datetime = date('Y-m-d H:i:s');
		if($this->title!=''&&$this->title!=null){
        	$this->db->set('title', $this->title);
		}
		if($this->desc!=''&&$this->desc!=null){
			$this->db->set('desc', $this->desc);
		}
		if($this->download_url!=''&&$this->download_url!=null){
			$this->db->set('download_url', $this->download_url);
		}
		if($this->is_private!=''&&$this->is_private!=null){
			$this->db->set('is_private', $this->is_private);
		}					
		if($this->preview_url!=''&&$this->preview_url!=null){
			$this->db->set('preview_url', $this->preview_url);
		}
		if($this->pic_url!=''&&$this->pic_url!=null){
			$this->db->set('pic_url', $this->pic_url);
		}
		if($this->thumb_url!=''&&$this->thumb_url!=null){
			$this->db->set('thumb_url', $this->thumb_url);
		}
		if($this->tags!=''&&$this->tags!=null){
			$this->db->set('tags', $this->tags);
		}
		if($this->type!=''&&$this->type!=null){
			$this->db->set('type', $this->type);
		}
		$this->db->set('update_date', $datetime);
		if(isset($this->price)&&$this->price!=null){
			$this->db->set('price', $this->price);
		}
        if($this->price_type!=''&&$this->price_type!=null){
        	$this->db->set('price_type', $this->price_type);
        }
		if($this->version!=''&&$this->version!=null){
        	$this->db->set('version', $this->version);
        }
        if(isset($this->platform)&&$this->platform!=null){
        	$this->db->set('platform', $this->platform);
        }
        if($this->parent_id!=''&&$this->parent_id!=null){
        	$this->db->set('parent_id', $this->parent_id);
        }
        if($this->from!=''&&$this->from!=null){
			$this->db->set('from', $this->from);
        }
        if(isset($this->is_private)&&$this->is_private!=null){
        	$this->db->set('is_private', $this->is_private);
        }
        if($this->contest_id!=''&&$this->contest_id!=null){
			$this->db->set('contest_id', $this->contest_id);
		}
		if(isset($this->tool)&&$this->tool!=null){
        	$this->db->set('tool', $this->tool);
		}
		if(isset($this->size)&&$this->size!=null){
			$this->db->set('file_size', $this->size);
		}
		if($this->file_size!=''&&$this->file_size!=null){
			$this->db->set('file_size', $this->file_size);
        }
        if($this->extension!=''&&$this->extension!=null){
			$this->db->set('extension', $this->extension);
        }
        $this->db->where('id', $id);    
        return $this->db->update('item');
    }
    
    function updateNew($id)
    { 
		$this->db->set('download_url', $this->download_url);
		$this->db->set('pic_url', $this->pic_url);
		$this->db->set('thumb_url', $this->thumb_url);
        $this->db->where('id', $id);    
        return $this->db->update('item');
    }
    
    function updatePic($id)
    { 
		$this->db->set('pic_url', $this->pic_url);
		$this->db->set('thumb_url', $this->thumb_url);
		$datetime = date('Y-m-d H:i:s');
		$this->db->set('update_date', $datetime);
        $this->db->where('id', $id);    
        return $this->db->update('item');
    }
    
    function updatePreview($id,$url)
    { 
		$this->db->set('preview_url', $url);
        $this->db->where('id', $id);    
        return $this->db->update('item');
    }
    
    function updateAttach($id)
    {
		$this->db->set('download_url', $this->download_url);
		$this->db->set('file_size', $this->size);
        $this->db->where('id', $id);    
        return $this->db->update('item');
    }
    
    function updateFileSize($id)
    { 
		$this->db->set('file_size', $this->size);
        $this->db->where('id', $id);    
        return $this->db->update('item');
    }
    
    function updateViewNum($id)
    { 				
		$this->db->set('view_num', $this->view_num);
        $this->db->where('id', $id);    
        return $this->db->update('item');
    }    
	
    function updateCommentNum($id)
    { 				
		$this->db->set('comment_num', $this->comment_num);
        $this->db->where('id', $id);    
        return $this->db->update('item');
    }
    
    function updateFavNum($id)
    { 				
		$this->db->set('fav_num', $this->fav_num);
        $this->db->where('id', $id);    
        return $this->db->update('item');
    }
    
    function updateWatchNum($id)
    { 				
		$this->db->set('watch_num', $this->watch_num);
        $this->db->where('id', $id);    
        return $this->db->update('item');
    }    
    
    function updateDownloadNum($id)
    { 				
		$this->db->set('download_num', $this->download_num);
        $this->db->where('id', $id);    
        return $this->db->update('item');
    } 
    
    function updateTopic($id)
    { 				
		$this->db->set('topic_id', $this->topic_id);
        $this->db->where('id', $id);    
        return $this->db->update('item');
    } 
    
    function updateActive($id)
    { 				
		$this->db->set('active', $this->active);
        $this->db->where('id', $id);    
        return $this->db->update('item');
    }
    
    function updatePrivate($id,$password)
    { 				
    	$datetime = date('Y-m-d H:i:s');
		$this->db->set('is_private', $this->is_private);
		$this->db->set('password', $this->password);
		$this->db->set('update_date', $datetime);
        $this->db->where('id', $id);    
        return $this->db->update('item');
    }
    
    //search one author's item
	function user_works_Search($str,$userid)
	{
		$this->db->select('*');
		$this->db->from('game_item');
		$this->db->where('author_id',intval($userid,10));
		//$this->db->where('(title LIKE '.$str.' OR desc LIKE '.$str.' OR tags LIKE '.$str.')', NULL);
		$this->db->like('title',$str);
		//$array = array('desc LIKE'=>"%".$str."%",  'tags LIKE'=>"%".$str."%");		
    	//$this->db->or_where($array);
    	//$where = "(title LIKE '%" .$str."%' OR desc LIKE '%".$str. "%' OR tags LIKE '%".$str."%')";
    	//$this->db->where($where);
    	$query = $this->db->get();
    	return $query->result_array();
	}
	
     //search item --local search
    function particle_search($str)
    {
    	$array = array('title'=>$str,'desc'=>$str,'tags'=>$str);
    	$this->db->like($array);

    	$query = $this->db->get('game_item');
    	return $query->result_array();
    }
    
     //search item with offset--local search
    function particle_search_offset($str,$num,$offset)
    {
    	$array = array('title'=>$str,'desc'=>$str,'tags'=>$str);
    	$this->db->or_like($array);
    	$this->db->where('work_id',0);
    	$this->db->select('*');
    	$query = $this->db->get('game_item',$num,$offset);
    	return $query->result_array();
    }
    
    //search all -- global search
    function global_search($str)
    {
    	$array = array('title'=>$str,'desc'=>$str,'tags'=>$str);
    	$this->db->or_like($array);
    	$this->db->select('*');
    	$query = $this->db->get('game_item');
    	
    	$this->db->like('content',$str);
    	$this->db->select('*');
    	$query1 = $this->db->get('game_item_comment');
    	
    	$data = array($query->result_array(),$query1->result_array());
    	return $data;   //$query1->result_array()
    }
    
    //search by tag
    function tag_search($str)
    { 	
    	$this->db->like('tags',$str);
    	$this->db->select('*');
    	$query = $this->db->get('game_item');
    	return $query->result_array();
    }
    
     //search by tag with offset
    function tag_search_offset($str,$num,$offset)
    { 	
    	$this->db->like('tags',$str);
    	$this->db->select('*');
    	$query = $this->db->get('game_item',$num,$offset);
    	return $query->result_array();
    }
    
    //find every author's items
    function find_item_by_authorid($author_id)
    {
    	$this->db->where('author_id',$author_id);
    	$this->db->where('work_id',0);
    	$this->db->where('pic_url is not null');
    	$this->db->select('*');
    	$this->db->limit(3);
    	$this->db->order_by("update_date", "desc");
    	$query = $this->db->get('game_item');
    	return $query->result_array();
    }
    
    //find items by itemType
    function find_item_by_itemtype($typename)
    {
    	$this->db->select('game_item.*');
        $this->db->from('game_item');
        $this->db->join('game_item_type', 'game_item_type.id = game_item.type');
        $this->db->where('name',$typename);
        $this->db->order_by("update_date", "desc");
        $query = $this->db->get();
        
        $rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
        	$row['author_level'] = $user['level'];
        	$row['author_point'] = $user['point'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    //order items by feature such as most appreciated,most viewed
    function count_item_by_feature($featurename,$typename)
    {
    	$this->db->select('count(*) total');
        $this->db->from('game_item');
        if($typename!='all'){
	    	$this->db->join('game_item_type', 'game_item_type.id = game_item.type');
	        $this->db->where('name',$typename);
    	}
    	$array =array('ThisMonth'=>'fav_num' ,'MostDownloaded'=>'download_num'  ,'MostAppreciated'=>'fav_num' ,'MostViewed'=>'view_num' ,'MostDiscussed'=>'comment_num' ,'MostRecent'=>'update_date');
    	if($featurename=='ThisMonth'){
    		$beginThismonth = mktime(0, 0, 0, date("m")-1, 1, date("Y"));//本月起点
        	$endThismonth = mktime(23, 59, 59, date("m"), date("t"), date("Y"));//本月终点
	    	$this->db->where('create_date between \''.date("Y-m-d H:i:s",$beginThismonth).'\' and \''.date("Y-m-d H:i:s",$endThismonth).'\'');
	    }
	    $this->db->where('work_id',0);
	    $this->db->where('is_private',0);
    	$this->db->order_by($array[$featurename], "desc");
    	$query = $this->db->get();
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
    
    function order_item_by_feature_offset($featurename,$typename,$num,$offset)
    {
    	$this->db->select('game_item.*');
    	$this->db->from('game_item');
    	if($typename!='all'){
	    	$this->db->join('game_item_type', 'game_item_type.id = game_item.type');
	        $this->db->where('name',$typename);
    	}
        $this->db->limit((int)$num, (int)$offset);
    	$array =array('ThisMonth'=>'fav_num' ,'MostAppreciated'=>'fav_num' ,'MostDownloaded'=>'download_num' ,'MostViewed'=>'view_num' ,'MostDiscussed'=>'comment_num' ,'MostRecent'=>'update_date');
    	if($featurename=='ThisMonth'){
    		$beginThismonth = mktime(0, 0, 0, date("m")-1, 1, date("Y"));//本月起点
        	$endThismonth = mktime(23, 59, 59, date("m"), date("t"), date("Y"));//本月终点
	    	$this->db->where('create_date between \''.date("Y-m-d H:i:s",$beginThismonth).'\' and \''.date("Y-m-d H:i:s",$endThismonth).'\'');
	    }
	    $this->db->where('work_id',0);
	    $this->db->where('is_private',0);
    	$this->db->order_by($array[$featurename], "desc");
    	$query = $this->db->get();
        
        $rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$type = $this->db->get_where('item_type',array('id' => $row['type']))->row_array();
        	$folder = $this->db->get_where('user_folder',array('id' => $row['folder_id']))->row_array();
        	if($folder&&$folder['parent_folder']>0)$row['folder_name'] = $folder['folder_name'];
        	if($row['tool']>0){
        		$tool = $this->db->get_where('tool',array('id' => $row['tool']))->row_array();
        		$row['tool_name'] = $tool['name'];
	        	$row['tool_domain'] = $tool['domain'];
	        	$row['tool_pic'] = $tool['thumb_url'];
        	}
        	if($row['platform']>0){
        		$platform = $this->db->get_where('platform',array('id' => $row['platform']))->row_array();
	        	$row['platform_name'] = $platform['name'];
	        	$row['platform_key'] = $platform['key'];
	        	$row['platform_pic'] = $platform['pic_url'];
        	}
        	$row['author_name'] = $user['displayName'];
        	
        	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
        	if (preg_match("/zh-c/i", $lang)||$lang=='cn') {
        		$row['type_name'] = $type['name_cn'];
        	} else {
        		$row['type_name'] = $type['name'];
        	}
        	
        	$row['author_pic'] = $user['pic_url'];
        	$row['author_level'] = $user['level'];
        	$row['author_point'] = $user['point'];
            $rows[] = $row;
        }
        return $rows;
    }
    
	function count_item_by_tool($featurename,$toolkey)
    {
    	$this->db->select('count(*) total');
        $this->db->from('game_item');
        if($toolkey!='all'){
	    	$this->db->join('game_tool', 'game_tool.id = game_item.tool');
	        $this->db->where('game_tool.domain',$toolkey);
    	}
    	$array =array('ThisMonth'=>'fav_num' ,'MostAppreciated'=>'fav_num' ,'MostViewed'=>'view_num' ,'MostDiscussed'=>'comment_num' ,'MostRecent'=>'update_date');
    	$this->db->order_by('game_item.'.$array[$featurename], "desc");
    	$query = $this->db->get();
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
    
    function order_item_by_tool_offset($featurename,$toolkey,$num,$offset)
    {
    	$this->db->select('game_item.*');
    	$this->db->from('game_item');
    	if($toolkey!='all'){
	    	$this->db->join('game_tool', 'game_tool.id = game_item.tool');
	        $this->db->where('game_tool.domain',$toolkey);
    	}
        $this->db->limit((int)$num, (int)$offset);
    	$array =array('ThisMonth'=>'fav_num' ,'MostAppreciated'=>'fav_num' ,'MostViewed'=>'view_num' ,'MostDiscussed'=>'comment_num' ,'MostRecent'=>'update_date');
    	$this->db->order_by('game_item.'.$array[$featurename], "desc");
    	$query = $this->db->get();
        
        $rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$type = $this->db->get_where('item_type',array('id' => $row['type']))->row_array();
        	if($row['tool']>0){
        		$tool = $this->db->get_where('tool',array('id' => $row['tool']))->row_array();
        		$row['tool_name'] = $tool['name'];
	        	$row['tool_domain'] = $tool['domain'];
	        	$row['tool_pic'] = $tool['thumb_url'];
        	}
        	if($row['platform']>0){
        		$platform = $this->db->get_where('platform',array('id' => $row['platform']))->row_array();
	        	$row['platform_name'] = $platform['name'];
	        	$row['platform_key'] = $platform['key'];
	        	$row['platform_pic'] = $platform['pic_url'];
        	}
        	$row['author_name'] = $user['displayName'];
        	$row['type_name'] = $type['name'];
        	$row['author_pic'] = $user['pic_url'];
        	$row['author_level'] = $user['level'];
        	$row['author_point'] = $user['point'];
            $rows[] = $row;
        }
        return $rows;
    } 
    
    function count_item_by_platform($featurename,$platformkey)
    {
    	$this->db->select('count(*) total');
        $this->db->from('game_item');
        if($platformkey!='all'){
	    	$this->db->join('game_platform', 'game_platform.id = game_item.platform');
	        $this->db->where('game_platform.key',$platformkey);
    	}
    	$array =array('ThisMonth'=>'fav_num' ,'MostAppreciated'=>'fav_num' ,'MostViewed'=>'view_num' ,'MostDiscussed'=>'comment_num' ,'MostRecent'=>'update_date');
    	$this->db->order_by('game_item.'.$array[$featurename], "desc");
    	$query = $this->db->get();
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
    
    function order_item_by_platform_offset($featurename,$platformkey,$num,$offset)
    {
    	$this->db->select('game_item.*');
    	$this->db->from('game_item');
    	if($platformkey!='all'){
	    	$this->db->join('game_platform', 'game_platform.id = game_item.platform');
	        $this->db->where('game_platform.key',$platformkey);
    	}
        $this->db->limit((int)$num, (int)$offset);
    	$array =array('ThisMonth'=>'fav_num' ,'MostAppreciated'=>'fav_num' ,'MostViewed'=>'view_num' ,'MostDiscussed'=>'comment_num' ,'MostRecent'=>'update_date');
    	$this->db->order_by('game_item.'.$array[$featurename], "desc");
    	$query = $this->db->get();
        
        $rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$type = $this->db->get_where('item_type',array('id' => $row['type']))->row_array();
        	if($row['tool']>0){
        		$tool = $this->db->get_where('tool',array('id' => $row['tool']))->row_array();
        		$row['tool_name'] = $tool['name'];
	        	$row['tool_domain'] = $tool['domain'];
	        	$row['tool_pic'] = $tool['thumb_url'];
        	}
        	if($row['platform']>0){
        		$platform = $this->db->get_where('platform',array('id' => $row['platform']))->row_array();
	        	$row['platform_name'] = $platform['name'];
	        	$row['platform_key'] = $platform['key'];
	        	$row['platform_pic'] = $platform['pic_url'];
        	}
        	$row['author_name'] = $user['displayName'];
        	$row['type_name'] = $type['name'];
        	$row['author_pic'] = $user['pic_url'];
        	$row['author_level'] = $user['level'];
        	$row['author_point'] = $user['point'];
            $rows[] = $row;
        }
        return $rows;
    }   
    
    function find_item_by_mylike($myid,$num,$offset)
    {
    	$this->db->select('*');
        $this->db->join('game_item_fav', 'game_item_fav.item_id = game_item.id');
        $this->db->where('user_id',$myid);
        $this->db->order_by("update_date", "desc");
    	$query = $this->db->get('game_item',$num,$offset);
    	
    	$rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
        	$row['author_level'] = $user['level'];
        	$row['author_point'] = $user['point'];
        	if($row['tool']>0){
        		$tool = $this->db->get_where('tool',array('id' => $row['tool']))->row_array();
        		$row['tool_name'] = $tool['name'];
	        	$row['tool_domain'] = $tool['domain'];
	        	$row['tool_pic'] = $tool['thumb_url'];
        	}
        	if($row['platform']>0){
        		$platform = $this->db->get_where('platform',array('id' => $row['platform']))->row_array();
	        	$row['platform_name'] = $platform['name'];
	        	$row['platform_key'] = $platform['key'];
	        	$row['platform_pic'] = $platform['pic_url'];
        	}
            $rows[] = $row;
        }
        return $rows;
    }
    
    //find items of authors that I follow with
    function find_item_by_myfollow($myid)
    {
    	$this->db->select('*');
        $this->db->from('game_item');
        $this->db->join('game_user_follow', 'game_user_follow.follower_id = game_item.author_id');
        $this->db->where('user_id',$myid);
        $this->db->order_by("update_date", "desc");
    	$query = $this->db->get();
    	
    	$rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
        	$row['author_level'] = $user['level'];
        	$row['author_point'] = $user['point'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    //get the tags of author's products by author_id
    function get_author_tags($myid)
    {
    	$this->db->select('game1.tags');
        $this->db->from('game_item as game1'); 
        $this->db->where('game1.author_id',$myid);
    	$query = $this->db->get();
		$taglist = Array();
		foreach($query->result() as $item)
		{
				$itemtaglist = explode(" ",$item->tags);
				foreach($itemtaglist as $tag)
				{
					if(!in_array($tag,$taglist))
					{
						array_push($taglist,$tag);
					}
				}
		}
		return $taglist;
    }
    
    //find items according to tags that inspired me
    function find_item_by_inspiredtags($myid,$typename,$tags,$num,$offset)
    {
    	$this->db->select('game2.*');
        $this->db->from('game_item as game2'); 
        /*if($typename!='all'){
	    	$this->db->join('game_item_type', 'game_item_type.id = game_item.type');
	        $this->db->where('name',$typename);
    	}*/
        $this->db->limit((int)$num, (int)$offset);
        foreach($tags as $tag)
    	{
    		$this->db->or_like('game2.tags',$tag);
    	}
    	$this->db->where('game2.author_id !=',intval($myid,10));
        $this->db->order_by("fav_num", "desc");
    	$query = $this->db->get();
    	
    	$rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('user',array('id' => $row['author_id']))->row_array();
        	$type = $this->db->get_where('item_type',array('id' => $row['type']))->row_array();
        	if($row['tool']>0){
        		$tool = $this->db->get_where('tool',array('id' => $row['tool']))->row_array();
        		$row['tool_name'] = $tool['name'];
	        	$row['tool_domain'] = $tool['domain'];
	        	$row['tool_pic'] = $tool['thumb_url'];
        	}
        	if($row['platform']>0){
        		$platform = $this->db->get_where('platform',array('id' => $row['platform']))->row_array();
	        	$row['platform_name'] = $platform['name'];
	        	$row['platform_key'] = $platform['key'];
	        	$row['platform_pic'] = $platform['pic_url'];
        	}
        	$row['author_name'] = $user['displayName'];
        	$row['type_name'] = $type['name'];
        	$row['author_pic'] = $user['pic_url'];
        	$row['author_level'] = $user['level'];
        	$row['author_point'] = $user['point'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    //get the sum of view num of a user's projects by author_id
    function get_sum_viewnum($author_id)
    {
    	$this->db->select_sum('view_num','total');
    	$this->db->where('author_id',$author_id);
        $query = $this->db->get('game_item');
        $total = 0;
        if ($row = $query->row_array()){
             $total = (int)$row['total'];
        }
        return $total;
    } 
    
    //get the sum of fav num of a user's projects by author_id
    function get_sum_favnum($author_id)
    {
    	$this->db->select_sum('fav_num','total');
    	$this->db->where('author_id',$author_id);
        $query = $this->db->get('game_item');
        $total = 0;
        if ($row = $query->row_array()){
             $total = (int)$row['total'];
        }
        return $total;
    } 
    
    function get_sum_filesize($author_id)
    {
    	$this->db->select_sum('file_size','total');
    	$this->db->where('author_id',$author_id);
        $query = $this->db->get('game_item');
        $total = 0;
        if ($row = $query->row_array()){
             $total = (int)$row['total'];
        }
        return $total;
    }
    
    //delete item by itemid
    function delete_item($itemid)
    {
    	$this->db->delete('game_item', array('id' => $itemid)); 
    }
}
