<?php
!function_exists('readover') && exit('Forbidden');
require_once(R_P.'require/header.php');

if(!$vod_action){
	require_once PrintEot('classpwd');footer();
} else{
	if($class[$cid]['password']==$vod_password && $groupid!='guest'){
		/**
		* 不同栏目不同密码
		*/
		Cookie("pwdcheck[$cid]",$class[$cid]['password']);
	} elseif($groupid=='guest'){
		Showmsg('classpw_guest');
	} else{
		Showmsg('classpw_pwd_error');
	}
}
?>