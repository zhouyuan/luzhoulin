<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=record";

$recordfile=D_P."data/cache/admin_record.php";
if(file_exists($recordfile)){
	$logfiledata=readlog($recordfile);
} else{
	$logfiledata=array();
}
$logfiledata=array_reverse($logfiledata);
$count=count($logfiledata);

if($action=='del'){
		if($count>100){
			$output=array_slice($logfiledata,0,100);
			$output=array_reverse($output);
			$output=implode("",$output);
			writeover($recordfile,$output);
			adminmsg('log_del');
		}else{
			adminmsg('log_min');
		}
}
(!is_numeric($page) || $page < 1) && $page = 1;
$pages = numofpage($count,$page,ceil($count/$db_adminperpage),"$basename&");	
$num=0;
$start=($page-1)*$db_adminperpage;
foreach($logfiledata as $value){
  if($num >= $start && $num < $start+$db_adminperpage){
	$detail=explode("|",$value);
	$logdate=get_date($detail[5]);
	$detail[2] && $detail[2]=substr_replace($detail[2],'***',1,-1);
	$detail[6]=htmlspecialchars($detail[6]);
	$adlogfor.="
	<tr class=bg align='center' onMouseOver=\"this.className='tableborder';\" onMouseOut=\"this.className='bg';\">
	<td>$detail[1]</td>
	<td>$detail[2]</td>
	<td>$detail[3]</td>
	<td>$detail[4]</td>
	<td>$logdate</td>
	<td>$detail[6]</td>
	</tr>";
  }
  $num++;
}

include PrintEot('record');exit;
?>