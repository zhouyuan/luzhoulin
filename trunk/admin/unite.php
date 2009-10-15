<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=unite&type=$type";

if(!$_POST['action']){
	@include_once(D_P.'data/cache/class.php');
	@include_once(D_P.'data/cache/nation.php');
	include PrintEot('unite');exit;
} elseif($action == 'unite_class'){
	if($cid==$tocid){
		adminmsg('unite_same');
	}

	$sub=$db->get_one("SELECT cid FROM pv_class WHERE cup='$cid' LIMIT 1");
	if($sub)adminmsg('board_havesub');

	$db->update("UPDATE pv_video SET cid='$tocid' WHERE cid='$cid'");
	$db->update("DELETE FROM pv_class WHERE cid='$cid'");

	updatecache_class();
	adminmsg('operate_success');
}elseif($action == 'unite_nation'){
	if($nid==$tonid){
		adminmsg('unite_same');
	}

	$db->update("UPDATE pv_video SET nid='$tonid' WHERE nid='$nid'");
	$db->update("DELETE FROM pv_nations WHERE id='$nid'");

	updatecache_n();
	adminmsg('operate_success');
}
?>