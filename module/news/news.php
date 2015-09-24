<?php
/**
 * Вывод новостей сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2012 
 * @link http://shiftcms.net
 * @version 1.04.05
 */
if(!defined("SHIFTCMS")) exit;

if(isset($_REQUEST['idn']) && is_numeric($_REQUEST['idn']) && $_REQUEST['idn']>0){
	$ms = $db->Execute("SELECT * FROM ".$_conf['prefix']."news_".$_SESSION['lang']."
	LEFT JOIN ".$_conf['prefix']."news_category USING(id)
	WHERE idn='".mysql_real_escape_string(stripslashes($_REQUEST['idn']))."'");
	if($ms->RecordCount()!=0){ // всего тем
		$tmpm = $ms->GetRowAssoc();
	
	if(isset($_REQUEST['nact']) && $_REQUEST['nact']=="addcomment" && isset($_SESSION['USER_IDU'])){
		if(trim($_REQUEST['comtext'])=="" || strlen($_REQUEST['comtext'])<5){
			$smarty->assign("message",msg_box($lang_ar['news_com_er1']));
		}else if(trim($_REQUEST['uname'])==""){
			$smarty->assign("message",msg_box("Пожалуйста, укажите Ваше имя!"));
		}elseif(trim($_REQUEST['uemail'])==""){
			$smarty->assign("message",msg_box("Пожалуйста, укажите Ваш e-mail!"));
		}else{
			$rc = $db -> Execute("INSERT INTO ".$_conf['prefix']."comments (idu,uname,uemail,service,id_item,date,comtext)VALUES
			('".$_SESSION['USER_IDU']."','".mysql_real_escape_string(stripslashes($_REQUEST['uname']))."','".mysql_real_escape_string(stripslashes($_REQUEST['uemail']))."','news','".$tmpm['IDN']."','".time()."',
			'".mysql_real_escape_string(strip_tags(stripslashes($_REQUEST['comtext']),"<b><strong><span><ol><ul><li><p><sub><sup>"))."')");
			$smarty->assign("message",msg_box($lang_ar['news_comsaved']));
			$_REQUEST['uname'] = $_REQUEST['uemail'] = $_REQUEST['comtext'] = '';
		}
	}
	//----------------------------------------------------------------------
		//$_REQUEST['category'] = $tmpm['NTRANS'];
		if(file_exists("files/newsanons/".$tmpm['IDN'].".jpg")) $photo = "files/newsanons/".$tmpm['IDN'].".jpg";
		else $photo = "no";
		$rss_array=array(
			'IDN'=>$tmpm['IDN'],
			'DATE'=>$tmpm['DATE'],
			'NTITLE'=>htmlentities(stripslashes($tmpm['NTITLE']),ENT_QUOTES, $_conf['encoding']),
			'NTEXT'=>stripslashes($tmpm['NTEXT']),
			'PHOTO'=>stripslashes($photo),
			'NLINK'=>stripslashes($tmpm['NLINK']),
			'CATEGORY_NAME'=>stripslashes($tmpm[strtoupper($_SESSION['lang'])])
		);
		
		$smarty -> assign("act","full");
		$smarty -> assign($rss_array);
		/**
		* Вывод комментариев и формы, если включено в конфигурации
		*/
		if($_conf['comments']=="y"){
			$smarty -> assign("comments", "1");
			$com_array=array(); $com_items=0; $cominterval=20;
			if(!isset($_REQUEST['comstart'])) $comstart=0;
			else $comstart=$_REQUEST['comstart'];
			$q = $_conf['prefix']."comments WHERE service='news' AND id_item=".$tmpm['IDN']." ORDER BY date";
			$rc = $db -> Execute("SELECT * FROM ".$q." LIMIT $comstart, $cominterval");
			$rc1 = $db -> Execute("SELECT count(*) FROM ".$q);
			$tc1 = $rc1 -> GetRowAssoc(false);
			$comlist_page=GetPaging($tc1['count(*)'],$cominterval,$comstart,"index.php?p=news&idn=".$tmpm['IDN']."&comstart=%start1%");
			while (!$rc->EOF) { 
				$tc = $rc -> GetRowAssoc(false);
				$com_array[$com_items]=array(
					'id' => $tc['id'],
					'date' => $tc['date'],
					'comtext'=>stripslashes($tc['comtext']),
					'whopost'=>stripslashes($tc['uname']),
				);
				$com_items++;
				$rc->MoveNext(); 
			}
			if(isset($_SESSION['USER_IDU'])){
				$uname = isset($_REQUEST['uname']) ? htmlspecialchars(stripslashes($_REQUEST['uname'])) : '';
				$uemail = isset($_REQUEST['uemail']) ? htmlspecialchars(stripslashes($_REQUEST['uemail'])) : $_SESSION['USER_EMAIL'];
				$comtext = isset($_REQUEST['comtext']) ? htmlspecialchars(stripslashes($_REQUEST['comtext'])) : '';
				$smarty -> assign("uname",$uname);
				$smarty -> assign("uemail",$uemail);
				$smarty -> assign("comtext",$comtext);
				$HEADER .= '
				<script src="'.$_conf['www_patch'].'/js/nicedit/nicEdit.js" type="text/javascript"></script>
				<script type="text/javascript">
					bkLib.onDomLoaded(function() {
					new nicEditor({buttonList : ["bold","italic","underline","strikeThrough","subscript","superscript","ol","ul"], iconsPath : "'.$_conf['www_patch'].'/js/nicedit/nicEditorIcons.gif", maxHeight : 200}).panelInstance("comtext");
				});
				</script>
				';
			}
			$smarty -> assign("comstart",$comstart);
			$smarty -> assign("paging",$comlist_page);
			$smarty -> assign("comlistpage",$smarty -> fetch("db:paging.tpl"));
			$smarty->assign("com",$com_array);
		}else{
			$smarty -> assign("comments", "0");
		}//end of comments
	}else{
		$smarty->assign("newsnotfound",$lang_ar['newsnotfound']);
	}


}else{

//SelectLimit($sql,$numrows=-1,$offset=-1,$inputarr=false)
$id = 0;
$rss_array=array();
$rss_items=0;
$interval = $_conf['news_count1'];
if(!isset($_REQUEST['start'])) $start=0;
else $start=$_REQUEST['start'];

/* Выбираем категории новостей */
if(isset($_REQUEST['category'])){
	$rc = $db -> Execute("Select * from ".$_conf['prefix']."news_category where ntrans='".mysql_real_escape_string(stripslashes($_REQUEST['category']))."'");
	if($rc -> RecordCount() > 0){
		$tc = $rc -> GetRowAssoc(false);
		$id = $tc['id'];
		$category_name = stripslashes($tc[$_SESSION['lang']]);
		$smarty -> assign("category_name", $category_name);
		$category = stripslashes($_REQUEST['category']);
	}
}
/* если выбран день календаря - готовим запрос к базе на выбранный день */
if(isset($_REQUEST['date'])){
	$d_start = strtotime($_REQUEST['date']." 00:00");
	$d_stop = strtotime($_REQUEST['date']." 23:59");
}
if(isset($d_start) && is_numeric($d_start) && strlen($d_start)==10){
	$qnd = $id==0 ? " WHERE " : " AND ";
	$qnd .= " date BETWEEN ".$d_start." AND ".$d_stop." ";
}else{
	$qnd = '';
}

if($id!=0){
	$q = "select SQL_CALC_FOUND_ROWS * FROM ".$_conf['prefix']."news_".$_SESSION['lang']." WHERE id='".$id."' ".$qnd." ORDER BY date DESC";
}else{
	$q = "select SQL_CALC_FOUND_ROWS * FROM ".$_conf['prefix']."news_".$_SESSION['lang']." ".$qnd." ORDER BY date DESC";
}
$q .= " LIMIT ".$start.", ".$interval;

$ms = $db -> Execute($q);

$r1 = $db -> Execute("select found_rows()");
$t1 = $r1 -> GetRowAssoc(false);
$all = $t1['found_rows()'];

//$list_page=Paging($all,$interval,$start,"index.php?p=news&start=%start1%","");
if($id==0) $list_page=GetPaging($all,$interval,$start,"index.php?p=news&start=%start1%");
else $list_page=GetPaging($all,$interval,$start,"index.php?p=news&category=".$category."&start=%start1%");
//echo "<br />".$list_page;
	while (!$ms->EOF) { 
		$tmpm=$ms->GetRowAssoc();
	if(file_exists("files/newsanons/".$tmpm['IDN'].".jpg")) $photo = "files/newsanons/".$tmpm['IDN'].".jpg";
	else $photo = "no";
	$rss_array[$rss_items]=array(
		'IDN'=>$tmpm['IDN'],
		'DATE'=>$tmpm['DATE'],
		'NTITLE'=>htmlentities(stripslashes($tmpm['NTITLE']),ENT_QUOTES, $_conf['encoding']),
		'NANONS'=>stripslashes($tmpm['NANONS']),
		'NTEXT'=>stripslashes($tmpm['NTEXT']),
		'PHOTO'=>stripslashes($photo),
		'NLINK'=>stripslashes($tmpm['NLINK'])
	);
	$rss_items++;
	$ms->MoveNext(); 
}
		$smarty -> assign("paging",$list_page);
		$smarty -> assign("listpage",$smarty -> fetch("db:paging.tpl"));
		$smarty -> assign("act","list");
		$smarty -> assign("rssfull",$rss_array);
		$smarty -> assign("news_category",getNewsCategoryArray());
}

$PAGE = $smarty->fetch("news/news.tpl");

//$CURPATCH=$TITLE=$KEYWORDS=$lang_ar['news'];
?>