<?php
/**
 * Управление блогами
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2011 
 * @link http://shiftcms.net
 * @version 1.00.00
 */

$smarty -> assign("PAGETITLE","<h2>Блоги : Рубрики</h2>");
$smarty -> assign("modSet", "blog");

//---------------------------------------------------------------


//if(!isset($_REQUEST['act'])){
	
	$r = $db -> Execute("select * from ".$_conf['prefix']."blog_rub order by b_rubname_".$_SESSION['admin_lang']."");
	while(!$r->EOF){
		$t -> GetRowAssoc(false);
		$r -> MoveNext();
	}
//}


?>