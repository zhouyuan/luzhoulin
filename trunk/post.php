<?php
require_once('global.php');
require_once(R_P.'require/header.php');
include_once(R_P.'data/cache/class.php');
include_once(R_P.'data/cache/nation.php');
include_once(R_P.'data/cache/player.php');
include_once(R_P.'data/cache/dbset.php');
include_once(R_P.'data/cache/creditdb.php');
//print($_POST['upfile']['savepath']	);
$urlreal = $_POST['realpos'];

$pid['0']=10;
//print $nid;

list(,,,$postgd)=explode("\t",$db_gdcheck);
!$postaction && $postaction="new";

$img = $postaction=='new' ? $imgpath."/pic/nopic.gif" : $pic;

if($groupid=='guest')
{
	$uid = '0';
	$username = '游客';
}

if ($postaction=="new"){
	!$step && $step="1";
	if($step=='1'){
		/* 用户组权限 */
		if($gp_allowpost!='1') Showmsg('group_post');

		$db_picmaxsize=ceil($db_picmaxsize/1024);

		$urls[$server]['player']=$player;
		$urls[$server]['urlmsg']='';

		$credit_opt = "<option value=\"money\">金钱</option><option value=\"rvrc\">威望</option>";
		foreach($_CREDITDB as $key => $value)
		{
			$credit_opt.="<option value=\"$key\">$value[0]</option>";
		}

		$sale_opt = $need_opt = $credit_opt;

		require_once PrintEot('post');footer();
	}elseif($step=='2'){

		/* 栏目权限 */
		if($class[$cid]['type']!='free' && $groupid=='guest') Showmsg('post_guest');

		if($class[$cid]['allowpost']!='')
		{
			if($groupid=='guest' || strpos($class[$cid]['allowpost'],",$groupid,")===false) Showmsg('post_noper');
		}

		$postgd && GdConfirm($gdcode);
		$row = $db->get_one("SELECT cup FROM pv_class WHERE cid='$cid' LIMIT 1");
		if($row['cup']=='0'){
			Showmsg('post_type');
		}
		
		
		
		$subject = Char_cv($subject);
		$playactor = Char_cv($playactor);
		$director = Char_cv($director);
		$atc_content = Char_cv($atc_content);
		$urls = Char_cv($urls);
		$tag=implode("\t",$tag);
		
		if(empty($subject) || empty($cid) || empty($nid) || empty($pid) /*|| empty($urls)*/){
			Showmsg('form_error');			
		}

		if (($class[$cid]['atccheck'] == '1' || $class[$cid]['atccheck'] == '3') && $gp_atccheck == '1')
		$yz='0'; else $yz='1';


		if(is_numeric($sale_value) && (int)$sale_value > 0)
			$sale="{$sale_value}|{$sale_type}";
		else
			$sale='';


		if(is_numeric($need_value) && (int)$need_value > 0)
			$need="{$need_value}|{$need_type}";
		else
			$need='';
		
		$db->update("INSERT INTO pv_video(cid,nid,author,authorid,postdate,lostdate,subject,playactor,director,tag,content,yz,grade) 
		VALUES('$cid','$nid','$username','$uid','$timestamp','$timestamp','$subject','$playactor','$director','$tag','$atc_content','$yz','$grade')");
		$vid=$db->insert_id();		
		$db->update("INSERT INTO pv_videodata SET vid='$vid',sale='$sale',need='$need'");
		 
/*		foreach($urls as $key => $vodurls)
		{
			$array_urls = Split("\n","$vodurls");
			$s=1;
			foreach($array_urls as $url){
				if($url=='') continue;
				$playerid = $pid[$key];
				$server=$key+1;
				$caption='';
				$p = strpos($url,',');
				if($p!==false)
				{
					$caption = substr($url,$p+1);
					$url = substr($url,0,$p);
					
					  $urlreal = $_POST['realpos'];
				}
				$db->update("INSERT INTO pv_urls(vid,pid,url,series,server,caption) VALUES ('$vid','$playerid','$urlreal','$s','$server','$caption')");
				$s++;
			}
		}	*/	
		
		$db->update("INSERT INTO pv_urls(vid,pid,url,series,server,caption) VALUES ('$vid','10','$urlreal','$s','$server','$caption')");
		
		if($yz=='1' && $groupid!='guest')
		{
			$credit = unserialize($db_creditset);

			$addmoney = $credit['money']['Post'];
			$addrvrc = $credit['rvrc']['Post'];
			$db->update("UPDATE pv_memberdata SET postnum=postnum+1,rvrc=rvrc+$addrvrc,money=money+$addmoney WHERE uid='$uid'");

			customcredit($uid,$credit,'Post');
			update_memberid($uid);
		}


		/* 海报 */		
		$error = $_FILES['image']['error'];
		$img_name = $_FILES['image']['name'];
		$img_tmp = $_FILES['image']['tmp_name'];
		$img_size = $_FILES['image']['size'];
		$image_path = $imgpath."/pic/";

		if($error=='0' && $img_size>0 && $img_size<=$db_picmaxsize)
		{
			$available_type = explode(',',trim($db_picfiletype));
			$img_ext = strtolower(substr(strrchr($img_name,'.'),1));
			if($img_ext && in_array($img_ext,$available_type))
			{
				$filename = $vid.'.'.$img_ext;
				if(copy($img_tmp,$image_path.$filename))
				{
					$db->update("UPDATE pv_video SET pic='$filename' WHERE vid='$vid'");
				}				

			}

		}
		
		if($yz=='1')
			refreshto("./class.php?cid=$cid",'vid_success');
		else
			refreshto("./class.php?cid=$cid",'vid_success_check');
	}

}elseif ($postaction=="modify"){
	!$step && $step="1";
	if($step=='1'){

		$video = $db->get_one("SELECT v.*,c.* FROM pv_video v LEFT JOIN pv_videodata c ON c.vid=v.vid WHERE v.vid='$vid'");

		if(!$video) Showmsg('video_illegal');
		if($SYSTEM['allowadminedit']!='1')
		{
			if($video['authorid']!=$uid || $gp_alloweditatc!='1') Showmsg('modify_vod_error');
		}

		extract($video);
		$class_opt = str_replace("<option value=\"$cid\">","<option value=\"$cid\" selected>",$class_opt);
		$nation_opt = str_replace("<option value=\"$nid\">","<option value=\"$nid\" selected>",$nation_opt);

		$credit_opt = "<option value=\"money\">金钱</option><option value=\"rvrc\">威望</option>";
		foreach($_CREDITDB as $key => $value)
		{
			$credit_opt.="<option value=\"$key\">$value[0]</option>";
		}
		
		$sale_opt = $need_opt = $credit_opt;		

		if($sale!='')
		{
			$p = strpos($sale,'|');
			if($p!==false)
			{
				$sale_value = substr($sale,0,$p);
				$sale_type = substr($sale,$p+1);
				if(!is_numeric($sale_value) || (int)$sale_value <= 0) $sale_value = 0;
				$sale_opt = str_replace("<option value=\"$sale_type\">","<option value=\"$sale_type\" selected>",$sale_opt);
			}else $sale_value='0';

		}else $sale_value='0';

		if($need!='')
		{
			$p = strpos($need,'|');
			if($p!==false)
			{
				$need_value = substr($need,0,$p);
				$need_type = substr($need,$p+1);
				if(!is_numeric($need_value) || (int)$need_value <= 0) $need_value = 0;
				$need_opt = str_replace("<option value=\"$need_type\">","<option value=\"$need_type\" selected>",$need_opt);
			}else $need_value='0';

		}else $need_value='0';


		$result = $db->query("SELECT server FROM pv_urls WHERE vid='$vid' GROUP BY server");
		while($row=$db->fetch_array($result))
		{
			$servers[] = $row['server'];
		}

		
		$urls=array();
		foreach($servers as $server)
		{
			$result = $db->query("SELECT * FROM pv_urls WHERE vid='$vid' AND server='$server' ORDER BY series ASC");
			$urlmsg='';
			while($row=$db->fetch_array($result))
			{
			
				$pid=$row['pid'];
				if($row['caption']!='')
				{
					if($urlmsg=='')
						$urlmsg = $row['url'].','.$row['caption'];
					else
						$urlmsg.="\n".$row['url'].','.$row['caption'];
				}
				else
				{
					if($urlmsg=='')
						$urlmsg = $row['url'];
					else
						$urlmsg .= "\n".$row['url'];
				}
				

			}

			$urls[$server]['player']=str_replace("<option value=\"$pid\">","<option value=\"$pid\" selected>",$player);
			$urls[$server]['urlmsg']=$urlmsg;
		}


		$tag=explode("\t",$tag);

		if($pic && file_exists("$imgdir/pic/$pic"))
			$img = "$imgpath/pic/$pic";
		elseif($pic && strtolower(substr($pic,0,7))=='http://')
			$img = $pic;
		else
			$img = "$imgpath/pic/nopic.gif";


		$db_picmaxsize=ceil($db_picmaxsize/1024);

		require_once PrintEot('post');footer();

	}elseif($step=='2'){

		$postgd && GdConfirm($gdcode);
		$row = $db->get_one("SELECT cup FROM pv_class WHERE cid='$cid' LIMIT 1");
		if($row['cup']=='0'){
			Showmsg('post_type');
		}

		$subject = Char_cv($subject);
		$playactor = Char_cv($playactor);
		$director = Char_cv($director);
		$atc_content = Char_cv($atc_content);
		$urls = Char_cv($urls);
		$tag=implode("\t",$tag);

		if(empty($subject) || empty($cid) || empty($nid) || empty($pid) /*|| empty($urls)*/){
			Showmsg('form_error');			
		}

		$db->update("UPDATE pv_video SET cid='$cid',nid='$nid',subject='$subject',tag='$tag',playactor='$playactor',director='$director',content='$atc_content',lostdate='$timestamp', grade='$grade' WHERE vid='$vid'");

		if(is_numeric($sale_value) && (int)$sale_value > 0)
			$sale="{$sale_value}|{$sale_type}";
		else
			$sale='';

		if(is_numeric($need_value) && (int)$need_value > 0)
			$need="{$need_value}|{$need_type}";
		else
			$need='';

		$db->update("UPDATE pv_videodata SET sale='$sale',need='$need' WHERE vid='$vid'");

		/* 更新 pv_urls */

		foreach($urls as $key => $value)
		{
			$server = $key + 1;
			$str.=','.$server;
		}

		$str = substr($str,1);
		//$db->query("DELETE FROM pv_urls WHERE vid='$vid' AND server NOT IN ($str)");
		
		foreach($urls as $key => $urlmsg) //遍历所有播放组
		{
			$server = $key + 1;
			$playerid = $pid[$key];

			$new_urls = Split("\n","$urlmsg");
			foreach($new_urls as $key => $url) 
			{
				if($url=='') unset($new_urls[$key]);
			}
			$new_urls = array_values($new_urls);
			$new_count = count($new_urls);

			$old_urls=array();
			$result = $db->query("SELECT * FROM pv_urls WHERE vid='$vid' AND server='$server' ORDER BY series ASC");
			while($row = $db->fetch_array($result))
			{
				$old_urls[]=$row;
			}
			$old_count = count($old_urls);

			if($new_count < $old_count)
			{
				$num = $old_count - $new_count;
				$str='';
				$result = $db->query("SELECT uid FROM pv_urls WHERE vid='$vid' AND server='$server' ORDER BY series DESC LIMIT $num");
				while($row = $db->fetch_array($result))
				{
					if($str=='') $str.=$row['uid']; else $str.=','.$row['uid'];
				}
				
				//$db->query("DELETE FROM pv_urls WHERE uid IN ($str)");
			}

			for($i=0;$i<$new_count;$i++)
			{
				$n=$i+1;
				$caption='';
				$p = strpos($new_urls[$i],',');
				if($p!==false)
				{
					$caption = substr($new_urls[$i],$p+1);
					$new_urls[$i] = substr($new_urls[$i],0,$p);
				}

				if($old_urls[$i]['url']==$new_urls[$i] && 
				   $old_urls[$i]['series']==$n &&
				   $old_urls[$i]['pid']==$playerid &&
				   $old_urls[$i]['server']==$server &&
				   $old_urls[$i]['caption']==$caption				   
				  )
				{
					continue;
				}
				else
				{
					if(isset($old_urls[$i]))
					{
						$olduid = $old_urls[$i]['uid'];
						$db->update("UPDATE pv_urls SET pid='$playerid',url='$new_urls[$i]',series='$n',server='$server',caption='$caption' WHERE uid='$olduid'");
					}
					else
					{
						$db->update("INSERT INTO pv_urls(vid,pid,url,series,server,caption) VALUES('$vid','$playerid','$new_urls[$i]','$n','$server','$caption')");
					}
				}

			}

		}

		/* 海报 */		
		$error = $_FILES['image']['error'];
		$img_name = $_FILES['image']['name'];
		$img_tmp = $_FILES['image']['tmp_name'];
		$img_size = $_FILES['image']['size'];
		$image_path = $imgpath."/pic/";

		if($error=='0' && $img_size>0 && $img_size<=$db_picmaxsize)
		{
			$available_type = explode(',',trim($db_picfiletype));
			$img_ext = strtolower(substr(strrchr($img_name,'.'),1));
			if($img_ext && in_array($img_ext,$available_type))
			{
				$filename = $vid.'.'.$img_ext;
				if(copy($img_tmp,$image_path.$filename))
				{
					
					if($pic!=$filename && $pic!='' && file_exists("$imgdir/pic/$pic"))
						P_unlink("$imgdir/pic/$pic");
					$db->update("UPDATE pv_video SET pic='$filename' WHERE vid='$vid'");
				}				

			}

		}

		refreshto("./read.php?vid=$vid",'operate_success');
	}
}elseif($postaction=='del'){
	
	$video = $db->get_one("SELECT authorid,pic,yz,cid FROM pv_video WHERE vid='$vid'");
	if(!$video) Showmsg('video_illegal');
	@extract($video);

	if($SYSTEM['allowadmindel']!='1')
	{
		if($authorid!=$uid || $gp_allowdelatc!='1') Showmsg('delete_vod_error');
	}

	if(file_exists("$imgdir/pic/$pic")) P_unlink("$imgdir/pic/$pic");
//TODO 删除视频文件
	if($yz=='1' && $groupid!='guest' && $authorid!='0')
	{
		@extract($db->get_one("SELECT postnum FROM pv_memberdata WHERE uid='$authorid'"));
		$postnum+=-1;
		$credit = unserialize($db_creditset);
		$decmoney = $credit['money']['Delete'];
		$decrvrc = $credit['rvrc']['Delete'];
		$db->update("UPDATE pv_memberdata SET postnum='$postnum',rvrc=rvrc-$decrvrc,money=money-$decmoney WHERE uid='$authorid'");

		customcredit($authorid,$credit,'Delete');
		update_memberid($authorid);
	}		
		
	$db->update("DELETE FROM pv_video WHERE vid='$vid'");
	$db->update("DELETE FROM pv_videodata WHERE vid='$vid'");
	$db->update("DELETE FROM pv_urls WHERE vid='$vid'");
	
	refreshto("./class.php?cid=$cid",'operate_success');
}

?>