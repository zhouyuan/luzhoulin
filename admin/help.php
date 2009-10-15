<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=help";

if(!$action){
	$helpdb=array();
	$query=$db->query("SELECT * FROM pv_help");
	while($rt=$db->fetch_array($query)){
		$helpdb[]=$rt;
	}
	include PrintEot('help');exit;
}elseif($action=='add'){
	if(!$step){
		include PrintEot('help');exit;
	}elseif($step==2){
		(!$title || !$content) && adminmsg('operate_fail');
		$title = ieconvert($title);
		$content = ieconvert($content);
		$db->update("INSERT INTO pv_help (title,content) VALUES('$title','$content')");
		adminmsg("operate_success");
	}
}elseif($action=='edit'){
	if(!$step){
		@extract($db->get_one("SELECT * FROM pv_help WHERE id='$id'"));
		include PrintEot('help');exit;
	}elseif($step==2){
		(!$title || !$content) && adminmsg('operate_fail');
		$title = ieconvert($title);
		$content = ieconvert($content);
		$db->update("UPDATE pv_help SET title='$title',content='$content' WHERE id='$id'");
		adminmsg("operate_success");
	}
}elseif($action=='del'){
	if(!$selid=checkselid($selid)){
		adminmsg('operate_error');
	}
	$db->update("DELETE FROM pv_help WHERE id IN($selid)");
	adminmsg("operate_success");
}
?>