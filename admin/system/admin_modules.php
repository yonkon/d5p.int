<?php
/**
 * Просмотр и управление установленными модулями в системе. Установка новых модулей. Проверка версии.
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00.03 16.06.2010
 */

$smarty -> assign("PAGETITLE","<h2><a href='admin.php?p=".$p."'>Управление модулями</a></h2>");

/* ***************************************************************************** */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="modInfo"){
	$r = $db -> Execute("select * from ".$_conf['prefix']."modules where id='".$_REQUEST['id']."'");
	if($r -> RecordCount()>0){
		$t = $r -> GetRowAssoc(false);
		$code = stripslashes($t['code']);
		echo '<h1>Модуль: '.$code.'</h1>';
		echo '<p><strong>'.stripslashes($t['description_'.$_SESSION['admin_lang']]).'</strong></p><br />';
		$installer = 'module/'.$code.'/install.php';
		if(file_exists($installer)){
			include($installer);
			if(isset($inst_queries)){
				echo '<strong>SQL:</strong><br /><textarea cols="70" rows="10">';
				while(list($k,$v)=each($inst_queries)) echo trim($v);
				echo '</textarea><br />';
			}
			//$r = $db -> Execute("update ".$_conf['prefix']."modules set installed='y' where code='".$code."'");
			if(isset($inst_info) && $inst_info!="") echo '<br /><strong>Информация</strong><br />'.$inst_info;
			if(isset($inst_relation) && $inst_relation!="") echo '<br /><strong>Зависимости</strong><br />'.$inst_relation;
			if(isset($inst_css) && $inst_css!="") echo '<br /><strong>Добавьте этот код в файл стилей:</strong><br /><textarea cols="70" rows="10">'.$inst_css.'</textarea><br />';
			if(isset($inst_js) && $inst_js!="") echo '<br /><strong>Добавьте этот код в файл js/func.js:</strong><br /><textarea cols="70" rows="10">'.$inst_js.'</textarea><br />';
			$tpldir = $_conf['tpl_dir'].$code.'/';
			$tpls = scandir_($tpldir);
			if(count($tpls)>0){
				echo '<br /><strong>Шаблоны модуля:</strong><br />';
				while(list($k,$v)=each($tpls)){
					echo '<span class="green">'.$tpldir.$v.'</span><br />';
				}
			}
		}else{
			echo msg_box("Не удалось найти файл для установки модуля: ".$installer);
		}
		echo '<br /><br />';
	}
	unset($_REQUEST['act']);
}
/* ***************************************************************************** */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="inst"){
	$code = stripslashes($_REQUEST['code']);
	$installer = 'module/'.$code.'/install.php';
	if(file_exists($installer)){
		include($installer);
		if(isset($inst_queries)){
			while(list($k,$v)=each($inst_queries)){	$r = $db -> Execute(trim($v)); }
		}
		$r = $db -> Execute("update ".$_conf['prefix']."modules set installed='y' where code='".$code."'");
		if(isset($inst_info) && $inst_info!="") echo '<br /><strong>Информация</strong><br />'.$inst_info;
		if(isset($inst_relation) && $inst_relation!="") echo '<br /><strong>Зависимости</strong><br />'.$inst_relation;
		if(isset($inst_css) && $inst_css!="") echo '<br /><strong>Добавьте этот код в файл стилей:</strong><br /><textarea cols="70" rows="10">'.$inst_css.'</textarea><br />';
		if(isset($inst_js) && $inst_js!="") echo '<br /><strong>Добавьте этот код в файл js/func.js:</strong><br /><textarea cols="70" rows="10">'.$inst_js.'</textarea><br />';
		$tpldir = $_conf['tpl_dir'].$code.'/';
		$tpls = scandir_($tpldir);
		if(count($tpls)>0){
			echo '<strong>Шаблоны модуля:</strong><br />';
			while(list($k,$v)=each($tpls)){
				echo '<span class="green">'.$tpldir.$v.'</span><br />';
			}
		}
	}else{
		echo msg_box("Не удалось найти файл для установки модуля: ".$installer);
	}
	unset($_REQUEST['act']);
}

