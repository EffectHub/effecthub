<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Collection extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
        $this->load->helper('time');
        $this->load->helper('cookie');
        $this->load->helper('my_form');
        $this->load->helper('rest');
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
        	$this->lang->load('collection','chinese');
        	$this->lang->load('single_work','chinese');
        	$this->lang->load('user','chinese');
        	$this->lang->load('pop','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('collection','english');
        	$this->lang->load('single_work','english');
        	$this->lang->load('user','english');
        	$this->lang->load('pop','english');
        }
        
        if($userid = $this->session->userdata('id')) {
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
	
	//show collection main page
	public function index($id) 
	{
		$data = array();
		
		if ($id!=0&&$id!=null)
		{
			$this->load->model('user_model');
			$data['user'] = $this->user_model->load($id);
			$this->load->model('user_social_model');
			$data['social_list'] = $this->user_social_model->loadByUser($id);
			$this->load->model('item_fav_model');
			$data['likes_num'] = $this->item_fav_model->count_item_favs(array('uid'=>$id));
			$this->load->model('item_model');
			$res= $this->item_model->find_items(array('user'=>$id,'order'=>'update_date'),0);
			$data['works_num'] = count($res);
			
			$this->load->model('collection_model','collect');
			$collection = $this->collect->find_collections(array('user'=>$id),0,0);
			
			$data['collections_num'] = count($collection);
			
			$this->load->library('pagination');		//加载分页类
			$config['base_url'] = base_url().'index.php/collection/index/'.$id;		//设置分页的url路径
			$config['total_rows'] = count($collection);		//得到数据库中的记录的总条数
			$config['uri_segment'] = 4;
			$config['per_page'] = '5';//每页记录数
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '</p>';
			$this->pagination->initialize($config);//分页的初始化
			$data['collection_list'] = $this->collect->find_collections(array('user'=>$id,'order'=>'update_date'),0,$config['per_page'],$this->uri->segment(4));//得到数据库记录
				    
			$this->load->model('user_follow_model');
			if ($this->session->userdata('id')!=null){
				$data['follow'] = $this->user_follow_model->loadByUserAndFav($id,$this->session->userdata('id'));
			}
			
			$data['nav']= 'profile';
			$data['feature']= 'collection';
			$this->load->model('country_model');
			$country = $this->country_model->load($data['user']['countryCode']);
			$data['country_name'] = $country['full_name'];
			$this->load->model('user_status_model');
			$data['activity_list']= $this->user_status_model->find_status(array('user'=>$id),5);
			$this->load->model('item_model');
			$data['view_num'] = $this->item_model->get_sum_viewnum($id);
			$data['fav_num'] = $this->item_model->get_sum_favnum($id);
			
					
		} else {
			redirect('collection/explore/top');
		}
			
		
		$this->load->view('collection/collection',$data);
	
	}
	
	//lead to create collection page
	public function create()
	{
		if (!$user=$this->session->userdata('id'))
		{
			redirect('login');
			exit();
		}
		$data['userid']= $user;
		$this->load->view('collection/collection_create',$data);
	}
	
	
	//insert new collection into database
	public function save()
	{
		if (!($id=$this->session->userdata('id'))){
			redirect('login');
			exit();
		}
		
		$this->load->model('collection_model' , 'collect');
		$this->collect->author_id = $this->session->userdata('id');
		$this->collect->title = $this->input->post('name');
		$this->collect->description = nl2br($this->input->post('desc'));
		$this->collect->view_num = 0;
		$this->collect->like_num = 0;
		$this->collect->works_num = 0;
		$this->collect->comment_num = 0;
		$this->collect->pic_url = 'http://www.effecthub.com/img/default.jpg';
		$this->collect->create();
		$new_collect_id = $this->db->insert_id();
		
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
				$user_id = $new_collect_id;
				$rs = array();
				$input = file_get_contents($_FILES["url"]["tmp_name"]);
				$data = $input;
				//设置上传目录
				$upload_dir = 'collection';
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
				
			$this->collect->pic_url = base_url().'uploads/'.$upload_dir.'/'.$user_id.'_thumb.jpg';
			
			$this->collect->update($new_collect_id);
		}

		redirect(site_url('collection/'.$id));
		
	}
	
	public function update()
	{
		if (!($id=$this->session->userdata('id'))){
			redirect('login');
			exit();
		}
		
		$this->load->model('collection_model' , 'collect');
		$id = $this->input->post('collection');
		$item = $this->collect->load($id);
		$this->collect->title = $this->input->post('name');
		$this->collect->description = nl2br($this->input->post('desc'));
		$this->collect->pic_url = $this->input->post('last_pic');

		
		$this->collect->update($id);

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
				$upload_dir = 'collection';
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
		
			$this->collect->pic_url = base_url().'uploads/'.$upload_dir.'/'.$user_id.'_thumb.jpg';
				
			$this->collect->update_pic($id);
		}
		
		redirect(site_url('collection/show/'.$id));
		
	}
	
	
	
	
	public function add($item,$collection)
	{	
		if ($this->session->userdata('id')==null){
			return;
		}
		
		$datetime = date('Y-m-d H:i:s');
		
		$this->load->model('collection_work_model','cwork');
		$this->cwork->work_id = $item;
		$this->cwork->collection_id = $collection;
		$this->cwork->add_time = $datetime;
		$this->cwork->add_work($this->session->userdata('id'));
		
		$this->load->model('collection_model','collect');
		$citem = $this->collect->load($collection);
		$this->collect->works_num = $citem['works_num'] + 1;
		$this->collect->update_works_num($collection);
		
		$this->load->model('item_model');
		$items = $this->item_model->load($item);
		
		$this->load->model('user_status_model','status');
		$this->status->user_id = $this->session->userdata('id');
		//$this->status->content = "added the work <a href='".site_url('item/'.$item)."'>".$items['title']."</a> to collection <a href='".site_url('collection/show/'.$collection)."'>".$citem['title']."</a>";
		//$this->status->target_url = site_url('item/'.$item);
		if($items['thumb_url']!=''&&$items['thumb_url']!=null){
			$this->status->pic_url = $items['thumb_url'];
		}
		
		$this->status->target_id = $collection;
		$this->status->target_name = $citem['title'];

		$this->status->content_id = $item;
		$this->status->status_type = 10;
		
		$this->status->insertData();
		

		$this->load->model('collection_model','collect');
		$this->collect->update_date = $datetime;
		$this->collect->update_add_time($collection);
		
	}
	
	//show single collection by collection id
	public function show($id)
	{
		$this->load->model('collection_model','collect');
		$data['collection'] = $this->collect->load($id);
		$content = $data['collection'];
		$data['collections'] = $this->collect->find_collections(array('user'=>$content['author_id'],'order'=>'update_date'),0,8,0);
		
		$this->load->model('user_model','user');
		$data['user'] = $this->user->load($content['author_id']);
		
		if ($this->session->userdata('id')&&($this->session->userdata('id')!=$data['collection']['author_id'])) {
			$this->collect->view_num = $data['collection']['view_num'] + 1;
			$this->collect->update_view_num($id);
		}

		$this->load->model('collection_work_model','cwork');
		$items = $this->cwork->find_works(array('collection_id'=>$id),0,0);

		$this->load->library('pagination');		//加载分页类
		$config['base_url'] = base_url().'index.php/collection/show/'.$id;		//设置分页的url路径
		$config['total_rows'] = count($items);		//得到数据库中的记录的总条数
		$config['uri_segment'] = 4;
		$config['per_page'] = '12';//每页记录数
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$this->pagination->initialize($config);//分页的初始化
		$data['items'] = $this->cwork->find_works(array('collection_id'=>$id,'order'=>'add_time'),1,$config['per_page'],$this->uri->segment(4));
		$data['feature'] = 'collection';
		$data['nav'] = 'profile';
		
		if ($this->session->userdata('id')) {
			$this->load->model('collection_like_model','clike');
			$data['like'] = $this->clike->load($id,$this->session->userdata('id'));
		}
		
		$this->load->model('collection_comment_model','comment');
		$data['item_comment_list'] = $this->comment->find_comments($id);
		
		
		
		$this->load->view('collection/collection_show',$data);
	}
	
	public function like($id) 
	{
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
		
		$this->load->model('collection_like_model','clike');
		$this->clike->user_id = $this->session->userdata('id');
		$this->clike->collection_id = $id;
		$this->clike->like();
		
		$this->load->model('collection_model','collect');
		$item = $this->collect->load($id);
		$this->collect->like_num = $item['like_num'] + 1;
		$this->collect->update_like_num($id);
		
		$this->load->model('user_status_model','status');
		$this->status->user_id = $this->session->userdata('id');
		//$this->status->content = "liked the collection <a href='".site_url('collection/show/'.$id)."'>".$item['title']."</a>";
		if($item['pic_url']!=''&&$item['pic_url']!=null){
			$this->status->pic_url = $item['pic_url'];
		}
		//$this->status->target_url = site_url('collection/show/'.$id);
		$this->status->target_id = $id;
		$this->status->target_name = $item['title'];
		$this->status->status_type = 11;
		
		$this->status->insertData();
		
		$this->load->model('user_notice_model');
		$this->user_notice_model->user_id = $item['author_id'];
		$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> liked your collection <a href='".site_url('collection/show/'.$id)."'>".$item['title']."</a>";
		$this->user_notice_model->insertData();
		
		
		
		
	}
	
	// unlike by collection id
	public function unlike($id)
	{
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
		
		$this->load->model('collection_like_model','clike');
		$this->clike->unlike($id,$this->session->userdata('id'));
		$this->load->model('collection_model','collect');
		$item = $this->collect->load($id);
		$this->collect->like_num = $item['like_num'] - 1;
		$this->collect->update_like_num($id);

	}
	
	
	//delete single work in collection
	public function delete($item,$collection)
	{
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
		
		$this->load->model('collection_work_model','cwork');
		$this->cwork->delete($collection,$item);
		
		$this->load->model('collection_model','collect');
		$collect = $this->collect->load($collection);
		$this->collect->works_num = $collect['works_num'] - 1;
		$this->collect->update_works_num($collection);
		

		redirect('collection/show/'.$collection);
		
	}
	
	public function delete_collection($id)
	{
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
		
		$this->load->model('collection_model','collect');
		$this->collect->delete($id);
		
		$this->load->model('collection_work_model','cwork');
		$this->cwork->delete($id);
		
		$this->load->model('collection_like_model','clike');
		$this->clike->delete($id);
		
		$this->load->model('collection_comment_model','comment');
		$this->comment->delete($id);
		
		echo '<script language="JavaScript">;alert("Delete successfully!");location.href="'.site_url('collection/'.$this->session->userdata('id')).'"</script>;';
	}
	
	
	public function savecomment()
	{
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
		
		$this->load->model('user_model');
		
		//$this->load->helper('my_form');
		$id = $_GET['collect_id'];
		$this->load->model('collection_comment_model','comment');
		$this->comment->author_id = $this->session->userdata('id');
		$this->comment->collection_id = $id;
		$this->comment->parent_id = $_GET['parent_id'];
		$comment = $this->comment->load($_GET['parent_id']);
		
		$content = $_GET['content'];
		if($comment){
			$reply_user = $this->user_model->load($comment['author_id']);
			$content = str_replace('@'.$reply_user['displayName'],"<a href='".site_url('user/'.$reply_user['id'])."'>".'@'.$reply_user['displayName']."</a>",$content);
		}
		$this->comment->content = $content;
		$this->comment->create();
		$new_comment = $this->db->insert_id();
		
		$this->load->model('collection_model','collect');
		$collect = $this->collect->load($id);
		$this->collect->comment_num = $collect['comment_num'] + 1;
		$this->collect->update_comment_num($id);
		
		$this->load->model('user_status_model');
		$this->user_status_model->user_id = $this->session->userdata('id');

		//$this->user_status_model->action = "commented the collection";
		if($collect['pic_url']!=''&&$collect['pic_url']!=null){
			$this->user_status_model->pic_url = $collect['pic_url'];
		}
		//$this->user_status_model->target_url = site_url('collection/show/'.$id);
		//$this->user_status_model->target_name = $collect['title'];
		
		$this->user_status_model->target_id = $id;
		$this->user_status_model->target_name = $collect['title'];
		$this->user_status_model->status_type = 9;
		$this->user_status_model->content_id = $new_comment;
		$this->user_status_model->insertData();
		
		$this->load->model('user_notice_model');
		if($collect['author_id']!=$this->session->userdata('id')){
			$this->user_notice_model->user_id = $collect['author_id'];
			$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> commented your collection <a href='".site_url('collection/show/'.$id)."'>".$collect['title']."</a>";
			$this->user_notice_model->insertData();
		}
		if($comment){
			$this->user_notice_model->user_id = $comment['author_id'];
			$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> replyed your comment in <a href='".site_url('collection/show/'.$id)."'>".$collect['title']."</a>";
			$this->user_notice_model->insertData();
		}
		
		$userid =$this->session->userdata('id');
		 
		$this->load->model('user_model');
		$user = $this->user_model->load($userid);
		$user_point = $user['point'] + 1;
		$this->user_model->update_point($userid,$user_point);
		
		$datetime = date('Y-m-d H:i:s');
		$output = '<li class="response comment group " data-user-id="'.$user['id'].'">
	<h2>
		<a href="'.site_url('user/'.$userid).'" class="url" title="'.$user['displayName'].'"><img alt="'.$user['displayName'].'" class="photo" src="'.$user['pic_url'].'"> '.$user['displayName'].'</a>
	</h2>
	<div class="comment-body">
		<p>'.$_GET['content'].'</p>
	</div>
	<p class="comment-meta">
	'.tranTime(strtotime($datetime)).'
	</p>
	</li>';

		echo $output;
		
	}
	
	public function back($collect,$user)
	{
		$this->load->model('collection_model','collect');
		$collection = $this->collect->find_collections(array('user'=>$user,'order'=>'update_date'),0,0);
		
		$i = 0;
		$offset = 0;
		foreach ($collection as $item) {
			if ($collect == $item['id']) break;
			$i++;
			if ($i==5){
				$i=0;
				$offset += 5;
			}
		}
		
		redirect('collection/index/'.$user.'/'.$offset);
		
	}
	
	//update basic information of collection
	public function edit($id)
	{
		
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
		
		$this->load->model('collection_model','collect');
		$data['collect'] = $this->collect->load($id);
		
		$this->load->view('collection/collection_edit',$data);
		
	}
	
	public function explore($option)
	{
		$this->load->model('collection_model','collect');
		$count = $this->collect->total_num();
		
		$this->load->library('pagination');		//加载分页类
		$config['base_url'] = base_url().'index.php/collection/explore/'.$option;		//设置分页的url路径
		$config['total_rows'] = $count;		//得到数据库中的记录的总条数
		$config['uri_segment'] = 4;
		$config['per_page'] = '10';//每页记录数
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$this->pagination->initialize($config);//分页的初始化
		
		$data['collection_list'] = $this->collect->find_collections(array('order'=>$option),1,$config['per_page'],$this->uri->segment(4));
		
		$rows = array();
		
		$this->load->model('collection_work_model','cwork');
		foreach ($data['collection_list'] as $list){
			$data['collection_works'][$list['id']] = $this->cwork->find_works(array('collection_id'=>$list['id'],'order'=>'add_time'),1,3,0);
		}
		
		//collections order by update-date
		$data['new_collection'] = $this->collect->find_collections(array('order'=>'update_date','works_num'=>'yes'),1,10,0);
		
		$data['nav']= 'explore';
		$data['feature']= 'collection';
		
		$this->load->view('collection/collection_explore',$data);
		
	}
	
	public function quick_create()
	{
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
		
		$this->load->model('collection_model' , 'collect');
		$this->collect->author_id = $this->session->userdata('id');
		$this->collect->title = $this->input->post('title');
		$this->collect->description = '';
		$this->collect->view_num = 0;
		$this->collect->like_num = 0;
		$this->collect->works_num = 0;
		$this->collect->comment_num = 0;
		$this->collect->pic_url = 'http://www.effecthub.com/img/default.jpg';
		$this->collect->create();
		$new_collect_id = $this->db->insert_id();
		
		$output="
				<li class='addcollect' name='".$new_collect_id."'>
                   	<span class='c-title'>".msubstr($this->input->post('title'),0,50)."</span>
                 </li>";
		
		echo $output;
	}
	
	
	
	
	
}
