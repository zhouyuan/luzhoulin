<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=chmod";

$filepath = array(
	'data',
	'data/cache',
	'data/groupdb',
	'data/hack',
	'data/player',
	'data/style',
	'data/template',
	'data/sql_config.php',
	$attachname,
	$picpath
);

$filemode = array();
foreach ($filepath as $key => $value){
	if (!file_exists($value)){
		$filemode[$key] = 1;
	} elseif (!is_writable($value)){
		$filemode[$key] = 2;
	} else {
		$filemode[$key] = 0;
	}
}
include PrintEot('chmod');exit;
?>