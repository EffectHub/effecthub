<?php
class user_agent_model extends CI_Model
{
    var $ip;
    
    var $browser;
    var $version;
    var $mobile;
    var $robot;
    var $platform;
    var $referrer;
	
	var $agent_string;	

	function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
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

        $query = $this->db->get_where('user_agent',array('id' => $id));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }
    
    /**
	 * load by key
	 *
	 *
	 */	
    function loadByIP($key)
    {
        if (!$key){
            return array();
        }

        $query = $this->db->get_where('user_agent',array('ip' => $key));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }    
    
	// --------------------------------------------------------------------

    /**
	 * 缁撴灉闆�
	 *
	 *
	 */	
    function find_user_agents($options = array(), $count=20, $offset=0)
	{
		if (!is_array($options)){
            return array();
        }
        if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		//brand
		$this->db->select('b.*');

		$query = $this->_query_user_agents($options);

		$rows = array();
        foreach ($query->result_array() as $row){
            $rows[] = $row;
        }
        return $rows;
       
	}
    
	// --------------------------------------------------------------------

    /**
	 * 绉佹湁鍑芥暟
	 *
	 *
	 */
	function _query_user_agents($options = null)
    {
        $this->db->from('user_agent as b');
       
		if (!empty($options['conditions'])){
            $this->db->where($options['conditions']);
        }
        
        if (isset($options['order'])){
            $this->db->order_by($options['order'],'desc');
        }else {
            $this->db->order_by('b.id desc');
        }

        return $this->db->get();
    }
    
    function create($url_id)
    { 
		$datetime = date('Y-m-d H:i:s');
		$this->db->set('url_id', $url_id);
		$this->db->set('user_id', $this->session->userdata('id'));
        $this->db->set('ip', $this->input->ip_address());
        $this->db->set('browser', $this->agent->browser());
		$this->db->set('version', $this->agent->version());
		$this->db->set('mobile', $this->agent->mobile());
        $this->db->set('robot', $this->agent->robot());
        $this->db->set('platform', $this->agent->platform());
        $this->db->set('referrer', $this->agent->referrer());
        $this->db->set('agent_string', $this->agent->agent_string());
        return $this->db->insert('user_agent');
    } 
}