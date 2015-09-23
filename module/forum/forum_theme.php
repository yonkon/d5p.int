<?php
/**
 * Вывод списка тем из выбранного раздела форума
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00	12.10.2009
 */
if(!defined("SHIFTCMS")) exit;
			$interval = 20;
			if(!isset($_REQUEST['start'])) $start=0;
			else $start=$_REQUEST['start'];
$user_idu = isset($_SESSION['USER_IDU']) ? $_SESSION['USER_IDU'] : -1;
  $q = "SELECT *  FROM ".$_conf['prefix']."forum 
  WHERE idf=".$_REQUEST['f']." AND ((ftype='o' OR ftype='c') 
   OR (ftype='s' AND FIND_IN_SET(".$user_idu.",fuser)))";
  $r = $db -> Execute($q);
  $s = $r -> GetRowAssoc(false);
	$smarty -> assign("section", stripslashes($s['fname_'.$_SESSION['lang']]));
	$TITLE = $KEYWORDS = stripslashes($s['fname_'.$_SESSION['lang']]);
	$DESCRIPTION = stripslashes($s['fdesc_'.$_SESSION['lang']]);
	$q1 = "SELECT *,
  (select count(*) from ".$_conf['prefix']."forum_msg where ".$_conf['prefix']."forum_msg.idt=".$_conf['prefix']."forum_theme.idt) as countmsg";
  	$q2 = "SELECT count(*) ";
  $q = "
   FROM ".$_conf['prefix']."forum_theme
   LEFT JOIN ".$_conf['prefix']."users ON ".$_conf['prefix']."forum_theme.tavtor=".$_conf['prefix']."users.idu
   WHERE idf = ".mysql_real_escape_string($_REQUEST['f'])."
   ORDER BY tdate ASC";
  $r = $db -> Execute($q1.$q." LIMIT ".$start.",".$interval);
  $fs = $r -> GetAll();
  $r1 = $db -> Execute($q2.$q);
  $t1 = $r1 -> GetRowAssoc(false);
  $list_page=GetPaging($t1['count(*)'],$interval,$start,"index.php?p=forum&show=theme&start=%start1%&f=".$_REQUEST['f']);

  $newfs = array();
  $j = 0;
  while(list($k, $v)=each($fs)){
		$rm = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_msg
		LEFT JOIN ".$_conf['prefix']."users ON ".$_conf['prefix']."users.idu=".$_conf['prefix']."forum_msg.mavtor
		WHERE idt=".$v['idt']." ORDER BY mdate DESC LIMIT 0,1");
		if($rm -> RecordCount() == 0) $v['lastmsg'] = "0";
		else{ $tm = $rm -> GetRowAssoc(false); $v['lastmsg'] = $tm;}
		if(date("d.m.Y", $v['lastmsg']['mdate']) == date("d.m.Y", time())) $v['lastmsg']['mdate'] = "Сегодня в ".date("H:i", $v['lastmsg']['mdate']);
		elseif(date("d.m.Y", $v['lastmsg']['mdate']) == date("d.m.Y", time()-24*3600)) $v['lastmsg']['mdate'] = "Вчера в ".date("H:i", $v['lastmsg']['mdate']);
		else $v['lastmsg']['mdate'] = date("d.m.Y H:i", $v['lastmsg']['mdate']);
		$msglist_page=GetPagingForum($v['countmsg'],$interval,0,"index.php?p=forum&show=msg&start=%start1%&f=".$v['idf']."&t=".$v['idt']."", 6);
			$smarty -> assign("start",$start);
			$smarty -> assign("paging",$msglist_page);
			$v['pl'] = $smarty -> fetch("forum/forum_paging.tpl");
			$v['ttext'] = stripslashes($v['ttext']);
			$v['tname'] = stripslashes($v['tname']);
		$newfs[$j] = $v;
		$j++;
  }

	//echo "<pre>";
	//print_r($newfs);
	//echo "</pre>";
			$smarty -> assign("start",$start);
			$smarty -> assign("paging",$list_page);
			$smarty -> assign("listpage",$smarty -> fetch("db:paging.tpl"));
	if($s['parent_idf']!='0'){
		$rp = $db -> Execute("select * from ".$_conf['prefix']."forum where idf=".$s['parent_idf']);
		$tp = $rp -> GetRowAssoc(false);
		$tp['fname'] = stripslashes($tp['fname_'.$_SESSION['lang']]);
		$smarty -> assign("parent",$tp);
	}
$smarty -> assign("f", $newfs);
$smarty -> assign("idf", $_REQUEST['f']);
//$smarty -> assign("sel", $select);
$PAGE = $smarty -> fetch("forum/forum_theme.tpl");

?>