<?php
define('SCR','class');
require_once('global.php');
require_once(R_P.'data/cache/class.php');

(!is_numeric($cid) || $class[$cid]['cup'] == 0) && Showmsg('class_illegal');
!isset($class[$cid]) && Showmsg('class_error');

/* 用户组权限*/
if($gp_allowread!='1') Showmsg('group_read');

/* 栏目权限 */
if($class[$cid]['type']!='free' && $groupid=='guest') Showmsg('class_guest');

if($class[$cid]['allowvisit']!='')
{
	if($groupid=='guest' || strpos($class[$cid]['allowvisit'],",$groupid,")===false) Showmsg('class_visit');
}

if($class[$cid]['rvrcneed'] || $class[$cid]['moneyneed'] || $class[$cid]['postneed'])
{
	$groupid=='guest' && Showmsg('class_guestlimit');
	$data = $db->get_one("SELECT postnum,rvrc,money FROM pv_memberdata WHERE uid='$uid'");

	$check = 1;
	if($class[$cid]['rvrcneed'] && $data['rvrc']<$class[$cid]['rvrcneed'])
		$check = 0;
	else if($class[$cid]['moneyneed'] && $data['money']<$class[$cid]['moneyneed'])
		$check = 0;
	else if($class[$cid]['postneed'] && $data['postnum']<$class[$cid]['postneed'])
		$check = 0;

	if(!$check)	Showmsg('class_creditlimit');
}

$pwdcheck=GetCookie('pwdcheck');
if($class[$cid]['password']!='' && ($groupid=='guest' || $pwdcheck[$cid]!=$class[$cid]['password']))
	require_once(R_P.'require/classpw.php');


$cup = $class[$cid]['cup'];
$subnum = 0; 
foreach($class as $value) if($value['cup']==$cid) $subnum++;
if($class[$cup]['cup']==0) $link=$db_bfn; else $link="class.php?cid=$cup";

$rt = $db->get_one("SELECT COUNT(*) AS sum FROM pv_video WHERE cid='$cid'");
(!is_numeric($page) || $page < 1) && $page = 1;
$limit = "LIMIT ".($page-1)*$db_perpage.",$db_perpage";
$pages = numofpage($rt['sum'],$page,ceil($rt['sum']/$db_perpage),"class.php?cid=$cid&");	

$orderway = $class[$cid]['orderway'];
$orderasc = $class[$cid]['orderasc'] == '0' ? 'ASC' : 'DESC';

if($SYSTEM['allowadminshow']!='1') $yzsql="AND yz='1'"; else $yzsql='';

$query=$db->query("SELECT *,v.subject as title,n.subject as nation FROM pv_video as v LEFT JOIN pv_videodata as vd ON v.vid=vd.vid LEFT JOIN pv_nations as n ON v.nid=n.id WHERE cid='$cid' $yzsql ORDER BY $orderway $orderasc $limit");
$videodb = array();
while($video=$db->fetch_array($query))
{
	strlen($video['title'])>24 && $video['title']=substrs($video['title'],24);
	strlen($video['playactor'])>24 && $video['playactor']=substrs($video['playactor'],24);

	if($video['pic']!='' && file_exists("$imgdir/pic/$video[pic]"))
		$video['pic']="$imgpath/pic/$video[pic]";
	elseif($video['pic']=='' || strtolower(substr($video['pic'],0,7))!='http://')
		$video['pic']="$imgpath/pic/nopic.gif";

	$video['postdate']=get_date($video['postdate']);
	$videodb[]=$video;
}
unset($video);

require_once(R_P.'require/header.php');
require_once PrintEot('class');footer();
?>