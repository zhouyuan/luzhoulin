<hr />
<form action="login.php" method="post" name="login">
<input type="hidden" value="2" name="step" />
<table class="table table_w960">
<tr><th colspan="2">
<img src="<?=$imgpath?>/<?=$stylepath?>/index/home_menu.gif" align="absmiddle"> 
<a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; ��Ա��¼
</th></tr>
<? if($logingd) { ?>
<tr>
<td><strong>��֤��</strong></td>
<td>
<img src="ck.php" align="absmiddle" onclick="this.src='ck.php'" style="cursor: pointer;" />
<input type="text" maxLength="4" class="text" name="gdcode" size="4" /> �����������֤�룬���ͼƬˢ��
</td>
</tr>
<? } ?>

<tr>
<td class="w40"><strong>�û���</strong></td>
<td><input type="text" name="username" class="text" /></td>
</tr>

<tr>
<td><strong>����</strong></td>
<td><input type="password" name="password" class="text" /></td>
</tr>

<tr>
<td><strong>Cookie ��Ч��</strong></td>
<td>
<input type="radio" name="cktime" value="31536000" checked /> һ��
<input type="radio" name="cktime" value="2592000" /> һ����
<input type="radio" name="cktime" value="86400" /> һ��
<input type="radio" name="cktime" value="3600" /> һСʱ
<input type="radio" name="cktime" value="0" /> ��ʱ
</td>
</tr>
</table>
<br /><center><input name="submit" type="submit" value="�� ¼" class="button" /></center>
</form>
<br />