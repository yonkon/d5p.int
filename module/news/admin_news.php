<?php
/**
 * Управление новостями сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2012 
 * @link http://shiftcms.net
 * @version 1.01.02
 */

$smarty -> assign("PAGETITLE","<h2>".$lang_ar['anews_title']." : <a href=\"admin.php?p=admin_news&act=list\">".$lang_ar['anews_list']."</a> : <a href=\"admin.php?p=admin_news&act=add_form\">".$lang_ar['anews_add']."</a> : <a title='".$alang_ar['anews_catwindow']."' href='javascript:void(null)' onClick=\"divwin=dhtmlwindow.open('NCBox', 'inline', '', '".$alang_ar['anews_catwindow']."', 'width=750px,height=550px,left=50px,top=90px,resize=1,scrolling=1'); getdata('','get','?p=".$p."&act=CategoryWindow','NCBox_inner'); return false; \">".$lang_ar['anews_catwindow']."</a></h2>");
$smarty -> assign("modSet", "news");

//---------------------------------------------------------------
$dirs="";

//----------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="deleteCategory"){
	$id = $_REQUEST['id'];
	$r = $db -> Execute("delete from ".$_conf['prefix']."news_category where id='".$id."'");
	$fl = GetLangField();
	while(list($k,$v)=each($fl)){
		$r = $db -> Execute("update ".$_conf['prefix']."news_".$k." set id='0' WHERE id='".$id."'");
	}
	echo msg_box($lang_ar['anews_cat_ok2']);
}

//----------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="updateCategories"){
/*
echo '<pre>';
print_r($_REQUEST);
echo '</pre>';
*/
	$fl = GetLangField();
	while(list($rk,$rv)=each($_REQUEST[$_conf['def_admin_lang']])){
		reset($fl); $qpar = ''; $er = 0;
		while(list($k,$v)=each($fl)){
			if(trim($_REQUEST[$k][$rk])=="") $er = 1;
			if($qpar=="") $qpar = $k."='".mysql_real_escape_string(stripslashes($_REQUEST[$k][$rk]))."'";
			else $qpar .= ", ".$k."='".mysql_real_escape_string(stripslashes($_REQUEST[$k][$rk]))."'";
		}
		$qpar .= ", ntrans='".mysql_real_escape_string(stripslashes(transurl($_REQUEST[$_conf['def_lang']][$rk])))."'";
		$q = "update ".$_conf['prefix']."news_category set ".$qpar." where id='".$rk."'";
		$r = $db -> Execute($q);
	}
	echo msg_box($lang_ar['anews_cat_ok2']);
}

//----------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="CategoryWindow"){
	$fl = GetLangField();
	echo '<form method ="post" action="javascript"void(null)" id="ACF" enctype="multipart/form-data">';
	echo '<h3>Создать категорию</h3>';
	while(list($k,$v)=each($fl)){
		echo '<input type="text" name="'.$v.'" id="'.$v.'" style="width:200px;" value="" maxlength="255" /> <img src="'.$_conf['admin_tpl_dir'].'flags/'.$v.'.gif" /> '.strtoupper($v).'<br />';
	}
	echo '<input type="hidden" name="p" id="p" value="'.$p.'" />';
	echo '<input type="hidden" name="act" id="act" value="saveNewCategory" />';
	echo '<input type="button" value="'.$lang_ar['save'].'" onclick="doLoad(\'ACF\',\'CatList\')" />';
	echo '</form>';
	
	echo '<div id="CatList">';
	echo outNewsCategoryEditList();
	echo '</div>';

}

if(isset($_REQUEST['act'])&&$_REQUEST['act']=="saveNewCategory"){
	$er = 0;
	$fl = GetLangField();
	while(list($k,$v)=each($fl)){
		if(trim($_REQUEST[$k])=="")	$er = 1;
	}
	if($er==1){
		echo msg_box($lang_ar['anews_cat_er1']);
	}else{
		reset($fl); $qpar = '';
		while(list($k,$v)=each($fl)){
			if($qpar=="") $qpar = $k."='".mysql_real_escape_string(stripslashes($_REQUEST[$k]))."'";
			else $qpar .= ", ".$k."='".mysql_real_escape_string(stripslashes($_REQUEST[$k]))."'";
		}
		$qpar .= ", ntrans='".mysql_real_escape_string(stripslashes(transurl($_REQUEST[$_conf['def_lang']])))."'";
		$q = "insert into ".$_conf['prefix']."news_category set ".$qpar;
		$r = $db -> Execute($q);
		echo msg_box($lang_ar['anews_cat_ok1']);
	}
	echo outNewsCategoryEditList();
}

