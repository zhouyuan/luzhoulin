<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=report";

if(!$action){
	(!is_numeric($page) || $page < 1) && $page=1;
	$limit="LIMIT ".($page-1)*$db_adminperpage.",$db_adminperpage";
	$rt=$db->get_one("SELECT COUNT(*) AS count FROM pv_report");
	$sum=$rt['count'];
	$numofpage=ceil($sum/$db_adminperpage);
	$pages=numofpage($sum,$page,$numofpage,"$basename&");
	$query=$db->query("SELECT r.*,m.username,v.subject FROM pv_report r LEFT JOIN pv_members m ON m.uid=r.uid LEFT JOIN pv_video v ON r.vid=v.vid ORDER BY id $limit");
	if($admin['grouptitle']=='校级管理员'){
		$sch = $admin['school'];
		$query=$db->query("SELECT r.*,m.username,v.subject FROM pv_report r LEFT JOIN pv_members m ON m.uid=r.uid LEFT JOIN pv_video v ON r.vid=v.vid where v.school ='$sch' ORDER BY id $limit");
	}
	else if($admin['grouptitle']=='区级管理员'){
		$reg = $admin['region'];
		$query=$db->query("SELECT r.*,m.username,v.subject FROM pv_report r LEFT JOIN pv_members m ON m.uid=r.uid LEFT JOIN pv_video v ON r.vid=v.vid where v.region = '$reg' ORDER BY id $limit");
	}
	
	while($rt=$db->fetch_array($query)){
		$reportdb[]=$rt;
	}
	include PrintEot('report');exit;
} elseif($action=='del'){
	if(!$selid = checkselid($selid)){
		adminmsg('operate_error');	
	}
	$db->update("DELETE FROM pv_report where id IN ($selid)");
	adminmsg('operate_success');
}
?>