<?php
/**
 * Личная страница пользователя внутри системы управления
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00
 */
if(!defined("SHIFTCMS")) exit;

$smarty -> assign("PAGETITLE","<h2>".$alang_ar['aui_title']."</h2>");
	$er = 0; $er_msg = "";

/* сохранение данных пользователя */
if(isset($_REQUEST['act']) && $_REQUEST['act'] == "SaveUserInfo"){
	$res = CheckUserData();
	if($res == "OK") {
		SaveUserData();
		$smarty->assign("info_message", $alang_ar['saved']);
		echo $smarty->fetch("messeg.tpl");
	}else{
		echo $res;
	}
	unset($_REQUEST['act']);
}


$ui = GetUserName($_SESSION['USER_IDU']);

echo "<h3>$ui[FIO] ($ui[LOGIN], IDU:$ui[IDU])</h3><br />";

echo "<ul>";
echo "<li><a title='".$alang_ar['edit']."' href='#' onClick=\"divwin=dhtmlwindow.open('UserEditBox', 'inline', '', '".$alang_ar['edit']."', 'width=450px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); getdata('','get','?p=site_server&act=AddOrEditUser&idu=$ui[IDU]&type=own&ret=user_info','UserEditBox_inner'); return false; \"><strong>".$alang_ar['aui_edit']."</strong></a></li>";
echo "</ul>";

if($er_msg!="") echo "<br />".$er_msg;


?>
