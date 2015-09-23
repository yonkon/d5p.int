<?php
/**
 * Обновление системы управления сайтом
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2012
 * @link http://shiftcms.net
 * @version 1.00
 */
if(!defined("SHIFTCMS")) exit;

$smarty -> assign("PAGETITLE","<h2><a href='admin.php?p=updater'>Обновление системы</a></h2>");
//$smarty -> assign("modSet", "main");
//-----------------------------------------------------------------------------
$dir = 'tmp/updates';
include("include/uploader.php");
$upl = new uploader;
if(!is_dir($dir)) $upl -> MakeDir($dir);
//-----------------------------------------------------------------------------
if(!isset($_REQUEST['act'])){

$r = $db -> Execute("select * from ".$_conf['prefix']."modules where installed='y'");
$ar = $r -> GetArray();
$rquery = '';
while(list($k,$v)=each($ar)){
	if($rquery!='') $rquery .= ',';
	$rquery .= $v['code'].'-'.$v['version'];
}
$rquery = 'mods='.$rquery;
$check = httpPost("upd.shiftcms.net","/update_server/act/checkUpdate/",$rquery);
//echo $check;
$updates = array();
if(trim($check)!=""){
	$mods = explode("||",$check);
	if(is_array($mods)){
		while(list($k,$v)=each($mods)){
			$cm = explode("::",$v);
			if(is_array($cm) && isset($cm[0]) && isset($cm[1]) && isset($cm[2]) && isset($cm[3]) && isset($cm[4])){
				$updates[$cm[0]] = array(
					'module'=>$cm[0],
					'version'=>$cm[1],
					'date'=>$cm[2],
					'description'=>$cm[3],
					'file'=>$cm[4]
				);
			}
		}
	}
}
echo '<div style="padding:20px; margin-top:30px; border-top:solid 1px #ccc;">
<h2>'.$alang_ar['am_modinstalled'].':</h2>';
echo '<table border="0" cellspacing="0" class="selrow">
<tr><th>'.$alang_ar['am_module'].'</th><th>'.$alang_ar['am_version'].'</th><th>'.$alang_ar['am_isupd'].'</th><th>'.$alang_ar['am_update'].'</th></tr>';
reset($ar);
while(list($k,$v)=each($ar)){
	if(!isset($updates[$v['code']])){
		echo '<tr><td>'.stripslashes($v['description_'.$_SESSION['admin_lang']]).'</td>
		<td>'.stripslashes($v['version']).'</td><td></td><td></td></tr>';
	}else{
		echo '<tr><td valign="top">'.stripslashes($v['description_'.$_SESSION['admin_lang']]).'</td>
		<td valign="top">'.stripslashes($v['version']).'</td>
		<td valign="top">'.$alang_ar['am_version'].': <strong>'.$updates[$v['code']]['version'].'</strong>, '.date("d.m.Y",$updates[$v['code']]['date']).'<br /><a href="javascript:void(null)" onclick="SwitchShow(\'UI'.$v['code'].'\')">'.$alang_ar['am_updinfo'].'</a><div id="UI'.$v['code'].'" style="display:none">'.nl2br($updates[$v['code']]['description']).'</div></td>
		<td valign="top"><a href="admin.php?p=updater&code='.$v['code'].'&act=initialize&nver='.$updates[$v['code']]['version'].'">'.$alang_ar['am_startupd'].'</a></td></tr>';
	}
}
echo '</table>';
}

