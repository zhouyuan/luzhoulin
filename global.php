<?php
error_reporting(E_ERROR | E_PARSE);
set_magic_quotes_runtime(0);

define('R_P',__FILE__ ? getdirname(__FILE__).'/' : './');
define('D_P',R_P);

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

$timestamp= time();
require_once(R_P.'require/defend.php');

/* DEBUG 模式运行网站 */
if($db_debug){
	error_reporting(E_ALL ^ E_NOTICE);
}

$version = "1.0";

!$_SERVER['PHP_SELF'] && $_SERVER['PHP_SELF']=$_SERVER['SCRIPT_NAME'];
$REQUEST_URI  = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];

$db_obstart == 1 && function_exists('ob_gzhandler') ? ob_start('ob_gzhandler') : ob_start();

require_once(R_P."require/template.php");
require_once(R_P."require/credit.php");
require_once(R_P."data/style/{$db_defaultstyle}.php");
require_once(R_P."data/cache/hack.php");
require_once(R_P.'data/cache/level.php');
require_once(R_P.'data/cache/dbset.php');
changedir();

$imgpath	= $db_http		!= 'N' ? $db_http	  : $picpath;
$imgdir		= R_P.$picpath;
$attachdir	= R_P.$attachname;

!$db_siteifopen && Showmsg($db_whyclose);

