<?php
require_once('global.php');
require_once(R_P.'require/header.php');
/**
* 用户组权限判断
*/
$groupid=='guest'  && Showmsg('not_login');
$gp_maxmsg<=0 && Showmsg('group_msg_max');
if(!$action) $action='receivebox';

$msgdb=array();
//收件箱
if ($action=="receivebox"){
	$query = $db->query("SELECT mid,fromuid,username,ifnew,title,mdate FROM pv_msg WHERE type='rebox' AND touid='$uid' ORDER BY mdate DESC");
	$msgcount = $db->num_rows($query);
	if($msgcount){
		$contl=number_format(($msgcount/$gp_maxmsg)*100,3);
	} else{
		$msgcount='0';	$contl='0';
	}

	while($msginfo=$db->fetch_array($query)){
		$msginfo['title']=substrs($msginfo['title'],70);
		$msginfo['mdate']=get_date($msginfo['mdate']);
		$msgdb[]=$msginfo;		
	}
	require_once(PrintEot('message'));footer();
}

//发件箱
if ($action=="sendbox"){
	$query = $db->query("SELECT mid,fromuid,touid,title,mdate FROM pv_msg WHERE type='sebox' AND fromuid='$uid' ORDER BY mdate DESC");
	while($msginfo=$db->fetch_array($query)){
		$msginfo['title']=substrs($msginfo['title'],70);
		$msginfo['mdate']=get_date($msginfo['mdate']);
		$rt = $db->get_one("SELECT username FROM pv_members WHERE uid='$msginfo[touid]'");
		$msginfo['touser']=$rt['username'];
		$msgdb[]=$msginfo;
	}
	require_once(PrintEot('message'));footer();
}

//阅读短消息
if ($action=="read"){
	$msginfo = $db->get_one("SELECT mid,touid,username,ifnew,title,mdate,content FROM pv_msg WHERE mid='$mid'");
	if ($msginfo){
		$msginfo['title'] =str_replace('&ensp;$','$', $msginfo['title']);
		$msginfo['content']=str_replace("\n","<br />",$msginfo['content']);
		$msginfo['content'] =str_replace('&ensp;$','$', $msginfo['content']);
		$msginfo['mdate']=get_date($msginfo['mdate']);
		if($action=="read" && $msginfo['ifnew']==1){
			$db->update("UPDATE pv_msg SET ifnew=0 WHERE mid='$mid'");
	    	setnewpm($uid);
		}
	} else{
		Showmsg('msg_error');
	}
	require_once(PrintEot('message'));footer();

}

//写短信
if($action=="write"){
	$gp_postpertime = "10";
	$rp = $db->get_one("SELECT mdate FROM pv_msg WHERE fromuid='$uid' ORDER BY mdate DESC LIMIT 1");
	$lastwrite = $rp['mdate'];
	if ($timestamp - $lastwrite <= $gp_postpertime){
		Showmsg('msg_limit');
	}
	list(,,,,$msggd)=explode("\t",$db_gdcheck);
	
	if (!$step){
		/* 用户组权限 */
		if($gp_allowmessage!='1') Showmsg('group_msg_post');

		$subject=$atc_content='';
		if(is_numeric($remid)){
			$reinfo=$db->get_one("SELECT fromuid,touid,username,type,title,content FROM pv_msg WHERE mid='$remid' AND (fromuid='$uid' OR (type='rebox' AND touid='$uid'))");
			if($reinfo){
				$msgid=$reinfo['username'];
				$subject=strpos($reinfo['title'],'Re:')===false ? 'Re:'.$reinfo['title']:$reinfo['title'];
				$atc_content=$reinfo['content'];
			}
		}elseif(is_numeric($touid)){
			$reinfo=$db->get_one("SELECT username FROM pv_members WHERE uid='$touid'");
			$msgid=$reinfo['username'];
		} else{
			$msgid='';
		}
		require_once(PrintEot('message'));footer();
	} elseif($step==2){
		$msggd && GdConfirm($gdcode);
		require_once(R_P.'require/msg.php');
		if (!$atc_content || !$msg_title || !$msg_user){
			Showmsg('msg_empty');
		} elseif (strlen($msg_title)>75 || strlen($atc_content)>1500){
			Showmsg('msg_subject_limit');
		}
		if($msg_user){
			$rt=$db->get_one("SELECT uid FROM pv_members WHERE username='$msg_user'");
			if(!$rt){
				$errorname=$msg_user;
				Showmsg('user_not_exists');
			}
		}

		$atc_content = Char_cv($atc_content);
		$msg_title   = Char_cv($msg_title);
		$ifsave=='1' && $ifsave='Y';

		$msg = array(
				$msg_user,
				$uid,
				$msg_title,
				$timestamp,
				$atc_content,
				$ifsave,
				$username
				);
		writenewmsg($msg);
		refreshto("message.php",'operate_success');
	}
}

if ($action=="clear"){
	$db->update("DELETE FROM pv_msg WHERE type='rebox' AND touid='$uid'");
	$db->update("DELETE FROM pv_msg WHERE type='sebox' AND fromuid='$uid'");
	setnewpm($uid);
	refreshto("message.php",'operate_success');
}
if ($action=="del"){
	if($mid){
		$delids=$mid;
	}else{
		$delids = checkselid($delid);
		if(!$delids) Showmsg('operate_error');	
	}
	$db->update("DELETE FROM pv_msg WHERE mid IN($delids)");
	if($db->affected_rows()==0){
		Showmsg('undefined_action');
	}
	setnewpm($uid);
	refreshto("message.php",'operate_success');
}

function setnewpm($id) {
	global $db;
	$rs=$db->get_one("SELECT COUNT(*) AS count FROM pv_msg WHERE touid='$id' AND ifnew='1' AND type='rebox'");
	$s = $rs['count']>0 ? '1' : '0';
	$db->update("UPDATE pv_members SET newpm='$s' WHERE uid='$id'");
}
?>