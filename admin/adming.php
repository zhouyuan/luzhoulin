<?php
!defined('R_P') && exit('Forbidden');
function_exists('date_default_timezone_set') && date_default_timezone_set('Etc/GMT+0');

unset($_ENV,$HTTP_ENV_VARS,$_REQUEST,$HTTP_POST_VARS,$HTTP_GET_VARS,$HTTP_POST_FILES,$HTTP_COOKIE_VARS);
if(!get_magic_quotes_gpc()){
	Add_S($_POST);
	Add_S($_GET);
	Add_S($_COOKIE);
}
Add_S($_FILES);

if($_SERVER['HTTP_X_FORWARDED_FOR']){
	$onlineip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	$c_agentip=1;
}elseif($_SERVER['HTTP_CLIENT_IP']){
	$onlineip = $_SERVER['HTTP_CLIENT_IP'];
	$c_agentip=1;
}else{
	$onlineip = $_SERVER['REMOTE_ADDR'];
	$c_agentip=0;
}
$onlineip = preg_match("/^[\d]([\d\.]){5,13}[\d]$/", $onlineip) ? $onlineip : 'unknown';

$timestamp  = time();
require_once(R_P.'admin/defend.php');
$cookietime = $timestamp+31536000;
!$_SERVER['PHP_SELF'] && $_SERVER['PHP_SELF']=$_SERVER['SCRIPT_NAME'];
$REQUEST_URI  = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];

if($adminjob=='quit'){
	Cookie('AdminUser','',0);
	ObHeader($admin_file);
}
include_once(R_P.'require/credit.php');
include_once(R_P.'data/cache/level.php');
include_once(R_P.'data/cache/dbset.php');
include_once(R_P.'data/cache/dbreg.php');
include_once(R_P.'data/cache/class.php');
include_once(R_P.'data/cache/nation.php');
include_once(R_P.'data/cache/creditdb.php');
include_once(R_P.'data/cache/hack.php');
include_once(R_P.'admin/cache.php');
include_once(R_P."data/style/{$db_defaultstyle}.php");

$version = "1.1";
$imgpath = $db_http	!= 'N' ? $db_http : "$picpath";
$imgdir     = R_P.$picpath;
$skin   = $db_defaultstyle;

$db_obstart == 1 && function_exists('ob_gzhandler') ? ob_start('ob_gzhandler') : ob_start();

//登陆防御
$recordfile = R_P."data/cache/admin_record.php";
$F_count=F_L_count($recordfile,2000);
$L_T=1200-($timestamp-@filemtime($recordfile));
$L_left=15-$F_count;

if($F_count>15 && $L_T>0){
	require_once GetLang('msg');
	$msg=$lang['login_fail'];
	include PrintEot('adminlogin');exit;
}

//数据库连接
include_once (D_P.'data/sql_config.php');
include_once (R_P.'require/db_'.$database.'.php');

$db = new DB($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);

if (file_exists("install.php")){
	adminmsg('installfile_exists');
}

//管理登陆验证
if($_POST['admin_pwd'] && $_POST['admin_name']){
	$pvuser		= $_POST['admin_name'];
	$AdminUser	= $timestamp."\t".$pvuser."\t".md5($_POST['admin_pwd']);
	Cookie('AdminUser',$AdminUser);
}elseif(GetCookie('AdminUser')){
	$AdminUser = GetCookie('AdminUser');
}else{
	$AdminUser = '';
}
list(,,$admingd) = explode("\t",$db_gdcheck);

if($AdminUser){
	$CK			= explode("\t",$AdminUser);
	$admin_name = stripcslashes($CK[1]);
}else{
	$CK = $admin_name = '';
}
$admin = checkpass($CK);
if ($admin == false) {
	if ($_POST['admin_name'] && $_POST['admin_pwd']){
		$record_name= str_replace('|','&#124;',Char_cv($_POST['admin_name']));
		$record_pwd	= str_replace('|','&#124;',Char_cv($_POST['admin_pwd']));
		$new_record="<?die;?>|$record_name|$record_pwd|Logging Failed|$onlineip|$timestamp|\n";
		writeover($recordfile,$new_record,"ab");
		adminmsg('login_error');
	}
	include PrintEot('adminlogin');exit;
}elseif($_POST['admin_name']){
	ObHeader($REQUEST_URI);
}

