<?php
/**
 * просмотр фотогалереи - одиночные фото
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00	30.06.2009
 */
if(!defined("SHIFTCMS")) exit;

	if(isset($_REQUEST['nact']) && $_REQUEST['nact']=="addcomment" && isset($_SESSION['USER_IDU'])){
		if(trim($_REQUEST['comtext'])==""){
			$smarty->assign("info_message", $lang_ar['gal_error1']);
			$smarty->assign("message",$smarty->fetch("messeg.tpl"));
		}else{
			$rc = $db -> Execute("INSERT INTO ".$_conf['prefix']."comments (idu,service,id_item,date,comtext)VALUES
			('".$_SESSION['USER_IDU']."','gallery','".$_REQUEST['idp']."','".time()."',
			'".mysql_real_escape_string($_REQUEST['comtext'])."')");
			$smarty->assign("info_message",$lang_ar['gal_ok1']);
			$smarty->assign("message",$smarty->fetch("messeg.tpl"));
		}
	}
	//----------------------------------------------------------------------


if(isset($_REQUEST['ids'])){
	$ids=$_REQUEST['ids'];
}else{
	$q="select MIN(ids) from ".$_conf['prefix']."galleries";
	$rs = $db -> Execute($q);
	$tmp = $rs -> GetRowAssoc();
	$ids=$tmp['MIN(IDS)'];
}
/*
$q="select * from sh_galleries order by name";
$rs = $db -> Execute($q);
$gal_list="<select id='ids' name='ids'>";
while(!$rs -> EOF){
	$tmp = $rs -> GetRowAssoc();
	if($ids==$tmp['IDS']) $gal_list.="<option value='$tmp[IDS]' selected='selected'>".stripslashes($tmp['NAME'])."</option>";
	else $gal_list.="<option value='$tmp[IDS]'>".stripslashes($tmp['NAME'])."</option>";
	$rs -> MoveNext();
}
$gal_list.="</select>";
echo "
<form action='$_SERVER[PHP_SELF]' id='GalleryForm' method='post'>
<input type='hidden' name='p' value='gallery' />
<input type='hidden' name='act' value='EditGallery' />
$gal_list
<input type='submit' value='Просмотр' />
</form><br />
<br style='clear:both;' />";
*/

$q="select * from ".$_conf['prefix']."galleries WHERE ids='$ids'";
$rs = $db -> Execute($q);
$galinf=$rs -> GetRowAssoc();




	if(!isset($_REQUEST['start'])) $start=0;
	else $start=$_REQUEST['start'];
	$interval=1;
	$q="select COUNT(*) from ".$_conf['prefix']."gal_photos WHERE ids='$ids'";
	$rs = $db -> Execute($q);
	$t = $rs -> GetRowAssoc();
	$all = $t['COUNT(*)'];

	$q="select * from ".$_conf['prefix']."gal_photos WHERE ids='$ids' ORDER BY g_order,idp LIMIT $start,$interval";
	$rs = $db -> Execute($q);
	$photos='';
	$items=0;
	$dw=$_conf['gal_photo_w']; $dw=$dw."px";
	$pagelist=Paging($all,$interval,$start,"?p=gal_browse&act=OutPhoto&ids=$ids&start=%start1%","");
		$tmp = ClearSleshes($rs -> GetRowAssoc());



		/**
		* Вывод комментариев и формы, если включено в конфигурации
		*/
		if($_conf['comments']=="y"){
			$smarty -> assign("comments", "1");
			$com_array=array(); $com_items=0; $cominterval=20;
			if(!isset($_REQUEST['comstart'])) $comstart=0;
			else $comstart=$_REQUEST['comstart'];
			$q = $_conf['prefix']."comments LEFT JOIN ".$_conf['prefix']."users USING(idu) WHERE service='gallery' AND id_item=".$tmp['IDP']." ORDER BY date";
			$rc = $db -> Execute("SELECT * FROM ".$q." LIMIT $comstart, $cominterval");
			$rc1 = $db -> Execute("SELECT count(*) FROM ".$q);
			$tc1 = $rc1 -> GetRowAssoc(false);
			$comlist_page=GetPaging($tc1['count(*)'],$cominterval,$comstart,"index.php?p=gal_browse&act=OutPhoto&comstart=%start1%&start=$start&idp=$tmp[IDP]");
			while (!$rc->EOF) { 
				$tc = $rc -> GetRowAssoc(false);
				$com_array[$com_items]=array(
					'id' => $tc['id'],
					'date' => $tc['date'],
					'comtext'=>stripslashes($tc['comtext']),
					'whopost'=>stripslashes($tc['login']),
					'idu'=>$tc['idu'],
				);
				$com_items++;
				$rc->MoveNext(); 
			}
			if(isset($_SESSION['USER_IDU'])){
				include($_conf['disk_patch']."include/FCKeditor/fckeditor.php") ;
				$oFCKeditor = new FCKeditor('comtext') ;
				$oFCKeditor->ToolbarSet = 'Comment' ;
				$sBasePath = $_conf['www_patch']."/include/FCKeditor/" ;
				$oFCKeditor->Width  = '70%';
				$oFCKeditor->Height = '200';
				$oFCKeditor_ua->Config['EditorAreaCSS'] = $_conf['www_patch']."/".$_conf['tpl_dir']."css/style.css" ;
				$oFCKeditor->Value = '' ;
				$FORMAREA = $oFCKeditor->Create() ;
				$smarty -> assign("FORMAREA",$FORMAREA);
			}
			$smarty -> assign("comstart",$comstart);
			$smarty -> assign("paging",$comlist_page);
			$smarty -> assign("comlistpage",$smarty -> fetch("db:paging.tpl"));
			$smarty->assign("com",$com_array);
		}else{
			$smarty -> assign("comments", "0");
		}//end of comments




$smarty -> assign("COMMENTS",stripslashes($tmp['COMMENTS']));
$smarty -> assign("start",$start);
$smarty -> assign("dw",$dw);
$smarty -> assign("IDS",$tmp['IDS']);
$smarty -> assign("IDP",$tmp['IDP']);
$smarty -> assign("IMG",$_conf['gal_photo_patch']."/".$tmp['IDP'].".jpg");
$smarty -> assign("pagelist",$pagelist);
$smarty -> assign("NAME",stripslashes($galinf['NAME']));
$smarty -> assign("OPIS",stripslashes($galinf['OPIS']));
$PAGE = $smarty -> fetch("gallery/gal_browse.tpl");	
?>