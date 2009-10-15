<?php
!function_exists('readover') && exit('Forbidden');
RunTime_Begin();
$logo = $imgpath."/logo.gif";

$hackdb = array();
foreach($hack as $value)
{
	if(file_exists(R_P."hack/{$value[directory]}/index.php") && $value['hidden']=='1') $hackdb[]=$value;
}

require PrintEot('header');
?>