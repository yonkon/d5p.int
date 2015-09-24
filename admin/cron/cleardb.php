<?php
$limitdate = time() - 365*24*3600;
$limitdate1 = time() - 180*24*3600;
$limitdate1 = time() - 90*24*3600;


/* очищаем историю входа в аккаунт */
$q = "DELETE FROM ".$_conf['prefix']."enterlog WHERE date < '".$limitdate."'";
$res = $db -> Execute($q);

/* очищаем устаревшие записи из календаря */
$q = "DELETE FROM ".$_conf['prefix']."calendar WHERE instime < '$limitdate4'";
$res = $db -> Execute($q);

$qdm = "SELECT idm FROM ".$_conf['prefix']."user_mail WHERE mdate < '".$limitdate1."'";
$rdm = $db -> Execute($qdm);
	require_once("include/uploader.php");
while(!$rdm->EOF){
	$tdm = $rdm -> GetRowAssoc(false);
	$idm = $tdm['idm'];
	$ra = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail_attach WHERE idm='".$idm."'");
		if($ra -> RecordCount() > 0){
			$upl = new uploader;
			while(!$ra -> EOF){
				$ta = $ra -> GetRowAssoc(false);
				$upl -> DeleteFile(stripslashes($ta['fpath']));
				$pp = pathinfo($ta['fpath']);
				@rmdir($pp['dirname']);
				$ra -> MoveNext();
			}
			unset($upl);
		}
	$r = $db -> Execute("DELETE FROM ".$_conf['prefix']."user_mail_attach WHERE idm='".$idm."'");
	$r = $db -> Execute("DELETE FROM ".$_conf['prefix']."user_mail WHERE idm='".$idm."'");
	$rdm -> MoveNext();
}

echo "Произведена очистка базы от устаревших записей.\n";



$dirs = $_SERVER['DOCUMENT_ROOT']."/tmp/ADOdbcache/";
$deltime = time()-7*86400;
GetFiles($dirs, $deltime);
echo "Произведена очистка файлов кеша базы данных старше 7 дней\n";
function GetFiles($dirs, $deltime){
	if (is_dir($dirs)) {
	    if ($dh = opendir($dirs)) {
	        while (($file = readdir($dh)) !== false) {
				if($file!="." && $file!=".."){
	              if(is_file($dirs.$file)){
					if($deltime > filemtime($dirs.$file)) @unlink($dirs.$file);
				  }else{
				  	GetFiles($dirs.$file."/", $deltime);
				  	@rmdir($dirs.$file);
				  }
				}
	        }
	    closedir($dh);
	    }
	}
}


?>