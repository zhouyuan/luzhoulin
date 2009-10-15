<?php
error_reporting(E_ERROR | E_PARSE);
set_magic_quotes_runtime(0);

define('R_P',__FILE__ ? getdirname(__FILE__).'/' : './');
define('D_P',R_P);

$admin_file = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
require_once(R_P."admin/adming.php");

if (!$adminjob){
	require_once PrintEot('index');
	exit;
} elseif ($adminjob == 'admin'){
	$query = $db->query("SHOW TABLE STATUS");
	while ($rs = $db->fetch_array($query)) {
		if (ereg("^$pv",$rs['Name'])){
			$pv_size = $pv_size + $rs['Data_length'] + $rs['Index_length'];
		} else{
			$o_size = $o_size + $rs['Data_length'] + $rs['Index_length'];
		}
	}	
	$o_size		= number_format($o_size/(1024*1024),2);
	$pv_size	= number_format($pv_size/(1024*1024),2);
	$systemtime	= gmdate("Y-m-d H:i",time()+$db_timedf*3600);
	$altertime	= gmdate("Y-m-d H:i",$timestamp+$db_timedf*3600);
	$sysversion = PHP_VERSION;
	$dbversion = mysql_get_server_info();
	$sysos      = $_SERVER['SERVER_SOFTWARE'];
	$max_upload = ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'Disabled';
	$max_ex_time= ini_get('max_execution_time').' seconds';
	$sys_mail   = ini_get('sendmail_path') ? 'Unix Sendmail ( Path: '.ini_get('sendmail_path').')' :( ini_get('SMTP') ? 'SMTP ( Server: '.ini_get('SMTP').')': 'Disabled' );
	$ifcookie   = isset($_COOKIE) ? "SUCCESS" : "FAIL";

	require_once PrintEot('admin');exit;
} elseif (in_array($adminjob,array('record'))){
	require_once(R_P."admin/$adminjob.php");
} elseif ($adminjob == 'hack'){
	if (!$hackset || !is_dir(R_P."hack/$hackset") || !file_exists(R_P."hack/$hackset/admin.php")){
		adminmsg("hack_error");
	}
	define('H_P',R_P."hack/$hackset/");
	$hackpath="hack/$hackset";
	$basename="$admin_file?adminjob=hack&hackset=$hackset";
	require_once(H_P."admin.php");
} elseif ($adminjob){
	!file_exists(R_P."admin/$adminjob.php") && adminmsg('undefine_action');
	require_once(R_P."admin/$adminjob.php");
} elseif ($adminjob == 'left'){
	require_once(R_P."admin/left.php");
}

function getdirname($path){
	if(strpos($path,'\\')!==false){
		return substr($path,0,strrpos($path,'\\'));
	}elseif(strpos($path,'/')!==false){
		return substr($path,0,strrpos($path,'/'));
	}else{
		return '/';
	}
}
?>