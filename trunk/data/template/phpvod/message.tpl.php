<hr />
<table class="table table_w960">
<tr><th colspan="4"><img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absmiddle"> <a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; 短消息</th></tr>
<tr class="text_center">
<td><a href="message.php?action=write">写新消息</a> </td>
<td><a href="message.php">收件箱</a></td>
<td><a href="message.php?action=sendbox">发件箱</a></td>
<td><a href="message.php?action=clear" onclick="return checkset();">清空</a></td>
</tr>
</table>
<? if($action=='receivebox') { ?>
<form action="message.php" method="post">
<input type="hidden" name="action" value="del" />
<table class="table table_w960">
<tr>
<th colspan="6">收件箱〔信箱状态：目前有短消息 <?=$msgcount?> 条；最多可存消息 <?=$gp_maxmsg?> 条；使用率 <?=$contl?>%〕</th>
</tr>

<tr class="caption">
<td width="6%">ID</td>
<td>标题</td>
<td width="10%">发件人</td>
<td width="20%">时间</td>
<td width="7%">已读</td>
<td width="7%">删除</td>		
</tr><? if(is_array($msgdb)) { foreach($msgdb as $key => $value) { $key++; ?><tr align="center">
<td><?=$key?></td>
<td><a href="message.php?action=read&mid=<?=$value[mid]?>"><?=$value[title]?></a></td>
<td><?=$value[username]?></td>
<td><?=$value[mdate]?></td>
<td>
<? if($value['ifnew']) { ?>
<span style="color:#FF0000">否</span>
<? } else { ?>
是
<? } ?>
</td>
<td><input type="checkbox" name="delid[]" value="<?=$value[mid]?>" /></td>
</tr><? } } ?></table><br />
<center>
<input type="button" name="chkall" value="全 选" class="button" onclick="CheckAll(this.form)" />
<input type="submit" value="提 交" class="button" />
</center>
</form><br />
<? } elseif($action=='sendbox') { ?>
<form action="message.php" method="post">
<input type="hidden" name="action" value="del" />
<table class="table table_w960">
<tr>
<th colspan="5">发件箱</th>
</tr>

<tr class="caption">
<td width="6%">ID</td>
<td>标题</td>
<td width="10%">收件人</td>
<td width="20%">时间</td>
<td width="7%">删除</td>
</tr><? if(is_array($msgdb)) { foreach($msgdb as $key => $value) { $key++; ?><tr align="center">
<td><?=$key?></td>
<td><a href="message.php?action=read&mid=<?=$value[mid]?>"><?=$value[title]?></a></td>
<td><?=$value[touser]?></td>
<td><?=$value[mdate]?></td>
<td><input type="checkbox" name="delid[]" value="<?=$value[mid]?>" /></td>
</tr><? } } ?></table><br />
<center>
<input type="button" name="chkall" value="全 选" class="button" onclick="CheckAll(this.form)" />
<input type="submit" value="提 交" class="button" />
</center>
</form><br />
<? } elseif($action=='write') { ?>
<form action="message.php?action=write" method="post">
<input type="hidden" name="step" value="2" />
<input type="hidden" name="mdate" value="<?=$timestamp?>" />

<table class="table table_w960">
<tr>
<th colspan="2">写新消息</th>
</tr>

<tr>
<td class="w40">用户名</td>
<td><input type="text" name="msg_user" maxlength="100" class="text" value="<?=$msgid?>"/></td>
</tr>

<tr>
<td>标题</td>
<td><input type="text" name="msg_title" maxlength="75" class="text" value="<?=$subject?>" /></td>
</tr>
<? if($msggd) { ?>
<tr>
<td>认证码</td>
<td><input type="text" name="gdcode" maxlength="4" size="8" class="text" />&nbsp;<img src="ck.php?" align="absmiddle" onclick="this.src='ck.php?'" /></td>
</tr>
<? } ?>
<tr>
<td>内容</td>
<td><textarea name="atc_content" id="atc_content" cols="90" rows="10" style="overflow:auto;" class="textarea"><?=$atc_content?></textarea></td>
</tr>

<tr>
<td>&nbsp;</td>
<td><input type="checkbox" name="ifsave" value="1" />保存到发件箱</td>
</tr>
</table>

<center><input type="submit" value="提 交" name="Submit" class="button" /></center>
</form><br />
<? } elseif($action=='read') { ?>
<table class="table table_w960">
<tr>
<th colspan="2">阅读短消息</th>
</tr>
<tr>
<td class="w30">用户名</td>
<td><?=$msginfo[username]?></td>
</tr>
<tr>
<td>标题</td>
<td><?=$msginfo[title]?></td>
</tr>
<tr>
<td>时间</td>
<td><?=$msginfo[mdate]?></td>
</tr>
<tr>
<td>内容</td>
<td><?=$msginfo[content]?></td>
</tr>
<tr>
<td>操作</td>
<td>
<a href="message.php?action=write&remid=<?=$msginfo[mid]?>">回复</a>
<a href="message.php?action=del&mid=<?=$msginfo[mid]?>">删除</a>	
</td>
</tr>
</table><br />
<center><input type="button" value="返 回" class="button" onclick="javascript:history.go(-1);"></center><br />
<? } ?>
<script language="JavaScript">
function checkset()
{
if(confirm("将删除收件箱和发件箱内所有消息，请确认！")){
return true;
} else {
return false;
}
}
</script>
