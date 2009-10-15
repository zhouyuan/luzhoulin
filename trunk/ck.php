<?php
error_reporting(0);
define('R_P',__FILE__ ? substr(__FILE__,0,-6) : './');
define('D_P',R_P);

$timestamp=time();
$x_size=60;
$y_size=20;
require_once(R_P.'data/cache/config.php');
require_once(R_P.'data/sql_config.php');
require_once(R_P.'require/db_'.$database.'.php');

$db = new DB($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);

$sid=GetCookie('sid');
$nmsg=num_rand(4);

if(!$sid){
	$sid = randstr(8);
	Cookie('sid',$sid);
	$db->update("REPLACE INTO pv_cknum SET sid='$sid',nmsg='$nmsg',time='$timestamp'");
}else{
	$newsid = randstr(8);
	Cookie('sid',$newsid);
	$db->update("UPDATE pv_cknum SET sid='$newsid',nmsg='$nmsg',time='$timestamp' WHERE sid='$sid'");
	if(!$db->affected_rows()){
		$db->update("REPLACE INTO pv_cknum SET sid='$newsid',nmsg='$nmsg',time='$timestamp'");
	}
}

if(function_exists('imagecreate') && function_exists('imagecolorallocate') && function_exists('imagepng') &&
function_exists('imagesetpixel') && function_exists('imageString') && function_exists('imagedestroy') && function_exists('imagefilledrectangle') && function_exists('imagerectangle')){
	$aimg = imagecreate($x_size,$y_size);
	$back = imagecolorallocate($aimg,255,255,255);
	$border = imagecolorallocate($aimg,0,0,0);
	imagefilledrectangle($aimg,0,0,$x_size - 1,$y_size - 1,$back);
	imagerectangle($aimg,0,0,$x_size - 1,$y_size - 1,$border);
  
    for($i=1; $i<=20;$i++){
		$dot = imagecolorallocate($aimg,mt_rand(50,255),mt_rand(50,255),mt_rand(50,255));
		imagesetpixel($aimg,mt_rand(1,$x_size-1), mt_rand(1,$y_size-1),$dot);
    }  
	for($i=1; $i<=10;$i++){
		imageString($aimg,1,$i*$x_size/10+mt_rand(1,3),mt_rand(1,15),'*',imageColorAllocate($aimg,mt_rand(150,255),mt_rand(150,255),mt_rand(150,255)));
	}
    for ($i=0;$i<strlen($nmsg);$i++){
		imageString($aimg,mt_rand(3,5),$i*$x_size/4+mt_rand(1,5),mt_rand(1,6),$nmsg[$i],imageColorAllocate($aimg,mt_rand(50,255),mt_rand(0,120),mt_rand(50,255)));
    }
	header("Pragma:no-cache");
	header("Cache-control:no-cache");
	header("Content-type: image/png");
    imagepng($aimg);
    imagedestroy($aimg);
	exit;
} else{
	header("Pragma:no-cache");
	header("Cache-control:no-cache");
	header("ContentType: Image/BMP");

	$Color[0] = chr(0).chr(0).chr(0);
	$Color[1] = chr(255).chr(255).chr(255);
	$_Num[0]  = "1110000111110111101111011110111101001011110100101111010010111101001011110111101111011110111110000111";
	$_Num[1]  = "1111011111110001111111110111111111011111111101111111110111111111011111111101111111110111111100000111";
	$_Num[2]  = "1110000111110111101111011110111111111011111111011111111011111111011111111011111111011110111100000011";
	$_Num[3]  = "1110000111110111101111011110111111110111111100111111111101111111111011110111101111011110111110000111";
	$_Num[4]  = "1111101111111110111111110011111110101111110110111111011011111100000011111110111111111011111111000011";
	$_Num[5]  = "1100000011110111111111011111111101000111110011101111111110111111111011110111101111011110111110000111";
	$_Num[6]  = "1111000111111011101111011111111101111111110100011111001110111101111011110111101111011110111110000111";
	$_Num[7]  = "1100000011110111011111011101111111101111111110111111110111111111011111111101111111110111111111011111";
	$_Num[8]  = "1110000111110111101111011110111101111011111000011111101101111101111011110111101111011110111110000111";
	$_Num[9]  = "1110001111110111011111011110111101111011110111001111100010111111111011111111101111011101111110001111";

	echo chr(66).chr(77).chr(230).chr(4).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(54).chr(0).chr(0).chr(0).chr(40).chr(0).chr(0).chr(0).chr(40).chr(0).chr(0).chr(0).chr(10).chr(0).chr(0).chr(0).chr(1).chr(0);
	echo chr(24).chr(0).chr(0).chr(0).chr(0).chr(0).chr(176).chr(4).chr(0).chr(0).chr(18).chr(11).chr(0).chr(0).chr(18).chr(11).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0);

	for ($i=9;$i>=0;$i--){
		for ($j=0;$j<=3;$j++){
			for ($k=1;$k<=10;$k++){
				if(mt_rand(0,7)<1){
					echo $Color[mt_rand(0,1)];
				}else{
					echo $Color[substr($_Num[$nmsg[$j]], $i * 10 + $k, 1)];
				}
			}
		}
	}
	exit;
}

function Cookie($ck_Var,$ck_Value,$ck_Time = 'F'){
	global $timestamp;
	$ck_Time = $ck_Time == 'F' ? $timestamp + 31536000 : ($ck_Value == '' && $ck_Time == 0 ? $timestamp - 31536000 : $ck_Time);
	setCookie($ck_Var,$ck_Value,$ck_Time);
}
function GetCookie($Var){
    return $_COOKIE[$Var];
}
function readover(){
}
function writeover($filename,$data,$method="rb+",$iflock=1,$check=1,$chmod=1){
	$check && strpos($filename,'..')!==false && exit('Forbidden');
	touch($filename);
	$handle=fopen($filename,$method);
	if($iflock){
		flock($handle,LOCK_EX);
	}
	fwrite($handle,$data);
	if($method=="rb+") ftruncate($handle,strlen($data));
	fclose($handle);
	$chmod && @chmod($filename,0777);
}
function num_rand($lenth){
	mt_srand((double)microtime() * 1000000);
	for($i=0;$i<$lenth;$i++){
		$randval.= mt_rand(1,6);
	}
	return $randval;
}
function randstr($lenth){
	mt_srand((double)microtime() * 1000000);
	for($i=0;$i<$lenth;$i++){
		$randval.= mt_rand(0,9);
	}	$randval=substr(md5($randval.time().$_SERVER["HTTP_USER_AGENT"]),mt_rand(0,32-$lenth),$lenth);
	return $randval;
}
?>