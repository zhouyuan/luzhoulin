<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=sharelinks";

if (!$action){
	$threaddb=array();
	$query=$db->query("SELECT * FROM pv_sharelinks ORDER BY threadorder");
	while($share=$db->fetch_array($query)){
		strlen($share['url'])>30 && $share['url']=substrs($share['url'],30);
		strlen($share['descrip'])>30 && $share['descrip']=substrs($share['descrip'],30);
		$sharedb[]=$share;
	}
	include PrintEot('sharelink');exit;
} elseif ($action=="add"){
	if(!$step){
		include PrintEot('sharelink');exit;
	} else if(!$name || !$url) {
		adminmsg('operate_fail');
	} else if($step=='2'){
		$name    = Char_cv($name);
		$url     = Char_cv($url);
		$descrip = Char_cv($descrip);
		$logo    = Char_cv($logo);
		$db->update("INSERT INTO pv_sharelinks (threadorder ,name ,url ,descrip ,logo ) VALUES ('$threadorder', '$name', '$url', '$descrip', '$logo');");
		updatecache_sharelink();
		adminmsg('operate_success');
	}
} elseif($action=="edit"){
	if(!$step){
		@extract($db->get_one("SELECT * FROM pv_sharelinks WHERE sid='$sid'"));
		include PrintEot('sharelink');exit;
	} else if($step=='2'){
		if(!$name || !$url) adminmsg('operate_fail');
		$name    = Char_cv($name);
		$url     = Char_cv($url);
		$descrip = Char_cv($descrip);
		$logo    = Char_cv($logo);
		$db->update("UPDATE pv_sharelinks SET threadorder='$threadorder',name='$name',url='$url',descrip='$descrip',logo='$logo' WHERE sid='$sid'");

		updatecache_sharelink();
		adminmsg('operate_success');
	}
} elseif($action=="del"){
	if(!$selid = checkselid($selid)){
		adminmsg('operate_error');
	}
	$db->update("DELETE FROM pv_sharelinks where sid IN($selid)");
	updatecache_sharelink();
	adminmsg('operate_success');
}
?>