<?php
/**
 * Вывод списка фотогалерей
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00	30.06.2009
 */
if(!defined("SHIFTCMS")) exit;

$q="select * from ".$_conf['prefix']."galleries 
where (select count(*) from ".$_conf['prefix']."gal_photos 
where ".$_conf['prefix']."gal_photos.ids=".$_conf['prefix']."galleries.ids) > 0
order by date DESC, name_".$_SESSION['lang']." ";
$rs = $db -> Execute($q);
$ids = isset($_REQUEST['ids']) ? $_REQUEST['ids'] : -1;
$lb_gallery_list = array();
while(!$rs -> EOF){
	$tmp = $rs -> GetRowAssoc(false);
	$lb_gallery_list[] = array(
		'ids'=>$tmp['ids'],
		'name'=>stripslashes($tmp['name_'.$_SESSION['lang']]),
		'cur'=>$ids==$tmp['ids'] ? 'y' : 'n'
	);
	$rs -> MoveNext();
}
if(count($lb_gallery_list)>0){
	$smarty -> assign("lb_gallery_list", $lb_gallery_list);
	$lb_gal_list = $smarty -> fetch("gallery/gal_list.tpl");
}else{
	$lb_gal_list = '';
}

?>