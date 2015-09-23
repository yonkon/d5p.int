<?php
/**
 * Главная страница форума
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00	12.10.2009
 */
if(!defined("SHIFTCMS")) exit;

if(isset($_SESSION['USER_IDU']) && isset($_SESSION['USER_GROUP']) && $_SESSION['USER_GROUP']=="super"){
	$access = "full";
	$smarty -> assign("access", $access);
}else{
	$access = "user";
	$smarty -> assign("access", $access);
}

if($_conf['forum_editor'] == "bbcode") include("include/bbcode/bbcode.lib.php");

//include("module/forum/forum_function.php");

if(isset($_REQUEST['show']) && $_REQUEST['show']=="theme") include("module/forum/forum_theme.php");
elseif(isset($_REQUEST['show']) && $_REQUEST['show']=="msg") include("module/forum/forum_msg.php");
elseif(isset($_REQUEST['show']) && $_REQUEST['show']=="create") include("module/forum/forum_create.php");
elseif(isset($_REQUEST['show']) && $_REQUEST['show']=="search") include("module/forum/forum_search.php");
else include("module/forum/forum_cat.php");


$HEADER .= '<script src="'.$_conf['www_patch'].'/'.$_conf['tpl_dir'].'forum/forum.js" type="text/javascript"></script>
';
if($_conf['forum_editor'] == "bbcode"){
	$HEADER .= '
	<script type="text/javascript" src="'.$_conf['www_patch'].'/include/bbcode/xbb.js.php"></script>';
}
?>