<?php
!function_exists('adminmsg') && exit('Forbidden');
require_once(R_P."require/template.php"); 

function updatecache($array=''){
	if(!$array){
		updatecache_c();
		updatecache_g();
		updatecache_l();
		updatecache_class();
		updatecache_sy();		
		updatecache_n();
		updatecache_p();
		updatecache_notice();
		updatecache_sharelink();
		updatecache_credit();
		updatecache_h();
		updatecache_md();
		updatecache_mddb();
	} else{
		foreach($array as $value){
			$value();
		}
	}
}

function updatecache_c(){
	global $db;
	$query=$db->query("SELECT * FROM pv_config");
	$configdb=$regdb="<?php\r\n";
	while(@extract(db_cv($db->fetch_array($query)))){
		$db_name = key_cv($db_name);
		if (strpos($db_name,'db_')!==false){
			$db_name=stripslashes($db_name);
			$configdb.="\$$db_name='$db_value';\r\n";
		} elseif (strpos($db_name,'rg_')!==false){
			$regdb.="\$$db_name='$db_value';\r\n";
		}
	}
	$configdb.="?>";
	$regdb.="?>";
	writeover(R_P.'data/cache/config.php',$configdb);
	writeover(R_P.'data/cache/dbreg.php',$regdb);
}

function updatecache_g($gid='A'){
	global $db;
	if($gid=='A'){
		$query=$db->query("SELECT * FROM pv_usergroups WHERE ifdefault='0' OR gid='1'"); 
		while($group=db_cv($db->fetch_array($query))){
			updatecache_gp($group);
		}
	}else{
		$group=db_cv($db->get_one("SELECT * FROM pv_usergroups WHERE gid='$gid'"));
		updatecache_gp($group);
	}
}
function updatecache_gp($group){
	$groupcache="<?php\r\n";
	$sysstart=0;
	foreach($group as $key=>$value){
		if($sysstart==0){
			$groupcache.="\$gp_$key='$value';\r\n";
		} else{
			if($group['gptype']=='member'||$group['gptype']=='default')break;
			$sysdb.="\t'$key'=>'$value',\r\n";
		}
		if($key=='ifdefault')$sysstart=1;
	}

	$sysdb=$sysdb ? "\$SYSTEM=array(\r\n".$sysdb."\t);" :"\r\n\$SYSTEM=array();";
	$groupcache=$groupcache."\r\n".$sysdb."\r\n?>";
	writeover(D_P."data/groupdb/group_$group[gid].php",$groupcache);
}

function updatecache_l($return=0){
	global $db;
	$query=$db->query("SELECT gid,gptype,grouptitle,groupimg,grouppost FROM pv_usergroups ORDER BY grouppost,gid");
	$defaultdb="\$ltitle=\$lpic=\$lneed=array();\r\n/**\r\n* 默认组\r\n*/\r\n";
	$sysdb="\r\n/**\r\n* 管理组\r\n*/\r\n";
	$memdb="\r\n/**\r\n* 会员组\r\n*/\r\n";
	while(@extract(db_cv($db->fetch_array($query)))){
		if($gptype=='member'){
			$memdb.="\$ltitle[$gid]='$grouptitle';\t\t\$lpic[$gid]='$groupimg';\t\t\$lneed[$gid]='$grouppost';\r\n";
		}elseif($gptype=='system'){
			$sysdb.="\$ltitle[$gid]='$grouptitle';\t\t\$lpic[$gid]='$groupimg';\r\n";
		}elseif($gptype=='default'){
			$defaultdb.="\$ltitle[$gid]='$grouptitle';\t\t\$lpic[$gid]='$groupimg';\r\n";
		}
	}
	if($return){
		return $defaultdb.$sysdb.$memdb;
	}else{
		writeover(D_P.'data/cache/level.php',"<?php\r\n".$defaultdb.$sysdb.$memdb."\r\n?>");
	}
}

function class_array($cup,&$array)
{
	global $db;
	$query = $db->query("SELECT * FROM pv_class WHERE cup='$cup' ORDER BY vieworder,cid");
	while($row = $db->fetch_array($query))
	{
		$array[]=$row;
		class_array($row['cid'],$array);
	}
}

