<?php
//上传文件
function DiskPath($user_id,$dir,$parent_dir='') {
	//判断创建新的目录
	if(!defined('ROOT_PATH')){
		define ( 'ROOT_PATH', str_replace ( 'application/helpers/my_form_helper.php', '', str_replace ( '\\', '/', __FILE__ ) ) );
	}
	$user_dir = ROOT_PATH . 'disk/' . $user_id;
	if (! file_exists ( $user_dir)) {
		@mkdir ( $user_dir . "/", 0777 );
	}
	if($parent_dir!=''){
		if (! file_exists ( $user_dir . "/" . $parent_dir )) {
			@mkdir ( $user_dir . "/". $parent_dir . "/", 0777 );
		}
		if($dir){
			if (! file_exists ( $user_dir . "/" . $parent_dir . "/" . $dir )) {
				@mkdir ( $user_dir . "/". $parent_dir . "/". $dir . "/", 0777 );
			}
			return $user_dir . '' .  "/" . $parent_dir .  "/" . $dir;
		}else{
			return $dir . '';
		}
	}else{
		if($dir){
			if (! file_exists ( $user_dir . "/" . $dir )) {
				@mkdir ( $user_dir . "/". $dir . "/", 0777 );
			}
			return $user_dir . '' .  "/" . $dir;
		}else{
			return $dir . '';
		}
	}
}

function DiskParentPath($dir,$parent_dir='') {
	//判断创建新的目录
	if(!defined('ROOT_PATH')){
		define ( 'ROOT_PATH', str_replace ( 'application/helpers/my_form_helper.php', '', str_replace ( '\\', '/', __FILE__ ) ) );
	}
	$parent_dir = ROOT_PATH . 'disk/' . $parent_dir;
	if (! file_exists ( $parent_dir)) {
		@mkdir ( $parent_dir . "/", 0777 );
	}
	if($parent_dir!=''){
		if($dir){
			if (! file_exists ( $parent_dir . "/" . $dir )) {
				@mkdir ( $parent_dir . "/". $dir . "/", 0777 );
			}
			return $parent_dir .  "/" . $dir;
		}else{
			return $parent_dir . '';
		}
	}else{
		return $parent_dir;
	}
}

function UploadPath($dir,$user_id='') {
	//判断创建新的目录
	if(!defined('ROOT_PATH')){
		define ( 'ROOT_PATH', str_replace ( 'application/helpers/my_form_helper.php', '', str_replace ( '\\', '/', __FILE__ ) ) );
	}
	$dir = ROOT_PATH . 'uploads/' . $dir . '/';
	if (! file_exists ( $dir)) {
		@mkdir ( $dir . "/", 0777 );
	}
	if($user_id){
		$dir3=$user_id;
		if (! file_exists ( $dir . "/" . $dir3 )) {
			@mkdir ( $dir . "/". $dir3 . "/", 0777 );
		}
		return $dir . '' .  "/" . $dir3;
	}else{
		//echo $dir.''.$dir1."/".$dir2; exit;
		return $dir . '';
	}

}

function CodefilePath($dir,$user_id='') {
	//判断创建新的目录
	if(!defined('ROOT_PATH')){
		define ( 'ROOT_PATH', str_replace ( 'application/helpers/my_form_helper.php', '', str_replace ( '\\', '/', __FILE__ ) ) );
	}
	$dir = ROOT_PATH . 'uploads/' . $dir . '/';
	if (! file_exists ( $dir)) {
		@mkdir ( $dir . "/", 0777 );
	}
	if($user_id){
		$dir3=$user_id;
		if (! file_exists ( $dir . "/" . $dir3 )) {
			@mkdir ( $dir . "/". $dir3 . "/", 0777 );
		}
		return $dir . '' .  "/" . $dir3;
	}else{
		//echo $dir.''.$dir1."/".$dir2; exit;
		return $dir . '';
	}

}

function CompilePath($dir,$uid='') {
	//判断创建新的目录
	if(!defined('ROOT_PATH')){
		define ( 'ROOT_PATH', str_replace ( 'application/helpers/my_form_helper.php', '', str_replace ( '\\', '/', __FILE__ ) ) );
	}
	$dir = ROOT_PATH . 'result/' . $dir . '/';
	if (! file_exists ( $dir)) {
		@mkdir ( $dir . "/", 0777 );
	}
	if($uid){
		$dir3=$uid;
		if (! file_exists ( $dir . "/" . $dir3 )) {
			@mkdir ( $dir . "/". $dir3 . "/", 0777 );
		}
		return $dir . '' .  "/" . $dir3;
	}else{
		return $dir . '';
	}

}

function UploadPath1($dir,$user_id='') {
	//判断创建新的目录
	if(!defined('ROOT_PATH')){
		define ( 'ROOT_PATH', str_replace ( 'application/helpers/my_form_helper.php', '', str_replace ( '\\', '/', __FILE__ ) ) );
	}
	$dir = ROOT_PATH . 'uploads/' . $dir . '/';
	$dir1 = date ( "Y", time () );
	$dir2 = date ( "m", time () );
	if (! file_exists ( $dir . $dir1 )) {
		@mkdir ( $dir . $dir1 . "/", 0777 );
	}
	if (! file_exists ( $dir . $dir1 . "/" . $dir2 )) {
		@mkdir ( $dir . $dir1 . "/" . $dir2 . "/", 0777 );
	}
	if($user_id){
		$dir3=$user_id;
		if (! file_exists ( $dir . $dir1 . "/" . $dir2 . "/" . $dir3 )) {
			@mkdir ( $dir . $dir1 . "/" . $dir2 . "/". $dir3 . "/", 0777 );
		}
		return $dir . '' . $dir1 . "/" . $dir2. "/" . $dir3;
	}else{
		//echo $dir.''.$dir1."/".$dir2; exit;
		return $dir . '' . $dir1 . "/" . $dir2;
	}

}

//缩略图路径调用
function get_thumb_pic($pic_id,$thumb) {
	$pic_id_1=explode(".",$pic_id);
	if($pic_id_1[0]){
		$pic_id_new=$pic_id_1[0].'_'.$thumb.'.'.$pic_id_1[1];
	}else{
		$pic_id_new = 'no_pic_50X50.jpg';
	}
	return $pic_id_new;
}

function msubstr($str, $start, $len) {
$null = "";
    preg_match_all("/./u", $str, $ar); 
    if(func_num_args() >= 3) { 
        $end = func_get_arg(2); 
        return join($null, array_slice($ar[0],$start,$end)); 
    } else { 
        return join($null, array_slice($ar[0],$start)); 
    } 
}
