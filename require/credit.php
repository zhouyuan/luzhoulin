<?php
!function_exists('readover') && exit('Forbidden');

function GetCredit($uid){
	global $db,$_CREDITDB;
	$credit = array();
	isset($_CREDITDB) || @include(R_P.'data/cache/creditdb.php');
	foreach($_CREDITDB as $key => $value){
		$credit[$key] = array($value[0],0);
	}
	$query = $db->query("SELECT cid,value FROM pv_membercredit WHERE uid='$uid'");
	while($rt = $db->fetch_array($query)){
		$credit[$rt['cid']]=array($_CREDITDB[$rt['cid']][0],$rt['value']);
	}
	return $credit;
}

function customcredit($uid,$creditset,$option){
	global $db;
	@include (R_P.'data/cache/creditdb.php');
	foreach($_CREDITDB as $key => $value){
		if($creditset[$key][$option]){
			if($option == 'Post' || $option == 'Reply'){
				$addpoint = $creditset[$key][$option];
			} else{
				$addpoint = -$creditset[$key][$option];
			}

			$db->pv_update(
				"SELECT uid FROM pv_membercredit WHERE uid='$uid' AND cid='$key'",
				"UPDATE pv_membercredit SET value=value+'$addpoint' WHERE uid='$uid' AND cid='$key'",
				"INSERT INTO pv_membercredit SET uid='$uid',cid='$key',value='$addpoint'"
			);
		}
	}
}

?>