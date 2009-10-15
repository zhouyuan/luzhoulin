<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=announce";

if (!$action){
	$annoucedb = array();
	$query     = $db->query("SELECT * FROM pv_announce ORDER BY vieworder,startdate DESC");
	while($rt  = $db->fetch_array($query)){
		strlen($rt['subject'])>30 && $rt['subject']=substrs($rt['subject'],30);
		$rt['startdate'] = get_date($rt['startdate']);
		$annoucedb[] = $rt;
	}
	include PrintEot('announce');exit();
} elseif($action=='add'){
	if (!$step){
    	include PrintEot('announce');exit();
	} else if($step=='2'){
		!is_numeric($vieworder) && $vieworder=0;
		if (!$newsubject || !$atc_content){
			adminmsg('operate_fail');
		}
		$newsubject  = ieconvert($newsubject);
		$atc_content = ieconvert($atc_content);
		$atc_content = trim($atc_content);
 		$db->update("INSERT INTO pv_announce(vieworder,author,startdate,subject,content) VALUES('$vieworder','$admin_name','$timestamp','$newsubject','$atc_content')");
		updatecache_notice();
		adminmsg('operate_success');
	}
} elseif ($action=='edit'){
	if (!$step){
		@extract($db->get_one("SELECT * FROM pv_announce WHERE aid='$aid'"));
		HtmlConvert($subject);
		HtmlConvert($content);
		$atc_content = $content;
	include PrintEot('announce');exit();
	} else if($step=='2'){
		!is_numeric($vieworder) && $vieworder=0;
		$newsubject  = ieconvert($newsubject);
		$atc_content = ieconvert($atc_content);
		$atc_content = trim($atc_content);
		$db->update("UPDATE pv_announce SET vieworder='$vieworder',subject='$newsubject',content='$atc_content' where aid='$aid'");
		updatecache_notice();
		adminmsg('operate_success');
	}
} elseif ($action=='del'){
	if(!$selid = checkselid($selid)){
		adminmsg('operate_error');	
	}
	$db->update("DELETE FROM pv_announce where aid IN($selid)");
	updatecache_notice();
	adminmsg('operate_success');
}
?>