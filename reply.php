<?php
require_once('global.php');
include_once(R_P.'data/cache/class.php');

header("Content-type: text/html;charset=GBK");
header("Cache-Control: no-cache, must-revalidate");//����������

if(!$action){
	$rt = $db->get_one("SELECT COUNT(*) AS sum FROM pv_replier where vid=$vid");
	(!is_numeric($page) || $page < 1) && $page = 1;
	$limit = "LIMIT ".($page-1)*$db_readperpage.",$db_readperpage";
	$pages = numpage($rt['sum'],$page,ceil($rt['sum']/$db_readperpage),"reply.php?vid=$vid&");	

	$query=$db->query("SELECT * FROM pv_replier WHERE vid=$vid AND yz='1' ORDER BY postdate DESC $limit");
	while($replier=$db->fetch_array($query))
	{
		$replier['postdate'] = get_date($replier['postdate']);
		$replier['content'] = ieconvert($replier['content']);

		if($replier['authorid']=='0')
			$replier['signature'] = '';
		else
		{
			$s = $db->get_one("SELECT signature FROM pv_members WHERE uid='$replier[authorid]'");
			$replier['signature'] = $s['signature'];			
		}
		
		$replierdb[]=$replier;
	}
	unset($replier);
	require_once PrintEot('reply');exit;
}elseif($ation='add'){

	/* �û���Ȩ�� */
	if($gp_allowrp!='1')
	{
		echo "�����ڵ��û��鲻�߱��������۵�Ȩ�ޡ�";
		exit;
	}

	/* ��ĿȨ�� */
	$v = $db->get_one("SELECT cid FROM pv_video WHERE vid='$vid'");
	$cid = $v['cid'];

	if($class[$cid]['type']!='free' && $groupid=='guest')
	{
		echo "��Ƶ���ڵ���ĿΪ�����飬�����߱��ڴ���Ŀ�������۵�Ȩ�ޡ�";
		exit;
	}

	if($class[$cid]['allowrp']!='')
	{
		if($groupid=='guest' || strpos($class[$cid]['allowrp'],",$groupid,")===false)
		{
			echo "��Ƶ���ڵ���ĿΪ��֤��飬�����߱��ڴ���Ŀ�������۵�Ȩ�ޡ�";
			exit;
		}
	}
	
	if (($class[$cid]['atccheck'] == '2' || $class[$cid]['atccheck'] == '3') && $gp_rpcheck == '1')
		$yz='0'; else $yz='1';

	$atc_content = utf8RawUrlDecode($atc_content);
	$atc_content = mb_convert_encoding($atc_content,"gb2312","HTML-ENTITIES");    
	$len = strlen($atc_content);
	if($len<$db_postmin || $len>$db_postmax)
	{
		echo "���ݳ��ȱ���λ�� $db_postmin - $db_postmax �ֽ�֮�䡣";
		exit;
	}
	$atc_content = char_cv($atc_content);
	if($groupid=='guest')
	{
		$username = '�ο�';
		$uid = '0';
	}
	$db->update("INSERT INTO pv_replier (vid,author,authorid,postdate,content,yz) VALUES ('$vid','$username','$uid','$timestamp','$atc_content','$yz')");

	if($yz=='1')
	{
		$db->update("UPDATE pv_videodata SET replier=replier+1 WHERE vid='$vid'");
		if($groupid!='guest')
		{
			$credit = unserialize($db_creditset);
			$addmoney = $credit['money']['Reply'];
			$addrvrc = $credit['rvrc']['Reply'];
			$db->update("UPDATE pv_memberdata SET rvrc=rvrc+$addrvrc,money=money+$addmoney WHERE uid='$uid'");

			customcredit($uid,$credit,'Reply');
			update_memberid($uid);
		}
	}
	else
	{
		echo "�����ύ�ɹ�����ȴ�����Ա��ˡ�";
	}
}


function numpage($count,$page,$numpage,$url,$max=0)
{
	$total=$numpage;
	$max && $numpage > $max && $numpage=$max;
	if ($numpage <= 1 || !is_numeric($page)){
		return ;
	}else{
		$pages="<a href=\"javascript:\" onclick=page('{$url}page=1');>��ҳ</a>&nbsp;";
		$flag=0;
		for($i=$page-3;$i<=$page-1;$i++)
		{
			if($i<1) continue;
			$pages.="&nbsp;<a href=\"javascript:\" onclick=page('{$url}page=$i');>$i</a>&nbsp;";
		}
		$pages.="&nbsp;<strong>$page</strong>&nbsp;";
		if($page<$numpage)
		{
			for($i=$page+1;$i<=$numpage;$i++)
			{
				$pages.="&nbsp;<a href=\"javascript:\" onclick=page('{$url}page=$i');>$i</a>&nbsp;";
				$flag++;
				if($flag==4) break;
			}
		}
		$pages.="
		
		<input type='text' size='2' class='text' onkeydown=\"javascript: if(event.keyCode==13) page('{$url}page='+this.value);\">
		&nbsp;<a href=\"javascript:\" onclick=page('{$url}page=$numpage');>ĩҳ</a>&nbsp;&nbsp;��{$total}ҳ";
		return $pages;
	}
}


function utf8RawUrlDecode ($source)
{
    $decodedStr = "";
    $pos = 0;
    $len = strlen ($source);
    while ($pos < $len) {
        $charAt = substr ($source, $pos, 1);
        if ($charAt == '%') {
            $pos++;
            $charAt = substr ($source, $pos, 1);
            if ($charAt == 'u') {
                // we got a unicode character
                $pos++;
                $unicodeHexVal = substr ($source, $pos, 4);
                $unicode = hexdec ($unicodeHexVal);
                $entity = "&#". $unicode . ';';
                $decodedStr .= utf8_encode ($entity);
                $pos += 4;
            }
            else {
                // we have an escaped ascii character
                $hexVal = substr ($source, $pos, 2);
                $decodedStr .= chr (hexdec ($hexVal));
                $pos += 2;
            }
        } else {
            $decodedStr .= $charAt;
            $pos++;
        }
    }
    return $decodedStr;
}

?>