<?php
/**
 * Скрипт завершения сессии авторизованными пользователями
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2011 
 * @link http://shiftcms.net
 * @version 1.00.01
 */
ob_start("ob_gzhandler");
session_start();
define('SHIFTCMS',true);
include('./include/config/set.inc.php'); 
	$time = time()-42000;
	while(list($key,$val)=each($_COOKIE)){
		setcookie($key,"",$time,'/');
		unset($_COOKIE[$key]);
	}
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', $time, '/');
	}
	session_destroy();
header("location:".$_conf['www_dir']."/");
?>
