<?php
define('SCR','play');
require_once('global.php');
require_once(R_P.'data/cache/class.php');

$url = $db->get_one("
SELECT
	u.vid,u.uid,u.url,u.pid,u.series,u.server,u.caption,
	v.subject,v.cid,v.authorid,
	vd.sale,vd.need,
	p.playpath 
FROM 
	pv_urls u LEFT JOIN pv_video v ON v.vid=u.vid LEFT JOIN pv_videodata vd ON v.vid=vd.vid LEFT JOIN pv_player p ON p.pid=u.pid 
WHERE
	u.uid='$urlid'
");

$next_series = $url['series'] + 1;
$next = $db->get_one("SELECT uid,url FROM pv_urls WHERE vid='$url[vid]' AND server='$url[server]' AND series='$next_series'");
if($next)
{
	$nextpage = $db_wwwurl.'/play.php?urlid='.$next['uid'];
	$nexturl = $next['url'];
}
else
{
	$nextpage = '';
	$nexturl = '';
}

!$url && Showmsg('data_error');


/* 用户组权限 */
if($gp_allowplay!='1') Showmsg('group_play');


/* 栏目权限 */
$cid = $url['cid'];

if($class[$cid]['type']!='free' && $groupid=='guest') Showmsg('play_guest');

if($class[$cid]['allowplay']!='')
{
	if($groupid=='guest' || strpos($class[$cid]['allowplay'],",$groupid,")===false) Showmsg('play_noper');
}

if($class[$cid]['rvrcneed'] || $class[$cid]['moneyneed'] || $class[$cid]['postneed'])
{
	$groupid=='guest' && Showmsg('play_guestlimit');
	$data = $db->get_one("SELECT postnum,rvrc,money FROM pv_memberdata WHERE uid='$uid'");

	$check = 1;
	if($class[$cid]['rvrcneed'] && $data['rvrc']<$class[$cid]['rvrcneed'])
		$check = 0;
	else if($class[$cid]['moneyneed'] && $data['money']<$class[$cid]['moneyneed'])
		$check = 0;
	else if($class[$cid]['postneed'] && $data['postnum']<$class[$cid]['postneed'])
		$check = 0;

	if(!$check)	Showmsg('play_creditlimit');
}

$pwdcheck=GetCookie('pwdcheck');
if($class[$cid]['password']!='' && ($groupid=='guest' || $pwdcheck[$cid]!=$class[$cid]['password']))
{
	Showmsg('play_password');
}


/* 积分 */
if($url['sale']!='' && strpos($user['buyvid'],",{$url[vid]},")===false && $SYSTEM['allowadminviewhide']!='1' && $uid!=$url['authorid'])
	Showmsg('play_credit_buy');

if($url['need']!='' && $SYSTEM['allowadminviewhide']!='1' && $uid!=$url['authorid'])
{
	$p = strpos($url['need'],'|');
	if($p!==false)
	{
		$url['need_value'] = substr($url['need'],0,$p);
		$url['need_type'] = substr($url['need'],$p+1);


		if(!is_numeric($url['need_value']) || (int)$url['need_value'] <= 0) $url['need_value'] = 0;
		if((int)$url['need_value'] > 0)
		{
			switch($url['need_type'])
			{
				case 'money':
					$nv = $db->get_one("SELECT money as v FROM pv_memberdata WHERE uid='$uid'");
					break;
				case 'rvrc':
					$nv = $db->get_one("SELECT rvrc as v FROM pv_memberdata WHERE uid='$uid'");
					break;
				default:
					$nv = $db->get_one("SELECT value as v FROM pv_membercredit WHERE uid='$uid' AND cid='$url[need_type]'");
					break;
			}

			if((int)$nv['v']<(int)$url['need_value'])
			{
				Showmsg('play_credit_need');				
			}
		}

	}
}


$player = readover(R_P.'data/player/'.$url['playpath']);
$player = str_replace('$urlpath',$url['url'],$player);
$player = str_replace('$nextpage',$nextpage,$player);
$player = str_replace('$nexturl',$nexturl,$player);

require_once(R_P.'require/header.php');
require_once PrintEot('play');footer();

?>