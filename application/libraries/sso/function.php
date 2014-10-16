<?php 
function encodeCookie($id,$userName,$displayName,$email,$group){
	global $cookieConf;
	$arr = array(
		'id' => $id,
		'userName' => $userName,
		'displayName' => $displayName,
		'email' => $email,
		'group' => $group,
		'ip' => $_SERVER['REMOTE_ADDR'],
	);
	$data = serialize($arr);
	$cryptData = mcrypt_encrypt($cookieConf['cipher'], $cookieConf['key'],
		utf8_encode($data), $cookieConf['mode']);
	$cryptData = base64_encode($cryptData);
	setcookie($cookieConf['name'],$cryptData,$cookieConf['expire'],
		$cookieConf['path']);

}

function decodeCookie(){
	global $cookieConf;
	try{
		$cryptData = $_COOKIE[$cookieConf['name']];
		if($cryptData == null || $cryptData == ""){
			return null;
		}
		$cryptData = base64_decode($cryptData);
		$data = mcrypt_decrypt($cookieConf['cipher'], $cookieConf['key'],
			$cryptData, $cookieConf['mode']);
		$arr = unserialize(utf8_decode($data));
		if($arr['ip'] != $_SERVER['REMOTE_ADDR']){
			return null;
		}else{
			return $arr;
		}
	}catch(Exception $e){
		return null;
	}
	return null;
}

function deleteSSOCookie(){
	global $cookieConf;
	delete_cookie($cookieConf['name']);
}