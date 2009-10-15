<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=updatecache";

if(!$action){
	include PrintEot('updatecache');exit;
} elseif($action=='cache'){
	updatecache();
	adminmsg('operate_success');
} elseif($action=='template_cache'){
	updatecache_template();
	adminmsg('operate_success');
} elseif($action=='siteinfo'){
	@extract($db->get_one("SELECT COUNT(*) AS count FROM pv_members"));
	@extract($db->get_one("SELECT username FROM pv_members ORDER BY uid DESC LIMIT 1"));
	$db->update("UPDATE pv_siteinfo SET newmember='".addslashes($username)."', totalmember='$count' WHERE id='1'");
	adminmsg('operate_success');
}
?>