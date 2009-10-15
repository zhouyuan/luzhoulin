<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=upgrade";

if (empty($_POST['action'])){
	$db_upgrade=$db->get_one("SELECT * FROM pv_config WHERE db_name='db_upgrade'");	
	$db_upgrade = unserialize($db_upgrade['db_value']);
	include PrintEot('upgrade');exit;
}else{
	foreach($upgrade as $key=>$val){
		if(is_numeric($val)){
			$upgrade[$key]=$val;
		}else{
			$upgrade[$key]=0;
		}
	}
	$upgrade=serialize($upgrade);
	$db->pv_update(
		"SELECT db_name FROM pv_config WHERE db_name='db_upgrade'",
		"UPDATE pv_config SET db_value='$upgrade' WHERE db_name='db_upgrade'",
		"INSERT INTO pv_config(db_name,db_value) VALUES ('db_upgrade','$upgrade')"
	);
	updatecache_c();
	adminmsg('operate_success');
}
?>