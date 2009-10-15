<? include_once PrintEot("hack_top"); ?><table width="98%" align=center cellspacing=1 cellpadding=3 class=tableborder>
<tr><td class=header colspan=2>提示信息</td></tr>
<tr><td class=bg style="padding: 20px; line-height: 1em;">说明：可以添加与编辑勋章。</td></tr>
</table>
<br />
<? if(empty($action)) { ?>
<table width=98% align=center cellspacing=1 cellpadding=3 class=tableborder>
<tr>
<td class=bg>
[<strong><a href="<?=$basename?>">勋章设置</a></strong>]
[<a href="<?=$basename?>&action=edit">勋章编辑</a>]
[<a href="<?=$basename?>&action=add">添加勋章</a>]
</td>
</tr>
</table>
<br>

<form action="<?=$basename?>" method="post">
<input type=hidden name="step" value="2">

<table width=98% align="center" cellpadding=3 cellspacing=1 class=tableborder>
<tr class="header"><td colspan="2">勋章设置</td></tr>
<tr class=bg>
<td width="30%">是否开启勋章功能<br>(需要到插件中心启用该插件方为有效)</td>
<td>
<input type="radio" value="1" name="config[md_ifopen]" <?=$ifopen_Y?>> 是 
<input type="radio" value="0" name="config[md_ifopen]" <?=$ifopen_N?>> 否
</td>
</tr>

<tr class=bg>
<td>颁发(摘除)勋章是否短消息通知用户</td>
<td>
<input type="radio" value="1" name="config[md_ifmsg]" <?=$ifmsg_Y?>> 是 
<input type="radio" value="0" name="config[md_ifmsg]" <?=$ifmsg_N?>> 否
</td>
</tr>

<tr class=bg>
<td>颁发(摘除)勋章用户组权限</td>
<td>
<table cellspacing='0' cellpadding='0' border='0' width='100%' align='center'>
<tr><? if(is_array($ltitle)) { foreach($ltitle as $key => $value) { if($key==1 || $key==2) { continue; } $num++; $htm_tr = $num % 4 == 0 ? '</tr><tr>' : ''; $g_ck=strpos($md_groups,",$key,")!==false ? 'checked' : ''; ?><td><input type='checkbox' name='groups[]' value='<?=$key?>' <?=$g_ck?>><?=$value?></td>
<?=$htm_tr?><? } } ?></tr></table>
</td>
</tr>
</table>
<br>
<center><input type=submit value="提 交"></center>
</form>
<br>
<? } elseif($action=='edit') { ?>
<table width=98% align=center cellspacing=1 cellpadding=3 class=tableborder>
<tr>
<td class=bg>
[<a href="<?=$basename?>">勋章设置</a>]
[<a href="<?=$basename?>&action=edit"><strong>勋章编辑</strong></a>]
[<a href="<?=$basename?>&action=add">添加勋章</a>]
</td>
</tr>
</table>
<br>

<form action="<?=$basename?>&action=edit&" method="post">
<input type="hidden" name="step" value="2">
<table width="98%" cellpadding=3 cellspacing=1 class="tableborder" align="center">
<tr class=header><td colspan=6>勋章编辑</td></tr>
<tr align="center">
<td width="5%">ID</td>
<td width="15%">勋章名称</td>
<td width="*">勋章说明</td>
<td width="15%">图片名称</td>
<td width="15%">勋章图片</td>
<td width="6%">删除</td>
</tr><? if(is_array($medaldb)) { foreach($medaldb as $key => $value) { $id=$value['id'] ?><tr class="bg" align="center">
<td><?=$id?></td>
<td><input type="text" name="medal[<?=$id?>][name]" value="<?=$value['name']?>"></td>
<td><input type="text" name="medal[<?=$id?>][intro]" value="<?=$value['intro']?>" size="50"></td>
<td><input type="text" name="medal[<?=$id?>][picurl]" value="<?=$value['picurl']?>"></td>
<td><img src="<?=$imgpath?>/medal/<?=$value['picurl']?>"></td>
<td><a href="<?=$basename?>&action=del&id=<?=$id?>">删除</a></td>
</tr><? } } ?></table>
<br>
<center><input type="submit" value="提 交"></center>
</form>
<? } elseif($action=='add') { ?>
<table width=98% align=center cellspacing=1 cellpadding=3 class=tableborder>
<tr>
<td class=bg>
[<a href="<?=$basename?>">勋章设置</a>]
[<a href="<?=$basename?>&action=edit">勋章编辑</a>]
[<a href="<?=$basename?>&action=add"><strong>添加勋章</strong></a>]
</td>
</tr>
</table>
<br>
<form action="<?=$basename?>&action=add&" method="post">
<input type=hidden name="step" value="2">
<table width=98% align="center" cellpadding=3 cellspacing=1 class=tableborder>
<tr class="header"><td colspan="2">添加勋章</td></tr>
<tr class=bg>
<td width="30%">勋章名称</td>
<td><input type="text" name="newname"></td>
</tr>
<tr class=bg>
<td>勋章说明</td>
<td><input type="text" name="newintro"></td>
</tr>
<tr class=bg>
<td>图片名称</td>
<td><input type="text" name="newpicurl"></td>
</tr>
</table>
<br>
<center><input type="submit" value="提 交"></center>
</form>
<? } include_once PrintEot("hack_bottom"); ?>