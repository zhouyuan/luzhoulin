<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=setstyles";

if (empty($action)){
	$styles = array();
	$result = $db->query("SELECT * FROM pv_styles");
	while ($row = $db->fetch_array($result)) {
		$styles[]=$row;
	}
	include PrintEot('setstyles');exit;
}
elseif ($action=='add' || $action=='edit'){

	if($step!=2){
		isset($name) && include_once Pcv(R_P."data/style/$name.php");
		include PrintEot('setstyles');exit;		
	}else {
		foreach ($style as $key => $value)	${$key}=trim($value);
		if(empty($name) || empty($image) || empty($tpl)) adminmsg('operate_fail');
		if($action=='add')
		{
			file_exists(R_P."data/style/".$name.".php") && adminmsg('style_exists');
			$db->update("INSERT INTO pv_styles(name,stylepath,tplpath) VALUES('$name','$image','$tpl')");
			updatecache_sy($name);
			adminmsg('style_add_success');
		}
		elseif($action=='edit') 
		{
			$db->update("UPDATE pv_styles SET name='$name',stylepath='$image',tplpath='$tpl' WHERE name LIKE '$oldname'");
			updatecache_sy($name);
			if($name!=$oldname)	P_unlink(R_P."data/style/$oldname.php");
			adminmsg('operate_success');
		}
	}
}

elseif ($action=='del'){
	if($name==$skin) adminmsg('style_del_error');
	$db->update("DELETE FROM pv_styles WHERE name='$name'");
	if(file_exists(R_P."data/style/$name.php")){
		if(P_unlink(R_P."data/style/$name.php")){
			adminmsg('operate_success');
		} else{
			adminmsg('operate_fail');
		}
	} else{
		adminmsg('style_not_exists');
	}	
}


?>