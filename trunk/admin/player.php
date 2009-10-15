<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=player";

if (!$action){
	$playerdb=array();
	$query=$db->query("SELECT * FROM pv_player ORDER BY pid");
	while($player=$db->fetch_array($query)){
		$playerdb[]=$player;
	}
	include PrintEot('player');exit;
} elseif ($action=="add"){
	if(!$_POST['step']){
		include PrintEot('player');exit;
	} elseif ($step=='2'){
		if(!trim($name) || !trim($content) || !trim($playpath)) adminmsg('operate_fail');
		$name     = Char_cv($name);
		$subject  = Char_cv($subject);
		$content  = exchange($content);
		writeplay();
		$db->update("INSERT INTO pv_player (hidden,name,subject,playpath) VALUES ('$hidden','$name','$subject','$playpath');");
		updatecache_p();
		adminmsg('operate_success');
	}
} elseif($action=="edit"){
	if(!$_POST['step']){
		@extract($db->get_one("SELECT * FROM pv_player WHERE pid='$pid'"));
		ifcheck($hidden,'hidden');
		$content = readover(R_P.'data/player/'.$playpath);
		include PrintEot('player');exit;
	} elseif($step=='2'){
		if(!trim($name) || !trim($content) || !trim($playpath)) adminmsg('operate_fail');
		$name     = Char_cv($name);
		$subject  = Char_cv($subject);
		$content  = exchange($content);
		editplay();
		$db->update("UPDATE pv_player SET hidden='$hidden',name='$name',subject='$subject',playpath='$playpath' WHERE pid='$pid'");
		updatecache_p();
		adminmsg('operate_success');
	}
} elseif($action=="del"){
	if($selid){
		foreach($selid as $pid){
			delplay();
			$db->update("DELETE FROM pv_player WHERE pid='$pid'");
		}
	}
	$db->update("UPDATE pv_player SET hidden=0");
	if($applyid = checkselid($applyid)){
		$db->update("UPDATE pv_player SET hidden=1 WHERE pid IN($applyid)");
	}
	updatecache_p();
	adminmsg('operate_success');
}
function writeplay(){
	global $db,$content,$playpath;
	writeover(R_P.'data/player/'.$playpath,$content);
}
function editplay(){
	global $db,$content,$playpath,$pid;
	$query=$db->query("SELECT playpath FROM pv_player WHERE pid='$pid'");
	$rt = $db->fetch_array($query);
	if($rt['playpath'] == $playpath){
		writeover(D_P.'data/player/'.$playpath,$content);
	}else{
		@rename("data/player/".$rt['playpath'],"data/player/".$playpath);
		writeover(D_P.'data/player/'.$playpath,$content);
	}
}
function delplay(){
  global $db,$pid;
  @extract($db->get_one("SELECT playpath FROM pv_player WHERE pid='$pid'"));
  @unlink(R_P.'data/player/'.$playpath);
}
function exchange($connt){
	$connt = str_replace('\"',"\"",$connt);
	$connt = str_replace("\'","'",$connt);
	return $connt;
}
?>