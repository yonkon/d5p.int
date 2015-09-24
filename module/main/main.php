<?php
/**
 * Вывод главной страницы сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00
 */
if(!defined("SHIFTCMS")) exit;


$PAGE = $smarty->fetch("main.tpl");

/*
$PAGE = out_site_text("mainpage");

$CURPATCH=get_site_text_name("mainpage");

$TITLE = "Главная страница ".$_conf['www_patch'];
$DESCRIPTION = "Главная страница ".$_conf['www_patch'];
$KEYWORDS = "Главная страница ".$_conf['www_patch'];
*/
?>