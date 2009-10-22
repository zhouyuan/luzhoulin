<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<? if(SCR=='index') { ?>
<title><?=$db_wwwname?></title>	
<? } if(SCR=='class') { ?>
<title><?=$class[$cid][caption]?> - <?=$db_wwwname?></title>	
<? } if(SCR=='read') { ?>
<title><?=$video[subject]?> - <?=$db_wwwname?></title>		
<? } if(SCR=='play') { ?>
<title><?=$url[subject]?> - <?=$db_wwwname?></title>
<? } ?>

<meta http-equiv="Content-Type" content="text/html; charset=<?=$db_charset?>">
<meta name="keywords" content="<?=$db_keywords?>" />
<meta name="description" content="<?=$db_description?>" />	
<script language="javascript" src="js/function.js"></script>
<script language="javascript" src="js/ajax.js"></script>

<base href="<?=$db_wwwurl?>/" />

<!--CSS-->
<style type="text/css">
/* --------------- Reset --------------- */
*{
margin: 0px;
padding: 0px;
font-family: Tahoma;
font-size: 12px;
color: #666666;
}
body{
margin: 0px auto;
width: 960px;
}
img, table {
border: 0px;
}
ol, ul {
list-style: none;
}
hr {
border: solid 0px #CCC;
border-top-width: 1px;
margin-bottom: 10px;
clear: both;
height: 0;
}
table {
border-collapse: collapse;
border-spacing: 0;
}

h1{
font-size: 14px;
font-weight: normal;
color: #C00;
float: left;
}
h2{
font-size: 12px;
font-weight: normal;
float: right;
}

.text_left{
text-align: left;
}
.text_right{
text-align: right;
}
.text_center{
text-align: center;
}

.bold{
font-weight: bold;
}

/* --------------- Box --------------- */
.box_border{
margin-bottom: 20px;
border-left: solid 1px #DDD;
border-right: solid 1px #DDD;
border-bottom: solid 1px #DDD;
float: left;
}
.box_border .box_caption{
padding: 5px 10px;
background-color: #F5F5F5;
border-top: solid 2px #C00;
border-bottom: solid 1px #DDD;
float: left;
clear: both;
}
.box_border .box_content{
padding: 5px 10px;
line-height: 2em;
float: left;
clear: both;
}

.box_border_w960{
width: 958px;
}
.box_caption_w960,.box_content_w960{
width: 938px;
}

.box_border_w720{
width: 718px;	
}
.box_caption_w720,.box_content_w720{
width: 698px;
}

.box_border_w220{
width: 218px;	
}
.box_caption_w220,.box_content_w220{
width: 198px;
}

/* --------------- Table --------------- */
.table{
margin-bottom: 20px;
border-left: solid 1px #DDD;
border-right: solid 1px #DDD;
border-bottom: solid 1px #DDD;
float: left;
}

.table th{
padding: 5px 10px;
text-align: left;
background-color: #F5F5F5;
border-top: solid 2px #C00;
border-bottom: solid 1px #DDD;
}

.table td{
border: solid 1px #EEE;
padding: 5px 10px;
line-height: 1.5em;
}

.table .caption{
text-align: center;
background-color: #FFFFF5;
}

.table_w960{
width: 958px;
}

.table td.w30{
width: 30%;
}

.table td.w40{
width: 40%;
}

/* --------------- Form --------------- */
input.text{
border: solid 1px #DDD;
padding: 1px 2px;
}

input.button{
border: solid 1px #DDD;
background-color: #FFF;
}

textarea{
border: solid 1px #DDD;
line-height: 1.5em;
overflow-y: auto;
}

/* --------------- Page --------------- */
.page{
float: left;
width: 98%;
text-align: right;
}

/* --------------- A --------------- */
a:link,a:visited{
color: #0044dd;
text-decoration: none;
}
a:hover,a:active{
color: #ff5500;
text-decoration: underline;
}

 h1 a:link,
 h1 a:visited
{
font-size: 14px;
font-weight: normal;
color: #C00;
}

 h1 a:hover,
 h1 a:active
{
font-size: 14px;
font-weight: normal;
color: #F50;
text-decoration: underline;
}

 h2 a:link,
 h2 a:visited,
.notice a:link,
.notice a:visited,
.order a:link,
.order a:visited,
.vlist p a:link,
.vlist p a:visited,
.subclass a:link,
.subclass a:visited,
.page a:link,
.page a:visited,
.sv a:link,
.sv a:visited,
.author a:link,
.author a:visited,
.video a:link,
.video a:visited
{
color: #666666;
text-decoration: none;
}
 h2 a:hover,
 h2 a:active,
