<?php
require_once('global.php');
!is_numeric($vid) && Showmsg('video_illegal');
$groupid=='guest' && Showmsg('not_login');

$rt=$db->get_one("SELECT vid FROM pv_report WHERE uid='$uid' AND vid='$vid'");
if($rt)	Showmsg('have_report');
if(!$step){
	require_once(R_P.'require/header.php');
	require_once PrintEot('report');footer();
} else {
	$reason=Char_cv($reason);
	$type=Char_cv($type);
	$db->update("INSERT INTO pv_report(vid,uid,type,reason) VALUES('$vid','$uid','$type','$reason')");
	refreshto("./read.php?vid=$vid",'operate_success');
}

?>