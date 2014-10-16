<?php
class Team_comment_model extends CI_Model 
{
	
	var $comment_id;
	
	var $user_id;
	var $team_id;
	var $comment_date;
	var $parent_id;
	var $content;
	
	
	function __construct()
	{	
		parent::__construct();
	}
	
	//load by comment_id
	function load($id)
	{
		return $this->db->get_where('team_comment',array('comment_id'=>$id))->row_array();
		
	}
	
	//load team comments;detail:0, no more information;detail:1, more information
	function load_comments($team_id,$detail=0,$limit=5,$offset=0,$options=array()) 
	{
		if ($team_id!=0&&$team_id!=null) {
			
			$this->db->order_by('comment_date','desc');
			
			if (isset($options)) {
				$this->db->where($options);
			}
			
			if ($limit>0){
				$this->db->limit($limit,$offset);
			}
			
			$query = $this->db->get_where('team_comment',array('team_id'=>$team_id))->result_array();
			
			if ($detail == 1) {
				if($query) {
				
					$rows = array();
				
					foreach ($query as $row) {
						$user = $this->db->get_where('user',array('id'=>$row['user_id']))->row_array();
						$row['user_name'] = $user['displayName'];
						$row['user_pic'] = $user['pic_url'];
					
						if ($row['parent_id']!=0&&$row['parent_id']!=null) {
							$comment = $this->db->get_where('team_comment',array('comment_id'=>$row['parent_id']))->row_array();
							$parent_user = $this->db->get_where('user',array('id'=>$comment['user_id']))->row_array();
						
							$row['parent_content'] = $comment['content'];
							$row['parent_comment_date'] = $comment['comment_date'];
							$row['parent_user'] = $parent_user['displayName'];
						
						}
					
						$rows[] = $row;
					
					}
				
					return $rows;
				}
			}
			
			return $query;
			
		} else {
			return array();
		}
			
		
	}
	
	
	function save()
	{
		
		$now = date('Y-m-d H:i:s');
		
		$this->db->set('team_id',$this->team_id);
		$this->db->set('content',$this->content);
		$this->db->set('user_id',$this->user_id);
		$this->db->set('parent_id',$this->parent_id);
		$this->db->set('comment_date',$now);
		
		$this->db->insert('team_comment');
		
		return $this->db->affected_rows();
	}
	
	function count($id=0)
	{
		if ($id == 0) {
			return 0;
		} else {
			$query = $this->db->get_where('team_comment',array('team_id'=>$id))->result_array();
			
			return count($query);
		}
		
	}
	
	
	
	
	
	
}


