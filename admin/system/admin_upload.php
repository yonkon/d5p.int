<?php
/**
 * Скрипт файл-менеджер
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2011 
 * @link http://shiftcms.net
 * @version 1.01.01
 */

if(!defined('SHIFTCMS')){
	exit;
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="UploadFile"){
	$fp=$_REQUEST['f'];
	$pp = pathinfo($fp);
	$name = $pp['basename'];
	$ext=$pp['extension'];
	if(isset($mt[$ext])) $mime=$mt[$ext];
	else $mime="application/zip";
	header("Content-Type: $mime; name=\"$name\"");
	header("Content-Disposition: inline; filename=\"$name\"");
	$fh=fopen($fp, "rb");
	fpassthru($fh);
	exit;
}



$smarty -> assign("PAGETITLE","<h2><a href='admin.php?p=".$p."'>".$alang_ar['afck_title']."</a></h2>");

//---------------------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="UploadFiles"){
	include "include/uploader.php";
	$upl = new uploader;
$farr=$upl->ConvertFileArray("userfile");
$upl -> rewrite = 1;
$pinfo="<b>".$alang_ar['afck_msg1'].":</b><br>";
while(list($key,$val)=each($farr)){
	$dir = str_replace($_conf['disk_patch'],'',$_REQUEST['dirs']);
	$filename=$dir.$val['name'];
	$upl -> fname = $filename;
	$res = $upl -> SaveFile($val);
	if($res == 1){
		$pinfo .= $filename." ($val[size] байт)<br />";
	}else{
		if(trim($val['name'])!="") $pinfo .= $res."<br />";
	}
}
echo msg_box($pinfo);
}

