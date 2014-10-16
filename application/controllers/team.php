<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Team extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
        $this->load->helper('time');
        $this->load->helper('my_form');
        $this->load->helper('rest');
        $this->load->helper('cookie');
        $this->load->library('encrypt');
        
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
        	$this->lang->load('team','chinese');
        	
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('team','english');
        	
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
	
	public function none()
	{
		$this->load->view('team/team_none');
	}
	
	public function forbidden($team=0)
	{
		if ($team>0) {
			
			$this->session->set_userdata('team_id',$team);
			
			$data['invite'] = get_cookie('invite');
			$data['team'] = $team;
		
			$this->load->model('team_notice_model','t_notice');
		
			//获取用户是否提交过还未处理的团队加入申请
			$data['apply'] = count($this->t_notice->load(array('producer_id'=>$this->session->userdata('id'),'team_id'=>$team,'read'=>0,'type'=>4)));
		
			$this->load->view('team/team_forbidden',$data);
		}
	}
	
	
	public function index($id=0) 
	{
		if ($id==0||$id==null) {
			redirect('team/myteam');	
		}
		$this->session->set_userdata('team_id',$id);
		$this->load->model('team_model');
		$team = $this->team_model->load($id,0);
		
		if (!$team) {
			redirect('team/none');
		}
		
		$p = 0;
		$data['is_member'] = 0;
		$data['position'] = 0;
		$invite = 0;
		
		if ($this->session->userdata('id')){
			
			$this->load->model('team_notice_model','t_notice');
			//获取用户是否提交过还未处理的团队加入申请
			$data['apply'] = count($this->t_notice->load(array('producer_id'=>$this->session->userdata('id'),'team_id'=>$id,'read'=>0,'type'=>4),0,0));
			
			
			$this->load->model('team_member_model','t_member');
			$members = $this->t_member->load_team_member($id);
			
			foreach ($members as $row) {
				if ($this->session->userdata('id') == $row['member_id']) {
					$p = 1;
					$data['is_member'] = 1;
					$data['position'] = $row['position'];
					$data['position_name'] = $row['position_name'];
				}
			}
			
			$this->load->model('team_notice_model','t_notice');
			$invite = count($this->t_notice->load(array('user_id'=>$this->session->userdata('id'),'read'=>0,'team_id'=>$id,'type'=>1)));
			
		}
			
		if ($team['priority'] == 1) {
			$p = 1;
		}
			
		if ($p==0&&$team['priority']==2) $p = 2;
		
		if ($p == 0){
			$cookie = array(
					'name'   => 'invite',
					'value'  => $invite,
					'expire' => '120',
			);
			set_cookie($cookie);
			
			redirect('team/forbidden/'.$id);
		}
		
		
		$data['team'] = $this->team_model->load($id,1);
		$this->team_model->view_num = $data['team']['view_num'] + 1;
		$this->team_model->update_view_num($id);
		
		$this->load->model('team_member_model','t_member');
		$data['members'] = $this->t_member->load_team_member($id,10);
		
		$this->load->model('team_share_model','t_share');
		$data['shares'] = $this->t_share->load_team_shares($id,1,3,0);
		
		$this->load->model('team_comment_model','t_comment');
		$data['comments'] = $this->t_comment->load_comments($id,1,5,0);
		$data['priority'] = $p;
		
		$data['invite'] = $invite;
		
		$data['nav'] = 'team';
		$data['feature'] = 'myteam';
		
		$this->load->view('team/team',$data);
		
	}
	
	public function create($step=1)
	{
		if (!$user = $this->session->userdata('id')) {
			redirect('login');
			exit();
		}
		
		$data['userid'] = $user;
		
		if ($step == 1) {
			$data['step'] = $step;
			
			$data['nav'] = 'team';
			$this->load->view('team/team_create',$data);
		} else if ($step == 2) {
			
			$data['step'] = $step;
			
			$this->load->model('user_model');
			$data['following_list'] = $this->user_model->find_following($user);
			$data['nav'] = 'team';
			$data['feature'] = 'myteam';
			
			$this->load->view('team/team_create',$data);
			
		} else if ($step == 3) {
			
			$data['step'] = 3;
			
			$this->load->view('team/team_create',$data);
			
		} else {
			redirect('team/myteam');
		}
		
		
	}
	
	
	public function save()
	{
		if (!$user = $this->session->userdata('id')) {
			redirect('login');
			exit();
		}
		
		$this->load->model('team_model','team');
		$this->team->author_id = $this->session->userdata('id');
		$this->team->leader_id = $this->session->userdata('id');
		$this->team->team_name = htmlspecialchars($this->input->post('name'));
		$this->team->description = htmlspecialchars(nl2br($this->input->post('desc')));
		$this->team->people_num = 1;
		$this->team->upper_limit = $this->input->post('upper');
		$this->team->status = 3;
		$this->team->project_num = 0;
		$this->team->work_num = 0;
		$this->team->priority = $this->input->post('priority');
		$this->team->view_num = 0;
		$this->team->pic_url = base_url().'images/icon-team.png';
		$this->team->create();
		$new_team_id = $this->db->insert_id();
			
		$pic_path = '';
		if ((($_FILES["url"]["type"] == "image/gif")
				|| ($_FILES["url"]["type"] == "image/jpeg")
				|| ($_FILES["url"]["type"] == "image/pjpeg")
				|| ($_FILES["url"]["type"] == "image/png")
				|| ($_FILES["url"]["type"] == "image/bmp")
				|| ($_FILES["url"]["type"] == "image/tiff"))
				&& ($_FILES["url"]["size"] < 2000000))
		{
			if ($_FILES["url"]["error"] > 0)
			{
				echo "Return Code: " . $_FILES["url"]["error"] . "<br />";
			}
			else
			{
				$this->load->helper('my_form');
				$base_url=$this->config->item('base_url');
				$user_id = $new_team_id;
				$rs = array();
				$input = file_get_contents($_FILES["url"]["tmp_name"]);
				$data = $input;
				//设置上传目录
				$upload_dir = 'team';
				$dir = UploadPath($upload_dir);
				//大图
				$file_name=$dir.'/'.$user_id.'.jpg';
					
				@file_put_contents($file_name, $data);
				$pic_path = base_url().'uploads/'.$upload_dir.'/'.$user_id.'.jpg';
				$rs['status'] = 1;
			}
		}
		if($pic_path!=''&&$pic_path!=null){
			$config['image_library'] = 'gd2';
			$config['source_image'] = $file_name;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 200;
			$config['height'] = 200;
				
			$this->load->library('image_lib', $config);
				
			$this->image_lib->resize();
				
			$this->team->pic_url = base_url().'uploads/'.$upload_dir.'/'.$user_id.'.jpg';
				
			$this->team->update($new_team_id);
		}
		
		$this->load->model('team_member_model','t_member');
		$this->t_member->member_id = $user;
		$this->t_member->team_id = $new_team_id;
		$this->t_member->position = 1;
		$this->t_member->position_name = null;
		$this->t_member->create();
		
		$cookie = array(
				'name'   => 'new_team',
				'value'  => $new_team_id,
				'expire' => '1200',
		);
		set_cookie($cookie);
		
		$this->load->model('user_status_model','u_status');	
    	
    	$this->u_status->user_id = $this->session->userdata('id');
    	$this->u_status->status_type = 4;
    	$this->u_status->target_id = $new_team_id;
    	$this->u_status->pic_url = $pic_path;
    	$this->u_status->target_name = $this->team->team_name;
    	$this->u_status->insertData();
		
		redirect('team/create/2');
	}
	
	
	
	public function invite()
	{
		if (!$user = $this->session->userdata('id')) {
			redirect('login');
			exit();
		}
		
		$chosen = $this->input->post('arr');
		$new_team = $this->input->post('new_team');

		$arr = array();
		
		$arr = explode(',', $chosen);
		
		//邀请好友加入团队
		if ($arr){
			$this->load->model('team_notice_model','t_notice');
			$this->load->model('team_member_model','t_member');
			
			for ($i=0;$i<count($arr);$i++) {
				
				$temp = intval(trim($arr[$i]));
				
				$ismember = count($this->t_member->load_user_teams($temp,$new_team,0,0));

				if ($ismember == 0){
					$this->t_notice->notice_type = 1;
					$this->t_notice->user_id = $temp;
					$this->t_notice->producer_id = $this->session->userdata('id');
					$this->t_notice->team_id = $new_team;
					$this->t_notice->target_id = 0;
					
					$this->t_notice->create();
				}
			}
			
			$cookie = array(
					'name'   => 'new_team',
					'value'  => $new_team,
					'expire' => '1200',
			);
			set_cookie($cookie);
			
		} 
		
		echo $chosen;
		
		return;
	}
	
	public function myteam()
	{
		if (!$user = $this->session->userdata('id')) {
			redirect('login');
			exit();
		}
		
		$this->load->model('team_member_model','t_member');
		$count =$this->t_member->count_my_team($user);
		
		$data['team_count'] = $count;
		
		$this->load->library('pagination');//加载分页类
		$config['base_url'] = site_url('team/myteam');	//设置分页的url路径
		$config['total_rows'] = $count;//得到数据库中的记录的总条数
		$config['per_page'] = '10';//每页记录数
		$config['first_link'] = 'First';
		$config['uri_segment']= 3 ;
		$config['last_link'] = 'Last';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$this->pagination->initialize($config);//分页的初始化
		$data['team_list'] = $this->t_member->load_user_teams($user,0,$this->uri->segment(3),10);
		
		$this->load->model('user_model');
		$data['user'] = $this->user_model->load($user);
		
		$this->load->model('team_notice_model','t_notice');
		$data['notice_count'] = count($this->t_notice->load(array('user_id'=>$user,'read'=>0),0,0));
		$data['notice'] = $this->t_notice->load(array('user_id'=>$user,'read'=>0),5,0);
		
		$data['nav'] = 'team';
		$data['feature'] = 'myteam';
		
		
		$this->load->view('team/team_myteam',$data);
		
		
		
	}
	
	public function explore()
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
		$this->load->model('team_model');
		$data['lang']= $lang;
		$count = $this->team_model->count_team();
		$this->load->library('pagination');//加载分页类
		$config['base_url'] = site_url('team/explore');	//设置分页的url路径
		$config['total_rows'] = $count;//得到数据库中的记录的总条数
		$config['per_page'] = '10';//每页记录数
		$config['first_link'] = 'First';
		$config['uri_segment']= 3;
		$config['last_link'] = 'Last';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$this->pagination->initialize($config);//分页的初始化
		$data['team_list'] = $this->team_model->find_teams(array('order' => 'hot'),1,$this->uri->segment(3),10);
			
		$data['team_member'] = array();
		$this->load->model('team_member_model');
		foreach ($data['team_list'] as $list) {
			$data['team_member'][$list['team_id']] = $this->team_member_model->load_team_member($list['team_id'],5);
		}
		
		$data['team_count'] = $count;
		
		$data['nav'] = 'team';
		$data['feature'] = 'teams';
			
		$this->load->view('team/team_explore',$data);
	}
	
	
	public function save_comment()
	{
		if (!$this->session->userdata('id')) {
			redirect('login');
		}
		
		$this->load->model('team_comment_model','t_comment');
		$this->t_comment->content = htmlspecialchars($this->input->post('content'));
		$this->t_comment->team_id = $this->input->post('team');
		$this->t_comment->user_id = $this->session->userdata('id');
		$this->t_comment->parent_id = $this->input->post('parent');
		$parent = $this->input->post('parent');
		$save = $this->t_comment->save();
		
		$new_comment = $this->db->insert_id();
		
		if ($save > 0) {
			if ($parent!= 0) {
				$comment = $this->t_comment->load($parent);
				
				$this->load->model('team_notice_model','t_notice');
				$this->t_notice->notice_type = 2;
				$this->t_notice->user_id = $comment['user_id'];
				$this->t_notice->producer_id = $this->session->userdata('id');
				$this->t_notice->team_id = $this->input->post('team');
				$this->t_notice->target_id = $new_comment;
				
				$this->t_notice->create();
			}
		}
		
	}
	
	public function comments($id=0)
	{
		if ($id==0){
			redirect('team/myteam');
		}
		$this->session->set_userdata('team_id',$id);
		
		$this->load->model('team_model');
		$data['team'] = $this->team_model->load($id,1);
		
		$p = 0;
		$invite = 0;
		
		if ($data['team']['priority'] == 1) {
			$p = 1;
		}
			
		if ($p==0&&$data['team']['priority']==2) $p = 2;
		
		if ($this->session->userdata('id')){
			$this->load->model('team_member_model','t_member');
			$members = $this->t_member->load_team_member($id);
		
			foreach ($members as $row) {
				if ($this->session->userdata('id') == $row['member_id']) {
					$p = 1;
				}
			}
			
			$this->load->model('team_notice_model','t_notice');
			$invite = count($this->t_notice->load(array('user_id'=>$this->session->userdata('id'),'read'=>0,'team_id'=>$id,'type'=>1)));
		
		}
		
		if ($p == 0){	
			
			$cookie = array(
					'name'   => 'invite',
					'value'  => $invite,
					'expire' => '120',
			);
			set_cookie($cookie);

			redirect('team/forbidden/'.$id);
		}
		
		$this->load->model('team_comment_model','t_comment');
		$count = $this->t_comment->count($id);
		
		$this->load->library('pagination');//加载分页类
		$config['base_url'] = site_url('team/comments/'.$id);	//设置分页的url路径
		$config['total_rows'] = $count;//得到数据库中的记录的总条数
		$config['per_page'] = '10';//每页记录数
		$config['first_link'] = 'First';
		$config['uri_segment']= 4;
		$config['last_link'] = 'Last';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$this->pagination->initialize($config);//分页的初始化
		$data['comments'] = $this->t_comment->load_comments($id,1,10,$this->uri->segment(4));
		
		$data['priority'] = $p;
		$data['comment_num'] = $count;
		
		$data['nav'] = 'team';
		$data['feature'] = 'myteam';
		
		
		$this->load->view('team/team_comments',$data);
		
	}
	
	public function quit($id){
		
		if (!$this->session->userdata('id')) {
			redirect('login');
		}
		
		$this->load->model('team_member_model','t_member');
		$member = $this->t_member->delete($this->session->userdata('id'),$id);
		
		if ($member > 0) {
			$this->load->model('team_model','team');
			
			$query = $this->team->load($id,0);
			if (!$query) {
				redirect('team/myteam');
			}
		
			$this->team->people_num = $query['people_num'] - 1;
			$update = $this->team->update_people_num($id);
			
			if ($update > 0) {
				redirect('team/'.$id);
			} else {
				$this->team->people_num = $query['people_num'];
				$update = $this->team->update_people_num($id);
			}
		}
		
		alert($this->lang->line('team_quit_fail'));
		redirect('team/'.$id);
		
	}
	
	//必须服务器端验证编辑小组的人是否是管理员，不能从前端获取数据，因为用户可以手工输入URL进行数据篡改
	public function edit($id)
	{
		if (!$this->session->userdata('id')) {
			redirect('login');
		}
		
		$this->load->model('team_model');
		$data['team'] = $this->team_model->load($id,0);
		
		if ($this->session->userdata('id') == $data['team']['leader_id']) {
			
			$this->load->view('team/team_edit',$data);
			
		} else {
			redirect('team/myteam');
		}
		
	}
	
	//accept team invite
	public function accept() 
	{
		if (!$this->session->userdata('id')) {
			redirect('login');
		}
		
		//由于要更新多张表，对值的插入进行同步，保证不同表间相关数据同步性和准确性良好
		$this->load->model('team_member_model','t_member');
		$this->t_member->team_id = $this->session->userdata('team_id');
		$this->t_member->member_id = $this->session->userdata('id');
		$this->t_member->position = 0;
		$this->t_member->position_name = null;
		$insert = $this->t_member->create();
		
		if ($insert > 0) {
			$this->load->model('team_model','team');	
			$query = $this->team->load($this->session->userdata('team_id'),0);
		
			if (!$query) {
				redirect('team/myteam');
			}
		
			$this->team->people_num = $query['people_num'] + 1;
			$update = $this->team->update_people_num($this->session->userdata('team_id'));
					
			if ($update > 0) {
				
				$this->load->model('team_notice_model','t_notice');
				$this->t_notice->read(array('notice_type'=>1,'user_id'=>$this->session->userdata('id'),'team_id'=>$this->session->userdata('team_id')),1);
				
			} else {
				$this->team->people_num = $query['people_num'];
				$update = $this->team->update_people_num($this->session->userdata('team_id'));
			}
		}
		
		redirect('team/'.$this->session->userdata('team_id'));
		
	}
	
	public function ignore(){
		
		if (!$this->session->userdata('id')) {
			redirect('login');
		}
		
		$this->load->model('team_notice_model','t_notice');
		$this->t_notice->read(array('notice_type'=>1,'user_id'=>$this->session->userdata('id'),'team_id'=>$this->session->userdata('team_id')),2);	
		
		redirect('team/'.$this->session->userdata('team_id'));
	}
	
	public function members($team)
	{
		
		$p = 0;
		$invite = 0;
		
		$this->load->model('team_model');
		$query = $this->team_model->load($team,1);
		
		$this->session->set_userdata('team_id',$team);
		
		if ($this->session->userdata('id')){
			$this->load->model('team_member_model','t_member');
			$members = $this->t_member->load_team_member($team);
				
			foreach ($members as $row) {
				if ($this->session->userdata('id') == $row['member_id']) {
					$p = 1;
				}
			}
			
			$this->load->model('team_notice_model','t_notice');
			$invite = count($this->t_notice->load(array('user_id'=>$this->session->userdata('id'),'read'=>0,'team_id'=>$team,'type'=>1)));	

		}
			
		if ($query['priority'] < 3) {
			$p = 1;
		}

		if ($p == 0){
			
			$cookie = array(
					'name'   => 'invite',
					'value'  => $invite,
					'expire' => '120',
			);
			set_cookie($cookie);
			
			redirect('team/forbidden/'.$team);
		}
		
		$this->load->model('team_member_model','t_member');
		$count = count($this->t_member->load_team_member($team));
		
		$this->load->library('pagination');//加载分页类
		$config['base_url'] = site_url('team/members/'.$team);	//设置分页的url路径
		$config['total_rows'] = $count;//得到数据库中的记录的总条数
		$config['per_page'] = '15';//每页记录数
		$config['first_link'] = 'First';
		$config['uri_segment']= 4;
		$config['last_link'] = 'Last';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$this->pagination->initialize($config);//分页的初始化
		
		$data['members'] = $this->t_member->load_team_member($team,15,$this->uri->segment(4));
		
		$data['team'] = $query;
		
		$this->load->view('team/team_members',$data);
		
	}
	
	public function shares($team)
	{
		$p = 0;
		$invite = 0;
		
		$this->load->model('team_model');
		$query = $this->team_model->load($team,1);
		
		if ($this->session->userdata('id')){
			$this->load->model('team_member_model','t_member');
			$members = $this->t_member->load_team_member($team);
		
			foreach ($members as $row) {
				if ($this->session->userdata('id') == $row['member_id']) {
					$p = 1;
					$data['is_member'] = 1;
				}
			}
		
			$this->load->model('team_notice_model','t_notice');
			$invite = count($this->t_notice->load(array('user_id'=>$this->session->userdata('id'),'read'=>0,'team_id'=>$team,'type'=>1)));
		
		}
			
		if ($query['priority'] < 3) {
			$p = 1;
		}
		
		if ($p == 0){
			$cookie = array(
					'name'   => 'invite',
					'value'  => $invite,
					'expire' => '120',
			);
			set_cookie($cookie);
		
			redirect('team/forbidden/'.$team);
		}
		
		$this->load->model('team_share_model','t_share');
		
		$count = count($this->t_share->load_team_shares($team,0,0,0));
		$this->load->library('pagination');//加载分页类
		$config['base_url'] = site_url('team/shares/'.$team);	//设置分页的url路径
		$config['total_rows'] = $count;//得到数据库中的记录的总条数
		$config['per_page'] = '12';//每页记录数
		$config['first_link'] = 'First';
		$config['uri_segment']= 4;
		$config['last_link'] = 'Last';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$this->pagination->initialize($config);//分页的初始化
		$data['shares'] = $this->t_share->load_team_shares($team,1,12,$this->uri->segment(4));
		
		$this->load->model('team_model');
		$data['team'] = $this->team_model->load($team,1);
		$data['share_num'] = $count;
		
		$data['nav'] = 'team';
		$data['feature'] = 'myteam';
		
		$this->load->view('team/team_shares',$data);
		
		
	}
	
	public function get_comment($notice=0)
	{
		
		if (!$this->session->userdata('id')) {
			redirect('login');
		}
		
		if ($notice>0) {
			
			$this->load->model('team_notice_model','t_notice');
			$item = $this->t_notice->load_by_id($notice);
			
			//寻找到回复的留言所在的那一页
			if (($item['user_id'] == $this->session->userdata('id'))&&($item!=null&&$item['target_id']>0)) {
			
				$this->load->model('team_comment_model','t_comment');
				$comment = $this->t_comment->load($item['target_id']);
			
				$count = count($this->t_comment->load_comments($comment['team_id'],0,0,0,array('comment_date >'=>$comment['comment_date'])));
				$offset = intval($count/10)*10;
			
				$this->t_notice->read = 1;
				$this->t_notice->read(array('notice_id'=>$notice),1);
			
				redirect('team/comments/'.$item['team_id'].'/'.$offset);

			}
			
			
		}	
		
		redirect('team/myteam');
	}
	
	public function apply($team)
	{
		
		if (!$this->session->userdata('id')) {
			redirect('login');
		}
		
		$this->load->model('team_model');
		$item = $this->team_model->load($team,0);
		
		//创建申请提醒，给该团队的队长
		$this->load->model('team_notice_model','t_notice');
		$this->t_notice->user_id = $item['leader_id'];
		$this->t_notice->producer_id = $this->session->userdata('id');
		$this->t_notice->team_id = $team;
		$this->t_notice->notice_type = 4;
		$this->t_notice->target_id = 0;
		
		$this->t_notice->create();
		
		redirect('team/'.$team);
		
	}
	
	//做好必要检验措施，防止用户手动输入此URL+$notice的ID，修改提醒数据库表（虽危害不大，但需做好防范）
	//return表示返回的页面路径，可以是myteam，和team_notice主页面
	public function accept_join($notice=0,$return=0) 
	{
		if (!$this->session->userdata('id')) {
			redirect('login');
		}
		
		
		//这里以下的数据库操作逻辑有空再完善下，把同步性做好，不要只做一半
		if ($notice>0) {
			
			$this->load->model('team_notice_model','t_notice');
			$item = $this->t_notice->load_by_id($notice);
			
			if (($item['user_id'] == $this->session->userdata('id'))&&($item['notice_type'] == 4)) {
				
				$read = $this->t_notice->read(array('notice_id'=>$notice),1);
				
				if ($read>0) {
					$this->load->model('team_member_model','t_member');
					
					$this->t_member->member_id = $item['producer_id'];
					$this->t_member->team_id = $item['team_id'];
					$this->t_member->position = 0;
					$this->t_member->position_description = '';
					
					$add = $this->t_member->create();
					
					if ($add>0) {
						
						$this->load->model('team_model');
						$team = $this->team_model->load($item['team_id'],0);
						$this->team_model->people_num = $team['people_num'] + 1;
						$this->team_model->update_people_num($team['team_id']);
						
						$this->t_notice->user_id = $item['producer_id'];
						$this->t_notice->producer_id = $item['user_id'];
						$this->t_notice->team_id = $item['team_id'];
						$this->t_notice->notice_type = 5;
						$this->t_notice->target_id = 0;
						
						$this->t_notice->create();
						
						if ($return ==0 ) {
							redirect('team/myteam');
						} else {
							redirect('team/notice/0');
						}
					}
					
				}
				
			}
			
		}

		alert($this->lang->line('teamnotice_error'));
		redirect('team/myteam');
		
	}
	
	public function deny_join($notice=0,$return=0)
	{
		if (!$this->session->userdata('id')) {
			redirect('login');
		}
		
		//这里以下的数据库操作逻辑有空再完善下，把同步性做好，不要只做一半
		if ($notice>0) {
				
			$this->load->model('team_notice_model','t_notice');
			$item = $this->t_notice->load_by_id($notice);
				
			if (($item['user_id'] == $this->session->userdata('id'))&&($item['notice_type'] == 4)) {
		
				$read = $this->t_notice->read(array('notice_id'=>$notice),2);
		
				
				if ($read>0) {
		
					$this->t_notice->user_id = $item['producer_id'];
					$this->t_notice->producer_id = $item['user_id'];
					$this->t_notice->team_id = $item['team_id'];
					$this->t_notice->notice_type = 6;
					$this->t_notice->target_id = 0;
		
					$this->t_notice->create();
		
					if ($return ==0 ) {
						redirect('team/myteam');
					} else {
						redirect('team/notice/0');
					}
					
				}
		
			}
		
		}
		
		alert($this->lang->line('teamnotice_error'));
		redirect('team/myteam');
		
	}
	
	//只需要阅读不需要处理的提醒在此函数进行处理
	public function join_notice($notice)
	{
		if (!$this->session->userdata('id')) {
			redirect('login');
		}
		
		if ($notice>0) {
		
			$this->load->model('team_notice_model','t_notice');
			$item = $this->t_notice->load_by_id($notice);

			if ($item['notice_type']==8) {
				$this->t_notice->read(array('user_id'=>$this->session->userdata('id'),'team_id'=>$item['team_id'],'notice_type'=>8),1);
			} else if (($item['user_id'] == $this->session->userdata('id'))) {
				
				$this->t_notice->read(array('notice_id'=>$notice),1);
				
			}
		
		}
		
		redirect('team/'.$item['team_id']);
		
	}
	

	public function update($id)
	{
		if (!$user = $this->session->userdata('id')) {
			redirect('login');
			exit();
		}
	
		$this->load->model('team_model','team');
		$this->team->team_name = htmlspecialchars($this->input->post('name'));
		$this->team->description = htmlspecialchars(nl2br($this->input->post('desc')));
		$this->team->upper_limit = $this->input->post('upper');
		$this->team->priority = $this->input->post('priority');
		$this->team->pic_url = $this->input->post('upfile');
		$this->team->status = 3;
		$this->team->update($id);
			
		$pic_path = '';
		if ((($_FILES["url"]["type"] == "image/gif")
				|| ($_FILES["url"]["type"] == "image/jpeg")
				|| ($_FILES["url"]["type"] == "image/pjpeg")
				|| ($_FILES["url"]["type"] == "image/png")
				|| ($_FILES["url"]["type"] == "image/bmp")
				|| ($_FILES["url"]["type"] == "image/tiff"))
				&& ($_FILES["url"]["size"] < 2000000))
		{
			if ($_FILES["url"]["error"] > 0)
			{
				echo "Return Code: " . $_FILES["url"]["error"] . "<br />";
			}
			else
			{
				$this->load->helper('my_form');
				$base_url=$this->config->item('base_url');
				$user_id = $id;
				$rs = array();
				$input = file_get_contents($_FILES["url"]["tmp_name"]);
				$data = $input;
				//设置上传目录
				$upload_dir = 'team';
				$dir = UploadPath($upload_dir);
				//大图
				$file_name=$dir.'/'.$user_id.'.jpg';
					
				@file_put_contents($file_name, $data);
				$pic_path = base_url().'uploads/'.$upload_dir.'/'.$user_id.'.jpg';
				$rs['status'] = 1;
			}
		}
		if($pic_path!=''&&$pic_path!=null){
			$config['image_library'] = 'gd2';
			$config['source_image'] = $file_name;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 200;
			$config['height'] = 200;
	
			$this->load->library('image_lib', $config);
	
			$this->image_lib->resize();
	
			$this->team->pic_url = base_url().'uploads/'.$upload_dir.'/'.$user_id.'.jpg';
	
			$this->team->update_pic($id);
		}
		
		redirect('team/'.$id);

	}
	
	public function delete_member($member,$team_id,$segment)
	{
		if (!$user = $this->session->userdata('id')) {
			redirect('login');
			exit();
		}
		
		if ($member>0&&$team_id>0){
		
			$this->load->model('team_model');
			$team = $this->team_model->load($team_id,0);
		
		//防止非团队队长用户恶意手工输入url篡改数据
			if ($user != $team['leader_id']){
				redirect('team/members/'.$team_id);
			}
			
			$this->load->model('team_member_model','t_member');
			$delete = $this->t_member->delete($member,$team_id);
			
			$this->team_model->people_num =$team['people_num'] - 1;
			$this->team_model->update_people_num($team_id);
			
			if ($delete>0){
		
				$this->load->model('team_notice_model','t_notice');
			
				$this->t_notice->user_id = $member;
				$this->t_notice->producer_id = $user;
				$this->t_notice->team_id = $team_id;
				$this->t_notice->notice_type = 3;
				$this->t_notice->target_id = 0;
				
				$this->t_notice->create();
			
				echo "<script>alert($this->lang->line('teammember_delete_success'));</script>";
			}
		
		}
		
		redirect('team/members/'.$team_id.'/'.$segment);
	}
	
	function edit_member()
	{	
		if (!$user = $this->session->userdata('id')) {
			echo 'fail';
			return;
		}
		
		$this->load->model('team_member_model','t_member');
		
		/*
		$member = $this->t_member->load_member($this->input->post('member'),$this->session->userdata('team_id'));
		if ($member['position']==$this->input->post('position')) {
			if ($member['position']==99) {
				if ($member['position_name']==$this->input->post('position_name')) {
					echo 'nochange';
					return;
				}
			} else {
				echo 'nochange';
				return;
			}
		}
		*/
		
		$this->t_member->position = $this->input->post('position');
		$this->t_member->position_name = htmlspecialchars($this->input->post('position_name'));
		$this->t_member->update_position($this->session->userdata('team_id'),$this->input->post('member'));
		
		$this->load->model('team_notice_model','t_notice');
		$this->t_notice->notice_type = 8;
		$this->t_notice->team_id = $this->session->userdata('team_id');
		$this->t_notice->user_id = $this->input->post('member');
		$this->t_notice->producer_id = $user;
		$this->t_notice->target_id = 0;
		$this->t_notice->create();
		
		echo 'success';
		
		return;
		
	}
	
	function notice($read=0)
	{
		if (!$user = $this->session->userdata('id')) {
			redirect('login');
			exit();
		}
		
		$this->load->model('team_notice_model','t_notice');
		$data['notice_count'] = count($this->t_notice->load(array('user_id'=>$user,'read'=>$read),0,0));
		
		$this->load->library('pagination');//加载分页类
		$config['base_url'] = site_url('team/notice/'.$read);	//设置分页的url路径
		$config['total_rows'] = $data['notice_count'];//得到数据库中的记录的总条数
		$config['per_page'] = '20';//每页记录数
		$config['first_link'] = 'First';
		$config['uri_segment']= 4;
		$config['last_link'] = 'Last';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$this->pagination->initialize($config);//分页的初始化
		
		
		$data['notice'] = $this->t_notice->load(array('user_id'=>$user,'read'=>$read),20,$this->uri->segment(4));
		
		$this->load->model('user_model');
		$data['user'] = $this->user_model->load($user);
		
		$data['nav'] = 'team';
		$data['feature'] = 'myteam';
		
		//显示的是已读还是未读消息
		$data['read'] = $read;
		
		$this->load->view('team/team_notice',$data);
		
	}
	
	//团队建好之后的邀请入口
	public function team_invite($team)
	{
		if (!$user = $this->session->userdata('id')) {
			redirect('login');
			exit();
		}
		
		$this->load->model('user_model');
		$data['following_list'] = $this->user_model->find_following($user);
		$data['follower_list'] = $this->user_model->find_followers($user);
		$data['nav'] = 'team';
		$data['feature'] = 'myteam';
		$data['team'] = $team;
		$this->load->view('team/team_invite',$data);
		
	}
	
	public function invite_done($team)
	{
		if (!$user = $this->session->userdata('id')) {
			redirect('login');
			exit();
		}
		
		$data['team'] = $team;
		$data['nav'] = 'team';
		$data['feature'] = 'myteam';
		
		$this->load->view('team/team_invite_finish',$data);
		
	}
	
	
	
}
