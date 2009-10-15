<?php
!function_exists('adminmsg') && exit('Forbidden');
require_once(R_P."require/credit.php");
$basename="$admin_file?adminjob=credit";

if(empty($action)){
	$credit=$db->query("SELECT * FROM pv_credits ORDER BY cid");
	include PrintEot('credit');exit;
} elseif($action=='edit'){
	if(!$step){
		$creditdb=$db->get_one("SELECT * FROM pv_credits WHERE cid='$cid'");
		if(!$creditdb)adminmsg('credit_error');
		include PrintEot('credit');exit;
	} else{
		$db->update("UPDATE pv_credits SET name='$name',description='$description' WHERE cid='$cid'");
		updatecache_credit();
		adminmsg('operate_success');
	}
}elseif($action=='newcredit'){
	if(!$step){
		include PrintEot('credit');exit;
	} else{
		$db->update("INSERT INTO pv_credits(name,description) VALUES('$name','$description')");
		updatecache_credit();
		adminmsg('operate_success');
	}
}elseif($action=='delete'){
	$delcids='';
	if(!$delcid)adminmsg('operate_error');
	foreach($delcid as $id){
		is_numeric($id) && $delcids.=$id.',';
	}
	if($delcids){
		$delcids=substr($delcids,0,-1);
		$db->update("DELETE FROM pv_credits WHERE cid IN($delcids)");
		$db->update("DELETE FROM pv_membercredit WHERE cid IN($delcids)");
		updatecache_credit();
		adminmsg('operate_success');
	} else{
		adminmsg('operate_fail');
	}
}elseif($action=='usercredit'){
	if(!$step)
	{
		include PrintEot('credit');
		exit;
	}
	elseif($step=='1')
	{
		$rt = $db->get_one("SELECT uid,username FROM pv_members WHERE username='$username'");
		!$rt && adminmsg('user_not_exists');
		$credit = GetCredit($rt['uid']);
		include PrintEot('credit');exit;		
	}
	elseif($step=='2')
	{
		!is_numeric($uid) && adminmsg('operate_error');
		foreach($creditdb as $key => $value){
			if(is_numeric($key) && is_numeric($value)){
				$db->pv_update(
					"SELECT uid FROM pv_membercredit WHERE uid='$uid' AND cid='$key'",
					"UPDATE pv_membercredit SET value='$value' WHERE uid='$uid' AND cid='$key'",
					"INSERT INTO pv_membercredit SET uid='$uid',cid='$key',value='$value'"
				);
			}
		}


		adminmsg('operate_success');
	}
}
?>
