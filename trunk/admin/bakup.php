<?php
!function_exists('adminmsg') && exit('Forbidden');
@set_time_limit(0);
if(!$type) $type='bakout';
$basename="$admin_file?adminjob=bakup&type=$type";

if($type=='bakout'){
	if(empty($action)){
		require_once(R_P."admin/table.php");
		include PrintEot('bakup');exit;
	}elseif($action=='bakout'){
		$step;
		$bak="#\n# PHPvod bakfile\n# Version:".$version."\n# Time: ".get_date($timestamp,'Y-m-d H:i')."\n# PHPvod: http://www.PHPvod.com\n# --------------------------------------------------------\n\n\n";
		$db->query("SET SQL_QUOTE_SHOW_CREATE = 0");

		$start = intval($start);
		!$tabledb && !$tablesel && adminmsg('operate_error');
		!$tabledb && $tabledb=explode("|",$tablesel);
		!$step && $sizelimit/=2;
		$bakupdata=bakupdata($tabledb,$start);
		if(!$step){
			!$tabledb && adminmsg('operate_error');
			$tablesel=implode("|",$tabledb);
			$step=1;
			$start=0;
			$pre='pv_'.get_date($timestamp,'YmdHis').'_';
			$bakuptable=bakuptable($tabledb);
		}
		$f_num=ceil($step/2);
		$filename=$pre.$f_num.'.sql';
		$step++;
		$writedata=$bakuptable ? $bakuptable.$bakupdata : $bakupdata;

		$t_name=$tabledb[$tableid-1];  $c_n=$startfrom;
		if($stop==1){
			$files=$step-1;

			trim($writedata) && writeover(D_P.'data/'.$filename,$bak.$writedata,'ab');
			$j_url="$basename&action=$action&start=$startfrom&tableid=$tableid&sizelimit=$sizelimit&step=$step&pre=$pre&tablesel=$tablesel&rows=$rows";
			adminmsg('bakup_step',$j_url,2);
		} else{
			trim($writedata) && writeover(D_P.'data/'.$filename,$bak.$writedata,'ab');
			if($step>1){
				for($i=1;$i<=$f_num;$i++){
					$bakfile.='<a href="data/'.$pre.$i.'.sql">'.$pre.$i.'.sql</a><br>';
				}
			}
			adminmsg('bakup_out');
		}
	}
} elseif($type=='bakin'){
	if(empty($action)){
		$filedb=array();
		$handle=opendir(R_P.'data');
		while($file = readdir($handle)){
			if((!$pv || eregi("^pv_",$file) || eregi("^$pv",$file)) && eregi("\.sql$",$file)){
				$strlen=eregi("^$pv",$file) ? 15 + strlen($pv) : 19;
				$fp=fopen(D_P."data/$file",'rb');
				$bakinfo=fread($fp,200);
				fclose($fp);
				$detail=explode("\n",$bakinfo);
				$bk['name']=$file;
				$bk['version']=substr($detail[2],10);
				$bk['time']=substr($detail[3],8);
				$bk['pre']=substr($file,0,$strlen);
				$bk['num']=substr($file,$strlen,strrpos($file,'.')-$strlen);
				$filedb[]=$bk;
			}
		}
		include PrintEot('bakup');exit;
	} elseif($action=='bakincheck'){
		include PrintEot('bakup');exit;
	} elseif($action=='bakin'){
		if(!$count){
			$count=0;
			$handle=opendir(D_P.'data');
			while($file = readdir($handle)){
				if(eregi("^$pre",$file) && eregi("\.sql$",$file)){
					$count++;
				}
			}
		}
		!$step && $step=1;
		bakindata(D_P.'data/'.$pre.$step.'.sql');
		$i=$step;
		$step++;
		if($count > 1 && $step <= $count){
			$j_url="$basename&action=bakin&step=$step&count=$count&pre=$pre";
			adminmsg('bakup_in',$j_url,2);
		}
		updatecache();
		adminmsg('operate_success');
	} elseif($action=='del'){
		if(!$delfile)adminmsg('operate_error');
		foreach($delfile as $key => $value){
			if(eregi("\.sql$",$value)){
				P_unlink(D_P."data/$value");
			}
		}
		adminmsg('operate_success');
	}
}
function bakupdata($tabledb,$start=0){
	global $db,$sizelimit,$tableid,$startfrom,$stop,$rows;
	$tableid=$tableid?$tableid-1:0;
	$stop=0;
	$t_count=count($tabledb);
	for($i=$tableid;$i<$t_count;$i++){

		$ts=$db->get_one("SHOW TABLE STATUS LIKE '$tabledb[$i]'");
		$rows=$ts['Rows'];

		$limitadd="LIMIT $start,100000";
		$query = $db->query("SELECT * FROM $tabledb[$i] $limitadd");
		$num_F = mysql_num_fields($query);


		$fields = '';
		for($c=0;$c<$num_F;$c++) 
		{
			if($fields=='') 
				$fields = mysql_field_name($query,$c); 
			else
				$fields.=','.mysql_field_name($query,$c);
		}

		while ($datadb = mysql_fetch_row($query)){
			$start++;
			$bakupdata .= "INSERT INTO $tabledb[$i]($fields) VALUES("."'".mysql_escape_string($datadb[0])."'";
			$tempdb='';
			for($j=1;$j<$num_F;$j++){
				$tempdb.=",'".mysql_escape_string($datadb[$j])."'";
			}
			$bakupdata .=$tempdb. ");\n";
			if($sizelimit && strlen($bakupdata)>$sizelimit*1000){
				break;
			}
		}
		$db->free_result($query);

		if($start>=$rows){
			$start=0;
			$rows=0;
		}

		$bakupdata .="\n";
		if($sizelimit && strlen($bakupdata)>$sizelimit*1000){
			$start==0 && $i++;
			$stop=1;
			break;
		}
		$start=0;
	}
	if($stop==1){
		$i++;
		$tableid=$i;
		$startfrom=$start;
		$start=0;
	}
	return $bakupdata;
}
function bakuptable($tabledb){
	global $db;
	foreach($tabledb as $key=>$table){
		$creattable.= "DROP TABLE IF EXISTS $table;\n";
		$CreatTable = $db->get_one("SHOW CREATE TABLE $table");
		$CreatTable['Create Table']=str_replace($CreatTable['Table'],$table,$CreatTable['Create Table']);
		$creattable.=$CreatTable['Create Table'].";\n\n";
	}
	return $creattable;
}
function bakindata($filename) {
	global $db,$charset;
	$sql=file($filename);
	$query='';
	$num=0;
	foreach($sql as $key => $value){
		$value=trim($value);
		if(!$value || $value[0]=='#') continue;
		if(eregi("\;$",$value)){
			$query.=$value;
			if(eregi("^CREATE",$query)){
				$extra = substr(strrchr($query,')'),1);
				$tabtype = substr(strchr($extra,'='),1);
				$tabtype = substr($tabtype, 0, strpos($tabtype,strpos($tabtype,' ') ? ' ' : ';'));
				$query = str_replace($extra,'',$query);
				if($db->server_info() > '4.1'){
					$extra = $charset ? "ENGINE=$tabtype DEFAULT CHARSET=$charset;" : "ENGINE=$tabtype;";
				}else{
					$extra = "TYPE=$tabtype;";
				}
				$query .= $extra;
			}elseif(eregi("^INSERT",$query)){
				$query='REPLACE '.substr($query,6);
			}
			$db->query($query);
			$query='';
		} else{
			$query.=$value;
		}

	}
}
?>