//管理日志
$_postdata	 = $_POST ? PostLog($_POST) : '';
$record_name = str_replace('|','&#124;',Char_cv($admin_name));
$record_URI	 = str_replace('|','&#124;',Char_cv($REQUEST_URI));
$new_record="<?die;?>|$record_name||$record_URI|$onlineip|$timestamp|$_postdata|\n";
writeover($recordfile,$new_record,"ab");

unset($_postdata,$record_name,$record_URI,$new_record,$recordfile);

function Cookie($ck_Var,$ck_Value,$ck_Time='F'){
	global $cookietime;
	if($ck_Time=='F') $ck_Time = $cookietime;
	setCookie($ck_Var,$ck_Value,$ck_Time);
}
function GetCookie($Var){
    return $_COOKIE[$Var];
}
function Add_S(&$array){
	if($array){
		foreach($array as $key=>$value){
			if(!is_array($value)){
				$array[$key]=addslashes($value);
			}else{
				Add_S($array[$key]);
			}
		}
	}
}
function HtmlConvert(&$array){
	if(is_array($array)){
		foreach($array as $key => $value){
			if(!is_array($value)){
				$array[$key]=htmlspecialchars($value);
			}else{
				HtmlConvert($array[$key]);
			}
		}
	} else{
		$array=htmlspecialchars($array);
	}
}
function checkpass($CK){
	global $db,$lg_num,$admingd;
	$admin = false;
	if (!$CK) return false;
	Add_S($CK);
	if($_POST['Login_f']==1 && $admingd){
		GdConfirm($lg_num);
	}

	$rt = $db->get_one("SELECT uid,password,groupid,allowadmincp,gptype,grouptitle FROM pv_members LEFT JOIN pv_usergroups ON pv_members.groupid=pv_usergroups.gid WHERE username='$CK[1]'");
	if($CK[2] != $rt['password']) return false;
	if($rt['gptype'] != 'system' || $rt['allowadmincp'] != 1) return false;
	$admin = $rt;
	return $admin;
}
function GdConfirm($code){
	global $db,$timestamp;
	$sid = GetCookie('sid');
	@extract($db->get_one("SELECT nmsg FROM pv_cknum WHERE sid='$sid'"));
	
	if(!$code || $nmsg!=$code){
		global $basename,$admin_file;
		Cookie('AdminUser','',0);
		$basename = $admin_file;
		adminmsg('check_error');
	}else{
		$newnmsg=num_rand(4);
		$db->update("UPDATE pv_cknum SET nmsg='$newnmsg',time='$timestamp' WHERE sid='$sid'");
	}
}
function num_rand($lenth){
	mt_srand((double)microtime() * 1000000);
	for($i=0;$i<$lenth;$i++){
		$randval.= mt_rand(1,9);
	}
	return $randval;
}
function F_L_count($filename,$offset)
{
	global $onlineip;
	$count=0;
	if($fp=@fopen($filename,"rb")){
		flock($fp,LOCK_SH);
		fseek($fp,-$offset,SEEK_END);
		$readb=fread($fp,$offset);
		fclose($fp);
		$readb=trim($readb);
		$readb=explode("\n",$readb);
		$count=count($readb);$count_F=0;
		for($i=$count-1;$i>0;$i--){
			if(strpos($readb[$i],"|Logging Failed|$onlineip|")===false){
				break;
			}
			$count_F++;
		}
	}
	return $count_F;
}
function GetLang($lang,$EXT="php"){
	$path=R_P."lang/admin_lang_$lang.$EXT";
	return $path;
}
function PrintEot($template,$EXT="htm"){
	if(!$template) $template='N';
	$path=R_P."template/admin/$template.$EXT";
	return $path;
}

function PrintHack($template,$EXT="htm")
{
	global $hackset,$db_tplrefresh;
	$tplfile=H_P."template/$template.$EXT";

	if(file_exists($tplfile))
	{
		$objfile=R_P."data/hack/$hackset/$template.tpl.php";
		if($db_tplrefresh == 1 && (@filemtime($tplfile) > @filemtime($objfile)))
		{
			parse_template($hackset,$template,$EXT,"hack");
		}
	
	}
	else exit("Current template file '$tplfile' not found or have no access!");

	return $objfile;
}

