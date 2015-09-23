<?php
/**
 * Вывод формы авторизации на сайте
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00
 */
if(!defined("SHIFTCMS")) exit;

if(isset($_SESSION['USER_IDU'])){
	if(isset($_SESSION['GROUP_ACCESS']) && $_SESSION['GROUP_ACCESS']=="y"){
		header("location:".$_conf['www_patch']."/admin.php"); exit;
	}else{
		header("location:".$_conf['www_patch']."/"); exit;
	}
}

$er="";
if(isset($_REQUEST['er']) && $_REQUEST['er']=="2"){
	$smarty->assign("login_error", $lang_ar['enter_er2']);
	$smarty->assign("er","error");
}
if(isset($_REQUEST['er']) && $_REQUEST['er']=="3"){
	$smarty->assign("login_error", $lang_ar['enter_er3']);
	$smarty->assign("er","error");
}
if(isset($_REQUEST['er']) && $_REQUEST['er']=="4"){
	$smarty->assign("login_error", $lang_ar['enter_er4']);
	$smarty->assign("er","error");
}
if(isset($_REQUEST['er']) && $_REQUEST['er']=="5"){
	$smarty->assign("login_error", $lang_ar['enter_er5']);
	$smarty->assign("er","error");
}
if(isset($_REQUEST['er']) && $_REQUEST['er']=="6"){
	$smarty->assign("login_error", $lang_ar['enter_er6']);
	$smarty->assign("er","error");
}
if(isset($_REQUEST['er']) && $_REQUEST['er']=="7"){
	$smarty->assign("login_error", $lang_ar['enter_er7']);
	$smarty->assign("er","error");
}
if(isset($_REQUEST['er']) && $_REQUEST['er']=="8"){
	$smarty->assign("login_error", $lang_ar['enter_er8']);
	$smarty->assign("er","error");
}
if(isset($_REQUEST['er']) && $_REQUEST['er']=="9"){
	$smarty->assign("login_error", $lang_ar['enter_er9']);
	$smarty->assign("er","error");
}
$smarty->assign("remember", $lang_ar['enter_restore']);
$rc  = rand(1000,9999);
$PAGE = $enter_block = $smarty->fetch("enter.tpl");

?>