<div id="class_menu" >
<ul>
<li><a href="<?=$db_bfn?>">��ҳ</a></li><? $valuedb = pv_loop('class',"cid=$cup"); if(is_array($valuedb)) { foreach($valuedb as $value) { ?><li><a href="class.php?cid=<?=$value[cid]?>"><?=$value[caption]?></a></li><? } } ?><li><a href="<?=$link?>">����</a></li>
</ul>
</div>

<div id="class_left">
<? if($subnum>0) { ?>
<div class="box_border box_border_w220">
<div class="box_caption box_caption_w220"><h1>�¼���Ŀ</h1></div>
<div class="box_content box_content_w220">
<ul class="subclass"><? $valuedb = pv_loop('class',"cid=$cid"); if(is_array($valuedb)) { foreach($valuedb as $value) { ?><li><a href="class.php?cid=<?=$value[cid]?>"><?=$value[caption]?></a></li><? } } ?></ul>
</div>
</div>
<? } ?>

<div class="box_border box_border_w220">
<div class="box_caption box_caption_w220"><h1>�����Ƽ�</h1></div>
<div class="box_content box_content_w220">
<ul class="order"><? $bestvoddb = pv_loop('video',"cid=0|best=2|order=lostdate DESC,postdate DESC|limit=20|subject_len=22"); if(is_array($bestvoddb)) { foreach($bestvoddb as $bestvod) { ?><li>
<img src="<?=$imgpath?>/<?=$stylepath?>/class/picli.gif" />
<span class="left"><a href="read.php?vid=<?=$bestvod[vid]?>"><?=$bestvod[subject]?></a></span>
<span class="right"><?=$bestvod[hits]?></span>
</li><? } } ?></ul>
</div>
</div>

<div class="box_border box_border_w220">
<div class="box_caption box_caption_w220"><h1>��������</h1></div>
<div class="box_content box_content_w220">
<ul class="order"><? $hitvoddb = pv_loop('video',"cid=0|order=hits DESC|limit=20|subject_len=22"); if(is_array($hitvoddb)) { foreach($hitvoddb as $hitvod) { ?><li>
<img src="<?=$imgpath?>/<?=$stylepath?>/class/picli.gif" />
<span class="left"><a href="read.php?vid=<?=$hitvod[vid]?>"><?=$hitvod[subject]?></a></span>
<span class="right"><?=$hitvod[hits]?></span>
</li><? } } ?></ul>
</div>
</div>

</div> <!-- ������ -->

<div id="class_right">

<div class="box_border box_border_w720">
<div class="box_caption box_caption_w720">
<h1><?=$class[$cid][caption]?></h1>
<h2><? $valuedb = pv_loop('class',"cid=$cid"); if(is_array($valuedb)) { foreach($valuedb as $value) { ?>&nbsp;&nbsp;<a href="class.php?cid=<?=$value[cid]?>"><?=$value[caption]?></a><? } } ?></h2>		
</div>
<div class="box_content box_content_w720">
<ul class="vlist"><? if(is_array($videodb)) { foreach($videodb as $video) { ?><li>
<a href="read.php?vid=<?=$video[vid]?>"><img src="<?=$video[pic]?>" /></a>
<h1><a href="read.php?vid=<?=$video[vid]?>"><?=$video[title]?></a></h1>
<p>����: <?=$video[playactor]?></p>
<p>��Ŀ: <?=$video[nation]?></p>
                    <p>�꼶: <?=$video[grade]?></p>
<p>ʱ��: <?=$video[postdate]?></p>
<p>��Ա: <a href="profile.php?action=show&id=<?=$video[authorid]?>" target="_blank"><?=$video[author]?></a></p>
<p>����: <?=$video[hits]?></p>
<p>����: <?=$video[replier]?></p>
</li><? } } ?></ul>
</div>
</div>
<div class="page"><?=$pages?></div>
</div> <!-- �Ҳ���� -->
