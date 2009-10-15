<?php
!function_exists('readover') && exit('Forbidden');

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

if($db_dir && $db_ext){
	$self_array = explode('-',$db_ext ? substr($_SERVER['QUERY_STRING'],0,strpos($_SERVER['QUERY_STRING'],$db_ext)) : $_SERVER['QUERY_STRING']);
	$s_count=count($self_array);
	for($i=0;$i<$s_count;$i++){
		$_key	= $self_array[$i];
		$_value	= $self_array[++$i];
		!ereg("^\_",$_key) && !isset($$_key) && $$_key = addslashes(rawurldecode($_value));
	}
}

if ($db_cc && ((!$_COOKIE && !$_SERVER['HTTP_USER_AGENT']) || ($db_cc==2 && $c_agentip))) {
	exit('Forbidden');
}

strpos($adminjob,'..') !== false && exit('Forbidden');
?>