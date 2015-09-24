<?php
/**
 * Скрипт управления конфигурационными перенными сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.01.01
 */

if(!defined("SHIFTCMS")) exit;
$ctype_ar = array(
'i'=>'Целое число',
'v'=>'Строка',
'r'=>'Radio',
's'=>'Select'
);
$smarty -> assign("PAGETITLE","<h2><a href='admin.php?p=".$p."'>".$alang_ar['conf_title']."</a></h2>");

//------------------------------------------------------------------------------
if(isset($_REQUEST['act']) && $_REQUEST['act']=="delete"){
	$q = "DELETE FROM ".$_conf['prefix']."site_config WHERE id='$_REQUEST[id]'";
	$ms = $db->Execute($q);
	//add_to_log($q,"fortrans");
	echo msg_box($alang_ar['conf_deleted']);
	unset($_REQUEST['act']);
}
//------------------------------------------------------------------------------
if(isset($_REQUEST['act']) && $_REQUEST['act']=="edit_form"){
	$r = $db -> Execute("select * from ".$_conf['prefix']."site_config where id='".$_REQUEST['id']."'");
	$t = $r -> GetRowAssoc(false);
  echo "<div class='block'>
  <h3>".$alang_ar['conf_editvar']."</h3>
  <form action='admin.php?p=".$p."' method='post' enctype='multipart/form-data'>
  <table border='0'>
  <tr><td align='right'>".$alang_ar['conf_vargroup']."</td><td><input type='text' name='grp' id='grp' size='20' value='".stripslashes($t['grp'])."' /></td></tr>
  <tr><td align='right'>".$alang_ar['conf_varname']."</td><td><input type='text' name='name' id='name' size='20' value='".stripslashes($t['name'])."' /></td></tr>
  <tr><td align='right'>".$alang_ar['conf_vardesc']."</td><td><input type='text' name='com' id='com' size='50' value='".stripslashes($t['com'])."' /></td></tr>
  <tr><td align='right'>".$alang_ar['conf_varvalue']."</td><td><input type='text' name='val' id='val' size='20' value='".stripslashes($t['val'])."' /></td></tr>
  <tr><td align='right'>".$alang_ar['conf_ctype']."</td><td>".create_select($ctype_ar, $t['ctype'], 'ctype', '', false)."</td></tr>
  <tr><td align='right'>".$alang_ar['conf_cvalue']."</td><td><input type='text' name='cvalue' id='cvalue' size='50' value='".stripslashes($t['cvalue'])."' /></td></tr>
  <tr><td><input type='hidden' name='act' value='cupd' /><input type='hidden' name='id' id='id' value='".$t['id']."' /></td><td><input type='submit' value='".$alang_ar['conf_addbut']."'></td></tr>
  </table>
  </form></div>";
	unset($_REQUEST['act']);
}
//------------------------------------------------------------------------------
if(isset($_REQUEST['act']) && $_REQUEST['act']=="add"){
	$q = "INSERT INTO ".$_conf['prefix']."site_config set 
	name='".mysql_real_escape_string(stripslashes($_REQUEST['name']))."',
	val='".mysql_real_escape_string(stripslashes($_REQUEST['val']))."',
	com='".mysql_real_escape_string(stripslashes($_REQUEST['com']))."',
	grp='".mysql_real_escape_string(stripslashes($_REQUEST['grp']))."',
	ctype='".mysql_real_escape_string(stripslashes($_REQUEST['ctype']))."',
	cvalue='".mysql_real_escape_string(stripslashes($_REQUEST['cvalue']))."'";
	$ms = $db->Execute($q);
	//add_to_log($q,"fortrans");
	echo msg_box($alang_ar['conf_added']);
	unset($_REQUEST['act']);
}
//------------------------------------------------------------------------------
if(isset($_REQUEST['act']) && $_REQUEST['act']=="cupd"){
	$q = "UPDATE ".$_conf['prefix']."site_config set 
	name='".mysql_real_escape_string(stripslashes($_REQUEST['name']))."',
	val='".mysql_real_escape_string(stripslashes($_REQUEST['val']))."',
	com='".mysql_real_escape_string(stripslashes($_REQUEST['com']))."',
	grp='".mysql_real_escape_string(stripslashes($_REQUEST['grp']))."',
	ctype='".mysql_real_escape_string(stripslashes($_REQUEST['ctype']))."',
	cvalue='".mysql_real_escape_string(stripslashes($_REQUEST['cvalue']))."'
	WHERE id='".$_REQUEST['id']."'";
	$ms = $db->Execute($q);
	onConfigUpdate(stripslashes($_REQUEST['name']),stripslashes($_REQUEST['val']));
	//add_to_log($q,"fortrans");
	echo msg_box($alang_ar['conf_added']);
	unset($_REQUEST['act']);
}
//------------------------------------------------------------------------------
if(isset($_REQUEST['act']) && $_REQUEST['act']=="save"){
	while(list($key, $val) = each($_REQUEST['var'])){
		$q = "UPDATE ".$_conf['prefix']."site_config SET val='".mysql_real_escape_string($val)."' WHERE name='".mysql_real_escape_string($key)."'";
		$ms = $db->Execute($q);
		onConfigUpdate(stripslashes($key),stripslashes($val));
	}
/*
  while (list($key, $val) = each($_POST)){
  	  $q = "UPDATE ".$_conf['prefix']."site_config SET val='".$val."' WHERE name='".$key."'";
     $ms = $db->Execute($q);
  }
*/
	//add_to_log($q,"fortrans");
	echo msg_box($alang_ar['conf_saved']);
	unset($_REQUEST['act']);
}


