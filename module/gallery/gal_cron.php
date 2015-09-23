<?php
/**
 * Управление фотогалерей - пакетная обработка фото по расписанию
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.02	11.12.2009
 */
@set_time_limit(0);
$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."gal_queue WHERE sdate2=0 AND state='n' ORDER BY sdate1 LIMIT 0,10");
if($r -> RecordCount() == 0){
	echo $lang_ar['agal_nophotointask']."\n";
}else{
	$i = 0;
			include "include/uploader.php";
			$upl = new uploader;
			include "include/imager.php";
			$img = new imager;
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
			$file = stripslashes($t['folder'])."/".stripslashes($t['file']);
			$idp = time();
			//$idp = $i.$idp;
			if(!file_exists($_conf['gal_thumb_patch'])) $upl -> MakeDir($_conf['gal_thumb_patch']);
			if(!file_exists($_conf['gal_photo_patch'])) $upl -> MakeDir($_conf['gal_photo_patch']);
	
			$width = array($_conf['gal_thumb_w'], $_conf['gal_photo_w']);
			$height = array($_conf['gal_thumb_h'], $_conf['gal_photo_h']);
			$name = array($_conf['gal_thumb_patch']."/".$idp.".jpg", $_conf['gal_photo_patch']."/".$idp.".jpg");
			$img -> width = $width;
			$img -> height = $height;
			$img -> fname = $name;
			$img -> crop = array("yes","");
			$img -> whatcrop = array("center","");

			$img -> desttype = array("thumb","photo");
			
			$_FILES = array(
				'file'=>array(
		            'name' => stripslashes($t['file']),
			        'type' => 'application/x-zip-compressed',
		            'tmp_name' => $file,
		            'error' => 0,
		            'size' => filesize($file),
				),
			);
			$res = $img -> ResizeImage($_FILES['file']);
			if($res == 1){
				$q="INSERT INTO ".$_conf['prefix']."gal_photos (idp,ids,date) VALUES 
				('".$idp."', '".$t['ids']."', '".time()."')";
				echo $q."<br />";
				$rs = $db -> Execute($q);
				$rd = $db -> Execute("DELETE FROM ".$_conf['prefix']."gal_queue WHERE id='".$t['id']."'");
				@unlink($file);
				@rmdir(stripslashes($t['folder']));
				echo "Фотография ".$_conf['gal_photo_patch']."/".$idp.".jpg успешно загружена на сервер!<br />\n";
			}else{
				$ru = $db -> Execute("UPDATE ".$_conf['prefix']."gal_queue 
				SET sdate2 = '".time()."', comment = '".mysql_real_escape_string($res)."'
				WHERE id='".$t['id']."'");
				echo $res."<br />\n";
			}
		$i++;
		sleep(1);
		$r -> MoveNext();
	}
}

$PAGE = "";

?>