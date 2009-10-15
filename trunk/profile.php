<?php
require_once('global.php');
require_once(R_P.'data/cache/dbreg.php');
require_once(R_P.'data/cache/level.php');
require_once(R_P.'data/cache/medaldb.php');
require_once(R_P.'require/header.php');

if ($action=="show"){
	/* 用户组权限 */
	if($id!=$uid && $gp_allowprofile=='0') Showmsg('profile_error');
	
	if($id=='0') Showmsg('guest_info');

	$userdb=array();
	$userdb =$db->get_one("SELECT m.*,md.* FROM pv_members m LEFT JOIN pv_memberdata md ON m.uid=md.uid WHERE m.uid='$id'");
	if(!$userdb) {
		$errorname='';
		Showmsg('user_not_exists');
	}
	$logininfo=explode('|',$userdb['onlineip']);
	$userdb['ip']=$logininfo[0];
	$userdb['lastlogin']=get_date($logininfo[1],"Y-m-d");
	$userdb['regdate']=get_date($userdb['regdate'],"Y-m-d");
	$userdb['gender']=!$userdb['gender']?'保密':($userdb['gender']=='1'?'帅哥':'靓女');
	$userdb['email']=$userdb['publicmail']=='1' ? "<a href=\"mailto:$userdb[email]\">$userdb[email]</a>" : '邮箱未公开';
	$userdb['grouptitle']=$ltitle[$userdb['groupid']];
	$userdb['membertitle']=$ltitle[$userdb['memberid']];

	!ereg("^http",$userdb['icon']) && $userdb['icon'] = "$imgpath/face/$userdb[icon]";

	$usercredit=array(
		"postnum"	=>	"$userdb[postnum]",
		"rvrc"		=>	"$userdb[rvrc]",
		"money"		=>	"$userdb[money]",
	);
	$creditdb = GetCredit($id);
	foreach($creditdb as $key=>$value){
		$usercredit[$key] = $value[1];
	}	

	$upgradeset = unserialize($db_upgrade);
	$userdb['credit'] = CalculateCredit($usercredit,$upgradeset);


	$row = $db->get_one("SELECT medals FROM pv_members WHERE uid='$id'");
	if($row['medals']){
		$userdb['medals'] = explode(',',$row['medals']);
	}else{
		$userdb['medals'] = '';
	}	

	require_once PrintEot('profile'); footer();

}elseif ($action=="modify"){
	if (!$step){
		$groupid=='guest' && Showmsg('not_login');
		include_once(R_P."data/cache/dbreg.php");
		if($user['publicmail']) $ifchecked="checked";
		$user['receivemail']=='1'?$email_open='checked':$email_close='checked';
		$sexselect[$user['gender']]="selected";
		$getbirthday = explode("-",$user['bday']);
		$yearslect[(int)$getbirthday[0]]="selected";
		$monthslect[(int)$getbirthday[1]]="selected";
		$dayslect[(int)$getbirthday[2]]="selected";

		$delicon = ereg("^user/",$user['icon']) ? '1' : '0';
		
		if(ereg("^http",$user['icon']))
		{
			$iconurl = $user['icon'];
		}
		else
		{
			$iconurl = '';
			$user['icon'] = "$imgpath/face/$user[icon]";
		}
		
		//$iconurl = ereg("^http",$user['icon']) ? $user['icon'] : '';
		//!ereg("^http",$user['icon']) && $user['icon'] = "$imgpath/face/$user[icon]";
		
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
		foreach($filedb as $value)
		{
			$value==$user['icon'] ? $c='selected' : $c='';
			$imgselect.="<option value='$value' $c>$value</option>";
		}

		require_once PrintEot('profile');footer();
	}else{
		if($propwd || $check_pwd){
			if(strlen($propwd) < 6) showmsg('not_password');
			$S_key=array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n",'#');
			foreach($S_key as $value){
				if (strpos($propwd,$value)!==false)	Showmsg('illegal_password'); 
			}
			if($propwd!=$check_pwd) Showmsg('password_confirm');
			if($oldpwd){
				$ckpwd=$db->get_one("SELECT password FROM pv_members WHERE uid='$uid'");
				if(md5($oldpwd) != $ckpwd['password']) Showmsg('pwd_error');
			}else Showmsg('not_oldpwd');
			$propwd=md5($propwd);
			$pwdadd = "password='$propwd',";
		}else{
			$pwdadd = "";		
		}
	
		if (!$proemail || !ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$proemail)) {
			Showmsg('illegal_email'); 
		}

		$bday = (!$proyear||!$promonth||!$proday) ? '0000-00-00' : $proyear."-".$promonth."-".$proday;

		if(strlen($prohonor) > $rg_regmaxhonor){
			Showmsg('honor_limit');
		}

		if(strlen($prosign) > $rg_regmaxsign){
		    Showmsg('sign_limit');
		}

		if(strpos($proicon,'..')!==false){
			Showmsg('undefined_action');
		}

		if(ereg("^user/",$user['icon'])) $proicon = $user['icon'];

		if($iconurl)
		{
			if(!ereg("^http",$iconurl))
				Showmsg('illegal_customimg');
			else
			{
				if(ereg("^user/",$user['icon']) && file_exists($imgdir.'/face/'.$user['icon'])) Showmsg('pro_custom_fail');
				$proicon = $iconurl;
			}
		}

		/* 上传头像 */		
		$error = $_FILES['upicon']['error'];
		$img_name = $_FILES['upicon']['name'];
		$img_tmp = $_FILES['upicon']['tmp_name'];
		$img_size = $_FILES['upicon']['size'];
		$image_path = $imgpath."/face/user/";
		
		if($error=='0' && $img_size>0 && $db_iconupload == '1' && $gp_allowupicon == '1')
		{
			$iconsize = $db_iconsize * 1024;
			if($img_size>$iconsize) Showmsg('pro_loadimg_limit');
			if(ereg("^user/",$user['icon']) && file_exists($imgdir.'/face/'.$user['icon'])) Showmsg('pro_loadimg_fail');
			
			$img_ext = strtolower(substr(strrchr($img_name,'.'),1));
			if($img_ext && in_array($img_ext,array('jpg','jpeg','png','bmp','gif')))
			{
				$filename = $uid.'.'.$img_ext;
				if(copy($img_tmp,$image_path.$filename))
				{
					$proicon = "user/$filename";
				}
			}
			else Showmsg('pro_loadimg_ext');
		}


		$db->update("UPDATE pv_members SET $pwdadd email='$proemail', publicmail='$propublicemail', receivemail='$proreceivemail', honor='$prohonor', icon='$proicon', gender='$progender', oicq='$prooicq', msn='$promsn', site='$prosite', bday='$bday', signature='$prosign' WHERE uid='$uid'");

		refreshto("./profile.php?action=show&id=$uid",'operate_success');
	}
}elseif($action=="myvideo"){
	$groupid=='guest' && Showmsg('not_login');
	$rt = $db->get_one("SELECT COUNT(*) AS sum FROM pv_video WHERE authorid='$uid'");
	(!is_numeric($page) || $page < 1) && $page = 1;
	$limit = "LIMIT ".($page-1)*$db_perpage.",$db_perpage";
	$pages = numofpage($rt['sum'],$page,ceil($rt['sum']/$db_perpage),"profile.php?action=myvideo&");	

	$query=$db->query("SELECT * FROM pv_video LEFT JOIN pv_videodata ON pv_video.vid = pv_videodata.vid WHERE authorid='$uid' ORDER BY postdate DESC $limit");
	while($search=$db->fetch_array($query)){
		$search['lostdate'] = get_date($search['postdate']);
		$search['yz'] = $search['yz']=='1' ? "<span style=\"color: green;\">通过</span>" : "<span style=\"color: red;\">未审核</span>";
		$gp_allowdelatc=='1' && $search['del']="<a href=\"post.php?action=del&vid=$search[vid]\">删除</a>";
		$searchdb[]=$search;
	}
	require_once PrintEot('profile');footer();
}
elseif($action=="delicon"){

	if(ereg("^user/",$user['icon']) && file_exists("$imgdir/face/$user[icon]")) P_unlink("$imgdir/face/$user[icon]");
	$db->query("UPDATE pv_members SET icon='none.gif' WHERE uid='$uid'");
	refreshto('profile.php?action=modify','operate_success');	
}

?>