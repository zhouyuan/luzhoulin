<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=delmsg";

if(!$action){
	include PrintEot('delmsg');exit;
} elseif($action == 'del'){

	if(!$step){

		if($type!='all'){
			$sql="m.type='$type'";
		} else{
			$sql='1 ';
		}

		if($keepnew){
			$sql.=" AND m.ifnew='0'";
		}

		if($msgdate){
			$sql.=" ";
		}

		if($keyword){
			$keyword=trim($keyword);
			$keywordarray=explode(",",$keyword);
			foreach($keywordarray as $value){
				$value=str_replace('*','%',$value);
				$keywhere.='OR';
				$keywhere.=" m.content LIKE '%$value%' OR m.title LIKE '%$value%' ";
			}
			$keywhere=substr_replace($keywhere,"",0,3);
			$sql.=" AND ($keywhere) ";
		}

		if($fromuser){
			$fromuser = str_replace('*','_',$fromuser);
			$rt = $db->get_one("SELECT uid,username FROM pv_members WHERE username LIKE '$fromuser'");
			if(!$rt){
				$errorname = $fromuser;
				adminmsg('user_not_exists');
			}
			if($type == 'rebox' || $type=='sebox'){
				$sql .= " AND m.type='$type' AND m.fromuid='$rt[uid]'";
			} else{
				$sql .= " AND m.fromuid='$rt[uid]'";
			}
		}

		if($touser){
			$touser = str_replace('*','_',$touser);
			$rt = $db->get_one("SELECT uid,username FROM pv_members WHERE username LIKE '$touser'");
			if(!$rt){
				$errorname = $touser;
				adminmsg('user_not_exists');
			}
			if($type == 'rebox' || $type=='sebox'){
				$sql .= " AND m.type='$type' AND m.touid='$rt[uid]'";
			} else{
				$sql .= " AND m.touid='$rt[uid]'";
			}
		}

		if($msgdate){
			$schtime=$timestamp-$msgdate*24*3600;
			$sql.=" AND m.mdate<'$schtime'";
		}

		$rs=$db->get_one("SELECT COUNT(*) AS count FROM pv_msg m WHERE $sql");
		$count=$rs['count'];
		if(!is_numeric($lines))$lines=100;
		(!is_numeric($page) || $page < 1) && $page=1;
		$numofpage=ceil($count/$lines);
		if($numofpage&&$page>$numofpage){
			$page=$numofpage;
		}
		$pages=numofpage($count,$page,$numofpage,"$admin_file?adminjob=delmsg&action=$action&type=$type&keepnew=$keepnew&msgdate=$msgdate&fromuser=".rawurlencode($fromuser)."&touser=".rawurlencode($touser)."&lines=$lines&");
		$start=($page-1)*$lines;
		$limit="LIMIT $start,$lines";

		$query=$db->query("SELECT m.*,m1.username as fromuser,m2.username as touser FROM pv_msg m LEFT JOIN pv_members m1 ON m1.uid=m.fromuid LEFT JOIN pv_members m2 ON m2.uid=m.touid WHERE $sql ORDER BY mid DESC $limit");
		while($message=$db->fetch_array($query)){
			if($direct){
				$delid[]=$message['mid'];
			} else{
				!$message['fromuser'] && $message['fromuser'] = $message['username'];
				$message['date']=get_date($message['mdate']);
				$messagedb[]=$message;
			}
		}
		if(!$direct){
			include PrintEot('delmsg');exit;
		}
	}

	if($step==2 || $direct){
		!$delid && adminmsg('operate_error');
		foreach($delid as $value){
			is_numeric($value) && $delids.=$value.',';
		}
		$delids=substr($delids,0,-1);
		$db->update("DELETE FROM pv_msg WHERE mid IN ($delids)");
		adminmsg('operate_success');
	}

}
?>