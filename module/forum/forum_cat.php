<?php
/**
 * Вывод списка разделов форума
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00	12.10.2009
 */
if(!defined("SHIFTCMS")) exit;
	if(isset($_REQUEST['t'])) $qa = " AND (idf='".$_REQUEST['t']."' OR parent_idf='".$_REQUEST['t']."')";
	else $qa = "";
	$user_idu = isset($_SESSION['USER_IDU']) ? $_SESSION['USER_IDU'] : -1;
  $q = "SELECT *,
  (select count(*) from ".$_conf['prefix']."forum_theme where ".$_conf['prefix']."forum_theme.idf=".$_conf['prefix']."forum.idf) as counttheme,
  (select count(*) from ".$_conf['prefix']."forum_msg where ".$_conf['prefix']."forum_msg.idf=".$_conf['prefix']."forum.idf) as countmsg
   FROM ".$_conf['prefix']."forum 
   WHERE ((ftype='o' OR ftype='c') OR (ftype='s' AND FIND_IN_SET(".$user_idu.",fuser)))
   ".$qa."
   ORDER BY ".$_conf['prefix']."forum.forder ASC";
   //echo $q;
  $r = $db -> Execute($q);
  $fs = $r -> GetAll();
  $newfs = array();
  $j = array();
  while(list($k, $v)=each($fs)){
  	if($v['parent_idf'] == 0){
		$newfs[$v['idf']][0] = $v;
	}else{
		$rm = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_msg
		LEFT JOIN ".$_conf['prefix']."forum_theme ON ".$_conf['prefix']."forum_theme.idt=".$_conf['prefix']."forum_msg.idt
		LEFT JOIN ".$_conf['prefix']."users ON ".$_conf['prefix']."users.idu=".$_conf['prefix']."forum_msg.mavtor
		WHERE ".$_conf['prefix']."forum_msg.idf=".$v['idf']." ORDER BY ".$_conf['prefix']."forum_msg.mdate DESC LIMIT 0,1");
		if($rm -> RecordCount() == 0) $v['lastmsg'] = "0";
		else{ $tm = $rm -> GetRowAssoc(false); $v['lastmsg'] = $tm;}
		if(date("d.m.Y", $v['lastmsg']['mdate']) == date("d.m.Y", time())) $v['lastmsg']['mdate'] = $lang_ar['forum_today_in']." ".date("H:i", $v['lastmsg']['mdate']);
		elseif(date("d.m.Y", $v['lastmsg']['mdate']) == date("d.m.Y", time()-24*3600)) $v['lastmsg']['mdate'] = $lang_ar['forum_yestoday_in']."".date("H:i", $v['lastmsg']['mdate']);
		else $v['lastmsg']['mdate'] = date("d.m.Y H:i", $v['lastmsg']['mdate']);
		$v['lastmsg']['tname'] = stripslashes($v['lastmsg']['tname']);
		if(isset($j[$v['parent_idf']])) $ind = $j[$v['parent_idf']];
		else $ind = $j[$v['parent_idf']] = 1;
		$newfs[$v['parent_idf']][$ind] = $v;
		$j[$v['parent_idf']] = $j[$v['parent_idf']] + 1;
	}
  }

	//echo "<pre>";
	//print_r($newfs);
	//echo "</pre>";
reset($newfs); $section = array(); $select = array();
while(list($k,$v)=each($newfs)){
	asort($v);
	while(list($k1,$v1)=each($v)){
		if($k1==0){
			$select[] = array('idf'=>$v1['idf'], 'fname'=>stripslashes($v1['fname_'.$_SESSION['lang']]));
		}else{
			$select[] = array('idf'=>$v1['idf'], 'fname'=>stripslashes($v1['fname_'.$_SESSION['lang']]));
		}
		$v1['fname'] = stripslashes($v1['fname_'.$_SESSION['lang']]);
		$v1['fdesc'] = stripslashes($v1['fdesc_'.$_SESSION['lang']]);
		$section[] = $v1;
	}
}
	//echo "<pre>".print_r($section,1)."</pre>";
$smarty -> assign("f", $section);
$smarty -> assign("sel", $select);
$PAGE = $smarty -> fetch("forum/forum_cat.tpl");
?>