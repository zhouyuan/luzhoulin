<?php
require_once('global.php');
require_once(R_P.'require/header.php');
$query=$db->query("SELECT * FROM pv_help ORDER BY id");
while($rt=$db->fetch_array($query)){
	$helpdb[]=$rt;
}
require_once PrintEot('faq');footer();
?>