//-----------------------------------------------------------------------------

if(!isset($_REQUEST['act']) || $_REQUEST['act']=="list"){
    
	//echo "<a href='admin.php?p=$p&act=add_form'><b>".$alang_ar['conf_create']."</b></a><br><br>";

	$sg=$db->Execute("SELECT grp FROM ".$_conf['prefix']."site_config");
	$i=0;
	while(!$sg->EOF){
         $grp[]=$sg->fields[0];
		 $sg->MoveNext();
		 $i++;
    }

	$gr=array_unique($grp);
    sort($gr);
    reset($gr);
 
   for ($n=0;$n<count($gr);$n++){ 
     $ms = $db->Execute("SELECT * FROM ".$_conf['prefix']."site_config WHERE grp='".$gr[$n]."'");
     echo "<div id='".$n.$n."' class='block' style='cursor:pointer;'>
           <a href='javascript:void(null)' onclick=\"SwitchShow('CF".$n."')\"><span><b>".$gr[$n]."</b></span></a>
           
     <div id='CF".$n."' style=\"display:none;\">
	 <form method='post' action='admin.php?p=".$p."&act=save' enctype='multipart/form-data'>
     <table border='0' cellspacing='0' class='selrow'>";
     $i=0;
     while (!$ms->EOF) { 	
       $tmp = $ms -> GetRowAssoc();
       $tar[] = $tmp['GRP'];
       echo "<tr>";
       echo "<td align=right valign=bottom><b>".$tmp['NAME']." = </b></td>";
       echo "<td><b>".stripslashes($tmp['COM'])."</b><br />".create_conf_field($tmp['NAME'], $tmp['VAL'], $tmp['CTYPE'], $tmp['CVALUE'])."</td>";
       echo "<td><a href='admin.php?p=".$p."&id=".$tmp['ID']."&act=edit_form'><b>".$alang_ar['edit']."</b></a></td>";
       echo "<td><a href='admin.php?p=".$p."&id=".$tmp['ID']."&act=delete'><b>".$alang_ar['conf_del']."</b></a></td>";
       echo "</tr>";
       $ms -> MoveNext(); 
       $i++;
     }
     echo "<tr>";
     echo "<td colspan=4 align=center><input type=submit value='".$alang_ar['conf_save']."'></td>";
     echo "</tr>";
     echo "</table></form>";
     echo "</form></div></div>";
   }
  echo "<br /><div class='block'>
  <h3>".$alang_ar['conf_create']."</h3>
  <form action='admin.php?p=".$p."' method='post' enctype='multipart/form-data'>
  <table border='0'>
  <tr><td align='right'>".$alang_ar['conf_vargroup']."</td><td><input type='text' name='grp' size='20' /></td></tr>
  <tr><td align='right'>".$alang_ar['conf_varname']."</td><td><input type='text' name='name' size='20' /></td></tr>
  <tr><td align='right'>".$alang_ar['conf_vardesc']."</td><td><input type='text' name='com' size='50' /></td></tr>
  <tr><td align='right'>".$alang_ar['conf_varvalue']."</td><td><input type='text' name='val' size='20' /></td></tr>
  <tr><td align='right'>".$alang_ar['conf_ctype']."</td><td>".create_select($ctype_ar, '', 'ctype', '', false)."</td></tr>
  <tr><td align='right'>".$alang_ar['conf_cvalue']."</td><td><input type='text' name='cvalue' id='cvalue' size='50' /></td></tr>
  <tr><td><input type='hidden' name='act' value='add' /></td><td><input type='submit' value='".$alang_ar['conf_addbut']."'></td></tr>
  </table>
  </form></div>";
   
}


