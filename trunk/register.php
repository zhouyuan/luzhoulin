<?php
require_once('global.php');
include_once(R_P."data/cache/dbreg.php");
include_once(R_P."data/cache/level.php");
include_once(R_P.'data/cache/class.php');
!$rg_allowregister && Showmsg('reg_close');
$groupid!='guest' && Showmsg('reg_repeat');
list($reggd)=explode("\t",$db_gdcheck);
if(!$step){
	require_once(R_P.'require/header.php');
	$rg_regdetail && $adv="checked";
	$img=@opendir("$imgdir/face");
	while ($imagearray=@readdir($img)){
		$extend = pathinfo($imagearray);
		$extend = strtolower($extend["extension"]);		
		if ($imagearray!="." && $imagearray!=".." && $imagearray!="" && $imagearray!="none.gif" && in_array($extend,array('jpg','jpeg','gif','png','bmp'))){
			$filedb[]=$imagearray;
		}
	}
	@closedir($img);
	natcasesort($filedb);
	foreach($filedb as $value) $imgselect.="<option value='$value'>$value</option>";
	require_once PrintEot('register');footer();
} else {
	$reggd && GdConfirm($gdcode);

	if (strlen($regname)>$rg_regmaxname || strlen($regname)<$rg_regminname){
		Showmsg('reg_username_limit');
	}
	if(!$regpwd || strlen($regpwd) < 6){
	    showmsg('not_password');
	}
	if ($regpwd != $regpwdrepeat){
		Showmsg('password_confirm'); 
	}
	if (!$regemail || !ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$regemail)) {
		Showmsg('illegal_email'); 
	}
	$S_key=array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n",'#');
	foreach($S_key as $value){
		if (strpos($regname,$value)!==false){ 
			Showmsg('illegal_username'); 
		}
		if (strpos($regpwd,$value)!==false){ 
			Showmsg('illegal_password'); 
		}
	}
	$regsex = $regsex ? $regsex : '0';
	$receivemail = !$regifemail ? '1' : $regifemail;
	$groupid = $rg_ifcheck == '1' ? '4' : '-1';
	
	$rg_birth = (!$regbirthyear||!$regbirthmonth||!$regbirthday) ? '0000-00-00' : $regbirthyear."-".$regbirthmonth."-".$regbirthday;

	if(strpos($regicon,'..')!==false){
		Showmsg('undefined_action');
	}

	if(strlen($regsign) > $rg_regmaxsign){
	    Showmsg('sign_limit');
	}

	$regname = Char_cv($regname);
	$regpwd  = md5(Char_cv($regpwd));
	$regicon = Char_cv($regicon);
	$region = Char_cv($region);
	$school = Char_cv($school);
	$site = Char_cv($site);
	$regsign = Char_cv($regsign);

	$regname=='guest' && Showmsg('illegal_username');
	$rg_banname=explode(',',$rg_banname);
	foreach($rg_banname as $value){
		if(strpos($regname,$value)!==false){
			Showmsg('illegal_username');
		}
	}
	$rs = $db->get_one("SELECT COUNT(*) AS count FROM pv_members WHERE username='$regname'");
	if($rs['count']>0) {
		Showmsg('username_same');
	}
	$self = $class[$cid]['caption'];
	$father = $class[$class[$cid]['fathers']]['caption'];
	
	asort($lneed);
	$memberid=key($lneed);
	
	$db->update("INSERT INTO pv_members (username, password, email, publicmail, groupid, memberid, icon, gender, regdate, signature,  region, school, site, bday, receivemail, yz, newpm, medals) VALUES ('$regname','$regpwd','$regemail','$regemailtoall','$groupid','$memberid','$regicon','$regsex','$timestamp','$regsign','$father','$self','$site','$rg_birth','$receivemail','1','0','')");
	$phpvod_uid=$db->insert_id();
	$db->update("INSERT INTO pv_memberdata (uid,postnum,rvrc,money,onlineip) VALUES ('$phpvod_uid','0','$rg_regrvrc','$rg_regmoney','$onlineip')");
	$db->update("UPDATE pv_siteinfo SET newmember='$regname',totalmember=totalmember+1 WHERE id='1'");

	$password=$regpwd;
	Cookie("user",$phpvod_uid."\t".$password);
	refreshto("./$db_bfn",'reg_success');
}
?>