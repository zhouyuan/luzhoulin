<hr />
<div class="box_border box_border_w960">
<div class="box_caption box_caption_w960 bold"><img src="<?=$imgpath?>/<?=$stylepath?>/index/home.gif" align="absbottom" /> <a href="<?=$db_bfn?>"><?=$db_wwwname?></a> &raquo; Аяжњ</div>
<div class="box_content box_content_w960">
<ol><? if(is_array($helpdb)) { foreach($helpdb as $key => $help) { ?><li><a href="faq.php#<?=$help[id]?>"><?=$help[title]?></a></li><? } } ?></ol>
</div>
</div><? if(is_array($helpdb)) { foreach($helpdb as $key => $help) { ?><table class="help">
<tr><td><a name="<?=$help[id]?>"></a><span class="bold"><?=$help[title]?></span></td></tr>
<tr><td><?=$help[content]?></td></tr>
</table><? } } ?>