if(isset($_REQUEST['act']) && $_REQUEST['act']=="modlist"){
     $ms = $db -> Execute("SELECT * FROM ".$_conf['prefix']."site_config WHERE grp='".$_REQUEST['mod']."'");

     echo '<br /><form method="post" action="javascript:void(null)" id="modSetF" enctype="multipart/form-data">
	 <input type="hidden" name="p" id="p" value="'.$p.'" />
	 <input type="hidden" name="act" id="act" value="modSave" />
     <table border="0" cellspacing="0" class="selrow">';
     $i = 0;
     while(!$ms -> EOF) { 	
       $tmp = $ms -> GetRowAssoc(false);
       $tar[] = $tmp['grp'];
       echo '<tr>';
       echo '<td align="right" valign="middle"><b>'.$tmp['name'].' = </b></td>';
       echo '<td><b>'.$tmp['com'].'</b><br>'.create_conf_field($tmp['name'], $tmp['val'], $tmp['ctype'], $tmp['cvalue']).'</td>';
       echo '</tr>';
       $ms -> MoveNext(); 
       $i++;
     }
     echo '<tr>';
     echo '<td colspan="2" align="center"><input type="submit" value="'.$alang_ar['conf_save'].'" onclick="doLoad(\'modSetF\',\'modSetRes\')" /></td>';
     echo '</tr>';
     echo '</table>';
     echo '</form>
	 <div id="modSetRes"></div>';
}

//------------------------------------------------------------------------------
if(isset($_REQUEST['act']) && $_REQUEST['act']=="modSave"){
	while(list($key, $val) = each($_REQUEST['var'])){
		$q = "UPDATE ".$_conf['prefix']."site_config SET val='".mysql_real_escape_string($val)."' WHERE name='".mysql_real_escape_string($key)."'";
		$ms = $db->Execute($q);
		onConfigUpdate(stripslashes($key),stripslashes($val));
	}
	echo msg_box($alang_ar['conf_saved']);
}


/*
* функция для вывода поля с выбором переменной
*/ 
function create_conf_field($name, $val, $ctype, $cvalue){
	if($ctype=="i"){
		return '<input type="text" name="var['.$name.']" id="var['.$name.']" value="'.$val.'" style="width:50px;" />';
	}elseif($ctype=="v"){
		return '<input type="text" name="var['.$name.']" id="var['.$name.']" value="'.$val.'" style="width:150px;" />';
	}elseif($ctype=="s"){
		$cv = explode(",",$cvalue); reset ($cv); $valdata = array();
		while(list($k,$v)=each($cv)){$kv = explode(":",$v); $valdata[trim($kv[0])] = trim($kv[1]);}
		return create_select($valdata, $val, 'var['.$name.']', '', false);
	}elseif($ctype=="r"){
		$cv = explode(",",$cvalue); reset ($cv); $valdata = array();
		while(list($k,$v)=each($cv)){$kv = explode(":",$v); $valdata[trim($kv[0])] = trim($kv[1]);}
		//return create_select($valdata, $val, $name, '', false);
		return create_radio($valdata,$val,'var['.$name.']',$add_par="",$sep=' &nbsp; ');
	}else{
		return 'Unknow type';
	}
}

function onConfigUpdate($name, $val){
	global $db, $_conf;
	if($name=="enable_reg"){
		if($val=="y") $r = $db -> Execute("update ".$_conf['prefix']."page set siteshow='y', menushow1='', menushow2='', menushow3='' where pname='register'");
		else $r = $db -> Execute("update ".$_conf['prefix']."page set siteshow='n', menushow1='', menushow2='', menushow3='' where pname='register'");
	}
	load_conf_var();
}

?>
