<script language="javascript">

var ajax=new AJAXRequest;
ajax.setcharset("GB2312");
ajax.timeout = 10000;
ajax.ontimeout = timeout_callback; 
ajax.onexception = exception_callback;

//读取评论内容
function read(vid)
{
ajax.get("reply.php?vid="+vid,callback);
}

//分页切换
function page(page)
{
ajax.get(page,callback);
}

//表单提交
function submit_form()
{

var form = document.getElementById("atc_content").value;
if(form == '')
{
alert('评论内容不能为空。');
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
alert("提交评论超时，请重试。");
}

function exception_callback(obj)
{
document.getElementById("post").disabled = false;
alert("提交评论发生异常，请重试。");
}


</script>

<div id="class_menu" >
<ul>
<li><a href="<?=$db_bfn?>">首页</a></li><? $valuedb = pv_loop('class',"cid=$cup"); if(is_array($valuedb)) { foreach($valuedb as $value) { ?><li><a href="class.php?cid=<?=$value[cid]?>"><?=$value[caption]?></a></li><? } } ?><li><a href="<?=$link?>">向上</a></li>
</ul>
</div>


<div id="read_left">

<div class="box_border box_border_w720">
<div class="box_caption box_caption_w720"><h1>视频详细信息</h1></div>
<div class="box_content box_content_w720">

<ul class="video">
<li><img src="<?=$video[pic]?>" class="pic" /></li>
<li class="subject"><h1><?=$video[subject]?></h1></li>
<li class="msg">类别: <?=$video[caption]?></li>
<li class="msg">影片产地: <?=$video[nation]?></li>
<li class="msg">演员: <?=$playactor?></li>
<li class="msg">导演: <?=$director?></li>
<li class="msg">标签: <?=$tag?></li>
<li class="msg">人气: <?=$video[hits]?></li>
<li class="msg">发布时间: <?=$video[postdate]?></li>
<li class="msg">更新时间: <?=$video[lostdate]?></li>
<li class="msg">
相关操作: 
<a href="javascript:window.external.addFavorite('<?=$db_wwwurl?>/read.php?vid=<?=$video[vid]?>','<?=$video[subject]?>');">收藏</a> | 
<a href="report.php?vid=<?=$vid?>">举报</a><?=$editvideo?><?=$delvideo?>
</li>
</ul>


</div>
</div>

<? if($sale_msg!='') { ?>
<div class="sale_need_msg"><?=$sale_msg?></div>
<? } if($need_msg!='') { ?>
<div class="sale_need_msg"><?=$need_msg?></div>
<? } if($buy_show=='1' && $need_show=='1') { if(is_array($urldb)) { foreach($urldb as $server => $url) { ?><div class="box_border box_border_w720">
<div class="box_caption box_caption_w720"><h1>播放地址 <?=$server?></h1><h2><?=$url[0][name]?></h2></div>
<div class="box_content box_content_w720">
<ul class="series"><? if(is_array($url)) { foreach($url as $urlmsg) { ?><li><a href="play.php?urlid=<?=$urlmsg[uid]?>" target="_blank" title="<?=$urlmsg[caption]?>"><?=$urlmsg[caption_str]?></a></li><? } } ?></ul>
</div>
</div><? } } } ?>

<div class="box_border box_border_w720">
<div class="box_caption box_caption_w720"><h1>视频简介</h1></div>
<div class="box_content box_content_w720">
<?=$video[content]?>
</div>
</div>
<? if($db_reply=='1') { ?>
<div class="box_border box_border_w720">
<div class="box_caption box_caption_w720"><h1>评论</h1></div>
<div class="box_content box_content_w720">
<? if($gp_allowrp=='1') { ?>			
<form method="post" name="from" action="reply.php?action=add" id="login">
<input type="hidden" name="vid" value="<?=$video[vid]?>" />
<input type="hidden" name="cid" value="<?=$video[cid]?>" />
<p>发表评论: (长度: <?=$db_postmin?> - <?=$db_postmax?> 字节)</p>
<p>
<textarea name="atc_content" id="atc_content" cols=80 rows=5></textarea>
<input type="button" value="提 交" name="post" onclick="submit_form();" id="post" class="button"/>
</p>
</form>
<? } ?>			
<div id="read"><div align="center"><img src="<?=$imgpath?>/Load.gif"></div></div>
<script>read('<?=$vid?>');</script>
</div>
</div>
<? } ?>

</div> <!-- 左侧结束 -->


<div id="read_right">
<? if($subnum>0) { ?>
<div class="box_border box_border_w220">
<div class="box_caption box_caption_w220"><h1>下级栏目</h1></div>
<div class="box_content box_content_w220">
<ul class="subclass"><? $valuedb = pv_loop('class',"cid=$cid"); if(is_array($valuedb)) { foreach($valuedb as $value) { ?><li><a href="class.php?cid=<?=$value[cid]?>"><?=$value[caption]?></a></li><? } } ?></ul>
</div>
</div>
<? } ?>

<div class="box_border box_border_w220">
<div class="box_caption box_caption_w220"><h1>会员信息</h1></div>
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

<p class="normal">级别: <?=$video[levelname]?></p>
<p class="normal"><img src="<?=$video[levelpic]?>" /></p>
<p class="normal">UID: <?=$video[authorid]?></p>
<p class="normal">头衔: <?=$video[honor]?></p>
<p class="normal">威望: <?=$video[rvrc]?></p>
<p class="normal">金钱: <?=$video[money]?></p><? if(is_array($creditdb)) { foreach($creditdb as $key => $value) { if($_CREDITDB[$key]) { ?>
<p class="normal"><?=$value[0]?>: <?=$value[1]?></td></tr>
<? } } } ?><p class="normal">影片数: <?=$video[postnum]?></p>
<p class="normal">积分: <?=$video[credit]?></p>
<p class="normal">注册时间: <?=$video[regdate]?></p>
<p class="normal">最后登录: <?=$video[lastlogin]?></p>
<p class="normal">最后登录IP: <?=$video[ip]?></p>
</ul>
</div>
</div>


<div class="box_border box_border_w220">
<div class="box_caption box_caption_w220"><h1>相关视频</h1></div>
<div class="box_content box_content_w220">
<ul class="order"><? if(is_array($otherdb)) { foreach($otherdb as $other) { ?><li>
<img src="<?=$imgpath?>/<?=$stylepath?>/class/picli.gif" />
<span class="left"><a href="read.php?vid=<?=$other[vid]?>"><?=$other[subject]?></a></span>
<span class="right"><?=$other[postdate]?></span>
</li><? } } ?></ul>
</div>
</div>	


</div> <!-- 右侧结束 -->
