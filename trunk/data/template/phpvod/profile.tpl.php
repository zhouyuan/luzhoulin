<hr />
<? if($action!='show' || $userdb[uid]==$uid) { ?>
<table class="table table_w960">
<tr><th colspan="3"><img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absmiddle"> <a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; 个人资料</th></tr>
<tr class="text_center">
<td><a href="profile.php?action=show&id=<?=$uid?>">我的资料</a></td>
<td><a href="profile.php?action=modify">修改资料</a></td>
<td><a href="profile.php?action=myvideo">我的视频</a></td>
</tr>
</table>
<? } if($action=='show') { ?>
<table class="table table_w960">
<tr><th colspan="2">
<img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absmiddle"> <a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; 个人资料
</th></tr>
<tr><td class="w40">UID</td><td><?=$userdb[uid]?></td></tr>
<tr><td>用户名</td><td><?=$userdb[username]?></td></tr>
   	<tr><td>区</td><td><?=$userdb[region]?></td></tr>
<tr><td>学校</td><td><?=$userdb[school]?></td></tr>
<tr><td>会员头衔</td><td><?=$userdb[membertitle]?></td></tr>
    <tr><td>最后登录IP</td><td><?=$userdb[ip]?></td></tr>
<!--	<tr><td>自定义头衔</td><td><?=$userdb[honor]?></td></tr>-->
<!--	<tr><td>系统头衔</td><td><?=$userdb[grouptitle]?></td></tr>-->
<!--	<tr><td>综合积分</td><td><?=$userdb[credit]?></td></tr>
<tr><td>视频数</td><td><?=$userdb[postnum]?></td></tr>
<tr><td>威望</td><td><?=$userdb[rvrc]?></td></tr>
<tr><td>金钱</td><td><?=$userdb[money]?></td></tr>-->

<tr><td>头像</td><td><img src="<?=$userdb[icon]?>" width="100" height="120" /></td></tr>
<tr><td>Email</td><td><?=$userdb[email]?></td></tr>
<tr><td>性别</td><td><?=$userdb[gender]?></td></tr>
<tr><td>生日</td><td><?=$userdb[bday]?></td></tr>
<tr><td>个人主页</td><td><a href="http://<?=$userdb[site]?>" target="_blank"><?=$userdb[site]?></a></td></tr>
<tr><td>签名</td><td><?=$userdb[signature]?></td></tr>
<tr><td>注册时间</td><td><?=$userdb[regdate]?></td></tr>
<tr><td>最后登录</td><td><?=$userdb[lastlogin]?></td></tr>
</table>
<? } elseif($action=='modify') { ?>
<form action="profile.php?" method="post" onSubmit="return procheck(this)" name="creator" enctype="multipart/form-data">
<input type="hidden" name="action" value="modify" />
<input type="hidden" value="2" name="step" />
<table class="table table_w960">

<tr><th colspan="2">
<img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absmiddle"> <a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; 修改资料
</th></tr>

<tr>
<td class="w40"><strong>原密码</strong></td>
<td><input type="password" name="oldpwd" value="" class="text" /></td>
</tr>

<tr>
<td><strong>新密码</strong></td>
<td><input type="password" name="propwd" value="" class="text" onchange="checkpwd();" />&nbsp;<span id="pwd_info"></span></td>
</tr>

<tr>
<td><strong>确认密码</strong></td>
<td><input type="password" name="check_pwd" value="" class="text" onchange="checkpwdrepeat();" />&nbsp;<span id="pwdrepeat_info"></span></td>
</tr>

<tr>
<td><strong>E-Mail</strong></td>
<td><input type="text" name="proemail" value="<?=$user[email]?>" class="text" onchange="checkemail();" />&nbsp;<span id="email_info"></span>
<input type="checkbox" name="propublicemail" value="1" <?=$ifchecked?> />公开邮箱</td>
</tr>

<tr>
<td><strong>性别</strong></td>
<td>
<select name="progender">
<option value="1" <?=$sexselect[1]?>>帅哥</option>
<option value="2" <?=$sexselect[2]?>>靓女</option>
<option value="0" <?=$sexselect[0]?>>保密</option>
</select>
</td>
</tr>

<tr>
<td><strong>生日</strong></td>
<td>
<select name="proyear">
<option value=""></option><? for($i=1960;$i<=2008;$i++){ ?><option value="<?=$i?>" <?=$yearslect[$i]?>><?=$i?></option><? } ?></select>年 
<select name="promonth">
<option value=""></option><? for($i=1;$i<=12;$i++){ ?><option value="<?=$i?>" <?=$monthslect[$i]?>><?=$i?></option><? } ?></select>月 
<select name="proday">
<option value=""></option><? for($i=1;$i<=31;$i++){ ?><option value="<?=$i?>" <?=$dayslect[$i]?>><?=$i?></option>  <? } ?></select>日
</td>
</tr>

<? if($gp_allowhonor=='1') { ?>
<!--	<tr>
<td><strong>自定义头衔</strong></td>
<td><input type="text" class="text" name="prohonor" value="<?=$user[honor]?>"/></td>
</tr>-->
<? } ?>
<tr>
<td><strong>选择您的头像</strong></td>
<td>
<img src="<?=$user[icon]?>" name="useravatars" width="100" height="120"/>
<select name="proicon" onChange="showimage('<?=$imgpath?>',this.options[this.selectedIndex].value)">
<option value="none.gif">none.gif</option>
<?=$imgselect?>
</select>
<br />
<? if($delicon=='1') { ?>
<a href="profile.php?action=delicon">[删除自定义头像]</a>
<? } if($gp_allowseticon=='1') { ?>
<br />
头像位置 <input type="text" class="text" name="iconurl" value="<?=$iconurl?>" /> 必须以 http://开头的路径。 

<? if($db_iconupload=='1' && $gp_allowupicon=='1') { ?>
<br />
头像上传 <input type=file name="upicon" class="text" />
<? } } ?>
</td>
</tr>

<tr>
        <td class="w40"><strong>所属区/学校</strong></td>
        <td>
            <select name="school">
                <?=$class_opt?>
            </select>
        </td>
    </tr>
<!--	<tr>
<td><strong>区</strong></td>
<td><input type="text" class="text" name="proregion" readonly="readonly" value="<?=$user[region]?>"/></td>
</tr>

<tr>
<td><strong>学校</strong></td>
<td><input type="text" class="text" name="proschool" readonly="readonly" value="<?=$user[school]?>"/></td>
</tr>-->

<tr>
<td><strong>个人主页</strong></td>
<td><input type="text" class="text" name="prosite" value="<?=$user[site]?>"/></td>
</tr>

<tr>
<td><strong>个性签名</strong><br /><?=$rg_regmaxsign?>字节以内</td>
<td><textarea name="prosign" cols="50" rows="5"><?=$user[signature]?></textarea></td>
</tr>

<tr>
<td><strong>是否接收系统邮件</strong></td>
<td>
<input type=radio value="1" name="proreceivemail" <?=$email_open?>> 接收邮件 
<input type=radio value="2" name="proreceivemail" <?=$email_close?>> 不接收邮件
</td>
</tr>

</table>
<br /><center><input type="submit" name="prosubmit" value="提 交" class="button"/><center>
</form><br />
<? } elseif($action=='myvideo') { ?>
<hr />
<table class="table table_w960">
<tr><th colspan="8">
<img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absmiddle"> <a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; 我的视频
</th></tr>

<tr class="caption">
<td width="10%">ID</td>
<td width="25%">标题</td>
<td width="15%">会员</td>
<td width="15%">更新时间</td>
<td width="5%">人气</td>
<td width="5%">评论</td>
<td width="10%">审核</td>
<td width="15%">操作</td>
</tr><? if(is_array($searchdb)) { foreach($searchdb as $value) { ?><tr class="text_center">
<td><?=$value[vid]?></td>
<td><a href="read.php?vid=<?=$value[vid]?>" target="_blank"><?=$value[subject]?></a></td>
<td><?=$value[author]?></td>
<td><?=$value[lostdate]?></td>
<td><?=$value[hits]?></td>
<td><?=$value[replier]?></td>
<td><?=$value[yz]?></td>
<td>
<a href="read.php?vid=<?=$value[vid]?>" target="_blank">浏览</a>
<a href="post.php?action=modify&vid=<?=$value[vid]?>">编辑</a>
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
var pwd = document.getElementById("propwd").value;
var pwdrepeat = document.getElementById("check_pwd").value;
if (pwd.length<6){
document.getElementById("pwd_info").innerHTML = "<span style=\"color: red;\">密码太少，请用6位以上</span>";
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
document.getElementById("pwdrepeat_info").innerHTML = "<span style=\"color: red;\">两次输入的密码不一致，请检查后重试。</span>";
}
}
function checkemail(){
var email = document.getElementById("proemail").value;
var myReg = /^[-a-zA-Z0-9_\.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$/; 
if(myReg.test(email)){
document.getElementById("email_info").innerHTML = "";
} else{
document.getElementById("email_info").innerHTML = "<span style=\"color: red;\">Email 格式错误!</span>";
}
}
</script>
