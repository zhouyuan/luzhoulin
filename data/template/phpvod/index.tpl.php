<script type='text/javascript'>
function getObject(objectId)//获取id的函数 
    {
    if(document.getElementById && document.getElementById(objectId)) {
    // W3C DOM
    return document.getElementById(objectId);
    } else if (document.all && document.all(objectId)) {
    // MSIE 4 DOM
    return document.all(objectId);
    } else if (document.layers && document.layers[objectId]) {
    // NN 4 DOM.. note: this won't find nested layers
    return document.layers[objectId];
    } else {
    return false;
    }
    }

function showM(thisobj,Num)
    {
    var number;
number = Num;
    for(j=0; j<=<?=$n?>; j++){
    if (j == number){
        if(getObject("mm"+j)!=false){
        getObject("mm"+ number).className = "menuhover";
        getObject("mb"+ number).className = "";
    }
    }
    else{
         if(getObject("mm"+j)!=false){ 
        getObject("mm"+ j).className = "";
        getObject("mb"+ j).className = "hide"; 
    }
    }
    }
    }

</script>

<div id="menu">
<div id="mainmenu_top"><?=$mm?></div>
<div id="mainmenu_bottom" >
<div class="mainmenu_rbg"><?=$mb?></div>
</div>
</div>


<div class="info">
<div class="notice">
<marquee direction="left" scrolldelay="1" scrollamount="2" onmouseover="this.stop()" onmouseout="this.start()"><? $valuedb = pv_loop('notice',"dateformat=1"); if(is_array($valuedb)) { foreach($valuedb as $value) { ?><a href="notice.php#<?=$value[aid]?>"><?=$value[subject]?> (<?=$value[startdate]?>)</a> &nbsp; &nbsp; &nbsp; &nbsp;<? } } ?></marquee>
</div>
<div class="siteinfo">
<?=$totalmember?> 位会员 | 欢迎新会员 <span style="color:#C00"><?=$newmember?></span>
</div>
</div>


<div id="index_left">

<div class="box_border box_border_w720">
<div class="box_caption box_caption_w720"><h1>推荐课程</h1></div>
<div class="box_content box_caption_w720">
<ul class="sv"><? $n=1; $videodb = pv_loop('video',"best=1|limit=16|order=lostdate DESC,postdate DESC"); if(is_array($videodb)) { foreach($videodb as $video) { if($n<=4) { ?>
<li class="list1">
<div><a href="read.php?vid=<?=$video[vid]?>"><img class="pic" src="<?=$video[pic]?>" /></a></div>
<div class="subject"><a href="read.php?vid=<?=$video[vid]?>"><?=$video[subject]?></a></div>
<div class="author"><a href="profile.php?action=show&id=<?=$video[authorid]?>" target="_blank"><?=$video[author]?></a></div>
</li>
<? } else { ?>
<li class="list2">
<img src="<?=$imgpath?>/<?=$stylepath?>/index/picli.gif" /><a href="read.php?vid=<?=$video[vid]?>"><?=$video[subject]?></a>
</li>
<? } $n++; } } ?></ul>
</div>
</div><? $c1db = pv_loop('class',"cid=0"); if(is_array($c1db)) { foreach($c1db as $c1) { ?><div class="box_border box_border_w720">
<div class="box_caption box_caption_w720">
<h1><?=$c1[caption]?></h1>
<h2><? $c2db = pv_loop('class',"cid=$c1[cid]"); if(is_array($c2db)) { foreach($c2db as $c2) { ?>&nbsp;&nbsp;<a href="class.php?cid=<?=$c2[cid]?>"><?=$c2[caption]?></a><? } } ?></h2>
</div>

<div class="box_content box_caption_w720">
<ul class="sv"><? $n=1; $videodb = pv_loop('video',"cid=$c1[cid]|showsub=1|order=lostdate DESC,postdate DESC|limit=16|subject_len=22"); if(is_array($videodb)) { foreach($videodb as $video) { if($n<=4) { ?>
<li class="list1">
<div><a href="read.php?vid=<?=$video[vid]?>"><img class="pic" src="<?=$video[pic]?>" /></a></div>
<div class="subject"><a href="read.php?vid=<?=$video[vid]?>"><?=$video[subject]?></a></div>
<div class="author"><a href="profile.php?action=show&id=<?=$video[authorid]?>" target="_blank"><?=$video[author]?></a></div>
</li>
<? } else { ?>
<li class="list2">
<img src="<?=$imgpath?>/<?=$stylepath?>/index/picli.gif" /><a href="read.php?vid=<?=$video[vid]?>"><?=$video[subject]?></a>
</li>
<? } $n++; } } ?></ul>
</div>
</div><? } } if($db_indexlink=='1') { ?>
<div class="box_border box_border_w720">
<div class="box_caption box_caption_w720">友情链接</div>
<div class="box_content box_content_w720"><?=$sharelink?></div>
</div>
<? } ?>

</div>

<div id="index_right">

<div class="box_border box_border_w220">
<div class="box_caption box_caption_w220">
<h1>最近更新</h1>
</div>
<div class="box_content box_content_w220">
<ul class="order"><? $videodb = pv_loop('video',"cid=-1|limit=10|order=lostdate DESC,postdate DESC,v.vid DESC|subject_len=22|dateformat=1"); if(is_array($videodb)) { foreach($videodb as $video) { ?><li>
<img src="<?=$imgpath?>/<?=$stylepath?>/index/picli.gif" />
<span class="left"><a href="read.php?vid=<?=$video[vid]?>"><?=$video[subject]?></a></span>
<span class="right"><?=$video[lostdate]?></span>
</li><? } } ?></ul>
</div>
</div><? $valuedb = pv_loop('class',"cid=0"); if(is_array($valuedb)) { foreach($valuedb as $value) { ?><div class="box_border box_border_w220">
<div class="box_caption box_caption_w220">
<h1><?=$value[caption]?>排行</h1>
</div>
<div class="box_content box_content_w220">
<ul class="order"><? $videodb = pv_loop('video',"cid=$value[cid]|showsub=1|limit=10|order=hits DESC,postdate DESC|subject_len=22|dateformat=1"); if(is_array($videodb)) { foreach($videodb as $video) { ?><li>
<img src="<?=$imgpath?>/<?=$stylepath?>/index/picli.gif" />
<span class="left"><a href="read.php?vid=<?=$video[vid]?>"><?=$video[subject]?></a></span>
<span class="right"><?=$video[hits]?></span>
</li><? } } ?></ul>
</div>
</div><? } } ?></div>