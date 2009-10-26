<?php
require_once('global.php');
@set_time_limit(0);
require_once(R_P.'require/header.php');
include_once(R_P.'data/cache/nation.php');
include_once(R_P.'data/cache/class.php');

if(!$action){
	require_once PrintEot('search');footer();
}elseif($action=='search'){
	if($SYSTEM['allowadminshow']!='1') $yzsql="AND yz='1'"; else $yzsql='';
	$keyword = urldecode(trim($keyword));
	$suject=$_POST['subject'];
	$director=$_POST['director'];
	$tag=$_POST['tag'];
	//empty($keyword) && Showmsg('no_condition');
	//empty($subject) && Showmsg('no_condition');
	$sql='1';

	if($cid){

		if($class[$cid]['cup']=='0')
		{
			$subcid='';
			foreach($class as $svalue)
			{
				$fathers = explode(',',$svalue['fathers']);
				if(in_array($cid,$fathers))
				{
					if($subcid=='') $subcid.="$svalue[cid]"; else $subcid.=",$svalue[cid]";
				}

			}
			$sql .= $subcid!='' ? " AND cid IN($subcid)" : " AND cid IN(-1)";

		}
		else $sql.=" AND (cid='$cid')";

	}
	
	if($nid){
		$sql.=" AND (nid='$nid')";
	}
	if($field){
		
		if($field=='author')
			$sql.=" AND ($field LIKE '$keyword')";
		else
			$sql.=" AND ($field LIKE '%$keyword%')";
	}
	
	if($suject){
		$field = 'subject';
		$sql.=" AND ($field LIKE '%$subject%')";
	}
	
	if($director){
		$field = 'director';
		$sql.=" AND ($field LIKE '%$director%')";
	}
	
	if($tag){
		$field = 'tag';
		$sql.=" AND ($field LIKE '%$tag%')";
	}

	if(!$orderway){
		$orderway = 'lostdate';
	}
	if(!$asc){
		$asc = 'DESC';
	}
	$orderby  = "ORDER BY $orderway $asc";

	$rt = $db->get_one("SELECT COUNT(*) AS sum FROM pv_video WHERE $sql");
	(!is_numeric($page) || $page < 1) && $page = 1;
	!is_numeric($lines) && $lines = $db_perpage;
	$limit = "LIMIT ".($page-1)*$lines.",$lines";
	$pages = numofpage($rt['sum'],$page,ceil($rt['sum']/$lines),"search.php?action=search&cid=$cid&nid=$nid&field=$field&orderway=$orderway&asc=$asc&keyword=".urlencode($keyword)."&lines=$lines&");	

	$query=$db->query("SELECT * FROM pv_video LEFT JOIN pv_videodata ON pv_video.vid = pv_videodata.vid WHERE $sql $yzsql $orderby $limit");
	while($search=$db->fetch_array($query)){
		$search['lostdate'] = get_date($search['postdate']);
		$search['yz'] = $search['yz']=='1' ? "<span style=\"color: green;\">Í¨¹ý</span>" : "<span style=\"color: red;\">Î´ÉóºË</span>";
		$searchdb[]=$search;
	}
	require_once PrintEot('search');footer();
}
?>