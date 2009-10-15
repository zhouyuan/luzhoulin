<?php
!function_exists('readover') && exit('Forbidden');
function Loginout(){
	Cookie('user','',0);
}
function Loginipwrite($phpvod_uid){
	global $db,$timestamp,$onlineip;
	$logininfo="$onlineip|$timestamp|6";
	$db->update("UPDATE pv_memberdata SET onlineip='$logininfo' WHERE uid='$phpvod_uid' ");
}
function checkpass($username,$password){
	global $db,$timestamp,$onlineip;

	$men=$db->get_one("SELECT m.uid,m.password,m.groupid,md.onlineip FROM pv_members m LEFT JOIN pv_memberdata md ON md.uid=m.uid WHERE username='$username'");
	if($men){
		$e_login=explode("|",$men['onlineip']);
		if($e_login[0]!=$onlineip.' *' || ($timestamp-$e_login[1])>600 || $e_login[2]>1 ){
			/*
			if($men['groupid'] == 4){
				Showmsg('login_jihuo');
			}
			*/
			if($men['password'] == $password){
				$L_groupid=(int)$men['groupid'];
			}else{
				global $L_T;
				$L_T=$e_login[2];
				$L_T ? $L_T--:$L_T=5;
				$F_login="$onlineip *|$timestamp|$L_T";
				$db->update("UPDATE pv_memberdata SET onlineip='$F_login' WHERE uid='$men[uid]'");
				Showmsg('login_pwd_error');
			}
		}else{
			global $L_T;
			$L_T=600-($timestamp-$e_login[1]);
			Showmsg('login_forbid');
		}
	} else {
		global $errorname;
		$errorname=$username;
		Showmsg('user_not_exists');
	}
	return array($men['uid'],$L_groupid,$password);
}
?>