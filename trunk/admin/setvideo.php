<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=setvideo";

if (!$action){
	include PrintEot('setvideo');exit;
} elseif($action=='search'){
	$sql='1';
	$author = trim($author);
	$subject = trim($subject);
	$content = trim($content);
	$playactor = trim($playactor);
	$director = trim($director);
	if($author!=''){
		$author=addslashes(str_replace('*','%',$author));
		$sql.=$author_s==1 ? " AND m.author LIKE '$author'" : " AND (m.author LIKE '%$author%')" ;
	}
	if($subject!=''){
		$subject=addslashes(str_replace('*','%',$subject));
		$sql.=$subject_s==1 ? " AND m.subject LIKE '$subject'" : " AND (m.subject LIKE '%$subject%')" ;
	}
	if($content!=''){
		$content=str_replace('*','%',$content);
		$sql.=" AND (m.content LIKE '%$content%')";
	}
	if($playactor!=''){
		$playactor=str_replace('*','%',$playactor);
		$sql.=" AND (m.playactor LIKE '%$playactor%')";
	}
	if($director!=''){
		$director=str_replace('*','%',$director);
		$sql.=" AND (m.director LIKE '%$director%')";
	}
	if($hits!=''){
		if($bj=='0') $sql.=" AND md.hits <'$hits'";
		elseif($bj=='1') $sql.=" AND md.hits >'$hits'";
	}
	if($best!='all')
	{
		$sql.=" AND m.best=$best";
	}
	if($postdate!='all' && is_numeric($postdate)){
		$schtime=$timestamp-$postdate;
		$sql.=" AND m.postdate<'$schtime'";
	}
	if($orderway){
		$order="ORDER BY $orderway $asc";
	}

	$rs=$db->get_one("SELECT COUNT(*) AS count FROM pv_video m LEFT JOIN pv_videodata md ON md.vid=m.vid WHERE $sql");
	$count=$rs['count'];
	if(!is_numeric($lines))$lines=100;
	(!is_numeric($page) || $page < 1) && $page=1;
	$numofpage=ceil($count/$lines);
	if($numofpage&&$page>$numofpage){
		$page=$numofpage;
	}
	$pages=numofpage($count,$page,$numofpage,"$admin_file?adminjob=setvideo&action=$action&author=".rawurlencode($author)."&subject=$subject&content=$content&playactor=$playactor&director=$director&hits=$hits&best=$best&postdate=$postdate&orderway=$orderway&lines=$lines&");
	$start=($page-1)*$lines;
	$limit="LIMIT $start,$lines";
	$videodb=array();

	$query=$db->query("SELECT m.vid,m.author,m.authorid,m.subject,md.hits,m.postdate,m.best FROM pv_video m LEFT JOIN pv_videodata md ON md.vid=m.vid WHERE $sql $order $limit");

	$option = "<option value=\"0\">不推荐</option><option value=\"1\">首页推荐</option><option value=\"2\">栏目推荐</option><option value=\"3\">首页栏目推荐</option>";
	
	while($rt=$db->fetch_array($query)){
		$rt['postdate']= get_date($rt['postdate']);
		$rt['option'] = str_replace("<option value=\"$rt[best]\">","<option value=\"$rt[best]\" selected>",$option);
		$videodb[]=$rt;
	}
	include PrintEot('setvideo');exit;
}elseif($action=='setvideo'){
	if(!$best) adminmsg('operate_error');

	foreach($best as $key => $value)
	{
		$db->update("UPDATE pv_video SET best='$value' WHERE vid='$key'");
	}


	if(is_array($selid))
	{
		foreach($selid as $vid)
		{
			@extract($db->get_one("SELECT authorid,pic,yz FROM pv_video WHERE vid='$vid'"));
			if(file_exists("$imgdir/pic/$pic")) P_unlink("$imgdir/pic/$pic");
			if($yz=='1' && $authorid!='0')
			{
				@extract($db->get_one("SELECT postnum FROM pv_memberdata WHERE uid='$authorid'"));
				$postnum+=-1;
				$credit = unserialize($db_creditset);
				$decmoney = $credit['money']['Delete'];
				$decrvrc = $credit['rvrc']['Delete'];
				$db->update("UPDATE pv_memberdata SET postnum='$postnum',rvrc=rvrc-$decrvrc,money=money-$decmoney WHERE uid='$authorid'");
				
				customcredit($authorid,$credit,'Delete');
				update_memberid($authorid);
			}		
			
			$db->update("DELETE FROM pv_video WHERE vid='$vid'");
			$db->update("DELETE FROM pv_videodata WHERE vid='$vid'");
			$db->update("DELETE FROM pv_urls WHERE vid='$vid'");

		}
	}
	adminmsg('operate_success');
}
?>