//-----------------------------------------------------------------------------
if(isset($_REQUEST['act']) && $_REQUEST['act']=="initialize"){
	$r = $db -> Execute("select * from ".$_conf['prefix']."modules where code='".mysql_real_escape_string(stripslashes($_REQUEST['code']))."' AND installed='y'");
	$t = $r -> GetRowAssoc(false);
	if($r->RecordCount()==0){
		echo 'Выбранный модуль не найден или не установлен в системе!';
	}else{
		echo '<h2>Обновление модуля системы: '.$_REQUEST['code'].'</h2>
		<p>'.stripslashes($t['description_'.$_SESSION['admin_lang']]).'</p>
		<p>Текущая версия: <strong>'.$t['version'].'</strong></p>
		<p>Новая версия: <strong>'.stripslashes($_REQUEST['nver']).'</strong> - ';
		echo '&laquo;&laquo; <a href="javascript:void(null)" onclick="$(\'#updStep1\').html(\'\');$(\'#updStep2\').html(\'\');$(\'#updStep3\').html(\'\');getdata(\'\',\'post\',\'?p=updater&act=updStep1&code='.$_REQUEST['code'].'&curversion='.$t['version'].'&newversion='.$_REQUEST['nver'].'\',\'updStep1\')">Загрузить обновление</a> &raquo;&raquo;</p>';
		echo '<div id="updStep1" style="margin-top:10px;"></div>';
		echo '<div id="updStep2" style="margin-top:10px;"></div>';
		echo '<div id="updStep3" style="margin-top:10px;"></div>';
	}
}
//-----------------------------------------------------------------------------
if(isset($_REQUEST['act']) && $_REQUEST['act']=="updStep1"){
	$rquery = 'mods='.$_REQUEST['code'].'-'.$_REQUEST['curversion'];
	$check = httpPost("upd.shiftcms.net","/update_server/act/checkUpdate/",$rquery);
			$cm = explode("::",$check);
			//print_r($cm);//Array ( [0] => core [1] => 1.07.125 [2] => 1334216169 [3] => Это всего лишь тест... [4] => http://upd.shiftcms.net/files/updates/update1.zip )
			if(is_array($cm) && isset($cm[0]) && isset($cm[1]) && isset($cm[2]) && isset($cm[3]) && isset($cm[4])){
				$pp = pathinfo($cm[4]);
				//print_r($pp);//Array ( [dirname] => http://upd.shiftcms.net/files/updates [basename] => update1.zip [extension] => zip [filename] => update1 )
				$zipfile = $dir.'/'.$pp['basename'];
				if(!copy($cm[4],$zipfile)){
					echo '<strong>Ошибка! Не удалось загрузить обновления. Попробуйте еще раз.</strong>';
				}else{
					chmod($zipfile, 0777); 
					$tmpdir = $dir.'/'.$pp['filename'];
					if(!is_dir($tmpdir)) $upl -> MakeDir($tmpdir);

					if(function_exists("zip_open")){ // используем библиотеку PHP
						include("include/zip/php_zip.inc.php");
						$ARCHIVE = new zip;
						$zinfo = $ARCHIVE->infosZip($zipfile, false);
						if($ARCHIVE->extractZip($zipfile, $tmpdir)){
							while(list($k,$v)=each($zinfo)){
								if($v['Size']!=0){
									echo "<small>$k ($v[Size] bytes)</small><br />";
									chmod($tmpdir."/".$k, 0777); 
								}
							}
						}else{
							echo msg_box("Не удалось распаковать архив!");
						}

					}else{ // используем сторонню библиотеку

						include("include/zip/dUnzip2.inc.php");
						$zip = new dUnzip2($zipfile);
						//$zip->debug = 1; // debug?
						$list = $zip->getList();
						foreach($list as $sfileName=>$zippedFile){
							echo "<small>$sfileName ($zippedFile[uncompressed_size] bytes)</small><br />";
							if($zippedFile['uncompressed_size']==0){
							  	$nd = $tmpdir."/".$sfileName;
							  	if(!is_dir($nd)) $upl -> MakeDir($nd);
							}else{
								$zip->unzip($sfileName, $tmpdir."/".$sfileName);
								chmod($tmpdir."/".$sfileName, 0777); 
							}
						}
						$zip -> close();
					}
					
					echo '<p><strong>Обновления загружены и готовы к установке</strong></p><br />
					<p>Для продолжения установки необходим ФТП доступ к  серверу. Введите хост, логин и пароль:</p> 
					<form method="post" action="javascript:void(null)" enctype="multipart/form-data" id="ChkFTP">
					<input type="hidden" name="p" id="p" value="'.$p.'" />
					<input type="hidden" name="act" id="act" value="updStep2" />
					<input type="hidden" name="fn" id="fn" value="'.$pp['filename'].'" />
					<input type="hidden" name="code" id="code" value="'.$_REQUEST['code'].'" />
					<p><strong>Хост:</strong> <input type="text" name="ftp_host" id="ftp_host" size="10" /> <strong>Логин:</strong> <input type="text" name="ftp_login" id="ftp_login" size="10" /> <strong>Пароль:</strong> <input type="password" name="ftp_pass" id="ftp_pass" size="10" />
					&laquo;&laquo; <a href="javascript:void(null)" onclick="doLoad(\'ChkFTP\',\'updStep2\')">Проверить соединение</a> &raquo;&raquo;</p>
					</form>';
				}
			}else{
				echo '<strong>Обновление не найдено!</strong>';
			}

	//print_r($_REQUEST);
	//print_r($check);
}
//-----------------------------------------------------------------------------
if(isset($_REQUEST['act']) && $_REQUEST['act']=="updStep2"){
	if(!$conn_id = ftp_connect($_REQUEST['ftp_host'])){
		echo '<p><small>Не удалось соединиться с хостом: '.$_REQUEST['ftp_host'].'</small></p>';
		exit;
	}else{
		echo '<p><small>Соединение с '.$_REQUEST['ftp_host'].' установлено!</small></p>';
	}
	if (!@ftp_login($conn_id, $_REQUEST['ftp_login'], $_REQUEST['ftp_pass'])) {
	    echo "<p><small>Не удалось войти под именем $_REQUEST[ftp_login]</small></p>";
		exit;
	}else{	
		echo '<p><small>Авторизация прошла успешно!</small></p>';
	}
	@ftp_cdup($conn_id);
	$ftp_dir = ftp_pwd($conn_id);
	$pp = pathinfo($_SERVER['SCRIPT_FILENAME']);
	$fullpatch = explode("/",$pp['dirname']);
	while(list($k,$v)=each($fullpatch)){
			if (@ftp_chdir($conn_id, $v)) {
				$ftp_dir = ftp_pwd($conn_id);
			}
	}
	echo '<p><small>Каталог в котором находятся файлы сайта: '.$ftp_dir.'</small></p>';

	echo '<p><br /><strong>&laquo;&laquo; <a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=updater&act=updStep3&code='.$_REQUEST['code'].'&fn='.$_REQUEST['fn'].'&ftp_host='.$_REQUEST['ftp_host'].'&ftp_login='.$_REQUEST['ftp_login'].'&ftp_pass='.$_REQUEST['ftp_pass'].'&ftp_dir='.$ftp_dir.'\',\'updStep3\')">Установить обновление</a> &raquo;&raquo;</strong></p>';

	ftp_quit($conn_id);
/*	
	echo '<br /><br /><pre>';
	print_r($_REQUEST);
	echo '</pre>';
*/
}
//-----------------------------------------------------------------------------
if(isset($_REQUEST['act']) && $_REQUEST['act']=="updStep3"){
	if(!$conn_id = ftp_connect($_REQUEST['ftp_host'])){
		echo '<p><small>Не удалось соединиться с хостом: '.$_REQUEST['ftp_host'].'</small></p>';
		exit;
	}else{
		echo '<p><small>Соединение с '.$_REQUEST['ftp_host'].' установлено!</small></p>';
	}
	if (!@ftp_login($conn_id, $_REQUEST['ftp_login'], $_REQUEST['ftp_pass'])) {
	    echo "<p><small>Не удалось войти под именем $_REQUEST[ftp_login]</small></p>";
		exit;
	}else{	
		echo '<p><small>Авторизация прошла успешно!</small></p>';
	}
	if(!@ftp_chdir($conn_id, $_REQUEST['ftp_dir'])){
		echo "<p class='mailok'>Не удалось перейти в рабочий каталог!</p>";
		exit;
	}
	$installer = $dir.'/'.$_REQUEST['fn'].'/update_install.php';
	include($installer);
	if(isset($upd_file) && !empty($upd_file)){
		while(list($k,$v)=each($upd_file)){
			$src_file = $dir.'/'.$_REQUEST['fn'].'/'.$v;
			$dest_file = $v;
			if (@ftp_put($conn_id, $dest_file, $src_file, FTP_BINARY)) {
				echo "<p class='mailok'>Файл $dest_file сохранен!</p>";
			} else {
				echo "<p class='mailerror'>Ошибка: Не удалось загрузить файл $dest_file</p>";
			}
		}
	}
	if(isset($del_file) && !empty($del_file)){
		while(list($k,$v)=each($del_file)){
			if (@ftp_delete($conn_id, $v)) {
				echo "<p class='mailok'>Файл $v удален!</p>";
			} else {
				echo "<p class='mailerror'>Ошибка: Не удалось удалить файл $v</p>";
			}
		}
	}
	if(isset($upd_query) && !empty($upd_query)){
		while(list($k,$v)=each($upd_query)){
			$r = $db -> Execute($v);
		}
		echo "<p class='mailok'>Запросы к базе данных успешно выполнены!</p>";
	}
	echo "<p class='mailok'>".updAdditional()."</p>";
	$r = $db -> Execute("update ".$_conf['prefix']."modules set version='".$upd_versio."' where code='".$upd_code."'");
	echo '<br /><br /><p><strong>Модуль <span class="mailerror">'.$upd_code.'</span> успешно обновлен к версии <span class="mailerror">'.$upd_version.'</span>!</strong></p><br />';
	echo '<div class="block">'.$upd_info.'</div>';
	echo '<script type="text/javascript">
	$("#updStep1").html("");
	$("#updStep2").html("");
	</script>';

	ftp_quit($conn_id);
/*
	echo '<br /><br /><pre>';
	print_r($_REQUEST);
	echo '</pre>';
*/
}
//-----------------------------------------------------------------------------
$HEADER .= '
';

