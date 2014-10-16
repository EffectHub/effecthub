<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {
	
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
		$data['lang']= $lang;
		$data['nav']= 'account';
		$this->load->model('user_model');
		$this->load->model('user_recharge_model');
		$data['recharge_list'] = $this->user_recharge_model->find_user_recharges(array('user_id'=>$this->session->userdata('id')));
		$data['error_msg'] = $this->uri->segment(4, 0);
		$data['user'] = $this->user_model->load($this->session->userdata('id'));
		$this->load->view('account/recharge',$data);
	}
	
	public function downloaded()
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
		$data['lang']= $lang;
		$data['nav']= 'account';
		$this->load->model('user_model');
		$this->load->model('item_download_model');
		
		$option = array('order'=>'timestamp','uid'=>$this->session->userdata('id'));
		$data['item_num'] = $this->item_download_model->count_item_downloads($option);
        $this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'account/payment/downloaded';//设置分页的url路径
        $config['total_rows'] = $data['item_num'];//得到数据库中的记录的总条数
        $config['uri_segment'] = 4;
        $config['per_page'] = '12';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
		$data['download_list'] = $this->item_download_model->find_item_downloads($option,$config['per_page'],$this->uri->segment(4));
		$data['error_msg'] = $this->uri->segment(4, 0);
		$data['user'] = $this->user_model->load($this->session->userdata('id'));
		$this->load->view('account/downloaded',$data);
	}
	
	public function withdraw()
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
		$data['lang']= $lang;
		$data['nav']= 'account';
		$this->load->model('user_model');
		$this->load->model('user_withdraw_model');
		$data['withdraw_list'] = $this->user_withdraw_model->find_user_withdraws(array('user_id'=>$this->session->userdata('id')));
		$data['error_msg'] = $this->uri->segment(4, 0);
		$data['user'] = $this->user_model->load($this->session->userdata('id'));
		$this->load->view('account/withdraw',$data);
	}
	
	public function rechargeRequest()
	{
		$this->load->model('user_recharge_model');
		$this->user_recharge_model->user_id = $this->session->userdata('id');
		$this->user_recharge_model->recharge_name = $this->input->post('recharge_name');
		$this->user_recharge_model->recharge_email = $this->input->post('recharge_email');
		$this->user_recharge_model->recharge_amount = $this->input->post('recharge_amount');
		$this->user_recharge_model->create();
		/*
		$this->load->model('user_notice_model');	
        $this->user_notice_model->user_id = $this->session->userdata('id');
    	$this->user_notice_model->content = "Your recharge request has been processed.";
		$this->user_notice_model->insertData();
		
		$this->load->model('email_model');
		$this->load->model('user_model');
        $user = $this->user_model->load($this->session->userdata('id'));
        $title = 'Your recharge request has been processed';
        $content = $this->user_notice_model->content;
		$this->email_model->send_notification($user['email'],$title,$content);
		*/
		redirect(site_url('account/payment')); 
	}
	
	public function withdrawRequest()
	{
		$this->load->model('user_withdraw_model');
		$this->user_withdraw_model->user_id = $this->session->userdata('id');
		$this->user_withdraw_model->withdraw_name = $this->input->post('withdraw_name');
		$this->user_withdraw_model->withdraw_email = $this->input->post('withdraw_email');
		$this->user_withdraw_model->withdraw_amount = $this->input->post('withdraw_amount');
		$this->user_withdraw_model->create();
		redirect(site_url('account/payment/withdraw')); 
	}
	
	public function coin()
	{
		$coincount = $this->input->post('coincount');
		$this->load->model('user_model');
		$user = $this->user_model->load($this->session->userdata('id'));
		if(($user['balance']*10+$user['balance_usd']*60)>$coincount){
			$coinfromusd = $coincount - $user['balance']*10;
			$balance = $user['balance'] - $coincount/10;
			if($balance>=0){
				$this->user_model->update_balance($user['id'],$balance);
        		$this->session->set_userdata('balance',$balance);
			}else{
				$this->user_model->update_balance($user['id'],0);
        		$this->session->set_userdata('balance',0);
			}
			if($coinfromusd>0){
				$balanceusd = $user['balance_usd'] - $coinfromusd/60;
				if($balanceusd>=0){
					$this->user_model->update_balanceusd($user['id'],$balanceusd);
	        		$this->session->set_userdata('balance_usd',$balanceusd);
				}
			}
			$point = $user['point'] + $coincount;
			$this->user_model->update_point($user['id'],$point);
        	$this->session->set_userdata('point',$point);
			redirect(site_url('account/payment')); 
		}else{
			redirect(site_url('account/payment')); 
		}
	}
}


