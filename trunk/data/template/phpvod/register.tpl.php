<hr />
<form action="register.php" method="post" onSubmit="return check(this)" name="register">
<input type="hidden" value="2" name="step" />
<table class="table table_w960">
<tr><th colspan="2">
<img src="<?=$imgpath?>/<?=$stylepath?>/index/home_menu.gif" align="absmiddle"> 
<a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; �»�Աע��
</th></tr>
<? if($reggd) { ?>
<tr>
<td><strong>��֤��<span style="color: red;">*</span></strong></td>
<td>
<img src="ck.php" align="absmiddle" onclick="this.src='ck.php'" style="cursor: pointer;" />
<input type="text" maxLength="4" class="text" name="gdcode" size="4" /> �����������֤�룬���ͼƬˢ��
</td>
</tr>
<? } ?>
<tr>
<td class="w40">
<strong>�û���<span style="color: red;">*</span></strong><br />���������ģ������пո񣬳��ȿ����� <?=$rg_regminname?> - <?=$rg_regmaxname?> �ֽ�����
</td>
<td><input type="text" class="text" name="regname" /></td>
</tr>

<tr>
<td><strong>����<span style="color: red;">*</span></strong><br />Ӣ����ĸ�����ֵȲ�����6λ</td>
<td><input type="password" class="text" name="regpwd" onchange="checkpwd();" />&nbsp;<span id="pwd_info"></span></td>
</tr>

<tr>
<td><strong>ȷ������<span style="color: red;">*</span></strong></td>
<td><input type="password" class="text" name="regpwdrepeat" onchange="checkpwdrepeat();" />&nbsp;<span id="pwdrepeat_info"></span></td>
</tr>

<tr>
<td><strong>E-Mail<span style="color: red;">*</span></strong></td>
<td><input type="text" class="text" name="regemail" onchange="checkemail();" />&nbsp;<span id="email_info"></span> <input type="checkbox" name="regemailtoall" value="1" checked /> ��������</td>
</tr>
<? if($rg_regdetail) { ?>
<tr>
<td><strong>�Ա�</strong></td>
<td>
<select name="regsex">
<option value="1">˧��</option>
<option value="2">��Ů</option>
<option value="0" selected>����</option>
</select>
</td>
</tr>

<tr>
<td><strong>����</strong></td>
<td>
<select name="regbirthyear">
<option value=""></option><? for($i=1960;$i<=2008;$i++){ ?><option value="<?=$i?>"><?=$i?></option><? } ?></select>�� 
<select name="regbirthmonth">
<option value=""></option><? for($i=1;$i<=12;$i++){ ?><option value="<?=$i?>"><?=$i?></option><? } ?></select>�� 
<select name="regbirthday">
<option value=""></option><? for($i=1;$i<=31;$i++){ ?><option value="<?=$i?>"><?=$i?></option>  <? } ?></select>��
</td>
</tr>

<tr>
<td><strong>�Զ���ͷ��</strong></td>
<td><input type="text" class="text" name="honor" /></td>
</tr>

<tr>
<td><strong>ѡ������ͷ��</strong></td>
<td>
<img src="<?=$imgpath?>/face/none.gif" name="useravatars" />
<select name="regicon" onChange="showimage('<?=$imgpath?>',this.options[this.selectedIndex].value)">
<option value="none.gif">none.gif</option>
<?=$imgselect?>
</select>

</td>
</tr>

<tr>
<td><strong>��ѶQQ</strong></td>
<td><input type="text" class="text" name="oicq" /></td>
</tr>

<tr>
<td><strong>MSN</strong></td>
<td><input type="text" class="text" name="msn" /></td>
</tr>

<tr>
<td><strong>������ҳ</strong></td>
<td><input type="text" class="text" name="site" /></td>
</tr>

<tr>
<td><strong>����ǩ��</strong><br /><?=$rg_regmaxsign?>�ֽ�����</td>
<td><textarea name="regsign" cols="50" rows="5"></textarea></td>
</tr>

<tr>
<td><strong>�Ƿ����ϵͳ�ʼ�</strong></td>
<td>
<input type=radio value="1" name="regifemail" CHECKED> �����ʼ� 
<input type=radio value="2" name="regifemail"> �������ʼ�
</td>
</tr>
<? } ?>
</table>
<br /><center><input name="regsubmit" type="submit" value="�� ��" class="button"/></center>
</form>
<br />

<script language="JavaScript" type="text/javascript">
<!--
function check(formct)
{
if (formct.regsign.value.length><?=$rg_regmaxsign?>)
{
alert('����ǩ��̫��������<?=$rg_regmaxsign?>�ֽ�����');
return false;
}
}
function showimage(imgpath,value)
{
if(value!= '') {	
document.images.useravatars.src=imgpath+'/face/'+value;
} else{
document.images.useravatars.src=imgpath+'/face/none.gif';
}
}
function checkpwd(){
var pwd = document.getElementById("regpwd").value;
var pwdrepeat = document.getElementById("regpwdrepeat").value;
if (pwd.length<6){
document.getElementById("pwd_info").innerHTML = "<span style=\"color: red;\">����̫�٣�����6λ���ϡ�</span>";
} else{
document.getElementById("pwd_info").innerHTML = "";
}
if(pwdrepeat){
checkpwdrepeat();
}
}
function checkpwdrepeat(){
var pwd = document.getElementById("regpwd").value;
var pwdrepeat = document.getElementById("regpwdrepeat").value;
if (pwdrepeat==pwd){
document.getElementById("pwdrepeat_info").innerHTML = "";
} else{
document.getElementById("pwdrepeat_info").innerHTML = "<span style=\"color: red;\">������������벻һ�£���������ԡ�</span>";
}
}
function checkemail(){
var email = document.getElementById("regemail").value;
var myReg = /^[-a-zA-Z0-9_\.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$/; 
if(myReg.test(email)){
document.getElementById("email_info").innerHTML = "";
} else{
document.getElementById("email_info").innerHTML = "<span style=\"color: red;\">Email ��ʽ����!</span>";
}
}
//-->
</script>