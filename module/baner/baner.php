<?php
/**
 * Модуль управления рекламой на сайте
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2012 
 * @link http://shiftcms.net
 * @version 1.02.01
 26.09.2009 - Во время вывода разделов сайта, выводятся только те стрнаицы, что принадлежат к фронтэнд части. Добавлена функция включения/отключения показа рекламы на сайте.
 */

$r = $db -> Execute("SELECT pname, p_title_".$_SESSION['admin_lang']." as p_title FROM ".$_conf['prefix']."page WHERE ptype='front' OR ptype='both'");
$section_list=array();
while(!$r -> EOF){
	$t = $r -> GetRowAssoc(false);
	$section_list[$t['pname']] = htmlspecialchars($t['p_title']);
	$r -> MoveNext();
}

//-----------------------------------------------------------------------------
$smarty -> assign("PAGETITLE","<h2><a href='admin.php?p=".$p."'>".$lang_ar['ad_title'].":</a> <a href='admin.php?p=".$p."&act=add_advert'>".$lang_ar['ad_add']."</a> | <a href='admin.php?p=".$p."&act=list_advert'>".$lang_ar['ad_list']."</a> | <a href='admin.php?p=".$p."&act=add_ad_place'>".$lang_ar['ad_add_place']."</a> | <a href='admin.php?p=".$p."&act=list_ad_place'>".$lang_ar['ad_list_place']."</a></h2>");

//------------Добавление рекламного места--------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=='save_ad_place'){
$q="insert into ".$_conf['prefix']."ad_place(id_adp,kod,comment)VALUE('','".mysql_real_escape_string(stripslashes($_REQUEST['kod']))."','".mysql_real_escape_string(stripslashes($_REQUEST['comment']))."')";
$r = $db -> Execute($q);
		echo msg_box($lang_ar['ad_ok1']);
}
//------------Изменение рекламного места--------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=='upd_ad_place'){
$q="update ".$_conf['prefix']."ad_place SET kod='".mysql_real_escape_string(stripslashes($_REQUEST['kod']))."',comment='".mysql_real_escape_string(stripslashes($_REQUEST['comment']))."' WHERE id_adp='".mysql_real_escape_string(stripslashes($_REQUEST['id']))."'";
$r = $db -> Execute($q);
		echo msg_box($_lang_ar['ad_ok2']);
}
//------------Добавление рекламного места--------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=='add_ad_place'){
echo "<h2>".$lang_ar['ad_add_place']."</h2>";
echo "<br /><b>".$lang_ar['ad_attention']."</b><br />".$lang_ar['ad_explaine']."";
echo "<form action='admin.php?p=".$p."&act=save_ad_place' method='post'>
".$lang_ar['ad_code_place'].":<br />
<input type='text' name='kod' size='20' maxlength='20' /><br />
".$lang_ar['ad_desc_place'].":<br />
<input type='text' name='comment' size='80' maxlength='250' /><br />
<input type='submit' value='".$lang_ar['add']."'>
</form>";
}
//------------Редактирование рекламного места--------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=='ed_ad_place'){
$cq="SELECT * FROM ".$_conf['prefix']."ad_place WHERE id_adp='".mysql_real_escape_string(stripslashes($_REQUEST['id']))."'";
$cr = $db -> Execute($cq);
$t = $cr -> GetRowAssoc(false);

echo "<h2>".$lang_ar['ad_edit_place']."</h2>";
echo "<form action='admin.php?p=".$p."&act=upd_ad_place&id=".$t['id_adp']."' method='post'>
".$lang_ar['ad_code_place'].":<br />
<input type='text' name='kod' size='20' maxlength='20' value='".$t['kod']."' /><br />
".$lang_ar['ad_desc_place'].":<br />
<input type='text' name='comment' size='80' maxlength='250' value=\"".htmlspecialchars(stripslashes($t['comment']))."\" /><br />
<input type='submit' value='".$lang_ar['save']."'>
</form>";
}

