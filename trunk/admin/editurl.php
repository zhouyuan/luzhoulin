<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=editurl";

if (!$action){
	include PrintEot('editurl');exit;
}elseif($action=='shift'){
	$query=$db->query("SELECT uid,url FROM pv_urls");
	while($rt=$db->fetch_array($query)){
		$rt['url'] = str_replace($urla,$urlb,$rt['url']);
		$db->update("UPDATE pv_urls SET url='$rt[url]' WHERE uid='$rt[uid]'");
	}
	adminmsg('operate_success');
}
?>