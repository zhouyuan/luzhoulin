<?php

define('R_P',$__file__ ? getdirname($__file__).'/' :	'./');
	include(R_P.'data/sql_config.php');

	include(R_P.'require/db_'.$database.'.php');
	include(R_P.'admin/cache.php');
	
	if(!($REQUEST_URI=$_SERVER['REQUEST_URI'])){
		$REQUEST_URI=$_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	}
	$wwwurl='http://'.$_SERVER['HTTP_HOST'].substr($REQUEST_URI,0,strrpos($REQUEST_URI,'/'));


	$db = new DB($dbhost, $dbuser, $dbpw, '', $pconnect);
	mysql_select_db($dbname);
	$db->update("UPDATE pv_config SET db_value='$wwwurl' WHERE db_name='db_wwwurl'");
	$db->update("UPDATE pv_config SET db_value='$wwwurl' WHERE db_name='db_ceoconnect'");
	writefile();
	updatecache();
echo "Success!!请返回首页看效果";
function writefile(){
	writeover(R_P.'data/cache/dbset.php',"<?php\r\n\$picpath='image';\r\n\$attachname='attachment';\r\n?>");
}
function readover($filename,$method="rb"){
	if($handle=@fopen($filename,$method)){
		flock($handle,LOCK_SH);
		$filedata=@fread($handle,filesize($filename));
		fclose($handle);
	}
	return $filedata;
}

function adminmsg(){
}

function writeover($filename,$data,$method="rb+"){
	@touch($filename);
	if($handle=@fopen($filename,$method)){
		flock($handle,LOCK_EX);
		fputs($handle,$data);
		if($method=="rb+") ftruncate($handle,strlen($data));
		fclose($handle);
	}
}

?>