<?php
!function_exists('readover') && exit('Forbidden');

/*
$msg=array(
			收件人用户名,
			发件人ID,
			消息标题,
			发送时间,
			消息内容,
			是否保存至发件箱(Y保存)
			发件人用户名,
		);
*/

function writenewmsg($msg,$sysmsg=0) {
	@extract($GLOBALS, EXTR_SKIP);
	include(GetLang('writemsg'));
	$lang[$msg[2]] && $msg[2] = Char_cv($lang[$msg[2]]);
	$lang[$msg[4]] && $msg[4] = Char_cv($lang[$msg[4]]);
	$msg[0] = addslashes($msg[0]);
	$msg[6] = Char_cv($msg[6]);
	!$msg[6] && $msg[6]='SYSTEM';

	$rt = $db->get_one("SELECT uid,username,newpm FROM pv_members WHERE username='$msg[0]'");
	Add_S($rt);
	if ($msg[5] == 'Y') {
		$rs = $db->get_one("SELECT COUNT(*) AS sum FROM pv_msg WHERE type='sebox' AND fromuid='$msg[1]'");
		$rs['sum'] >= $gp_maxmsg && Showmsg('sebox_full');
		$db->update("INSERT INTO pv_msg(touid,fromuid,username,type,ifnew,mdate,title,content) VALUES('$rt[uid]','$msg[1]','$msg[6]','sebox','0','$msg[3]','$msg[2]','$msg[4]')");
	}
	$db->update("INSERT INTO pv_msg(touid,fromuid,username,type,ifnew,mdate,title,content) VALUES('$rt[uid]','$msg[1]','$msg[6]','rebox','1','$msg[3]','$msg[2]','$msg[4]')");
	
	if ($rt['newpm'] == 0) {
		$db->update("UPDATE pv_members SET newpm='1' WHERE uid='$rt[uid]'");
	}
}
?>