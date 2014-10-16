<?php
class Team_share_model extends CI_Model 
{
	
	var $share_id;
	var $item_id;
	var $folder_id;
	var $team_id;
	var $share_time;
	var $user_id;
	
	
	function __construct()
	{	
		parent::__construct();
	}
	
	//$detail:0 不需要提取分享的封面等信息
	//$detail:1 提取该分享的其他在页端展示的信息，封面，作者名称等
	function load_team_shares($id,$detail,$count=0,$offset) 
	{
		if (!$id) {
			return array();
		}
		$this->db->order_by('share_time','desc');
		
		if ($count>0) {
			$this->db->limit($count,$offset);
		}
		
		$query = $this->db->get_where('team_share',array('team_id'=>$id));
		
		if ($detail == 1) {
			
			$rows = array();
			
			foreach ($query->result_array() as $row) {
				$user = $this->db->get_where('user',array('id'=>$row['user_id']))->row_array();
				
				if ($user){
					$row['user_name'] = $user['displayName'];
					$row['user_pic'] = $user['pic_url'];
				}
				if ($row['item_id']==0||$row['item_id']==null) {
					$folder = $this->db->get_where('user_folder',array('id'=>$row['folder_id']))->row_array();
					$row['pic_url'] = base_url('images/cloud/folder.png');
					$row['name'] = $folder['folder_name'];
					
				} else {
					$item = $this->db->get_where('item',array('id'=>$row['item_id']))->row_array();
					$row['name'] = $item['title'];
					if ($item['pic_url']!=null) {
						$row['pic_url'] = $item['pic_url'];
					} else {
						$row['pic_url'] = null;
					}
					
				}
				
				$rows[] = $row;
			}
			
			return $rows;
		}
		
		return $query->result_array();
		
		
		
	}
	
	
	
	
	
	function create() {
		$datetime = date('Y-m-d H:i:s');
		
		$this->db->set('item_id', $this->item_id);
		$this->db->set('folder_id', $this->folder_id);
		$this->db->set('team_id', $this->team_id);
		$this->db->set('user_id',$this->user_id);
		
		$this->db->set('share_time', $datetime);
		
		return $this->db->insert('team_share');
		
	}
	
	
	
	
	
	
	
	
	
	
}


