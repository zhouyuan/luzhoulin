<?php
function parse_template($tpldir,$file,$EXT,$type="style") {

	if($type=="style")
	{
	    $tplfile = R_P."template/$tpldir/$file.$EXT";
	    $objfile = R_P."data/template/$tpldir/$file.tpl.php";
		$objdir = R_P."data/template/$tpldir";
	}
	elseif($type=="hack")
	{
		$tplfile = R_P."hack/$tpldir/template/$file.$EXT";
		$objfile = R_P."data/hack/$tpldir/$file.tpl.php";
		$objdir = R_P."data/hack/$tpldir";
	}

	$nest = 6;
	if(!@$fp = fopen($tplfile, 'r')) {
        exit("Current template file '$tplfile' not found or have no access!");
    }
    $template = @fread($fp, filesize($tplfile));
    fclose($fp);
	
	$var_regexp = "((\\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)(\[[a-zA-Z0-9_\-\.\"\'\[\]\$\x7f-\xff]+\])*)";
	$const_regexp = "([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)";

	$template = preg_replace("/([\n\r]+)\t+/s", "\\1", $template);
	$template = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $template);    
	$template = str_replace("{LF}", "<?=\"\\n\"?>", $template);

	$template = preg_replace("/\{(\\\$[a-zA-Z0-9_\[\]\'\"\$\.\x7f-\xff]+)\}/s", "<?=\\1?>", $template);
	$template = preg_replace("/$var_regexp/es", "addquote('<?=\\1?>')", $template);
	$template = preg_replace("/\<\?\=\<\?\=$var_regexp\?\>\?\>/es", "addquote('<?=\\1?>')", $template);	

	$template = preg_replace("/[\n\r\t]*\{eval\s+(.+?)\}[\n\r\t]*/ies", "stripvtags('<? \\1 ?>','')", $template);
	$template = preg_replace("/[\n\r\t]*\{echo\s+(.+?)\}[\n\r\t]*/ies", "stripvtags('<? echo \\1; ?>','')", $template);
	$template = preg_replace("/([\n\r\t]*)\{elseif\s+(.+?)\}([\n\r\t]*)/ies", "stripvtags('\\1<? } elseif(\\2) { ?>\\3','')", $template);
	$template = preg_replace("/([\n\r\t]*)\{else\}([\n\r\t]*)/is", "\\1<? } else { ?>\\2", $template);

	for($i = 0; $i < $nest; $i++) {
		$template = preg_replace("/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\}[\n\r]*(.+?)[\n\r]*\{\/loop\}[\n\r\t]*/ies", "stripvtags('<? if(is_array(\\1)) { foreach(\\1 as \\2) { ?>','\\3<? } } ?>')", $template);
		$template = preg_replace("/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}[\n\r\t]*(.+?)[\n\r\t]*\{\/loop\}[\n\r\t]*/ies", "stripvtags('<? if(is_array(\\1)) { foreach(\\1 as \\2 => \\3) { ?>','\\4<? } } ?>')", $template);
		$template = preg_replace("/([\n\r\t]*)\{if\s+(.+?)\}([\n\r]*)(.+?)([\n\r]*)\{\/if\}([\n\r\t]*)/ies", "stripvtags('\\1<? if(\\2) { ?>\\3','\\4\\5<? } ?>\\6')", $template);

   		$template = preg_replace("/[\n\r\t]*\{loop:(\S+):(\S+)\s+(.+?)\}[\n\r\t]*(.+?)[\n\r\t]*\{\/loop:\\1\}[\n\r\t]*/ies", "stripvtags('<? \\2db = pv_loop(\'\\1\',\"\\3\"); if(is_array(\\2db)) { foreach(\\2db as \\2) { ?>','\\4<? } } ?>')", $template);

	}

	$template = preg_replace("/\{$const_regexp\}/s", "<?=\\1?>", $template);
	$template = preg_replace("/ \?\>[\n\r]*\<\? /s", " ", $template);


	!is_dir($objdir) && mkdir($objdir,0777);
	if(!@$fp = fopen($objfile, 'w')) {
        exit("Directory '$objdir' not found or have no access!");
    }
    flock($fp, 2);
    fwrite($fp, $template);
    fclose($fp);
}

function stripvtags($expr, $statement){
    $expr = str_replace("\\\"", "\"", preg_replace("/\<\?\=(\\\$.+?)\?\>/s", "\\1", $expr));
    $statement = str_replace("\\\"", "\"", $statement);
    return $expr.$statement;
}

function addquote($var) {
	return str_replace("\\\"", "\"", $var);
}

function bak_addquote($var) {
	return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var));
}

?>