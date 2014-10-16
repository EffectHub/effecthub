<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsfeed extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('time');
		$this->load->helper('my_form');
		
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
	
    
	public function index($start,$end)
	{
		$this->load->model('user_status_model','u_status');
		$data['count'] = $this->u_status->localization($start,$end);
		$data['start'] = $start;
		$data['end'] = $end;
		
		$this->load->view('newsfeed',$data);
		
	}
	
}