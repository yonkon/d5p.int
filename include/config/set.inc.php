<?php
/**
 * Файл конфигурации сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2011
 * @link http://shiftcms.net
 * @version 1.01.02
 */
	ini_set('date.timezone','Europe/Kiev');
	// http://ua2.php.net/manual/en/timezones.php, Europe/Kiev, Europe/Moscow, Europe/Minsk, Asia/Vladivostok
	
	ini_set("display_errors","1");
	if($_SERVER['REMOTE_ADDR'] == "127.0.0.1"){
		if (version_compare(phpversion(), "5.0.0", ">")==1) {
			ini_set("error_reporting", E_ALL | E_STRICT);
		}else{
			ini_set("error_reporting", E_ALL);
		}
	}else ini_set("error_reporting", E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	 
	$host = "localhost";
	$base = 'spluso_dip';
	$user = 'root';
	$pass = 'root';
	$_conf['prefix'] = 'su_';

	$_conf['www_dir'] = ""; // если сайт ставиться в каталоге (напр.: /mydir) - внести имя этого каталога в файле .htaccess
	$_conf['disk_patch'] = $_SERVER['DOCUMENT_ROOT'].$_conf['www_dir']."/";
	$_conf['doc_root'] = "/home/shikon/proj/d5p.int/".$_conf['www_dir']."";
	$_conf['www_patch'] = "http://d5p.int/".$_conf['www_dir'];
	$_conf['url_type'] = 1; // использовать ЧПУ - 1 или реальный - 0

	$_conf['tpl_dir'] = "tmpl/lite/";
	$_conf['fck_dir'] = $_conf['www_dir']."/files/";

	$_conf['def_lang'] = "ru"; // ru, ua, en
	$_conf['def_admin_lang'] = "ru"; // ru, ua, en
	$_conf['encoding'] = "UTF-8"; // UTF-8, Windows-1251
	$_conf['encoding_db'] = "utf8"; // utf8, cp1251
	
	setlocale(LC_ALL, 'ru_RU.'.$_conf['encoding']);
