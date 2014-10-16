<?php
/*
 * GET请求
*/
function get($sUrl,$aGetParam){
	$oCurl = curl_init();
	if(stripos($sUrl,"https://")!==FALSE){
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
	}
	$aGet = array();
	foreach($aGetParam as $key=>$val){
		$aGet[] = $key."=".urlencode($val);
	}
	curl_setopt($oCurl, CURLOPT_URL, $sUrl."?".join("&",$aGet));
	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
	$sContent = curl_exec($oCurl);
	$aStatus = curl_getinfo($oCurl);
	curl_close($oCurl);
	if(intval($aStatus["http_code"])==200){
		return $sContent;
	}else{
		echo $aStatus["http_code"];
		return FALSE;
	}
}

/*
 * POST 请求
*/
function post($sUrl,$aPOSTParam){
	$oCurl = curl_init();
	if(stripos($sUrl,"https://")!==FALSE){
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
	}
	$aPOST = array();
	foreach($aPOSTParam as $key=>$val){
		$aPOST[] = $key."=".urlencode($val);
	}
	curl_setopt($oCurl, CURLOPT_URL, $sUrl);
	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt($oCurl, CURLOPT_POST,true);
	curl_setopt($oCurl, CURLOPT_POSTFIELDS, join("&", $aPOST));
	$sContent = curl_exec($oCurl);
	$aStatus = curl_getinfo($oCurl);
	curl_close($oCurl);
	if(intval($aStatus["http_code"])==200){
		return $sContent;
	}else{
		echo $aStatus["http_code"];
		return FALSE;
	}
}

/*
 * 上传图片
*/
function upload($sUrl,$aPOSTParam,$aFileParam){
	//防止请求超时
	set_time_limit(0);
	$oCurl = curl_init();
	if(stripos($sUrl,"https://")!==FALSE){
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
	}
	$aPOSTField = array();
	foreach($aPOSTParam as $key=>$val){
		$aPOSTField[$key]= $val;
	}
	foreach($aFileParam as $key=>$val){
		$aPOSTField[$key] = "@".$val; //此处对应的是文件的绝对地址
	}
	curl_setopt($oCurl, CURLOPT_URL, $sUrl);
	curl_setopt($oCurl, CURLOPT_POST, true);
	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt($oCurl, CURLOPT_POSTFIELDS, $aPOSTField);
	$sContent = curl_exec($oCurl);
	$aStatus = curl_getinfo($oCurl);
	curl_close($oCurl);
	if(intval($aStatus["http_code"])==200){
		return $sContent;
	}else{
		echo $aStatus["http_code"];
		return FALSE;
	}
}
