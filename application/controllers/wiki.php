<?php
/**
 * 首页
 *
 *
 */
class Wiki extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
        
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
   

    function index()
    {    
       
		    $this->load->view('wiki/wiki');
    }
    
    
}

?>