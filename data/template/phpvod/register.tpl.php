<hr />
<form action="register.php" method="post" onSubmit="return check(this)" name="register">
<input type="hidden" value="2" name="step" />
<table class="table table_w960">
<tr><th colspan="2">
<img src="<?=$imgpath?>/<?=$stylepath?>/index/home_menu.gif" align="absmiddle"> 
<a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; 新会员注册
</th></tr>
<? if($reggd) { ?>
<tr>
<td><strong>认证码<span style="color: red;">*</span></strong></td>
<td>
<img src="ck.php" align="absmiddle" onclick="this.src='ck.php'" style="cursor: pointer;" />
<input type="text" maxLength="4" class="text" name="gdcode" size="4" /> 如果看不清验证码，请点图片刷新
</td>
</tr>
<? } ?>
<tr>
<td class="w40">
<strong>用户名<span style="color: red;">*</span></strong><br />可以是中文，不能有空格，长度控制在 <?=$rg_regminname?> - <?=$rg_regmaxname?> 字节以内
</td>
<td><input type="text" class="text" name="regname" /></td>
</tr>

    <tr>
        <td class="w40"><strong>所属区/学校<span style="color:red;">*</span></strong></td>
        <td>
            <select name="cid">
                <?=$class_opt?>
            </select>
        </td>
    </tr>
    
<tr>
<td><strong>密码<span style="color: red;">*</span></strong><br />英文字母或数字等不少于6位</td>
<td><input type="password" class="text" name="regpwd" onchange="checkpwd();" />&nbsp;<span id="pwd_info"></span></td>
</tr>

<tr>
<td><strong>确认密码<span style="color: red;">*</span></strong></td>
<td><input type="password" class="text" name="regpwdrepeat" onchange="checkpwdrepeat();" />&nbsp;<span id="pwdrepeat_info"></span></td>
</tr>

<tr>
<td><strong>E-Mail<span style="color: red;">*</span></strong></td>
<td><input type="text" class="text" name="regemail" onchange="checkemail();" />&nbsp;<span id="email_info"></span> <input type="checkbox" name="regemailtoall" value="1" checked /> 公开邮箱</td>
</tr>
<? if($rg_regdetail) { ?>
<tr>
<td><strong>性别</strong></td>
<td>
<select name="regsex">
<option value="1">男生</option>
<option value="2">女生</option>
<option value="0" selected>保密</option>
</select>
</td>
</tr>

<tr>
<td><strong>生日</strong></td>
<td>
<select name="regbirthyear">
<option value=""></option><? for($i=1960;$i<=2008;$i++){ ?><option value="<?=$i?>"><?=$i?></option><? } ?></select>年 
<select name="regbirthmonth">
<option value=""></option><? for($i=1;$i<=12;$i++){ ?><option value="<?=$i?>"><?=$i?></option><? } ?></select>月 
<select name="regbirthday">
<option value=""></option><? for($i=1;$i<=31;$i++){ ?><option value="<?=$i?>"><?=$i?></option>  <? } ?></select>日
</td>
</tr>

<!--	<tr>
<td><strong>自定义头衔</strong></td>
<td><input type="text" class="text" name="honor" /></td>
</tr>-->

<tr>
<td><strong>选择您的头像</strong></td>
<td>
<img src="<?=$imgpath?>/face/none.gif" name="useravatars" />
<select name="regicon" onChange="showimage('<?=$imgpath?>',this.options[this.selectedIndex].value)">
<option value="none.gif">none.gif</option>
<?=$imgselect?>
</select>

</td>
</tr>

<!--	<tr>
<td><strong>区</strong></td>
<td><input type="text" class="text" name="region" /></td>
</tr>

<tr>
<td><strong>学校</strong></td>
<td><input type="text" class="text" name="school" /></td>
</tr>-->

<tr>
<td><strong>个人主页</strong></td>
<td><input type="text" class="text" name="site" /></td>
</tr>

<tr>
<td><strong>个性签名</strong><br /><?=$rg_regmaxsign?>字节以内</td>
<td><textarea name="regsign" cols="50" rows="5"></textarea></td>
</tr>

<tr>
<td><strong>是否接收系统邮件</strong></td>
<td>
<input type=radio value="1" name="regifemail" CHECKED> 接收邮件 
<input type=radio value="2" name="regifemail"> 不接收邮件
</td>
</tr>
<? } ?>
</table>
<br /><center><input name="regsubmit" type="submit" value="提 交" class="button"/></center>
</form>
<br />

<script language="JavaScript" type="text/javascript">
<!--
function check(formct)
{
if (formct.regsign.value.length><?=$rg_regmaxsign?>)
{
alert('个性签名太长，请在<?=$rg_regmaxsign?>字节以内');
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
document.getElementById("pwd_info").innerHTML = "<span style=\"color: red;\">密码太少，请用6位以上。</span>";
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
document.getElementById("pwdrepeat_info").innerHTML = "<span style=\"color: red;\">两次输入的密码不一致，请检查后重试。</span>";
}
}
function checkemail(){
var email = document.getElementById("regemail").value;
var myReg = /^[-a-zA-Z0-9_\.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$/; 
if(myReg.test(email)){
document.getElementById("email_info").innerHTML = "";
} else{
document.getElementById("email_info").innerHTML = "<span style=\"color: red;\">Email 格式错误!</span>";
}
}
//-->
</script>
