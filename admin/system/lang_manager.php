<?php
/**
 * Управление языками сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2010 
 * @link http://shiftcms.net
 * @version 1.02.02	23.12.2009
 * 10.10.2010 - добавлены функции импорта/экспорта записей в .csv формат
 * 04.12.2010 - добавлена возможность устанавливать основной язык сайта
 */
if(!defined("SHIFTCMS")) exit;


/**
* Додаємо запис
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="AddRecord"){
	$fl = GetLangField(); $er = 0;
	if(trim($_REQUEST['pkey'])=="" || trim($_REQUEST['sections'])==""){
		echo msg_box($lang_ar['ln_er1']);
		$er = 1;
	}
	$rc = $db -> Execute("SELECT * FROM ".$_conf['prefix']."translate WHERE pkey='".mysql_real_escape_string(stripslashes($_REQUEST['pkey']))."'");
	if($rc -> RecordCount() > 0){
		echo msg_box($lang_ar['ln_er2']);
		$er = 1;
	}
	if($er==0){
		$q = "INSERT INTO ".$_conf['prefix']."translate (pkey,sections,".implode(",",$fl).")VALUES(
		'".mysql_real_escape_string(stripslashes($_REQUEST['pkey']))."',
		'".mysql_real_escape_string(stripslashes($_REQUEST['sections']))."'";
		reset($fl);
		while(list($k1, $v1)=each($fl)){		 
			$q .= ", '".mysql_real_escape_string(stripslashes($_REQUEST[$v1]))."'"; 
		}
		$q .= ")";
		$ri = $db -> Execute($q);
		echo msg_box($lang_ar['ln_ok1']);
	}
}

/**
* Видалити запис
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="DelRecord"){
	$rd = $db -> Execute("DELETE FROM ".$_conf['prefix']."translate WHERE id='".stripslashes($_REQUEST['id'])."'");
	echo msg_box($lang_ar['ln_ok2']);
}

/**
* Видалити групу записів
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="delSection"){
	$rd = $db -> Execute("DELETE FROM ".$_conf['prefix']."translate WHERE sections='".mysql_real_escape_string(stripslashes($_REQUEST['sect']))."'");
	echo msg_box($lang_ar['ln_ok3']);
	unset($_REQUEST['act']);
	unset($_REQUEST['sect']);
	$_REQUEST['act'] = "EditForm";
}

/**
* Зберігаємо дані
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="SaveData"){
	//echo '<pre>';
	//print_r($_REQUEST);
	//echo '</pre>';
	$fl = GetLangField();
	while(list($k,$v)=each($_REQUEST['oldpkey'])){
		$rc = $db -> Execute("SELECT * FROM ".$_conf['prefix']."translate WHERE pkey='".mysql_real_escape_string(stripslashes($_REQUEST['pkey'][$k]))."' AND id!='".$k."'");
		if($rc -> RecordCount() == 0){
			$q = "UPDATE ".$_conf['prefix']."translate SET pkey='".$v."', 
			sections='".mysql_real_escape_string(stripslashes($_REQUEST['sections'][$k]))."'";
			reset($fl);
			while(list($k1, $v1)=each($fl)){		 
				$q .= ", ".$v1."='".mysql_real_escape_string(stripslashes($_REQUEST[$v1][$k]))."'"; 
			}
			$q .= " WHERE id = ".$k;
			//echo $q.'<br />';
			$r = $db -> Execute($q);
		}else{
			echo msg_box($lang_ar['ln_er3']);
		}
	}
	echo msg_box($lang_ar['ln_ok4']);
}

/**
* Форма редагування мов
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="LoadForm"){
	$fl = GetLangField();
	$r = $db -> Execute("SELECT * 
	FROM ".$_conf['prefix']."translate 
	WHERE sections='".mysql_real_escape_string(stripslashes($_REQUEST['sections']))."'");
	$i = 0;
	$id = time();
	echo '<div class="block"><form method="post" action="javascript:void(null)" enctype="multipart/form-data" id="F'.$id.'">';
	echo '<input type="hidden" name="p" id="p" value="lang_manager" />';
	echo '<input type="hidden" name="act" id="act" value="SaveData" />';
	echo '<table border="0" cellspacing="0" class="selrow">';
	echo '<tr><th>'.$lang_ar['ln_key'].'</th><th>'.$lang_ar['ln_section'].'</th>';
	reset($fl);
	while(list($k1, $v1)=each($fl)){		 
		echo '<th>'.strtoupper($v1).' <img src="'.$_conf['admin_tpl_dir'].'flags/'.$v1.'.gif" /></th>';
	}
	if($_SESSION['USER_GROUP']=="super") echo '<th>'.$lang_ar['delete'].'</th>';
	echo '</tr>';
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		$ro = $_SESSION['USER_GROUP']=="super" ? "" : ' readonly="readonly"';
		echo '<tr id="TR'.$t['id'].'">';
		echo '<td><input type="hidden" name="oldpkey['.$t['id'].']" id="oldpkey['.$t['id'].']" value="'.htmlspecialchars(stripslashes($t['pkey'])).'" />';
		echo '<input type="text" size="20" name="pkey['.$t['id'].']" id="pkey['.$t['id'].']" value="'.htmlspecialchars(stripslashes($t['pkey'])).'"'.$ro.' /></td>';
		echo '<td><input type="text" size="20" name="sections['.$t['id'].']" id="sections['.$t['id'].']" value="'.htmlspecialchars(stripslashes($t['sections'])).'"'.$ro.' /></td>';
		reset($fl);
		while(list($k1, $v1)=each($fl)){		 
			echo '<td><input type="text" name="'.$k1.'['.$t['id'].']" id="'.$k1.'['.$t['id'].']" value="'.htmlspecialchars(stripslashes($t[$k1])).'" size="30" /></td>';
		}
		if($_SESSION['USER_GROUP']=="super") echo '<td><a href="javascript:void(null)" onclick="getdata(\'\', \'post\', \'?p=lang_manager&sections='.stripslashes($t['sections']).'&act=DelRecord&id='.$t['id'].'\', \'D'.$id.'\'); delelem(\'TR'.$t['id'].'\')">'.$lang_ar['delete'].'</a></td>';
		echo '</tr>';
		$i++;
		$r -> MoveNext();
	}
	echo '</table>';
	echo '<input type="button" onclick="doLoad(\'F'.$id.'\',\'D'.$id.'\')" value="'.$alang_ar['save'].'" />';
	echo '</form>';
	echo '<div id="D'.$id.'"></div></div>';
}







$links = ' | <a href="admin.php?p='.$p.'&act=EditForm"><strong>'.$lang_ar['ln_edit'].'</strong></a> | ';
$links .= '<a href="admin.php?p='.$p.'&act=LangList"><strong>'.$lang_ar['ln_list'].'</strong></a> | ';
$smarty -> assign("PAGETITLE","<h2 style='display:inline'><a href='admin.php?p=lang_manager'>".$lang_ar['ln_manage']."</a></h2> ".$links);

/**
* Форма редагування мов
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="EditForm"){
	$fl = GetLangField();
	echo '<form method="post" action="javascript:void(null)" enctype="multipart/form-data" id="Fadd">';
	echo '<input type="hidden" name="p" id="p" value="lang_manager" />';
	echo '<input type="hidden" name="act" id="act" value="AddRecord" />';
	echo '<table border="0" cellspacing="0" class="selrow">';
	echo '<tr><th>Ключ</th><th>'.$lang_ar['ln_section'].'</th>';
	reset($fl);
	while(list($k1, $v1)=each($fl)){		 
		echo '<th>'.strtoupper($v1).' <img src="'.$_conf['admin_tpl_dir'].'flags/'.$v1.'.gif" /></th>';
	}
	echo '<th>&nbsp;</th>';
	echo '</tr>';

	echo '<tr><td><input type="text" name="pkey" id="pkey" value="" size="30" /></td>
	<td><input type="text" name="sections" id="sections" value="" size="30" /></td>';
	reset($fl);
	while(list($k1, $v1)=each($fl)){		 
		echo '<td><input type="text" name="'.$v1.'" id="'.$v1.'" value="" size="30" /></td>';
	}
	echo '<td><input type="button" onclick="doLoad(\'Fadd\',\'Dadd\')" value="'.$alang_ar['add'].'" /></td>';
	echo '</tr>';
	echo '</table>';
	echo '</form>';
	echo '<div id="Dadd"></div>';

	$r = $db -> Execute("SELECT sections FROM ".$_conf['prefix']."translate GROUP BY sections");
	$i = 0;
	echo '<table>';
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		$sect = $t['sections']=="" ? "Undefined" : stripslashes($t['sections']);
		echo "<tr><td valign='top'>
		 &raquo; <a href='javascript:void(null)' onclick=\"if(document.getElementById('B".$i."').style.display=='none'){ getdata('','post','?p=lang_manager&sections=".stripslashes($t['sections'])."&act=LoadForm','B".$i."'); document.getElementById('B".$i."').style.display='block'} else {document.getElementById('B".$i."').style.display='none'; document.getElementById('B".$i."').innerHTML='none'}\"><strong>".$sect."</strong></a>
		 </td>";
		 if($_SESSION['USER_GROUP']=="super") echo "<td>&nbsp;&nbsp; - &nbsp;&nbsp;<small><a href='admin.php?p=".$p."&amp;sect=".$sect."&act=delSection'>".$lang_ar['ln_del_group']."</a></small></td>";
		 echo "</tr>";
		echo "<tr><td colspan='2'><div id='B".$i."' style='display:none;'></div></td></tr>";
		$i++;
		$r -> MoveNext();
	}
	echo '</table>';
}
/* switch lang */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="SwitchLang"){
	$r = $db -> Execute("select * from ".$_conf['prefix']."countries where domain='".$_REQUEST['l_domain']."'");
	$t = $r -> GetRowAssoc(false);
	if($t['switchon']=="0"){
		$switchon = "1"; $msg = $lang_ar['lang_swon'];
	}else{
		$switchon = "0"; $msg = $lang_ar['lang_swoff'];
	}
	$r = $db -> Execute("update ".$_conf['prefix']."countries set switchon='".$switchon."' where domain='".$_REQUEST['l_domain']."'");
	$_SESSION['fl'] = GetLangField();
	echo msg_box($msg);
}

