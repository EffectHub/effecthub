<?php
/**
 * 客户
 *
 *
 */
class User_social_model extends CI_Model
{
    var $user_id;
    var $token;
    var $token_secret;
    var $social_id;
    var $name;
    var $avatar;
    var $type;
    var $expires_in;
    var $refresh_token;
    var $outlink;

	function __construct()
    {
        parent::__construct();
    }

	// --------------------------------------------------------------------

    /**
	 * 添加新客户
	 *
	 *
	 */	
	function create()
    { 
		$datetime = date('Y-m-d H:i:s');
        $this->db->set('user_id', $this->user_id);
        $this->db->set('token', $this->token);
        $this->db->set('token_secret', $this->token_secret);
		$this->db->set('social_id', $this->social_id);
		$this->db->set('name', $this->name);					
		$this->db->set('avatar', $this->avatar);
		$this->db->set('type', $this->type);
        $this->db->set('expires_in', $this->expires_in);
        $this->db->set('refresh_token', $this->refresh_token);
        $this->db->set('link', $this->outlink);      
        return $this->db->insert('user_social');
    }
    
    function deleteSocial($user_id, $type)
    {
    	$this->db->where('user_id', $user_id);
    	$this->db->where('type', $type);
        return $this->db->delete('user_social'); 
    }

    // --------------------------------------------------------------------

    /**
	 * 查询该用户名是否存在
	 *
	 *
	 */	
	function check_name($name)
	{
		$query = $this->db->get_where('user_social',array('name' => $name));
        if ($row = $query->row_array()){
            return true;
        }
        return false;
	}
    
	// --------------------------------------------------------------------

    /**
	 * 查询该邮箱是否存在
	 *
	 *
	 */	
	function check_email($email)
	{
		$query = $this->db->get_where('user_social',array('email' => $email));
        if ($row = $query->row_array()){
            return true;
        }
        return false;
	}

   // --------------------------------------------------------------------

    /**
	 * 查询该用户，返回用户信息
	 *
	 *
	 */	
	function check_user_social()
	{
        $query = $this->db->get_where('user_social',array('email' => $this->email,'password' => md5($this->password)));
        if ($row = $query->row_array()){			
            return $row;
        }
        return array();
	}
	
	function check_user_social_uid($type,$uid)
	{
		$query = null;
		if($type=='sina')$query = $this->db->get_where('user_social',array('uid_sina' => $uid));
        if($type=='douban')$query = $this->db->get_where('user_social',array('uid_douban' => $uid));
        if($type=='qq')$query = $this->db->get_where('user_social',array('uid_qq' => $uid));
        if($type=='renren')$query = $this->db->get_where('user_social',array('uid_renren' => $uid));
        
        if ($row = $query->row_array()){			
            return $row;
        }
        return array();
	}	
	
	function check_user_social_email()
	{
        $query = $this->db->get_where('user_social',array('email' => $this->email,'password' => md5($this->password)));
        if ($row = $query->row_array()){	
            return $row;
        }
        return array();
	}	
	
	function check_user_social_phone()
	{
        $query = $this->db->get_where('user_social',array('phone' => $this->phone,'password' => md5($this->password)));
        if ($row = $query->row_array()){	
            return $row;
        }
        return array();
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

        $query = $this->db->get_where('user_social',array('id' => $id));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }
    
    function loadByUid($uid)
    {
        if (!$uid){
            return array();
        }

        $query = $this->db->get_where('user_social',array('social_id' => $uid));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }  
    
    function loadByUser($uid)
    {
        if (!$uid){
            return array();
        }

        $query = $this->db->get_where('user_social',array('user_id' => $uid));

        $rows = array();
        foreach ($query->result_array() as $row){
            $rows[] = $row;
        }
        return $rows;
    }      
	
    // --------------------------------------------------------------------

    /**
	 * 更新客户信息
	 *
	 *
	 */	
	function update($id)
    {
        $this->db->set('token', $this->token);
        $this->db->set('token_secret', $this->token_secret);
		$this->db->set('social_id', $this->social_id);
		$this->db->set('name', $this->name);					
		$this->db->set('avatar', $this->avatar);
		$this->db->set('type', $this->type);
        $this->db->set('expires_in', $this->expires_in);
        $this->db->set('refresh_token', $this->refresh_token); 
		$this->db->set('link', $this->outlink); 
        $this->db->where('id', $id);
        return $this->db->update('user_social');
    }
    
    function updateToken($id =null,$access_token =null)
    {
//     	if($type=='douban')$this->db->set('access_token_douban', $access_token);
//     	if($type=='sina')$this->db->set('access_token_sina', $access_token);
//     	if($type=='renren')$this->db->set('access_token_renren', $access_token);
//     	if($type=='qq')$this->db->set('access_token_qq', $access_token);
        
    	$this->db->set('token',$access_token);
        $this->db->where('id', $id);
        return $this->db->update('user_social');
    }
    
    function updateUid($id =null,$type =null,$uid =null)
    {
    	if($type=='douban')$this->db->set('uid_douban', $uid);
    	if($type=='sina')$this->db->set('uid_sina', $uid);
    	if($type=='renren')$this->db->set('uid_renren', $uid);
    	if($type=='qq')$this->db->set('uid_qq', $uid);
        
        $this->db->where('id', $id);
        return $this->db->update('user_social');
    }    
    
    function updatePic($id =null,$pic =null,$source =null)
    {
    	$this->db->set('pic_url', $pic);
    	$this->db->set('source_pic_url', $source);
    	
        $this->db->where('id', $id);
        return $this->db->update('user_social');
    }

    // --------------------------------------------------------------------

    /**
	 * 查询密码是否正确
	 *
	 *
	 */	
    function check_pwd($password)
	{
		$query = $this->db->get_where('user_social',array('password' => md5($password)));
        if ($row = $query->row_array()){
            return true;
        }
        return false;
	}
    
	// --------------------------------------------------------------------

    /**
	 * 更新密码
	 *
	 *
	 */	
	function update_pwd($id,$pwd)
    {
		$this->db->set('password', md5($pwd));	
        $this->db->where('id', $id);
        return $this->db->update('user_social');
    }
    
	function update_subscribe($id,$subscribe)
    {
		$this->db->set('subscribe',$subscribe);	
        $this->db->where('id', $id);
        return $this->db->update('user_social');
    }    
    
	function update_point($id,$point)
    {
		$this->db->set('user_social_point',$point);	
        $this->db->where('id', $id);
        return $this->db->update('user_social');
    }
}
