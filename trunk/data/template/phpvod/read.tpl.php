<script language="javascript">

var ajax=new AJAXRequest;
ajax.setcharset("GB2312");
ajax.timeout = 10000;
ajax.ontimeout = timeout_callback; 
ajax.onexception = exception_callback;

//��ȡ��������
function read(vid)
{
ajax.get("reply.php?vid="+vid,callback);
}

//��ҳ�л�
function page(page)
{
ajax.get(page,callback);
}

//���ύ
function submit_form()
{

var form = document.getElementById("atc_content").value;
if(form == '')
{
alert('�������ݲ���Ϊ�ա�');
return false;
}

document.getElementById("post").disabled  = true;
form_obj = document.getElementById("login");
ajax.postf(form_obj,submit_callback);
}

function callback(obj)
{
document.getElementById('read').innerHTML = obj.responseText;
}

function submit_callback(obj)
{ 
if(obj.responseText!='') alert(obj.responseText);
read(<?=$vid?>);
document.getElementById("atc_content").value = '';
document.getElementById("post").disabled = false;	
}

function timeout_callback(obj)
{
document.getElementById("post").disabled = false;
alert("�ύ���۳�ʱ�������ԡ�");
}

function exception_callback(obj)
{
document.getElementById("post").disabled = false;
alert("�ύ���۷����쳣�������ԡ�");
}


</script>

<div id="class_menu" >
<ul>
<li><a href="<?=$db_bfn?>">��ҳ</a></li><? $valuedb = pv_loop('class',"cid=$cup"); if(is_array($valuedb)) { foreach($valuedb as $value) { ?><li><a href="class.php?cid=<?=$value[cid]?>"><?=$value[caption]?></a></li><? } } ?><li><a href="<?=$link?>">����</a></li>
</ul>
</div>


<div id="read_left">

<div class="box_border box_border_w720">
<div class="box_caption box_caption_w720"><h1>��Ƶ��ϸ��Ϣ</h1></div>
<div class="box_content box_content_w720">

<ul class="video">
<li><img src="<?=$video[pic]?>" class="pic" /></li>
<li class="subject"><h1><?=$video[subject]?></h1></li>
<li class="msg">���: <?=$video[caption]?></li>
<li class="msg">ӰƬ����: <?=$video[nation]?></li>
<li class="msg">��Ա: <?=$playactor?></li>
<li class="msg">����: <?=$director?></li>
<li class="msg">��ǩ: <?=$tag?></li>
<li class="msg">����: <?=$video[hits]?></li>
<li class="msg">����ʱ��: <?=$video[postdate]?></li>
<li class="msg">����ʱ��: <?=$video[lostdate]?></li>
<li class="msg">
��ز���: 
<a href="javascript:window.external.addFavorite('<?=$db_wwwurl?>/read.php?vid=<?=$video[vid]?>','<?=$video[subject]?>');">�ղ�</a> | 
<a href="report.php?vid=<?=$vid?>">�ٱ�</a><?=$editvideo?><?=$delvideo?>
</li>
</ul>


</div>
</div>

<? if($sale_msg!='') { ?>
<div class="sale_need_msg"><?=$sale_msg?></div>
<? } if($need_msg!='') { ?>
<div class="sale_need_msg"><?=$need_msg?></div>
<? } if($buy_show=='1' && $need_show=='1') { if(is_array($urldb)) { foreach($urldb as $server => $url) { ?><div class="box_border box_border_w720">
<div class="box_caption box_caption_w720"><h1>���ŵ�ַ <?=$server?></h1><h2><?=$url[0][name]?></h2></div>
<div class="box_content box_content_w720">
<ul class="series"><? if(is_array($url)) { foreach($url as $urlmsg) { ?><li><a href="play.php?urlid=<?=$urlmsg[uid]?>" target="_blank" title="<?=$urlmsg[caption]?>"><?=$urlmsg[caption_str]?></a></li><? } } ?></ul>
</div>
</div><? } } } ?>

