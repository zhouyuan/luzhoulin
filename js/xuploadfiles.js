
// Functions for XUploadFiles

// ���ͻ��˲���汾���Ƿ���������汾ƥ��
function xuploadfiles_ver()
{
	// �ͻ��˲���汾�š�����������ص�ַ
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
		'<b><font face="Arial" size="6" color="#FF0000">�ϴ��������ͨ��</font></b><br>'+
		'<font color="#FFFFFF">������ʹ�õ� XUploadFiles ����İ汾Ϊ: <b>'+strmyver+'</b></br>'+
		'��������������������°汾: <b>'+strver+'</b></font></td></tr>');
	} else
	document.writeln(
		'<table align="center" border="1" width="540" cellspacing="0" bordercolor="#000000" cellpadding="15">'+
		'<tr><td bgcolor="#000000" align="center">'+
		'<b><font face="Arial" size="6" color="#FF0000">�� Ҫ �� ʾ</font></b><br>'+
		'<font color="#FFFFFF">����Ҫ��װ XUploadFiles �ͻ��˲������ɱ�ҳ���ļ��ϴ�����</font></td></tr>');
	document.writeln(
		'<tr><td bgcolor="#EBEBEB"><b>��������:</b>'+
		'<ol><li>�������: <a href="'+updateURL+'.cab" target="_blank" title="������WinXP/2003">��ȫ������</a>��'+
		'<a href="'+updateURL+'_98.cab" target="_blank" title="������Win98/2000">ͨ�ð�����</a></li>'+
		'<li>�ر���������ڣ�Ȼ��ִ�������ļ������ install.exe ���а�װ��</li></ol></table>');
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

// ���ü��ͻ��˲���汾����
xuploadfiles_ver();