function updatecache_class()
{
	$arr = array();
	class_array(0,$arr);
	cache_value($arr);
	$class="\$class = array(";
	$class_opt="\$class_opt = '";
	foreach ($arr as $row)
	{
		$class.="
		'$row[cid]'=>array(
			'cid'=>'$row[cid]',
			'cup'=>'$row[cup]',
			'lv'=>'$row[lv]',
			'fathers'=>'$row[fathers]',
			'caption'=>'$row[caption]',
			'vieworder'=>'$row[vieworder]',
			'type'=>'$row[type]',
			'orderway'=>'$row[orderway]',
			'orderasc'=>'$row[orderasc]',
			'atccheck'=>'$row[atccheck]',
			'rvrcneed'=>'$row[rvrcneed]',
			'moneyneed'=>'$row[moneyneed]',
			'postneed'=>'$row[postneed]',
			'password'=>'$row[password]',
			'allowvisit'=>'$row[allowvisit]',
			'allowplay'=>'$row[allowplay]',
			'allowpost'=>'$row[allowpost]',
			'allowrp'=>'$row[allowrp]',
		),";

		$pre='';
		for($i=0;$i<$row['lv'];$i++) $pre.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$class_opt.="
			<option value=\"$row[cid]\">{$pre}{$row[caption]}</option>";
	}
	$class.="\r\n);";
	$class_opt.="\r\n';";
	writeover(R_P.'data/cache/class.php',"<?php\r\n".$class."\r\n".$class_opt."\r\n?>");
}

function updatecache_sy($name=''){
	global $db;
	if($name!='') $sqlwhere="WHERE name='$name'";
	$query=$db->query("SELECT * FROM pv_styles $sqlwhere");
	while(@extract(db_cv($db->fetch_array($query)))){
		$stylecontent="<?php\r\n\t\$stylename = '$name';\r\n\t\$stylepath = '$stylepath';\r\n\t\$tplpath = '$tplpath';\r\n\?>";
		writeover(R_P."data/style/$name.php",str_replace("\?>","?>",$stylecontent));
	}
}

function updatecache_n(){
	global $db;
	$nationcache='';
	$nationcache="\$nation_opt='";
	$query=$db->query("SELECT * FROM pv_nations ORDER BY vieworder");
	while(@extract(db_cv($db->fetch_array($query)))){
		$nationcache.="\r\n<option value=\"$id\">{$subject}</option>";
	}
	$nationcache .= "\r\n';";
	writeover(R_P."data/cache/nation.php","<?php\r\n".$nationcache."\r\n?>");
}

function updatecache_p(){
	global $db;

	$player="\$player='";
	$query=$db->query("SELECT * FROM pv_player WHERE hidden='1'");
	while(@extract(db_cv($db->fetch_array($query)))){
		$player.="<option value=\"$pid\">{$name}</option>";
	}
	$player .= "';";
	writeover(R_P."data/cache/player.php","<?php\n".$player."\n?>");
}

function updatecache_notice(){
	global $db;	
	$notice='';
	$query=$db->query("SELECT * FROM pv_announce ORDER BY vieworder,startdate DESC");
	while(@extract(db_cv($db->fetch_array($query)))){
		$notice.="'$aid'=>array(\n\t\t'aid'=>'$aid',\n\t\t'author'=>'$author',\n\t\t'startdate'=>'$startdate',\n\t\t'subject'=>'$subject',\n\t\t),\n\t";
	}

	$cache="<?php\r\n\$notice=array(\r\n\t$notice\r\n\t);\r\n?>";	
	writeover(R_P.'data/cache/notice.php',$cache);
}

function updatecache_sharelink(){	
	global $db;
	$sharelink1=''; $sharelink2='';
	$query=$db->query("SELECT * FROM pv_sharelinks ORDER BY threadorder");
	while(@extract(db_cv($db->fetch_array($query)))){
		if($logo){
			$sharelink1.="<a href=\"$url\" target=_blank><img src=\"$logo\" alt=\"$descrip\" width=\"88\" height=\"31\"></a> ";
		}else{
			$sharelink2.="<a href=\"$url\" target=\"_blank\" title=\"$descrip\">[$name]</a> ";
		}
	}
	
	$sharelink2 && $sharelink1 = $sharelink2.'<br />'.$sharelink1;

	$cache="<?php\r\n\$sharelink='$sharelink1';\r\n?>";
	writeover(R_P.'data/cache/sharelink.php',$cache);
}

