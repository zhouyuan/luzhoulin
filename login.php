<?php
require_once('global.php');

if ($groupid!='guest' && $action!="quit"){
	Showmsg('login_have');
}
!$action && $action="login";

list(,$logingd)=explode("\t",$db_gdcheck);

if ($action=="login"){
	if (!$step){
		require_once(R_P.'require/header.php');
		require_once PrintEot('login');footer();	
	} else{
		$logingd && GdConfirm($gdcode);
		require_once(R_P.'require/checkpass.php');
		if($username && $password){
			$password=md5($password);
			list($phpvod_uid,$groupid,$password)=checkpass($username,$password);
		} else{
			Showmsg('login_empty');
		}
		$cktime != 0 && $cktime += $timestamp;
		Cookie("user",$phpvod_uid."\t".$password,$cktime);
		Loginipwrite($phpvod_uid);
		refreshto($db_bfn,'have_login');
	}
} elseif($action=="quit"){
	require_once(R_P.'require/checkpass.php');
	Loginout();
	refreshto($db_bfn,'login_out');
}
?>