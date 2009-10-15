<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename = "$admin_file?adminjob=class";

if($action=='add_board') { 
	$db->update("INSERT INTO pv_class(caption) VALUES('$name')");
	updatecache_class();
	adminmsg('operate_success');
}elseif ($action=='add_sub') {  
	$lv=0;
	$fathers='';
	if($cup!=0)
	{
		$up = $db->get_one("SELECT * FROM pv_class WHERE cid='$cup'");
		$lv = $up['lv']+1;
		$fathers = empty($up['fathers'])?$up['cid']:$up['fathers'].','.$up['cid'];
	}
	$db->update("INSERT INTO pv_class(cup,lv,fathers,caption) VALUES('$cup','$lv','$fathers','$caption')");
	updatecache_class();
	adminmsg('operate_success');
} elseif ($action=='edit_board') {
	if($step==2){
		$basename = "$admin_file?adminjob=class&action=edit_board&cid=$cid";
		!is_numeric($vieworder) && $vieworder=0;
		$db->update("UPDATE pv_class SET vieworder='$vieworder',caption='$caption' WHERE cid='$cid'");
		updatecache_class();
		adminmsg('operate_success');
	}
} elseif ($action=='edit_sub') {
	if($step!=2) {
		$class_opt = str_replace("<option value=\"{$class[$cid][cup]}\">","<option value=\"{$class[$cid][cup]}\" selected>",$class_opt);
		${ 'atccheck_'.(int)$class[$cid][atccheck] } = 'selected';
		${ 'classtype_'.(string)$class[$cid][type] } = 'selected';
		${ 'orderway_'.(string)$class[$cid][orderway] } = 'selected';
		${ 'orderasc_'.(int)$class[$cid][orderasc] } = 'selected';

		$usergroup  = "<table cellspacing='0' cellpadding='0' border='0' width='100%' align='center'><tr>";
		foreach ($ltitle as $key=>$value) {
			if ($key==1||$key==2) continue;
			$htm_tr='';$num++;$num%5==0?$htm_tr='</tr><tr>':'';
			$usergroup.="<td><input type='checkbox' name='permit[]' value='$key' _{$key}_> $value</td>$htm_tr";
		}
		$usergroup  .= "</tr></table>";

		$viewvisit	 = str_replace('permit','allowvisit',$usergroup);
		$viewplay    = str_replace('permit','allowplay', $usergroup);
		$viewpost    = str_replace('permit','allowpost',$usergroup);
		$viewrp      = str_replace('permit','allowrp',$usergroup);

		$visitper =explode(",", $class[$cid]['allowvisit'] );
		$player   =explode(",", $class[$cid]['allowplay'] );
		$postper  =explode(",", $class[$cid]['allowpost'] );
		$rpper	  =explode(",", $class[$cid]['allowrp'] );

		foreach($visitper as $value)
			$viewvisit =str_replace("_{$value}_",'checked',$viewvisit);			
		foreach($player as $value)
			$viewplay = str_replace("_{$value}_",'checked',$viewplay);		
		foreach($postper as $value)
			$viewpost  =str_replace("_{$value}_",'checked',$viewpost);
		foreach($rpper as $value)
			$viewrp  =str_replace("_{$value}_",'checked',$viewrp);
	}
	else {
		$basename = "$admin_file?adminjob=class&action=edit_sub&cid=$cid";
		$cup==$cid && adminmsg('board_fupsame');
		$up = $db->get_one("SELECT * FROM pv_class WHERE cid='$cup'");
		if(strpos($up['fathers'],$cid)!==false) adminmsg('board_fupsub');

		$lv=0;
		$fathers='';
		if($cup!=0)
		{
			$lv = $up['lv']+1;
			$fathers = empty($up['fathers'])?$up['cid']:$up['fathers'].','.$up['cid'];
		}

		!is_numeric($rvrcneed) && $rvrcneed=0;
		!is_numeric($moneyneed) && $moneyneed=0;
		!is_numeric($postneed) && $postneed=0;

		$allowvisit	  && $allowvisit   =','.implode(",",$allowvisit).',';
		$allowplay    && $allowplay    =','.implode(",",$allowplay).',';
		$allowpost	  && $allowpost	   =','.implode(",",$allowpost).',';
		$allowrp	  && $allowrp	   =','.implode(",",$allowrp).',';

		$db->update("UPDATE pv_class SET cup='$cup',lv='$lv',fathers='$fathers',vieworder='$vieworder',caption='$caption',type='$type',orderway='$orderway',orderasc='$orderasc',atccheck='$atccheck',rvrcneed='$rvrcneed',moneyneed='$moneyneed',postneed='$postneed',password='$password',allowvisit='$allowvisit',allowplay='$allowplay',allowpost='$allowpost',allowrp='$allowrp' WHERE cid='$cid'");

		$sub = $db->query("SELECT * FROM pv_class WHERE fathers LIKE '%$cid%'");
		while($row=$db->fetch_array($sub))
		{
			$f = substr($row['fathers'],strpos($row['fathers'],$cid)+strlen($cid));
			$f = empty($fathers)? $cid.$f : $fathers.','.$cid.$f;
			$l = substr_count($f,',')+1;
			$db->update("UPDATE pv_class SET lv='$l',fathers='$f' WHERE cid='$row[cid]'");
		}

		updatecache_class();
		adminmsg('operate_success');
	}
} elseif ($action=='update') {
	foreach ($selid as $key => $value) {
		$value != $class[$key]['vieworder'] && is_numeric($value) && $db->update("UPDATE pv_class SET vieworder='$value' WHERE cid='$key'");
	}
	updatecache_class();
	adminmsg('operate_success');
} elseif ($action=='delete' && $cid > 0) {
	$result = $db->query("SELECT * FROM pv_class WHERE cup='$cid'");
	$num = $db->num_rows($result);
	if($num>0) adminmsg('board_havesub');

	$result = $db->query("SELECT * FROM pv_video WHERE cid='$cid'");
	$vnum = $db->num_rows($result);
	if($vnum>0) adminmsg('board_havevod');

	$db->update("DELETE FROM pv_class WHERE cid='$cid'");
	updatecache_class();
	adminmsg('operate_success');
} else { 
	$listdb = array();
	foreach ($class as $value)
	{
		$pre='';
		for($i=0;$i<$value['lv'];$i++) $pre.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		//$pre.= '©¦©¤ ';
		$value['caption']=$pre.$value['caption'];
		$listdb[]=$value;
	}
}
include PrintEot('class');exit;
?>