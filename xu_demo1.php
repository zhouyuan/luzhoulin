<?php
include("xu_class.php");
$myUpload = new XUpload_class;
$myUpload->SetMaxFileSize(1048576000);
$myUpload->SetOverlayMode(true); // 覆盖同名文件
$myUpload->InitParameters();
$myUpload->SetAllowExt("iac");
if ($myUpload->IsUploadFile()) {
	// 将文件保存在文件夹 upload 下
	//print_r($_POST);
	$filename = $myUpload->CreateFileName("upload","",$_POST['xu_tag'].".iac");
	if ($filename != "") $filename = $myUpload->SaveToFile($filename);
	if ($filename != "") {
		$filename = $myUpload->CreateFileURL("upload","",$filename);
		$myUpload->Out($filename);
	}
}


?>