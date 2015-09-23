<?php
if(!defined('SHIFTCMS')){
	exit;
}

$smarty -> assign("PAGETITLE","<h2>".$alang_ar['afck_title']."</h2>");

if(isset($_REQUEST['CKEditor'])) $_SESSION['ut'] = 'ck';
if(isset($_REQUEST['FCK'])) $_SESSION['ut'] = 'fck';
if(!$_SESSION['ut']) $_SESSION['ut'] = 'fck';

// --------------------------------------------------------------------------

$dirs = $basedir = $_SERVER['DOCUMENT_ROOT'].$_conf['fck_dir'];
if(isset($_SESSION['fck_cur_dir'])) $dirs = $_SESSION['fck_cur_dir'];
if(isset($_REQUEST['dirs'])) $dirs = $_REQUEST['dirs'];
$_SESSION['fck_cur_dir'] = $dirs;

$th_dir = $_conf['upldir']."/_th";
$th_size = array('width'=>70,'height'=>70);
//------------------------------------------------------------------------
	include "include/uploader.php";
	$upl = new uploader;
	if(!is_dir($th_dir)) $upl->MakeDir($th_dir);


$mt = array(
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

//---------------------------------------------------------------
if(isset($_REQUEST['act']) && $_REQUEST['act']=="UploadFile"){
	$fp = $_REQUEST['f'];
	$pp = pathinfo($fp);
	$name = $pp['basename'];
	$ext = $pp['extension'];
	if(isset($mt[$ext])) $mime = $mt[$ext];
	else $mime="application/zip";
	header("Content-Type: $mime; name=\"$name\"");
	header("Content-Disposition: inline; filename=\"$name\"");
	$fh=fopen($fp, "rb");
	fpassthru($fh);
	exit;
}

//---------------------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="UploadFiles"){
	$farr = $upl->ConvertFileArray("userfile");
	$upl -> rewrite = 1;
	$pinfo = "<b>".$alang_ar['afck_msg1'].":</b><br>";
	while(list($key,$val) = each($farr)){
		$dir = str_replace($_conf['disk_patch'],'',$_REQUEST['dirs']);
		$filename = $dir.$val['name'];
		$upl -> fname = $filename;
		$res = $upl -> SaveFile($val);
		if($res == 1){
			$pinfo .= $filename." (".$val['size']." байт)<br />";
			$pp = pathinfo($filename);
			if(strtolower($pp['extension'])=="jpg" || strtolower($pp['extension']=="gif") || strtolower($pp['extension']=="jpeg") || strtolower($pp['extension']=="png")){
				makeImagePreviev($filename, $th_dir, $th_size);
			}
		}else{
			if(trim($val['name'])!="") $pinfo .= $res."<br />";
		}
	}
	echo msg_box($pinfo);
}
//-----------------------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="make_dir"){
   $pndir=$_REQUEST['dirs'].$_REQUEST['new_dir'];
	if(!is_dir($pndir)) $upl -> MakeDir($pndir);
   echo msg_box(sprintf($alang_ar['afck_msg2'], $_REQUEST['new_dir']));
}
//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="del_file"){
   unlink($_REQUEST['del_file']);
   $pp = pathinfo($_REQUEST['del_file']);
   if(file_exists($th_dir.'/'.$pp['basename'])) @unlink($th_dir.'/'.$pp['basename']);
   echo msg_box(sprintf($alang_ar['afck_msg3'], $_REQUEST['del_file']));
}
//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="del_dir"){
   if(@rmdir($_REQUEST['del_dir'])){
      echo msg_box(sprintf($alang_ar['afck_msg3'], $_REQUEST['del_dir']));
   }else{
      echo msg_box(sprintf($alang_ar['afck_msg4'], $_REQUEST['del_dir']));
   }
}
//---------------------------------------------------------------
if(is_dir($dirs)) {
	$files_ar=array();
	$dirs_ar=array();
	echo "<b>".str_replace($basedir, "", $dirs)."</b><hr>";
	    if ($dh = opendir($dirs)) {
	    echo "<table border='0' cellpadding='2'><tr><td valign='top' style='width:450px;'>
	            <table border='0' cellpadding='0' cellspacing='0' class='selrow'>";
	        $k=0;
	        while (($file = readdir($dh)) !== false) {
	              if(@is_file($dirs.$file)) $files_ar[$k]=$file;
	              else $dirs_ar[$k]=$file;
	              $k++;
	        }
	        closedir($dh);
	    }
	}
	sort($files_ar);
	reset($files_ar);
	sort($dirs_ar);
	reset($dirs_ar);
	$file_ar=array_merge($dirs_ar,$files_ar);
	$makepreview = 0;
	for($i=0;$i<count($file_ar);$i++){
            $f_img='';
            if($file_ar[$i]!=".") {
              $fpt=$file_ar[$i];
              $ndirs=$dirs.$fpt;
              $check_dir=$ndirs;
              $path_parts = pathinfo($ndirs);
              if(!isset($path_parts['extension'])) $path_parts['extension']="";
              $links = "<a href=\"admin.php?p=".$_REQUEST['p']."&dirs=".$dirs."&del_file=".$ndirs."&act=del_file\"><img src=\"".$_conf['admin_tpl_dir']."img/delit.png\" BORDER=0 alt=\"".$alang_ar['delete']."\"></a>";
              if(@is_dir($ndirs) && $file_ar[$i]!=".htaccess"){
                 $f_img="<img src=\"".$_conf['admin_tpl_dir']."img/folder.png\" border=0> ";
                 if($file_ar[$i]==".."){
                      $ndirs = substr($ndirs,0,-4);
                      $last_slash = strrpos($ndirs,"/")+1;
                      $ndirs = substr($ndirs,0,$last_slash);
                      $f_img = "<a href=\"admin.php?p=".$_REQUEST['p']."&dirs=".$ndirs."\"><img src=\"".$_conf['admin_tpl_dir']."img/arrow_ltr.png\" border=0></a> ";
						if(strlen($dirs) <= strlen($_SERVER['DOCUMENT_ROOT']."/".$_conf['fck_dir'])){
                          $fpt = "";
                          $f_img = "";
                      }
                      $links="";
                 }else{
                    $ndirs = $ndirs."/";
                 }
                 $fpt = "<a href=\"?p=".$_REQUEST['p']."&dirs=".$ndirs."\">$fpt</a>";
                 if($file_ar[$i]!="..") {
                    $links = "<a href=\"admin.php?p=$_REQUEST[p]&dirs=".$dirs."&del_dir=".$ndirs."&act=del_dir\"><img src=\"".$_conf['admin_tpl_dir']."img/delit.png\" BORDER=0 alt=\"".$alang_ar['delete']."\"></a>";
                    //$links.="     <a href=\"?p=$_REQUEST[p]&dirs=$dirs&ren_file=$file_ar[$i]&act=ren_file\"><img src=\"$_conf[admin_tpl_dir]img/rename.gif\" BORDER=0 alt=\"$alang_ar[rename]\"></a>";
                 }
              }else{
				if((strtolower($path_parts['extension'])=="jpg" || strtolower($path_parts['extension']=="gif") || strtolower($path_parts['extension']=="jpeg") || strtolower($path_parts['extension']=="png")) && $makepreview<10){
					makeImagePreviev($ndirs, $th_dir, $th_size);
					$makepreview++;
				}
				  
                 if($path_parts['extension']=="php") $f_img="<img src=\"".$_conf['admin_tpl_dir']."img/text.png\" border=0> ";
                 if($path_parts['extension']=="css") $f_img="<img src=\"".$_conf['admin_tpl_dir']."img/binary.png\" border=0> ";
				 if(file_exists("include/FCKeditor/editor/filemanager/browser/default/images/icons/".$path_parts['extension'].".gif")) $f_img="<img src=\"include/FCKeditor/editor/filemanager/browser/default/images/icons/".$path_parts['extension'].".gif\" border=0> ";
                 if($path_parts['extension']=="tpl") $f_img="<img src=\"".$_conf['admin_tpl_dir']."img/html.png\" border=0> ";
              }
              if($file_ar[$i]==".htaccess") $f_img="<img src=\"".$_conf['admin_tpl_dir']."img/binary.png\" border=0> ";
              if(strtolower($path_parts['extension'])=="png"||strtolower($path_parts['extension'])=="ico") $f_img="<img src=\"$_conf[admin_tpl_dir]img/img.gif\" border=0> ";
              if($f_img=='')  $f_img="<img src=\"include/FCKeditor/editor/filemanager/browser/default/images/icons/default.icon.gif\" border=0> ";
              clearstatcache ();
              if((!@is_dir($ndirs)&&$ndirs!="..")||(strlen($ndirs)>=strlen($_conf['disk_patch']))) $file_size=@get_filesize(filesize($ndirs));
              else $file_size="";
			  clearstatcache();
			  $permision = substr(sprintf('%o', fileperms($ndirs)), -4);
              if(strlen($ndirs)>=strlen($_conf['disk_patch'])) $dac=date ("d/m/Y H:i:s", @filemtime($ndirs));
              else $dac='';
			 $ddr = str_replace($_SERVER['DOCUMENT_ROOT']."/", "", $dirs);
			  $f_img = file_exists($th_dir.'/'.$path_parts['basename'])&&is_file($th_dir.'/'.$path_parts['basename']) ? '<img src="'.$th_dir.'/'.$path_parts['basename'].'" style="vertical-align:middle;" />' : $f_img;
			  if(is_file($ndirs)){
			  	$uploadlink = "<a href='admin.php?p=admin_fck_upload&act=UploadFile&f=".$ndirs."'><img src='".$_conf['admin_tpl_dir']."img/download.png' width='16' height='16' alt='".$alang_ar['afck_download']."' /></a>";
			  }else{
			  	$uploadlink = "";
			  }
             if($dac=='' && $file_size=='') echo '';
             else{
			 	if(is_dir($ndirs)) echo "<tr bgcolor=#F0F0F0><td align='center' valign='middle'>".$f_img."</td><td>".$fpt."</td>";
				else  echo "<tr bgcolor=#F0F0F0><td align='center' valign='middle'>".$f_img."</td><td><a href='javascript:void(null)' 
			 	onclick=\"OpenFile('".$ddr.$fpt."', '".$_SESSION['ut']."')\">".$fpt."</a></td>";
			 
             	echo "<td><font style=\"font-size:8pt\">$file_size</font></td>
	             <td><font style=\"font-size:8pt;color:brown;\">".$permision."</font></td>
    	         <td><font style=\"font-size:8pt;color:#003300;\">".$dac."</font></td>
                <td>".$links."</td><td>".$uploadlink."</td></tr>";
			}
            }
}
echo "</table></td><td class=left valign=top align=center>

