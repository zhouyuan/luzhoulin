<hr />
<div class="box_border box_border_w960">
<div class="box_caption box_caption_w960 bold"><img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absbottom" /> <a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; 网站公告</div>
<div class="box_content box_content_w960">
<ol><? if(is_array($noticedb)) { foreach($noticedb as $key => $notice) { ?><li><a href="notice.php#<?=$notice[aid]?>"><?=$notice[subject]?></a></li><? } } ?></ol>
</div>
</div><? if(is_array($noticedb)) { foreach($noticedb as $key => $notice) { ?><table class="notice">
<tr><td><a name="<?=$notice[aid]?>"></a><span class="bold"><?=$notice[subject]?></span></td></tr>
<tr><td><?=$notice[content]?></td></tr>
<tr><td class="text_right">发布人: <?=$notice[author]?> &nbsp;&nbsp;&nbsp;&nbsp; 发布时间: <?=$notice[startdate]?></td></tr>
</table><? } } ?>