//-----------Удаление рекламного места----------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=='del_ad_place'){
$q="delete from ".$_conf['prefix']."ad_place WHERE id_adp='".mysql_real_escape_string(stripslashes($_REQUEST['id']))."'";
$r = $db -> Execute($q);
		echo msg_box($lang_ar['ad_ok3']);
}
//-----------Удаление рекламы----------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=='delete_advert'){
$q="delete from ".$_conf['prefix']."advert WHERE ad_id='".mysql_real_escape_string(stripslashes($_REQUEST['id']))."'";
$r = $db -> Execute($q);
		echo msg_box($lang_ar['ad_ok4']);
}
//-----------Сохранение новой рекламы----------------------------
if(isset($_REQUEST['act']) && $_REQUEST['act']=='save_advert'){
if($_REQUEST['ad_type_show']=='no'){
    $dstart = $dstop = $shows = $clicks = '';
}
if($_REQUEST['ad_type_show']=='date'){
    $ds1 = explode("-",$_REQUEST['ad_dstart']);
    $ds2 = explode("-",$_REQUEST['ad_dstop']);
    $dstart = mktime(0,0,0,$ds1[1],$ds1[0],$ds1[2]);
    $dstop = mktime(0,0,0,$ds2[1],$ds2[0],$ds2[2]);
    $shows = $clicks = '';
}
if($_REQUEST['ad_type_show']=='shows'){
    $dstart=$dstop=$clicks='';
    $shows=$_REQUEST['ad_shows'];
}
if($_REQUEST['ad_type_show']=='clicks'){
    $dstart=$dstop=$shows='';
    $clicks=$_REQUEST['ad_clicks'];
}

$ad_switch = isset($_REQUEST['ad_switch']) ? 'y' : 'n';

if($_REQUEST['ad_section_type']=='all'){
    $section='all';
}else{
   $section=implode(",",$_REQUEST['ad_section']);
}
$q_val = $q_key = array();
reset($_SESSION['fl']);
while(list($k,$v)=each($_SESSION['fl'])){
	$q_key[] = 'ad_kode_'.$v;
	$q_val[] = "'".mysql_real_escape_string(stripslashes($_REQUEST['ad_kode_'.$v]))."'";
}
$q = "insert into ".$_conf['prefix']."advert(ad_id,ad_place,ad_link,ad_type_show,ad_dstart,ad_dstop,ad_shows,ad_clicks,
ad_section,ad_type,shows,clicks,ad_switch,".implode(",",$q_key).")VALUE('',
'".mysql_real_escape_string(stripslashes($_REQUEST['ad_place']))."',
'".mysql_real_escape_string(stripslashes($_REQUEST['ad_link']))."',
'".mysql_real_escape_string(stripslashes($_REQUEST['ad_type_show']))."', 
'".$dstart."','".$dstop."','".$shows."','".$clicks."', '".$section."',
'".mysql_real_escape_string(stripslashes($_REQUEST['ad_type']))."','0','0',
'".$ad_switch."',".implode(",",$q_val).")";
$r = $db -> Execute($q);
		echo msg_box($lang_ar['ad_ok5']);
		$_REQUEST['act'] = "list_advert";
}
//-----------Сохранение изменений----------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=='update_advert'){
if($_REQUEST['ad_type_show']=='no'){
    $dstart = $dstop = $shows = $clicks = '';
}
if($_REQUEST['ad_type_show']=='date'){
    $ds1 = explode("-",$_REQUEST['ad_dstart']);
    $ds2 = explode("-",$_REQUEST['ad_dstop']);
    $dstart = mktime(0,0,0,$ds1[1],$ds1[0],$ds1[2]);
    $dstop = mktime(0,0,0,$ds2[1],$ds2[0],$ds2[2]);
    $shows = $clicks = '';
}
if($_REQUEST['ad_type_show']=='shows'){
    $dstart = $dstop = $clicks = '';
    $shows = $_REQUEST['ad_shows'];
}
if($_REQUEST['ad_type_show']=='clicks'){
    $dstart = $dstop = $shows = '';
    $clicks = $_REQUEST['ad_clicks'];
}

if($_REQUEST['ad_section_type']=='all' || $_REQUEST['ad_section']==""){
    $section = 'all';
}else{
   $section = implode(",",$_REQUEST['ad_section']);
}
$ad_switch = isset($_REQUEST['ad_switch']) ? 'y' : 'n';

$q_val = array();
reset($_SESSION['fl']);
while(list($k,$v)=each($_SESSION['fl'])){
	$q_val[] = "ad_kode_".$v."='".mysql_real_escape_string(stripslashes($_REQUEST['ad_kode_'.$v]))."'";
}

