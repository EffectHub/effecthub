<?php
/**
 * 客户
 *
 *
 */
class User_model extends CI_Model
{
	var $id;
    var $name;
    
	var $email;
	
	var $phone;

	var $password;
	var $consent;
	var $message;
	var $followme;
	var $invite;
	var $comment;

	var $dob;
    
    var $is_sendemail;

	var $userId;
	
	var $countryCode;
	var $displayName;
	var $access_token;
	var $expires_in;
	
	var $pic_url;
	
	var $follow_num;
	var $follower_num;
	
	var $from;
	var $point;
	
	var $homepage;
	var $desc;
    
    var $latitude;
    var $longitude;
    
    var $language;
    
    var $client_id;
     
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
        $this->db->set('name', $this->name);
        $this->db->set('password', $this->password);
        $this->db->set('consent', $this->consent);
		$this->db->set('email', $this->email);				
		$this->db->set('countryCode', $this->countryCode);
		$this->db->set('displayName', $this->displayName);
        $this->db->set('pic_url', $this->pic_url);      
        $this->db->set('from', $this->from);
        if($this->client_id!=null&&$this->client_id!='')    
        $this->db->set('client_id', $this->client_id);
        $this->db->set('create_time', $datetime);
        $this->db->set('update_time', $datetime);
        return $this->db->insert('user');
    }

    // --------------------------------------------------------------------

    /**
	 * 查询该用户名是否存在
	 *
	 *
	 */	
	function check_name($name)
	{
		$query = $this->db->get_where('user',array('name' => $name));
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
		$query = $this->db->get_where('user',array('email' => $email));
		
        if ($row = $query->row_array()){
            return true;
        }
        return false;
	}
	
	function check_token($uid,$token)
	{
		$query = $this->db->get_where('user',array('id' => $uid,'token' => $token));
		
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
	function check_user()
	{
        $query = $this->db->get_where('user',array('email' => $this->email,'password' => md5($this->password)));
        if ($row = $query->row_array()){			
            return $row;
        }
        return array();
	}
	
	function check_user_api()
	{
        $query = $this->db->get_where('user',array('email' => $this->email,'password' => $this->password));
        if ($row = $query->row_array()){			
            return $row;
        }
        return array();
	}
	
	function check_user_client_id()
	{
        $query = $this->db->get_where('user',array('client_id' => $this->client_id,'password' => $this->password));
        if ($row = $query->row_array()){			
            return $row;
        }
        return array();
	}
	
	function check_user_uid($type,$uid)
	{
		$query = null;
		if($type=='sina')$query = $this->db->get_where('user',array('uid_sina' => $uid));
        if($type=='douban')$query = $this->db->get_where('user',array('uid_douban' => $uid));
        if($type=='qq')$query = $this->db->get_where('user',array('uid_qq' => $uid));
        if($type=='renren')$query = $this->db->get_where('user',array('uid_renren' => $uid));
        
        if ($row = $query->row_array()){			
            return $row;
        }
        return array();
	}	
	
	function check_user_email()
	{
        $query = $this->db->get_where('user',array('email' => $this->email,'password' => md5($this->password)));
        if ($row = $query->row_array()){	
            return $row;
        }
        return array();
	}	
	
	function check_user_phone()
	{
        $query = $this->db->get_where('user',array('phone' => $this->phone,'password' => md5($this->password)));
        if ($row = $query->row_array()){	
            return $row;
        }
        return array();
	}	
	
	function check_user_login()
	{
		$row = $this->db->get_where('user',array('id'=>$this->id))->row_array();
		if ($row['password'] == $this->password) {
			return $row;
		} else return array();
		
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

        $query = $this->db->get_where('user',array('id' => $id));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }
    
    function loadByName($name)
    {
        if (!$name){
            return array();
        }

        $query = $this->db->get_where('user',array('name' => $name));
        if ($row = $query->row_array()){
            return $row;
        }
        return array();
    }     
    
    function loadByEmail($email)
    {
        if (!$email){
            return array();
        }

        $query = $this->db->get_where('user',array('email' => $email));

        if ($row = $query->row_array()){
        	$country = $this->db->get_where('country',array('key' => $row['countryCode']))->row_array();
        	$row['country_name'] = $country['full_name'];
            return $row;
        }

        return array();
    }  
    
    function loadBySocial($socialId)
    {
        if (!$socialId){
            return array();
        }

        $query = $this->db->get_where('user_social',array('social_id' => $socialId));

        if ($row = $query->row_array()){
        	$user = $this->db->get_where('user',array('id' => $row['user_id']))->row_array();
        	$country = $this->db->get_where('country',array('key' => $user['countryCode']))->row_array();
        	$user['country_name'] = $country['full_name'];
            return $user;
        }

        return array();
    }   
	
    // --------------------------------------------------------------------

    /**
	 * 更新客户信息
	 *
	 *
	 */	
	function update($id)
    {
    	$datetime = date('Y-m-d H:i:s');
        $this->db->set('name', $this->name);
        $this->db->set('password', $this->password);
        $this->db->set('consent', $this->consent);
		$this->db->set('email', $this->email);				
		$this->db->set('countryCode', $this->countryCode);
		$this->db->set('displayName', $this->displayName);
        $this->db->set('pic_url', $this->pic_url);
		$this->db->set('update_time', $datetime);
        $this->db->where('id', $id);
        return $this->db->update('user');
    }
    
	function updateinfo($id)
    {
    	$datetime = date('Y-m-d H:i:s');
        $this->db->set('name', $this->name);		
		$this->db->set('countryCode', $this->countryCode);
		$this->db->set('displayName', $this->displayName);
		$this->db->set('homepage', $this->homepage);
		$this->db->set('desc', $this->desc);
		$this->db->set('update_time', $datetime);
        $this->db->where('id', $id);
        return $this->db->update('user');
    }    
    
    function updateVerified($id =null,$verified =null)
    {
    	$this->db->set('verified', $verified);
        $this->db->where('id', $id);
        return $this->db->update('user');
    }
    
    function updateToken($id =null,$token =null)
    {
    	$this->db->set('token', $token);
        $this->db->where('id', $id);
        return $this->db->update('user');
    }
    
    function updateUid($id =null,$type =null,$uid =null)
    {
    	if($type=='douban')$this->db->set('uid_douban', $uid);
    	if($type=='sina')$this->db->set('uid_sina', $uid);
    	if($type=='renren')$this->db->set('uid_renren', $uid);
    	if($type=='qq')$this->db->set('uid_qq', $uid);
        
        $this->db->where('id', $id);
        return $this->db->update('user');
    }    
    
    function updatePic($id =null,$pic =null,$source =null)
    {
    	$this->db->set('pic_url', $pic);
    	$this->db->set('source_pic_url', $source);
    	
        $this->db->where('id', $id);
        return $this->db->update('user');
    }

    // --------------------------------------------------------------------

    /**
	 * 查询密码是否正确
	 *
	 *
	 */	
    function check_pwd($id,$password)
	{
		$query = $this->db->get_where('user',array('id' => $id,'password' => md5($password)));
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
        return $this->db->update('user');
    }
    
	function update_subscribe($id)
    {
		$this->db->set('consent',$this->consent);	
		$this->db->set('noti_message',$this->message);	
		$this->db->set('noti_followme',$this->followme);	
		$this->db->set('noti_invite',$this->invite);	
		$this->db->set('noti_comment',$this->comment);	
        $this->db->where('id', $id);
        return $this->db->update('user');
    }    
    
	function update_point($id,$point)
    {
		$this->db->set('point',$point);	
        $this->db->where('id', $id);
        return $this->db->update('user');
    }
    
    function update_balance($id,$balance)
    {
		$this->db->set('balance',$balance);	
        $this->db->where('id', $id);
        return $this->db->update('user');
    }
    
    function update_balanceusd($id,$balance)
    {
		$this->db->set('balance_usd',$balance);	
        $this->db->where('id', $id);
        return $this->db->update('user');
    }
    
	function update_visit($id,$visit)
    {
		$this->db->set('visit_num',$visit);	
        $this->db->where('id', $id);
        return $this->db->update('user');
    } 
    
    function update_verify($id)
    {
		$this->db->set('verified','1');	
		$this->db->set('space',5368709120);	
        $this->db->where('id', $id);
        return $this->db->update('user');
    }       
    
	// --------------------------------------------------------------------

    /**
	 * 更新最后登录时间
	 *
	 *
	 */	
    function update_last_login($user_id)
	{
		$datetime = date('Y-m-d H:i:s');
		$this->db->set('last_login_time', $datetime);	
        $this->db->where('id', $user_id);
        return $this->db->update('user');
	}
	
	function update_last_ip($user_id)
	{
		$this->db->set('last_login_ip', $this->input->ip_address());	
        $this->db->where('id', $user_id);
        return $this->db->update('user');
	}
	
	function updateFollowNum($user_id)
	{
		$this->db->set('follow_num', $this->follow_num);	
        $this->db->where('id', $user_id);
        return $this->db->update('user');
	}	
	
	function updateFollowerNum($user_id)
	{
		$this->db->set('follower_num', $this->follower_num);	
        $this->db->where('id', $user_id);
        return $this->db->update('user');
	}
	
	function updateUserLocation($user_id)
	{
		$this->db->set('latitude', $this->latitude);
		$this->db->set('longitude', $this->longitude);	
        $this->db->where('id', $user_id);
        return $this->db->update('user');
	}		
	
	function updatelanguage($user)
	{
		$this->db->set('language',$this->language);
		$this->db->where('id',$user);
		return $this->db->update('user');
	}
	
	function updatejob($user)
	{
		$this->db->set('job_type',$this->job_type);
		$this->db->where('id',$user);
		return $this->db->update('user');
	}
	
	function updatevalid($user)
	{
		$this->db->set('email_valid',$this->email_valid);
		$this->db->where('id',$user);
		return $this->db->update('user');
	}
	
    function find_users($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_users($options);
		$rows = array();
        foreach ($query->result_array() as $row){
        	$country = $this->db->get_where('country',array('key' => $row['countryCode']))->row_array();
        	$row['country_name'] = $country['full_name'];
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
	function _query_users($options = null)
    {
        $this->db->from('user as b');
       
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        if (!empty($options['active'])){
            $this->db->where('active',$options['active']);
        }
        if (isset($options['verified'])){
            $this->db->where('verified',$options['verified']);
        }
        if (!empty($options['countryCode'])){
            $this->db->where('countryCode',$options['countryCode']);
        }
        if (!empty($options['in'])){
        	$this->db->where_in('id', $options['in']);
        }
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
        }else if (isset($options['rand'])){
            $this->db->order_by('rand()');
        } else {
            $this->db->order_by('b.point desc');
        }

        return $this->db->get();
    }
    
	// --------------------------------------------------------------------

	/**
	 * 总数
	 *
	 *
	 */	
	function count_users($options = array())
    {
        $this->db->select('COUNT(DISTINCT(b.id)) as total');
        
        $query = $this->_query_users($options);
        
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
    }	
    
    //order popular authors
    function order_popular_author()
    {
    	$this->db->select('id, name, countryCode, displayName, pic_url, follow_num, follower_num');
        $this->db->from('game_user');
        $this->db->order_by("follower_num", "desc");
        $this->db->limit(10);
    	$query = $this->db->get();
    	$rows = array();
        foreach ($query->result_array() as $row){
        	$country = $this->db->get_where('country',array('key' => $row['countryCode']))->row_array();
        	$row['country_name'] = $country['full_name'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    function order_new_author()
    {
    	$this->db->select('id, name, countryCode, displayName, pic_url, follow_num, follower_num');
        $this->db->from('game_user');
        $this->db->where('active', 1);
        $this->db->order_by("create_time", "desc");
        $this->db->limit(10);
    	$query = $this->db->get();
    	$rows = array();
        foreach ($query->result_array() as $row){
        	$country = $this->db->get_where('country',array('key' => $row['countryCode']))->row_array();
        	$row['country_name'] = $country['full_name'];
            $rows[] = $row;
        }
        return $rows;
    }
    
     //order popular tags
    function order_popular_tag($tags)
    {
    	$rows = array();
        foreach ($tags as $tag){
        	$this->db->select('COUNT(b.tags) as total');
        	$this->db->from('game_item as b');
        	$this->db->like('tags',$tag);
            $query1 = $this->db->get();
            $total = 0;
            if ($row1 = $query1->row_array()){
                $total = (int)$row1['total'];
            }
            
            $rows[$tag] = $total;
        }
        arsort($rows); //将数组降序排列
        $results = array();
        foreach($rows as $key => $value){ 
            array_push($results,$key);
            if(count($results) == 8)
            {
                break;
            }
        } 
        return $results;
    }
    
    //find followers by userid
    function find_followers($userid)
    {
    	$this->db->select('*');
        $this->db->from('game_user');
        $this->db->join('game_user_follow', 'game_user_follow.follower_id = game_user.id');
        $this->db->where('game_user_follow.user_id',$userid);
        $this->db->order_by("game_user.create_time", "desc");
    	$query = $this->db->get();
    	$rows = array();
        foreach ($query->result_array() as $row){
        	$country = $this->db->get_where('country',array('key' => $row['countryCode']))->row_array();
        	$row['country_name'] = $country['full_name'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    //find following by userid
    function find_following($userid)
    {
    	$this->db->select('*');
        $this->db->from('game_user');
        $this->db->join('game_user_follow', 'game_user_follow.user_id = game_user.id');
        $this->db->where('game_user_follow.follower_id',$userid);
        $this->db->order_by("game_user.create_time", "desc");
    	$query = $this->db->get();
    	$rows = array();
        foreach ($query->result_array() as $row){
        	$country = $this->db->get_where('country',array('key' => $row['countryCode']))->row_array();
        	$row['country_name'] = $country['full_name'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    function find_allusers()
    {
    	$this->db->select('*');
        $this->db->from('game_user');
        $query = $this->db->get();
    	return $query->result_array();
    }
    
    function find_user_by_name($username)
    {

        $this->db->from('game_user');
        $this->db->like('displayName',$username);
        $this->db->where('active',1);
        $query = $this->db->get();
    	$rows = array();
        foreach ($query->result_array() as $row){
        	$country = $this->db->get_where('country',array('key' => $row['countryCode']))->row_array();
        	$row['country_name'] = $country['full_name'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    function find_user_by_country($countrycode)
    {
    	$this->db->select('*');
        $this->db->from('game_user');
        $this->db->where('countryCode',$countrycode);
        $this->db->where('active',1);
        $query = $this->db->get();
    	$rows = array();
        foreach ($query->result_array() as $row){
        	$country = $this->db->get_where('country',array('key' => $row['countryCode']))->row_array();
        	$row['country_name'] = $country['full_name'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    function find_user_by_level($level)
    {
    	$this->db->select('*');
        $this->db->from('game_user');
        $this->db->where('level',$level);
        $this->db->where('active',1);
        $query = $this->db->get();
    	$rows = array();
        foreach ($query->result_array() as $row){
        	$country = $this->db->get_where('country',array('key' => $row['countryCode']))->row_array();
        	$row['country_name'] = $country['full_name'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    function find_user_by_name_offset($username,$num,$offset)
    {
    	$this->db->select('*');
        $this->db->like('displayName',$username);
        $this->db->where('active',1);
        $query = $this->db->get('game_user',$num,$offset);
    	$rows = array();
        foreach ($query->result_array() as $row){
        	$country = $this->db->get_where('country',array('key' => $row['countryCode']))->row_array();
        	$row['country_name'] = $country['full_name'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    function find_user_by_country_offset($countrycode,$num,$offset)
    {
    	$this->db->select('*');
        $this->db->where('countryCode',$countrycode);
        $this->db->where('active',1);
        $query = $this->db->get('game_user',$num,$offset);
    	$rows = array();
        foreach ($query->result_array() as $row){
        	$country = $this->db->get_where('country',array('key' => $row['countryCode']))->row_array();
        	$row['country_name'] = $country['full_name'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    function find_user_by_level_offset($level,$num,$offset)
    {
    	$this->db->select('*');
        $this->db->where('level',$level);
        $this->db->where('active',1);
        $query = $this->db->get('game_user',$num,$offset);
    	$rows = array();
        foreach ($query->result_array() as $row){
        	$country = $this->db->get_where('country',array('key' => $row['countryCode']))->row_array();
        	$row['country_name'] = $country['full_name'];
            $rows[] = $row;
        }
        return $rows;
    }
    
    //check whether the new username is been used or not
    function verify_username($name)
    {
    	$this->db->where('name',$name);
    	$this->db->where('id !=',$this->session->userdata('id'));
    	$query = $this->db->get('user');
    	return $query->row_array();
    }
    
}