/* set base lang */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="SetBaseLang"){
	$r = $db -> Execute("update ".$_conf['prefix']."countries set baselang='n'");
	$r = $db -> Execute("update ".$_conf['prefix']."countries set baselang='y' WHERE domain='".$_REQUEST['nbaselang']."'");
	echo msg_box($lang_ar['ln_ok7']);
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="LangList"){
	if(isset($_REQUEST['subact']) && $_REQUEST['subact']=="AddNewSiteLang"){
		$fl = GetLangField();
		if(strlen($_REQUEST['newLang'])!=2){
			echo msg_box($lang_ar['lang_er5']);
		}elseif(in_array($_REQUEST['newLang'], $fl)){
			echo msg_box($lang_ar['ln_er4']);
		}else{
			$res = CreateNewLang($_REQUEST['newLang'],$_REQUEST['baseLang']);
			echo msg_box($res);
		}
	}
	if(isset($_REQUEST['subact']) && $_REQUEST['subact']=="DelSiteLang"){
			$res = DelSiteLang($_REQUEST['dellang']);
			echo msg_box($res);
	}
	/* ********************************************* */
	$fl = GetLangField();
	reset($fl);
	$langList1 = '<select name="baseLang" id="baseLang">';
	while(list($k1, $v1)=each($fl)){		 
		$langList1 .= '<option value="'.$k1.'" style="color:blue;"> '.strtoupper($k1).' </option>';
	}
	$langList1 .= "</select>";

	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."countries ORDER BY domain");
	$alllang = array();
	$langList = '<select name="newLang" id="newLang">';
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		if(!in_array($t['domain'],$fl)) $langList .= '<option value="'.$t['domain'].'" style="color:red;"> '.strtoupper($t['domain']).' </option>';
		$alllang[$t['domain']] = $t;
		$r -> MoveNext();
	}
	$langList .= "</select>";
	echo '<div class="block">
	<h3>'.$lang_ar['ln_add'].'</h3>
	<form method="post" action="admin.php?p='.$p.'&act=LangList&subact=AddNewSiteLang" enctype="multipart/form-data" id="LFN">
	'.$lang_ar['lang_name2'].': <input type="text" name="newLang" id="newLang" value="" size="3" /> &nbsp;&nbsp;
	'.$lang_ar['lang_name3'].': <input type="text" name="_name" id="_name" value="" size="15" /> &nbsp;&nbsp;
	'.$lang_ar['ln_lang_sel2'].': '.$langList1.'  &nbsp;&nbsp;
	<input type="submit" value="'.$lang_ar['add'].'" />
	</form>
	</div>';
	echo '<br /><h3>'.$lang_ar['ln_lang_list'].'</h3>';
	reset($fl);
	echo '<table border="0" cellspacing="0" class="selrow">';
	echo '<tr><th>Код языка</th><th>Флаг</th><th>Основной</th><th>Включить</th><th>Удалить</th></tr>';
	while(list($k1, $v1)=each($alllang)){
		if($alllang[$k1]['switchon']=="0") $swch = "";
		else $swch = ' checked="checked" ';
		$blc = $k1==$_conf['def_lang'] ? ' <input type="radio" name="baselang" id="baselang_'.$k1.'" value="'.$k1.'" checked="checked" /> ' : '';
		echo '<tr>
		<td align="center" width="100">'.strtoupper($k1).'</td>
		<td align="center" width="100"><img src="'.$_conf['admin_tpl_dir'].'flags/'.$k1.'.gif" /></td>
		<td>
		'.$blc.'
		</td>
		<td align="center" width="100">';
		if($k1!=$_conf['def_lang']) echo '<input type="checkbox" name="lang['.$k1.']" id="lang['.$k1.']" value=""'.$swch.' onclick="getdata(\'\',\'post\',\'?p='.$p.'&act=SwitchLang&l_domain='.$k1.'\',\'ActionRes\');" />';
		else echo '&nbsp;';
		echo '</td><td>';
		if($k1!=$_conf['def_lang']) echo '<a href="admin.php?p=lang_manager&act=LangList&subact=DelSiteLang&dellang='.$k1.'">'.$alang_ar['delete'].'</a>';
		else echo '&nbsp;';
		echo '</td></tr>';
	}
	echo '</table>';
}
/* export in cvs */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="export"){
    include_once('include/adodb/toexport.inc.php'); 
    include_once('include/adodb/rsfilter.inc.php'); 
    $q = "select * from ".$_conf['prefix']."translate order by sections, pkey";
	$r = $db -> Execute($q);
	if($_conf['encoding_db']!="cp1251"){
		function do_encode(&$arr,$r){
			global $_conf;
			foreach($arr as $k => $v){
				$arr[$k] = mb_convert_encoding($v,"CP1251",$_conf['encoding']);
			}
		}
		$r = RSFilter($r,'do_encode');
	}
	$file = "tmp/lang.csv";
 	$fp = fopen($file,'w');
	rs2csvfile($r,$fp);
	fclose($fp);	
	$fz = get_filesize(filesize($file));
	echo '<h2><a href="'.$file.'">'.$alang_ar['lang_uplfile'].' '.$file.' ('.$fz.')</a></h2>';	
	echo '<p><small>'.$alang_ar['lang_uplhint'].'</small></p><br />';
	echo '<p><strong>'.$alang_ar['lang_rules'].':</strong><br />
	'.$alang_ar['lang_rule1'].'<br />
	'.$alang_ar['lang_rule2'].'<br />
	'.$alang_ar['lang_rule3'].'<br />
	'.$alang_ar['lang_rule4'].'<br />
	'.$alang_ar['lang_rule5'].'</p>';
}
/* import from csv */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="import"){
	print_r($_FILES);
	if($_FILES['file']['error']!=0){
		echo msg_box($lang_ar['lang_er6']);
	}elseif($_FILES['file']['type']!='text/csv' && $_FILES['file']['type']!='text/comma-separated-values'){
		echo msg_box($lang_ar['lang_er7']);
	}else{
		$row = 1; $fields = array();
		$handle = fopen($_FILES['file']['tmp_name'], "r");
		$r = $db -> Execute("LOCK TABLES ".$_conf['prefix']."translate WRITE;");
		while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
			$num = count($data);
			if($row==1){
				for ($c=0; $c < $num; $c++) {
					$fields[$c] = $data[$c];
				}
				//print_r($fields);
			}else{
				$q = ''; $type = ''; $id = '';
				for ($c=0; $c < $num; $c++) {
					if($_conf['encoding_db']!="cp1251") $data[$c] = mb_convert_encoding($data[$c],$_conf['encoding'],"CP1251");
					if($c>0){
						if($q=='') $q .= $fields[$c]."='".mysql_real_escape_string($data[$c])."'";
						else  $q .= ",".$fields[$c]."='".mysql_real_escape_string($data[$c])."'";
					}
					if($c==0 && $data[$c]=='') $type = 'insert';
					if($c==0 && $data[$c]!='') {$type = 'update'; $id=$data[$c]; }
				}
				if($type=="insert") $query = "insert IGNORE into ".$_conf['prefix']."translate set ".$q." ";
				if($type=="update") $query = "update ".$_conf['prefix']."translate set ".$q." where id='".$id."'";
				$r = $db -> Execute($query);
				//echo $query . "<br />\n";
			}
			$row++;
			$r = $db -> Execute("UNLOCK TABLES");
		}
		fclose($handle);
		echo msg_box($lang_ar['lang_ok7']);
	}
	
}
/* start page */
if(!isset($_REQUEST['act'])){
	echo '<h2><a href="admin.php?p=lang_manager&act=export">'.$lang_ar['lang_msg1'].'</a></h2>';
	echo '<br /><hr /><br />';
	echo '<h2>'.$lang_ar['lang_msg2'].'</h2>
	<form method="post" action="admin.php?p=lang_manager&act=import" id="iForm" enctype="multipart/form-data">
	'.$lang_ar['lang_selfile'].': <input type="file" name="file" id="file" />
	<input type="submit" name="sendFile" value="'.$lang_ar['lang_import'].'" />
	</form>';
}

