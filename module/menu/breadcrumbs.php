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
	if(!isset($CMS['breadcrumbs']['main'])){
		$CMS['breadcrumbs'] = array_reverse($CMS['breadcrumbs']);
		$CMS['breadcrumbs'][-1] = $CMS['structure']['main'];
		unset($CMS['breadcrumbs'][-1]['sub']);
		$CMS['breadcrumbs'] = array_reverse($CMS['breadcrumbs']);
	}
	$smarty->assign("breadcrumbs_ar", $CMS['breadcrumbs']);
	$breadcrumbs = $smarty->fetch("menu/breadcrumbs.tpl");

//echo '<pre>'.print_r($CMS['breadcrumbs'],1).'</pre>';
//if(!isset($CMS['breadcrumbs'])) loadBreadCrumbs();
/*
echo '<pre>'.print_r($CMS['breadcrumbs'],1).'</pre>';

$breadcrumbs_ar = array();
$level = -1;
$index = 0;
$sql_p = $p;
if($p!="main"){

	if($sql_p=="cabinet" && isset($_REQUEST['page'])){
		if($_REQUEST['page']=="order")	$breadcrumbs_ar[] = array('link'=>'?p=cabinet&page=order','linkname'=>'Оформить заказ','linktitle'=>'Оформить заказ','index'=>$index);
		if($_REQUEST['page']=="registeravtor")	$breadcrumbs_ar[] = array('link'=>'?p=cabinet&page=registeravtor','linkname'=>'Регистрация автора','linktitle'=>'Регистрация автора','index'=>$index);
		if($_REQUEST['page']=="news")	$breadcrumbs_ar[] = array('link'=>'?p=cabinet&page=news','linkname'=>'Новости компании','linktitle'=>'Новости компании','index'=>$index);
		if($_REQUEST['page']=="orderlist")	$breadcrumbs_ar[] = array('link'=>'?p=cabinet&page=orderlist','linkname'=>'Мои заказы','linktitle'=>'Мои заказы','index'=>$index);
		if($_REQUEST['page']=="owninfo")	$breadcrumbs_ar[] = array('link'=>'?p=cabinet&page=owninfo','linkname'=>'Личная информация','linktitle'=>'Личная информация','index'=>$index);
		if($_REQUEST['page']=="refprg")	$breadcrumbs_ar[] = array('link'=>'?p=cabinet&page=refprg','linkname'=>'Партнерская программа','linktitle'=>'Партнерская программа','index'=>$index);
		$index++;
	}

	while($level!=0){
		$r = $db -> Execute("SELECT 
		pid, pname, pparent, ptitle, ppar, plevel, pgroups, ptype, siteshow, menushow1, menushow2, menushow3
		lastedit, linkname_".$_SESSION['lang'].", linktitle_".$_SESSION['lang']."
		FROM ".$_conf['prefix']."page 
		WHERE siteshow='y' AND ptype='front' AND pname='".$sql_p."'
		ORDER BY linkpos");
		$t = $r -> GetRowAssoc(false);
		$level = $t['plevel'];
		if($t['pparent']=="main") $level = 0;
		$sql_p = $t['pparent'];
		if(stripslashes($t['linktitle_'.$_SESSION['lang']])=="") $t['linktitle_'.$_SESSION['lang']]=stripslashes($v['linkname_'.$_SESSION['lang']]);
		$link = $_conf['www_patch'].'/?p='.stripslashes($t['pname']);
		$breadcrumbs_ar[] = array(
			'link'=>$link,//'?p='.stripslashes($t['pname']),
			'linkname'=>stripslashes($t['linkname_'.$_SESSION['lang']]),
			'linktitle'=>stripslashes($t['linktitle_'.$_SESSION['lang']]),
			'index'=>$index,
		);
		$index++;
}

		$r = $db -> Execute("SELECT 
		pid, pname, pparent, ptitle, ppar, plevel, pgroups, ptype, siteshow, menushow1, menushow2, menushow3
		lastedit, linkname_".$_SESSION['lang'].", linktitle_".$_SESSION['lang']."
		FROM ".$_conf['prefix']."page 
		WHERE siteshow='y' AND ptype='front' AND pname='main'
		ORDER BY linkpos");
		$t = $r -> GetRowAssoc(false);
		if(stripslashes($t['linktitle_'.$_SESSION['lang']])=="") $t['linktitle_'.$_SESSION['lang']]=stripslashes($v['linkname_'.$_SESSION['lang']]);
		$breadcrumbs_ar[] = array(
			'link'=>'?p='.stripslashes($t['pname']),
			'linkname'=>stripslashes($t['linkname_'.$_SESSION['lang']]),
			'linktitle'=>stripslashes($t['linktitle_'.$_SESSION['lang']]),
			'index'=>$index,
		);

	$smarty->assign("breadcrumbs_ar", array_reverse($breadcrumbs_ar));
	$breadcrumbs = $smarty->fetch("menu/breadcrumbs.tpl");
}else{
	$breadcrumbs = '';
}
*/

?>