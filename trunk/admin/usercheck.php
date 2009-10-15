<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=usercheck";

if (!$action){
	(!is_numeric($page) || $page < 1) && $page = 1;
	$limit = "LIMIT ".($page-1)*$db_adminperpage.",$db_adminperpage";
	$rt    = $db->get_one("SELECT COUNT(*) AS sum FROM pv_members WHERE groupid='4'");
	$pages = numofpage($rt['sum'],$page,ceil($rt['sum']/$db_adminperpage),"$basename&");
	$memdb=array();
	$query=$db->query("SELECT * FROM pv_members WHERE groupid='4' $limit");
	while($member=$db->fetch_array($query)){
		$member['regdate']=get_date($member['regdate']);
		$memdb[]=$member;
	}
	include PrintEot('usercheck');exit;
}
elseif($action=='check'){
	!$yzmem && adminmsg('operate_error');
	$uids=checkselid($yzmem);
	if($uids){
		if($type=='pass'){
			$db->update("UPDATE pv_members SET groupid='-1' WHERE uid IN($uids)");
		}else{
			$db->update("DELETE FROM pv_members WHERE uid IN ($uids)");
			$db->update("DELETE FROM pv_memberdata WHERE uid IN ($uids)");
			@extract($db->get_one("SELECT count(*) AS count FROM pv_members"));
			@extract($db->get_one("SELECT username FROM pv_members ORDER BY uid DESC LIMIT 1"));
			$db->update("UPDATE pv_siteinfo SET newmember='$username', totalmember='$count'  WHERE id='1'");
		}
	}
	adminmsg('operate_success');
}

?>