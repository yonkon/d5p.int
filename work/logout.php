<?
/**
 * Скрипт завершения сессии авторизованными пользователями
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00
 */
session_start();
require(dirname(__FILE__)."/include/config/config.php");
	$time=time()-42000;
	while(list($key,$val)=each($_COOKIE)){
		setcookie($key,"",$time);
		unset($_COOKIE[$key]);
	}
	/* this code is deprecated in PHP 5.3 */
	/*
	while(list($key,$val)=each($_SESSION)){
		session_unregister($key);
		unset($_SESSION[$key]);
	}
	*/
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', $time);
	}
	session_destroy();
	header("location:".$_conf['base_url']);
	exit;
?>