$q="update ".$_conf['prefix']."advert set ad_place='".mysql_real_escape_string(stripslashes($_REQUEST['ad_place']))."', ad_link='".mysql_real_escape_string(stripslashes($_REQUEST['ad_link']))."', 
ad_type_show='".mysql_real_escape_string(stripslashes($_REQUEST['ad_type_show']))."', ad_dstart='".$dstart."', ad_dstop='".$dstop."', ad_shows='".$shows."', ad_clicks='".$clicks."', ad_section='".$section."', ad_type='".mysql_real_escape_string(stripslashes($_REQUEST['ad_type']))."', ad_switch='".$ad_switch."',".implode(",",$q_val)."
 WHERE ad_id='".mysql_real_escape_string(stripslashes($_REQUEST['id']))."'";
$r = $db -> Execute($q);
		echo msg_box($lang_ar['ad_ok6']);
		$_REQUEST['act'] = "list_advert";
}
//-----------Форма добавления новой рекламы---------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=='add_advert'){
	$sec_chk = create_check($section_list,"","ad_section","");
	$cq="SELECT * FROM ".$_conf['prefix']."ad_place ORDER BY kod";
	$cr = $db -> Execute($cq);
	$kod_list=array();
	while(!$cr -> EOF){
	  	$ctmp = $cr -> GetRowAssoc(false);
    	$kod_list[stripslashes($ctmp['kod'])] = stripslashes($ctmp['kod']." - ".$ctmp['comment']);
		$cr -> MoveNext();
	}
	$sel_kod = create_select($kod_list, "", "ad_place", "", false);

echo '<div class="block">
<h3>'.$lang_ar['ad_add'].'</h3>
<form action="admin.php?p='.$p.'&act=save_advert" method="post" enctype="multipart/form-data" id="BF">
<input type="checkbox" name="ad_switch" id="ad_switch" value="y" checked="checked" /> <strong>'.$lang_ar['ad_switch'].'</strong>
<br /><br />
<strong>'.$lang_ar['ad_code_place'].':</strong><br />
'.$sel_kod.'
<br />
<strong>'.$lang_ar['ad_type'].':</strong><br />
<select name="ad_type"><option value="free">'.$lang_ar['ad_type1'].'</option><option value="paid">'.$lang_ar['ad_type2'].'</option></select>
<br />
<strong>'.$lang_ar['ad_link'].':</strong><br />
<input type="text" name="ad_link" value="http://" size="50" maxlength="250" /><br />
'.$lang_ar['ad_attention'].' '.$lang_ar['ad_link_explaine'].' 
<br />
<strong>'.$lang_ar['ad_code'].':</strong><br />';

initializeEditor("ck");
echo '<br /><div id="tabs"><ul>';
	reset($_SESSION['fl']); $i=1;
	while(list($k,$v)=each($_SESSION['fl'])){
		echo '<li><a href="#tabs-'.$i.'" rel="formtab'.$i.'">'.strtoupper($k).'</a></li>';
		$i++;
	}
echo '</ul>';
reset($_SESSION['fl']);
$i = 1;
while(list($k,$v)=each($_SESSION['fl'])){
	echo '<div id="tabs-'.$i.'">';
	echo '<textarea name="ad_kode_'.$v.'" id="ad_kode_'.$v.'" rows="30" cols="120"></textarea><br />';
	addCKToField('ad_kode_'.$v, 'Default', '800', '300');
	echo '</div>';
	$i++;
}
echo '</div>';
	$HEADER .= '
	<script type="text/javascript" src="js/jquery/ui/jquery.ui.tabs.js"></script>
	<script type="text/javascript">
	$(function() { $("#tabs").tabs(); });
	</script>
	';

echo '
<strong>'.$lang_ar['ad_as_show'].':</strong><br />
	<select name="ad_type_show" onchange="sel_ad_type(this.value);">
		<option value="no">'.$lang_ar['ad_as_show1'].'</option>
		<option value="date">'.$lang_ar['ad_as_show2'].'</option>
		<option value="shows">'.$lang_ar['ad_as_show3'].'</option>
		<option value="clicks">'.$lang_ar['ad_as_show4'].'</option>
	</select>
	<div id="ad_par"></div>
<br />
<strong>'.$lang_ar['ad_section'].':</strong><br />
	<select name="ad_section_type" onchange="if(this.value==\'all\'){ document.getElementById(\'adSecBlock\').style.display=\'none\';} else {document.getElementById(\'adSecBlock\').style.display=\'block\';}">
	<option value="all" selected="selected">'.$lang_ar['ad_section1'].'</option>
	<option value="selected">'.$lang_ar['ad_section2'].'</option>
	</select>
