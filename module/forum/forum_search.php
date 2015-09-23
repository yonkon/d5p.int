<?php
/**
 * Поиск по форуму
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00	13.10.2009
 */
if(!defined("SHIFTCMS")) exit;
			$interval = 20;
			if(!isset($_REQUEST['start'])) $start=0;
			else $start=$_REQUEST['start'];

$stext = isset($_REQUEST['stext']) ? htmlspecialchars(stripslashes($_REQUEST['stext'])) : "";
$smarty -> assign("stext", $stext);

if(isset($_REQUEST['search']) && trim($stext)=="" && !isset($_REQUEST['filter'])){
	$smarty -> assign("infmsg", msg_box("Вы не ввели слово или фразу для поиска"));
	unset($_REQUEST['search']);
}

if(isset($_REQUEST['search'])){
	/**
	* Поиск по темам
	*/ 
$add = "";	
if(isset($stext) && $stext!=""){	
	$q1 = "SELECT *,
  (select count(*) from ".$_conf['prefix']."forum_msg fmsg where fmsg.idt=".$_conf['prefix']."forum_theme.idt) as countmsg";
  	$q2 = "SELECT idt ";
  $q = "
   FROM ".$_conf['prefix']."forum_theme
   LEFT JOIN ".$_conf['prefix']."users ON ".$_conf['prefix']."forum_theme.tavtor=".$_conf['prefix']."users.idu
   WHERE MATCH(tname) AGAINST ('".mysql_real_escape_string($stext)."' IN BOOLEAN MODE) 
   OR MATCH(ttext) AGAINST ('".mysql_real_escape_string($stext)."' IN BOOLEAN MODE)
   OR (SELECT count(*) FROM ".$_conf['prefix']."forum_msg WHERE ".$_conf['prefix']."forum_msg.idt=".$_conf['prefix']."forum_theme.idt AND MATCH(mtext) AGAINST ('".mysql_real_escape_string($stext)."' IN BOOLEAN MODE)!=0)
   GROUP BY ".$_conf['prefix']."forum_theme.idt
   ORDER BY tdate ASC";
   $add .= "&stext=".$stext;
}
if(isset($_REQUEST['filter']) && $_REQUEST['filter']=="my"){
	$q1 = "SELECT *,
  (select count(*) from ".$_conf['prefix']."forum_msg fmsg where fmsg.idt=".$_conf['prefix']."forum_theme.idt) as countmsg";
  	$q2 = "SELECT idt ";
  $q = "
   FROM ".$_conf['prefix']."forum_theme
   LEFT JOIN ".$_conf['prefix']."users ON ".$_conf['prefix']."forum_theme.tavtor=".$_conf['prefix']."users.idu
   WHERE tavtor = '".$_SESSION['USER_IDU']."'
   OR (SELECT count(*) FROM ".$_conf['prefix']."forum_msg WHERE ".$_conf['prefix']."forum_msg.idt=".$_conf['prefix']."forum_theme.idt AND mavtor = '".$_SESSION['USER_IDU']."')!=0
   GROUP BY ".$_conf['prefix']."forum_theme.idt
   ORDER BY tdate ASC";
   $add .= "&filter=my";
}
if(isset($_REQUEST['filter']) && $_REQUEST['filter']=="unanswered"){
	$q1 = "SELECT *,
  (select count(*) from ".$_conf['prefix']."forum_msg fmsg where fmsg.idt=".$_conf['prefix']."forum_theme.idt) as countmsg";
  	$q2 = "SELECT idt ";
  $q = "
   FROM ".$_conf['prefix']."forum_theme
   LEFT JOIN ".$_conf['prefix']."users ON ".$_conf['prefix']."forum_theme.tavtor=".$_conf['prefix']."users.idu
   WHERE (SELECT count(*) FROM ".$_conf['prefix']."forum_msg WHERE ".$_conf['prefix']."forum_msg.idt=".$_conf['prefix']."forum_theme.idt)=0
   GROUP BY ".$_conf['prefix']."forum_theme.idt
   ORDER BY tdate ASC";
   $add .= "&filter=my";
}
if(isset($_REQUEST['filter']) && $_REQUEST['filter']=="forday"){
	$stime = time() - 24*3600;
	$q1 = "SELECT *,
  (select count(*) from ".$_conf['prefix']."forum_msg fmsg where fmsg.idt=".$_conf['prefix']."forum_theme.idt) as countmsg";
  	$q2 = "SELECT idt ";
  $q = "
   FROM ".$_conf['prefix']."forum_theme
   LEFT JOIN ".$_conf['prefix']."users ON ".$_conf['prefix']."forum_theme.tavtor=".$_conf['prefix']."users.idu
   WHERE tdate > '".$stime."'
   OR (SELECT count(*) FROM ".$_conf['prefix']."forum_msg WHERE ".$_conf['prefix']."forum_msg.idt=".$_conf['prefix']."forum_theme.idt AND mdate > '".$stime."')!=0
   GROUP BY ".$_conf['prefix']."forum_theme.idt
   ORDER BY tdate ASC";
   $add .= "&filter=my";
}  
   //echo $q;
  $r = $db -> Execute($q1.$q." LIMIT ".$start.",".$interval);
  $fs = $r -> GetAll();
  $r1 = $db -> Execute($q2.$q);
  $all = $r1 -> RecordCount();
  $list_page=GetPaging($all,$interval,$start,"index.php?p=forum&show=search&start=%start1%&search=search".$add);
  $newfs = array();
  $j = 0;
  while(list($k, $v)=each($fs)){
		$rm = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_msg
		LEFT JOIN ".$_conf['prefix']."users ON ".$_conf['prefix']."users.idu=".$_conf['prefix']."forum_msg.mavtor
		WHERE idt=".$v['idt']." ORDER BY mdate DESC LIMIT 0,1");
		if($rm -> RecordCount() == 0) $v['lastmsg'] = "0";
		else{ $tm = $rm -> GetRowAssoc(false); $v['lastmsg'] = $tm;}
		if(date("d.m.Y", $v['lastmsg']['mdate']) == date("d.m.Y", time())) $v['lastmsg']['mdate'] = $lang_ar['forum_today_in']." ".date("H:i", $v['lastmsg']['mdate']);
		elseif(date("d.m.Y", $v['lastmsg']['mdate']) == date("d.m.Y", time()-24*3600)) $v['lastmsg']['mdate'] = $lang_ar['forum_yestoday_in']." ".date("H:i", $v['lastmsg']['mdate']);
		else $v['lastmsg']['mdate'] = date("d.m.Y H:i", $v['lastmsg']['mdate']);
		$msglist_page=GetPagingForum($v['countmsg'],$interval,0,"index.php?p=forum&show=msg&start=%start1%&f=".$v['idf']."&t=".$v['idt'], 6);
			$smarty -> assign("start",$start);
			$smarty -> assign("paging",$msglist_page);
			$v['pl'] = $smarty -> fetch("forum/forum_paging.tpl");
			if(isset($stext) && $stext!="") $v['tname'] = highlight_words($v['tname'], $stext);
		$newfs[$j] = $v;
		$j++;
  }

  if(count($newfs)==0){ 
  	$smarty -> assign("infmsg", msg_box("По вашему запросу ничего не найдено!"));
  }

			$smarty -> assign("start",$start);
			$smarty -> assign("paging",$list_page);
			$smarty -> assign("listpage",$smarty -> fetch("db:paging.tpl"));
	
	$smarty -> assign("f", $newfs);
	$smarty -> assign("searchres", "searchres");
}

$PAGE = $smarty -> fetch("forum/forum_search.tpl");

?>