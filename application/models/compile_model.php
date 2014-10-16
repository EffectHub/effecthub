<?php
class compile_model extends CI_Model
{

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
        $this->load->database();
        $query = $this->db->get_where('compile',array('id' => $id));

        return $query->row_array();
    }
    
	
    function create()
    {
        $data =array(
            'code'=>''
        );
        $this->load->database();
        $this->db->insert('compile',$data);
        return $this->db->insert_id();
    } 
    
    function update($data)
    { 
        $this->load->database();
        $this->db->set('code', $data['code']);
        $this->db->where('id', $data['id']);    
        return $this->db->update('compile');
    }
    

}