function ObHeader($URL){
	echo "<meta http-equiv='refresh' content='0;url=$URL'>";exit;
}
function adminmsg($msg,$jumpurl='',$t=2)
{
	extract($GLOBALS, EXTR_SKIP);
	!$basename && $basename=$REQUEST_URI;
	if($jumpurl!=''){
		$ifjump="<META HTTP-EQUIV='Refresh' CONTENT='$t; URL=$jumpurl'>";
	}
	require_once GetLang('msg');
	$lang[$msg] && $msg=$lang[$msg];
	include PrintEot('message');exit;
}
function PostLog($log){
	foreach($log as $key=>$val){
		if(is_array($val)){
			$data .= "$key=array(".PostLog($val).")";
		}else{
			$val = str_replace(array("\n","\r","|"),array('','','&#124;'),$val);
			if($key=='password' || $key=='check_pwd'){
				$data .= "$key=***, ";				
			}else{
				$data .= "$key=$val, ";
			}
		}
	}
	return $data;
}
function readlog($filename,$offset=1024000)
{
	$readb=array();
	if($fp=@fopen($filename,"rb")){
		flock($fp,LOCK_SH);
		$size=filesize($filename);
		$size>$offset ? fseek($fp,-$offset,SEEK_END): $offset=$size;
		$readb=fread($fp,$offset);
		fclose($fp);
		$readb=str_replace("\n","\n<:phpvod:>",$readb);
		$readb=explode("<:phpvod:>",$readb);
		$count=count($readb);
		if($readb[$count-1]==''||$readb[$count-1]=="\r"){unset($readb[$count-1]);}
		if(empty($readb)){$readb[0]="";}
	}
	return $readb;
}
function readover($filename,$method="rb"){
	strpos($filename,'..')!==false && exit('Forbidden');
    if($handle=@fopen($filename,$method)){
        flock($handle,LOCK_SH);
        $filedata=@fread($handle,filesize($filename));
        fclose($handle);
    }
    return $filedata;
}
function writeover($filename,$data,$method="rb+",$iflock=1,$check=1,$chmod=1){
	$check && strpos($filename,'..')!==false && exit('Forbidden');
	touch($filename);
	$handle=fopen($filename,$method);
	if($iflock){
		flock($handle,LOCK_EX);
	}
	fwrite($handle,$data);
	if($method=="rb+") ftruncate($handle,strlen($data));
	fclose($handle);
	$chmod && @chmod($filename,0777);
}
function ifcheck($var,$out){
	global ${$out.'_Y'},${$out.'_N'};
	if($var) ${$out.'_Y'}="CHECKED"; else ${$out.'_N'}="CHECKED";

}
function checkselid($selid){
	if(is_array($selid)){
		$ret='';
		foreach($selid as $key => $value){
			if(!is_numeric($value)){
				return false;
			}
			$ret .= $ret ? ','.$value : $value;
		}
		return $ret;
	} else{
		return '';
	}
}
function Char_cv($msg){
	$msg = str_replace("\t","",$msg);
	$msg = str_replace("<","&lt;",$msg);  
	$msg = str_replace(">","&gt;",$msg);
	$msg = str_replace("\r","",$msg);
	$msg = str_replace("\n","<br />",$msg);
	$msg = str_replace("|","│",$msg);
	$msg = str_replace("   "," &nbsp; ",$msg);//禁止html
	return $msg;
}
function ieconvert($msg){
	$msg = str_replace("\t","",$msg);
	$msg = str_replace("\r","",$msg);
	$msg = str_replace("\n","<br />",$msg);
	$msg = str_replace("|","│",$msg);
	$msg = str_replace("   "," &nbsp; ",$msg);//允许html
	return $msg;       
}
function substrs($content,$length){
	global $db_charset;
	if($length && strlen($content)>$length){
		if($db_charset!='utf-8'){
			$retstr='';
			for($i = 0; $i < $length - 2; $i++) {
				$retstr .= ord($content[$i]) > 127 ? $content[$i].$content[++$i] : $content[$i];
			}
			return $retstr.' ..';
		}else{
			return utf8_trim(substr($content,0,$length)).' ..';
		}
	}
	return $content;
}
function utf8_trim($str) {
	$len = strlen($str);
	for($i=strlen($str)-1;$i>=0;$i-=1){
		$hex .= ' '.ord($str[$i]);
		$ch   = ord($str[$i]);
		if(($ch & 128)==0)	return substr($str,0,$i);
		if(($ch & 192)==192)return substr($str,0,$i);
	}
	return($str.$hex);
}
function get_date($timestamp,$timeformat=''){
	global $db_datefm,$db_timedf;
	$date_show=$timeformat ? $timeformat : $db_datefm;
	return gmdate($date_show,$timestamp+$db_timedf*3600);
}
function numofpage($count,$page,$numofpage,$url,$max=0)
{
	$total=$numofpage;
	$max && $numofpage > $max && $numofpage=$max;
	if ($numofpage <= 1 || !is_numeric($page)){
		return ;
	}else{
		$pages="<a href=\"{$url}page=1\">首页</a>&nbsp;";
		$flag=0;
		for($i=$page-3;$i<=$page-1;$i++)
		{
			if($i<1) continue;
			$pages.="&nbsp;<a href='{$url}page=$i'>$i</a>&nbsp;";
		}
		$pages.="&nbsp;<strong>{$page}</strong>&nbsp;";
		if($page<$numofpage)
		{
			for($i=$page+1;$i<=$numofpage;$i++)
			{
				$pages.="&nbsp;<a href='{$url}page=$i'>$i</a>&nbsp;";
				$flag++;
				if($flag==4) break;
			}
		}
		$pages.=" <input type='text' size='2' style='height: 16px; border:1px solid #698CC3' onkeydown=\"javascript: if(event.keyCode==13) location='{$url}page='+this.value;\">&nbsp;<a href=\"{$url}page=$numofpage\">末页</a>&nbsp;Pages: ( $page/$total total )";
		return $pages;
	}
}