/******************************************************************************
******************** FUNCTIONS ************************************************
******************************************************************************/


function CreateNewLang($lang, $baselang){
	global $_conf, $db, $lang_ar;
	$r = $db -> Execute("insert into ".$_conf['prefix']."countries set domain='".strtolower($lang)."', switchon='0', ru='".mysql_real_escape_string(stripslashes($_REQUEST['_name']))."'");
	$tabs = GetTableList();
	reset($tabs);
	while(list($k,$v)=each($tabs)){
		if($foundres = strstr($v, '_'.$baselang)){ // создаем копию таблицы с новым языком и наполняем данными
			if($foundres == "_".$baselang){
				$r = $db -> Execute("SHOW CREATE TABLE ".$v);
				$t = $r -> GetRowAssoc(false);
				$newtab = str_replace('_'.$baselang, '_'.$lang, $v);
				$create_table_query = str_replace($v, $newtab, $t['create table']);
				$rc = $db -> Execute($create_table_query);
				$ri = $db -> Execute("INSERT INTO ".$newtab." SELECT * FROM ".$v);
			}
		}
	}
	$tabs = GetTableList();
	reset($tabs);
	while(list($k,$v)=each($tabs)){
			$rind = $db -> Execute("SHOW INDEX FROM ".$v);
			$tind = $rind -> GetRowAssoc(false);
			$indexfield = $tind['column_name'];
		$r = $db -> Execute("SHOW FULL COLUMNS FROM ".$v);
		while(!$r->EOF){
			$t = $r -> GetRowAssoc(false);
			if($foundres=strstr($t['field'], '_'.$baselang) || $t['field']==$baselang){
			if($foundres=="_".$baselang){
				if(strstr($t['field'], '_'.$baselang)) $newfield = str_replace('_'.$baselang, '_'.$lang, $t['field']);
				if($t['field']==$baselang) $newfield = $lang;
				if(strtolower($t['null']) == 'no') $null = 'NOT NULL';
				else $null = 'NULL';
				$qch = "ALTER TABLE `".$v."` ADD `".$newfield."` ".$t['type']." ".$null." ";
				$rch = $db -> Execute($qch);
				$rs = $db -> Execute("SELECT `".$indexfield."`,`".$t['field']."` FROM ".$v."");
				while(!$rs->EOF){
					$ts = $rs -> GetRowAssoc(false);
					$ri = $db -> Execute("UPDATE ".$v." SET `".$newfield."`='".mysql_real_escape_string(stripslashes($ts[$t['field']]))."' WHERE ".$indexfield."='".mysql_real_escape_string(stripslashes($ts[$indexfield]))."'");
					$rs -> MoveNext();
				}
			}}
			$r -> MoveNext();
		}
	}
	$result = $lang_ar['ln_ok5'];
	return $result;
}


