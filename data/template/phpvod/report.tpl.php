<hr />
<form action="report.php" method="post">
<input type="hidden" value="2" name="step" />
<input type="hidden" name="vid" value="<?=$vid?>">
<table class="table table_w960">
<tr>
<th colspan="2">
<img src="<?=$imgpath?>/<?=$stylepath?>/index/home_menu.gif" align="absmiddle"> 
<a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; �ٱ���Ƶ
</th>
</tr>
<tr>
<td class="w40">����Ϊ</td>
<td>
<select name="type">
<option value="����ʧЧ">����ʧЧ</option>
<option value="Υ����Ƶ">Υ����Ƶ</option>
<option value="����ԭ��">����ԭ��</option>
</select>
</td>
</tr>
<tr>
<td>ԭ��</td>
<td><textarea name="reason" cols="60" rows="6"></textarea></td>
</tr>
</table><br />
<center><input type="submit" value='�� ��' class="button"></center>
</form>