<?php
!function_exists('adminmsg') && exit('Forbidden');

$tabledb=array(
	'pv_advert',
	'pv_announce',
	'pv_attachs',
	'pv_cknum',
	'pv_class',
	'pv_config',
	'pv_hack',
	'pv_hackvar',
	'pv_help',
	'pv_medalinfo',
	'pv_medalslogs',
	'pv_memberdata',
	'pv_members',
	'pv_msg',
	'pv_nations',
	'pv_player',
	'pv_replier',
	'pv_report',
	'pv_sharelinks',
	'pv_siteinfo',
	'pv_styles',
	'pv_urls',
	'pv_usergroups',
	'pv_video',
	'pv_videodata',
);

if($pv!='pv_'){
	foreach($tabledb as $key=>$value){
		$tabledb[$key] = str_replace('pv_',$pv,$value);
	}
}

?>