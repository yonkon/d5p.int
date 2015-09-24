<?php
/**
 * Вывод блока меню на сайте, формируемого на основании списка текстовых страниц
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00
 */
if(!defined("SHIFTCMS")) exit;

$menu1 = getMenu('menushow1');
$smarty->assign("menu1", $menu1);
$menu_block = $smarty->fetch("menu/menu_block.tpl");


$menu2 = getMenu('menushow2');
$smarty->assign("menu2", $menu2);
$menu2_block = $smarty->fetch("menu/menu2.tpl");
$smarty->assign("menu2_block", $menu2_block);


/*
$menu3 = getMenu('menushow3');
$smarty->assign("menu3", $menu3);
$menu3_block = $smarty->fetch("menu/menu3.tpl");
$smarty->assign("menu3_block", $menu3_block);
*/
?>