<form action='admin.php' method='post' enctype='multipart/form-data'>
<b>".$alang_ar['afck_createdir']."</b><br>
  <input type=hidden name=dirs value=\"".$dirs."\">
  <input type=hidden name=p value=\"admin_fck_upload\">
  <input type=hidden name=act value=\"make_dir\">
  <input type=text name=new_dir size=25><br>
  <input type=submit value=\"".$alang_ar['save']."\">
</form>

<form action='admin.php' method='post' enctype='multipart/form-data'>
<table border=0 cellspacing=2 align=center>
<caption><b>".$alang_ar['afck_upload'].":</b></caption>
  <input type='hidden' name='act' value=\"UploadFiles\">
  <input type='hidden' name='dirs' value=\"".$dirs."\">
  <input type='hidden' name='p' value=\"admin_fck_upload\">
 <tr>
 <td>
<input type='file' class='uploadinputbutton' name='userfile[]' onchange=\"return add_file('userfile', 1);\" /><br />
<span id='userfile_1'><input type='button' value='Добавить другой' onclick=\"return add_file('userfile', 1);\" /></span><br />
</td>
</tr><tr><td>
  <br /><input type=submit value=\"".$alang_ar['upload']."\">
</td></tr>
</table>
</form>
";
echo "</td></tr></table>";


function makeImagePreviev($filename, $th_dir, $th_size){
	if(!class_exists("imager")) include("include/imager.php");
	$pp = pathinfo($filename);
	$dest = $th_dir.'/'.$pp['basename'];
	if(!file_exists($dest)){
		$img = new imager;
		$img -> width=array($th_size['width']);
		$img -> height=array($th_size['height']);
		$img -> fname=array($dest);
		$img -> sign=array('');
		$img -> signtype=array('');
		$img -> crop=array('');
		$img -> whatcrop=array('');
		$img -> desttype=array('thumb');
		$img -> resizetype = 'square';
		$file_array = $img->getExistsImage($filename);
		$res = $img -> ResizeImage($file_array);
	}
}


?>

<script type="text/javascript">
function OpenFile(fileUrl, ut){
	if(ut=="ck") window.opener.CKEDITOR.tools.callFunction(2, fileUrl);
	if(ut=="fck"){
		window.top.opener.SetUrl(encodeURI("/"+fileUrl).replace( '#', '%23' ));
	}
	window.top.close() ;
	window.top.opener.focus() ;
}
</script>