//----------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="add_news"){
    $da=strtotime($_REQUEST['date']);
	while(list($k,$v)=each($_REQUEST['ntitle'])){
		$q = "
		INSERT INTO ".$_conf['prefix']."news_".$k." SET
		ntitle='".mysql_real_escape_string(stripslashes($_REQUEST['ntitle'][$k]))."',
		ntext='".mysql_real_escape_string(stripslashes($_REQUEST['ntext'][$k]))."', 
		nlink='".mysql_real_escape_string(stripslashes($_REQUEST['nlink'][$k]))."',
		date='".$da."', 
		id='".stripslashes($_REQUEST['id'])."'
		";
		$r = $db -> Execute($q);
	    MakeRss();
	}
	echo msg_box($lang_ar['anews_saved']);
	   $_REQUEST['act']="list";
}
//--------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="update"){
    $da=strtotime($_REQUEST['date']);
	while(list($k,$v)=each($_REQUEST['ntitle'])){
		$q = "
		UPDATE `".$_conf['prefix']."news_".$k."` SET 
		`ntitle`='".mysql_real_escape_string(stripslashes($_REQUEST['ntitle'][$k]))."', 
		`ntext`='".mysql_real_escape_string(stripslashes($_REQUEST['ntext'][$k]))."', 
		`nlink`='".mysql_real_escape_string(stripslashes($_REQUEST['nlink'][$k]))."', 
		`date`='".$da."', `id`='".stripslashes($_REQUEST['id'])."'
		WHERE `idn`='".$_REQUEST['idn']."'";
		$r = $db -> Execute($q);
	    MakeRss();
	}
	echo msg_box($lang_ar['anews_upadated']);
	   $_REQUEST['act']="list";
}
//------------ВИДАЛЕННЯ ВИЮРАНОЇ НОВИНИ----------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="delit"){

	$fl = GetLangField();
	while(list($k,$v)=each($fl)){
	   $q = "DELETE FROM `".$_conf['prefix']."news_".$k."` WHERE `idn`='".$_REQUEST['idn']."'";
		$r = $db -> Execute($q);
		MakeRss();
	}
	echo msg_box($lang_ar['anews_deleted']);
	   $_REQUEST['act']="list";
}