//-----------------------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="make_file"){
   $nfile=$_REQUEST['dirs'].$_REQUEST['new_file'];
   $nf=fopen($nfile,"w");
   fclose($nf);
   @chmod($nfile,0777);
   echo msg_box(sprintf($alang_ar['afck_msg5'], $_REQUEST['new_file']));
}
//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="make_dir"){
   $pndir=$_REQUEST['dirs'].$_REQUEST['new_dir'];
	include("include/uploader.php");
	$upl = new uploader;
	if(!is_dir($pndir)) $upl -> MakeDir($pndir);
   echo msg_box(sprintf($alang_ar['afck_msg2'], $_REQUEST['new_dir']));
}
//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="free_trash"){
   $iq="SELECT * FROM ".$_SESSION['conf']['prefix']."trash";
   $ir = $db -> Execute($iq);
   while(!$ir -> EOF){
   	$it = $ir -> GetRowAssoc(false);
      $source="tmp/trash/".$it['name'];
      unlink($source);
	  $ir -> MoveNext();
   }
   $dq="DELETE FROM ".$_SESSION['conf']['prefix']."trash";
   $dr = $db -> Execute($dq);
   echo msg_box($alang_ar['afck_trashempty']);
}
//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="restore_trash"){
   $iq="SELECT * FROM ".$_SESSION['conf']['prefix']."trash";
   $ir = $db -> Execute($iq);
   while(!$ir -> EOF){
   	$it = $ir -> GetRowAssoc(false);
      $pp = pathinfo($it['source']);
      if (!file_exists($pp['dirname'])){
             mkdir($pp['dirname']);
      }
         $source="tmp/trash/".$it['name'];
         copy($source, $it['source']);
         unlink($source);
		 $ir -> MoveNext();
   }
   $dq="DELETE FROM ".$_SESSION['conf']['prefix']."trash";
   $dr = $db -> Execute($dq);
   echo msg_box($alang_ar['afck_trashrest']);
}
//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="restore_one"){
   $iq="SELECT * FROM ".$_SESSION['conf']['prefix']."trash WHERE name='$_REQUEST[fname]'";
   $ir = $db -> Execute($iq);
   while(!$ir -> EOF){
   	$it = $ir -> GetRowAssoc(false);
      $pp = pathinfo($it['source']);
      if (!file_exists($pp['dirname'])){
             mkdir($pp['dirname']);
      }
         $source="tmp/trash/".$it['name'];
         copy($source, $it['source']);
         unlink($source);
		$ir -> MoveNext();
   }
   $dq="DELETE FROM ".$_SESSION['conf']['prefix']."trash  WHERE name='$_REQUEST[fname]'";
   $dr = $db -> Execute($dq);
   echo msg_box(sprintf($alang_ar['afck_msg6'], $_REQUEST['fname']));
}
//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="del_file"){
   $pp = pathinfo($_REQUEST['del_file']);
   $dest="tmp/trash/".$pp['basename'];
   copy($_REQUEST['del_file'], $dest);
   unlink($_REQUEST['del_file']);
   $iq="INSERT INTO ".$_SESSION['conf']['prefix']."trash(idt,source,name) VALUES
   ('','$_REQUEST[del_file]','$pp[basename]')";
   $ir = $db -> Execute($iq);
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
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="edit_file"){
	$tpl_cont = str_replace("<","&lt;",file_get_contents($_REQUEST['edit_file']));
	echo "<h2>".$alang_ar['aephp_edit']."</h2>";
	echo '
	<table border="0"><tr><td>
	<form action="admin.php?p='.$p.'&act=save_edit_file&dirs='.stripslashes($_REQUEST['dirs']).'&edit_file='.stripslashes($_REQUEST['edit_file']).'" method="post">
	<b>'.$_REQUEST['edit_file'].'</b><br>
	<textarea name="editcont" id="editcont" cols="130" rows="30">'.$tpl_cont.'</textarea><br />
	<input type="submit" name="tpl_save" value="'.$alang_ar['save'].'" />
	</form>
	</td></tr></table>';
}
//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="save_edit_file"){
   $edit_patch = stripslashes($_REQUEST['edit_file']);
   $edit_cont = stripslashes($_REQUEST['editcont']);
   $fp = fopen($edit_patch, "w");
   fwrite($fp, $edit_cont);
   fclose($fp);
   echo msg_box("$edit_patch ".$alang_ar['aephp_saved']);
}
//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="ren_file"){
	echo "<h2>$alang_ar[rename]</h2>
	<table border=0><tr><td>
	<form action=admin.php method=post>
	<input type=hidden name=ren_file value=\"$_REQUEST[ren_file]\">
	<input type=hidden name=p value=\"$_REQUEST[p]\">
	<input type=hidden name=dirs value=\"$_REQUEST[dirs]\">
	<input type=hidden name=act value=\"save_ren_file\">
	<input type=text name=new_file value=\"$_REQUEST[ren_file]\" size=25> <input type=submit name=tpl_save value=\"$alang_ar[save]\">
	</form>
	</td></tr></table>";
}
//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="save_ren_file"){
   $old_file = stripslashes($_REQUEST['dirs'].$_REQUEST['ren_file']);
   $new_file = stripslashes($_REQUEST['dirs'].$_REQUEST['new_file']);
   rename ($old_file, $new_file);
   echo msg_box(sprintf($alang_ar['arn_msg1'], $old_file, $new_file));
}
//---------------------------------------------------------------
$dirs=$_conf['disk_patch'];
if(isset($_REQUEST['dirs'])) $dirs=$_REQUEST['dirs'];
if (is_dir($dirs)) {
$files_ar=array();
$dirs_ar=array();
echo "<b>".$dirs."</b><hr>";
    if ($dh = opendir($dirs)) {
    echo "<table border='0' cellpadding='2'><tr><td valign=top>
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
for($i=0;$i<count($file_ar);$i++){
            $f_img='';
            if($file_ar[$i]!=".") {
              $fpt=$file_ar[$i];
              $ndirs=$dirs.$fpt;
              $check_dir=$ndirs;
              $path_parts = pathinfo($ndirs);
              if(!isset($path_parts['extension'])) $path_parts['extension']="";

              if(is_writable($ndirs)) $links="<a href=\"admin.php?p=".$_REQUEST['p']."&dirs=".$dirs."&del_file=".$ndirs."&act=del_file\"><img src=\"".$_conf['admin_tpl_dir']."img/delit.png\" BORDER=0 alt=\"".$alang_ar['delete']."\"></a>";

              if(is_writable($ndirs)) $links.="&nbsp;<a href=\"admin.php?p=".$_REQUEST['p']."&dirs=".$dirs."&ren_file=".$fpt."&act=ren_file\"><img src=\"".$_conf['admin_tpl_dir']."img/rename.gif\" BORDER=0 alt=\"".$alang_ar['rename']."\"></a>";

              if(($path_parts['extension']=="php" ||
			  $path_parts['extension']=="js" ||
			  $path_parts['extension']=="ini" ||
			  $path_parts['extension']=="log" ||
			  $path_parts['extension']=="txt" || 
			  $path_parts['extension']=="css" ||
			  $file_ar[$i]==".htaccess" ||
			  $path_parts['extension']=="xml" ||
			  $path_parts['extension']=="sql" || 
			  $path_parts['extension']=="tpl" ||
			  $path_parts['extension']=="htm" ||
			  $path_parts['extension']=="html" ||
			  $path_parts['extension']=="shtml" ||
			  $path_parts['extension']=="shtm" ||
			  $path_parts['extension']=="config") &&
			  is_writable($ndirs)) $links .= "&nbsp;<a href=\"admin.php?p=".$_REQUEST['p']."&dirs=".$dirs."&edit_file=".$ndirs."&act=edit_file\"><img src=\"".$_conf['admin_tpl_dir']."img/edit.png\" border='0' alt=\"".$alang_ar['edit']."\" /></a>";

              if($path_parts['dirname']=="tmp/trash") {
              $links="<a href=\"admin.php?p=".$_REQUEST['p']."&dirs=".$dirs."&del_file=".$ndirs."&act=del_file\"><img src=\"".$_conf['admin_tpl_dir']."img/delit.png\" border='0' alt=\"".$alang_ar['delete']."\" /></a>";
              $links.="     <a href=\"admin.php?p=".$p."&dirs=".$dirs."&act=restore_one&fname=".$path_parts['basename']."\"><img src=\"".$_conf['admin_tpl_dir']."img/rename.gif\" border='0' alt=\"".$alang_ar['restore']."\" /></a>";
              }
              if(@is_dir($ndirs)&&$file_ar[$i]!=".htaccess"){
                 $f_img="<img src=\"".$_conf['admin_tpl_dir']."img/folder.png\" border=0> ";
                 if($file_ar[$i]==".."){
                      $ndirs=substr($ndirs,0,-4);
                      $last_slash=strrpos($ndirs,"/")+1;
                      $ndirs=substr($ndirs,0,$last_slash);
                      $f_img="<a href=\"admin.php?p=".$_REQUEST['p']."&dirs=".$ndirs."\"><img src=\"".$_conf['admin_tpl_dir']."img/arrow_ltr.png\" border='0' /></a> ";
                      if($dirs==$_conf['disk_patch']){
                          $fpt="";
                          $f_img="";
                      }
                      $links="";
                 }else{
                    $ndirs=$ndirs."/";
                 }
                 $fpt="<a href=\"admin.php?p=".$_REQUEST['p']."&dirs=".$ndirs."\">".$fpt."</a>";
                 if($file_ar[$i]!="..") {
                    $links="<a href=\"admin.php?p=".$_REQUEST['p']."&dirs=".$dirs."&del_dir=".$ndirs."&act=del_dir\"><img src=\"".$_conf['admin_tpl_dir']."img/delit.png\" BORDER=0 alt=\"".$alang_ar['delete']."\"></a>";
                    $links.="     <a href=\"admin.php?p=".$p."&dirs=".$dirs."&ren_file=".$file_ar[$i]."&act=ren_file\"><img src=\"".$_conf['admin_tpl_dir']."img/rename.gif\" BORDER=0 alt=\"".$alang_ar['rename']."\"></a>";
                 }
              }else{
                 if($path_parts['extension']=="php") $f_img="<img src=\"".$_conf['admin_tpl_dir']."img/text.png\" border=0> ";
                 if($path_parts['extension']=="css") $f_img="<img src=\"".$_conf['admin_tpl_dir']."img/binary.png\" border=0> ";
				 if(file_exists("include/FCKeditor/editor/filemanager/browser/default/images/icons/".$path_parts['extension'].".gif")) $f_img="<img src=\"include/FCKeditor/editor/filemanager/browser/default/images/icons/".$path_parts['extension'].".gif\" border=0> ";
                 if($path_parts['extension']=="tpl") $f_img="<img src=\"".$_conf['admin_tpl_dir']."img/html.png\" border=0> ";
              }
              if($file_ar[$i]==".htaccess") $f_img="<img src=\"".$_conf['admin_tpl_dir']."img/binary.png\" border=0> ";
              if(strtolower($path_parts['extension'])=="png"||strtolower($path_parts['extension'])=="ico") $f_img="<img src=\"".$_conf['admin_tpl_dir']."img/img.gif\" border=0> ";
              if($f_img=='')  $f_img="<img src=\"include/FCKeditor/editor/filemanager/browser/default/images/icons/default.icon.gif\" border=0> ";
              clearstatcache ();
              if((!@is_dir($ndirs) && $ndirs!="..") || (strlen($ndirs) >= strlen($_conf['disk_patch']))) $file_size=@get_filesize(filesize($ndirs));
              else $file_size="";
			  clearstatcache();
			  $permision = substr(sprintf('%o', fileperms($ndirs)), -4);
              if(strlen($ndirs)>=strlen($_conf['disk_patch'])) $dac=date ("d.m.Y H:i:s", @filemtime($ndirs));
              else $dac='';
			  if(is_file($ndirs)){
			  	$uploadlink = "<a href='admin.php?p=admin_upload&act=UploadFile&f=".$ndirs."'><img src='".$_conf['admin_tpl_dir']."img/download.png' width='16' height='16' alt='".$alang_ar['afck_download']."' /></a>";
			  }else{
			  	$uploadlink = "";
			  }
             if($dac=='' && $file_size=='') echo '';
             else echo "<tr bgcolor=#F0F0F0><td><b>".$f_img." ".$fpt."</b></td>
             <td><font style=\"font-size:8pt\">".$file_size."</font></td>
             <td><font style=\"font-size:8pt;color:brown;\">".$permision."</font></td>
             <td><font style=\"font-size:8pt;color:#003300;\">".$dac."</font></td>
                <td>".$links."</td>
                <td>".$uploadlink."</td>
				</tr>";
            }
}
echo "</table></td><td class=left valign=top align=center>
<form action='admin.php' method='post'>
<b>".$alang_ar['afck_createdir']."</b><br>
  <input type=hidden name=dirs value=\"".$dirs."\">
  <input type=hidden name=p value=\"admin_upload\">
  <input type=hidden name=act value=\"make_dir\">
  <input type=text name=new_dir size=25><br>
  <input type=submit value=\"".$alang_ar['save']."\">
</form>
<form action='admin.php' method='post'>
<b>".$alang_ar['afck_createfile']."</b><br>
  <input type=hidden name=dirs value=\"".$dirs."\">
  <input type=hidden name=p value=\"admin_upload\">
  <input type=hidden name=act value=\"make_file\">
  <input type=text name=new_file size=25><br>
  <input type=submit value=\"".$alang_ar['save']."\">
</form>

<table border='0' cellspacing='2' align='center'>
<caption><b>".$alang_ar['afck_upload'].":</b></caption>
<form action='admin.php' method='post' enctype='multipart/form-data'>
  <input type='hidden' name='act' value=\"UploadFiles\">
  <input type=hidden name=dirs value=\"".$dirs."\">
  <input type=hidden name=p value=\"admin_upload\">
 <tr>
 <td>
  <input name=userfile[] type=file /><br>
  <input name=userfile[] type=file /><br>
  <input name=userfile[] type=file /><br>
  <input name=userfile[] type=file /><br>
  <input name=userfile[] type=file /><br>

  <input name=userfile[] type=file /><br>
  <input name=userfile[] type=file /><br>
  <input name=userfile[] type=file /><br>
  <input name=userfile[] type=file /><br>
  <input name=userfile[] type=file /><br>

   <input name=userfile[] type=file /><br>
  <input name=userfile[] type=file /><br>
  <input name=userfile[] type=file /><br>
  <input name=userfile[] type=file /><br>
  <input name=userfile[] type=file /><br>

  <input name=userfile[] type=file /><br>
  <input name=userfile[] type=file /><br>
  <input name=userfile[] type=file /><br>
  <input name=userfile[] type=file /><br>
  <input name=userfile[] type=file /><br>
</td>
</tr><tr><td>
  <input type=submit value=\"".$alang_ar['save']."\">
</td></tr>
</form>
</table>
";

//---TRASH--------------------------------------------
$tq="SELECT count(*) FROM ".$_conf['prefix']."trash";
   $r = $db -> Execute($tq);
   $t = $r -> GetRowAssoc(false);
   $tt = $t['count(*)'];
if($tt==0){
   echo "<br><a href=\"admin.php?p=admin_upload&dirs=./tmp/trash/\" title=\"".$alang_ar['afck_trash_isempty']."\"><img src=\"".$_conf['admin_tpl_dir']."img/empty_rec.gif\" border=0></a><br>";
}
if($tt['0']!=0){
   echo "<br><a href=\"admin.php?p=".$p."&dirs=".$dirs."&act=free_trash\">".$alang_ar['afck_clear']."</a><br>
   <a href=\"?p=admin_upload&dirs=./tmp/trash/\" title=\"".$alang_ar['open']."\"><img src=\"".$_conf['admin_tpl_dir']."img/full_rec.gif\" border=0></a><br>
   <a href=\"admin.php?p=".$p."&dirs=".$dirs."&act=restore_trash\">".$alang_ar['restore']."</a>";
}

echo "</td></tr></table>";






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
?>
