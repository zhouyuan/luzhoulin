<hr />
<table class="table table_w960">
<tr>
<th>
<img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absbottom" /> 
<a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; 勋章中心
</th>
<th style="text-align: right; font-weight: normal;">
<a href="<?=$basename?>">勋章介绍</a> |
<a href="<?=$basename?>&action=list">获得勋章名单</a> |
<a href="<?=$basename?>&action=log">勋章颁发情况</a>
<? if(strpos($md_groups,",$groupid,")!==false) { ?>
| <a href="<?=$basename?>&action=award">颁发勋章</a>
<? } ?>
</th>
</tr>
<tr>
<td style="text-align:center" colspan="2">
<? if($userdb['medals']) { ?>
您获得的勋章<? if(is_array($userdb['medals'])) { foreach($userdb['medals'] as $key => $value) { if($medaldb[$value]['picurl']) { ?>
<img src="<?=$imgpath?>/medal/<?=$medaldb[$value]['picurl']?>" alt="<?=$medaldb[$value]['name']?>" /> 
<? } } } } else { ?>
您还没有勋章
<? } ?>
</td>
</tr>
</table>


<? if(!$action) { ?>
<table class="table table_w960">
<tr><th colspan="4">勋章介绍</th></tr>
<tr class="caption">
<td width="5%">ID</td>
<td width="15%">勋章名称</td>
<td width="*">勋章说明</td>
<td width="15%">勋章图片</td>
</tr><? $num=0; if(is_array($medaldb)) { foreach($medaldb as $key => $value) { $num++; ?><tr class="text_center">
<td><?=$num?></td>
<td><?=$value['name']?></td>
<td><?=$value['intro']?></td>
<td><img src="<?=$imgpath?>/medal/<?=$value['picurl']?>" /></td>
</tr><? } } ?></table>
<? } elseif($action=='list') { ?>
<table class="table table_w960">
<tr>
<th colspan="3">获得勋章名单</th>
</tr>
<tr class="caption text_center">
<td width="10%">ID</td>
<td width="20%">用户名</td>
<td width="70%">所获勋章</td>
</tr><? $num=($page-1)*$db_perpage; if(is_array($listdb)) { foreach($listdb as $key => $value) { $num++; ?><tr class="text_center">
<td><?=$num?></td>
<td><a href="profile.php?action=show&id=<?=$value['uid']?>" target="_blank"><?=$value['username']?></a></td>
<td><?=$value['medals']?></td>
</tr><? } } ?></table>
<div class="page"><?=$pages?></div>
<? } elseif($action=='award') { ?>
<form method="post" action="<?=$basename?>&action=award&">
<input type="hidden" name="step" value="2" />
<table class="table table_w960">
<tr><th colspan="2">颁发勋章</th></tr>
<tr>
<td class="w30">用户名: </td>
<td><input class="text" type="text" name="pvuser" size="40" /></td>
</tr>
<tr>
<td>选择操作: </td>
<td>
<input type="radio" name="type" value="1" checked /> 颁发
<input type="radio" name="type" value="2" /> 收回
</td>
</tr>
<tr>
<td>选择勋章: </td>
<td>
<select name="medal">
<option>选择勋章</option><? if(is_array($medaldb)) { foreach($medaldb as $key => $value) { ?><option value="<?=$key?>"><?=$value['name']?></option><? } } ?></select>
</td>
</tr>
<tr>
<td>有效期:</td>
<td>
<select name="timelimit">
<option value="0">永久</option>
</select>
</td>
</tr>
<tr>
<td>操作理由: </td>
<td><input class="text" type="text" name="reason" size="50" /></td>
</tr>
</table>
<center><input class="button" type="submit" value="提 交" /></center>
</form>
<? } elseif($action=='log') { ?>
<table class="table table_w960">
<tr><th colspan="9">勋章颁发情况</th></tr>
<tr class="caption">
<td width="3%">ID</td>
<td width="12%">用户名</td>
<td width="12%">管理员</td>
<td width="10%">勋章名称</td>
<td width="5%">操作</td>
<td><div style="table-layout:fixed;word-wrap:break-word;">操作原因</div></td>
<td width="15%">操作时间</td>
<td width="6%">有效期</td>
<? if($groupid==3) { ?>
<td width="5%">删除</td>
<? } ?>
</tr><? $num=($page-1)*$db_perpage; if(is_array($logdb)) { foreach($logdb as $key => $value) { $num++; ?><tr class="text_center">
<td><?=$num?></td>
<td><?=$value['awardee']?></td>
<td><?=$value['awarder']?></td>
<td><?=$medaldb[$value['level']]['name']?><br /></td>

<? if($value['action']==1) { ?>
<td>颁发</td>
<? } elseif($value['action']==2) { ?>
<td>收回</td>
<? } ?>
<td><?=$value['why']?><br /></td>
<td><?=$value['awardtime']?></td>
<? if($value['action']==1) { if($value['timelimit']<1) { ?>
<td>永久</td>
<? } else { ?>
<td><?=$value['timelimit']?> 个月</td>
<? } } else { ?>
<td>--</td>
<? } if($groupid==3) { if($value['action']==1 && $value['state']==0 && $value['timelimit']>0) { ?>
<td>--</td>
<? } else { ?>
<td><a href="<?=$basename?>&action=log&job=del&id=<?=$value['id']?>">删除</a></td>
<? } } ?>
</tr><? } } ?></table>
<div class="page"><?=$pages?></div>
<? } ?>