//-----------------------------------------------------------------------------
function httpPost($host, $path, $params){
	if(!function_exists("curl_init")){	
		///////////////////////////////////////////////////////////////////////////////////////////////////
		// 1. do HTTP POST via fsockopen. Uncomment this code and comment cURL code if cURL is not installed
		///////////////////////////////////////////////////////////////////////////////////////////////////
		if(function_exists("fsockopen")){
		$params_len = strlen($params);
		$fp = @fsockopen($host, 80);
		if (!$fp)
			return null;
		fputs($fp, "POST $path HTTP/1.0\nHost: $host\nContent-Type: application/x-www-form-urlencoded\nUser-Agent: sms.php class 1.0 (fsockopen)\nContent-Length: $params_len\nConnection: Close\n\n$params\n");
		$response = fread($fp, 8000);
		fclose($fp);
		if (preg_match('|^HTTP/1\.[01] (\d\d\d)|', $response, $regs))
			$http_result_code = $regs[1];
		return ($http_result_code==200) ? substr($response, strpos($response, "\r\n\r\n") + 4) : null;
		}
	}else{
		///////////////////////////////////////////////////////////////////////////////////////////////////
		// 2. do HTTP POST via cURL. Uncomment this code and comment fsockopen code if cURL is installed
		///////////////////////////////////////////////////////////////////////////////////////////////////
		$protocol='http'; // alternatively, use https
		$ch = curl_init($protocol.'://'.$host.$path);
		curl_setopt($ch, CURLOPT_POST, 1);
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // do not verify that ssl cert is valid (it is not the case for failover server)
		curl_setopt($ch, CURLOPT_USERAGENT, "shiftcms update checker");
		curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 10 seconds
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		$http_result_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		return ($http_result_code==200) ? $response : null;
	}
}
?>