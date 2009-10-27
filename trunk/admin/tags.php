<?php
!function_exists('adminmsg') && exit('Forbidden');
include_once(R_P.'data/cache/nation.php');
include_once(R_P.'data/cache/grade.php');

$basename="$admin_file?adminjob=tags";
$role = $admin['grouptitle'];
if (!$action){
	$nationdb=array();
	$query=$db->query("SELECT * FROM pv_tags ORDER BY id");
	while($nation=$db->fetch_array($query)){
		$gid = $nation['gradeID'];
		$nid = $nation['nationID'];
		$nation['selectN'] = str_replace("<option value=\"$nid\">","<option value= \"$nid\" selected>",$nation_opt);
		$nation['selectG'] = str_replace("<option value=\"$gid\">","<option value= \"$gid\" selected>",$grade_optID);
		$nationdb[]=$nation;
	}
	include PrintEot('tags');exit;
} elseif ($action=="add"){
	if(trim($subject)==''){
		adminmsg('operate_fail');
	}
	$subject = Char_cv($subject);
	$db->update("INSERT INTO pv_tags SET subject='$subject',gradeID='$grade',nationID='$nation';");	
	updatecache_tag();
	adminmsg('operate_success');
} elseif($action=="edit"){
//echo "UPDATE pv_tags SET gradeID='$grade[1]',nationID = '$nation[1]',subject='$subject[1]' WHERE id='1'";exit;
	foreach($nation as $key=>$value){		
		
		$db->update("UPDATE pv_tags SET gradeID='$grade[$key]',nationID = '$nation[$key]',subject='$subject[$key]' WHERE id='$key'");
	}
	updatecache_tag();
	adminmsg('operate_success');
} elseif($action=="del"){
	$db->update("DELETE FROM pv_tags WHERE ID='$id'");
	updatecache_tag();
	adminmsg('operate_success');
}
?>