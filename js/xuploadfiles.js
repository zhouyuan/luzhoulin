
// Functions for XUploadFiles

// 检查客户端插件版本，是否与服务器版本匹配
function xuploadfiles_ver()
{
	// 客户端插件版本号、最新软件下载地址
	var ver = 2100;	// 2.1.0.0
	var updateURL = "http://localhost/xuploadfiles/activex/xuploadfiles"; 

	var obj;

	for(i=0;i<document.all.length;i++) {
		obj = document.all(i);
		try { if(obj.classid == 'clsid:18B9E4BF-F21F-46B9-AD50-5CA62145426A') break; } catch(e) { }
		obj = null;
	}

	var myver = 0;
	alert(obj.version());//bug
	try { myver = obj.version(); } catch(e) { }
	if (myver >= ver) return;
	
	var strver,strmyver;
	s = ver.toString();
	strver = s.substr(0,1)+','+s.substr(1,1)+','+s.substr(2,1)+','+s.substr(3,1);
	if (myver > 0) {
		s = myver.toString();
		strmyver = s.substr(0,1)+','+s.substr(1,1)+','+s.substr(2,1)+','+s.substr(3,1);

	document.writeln(
		'<table align="center" border="1" width="540" cellspacing="0" bordercolor="#000000" cellpadding="15">'+
		'<tr><td bgcolor="#000000" align="center">'+
		'<b><font face="Arial" size="6" color="#FF0000">上传插件升级通告</font></b><br>'+
		'<font color="#FFFFFF">您现在使用的 XUploadFiles 插件的版本为: <b>'+strmyver+'</b></br>'+
		'请立即升级到插件的最新版本: <b>'+strver+'</b></font></td></tr>');
	} else
	document.writeln(
		'<table align="center" border="1" width="540" cellspacing="0" bordercolor="#000000" cellpadding="15">'+
		'<tr><td bgcolor="#000000" align="center">'+
		'<b><font face="Arial" size="6" color="#FF0000">重 要 提 示</font></b><br>'+
		'<font color="#FFFFFF">您需要安装 XUploadFiles 客户端插件来完成本页的文件上传操作</font></td></tr>');
	document.writeln(
		'<tr><td bgcolor="#EBEBEB"><b>操作方法:</b>'+
		'<ol><li>点击下载: <a href="'+updateURL+'.cab" target="_blank" title="适用于WinXP/2003">完全版下载</a>，'+
		'<a href="'+updateURL+'_98.cab" target="_blank" title="适用于Win98/2000">通用版下载</a></li>'+
		'<li>关闭浏览器窗口，然后执行下载文件里面的 install.exe 进行安装。</li></ol></table>');
	document.writeln("<div style=\"display:none\"><style><!-- ");
}

function xu_find()
{
	var i,obj = null;
	for(i=0;i<document.all.length;i++) {
		obj = document.all(i);
		try { if(obj.classid == 'clsid:18B9E4BF-F21F-46B9-AD50-5CA62145426A') break; } catch(e) { }
		obj = null;
	}
	return obj;
}
function xu_reset()
{
	var obj = xu_find();
	if (obj != null) obj.reset();
}
function xu_subpath(subpath)
{
	var obj = xu_find();
	if (obj != null) obj.setpath(subpath);
}
function xu_selectfiles()
{
	var obj = xu_find();
	if (obj != null) obj.selectfiles();
}

// 调用检查客户端插件版本函数
xuploadfiles_ver();
