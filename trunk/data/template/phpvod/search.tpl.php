<? if(!$action) { ?>
<hr />
<form method="post" action="search.php">
<input type="hidden" name="action" value="search" />
<table class="table table_w960">
<tr><th colspan="2">
<img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absmiddle"> <a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; ������Ƶ
</th></tr>

<tr>
<td class="w40">�ؼ���</td>
<td>
<select name="field">
<option value="subject">����</option>
<option value="playactor">��Ա</option>
<option value="director">����</option>
<option value="author">��Ա</option>
<option value="tag">��ǩ</option>
</select>
<input type="input" name="keyword" value="" class="text" />
</td>
</tr>

<tr>
<td>�������</td>
<td>
<select name="cid">
<option value="">������</option>
<?=$class_opt?>
</select>
</td>
</tr>

<tr>
<td>���ҵ���</td>
<td>
<select name="nid">
<option value="">������</option>
<?=$nation_opt?>
</td>
</tr>

<tr>
<td>��������</td>
<td>
<select name="orderway">
<option value="postdate">����ʱ��</option>
<option value="lostdate">����ʱ��</option>
<option value="hits">����</option>
<option value="replier">����</option>
</select>

<select name="asc">
<option value="ASC">����</option>
<option value="DESC" selected>����</option>
</select>
</td>
</tr>

<tr>
<td>ÿҳ��ʾ����</td>
<td>
<input type="text" size="5" value="<?=$db_perpage?>" name="lines" class="text"/>
</td>
</tr>

</table><br />
<center><input type="submit" value="�� ��" class="button" /></center><br />
</form>
<? } elseif($action=='search') { ?>
<hr />
<table class="table table_w960">
<tr><th colspan="7">
<img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absmiddle"> <a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; ����"<span style="color: #C00;"><?=$keyword?></span>"���: ����<?=$rt[sum]?>����Ƶ
</th></tr>

<tr class="caption">
<td width="10%">ID</td>
<td width="25%">����</td>
<td width="20%">��Ա</td>
<td width="15%">����ʱ��</td>
<td width="10%">����</td>
<td width="10%">������</td>
<td width="10%">���</td>
</tr><? if(is_array($searchdb)) { foreach($searchdb as $value) { ?><tr class="text_center">
<td><?=$value[vid]?></td>
<td><a href="read.php?vid=<?=$value[vid]?>" target="_blank"><?=$value[subject]?></a></td>
<td><a href="profile.php?action=show&id=<?=$value[authorid]?>" target="_blank"><?=$value[author]?></a></td>
<td><?=$value[lostdate]?></td>
<td><?=$value[hits]?></td>
<td><?=$value[replier]?></td>
<td><?=$value[yz]?></td>
</tr><? } } ?></table>
<div class="page"><?=$pages?></div>
<center><input type="button" class="button" value="�� ��" onclick="javascript:history.go(-1);" /></center>
<? } ?>