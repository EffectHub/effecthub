<?php
/**
 *  用户状态模型
 *
 *
 */
class user_status_model extends CI_Model
{
	var $user_id;
	
	var $action;
    
	var $content;
	
	var $pic_url;
	
	var $target_url;
	
	var $target_name;
	
	var $status_type;
	var $content_id;
	var $target_id;
	
	var $timestamp;
	
	function __construct()
    {
        parent::__construct();
    }

	// --------------------------------------------------------------------
	
	//向game_status表中插入新数据
	function insertData()
	{
		$datetime = date('Y-m-d H:i:s');

		$this->db->set('user_id', $this->user_id);
		$this->db->set('action', $this->action);
		$this->db->set('pic_url', $this->pic_url);
		$this->db->set('target_url', $this->target_url);
		$this->db->set('target_name', $this->target_name);
		$this->db->set('content', $this->content);
		$this->db->set('timestamp', $datetime);
		
		$this->db->set('status_type',$this->status_type);
		$this->db->set('target_id',$this->target_id);
		if (isset($this->content_id)){
		$this->db->set('content_id',$this->content_id);
		} else {
			$this->db->set('content_id',0);
		}	
		return $this->db->insert('game_user_status');
	}
	
	function find_status_user()
	{
		$this->db->select('DISTINCT(user_id)');
		$this->db->from('game_user_status');
        $query = $this->db->get();
        $rows = array();
        foreach ($query->result_array() as $row){
            $rows[] = $row['user_id'];
        }
        return $rows;
	}
	
	//查找myfollow 的用户的最新状态
	function find_status_by_myfollow($myid)
	{
		$this->db->select('COUNT(DISTINCT(game_user_status.id)) as total');
        $this->db->from('game_user_status');
        $this->db->join('game_user_follow', 'game_user_follow.user_id = game_user_status.user_id');
        $this->db->where('game_user_follow.follower_id',$myid);
        $this->db->order_by("game_user_status.timestamp", "desc");
    	$query = $this->db->get();
    	
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
	}
	
