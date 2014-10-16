<?php
class Stats_model extends CI_Model 
{
	
	var $comment_id;
	var $collection_id;
	var $author_id;
	var $create_date;
	var $content;
	var $parent_id;
	
	function __construct()
	{	
		parent::__construct();
	}
	
	function list_stats($sql)
	{
		$query = $this->db->query($sql);
		$rows = array();
        foreach ($query->result_array() as $row){
            $rows[] = $row;
        }
        return $rows;
	}
	
	function sql_stats($sql)
	{
		$query = $this->db->query($sql);
		if ($row = $query->row_array()){
            return $row;
        }
        return array();
	}

	function file_stats($options = array())
	{
		$this->db->select('count(*) as count,count(distinct(author_id)) as user_count, sum(view_num) as view_count,sum(fav_num) as fav_count,sum(comment_num) as comment_count,sum(watch_num) as watch_count,sum(download_num) as download_count');
        
        $query = $this->_query_files($options);
        
        if ($row = $query->row_array()){
            return $row;
        }
        return array();
	}
	
	function _query_files($options = null)
    {
        $this->db->from('game_item as b');
       
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        if (!empty($options['from'])){
            $this->db->where('from',$options['from']);
        }
        if (!empty($options['tool'])){
            $this->db->where('tool',$options['tool']);
        }
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
        }

        return $this->db->get();
    }
	
}


