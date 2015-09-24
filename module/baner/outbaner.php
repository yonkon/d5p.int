<?php
/**
 * Модуль для вывода рекламного блока в соответствующем месте на странице
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.01
 26.09.2009 - Во время вывода разделов сайта, выводятся только те стрнаицы, что принадлежат к фронтэнд части. Добавлена функция включения/отключения показа рекламы на сайте.
 */

$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."ad_place");
while(!$r -> EOF){
	$t = $r -> GetRowAssoc(false);
	$smarty->assign($t['kod'],ad_insert("$t[kod]"));
	$r -> MoveNext();
}
$outbaner = "";



//--------------------------------------------------------------------------
function ad_insert($ad_place){
/*
$ad_place - место расположения рекламы
вставляет рекламный банер в месте вызова
*/
global $group,$_conf,$p, $db, $smarty;
$comp=time();
$ad_q="SELECT * FROM ".$_conf['prefix']."advert WHERE ad_place='".$ad_place."' AND (ad_section='all' OR FIND_IN_SET('".$p."',ad_section)) AND ad_switch='y'";
$ad_r = $db -> Execute($ad_q);
$ad_all = $ad_r -> RecordCount();
   if($ad_all==0){
      $ad_str='';
      $upd_id='';
   }else{
      $free_ar=array();
      $paid_ar=array();
      $ad_ar=array();
	  while(!$ad_r -> EOF){
	  	$tmp = $ad_r -> GetRowAssoc(false);
          if($tmp['ad_type_show']=='date' && $tmp['ad_dstart']<=$comp && $tmp['ad_dstop']>=$comp && $tmp['ad_type']=='free') $free_ar[]=$tmp['ad_id'];
          if($tmp['ad_type_show']=='date' && $tmp['ad_dstart']<=$comp && $tmp['ad_dstop']>=$comp && $tmp['ad_type']=='paid') $paid_ar[]=$tmp['ad_id'];
          if($tmp['ad_type_show']=='shows' && $tmp['shows']<$tmp['ad_shows'] && $tmp['ad_type']=='free') $free_ar[]=$tmp['ad_id'];
          if($tmp['ad_type_show']=='shows' && $tmp['shows']<$tmp['ad_shows'] && $tmp['ad_type']=='paid') $paid_ar[]=$tmp['ad_id'];
          if($tmp['ad_type_show']=='clicks' && $tmp['clicks']<$tmp['ad_clicks'] && $tmp['ad_type']=='free') $free_ar[]=$tmp['ad_id'];
          if($tmp['ad_type_show']=='clicks' && $tmp['clicks']<$tmp['ad_clicks'] && $tmp['ad_type']=='free') $paid_ar[]=$tmp['ad_id'];
          if($tmp['ad_type_show']=='no' && $tmp['ad_type']=='free') $free_ar[]=$tmp['ad_id'];
          if($tmp['ad_type_show']=='no' && $tmp['ad_type']=='paid') $paid_ar[]=$tmp['ad_id'];
		  $ad_r -> MoveNext();
      }

          if(count($paid_ar) != 0) $ad_ar = $paid_ar;
          else $ad_ar = $free_ar;
          $rid = rand(0,count($ad_ar)-1);
          $a_q = "SELECT * FROM ".$_conf['prefix']."advert WHERE ad_id='".$ad_ar[$rid]."'";
          $a_r = $db -> Execute($a_q);
          $t = $a_r -> GetRowAssoc(false);
		  if($_SESSION['lang'] != $_conf['def_lang']){
			  if(trim($t['ad_kode_'.$_SESSION['lang']])=="") $ad_kode = stripslashes($t['ad_kode_'.$_conf['def_lang']]);
			  else  $ad_kode  = stripslashes($t['ad_kode_'.$_SESSION['lang']]);
		  }else $ad_kode  = stripslashes($t['ad_kode_'.$_SESSION['lang']]);
          if(trim($t['ad_link'])=="") $ad_str = $ad_kode;
		  else  $ad_str='<a href="?p=goto&id='.$t['ad_id'].'" target="_blank">'.$ad_kode.'</a>';
          $u_q="UPDATE ".$_conf['prefix']."advert SET shows=shows+1 WHERE ad_id='".$ad_ar[$rid]."'";
		  $u_r = $db -> Execute($u_q);
   }
   //$smarty -> assign($ad_place, $ad_str);
 return $ad_str;
}
?>