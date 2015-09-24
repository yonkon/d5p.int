<?
/**
 * Авторизация пользователей системы
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00
 */

if(!defined("SHIFTCMS")) exit;
	
	$check=0;

if(trim($_REQUEST['login'])=="" || trim($_REQUEST['password'])==""){
	$check = 1;
	$error = "Пожалуйста, укажите Ваши логин и пароль!";
}

if($check==0) {
	$data = array(
		'login'=>strip_tags(stripslashes($_REQUEST['login'])),
		'password'=>strip_tags(stripslashes($_REQUEST['password'])),
		'authperiod'=>isset($_REQUEST['authperiod']) ? 'y' : 'n',
		'a_version'=>$_conf['version']
	);
	$res = SendRemoteRequest("AuthorizeUser",$data);
	if($res['status']['code']==0){
		Authorize($res['data']);
	}else{
		$error = $res['status']['msg'];
	}
}

?>