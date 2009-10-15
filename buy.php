<?php
require_once('global.php');

$groupid=='guest'  && Showmsg('not_login');

$video = $db->get_one("SELECT v.*,vd.* FROM	pv_video v LEFT JOIN pv_videodata vd ON v.vid=vd.vid WHERE v.vid='$vid'");

if($video)
{
	if($video['sale']!='')
	{
		$video['sale_value'] = 0;
		$p = strpos($video['sale'],'|');
		if($p!==false)
		{
			$video['sale_value'] = substr($video['sale'],0,$p);
			$video['sale_type'] = substr($video['sale'],$p+1);
			if(!is_numeric($video['sale_value']) || (int)$video['sale_value'] <= 0) $video['sale_value'] = 0;
			if($video['sale_value']=='0') Showmsg('video_nosale');

			switch($video['sale_type'])
			{
				case 'money':
					$v = $db->get_one("SELECT money as n FROM pv_memberdata WHERE uid='$uid'");
					break;
				case 'rvrc':
					$v = $db->get_one("SELECT rvrc as n FROM pv_memberdata WHERE uid='$uid'");
					break;
				default:
					$v = $db->get_one("SELECT value as n FROM pv_membercredit WHERE uid='$uid' AND cid='$video[sale_type]'");
			}

			if((int)$v['n'] < (int)$video['sale_value']) Showmsg('video_sale_error');

			$u = $db->get_one("SELECT buyvid FROM pv_memberdata WHERE uid='$uid'");
			if($u['buyvid'] == '')
				$buyvid = ",{$vid},";
			else
				$buyvid = $u['buyvid']."{$vid},";

			switch($video['sale_type'])
			{
				case 'money':
					$db->update("UPDATE pv_memberdata SET money=money-$video[sale_value],buyvid='$buyvid' WHERE uid='$uid'");
					if($video['authorid']!='0')
						$db->update("UPDATE pv_memberdata SET money=money+$video[sale_value] WHERE uid='$video[authorid]'");
					break;
				case 'rvrc':
					$db->update("UPDATE pv_memberdata SET rvrc=rvrc-$video[sale_value],buyvid='$buyvid' WHERE uid='$uid'");
					if($video['authorid']!='0')
						$db->update("UPDATE pv_memberdata SET rvrc=rvrc+$video[sale_value] WHERE uid='$video[authorid]'");
					break;
				default:
					$db->update("UPDATE pv_membercredit SET value=value-$video[sale_value] WHERE uid='$uid' AND cid='$video[sale_type]'");
					$db->update("UPDATE pv_memberdata SET buyvid='$buyvid' WHERE uid='$uid'");
					if($video['authorid']!='0')
						$db->update("UPDATE pv_membercredit SET value=value+$video[sale_value] WHERE uid='$video[authorid]' AND cid='$video[sale_type]'");
			}

		}

		Showmsg('video_sale_success',"read.php?vid=$vid",'返回观看影片');
	}
	else
		Showmsg('video_nosale');

}
else
	Showmsg('video_error');

?>