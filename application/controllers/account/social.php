<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Social extends CI_Controller {
	
	public function __construct(){
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('cookie');
        if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
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
        	$this->lang->load('account','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('account','english');
        }
    }
	
	public function index()
	{
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
		$data['nav']= 'account';
		$this->load->model('user_model');
		$this->load->model('user_social_model');
		$data['error_msg'] = $this->uri->segment(4, 0);
		$data['user'] = $this->user_model->load($this->session->userdata('id'));
		$data['social_list'] = $this->user_social_model->loadByUser($this->session->userdata('id'));
		$this->load->view('account/social',$data);
	}
}


