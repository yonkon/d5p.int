<?php
/**
 * Скачивание файлов
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2011 
 * @link http://shiftcms.net
 * @version 1.00.01
 */
if(!defined("SHIFTCMS")) exit;

if(isset($_REQUEST['type']) && $_REQUEST['type']=="price"){
	$rs = $db->Execute("SELECT * FROM su_price WHERE id='$_REQUEST[id]'");
	if($rs -> RecordCount() > 0){
		$tmp=$rs->GetRowAssoc();
		$r = $db->Execute("UPDATE su_price SET `p_downloads`=`p_downloads`+1 WHERE id='$_REQUEST[id]'");
		$name=$tmp['P_FILE'];
		$fp=$_SERVER['DOCUMENT_ROOT']."/tmp/price/".$tmp['P_FILE'];
		$pp = pathinfo($tmp['P_FILE']);
		$ext=$pp['extension'];
	}else{
		echo $alang_ar['gf_notfound']; exit;
	}
}else if(isset($_REQUEST['type']) && $_REQUEST['type']=="SQLDump"){
	$name = stripslashes($_REQUEST['fl']);
	$fp=$_SERVER['DOCUMENT_ROOT']."/".$name;
	$pp = pathinfo($name);
	$ext=$pp['extension'];
}else if(isset($_REQUEST['type']) && $_REQUEST['type']=="attach"){
	$rs = $db->Execute("SELECT * FROM su_mail_attach WHERE id='$_REQUEST[id]'");
	$tmp=$rs->GetRowAssoc();
	$name=$tmp['FNAME'];
	$fp=$_SERVER['DOCUMENT_ROOT']."/".$tmp['FNAME'];
	$pp = pathinfo($tmp['FNAME']);
	$ext=$pp['extension'];
}else{
	exit;
}
	
$mt=array(
'bmp'=>'image/bmp',
'gif'=>'image/gif',
'jpeg'=>'image/jpeg',
'jpg'=>'image/jpeg',
'jpe'=>'image/jpeg',
'png'=>'image/png',
'tiff'=>'image/tiff',
'tif'=>'image/tiff',
'au'=>'audio/basic',
'snd'=>'audio/basic',
'mid'=>'audio/midi',
'midi'=>'audio/midi',
'kar'=>'audio/midi',
'mpga'=>'audio/mpeg',
'mp2'=>'audio/mpeg',
'mp3'=>'audio/mpeg',
'ram'=>'audio/x-pn-realaudio',
'rm'=>'audio/x-pn-realaudio',
'rpm'=>'audio/x-pn-realaudio-plugin',
'ra'=>'audio/x-realaudio',
'wav'=>'audio/x-wav',
'mpeg'=>'video/mpeg',
'mpg'=>'video/mpeg',
'mpe'=>'video/mpeg',
'qt'=>'video/quicktime',
'mov'=>'video/quicktime',
'avi'=>'video/x-msvideo',
'movie'=>'video/x-sgi-movie',
'wrl'=>'model/vrml',
'vrml'=>'model/vrml',
'css'=>'text/css',
'html'=>'text/html',
'htm'=>'text/html',
'asc'=>'text/plain',
'txt'=>'text/plain',
'rtx'=>'text/richtext',
'rtf'=>'text/rtf',
'sgml'=>'text/sgml',
'sgm'=>'text/sgml',
'xml'=>'text/xml',
'gtar'=>'application/x-gtar',
'tar'=>'application/x-tar',
'zip'=>'application/zip',
'rar'=>'application/rar',
'doc'=>'application/msword',
'docx'=>'application/msword',
'xls'=>'application/vnd.ms-excel',
'xlsx'=>'application/vnd.ms-excel',
'ppt'=>'application/vnd.ms-powerpoint',
'wbxml'=>'application/vnd.wap.wbxml',
'wmlc'=>'application/vnd.wap.wmlc',
'wmlsc'=>'application/vnd.wap.wmlscriptc',
'wbmp'=>'image/vnd.wap.wbmp',
'wml'=>'text/vnd.wap.wml',
'wmls'=>'text/vnd.wap.wmlscript',
'bin'=>'application/octet-stream',
'dms'=>'application/octet-stream',
'lha'=>'application/octet-stream',
'exe'=>'application/octet-stream',
'class'=>'application/octet-stream',
'pdf'=>'application/pdf',
'ai'=>'application/postscript',
'eps'=>'application/postscript',
'ps'=>'application/postscript',
'swf'=>'application/x-shockwave-flash'
);                 
 
	
if(isset($mt[$ext])) $mime=$mt[$ext];
else $mime="application/zip";


header("Content-Type: $mime; name=\"$name\"");
header("Content-Disposition: inline; filename=\"$name\"");
$fh=fopen($fp, "rb");
fpassthru($fh);
exit;
?>