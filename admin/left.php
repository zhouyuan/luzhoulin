<?php
!function_exists('adminmsg') && exit('Forbidden');
require GetLang('left');

$leftdb=$lang;
unset($lang);
$leftinfo='';
$i=3;

$imgtype=$styletype=array();
list($imgtype[a0],$styletype[a0])=GetDeploy('a0');
list($imgtype[a1],$styletype[a1])=GetDeploy('a1');

foreach($leftdb as $key=>$left){
	$id='a'.$i;
	list($imgname,$style)=GetDeploy($id);
	
	$left && $output1="<table width=\"173\" align=center cellspacing=1 cellpadding=3 class=tableborder>
		<tr><td class=header><a style=\"float:right\" href=\"#\" onclick=\"return IndexDeploy('$id',1)\"><img id=\"img_$id\" src=\"$imgpath/admin/cate_$imgname.gif\"></a>
		<b>$key</b></td></tr>
		<tbody id=\"cate_$id\" style=\"$style\" class=bg>
		";
	$output2='';
	foreach($left as $key=>$value){
			if(is_array($value)){
				foreach($value as $k=>$v){
					$output2 .= "<tr><td>".$v."</td>";
				}
			}else{
				$output2 .= "<tr><td>".$value."</td>";
			}
 	}
	if($output2){
		$output1 .= $output2."</tr></td></tr></tbody></table>";
	}else{
		unset($output1);
	}
	$leftinfo .= $output1;
	$i++;
}

function GetDeploy($name){
	global $_COOKIE;
	if(strpos($_COOKIE['deploy'],"\t".$name."\t")===false){
		$type='fold';
	}else{
		$type='open';
		$style='display:none;';
	}
	return array($type,$style);
}

include PrintEot('adminleft');exit;
?>