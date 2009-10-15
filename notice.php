<?php
require_once('global.php');
require_once(R_P.'require/header.php');

$query=$db->query("SELECT * FROM pv_announce ORDER BY vieworder,startdate DESC");
while($notice=$db->fetch_array($query)){
	$notice['startdate'] = get_date($notice['startdate']);
	$noticedb[]=$notice;
}
unset($notice);
include PrintEot('notice');footer();

?>