function updatecache_credit(){
	global $db;
	$creditdb="\$_CREDITDB=array(\r\n\t\t";
	$query=$db->query("SELECT * FROM  pv_credits ORDER BY cid");
	while($write=db_cv($db->fetch_array($query))){
		if($write){
			$creditdb.="'".$write['cid']."'=>array('$write[name]','$write[description]'),\r\n\t\t";
		}
	}
	$creditdb.=");";
	writeover(R_P."data/cache/creditdb.php","<?php\r\n".$creditdb."\r\n?>");
}

function updatecache_template($EXT='htm')
{
	global $tplpath;
	$fp=@opendir(R_P."template/$tplpath/");
	if($fp)
	{
		while($tplfile=readdir($fp))
		{
			if(eregi("\.{$EXT}$",$tplfile))
			{
				$tplfile = basename($tplfile,".{$EXT}");
				parse_template($tplpath,$tplfile,$EXT);
			}

		}
		closedir($fp);
	}
}

function updatecache_hack($tplpath,$EXT='htm')
{
	$fp=@opendir(R_P."hack/$tplpath/template/");
	if($fp)
	{
		while($tplfile=readdir($fp))
		{
			if(eregi("\.{$EXT}$",$tplfile))
			{
				$tplfile = basename($tplfile,".{$EXT}");
				parse_template($tplpath,$tplfile,$EXT,"hack");
			}

		}
		closedir($fp);
	}
}

function updatecache_h(){
	global $db;	
	$hack='';
	$query=$db->query("SELECT * FROM pv_hack");
	while(@extract(db_cv($db->fetch_array($query)))){
		$hack.="'$directory'=>array(\n\t\t'hid'=>'$hid',\n\t\t'name'=>'$name',\n\t\t'directory'=>'$directory',\n\t\t'hidden'=>'$hidden',\n\t\t),\n\t";
	}

	$cache="<?php\r\n\$hack=array(\r\n\t$hack\r\n\t);\r\n?>";	
	writeover(R_P.'data/cache/hack.php',$cache);

}

function updatecache_md($return=0){
	global $db;
	$medaldb='';
	$query = $db->query("SELECT * FROM pv_hackvar WHERE hk_name LIKE 'md\_%'");
	while(@extract(db_cv($db->fetch_array($query)))){
		$hk_name = key_cv($hk_name);
		$medaldb.="\$$hk_name='$hk_value';\r\n";
	}
	if($return){
		return $medaldb;
	}else{
		writeover(R_P.'data/cache/md_config.php',"<?php\r\n".$medaldb."\r\n?>");
	}
}

function updatecache_mddb($return=0){
	global $db;
	$medaldb="\$medaldb=array(\r\n";
	$query = $db->query("SELECT * FROM pv_medalinfo ORDER BY id");
	while($rt=db_cv($db->fetch_array($query))){
		$medaldb.="\t'$rt[id]'=>array(\r\n\t";
		foreach($rt as $key=>$value){
			$medaldb.="\t'$key'=>'$value',\r\n\t";
		}
		$medaldb.="),\r\n";
	}
	$medaldb.=");";
	if($return){
		return $medaldb;
	}else{
		writeover(R_P.'data/cache/medaldb.php',"<?php\r\n".$medaldb."\r\n?>");
	}
}

function db_cv($array){
	if(is_array($array)){
		foreach($array as $key=>$value){
			$array[$key]=str_replace(array("\\","'"),array("\\\\","\'"),$value);
		}
	}
	return $array;
}

function key_cv($key){
	$key = str_replace(
	array(';','\\','/','(',')','$'),
	'',
	$key
	);
	return $key;
}

function cache_value(&$array) {
	if(is_array($array)){
		foreach($array as $key => $value){
			if(!is_array($value)){
				$array[$key]=str_replace(array("\\","'"),array("\\\\","\'"),$value);
			}else{
				cache_value($array[$key]);
			}
		}
	} else{
		$array=str_replace(array("\\","'"),array("\\\\","\'"),$array);
	}	
}
?>