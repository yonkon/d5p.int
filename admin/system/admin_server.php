<?php
/**
 * Набор действий используемых в системе управления
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2011 
 * @link http://shiftcms.net
 * @version 1.01.02
 26.09.2009 - В функции настройки показа блоков на странице установлено ограничение на вывод страниц отображаемых только на сайте. Испрален баг, когда не сохранялись данные блока, когда не выбрано ни одной страницы.
*/
if(!defined("SHIFTCMS")) exit;

/* ************************************************************************* */
/* Форма настройки меню в системе администрирования для группы пользователей */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="SetMenuForm"){
	echo "<strong>".sprintf($alang_ar['as_msg1'], $_REQUEST['group_code'])."</strong><br />".$alang_ar['as_msg2']."<br /><br />";
	echo "<form action='javascript:void(null)' id='GroupMenuForm' method='post' enctype='multipart/form-data'>
	<input type='hidden' name='p' id='p' value='admin_server' />
	<input type='hidden' name='act' id='act' value='SetMenuSave' />
	<input type='hidden' name='group_code' id='group_code' value='$_REQUEST[group_code]' />
	<table border='0' cellspacing='1'>";

echo OutListMenu(0, 0);

echo "</table>
<input type='button' value='$alang_ar[save]' onclick=\"doLoad('GroupMenuForm','GroupMenuRes')\" />
</form>
<div id='GroupMenuRes'></div>";
}

/* ******************************************************************** */
/* сохранение меню в системе администрирования для группы пользователей */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="SetMenuSave"){
	if(isset($_REQUEST['mid'])){
		$midar = $_REQUEST['mid'];
		$gc = $_REQUEST['group_code'];
			$q = "select * from ".$_conf['prefix']."admin_menu";
			$r = $db -> Execute($q);
			while(!$r -> EOF){
				$t = $r -> GetRowAssoc();
				$mid = $t['MID'];
				if(trim($t['PUNKT_GROUPS'])!="") $mar = explode(",",$t['PUNKT_GROUPS']);
				else $mar = array();
				$new_mar = array();
				if(isset($midar[$mid])){
					if(!in_array($gc,$mar)) $mar[]=$gc;
					$new_mar = $mar;
				}else{
					while(list($key,$val)=each($mar)){
						if($gc!=$val) $new_mar[] = $val;
					}
				}
				if(count($new_mar)!=0) $nm = implode(",",$new_mar);
				else $nm = '';
				$q1 = "update ".$_conf['prefix']."admin_menu set punkt_groups='$nm' where mid='$mid'";
				$r1 = $db -> Execute($q1);
				$r -> MoveNext();
			}
	}
	$smarty->assign("info_message", $alang_ar['saved']);
	echo $smarty->fetch("messeg.tpl");
}

/* ************************************************ */
/* Форма настройки доступа для группы пользователей */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="SetAccessForm"){
	echo "<strong>".sprintf($alang_ar['as_msg3'], $_REQUEST['group_code'])."</strong><br />".$alang_ar['as_msg4']."<br /><br />";
	echo "<form action='javascript:void(null)' id='GroupAccessForm' method='post' enctype='multipart/form-data'>
	<input type='hidden' name='p' id='p' value='admin_server' />
	<input type='hidden' name='act' id='act' value='SetAccessSave' />
	<input type='hidden' name='group_code' id='group_code' value='$_REQUEST[group_code]' />
	<table border='0' cellspacing='1'>";

	echo OutListPage('', 0);
	
echo "</table>
<input type='button' value='$alang_ar[save]' onclick=\"doLoad('GroupAccessForm','GroupAccessRes')\" />
</form>
<div id='GroupAccessRes'></div>";
}

/* ******************************************************************** */
/* сохранение меню в системе администрирования для группы пользователей */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="SetAccessSave"){
	if(isset($_REQUEST['mid'])){
		$midar = $_REQUEST['mid'];
		$gc = $_REQUEST['group_code'];
			$q = "select * from ".$_conf['prefix']."page";
			$r = $db -> Execute($q);
			while(!$r -> EOF){
				$t = $r -> GetRowAssoc();
				$mid = $t['PNAME'];
				if(trim($t['PGROUPS'])!="") $mar = explode(",",$t['PGROUPS']);
				else $mar = array();
				$new_mar = array();
				if(isset($midar[$mid])){
					if(!in_array($gc,$mar)) $mar[]=$gc;
					$new_mar = $mar;
				}else{
					while(list($key,$val)=each($mar)){
						if($gc!=$val) $new_mar[] = $val;
					}
				}
				if(count($new_mar)!=0) $nm = implode(",",$new_mar);
				else $nm = '';
				$q1 = "update ".$_conf['prefix']."page set pgroups='$nm' where pname='$mid'";
				//echo $q1."<br />";
				$r1 = $db -> Execute($q1);
				$r -> MoveNext();
			}
	}
	$smarty->assign("info_message", $alang_ar['saved']);
	echo $smarty->fetch("messeg.tpl");
}

