<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=nation";

if (!$action){
	$nationdb=array();
	$query=$db->query("SELECT * FROM pv_nations ORDER BY vieworder");
	while($nation=$db->fetch_array($query)){
		$nationdb[]=$nation;
	}
	include PrintEot('nation');exit;
} elseif ($action=="add"){
	if(trim($subject)==''){
		adminmsg('operate_fail');
	}
	$subject = Char_cv($subject);
	$db->update("INSERT INTO pv_nations SET subject='$subject';");	
	updatecache_n();
	adminmsg('operate_success');
} elseif($action=="edit"){
	foreach($vieworder as $key=>$value){		
		$db->update("UPDATE pv_nations SET vieworder='$vieworder[$key]',subject='$subject[$key]' WHERE id='$key'");
	}
	updatecache_n();
	adminmsg('operate_success');
} elseif($action=="del"){
	$db->update("DELETE FROM pv_nations WHERE id='$id'");
	updatecache_n();
	adminmsg('operate_success');
}
?>