<hr />
<? if($action!='show' || $userdb[uid]==$uid) { ?>
<table class="table table_w960">
<tr><th colspan="3"><img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absmiddle"> <a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; ��������</th></tr>
<tr class="text_center">
<td><a href="profile.php?action=show&id=<?=$uid?>">�ҵ�����</a></td>
<td><a href="profile.php?action=modify">�޸�����</a></td>
<td><a href="profile.php?action=myvideo">�ҵ���Ƶ</a></td>
</tr>
</table>
<? } if($action=='show') { ?>
<table class="table table_w960">
<tr><th colspan="2">
<img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absmiddle"> <a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; ��������
</th></tr>
<tr><td class="w40">UID</td><td><?=$userdb[uid]?></td></tr>
<tr><td>�û���</td><td><?=$userdb[username]?></td></tr>
   	<tr><td>��</td><td><?=$userdb[region]?></td></tr>
<tr><td>ѧУ</td><td><?=$userdb[school]?></td></tr>
<tr><td>��Աͷ��</td><td><?=$userdb[membertitle]?></td></tr>
    <tr><td>����¼IP</td><td><?=$userdb[ip]?></td></tr>
<!--	<tr><td>�Զ���ͷ��</td><td><?=$userdb[honor]?></td></tr>-->
<!--	<tr><td>ϵͳͷ��</td><td><?=$userdb[grouptitle]?></td></tr>-->
<!--	<tr><td>�ۺϻ���</td><td><?=$userdb[credit]?></td></tr>
<tr><td>��Ƶ��</td><td><?=$userdb[postnum]?></td></tr>
<tr><td>����</td><td><?=$userdb[rvrc]?></td></tr>
<tr><td>��Ǯ</td><td><?=$userdb[money]?></td></tr>-->

<tr><td>ͷ��</td><td><img src="<?=$userdb[icon]?>" width="100" height="120" /></td></tr>
<tr><td>Email</td><td><?=$userdb[email]?></td></tr>
<tr><td>�Ա�</td><td><?=$userdb[gender]?></td></tr>
<tr><td>����</td><td><?=$userdb[bday]?></td></tr>
<tr><td>������ҳ</td><td><a href="<?=$userdb[site]?>" target="_blank"><?=$userdb[site]?></a></td></tr>
<tr><td>ǩ��</td><td><?=$userdb[signature]?></td></tr>
<tr><td>ע��ʱ��</td><td><?=$userdb[regdate]?></td></tr>
<tr><td>����¼</td><td><?=$userdb[lastlogin]?></td></tr>
</table>
<? } elseif($action=='modify') { ?>
<form action="profile.php?" method="post" onSubmit="return procheck(this)" name="creator" enctype="multipart/form-data">
<input type="hidden" name="action" value="modify" />
<input type="hidden" value="2" name="step" />
<table class="table table_w960">

<tr><th colspan="2">
<img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absmiddle"> <a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; �޸�����
</th></tr>

<tr>
<td class="w40"><strong>ԭ����</strong></td>
<td><input type="password" name="oldpwd" value="" class="text" /></td>
</tr>

<tr>
<td><strong>������</strong></td>
<td><input type="password" name="propwd" value="" class="text" onchange="checkpwd();" />&nbsp;<span id="pwd_info"></span></td>
</tr>

<tr>
<td><strong>ȷ������</strong></td>
<td><input type="password" name="check_pwd" value="" class="text" onchange="checkpwdrepeat();" />&nbsp;<span id="pwdrepeat_info"></span></td>
</tr>

<tr>
<td><strong>E-Mail</strong></td>
<td><input type="text" name="proemail" value="<?=$user[email]?>" class="text" onchange="checkemail();" />&nbsp;<span id="email_info"></span>
<input type="checkbox" name="propublicemail" value="1" <?=$ifchecked?> />��������</td>
</tr>

<tr>
<td><strong>�Ա�</strong></td>
<td>
<select name="progender">
<option value="1" <?=$sexselect[1]?>>˧��</option>
<option value="2" <?=$sexselect[2]?>>��Ů</option>
<option value="0" <?=$sexselect[0]?>>����</option>
</select>
</td>
</tr>

<tr>
<td><strong>����</strong></td>
<td>
<select name="proyear">
<option value=""></option><? for($i=1960;$i<=2008;$i++){ ?><option value="<?=$i?>" <?=$yearslect[$i]?>><?=$i?></option><? } ?></select>�� 
<select name="promonth">
<option value=""></option><? for($i=1;$i<=12;$i++){ ?><option value="<?=$i?>" <?=$monthslect[$i]?>><?=$i?></option><? } ?></select>�� 
<select name="proday">
<option value=""></option><? for($i=1;$i<=31;$i++){ ?><option value="<?=$i?>" <?=$dayslect[$i]?>><?=$i?></option>  <? } ?></select>��
</td>
</tr>

<? if($gp_allowhonor=='1') { ?>
<!--	<tr>
<td><strong>�Զ���ͷ��</strong></td>
<td><input type="text" class="text" name="prohonor" value="<?=$user[honor]?>"/></td>
</tr>-->
<? } ?>
<tr>
<td><strong>ѡ������ͷ��</strong></td>
<td>
<img src="<?=$user[icon]?>" name="useravatars" width="100" height="120"/>
<select name="proicon" onChange="showimage('<?=$imgpath?>',this.options[this.selectedIndex].value)">
<option value="none.gif">none.gif</option>
<?=$imgselect?>
</select>
<br />
<? if($delicon=='1') { ?>
<a href="profile.php?action=delicon">[ɾ���Զ���ͷ��]</a>
<? } if($gp_allowseticon=='1') { ?>
<br />
ͷ��λ�� <input type="text" class="text" name="iconurl" value="<?=$iconurl?>" /> ������ http://��ͷ��·���� 

<? if($db_iconupload=='1' && $gp_allowupicon=='1') { ?>
<br />
ͷ���ϴ� <input type=file name="upicon" class="text" />
<? } } ?>
</td>
</tr>

<tr>
        <td class="w40"><strong>������/ѧУ</strong></td>
        <td>
            <select name="school">
                <?=$class_opt?>
            </select>
        </td>
    </tr>
<!--	<tr>
<td><strong>��</strong></td>
<td><input type="text" class="text" name="proregion" readonly="readonly" value="<?=$user[region]?>"/></td>
</tr>

<tr>
<td><strong>ѧУ</strong></td>
<td><input type="text" class="text" name="proschool" readonly="readonly" value="<?=$user[school]?>"/></td>
</tr>-->

<tr>
<td><strong>������ҳ</strong></td>
<td><input type="text" class="text" name="prosite" value="<?=$user[site]?>"/></td>
</tr>

<tr>
<td><strong>����ǩ��</strong><br /><?=$rg_regmaxsign?>�ֽ�����</td>
<td><textarea name="prosign" cols="50" rows="5"><?=$user[signature]?></textarea></td>
</tr>

<tr>
<td><strong>�Ƿ����ϵͳ�ʼ�</strong></td>
<td>
<input type=radio value="1" name="proreceivemail" <?=$email_open?>> �����ʼ� 
<input type=radio value="2" name="proreceivemail" <?=$email_close?>> �������ʼ�
</td>
</tr>

</table>
<br /><center><input type="submit" name="prosubmit" value="�� ��" class="button"/><center>
</form><br />
<? } elseif($action=='myvideo') { ?>
<hr />
<table class="table table_w960">
<tr><th colspan="8">
<img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absmiddle"> <a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; �ҵ���Ƶ
</th></tr>

<tr class="caption">
<td width="10%">ID</td>
<td width="25%">����</td>
<td width="15%">��Ա</td>
<td width="15%">����ʱ��</td>
<td width="5%">����</td>
<td width="5%">����</td>
<td width="10%">���</td>
<td width="15%">����</td>
</tr><? if(is_array($searchdb)) { foreach($searchdb as $value) { ?><tr class="text_center">
<td><?=$value[vid]?></td>
<td><a href="read.php?vid=<?=$value[vid]?>" target="_blank"><?=$value[subject]?></a></td>
<td><?=$value[author]?></td>
<td><?=$value[lostdate]?></td>
<td><?=$value[hits]?></td>
<td><?=$value[replier]?></td>
<td><?=$value[yz]?></td>
<td>
<a href="read.php?vid=<?=$value[vid]?>" target="_blank">���</a>
<a href="post.php?action=modify&vid=<?=$value[vid]?>">�༭</a>
<?=$value[del]?>		
</td>
</tr><? } } ?></table>
<div class="page"><?=$pages?></div>
<? } ?>
<script language="JavaScript1.2">
function procheck(formct)
{
if (formct.prosign.value.length><?=$rg_regmaxsign?>)
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
var pwd = document.getElementById("propwd").value;
var pwdrepeat = document.getElementById("check_pwd").value;
if (pwd.length<6){
document.getElementById("pwd_info").innerHTML = "<span style=\"color: red;\">����̫�٣�����6λ����</span>";
} else{
document.getElementById("pwd_info").innerHTML = "";
}
if(pwdrepeat){
checkpwdrepeat();
}
}
function checkpwdrepeat(){
var pwd = document.getElementById("propwd").value;
var pwdrepeat = document.getElementById("check_pwd").value;
if (pwdrepeat==pwd){
document.getElementById("pwdrepeat_info").innerHTML = "";
} else{
document.getElementById("pwdrepeat_info").innerHTML = "<span style=\"color: red;\">������������벻һ�£���������ԡ�</span>";
}
}
function checkemail(){
var email = document.getElementById("proemail").value;
var myReg = /^[-a-zA-Z0-9_\.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$/; 
if(myReg.test(email)){
document.getElementById("email_info").innerHTML = "";
} else{
document.getElementById("email_info").innerHTML = "<span style=\"color: red;\">Email ��ʽ����!</span>";
}
}
</script>