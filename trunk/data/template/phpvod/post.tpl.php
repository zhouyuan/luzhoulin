<hr />
<form method="post" name="from" action="post.php" enctype="multipart/form-data">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" value="2" name="step" />
<input type="hidden" value="<?=$vid?>" name="vid" />
<input type="hidden" value="<?=$pic?>" name="pic" />

<table class="table table_w960" id="tp">
<tr><th colspan="2">
<img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absmiddle"> <a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; ������Ƶ
</th></tr>
<? if(($action=='new' || $action=='modify') && $step=='1') { if($postgd) { ?>
<tr>
<td>��֤��<span style="color:red;">*</span></td>
<td>
<img src="ck.php" align="absmiddle" onclick="this.src='ck.php'" style="cursor: pointer;" />
<input type="text" maxLength="4" class="text" name="gdcode" size="4" /> �����������֤�룬���ͼƬˢ��

</td>
</tr>
<? } ?>
<tr>
<td class="w40">�������<span style="color:red;">*</span></td>
<td>
<select name="cid">
<?=$class_opt?>
</select>
</td>
</tr>

<tr>
<td>����/����<span style="color:red;">*</span></td>
<td>
<select name="nid">
<?=$nation_opt?>
</select>
</td>
</tr>

<tr>
<td>����<span style="color:red;">*</span></td>
<td><input type="text" name="subject" size="30" class="text" value="<?=$subject?>" /></td>
</tr>

<tr>
<td>��ǩ[<a href="#" onclick="this.blur();alert('�����û�����ͨ����ǩ������ҵ������Ŀ');return false;"><strong>?</strong></a>]</td>
<td>
��ǩ1 <input name="tag[]" size="10" value="<?=$tag[0]?>" maxlength="10" class="text" /> 
��ǩ2 <input name="tag[]" size="10" value="<?=$tag[1]?>" maxlength="10" class="text" /> 
��ǩ3 <input name="tag[]" size="10" value="<?=$tag[2]?>" maxlength="10" class="text" /> 
</td>
</tr>

<tr>
<td>��������</td>
<td><input type="text" name="playactor" value="<?=$playactor?>" class="text" /> (�����Ա�������ÿո��","����)</td>
</tr>

<tr>
<td>����</td>
<td><input type="text" name="director" value="<?=$director?>" class="text" /></td>
</tr>

<tr>
<td>���ݼ��</td>
<td><textarea name="atc_content" cols=60 rows=8><?=$content?></textarea></td>
</tr>


<tr>
<td>���� <br />�����ϴ���ʽ: <?=$db_picfiletype?> <br />�����ϴ���С: <?=$db_picmaxsize?>KB</td>
<td>
<div id="preview_fake" style="width: 120px; height: 150px;"><img id="preview" src="<?=$img?>" style="width: 120px; height: 150px;" /></div>
<? if($db_uploadvodpic) { ?>
<input name="image" type="file" size="30" class="text" onchange="onUploadImgChange(this)"/> 
<? } ?>
</td>
</tr>

<? if($gp_allowsell=='1') { ?>
<tr>
<td>������Ƶ</td>
<td>��Ա֧�� <input class="text" maxLength=6 size=6 value="<?=$sale_value?>" name="sale_value">
<select name="sale_type">
<?=$sale_opt?>
</select>	
���ܲ�����Ƶ
</td>
</tr>
<? } if($gp_allowencode=='1') { ?>
<tr>
<td>������Ƶ</td>
<td>��Աӵ�� <input class="text" maxLength=6 size=6 value="<?=$need_value?>" name="need_value">
<select name="need_type">
<?=$need_opt?>
</select>		
���ϲ��ܲ�����Ƶ
</td>
</tr>
<? } if(is_array($urls)) { foreach($urls as $server => $value) { ?><tr>
<td>��Ƶ��ַ<span style="color:red;">*</span><br />
ÿ������һ����Ƶ��ַ<br />
��ʽ��<span style="color: green">��Ƶ��ַ</span>,<span style="color: red">����</span><br />
˵������Ƶ��ַ�����֮����","�ֿ������ⲿ��Ϊ��ѡ���ʡ�ԡ�
</td>
<td>
<select name="pid[]"><?=$value[player]?></select><br />
<textarea name="urls[]" cols="80" rows="8" style="word-wrap: normal; overflow-x: auto; margin: 5px 0px;"><?=$value[urlmsg]?></textarea>
<br />
<input type="button" class="button" onclick="add();" value="����" /> <input type="button" class="button" onclick="del(this);" value="ɾ��" />
</td>
</tr><? } } ?></table><br />
<center><input type="submit" value="�� ��" class="button" /></center><br />
</form>

<script language="JavaScript" type="text/javascript">

function onUploadImgChange(sender){   
    if(!sender.value.match(/.jpg|.gif|.png|.bmp/i)){   
        alert('ͼƬ��ʽ��Ч');   
        return false;   
    }  
    var objPreview = document.getElementById('preview');   
    var objPreviewFake = document.getElementById('preview_fake');   
       
    if( sender.files && sender.files[0] ){   
        objPreview.style.display = 'block';   
        objPreview.src = sender.files[0].getAsDataURL();       
    }else if( objPreviewFake.filters ){    
        sender.select();   
        var imgSrc = document.selection.createRange().text;   
        objPreviewFake.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = imgSrc;   
    objPreview.style.display = 'none';   
    }   
}  

function add()
{
var caption = '��Ƶ��ַ<span style="color:red;">*</span><br />ÿ������һ����Ƶ��ַ<br />��ʽ��<span style="color: green">��Ƶ��ַ</span>,<span style="color: red">����</span><br />˵������Ƶ��ַ�����֮����","�ֿ������ⲿ��Ϊ��ѡ���ʡ�ԡ�';
var html = '<select name="pid[]"><?=$player?></select><br /><textarea name="urls[]" cols="80" rows="8" style="word-wrap: normal; overflow-x: auto; margin: 5px 0px;"></textarea><br /><input type="button" class="button" onclick="add();" value="����" /> <input type="button" class="button" onclick="del(this);" value="ɾ��" />';
var tr = fetch_object("tp").insertRow(-1);
tr.insertCell(-1).innerHTML=caption;
tr.insertCell(-1).innerHTML=html;  
}

function del(obj)
{
var i=obj.parentNode.parentNode.rowIndex;
fetch_object('tp').deleteRow(i);
}
</script>
<? } ?>