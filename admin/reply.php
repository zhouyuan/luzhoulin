<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=reply";
$role = $admin['grouptitle'];
$userRegion = $admin['region'];
$userSchool = $admin['school'];

if (!$action){
	include PrintEot('reply');exit;
} elseif($action=='search'){
	$sql='1';
	$author = trim($author);
	if($author!=''){
		$author=addslashes(str_replace('*','%',$author));
		$sql.= $author_s==1 ? " AND author LIKE '$author'" : " AND (author LIKE '%$author%')" ;
	}
	if($content!=''){
		$content=str_replace('*','%',$content);
		$sql.=" AND (content LIKE '%$content%')";
	}
	if($postdate!='all' && is_numeric($postdate)){
		$schtime=$timestamp-$postdate;
		$sql.=" AND postdate<'$schtime'";
	}
	if($yz!='all' && is_numeric($yz)){
		$sql.=" AND yz=$yz";
	}
	
	if($role =="校级管理员")$sql.=" AND m.school = '$userSchool' AND groupid >5 OR groupid<3 ";
	else if($role == "区级管理员")$sql.=" AND m.region = '$userRegion' AND groupid<>5 ";
	
	if($orderway){
		$order="ORDER BY '$orderway'";
		 $asc && $order.=$asc;
	}
	$rs=$db->get_one("SELECT COUNT(*) AS count FROM pv_replier inner join pv_members m on pv_replier.authorid = m.uid WHERE $sql");
	$count=$rs['count'];
	if(!is_numeric($lines))$lines=100;
	(!is_numeric($page) || $page < 1) && $page=1;
	$numofpage=ceil($count/$lines);
	if($numofpage&&$page>$numofpage){
		$page=$numofpage;
	}
	$pages=numofpage($count,$page,$numofpage,"$admin_file?adminjob=reply&action=$action&author=".rawurlencode($author)."&content=$content&postdate=$postdate&orderway=$orderway&lines=$lines&");
	$start=($page-1)*$lines;
	$limit="LIMIT $start,$lines";

	$schdb=array();
	$query=$db->query("SELECT * FROM pv_replier inner join pv_members m on pv_replier.authorid = m.uid WHERE $sql $order $limit");
	while($sch=$db->fetch_array($query)){
		$sch['postdate']= get_date($sch['postdate']);
		$sch['yz'] = $sch['yz']=='1' ? '已通过' : '未审核';
		strlen($sch['content'])>40 && $sch['content']=substrs($sch['content'],40);
		$schdb[]=$sch;
	}
	include PrintEot('reply');exit;
} elseif($action=='read'){
	@extract($db->get_one("SELECT content FROM pv_replier WHERE id='$id'"));
	include PrintEot('reply');exit;
}elseif($action=='check'){
	!$selid && adminmsg('operate_error');
	foreach($selid as $id)
	{
		$video = $db->get_one("SELECT vid,yz,authorid FROM pv_replier WHERE id='$id'");
		if($type=='pass')
		{
			if($video['yz']==1) continue;
			$db->update("UPDATE pv_videodata SET replier=replier+1 WHERE vid='$video[vid]'");
			$db->update("UPDATE pv_replier SET yz='1' WHERE id='$id'");
			if($video['authorid']!='0')
			{
				$credit = unserialize($db_creditset);
				$addmoney = $credit['money']['Reply'];
				$addrvrc = $credit['rvrc']['Reply'];
				$db->update("UPDATE pv_memberdata SET rvrc=rvrc+$addrvrc,money=money+$addmoney WHERE uid='$video[authorid]'");

				customcredit($video['authorid'],$credit,'Reply');
				update_memberid($video['authorid']);
			}
		}
		else
		{
			$db->update("DELETE FROM pv_replier WHERE id='$id'");
			if($video['yz']==0) continue;
			$db->update("UPDATE pv_videodata SET replier=replier-1 WHERE vid='$video[vid]'");
			if($video['authorid']!='0')
			{
				$credit = unserialize($db_creditset);
				$decmoney = $credit['money']['Deleterp'];
				$decrvrc = $credit['rvrc']['Deleterp'];
				$db->update("UPDATE pv_memberdata SET rvrc=rvrc-$decrvrc,money=money-$decmoney WHERE uid='$video[authorid]'");

				customcredit($video['authorid'],$credit,'Deleterp');
				update_memberid($video['authorid']);
			}
		}
	}

	adminmsg('operate_success');

}
?>