/* ***************************************************************************** */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="uninst"){
	$code = stripslashes($_REQUEST['code']);
	$installer = 'module/'.$code.'/install.php';
	if(file_exists($installer)){
		include($installer);
		if(isset($uninst_queries)){
			while(list($k,$v)=each($uninst_queries)){ $r = $db -> Execute(trim($v)); }
		}
		$r = $db -> Execute("update ".$_conf['prefix']."modules set installed='n' where code='".$code."'");
		if(isset($uninst_info) && $uninst_info!="") echo '<br /><strong>Информация</strong><br />'.$uninst_info;
		if(isset($uninst_relation) && $uninst_relation!="") echo '<br /><strong>Зависимости</strong><br />'.$uninst_relation;
		if(isset($inst_css) && $inst_css!="") echo '<br /><strong>Удалите этот код с файла стилей:</strong><br /><textarea cols="70" rows="10">'.$inst_css.'</textarea><br />';
	}else{
		echo msg_box("Не удалось найти файл для установки модуля: ".$installer);
	}
	unset($_REQUEST['act']);
}

/* ***************************************************************************** */
if(!isset($_REQUEST['act'])){
	if(isset($_REQUEST['start'])) $_SESSION['start'] = $_REQUEST['start'];
	if(isset($_SESSION['start'])) $start = $_SESSION['start'];
	else $start = 0;
	$interval = 20;

		$q="SELECT * FROM ".$_conf['prefix']."modules ORDER BY id LIMIT $start, $interval";
		$q1="SELECT count(*) FROM ".$_conf['prefix']."modules ORDER BY id";
	
		$r1 = $db->Execute($q1);
		$t1 = $r1 -> GetRowAssoc(false);
		$all = $t1['count(*)'];
		$list_page=Paging($all,$interval,$start,"admin.php?p=".$p."&start=%start1%","");

		$r = $db->Execute($q);

	echo "<strong>Всего $all</strong>";
	echo $list_page;
	echo "<table border='0' cellspacing='0' class='selrow' width='100%'>
	<th>ID</th><th>Код</th><th>Версия</th><th>Описание</th><th>Информация</th><th>Состояние</th><th>Действие</th></tr>";
	while (!$r -> EOF) { 
		$t = $r -> GetRowAssoc(false);
		if($t['installed']=="y"){
			$mstate = '<span style="color:green;">Установлен</span>';
			$installer = 'module/'.$t['code'].'/install.php';
			clearstatcache();
			if($t['code']!="core" && file_exists($installer)) $action = '<a href="admin.php?p='.$p.'&act=uninst&code='.$t['code'].'">Удалить</a>';
			elseif($t['code']!="core" && !file_exists($installer)) $action = 'недоступно';
			else $action = '';
		}
		if($t['installed']=="n"){
			$mstate = '<span class="red">Не установлен</span>';
			$installer = 'module/'.$t['code'].'/install.php';
			clearstatcache();
			if($t['code']!="core" && file_exists($installer)) $action = '<a href="admin.php?p='.$p.'&act=inst&code='.$t['code'].'">Установить</a>';
			else $action = '<small>недоступно</small>';
		}
	    echo "<tr>";
		echo "
		<td>".$t['id']."</td>
		<td>".$t['code']."</td>
		<td>".$t['version']."</td>
		<td>".stripslashes($t['description_'.$_SESSION['admin_lang']])."</td>
		<td><a href='admin.php?p=admin_modules&act=modInfo&id=".$t['id']."'>Инфо</a></td>
		<td>".$mstate."</td>
		<td>".$action."</td>";
    	echo "</tr>";
		$r->MoveNext();
	}
	echo "</table>";
	echo $list_page;

}

?>