<div class="box_border box_border_w720">
<div class="box_caption box_caption_w720"><h1>��Ƶ���</h1></div>
<div class="box_content box_content_w720">
<?=$video[content]?>
</div>
</div>
<? if($db_reply=='1') { ?>
<div class="box_border box_border_w720">
<div class="box_caption box_caption_w720"><h1>����</h1></div>
<div class="box_content box_content_w720">
<? if($gp_allowrp=='1') { ?>			
<form method="post" name="from" action="reply.php?action=add" id="login">
<input type="hidden" name="vid" value="<?=$video[vid]?>" />
<input type="hidden" name="cid" value="<?=$video[cid]?>" />
<p>��������: (����: <?=$db_postmin?> - <?=$db_postmax?> �ֽ�)</p>
<p>
<textarea name="atc_content" id="atc_content" cols=80 rows=5></textarea>
<input type="button" value="�� ��" name="post" onclick="submit_form();" id="post" class="button"/>
</p>
</form>
<? } ?>			
<div id="read"><div align="center"><img src="<?=$imgpath?>/Load.gif"></div></div>
<script>read('<?=$vid?>');</script>
</div>
</div>
<? } ?>

</div> <!-- ������ -->


<div id="read_right">
<? if($subnum>0) { ?>
<div class="box_border box_border_w220">
<div class="box_caption box_caption_w220"><h1>�¼���Ŀ</h1></div>
<div class="box_content box_content_w220">
<ul class="subclass"><? $valuedb = pv_loop('class',"cid=$cid"); if(is_array($valuedb)) { foreach($valuedb as $value) { ?><li><a href="class.php?cid=<?=$value[cid]?>"><?=$value[caption]?></a></li><? } } ?></ul>
</div>
</div>
<? } ?>

<div class="box_border box_border_w220">
<div class="box_caption box_caption_w220"><h1>��Ա��Ϣ</h1></div>
<div class="box_content box_content_w220">
<ul class="member">
<p class="normal author">
<a href="profile.php?action=show&id=<?=$video[authorid]?>" target="_blank"><?=$video[author]?></a>
</p>
<p class="normal icon"><img src="<?=$video[icon]?>" class="icon" /></p>

<? if($video['medals']) { ?>
<p class="normal medal"><? if(is_array($video['medals'])) { foreach($video['medals'] as $key => $value) { if($medaldb[$value][picurl]) { ?>
<img src="<?=$imgpath?>/medal/<?=$medaldb[$value][picurl]?>" alt="<?=$medaldb[$value][name]?>" class="medal"/> 
<? } } } ?></p>
<? } ?>

<p class="normal">����: <?=$video[levelname]?></p>
<p class="normal"><img src="<?=$video[levelpic]?>" /></p>
<p class="normal">UID: <?=$video[authorid]?></p>
<p class="normal">ͷ��: <?=$video[honor]?></p>
<p class="normal">����: <?=$video[rvrc]?></p>
<p class="normal">��Ǯ: <?=$video[money]?></p><? if(is_array($creditdb)) { foreach($creditdb as $key => $value) { if($_CREDITDB[$key]) { ?>
<p class="normal"><?=$value[0]?>: <?=$value[1]?></td></tr>
<? } } } ?><p class="normal">ӰƬ��: <?=$video[postnum]?></p>
<p class="normal">����: <?=$video[credit]?></p>
<p class="normal">ע��ʱ��: <?=$video[regdate]?></p>
<p class="normal">����¼: <?=$video[lastlogin]?></p>
<p class="normal">����¼IP: <?=$video[ip]?></p>
</ul>
</div>
</div>


<div class="box_border box_border_w220">
<div class="box_caption box_caption_w220"><h1>�����Ƶ</h1></div>
<div class="box_content box_content_w220">
<ul class="order"><? if(is_array($otherdb)) { foreach($otherdb as $other) { ?><li>
<img src="<?=$imgpath?>/<?=$stylepath?>/class/picli.gif" />
<span class="left"><a href="read.php?vid=<?=$other[vid]?>"><?=$other[subject]?></a></span>
<span class="right"><?=$other[postdate]?></span>
</li><? } } ?></ul>
</div>
</div>	


</div> <!-- �Ҳ���� -->