/* ******************************************************************** */
/*          Вывод справки к странице                                    */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="GetPageHelp"){
//	print_r($_REQUEST); exit;
	if(isset($_REQUEST['source']) && file_exists($_REQUEST['source'])){
		$help = file_get_contents($_REQUEST['source']);
		echo "<div style='padding:5px;'>";
		echo $help;
		echo "</div>";	
	}else{
		echo "<br /><br /><strong>".$alang_ar['as_msg5']."</strong>";
	}
}

/* обработка запроса к базе данных */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="SendSQL" && isset($_SESSION['USER_IDU']) && $_SESSION['USER_GROUP']=="super"){
$query="";
$q=0;
$handle=explode("\n",$_REQUEST['sql']);

for($k=0;$k<count($handle);$k++){
	$buffer=trim($handle[$k]);
	if($buffer{0}=='-' || $buffer{0}=='/' || $buffer==''){
		continue;
	}else{
		$query.=$buffer;
		$blen=strlen($query)-1;
		if($query{$blen}==";") {
		if (!( $r=mysql_query(stripslashes($query)))) {
			echo msg_box(mysql_errno() . ": " . mysql_error(). "<br>");
		}else{
			$res="<table cellspacing='0' cellpadding='0' border='0' class='selrow'>";
			//for ($i=0; $i<=sqlrows($r) && $tmp=sqlget($r); $i++) {
			while($tmp = @mysql_fetch_array($r, MYSQL_NUM)){
				$res.="<tr>";
				for ($j=0; $j<count($tmp); $j++) {
					if(isset($tmp[$j])) $res.="<td>".$tmp[$j]."</td>";
				}
				$res.="</tr>";
			}
			$res.="</table>";
			echo sprintf($alang_ar['as_msg6'], stripslashes($query), $res);
		}
		$q++;
		$query="";
		}
	}
}
	//echo mysql_info();
}

/* обработка запроса к базе данных */
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="ShowDBTableInfo"){
if(isset($_REQUEST['tb'])){
    $result = mysql_query("SELECT * FROM $_REQUEST[tb]");
    $fields = mysql_num_fields($result);
    $rows   = mysql_num_rows($result);
    $table = mysql_field_table($result, 0);

   echo "<b>".sprintf($alang_ar['as_msg7'], $_REQUEST['tb'], $fields, $rows)."</b><br>";
   echo "<table cellspacing='0' class='selrow' border='0'>
   <tr><td>".$alang_ar['as_field']."</td><td>".$alang_ar['as_type']."</td><td>".$alang_ar['as_lenght']."</td><td>".$alang_ar['as_flags']."</td></tr>";
   for ($i = 0; $i < $fields; $i++) {
      echo "<tr><td><b>".mysql_field_name($result, $i) . "</b></td>";
      echo "<td>".mysql_field_type($result, $i) . "</td>";
      echo "<td>".mysql_field_len($result, $i) . "</td>";
      echo "<td>".mysql_field_flags($result, $i) . "</td></tr>";
   }
   echo "</table>";
    mysql_free_result($result);
    mysql_close();
}
}


/* ************************************************ */
/* Форма настройки блоков для страниц сайта */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="SetPageListForBlock"){
	echo "<strong>".sprintf($alang_ar['as_msg8'], $_REQUEST['block_name'])."<br /><br />";
	echo "<form action='javascript:void(null)' id='PageForBlockForm' method='post' enctype='multipart/form-data'>
	<input type='hidden' name='p' id='p' value='admin_server' />
	<input type='hidden' name='act' id='act' value='PageForBlockSave' />
	<input type='hidden' name='block_name' id='block_name' value='$_REQUEST[block_name]' />
	<input type='hidden' name='block_id' id='block_id' value='$_REQUEST[block_id]' />
	<table border='0' cellspacing='1'>
	<tr><td>Выделить все / Снять выделение</td><td><input type='checkbox' onclick='setall(\"CHKB\")' /></td></tr>
	";

	echo OutListPageB('', 0);
		
echo "</table>
<input type='button' value='$alang_ar[save]' onclick=\"doLoad('PageForBlockForm','PageForBlockRes')\" />
</form>
<div id='PageForBlockRes'></div>";
}