function P_unlink($filename){
	strpos($filename,'..')!==false && exit('Forbidden');
	return @unlink($filename);
}

function Pcv($filename,$ifcheck=1){
	strpos($filename,'http://')!==false && exit('Forbidden');
	$ifcheck && strpos($filename,'..')!==false && exit('Forbidden');
	return $filename;
}

function getstyles($skin){
	$styles='';
	$fp=opendir(R_P."data/style/");
	while($skinfile=readdir($fp)){
		if(eregi("\.php$",$skinfile)) {
			$skinfile=str_replace(".php","",$skinfile);
			if($skin && $skinfile==$skin){
				$styles .= "<option value=\"$skinfile\" selected>$skinfile</option>";
			}else{
				$styles .= "<option value=\"$skinfile\">$skinfile</option>";
			}
		}
	}
	closedir($fp);
	return $styles;
}

function PvStrtoTime($time){
	global $db_timedf;
	return function_exists('date_default_timezone_set') ? strtotime($time) - $db_timedf*3600 : strtotime($time);
}

function CalculateCredit($creditdb,$upgradeset)
{
	$credit=0;
	if(is_array($upgradeset))
	foreach($upgradeset as $key=>$val){
		if($creditdb[$key] && $val){
			$credit += $creditdb[$key]*$val;
		}
	}
	return (int)$credit;
}

function getmemberid($nums)
{
	global $lneed;
	arsort($lneed);
	reset($lneed);
	foreach($lneed as $key=>$lowneed){
		$gid=$key;
		if($nums>=$lowneed){
			break;
		}
	}
	return $gid;
}

function update_memberid($userid)
{
	global $db,$db_upgrade;
	$u = $db->get_one("SELECT memberid FROM pv_members WHERE uid='$userid'");
	if(!$u) exit;

	$upgradeset  = unserialize($db_upgrade);
	$usercredit = $db->get_one("SELECT postnum,rvrc,money FROM pv_memberdata WHERE uid='$userid'");

	$creditdb = GetCredit($userid);
	foreach($creditdb as $key=>$value){
		$usercredit[$key] = $value[1];
	}	

	$totalcredit = CalculateCredit($usercredit,$upgradeset);
	$newmemberid = getmemberid($totalcredit);
	if($u['memberid'] != $newmemberid)
	{
		$db->update("UPDATE pv_members SET memberid='$newmemberid' WHERE uid='$userid'");
	}
}

function alert($msg) {
	echo "<script>alert(\"$msg\");</script>";
}

?>