.notice a:hover,
.notice a:active,
.order a:hover,
.order a:active,
.vlist p a:hover,
.vlist p a:active,
.subclass a:hover,
.subclass a:active,
.page a:hover,
.page a:active,
.sv a:hover,
.sv a:active,
.author a:hover,
.author a:active,
.video a:hover,
.video a:active
{
color: #ff5500;
text-decoration: underline;
}

/* --------------- Header --------------- */
.header{
float: left;
width: 100%;
margin-bottom: 20px;
}
.nav_info{
padding: 5px 0;
}
#logo{
float: left;
}
.nav_login{
float: right;
}

#body{
margin: 0px;
float: left;
width: 100%;
}


/* --------------- footer --------------- */
#footer{
width: 100%;
margin-top: 10px;
line-height: 2em;
float: left;
}

/* --------------- 首页 --------------- */
/* --------------- Menu --------------- */
#index_left{
width: 720px;
float: left;
}

#index_right{
width: 220px;
float: right;
}

.hide{
display:none;
}
#menu{
width: 100%;
float: left;
}
#mainmenu_top a,#mainmenu_bottom a {
text-decoration: none;
}
#mainmenu_top{
height:28px;
}
#mainmenu_top ul li {
float:left;
}
#mainmenu_top ul li .menuhover{
background:url(<?=$db_wwwurl?>/<?=$imgpath?>/<?=$stylepath?>/mainmenu_s.gif) no-repeat;
color:#fff;
}
#mainmenu_top ul li a{
padding-top:8px;
color:#666666;
display:block;
font-weight:bold;
width:81px;
height:20px;
text-align:center;
cursor:pointer;
background:url(<?=$db_wwwurl?>/<?=$imgpath?>/<?=$stylepath?>/mainmenu_h.gif) no-repeat;
}
#mainmenu_bottom{
background:url(<?=$db_wwwurl?>/<?=$imgpath?>/<?=$stylepath?>/mainmenu_bg.jpg) repeat-x;
}
#mainmenu_bottom .mainmenu_rbg{
color:#fff;
margin-left:0px;
height:32px;
}
#mainmenu_bottom ul li{
color: #FFF;
float:left;
height:32px;
line-height:32px;
margin-left:7px;
padding-left:8px;
padding-right:18px;
background:url(<?=$db_wwwurl?>/<?=$imgpath?>/<?=$stylepath?>/menulink_bg_normal.gif) no-repeat right;
}
#mainmenu_bottom ul li a{
color:#fff;
display:block;
}
#mainmenu_bottom ul li a:hover{
text-decoration: underline;
}

/* --------------- Notice --------------- */
.info{
margin: 10px 0px;
padding: 5px 0px;
border: solid 1px #DDD;
width: 958px;
float: left;
}
.info .notice{
width: 70%;
float: left;
}

.info .siteinfo{
text-align: right;
padding-right: 10px;
float: right;
}

/* --------------- Show Video --------------- */
.sv{
margin: 15px 0px;
}

.sv li.list1{
width: 25%;
text-align: center;
float: left;
}

.sv li.list1 .pic{
width: 134px;
height: 180px;
padding: 2px;
border: solid 1px #DDDDDD;
}

.sv li.list1 .subject{
height: 20px;
}

.sv li.list1 .author{
height: 20px;
margin-bottom: 18px;
}

.sv li.list2{
width: 25%;
height: 26px;
text-align: center;
float: left;
}



/* --------------- Order --------------- */
ul.order{
float: left;
width: 100%;
}

ul.order li{
margin: 1px 0px;
width: 100%;
clear: both;
float: left;
}

ul.order li img{
margin-top: 9px;
float: left;
}

ul.order li .left{
float: left;
}

ul.order li .right{
float: right;
color: #C00;
}

ul.order li .pic
{
float: left;
margin-top: 0px;
padding: 2px;
border: solid 1px #DDD;
height: 82px;
width: 70px;
}


/* --------------- 影片列表页 --------------- */
/* --------------- class --------------- */
#class_menu{
color:#FFFFFF;
background:url(<?=$db_wwwurl?>/<?=$imgpath?>/<?=$stylepath?>/mainmenu_bg.jpg) repeat-x;
height: 30px;
margin-bottom: 15px;
}

