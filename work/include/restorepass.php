<?
/**
 * Восстановление пароля пользователя
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00
 */

if(!defined("SHIFTCMS")) exit;
	
$check=0;

if(strip_tags(trim($_REQUEST['email']))=="" || strip_tags(trim($_REQUEST['check_code']))==""){
	$check = 1;
	$error = "Пожалуйста, укажите Ваш e-mail и код с картинки!";
}
if($_REQUEST['check_code'] != $_SESSION['check_code']){
	$check = 1;
	$error = "Ошибка! Вы не верно ввели код с картинки!";
}

if($check==0) {
	$data = array(
		'email'=>strip_tags(stripslashes($_REQUEST['email']))
	);
	$res = SendRemoteRequest("RestoreUserPassword", $data);
	if($res['status']['code']==0){
		$infomsg = $res['status']['msg'];
	}else{
		$error = $res['status']['msg'];
	}
}

?>