/* ************************************************************ */
if(!isset($_REQUEST['act'])||$_REQUEST['act']=="add_form"){
	$fl = GetLangField();
	//include($_conf['disk_patch']."include/FCKeditor/fckeditor.php") ;
	$ms = $db -> Execute("SELECT max(idn) FROM ".$_conf['prefix']."news_".$_conf['def_lang']."");
	$t = $ms -> GetRowAssoc();
	$next_idn = $t['MAX(IDN)']+1;
	$cat_option = outNewsCategoryOptionList();
	echo "
	<h2>".$lang_ar['anews_add']."</h2><br />";
	include($_conf['disk_patch']."module/news/img_form.php");
	echo "<br /><div id='loadphotores'></div><br />
	<form action='$_SERVER[PHP_SELF]' method='post'>
	<span>".$lang_ar['anews_date'].":</span><br />
	<input type='text' id='date' name='date' value='".date("d.m.Y H:i",time())."' size='20' class='datetextbox' readonly='readonly' />
	<br />";
	echo $lang_ar['anews_category'].':<br /><select name="id" id="id"><option value="0"></option>'.$cat_option.'</select><br />';

	echo '<br />';
	
	initializeEditor($_conf['neditor']);
	
	echo '<div id="tabs">';
	echo '<ul>';
		reset($fl); $i=1;
		while(list($k,$v)=each($fl)){
			//echo '<li><a href="javascript:void(null)" rel="formtab'.$i.'">'.strtoupper($k).'</a></li>';
			echo '<li><a href="#tabs-'.$i.'">'.strtoupper($k).'</a></li>';
			$i++;
		}
	echo '</ul>';
	reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
		echo '<div id="tabs-'.$i.'">';

		echo "<span>".$lang_ar['anews_ntitle'].":</span><br />
		<input type='text' name='ntitle[".$k."]' id='ntitle[".$k."]' size='75' maxlenght='250' value='' /><br />
		<span>".$lang_ar['anews_nlink'].":</span><br />
		<input type='text' name='nlink[".$k."]' id='nlink[".$k."]' size='75' maxlenght='250' value='' /><br />
		<span>".$lang_ar['anews_ntext']."</span><br />";
		$cfield = 'ntext['.$k.']';
		if($_conf['neditor'] == "tiny"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120"></textarea><br />';
			addTinyToField($cfield);
		}elseif($_conf['neditor'] == "fck"){
			addFCKToField($cfield, '', 'Default', '900', '600');
		}elseif($_conf['neditor'] == "ck"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120"></textarea><br />';
			addCKToField($cfield, 'Default', '900', '600');
		}elseif($_conf['neditor'] == "earea"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120"></textarea><br />';
			addEditAreaToField($cfield);
		}else{
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120"></textarea><br />';
		}
		echo '</div>';

		$i++;
	}

	echo '</div>';
	echo "<br />
	<input type='hidden' name='p' value='admin_news' />
	<input type='hidden' name='act' value='add_news' />
	<input type='submit' value='".$lang_ar['add']."' style='width:200px;' />
	</form>";

	$HEADER .= '
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/ui/jquery.ui.tabs.js"></script>
	<script type="text/javascript">
	$(function(){
		$("#tabs").tabs();
	});
	</script>
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/ui/ui.datetimepicker.js"></script>
	<link rel="stylesheet" href="'.$_conf['www_patch'].'/js/jquery/themes/green/dark.datetimepicker.css" type="text/css">
	<script type="text/javascript">
	$(function() {
		$("#date").datetimepicker({
			dateFormat: "dd.mm.yy",
			timeFormat: "hh:ii",
		});
	});
	</script>
	';
	
}
//-----------РЕДАГУВАННЯ ВИБРАНОЇ НОВИНИ------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="edit_form"){
	if(isset($_REQUEST['nact']) && $_REQUEST['nact']=="delcom"){
		$rc = $db -> Execute("DELETE FROM ".$_conf['prefix']."comments WHERE id='$_REQUEST[idc]'");
		echo msg_box($lang_ar['anews_comdeleted']);
	}
