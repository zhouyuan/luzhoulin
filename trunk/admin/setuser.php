<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=setuser";

if (!$action){
	$groupselect="<option value='-1'>普通会员</option>";
	$query=$db->query("SELECT gid,gptype,grouptitle FROM pv_usergroups WHERE gptype<>'member' AND gptype<>'default' ORDER BY gid");
	while($group=$db->fetch_array($query)){
		$groupselect.="<option value=$group[gid]>$group[grouptitle]</option>";
	}
	include PrintEot('setuser');exit;
} elseif($action=='addnew'){
	if(!$groupid)$groupid='-1';
	if(!$username ||!$password||!$email){
		adminmsg('setuser_empty');
	} else{
		$username=trim($username);
		$S_key=array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n",'#');
		foreach($S_key as $value){
			if (strpos($username,$value)!==false){
				adminmsg('illegal_username');
			}
			if (strpos($password,$value)!==false){
				adminmsg('illegal_password');
			}
		}
		if(strlen($username)>14 || strrpos($username,"|")!==false || strrpos($username,'.')!==false || strrpos($username,' ')!==false || strrpos($username,"'")!==false || strrpos($username,'/')!==false || strrpos($username,'*')!==false || strrpos($username,";")!==false || strrpos($username,",")!==false || strrpos($username,"<")!==false || strrpos($username,">")!==false){
			adminmsg('illegal_username');
		}
		if (strrpos($password,"\r")!==false || strrpos($password,"\t")!==false || strrpos($password,"|")!==false || strrpos($password,"<")!==false || strrpos($password,">")!==false){
			adminmsg('illegal_password');
		} else{
			$password=md5($password);
		}
		if ($email&&!ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,3}$",$email)){
			adminmsg('illegal_email');
		}
		$rs = $db->get_one("SELECT COUNT(*) AS count FROM pv_members WHERE username='$username'");
		if($rs['count']>0) {
			adminmsg('username_exists');
		}
	}

	asort($lneed);
	$memberid=key($lneed);
	$db->update("INSERT INTO pv_members(username,password,email,groupid,memberid,regdate) VALUES('$username','$password','$email','$groupid','$memberid','$timestamp')");
	$voduid=$db->insert_id();
	$db->update("INSERT INTO pv_memberdata (uid,postnum,rvrc,money,onlineip) VALUES ('$voduid','0','$rg_regrvrc','$rg_regmoney','$onlineip')");
	$db->update("UPDATE pv_siteinfo SET newmember='$username',totalmember=totalmember+1 WHERE id='1'");
	adminmsg('operate_success');

} elseif($action=='search'){
	$sql = is_numeric($groupid) ? "m.groupid='$groupid'" : 1;

	$schname = trim($schname);
	if($schname!=''){
		$schname=addslashes(str_replace('*','%',$schname));
		$sql.=$schname_s==1 ? " AND m.username LIKE '$schname'" : " AND (m.username LIKE '%$schname%')" ;
	}
	if($schemail!=''){
		$schemail=str_replace('*','%',$schemail);
		$sql.=" AND (m.email LIKE '%$schemail%')";
	}
	if($userip!=''){
		$userip=str_replace('*','%',$userip);
		$sql.=" AND (md.onlineip LIKE '%$userip%')";
	}
	if($regdate!='all' && is_numeric($regdate)){
		$schtime=$timestamp-$regdate;
		$sql.=" AND m.regdate<'$schtime'";
	}
	if($orderway){
		$order="ORDER BY '$orderway'";
		$asc && $order.=$asc;
	}
	$rs=$db->get_one("SELECT COUNT(*) AS count FROM pv_members m LEFT JOIN pv_memberdata md ON md.uid=m.uid WHERE $sql");
	$count=$rs['count'];
	if(!is_numeric($lines))$lines=100;
	(!is_numeric($page) || $page < 1) && $page=1;
	$numofpage=ceil($count/$lines);
	if($numofpage&&$page>$numofpage){
		$page=$numofpage;
	}
	$pages=numofpage($count,$page,$numofpage,"$admin_file?adminjob=setuser&action=$action&schname=".rawurlencode($schname)."&schemail=$schemail&regdate=$regdate&orderway=$orderway&lines=$lines&");
	$start=($page-1)*$lines;
	$limit="LIMIT $start,$lines";
	$groupselect="<option value='-1'>普通会员</option>";
	$query=$db->query("SELECT gid,gptype,grouptitle FROM pv_usergroups WHERE gptype<>'member' AND gptype<>'default' ORDER BY gid");
	while($group=$db->fetch_array($query)){
		$gid=$group['gid'];
		$groupselect.="<option value='$gid'>$group[grouptitle]</option>";
	}
	$schdb=array();
	$query=$db->query("SELECT m.uid,m.username,m.email,m.groupid,m.regdate,md.postnum,md.onlineip FROM pv_members m LEFT JOIN pv_memberdata md ON md.uid=m.uid WHERE $sql $order $limit");
	while($sch=$db->fetch_array($query)){
		$sch['regdate']= get_date($sch['regdate']);
		strpos($sch['onlineip'],'|') && $sch['onlineip']=substr($sch['onlineip'],0,strpos($sch['onlineip'],'|'));

		if($sch['groupid']=='-1'){
			$sch['groupselect']=str_replace("<option value='-1'>普通会员</option>","<option value='-1' selected>普通会员</option>",$groupselect);
		} else{
			$sch['groupselect']=str_replace("<option value='$sch[groupid]'>".$ltitle[$sch['groupid']]."</option>","<option value='$sch[groupid]' selected>".$ltitle[$sch['groupid']]."</option>",$groupselect);
		}

		$schdb[]=$sch;
	}
	include PrintEot('setuser');exit;
} elseif($action=='editgroup'){

	if(!$gid) adminmsg('operate_error');
	$selid = checkselid($selid);

	foreach($gid as $uid=>$groupid){
		if(strpos($selid,(string)$uid)===false){
			$db->update("UPDATE pv_members SET groupid='$groupid' WHERE uid='$uid'");
		}
		else {
			$db->update("DELETE FROM pv_members WHERE uid IN($selid)");
			$db->update("DELETE FROM pv_memberdata WHERE uid IN($selid)");
		}

	}

	adminmsg('operate_success');

} elseif($action=='edit'){
	if(!$step){
		@extract($db->get_one("SELECT m.*,md.* FROM pv_members m LEFT JOIN pv_memberdata md ON md.uid=m.uid WHERE m.uid='$uid'"));

		$groupselect="<option value='-1'>普通会员</option>";
		$query=$db->query("SELECT gid,gptype,grouptitle FROM pv_usergroups WHERE gptype<>'member' AND gptype<>'default' ORDER BY gid");
		while($group=$db->fetch_array($query)){
			$groupselect.="<option value='$group[gid]'>$group[grouptitle]</option>";
		}

		$groupselect = str_replace("<option value='$groupid'>","<option value='$groupid' selected>",$groupselect);

		if(strpos($onlineip,'|')){
			$onlineip=substr($onlineip,0,strpos($onlineip,'|'));
		}
		$regdate=get_date($regdate);
		$ifchecked=$publicmail ? 'checked' : '';
		$receivemail ? $email_open='checked' : $email_close='checked';
		$sexselect[$gender]='selected';
		$getbirthday = explode("-",$bday);
		$yearslect[(int)$getbirthday[0]]="selected";
		$monthslect[(int)$getbirthday[1]]="selected";
		$dayslect[(int)$getbirthday[2]]="selected";

		include PrintEot('setuser');exit;
	} elseif($step=='2'){
		$basename.="&action=edit&uid=$uid";
		$oldinfo=$db->get_one("SELECT username,groupid,icon FROM pv_members WHERE uid='$uid'");
		if($oldinfo['username']!=stripcslashes($username)){
			$rs = $db->get_one("SELECT COUNT(*) AS count FROM pv_members WHERE username='$username'");
			if($rs['count']>0) {
				adminmsg('username_exists');
			}
		}

		if($password!=''){
			$password!=$check_pwd && adminmsg('password_confirm');
			$password=md5($password);
			$setpassword=",password='$password'";
		} else{
			$setpassword='';
		}

		$regdate=PvStrtoTime($regdate);
		$bday=$year."-".$month."-".$day;

		if($oldinfo['username']!=stripcslashes($username)){
			$db->update("UPDATE pv_video SET author='$username' WHERE authorid='$uid'");
			$db->update("UPDATE pv_replier SET author='$username' WHERE authorid='$uid'");
			$db->update("UPDATE pv_announce SET author='$username' WHERE author='".addslashes($oldinfo['username'])."'");
		}

		$db->update("UPDATE pv_members SET username='$username' $setpassword,groupid='$groupid',gender='$gender',email='$email',regdate='$regdate',publicmail='".(int)$publicmail."',receivemail='$receivemail',icon='$icon',bday='$bday',honor='$honor',signature='$signature',oicq='$oicq',msn='$msn',site='$site' WHERE uid='$uid'");
		$db->update("UPDATE pv_memberdata SET postnum='$postnum',rvrc='$rvrc',money='$money',onlineip='$userip' WHERE uid='$uid'");

		update_memberid($uid);

		adminmsg('operate_success');
	}

}