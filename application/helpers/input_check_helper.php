<?php

function maketimes($time) {
	$t = time() - $time;
	$f = array (
		'31536000' => 'year',
		'2592000' => 'month',
		'604800' => 'week',
		'86400' => 'day',
		'3600' => 'hour',
		'60' => 'minutes',
		'1' => 'second'
	);
	foreach ($f as $k => $v) {
		if (0 != $c = floor($t / (int) $k)) {
			return $c . $v . 'ago';
		}
	}
}

function tranTime($time) {
	//date_default_timezone_set("PRC");
	$rtime = date("Y-m-d H:i", $time);
	$htime = date("H:i", $time);
	$time = time() - $time;
	if ($time < 60) {
		$str = ' just';
	}
	elseif ($time < 60 * 60) {
		$min = floor($time / 60);
		$str = $min . ' minutes ago';
	}
	elseif ($time < 60 * 60 * 24) {
		$h = floor($time / (60 * 60));
		$str = $h . ' hours ago ' . $htime;
	}
	elseif ($time < 60 * 60 * 24 * 3) {
		$d = floor($time / (60 * 60 * 24));
		if ($d == 0)
			$str = ' yesterday ' . $rtime;
		else
			$str = ' ' . $rtime;
	} else {
		$str = $rtime;
	}
	return $str;
}

function create_guid() {
	$charid = strtoupper(md5(uniqid(mt_rand(), true)));
	$hyphen = chr(45);// "-"
	$uuid = substr($charid, 0, 8).$hyphen
	.substr($charid, 8, 4).$hyphen
	.substr($charid,12, 4).$hyphen
	.substr($charid,16, 4).$hyphen
	.substr($charid,20,12);
	return $uuid;
}

function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
    $url = 'http://www.gravatar.com/avatar/';
    $d = 'http://www.effecthub.com/img/default.jpg';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function get_level ($level,$point)
{
	if($level==10){
		return "MVP";
	}else if($level==11){
		return "STAFF";
	}else{
		if($point<=50){
			return "MEMBER";
		}else if($point>50&&$point<=100){
			return "MEMBER +";
		}else if($point>100&&$point<=1000){
			return "MEMBER ++";
		}else if($point>1000&&$point<=10000){
			return "MEMBER +++";
		}else if($point>10000&&$point<=100000){
			return "MEMBER ++++";
		}else{
			return "MVP";
		}
	}
}

function getRealSize($size)
{ 
    $kb = 1024;         // Kilobyte
    $mb = 1024 * $kb;   // Megabyte
    $gb = 1024 * $mb;   // Gigabyte
    $tb = 1024 * $gb;   // Terabyte
    
    if($size < $kb)
    { 
        return $size." B";
    }
    else if($size < $mb)
    { 
        return round($size/$kb,1)."K";
    }
    else if($size < $gb)
    { 
        return round($size/$mb,1)."M";
    }
    else if($size < $tb)
    { 
        return round($size/$gb,1)."G";
    }
    else
    { 
        return round($size/$tb,1)."T";
    }
}

function getDirSize($dir)
{ 
    $handle = opendir($dir);
    while (false!==($FolderOrFile = readdir($handle)))
    { 
        if($FolderOrFile != "." && $FolderOrFile != "..")
        { 
            if(is_dir("$dir/$FolderOrFile"))
            { 
                $sizeResult += getDirSize("$dir/$FolderOrFile"); 
            }
            else
            { 
                $sizeResult += filesize("$dir/$FolderOrFile"); 
            }
        }    
    }
    closedir($handle);
    return $sizeResult;
}


?>