/* ****************** */

	$fl = GetLangField();
	reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
		$q = "SELECT * FROM ".$_conf['prefix']."news_".$k." WHERE idn='".$_REQUEST['idn']."'";
		$r = $db -> Execute($q);
	 	$tmp[$k] = $r -> GetRowAssoc(false);
		$i++;
	}
	$cat_option = outNewsCategoryOptionList($tmp[$_conf['def_admin_lang']]['id']);
	$next_idn=$tmp[$_conf['def_lang']]['idn'];
	include($_conf['disk_patch']."include/FCKeditor/fckeditor.php") ;
	echo "<h4>".$lang_ar['anews_edit']."</h4>";
	include($_conf['disk_patch']."module/news/img_form.php");
	if(file_exists("files/newsanons/".$next_idn.".jpg")) $ph_link="<img src='files/newsanons/".$next_idn.".jpg' alt='' /><br /><a href='javascript:void(null)' onclick=\"getdata('', 'get', '?p=getphoto&act=delete_photo&idn=".$_REQUEST['idn']."','loadphotores')\">".$lang_ar['anews_delphoto']."</a>";
	else $ph_link="";

	echo "<br /><div id='loadphotores'>".$ph_link."</div><br />
	<form action='admin.php' method='post'>
	<span>".$lang_ar['anews_date'].":</span><br />
	<input type='text' id='date' name='date' value='".date("d.m.Y H:i",$tmp[$_SESSION['admin_lang']]['date'])."' size='20' class='datetextbox' readonly='readonly' />
	<br />";
	echo $lang_ar['anews_category'].':<br /><select name="id" id="id"><option value="0"></option>'.$cat_option.'</select><br />';
	
	initializeEditor($_conf['neditor']);

	echo '<br /><div id="tabs">';
	echo '<ul>';
	reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
		echo '<li><a href="#tabs-'.$i.'">'.strtoupper($k).'</a></li>';
		$i++;
	}
	echo '</ul>';
	reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
	
		echo '<div id="tabs-'.$i.'">';

		echo "<span>".$lang_ar['anews_ntitle'].":</span><br>
		<input type='text' name='ntitle[".$k."]' id='ntitle[".$k."]' size='75' maxlenght='250' value='".htmlspecialchars(stripslashes($tmp[$k]['ntitle']))."' /><br>
		<span>".$lang_ar['anews_nlink'].":</span><br>
		<input type='text' name='nlink[".$k."]' id='[".$k."]' size='75' maxlenght='250' value='".htmlspecialchars(stripslashes($tmp[$k]['nlink']))."' /><br>
		<span>".$lang_ar['anews_ntext']."</span><br>";
		$cfield = 'ntext['.$k.']';
		if($_conf['neditor'] == "no" || $_conf['neditor'] == "") $tmp[$k]['ntext'] = htmlspecialchars($tmp[$k]['ntext']);
		if($_conf['neditor'] == "tiny"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$tmp[$k]['ntext'].'</textarea><br />';
			addTinyToField($cfield);
		}elseif($_conf['neditor'] == "fck"){
			addFCKToField($cfield, $tmp[$k]['ntext'], 'Default', '900', '600');
		}elseif($_conf['neditor'] == "ck"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$tmp[$k]['ntext'].'</textarea><br />';
			addCKToField($cfield, 'Default', '900', '600');
		}elseif($_conf['neditor'] == "earea"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$tmp[$k]['ntext'].'</textarea><br />';
			addEditAreaToField($cfield);
		}else{
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$tmp[$k]['ntext'].'</textarea><br />';
		}

		echo '</div>';

		$i++;
	}

	echo '</div>';

	echo "<br />
	<input type=hidden name=p value='".$p."'>
	<input type=hidden name=act value='update'>
	<input type=hidden name=idn value='".$tmp[$_conf['def_lang']]['idn']."'>
	<input type=submit value=\"".$alang_ar['save']."\" style='width:200px;' />
	</form>";

	$HEADER .= '
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/ui/jquery.ui.tabs.js"></script>
	<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
	</script>
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/calendar.js"></script>
	<link rel="stylesheet" href="'.$_conf['www_patch'].'/js/calendar.css" type="text/css">
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/ui/ui.datetimepicker.js"></script>
	<link rel="stylesheet" href="'.$_conf['www_patch'].'/js/jquery/themes/green/dark.datetimepicker.css" type="text/css">
	<script type="text/javascript">
	$(function() {
		$("#date").datetimepicker({
			dateFormat: "dd.mm.yy",
			timeFormat: "hh:ii"
		});
	});
	</script>
	';
