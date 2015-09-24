<?
/**
* Главная страница системы учёта
* @package ShiftCMS
* @subpackage ORDER
* @version 1.00 15.02.2011
* @author Volodymyr Demchuk, http://shiftcms.net
*/

if(!defined('SHIFTCMS')){
	exit;
}

$dir = $_conf['docroot'].'/'.$_conf['tmpdir'].'/';
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
			if($file!="." && $file!=".." && filetype($dir . $file)!="dir"){
				@unlink($dir . $file);
			}
        }
        closedir($dh);
    }
}


$_REQUEST['JsHttpRequest'] = '1234567890';

$data = array();
$data['pars']['type'] = $_REQUEST['type'];
if(isset($_REQUEST['ida'])) $data['pars']['ida'] = $_REQUEST['ida'];
if(isset($_REQUEST['ido'])) $data['pars']['ido'] = $_REQUEST['ido'];
if(isset($_REQUEST['idf'])) $data['pars']['idf'] = $_REQUEST['idf'];
if(isset($_REQUEST['idd'])) $data['pars']['idd'] = $_REQUEST['idd'];
if(isset($_REQUEST['sop'])) $data['pars']['sop'] = $_REQUEST['sop'];
$res = SendRemoteRequest("LoadFile", $data);

if($res['status']['code']==0){
//-----------------------------------------------------------------------------

$tmpfile = $_conf['docroot']."/".$_conf['tmpdir']."/".$res['data']['fname'];
$fp = fopen($tmpfile, "wb");
fwrite($fp, base64_decode(trim($res['data']['fcont'])));
fclose($fp);

$ext = $res['data']['ext'];
$name = $res['data']['fname'];

	if($res['data']['fmd5']!=md5_file($tmpfile)){
		echo "Не совпадает md5 оригинального файла с полученным! Файл поврежден! Попробуйте еще раз!";
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
$ext = strtolower($ext);
if(isset($mt[$ext])) $mime=$mt[$ext];
else $mime="application/zip";

@ob_end_clean();
if(ini_get('zlib.output_compression')) @ini_set('zlib.output_compression', 'Off');
header('Pragma: public');
header('Content-Transfer-Encoding: none');
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
  header('Cache-Control: no-store, no-cache, must-revalidate'); 
  header('Cache-Control: post-check=0, pre-check=0', FALSE); 
  header("Content-Type: octet-stream");
header("Content-Type: $mime; name=\"$name\"");
header("Content-Disposition: inline; filename=\"$name\"");
header("Content-Length: ".filesize($tmpfile));
$fh = fopen($tmpfile, "rb");
@ob_end_clean();
fpassthru($fh);
//unlink($tmpfile);
exit;

} else {
	$PAGE .= '<strong>Ошибка:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
}
?>