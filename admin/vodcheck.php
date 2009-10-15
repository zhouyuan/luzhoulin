<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=vodcheck";

if (!$action){
	(!is_numeric($page) || $page < 1) && $page = 1;
	$limit = "LIMIT ".($page-1)*$db_adminperpage.",$db_adminperpage";
	$rt    = $db->get_one("SELECT COUNT(*) AS sum FROM pv_video WHERE yz='0' ORDER BY vid ASC");
	$pages = numofpage($rt['sum'],$page,ceil($rt['sum']/$db_adminperpage),"$basename&");
	$voddb=array();
	$query=$db->query("SELECT * FROM pv_video WHERE yz='0' ORDER BY vid ASC $limit");
	while($yzvod=$db->fetch_array($query)){
		$yzvod['postdate']=get_date($yzvod['postdate']);
		$yzvod['classname']=$class[$yzvod['cid']]['caption'];
		$voddb[]=$yzvod;
	}
	include PrintEot('vodcheck');exit;
}
elseif($action=='check'){
	!$yzvod && adminmsg('operate_error');

	foreach($yzvod as $vid)
	{
		if($type=='pass')
		{
			$db->update("UPDATE pv_video SET yz='1' WHERE vid='$vid'");
			@extract($db->get_one("SELECT authorid FROM pv_video WHERE vid='$vid'"));
			if($authorid!='0')
			{
				$credit = unserialize($db_creditset);
				$addmoney = $credit['money']['Post'];
				$addrvrc = $credit['rvrc']['Post'];
				$db->update("UPDATE pv_memberdata SET postnum=postnum+1,rvrc=rvrc+$addrvrc,money=money+$addmoney WHERE uid='$authorid'");

				customcredit($authorid,$credit,'Post');
				update_memberid($authorid);
			}
		}
		else
		{
			@extract($db->get_one("SELECT pic FROM pv_video WHERE vid='$vid'"));
			if(file_exists("$imgdir/pic/$pic")) 
			{
				P_unlink("$imgdir/pic/$pic");
			}

			$db->update("DELETE FROM pv_video WHERE vid='$vid'");
			$db->update("DELETE FROM pv_videodata WHERE vid='$vid'");
			$db->update("DELETE FROM pv_urls WHERE vid='$vid'");

		}
	}

	adminmsg('operate_success');

}

?>