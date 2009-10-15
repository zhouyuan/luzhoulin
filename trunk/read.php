<?php
define('SCR','read');
require_once('global.php');
require_once(R_P.'data/cache/class.php');
require_once(R_P.'data/cache/level.php');
require_once(R_P.'data/cache/medaldb.php');
require_once(R_P.'data/cache/creditdb.php');

!is_numeric($vid) && Showmsg('video_illegal');
if($SYSTEM['allowadminshow']!='1') $yzsql="AND v.yz='1'"; else $yzsql='';

$video = $db->get_one("
SELECT
	v.*,vd.*,m.*,md.*,c.*,n.subject as nation 
FROM
	pv_video v LEFT JOIN pv_videodata vd ON v.vid=vd.vid 
	LEFT JOIN pv_members m ON m.uid=v.authorid 
	LEFT JOIN pv_memberdata md ON md.uid=v.authorid 
	LEFT JOIN pv_class c ON c.cid=v.cid 
	LEFT JOIN pv_nations n ON n.id=v.nid 
WHERE v.vid='$vid' $yzsql");
!$video && Showmsg('video_error');

/* 用户组权限 */
if($gp_allowread!='1') Showmsg('group_read');

/* 栏目权限 */
$cid = $video['cid'];
if($class[$cid]['type']!='free' && $groupid=='guest') Showmsg('read_guest');

if($class[$cid]['allowvisit']!='')
{
	if($groupid=='guest' || strpos($class[$cid]['allowvisit'],",$groupid,")===false) Showmsg('read_visit');
}

if($class[$cid]['rvrcneed'] || $class[$cid]['moneyneed'] || $class[$cid]['postneed'])
{
	$groupid=='guest' && Showmsg('read_guestlimit');
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
{
	Showmsg('read_password');
}


/* 菜单 */
$cup = $class[$cid]['cup'];
$subnum = 0; 
foreach($class as $value) if($value['cup']==$cid) $subnum++;
if($class[$cup]['cup']==0) $link=$db_bfn; else $link="class.php?cid=$cup";


/* 影片 */
if($video['pic']!='' && file_exists("$imgdir/pic/$video[pic]"))
	$video['pic']="$imgpath/pic/$video[pic]";
elseif($video['pic']=='' || strtolower(substr($video['pic'],0,7))!='http://')
	$video['pic']="$imgpath/pic/nopic.gif";

$video['tag']=explode("\t",$video['tag']);
foreach($video['tag'] as $key){
	$tag.="<a href=search.php?action=search&field=tag&keyword=".urlencode($key).">$key</a> ";
}

if(strpos($video['playactor'],',')!==false)
	$video['playactor']=explode(",",$video['playactor']);
else
	$video['playactor']=explode(" ",$video['playactor']);

foreach($video['playactor'] as $key){
	$playactor.="<a href=search.php?action=search&field=playactor&keyword=".urlencode($key).">$key</a> ";
}

if(strpos($video['director'],',')!==false)
	$video['director']=explode(",",$video['director']);
else
	$video['director']=explode(" ",$video['director']);

foreach($video['director'] as $key){
	$director.="<a href=search.php?action=search&field=director&keyword=".urlencode($key).">$key</a> ";
}

/* 出售 & 加密 */
$need_show = '1';
$buy_show = '1';

$video['sale_value'] = $video['need_value'] = '0';
$sale_msg = $need_msg = '';

if($video['sale']!='' && strpos($user['buyvid'],",{$vid},")===false && $SYSTEM['allowadminviewhide']!='1' && $uid!=$video['authorid'])
{
	$p = strpos($video['sale'],'|');
	if($p!==false)
	{
		$video['sale_value'] = substr($video['sale'],0,$p);
		$video['sale_type'] = substr($video['sale'],$p+1);
		
		if($video['sale_type'] == 'money')
			$video['sale_type_caption'] = '金钱';
		elseif($video['sale_type'] == 'rvrc')
			$video['sale_type_caption'] = '威望';
		else
			$video['sale_type_caption'] = $_CREDITDB[$video['sale_type']][0];

		if(!is_numeric($video['sale_value']) || (int)$video['sale_value'] <= 0) $video['sale_value'] = 0;
		if((int)$video['sale_value'] > 0) $sale_msg = "您必须支付 <span style=\"color: red;\">{$video[sale_value]} {$video[sale_type_caption]}</span> 才能观看视频。 <a href=\"buy.php?vid=$vid\">[付费购买]</a>";
		$buy_show = '0';
	}
}

if($video['need']!='' && $SYSTEM['allowadminviewhide']!='1' && $uid!=$video['authorid'])
{
	$p = strpos($video['need'],'|');
	if($p!==false)
	{
		$video['need_value'] = substr($video['need'],0,$p);
		$video['need_type'] = substr($video['need'],$p+1);

		if($video['need_type'] == 'money')
			$video['need_type_caption'] = '金钱';
		elseif($video['need_type'] == 'rvrc')
			$video['need_type_caption'] = '威望';
		else
			$video['need_type_caption'] = $_CREDITDB[$video['need_type']][0];

		if(!is_numeric($video['need_value']) || (int)$video['need_value'] <= 0) $video['need_value'] = 0;
		if((int)$video['need_value'] > 0)
		{
			switch($video['need_type'])
			{
				case 'money':
					$nv = $db->get_one("SELECT money as v FROM pv_memberdata WHERE uid='$uid'");
					break;
				case 'rvrc':
					$nv = $db->get_one("SELECT rvrc as v FROM pv_memberdata WHERE uid='$uid'");
					break;
				default:
					$nv = $db->get_one("SELECT value as v FROM pv_membercredit WHERE uid='$uid' AND cid='$video[need_type]'");
					break;
			}

			if((int)$nv['v']<(int)$video['need_value'])
			{
				$need_msg = "您必须拥有 <span style=\"color: red;\">{$video[need_value]} {$video[need_type_caption]}</span> 以上才能观看视频";
				$need_show = '0';
			}
		}

	}
}

$video['postdate'] = get_date($video['postdate']);
$video['lostdate'] = get_date($video['lostdate']);
$video['content'] = ieconvert($video['content']);

$editvideo=$delvideo='';
if($groupid=='guest') $uid=0;
if(($video['authorid']==$uid && $gp_alloweditatc=='1') || $SYSTEM['allowadminedit']=='1')
	$editvideo = " | <a href=\"post.php?action=modify&vid=$video[vid]\">编辑</a>";

if(($video['authorid']==$uid && $gp_allowdelatc=='1') || $SYSTEM['allowadmindel']=='1')
	$delvideo = " | <a href=\"post.php?action=del&vid=$video[vid]\" onclick=\"return window.confirm('您确定要删除视频 $video[subject] 吗？');\">删除</a>";	

$servers=array();
$query=$db->query("SELECT server FROM pv_urls WHERE vid='$vid' GROUP BY server");
while($row=$db->fetch_array($query))
{
	$servers[] = $row['server'];
}

$urldb=array();
foreach($servers as $server)
{
	$query=$db->query("SELECT series,uid,caption,server,name FROM pv_urls LEFT JOIN pv_player ON pv_urls.pid = pv_player.pid WHERE vid='$vid' AND server='$server' ORDER BY series ASC");
	while($url=$db->fetch_array($query))
	{
		$url['caption']=='' && $url['caption']='第'.$url['series'].'集';
		strlen($url['caption'])>12 ? $url['caption_str']=substrs($url['caption'],12) : $url['caption_str']=$url['caption'];
		$urldb[$server][]=$url;
	}
}

/* 会员 */
if($video['authorid']!='0' && $video['groupid']!='')
{
	if($video['icon']=='' || !file_exists("$imgdir/face/$video[icon]"))
		$video['icon']="$imgpath/face/none.gif";
	else
		$video['icon']="$imgpath/face/$video[icon]";

	$gid = $video['groupid'] == '-1' ? 'memberid' : 'groupid';
	$lpic=$lpic[$video[$gid]];
	$video['levelpic'] = "$imgpath/$stylepath/level/$lpic.gif";
	$video['levelname'] = $ltitle[$video[$gid]];

	$usercredit=array(
		"postnum"	=>	"$video[postnum]",
		"rvrc"		=>	"$video[rvrc]",
		"money"		=>	"$video[money]",
	);

	$creditdb = GetCredit($video['authorid']);
	foreach($creditdb as $key=>$value){
		$usercredit[$key] = $value[1];
	}
	
	$upgradeset = unserialize($db_upgrade);
	$video['credit'] = CalculateCredit($usercredit,$upgradeset);

	$video['regdate'] = get_date($video['regdate']);
	$logininfo=explode('|',$video['onlineip']);
	$video['ip']=$logininfo[0];
	$video['lastlogin']=get_date($logininfo[1]);

	$row = $db->get_one("SELECT medals FROM pv_members WHERE uid='$video[uid]'");
	if($row['medals']){
		$video['medals'] = explode(',',$row['medals']);
	}else{
		$video['medals'] = '';
	}	
}
else
{
	//guest
	$video['icon']="$imgpath/face/none.gif";
	$video['levelpic'] = "$imgpath/$stylepath/level/{$lpic[2]}.gif";
	$video['levelname'] = $ltitle[2];
	$video['honor'] = '*';
	$video['rvrc'] = '*';
	$video['money'] = '*';
	$video['postnum'] = '*';
	$video['credit'] = '*';
	$video['regdate'] = '*';
	$video['ip'] = '*';
	$video['lastlogin'] = '*';

	$creditdb = GetCredit($video['authorid']);
	foreach($creditdb as $key => $value) $creditdb[$key][1] = '*';
}

$otherdb = array();
$result = $db->query("SELECT * FROM pv_video WHERE authorid='$video[authorid]' AND vid<>'$video[vid]' ORDER BY postdate DESC LIMIT 10");
while($row=$db->fetch_array($result))
{
	$row['postdate'] = get_date($row['postdate'],'m-j');
	strlen($row['subject'])>20 && $row['subject']=substrs($row['subject'],20);
	$otherdb[]=$row;
}

require_once(R_P.'require/header.php');
require_once PrintEot('read');
$db->update("UPDATE pv_videodata SET hits=hits+1 WHERE vid='$vid'");
footer();
?>