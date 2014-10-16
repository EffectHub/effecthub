<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contest extends CI_Controller {
	
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
	
	public function index($lang='en')
	{
		$data['nav']= 'explore';
		$data['type']= 'all';
		$data['feature']= 'ThisMonth';
		
		$this->load->model('item_model');
		$data['item_list'] = $this->item_model->find_items(array('order'=>'create_date','contest'=>'1','from'=>'particle'), 100, 0);
		
		$this->session->set_userdata('redirectURL',site_url('contest'));
		
		$this->load->model('item_fav_model');
		$item_list = array();
		foreach($data['item_list'] as $item){
			$item_fav_list = $this->item_fav_model->loadByContestItem($item['id']);
			$item['fav_list'] = $item_fav_list;
			$item['fav_count'] = count($item_fav_list);
			array_push($item_list,$item);
		}
		$newList = array_sort($item_list,'fav_count','desc');
		$data['winner_list'] = $newList;
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4); 
		if (preg_match("/zh-c/i", $lang)||$lang=='cn') 
	 	{
			$this->load->view('contest_cn',$data);
	 	}else{
	 		$this->load->view('contest',$data);
	 	}
		/*if($lang=='en'){
			$this->load->view('contest',$data);
		}else{
			$this->load->view('contest_cn',$data);
		}*/
	}
	private function arrCmp($a,$b){
		if($a['fav_count'] == $b['fav_count']){  
		return 0;
		}   
		return($a['fav_count']<$b['fav_count']) ? -1 : 1;
	} 
}