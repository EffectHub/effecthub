<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('time');
        $this->load->helper('cookie');
		$this->load->library('encrypt');
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
        	$this->lang->load('user','chinese');
        	$this->lang->load('account','chinese');
        	$this->lang->load('single_work','chinese');
        	$this->lang->load('pop','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('user','english');
        	$this->lang->load('account','english');
        	$this->lang->load('single_work','english');
        	$this->lang->load('pop','english');
        }
        
        if($userid=$this->session->userdata('id')) {
        	$this->load->model('user_model');
        	$this->load->model('user_notice_model');
        	$notice_count = $this->user_notice_model->find_unread_count($userid);
        	$this->session->set_userdata('notice_count',$notice_count);
        	$this->load->model('user_mail_model');
        	$mail_count =$this->user_mail_model->find_unread_count($userid);
        	$this->session->set_userdata('mail_count',$mail_count);
        	$user = $this->user_model->load($userid);
        	$this->session->set_userdata('point',$user['point']);
        
        	$this->load->model('team_notice_model','t_notice');
        	$team_notice = count($this->t_notice->load(array('user_id'=>$this->session->userdata('id'),'read'=>0),0,0,0));
        	$this->session->set_userdata('team_notice',$team_notice);
        } else {
        	if (get_cookie('effecthub_user')&&get_cookie('effecthub_password')) {
        		$user = $this->encrypt->decode(get_cookie('effecthub_user'));
        		$password = $this->encrypt->decode(get_cookie('effecthub_password'));
        		$this->load->model('user_model');
        		$this->user_model->id = $user;
        		$this->user_model->password = $password;
        		$valid_user = $this->user_model->check_user_login();
        		if ($valid_user!==null) {
        			$this->session->set_userdata($valid_user);
        		}
        	}
        }
        
    }
	
	public function index($id=0)
	{
		$this->load->model('user_model');
        $data = array();
        if($id!=null&&$id!=0){
        	$this->load->model('user_social_model');
        	$data['user'] = $this->user_model->load($id);
        	$data['social_list'] = $this->user_social_model->loadByUser($id);
        	$this->load->model('item_fav_model');
        	$data['likes_num'] = $this->item_fav_model->count_item_favs(array('uid'=>$id));
        	
        	$this->load->model('item_model');      
			$count= $this->item_model->count_items(array('user'=>$id,'is_private'=>0,'work_id'=>0,'order'=>'update_date'),0);
			$data['works_num']= $count;
			
	        $this->load->library('pagination');//加载分页类
	        $config['base_url'] = base_url().'user/index/'.$id;//设置分页的url路径
	        $config['total_rows'] = $count;//得到数据库中的记录的总条数
	        $config['uri_segment'] = 4;
	        $config['per_page'] = '9';//每页记录数
	        $config['first_link'] = 'First';
	        $config['last_link'] = 'Last';
	        $config['full_tag_open'] = '<p>';
	 	    $config['full_tag_close'] = '</p>'; 
	        $this->pagination->initialize($config);//分页的初始化
	        $data['user_item_list'] = $this->item_model->find_items(array('user'=>$id,'is_private'=>0,'work_id'=>0,'order'=>'update_date'),$config['per_page'],$this->uri->segment(4));//得到数据库记录
	        
			$taglist = Array();
			foreach($data['user_item_list'] as $item){
				$tok = strtok($item['tags']," ,"); 
				while($tok !== false){
					if(!in_array($tok,$taglist)){
						if($tok!='')
						array_push($taglist,$tok);
					}
					$tok = strtok(" ,"); 
				}
			}
			$data['tags'] = $taglist;
			$this->load->model('user_follow_model');
			if ($this->session->userdata('id')!=null){
	   			$data['follow'] = $this->user_follow_model->loadByUserAndFav($id,$this->session->userdata('id'));
	   		}
        }
        $data['nav']= 'profile';
        $data['feature']= 'works';
        $this->load->model('country_model');
		$country = $this->country_model->load($data['user']['countryCode']);
		$data['country_name'] = $country['full_name'];
		$this->load->model('user_status_model');       
		$data['activity_list']= $this->user_status_model->find_status(array('user'=>$id),5);
        $data['view_num'] = $this->item_model->get_sum_viewnum($id);
        $data['fav_num'] = $this->item_model->get_sum_favnum($id);
		$this->load->view('user/user',$data);
	}
	
	public function forgot($msg='')
	{
		$data['nav']= 'account';
		$this->load->model('item_model');
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$data['msg'] = $msg;
		$this->load->view('account/forgot',$data);
	}
	
	public function password()
	{
		$email = $this->input->post('email');
		$this->load->model('user_model');
		if(!$this->user_model->check_email($email)){
			redirect('user/forgot/invalid');
		}
		$this->load->model('email_model');
		$user = $this->user_model->loadByEmail($email);
		if($user['token']){
			$url = 'http://www.effecthub.com/user/go_reset_password/'.$user['id'].'/'.$user['token'];
		}else{
			$token = create_guid();
			$this->user_model->updateToken($user['id'],$token);
			$url = 'http://www.effecthub.com/user/go_reset_password/'.$user['id'].'/'.$token;
		}
		$this->email_model->send_reset_password($email,$url);
		$this->load->model('item_model');
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$this->load->view('account/forgot2',$data);
	}
	
	public function go_reset_password($uid,$token)
	{
		$this->load->model('user_model');
		if(!$this->user_model->check_token($uid,$token)){
			redirect('login');
		}
		$data['uid'] = $uid;
		$data['token'] = $token;
		$this->load->model('item_model');
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$this->load->view('account/forgot3',$data);
	}	
	
	public function reset_password()
	{
		$uid = $this->input->post('uid');
		$token = $this->input->post('token');
		$new_pwd = $this->input->post('new_password');
		$this->load->model('user_model');
		if(!$this->user_model->check_token($uid,$token)){
			redirect('login');
		}
		$this->user_model->update_pwd($uid,$new_pwd);
		$user = $this->user_model->load($uid);
		$this->load->model('user_social_model');
		$social_list = $this->user_social_model->loadByUser($user['id']);
		foreach($social_list as $social): 
			if( $social['type']=='twitter'){ 
				$user['token_twitter'] = $social['token'];
				$user['token_secret_twitter'] = $social['token_secret'];
			}
			if( $social['type']=='facebook'){ 
				$user['token_facebook'] = $social['token'];
			}
			if( $social['type']=='sina'){ 
				$user['token_sina'] = $social['token'];
			}	
			if( $social['type']=='google'){ 
				$user['token_google'] = $social['token'];
			}
			if( $social['type']=='behance'){ 
				$user['token_behance'] = $social['token'];
			}
		endforeach;
		$cookie = array(
				    'name'   => 'effecthubcookie',
				    'value'  => $user['id'],
				    'expire' => '2595000',
				    'domain' => '.effecthub.com',
				    'path'   => '/',
				    'prefix' => 'game_',
				    'secure' => TRUE
				);
        set_cookie($cookie);
		$this->session->set_userdata($user);
		redirect(site_url('home')); 
	}	
	
	public function confirm_email($uid,$token)
	{
		$this->load->model('user_model');
		if(!$this->user_model->check_token($uid,$token)){
			redirect('login');
		}
		$this->user_model->update_verify($uid);
		$user = $this->user_model->load($uid);
		$this->load->model('user_social_model');
		$social_list = $this->user_social_model->loadByUser($user['id']);
		foreach($social_list as $social): 
			if( $social['type']=='twitter'){ 
				$user['token_twitter'] = $social['token'];
				$user['token_secret_twitter'] = $social['token_secret'];
			}
			if( $social['type']=='facebook'){ 
				$user['token_facebook'] = $social['token'];
			}
			if( $social['type']=='sina'){ 
				$user['token_sina'] = $social['token'];
			}	
			if( $social['type']=='google'){ 
				$user['token_google'] = $social['token'];
			}
			if( $social['type']=='behance'){ 
				$user['token_behance'] = $social['token'];
			}
		endforeach;
		$cookie = array(
				    'name'   => 'effecthubcookie',
				    'value'  => $user['id'],
				    'expire' => '2595000',
				    'domain' => '.effecthub.com',
				    'path'   => '/',
				    'prefix' => 'game_',
				    'secure' => TRUE
				);
        set_cookie($cookie);
		$this->session->set_userdata($user);
		$this->load->model('item_model');
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$this->load->view('account/email_confirm2',$data);
	}		
	
	function follow($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		if ($this->session->userdata('id')==$id){  
			redirect(site_url('user/'.$id)); 
			return;
		}
		$this->load->model('user_follow_model');
		
		$follow = $this->user_follow_model->loadByUserAndFav($id,$this->session->userdata('id'));
		if($follow){
			redirect(site_url('user/'.$id)); 
			return;
		}
        $this->user_follow_model->user_id = $id;
    	$this->user_follow_model->follower_id = $this->session->userdata('id');
		$this->user_follow_model->create();
		$this->load->model('user_model');
	    $user = $this->user_model->load($id);
	    $this->user_model->follower_num = $user['follower_num'] + 1;
	    $this->user_model->updateFollowerNum($id);
	    $my = $this->user_model->load($this->session->userdata('id'));
	    $this->user_model->follow_num = $my['follow_num'] + 1;
	    $this->user_model->updateFollowNum($this->session->userdata('id'));
	    
	    $this->load->model('user_status_model','u_status');	
	    /*
        $this->user_status_model->user_id = $this->session->userdata('id');
    	
		$this->user_status_model->action = "followed";
    	$this->user_status_model->pic_url = $user['pic_url'];
    	$this->user_status_model->target_url = site_url('user/'.$id);
    	$this->user_status_model->target_name = $user['displayName'];
    	*/
	    $this->u_status->target_name = $user['displayName'];
	    $this->u_status->pic_url = $user['pic_url'];
    	$this->u_status->user_id = $this->session->userdata('id');
    	$this->u_status->status_type = 1;
    	$this->u_status->target_id = $id;
    	
    	$this->u_status->insertData();
		
		$this->load->model('user_notice_model');	
        $this->user_notice_model->user_id = $id;
    	$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> followed you";
		$this->user_notice_model->insertData();
		
		$this->load->model('email_model');
        $title = $this->session->userdata('displayName').' is now following you on on EffectHub.com';
        $content = $user['displayName'].', You have a new follower <a target="_blank" href="http://www.effecthub.com/user/'.$this->session->userdata('id').'">'.$this->session->userdata('displayName').'</a>';
		$this->email_model->send_notification($user['email'],$title,$content);
		
		redirect(site_url('user/'.$id)); 
	}
	
	function unfollow($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->model('user_follow_model');
		$this->user_follow_model->delete($id,$this->session->userdata('id'));
		$this->load->model('user_model');
	    $user = $this->user_model->load($id);
	    $this->user_model->follower_num = $user['follower_num'] - 1;
	    $this->user_model->updateFollowerNum($id);
	    $my = $this->user_model->load($this->session->userdata('id'));
	    $this->user_model->follow_num = $my['follow_num'] - 1;
	    $this->user_model->updateFollowNum($this->session->userdata('id'));
	    
	    /*$this->load->model('user_status_model');	
        $this->user_status_model->user_id = $this->session->userdata('id');
    	$this->user_status_model->content = "unfollowed <a href='".site_url('user/'.$id)."'>".$user['name']."</a>";
		$this->user_status_model->insertData();*/
		
		redirect(site_url('user/'.$id)); 
	}
	
	//see more particles of one user --asynchronous loading
	function seemore($id)
	{
		$num_load_everytime =6; // 每点击一次seemore,加载的particle个数
		$post_id = $_GET['id'];
		$this->load->model('user_model');
        $data = array();
        if($id!=null&&$id!=0){
        	$data['user'] = $this->user_model->load($id);
        	$this->load->model('item_model');
			$data['user_item_list'] = $this->item_model->find_items(array('user'=>$id), $num_load_everytime, $num_load_everytime*$post_id);
			foreach($data['user_item_list'] as $_user_item){
				$output ="<div id='item' class='clearfix'>
                       <a href='".site_url('item/'.$_user_item['id'])."'><img id='item-img' src='".$_user_item['pic_url']."' class='image' /></a>
                       <div id='item-desc' class='clearfix'>
                           <p>
                           ".$_user_item['desc']."
                           </p>
                           <div id='item-author'>
                               <p>".$_user_item['create_date']."</p>
                           </div>
                       </div> 
                       <div id='item-tag' class='clearfix'>
                           ".$_user_item['tags']."
                       </div>
                       <div id='item-info' class='clearfix'> 
                           <div class='iconimg'>
                                <img src='".base_url()."img/appre.jpg'> <b class='smallgrayword1'>".$_user_item['fav_num']."</b>
                           </div>
                            <div class='iconimg marginleftstyle4'>
                                <img src='".base_url()."img/view1.jpg'> <b class='smallgrayword1'>".$_user_item['view_num']."</b>
                            </div>
                       </div>
                   </div> ";
				echo $output; 	
			}
		}
		//判断是否加载完全
		$particle_count = $this->item_model->count_items(array('user'=>$id));
		if($particle_count/$num_load_everytime==$post_id+1){
			$loadcompletely = "<div style='margin-left:30px;'>Load Completely!</div>";
			//echo $loadcompletely;
		}
	}
	
	//show my followers
	function showfollowers($id)
	{
		$this->load->model('user_model');
		
		$this->load->model('user_social_model');
        	$data['user'] = $this->user_model->load($id);
        	$data['social_list'] = $this->user_social_model->loadByUser($id);
		$data['users'] = $this->user_model->find_followers($id);
		
		$data['user'] = $this->user_model->load($id);
		$this->load->model('item_model');
        $data['view_num'] = $this->item_model->get_sum_viewnum($id);
        $data['fav_num'] = $this->item_model->get_sum_favnum($id);
        $this->load->model('item_fav_model');
		$data['likes_num'] = $this->item_fav_model->count_item_favs(array('uid'=>$id));
		$this->load->model('item_model');
		$res= $this->item_model->find_items(array('user'=>$id),0);
		$data['works_num']= count($res);
			$taglist = Array();
			foreach($res as $item){
				$itemtaglist = explode(" ",$item['tags']);
				foreach($itemtaglist as $tag){
					if(!in_array($tag,$taglist)){
						if($tag!='')
						array_push($taglist,$tag);
					}
				}
			}
		$data['tags'] = $taglist;
		$this->load->model('user_follow_model');
		if ($this->session->userdata('id')!=null){
	   		$data['follow'] = $this->user_follow_model->loadByUserAndFav($id,$this->session->userdata('id'));
	   	}
	   			$this->load->model('country_model');
			$country = $this->country_model->load($data['user']['countryCode']);
			$data['country_name'] = $country['full_name'];
			$data['nav']= 'profile';
			$data['feature']= 'follower';
		$this->load->view('user/user_follow',$data);
	}
	
	//show users that I follow with
	function showfollowing($id)
	{
		$this->load->model('user_model');
		
		$this->load->model('user_social_model');
        	$data['user'] = $this->user_model->load($id);
        	$data['social_list'] = $this->user_social_model->loadByUser($id);
		$data['users'] = $this->user_model->find_following($id);
		
		$data['user'] = $this->user_model->load($id);
		$this->load->model('item_model');
        $data['view_num'] = $this->item_model->get_sum_viewnum($id);
        $data['fav_num'] = $this->item_model->get_sum_favnum($id);
        $this->load->model('item_fav_model');
		$data['likes_num'] = $this->item_fav_model->count_item_favs(array('uid'=>$id));
		$this->load->model('item_model');
		$res= $this->item_model->find_items(array('user'=>$id),0);
		$data['works_num']= count($res);
			$taglist = Array();
			foreach($res as $item){
				$itemtaglist = explode(" ",$item['tags']);
				foreach($itemtaglist as $tag){
					if(!in_array($tag,$taglist)){
						if($tag!='')
						array_push($taglist,$tag);
					}
				}
			}
		$data['tags'] = $taglist;
		$this->load->model('user_follow_model');
		if ($this->session->userdata('id')!=null){
	   		$data['follow'] = $this->user_follow_model->loadByUserAndFav($id,$this->session->userdata('id'));
	    }
			$this->load->model('country_model');
			$country = $this->country_model->load($data['user']['countryCode']);
			$data['country_name'] = $country['full_name'];
			$data['nav']= 'profile';
			$data['feature']= 'following';
		$this->load->view('user/user_follow',$data);
	}
	
	//save user's location
	function saveuserlocation($id)
	{
		$this->load->model('user_model');
		$this->user_model->latitude = $_GET['latitude'];
		$this->user_model->longitude =$_GET['longitude'];
		$this->user_model->updateUserLocation($id);
	}
	
	function check()	
	{
		$this->load->model('user_model');
		$email = $this->input->post('email');
		echo $this->user_model->check_email($email);
	}
	
	function notice($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		if($this->session->userdata('id')!=$id){
			redirect('home');
		}
		$data['nav']= 'profile';
		$data['feature']= 'Notification';
		$this->load->model('user_model');
        $data['user_list'] = $this->user_model->order_popular_author();
        
		$this->load->model('user_notice_model');
		$res= $this->user_notice_model->count_notice($id);
	        $this->load->library('pagination');//加载分页类
	        $config['base_url'] = base_url().'user/notice/'.$id.'/';//设置分页的url路径
	        $config['total_rows'] = $res;//得到数据库中的记录的总条数
	        $config['uri_segment'] = 4;
	        $config['per_page'] = '20';//每页记录数
	        $config['first_link'] = 'First';
	        $config['last_link'] = 'Last';
	        $config['full_tag_open'] = '<p>';
	 	    $config['full_tag_close'] = '</p>'; 
	        $this->pagination->initialize($config);//分页的初始化
	        $data['notice_list']= $this->user_notice_model->find_notice($id,$config['per_page'],$this->uri->segment(4));//得到数据库记录
			
			
		$this->user_notice_model->update_read($id);
		$this->session->unset_userdata('notice_count');
		$this->load->view('account/notification',$data);
	}
	
	function checkmail($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		if($this->session->userdata('id')!=$id){
			redirect('home');
		}
		$this->load->model('item_model');
		$data['item_list1'] = $this->item_model->find_items(array(), 100, 0);
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array(), 100, 0);
		$taglist = Array();
		foreach($data['item_list1'] as $item){
			$tok = strtok($item['tags']," ,"); 
			while($tok !== false){
				    if(!in_array($tok,$taglist)){
					   if($tok!='')
					   array_push($taglist,$tok);
				    }
				    $tok = strtok(" ,"); 
			} 
		}
		$data['nav']= 'profile';
		$data['feature']= 'Mailbox';

		$this->load->model('user_model');
        $data['user_list'] = $this->user_model->order_popular_author();
        $data['tags'] = $this->user_model->order_popular_tag($taglist);
        
        $this->load->model('user_mail_model');       
		$res= $this->user_mail_model->find_mail($id,'0');
        $this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'index.php/user/checkmail/'.$id;//设置分页的url路径
        $config['total_rows'] = count($res);//得到数据库中的记录的总条数
        $config['uri_segment'] = 4;
        $config['per_page'] = '20';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $data['mail_list']= $this->user_mail_model->find_mail_offset($id,'0',$config['per_page'],$this->uri->segment(4));//得到数据库记录
        
        //$this->load->model('user_mail_model');
        //$data['mail_list'] = $this->user_mail_model->find_mail($id,'0');
        $data['unreadcount'] =$this->user_mail_model->find_unread_count($id);
        $data['unreadjunkcount'] =$this->user_mail_model->find_unreadjunk_count($id);
        $this->load->view('mail/mailbox',$data);
	}
	
	function checkjunkmail($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		if($this->session->userdata('id')!=$id){
			redirect('home');
		}
		$this->load->model('item_model');
		$data['item_list1'] = $this->item_model->find_items(array(), 100, 0);
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array(), 100, 0);
		$taglist = Array();
		foreach($data['item_list1'] as $item){
			$tok = strtok($item['tags']," ,"); 
			while($tok !== false){
				    if(!in_array($tok,$taglist)){
					   if($tok!='')
					   array_push($taglist,$tok);
				    }
				    $tok = strtok(" ,"); 
			} 
		}
		$data['nav']= 'profile';
		$data['feature']= 'Mailbox';
		$this->load->model('user_model');
        $data['user_list'] = $this->user_model->order_popular_author();
        $data['tags'] = $this->user_model->order_popular_tag($taglist);
        
        $this->load->model('user_mail_model');       
		$res= $this->user_mail_model->find_mail($id,'1');
        $this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'index.php/user/checkjunkmail/'.$id;//设置分页的url路径
        $config['total_rows'] = count($res);//得到数据库中的记录的总条数
        $config['uri_segment'] = 4;
        $config['per_page'] = '20';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $data['mail_list']= $this->user_mail_model->find_mail_offset($id,'1',$config['per_page'],$this->uri->segment(4));//得到数据库记录
        
        //$this->load->model('user_mail_model');
        //$data['mail_list'] = $this->user_mail_model->find_mail($id,'1');
        $data['unreadcount'] =$this->user_mail_model->find_unread_count($id);
        $data['unreadjunkcount'] =$this->user_mail_model->find_unreadjunk_count($id);
        $this->load->view('mail/mailboxjunk',$data);
	}
	
	function checksendmail($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		if($this->session->userdata('id')!=$id){
			redirect('home');
		}
		$this->load->model('item_model');
		$data['item_list1'] = $this->item_model->find_items(array(), 100, 0);
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array(), 100, 0);
		$taglist = Array();
		foreach($data['item_list1'] as $item){
			$tok = strtok($item['tags']," ,"); 
			while($tok !== false){
				    if(!in_array($tok,$taglist)){
					   if($tok!='')
					   array_push($taglist,$tok);
				    }
				    $tok = strtok(" ,"); 
			} 
		}
		$data['nav']= 'profile';
		$data['feature']= 'Mailbox';
		$this->load->model('user_model');
        $data['user_list'] = $this->user_model->order_popular_author();
        $data['tags'] = $this->user_model->order_popular_tag($taglist);
        
        $this->load->model('user_mail_model');       
		$res= $this->user_mail_model->find_send_mail($id);
        $this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'index.php/user/checksendmail/'.$id;//设置分页的url路径
        $config['total_rows'] = count($res);//得到数据库中的记录的总条数
        $config['uri_segment'] = 4;
        $config['per_page'] = '20';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $data['mail_list']= $this->user_mail_model->find_send_mail_offset($id,$config['per_page'],$this->uri->segment(4));//得到数据库记录
        
        //$this->load->model('user_mail_model');
        //$data['mail_list'] = $this->user_mail_model->find_send_mail($id);
        $data['unreadcount'] =$this->user_mail_model->find_unread_count($id);
        $data['unreadjunkcount'] =$this->user_mail_model->find_unreadjunk_count($id);
        $this->load->view('mail/mailboxsend',$data);
	}
	
	function choosefollowing($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		if($this->session->userdata('id')!=$id){
			redirect('home');
		}
		$data['nav']= 'profile';
		$data['feature']= 'Mailbox';
		$this->load->model('item_model');
		$data['item_list1'] = $this->item_model->find_items(array(), 100, 0);
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array(), 100, 0);
		$taglist = Array();
		foreach($data['item_list1'] as $item){
			$tok = strtok($item['tags']," ,"); 
			while($tok !== false){
				    if(!in_array($tok,$taglist)){
					   if($tok!='')
					   array_push($taglist,$tok);
				    }
				    $tok = strtok(" ,"); 
			} 
		}

		$this->load->model('user_model');
        $data['user_list'] = $this->user_model->order_popular_author();
        $data['tags'] = $this->user_model->order_popular_tag($taglist);
		
		$data['following_list'] = $this->user_model->find_following($id);
        $this->load->view('mail/mailchoosefollowing',$data);
	}
	
	function writemail($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$data['nav']= 'profile';
		$data['feature']= 'Mailbox';

		$this->load->model('user_model');
        
        $data['user'] = $this->user_model->load($id);
        $this->load->view('mail/mailwrite',$data);
	}
	
	function sendMail($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$data['nav']= 'profile';
		$data['feature']= 'Mailbox';
		if(!empty($_POST['m_cancel'])) {
            redirect(site_url('user/checkmail/'.$this->session->userdata('id')));
        }elseif(!empty($_POST['m_submit'])) {
        	$this->load->model('user_mail_model');
        	$this->user_mail_model->receiver_id = $id;
    	    $this->user_mail_model->sender_id = $this->session->userdata('id');
    	    $this->user_mail_model->content = $_POST['m_text'];
            $this->user_mail_model->insertData();
            
            $this->load->model('email_model');
            $this->load->model('user_model');
            $user = $this->user_model->load($id);
            $sender = $this->user_model->load($id);
            $title = $this->session->userdata('displayName').' has sent you a mail on EffectHub.com';
            $content = $this->user_mail_model->content;
			$this->email_model->send_notification($user['email'],$title,$content);
			
            echo '<script language="JavaScript">;alert("Send mail successfully!");location.href="'.site_url('user/checkmail/'.$this->session->userdata('id')).'"</script>;';
        }
		
	}
	
	function deletemail($mailid,$junked)
	{
		$this->load->model('user_mail_model');
		$this->user_mail_model->delete_mail($mailid,'receiver_deleted');
		if($junked=='0'){
		   redirect(site_url('user/checkmail/'.$this->session->userdata('id')));
		}else{
			redirect(site_url('user/checkjunkmail/'.$this->session->userdata('id')));
		}
	}
	
	function deletesendmail($mailid)
	{
		$this->load->model('user_mail_model');
		$this->user_mail_model->delete_mail($mailid,'sender_deleted');
        redirect(site_url('user/checksendmail/'.$this->session->userdata('id')));
	}
	
	function movemail($mailid,$junked)
	{
		$this->load->model('user_mail_model');
		$this->user_mail_model->move_mail($mailid,$junked);
		if($junked=='1'){
		   redirect(site_url('user/checkmail/'.$this->session->userdata('id')));
		}else{
			redirect(site_url('user/checkjunkmail/'.$this->session->userdata('id')));
		}
	}
	
	function movesendmail($mailid)
	{
		$this->load->model('user_mail_model');
		$this->user_mail_model->move_mail($mailid,'1');
		redirect(site_url('user/checksendmail/'.$this->session->userdata('id')));
	}
	
	function readmail($mailid,$author)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$data['nav']= 'profile';
		$data['feature']= 'Mailbox';
		$this->load->model('item_model');
		$data['item_list1'] = $this->item_model->find_items(array(), 100, 0);
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array(), 100, 0);
		$taglist = Array();
		foreach($data['item_list1'] as $item){
			$tok = strtok($item['tags']," ,"); 
			while($tok !== false){
				    if(!in_array($tok,$taglist)){
					   if($tok!='')
					   array_push($taglist,$tok);
				    }
				    $tok = strtok(" ,"); 
			} 
		}

		$this->load->model('user_model');
        $data['user_list'] = $this->user_model->order_popular_author();
        $data['tags'] = $this->user_model->order_popular_tag($taglist);
        
        $this->load->model('user_mail_model');
        $data['maildetail']=$this->user_mail_model->load_mail($mailid,$author);
        $data['author_id']= $author; //='sender_id' or 'receiver_id'
        if ($this->uri->segment(2) !== 'checksendmail'){
            $this->user_mail_model->update_read_singlemail($mailid);
        }
        $this->load->view('mail/maildetail',$data);
	}
	
	function markallread($junked)
	{
		$this->load->model('user_mail_model');
		$this->user_mail_model->update_read($this->session->userdata('id'),$junked);	
		if($junked=='0'){
		   redirect(site_url('user/checkmail/'.$this->session->userdata('id')));
		}else{
			redirect(site_url('user/checkjunkmail/'.$this->session->userdata('id')));
		}
	}
	
	function operatechosedmail($junked)
	{
		if(!empty($_POST['deletechosedmail'])){
            if(!empty($_POST['choosemail'])&&$_POST['choosemail']!=0){
              for($i=0;$i<count($_POST['choosemail']);$i++){
                 $chosed=$_POST['choosemail'][$i];
                 $this->load->model('user_mail_model');
		         $this->user_mail_model->delete_mail($chosed,'receiver_deleted');
              }
            }else{
            	if($junked=='0'){
            	    echo '<script language="JavaScript">;alert("Please first choose mail!");location.href="'.site_url('user/checkmail/'.$this->session->userdata('id')).'"</script>;';
            	}else{
            		echo '<script language="JavaScript">;alert("Please first choose mail!");location.href="'.site_url('user/checkjunkmail/'.$this->session->userdata('id')).'"</script>;';
            	}
            }

        }elseif(!empty($_POST['markchosedmail'])){
            if(!empty($_POST['choosemail'])&&$_POST['choosemail']!=0){
              for($i=0;$i<count($_POST['choosemail']);$i++){
                 $chosed=$_POST['choosemail'][$i];
                 $this->load->model('user_mail_model');
                 $this->user_mail_model->update_read_singlemail($chosed);
              }
            }else{
            	if($junked=='0'){
            	    echo '<script language="JavaScript">;alert("Please first choose mail!");location.href="'.site_url('user/checkmail/'.$this->session->userdata('id')).'"</script>;';
            	}else{
            		echo '<script language="JavaScript">;alert("Please first choose mail!");location.href="'.site_url('user/checkjunkmail/'.$this->session->userdata('id')).'"</script>;';
            	}
            }

        }elseif(!empty($_POST['movechosedmail'])){
            if(!empty($_POST['choosemail'])&&$_POST['choosemail']!=0){
              for($i=0;$i<count($_POST['choosemail']);$i++){
                 $chosed=$_POST['choosemail'][$i];
                 $this->load->model('user_mail_model');
                 if($junked=='0'){
                   $this->user_mail_model->move_mail($chosed,'1');
                 }else{
                 	$this->user_mail_model->move_mail($chosed,'0');
                 }
              }
            }else{
            	if($junked=='0'){
            	    echo '<script language="JavaScript">;alert("Please first choose mail!");location.href="'.site_url('user/checkmail/'.$this->session->userdata('id')).'"</script>;';
            	}else{
            		echo '<script language="JavaScript">;alert("Please first choose mail!");location.href="'.site_url('user/checkjunkmail/'.$this->session->userdata('id')).'"</script>;';
            	}
            }
            
        }
        if($junked=='0'){
		       redirect(site_url('user/checkmail/'.$this->session->userdata('id')));
		}else{
			   redirect(site_url('user/checkjunkmail/'.$this->session->userdata('id')));
		}				
	}
	
	function operatechosedsendmail()
	{
		if(!empty($_POST['deletechosedmail'])){
            if(!empty($_POST['choosemail'])&&$_POST['choosemail']!=0){
              for($i=0;$i<count($_POST['choosemail']);$i++){
                 $chosed=$_POST['choosemail'][$i];
                 $this->load->model('user_mail_model');
		         $this->user_mail_model->delete_mail($chosed,'sender_deleted');
              }
            }else{
            	 echo '<script language="JavaScript">;alert("Please first choose mail!");location.href="'.site_url('user/checksendmail/'.$this->session->userdata('id')).'"</script>;';
            }
        }
        redirect(site_url('user/checksendmail/'.$this->session->userdata('id')));
	}
	
	function findunreadmail($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		if($this->session->userdata('id')!=$id){
			redirect('home');
		}
		$data['nav']= 'profile';
		$data['feature']= 'Mailbox';
		$this->load->model('item_model');
		$data['item_list1'] = $this->item_model->find_items(array(), 100, 0);
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array(), 100, 0);
		$taglist = Array();
		foreach($data['item_list1'] as $item){
			$tok = strtok($item['tags']," ,"); 
			while($tok !== false){
				    if(!in_array($tok,$taglist)){
					   if($tok!='')
					   array_push($taglist,$tok);
				    }
				    $tok = strtok(" ,"); 
			} 
		}

		$this->load->model('user_model');
        $data['user_list'] = $this->user_model->order_popular_author();
        $data['tags'] = $this->user_model->order_popular_tag($taglist);
        
		$this->load->model('user_mail_model');
		$data['mail_list'] = $this->user_mail_model->find_read_or_unreadmail($id,'0');
		$data['unreadcount'] =$this->user_mail_model->find_unread_count($id);
        $data['unreadjunkcount'] =$this->user_mail_model->find_unreadjunk_count($id);
        //$data['unread'] = 2;
        $this->load->view('mail/mailbox',$data);
	}
	
	function findreadmail($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		if($this->session->userdata('id')!=$id){
			redirect('home');
		}
		$data['nav']= 'profile';
		$data['feature']= 'Mailbox';
		$this->load->model('item_model');
		$data['item_list1'] = $this->item_model->find_items(array(), 100, 0);
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array(), 100, 0);
		$taglist = Array();
		foreach($data['item_list1'] as $item){
			$tok = strtok($item['tags']," ,"); 
			while($tok !== false){
				    if(!in_array($tok,$taglist)){
					   if($tok!='')
					   array_push($taglist,$tok);
				    }
				    $tok = strtok(" ,"); 
			} 
		}

		$this->load->model('user_model');
        $data['user_list'] = $this->user_model->order_popular_author();
        $data['tags'] = $this->user_model->order_popular_tag($taglist);
        
		$this->load->model('user_mail_model');
		$data['mail_list'] = $this->user_mail_model->find_read_or_unreadmail($id,'1');
		$data['unreadcount'] =$this->user_mail_model->find_unread_count($id);
        $data['unreadjunkcount'] =$this->user_mail_model->find_unreadjunk_count($id);
        //$data['unread'] = 3;
        $this->load->view('mail/mailbox',$data);
	}
	
	
	public function changejobtype()
	{
		$job = $this->input->post('job_type');
		
		$this->session->set_userdata('job_type',$job);
		
		if ($this->session->userdata('id')) {
			
			$this->load->model('user_model');
			$this->user_model->job_type = $job;
			$this->user_model->updatejob($this->session->userdata('id'));
			
		}
		
		return;
	}
}