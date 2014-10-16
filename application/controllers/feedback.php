<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedback extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        
		if($this->session->userdata('language')) {
			$lang = $this->session->userdata('language');
		} else {
			$language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
			if (preg_match("/zh-c/i", $language)||$language=='cn'){
				$lang = 2;
			} else {
				$lang = 1;
			}
			
		}
        if ($lang==2)
        {
        	$this->lang->load('header','chinese');
        	$this->lang->load('footer','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        }
    }
	
	public function index()
	{
		
	}
	
	public function send($type='effecthub',$from='web')
	{
		$this->load->model('feedback_model');
		$this->feedback_model->name = $this->input->post('name');
		$this->feedback_model->email = $this->input->post('email');
		$this->feedback_model->comment = $this->input->post('message');
		$this->feedback_model->tool = $type;
		$this->feedback_model->from = $from;
		echo $this->feedback_model->create();
	}
}