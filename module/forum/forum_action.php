<?php
/**
 * Набор функций для работы форума
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00	13.10.2009
 */
if(!defined("SHIFTCMS")) exit;

//include("module/forum/forum_function.php");

if(isset($_REQUEST['act']) && $_REQUEST['act']=="MakeEditFormMsg"){
	echo MakeEditFormMsg($_REQUEST['idm']);
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="cancelEditMsg"){
	cancelEditMsg($_REQUEST['idm']);
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="SaveMsg"){
	SaveMsg($_REQUEST['idm']);
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="MakeEditFormTheme"){
	echo MakeEditFormTheme($_REQUEST['idt']);
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="cancelEditTheme"){
	cancelEditTheme($_REQUEST['idt']);
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="SaveTheme"){
	SaveTheme($_REQUEST['idt']);
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="SearchUsers"){
	echo SearchUsers(stripslashes($_REQUEST['sText']));
}

?>