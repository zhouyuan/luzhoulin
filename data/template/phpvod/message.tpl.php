<hr />
<table class="table table_w960">
<tr><th colspan="4"><img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absmiddle"> <a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; ����Ϣ</th></tr>
<tr class="text_center">
<td><a href="message.php?action=write">д����Ϣ</a> </td>
<td><a href="message.php">�ռ���</a></td>
<td><a href="message.php?action=sendbox">������</a></td>
<td><a href="message.php?action=clear" onclick="return checkset();">���</a></td>
</tr>
</table>
<? if($action=='receivebox') { ?>
<form action="message.php" method="post">
<input type="hidden" name="action" value="del" />
<table class="table table_w960">
<tr>
<th colspan="6">�ռ��䡲����״̬��Ŀǰ�ж���Ϣ <?=$msgcount?> �������ɴ���Ϣ <?=$gp_maxmsg?> ����ʹ���� <?=$contl?>%��</th>
</tr>

<tr class="caption">
<td width="6%">ID</td>
<td>����</td>
<td width="10%">������</td>
<td width="20%">ʱ��</td>
<td width="7%">�Ѷ�</td>
<td width="7%">ɾ��</td>		
</tr><? if(is_array($msgdb)) { foreach($msgdb as $key => $value) { $key++; ?><tr align="center">
<td><?=$key?></td>
<td><a href="message.php?action=read&mid=<?=$value[mid]?>"><?=$value[title]?></a></td>
<td><?=$value[username]?></td>
<td><?=$value[mdate]?></td>
<td>
<? if($value['ifnew']) { ?>
<span style="color:#FF0000">��</span>
<? } else { ?>
��
<? } ?>
</td>
<td><input type="checkbox" name="delid[]" value="<?=$value[mid]?>" /></td>
</tr><? } } ?></table><br />
<center>
<input type="button" name="chkall" value="ȫ ѡ" class="button" onclick="CheckAll(this.form)" />
<input type="submit" value="�� ��" class="button" />
</center>
</form><br />
<? } elseif($action=='sendbox') { ?>
<form action="message.php" method="post">
<input type="hidden" name="action" value="del" />
<table class="table table_w960">
<tr>
<th colspan="5">������</th>
</tr>

<tr class="caption">
<td width="6%">ID</td>
<td>����</td>
<td width="10%">�ռ���</td>
<td width="20%">ʱ��</td>
<td width="7%">ɾ��</td>
</tr><? if(is_array($msgdb)) { foreach($msgdb as $key => $value) { $key++; ?><tr align="center">
<td><?=$key?></td>
<td><a href="message.php?action=read&mid=<?=$value[mid]?>"><?=$value[title]?></a></td>
<td><?=$value[touser]?></td>
<td><?=$value[mdate]?></td>
<td><input type="checkbox" name="delid[]" value="<?=$value[mid]?>" /></td>
</tr><? } } ?></table><br />
<center>
<input type="button" name="chkall" value="ȫ ѡ" class="button" onclick="CheckAll(this.form)" />
<input type="submit" value="�� ��" class="button" />
</center>
</form><br />
<? } elseif($action=='write') { ?>
<form action="message.php?action=write" method="post">
<input type="hidden" name="step" value="2" />
<input type="hidden" name="mdate" value="<?=$timestamp?>" />

<table class="table table_w960">
<tr>
<th colspan="2">д����Ϣ</th>
</tr>

<tr>
<td class="w40">�û���</td>
<td><input type="text" name="msg_user" maxlength="100" class="text" value="<?=$msgid?>"/></td>
</tr>

<tr>
<td>����</td>
<td><input type="text" name="msg_title" maxlength="75" class="text" value="<?=$subject?>" /></td>
</tr>
<? if($msggd) { ?>
<tr>
<td>��֤��</td>
<td><input type="text" name="gdcode" maxlength="4" size="8" class="text" />&nbsp;<img src="ck.php?" align="absmiddle" onclick="this.src='ck.php?'" /></td>
</tr>
<? } ?>
<tr>
<td>����</td>
<td><textarea name="atc_content" id="atc_content" cols="90" rows="10" style="overflow:auto;" class="textarea"><?=$atc_content?></textarea></td>
</tr>

<tr>
<td>&nbsp;</td>
<td><input type="checkbox" name="ifsave" value="1" />���浽������</td>
</tr>
</table>

<center><input type="submit" value="�� ��" name="Submit" class="button" /></center>
</form><br />
<? } elseif($action=='read') { ?>
<table class="table table_w960">
<tr>
<th colspan="2">�Ķ�����Ϣ</th>
</tr>
<tr>
<td class="w30">�û���</td>
<td><?=$msginfo[username]?></td>
</tr>
<tr>
<td>����</td>
<td><?=$msginfo[title]?></td>
</tr>
<tr>
<td>ʱ��</td>
<td><?=$msginfo[mdate]?></td>
</tr>
<tr>
<td>����</td>
<td><?=$msginfo[content]?></td>
</tr>
<tr>
<td>����</td>
<td>
<a href="message.php?action=write&remid=<?=$msginfo[mid]?>">�ظ�</a>
<a href="message.php?action=del&mid=<?=$msginfo[mid]?>">ɾ��</a>	
</td>
</tr>
</table><br />
<center><input type="button" value="�� ��" class="button" onclick="javascript:history.go(-1);"></center><br />
<? } ?>
<script language="JavaScript">
function checkset()
{
if(confirm("��ɾ���ռ���ͷ�������������Ϣ����ȷ�ϣ�")){
return true;
} else {
return false;
}
}
</script>
