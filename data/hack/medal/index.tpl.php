<hr />
<table class="table table_w960">
<tr>
<th>
<img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absbottom" /> 
<a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; ѫ������
</th>
<th style="text-align: right; font-weight: normal;">
<a href="<?=$basename?>">ѫ�½���</a> |
<a href="<?=$basename?>&action=list">���ѫ������</a> |
<a href="<?=$basename?>&action=log">ѫ�°䷢���</a>
<? if(strpos($md_groups,",$groupid,")!==false) { ?>
| <a href="<?=$basename?>&action=award">�䷢ѫ��</a>
<? } ?>
</th>
</tr>
<tr>
<td style="text-align:center" colspan="2">
<? if($userdb['medals']) { ?>
����õ�ѫ��<? if(is_array($userdb['medals'])) { foreach($userdb['medals'] as $key => $value) { if($medaldb[$value]['picurl']) { ?>
<img src="<?=$imgpath?>/medal/<?=$medaldb[$value]['picurl']?>" alt="<?=$medaldb[$value]['name']?>" /> 
<? } } } } else { ?>
����û��ѫ��
<? } ?>
</td>
</tr>
</table>


<? if(!$action) { ?>
<table class="table table_w960">
<tr><th colspan="4">ѫ�½���</th></tr>
<tr class="caption">
<td width="5%">ID</td>
<td width="15%">ѫ������</td>
<td width="*">ѫ��˵��</td>
<td width="15%">ѫ��ͼƬ</td>
</tr><? $num=0; if(is_array($medaldb)) { foreach($medaldb as $key => $value) { $num++; ?><tr class="text_center">
<td><?=$num?></td>
<td><?=$value['name']?></td>
<td><?=$value['intro']?></td>
<td><img src="<?=$imgpath?>/medal/<?=$value['picurl']?>" /></td>
</tr><? } } ?></table>
<? } elseif($action=='list') { ?>
<table class="table table_w960">
<tr>
<th colspan="3">���ѫ������</th>
</tr>
<tr class="caption text_center">
<td width="10%">ID</td>
<td width="20%">�û���</td>
<td width="70%">����ѫ��</td>
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
<tr><th colspan="2">�䷢ѫ��</th></tr>
<tr>
<td class="w30">�û���: </td>
<td><input class="text" type="text" name="pvuser" size="40" /></td>
</tr>
<tr>
<td>ѡ�����: </td>
<td>
<input type="radio" name="type" value="1" checked /> �䷢
<input type="radio" name="type" value="2" /> �ջ�
</td>
</tr>
<tr>
<td>ѡ��ѫ��: </td>
<td>
<select name="medal">
<option>ѡ��ѫ��</option><? if(is_array($medaldb)) { foreach($medaldb as $key => $value) { ?><option value="<?=$key?>"><?=$value['name']?></option><? } } ?></select>
</td>
</tr>
<tr>
<td>��Ч��:</td>
<td>
<select name="timelimit">
<option value="0">����</option>
</select>
</td>
</tr>
<tr>
<td>��������: </td>
<td><input class="text" type="text" name="reason" size="50" /></td>
</tr>
</table>
<center><input class="button" type="submit" value="�� ��" /></center>
</form>
<? } elseif($action=='log') { ?>
<table class="table table_w960">
<tr><th colspan="9">ѫ�°䷢���</th></tr>
<tr class="caption">
<td width="3%">ID</td>
<td width="12%">�û���</td>
<td width="12%">����Ա</td>
<td width="10%">ѫ������</td>
<td width="5%">����</td>
<td><div style="table-layout:fixed;word-wrap:break-word;">����ԭ��</div></td>
<td width="15%">����ʱ��</td>
<td width="6%">��Ч��</td>
<? if($groupid==3) { ?>
<td width="5%">ɾ��</td>
<? } ?>
</tr><? $num=($page-1)*$db_perpage; if(is_array($logdb)) { foreach($logdb as $key => $value) { $num++; ?><tr class="text_center">
<td><?=$num?></td>
<td><?=$value['awardee']?></td>
<td><?=$value['awarder']?></td>
<td><?=$medaldb[$value['level']]['name']?><br /></td>

<? if($value['action']==1) { ?>
<td>�䷢</td>
<? } elseif($value['action']==2) { ?>
<td>�ջ�</td>
<? } ?>
<td><?=$value['why']?><br /></td>
<td><?=$value['awardtime']?></td>
<? if($value['action']==1) { if($value['timelimit']<1) { ?>
<td>����</td>
<? } else { ?>
<td><?=$value['timelimit']?> ����</td>
<? } } else { ?>
<td>--</td>
<? } if($groupid==3) { if($value['action']==1 && $value['state']==0 && $value['timelimit']>0) { ?>
<td>--</td>
<? } else { ?>
<td><a href="<?=$basename?>&action=log&job=del&id=<?=$value['id']?>">ɾ��</a></td>
<? } } ?>
</tr><? } } ?></table>
<div class="page"><?=$pages?></div>
<? } ?>