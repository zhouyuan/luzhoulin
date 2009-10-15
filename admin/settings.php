<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=settings&type=$type";
$dbsetfile = 'data/cache/dbset.php';

if ($action!='unsubmit'){
	!$type && $type='wwwset';
	if($type=='wwwset' || $type=='all'){
		$db_whyclose = str_replace('<br />',"\n",$db_whyclose);
		$db_copyright = str_replace('<br />',"\n",$db_copyright);
		ifcheck($db_siteifopen,'siteifopen');
	}
	if($type=='function' || $type=='all'){
		$db_timedf < 0 ? ${'zone_0'.str_replace('.','_',abs($db_timedf))}='selected' : ${'zone_'.str_replace('.','_',$db_timedf)}='selected';
		${'charset_'.str_replace('-','',$db_charset)}='selected';
		${'cc_'.$db_cc}='selected';
		ifcheck($db_obstart,'obstart');
		ifcheck($db_debug,'debug');
		ifcheck($db_ifjump,'ifjump');
		
		if($db_datefm){
			if(strpos($db_datefm,'h:i A')){
				$db_datefm=str_replace(' h:i A','',$db_datefm);
				$check_12='checked';
			} else{
				$db_datefm=str_replace(' H:i','',$db_datefm);
				$check_24='checked';
			}
			$db_datefm = str_replace('m', 'mm', $db_datefm);
			$db_datefm = str_replace('n', 'm', $db_datefm);
			$db_datefm = str_replace('d', 'dd', $db_datefm);
			$db_datefm = str_replace('j', 'd', $db_datefm);
			$db_datefm = str_replace('y', 'yy', $db_datefm);
			$db_datefm = str_replace('Y', 'yyyy', $db_datefm);
		} else{
			$db_datefm='yyyy-mm-dd';
			$check_24='checked';
		}
				
		ifcheck($db_forcecharset,'forcecharset');
		ifcheck($db_tplrefresh,'tplrefresh');
		ifcheck($db_iconupload,'iconupload');
		$choseskin = getstyles($db_defaultstyle);

	}
	if($type=='ck' || $type=='all'){
		list($reggd,$logingd,$admingd,$postgd,$msggd,$othergd)=explode("\t",$db_gdcheck);
		ifcheck($reggd,'reggd');
		ifcheck($logingd,'logingd');
		ifcheck($admingd,'admingd');
		ifcheck($postgd,'postgd');
		ifcheck($msggd,'msggd');
		ifcheck($othergd,'othergd');
	}
	if($type=='info' || $type=='all'){
		ifcheck($db_indexlink,'indexlink');
		ifcheck($db_indexmqlink,'indexmqlink');
		ifcheck($db_reply,'reply');
	}
	if($type=='pathset' || $type=='all'){
		if (file_exists($imgdir) && !is_writeable($imgdir)){
			$imgdisabled='disabled';
		}
		if (file_exists($attachdir) && !is_writeable($attachdir)){
			$attdisabled='disabled';
		}
		$db_hour && $hour_sel[$db_hour]='selected';
		ifcheck($db_autochange,'autochange');
	}
	if($type=='sethtm' || $type=='all'){
		ifcheck($db_htmifopen,'htmifopen');
		!$db_dir && $db_dir='.php?';
		!$db_ext && $db_ext='.html';	
	}
	if($type=='upfile' || $type=='all'){
		ifcheck($db_uploadvodpic,'uploadvodpic');
		$db_picmaxsize=ceil($db_picmaxsize/1024);
	}
	if($type=='regset' || $type=='all'){
		include(D_P.'data/cache/dbreg.php');
		ifcheck($rg_allowregister,'allowregister');
		ifcheck($rg_regdetail,'regdetail');
		ifcheck($rg_ifcheck,'ifcheck');
	}
	if($type=='atcset' || $type=='all')
	{
		$credit = unserialize($db_creditset);
	}

	include PrintEot('setting');exit;
}elseif ($action=="unsubmit"){
	if(!is_writeable(D_P.'data/cache/config.php') && !chmod(D_P.'data/cache/config.php',0777)){
		adminmsg('config_777');
	}
	
	if($type=='function' || $type=='all'){
		if($config['datefm']){
			if(strpos($config['datefm'],'mm')!==false){
				$config['datefm'] = str_replace('mm','m',$config['datefm']);
			} else{
				$config['datefm'] = str_replace('m','n',$config['datefm']);
			}
			if(strpos($config['datefm'],'dd')!==false){
				$config['datefm'] = str_replace('dd','d',$config['datefm']);
			} else{
				$config['datefm'] = str_replace('d','j',$config['datefm']);
			}
			$config['datefm'] = str_replace('yyyy','Y',$config['datefm']);
			$config['datefm'] = str_replace('yy','y',$config['datefm']);
			$timefm=$time_f=='12' ? ' h:i A' :' H:i';
			$config['datefm'].=$timefm;
		} else{
			$config['datefm']='Y-n-j H:i';
		}

		!is_numeric($config['iconsize']) && $config['iconsize'] = 20;
	}
			
	if($type=='ck' || $type=='all'){
		$config['gdcheck'] = implode("\t",$gdcheck);
	}
	if($type=='info' || $type=='all'){
		!is_numeric($config['adminperpage'])	&& $config['adminperpage']=20;
		!is_numeric($config['perpage'])	&& $config['perpage']=10;
		!is_numeric($config['readperpage'])	&& $config['readperpage']=10;
		!is_numeric($config['postmin'])	&& $config['postmin']=3;
		!is_numeric($config['postmax'])	&& $config['postmax']=5000;
	}
	if($type=='pathset' || $type=='all'){
		if ($config['http']!='N' && !ereg("^http",$config['http'])){
			adminmsg('setting_http');
		}
		if($config['autochange']){
			if(!is_writeable($imgdir)){
				$config['autochange']=0;
			}
		}
		if(!is_dir($set['picpath']) && $picpath!=$set['picpath'] && !@rename($picpath,$set['picpath'])){
			$set['picpath']=$picpath;
			adminmsg('setting_777');
		}
		if (!is_dir($set['attachpath']) && $attachname!=$set['attachpath'] && !@rename($attachname,$set['attachpath'])){
			$set['attachpath']=$attachname;
			adminmsg('setting_777');
		}
		$dbcontent="<?php\r\n\$picpath='$set[picpath]';\r\n\$attachname='$set[attachpath]';\r\n?>";
		writeover(R_P.'data/cache/dbset.php',$dbcontent);
	}
	if($type=='upfile' || $type=='all'){
		if (!is_numeric($config['picmaxsize'])){
			$config['picmaxsize']=0;
		} else{
			$config['picmaxsize']*=1024;
		}
	}
	if($type=='regset' || $type=='all'){
		include_once(D_P."data/cache/dbreg.php");
		!is_numeric($reg['regmaxsign'])	&& $reg['regmaxsign']=100;
		!is_numeric($reg['regminname']) && $reg['regminname']=3;
		!is_numeric($reg['regmaxname']) && $reg['regmaxname']=12;
		if ($reg['regmaxname']>15){
			adminmsg('illegal_username');
		}
		foreach($reg as $key=>$value){
			if(${'rg_'.$key}!=$value){
				$rt=$db->get_one("SELECT db_name FROM pv_config WHERE db_name='rg_$key'");
				if($rt['db_name']=="rg_$key"){
					$db->update("UPDATE pv_config SET db_value='$value' WHERE db_name='rg_$key'");
				}else{
					$db->update("INSERT INTO pv_config(db_name,db_value) VALUES ('rg_$key','$value')");
				}
			}
		}
	}
	if($type=='atcset' || $type=='all'){
		foreach($creditdb as $key => $value){
			foreach($value as $k => $val){
				$creditdb[$key][$k] = (int)$val;
			}
		}

		$config['creditset'] = $creditdb ? serialize($creditdb) : '';
	}

	if(!in_array($type,array('mail'))){
		//get pv_config value
		$query = $db->query("SELECT * FROM pv_config WHERE db_name LIKE 'db\_%' OR db_name LIKE 'rg\_%'");
		while ($rt = $db->fetch_array($query)){
			$rt['db_name']=str_replace("'","\'",$rt['db_name']);
			$configdb[$rt['db_name']]=$rt['db_value'];
		}
		if(is_array($config))
		foreach($config as $key=>$value){
			$c_key=${'db_'.$key};
			if(strpos($key,'_')!==false){ // a_b -> $db_a['b'] -> a[\'b\']
				$c_db=explode('_',$key);
				$c_db_array=${'db_'.$c_db[0]};
				$c_key=$c_db_array[$c_db[1]];
				$key=str_replace('_',"[\'",$key)."\']";
			}
			if($c_key!=$value || $configdb["db_$key"]!=$value){
				$rt=$db->get_one("SELECT db_name FROM pv_config WHERE db_name='db_$key'");
				if($rt['db_name']){
					$db->update("UPDATE pv_config SET db_value='$value' WHERE db_name='db_$key'");
				}else{
					$db->update("INSERT INTO pv_config(db_name,db_value) VALUES ('db_$key','$value')");
				}
			}
		}
	}
	updatecache_c();
	adminmsg('operate_success');
}
?>