/**	
/* Комментарии к новости
*/
			echo "<br /><hr /><h3>".$lang_ar['news_com']."</h3><br />";
			$cominterval=20;
			if(!isset($_REQUEST['comstart'])) $comstart=0;
			else $comstart=$_REQUEST['comstart'];
			$q = $_conf['prefix']."comments LEFT JOIN ".$_conf['prefix']."users USING(idu) WHERE service='news' AND id_item=".$_REQUEST['idn']." ORDER BY date desc";
			$rc = $db -> Execute("SELECT * FROM ".$q." LIMIT $comstart, $cominterval");
			$rc1 = $db -> Execute("SELECT count(*) FROM ".$q);
			$tc1 = $rc1 -> GetRowAssoc(false);
			if($rc -> RecordCount()>0){
				$comlist_page=GetPaging($tc1['count(*)'],$cominterval,$comstart,"admin.php?p=admin_news&act=edit_form&comstart=%start1%&idn=$_REQUEST[idn]");
				$smarty -> assign("paging",$comlist_page);
				$comlistpage = $smarty -> fetch("db:paging.tpl");
				echo $comlistpage;
				echo '<table border="0" cellspacing="0" class="selrow">';
				echo '<tr><th>Кто</th><th>Дата</th><th>Комментарий</th><th>Удалить</th></tr>';
				while (!$rc->EOF) { 
					$tc = $rc -> GetRowAssoc(false);
					if($tc['idu']!='' && $tc['idu']!=0){
						$uedit = "<br /><a title='".$alang_ar['au_uedit']."' href='#' onClick=\"divwin=dhtmlwindow.open('UserEditBox', 'inline', '', '".$alang_ar['au_uedit']."', 'width=450px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); getdata('','get','?p=site_server&act=AddOrEditUser&idu=".$tc['idu']."','UserEditBox_inner'); return false; \"><strong>".$tc['login']."</strong></a>";
					}else $uedit = '';
					echo "<tr>
					<td><strong>".stripslashes($tc['uname'])."</strong><br />".MailToEmail($tc['uemail'], $tc['uname']).$uedit."</td>
					<td><small>".date("d.m.Y H:i",$tc['date'])."</small></td>
					<td>".stripslashes($tc['comtext'])."</td>
					<td><a href='admin.php?p=admin_news&act=edit_form&idn=$_REQUEST[idn]&nact=delcom&idc=$tc[id]'>".$lang_ar['delete']."</a></td>
					</tr>";
					$rc->MoveNext(); 
				}
				echo '</table>';
				echo $comlistpage;
			}//if records > 0
}
//-----------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="list"){
$interval = 30;
if(!isset($_REQUEST['start'])) $start=0;
else $start=$_REQUEST['start'];
   $qn1="SELECT *, 
   (select count(*) from ".$_conf['prefix']."comments where service='news' AND id_item=idn) as comments FROM ".$_conf['prefix']."news_".$_conf['def_lang']."
   LEFT JOIN ".$_conf['prefix']."news_category USING(id)
   ORDER BY date DESC";
echo "<h1>".$lang_ar['news']."</h1>";
$qn=$qn1." LIMIT $start,$interval";

	$ms1 = $db->Execute($qn1);
	$ms = $db->Execute($qn);
	$all=$ms1->RecordCount(); // всего тем

$list_page=Paging($all,$interval,$start,"admin.php?p=admin_news&act=list&start=%start1%","");
echo "<br />".$list_page;
echo '<table border="0" cellspacing="0" cellpadding="0" class="selrow">';
echo '<tr><th>ID</th><th>'.$lang_ar['anews_date'].'</th><th>'.$lang_ar['anews_category'].'</th><th>'.$lang_ar['anews_ltit'].'</th><th>'.$lang_ar['news_com'].'</th><th>&nbsp;</th></tr>';
	while (!$ms->EOF) { 
		$tmpn = $ms->GetRowAssoc();
	echo '<tr>
    <td><a href="admin.php?p=admin_news&act=edit_form&idn='.$tmpn['IDN'].'" title="Редактировать">'.$tmpn['IDN'].'</a></td>
    <td><small>'.date("d.m.Y H:i",$tmpn['DATE']).'</small></td>
	<td>'.stripslashes($tmpn[strtoupper($_conf['def_admin_lang'])]).'</td>
	<td><a href="admin.php?p=admin_news&act=edit_form&idn='.$tmpn['IDN'].'" title="Редактировать">'.stripslashes($tmpn['NTITLE']).'</a></td>
	<td><small>'.$lang_ar['news_com'].': '.$tmpn['COMMENTS'].'</small></td>
	<td><a href="admin.php?p=admin_news&act=delit&idn='.$tmpn['IDN'].'">'.$lang_ar['delete'].'</a></td>
    </tr>';
	$ms->MoveNext();
}
echo '</table>';
}
//---------FUNCTION-------------------------------------------------
function MakeRss(){
	global $_conf,$db,$lang_ar;

	$fl = GetLangField(); $i=0;
	while(list($k,$v)=each($fl)){
		$rss="<?xml version=\"1.0\" encoding=\"".$_conf['encoding']."\" ?>
		<rss version=\"2.0\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\">
			<channel>
				<title>".$lang_ar['news_rss_title']." ".$_conf['site_name']."</title>
				<link>$_conf[www_patch]/index.php?p=news</link>
				<description>".$lang_ar['news_rss_title']." ".$_conf['site_name']."</description>
				<lastBuildDate>".date("r",time())."</lastBuildDate>";
			$ms = $db -> Execute("SELECT * FROM ".$_conf['prefix']."news_".$k." ORDER BY date DESC LIMIT 0,10");
			while (!$ms->EOF) { 
				$tmp = $ms -> GetRowAssoc();
				$rss .= "
				    <item>
				      <title>".htmlspecialchars(stripslashes($tmp['NTITLE']))."</title>
				      <link>".$_conf['www_patch']."/index.php?p=news&amp;idn=$tmp[IDN]&amp;start=0</link>
				      <description>".htmlspecialchars(stripslashes($tmp['NTEXT']))."</description>
				      <pubDate>".date("r",$tmp['DATE'])."</pubDate>
				      <guid>".$_conf['www_patch']."/index.php?p=news&amp;idn=".$tmp['IDN']."&amp;start=0</guid>
				    </item>";
				$ms -> MoveNext();
			}
			$rss.="
			  </channel>
			</rss>";
			$fp=fopen("files/rss/news_".$k.".rss","w");
			fwrite($fp,$rss);
			fclose($fp);
		$i++;
	}
}


