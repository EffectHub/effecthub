<?php
/**
 *  用户邮件模型
 *
 *
 */
class user_mail_model extends CI_Model
{
	var $sender_id;
    var $receiver_id;
	var $content;
	
	function __construct()
    {
        parent::__construct();
    }

	// --------------------------------------------------------------------
	
	//向game_user_mail表中插入新数据
	function insertData()
	{
		$datetime = date('Y-m-d H:i:s');

		$this->db->set('sender_id', $this->sender_id);
		$this->db->set('receiver_id', $this->receiver_id);
		$this->db->set('content', $this->content);
		//$this->db->set('read',0);
		$this->db->set('timestamp', $datetime);
		
		return $this->db->insert('game_user_mail');
	}
	
	function update_read($id,$junked)
    {
		$this->db->set('read','1');	
        $this->db->where('receiver_id', $id);
        $this->db->where('junked',$junked);
        return $this->db->update('game_user_mail');
    }
	
	function update_read_singlemail($mailid)
    {
		$this->db->set('read','1');	
        $this->db->where('id', $mailid);
        return $this->db->update('game_user_mail');
    }
    
	function find_unread_count($myid)
	{
		$this->db->select('count(*) total');
        $this->db->from('game_user_mail');
        $this->db->where('game_user_mail.receiver_id',$myid);
        $this->db->where('game_user_mail.read','0');
        $this->db->where('game_user_mail.junked','0');
        $this->db->order_by("game_user_mail.timestamp", "desc");
    	$query = $this->db->get();
    	if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
	}
	
	function find_unreadjunk_count($myid)
	{
		$this->db->select('count(*) total');
        $this->db->from('game_user_mail');
        $this->db->where('game_user_mail.receiver_id',$myid);
        $this->db->where('game_user_mail.read','0');
        $this->db->where('game_user_mail.junked','1');
        $this->db->order_by("game_user_mail.timestamp", "desc");
    	$query = $this->db->get();
    	if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
	}
	
	//查找用户的最新邮件
	function find_mail($myid,$junked)
	{
		$this->db->select('*');
        $this->db->from('game_user_mail');
        $this->db->where('game_user_mail.receiver_id',$myid);
        $this->db->where('game_user_mail.junked',$junked);
        $this->db->where('game_user_mail.receiver_deleted','0');
        $this->db->order_by("game_user_mail.timestamp", "desc");
    	$query = $this->db->get();
    	
    	$rows = array();
        foreach ($query->result_array() as $row){
            $user = $this->db->get_where('game_user',array('id' => $row['sender_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
            $rows[] = $row;
        }
        return $rows;
	}
	
	function find_mail_offset($myid,$junked,$num,$offset)
	{
		$this->db->select('*');
        //$this->db->from('game_user_mail');
        $this->db->where('game_user_mail.receiver_id',$myid);
        $this->db->where('game_user_mail.junked',$junked);
        $this->db->where('game_user_mail.receiver_deleted','0');
        $this->db->order_by("game_user_mail.timestamp", "desc");
    	$query = $this->db->get('game_user_mail',$num,$offset);
    	
    	$rows = array();
        foreach ($query->result_array() as $row){
            $user = $this->db->get_where('game_user',array('id' => $row['sender_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
            $rows[] = $row;
        }
        return $rows;
	}	
	
	//查找用户发出去的邮件
	function find_send_mail($myid)
	{
		$this->db->select('*');
        $this->db->from('game_user_mail');
        $this->db->where('game_user_mail.sender_id',$myid);
        $this->db->where('game_user_mail.sender_deleted','0');
        $this->db->order_by("game_user_mail.timestamp", "desc");
    	$query = $this->db->get();
    	
    	$rows = array();
        foreach ($query->result_array() as $row){
            $user = $this->db->get_where('game_user',array('id' => $row['receiver_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
            $rows[] = $row;
        }
        return $rows;
	}
	
	function find_send_mail_offset($myid,$num,$offset)
	{
		$this->db->select('*');
        //$this->db->from('game_user_mail');
        $this->db->where('game_user_mail.sender_id',$myid);
        $this->db->where('game_user_mail.sender_deleted','0');
        $this->db->order_by("game_user_mail.timestamp", "desc");
    	$query = $this->db->get('game_user_mail',$num,$offset);
    	
    	$rows = array();
        foreach ($query->result_array() as $row){
            $user = $this->db->get_where('game_user',array('id' => $row['receiver_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
            $rows[] = $row;
        }
        return $rows;
	}
	
	function find_read_or_unreadmail($myid,$read)
	{
		$this->db->select('*');
        $this->db->from('game_user_mail');
        $this->db->where('game_user_mail.receiver_id',$myid);
        $this->db->where('game_user_mail.read',$read);
        $this->db->where('junked','0');
        $this->db->order_by("game_user_mail.timestamp", "desc");
    	$query = $this->db->get();
    	
    	$rows = array();
        foreach ($query->result_array() as $row){
            $user = $this->db->get_where('game_user',array('id' => $row['sender_id']))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
            $rows[] = $row;
        }
        return $rows;
	}
	
	function delete_mail($mailid,$deleted)
	{
		$this->db->set($deleted,'1');
		$this->db->where('id', $mailid);
		$this->db->update('game_user_mail');
		
		$mail = $this->db->get_where('game_user_mail',array('id' => $mailid))->row_array();	
		if($mail['sender_deleted']==1 &&$mail['receiver_deleted']==1){
		   $this->db->delete('game_user_mail', array('id' => $mailid)); 
		}
	}
	
	function load_mail($mailid,$author)
	{
		$this->db->select('*');
        $this->db->from('game_user_mail');
        $this->db->where('game_user_mail.id',$mailid);
        $query = $this->db->get();
        
        if ($row = $query->row_array()){
        	$user = $this->db->get_where('game_user',array('id' => $row[$author]))->row_array();
        	$row['author_name'] = $user['displayName'];
        	$row['author_pic'] = $user['pic_url'];
            return $row;
        }

        return array();
	}
	
	function move_mail($mailid,$junked)
	{
		$this->db->set('junked',$junked);	
        $this->db->where('id', $mailid);
        return $this->db->update('game_user_mail');
	}
	
}