//数据库连接
require_once(R_P.'data/sql_config.php');
require_once (R_P.'require/db_'.$database.'.php');
$db = new DB($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
unset($dbhost,$dbuser,$dbpw,$dbname,$pconnect);
list($uid,$pwd)=explode("\t",GetCookie('user'));
if(is_numeric($uid) && strlen($pwd)>=32){
	$user		=User_info();
	$uid		=$user['uid'];
	$groupid	=$user['groupid'];
	$memberid   =$user['memberid'];
	$username	=$user['username'];
	$groupid=='-1' && $groupid=$memberid;
} else{
	$groupid = 'guest';
}

if($groupid!='guest'){
	if(file_exists(R_P."data/groupdb/group_$groupid.php")){
		require_once Pcv(R_P."data/groupdb/group_$groupid.php");
	}else{
		require_once(R_P."data/groupdb/group_1.php");
	}
} else{
	require_once(R_P."data/groupdb/group_2.php");
}

function Add_S(&$array){
	foreach($array as $key=>$value){
		if(!is_array($value)){
			$array[$key]=addslashes($value);
		}else{
			Add_S($array[$key]);
		}
	}
}
function Cookie($ck_Var,$ck_Value,$ck_Time = 'F'){
	global $timestamp;
	$ck_Time = $ck_Time == 'F' ? $timestamp + 31536000 : ($ck_Value == '' && $ck_Time == 0 ? $timestamp - 31536000 : $ck_Time);
	setCookie($ck_Var,$ck_Value,$ck_Time);
}
function GetCookie($Var){
    return $_COOKIE[$Var];
}
function GdConfirm($code){
	global $db,$timestamp;
	$sid = GetCookie('sid');
	@extract($db->get_one("SELECT nmsg FROM pv_cknum WHERE sid='$sid'"));
	
	if(!$code || $nmsg!=$code){
		Showmsg('check_error');
	}else{
		$newnmsg=num_rand(4);
		$db->update("UPDATE pv_cknum SET nmsg='$newnmsg',time='$timestamp' WHERE sid='$sid'");
	}
}
function num_rand($lenth){
	mt_srand((double)microtime() * 1000000);
	for($i=0;$i<$lenth;$i++){
		$randval.= mt_rand(0,9);
	}
	return $randval;
}
function User_info(){
	global $db,$uid,$pwd;
	$detail =$db->get_one("SELECT m.*,md.* FROM pv_members m LEFT JOIN pv_memberdata md ON m.uid=md.uid WHERE m.uid='$uid'");
	if(!$detail || $detail['password'] != $pwd){
		unset($detail);
		$GLOBALS['groupid']='guest';
		require_once(R_P.'require/checkpass.php');
		Loginout();
		Showmsg('ip_change','login.php','返回登录页面');
	}else{
		unset($detail['password']);
	}
	return $detail;
}
function refreshto($URL,$content,$statime=2){
	global $db_ifjump;
	$URL=str_replace('&#61;','=',$URL);
	if($db_ifjump && $statime>0){
		ob_end_clean();
		global $imgpath,$db_obstart,$db_wwwname,$db_wwwurl;
		$index_name =& $db_wwwname;
		$index_url =& $db_wwwurl;
		$db_obstart == 1 && function_exists('ob_gzhandler') ? ob_start('ob_gzhandler') : ob_start();
		@extract($GLOBALS, EXTR_SKIP);
		require_once GetLang('refreshto');
		$lang[$content] && $content=$lang[$content];
		@require PrintEot('refreshto');
		exit;
	} else{
		ObHeader($URL);
	}
}
function ObHeader($URL){
	global $db_obstart,$db_wwwurl,$db_htmifopen;
	if($db_htmifopen && strtolower(substr($URL,0,4))!='http'){
		$URL="$db_wwwurl/$URL";
	}

	ob_end_clean();
	if($db_obstart){
		header("Location: $URL");exit;
	}else{
		ob_start();
		echo "<meta http-equiv='refresh' content='0;url=$URL'>";
		exit;
	}
}
function Showmsg($msg_info,$url='',$text=''){
	@extract($GLOBALS, EXTR_SKIP);

	require_once(R_P.'require/header.php');
	require_once GetLang('msg');
	$lang[$msg_info] && $msg_info=$lang[$msg_info];
	$url=='' && $url='javascript:history.go(-1);';
	$text=='' && $text='返回上一步';

	require_once PrintEot('showmsg');
	exit;
}
function GetLang($lang,$EXT="php"){
	$path=R_P."lang/lang_$lang.$EXT";
	return $path;
}

function PrintEot($template,$EXT="htm")
{
	global $tplpath,$db_tplrefresh;
	if(!$template) $template=N;

	$tplfile=R_P."template/$tplpath/$template.$EXT";

	if(file_exists($tplfile))
	{
		$objfile=R_P."data/template/$tplpath/$template.tpl.php";
		if($db_tplrefresh == 1 && (@filemtime($tplfile) > @filemtime($objfile)))
		{
			parse_template($tplpath,$template,$EXT);
		}
	
	}
	else
		$objfile=R_P."data/template/phpvod/$template.tpl.php";

	return $objfile;
}

function PrintHack($template,$EXT="htm")
{
	global $H_name,$db_tplrefresh;
	$tplfile=H_P."template/$template.$EXT";

	if(file_exists($tplfile))
	{
		$objfile=R_P."data/hack/$H_name/$template.tpl.php";
		if($db_tplrefresh == 1 && (@filemtime($tplfile) > @filemtime($objfile)))
		{
			parse_template($H_name,$template,$EXT,"hack");
		}
	
	}
	else exit("Current template file '$tplfile' not found or have no access!");
	return $objfile;
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

function footer(){
	global $db_copyright,$db_icp,$db_icpurl,$db_wwwname,$db_ceoconnect,$db_ceoemail,$groupid,$version,$db_htmifopen,$db_obstart;

	$about = "<a href=\"$db_ceoconnect\" target=\"_blank\">关于$db_wwwname</a> ┆ <a href=\"mailto:$db_ceoemail\">联系我们</a>";
	$RunTime = RunTime_End();
	$db_icp && $db_icp = $db_icpurl ? "<a href=\"$db_icpurl\" target=\"_blank\">$db_icp</a>" : "<a href=\"http://www.miibeian.gov.cn\">$db_icp</a>";
	$powered = "<a href='http://www.phpvod.com' target=\"_blank\">Powered by PHPvod $version</a>";
	include PrintEot('footer');
	$output = str_replace(array('<!--<!---->','<!---->'),array('',''),ob_get_contents());


	if($db_htmifopen){
		$output = preg_replace(
			"/\<a(\s*[^\>]+\s*)href\=([\"|\']?)([^\"\'>\s]+\.php\?[^\"\'>\s]+)([\"|\']?)/ies",
			"Htm_cv('\\3','<a\\1href=\"')",
			$output
		);
	}

	ob_end_clean();	
	$db_obstart == 1 && function_exists('ob_gzhandler') ? ob_start('ob_gzhandler') : ob_start();	
	echo $output;
	exit;
}

function Htm_cv($url,$tag){
	global $db_dir,$db_ext;
	if(ereg("^http|ftp|telnet|mms|rtsp|admin.php|rss.php",$url)===false){
		if(strpos($url,'#')!==false){
			$add = substr($url,strpos($url,'#'));
		}
		$url = str_replace(
			array('.php?','=','&',$add),
			array($db_dir,'-','-',''),
			$url
		).$db_ext.$add;
	}
	return stripslashes($tag).$url.'"';
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
function Char_cv($msg){
	$msg = str_replace('&amp;','&',$msg);
	$msg = str_replace('&nbsp;',' ',$msg);
	$msg = str_replace('"','&quot;',$msg);
	$msg = str_replace("'",'&#39;',$msg);
	$msg = str_replace("<","&lt;",$msg);
	$msg = str_replace(">","&gt;",$msg);
	$msg = str_replace("\t"," &nbsp; &nbsp;",$msg);
	$msg = str_replace("\r","",$msg);
	$msg = str_replace("   "," &nbsp; ",$msg);
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
function get_date($timestamp,$timeformat=''){
	global $db_datefm,$db_timedf;
	$date_show=$timeformat ? $timeformat : $db_datefm;
	return gmdate($date_show,$timestamp+$db_timedf*3600);
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
		$pages.="&nbsp;<strong>$page</strong>&nbsp;";
		if($page<$numofpage)
		{
			for($i=$page+1;$i<=$numofpage;$i++)
			{
				$pages.="&nbsp;<a href='{$url}page=$i'>$i</a>&nbsp;";
				$flag++;
				if($flag==4) break;
			}
		}
		$pages.="<input type='text' size='2' class='text' onkeydown=\"javascript: if(event.keyCode==13) location='{$url}page='+this.value;\">&nbsp;<a href=\"{$url}page=$numofpage\">末页</a>&nbsp;共{$total}页";
		return $pages;
	}
}
function RunTime_Begin()
{
	global $_starttime;
	$_nowtime = explode(" ", microtime());
	$_starttime = $_nowtime[1] + $_nowtime[0];
}
function RunTime_End()
{
	global $_starttime;
	$_nowtime = explode(" ", microtime());
	$_endtime = $_nowtime[1] + $_nowtime[0];
	$_totaltime = $_endtime - $_starttime;
	return $_totaltime;
}
function Pcv($filename,$ifcheck=1){
	strpos($filename,'http://')!==false && exit('Forbidden');
	$ifcheck && strpos($filename,'..')!==false && exit('Forbidden');
	return $filename;
}

function P_unlink($filename){
	strpos($filename,'..')!==false && exit('Forbidden');
	return @unlink($filename);
}

function changedir(){
	global $db_hour,$timestamp,$db_autochange,$picpath,$attachname;
	if($db_autochange)
	{
		if(file_exists(R_P."data/cache/changedir.php"))
		{
			list(,$set_control) = explode("|",readover(R_P."data/cache/changedir.php"));
		}
		else
		{
			$set_control = 0;
		}

		if (($timestamp - $set_control) > $db_hour * 3600)
		{
			$imgdt    = $timestamp + $db_hour;
			$attachdt = $imgdt + $db_hour * 100;

			if(@rename(R_P.$picpath,R_P.$imgdt) && @rename(R_P.$attachname,R_P.$attachdt))
			{
				$dbcontent="<?php\n\$picpath='$imgdt';\n\$attachname='$attachdt';\n?>";
				writeover(R_P."data/cache/dbset.php",$dbcontent);
				$GLOBALS['picpath'] = $imgdt;
				$GLOBALS['attachname'] = $attachdt;
			}

			writeover(R_P."data/cache/changedir.php","<?die;?>|$timestamp");
		}
	}
}

function CalculateCredit($creditdb,$upgradeset)
{
	$credit=0;
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

function getsubcid($cid)
{
	global $class;
	$subcid='';
	foreach($class as $svalue)
	{
		$fathers = explode(',',$svalue['fathers']);
		if(in_array($cid,$fathers))
		{
			if($subcid=='') $subcid.="$svalue[cid]"; else $subcid.=",$svalue[cid]";
		}
	}
	return $subcid;
}

function pv_loop($type,$str_param)
{
	global $db,$class,$notice,$cid,$imgdir,$imgpath,$SYSTEM;

	/* 分解参数成数组 */
	$param_array = explode('|',$str_param);
	$param = array();
	foreach($param_array as $value)
	{
		$p = strpos($value,'=');
		if($p===false) continue;
		$key = substr($value,0,$p);
		$val = substr($value,$p+1);
		$param[$key]=$val;
	}

	$result = array();
	if($SYSTEM['allowadminshow']!='1') $sql="yz='1'"; else $sql='1';

	/* 视频循环 cid=1|showsub=1|best=1|order=?|limit=?|dateformat=1|subject_len=22|playactor_len=10|content_len=30 */
	if($type=='video')
	{
		/* 	类别 [cid=?] -1表示所有类别, 0表示当前类别, 其余数字表示类别ID */
		if(isset($param['cid']) && is_numeric($param['cid']) && (int)$param['cid']>=0)
		{
			if($param['cid']=='0') $nowcid = $cid; else $nowcid = $param['cid'];
			$class[$nowcid]['cup']!='0' && $sql.=" AND v.cid='$nowcid'";

			/* 是否显示子类别下的视频 1为显示, 0为不显示 */
			if(isset($param['showsub']) && $param['showsub']=='1')
			{
				$subcid = getsubcid($nowcid);
				if($subcid!='') $sql.=" AND v.cid IN($subcid)";
			}

		}

		/* 推荐 0表示没有推荐的视频 1表示在首页显示的推荐视频 2表示在栏目显示的推荐视频 */
		if(isset($param['best']) && is_numeric($param['best']) && (int)$param['best']>=0)
		{
			switch($param['best'])
			{
				case '0':
					$sql.=" AND best='0'";
					break;
				case '1':
					$sql.=" AND (best='1' OR best='3')";
					break;
				case '2':
					$sql.=" AND (best='2' OR best='3')";
					break;
			}

		}


		/* 排序 */
		if(isset($param['order']) && $param['order']!='')
		{
			$sql.=" ORDER BY $param[order]";
		}

		/* 显示数量 */
		if(isset($param['limit']) && $param['limit']!='')
		{
			$sql.=" LIMIT $param[limit]";
		}

		$query = $db->query("SELECT * FROM pv_video as v LEFT JOIN pv_videodata as vd ON v.vid=vd.vid WHERE $sql");
		
		while($video = $db->fetch_array($query))
		{
			switch($param['dateformat'])
			{
				case '0': $dateformat = 'Y-m-d'; break;
				case '1': $dateformat = 'm-d'; break;
				case '2': $dateformat = 'Y/m/d'; break;
				case '3': $dateformat = 'm/d'; break;
				case '4': $dateformat = 'Y.m.d'; break;
				case '5': $dateformat = 'm.d'; break;
				default: $dateformat = 'Y-m-d'; break;
			}

			$video['postdate'] = get_date($video['postdate'],$dateformat);
			$video['lostdate'] = get_date($video['lostdate'],$dateformat);

			$picname=$video['pic'];
			if($picname!='' && file_exists("$imgdir/pic/$picname"))
				$video['pic']="$imgpath/pic/$picname";
			elseif($picname=='' || strtolower(substr($picname,0,7))!='http://')
				$video['pic']="$imgpath/pic/nopic.gif";

			isset($param['subject_len']) && is_numeric($param['subject_len']) && strlen($video['subject'])>(int)$param['subject_len'] && $video['subject']=substrs($video['subject'],$param['subject_len']);

			isset($param['playactor_len']) && is_numeric($param['playactor_len']) && strlen($video['playactor'])>(int)$param['playactor_len'] && $video['playactor']=substrs($video['playactor'],$param['playactor_len']);

			isset($param['content_len']) && is_numeric($param['content_len']) && strlen($video['content'])>(int)$param['content_len'] && $video['content']=substrs($video['content'],$param['content_len']);
			
			$result[]=$video;

		}
		
		return $result;

	}
	
	/* 栏目循环 cid=0 */
	elseif($type=='class')
	{
		if(isset($param['cid']) && is_numeric($param['cid']))
		{
			foreach($class as $value)
			{
				if($value['cup']==$param['cid']) $result[]=$value;
			}

		}
		return $result;
	}

	/* 公告循环 dateformat=1*/
	elseif($type=='notice')
	{
		
		switch($param['dateformat'])
		{
			case '0': $dateformat = 'Y-m-d'; break;
			case '1': $dateformat = 'm-d'; break;
			case '2': $dateformat = 'Y/m/d'; break;
			case '3': $dateformat = 'm/d'; break;
			case '4': $dateformat = 'Y.m.d'; break;
			case '5': $dateformat = 'm.d'; break;
			default: $dateformat = 'Y-m-d'; break;
		}
		
		foreach($notice as $value)
		{
			$value['startdate'] = get_date($value['startdate'],$dateformat);
			$result[]=$value;
		}
		return $result;
	}
	
}

?>