function outNewsCategoryEditList(){
	global $_conf, $db, $p, $lang_ar;
	$fl = GetLangField();
	$r = $db -> Execute("select * from ".$_conf['prefix']."news_category order by ".$_SESSION['admin_lang']." ");
	if($r -> RecordCount()>0){
		echo '<form method="post" id="CLF" enctype="multipart/form-data" action="javascript:void(null)">';
		echo '<table border="0" cellspacing="0" class="seltab">';
			reset($fl);
			echo '<tr>';
			while(list($k,$v)=each($fl)) echo '<th><img src="'.$_conf['admin_tpl_dir'].'flags/'.$v.'.gif" /> '.strtoupper($v).'</th>';
			echo '<th></th></tr>';
			$i=0;
		while(!$r->EOF){
			$t = $r -> GetRowAssoc(false);
			echo '<tr id="NTR'.$t['id'].'">';
			reset($fl);
			while(list($k,$v)=each($fl)) echo '<td><input type="text" name="'.$k.'['.$t['id'].']" id="'.$k.'['.$t['id'].']" value="'.htmlspecialchars(stripslashes($t[$k])).'" size="35" /></td>';
			echo '<td><a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=admin_news&id='.$t['id'].'&act=deleteCategory\',\'ActionRes\'); delelem(\'NTR'.$t['id'].'\')"><img src="'.$_conf['admin_tpl_dir'].'img/delit.png" /></a></td></tr>';
			$i++;
			$r -> MoveNext();
		}
		echo '</table>';
		echo '<input type="hidden" name="p" id="p" value="'.$p.'" />';
		echo '<input type="hidden" name="act" id="act" value="updateCategories" />';
		echo '<input type="button" value="'.$lang_ar['save'].'" onclick="doLoad(\'CLF\',\'ActionRes\')" />';
		echo '</form>';
	}
}

function outNewsCategoryOptionList($val=''){
	global $_conf, $db, $p, $lang_ar;
	$out = '';
	$r = $db -> Execute("select * from ".$_conf['prefix']."news_category order by ".$_SESSION['admin_lang']." ");
		while(!$r->EOF){
			$t = $r -> GetRowAssoc(false);
			$sel = $val==$t['id'] ? ' selected="selected"' : '';
			$out .= '<option value="'.$t['id'].'" id="'.$t['id'].'"'.$sel.'>'.htmlspecialchars(stripslashes($t[$_SESSION['admin_lang']])).'</option>';
			$r -> MoveNext();
		}
	return $out;
}

?>