/* ******************************************************************** */
/* сохранение зависимости блоков и страниц */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="PageForBlockSave"){
	//if(isset($_REQUEST['mid'])){
		if(isset($_REQUEST['mid'])) $midar = $_REQUEST['mid'];
		else $midar = array();
		$gc = $_REQUEST['block_name'];
			$q = "select * from ".$_conf['prefix']."page WHERE ptype='front' OR ptype='both'";
			$r = $db -> Execute($q);
			while(!$r -> EOF){
				$t = $r -> GetRowAssoc();
				$mid = $t['PNAME'];
				if(trim($t['PAGE_BLOCKS'])!="") $mar = explode(",",$t['PAGE_BLOCKS']);
				else $mar = array();
				$new_mar = array();
				if(isset($midar[$mid])){
					if(!in_array($gc,$mar)) $mar[]=$gc;
					$new_mar = $mar;
				}else{
					while(list($key,$val)=each($mar)){
						if($gc!=$val) $new_mar[] = $val;
					}
				}
				if(count($new_mar)!=0) $nm = implode(",",$new_mar);
				else $nm = '';
				$q1 = "update ".$_conf['prefix']."page set page_blocks='$nm' where pname='$mid'";
				$r1 = $db -> Execute($q1);
				$r -> MoveNext();
			}
	//}
	$smarty->assign("info_message", $alang_ar['saved']);
	echo $smarty->fetch("messeg.tpl");
}


/* ******************************************************************** */
/* создание полного дампа базы данных */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="makeDBdump"){
	require "include/config/set.inc.php";
	$dumpfile = 'tmp/sql/'.$base.'-'.date("d-m-Y-H-i",time()).'.sql';
	$fp = fopen($dumpfile,"a");
	fwrite($fp,"-- ShiftCMS SQL Dump\n");
	fwrite($fp,"-- ".date("d.m.Y H:i",time())."\n");
	fwrite($fp,"-- Database: ".$base."\n\n");
	$q = "SHOW TABLES FROM $base";
	$r = $db -> Execute($q);
	$tables = array();
	if($r){
	while($arr = $r->FetchRow()){
		$tables[] = $arr[0];
		$rt = $db -> Execute("show create table `".$arr[0]."`");
		$tt = $rt -> GetRowAssoc(false);
		
		fwrite($fp,"\n-- Structure of table: ".$arr[0].";\n\n");
		fwrite($fp,"DROP TABLE IF EXISTS `".$arr[0]."`;\n");
		fwrite($fp,$tt['create table'].";\n");
		$rs = $db -> Execute("select * from `".$arr[0]."`");
		if($rs -> RecordCount() > 0){
			fwrite($fp,"\n-- Dump of table: ".$arr[0].";\n\n");
			$max = 100; $i = 0; $insert_str = '';
			while(!$rs->EOF){
				$ts = $rs -> GetRowAssoc(false);
				if($i==0){
					$insert_str = "INSERT INTO `".$arr[0]."` (";
					$j=0;
					while(list($k,$v)=each($ts)){
						if($j==0) $insert_str .= "`".$k."`";
						else $insert_str .= ", `".$k."`";
						$j++;
					}
					$insert_str .= ") VALUES ";
					reset($ts);
					$d=0;
					while(list($k,$v)=each($ts)){
						if($d==0) $insert_str .= "('".mysql_real_escape_string(stripslashes($v))."'";
						else $insert_str .= ", '".mysql_real_escape_string(stripslashes($v))."'";
						$d++;
					}
					$insert_str .= ")";
				}else{
					reset($ts);
					$d=0;
					while(list($k,$v)=each($ts)){
						if($d==0) $insert_str .= ", ('".mysql_real_escape_string(stripslashes($v))."'";
						else $insert_str .= ", '".mysql_real_escape_string(stripslashes($v))."'";
						$d++;
					}
					$insert_str .= ")";
				}
				$i++;
				if($i==$max){
					fwrite($fp,$insert_str.";\n");
					$insert_str .= "";
					$i = 0; $insert_str = '';
				}
				$rs -> MoveNext();
			}
			fwrite($fp,$insert_str.";\n");
		}
	}}
	fclose($fp);
	echo getDBdumpFile('tmp/sql');
}

/* ******************************************************************** */
/* удаление дампа базы данных */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="delSQLDump"){
	@unlink(stripslashes($_REQUEST['fl']));
	echo msg_box("Дамп базы данных ".stripslashes($_REQUEST['fl'])." удален!");
}