function DelSiteLang($lang){
	global $_conf, $db, $lang_ar;
	$r = $db -> Execute("delete from ".$_conf['prefix']."countries where domain='".$lang."'");
	
	$tabs = GetTableList();
	reset($tabs);
	while(list($k,$v)=each($tabs)){
		if($append = strstr($v, '_'.$lang)){ // Удаляем таблицу для указанного языка
			if($append=='_'.$lang){
				$q = "DROP TABLE `".$v."`";
				//echo $q."<br />";
				$rd = $db -> Execute($q);
			}
		}
	}
	$tabs = GetTableList();
	reset($tabs);
	while(list($k,$v)=each($tabs)){
		$r = $db -> Execute("SHOW FULL COLUMNS FROM ".$v);
		while(!$r->EOF){
			$t = $r -> GetRowAssoc(false);
			if(strstr($t['field'], '_'.$lang) || $t['field']==$lang){
				$q = "ALTER TABLE `".$v."` DROP `".$t['field']."`";
				//echo $q."<br />";
				$rch = $db -> Execute($q);
			}
			$r -> MoveNext();
		}
	}
	$result = $lang_ar['ln_ok6'];
	return $result;
}

function GetTableList(){
	global $db, $_conf;
	$tab = array();
	$r = $db -> Execute("SHOW TABLES");
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		list($k,$v)=each($t);
		$tab[$v] = $v;
		$r -> MoveNext();
	}
	return $tab;
}
?>
