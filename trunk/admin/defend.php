<?php
!function_exists('adminmsg') && exit('Forbidden');

foreach($_POST as $_key=>$_value){
	!ereg("^\_",$_key) && !isset($$_key) && $$_key=$_POST[$_key];
}
foreach($_GET as $_key=>$_value){
	!ereg("^\_",$_key) && !isset($$_key) && $$_key=$_GET[$_key];
}

@require_once(R_P.'data/cache/config.php');

if ($db_forcecharset) {
	@header("Content-Type:text/html; charset=$db_charset");
}

if ($db_cc && ((!$_COOKIE && !$_SERVER['HTTP_USER_AGENT']) || ($db_cc==2 && $c_agentip))) {
	exit('Forbidden');
}

strpos($adminjob,'..') !== false && exit('Forbidden');

?>