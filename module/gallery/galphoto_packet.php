<?php
/**
 * Управление фотогалерей - пакетная загрузка фото на сервер
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.02	11.12.2009
 * Чтобы увеличить значения максимально возможного размера для загрузки файлов, надо в файл .htaccess добавить следующие строки
 * php_value upload_max_filesize 50M
 * php_value post_max_size 64M
 * php_value max_input_time 240
 */
if(!defined("SHIFTCMS")) exit;

$smarty -> assign("PAGETITLE","<h2><a href='admin.php?p=gallery_manage'>".$lang_ar['gal_title']."</a> : <a href='admin.php?p=galphoto_packet'>".$lang_ar['agal_packet']."</a></h2>");
$smarty -> assign("modSet", "gallery");

if(isset($_REQUEST['act']) && $_REQUEST['act']=="DelFromQueue"){
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."gal_queue WHERE id='".(int)$_REQUEST['id']."'");
	if($r -> RecordCount() == 0){
		echo msg_box($lang_ar['agal_tasknotfound']);
	}else{
		$t = $r -> GetRowAssoc(false);
		$file = stripslashes($t['folder'])."/".stripslashes($t['file']);
		@unlink($file);
		@rmdir(stripslashes($t['folder']));
		$rd = $db -> Execute("DELETE FROM ".$_conf['prefix']."gal_queue WHERE id='".(int)$_REQUEST['id']."'");
	}
	unset($_REQUEST['act']);
}


