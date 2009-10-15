<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=level";

if (empty($action)){
	$memberdb=$vipdb=$sysdb=$defaultdb=array();
	$query=$db->query("SELECT gid,gptype,grouptitle,groupimg,grouppost FROM pv_usergroups ORDER BY grouppost,gid");
	while($level=$db->fetch_array($query)){
		if($level['gptype']=='member'){
			$memberdb[]=$level;
		} elseif($level['gptype']=='system'){
			$sysdb[]=$level;
		} elseif($level['gptype']=='default'){
			$defaultdb[]=$level;
		}
	}
	include PrintEot('level');exit;
} elseif($action=="menedit"){
	@asort($mempost);	
	foreach($mempost as $key=>$value){
		if(!is_numeric($value)){
			$value=20*pow(2,$key);
			$mempost[$key]=$value;
		}
		$db->update("UPDATE pv_usergroups SET grouptitle='$memtitle[$key]',groupimg='$mempic[$key]',grouppost='".(int)$mempost[$key]."' WHERE gptype='member' AND gid='$key'");
	}
	updatecache_l();
	adminmsg('operate_success');
} elseif($action=="defedit"){
	foreach($deftitle as $key=>$value){
		$db->update("UPDATE pv_usergroups SET grouptitle='$value',groupimg='$defpic[$key]' WHERE gptype='default' AND gid='$key'");
	}
	updatecache_l();
	adminmsg('operate_success');
} elseif($action=="sysedit"){
	foreach($systitle as $key=>$value){
		$db->update("UPDATE pv_usergroups SET grouptitle='$value',groupimg='$syspic[$key]' WHERE gptype='system' AND gid='$key'");
	}
	updatecache_l();
	adminmsg('operate_success');
} elseif($action=="addmengroup"){
	$db->update("INSERT INTO pv_usergroups(gptype,grouptitle,groupimg,grouppost) VALUES ('member', '$newtitle', '$newpic','".(int)$newpost."')");
	updatecache_l();
	$gid=$db->insert_id();
	$basename="$admin_file?adminjob=level&action=editgroup&gid=$gid";
	adminmsg('operate_success');
} elseif($action=="addadmingroup"){
	$db->update("INSERT INTO pv_usergroups(gptype,grouptitle,groupimg,ifdefault) VALUES ('system', '$newtitle', '$newpic','0')");
	$gid=$db->insert_id();
	updatecache_g($gid);
	updatecache_l();
	$basename="$admin_file?adminjob=level&action=editgroup&gid=$gid";
	adminmsg('operate_success');
} elseif($action=="delgroup"){
	if($delid<5){
		adminmsg('level_del');
	}
	$db->update("DELETE FROM pv_usergroups WHERE gid='$delid'");
	updatecache_l();
	adminmsg('operate_success');
} elseif($action=="editgroup"){
	$basename="$admin_file?adminjob=level&action=editgroup&gid=$gid";
	if(!$step){
		if(file_exists(D_P."data/groupdb/group_$gid.php") && $gid!=1){
			include_once Pcv(D_P."data/groupdb/group_$gid.php");
			$default=0;
		} else{
			include_once(D_P."data/groupdb/group_1.php");
			$default=1;
		}
		@extract($SYSTEM);
		$selected_g[$gid]='selected';

		foreach($ltitle as $key=>$value){
			$groupselect.="<option value=$key $selected_g[$key]>$value</option>";
		}

		/*
		* 基本权限
		*/
		ifcheck($gp_allowread,'read');
		ifcheck($gp_allowrp,'reply');
		ifcheck($gp_allowhonor,'honor');
		ifcheck($gp_alloweditatc,'editatc');
		ifcheck($gp_allowdelatc,'delatc');
		ifcheck($gp_allowpost,'post');
		ifcheck($gp_allowmessage,'message');
		ifcheck($gp_allowplay,'play');
		ifcheck($gp_atccheck,'atccheck');
		ifcheck($gp_rpcheck,'rpcheck');
		ifcheck($gp_allowprofile,'profile');
		ifcheck($gp_allowseticon,'seticon');
		ifcheck($gp_allowupicon,'upicon');
		ifcheck($gp_allowsell,'sell');
		ifcheck($gp_allowencode,'encode');

		/*
		* 管理权限
		*/
		ifcheck($allowadmincp,'allowadmincp');
		ifcheck($allowadminedit,'allowadminedit');
		ifcheck($allowadmindel,'allowadmindel');
		ifcheck($allowadminshow,'allowadminshow');
		ifcheck($allowadminviewhide,'allowadminviewhide');

		include PrintEot('level');exit;

	} elseif($step==2){
		!isset($group['maxmsg']) && $group['maxmsg']=10;
		$group['ifdefault'] = $gid !=1 ? 0 : 1;

		if($gptype=='system'){
			foreach($sysgroup as $key => $value){
				$group[$key] = $value;
			}
		}

		$sql = "gid='$gid'";
		foreach($group as $key => $value){
			$sql .=",$key='$value'";
		}

		$db->update("UPDATE pv_usergroups SET $sql WHERE gid='$gid'");
		//updatecache_g();
		updatecache_g($gid);
		adminmsg('operate_success');
	} elseif($step==3){
		$db->update("UPDATE pv_usergroups SET ifdefault='1' WHERE gid='$gid'");
		P_unlink(D_P."data/groupdb/group_$gid.php");
		adminmsg('operate_success');
	}
}
?>