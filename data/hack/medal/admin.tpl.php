<? include_once PrintEot("hack_top"); ?><table width="98%" align=center cellspacing=1 cellpadding=3 class=tableborder>
<tr><td class=header colspan=2>��ʾ��Ϣ</td></tr>
<tr><td class=bg style="padding: 20px; line-height: 1em;">˵�������������༭ѫ�¡�</td></tr>
</table>
<br />
<? if(empty($action)) { ?>
<table width=98% align=center cellspacing=1 cellpadding=3 class=tableborder>
<tr>
<td class=bg>
[<strong><a href="<?=$basename?>">ѫ������</a></strong>]
[<a href="<?=$basename?>&action=edit">ѫ�±༭</a>]
[<a href="<?=$basename?>&action=add">���ѫ��</a>]
</td>
</tr>
</table>
<br>

<form action="<?=$basename?>" method="post">
<input type=hidden name="step" value="2">

<table width=98% align="center" cellpadding=3 cellspacing=1 class=tableborder>
<tr class="header"><td colspan="2">ѫ������</td></tr>
<tr class=bg>
<td width="30%">�Ƿ���ѫ�¹���<br>(��Ҫ������������øò����Ϊ��Ч)</td>
<td>
<input type="radio" value="1" name="config[md_ifopen]" <?=$ifopen_Y?>> �� 
<input type="radio" value="0" name="config[md_ifopen]" <?=$ifopen_N?>> ��
</td>
</tr>

<tr class=bg>
<td>�䷢(ժ��)ѫ���Ƿ����Ϣ֪ͨ�û�</td>
<td>
<input type="radio" value="1" name="config[md_ifmsg]" <?=$ifmsg_Y?>> �� 
<input type="radio" value="0" name="config[md_ifmsg]" <?=$ifmsg_N?>> ��
</td>
</tr>

<tr class=bg>
<td>�䷢(ժ��)ѫ���û���Ȩ��</td>
<td>
<table cellspacing='0' cellpadding='0' border='0' width='100%' align='center'>
<tr><? if(is_array($ltitle)) { foreach($ltitle as $key => $value) { if($key==1 || $key==2) { continue; } $num++; $htm_tr = $num % 4 == 0 ? '</tr><tr>' : ''; $g_ck=strpos($md_groups,",$key,")!==false ? 'checked' : ''; ?><td><input type='checkbox' name='groups[]' value='<?=$key?>' <?=$g_ck?>><?=$value?></td>
<?=$htm_tr?><? } } ?></tr></table>
</td>
</tr>
</table>
<br>
<center><input type=submit value="�� ��"></center>
</form>
<br>
<? } elseif($action=='edit') { ?>
<table width=98% align=center cellspacing=1 cellpadding=3 class=tableborder>
<tr>
<td class=bg>
[<a href="<?=$basename?>">ѫ������</a>]
[<a href="<?=$basename?>&action=edit"><strong>ѫ�±༭</strong></a>]
[<a href="<?=$basename?>&action=add">���ѫ��</a>]
</td>
</tr>
</table>
<br>

<form action="<?=$basename?>&action=edit&" method="post">
<input type="hidden" name="step" value="2">
<table width="98%" cellpadding=3 cellspacing=1 class="tableborder" align="center">
<tr class=header><td colspan=6>ѫ�±༭</td></tr>
<tr align="center">
<td width="5%">ID</td>
<td width="15%">ѫ������</td>
<td width="*">ѫ��˵��</td>
<td width="15%">ͼƬ����</td>
<td width="15%">ѫ��ͼƬ</td>
<td width="6%">ɾ��</td>
</tr><? if(is_array($medaldb)) { foreach($medaldb as $key => $value) { $id=$value['id'] ?><tr class="bg" align="center">
<td><?=$id?></td>
<td><input type="text" name="medal[<?=$id?>][name]" value="<?=$value['name']?>"></td>
<td><input type="text" name="medal[<?=$id?>][intro]" value="<?=$value['intro']?>" size="50"></td>
<td><input type="text" name="medal[<?=$id?>][picurl]" value="<?=$value['picurl']?>"></td>
<td><img src="<?=$imgpath?>/medal/<?=$value['picurl']?>"></td>
<td><a href="<?=$basename?>&action=del&id=<?=$id?>">ɾ��</a></td>
</tr><? } } ?></table>
<br>
<center><input type="submit" value="�� ��"></center>
</form>
<? } elseif($action=='add') { ?>
<table width=98% align=center cellspacing=1 cellpadding=3 class=tableborder>
<tr>
<td class=bg>
[<a href="<?=$basename?>">ѫ������</a>]
[<a href="<?=$basename?>&action=edit">ѫ�±༭</a>]
[<a href="<?=$basename?>&action=add"><strong>���ѫ��</strong></a>]
</td>
</tr>
</table>
<br>
<form action="<?=$basename?>&action=add&" method="post">
<input type=hidden name="step" value="2">
<table width=98% align="center" cellpadding=3 cellspacing=1 class=tableborder>
<tr class="header"><td colspan="2">���ѫ��</td></tr>
<tr class=bg>
<td width="30%">ѫ������</td>
<td><input type="text" name="newname"></td>
</tr>
<tr class=bg>
<td>ѫ��˵��</td>
<td><input type="text" name="newintro"></td>
</tr>
<tr class=bg>
<td>ͼƬ����</td>
<td><input type="text" name="newpicurl"></td>
</tr>
</table>
<br>
<center><input type="submit" value="�� ��"></center>
</form>
<? } include_once PrintEot("hack_bottom"); ?>