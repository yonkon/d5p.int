<?php
/**
 * Главная страница системы управления
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2011 
 * @link http://shiftcms.net
 * @version 1.01
 */
if(!defined("SHIFTCMS")) exit;

//-----------------------------------------------------------------------------

echo '<table border="0" cellspacing="20" width="100%"><tr>';
echo '<td valign="top">';

echo "<p>".sprintf($alang_ar['am_welkom'], $_SESSION['USER_LOGIN'])."</p>";

$info = Informer();
if(trim($info)!=""){ echo $info; }

echo '</td>
<td valign="top" align="right">';

$ow = GetListOnlineWorker();

echo '</td>';
echo '</tr></table>';


include("admin/system/updater.php");

include("cron_init.php");

$smarty -> assign("PAGETITLE","<h2>".$alang_ar['am_title']."</h2>");
$smarty -> assign("modSet", "main");

?>