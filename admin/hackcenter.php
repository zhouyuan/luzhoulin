<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=hackcenter";
require_once(R_P.'data/cache/hack.php');

if (!$action){
	include PrintEot('hackcenter');exit;
} elseif ($action=="add"){
	if(!$_POST['step']){
		include PrintEot('hackcenter');exit;
	} elseif ($step=='2'){
		$name		= Char_cv($name);
		$directory  = Char_cv($directory);
		
		if(!$name || !$directory){
			adminmsg('hackcenter_empty');
		}
		if(!is_dir(R_P."hack/$directory")){
			adminmsg('hackcentre_upload');
		}
		foreach($hack as $key=>$value){	
			if($directory==$value['directory']){
				adminmsg('hackcenter_sign_exists');
			}
		}
		if(file_exists(R_P."hack/$directory/sql.txt")){
			updatedb(R_P."hack/$directory/sql.txt");
			P_unlink(R_P."hack/$directory/sql.txt");
		}

		$db->update("INSERT INTO pv_hack (name,directory,hidden) VALUES ('$name','$directory','$hidden');");
		updatecache_h();
		adminmsg('operate_success');
	}
} elseif($action=="edit"){
	if(!$_POST['step']){
		ifcheck($hack[$directory]['hidden'],'hidden');
		include PrintEot('hackcenter');exit;
	} elseif ($step=='2'){
		$name		= Char_cv($name);
		$directory	= Char_cv($directory);

		if(!$name || !$directory){
			adminmsg('hackcenter_empty');
		}

		foreach($hack as $key=>$value){	
			if($directory==$value['directory'] && $value['hid']!=$hack[$hackdir]['hid']){
				adminmsg('hackcenter_sign_exists');
			}
		}

		$db->update("UPDATE pv_hack SET hidden='$hidden',name='$name',directory='$directory' WHERE directory='$hackdir'");
		updatecache_h();

		if(@rename(R_P."hack/$hackdir",R_P."hack/$directory"))
			adminmsg('operate_success');
		else
			adminmsg('hackcenter_edit_fail');
	}
} elseif($action=="update"){
	$db->update("UPDATE pv_hack SET hidden=0");
	if($applyid = checkselid($applyid)){
		$db->update("UPDATE pv_hack SET hidden=1 WHERE hid IN($applyid)");
	}
	updatecache_h();
	adminmsg('operate_success');
} elseif($action=='del') {
	$db->query("DELETE FROM pv_hack WHERE directory='$directory'");
	$tdir = R_P."hack/{$hack[$directory][directory]}";
	$odir = R_P."data/hack/{$hack[$directory][directory]}";
	updatecache_h();
	if(P_rmdir($tdir)===false || P_rmdir($odir)===false){
		adminmsg('hackcenter_del_fail');
	}else{
		adminmsg('operate_success');
	}
} elseif($action=='parse') {
	updatecache_hack("$directory");
	adminmsg('operate_success');
}

function P_rmdir($pathname){
	strpos($pathname,'..')!==false && exit('Forbidden');
	if(is_dir($pathname)){
		if($handle = opendir($pathname)){
			while(($file = readdir($handle))){
				if($file == "." || $file == ".."){
					continue;
				}
				if(is_dir($pathname."/".$file)){
					P_rmdir($pathname."/".$file);
				}else{
					P_unlink($pathname."/".$file);
				}
			}
			closedir($handle);
			return @rmdir($pathname);
		}
		return false;
	}else{
		return 0;
	}
}

function updatedb($filename) {
	global $db,$charset;
	
	$sql=file($filename);
	$query='';
	$num=0;
	foreach($sql as $key => $value){
		$value=trim($value);
		if(!$value || $value[0]=='#' || $value[0]=='-') continue;
		if(eregi("\;$",$value)){
			$query.=$value;
			if(eregi("^CREATE",$query)){
				$extra = substr(strrchr($query,')'),1);
				$tabtype = substr(strchr($extra,'='),1);
				$tabtype = substr($tabtype, 0, strpos($tabtype,strpos($tabtype,' ') ? ' ' : ';'));
				$query = str_replace($extra,'',$query);
				if($db->server_info() > '4.1'){
					$extra = $charset ? "ENGINE=$tabtype DEFAULT CHARSET=$charset;" : "ENGINE=$tabtype;";
				}else{
					$extra = "TYPE=$tabtype;";
				}
				$query .= $extra;
			}
			$db->query($query);
			$query='';
		} else{
			$query.=$value;
		}
	}
}

?>