	function find_status_by_myfollow_offset($myid,$num,$offset)
	{
		$this->db->select('game_user_status.user_id,game_user_status.pic_url,game_user_status.target_url,game_user_status.target_name,game_user_status.action,game_user_status.content,game_user_status.target_id,game_user_status.status_type,game_user_status.content_id,game_user_status.timestamp');
        //$this->db->from('game_user_status');
        $this->db->join('game_user_follow', 'game_user_follow.user_id = game_user_status.user_id');
        $this->db->where('game_user_follow.follower_id',$myid);
        $this->db->order_by("game_user_status.timestamp", "desc");
    	$query = $this->db->get('game_user_status',$num,$offset);
    	
    	$rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('game_user',array('id' => $row['user_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
            
        	if ($row['content_id']!=0&&$row['content_id']!='') {
        		if ($row['status_type']==3) {
        			$group = $this->db->get_where('group',array('id'=>$row['content_id']))->row_array();
        			$row['content_name'] = $group['group_name'];
        		} else if ($row['status_type']==10) {
        			$item = $this->db->get_where('item',array('id'=>$row['content_id']))->row_array();
        			$row['content_name'] = $item['title'];
        			if ($item['pic_url']!=null&&$item['pic_url']!='') {
        				$row['content_pic'] = $item['pic_url'];
        			}
        		} else if ($row['status_type']==8) {
        			$comment = $this->db->get_where('topic_comment',array('id'=>$row['content_id']))->row_array();
        			$row['content_content'] = $comment['comment_content'];
        		} else if ($row['status_type']==5) {
        			$comment = $this->db->get_where('item_comment',array('id'=>$row['content_id']))->row_array();
        			$row['content_content'] = $comment['content'];
        		} else if ($row['status_type']==9) {
        			$comment = $this->db->get_where('collection_comment',array('id'=>$row['content_id']))->row_array();
        			$row['content_content'] = $comment['content'];
        		}
        	}
        	
        	
        	$rows[] = $row;
            
        }
        return $rows;
	}
	
	function count_status($options = array())
    {
        $this->db->select('COUNT(DISTINCT(b.id)) as total');
        
        $query = $this->_query_status($options);
        
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }
    
    function find_status($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_status($options);

        return $query->result_array();
       
	}
    
    function _query_status($options = null)
    {
        $this->db->from('user_status as b');
       
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        if (!empty($options['user'])){
            $this->db->where('user_id',$options['user']);
        }
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
        }else {
            $this->db->order_by('b.id desc');
        }

        return $this->db->get();
    }
	
	function find_status_offset($num,$offset)
	{
		$this->db->order_by('id desc');
    	$query = $this->db->get('user_status',$num,$offset);
    	
    	$rows = array();
        foreach ($query->result_array() as $row){
        	$user = $this->db->get_where('game_user',array('id' => $row['user_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
        	
        	if ($row['content_id']!=0&&$row['content_id']!='') {
        		if ($row['status_type']==3) {
        			$group = $this->db->get_where('group',array('id'=>$row['content_id']))->row_array();
        			if (!empty($group)) {
	        			$row['content_name'] = $group['group_name'];
        			}
        		} else if ($row['status_type']==10) {
        			$item = $this->db->get_where('item',array('id'=>$row['content_id']))->row_array();
        			$row['content_name'] = $item['title'];
        			if ($item['pic_url']!=null&&$item['pic_url']!='') {
        				$row['content_pic'] = $item['pic_url'];
        			}
        		} else if ($row['status_type']==8) {
        			$comment = $this->db->get_where('topic_comment',array('id'=>$row['content_id']))->row_array();
        			$row['content_content'] = $comment['comment_content'];
        		} else if ($row['status_type']==5) {
        			$comment = $this->db->get_where('item_comment',array('id'=>$row['content_id']))->row_array();
        			$row['content_content'] = $comment['content'];
        		} else if ($row['status_type']==9) {
        			$comment = $this->db->get_where('collection_comment',array('id'=>$row['content_id']))->row_array();
        			$row['content_content'] = $comment['content'];
        		}
        	}
        	
        	
            $rows[] = $row;
        }
        return $rows;
	}
	
	function updateStatus($id)
    {
    	$this->db->set('content', $this->content);
    	$this->db->set('timestamp', $this->timestamp);
        $this->db->where('id', $id);
        return $this->db->update('user_status');
    }
    
    function localization($start=0,$end=500)
    {
    	$count = $this->db->count_all('user_status');
    	if ($end>$count) $end = $count;
    	for ($i=$start;$i<$end;$i++) {
    		$this->db->limit(1,$i);
    		$this->db->order_by('timestamp','asc');
    		$item = $this->db->get('user_status')->row_array();
    		
    		if ((strstr($item['action'],'followed')!=false)||(strstr($item['content'],'followed')!=false)) {
    			$this->db->set('status_type', 1);
    			
    			if ($item['content']!=''&&$item['content']!=null) {
    				$arr = explode('/', $item['content']);
    				$user = $arr[4];
    				
    				$arrow = explode("'", $user);
    				
    				$this->db->set('target_id', intval(trim($arrow[0])));
    				
    				if ($item['target_name']==''||$item['target_name']==null) {
    					$user_item = $this->db->get_where('user',array('id'=>intval(trim($arrow[0]))))->row_array();
    					if(!empty($user_item)){
    						$this->db->set('target_name',$user_item['displayName']);
    					}
    					
    				}
    				
    			} else {
    				$arr = explode('/', $item['target_url']);
    				$user = $arr[4];
    				
    				$this->db->set('target_id', intval(trim($user)));
    				if ($item['target_name']==''||$item['target_name']==null) {
    					$user_item = $this->db->get_where('user',array('id'=>intval(trim($user))))->row_array();
    					if(!empty($user_item)){
    						$this->db->set('target_name',$user_item['displayName']);
    					}
    				}
    			}
    			
    			$this->db->where('id',$item['id']);
    			$this->db->update('user_status');
    		
    		}
    		if ((strstr($item['action'],'created a new work')!=false)||(strstr($item['content'],'uploaded a new work')!=false)||(strstr($item['content'],'created a new work')!=false)) {
    			$this->db->set('status_type',2);
    			
    			if ($item['content']!=''&&$item['content']!=null) {
    				$arr = explode('/', $item['content']);
    				$work = $arr[4];
    				
    				$arrow = explode("'", $work);
    				$this->db->set('target_id', intval(trim($arrow[0])));
    				if ($item['target_name']==''||$item['target_name']==null) {
    					$user_item = $this->db->get_where('item',array('id'=>intval(trim($arrow[0]))))->row_array();
    					if(!empty($user_item)){
	    					$this->db->set('target_name',$user_item['title']);
    					}
    				}
    				
    			} else {
    				$arr = explode('/', $item['target_url']);
    				$work = $arr[4];
    				
    				$this->db->set('target_id', intval(trim($work)));
    				if ($item['target_name']==''||$item['target_name']==null) {
    					$user_item = $this->db->get_where('item',array('id'=>intval(trim($work))))->row_array();
    					if(!empty($user_item)){
	    					$this->db->set('target_name',$user_item['title']);
    					}
    				}
    				
    			}
    			
    			$this->db->where('id',$item['id']);
    			$this->db->update('user_status');
    			
    			
    		}
    		if ((strstr($item['action'],'created a topic')!=false)||(strstr($item['content'],'create a topic')!=false)) {
    			$this->db->set('status_type',3);
    			
    			if ($item['content']!==''&&$item['content']!=null) {
    				$arr = explode('/', $item['content']);
    				$topic = $arr[4];
    				
    				$arrow = explode("'", $topic);
    				$this->db->set('target_id', intval(trim($arrow[0])));

    				if ($item['target_name']==''||$item['target_name']==null) {
    					$user_item = $this->db->get_where('topic',array('id'=>intval(trim($arrow[0]))))->row_array();
    					
    					if(!empty($user_item)){
    						$this->db->set('target_name',$user_item['topic_title']);
    					}
    				}
    				
    			} else {
    				
    				$arr = explode('/', $item['target_url']);
    				$topic = $arr[4];
    				
    				$this->db->set('target_id', intval(trim($topic)));
    				
    				if ($item['target_name']==''||$item['target_name']==null) {
    					$user_item = $this->db->get_where('topic',array('id'=>intval(trim($topic))))->row_array();
    					if(!empty($user_item)){
    						$this->db->set('target_name',$user_item['topic_title']);
    					}
    				}
    			}
    			
    			//获取group id存放入conten_id字段
    			$content = $this->db->get_where('topic',array('id'=>$topic))->row_array();
    			if (!empty($content)) {
	    			$this->db->set('content_id', $content['group_id']);
    			}			
    			$this->db->where('id',$item['id']);
    			$this->db->update('user_status');
    			
    		}
    		if ((strstr($item['action'], 'commented the work')!=false)||(strstr($item['content'], 'commented the work'))) {
    			$this->db->set('status_type',5);
    			
    			if ($item['content']!==''&&$item['content']!=null) {
    				$arr = explode('/', $item['content']);
    				$work = $arr[4];
    				
    				$arrow = explode("'", $work);
    				$this->db->set('target_id', intval(trim($arrow[0])));

    				if ($item['target_name']==''||$item['target_name']==null) {
    					$user_item = $this->db->get_where('item',array('id'=>intval(trim($arrow[0]))))->row_array();
    					if(!empty($user_item)){
	    					$this->db->set('target_name',$user_item['title']);
    					}
    				}
    				
    			} else {
    				
    				$arr = explode('/', $item['target_url']);
    				$work = $arr[4];
    				
    				$this->db->set('target_id', intval(trim($work)));
    				
    				if ($item['target_name']==''||$item['target_name']==null) {
    					$user_item = $this->db->get_where('item',array('id'=>intval(trim($work))))->row_array();
    					if(!empty($user_item)){
	    					$this->db->set('target_name',$user_item['title']);
    					}
    				}
    			}
    			
    			$this->db->where('id',$item['id']);
    			$this->db->update('user_status');
    			
    		}
    		if ((strstr($item['action'], 'liked the work')!=false)||(strstr($item['content'], 'liked the work'))) {
    			$this->db->set('status_type',6);
    			
    			if ($item['content']!==''&&$item['content']!=null) {
    				$arr = explode('/', $item['content']);
    				$work = $arr[4];
    				
    				$arrow = explode("'", $work);
    				$this->db->set('target_id', intval(trim($arrow[0])));

    				if ($item['target_name']==''||$item['target_name']==null) {
    					$user_item = $this->db->get_where('item',array('id'=>intval(trim($arrow[0]))))->row_array();
    					if(!empty($user_item)){
	    					$this->db->set('target_name',$user_item['title']);
    					}
    				}
    			} else {
    				
    				$arr = explode('/', $item['target_url']);
    				$work = $arr[4];
    				
    				$this->db->set('target_id', intval(trim($work)));
    				
    				if ($item['target_name']==''||$item['target_name']==null) {
    					$user_item = $this->db->get_where('item',array('id'=>intval(trim($work))))->row_array();
    					if(!empty($user_item)){
	    					$this->db->set('target_name',$user_item['title']);
    					}
    				}
    				
    			}
    			
    			$this->db->where('id',$item['id']);
    			$this->db->update('user_status');
    			
    		}
    		if (strstr($item['content'], 'changed')) {
    			$this->db->set('status_type',7);
    		
    			$this->db->set('target_id', $item['user_id']);
    			 
    			if ($item['target_name']==''||$item['target_name']==null) {
    				$user_item = $this->db->get_where('user',array('id'=>$item['user_id']))->row_array();
    				
    				if(!empty($user_item)){
    					$this->db->set('target_name',$user_item['displayName']);
    				}
    			}
    			
    			$this->db->where('id',$item['id']);
    			$this->db->update('user_status');
    			 
    		}
    		if ((strstr($item['action'], 'commented the topic')!=false)||(strstr($item['content'], 'commented the topic'))) {
    			$this->db->set('status_type',8);
    			
    			if ($item['content']!==''&&$item['content']!=null) {
    				$arr = explode('/', $item['content']);
    				$topic = $arr[4];
    				
    				$arrow = explode("'", $topic);
    				$this->db->set('target_id', intval(trim($arrow[0])));	

    				if ($item['target_name']==''||$item['target_name']==null) {
    					$user_item = $this->db->get_where('topic',array('id'=>intval(trim($arrow[0]))))->row_array();
    					if(!empty($user_item)){
    						$this->db->set('target_name',$user_item['topic_title']);
    					}
    				}
    			} else {
    				
    				$arr = explode('/', $item['target_url']);
    				$topic = $arr[4];
    				
    				$this->db->set('target_id', intval(trim($topic)));
    				
    				if ($item['target_name']==''||$item['target_name']==null) {
    					$user_item = $this->db->get_where('topic',array('id'=>intval(trim($topic))))->row_array();
    					if(!empty($user_item)){
    						$this->db->set('target_name',$user_item['topic_title']);
    					}
    				}
    			}
    			
    			$this->db->where('id',$item['id']);
    			$this->db->update('user_status');
    			
    		}
    		if (strstr($item['action'], 'commented the collection')!=false) {
    			$this->db->set('status_type',9);

    			$arr = explode('/', $item['target_url']);
    			$work = $arr[5];
    		
    			$this->db->set('target_id', intval(trim($work)));
				
    			if ($item['target_name']==''||$item['target_name']==null) {
    				$user_item = $this->db->get_where('collection',array('id'=>intval(trim($work))))->row_array();
    				if(!empty($user_item)){
	    				$this->db->set('target_name',$user_item['title']);
    				}
    			}
    			 
    			$this->db->where('id',$item['id']);
    			$this->db->update('user_status');
    			 
    		}
    		if (strstr($item['content'], 'added the work')) {
    			$this->db->set('status_type',10);
    			
    			$arr = explode('/', $item['content']);
    			$collection = $arr[10];
    			
    			$arrow = explode("'", $collection);
    			$this->db->set('target_id', intval(trim($arrow[0])));			
    			
    			if ($item['target_name']==''||$item['target_name']==null) {
    				$user_item = $this->db->get_where('collection',array('id'=>intval(trim($arrow[0]))))->row_array();
    				if(!empty($user_item)){
	    				$this->db->set('target_name',$user_item['title']);
    				}
    			}
    			
    			//加入收藏集的作品放入content_id中，在新鲜事显示时，进行同类合并
    			$work = explode("/", $item['target_url']);
    			$this->db->set('content_id', intval(trim($work[4])));
    			
    			$this->db->where('id',$item['id']);
    			$this->db->update('user_status');
    			
    		}
    		if (strstr($item['content'], 'liked the collection')) {
    			$this->db->set('status_type',11);

    			$arr = explode('/', $item['target_url']);
    			$collection = $arr[5];
    		
    			$this->db->set('target_id', intval(trim($collection)));
    			 
    			if ($item['target_name']==''||$item['target_name']==null) {
    				$user_item = $this->db->get_where('collection',array('id'=>intval(trim($collection))))->row_array();
    				if(!empty($user_item)){
	    				$this->db->set('target_name',$user_item['title']);
    				}
    			}
    			
    			$this->db->where('id',$item['id']);
    			$this->db->update('user_status');
    			 
    		}
    		if (strstr($item['action'], 'shared a folder')!=false) {
    			$this->db->set('status_type',12);
    			 
    			$arr = explode('/', $item['target_url']);
    			$folder = $arr[4];
    		
    			$this->db->set('target_id', intval(trim($folder)));
    			 
    			
    			$this->db->where('id',$item['id']);
    			$this->db->update('user_status');
    			 
    		}
    		if (strstr($item['action'], 'shared a new work')!=false) {
    			$this->db->set('status_type',13);
    			 
    			$arr = explode('/', $item['target_url']);
    			$work = $arr[4];
    		
    			$this->db->set('target_id', intval(trim($work)));
    			 
    			$this->db->where('id',$item['id']);
    			$this->db->update('user_status');
    			 
    		}
    		if (strstr($item['action'], 'upload files to')!=false) {
    			$this->db->set('status_type',14);
    			 
    			$arr = explode('/', $item['target_url']);
    			$work = $arr[4];
    		
    			$this->db->set('target_id', intval(trim($work)));
    			 
    			$this->db->where('id',$item['id']);
    			$this->db->update('user_status');
    		}
    		if (strstr($item['action'], 'joined group')!=false) {
    			$this->db->set('status_type',15);
    			 
    			$arr = explode('/', $item['target_url']);
    			$group = $arr[4];
    		
    			$this->db->set('target_id', intval(trim($group)));
    			 
    			$this->db->where('id',$item['id']);
    			$this->db->update('user_status');
    		}
    		if (strstr($item['action'], 'watched a folder')!=false) {
    			$this->db->set('status_type',17);
    		
    			$arr = explode('/', $item['target_url']);
    			$folder = $arr[4];
    		
    			$this->db->set('target_id', intval(trim($folder)));
    		
    			$this->db->where('id',$item['id']);
    			$this->db->update('user_status');
    		}
    		if (strstr($item['action'], 'folked a new work')!=false) {
    			$this->db->set('status_type',18);
    		
    			$arr = explode('/', $item['target_url']);
    			$work = $arr[4];
    		
    			$this->db->set('target_id', intval(trim($work)));
    		
    			$this->db->where('id',$item['id']);
    			$this->db->update('user_status');
    		}
    		
    	}
    	
    	return $count;
    	
    	
    }
    
    
    
    
    
}