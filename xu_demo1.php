<?php
include("xu_class.php");
$myUpload = new XUpload_class;
$myUpload->SetMaxFileSize(1048576000);
$myUpload->SetOverlayMode(true); // ����ͬ���ļ�
$myUpload->InitParameters();
$myUpload->SetAllowExt("iac");
if ($myUpload->IsUploadFile()) {
	// ���ļ��������ļ��� upload ��
	//print_r($_POST);
	$filename = $myUpload->CreateFileName("upload","",$_POST['xu_tag'].".iac");
	if ($filename != "") $filename = $myUpload->SaveToFile($filename);
	if ($filename != "") {
		$filename = $myUpload->CreateFileURL("upload","",$filename);
		$myUpload->Out($filename);
	}
}


?>