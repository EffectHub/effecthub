<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Language extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        
    }
	
	public function select()
	{
		
		$language = $this->input->post('language');
		
		$this->session->set_userdata('language',$language);
		
		if ($this->session->userdata('id')) {
			
			$this->load->model('user_model');
			$this->user_model->language = $language;
			$this->user_model->updatelanguage($this->session->userdata('id'));
			
		}
		
		return;
	}
	
	public function convertStatusList($list)
	{
		
	}
	
	public function getStatus($status)
	{
		
	}
}