/* ************************************************************** */
function OutListMenu($punkt_parent, $level){
	global $db, $_conf, $p;
	$tab = '';
	$fill = str_repeat("&nbsp;", $level*4);
  $q="SELECT * FROM ".$_conf['prefix']."admin_menu WHERE punkt_parent='$punkt_parent' ORDER BY punkt_order";
		$r = $db -> Execute($q);

  while(!$r -> EOF){
  	$tmp = $r -> GetRowAssoc();
	$mid = $tmp['MID'];
	$mar = explode(",",$tmp['PUNKT_GROUPS']);
	if(in_array($_REQUEST['group_code'],$mar)) $ch = "checked='checked'";
	else $ch = "";
	$pnl = "PUNKT_NAME_".strtoupper($_SESSION['admin_lang']);
	echo "<tr class='tbg".$level."'>
	<td>$fill<strong>".$tmp[$pnl]."</strong></td>
	<td><input type='checkbox' name='mid[$mid]' id='mid[$mid]' value='y' $ch /></td>
	</tr>";
 
	 $tab .= OutListMenu($tmp['MID'], $level+1);
	 $r -> MoveNext();
  }
  return $tab;		
}

/* ************************************************************** */
function OutListPage($pparent, $level){
	global $db, $_conf, $p;
	$tab = '';
	$fill = str_repeat("&nbsp;", $level*4);
  $q="SELECT pid, pname, pparent, pgroups, p_title_".$_SESSION['admin_lang']." FROM ".$_conf['prefix']."page WHERE pparent='$pparent' ORDER BY linkpos";
		$r = $db -> Execute($q);

  while(!$r -> EOF){
  	$tmp = $r -> GetRowAssoc();
	$ms = $db->Execute("SELECT * FROM ".$_conf['prefix']."page WHERE plevel='0' ORDER BY ptitle");
		$pname = $tmp['PNAME'];
		$mar = explode(",",$tmp['PGROUPS']);
		if(in_array($_REQUEST['group_code'],$mar)) $ch = "checked='checked'";
		else $ch = "";
		$tab .= "<tr class='tbg".$level."'>
		<td> $fill <strong>".stripslashes($tmp['P_TITLE_'.strtoupper($_SESSION['admin_lang'])])."</strong></td>
		<td><input type='checkbox' name='mid[$pname]' id='mid[$pname]' value='y' $ch /></td>
		</tr>";
	 $tab .= OutListPage($tmp['PNAME'], $level+1);
	 $r -> MoveNext();
  }
  return $tab;		
}


/* ************************************************************** */
function OutListPageB($pparent, $level){
	global $db, $_conf, $p;
	$tab = '';
	$fill = str_repeat("&nbsp;", $level*4);
  $q="SELECT pid, pname, pparent, pgroups, page_blocks, p_title_".$_SESSION['admin_lang']." FROM ".$_conf['prefix']."page WHERE pparent='$pparent' AND (ptype='front' OR ptype='both') ORDER BY linkpos";
		$r = $db -> Execute($q);

  while(!$r -> EOF){
  	$tmp = $r -> GetRowAssoc();
		//$ms = $db->Execute("SELECT * FROM ".$_SESSION['conf']['prefix']."page WHERE plevel='0' ORDER BY ptitle");
		$pname = $tmp['PNAME'];
		$mar = explode(",",$tmp['PAGE_BLOCKS']);
		if(in_array($_REQUEST['block_name'],$mar)) $ch = "checked='checked'";
		else $ch = "";
		echo "<tr class='tbg".$level."'>
		<td> $fill <strong>".stripslashes($tmp['P_TITLE_'.strtoupper($_SESSION['admin_lang'])])."</strong></td>
		<td><input class='CHKB' type='checkbox' name='mid[$pname]' id='mid[$pname]' value='y' $ch /></td>
		</tr>";
	
		 $tab .= OutListPageB($tmp['PNAME'], $level+1);
	 $r -> MoveNext();
  }
  return $tab;		
}

function getDBdumpFile($sqldir){
	global $_conf, $lang_ar;
	$fileout = ''; $i='';
	$dh  = opendir($sqldir);
	while (false !== ($fl = readdir($dh))) {
	    if($fl!='.' && $fl!='..' && $fl!='.htaccess') $fileout .= '<tr id="SQLTR'.$i.'"><td><a href="admin.php?p=getfile&type=SQLDump&fl='.$sqldir.'/'.$fl.'">'.$fl.'</a></td><td>'.get_filesize(filesize($sqldir.'/'.$fl)).'</td><td><a href="javascript:void(null)" onclick="getdata(\'\',\'get\',\'?p=admin_server&act=delSQLDump&fl='.$sqldir.'/'.$fl.'\',\'ActionRes\'); delelem(\'SQLTR'.$i.'\')">'.$lang_ar['delete'].'</a></td></tr>';
		$i++;
	}
	return '<table border="0" class="selrow" cellspacing="0">'.$fileout.'</table>';
}
?>