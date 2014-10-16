<?php
function post($sUrl,$aPOSTParam,$header){
	$oCurl = curl_init();
	/*if(stripos($sUrl,"https://")!==FALSE){
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
	}*/
	$aPOST = array();
	foreach($aPOSTParam as $key=>$val){
		$aPOST[] = $key."=".urlencode($val);
	}
	curl_setopt($oCurl, CURLOPT_URL, $sUrl);
	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt($oCurl, CURLOPT_POST,true);
	curl_setopt($oCurl, CURLOPT_POSTFIELDS, join("&", $aPOST));
	$opts[CURLOPT_HTTPHEADER] = $header;
	curl_setopt($oCurl, CURLOPT_HTTPHEADER, $header );
	$sContent = curl_exec($oCurl);
	$aStatus = curl_getinfo($oCurl);
	echo '$sContent'.$sContent;
	echo '$aStatus'.$aStatus;
	curl_close($oCurl);
	if(intval($aStatus["http_code"])==200){
		return $sContent;
	}else{
		echo $aStatus["http_code"];
		return FALSE;
	}
}

function get($sUrl,$aGetParam,$header=null){
	$oCurl = curl_init();
	/*if(stripos($sUrl,"https://")!==FALSE){
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
	}*/
	$aGet = array();
	foreach($aGetParam as $key=>$val){
		$aGet[] = $key."=".urlencode($val);
	}
	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($oCurl, CURLOPT_ENCODING, "");
	curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($oCurl, CURLOPT_HEADER, FALSE);
	if($header!=null)
	curl_setopt($oCurl, CURLOPT_HTTPHEADER, $header );
	curl_setopt($oCurl, CURLINFO_HEADER_OUT, TRUE );
	curl_setopt($oCurl, CURLOPT_URL, $sUrl."?".join("&",$aGet));
	//echo $sUrl."?".join("&",$aGet);
	$sContent = curl_exec($oCurl);
	$aStatus = curl_getinfo($oCurl);
	curl_close($oCurl);
	//echo '$sContent'.$sContent;
	//echo '$aStatus'.$aStatus;
	if(intval($aStatus["http_code"])==200){
		return $sContent;
	}else{
		echo $aStatus["http_code"];
		return FALSE;
	}
}

function upload($sUrl,$aPOSTParam,$header,$aFileParam){
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
	
    $header[] = 'Expect:'; 
    $opts[CURLOPT_HTTPHEADER] = $header;
    echo $oCurl;
	$sContent = curl_exec($oCurl);
	$aStatus = curl_getinfo($oCurl);
	echo '$sContent'.$sContent;
	echo '$aStatus'.$aStatus;
	curl_close($oCurl);
	if(intval($aStatus["http_code"])==200){
		return $sContent;
	}else{
		echo $aStatus["http_code"];
		return FALSE;
	}
}
?>