#class_menu ul li{
color: #FFF;
float:left;
padding: 7px 18px 4px 18px;
background:url(<?=$db_wwwurl?>/<?=$imgpath?>/<?=$stylepath?>/menulink_bg_normal.gif) no-repeat right;
}

#class_menu ul li a{
color:#fff;
}

#class_menu ul li a:hover{
text-decoration: underline;
}

#class_left{
width: 220px;
float: left;
}

#class_right{
width: 720px;
float: right;
}

.subclass{
width: 100%;
}

.subclass li{
width: 33%;
text-align: center;
float: left;
}

.vlist{
}

.vlist li{
padding: 10px;
width: 329px;
height: 180px;
float: left;
}

.vlist img{
width: 134px;
height: 180px;
padding: 2px;
float: left;
border: solid 1px #DDDDDD;
}

.vlist h1{
width: 179px;
margin-left: 10px;
float: left;
}

.vlist p{
width: 179px;
margin-left: 10px;
float: left;
}

/* --------------- 影片详细页 --------------- */
/* --------------- Read --------------- */
#read_left{
width: 720px;
float: left;
}

#read_right{
width: 220px;
float: right;
}

.video{
}

.video li{
padding: 10px;
float: left;
}

.video li.subject{
padding: 10px;
width: 60%;
float: left;
}

.video li.msg{
padding: 0px 10px;
width: 60%;
float: left;
}

.video img.pic{
width: 200px;
height: 250px;
padding: 2px;
float: left;
border: solid 1px #DDDDDD;
}

.series{
width: 100%;
float: left;
}

.series li{
float: left;
}

.series li a{
width: 99px;
margin: 5px;
padding: 2px;
text-align: center;
float: left;
}
.series a:link, .series a:visited{
border: solid 1px #DDD;
color: #666666;
text-decoration: none;
}

.series a:hover, .series a:active{
border: solid 1px #FF5500;
color: #FF5500;
}

.reply_caption{
float: left;
width: 694px;
background-color: #F5F5F5;
padding: 2px;
margin-top: 12px;
}

.reply_content{
float: left;
word-break: break-all;
width: 694px;
padding: 2px;
}

.reply_signature{
float: left;
text-align: right;
width: 694px;
padding: 2px;
color: #AAA;
}

.member{
}

.member li{
width: 100%;
float: left;
}

.member p.normal{
width: 90%;
margin-left: 10px;
clear: both;
float: left;
}

.member p.author a{
font-weight: bold;
}

.member p.icon{
margin-bottom: 10px;
}

.member p.medal{
margin-top: 10px;
margin-bottom: 10px;
}

.member img.icon{
width: 100px;
height: 120px;
float: left;
}

.member img.medal{
margin: 2px 2px;
float: left;
}

.sale_need_msg{
margin-bottom: 20px;
padding: 5px 20px;
border: solid 1px #DDD;
width: 678px;
float: left;
}

/* --------------- 帮助 公告--------------- */
/* --------------- Help Notice--------------- */
table.help,
table.notice
{
margin: 0px 0px 20px 0px;
border: solid 1px #DDD;
width: 958px;
float: left;
}

table.help td,
table.notice td
{
padding: 10px;
}

/* --------------- post --------------- */
#preview_fake{
    filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale);
margin-bottom: 5px;
} 

/* --------------- 通用 --------------- */
/* --------------- global --------------- */
img.icon
{
width: 100px;
height: 120x;
}

</style>

</head>
<body>
            
<div class="header">
<div class="nav_info">
<a href="<?=$db_bfn?>" id="logo"><img src="<?=$logo?>" /></a>
<div class="nav_login">
您好，
<? if($groupid=='guest') { ?>
请 <a href="register.php">注册</a> 或 <a href="login.php">登录</a>
<? } else { ?>
<?=$username?>！<a href="login.php?action=quit">[退出]</a>
<!--┆ <a href="message.php">短消息</a>-->
┆ <a href="profile.php?action=show&id=<?=$uid?>">个人资料</a>
<? } if($gp_allowpost=='1') { ?>
┆ <a href="post.php">发布视频</a>
<? } if(is_array($hackdb)) { foreach($hackdb as $h) { ?>┆ <a href="hack.php?H_name=<?=$h[directory]?>"><?=$h[name]?></a><? } } if($SYSTEM[allowadmincp]=='1') { ?>
┆ <a href="admin.php" target="_blank">后台管理</a>
<? } ?>

┆ <a href="search.php">搜索</a>
<!--┆ <a href="faq.php">帮助</a>-->
</div>
</div>
</div><!-- header end -->

<div id="body">
