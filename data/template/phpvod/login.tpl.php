<hr />
<form action="login.php" method="post" name="login">
<input type="hidden" value="2" name="step" />
<table class="table table_w960">
<tr><th colspan="2">
<img src="<?=$imgpath?>/<?=$stylepath?>/index/home_menu.gif" align="absmiddle"> 
<a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; 会员登录
</th></tr>
<? if($logingd) { ?>
<tr>
<td><strong>认证码</strong></td>
<td>
<img src="ck.php" align="absmiddle" onclick="this.src='ck.php'" style="cursor: pointer;" />
<input type="text" maxLength="4" class="text" name="gdcode" size="4" /> 如果看不清验证码，请点图片刷新
</td>
</tr>
<? } ?>

<tr>
<td class="w40"><strong>用户名</strong></td>
<td><input type="text" name="username" class="text" /></td>
</tr>

<tr>
<td><strong>密码</strong></td>
<td><input type="password" name="password" class="text" /></td>
</tr>

<tr>
<td><strong>Cookie 有效期</strong></td>
<td>
<input type="radio" name="cktime" value="31536000" checked /> 一年
<input type="radio" name="cktime" value="2592000" /> 一个月
<input type="radio" name="cktime" value="86400" /> 一天
<input type="radio" name="cktime" value="3600" /> 一小时
<input type="radio" name="cktime" value="0" /> 即时
</td>
</tr>
</table>
<br /><center><input name="submit" type="submit" value="登 录" class="button" /></center>
</form>
<br />