if(isset($_REQUEST['act']) && $_REQUEST['act']=="uploadZIP"){
//echo '<pre>';
//print_r($_FILES);
//echo '</pre>';
	$ids = $_REQUEST['ids'];
	include("include/uploader.php");
	$upl = new uploader;
	$filename = "tmp/".$_FILES['file']['name'];
	$upl -> fname = $filename;
	$upl -> rewrite = '1';
	$res = $upl -> SaveFile($_FILES['file']);
	$pp = pathinfo($filename);
	$ext = strtolower($pp['extension']);
	if($res == 1 && $ext != "zip") $res = $lang_ar['agal_onlyzip'];
	if($res == 1 && strtolower($ext) == "zip"){
		$pdir = "tmp/".time();
		$upl -> MakeDir($pdir);
		
		if(function_exists("zip_open")){ // используем библиотеку PHP
			include("include/zip/php_zip.inc.php");
			$ARCHIVE = new zip;
			$zinfo = $ARCHIVE->infosZip($filename, false); // get infos of this ZIP archive (without files content)
			//var_export($ARCHIVE->infosZip($filename)); // get infos of this ZIP archive (with files content)
				//echo '<pre>';
				//print_r($zinfo);
				//echo '</pre>';
			if($ARCHIVE->extractZip($filename, $pdir)){
			while(list($k,$v)=each($zinfo)){
				if($v['Size']!=0){
			  	echo "<small>$k ($v[Size] bytes)</small><br />";
				  chmod($pdir."/".$k, 0777); 
				  $r = $db -> Execute("INSERT INTO ".$_conf['prefix']."gal_queue (ids,folder,file,state,sdate1)VALUES
				  ('".$ids."', '".mysql_real_escape_string($pdir)."', '".mysql_real_escape_string($k)."','n','".time()."')");
				 }
			}
			}else{
				echo msg_box("Не удалось распаковать архив!");
			}

		}else{ // используем сторонню библиотеку
		
			include("include/zip/dUnzip2.inc.php");
			$zip = new dUnzip2($filename);
			//$zip->debug = 1; // debug?
			$list = $zip->getList();
			foreach($list as $sfileName=>$zippedFile){
				  echo "<small>$sfileName ($zippedFile[uncompressed_size] bytes)</small><br />";
				  if($zippedFile['uncompressed_size']==0){
				  	$nd = $pdir."/".$sfileName;
				  	if(!is_dir($nd)) $upl -> MakeDir($nd);
				  }else{
					  $zip->unzip($sfileName, $pdir."/".$sfileName);
					  chmod($pdir."/".$sfileName, 0777); 
					  $r = $db -> Execute("INSERT INTO ".$_conf['prefix']."gal_queue (ids,folder,file,state,sdate1)VALUES
					  ('".$ids."', '".mysql_real_escape_string($pdir)."', '".mysql_real_escape_string($sfileName)."','n','".time()."')");
				  }
			}
			$zip -> close();
		}
		echo msg_box($lang_ar['agal_taskadded']);
	}else{
		echo msg_box($res);
	}
	@unlink($filename);	
	//echo "<br /><br />"; print_r($_REQUEST); echo "<br /><br />";
	unset($_REQUEST['act']);
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="uploadFOLDER"){
	$er = 0; 
	$folder = stripslashes($_REQUEST['folder']);
	$ids = $_REQUEST['ids'];
	if(trim($folder)==""){
		$er = 1;
		echo msg_box($lang_ar['agal_error2']);
	}
	if(!is_dir("tmp/".$folder)){
		$er = 1;
		echo msg_box(sprintf($alang_ar['agal_error3'], $_SERVER['DOCUMENT_ROOT']));
	}
	if(is_dir("tmp/".$folder) && !is_writable("tmp/".$folder)){
		$er = 1;
		echo msg_box($lang_ar['agal_error4']);
	}
	if($er==0){
		$dirs = "tmp/".$folder;
	    if ($dh = opendir($dirs)) {
	        while (($file = readdir($dh)) !== false) {
				if($file!="." && $file!=".."){
	              if(is_file($dirs."/".$file)){
					//if($deltime > filemtime($dirs."/".$file)) @unlink($dirs."/".$file);
						echo "<small>".$dirs."/".$file."</small><br />";
					  $r = $db -> Execute("INSERT INTO ".$_conf['prefix']."gal_queue (ids,folder,file,state,sdate1)VALUES
					  ('".$ids."', '".mysql_real_escape_string($dirs)."', 
					  '".mysql_real_escape_string($file)."','n','".time()."')");
				  }
				}
	        }
	    closedir($dh);
	    }
		echo msg_box(sprintf($alang_ar['agal_ok2'], $dirs));
	}
	
	//echo "<br /><br />"; print_r($_REQUEST); echo "<br /><br />";
	unset($_REQUEST['act']);
}


if(!isset($_REQUEST['act'])){
	//if (!ini_set('upload_max_filesize', 20)) {
	    //echo "Не удалось изменить максимальный размер загружаемого файла.";
	//}

	$maxfilesize = ini_get("upload_max_filesize");
	
	$gal_list="<select id='ids' name='ids'>";
	$q="select * from ".$_conf['prefix']."galleries order by name_".$_conf['def_admin_lang'];
	$rs = $db -> Execute($q);
	while(!$rs -> EOF){
		$tmp = $rs -> GetRowAssoc(false);
		$gal_list.="<option value='$tmp[ids]'>$tmp[ids]: ".stripslashes($tmp['name_'.$_conf['def_admin_lang']])."</option>";
		$rs -> MoveNext();
	}
	$gal_list.="</select>";
echo '
<p><strong>'.$lang_ar['agal_var1'].'</strong><br />
'.$lang_ar['agal_var1hint'].': '.$maxfilesize.'</p><br />
<div class="block"><form method="post" action="admin.php?p='.$p.'&act=uploadZIP" id="UZF" enctype="multipart/form-data">
'.$lang_ar['agal_selgal'].': '.$gal_list.' &nbsp;&nbsp;
'.$lang_ar['agal_selzip'].': <input type="file" name="file" id="file" size="15" /> &nbsp;&nbsp;
<input type="submit" value="'.$lang_ar['upload'].'" />
</form></div>
<br /><br />
<p><strong>'.$lang_ar['agal_var2'].'</strong><br />
'.$lang_ar['agal_var2hint1'].' <strong>'.$_SERVER['DOCUMENT_ROOT'].'/tmp/</strong><br />
'.$lang_ar['agal_var2hint2'].' '.$_SERVER['DOCUMENT_ROOT'].'/tmp/myphoto), 
'.$lang_ar['agal_var2hint3'].' (.jpg, .gif, .png)<br />
'.$lang_ar['agal_var2hint4'].'<br />
'.$lang_ar['agal_var2hint5'].'</p><br />
<div class="block"><form method="post" action="admin.php?p='.$p.'&act=uploadFOLDER" id="UFF" enctype="multipart/form-data">
'.$lang_ar['agal_selgal'].': '.$gal_list.' &nbsp;&nbsp;
'.$lang_ar['agal_catname'].': <input type="text" name="folder" id="folder" size="15" /> &nbsp;&nbsp;
<input type="submit" value="'.$lang_ar['upload'].'" />
</form></div><br /><br />
';

echo '<h3>'.$lang_ar['agal_photointask'].'</h3>';
$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."gal_queue 
LEFT JOIN ".$_conf['prefix']."galleries USING(ids)
ORDER BY sdate1 ASC");
	if($r -> RecordCount() == 0){
		echo msg_box($lang_ar['agal_nophotointask']);
	}else{
		echo '<table border="0" class="selrow" cellspacing="0">
		<tr><th>'.$lang_ar['agal_th_photo'].'</th><th>'.$lang_ar['agal_th_gal'].'</th><th>'.$lang_ar['agal_th_dadd'].'</th><th>'.$lang_ar['agal_th_comm'].'</th><th>'.$lang_ar['delete'].'</th></tr>';
		while(!$r -> EOF){
			$t = $r -> GetRowAssoc(false);
			echo '<tr>
			<td>'.stripslashes($t['folder']).'/'.stripslashes($t['file']).'</td>
			<td>'.stripslashes($t['name_'.$_conf['def_admin_lang']]).'</td>
			<td>'.date("d.m.Y H:i", $t['sdate1']).'</td>
			<td>'.stripslashes($t['comment']).'</td>
			<td><a href="admin.php?p='.$p.'&act=DelFromQueue&id='.$t['id'].'">'.$lang_ar['delete'].'</a></td>
			</tr>';
			$r -> MoveNext();
		}
		echo '</table>';
	}
}

?>