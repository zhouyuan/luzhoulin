<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=manager";
$configfile = 'data/sql_config.php';

$rs=$db->get_one("SELECT username FROM pv_members WHERE groupid='3'");
if (!$_POST['action']){
	include PrintEot('manager');exit;
} else {
	$rt=$db->get_one("SELECT uid FROM pv_members WHERE username='$username'");
	if(!$rs){
		$errorname=$username;
		adminmsg('user_not_exists');
	}
	if($password){
		$check_pwd!=$password && adminmsg('password_confirm');
		$S_key=array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n",'#');
		foreach($S_key as $value){
			if (strpos($password,$value)!==false){ 
				adminmsg('illegal_password'); 
			}
		}
		$password=md5($password);
	} else{
		$password=$manager_pwd;
	}
	if(!$pconnect){
		$pconnect=0;
	}
	$fp = @fopen($configfile, 'r');
	$filecontent = @fread($fp, @filesize($configfile));
	@fclose($fp);
	$filecontent = preg_replace("/[$]manager\s*\=\s*[\"'].*?[\"']/is", "\$manager = '$username'", $filecontent);
	$filecontent = preg_replace("/[$]manager_pwd\s*\=\s*[\"'].*?[\"']/is", "\$manager_pwd = '$password'", $filecontent);
	$fp = @fopen($configfile, 'w');
	@fwrite($fp, trim($filecontent));
	@fclose($fp);

	$db->update("UPDATE pv_members SET groupid='1' WHERE username='$rs[username]'");
	$db->update("UPDATE pv_members SET groupid='3' WHERE username='$username'");

	adminmsg('operate_success');
}
?>