<br />
<div id="adSecBlock" style="display:none;">
	'.$lang_ar['ad_section3'].':<br />
	'.$sec_chk.'
</div>
<br /><input type="submit" value="'.$lang_ar['save'].'" />
</form>
</div>';

$HEADER .= '
<script type="text/javascript">
	function sel_ad_type(val){
		if(val==\'no\') document.getElementById(\'ad_par\').innerHTML=\'\';
		if(val==\'shows\') document.getElementById(\'ad_par\').innerHTML = \''.$lang_ar['ad_section4'].':<br /><input type="text" name="ad_shows" id="ad_shows" size="10" /><br />\';
		if(val==\'clicks\') document.getElementById(\'ad_par\').innerHTML = \''.$lang_ar['ad_section5'].':<br /><input type="text" name="ad_clicks" id="ad_clicks" size="10" /><br />\';
		if(val==\'date\') document.getElementById(\'ad_par\').innerHTML = \''.$lang_ar['ad_section6'].':<br />'.$lang_ar['ad_section7'].': <input type="text" name="ad_dstart" id="ad_dstart" size="10" /> '.$lang_ar['ad_section8'].': <input type="text" name="ad_dstop" id="ad_dstop" size="10" /><br />\';
	}
</script>
';
}
//-----------Форма редактирования рекламы-------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=='edit_advert'){
$ad_q="SELECT * FROM ".$_conf['prefix']."advert WHERE ad_id='".mysql_real_escape_string(stripslashes($_REQUEST['id']))."'";
$ad_r = $db -> Execute($ad_q);
$t = $ad_r -> GetRowAssoc(false);

$sval=explode(",",$t['ad_section']);
$sec_chk=create_check($section_list,$sval,"ad_section","");

$cq="SELECT * FROM ".$_conf['prefix']."ad_place ORDER BY kod";
$cr = $db -> Execute($cq);
$kod_list=array();
  while(!$cr -> EOF){
  	$ctmp = $cr -> GetRowAssoc(false);
      $key=$ctmp['kod'];
      $kod_list[$key]=$ctmp['kod']." - ".$ctmp['comment'];
	  $cr -> MoveNext();
  }
$sel_kod=create_select($kod_list, $t['ad_place'], "ad_place");

$at1=$at2='';
if($t['ad_type']=='free') $at1='selected';
if($t['ad_type']=='paid') $at2='selected';

if($t['ad_type_show']=='no') $inner_div="";
if($t['ad_type_show']=='date') $inner_div="Укажите период показа (Формат даты: ДД-ММ-ГГГГ):<br />начало: <input type='text' name='ad_dstart' size='10' value='".date("d-m-Y",$t['ad_dstart'])."' /> конец: <input type='text' name='ad_dstop' size='10' value='".date("d-m-Y",$t['ad_dstop'])."' />";
if($t['ad_type_show']=='shows') $inner_div="Максимальное количество показов:<br /><input type='text' name='ad_shows' value='".$t['ad_shows']."' size='10' />";
if($t['ad_type_show']=='clicks') $inner_div="Максимальное количество кликов (переходов):<br /><input type='text' name='ad_clicks' size='10' value='".$t['ad_clicks']."' />";

if($t['ad_section']=='all') $shd1='none';
else $shd1='block';
$sc1=$sc2='';
if($t['ad_section']=='all') $sc1='selected';
else $sc2='selected';

$asw = $t['ad_switch']=='y' ? 'checked="checked"' : '';
/*
if($t['ad_region']=='all') $rhd1='none';
else $rhd1='block';
$rc1=$rc2='';
if($t['ad_region']=='all') $rc1='selected';
else $rc2='selected';
*/
echo '<div class="block">
<h3>'.$lang_ar['ad_edit'].'</h3>';
echo '<form action="admin.php?p='.$p.'&act=update_advert&id='.$_REQUEST['id'].'" method="post" enctype="multipart/form-data" id="EAF">
<input type="checkbox" name="ad_switch" id="ad_switch" value="y" '.$asw.' />  <strong>'.$lang_ar['ad_switch'].'</strong>
<br /><br />

<strong>'.$lang_ar['ad_code_place'].':</strong><br />
'.$sel_kod.'<br />

<strong>'.$lang_ar['ad_type'].':</strong><br />
<select name="ad_type">
<option value="free" '.$at1.'>'.$lang_ar['ad_type1'].'</option>
<option value="paid" '.$at2.'>'.$lang_ar['ad_type2'].'</option>
</select><br />

<strong>'.$lang_ar['ad_link'].':</strong><br />
<input type="text" name="ad_link" value="'.$t['ad_link'].'" size="50" maxlength="250" /><br />
'.$lang_ar['ad_attention'].' '.$lang_ar['ad_link_explaine'].' 
<br />
<strong>'.$lang_ar['ad_code'].':</strong><br />';


initializeEditor("ck");
echo '<br /><div id="tabs"><ul>';
	reset($_SESSION['fl']); $i=1;
	while(list($k,$v)=each($_SESSION['fl'])){
		echo '<li><a href="#tabs-'.$i.'" rel="formtab'.$i.'">'.strtoupper($k).'</a></li>';
		$i++;
	}
echo '</ul>';
reset($_SESSION['fl']);
$i = 1;
while(list($k,$v)=each($_SESSION['fl'])){
	echo '<div id="tabs-'.$i.'">';
	echo '<textarea name="ad_kode_'.$v.'" id="ad_kode_'.$v.'" rows="30" cols="120">'.stripslashes($t['ad_kode_'.$v]).'</textarea><br />';
	addCKToField('ad_kode_'.$v, 'Default', '800', '300');
	echo '</div>';
	$i++;
}
echo '</div>';
	$HEADER .= '
	<script type="text/javascript" src="js/jquery/ui/jquery.ui.tabs.js"></script>
	<script type="text/javascript">
	$(function() { $("#tabs").tabs(); });
	</script>
	';

echo '<br />
<strong>'.$lang_ar['ad_as_show'].':</strong><br />
<select name="ad_type_show" onchange="sel_ad_type(this.value);">
<option value="no">'.$lang_ar['ad_as_show1'].'</option>
<option value="date">'.$lang_ar['ad_as_show2'].'</option>
<option value="shows">'.$lang_ar['ad_as_show3'].'</option>
<option value="clicks">'.$lang_ar['ad_as_show4'].'</option>
</select><br />
<div id="ad_par">'.$inner_div.'</div>

<strong>'.$lang_ar['ad_section'].':</strong><br />
<select name="ad_section_type" onchange="if(this.value==\'all\') document.getElementById(\'adSec\').style.display=\'none\'; else document.getElementById(\'adSec\').style.display=\'block\';">
<option value="all" '.$sc1.'>'.$lang_ar['ad_section1'].'</option>
<option value="selected" '.$sc2.'>'.$lang_ar['ad_section2'].'</option>
</select><br />
<div id="adSec" style="display:'.$shd1.';">'.$lang_ar['ad_section3'].':<br />
'.$sec_chk.'
</div>
<br /><input type="submit" value="'.$lang_ar['save'].'" />
</form>
</div>';
$HEADER .= '
<script type="text/javascript">
	function sel_ad_type(val){
		if(val==\'no\') document.getElementById(\'ad_par\').innerHTML=\'\';
		if(val==\'shows\') document.getElementById(\'ad_par\').innerHTML = \''.$lang_ar['ad_section4'].':<br /><input type="text" name="ad_shows" id="ad_shows" size="10" /><br />\';
		if(val==\'clicks\') document.getElementById(\'ad_par\').innerHTML = \''.$lang_ar['ad_section5'].':<br /><input type="text" name="ad_clicks" id="ad_clicks" size="10" /><br />\';
		if(val==\'date\') document.getElementById(\'ad_par\').innerHTML = \''.$lang_ar['ad_section6'].':<br />'.$lang_ar['ad_section7'].': <input type="text" name="ad_dstart" id="ad_dstart" size="10" /> '.$lang_ar['ad_section8'].': <input type="text" name="ad_dstop" id="ad_dstop" size="10" /><br />\';
	}
</script>
';

}
//----------Список рекламы------------------------------
if(!isset($_REQUEST['act'])||$_REQUEST['act']=='list_advert'){
echo '<h3>'.$lang_ar['ad_list'].'</h3>';
$ad_q="SELECT * FROM ".$_conf['prefix']."advert ORDER BY ad_id DESC";
$ad_r = $db -> Execute($ad_q);
$ad_all = $ad_r -> RecordCount();
   if($ad_all==0){
		echo msg_box($lang_ar['ad_msg1']);
   }else{
      echo '<table border="0">';
	  while(!$ad_r -> EOF){
	  	$tmp = $ad_r -> GetRowAssoc(false);
		$asw = $tmp['ad_switch']=='y' ? '<font color="green">'.$lang_ar['ad_on'].'</font>' : '<font color="red">'.$lang_ar['ad_off'].'</font>';
          echo "<tr><td>".stripslashes($tmp['ad_kode_'.$_SESSION['admin_lang']])."</td><td>
           ".$lang_ar['ad_place'].": <b>".$tmp['ad_place']."</b><br />
		   ".$lang_ar['ad_show'].": ".$asw."<br />
           ".$lang_ar['ad_href'].": <font color='blue'>".$tmp['ad_link']."</font><br />";
           if($tmp['ad_type']=='free') echo $lang_ar['ad_type'].": <font color='red'>".$lang_ar['ad_type1']."</font><br />";
           else echo $lang_ar['ad_type'].": <font color=red>".$lang_ar['ad_type2']."</font><br />";
           if($tmp['ad_type_show']=='no') echo "<b>".$lang_ar['ad_type_show1']."</b><br />";
           if($tmp['ad_type_show']=='date') echo "<b>".$lang_ar['ad_type_show2']." ".date("d/m/Y",$tmp['ad_dstart'])." ".$lang_ar['ad_type_show2_1']." ".date("d/m/Y",$tmp['ad_dstop'])."</b><br />";
           if($tmp['ad_type_show']=='shows') echo "<b>".$lang_ar['ad_type_show3'].": ".$tmp['ad_shows']."</b><br />";
           if($tmp['ad_type_show']=='clicks') echo "<b>".$lang_ar['ad_type_show4'].": ".$tmp['ad_clicks']."</b><br />";
           if($tmp['ad_section']=='all'){
              echo "<b>".$lang_ar['ad_show_sec1']."</b><br />";
           }else{
              echo "<b>".$lang_ar['ad_show_sec2'].":</b><br /><div style='padding-left:20px;'>";
              echo cr_data_str($section_list,$tmp['ad_section']);
              echo "</div>";
           }
          echo "<font color=blue>".$lang_ar['ad_shows'].": ".$tmp['shows']."<br />".$lang_ar['ad_gos'].": ".$tmp['clicks']."</font><hr />
          <a href='admin.php?p=".$p."&act=edit_advert&id=".$tmp['ad_id']."'><b>".strtoupper($lang_ar['edit'])."</b></a> | <a href='admin.php?p=".$p."&act=delete_advert&id=".$tmp['ad_id']."'><b>".strtoupper($lang_ar['delete'])."</b></a>
          </td></tr><tr><td colspan='2' bgcolor='#7C9C81'>&nbsp;</td></tr>";
		  $ad_r -> MoveNext();
      }
      echo "</table>";
    }
}
//----------Список рекламных мест------------------------------
if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'list_ad_place'){
echo '<h2>'.$lang_ar['ad_list_place'].'</h2>';
$ad_q="SELECT * FROM ".$_conf['prefix']."ad_place ORDER BY id_adp";
$ad_r = $db -> Execute($ad_q);
$ad_all = $ad_r -> RecordCount();
   if($ad_all==0){
      echo msg_box($lang_ar['ad_msg2']);
   }else{
      echo "<table border=0 class='selrow' cellspacing='0'>";
          echo "<tr bgcolor='#F0F4F1'><td><b>Код</b></td><td><b>Описание</b></td><td>&nbsp;</td><td>&nbsp;</td></tr>";
      while(!$ad_r -> EOF){
	  	$tmp = $ad_r -> GetRowAssoc(false);
          echo "<tr><td><b>".$tmp['kod']."</b></td><td>".$tmp['comment']."</td>
          </td><td><a href='admin.php?p=".$p."&act=ed_ad_place&id=".$tmp['id_adp']."'>".$lang_ar['edit']."</a></td>
          </td><td><a href='admin.php?p=".$p."&act=del_ad_place&id=".$tmp['id_adp']."'>".$lang_ar['delete']."</a></td></tr>";
		  $ad_r -> MoveNext();
      }
      echo "</table>";
    }
}

/* *************************************************************** */
//-----------------------------------------------
function cr_data_str($list,$value){
$ir = explode(",",$value);
$data_str = "";
while (list($key, $name) = each($list)){
  for($i=0;$i<count($ir);$i++){
    if($key==$ir[$i]) {
       $data_str.=$name."<br />";
    }
    }
}
return $data_str;
}

?>
