<?php
define('SCR','index');
require_once('global.php');
require_once(R_P.'data/cache/class.php');
require_once(R_P.'data/cache/notice.php');
require_once(R_P.'data/cache/sharelink.php');

/********** MENU BEGIN **********/
$mm='<li><a id="mm0" href="'.$db_wwwurl.'" onmouseover="showM(this,0);" class="menuhover">首页</a></li>';
$mb='<ul id="mb0"><li><a href="#" onClick="this.style.behavior=\'url(#default#homepage)\'; this.setHomePage(document.location.href);">设为首页</a></li><li><a href="javascript:window.external.addFavorite(document.location.href,document.title)">加入收藏</a> </li></ul>';
$n=0;
if(is_array($class)) {
	foreach($class as $value){
         if($value['cup']=='0'){
			$n++;
			$mm.="<li><a id=\"mm{$n}\" href=\"#\" onmouseover=\"showM(this,{$n});\">$value[caption]</a></li>";
			$fid=$value['cid'];

			$mb.="<ul id=\"mb{$n}\" class=\"hide\">";
			foreach($class as $svalue) {				
				if($svalue['cup']==$fid) $mb.="<li><a href=\"class.php?cid=$svalue[cid]\">$svalue[caption]</a></li>";
			}
			$mb.='</ul>';
		 }		 
	}
	$mm='<ul>'.$mm.'</ul>';
}

/********** MENU END **********/

// ShareLink
if($db_indexmqlink){
	$sharelink="<marquee scrolldelay=\"100\" scrollamount=\"4\" onmouseout=\"this.start()\" onmouseover=\"this.stop()\" behavior=\"alternate\">$sharelink</marquee>";
}

@extract($db->get_one("SELECT * FROM pv_siteinfo WHERE id=1"));
require_once(R_P.'require/header.php');
require_once PrintEot('index');footer();
?>