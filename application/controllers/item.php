<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once( APPPATH.'/libraries/twitter/config.php' );
require_once( APPPATH.'/libraries/twitter/Twitter.php' );
include_once( APPPATH.'/libraries/weibo/config.php' );
include_once( APPPATH.'/libraries/weibo/SaeTOAuthV2.php' );
require_once( APPPATH.'/libraries/facebook/Facebook.php' );
require_once( APPPATH.'/libraries/behance/config.php' );
require_once( APPPATH.'/libraries/behance/Api.php' );


class Item extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('rest');
        $this->load->helper('time');
        $this->load->helper('my_form');
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
        	$this->lang->load('user','chinese');
        	$this->lang->load('item','chinese');
        	$this->lang->load('pop','chinese');
        	$this->lang->load('single_work','chinese');
        	$this->lang->load('other','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        	$this->lang->load('user','english');
        	$this->lang->load('item','english');
        	$this->lang->load('pop','english');
        	$this->lang->load('single_work','english');
        	$this->lang->load('other','english');
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
    /*
    public function update()
	{
		$this->load->model('item_model');
		$item_list = $this->item_model->find_items(array(), 200, 0);
		foreach($item_list as $item): 
			$download_url = str_replace('awayeffect.com','effecthub.com',$item["download_url"]);
			$pic_url = str_replace('awayeffect.com','effecthub.com',$item["pic_url"]);
			$thumb_url = str_replace('awayeffect.com','effecthub.com',$item["thumb_url"]);
			$this->item_model->download_url = $download_url;
			$this->item_model->pic_url = $pic_url;
			$this->item_model->thumb_url = $thumb_url;
	        $this->item_model->updateNew($item['id']);
	        echo 'updated '.$item['id'];
		endforeach; 
	}
	
	public function updateUser()
	{
		$this->load->model('user_model');
		$user_list = $this->user_model->find_users(array(), 500, 0);
		foreach($user_list as $user): 
			$pic_url = str_replace('awayeffect.com','effecthub.com',$user["pic_url"]);
			$source_pic_url = str_replace('awayeffect.com','effecthub.com',$user["source_pic_url"]);
			$this->user_model->source_pic_url = $source_pic_url;
			$this->user_model->pic_url = $pic_url;
	        $this->user_model->updatePic($user['id'],$pic_url,$source_pic_url);
	        echo 'updated '.$user['id'];
		endforeach; 
	}
	
	public function updateGroup()
	{
		$this->load->model('group_model');
		$group_list = $this->group_model->find_groups(array(), 100, 0);
		foreach($group_list as $group): 
			$pic_url = str_replace('awayeffect.com','effecthub.com',$group["group_pic"]);
			$this->group_model->group_pic = $pic_url;
	        $this->group_model->updatePic($group['id']);
	        echo 'updated '.$group['id'];
		endforeach; 
	}
	
	public function updateStatus()
	{
		$this->load->model('user_status_model');
		$status_list = $this->user_status_model->find_status(array(), 1200, 0);
		foreach($status_list as $status): 
			$content = str_replace('awayeffect.com','effecthub.com',$status["content"]);
			$this->user_status_model->content = $content;
			$this->user_status_model->timestamp = $status['timestamp'];
	        $this->user_status_model->updateStatus($status['id']);
	        echo 'updated '.$status['id'];
		endforeach; 
	}
	
	public function updateNotice()
	{
		$this->load->model('user_notice_model');
		$notice_list = $this->user_notice_model->find_all_notice(array(), 850, 0);
		foreach($notice_list as $notice): 
			$content = str_replace('awayeffect.com','effecthub.com',$notice["content"]);
			$this->user_notice_model->content = $content;
			$this->user_notice_model->timestamp = $notice['timestamp'];
	        $this->user_notice_model->updateNotice($notice['id']);
	        echo 'updated '.$notice['id'];
		endforeach; 
	}
	*/
	
	public function none()
	{
		$this->load->view('item/item_none');
	}
	
	public function forbidden($id=0)
	{
		$this->load->model('item_model');
		$data = array();
		if($id!=0){
			$data['item'] = $this->item_model->load($id);
		}
		$this->load->view('item/item_private',$data);
	}
	
	public function password($item_id,$msg='')
	{
		$data['msg'] = $msg;
		$data['item_id'] = $item_id;
		$this->load->view('item/item_password',$data);
	}
	
	public function index($id=0)
	{
		$this->load->model('item_model');
        $data = array();
        $data['nav']= 'works';
        if($this->session->userdata('language')) {
			$lang = $this->session->userdata('language');
			$data['lang']= $lang;
		}else{
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
	        if (preg_match("/zh-c/i", $lang)||$lang=='cn')
	        {
	        	$data['lang']= '2';
	        }else{
	        	$data['lang']= '1';
	        }
		}
        if($id!=null&&$id!=0){
        	$data['item'] = $this->item_model->load($id);
        	if($data['item']==null){
	   			redirect('item/none');
				exit();
	   		}else{
	   			if($data['item']['is_private']==1&&($this->session->userdata('id')!=$data['item']['author_id'])){
		   			redirect('item/forbidden/'.$id);
					exit();
		   		}else if($data['item']['password']&&($this->session->userdata('id')!=$data['item']['author_id'])){
		   			if($data['item']['password']==$this->input->post('password')){
		   			
		   			}else{
		   				if($this->input->post('password')){
				   			redirect('item/password/'.$id.'/invalid');
							exit();
		   				}else{
		   					redirect('item/password/'.$id);
							exit();
		   				}
		   			}
	   			}else{
	   				$this->session->set_userdata('redirectURL',site_url('item/'.$data['item']['id']));
	   			}
	   		}
        	if($data['item']['tags']!=''){
        		$data['tags'] = explode(" ",$data['item']['tags']);
        	}else{
        		$data['tags'] = array();
        	}
        	parse_str($_SERVER['QUERY_STRING'], $_GET);
			$data['list'] = $this->input->get('tool');
			
			$data['prev'] = $this->item_model->find_items(array('orderby'=>'id desc','prev'=>$data['item']['id'],'tool'=>$data['item']['tool'],'folder_id'=>0,'work_id'=>0),1,0);
			$data['next'] = $this->item_model->find_items(array('orderby'=>'id asc','next'=>$data['item']['id'],'tool'=>$data['item']['tool'],'folder_id'=>0,'work_id'=>0),1,0);
			
        	$data['parent'] = $this->item_model->load($data['item']['parent_id']);
        	$data['work'] = $this->item_model->load($data['item']['work_id']);
	        $data['work_file_list'] = $this->item_model->find_items(array('work_id'=>$data['item']['id']), 100, 0);
        	$this->load->model('tool_model');
        	$data['tool'] = $this->tool_model->load($data['item']['tool']);
        	$this->load->model('group_model');
        	if($data['tool'])
        	$data['group'] = $this->group_model->load($data['tool']['group_id']);
        	$data['title'] = $data['item']['title'].': '.$data['item']['desc'];
        	$data['tool_item_list'] = $this->item_model->find_items(array('rand'=>'1','folder_id'=>0,'work_id'=>0,'notin'=>$id,'tool'=>$data['item']['tool']), 2, 0);
        	$data['user_item_list'] = $this->item_model->find_items(array('folder_id'=>0,'work_id'=>0,'user'=>$data['item']['author_id']), 4, 0);
        	if(count($data['tool_item_list'])<2)
        	$data['tool_item_list'] = $this->item_model->find_items(array('rand'=>'1','folder_id'=>0,'work_id'=>0), 2, 0);
        	if($data['item']['folder_id']>0)
        	$data['tool_item_list'] = $this->item_model->find_items(array('rand'=>'1','folder_id'=>$data['item']['folder_id'],'work_id'=>0), 2, 0);
        	if($data['list']&&($data['prev']||$data['next'])){
        		$data['id_list'] = array();
        		if($data['prev'])array_push($data['id_list'],$data['prev'][0]['id']);
        		if($data['next'])array_push($data['id_list'],$data['next'][0]['id']);
        		$data['tool_item_list'] = $this->item_model->find_items(array('order'=>'id','is_private'=>'0','in'=>$data['id_list'],'folder_id'=>0,'work_id'=>0,'notin'=>$id,'tool'=>$data['item']['tool']), 2, 0);
        	}
        	$data['fork_list'] = $this->item_model->find_items(array('folder_id'=>0,'work_id'=>0,'parent_id'=>$data['item']['id']), 100, 0);
        	$this->load->model('item_comment_model');
        	$this->load->model('item_fav_model');
        	$this->load->model('item_download_model');
        	$data['item_comment_list'] = $this->item_comment_model->find_item_comments(array('item'=>$data['item']['id']), 10, 0);
        	$data['item_fav_list'] = $this->item_fav_model->loadByItem($data['item']['id']);
        	$data['item_download_list'] = $this->item_download_model->loadByItem($data['item']['id']);
        	$data['comments_num'] = $this->item_comment_model->count_item_comments(array('item'=>$data['item']['id']));
        	if ($data['comments_num'] <= 10) {
        		$data['more_comments'] = 0;
        	} else {
        		$data['more_comments'] = 1;
        	}
        	$this->load->model('item_fav_model');
        	$this->load->model('user_watch_model');
        	if ($this->session->userdata('id')!=null){
	   			$data['fav'] = $this->item_fav_model->loadByUserAndFav($this->session->userdata('id'),$id);
	   			$data['watch'] = $this->user_watch_model->loadByUserAndWatch($this->session->userdata('id'),$id);
	   			$data['download'] = $this->item_download_model->loadByUserAndDownload($this->session->userdata('id'),$id);
	   			$this->load->model('user_social_model');
				$data['social_list'] = $this->user_social_model->loadByUser($this->session->userdata('id'));
	   		}
	   		
	        	if ($this->session->userdata('id')!=$data['item']['author_id']) {
	        		$this->item_model->view_num = $data['item']['view_num']+1;
	        		$this->item_model->updateViewNum($id);
	        	}
	        	
	        /**
	         *
	         * add collection function
	         */
	        $this->load->model('collection_model','collect');
	        $data['my_collections'] = $this->collect->find_collections(array('user'=>($this->session->userdata('id')),'order'=>'update_date'),0,0);

	        	
	        $this->load->model('collection_work_model','cwork');
	        //the collections of mine which owns this work already
	        $data['work_in_my_collection'] = $this->cwork->find_works(array('work_id'=>$id,'owner_id'=>$this->session->userdata('id')),0,0);

	        // all collections that owns this work
	        $data['in_collections'] = $this->cwork->find_works(array('work_id'=>$id,'order'=>'like_num'),2,4,0);
	        
	        $this->load->model('item_history_model');
	        $data['item_history'] = $this->item_history_model->loadbyitem($id);
        }else{
        	
        }
        $from = $data['item']['from'];
       /* if($from=='particle'||$from=='dragonbones'||$from=='sea3d'||$from=='htmleditor'||$from=='aseditor'||
        ($data['item']['type']==12&&$data['item']['platform']=='2')||
        ($data['item']['type']==12&&$data['item']['platform']=='1')||
        ($data['item']['type']==2&&$data['item']['extension']=='zip')||
        $data['item']['preview_url']!=0){
			$this->load->view('item/item',$data);
        }else{
        	$this->load->view('item/item_pic',$data);
        }*/
        $this->load->view('item/item_pic',$data);
	}
	
	public function create()
	{
		$this->load->model('item_model');
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$this->load->view('item/item_create',$data);
	}
	
	public function saveparticle2dx()
	{
		if ($this->session->userdata('id')==null){          		
			echo 0;
			exit();
		}
		$id = $this->input->post('id');
		$oldid = $id;
		$filename = $this->input->post('png_filename');
		$plist_xml = rawurldecode($this->input->post('plist_xml'));
		$plist_xml=str_replace('&lt;','<',$plist_xml);
		$plist_xml=str_replace('&gt;','>',$plist_xml);
		$plist_xml=str_replace('plist versi','plist',$plist_xml);
		$input = $plist_xml;
		$data = $input;
		$ext = 'plist';
		$price = $this->input->post('price');
		$price_type = $this->input->post('price_type');
		if(!$price)$price=0;
		if(!$price_type)$price_type=1;
		
		$this->load->model('user_status_model','u_status');		
		$this->u_status->status_type = 2;
        $this->u_status->user_id = $this->session->userdata('id');
		
		$this->load->helper('my_form');
		$this->load->model('item_model');
		if($id!=null&&$id!=''&&$id!=0){
			$item = $this->item_model->load($id);
			//fork item
			if($item['author_id']!=$this->session->userdata('id')){
				$this->item_model->parent_id = $id;
				$this->item_model->author_id = $this->session->userdata('id');
				$this->item_model->title = $filename;
				$this->item_model->desc = '';
				$this->item_model->tags = '';
				$this->item_model->price_type = $price_type;
				$this->item_model->price = $price;
				$this->item_model->share = 0;
				$this->item_model->preview_url = 0;
				$this->item_model->download_url = 0;
				$this->item_model->type = 1;
				$this->item_model->platform = 0;
				$this->item_model->from = 'particle2dx';
				$this->item_model->extension = $ext;
				$this->item_model->is_private = 0;
				$this->item_model->contest_id = 0;
				$this->item_model->tool = 94;
		        $this->item_model->create();
				$id = $this->db->insert_id();
				
				
				
				$user_id = $this->session->userdata('id');
				$this->load->model('user_model');
				$user = $this->user_model->load($user_id);
				
				$this->load->model('user_notice_model');
				if($this->item_model->parent_id!=null&&$this->item_model->parent_id!='0'){
					$parent_item = $this->item_model->load($this->item_model->parent_id);
			        $this->user_notice_model->user_id = $parent_item['author_id'];
			    	$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> forked your work <a href='".site_url('item/'.$parent_item['id'])."'>".$parent_item['title']."</a>";
					$this->user_notice_model->insertData();
					
					$this->load->model('email_model');
		            $author = $this->user_model->load($parent_item['author_id']);
		            $title = $this->session->userdata('displayName').' forked your work '.$parent_item['title'].' on EffectHub.com';
		            $content = $this->user_notice_model->content;
					$this->email_model->send_notification($author['email'],$title,$content);
					
					$user_point = $user['point'] + 10;
					$this->user_model->update_point($user_id,$user_point);
				}
				
		
			}
		}else{
			$this->item_model->author_id = $this->session->userdata('id');
			$this->item_model->title = $filename;
			$this->item_model->desc = '';
			$this->item_model->tags = '';
			$this->item_model->price_type = $price_type;
			$this->item_model->price = $price;
			$this->item_model->share = 0;
			$this->item_model->preview_url = 0;
			$this->item_model->download_url = 0;
			$this->item_model->type = 1;
			$this->item_model->platform = 0;
			$this->item_model->from = 'particle2dx';
			$this->item_model->extension = $ext;
			$this->item_model->is_private = 0;
			$this->item_model->contest_id = 0;
			$this->item_model->tool = 94;
	        $this->item_model->create();
			$id = $this->db->insert_id();
		}
		
		$img = $this->input->post('pic');
		$img=str_replace('[removed]','',$img);
		$img=str_replace('data:image/png;base64,','',$img);
		 
		//echo base64_decode($img);
		$pic_dir = 'item';
		$pdir = UploadPath($pic_dir);
		$pic_file_name=$pdir.'/'.$id.'.jpg';
		@file_put_contents($pic_file_name, base64_decode($img));
		$pic_path = base_url().'uploads/'.$pic_dir.'/'.$id.'.jpg';

		if($pic_path!=''&&$pic_path!=null){
    		$this->item_model->pic_url = $pic_path;
    		$this->item_model->thumb_url = $pic_path;
	    	$this->item_model->updatePic($id);
	    	$this->u_status->pic_url = $pic_path;
    	}
    	
    	if($this->item_model->parent_id!=null&&$this->item_model->parent_id!='0'){
    		$this->u_status->status_type = 18;
	        $this->u_status->target_id = $id;
	        $this->u_status->target_name = $this->item_model->title;
			$this->u_status->insertData();
		}else{
			if($oldid!=null&&$oldid!=''&&$oldid!=0){
				
			}else{
				$this->u_status->target_id = $id;
		        $this->u_status->target_name = $this->item_model->title;
				$this->u_status->insertData();
			}
		}
		
		$attach_id = create_guid();
		$upload_dir = 'attachment';
		$dir = UploadPath($upload_dir);
		$file_name=$dir.'/'.$attach_id.'.'.$ext;

		@file_put_contents($file_name, $data);
		$attachment_path = base_url().'uploads/'.$upload_dir.'/'.$attach_id.'.'.$ext;
		$realpath = str_replace("http://www.effecthub.com",$_SERVER['DOCUMENT_ROOT'],$attachment_path);
		$realpath = str_replace('\\', '/', $realpath);
		$size = filesize($realpath);
		$this->item_model->size = $size;
		$this->item_model->download_url = $attachment_path;
    	$this->item_model->updateAttach($id);
    	
    	//redirect(site_url('item/'.$id));
    	echo $id;
	}
	
	public function particle2dx()
	{
		if($this->session->userdata('language')) {
			$lang = $this->session->userdata('language');
			$data['lang']= $lang;
		}else{
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
	        if (preg_match("/zh-c/i", $lang)||$lang=='cn')
	        {
	        	$data['lang']= '2';
	        }else{
	        	$data['lang']= '1';
	        }
		}
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$id = $this->input->get('id');
		$uid = $this->session->userdata('id');
		if($id==null)$id=0;
		if($uid==null)$uid=0;
		if($data['lang']== '2'){
			$data['editor'] = base_url().'editor/particle2dx/index_cn.php?id='.$id.'&uid='.$uid;
			$data['title'] = 'EffectHub Cocos2dx粒子特效编辑器';
		}else{
			$data['editor'] = base_url().'editor/particle2dx/index_en.php?id='.$id.'&uid='.$uid;
			$data['title'] = 'EffectHub Cocos2dx Particle Effect Editor';
		}
		$this->load->view('editor/particle2dx',$data);
	}
	
	public function upload()
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		if($this->session->userdata('language')) {
			$lang = $this->session->userdata('language');
			$data['lang']= $lang;
		}else{
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
	        if (preg_match("/zh-c/i", $lang)||$lang=='cn')
	        {
	        	$data['lang']= '2';
	        }else{
	        	$data['lang']= '1';
	        }
		}
		$this->load->model('item_model');
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1), 100, 0);
		$this->load->model('tool_model');
		$data['tool_list'] = $this->tool_model->find_tools(array(), 100, 0);
		$this->load->model('platform_model');
		$data['platform_list'] = $this->platform_model->find_platforms(array(), 100, 0);
		$this->load->model('user_social_model');
		$data['social_list'] = $this->user_social_model->loadByUser($this->session->userdata('id'));
		$this->load->view('item/item_upload',$data);
	}
	
	public function share()
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		if($this->session->userdata('language')) {
			$lang = $this->session->userdata('language');
			$data['lang']= $lang;
		}else{
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
	        if (preg_match("/zh-c/i", $lang)||$lang=='cn')
	        {
	        	$data['lang']= '2';
	        }else{
	        	$data['lang']= '1';
	        }
		}
		$url = $this->input->get('share_url');
		if($url!=null&&$url!=''){
			$text=file_get_contents($url);
			preg_match('/<title>([^<>]*)<\/title>/', $text, $title);
			$data['item'] = array(
						   'url'  => $url,
						   'title'  => $title?$title[1]:''
			);
		}
		$this->load->model('item_model');
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1), 100, 0);
		$this->load->model('tool_model');
		$data['tool_list'] = $this->tool_model->find_tools(array(), 100, 0);
		$this->load->model('platform_model');
		$data['platform_list'] = $this->platform_model->find_platforms(array(), 100, 0);
		$this->load->model('user_social_model');
		$data['social_list'] = $this->user_social_model->loadByUser($this->session->userdata('id'));
		$this->load->view('item/item_share',$data);
	}
	
	public function preview($id)
	{
		
		$this->load->model('item_model');
		$data['item'] = $this->item_model->load($id);
		
	        if ($this->session->userdata('id')!=$data['item']['author_id']){
		        $this->item_model->view_num = $data['item']['view_num']+1;
		        $this->item_model->updateViewNum($id);
	        }
		$data['is_embed'] = 1;
		$this->load->model('item_code_model');
		$data['item_code'] = $this->item_code_model->loadbyitem($id);
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$this->load->view('item/item_preview',$data);
	}	
	
	public function embed($id)
	{
		$this->load->model('item_model');
		$data['item'] = $this->item_model->load($id);
		
	        if ($this->session->userdata('id')!=$data['item']['author_id']){
		        $this->item_model->view_num = $data['item']['view_num']+1;
		        $this->item_model->updateViewNum($id);
	        }
		$this->load->model('item_code_model');
		$data['item_code'] = $this->item_code_model->loadbyitem($id);
		$data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$this->load->view('item/item_preview',$data);
	}
	
	public function preview_html($id)
	{
		$this->load->model('item_model');
		$this->load->model('item_code_model');
		$data['item'] = $this->item_model->load($id);
		$data['item_code'] = $this->item_code_model->loadbyitem($id);
		$this->load->view('item/item_preview_html',$data);
	}
	public function preview_folder($id)
	{
		
	}
	
	public function fullscreen($id)
	{
		$this->load->model('item_model');
		$data['item'] = $this->item_model->load($id);
		$this->load->view('item/item_fullscreen',$data);
	}
	
	public function history_preview($id)
	{
		$this->load->model('item_history_model');
		$data['item_history'] = $this->item_history_model->load($id);
		$this->load->model('item_model');
		$data['item'] = $this->item_model->load($data['item_history']['item_id']);
		$this->load->view('item/item_history_preview',$data);
	}
	
	public function new_content($type)
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		if($this->session->userdata('language')) {
			$lang = $this->session->userdata('language');
			$data['lang']= $lang;
		}else{
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
	        if (preg_match("/zh-c/i", $lang)||$lang=='cn')
	        {
	        	$data['lang']= '2';
	        }else{
	        	$data['lang']= '1';
	        }
		}
		if($type=='particle2dx'){
			if($data['lang']== '1'){
				redirect('http://www.effecthub.com/editor/particle2dx/index.php');
			}else{
				redirect('http://www.effecthub.com/editor/particle2dx/index_cn.php');
			}
		}
		$user_id = $this->session->userdata('id');
		$this->load->model('user_model');
		$user = $this->user_model->load($user_id);
		$data['type'] = $type;
		$data['user'] = $user;
		if($type=='aseditor'){
	        $id = create_guid();
	        $data['src']['id']=$id;
	        $data['src']['code']='';
		}
		
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1), 100, 0);
		
		$this->load->model('item_model');
		$data['recommend'] = $this->item_model->recommend_items(array('from'=>'particle'),5);
			
		
		$this->load->view('item/item_new_content',$data);
	}
	
	public function edit_content($item_id)
	{
		if (!$this->session->userdata('id')){          		
			redirect('login');
			exit();
		}
		if($this->session->userdata('language')) {
			$lang = $this->session->userdata('language');
			$data['lang']= $lang;
		}else{
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
	        if (preg_match("/zh-c/i", $lang)||$lang=='cn')
	        {
	        	$data['lang']= '2';
	        }else{
	        	$data['lang']= '1';
	        }
		}
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1), 100, 0);
		$this->load->model('item_model');
		$item = $this->item_model->load($item_id);
		$this->load->model('item_code_model');
		$data['item_code'] = $this->item_code_model->loadbyitem($item_id);
		$this->load->model('item_file_model');
		$data['item_file_list'] = $this->item_file_model->loadbyitem($item_id);
		$user_id = $this->session->userdata('id');
		$this->load->model('user_model');
		$user = $this->user_model->load($user_id);
		$author = $this->user_model->load($item['author_id']);
		if($user_id==$item['author_id']){
			$data['item'] = $item;
			$data['user'] = $user;
			if($item['from']=='aseditor')
			$data['src']['id']=$data['item_code']['item_key'];
			
			$this->load->model('item_model');
			$data['recommend'] = $this->item_model->recommend_items(array('from'=>'particle'),5);
			
			
			$this->load->view('item/item_edit_content',$data);
		}
	}
	
	public function fork($item_id,$price=0)
	{
		if($this->session->userdata('language')) {
			$lang = $this->session->userdata('language');
			$data['lang']= $lang;
		}else{
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
	        if (preg_match("/zh-c/i", $lang)||$lang=='cn')
	        {
	        	$data['lang']= '2';
	        }else{
	        	$data['lang']= '1';
	        }
		}
		$this->load->model('item_model');
		$item = $this->item_model->load($item_id);
		if($item['is_private']==1&&($this->session->userdata('id')!=$item['author_id'])){
   			redirect('item/forbidden/'.$item_id);
			exit();
   		}
   		if($item['contest_id']>1){
   			redirect('item/'.$item_id);
			exit();
   		}
		$this->load->model('item_code_model');
		$data['item_code'] = $this->item_code_model->loadbyitem($item_id);
		
		$this->load->model('item_file_model');
		$data['item_file_list'] = $this->item_file_model->loadbyitem($item_id);
		
		$this->load->model('item_model');
		$data['recommend'] = $this->item_model->recommend_items(array('from'=>'particle'),5);
		
		
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1), 100, 0);
		
		if($item['from']=='particle2dx'){   
				redirect('particle2dx?id='.$item['id']);			
		}
		if (!$this->session->userdata('id')){
			if($item['from']=='aseditor'||$item['from']=='htmleditor'){
				        $id = create_guid();
				        $data['src']['id']=$id;
				        $data['src']['code']='';
					
						$data['item'] = $item;
						$this->load->view('item/item_fork',$data);
			}else{       		
				redirect('login');
				exit();
			}
		}else{
		$user_id = $this->session->userdata('id');
		$this->load->model('user_model');
		$user = $this->user_model->load($user_id);
		$author = $this->user_model->load($item['author_id']);
		if($user_id==$item['author_id']){
			redirect(site_url('item/edit_content/'.$item_id)); 
			}else{
			$this->load->model('item_download_model');
			$download = $this->item_download_model->loadByUserAndDownload($this->session->userdata('id'),$item_id);
			$data['download'] =$download;
			if(!$download){
				$enough = 0;
				if($item['price_type']==1){
					if($user['point']>=$item['price']){
						$enough = 1;
						$user_point = $user['point'] - $item['price'];
						$this->user_model->update_point($user_id,$user_point);
						$author_point = $author['point'] + $item['price'];
						$this->user_model->update_point($item['author_id'],$author_point);
					}
				}else if($item['price_type']==2){
					if(($user['balance']+$user['balance_usd']*6)>=$item['price']){
						$enough = 1;
						$payusd = $item['price'] - $user['balance'];
						if($payusd>=0){
							$this->user_model->update_balanceusd($user_id,$user['balance_usd']-$payusd/6);
							$this->user_model->update_balance($user_id,0);
						}else{
							$this->user_model->update_balance($user_id,$user['balance'] - $item['price']);
						}
						
						$author_rmb = $author['balance'] + $item['price'];
						$this->user_model->update_balance($item['author_id'],$author_rmb);
					}
				}else if($item['price_type']==3){
					if(($user['balance']+$user['balance_usd']*6)>=$item['price']*6){
						$enough = 1;
						$payrmb = ($item['price'] - $user['balance_usd'])*6;
						if($payrmb>=0){
							$this->user_model->update_balance($user_id,$user['balance']-$payrmb);
							$this->user_model->update_balanceusd($user_id,0);
						}else{
							$this->user_model->update_balanceusd($user_id,$user['balance_usd'] - $item['price']);
						}
						
						$author_usd = $author['balance_usd'] + $item['price'];
						$this->user_model->update_balanceusd($item['author_id'],$author_usd);
					}
				}
				$user = $this->user_model->load($user_id);
	        	$this->session->set_userdata('point',$user['point']);
	        	$this->session->set_userdata('balance',$user['balance']);
	        	$this->session->set_userdata('balance_usd',$user['balance_usd']);
				if($enough==1){
			        $this->item_download_model->user_id = $this->session->userdata('id');
			    	$this->item_download_model->item_id = $item_id;
			    	$this->item_download_model->price_type = $item['price_type'];
			    	$this->item_download_model->price = $item['price'];
					$this->item_download_model->create();
					
					$this->load->model('item_model');
				    $item = $this->item_model->load($item_id);
				    $this->item_model->download_num = $item['download_num'] + 1;
				    $this->item_model->updateDownloadNum($item_id);
					
					if($item['from']=='aseditor'){
				        $id = create_guid();
				        $data['src']['id']=$id;
				        $data['src']['code']='';
					}
					
					$data['item'] = $item;
					$data['user'] = $user;
					$data['price'] = $price;
					$this->load->view('item/item_fork',$data);
					
				}else{
					echo "<script>alert('No enough coins. You can upload works or leave comments to earn coins:)');window.close();</script>";
				}
			}else{
				if($item['from']=='aseditor'){
			        $id = create_guid();
			        $data['src']['id']=$id;
			        $data['src']['code']='';
				}
				$data['item'] = $item;
				$data['user'] = $user;
				$this->load->view('item/item_fork',$data);
			}
		}
		}
	}
	
	public function download($item_id)
	{
		if (!$this->session->userdata('id')){          		
			redirect('login?redirectURL='.site_url('item/download/'.$item_id));
			exit();
		}
		$this->load->model('item_model');
		$item = $this->item_model->load($item_id);
		if($item['is_private']==1&&($this->session->userdata('id')!=$item['author_id'])){
   			redirect('item/forbidden/'.$item_id);
			exit();
   		}
   		/*if($item['contest_id']>1){
   			$this->load->model('item_model');
		    $item = $this->item_model->load($item_id);
		    $this->item_model->download_num = $item['download_num'] + 1;
		    $this->item_model->updateDownloadNum($item_id);
   			redirect($item['download_url']);
			exit();
   		}*/
   		
		$user_id = $this->session->userdata('id');
		$this->load->model('user_model');
		$user = $this->user_model->load($user_id);
		$author = $this->user_model->load($item['author_id']);
		if($user_id==$item['author_id']){
			if($item['is_share']==0){
				header('Content-Disposition: attachment; filename="'.basename($item['download_url']).'"');
				readfile($item['download_url']);
			}else{
				redirect($item['download_url']);
			}
		}else{
				$this->load->model('item_download_model');
				$download = $this->item_download_model->loadByUserAndDownload($this->session->userdata('id'),$item_id);
				if(!$download){
					$enough = 0;
					if($item['price_type']==1){
						if($user['point']>=$item['price']){
							$enough = 1;
							$user_point = $user['point'] - $item['price'];
							$this->user_model->update_point($user_id,$user_point);
							$author_point = $author['point'] + $item['price'];
							$this->user_model->update_point($item['author_id'],$author_point);
						}
					}else if($item['price_type']==2){
						if(($user['balance']+$user['balance_usd']*6)>=$item['price']){
							$enough = 1;
							$payusd = $item['price'] - $user['balance'];
							if($payusd>=0){
								$this->user_model->update_balanceusd($user_id,$user['balance_usd']-$payusd/6);
								$this->user_model->update_balance($user_id,0);
							}else{
								$this->user_model->update_balance($user_id,$user['balance'] - $item['price']);
							}
							
							$author_rmb = $author['balance'] + $item['price'];
							$this->user_model->update_balance($item['author_id'],$author_rmb);
						}
					}else if($item['price_type']==3){
						if(($user['balance']+$user['balance_usd']*6)>=$item['price']*6){
							$enough = 1;
							$payrmb = ($item['price'] - $user['balance_usd'])*6;
							if($payrmb>=0){
								$this->user_model->update_balance($user_id,$user['balance']-$payrmb);
								$this->user_model->update_balanceusd($user_id,0);
							}else{
								$this->user_model->update_balanceusd($user_id,$user['balance_usd'] - $item['price']);
							}
							
							$author_usd = $author['balance_usd'] + $item['price'];
							$this->user_model->update_balanceusd($item['author_id'],$author_usd);
						}
					}
					
					$user = $this->user_model->load($user_id);
		        	$this->session->set_userdata('point',$user['point']);
		        	$this->session->set_userdata('balance',$user['balance']);
		        	$this->session->set_userdata('balance_usd',$user['balance_usd']);
					if($enough==1){
						if($item['price_type']==2||$item['price_type']==3){
							$this->load->model('user_notice_model');	
					        $this->user_notice_model->user_id = $item['author_id'];
					    	$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> bought your work <a href='".site_url('item/'.$item['id'])."'>".$item['title']."</a>";
							$this->user_notice_model->insertData();
							
							$this->load->model('email_model');
					        $user = $this->user_model->load($item['author_id']);
					        $title = $this->session->userdata('displayName').' bought your work '.$item['title'].' on EffectHub.com';
					        $content = $this->user_notice_model->content;
							$this->email_model->send_notification($user['email'],$title,$content);
						}
					
				        $this->item_download_model->user_id = $this->session->userdata('id');
				    	$this->item_download_model->item_id = $item_id;
				    	$this->item_download_model->price_type = $item['price_type'];
				    	$this->item_download_model->price = $item['price'];
						$this->item_download_model->create();
						
						$this->load->model('item_model');
					    $item = $this->item_model->load($item_id);
					    $this->item_model->download_num = $item['download_num'] + 1;
					    $this->item_model->updateDownloadNum($item_id);
						if($item['is_share']==0){
							header('Content-Disposition: attachment; filename="'.basename($item['download_url']).'"');
							readfile($item['download_url']);
						}else{
							redirect($item['download_url']);
						}
					}else{
						echo "<script>alert('No enough coins. You can upload works or leave comments to earn coins:)');window.close();</script>";
					}
				}else{
					if($item['is_share']==0){
						header('Content-Disposition: attachment; filename="'.basename($item['download_url']).'"');
						readfile($item['download_url']);
					}else{
						redirect($item['download_url']);
					}
				}
		}
	}
	
	function like($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->model('item_fav_model');
		
        $this->item_fav_model->user_id = $this->session->userdata('id');
    	$this->item_fav_model->item_id = $id;
		$this->item_fav_model->create();
		$this->load->model('item_model');
	    $item = $this->item_model->load($id);
	    $this->item_model->fav_num = $item['fav_num'] + 1;
	    $this->item_model->updateFavNum($id);
		echo $this->lang->line('item_unlike');
		
		$this->load->model('user_status_model','u_status');	
        $this->u_status->user_id = $this->session->userdata('id');
    	//$this->user_status_model->content = "  <a href='".site_url('item/'.$id)."'>".$item['title']."</a>";
		//$this->user_status_model->action = "liked the work";
    	if($item['thumb_url']!=''&&$item['thumb_url']!=null){
			$this->u_status->pic_url = $item['thumb_url'];
    	}
    	$this->u_status->target_id = $id;
		$this->u_status->status_type = 6;
		$this->u_status->target_name = $item['title'];
		$this->u_status->insertData();
		
		$this->load->model('user_notice_model');	
        $this->user_notice_model->user_id = $item['author_id'];
    	$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> liked your work <a href='".site_url('item/'.$id)."'>".$item['title']."</a>";
		$this->user_notice_model->insertData();
		
		$this->load->model('email_model');
		$this->load->model('user_model');
        $user = $this->user_model->load($item['author_id']);
        $title = $this->session->userdata('displayName').' liked your work '.$item['title'].' on EffectHub.com';
        $content = $this->user_notice_model->content;
		$this->email_model->send_notification($user['email'],$title,$content);
	}
	
	function unlike($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		
		$this->load->model('item_fav_model');
		
		$data['fav'] = $this->item_fav_model->loadByUserAndFav($this->session->userdata('id'),$id);
		if($data['fav']){
		$this->item_fav_model->delete($this->session->userdata('id'),$id);
		$this->load->model('item_model');
	    $item = $this->item_model->load($id);
	    $this->item_model->fav_num = $item['fav_num'] - 1;
	    $this->item_model->updateFavNum($id);
		}
		echo $this->lang->line('item_like');
		
		/*$this->load->model('user_status_model');	
        $this->user_status_model->user_id = $this->session->userdata('id');
    	$this->user_status_model->content = "unliked the work  <a href='".site_url('item/'.$id)."'>".$item['title']."</a>";
		$this->user_status_model->insertData();*/
	}	  		
	
	function watch($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->model('user_watch_model');
		
        $this->user_watch_model->user_id = $this->session->userdata('id');
    	$this->user_watch_model->item_id = $id;
    	$this->user_watch_model->is_folder = 0;
		$this->user_watch_model->create();
		$this->load->model('item_model');
	    $item = $this->item_model->load($id);
	    $this->item_model->watch_num = $item['watch_num'] + 1;
	    $this->item_model->updateWatchNum($id);
		echo $this->lang->line('item_unwatch');
	}
	
	function unwatch($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->model('user_watch_model');
		$this->user_watch_model->delete($this->session->userdata('id'),$id,0);
		$this->load->model('item_model');
	    $item = $this->item_model->load($id);
	    $this->item_model->watch_num = $item['watch_num'] - 1;
	    $this->item_model->updateWatchNum($id);
		echo $this->lang->line('item_watch');
	}	
	
	public function savecomment()
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		
		$this->load->model('user_model');
		
        $this->load->helper('my_form');
		$id = $this->input->post('item_id');
		$this->load->model('item_comment_model');
		$this->item_comment_model->author_id = $this->session->userdata('id');
		$this->item_comment_model->item_id = $this->input->post('item_id');
		$this->item_comment_model->parent_id = $this->input->post('parent_id');
        
		$comment = $this->item_comment_model->load($this->input->post('parent_id'));
		if ($comment) {
			$parent_user = $this->user_model->load($comment['user_id']);
		}
		$this->item_comment_model->content = htmlspecialchars($this->input->post('content'));
        $this->item_comment_model->create();
        $new_comment = $this->db->insert_id();
        $this->load->model('item_model');
        $item = $this->item_model->load($id);
        $this->item_model->comment_num = $item['comment_num']+1;
        $this->item_model->updateCommentNum($id);
        
        $this->load->model('user_status_model','u_status');	
        $this->u_status->user_id = $this->session->userdata('id');
    	//$this->user_status_model->content = "commented the work  <a href='".site_url('item/'.$id)."'>".$item['title']."</a>\n comment content: ".$content;
		//$this->user_status_model->action = "commented the work";
		if($item['thumb_url']!=''&&$item['thumb_url']!=null){
			$this->u_status->pic_url = $item['thumb_url'];
    	}
    	$this->u_status->target_id = $id;
    	$this->u_status->target_name = $item['title'];
    	$this->u_status->status_type = 5;
    	$this->u_status->content_id = $new_comment;
		$this->u_status->insertData();
		
		$this->load->model('user_notice_model');	
		if($item['author_id']!=$this->session->userdata('id')){
	        $this->user_notice_model->user_id = $item['author_id'];
	    	$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> commented your work <a href='".site_url('item/'.$id)."'>".$item['title']."</a>";
			$this->user_notice_model->insertData();
			/*
			$this->load->model('email_model');
            $user = $this->user_model->load($item['author_id']);
            $title = $this->session->userdata('displayName').' commented your work '.$item['title'].' on EffectHub.com';
            $content = $this->user_notice_model->content;
			$this->email_model->send_notification($user['email'],$title,$content);
			*/
		}
		if($comment){
			$this->user_notice_model->user_id = $comment['author_id'];
	    	$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> replyed your comment in <a href='".site_url('item/'.$id)."'>".$item['title']."</a>";
			$this->user_notice_model->insertData();
			/*
			$this->load->model('email_model');
            $user = $this->user_model->load($comment['author_id']);
            $title = $this->session->userdata('displayName').' replyed your comment in '.$item['title'].' on EffectHub.com';
            $content = $this->user_notice_model->content;
			$this->email_model->send_notification($user['email'],$title,$content);
			*/
		}
		
		
		
		$userid =$this->session->userdata('id');
	    
		$this->load->model('user_model');
		$user = $this->user_model->load($userid);
		$user_point = $user['point'] + 1;
		$this->user_model->update_point($userid,$user_point);
		
		$cookie = array(
				'name'   => 'new_comment',
				'value'  => 1,
				'expire' => '300',
		);
		set_cookie($cookie);
		
		/*$output = "<div class='commentitem'>
                            <div class='commentimg'>
                                <a href='".site_url('user/'.$userid)."'><img width='50px' src='".$user['pic_url']."'></a>
                            </div>
                            <div>
                                <div class='paragraphstyle'><b><a href='".site_url('user/'.$userid)."'>".$user['displayName']."</a></b>". tranTime(strtotime($datetime)). "</div>
                                <div class='commenttext'>".$_GET['content']."</div>
                            </div>
                   </div>";*/
		 	
        //redirect(site_url('item/'.$id)); 
	}	
	
	public function social($type)
	{
		
        $this->load->helper('my_form');
		$id = $this->input->post('item_id');
		if($type=='sina'){
			$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $this->input->post('token_sina'));
			$ret_sina = $c->update('I uploaded my works on EffectHub.com just now: '.$this->input->post('title').'——'.msubstr($this->input->post('desc'),0,80).' '.site_url('item/'.$id));
			if ( isset($ret_sina['error_code']) && $ret_sina['error_code'] > 0 ) {
				echo 'error'.$ret_sina['error_code'];
			}else{
				echo $ret_sina['id'];
			}
		}
		if($type=='twitter'){
			$api = new Twitter( TT_AKEY , TT_SKEY );
			$api->setOAuthToken($this->input->post('token_twitter'));
			$api->setOAuthTokenSecret($this->input->post('token_secret_twitter'));
			$api->statusesUpdate('I uploaded my works on EffectHub.com just now: '.$this->input->post('title').'——'.msubstr($this->input->post('desc'),0,80).' '.site_url('item/'.$id));
		}
		if($type=='facebook'){
			$api = new Facebook(array());
			$api->setAccessToken($this->input->post('token_facebook'));
			$api->api('/me/feed', 'POST',
                                array(
                                  'link' => site_url('item/'.$id),
                                  'message' => 'I uploaded my works on EffectHub.com just now: '.$this->input->post('title').'——'.msubstr($this->input->post('desc'),0,80)
                             ));
		}
	}
	
	public function uploadCodeFile()
	{
		$this->load->helper('my_form');
		if($_POST['folder']!='0'){
			$guid = $_POST['folder'];
			$targetFolder = '/result/'.$guid;
			CompilePath($guid);
		}else{
			$guid = create_guid();
			$targetFolder = '/uploads/codefile/'.$guid;
			UploadPath('codefile',$guid);
		}
		$verifyToken = md5('unique_salt' . $_POST['timestamp']);
		if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
			$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
			
			// Validate the file type
			$fileTypes = array('json','xml','js','css','jpg','jpeg','gif','png','eot','svg','ttf','woff'); // File extensions
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			
			if (in_array($fileParts['extension'],$fileTypes)) {
				move_uploaded_file($tempFile,$targetFile);
				if($_POST['folder']){
					echo base_url() . 'result/'.$guid.'/' . $_FILES['Filedata']['name'];
				}else{
					echo base_url() . 'uploads/codefile/'.$guid.'/' . $_FILES['Filedata']['name'];
				}
			} else {
				echo 'Invalid file type.';
			}
		}
	}
	
	public function editcode($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->model('item_code_model');
		$this->item_code_model->item_html = $this->input->post('code');
		$this->item_code_model->item_css = $this->input->post('code_css');
		$this->item_code_model->item_js = $this->input->post('code_js');
		$this->item_code_model->item_as = $this->input->post('as');
        $this->item_code_model->update($id);
        $item_code = $this->item_code_model->load($id);
        
        
        $this->load->model('item_model');
        if($this->input->post('title')!=null&&$this->input->post('title')!='')
		$this->item_model->title = htmlspecialchars($this->input->post('title'));
		$this->item_model->desc = nl2br($this->input->post('desc'));
		$this->item_model->tags = $this->input->post('tags');
		$this->item_model->type = $this->input->post('type');
		$this->item_model->platform = $this->input->post('platform');
		$this->item_model->update($item_code['item_id']);
		
        $codefilelist = $this->input->post('codefile');
        if($codefilelist){
        $this->load->model('item_file_model');
        foreach($codefilelist as $codefile): 
			$this->item_file_model->item_id = $item_code['item_id'];
			$this->item_file_model->download_url = $codefile;
	        $this->item_file_model->insertData();
		endforeach; 
        }
        redirect(site_url('item/'.$item_code['item_id']));
	}
	
	public function savecode($type)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->helper('my_form');
		$this->load->model('item_model');
		$this->item_model->platform = $this->input->post('platform');
		if($type=='1'){
			if(trim($this->input->post('code'))==''&&trim($this->input->post('code_css'))==''&&trim($this->input->post('code_js'))==''){
				redirect('item/new_content/html');
				exit();
			}
			$this->item_model->from = 'htmleditor';
		}else if($type=='2'){
			if(trim($this->input->post('as'))==''){
				redirect('item/new_content/actionscript');
				exit();
			}
			$this->item_model->from = 'aseditor';
			$this->item_model->extension = 'as';
			$this->item_model->download_url = $this->input->post('download_url');
			$this->item_model->preview_url = $this->input->post('preview_url');
		}else{
			redirect('home');
		}
		$this->item_model->author_id = $this->session->userdata('id');
		if($this->input->post('title')!=null&&$this->input->post('title')!='')
		$this->item_model->title = htmlspecialchars($this->input->post('title'));
		else $this->item_model->title = 'A work by '.$this->session->userdata('displayName');
		$this->item_model->desc = nl2br($this->input->post('desc'));
		$this->item_model->tags = $this->input->post('tags');
		$this->item_model->type = $this->input->post('type');
		$this->item_model->parent_id = $this->input->post('parent');
		if($this->input->post('parent')!=null&&$this->input->post('parent')!='0'){
			$parent_item = $this->item_model->load($this->input->post('parent'));
			$this->item_model->title = 'A work forked from '.$parent_item['title'];
		}
		$this->item_model->is_private = 0;
		$this->item_model->contest_id = 0;
		$this->item_model->price = 0;
        $this->item_model->create();
		$id = $this->db->insert_id();
		
		$this->load->model('item_code_model');
		$this->item_code_model->item_id = $id;
		$this->item_code_model->item_html = $this->input->post('code');
		$this->item_code_model->item_css = $this->input->post('code_css');
		$this->item_code_model->item_js = $this->input->post('code_js');
		$this->item_code_model->item_as = $this->input->post('as');
		$this->item_code_model->item_key = $this->input->post('key');
        $this->item_code_model->create();
        
        $codefilelist = $this->input->post('codefile');
        if($codefilelist){
        $this->load->model('item_file_model');
        foreach($codefilelist as $codefile): 
			$this->item_file_model->item_id = $id;
			$this->item_file_model->download_url = $codefile;
	        $this->item_file_model->insertData();
		endforeach; 
        }
		$this->load->model('user_status_model','u_status');	
        $this->u_status->user_id = $this->session->userdata('id');
    	if($this->input->post('parent')!=null&&$this->input->post('parent')!='0'){
    		
    		$this->u_status->status_type = 18;
    		
    		//$this->user_status_model->content = "forked a new work named  <a href='".site_url('item/'.$id)."'>".$this->item_model->title."</a>";
    	}else{
    		
    		$this->u_status->status_type = 2;
    		
    		//$this->user_status_model->content = "created a new work named  <a href='".site_url('item/'.$id)."'>".$this->item_model->title."</a>";
    	}
    	$this->u_status->target_name = $this->item_model->title;
    	$this->u_status->target_id = $id;
		$this->u_status->insertData();
		
		
		$user_id = $this->session->userdata('id');
		$this->load->model('user_model');
		$user = $this->user_model->load($user_id);
		
		$this->load->model('user_notice_model');
		if($this->input->post('parent')!=null&&$this->input->post('parent')!='0'){
			$parent_item = $this->item_model->load($this->input->post('parent'));
	        $this->user_notice_model->user_id = $parent_item['author_id'];
	    	$this->user_notice_model->content = "<a href='".site_url('user/'.$this->session->userdata('id'))."'>".$this->session->userdata('displayName')."</a> forked your work <a href='".site_url('item/'.$parent_item['id'])."'>".$parent_item['title']."</a>";
			$this->user_notice_model->insertData();
			
			$this->load->model('email_model');
            $author = $this->user_model->load($parent_item['author_id']);
            $title = $this->session->userdata('displayName').' forked your work '.$parent_item['title'].' on EffectHub.com';
            $content = $this->user_notice_model->content;
			$this->email_model->send_notification($author['email'],$title,$content);
		}
		
		$user_point = $user['point'] + 10;
		$this->user_model->update_point($user_id,$user_point);
		
		
		try {
		$socialBind=$this->input->post('socialBind');
		for($i=0;$i<count($socialBind);$i++)
		{
			if($socialBind[$i]=='sina'){
				$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $this->session->userdata('token_sina') );
				$c->update('I created a new work on EffectHub.com just now: '.$this->item_model->title.'——'.msubstr($this->input->post('desc'),0,80).' '.site_url('item/'.$id));
			}
			if($socialBind[$i]=='twitter'){
				$api = new Twitter( TT_AKEY , TT_SKEY );
				$api->setOAuthToken($this->session->userdata('token_twitter'));
				$api->setOAuthTokenSecret($this->session->userdata('token_secret_twitter'));
				$api->statusesUpdate('I created a new work on EffectHub.com just now: '.$this->item_model->title.'——'.msubstr($this->input->post('desc'),0,80).' '.site_url('item/'.$id));
			}
			if($socialBind[$i]=='facebook'){
				$api = new Facebook(array());
				$api->setAccessToken($this->session->userdata('token_facebook'));
				$api->api('/me/feed', 'POST',
                                    array(
                                      'link' => site_url('item/'.$id),
                                      'message' => 'I created a new work on EffectHub.com just now: '.$this->item_model->title.'——'.msubstr($this->input->post('desc'),0,80)
                                 ));
			}
		}
		} catch (OAuthException $e) {
		}
		
		$cookie = array(
				'name'   => 'new_item',
				'value'  => 1,
				'expire' => '300',
		);
		set_cookie($cookie);
		
		redirect(site_url('item/'.$id));
	}
	
	public function save()
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		if(trim($this->input->post('title'))==''){
			redirect('item/upload');
			exit();
		}
        $this->load->helper('my_form');
		$this->load->model('item_model');
		$this->item_model->author_id = $this->session->userdata('id');
		$this->item_model->title = htmlspecialchars($this->input->post('title'));
		$this->item_model->desc = nl2br(htmlspecialchars($this->input->post('desc')));
		$this->item_model->tags = $this->input->post('tags');
		$this->item_model->price = $this->input->post('price');
		$this->item_model->share = $this->input->post('share');
		$this->item_model->preview_url = $this->input->post('preview');
		$this->item_model->download_url = $this->input->post('download_url');
		$this->item_model->type = $this->input->post('type');
		$this->item_model->platform = $this->input->post('platform');
		$this->item_model->from = $this->input->post('istool');
		$this->item_model->is_private = $this->input->post('is_private');
		$this->item_model->contest_id = $this->input->post('contest_id');
		$this->item_model->tool = $this->input->post('tool');
		if($this->item_model->share!=1){
			if($this->item_model->tool!=null&&$this->item_model->tool==1){
				$this->item_model->from = 'particle';
			}
		}
			if($this->item_model->tool!=null&&$this->item_model->tool==2){
				$this->item_model->from = 'dragonbones';
			}
			if($this->item_model->tool!=null&&$this->item_model->tool==3){
				$this->item_model->from = 'sea3d';
			}
			if($this->item_model->platform!=null&&$this->item_model->platform==3){
				$this->item_model->from = 'unity';
			}
		
        $this->item_model->create();
		$id = $this->db->insert_id();
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
		    //echo "Return Code: " . $_FILES["url"]["error"] . "<br />";
		    }
		  else
		    {
				$base_url=$this->config->item('base_url');
				$user_id = $id;
				$rs = array();
				$input = file_get_contents($_FILES["url"]["tmp_name"]);
				$data = $input;
				$upload_dir = 'item';
				$dir = UploadPath($upload_dir);
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
			$config['width'] = 400;
			$config['height'] = 320;
			
			$this->load->library('image_lib', $config); 
			
			$this->image_lib->resize();
			
    		$this->item_model->pic_url = $pic_path;
    		$this->item_model->thumb_url = base_url().'uploads/'.$upload_dir.'/'.$user_id.'_thumb.jpg';
    		
	    	$this->item_model->update($id);
    	}
    	$attachment_path = '';
    	if($this->item_model->share==null||$this->item_model->share==0){
    	if ($_FILES["attach"]["size"]>0 && $_FILES["attach"]["size"] < 50000000)
		  {
		  if ($_FILES["attach"]["error"] > 0)
		    {
		    //echo "Return Code: " . $_FILES["attach"]["error"] . "<br />";
		    }
		  else
		    {
		    	$attach_id = create_guid();
				$base_url=$this->config->item('base_url');
				$user_id = $id;
				$rs = array();
				$input = file_get_contents($_FILES["attach"]["tmp_name"]);
				$filename = $_FILES['attach']['name'];
				preg_match('|\.(\w+)$|', $filename, $ext);
				$ext = strtolower($ext[1]);
				$this->item_model->extension = $ext;
				$data = $input;
				$upload_dir = 'attachment';
				$dir = UploadPath($upload_dir);
				$file_name=$dir.'/'.$attach_id.'.'.$ext;
		
				@file_put_contents($file_name, $data);
				$attachment_path = base_url().'uploads/'.$upload_dir.'/'.$attach_id.'.'.$ext;
				$rs['status'] = 1;		
		    }
		  }
    	if($attachment_path!=''&&$attachment_path!=null){
    		$this->item_model->download_url = $attachment_path;
    		$this->item_model->size = $_FILES["attach"]["size"];
	    	$this->item_model->update($id);
    		$realpath = str_replace("http://www.effecthub.com",$_SERVER['DOCUMENT_ROOT'],$attachment_path);
			$realpath = str_replace('\\', '/', $realpath);
    		if($realpath!=''&&$this->item_model->extension == 'zip'){
    				$item = $this->item_model->load($id);
					$this->load->helper('my_form');
					$guid = create_guid();
					UploadPath('extract',$guid);
					$extract_path = $_SERVER['DOCUMENT_ROOT'].'/uploads/extract/'.$guid;
					$zipresult = exec('unzip -d '.$extract_path.' '.$realpath);
					//echo $zipresult;
					$this->load->helper('file');
					$folder_files = get_dir_file_info($extract_path);
					//print_r($folder_files);
					if(count($folder_files)==1&&is_dir($folder_files[0]))
					$folder_files = get_dir_file_info($folder_files[0]['server_path']);
					foreach($folder_files as $file): 
						$targetFile = $file['server_path'];
						$item_download_url = base_url() . 'uploads/extract/'.$guid.'/'. $file['name'];
						$item_extension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
						$fileTypes = array('jpg','jpeg','gif','png','JPG','PNG','GIF','JPEG');
						$textureTypes = array('jpg','png','atf','dds','bmp','jpeg','gif');
						$modelTypes = array('awd','obj','3ds','md2','dae','md5mesh','md5anim');
						if($file['name']=='index.html'||$file['name']=='index.htm'){
							$this->item_model->updatePreview($id,$item_download_url);
						}
						if(!$this->item_model->loadbydownloadurl($item_download_url)&&$item_extension!=''){
							$this->item_model->pic_url = '';
							$this->item_model->thumb_url = '';
							$this->item_model->author_id = $item['author_id'];
							$this->item_model->title = $file['name'];
							$this->item_model->desc =  $file['name'];
							$this->item_model->file_name = $file['name'];
							$this->item_model->work_id = $item['id'];
							$this->item_model->price = $item['price'];
							$this->item_model->price_type = $item['price_type'];
							$this->item_model->share = 0;
							$this->item_model->tool = 0;
							$this->item_model->from = 0;
							$this->item_model->folder_id = 0;
							$this->item_model->platform = 0;
							if(in_array($item_extension,$textureTypes)){
								$this->item_model->pic_url = $item_download_url;
								$this->item_model->thumb_url = $item_download_url;
								$this->item_model->type = 3;
							}else if(in_array($item_extension,$modelTypes)){
								$this->item_model->type = 2;
							}else if($item_extension=='amf'){
								$this->item_model->type = 9;
								$this->item_model->platform = 1;
							}else if($item_extension=='awp'){
								$this->item_model->type = 1;
								$this->item_model->platform = 1;
							}else{
								$this->item_model->type = 13;
							}
							if($item_extension=='awd'){
								$this->item_model->platform = 1;
							}
							$this->item_model->extension = $item_extension;
							$this->item_model->download_url = $item_download_url;
							$this->item_model->contest_id = 0;
							$this->item_model->file_size = $file['size'];
							$this->item_model->is_private = $item['is_private'];
					        $this->item_model->create();
							//echo 'create item '.$file['name'].' successfully'.'<br/>';
						}
					endforeach; 
				}
    	}
    	}
	    
	    $this->load->model('user_status_model','u_status');	
        $this->u_status->user_id = $this->session->userdata('id');
        if($this->item_model->share){
        	$this->u_status->status_type = 13;
        }else{
        	$this->u_status->status_type = 2;
        }
        
    	//$this->user_status_model->content = " named  <a href='".site_url('item/'.$id)."'>".$this->input->post('title')."</a>";
		/*
		if($pic_path!=''&&$pic_path!=null){
			$this->user_status_model->pic_url = $this->item_model->thumb_url;
    	}
    	$this->user_status_model->target_url = site_url('item/'.$id);
		$this->user_status_model->target_name = $this->input->post('title');
		*/
        $this->u_status->target_id = $id;
        $this->u_status->target_name = htmlspecialchars($this->input->post('title'));
        $this->u_status->pic_url = $pic_path;
        
		$this->u_status->insertData();
		
		$user_id = $this->session->userdata('id');
		$this->load->model('user_model');
		$user = $this->user_model->load($user_id);
		$user_point = $user['point'] + 10;
		$this->user_model->update_point($user_id,$user_point);
		
		$this->load->model('item_history_model');	
        $this->item_history_model->item_id = $id;
        $this->item_history_model->action = "create";
        $content = ' '.$this->input->post('title');
		if($content!=''){
			$this->item_history_model->content = $content;
			if($attachment_path!=''&&$attachment_path!=null){
			$this->item_history_model->download_url = $attachment_path;
			}
			$this->item_history_model->insertData();
		}
		
		try {
		$socialBind=$this->input->post('socialBind');
		for($i=0;$i<count($socialBind);$i++)
		{
			if($socialBind[$i]=='sina'){
				$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $this->session->userdata('token_sina') );
				$c->upload('我刚刚在全球游戏设计师社交网络EffectHub.com上传了一件作品，期待你的评价:) '.$this->input->post('title').'——'.msubstr($this->input->post('desc'),0,80).' '.site_url('item/'.$id),$_FILES["url"]["tmp_name"]);
			}
			if($socialBind[$i]=='twitter'){
				$api = new Twitter( TT_AKEY , TT_SKEY );
				$api->setOAuthToken($this->session->userdata('token_twitter'));
				$api->setOAuthTokenSecret($this->session->userdata('token_secret_twitter'));
				$api->statusesUpdate('I uploaded my works on EffectHub.com just now: '.$this->input->post('title').'——'.msubstr($this->input->post('desc'),0,80).' '.site_url('item/'.$id));
			}
			if($socialBind[$i]=='facebook'){
				$api = new Facebook(array());
				$api->setAccessToken($this->session->userdata('token_facebook'));
				$api->api('/me/feed', 'POST',
                                    array(
                                      'link' => site_url('item/'.$id),
                                      'message' => 'I uploaded my works on EffectHub.com just now: '.$this->input->post('title').'——'.msubstr($this->input->post('desc'),0,80)
                                 ));
			}
			if($socialBind[$i]=='behance'){
				echo $_FILES["url"]["tmp_name"];
				$api = new Be_Api( BE_AKEY , BE_SKEY );
				$api->setAccessToken($this->session->userdata('token_behance'));
				$api->createUserWip($_FILES["url"]["tmp_name"],$this->input->post('title'),explode(" ",$this->input->post('tags')),$this->input->post('desc'));
			}
		}
		} catch (OAuthException $e) {
		}
		redirect(site_url('item/'.$id)); 
	}
	
	function testfacebook()
	{
		$api = new Facebook(array());
				$api->setAccessToken($this->session->userdata('token_facebook'));
				echo $api->api('/me/feed', 'POST',
                                    array(
                                      'link' => site_url('item/'.'1'),
                                      'message' => 'I uploaded my works on EffectHub.com just now: '
                                 ));
	}
	
	function testbehance()
	{
		$tag = array();
		$api = new Be_Api( BE_AKEY , BE_SKEY );
		$api->setAccessToken($this->session->userdata('token_behance'));
		$api->createUserWip('C:\xampp\tmp\a.jpg','testaa',$tag,'test test');
	}
	
	function testsina()
	{
		$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $this->session->userdata('token_sina') );
			echo $c->update('I uploaded my works on EffectHub.com just now');
	}
	
	//search one author's item
	function userworksSearch($userid)
	{
		$this->load->model('user_model');
        $data = array();
        if($userid!=null&&$userid!=0){
        	$data['user'] = $this->user_model->load($userid);
        	$this->load->model('item_model');
            $data['view_num'] = $this->item_model->get_sum_viewnum($userid);
            $data['fav_num'] = $this->item_model->get_sum_favnum($userid);
			$data['user_item_list1'] = $this->item_model->find_items(array('user'=>$userid), 50, 0);
			$taglist = Array();
			foreach($data['user_item_list1'] as $item){
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
	   			$data['follow'] = $this->user_follow_model->loadByUserAndFav($userid,$this->session->userdata('id'));
	   		}
        }
        
		$input_str = $this->input->post('search');
		$this->load->model('item_model');
		$data['user_item_list']= $this->item_model->user_works_Search($input_str,$userid);
		$this->load->view('user/user',$data);
	}
	
	//search item --local search
	function search()
	{
		$this->load->model('item_model');
		/*
			$data['item_list1'] = $this->item_model->find_items(array(), 100, 0);
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
		$data['tags'] = $this->user_model->order_popular_tag($taglist);
		*/
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array(), 100, 0);
		//$this->load->model('user_model');
		//$data['user_list'] = $this->user_model->order_popular_author();
	
		$input_str = trim($this->input->post('search'));
		if(!$input_str){
			parse_str($_SERVER['QUERY_STRING'], $_GET);
			$input_str = trim($this->input->get('keyword'));
		}
	
	
		//search estimate
		//update the search table for future user action estimate
		$this->load->model('search_model');
		$userid = '0'; // default $userid is 0, which is a anonymouse user, it does not exist in user table
		if ($this->session->userdata('id')!=null){
			$userid = $this->session->userdata('id');
		}
		//@file_put_contents('D:\\Git\\wjb.log',"\n".'userid:'.$userid."\n",FILE_APPEND);
		$search_item = $this->search_model->search($input_str,$userid);
		//@file_put_contents('D:\\Git\\wjb.log',$search_item == null?'$search_item:null'. "\n":'$search_item:'.$search_item->id."\n",FILE_APPEND);
		if ( $search_item != null)
		{
			$count = $search_item->count + 1;
			//@file_put_contents('D:\\Git\\wjb.log','count:'.$count."\n",FILE_APPEND);
			$this->search_model->update($search_item->id,$count);
		}
		else
		{
			$this->search_model->insert_new($input_str,$userid);
		}
		//end search estimate
	
	
		$res= $this->item_model->particle_search($input_str);
	
		$this->load->library('pagination');//加载分页类
		$config['base_url'] = base_url().'item/search?keyword='.$input_str;//设置分页的url路径
		$config['total_rows'] = count($res);//得到数据库中的记录的总条数
		$config['per_page'] = '10';//每页记录数
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$config['page_query_string'] = TRUE;
		$this->pagination->initialize($config);//分页的初始化
		$data['results']= $this->item_model->particle_search_offset($input_str,$config['per_page'],$this->uri->segment(3));//得到数据库记录
		$data['seach_active_tag'] = 'item';
	
		$data['input_str'] = $input_str;
		$this->load->view('search_result',$data);
	}		
	
	//search all -- global search
	function globalSearch()
	{
		$input_str = $this->input->post('search');
		$this->load->model('item_model');
		$data['results'] = $this->item_model->global_search($input_str);
		/*foreach ($data as $v1)   
        {  
          foreach ($v1 as $v2)   
          {  
            echo $v2['content'];
          }  
       }  */
      /* foreach ($data[1] as $v2)   
       {  
            echo $v2['content'];
       } */
		$this->load->view('item/global_search_result',$data);
	}
	
	//search by tag
	function tagSearch()
	{
		$this->load->model('item_model');
		/*
		$data['item_list1'] = $this->item_model->find_items(array(), 100, 0);
		
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
		$data['tags'] = $this->user_model->order_popular_tag($taglist);
		*/
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$tag_str = $this->input->get('tag');
		$data['input_str'] = $tag_str;
		
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array(), 100, 0);
		//$this->load->model('user_model');
		//$data['user_list'] = $this->user_model->order_popular_author();

		$res = $this->item_model->tag_search($tag_str);
		$this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'index.php/item/tagSearch/'.$tag_str;//设置分页的url路径
        $config['total_rows'] = count($res);//得到数据库中的记录的总条数
        $config['per_page'] = '10';//每页记录数
        $config['first_link'] = 'First';
        $config['uri_segment']=4;
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $data['results']= $this->item_model->tag_search_offset($tag_str,$config['per_page'],$this->uri->segment(4));//得到数据库记录
		$this->load->view('item/search_result',$data);
	}
	
	//see more--asynchronous loading
	function seemore($item_id="")
	{
		$num_load_everytime =10; // 每点击一次seemore,加载的评论条数
		$post_id = $_GET['id'];
		$this->load->model('item_model');
        $data = array();
		$data1['item'] = $this->item_model->load(intval($item_id, 10));
		$this->load->model('item_comment_model');
        $data = $this->item_comment_model->find_item_comments(array('item'=>$data1['item']['id']), $num_load_everytime, $num_load_everytime*$post_id);
		foreach($data as $_item_comment){
			$output = "<div class='commentitem'>
                            <div class='commentimg'>
                                <a href='".site_url('user/'.$_item_comment['author_id'])."'><img width='50px' src='".$_item_comment['author_pic']."'></a>
                            </div>
                            <div>
                                <div class='paragraphstyle'><b><a href='".site_url('user/'.$_item_comment['author_id'])."'>".$_item_comment['author_name']."</a></b>". tranTime(strtotime($_item_comment['create_date'])). "</div>
                                <div class='commenttext'>".$_item_comment['content']."</div>
                            </div>
                   </div>";
		    echo $output; 	
		}
		//判断是否加载完全
		$comment_count = $this->item_comment_model->count_item_comments(array('item'=>$data1['item']['id']));
		if($comment_count/$num_load_everytime==$post_id+1){
			$loadcompletely = "<div style='margin-left:30px;'>Load Completely!</div>";
			//echo $loadcompletely;
		}
        
	}
	
	//show items by itemType
	function itemtype($typename)
	{
		$this->load->model('item_model');
		$data['item_list'] = $this->item_model->find_item_by_itemtype($typename);
		$this->load->view('index',$data);
	}
	
	//show items by features such as most appreciated,most viewed
	function featured($featurename,$type='all')
	{
		if($this->session->userdata('language')) {
			$lang = $this->session->userdata('language');
			$data['lang']= $lang;
		}else{
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
			if (preg_match("/zh-c/i", $lang)||$lang=='cn')
			{
				$data['lang']= '2';
			}else{
				$data['lang']= '1';
			}
		}
		
		if($featurename!='MostRecent'){
			$this->session->set_userdata('item_notice',0);
			$data['nav']= 'explore';
			$data['type']= 'all';
			$this->load->model('user_model');
			$user_count = $this->user_model->count_users();
			$data['user_count'] = $user_count;
			$this->load->model('item_model');
			$data['item_count'] = $this->item_model->count_items(array());
			$data['item_num'] = $this->item_model->count_item_by_feature($featurename,$type);
			$data['feature'] = $featurename;
	        $data['type'] = $type;
	        $this->load->library('pagination');//加载分页类
	        $config['base_url'] = base_url().'item/featured/'.$featurename.'/'.$type;//设置分页的url路径
	        $config['total_rows'] = $data['item_num'];//得到数据库中的记录的总条数
	        $config['uri_segment'] = 5;
	        $config['per_page'] = '12';//每页记录数
	        $config['first_link'] = 'First';
	        $config['last_link'] = 'Last';
	        $config['full_tag_open'] = '<p>';
	 	    $config['full_tag_close'] = '</p>'; 
	        $this->pagination->initialize($config);//分页的初始化
	        $this->load->model('item_type_model');
	        
		    parse_str($_SERVER['QUERY_STRING'], $_GET);
			$tag_str = $this->input->get('tag');
			$data['tag'] = $tag_str;
			
			$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1,'order'=>'order'));
			$this->load->model('item_model');
			$data['item_list'] = $this->item_model->order_item_by_feature_offset($featurename,$type,$config['per_page'],$this->uri->segment(5));
			$this->load->view('index',$data);
		}else{
			$this->session->set_userdata('item_notice',0);
			$data['nav']= 'explore';
			$data['type']= 'all';
			$this->load->model('user_model');
			$user_count = $this->user_model->count_users();
			$data['user_count'] = $user_count;
			$this->load->model('item_model');
			$this->load->model('file_model');
			$data['item_count'] = $this->item_model->count_items(array());
			$data['item_num'] = $this->file_model->count_item_by_feature($featurename,$type);
			$data['feature'] = $featurename;
			$data['type'] = $type;
			$this->load->library('pagination');//加载分页类
			$config['base_url'] = base_url().'item/featured/'.$featurename.'/'.$type;//设置分页的url路径
			$config['total_rows'] = $data['item_num'];//得到数据库中的记录的总条数
			$config['uri_segment'] = 5;
			$config['per_page'] = '12';//每页记录数
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '</p>';
			$this->pagination->initialize($config);//分页的初始化
			$this->load->model('item_type_model');
		
			parse_str($_SERVER['QUERY_STRING'], $_GET);
			$tag_str = $this->input->get('tag');
			$data['tag'] = $tag_str;
		
			$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1,'order'=>'order'));
			$this->load->model('user_folder_model');
			$this->load->model('tool_model');
			$this->load->model('platform_model');
			$rows = array();
			$file_list = $this->file_model->order_item_by_feature_offset($featurename,$type,$config['per_page'],$this->uri->segment(5));
			foreach ($file_list as $row)
			{
				$user = $this->user_model->load($row['author_id']);			
				//In debug, sometime the first time query, the result is null
				//So add following logic to fix it.
				if($user == null || $user['displayName'] == null || $user['displayName'] == '')
				{
					$user = $this->user_model->load($row['author_id']);			
				}
				$row['author_pic'] = $user['pic_url'];
				$row['author_level'] = $user['level'];
				$row['author_point'] = $user['point'];
				$type = $this->item_type_model->load($row['type']);
				if($row['file_type'] == 1)
				{
					//this is a folder item
					$folder_items = $this->item_model->find_items(array('folder_id'=>$row['id'],'pic'=>'pic_url','order'=>'update_date'),1,0);
					$folder_img_count = 0;
					foreach($folder_items as $folder_item)
					{
						if($folder_item['thumb_url'] != null || $folder_item['pic_url'] != null)
						{
							$folder_img_count += 1; 
						}					
					}
					$row['img_count'] = $folder_img_count;
					if($folder_img_count > 0)
					{
						$row['img_count'] = $folder_img_count;
						$row['folder_items'] = $folder_items;
					}
					else
					{
						$row['folder_img'] = 'http://www.effecthub.com/images/cloud/folder.png';
					}
				}
				else
				{
					$folder = $this->user_folder_model->load($row['folder_id']);
					if($folder&&$folder['parent_folder']>0){
						$row['folder_name'] = $folder['folder_name'];
					}
				}
				if($row['tool']>0){
					$tool = $this->tool_model->load($row['tool']);
					$row['tool_name'] = $tool['name'];
					$row['tool_domain'] = $tool['domain'];
					$row['tool_pic'] = $tool['thumb_url'];
				}
				if($row['platform']>0){
					$platform = $this->platform_model->load($row['platform']);
					$row['platform_name'] = $platform['name'];
					$row['platform_key'] = $platform['key'];
					$row['platform_pic'] = $platform['pic_url'];
				}
				$row['author_name'] = $user['displayName'];
				 
				$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
				if (preg_match("/zh-c/i", $lang)||$lang=='cn') {
					$row['type_name'] = $type['name_cn'];
				} else {
					$row['type_name'] = $type['name'];
				}			
				$rows[] = $row;
			}	
			$data['item_list'] = $rows;
			$this->load->view('index',$data);
		}
	}
	function featured_($featurename,$type='all')
	{
		if($this->session->userdata('language')) {
			$lang = $this->session->userdata('language');
			$data['lang']= $lang;
		}else{
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
	        if (preg_match("/zh-c/i", $lang)||$lang=='cn')
	        {
	        	$data['lang']= '2';
	        }else{
	        	$data['lang']= '1';
	        }
		}
        $this->session->set_userdata('item_notice',0);
		$data['nav']= 'explore';
		$data['type']= 'all';
		$this->load->model('user_model');
		$user_count = $this->user_model->count_users();
		$data['user_count'] = $user_count;
		$this->load->model('item_model');
		$data['item_count'] = $this->item_model->count_items(array());
		$data['item_num'] = $this->item_model->count_item_by_feature($featurename,$type);
		$data['feature'] = $featurename;
        $data['type'] = $type;
        $this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'item/featured/'.$featurename.'/'.$type;//设置分页的url路径
        $config['total_rows'] = $data['item_num'];//得到数据库中的记录的总条数
        $config['uri_segment'] = 5;
        $config['per_page'] = '12';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $this->load->model('item_type_model');
        
	    parse_str($_SERVER['QUERY_STRING'], $_GET);
		$tag_str = $this->input->get('tag');
		$data['tag'] = $tag_str;
		
		$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1,'order'=>'order'));
		$this->load->model('item_model');
		$data['item_list'] = $this->item_model->order_item_by_feature_offset($featurename,$type,$config['per_page'],$this->uri->segment(5));
		$this->load->view('index',$data);
	}
	
	function tool($toolkey,$featurename='MostRecent')
	{
		$data['nav']= 'explore';
		$data['type']= 'all';
		$this->load->model('item_model');
		$this->load->model('tool_model');
		$data['tool'] = $this->tool_model->loadbykey($toolkey);
		$array =array('ThisMonth'=>'fav_num' ,'MostDownloaded'=>'download_num'  ,'MostAppreciated'=>'fav_num' ,'MostViewed'=>'view_num' ,'MostDiscussed'=>'comment_num' ,'MostRecent'=>'update_date');
		$option = array('order'=>$array[$featurename],'typenotin'=>12,'tool'=>$data['tool']['id']);
		$data['item_num'] = $this->item_model->count_items($option);
		$data['feature'] = $featurename;
        $this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'item/demo/'.$toolkey.'/'.$featurename;//设置分页的url路径
        $config['total_rows'] = $data['item_num'];//得到数据库中的记录的总条数
        $config['uri_segment'] = 5;
        $config['per_page'] = '12';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $this->load->model('item_type_model');
	        $data['item_type_list'] = $this->item_type_model->find_item_types();
		$this->load->model('item_model');
		$data['item_list'] = $this->item_model->find_items($option,$config['per_page'],$this->uri->segment(5));
		$this->load->view('item/item_demo_list',$data);
	}
	
	function demo($toolkey,$featurename='MostRecent')
	{
		$data['nav']= 'explore';
		$data['type']= 'all';
		$this->load->model('item_model');
		$this->load->model('tool_model');
		$data['tool'] = $this->tool_model->loadbykey($toolkey);
		$array =array('ThisMonth'=>'fav_num' ,'MostDownloaded'=>'download_num'  ,'MostAppreciated'=>'fav_num' ,'MostViewed'=>'view_num' ,'MostDiscussed'=>'comment_num' ,'MostRecent'=>'id');
		$option = array('order'=>$array[$featurename],'typenotin'=>12,'is_private'=>0,'tool'=>$data['tool']['id']);
		$data['item_num'] = $this->item_model->count_items($option);
		$data['feature'] = $featurename;
        $this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'item/demo/'.$toolkey.'/'.$featurename;//设置分页的url路径
        $config['total_rows'] = $data['item_num'];//得到数据库中的记录的总条数
        $config['uri_segment'] = 5;
        $config['per_page'] = '12';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $this->load->model('item_type_model');
	        $data['item_type_list'] = $this->item_type_model->find_item_types();
		$this->load->model('item_model');
		$data['item_list'] = $this->item_model->find_items($option,$config['per_page'],$this->uri->segment(5));
		$this->load->view('item/item_demo_list',$data);
	}
	
	function showcase($toolkey,$featurename='MostRecent')
	{
		$data['nav']= 'explore';
		$data['type']= 'all';
		$this->load->model('item_model');
		$this->load->model('tool_model');
		$data['tool'] = $this->tool_model->loadbykey($toolkey);
		$array =array('ThisMonth'=>'fav_num' ,'MostDownloaded'=>'download_num'  ,'MostAppreciated'=>'fav_num' ,'MostViewed'=>'view_num' ,'MostDiscussed'=>'comment_num' ,'MostRecent'=>'update_date');
		$option = array('order'=>$array[$featurename],'type'=>12,'is_private'=>0,'tool'=>$data['tool']['id']);
		$data['item_num'] = $this->item_model->count_items($option);
		$data['feature'] = $featurename;
        $this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'item/showcase/'.$toolkey.'/'.$featurename;//设置分页的url路径
        $config['total_rows'] = $data['item_num'];//得到数据库中的记录的总条数
        $config['uri_segment'] = 5;
        $config['per_page'] = '12';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $this->load->model('item_type_model');
	        $data['item_type_list'] = $this->item_type_model->find_item_types();
		$this->load->model('item_model');
		$data['item_list'] = $this->item_model->find_items($option,$config['per_page'],$this->uri->segment(5));
		$this->load->view('item/item_showcase_list',$data);
	}
	
	function platform($platformkey,$featurename='MostAppreciated')
	{
		$data['nav']= 'explore';
		$data['type']= 'all';
		$this->load->model('item_model');
		$data['item_num'] = $this->item_model->count_item_by_platform($featurename,$platformkey);
		$this->load->model('platform_model');
		$data['platform'] = $this->platform_model->loadbykey($platformkey);
		$data['feature'] = $featurename;
        $this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'item/platform/'.$platformkey.'/'.$featurename;//设置分页的url路径
        $config['total_rows'] = $data['item_num'];//得到数据库中的记录的总条数
        $config['uri_segment'] = 5;
        $config['per_page'] = '12';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $this->load->model('item_type_model');
	        $data['item_type_list'] = $this->item_type_model->find_item_types();
		$this->load->model('item_model');
		$data['item_list'] = $this->item_model->order_item_by_platform_offset($featurename,$platformkey,$config['per_page'],$this->uri->segment(5));
		$this->load->view('item/item_platform',$data);
	}
	
	//show items by user like
	function mylike($id)
	{
		$data['nav']= 'explore';
		$this->load->model('item_model');
		$this->load->model('item_fav_model');
		$data['likes_num'] = $this->item_fav_model->count_item_favs(array('uid'=>$id));
		$this->load->model('item_model');
		$res= $this->item_model->find_items(array('user'=>$id),0);
		$data['works_num']= count($res);
		
		$data['feature'] = 'Favorite';
        
        $this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'item/mylike/'.$id;//设置分页的url路径
        $config['total_rows'] = $data['likes_num'];//得到数据库中的记录的总条数
        $config['uri_segment'] = 4;
        $config['per_page'] = '12';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        
		$this->load->model('item_model');
		$data['user_item_list'] = $this->item_model->find_item_by_mylike($id,$config['per_page'],$this->uri->segment(4));
		$data['item_list'] = $this->item_model->find_items(array('user'=>$id));
		$this->load->model('user_status_model');       
		$data['activity_list']= $this->user_status_model->find_status(array('user'=>$id),5);

		$this->load->model('user_model');
		$this->load->model('user_social_model');
        	$data['user'] = $this->user_model->load($id);
        	$data['social_list'] = $this->user_social_model->loadByUser($id);
        	
			$taglist = Array();
			foreach($data['item_list'] as $item){
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
		
		
		$data['nav']= 'profile';
		$data['feature']= 'likes';
        $this->load->model('country_model');
		$country = $this->country_model->load($data['user']['countryCode']);
		$data['country_name'] = $country['full_name'];
        $this->load->model('item_model');
        $data['view_num'] = $this->item_model->get_sum_viewnum($id);
        $data['fav_num'] = $this->item_model->get_sum_favnum($id);
		$this->load->view('user/user',$data);
	}
	
	//show status of authors that I follow with
	function myfollow($myid)
	{
		$data['nav']= 'works';
        	$data['feature']= 'following';

		$this->load->model('user_model');
	    $data['user_list'] = $this->user_model->find_users(array('rand'=>1), 5, 0);
        
	    	$user = $this->user_model->load($myid);
	    	
	    	$data['user']= $user;
	    	
        $this->load->model('user_status_model');       
		$res= $this->user_status_model->find_status_by_myfollow($myid);
        $this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'item/myfollow/'.$myid;//设置分页的url路径
        $config['total_rows'] = count($res);//得到数据库中的记录的总条数
        $config['uri_segment'] = 4;
        $config['per_page'] = '20';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $data['status_list']= $this->user_status_model->find_status_by_myfollow_offset($myid,$config['per_page'],$this->uri->segment(4));//得到数据库记录
        
		//$this->load->model('user_status_model');
		//$data['status_list'] = $this->user_status_model->find_status_by_myfollow($myid);
		$this->load->view('user/user_status',$data);
	}	
	
	//show history of items that I have watched
	function mywatch($myid)
	{
		$data['nav']= 'works';
        	$data['feature']= 'Watching';
		$this->load->model('item_model');
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array(), 100, 0);

		$this->load->model('user_model');
        $data['user_list'] = $this->user_model->order_popular_author();
        //$data['tags'] = $this->user_model->order_popular_tag($taglist);
        $data['user']= $this->user_model->load($myid);
		$this->load->model('user_watch_model');
		$res= $this->user_watch_model->find_history_by_mywatch($myid);
        $this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'item/mywatch/'.$myid;//设置分页的url路径
        $config['total_rows'] = count($res);//得到数据库中的记录的总条数
        $config['uri_segment'] = 4;
        $config['per_page'] = '20';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
		$data['item_history_list'] = $this->user_watch_model->find_history_by_mywatch_offset($myid,$config['per_page'],$this->uri->segment(4));//得到数据库记录
		
		$data['watch_list'] = $this->user_watch_model->loadByUser($myid);
		//$data['item_history_list'] = $this->user_watch_model->find_history_by_mywatch($myid);
		$this->load->view('item/item_history',$data);
	}	
	
	//show items according to tags that inspired me
	function inspired($myid,$type='all')
	{
		$data['nav']= 'works';
		$data['type']= 'all';
		$data['feature']= 'Suggestions';
		$this->load->model('item_model');
		$tags= $this->item_model->get_author_tags($myid);
		
		$this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'item/inspired/'.$myid;//设置分页的url路径
        $config['total_rows'] = 48;//得到数据库中的记录的总条数
        $config['uri_segment'] = 4;
        $config['per_page'] = '12';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        
        $this->load->model('item_type_model');
	        $data['item_type_list'] = $this->item_type_model->find_item_types();
		$this->load->model('item_model');
		$data['item_list'] = $this->item_model->find_item_by_inspiredtags($myid,$type,$tags,$config['per_page'],$this->uri->segment(4));
		$this->load->view('index',$data);
	}
	
	//edit item (click the edit button)
	function edit($itemid)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->model('item_model');
        $data = array();
		if($this->session->userdata('language')) {
			$lang = $this->session->userdata('language');
			$data['lang']= $lang;
		}else{
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
	        if (preg_match("/zh-c/i", $lang)||$lang=='cn')
	        {
	        	$data['lang']= '2';
	        }else{
	        	$data['lang']= '1';
	        }
		}
        if($itemid!=null&&$itemid!=0){
        	$data['item'] = $this->item_model->load($itemid);
        }
        if ($this->session->userdata('id')!=$data['item']['author_id']){         		
			redirect('home');
			exit();
		}
		$this->load->model('tool_model');
		$data['tool_list'] = $this->tool_model->find_tools(array(), 100, 0);
		$this->load->model('platform_model');
		$data['platform_list'] = $this->platform_model->find_platforms(array(), 100, 0);
        $data['hot_item_list'] = $this->item_model->find_items(array('rand'=>'1'), 6, 0);
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1), 100, 0);
		
		//$this->load->model('item_model');
		//$data['recommend'] = $this->item_model->recommend_items(array('from'=>$data['item']['from']),5);
		
		
		$this->load->view('item/item_edit',$data);
	}
	
	//modify item (click the modify button)
	function modify($id)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		if($this->input->post('title')==''){
			redirect('item/edit/'.$id);
			exit();
		}
		$this->load->helper('my_form');
		$this->load->model('item_model');
		$olditem = $this->item_model->load($id);
		
		$this->item_model->author_id = $this->session->userdata('id');
		$this->item_model->title = $this->input->post('title');
		$this->item_model->desc = nl2br($this->input->post('desc'));
		$this->item_model->tags = $this->input->post('tags');
		$this->item_model->price = $this->input->post('price');
		$this->item_model->price_type = $this->input->post('price_type');
		$this->item_model->share = $this->input->post('share');
		$this->item_model->preview_url = $this->input->post('preview');
		$this->item_model->type = $this->input->post('type');
		$this->item_model->platform = $this->input->post('platform');
		$this->item_model->from = $this->input->post('istool');
		$this->item_model->tool = $this->input->post('tool');
		$this->item_model->is_private = $this->input->post('is_private');
		if($this->item_model->share!=1){
			if($this->item_model->tool!=null&&$this->item_model->tool==1){
				$this->item_model->from = 'particle';
			}
		}
			if($this->item_model->tool!=null&&$this->item_model->tool==2){
				$this->item_model->from = 'dragonbones';
			}
			if($this->item_model->tool!=null&&$this->item_model->tool==3){
				$this->item_model->from = 'sea3d';
			}
			if($this->item_model->platform!=null&&$this->item_model->platform==3){
				$this->item_model->from = 'unity';
			}
        $this->item_model->update($id);
		
		if($_FILES["url"]["size"] !== 0)
		{
			
		
		$pic_path = '';
    	if ((($_FILES["url"]["type"] == "image/gif")
		|| ($_FILES["url"]["type"] == "image/jpeg")
		|| ($_FILES["url"]["type"] == "image/png")
		|| ($_FILES["url"]["type"] == "image/pjpeg"))
		&& ($_FILES["url"]["size"] < 2000000))
		  {
		  if ($_FILES["url"]["error"] > 0)
		    {
		    echo "Return Code: " . $_FILES["url"]["error"] . "<br />";
		    }
		  else
		    {
				$base_url=$this->config->item('base_url');
				$user_id = $id;
				$rs = array();
				$input = file_get_contents($_FILES["url"]["tmp_name"]);
				$data = $input;
				$upload_dir = 'item';
				$dir = UploadPath($upload_dir);
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
			$config['width'] = 400;
			$config['height'] = 320;
			
			$this->load->library('image_lib', $config); 
			
			$this->image_lib->resize();
			
    		$this->item_model->pic_url = $pic_path;
    		$this->item_model->thumb_url = base_url().'uploads/'.$upload_dir.'/'.$user_id.'_thumb.jpg';
    	}
    	$this->item_model->update($id);
	  }
	  if($this->item_model->share==null||$this->item_model->share==0){
	  if($_FILES["attach"]["size"] > 0)
		{
		  if($_FILES["attach"]["error"] !==4)
		  {
	    	$attachment_path = '';
	    	if ($_FILES["attach"]["size"] <50000000)
			  {
			  if ($_FILES["attach"]["error"] > 0)
			    {
			    echo "Return Code: " . $_FILES["attach"]["error"] . "<br />";
			    }
			  else
			    {
			    	$attach_id = create_guid();
					$base_url=$this->config->item('base_url');
					$user_id = $id;
					$rs = array();
					$input = file_get_contents($_FILES["attach"]["tmp_name"]);
					$filename = $_FILES['attach']['name'];
					preg_match('|\.(\w+)$|', $filename, $ext);
					$ext = strtolower($ext[1]);
					$this->item_model->extension = $ext;
					$data = $input;
					$upload_dir = 'attachment';
					$dir = UploadPath($upload_dir);
					$file_name=$dir.'/'.$attach_id.'.'.$ext;
			
					@file_put_contents($file_name, $data);
					$attachment_path = base_url().'uploads/'.$upload_dir.'/'.$attach_id.'.'.$ext;
					$rs['status'] = 1;		
			    }
			  }
		    	if($attachment_path!=''&&$attachment_path!=null){
		    		$this->item_model->download_url = $attachment_path;
		    	}
		    	$this->item_model->update($id);
		  }
		}
	  }
	  $this->load->model('item_history_model');	
        $this->item_history_model->item_id = $id;
        $this->item_history_model->action = "modify";
        $content = '';
        if($olditem['title']!=$this->item_model->title){
        	$content = $content."title to ".$this->item_model->title;
        }
        if($olditem['desc']!=$this->item_model->desc){
        	$content = $content."; description to ".$this->item_model->desc;
        }
        if($olditem['download_url']!=$this->item_model->download_url){
        	$content = $content."; attachment updated";
			$this->item_history_model->download_url = $this->item_model->download_url;
        }
		if($content!=''){
			$this->item_history_model->content = $content;
			$this->item_history_model->insertData();
		}
	    //$this->item_model->update($id);
		redirect(site_url('item/'.$id)); 
	}
	
	//delete item (click the delete button)
	function delete($itemid)
	{
		if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		$this->load->model('item_model');
        $data = array();
        if($itemid!=null&&$itemid!=0){
        	$data['item'] = $this->item_model->load($itemid);
        }
        if ($this->session->userdata('id')!=$data['item']['author_id']){         		
			redirect('home');
			exit();
		}
		if($itemid!=null&&$itemid!=0){
		    $this->item_model->delete_item($itemid);
		}
		$user_id = $this->session->userdata('id');
		$this->load->model('user_model');
		$user = $this->user_model->load($user_id);
		$user_point = $user['point'] - 10;
		$this->user_model->update_point($user_id,$user_point);
		echo '<script language="JavaScript">;alert("Delete successfully!");location.href="'.site_url('home').'"</script>;';
		//redirect('home');
	}
	
	function get_point()
	{
	
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
	
		$this->load->model('user_model');
		$user = $this->user_model->load($this->session->userdata('id'));
	
		echo $user['point'];
	
	}
	
	function enough($item_id)
	{
	
		if ($this->session->userdata('id')==null){
			redirect('login');
			exit();
		}
	
		$this->load->model('user_model');
		$user = $this->user_model->load($this->session->userdata('id'));
		
		$this->load->model('item_model');
		$item = $this->item_model->load($item_id);
		
		if($item['price_type']==1){
			if($user['point']>=$item['price']){
				echo 1;
			}else{
				echo 0;
			}
		}else if($item['price_type']==2){
			if(($user['balance']+$user['balance_usd']*6)>=$item['price']){
				echo 1;
			}else{
				echo 0;
			}
		}else if($item['price_type']==3){
			if(($user['balance']+$user['balance_usd']*6)>=$item['price']*6){
				echo 1;
			}else{
				echo 0;
			}
		}
	}
	
	function more_comments()
	{
		$this->load->model('item_comment_model');
		$load_comments = $this->item_comment_model->find_item_comments(array('item'=>$this->input->post('itemID')), 10, $this->input->post('offset'));
		$output = '';
		foreach ($load_comments as $comments) {		
			
			$output .= '<div class="single-comment">
			<div class="comment-user">
				<a class="comment-img" href="'. site_url("user/".$comments['author_id']).'"><img src="'.$comments['author_pic'].'" /></a>
				<div class="comment-username">
					<a href="'. site_url("user/".$comments['author_id']).'">'.$comments['author_name'].'</a>
					<span>'.trantime(strtotime($comments['create_date'])).'</span>';
					
			if ($this->session->userdata('id')) {
				$output .= '<a id="comment-reply">'.$this->lang->line('item_reply').'</a>';
			}
			$output .= '</div>
				</div>';
			
			if ($this->session->userdata('id')) {
				$output .= '<div id="reply-area">
					<textarea rows="1" name="reply-content" class="reply-content"></textarea>
					<a style="cursor:pointer;" class="reply-content form-sub" name="'.$comments['id'].'">'.$this->lang->line('item_reply').'</a>
				</div>';
			}
						
			$output	.= '<div class="t-content">';
			
			if ($comments['parent_id']!=0&&$comments['parent_id']!=null) {
				
				$output .= '<div class="parent-comment">
					
					<span>'. $comments['parent_user'].' '. trantime(strtotime($comments['parent_date'])).'</span>
					<p>'.$comments['parent_content'].'</p>
					
				</div>';
				
			}
				
			$output .= '<p>'.$comments['content'].'</p>
				
			</div>
		
		</div>';

		}
	
		echo $output;
	
	
	}
	
    function widget($toolkey,$featurename='MostAppreciated')
    {
    	$data['nav']= 'explore';
		$data['type']= 'all';
		$this->load->model('item_model');
		$data['item_num'] = $this->item_model->count_item_by_tool($featurename,$toolkey);
		$this->load->model('tool_model');
		$data['tool'] = $this->tool_model->loadbykey($toolkey);
		$data['feature'] = $featurename;
        $this->load->library('pagination');//加载分页类
        $config['base_url'] = base_url().'index.php/item/widget/'.$toolkey.'/'.$featurename;//设置分页的url路径
        $config['total_rows'] = $data['item_num'];//得到数据库中的记录的总条数
        $config['uri_segment'] = 5;
        $config['per_page'] = '2';//每页记录数
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<p>';
 	    $config['full_tag_close'] = '</p>'; 
        $this->pagination->initialize($config);//分页的初始化
        $this->load->model('item_type_model');
	        $data['item_type_list'] = $this->item_type_model->find_item_types();
		$this->load->model('item_model');
		$data['item_list'] = $this->item_model->order_item_by_tool_offset($featurename,$toolkey,$config['per_page'],$this->uri->segment(5));
		$this->load->view('widget/tool_item_list',$data);
    }
    
    
    function submitdemo($id)
    {
    	if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		if($this->session->userdata('language')) {
			$lang = $this->session->userdata('language');
			$data['lang']= $lang;
		}else{
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
	        if (preg_match("/zh-c/i", $lang)||$lang=='cn')
	        {
	        	$data['lang']= '2';
	        }else{
	        	$data['lang']= '1';
	        }
		}
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1), 100, 0);
		$this->load->model('platform_model');
		$data['platform_list'] = $this->platform_model->find_platforms(array(), 100, 0);
		$this->load->model('user_social_model');
		$data['social_list'] = $this->user_social_model->loadByUser($this->session->userdata('id'));
    	$this->load->model('tool_model');
    	$data['tool'] = $this->tool_model->load($id);
    	$this->load->view('item/item_demo',$data);
    }
    
    function submitshowcase($id)
    {
    	if ($this->session->userdata('id')==null){          		
			redirect('login');
			exit();
		}
		if($this->session->userdata('language')) {
			$lang = $this->session->userdata('language');
			$data['lang']= $lang;
		}else{
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
	        if (preg_match("/zh-c/i", $lang)||$lang=='cn')
	        {
	        	$data['lang']= '2';
	        }else{
	        	$data['lang']= '1';
	        }
		}
		$this->load->model('item_type_model');
		$data['item_type_list'] = $this->item_type_model->find_item_types(array('active'=>1), 100, 0);
		$this->load->model('platform_model');
		$data['platform_list'] = $this->platform_model->find_platforms(array(), 100, 0);
		$this->load->model('user_social_model');
		$data['social_list'] = $this->user_social_model->loadByUser($this->session->userdata('id'));
    	$this->load->model('tool_model');
    	$data['tool'] = $this->tool_model->load($id);
    	$this->load->view('item/item_showcase',$data);
    }
	
}
