<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once( APPPATH.'/libraries/encrypt/STD3Des.php' );
class Download extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        
    }
	
	public function index()
	{
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
		$data['nav']= 'teams';
		$this->load->model('item_model');
		$data['title'] = 'Download Sparticle And Parser For Free!';
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$this->load->view('download',$data);
	}
	
	public function software($key)
	{
		
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
        
		$this->load->model('url_model');
		$this->load->model('user_agent_model');
        $url = $this->url_model->loadByKey($key);
        if($url){
	        $this->url_model->open_num = $url['open_num']+1;
	        $this->url_model->updateOpenNum($url['id']);
	        $this->user_agent_model->create($url['id']);
	        redirect($url['url']);
        }
	}
	
	public function particle2dx($item_id)
	{
		$this->load->model('item_model');
		$item = $this->item_model->load($item_id);
		if($item["download_url"]==''||$item["download_url"]==null)return;
		if($item['tool']==94||$item['tool']==92){
			$input = file_get_contents($item["download_url"]);
			echo $input;
		}else{
			echo 'error';
		}
	}
	
	public function data($item_id)
	{
		$this->load->model('item_model');
		$item = $this->item_model->load($item_id);
		if($item["download_url"]==''||$item["download_url"]==null)return;
		$input = file_get_contents($item["download_url"]);
		//$des = new Crypt_DES('CRYPT_DES_MODE_ECB');
	    //$des->setKey('fect.com');
	    //$after = $des->encrypt($input);
		$api = new STD3Des('effecthub','effecthub');
		$after = $api->encrypt($input);
		//@header("Content-Type: application/octetstream");
		header('Content-Length: '.strlen($after));
		Header("Accept-Ranges: bytes");
		header('Content-Type: application/zip;');
		//@file_put_contents('c:/a.txt', $after);
		echo $after;
	}
	
	public function historydata($history_id)
	{
		$this->load->model('item_history_model');
		$item_history = $this->item_history_model->load($history_id);
		if($item_history["download_url"]==''||$item_history["download_url"]==null)return;
		$input = file_get_contents($item_history["download_url"]);
		$api = new STD3Des('fect.com','12345678');
		$after = $api->encrypt($input);
		header('Content-Length: '.strlen($after));
		Header("Accept-Ranges: bytes");
		header('Content-Type: application/zip;');
		echo $after;
	}
}
