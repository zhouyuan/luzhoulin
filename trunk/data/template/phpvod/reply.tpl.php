<? if(is_array($replierdb)) { foreach($replierdb as $key => $value) { ?><div class="reply_caption">
<a href="profile.php?action=show&id=<?=$value[authorid]?>" target='_blank'><?=$value[author]?></a> (<?=$value[postdate]?>) ˵:
</div>
<div class="reply_content"><?=$value[content]?></div>
<div class="reply_signature"><?=$value[signature]?></div><? } } ?><div class="page"><?=$pages?></div>
