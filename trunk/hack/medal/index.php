<?php
!function_exists('readover') && exit('Forbidden');
include_once(R_P.'data/cache/md_config.php');
include_once(R_P.'data/cache/medaldb.php');
!$md_ifopen && Showmsg('medal_close');

$userdb = $db->get_one("SELECT medals FROM pv_members WHERE uid='$uid'");
if($userdb['medals']){
	$userdb['medals'] = explode(',',$userdb['medals']);
}else{
	$userdb['medals'] = '';
}
if(!$action){
	if($userdb['medals']){
		$ifunset = 0;
		foreach($userdb['medals'] as $key=>$val){
			if(!array_key_exists($val,$medaldb)){
				unset($userdb['medals'][$key]);
				$ifunset = 1;
			}
		}
		if($ifunset){
			$newmedals = implode(',',$userdb['medals']);
			$db->update("UPDATE pv_members SET medals='$newmedals' WHERE uid='$uid'");
			!$newmedals && updatemedal_list();
		}
	}
	require_once PrintHack('index');footer();
}elseif($action=='list'){
	$uids = substr(readover(R_P.'data/cache/medals_list.php'),8);
	if($uids!='')
	{
		(!is_numeric($page) || $page < 1) && $page = 1;
		$limit = "LIMIT ".($page-1)*$db_perpage.",$db_perpage";
		$rt    = $db->get_one("SELECT COUNT(*) AS sum FROM pv_members WHERE uid IN($uids)");
		$pages = numofpage($rt['sum'],$page,ceil($rt['sum']/$db_perpage),"$basename&action=list&");

		$listdb=array();
		$query = $db->query("SELECT uid,username,medals FROM pv_members WHERE uid IN($uids) ORDER BY uid $limit");
		while ($rt = $db->fetch_array($query)){
			$medals='';
			$md_a = explode(',',$rt['medals']);
			foreach($md_a as $key=>$value){
				if($value){
					$medals.="<img src=\"$imgpath/medal/{$medaldb[$value][picurl]}\" alt=\"{$medaldb[$value][name]}\"> ";
				}
			}
			$rt['medals'] = $medals;
			$listdb[] = $rt;
		}
	}
	require_once PrintHack('index');footer();
}elseif($action=='award'){
	if(strpos($md_groups,",$groupid,")===false){
		Showmsg('medal_groupright');
	}
	if(!$step){
		require_once PrintHack('index');footer();
	}elseif($step=="2"){
		$rt = $db->get_one("SELECT uid,username,medals FROM pv_members WHERE username='$pvuser'");
		Add_S($rt);
		!$rt && Showmsg('user_not_exists');
		!$reason && Showmsg('medal_noreason');
		$medals='';
		$medal=(int)$medal;
		!$medal && Showmsg('medal_nomedal');
		$reason = Char_cv($reason);

		require_once(R_P.'require/msg.php');
		if($type==1){ //°ä·¢
			if($rt['medals'] && strpos(",$rt[medals],",",$medal,")!==false){
				Showmsg('medal_alreadyhave');
			}elseif($rt['medals']){
				$medals="$rt[medals],$medal";
			}else{
				$medals=$medal;
			}
			if($md_ifmsg){
				$message=array(
					$pvuser,
					$uid,
					'metal_add',
					$timestamp,
					"metal_add_content",
					'',
					$username
				);
				writenewmsg($message,1);
			}
		}elseif($type==2){ //ÊÕ»Ø
			if(!$rt['medals'] || strpos(",$rt[medals],",",$medal,")===false){
				Showmsg('medal_none');
			}else{
				$medals=substr(str_replace(",$medal,",',',",$rt[medals],"),1,-1);
			}
			if($md_ifmsg){
				$message=array(
					$pvuser,
					$uid,
					'metal_cancel',
					$timestamp,
					"metal_cancel_content",
					'',
					$username
				);
				writenewmsg($message,1);
			}
			$timelimit=0;
			$db->update("UPDATE pv_medalslogs SET state='1' WHERE awardee='$pvuser' AND level='$medal'");
		}
		$medals==',' && $medals='';
		$db->update("UPDATE pv_members SET medals='$medals' WHERE uid='$rt[uid]'");
		$db->update("INSERT INTO pv_medalslogs(awardee,awarder,awardtime,timelimit,level,action,why) VALUES('$pvuser','$username','$timestamp','$timelimit','$medal','$type','$reason')");
		updatemedal_list();
		refreshto("$basename&action=list",'operate_success');
	}
}elseif($action=='log'){
	if(!$job){
		(!is_numeric($page) || $page < 1) && $page = 1;
		$limit = "LIMIT ".($page-1)*$db_perpage.",$db_perpage";
		$rt    = $db->get_one("SELECT COUNT(*) AS sum FROM pv_medalslogs");
		$pages = numofpage($rt['sum'],$page,ceil($rt['sum']/$db_perpage),"$basename&action=log&");

		$logdb=array();
		$query = $db->query("SELECT * FROM pv_medalslogs ORDER BY id DESC $limit");
		while ($rt = $db->fetch_array($query)){
			$rt['awardtime'] = get_date($rt['awardtime']);
			$logdb[] = $rt;
		}
		require_once PrintHack('index');footer();
	}elseif($job=='del'){
		$groupid != '3' && Showmsg('medal_dellog');
		$id=(int)$id;
		$rt=$db->get_one("SELECT id,state,action,timelimit FROM pv_medalslogs WHERE id='$id'");
		if($rt['action']==1 && $rt['state']==0 && $rt['timelimit']>0){
			Showmsg('medallog_del_error');			
		}
		$db->update("DELETE FROM pv_medalslogs WHERE id='$id'");
		refreshto("$basename&action=log",'operate_success');
	}
}

function updatemedal_list(){
	global $db;
	$query = $db->query("SELECT uid,medals FROM pv_members WHERE medals!=''");
	$medaldb = '<?die;?>0';
	while($rt=$db->fetch_array($query)){
		if(str_replace(',','',$rt['medals'])){
			$medaldb .= ','.$rt['uid'];
		}
	}
	writeover(R_P.'data/cache/medals_list.php',$medaldb);
}
?>