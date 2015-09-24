<?php
/**
 * Управление модулями подключаемыми к сайту
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2012 
 * @link http://shiftcms.net
 * @version 1.05.05 14.11.2009
 * 26.09.2009 - Добавлена группировка подключаемых скриптов по их принадлежности к сайту, системе управления и скрытых скриптов
 * 14.11.2009 - переделаны функции SecList, OutList таким образом, что они используют только один запрос к базе
 * 12.06.2010 - сведены в едино таблицы текстовых страниц и страниц. Соответственно модуль текстовых страниц удален
 * 04.12.2010 - Добавлена проверка данных с сохранением введенных данных в случае ошибки. Добавлено сворачивание боока с настройками. Добавлена возможность выбора и отключения редактора.
 * 08.12.2010 - Добавлена функция копирования страницы и ссылка для создания подчиненной страницы
 * 29.03.2011 - Добавлена возможность добавлять фотогалереи к страницам
 */

if(!defined("SHIFTCMS")) exit;

$page_type = array(
	'front'=>'Сайт',
	'fronthid'=>'Сайт, скрыто',
	'back'=>'Админка',
	'backhid'=>'Админка, скрыто',
	'both'=>'Сайт и админка',
	'bothhid'=>'Сайт и админка, скрыто',
);
$bed_array = array('no'=>'не использовать','ck'=>'ckeditor','fck'=>'FCKeditor', 'earea'=>'EditArea');

$smarty -> assign("PAGETITLE","<h2><a href='admin.php?p=".$p."'>".$alang_ar['ala_title']."</a> : <a href='admin.php?p=".$p."&act=addForm'>".$alang_ar['ala_padd']."</a></h2>");
$smarty -> assign("modSet", "page");

		$gr = $db->Execute("SELECT * FROM ".$_conf['prefix']."user_group ORDER BY group_code");
		$glist=array();
		while (!$gr->EOF) { 
			$gt=$gr->GetRowAssoc(false);
			$gc = $gt['group_code'];
			$glist[$gc] = $gt['group_name'];
			$gr->MoveNext(); 
		}

		$br = $db->Execute("SELECT * FROM ".$_conf['prefix']."blocks ORDER BY block_id");
		$blist=array();
		while (!$br->EOF) { 
			$bt=$br->GetRowAssoc(false);
			$bc = $bt['block_name'];
			$blist[$bc] = '<a title="'.$alang_ar['abl_set'].'" href="javascript:void(null)" onClick="divwin=dhtmlwindow.open(\'PageListBox\', \'inline\', \'\', \''.$alang_ar['abl_set'].'\', \'width=600px,height=500px,left=50px,top=70px,resize=1,scrolling=1\'); getdata(\'\',\'get\',\'?p=admin_server&act=SetPageListForBlock&block_id='.$bt['block_id'].'&block_name='.$bt['block_name'].'\',\'PageListBox_inner\'); return false; ">'.$bt['block_description'].'</a>';
			$br->MoveNext(); 
		}

//===============Форма копирования страницы================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="CopyPageForm"){
	$r = $db -> Execute("select * from ".$_conf['prefix']."page where pid='".$_REQUEST['source_pid']."'");
	$t = $r -> GetRowAssoc(false);
	if($_SESSION['USER_GROUP']=="super"){
		$q="SELECT pid, pname, pparent, ptitle, plevel, pfile, pgroups, ptemplate, ptype, linkpos, siteshow, menushow1, menushow2, menushow3, added, lastedit, whoedit, p_title_".$_SESSION['admin_lang']." FROM ".$_conf['prefix']."page ORDER BY linkpos";
	}else{
		$q="SELECT pid, pname, pparent, ptitle, plevel, pfile, pgroups, ptemplate, ptype, linkpos, siteshow, menushow1, menushow2, menushow3, added, lastedit, whoedit, p_title_".$_SESSION['admin_lang']." FROM ".$_conf['prefix']."page WHERE FIND_IN_SET('".$_SESSION['USER_GROUP']."',pgroups) ORDER BY linkpos";
	}
	  $r = $db -> Execute($q);
	  $all = $r -> GetAll();
	$pparent_list = "<select name='pparent' id='pparent' style='width:200px;'><option value=''> - ".$alang_ar['ala_newoption']." - </option>".SecList($all,'',0,$t['pparent'])."</select>";
	echo '<center><br /><h3>'.$lang_ar['create_copy'].':<br />'.stripslashes($t['p_title_'.$_SESSION['admin_lang']]).'<br />('.$t['pname'].')</h3>
	<form metgod="post" action="admin.php" id="CPF" enctype="multipart/form-data">
	<input type="hidden" name="p" id="p" value="'.$p.'" />
	<input type="hidden" name="act" id="act" value="CopyPage" />
	<input type="hidden" name="source_pid" id="source_pid" value="'.$_REQUEST['source_pid'].'" />
	<br /><strong>'.$alang_ar['ainf_pagename'].'</strong><br /><input type="text" name="pname" id="pname" value="" style="width:200px;" /><br />
	<br /><strong>'.$alang_ar['ala_pparent'].'</strong><br />'.$pparent_list.'<br />
	<br /><input type="submit" value="'.$lang_ar['create'].'" />
	</form></center>';
	//print_r($t);
}

//===============Копирование страницы================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="CopyPage"){
	$r = $db -> Execute("select * from ".$_conf['prefix']."page where pname='".mysql_real_escape_string(stripslashes($_REQUEST['pname']))."'");
	if($r -> RecordCount() > 0){
		echo msg_box($alang_ar['ala_pexists']);
	}elseif(trim($_REQUEST['pname'])==""){
		echo msg_box($lang_ar['asys_pempty']);
	}else{
		$r = $db -> Execute("select * from ".$_conf['prefix']."page where pid='".$_REQUEST['source_pid']."'");
		$t = $r -> GetRowAssoc(false);
		$q = '';
		while(list($k,$v)=each($t)){
			if($k=="pname") $t[$k] = stripslashes($_REQUEST['pname']);
			elseif($k=="pparent") $t[$k] = stripslashes($_REQUEST['pparent']);
			elseif($k=="added") $t[$k] = time();
			elseif($k=="whoedit") $t[$k] = $_SESSION['USER_IDU'];
			elseif($k=="plevel") $t[$k] = $_REQUEST['pparent']=="" ? 0 : 1;
			else $t[$k] = stripslashes($v);
			
			if($k!="pid"){
				if($q=="") $q .= "`".$k."`='".mysql_real_escape_string($t[$k])."'";
				else $q .= ",`".$k."`='".mysql_real_escape_string($t[$k])."'";
			}
		}
		$q = "insert into ".$_conf['prefix']."page set ".$q;
		//echo $q;
		$r = $db -> Execute($q);
		$newpid = $db -> Insert_ID();
		echo msg_box($alang_ar['saved']);
	}
	$_REQUEST['act'] = "edit";
	$_REQUEST['pid'] = $newpid;
}

//=======Обновления порядка расположения разделов============
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="change_order"){
	while(list($key,$val)=each($_REQUEST['pid'])){
		$ss = $ms1 = $ms2 = $ms3 = "";
		if(isset($_REQUEST['siteshow'][$key])) $ss=$_REQUEST['siteshow'][$key];
		if(isset($_REQUEST['menushow1'][$key])) $ms1=$_REQUEST['menushow1'][$key];
		if(isset($_REQUEST['menushow2'][$key])) $ms2=$_REQUEST['menushow2'][$key];
		if(isset($_REQUEST['menushow3'][$key])) $ms3=$_REQUEST['menushow3'][$key];
			$q="update ".$_conf['prefix']."page set linkpos='".$val."', siteshow='".$ss."', menushow1='".$ms1."', menushow2='".$ms2."', menushow3='".$ms3."' WHERE pid='".$key."'";
			$r = $db -> Execute($q);
	}
		echo msg_box($alang_ar['ainf_msg1']);
	   unset($_REQUEST['act']);
}
//================ОБНОВЛЕНИ ИНФОРМАЦИИ О СТРАНИЦЕ=====================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="save"){
	$er = 0;
	$rs = $db->Execute("SELECT pid FROM ".$_conf['prefix']."page WHERE pname='".mysql_real_escape_string($_REQUEST['pname'])."' AND pid!='".(int)$_REQUEST['pid']."'");
	if($rs->RecordCount() > 0){
		echo msg_box($alang_ar['ala_pexists']);
		$er = 1;
	}
	if(trim($_REQUEST['pname'])==""){
		echo msg_box($lang_ar['asys_pempty']);
		$er = 1;
	}
	if(trim($_REQUEST['ptemplate'])==""){
		echo msg_box($lang_ar['asys_ptempty']);
		$er = 1;
	}
	if(!isset($_REQUEST['pgroups'])){
		echo msg_box($lang_ar['asys_pgempty']);
		$er = 1;
	}
	if($er==0){
		$fl = GetLangField();
		if(trim($_REQUEST['pparent'])!=''){
			$pparent=$_REQUEST['pparent'];
			$plevel=1;
		}else{
			$pparent='';
			$plevel=0;
		}
		$pgroups = isset($_REQUEST['pgroups']) ? implode(",",$_REQUEST['pgroups']) : "";
		$page_blocks = isset($_REQUEST['page_blocks']) ? implode(",",$_REQUEST['page_blocks']) : "";
		$ss = isset($_REQUEST['siteshow']) ? "y" : "n";
		$ms1 = isset($_REQUEST['menushow1']) ? "y" : "n";
		$ms2 = isset($_REQUEST['menushow2']) ? "y" : "n";
		$ms3 = isset($_REQUEST['menushow3']) ? "y" : "n";

		reset($fl); $vals = '';
		while(list($k1, $v1)=each($fl)){ 
			$vals .= ", content_".$v1."='".mysql_real_escape_string(stripslashes($_REQUEST['content_'.$v1]))."'"; 
			$vals .= ", p_title_".$v1."='".mysql_real_escape_string(stripslashes($_REQUEST['p_title_'.$v1]))."'"; 
			$vals .= ", p_keywords_".$v1."='".mysql_real_escape_string(stripslashes($_REQUEST['p_keywords_'.$v1]))."'"; 
			$vals .= ", p_description_".$v1."='".mysql_real_escape_string(stripslashes($_REQUEST['p_description_'.$v1]))."'"; 
			$vals .= ", linkname_".$v1."='".mysql_real_escape_string(stripslashes($_REQUEST['linkname_'.$v1]))."'"; 
			$vals .= ", linktitle_".$v1."='".mysql_real_escape_string(stripslashes($_REQUEST['linktitle_'.$v1]))."'"; 
		}
		$pfile = $_REQUEST['psource']=="link" ? $_REQUEST['plink'] : $_REQUEST['pfile'];
		$q="UPDATE ".$_conf['prefix']."page SET 
		pname='".mysql_real_escape_string(stripslashes($_REQUEST['pname']))."',
		pparent='".mysql_real_escape_string(stripslashes($_REQUEST['pparent']))."',
		ptitle='".mysql_real_escape_string(stripslashes($_REQUEST['psource']))."',
		ppar='".mysql_real_escape_string(stripslashes($_REQUEST['ppar']))."',
		plevel='".$plevel."',
		pfile='".mysql_real_escape_string(stripslashes($pfile))."',
		pgroups='".$pgroups."',
		ptemplate='".mysql_real_escape_string(stripslashes($_REQUEST['ptemplate']))."',
		phelp='".mysql_real_escape_string(stripslashes($_REQUEST['phelp']))."',
		page_blocks='".$page_blocks."',
		ptype='".mysql_real_escape_string(stripslashes($_REQUEST['ptype']))."',
		linkpos='".mysql_real_escape_string(stripslashes($_REQUEST['linkpos']))."',
		siteshow='".$ss."',
		menushow1='".$ms1."',
		menushow2='".$ms2."',
		menushow3='".$ms3."',
		lastedit='".time()."',
		whoedit='".$_SESSION['USER_IDU']."',
		beditor='".mysql_real_escape_string(stripslashes($_REQUEST['beditor']))."'
		".$vals."
		WHERE pid='".(int)$_REQUEST['pid']."'";
//echo $q;
		$ms = $db -> Execute($q);
		add_to_log($q,"fortrans");
		if($_REQUEST['old_pname']!=$_REQUEST['pname']){
			$r = $db -> Execute("UPDATE ".$_conf['prefix']."page SET
			pparent='".mysql_real_escape_string(stripslashes($_REQUEST['pname']))."'
			WHERE pparent='".mysql_real_escape_string(stripslashes($_REQUEST['old_pname']))."'
			");
		}
		echo msg_box($alang_ar['saved']);
	}
	if($er==1){
		$_REQUEST['act'] = "edit";
	}else{
		unset($_REQUEST['act']);
	}
}
//==============РЕДАКТИРОВАНИЕ ИНФОРМАЦИИ О СТРАНИЦЕ============================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="edit"){
	$fl = GetLangField();
	
	$rform = $db -> Execute("select * from ".$_conf['prefix']."form");
	$forms = '';
	if($rform->RecordCount()>0){
		$forms .= '<br /><br /><div><strong>'.$lang_ar['ala_formlist'].':</strong><br />
		<small>'.$lang_ar['ala_formlist_h'].'</small><br />
		<select name="FormList" id="FormList" style="width:200px;" onchange="if(this.value!=\'\') $(\'#FCOPY\').val(\'{FORM-\'+this.value+\'-FORM}\');">
		<option value=""></option>';
		while(!$rform->EOF){
			$tform = $rform -> GetRowAssoc(false);
			$forms .= '<option value="'.$tform['idf'].'">'.stripslashes($tform['name']).'</option>';
			$rform -> MoveNext();
		}
		$forms .= '</select><br />';
		$forms .= '<input type="text" id="FCOPY" name="FCOPY" size="20" onfocus="select()" /></div>';
	}
	
	$rs = $db->Execute("SELECT * FROM ".$_conf['prefix']."page WHERE pid='".(int)$_REQUEST['pid']."'");
	if($rs->RecordCount()!=0){
		$tmp=$rs->GetRowAssoc(false);
		  $q="SELECT * FROM ".$_conf['prefix']."page ORDER BY linkpos";
		  $r = $db -> Execute($q);
		  $all = $r -> GetAll();

		$pparent = isset($_REQUEST['pparent']) ? htmlspecialchars(stripslashes($_REQUEST['pparent'])) : $tmp['pparent'];
		$pparent_list = "<select name='pparent' id='pparent' style='width:200px;'><option value=''> - ".$alang_ar['ala_newoption']." - </option>".SecList($all,'',0,$pparent)."</select>";

		$gvalue = isset($_REQUEST['pgroups']) ? $_REQUEST['pgroups'] : explode(",",$tmp['pgroups']);
		$g_check = create_check($glist,$gvalue,"pgroups","");

		$bvalue = isset($_REQUEST['page_blocks']) ? $_REQUEST['page_blocks'] : explode(",",$tmp['page_blocks']);
		$b_check = create_check($blist,$bvalue,"page_blocks","");
		
		$ptype = isset($_REQUEST['ptype']) ? htmlspecialchars(stripslashes($_REQUEST['ptype'])) :  $tmp['ptype'];	
		$p_type = create_select($page_type, $ptype, "ptype", "");

		$pname = isset($_REQUEST['pname']) ? htmlspecialchars(stripslashes($_REQUEST['pname'])) : htmlspecialchars(stripslashes($tmp['pname']));
		$phelp = isset($_REQUEST['phelp']) ? htmlspecialchars(stripslashes($_REQUEST['phelp'])) : htmlspecialchars(stripslashes($tmp['phelp']));
		$linkpos = isset($_REQUEST['linkpos']) ? htmlspecialchars(stripslashes($_REQUEST['linkpos'])) : htmlspecialchars(stripslashes($tmp['linkpos']));
		$pfile = isset($_REQUEST['pfile']) ? htmlspecialchars(stripslashes($_REQUEST['pfile'])) : htmlspecialchars(stripslashes($tmp['pfile']));
		$ptemplate = isset($_REQUEST['ptemplate']) ? htmlspecialchars(stripslashes($_REQUEST['ptemplate'])) : htmlspecialchars(stripslashes($tmp['ptemplate']));
		$ppar = isset($_REQUEST['ppar']) ? htmlspecialchars(stripslashes($_REQUEST['ppar'])) : htmlspecialchars(stripslashes($tmp['ppar']));
		$ptitle = isset($_REQUEST['psource']) ? htmlspecialchars(stripslashes($_REQUEST['psource'])) : htmlspecialchars(stripslashes($tmp['ptitle']));
		$beditor = isset($_REQUEST['beditor']) ? htmlspecialchars(stripslashes($_REQUEST['beditor'])) : htmlspecialchars(stripslashes($tmp['beditor']));
		$bed = create_select($bed_array, $beditor, "beditor", "");
		$editor = $tmp['beditor'];
		
		$d_ss = isset($_REQUEST['siteshow']) ? 'y' : $tmp['siteshow'];
		$d_ms1 = isset($_REQUEST['menushow1']) ? 'y' : $tmp['menushow1'];
		$d_ms2 = isset($_REQUEST['menushow2']) ? 'y' : $tmp['menushow2'];
		$d_ms3 = isset($_REQUEST['menushow3']) ? 'y' : $tmp['menushow3'];

		$ss = $tmp['siteshow']=="y" ? ' checked="checked"' : '';
		$ms1 = $tmp['menushow1']=="y" ? ' checked="checked"' : '';
		$ms2 = $tmp['menushow2']=="y" ? ' checked="checked"' : '';
		$ms3 = $tmp['menushow3']=="y" ? ' checked="checked"' : '';

		$ps1 = $ps2 = $ps3 = $ps4 = ''; $psf = $psc = $psdl = "none";
		if($ptitle=="file"){
			$ps1 = ' checked="checked"';
			$psf = "block";
		}
		if($ptitle=="combi"){
			$ps3 = ' checked="checked"';
			$psf = $psc = "block";
		}
		if($ptitle=="base"){
			$ps2 = ' checked="checked"';
			$psc = "block";
		}
		if($ptitle=="link"){
			$ps4 = ' checked="checked"';
			$psdl = "block";
		}
		$whoedit = GetUserName($tmp['whoedit']);
		
		/* получаем список страниц сайта для формирования ссылок */
		$ql="SELECT pid, pname, pparent, ptitle, plevel, pfile, pgroups, ptemplate, ptype, linkpos, siteshow, menushow1, menushow2, menushow3, added, lastedit, whoedit, p_title_".$_SESSION['admin_lang']." FROM ".$_conf['prefix']."page WHERE ptype='front' AND siteshow='y' ORDER BY linkpos";
		$rl = $db -> Execute($ql);
		$alll = $rl -> GetAll();
		$link_list = '<small>'.$lang_ar['ala_getlink'].'</small><br />
		<select name="links" id="links" style="width:150px;" onchange="document.getElementById(\'copylink\').value=\'?p=\'+this.value"><option value=""></option>'.SecList($alll,'',0,'').'</select><br />
		<input type="text" name="copylink" id="copylink" value="" style="width:150px;" onfocus="select()" />';
		/* конец секции*/
		
	echo "<h2>".$lang_ar['edit']."</h2>";
	echo "<div class='block'>
	<form action='admin.php?p=".$p."&act=save&pid=".$tmp['pid']."' method='post' enctype='multipart/form-data' id='APF'>
	<div class='block'><small>
	".$lang_ar['ainf_added'].": ".date("d.m.Y H:i",$tmp['added'])."<br />
	".$lang_ar['ainf_last'].": ".date("d.m.Y H:i",$tmp['lastedit'])."<br />
	".$lang_ar['ainf_who'].": ".$whoedit['FIO']." (login: ".$whoedit['login'].", id:".$tmp['whoedit'].")<br />
	</small></div>
	<span id='pset' onclick='SwitchShow(\"psetdiv\");' style='display:block; color:brown; font-size:14px; cursor:pointer; font-weight:bold; text-decoration:underline;'>Настройки страницы</span>
	<div id='addpageform'>
	<div id='psetdiv' style='display:none;'>
	<table border='0' cellspacing='0' cellpadding='0'>
	<tr>
	
	<td valign='top'>
	<span class='req'>* <strong>".$alang_ar['ainf_pagename']."</strong>:</span><br /><input type='text' name='pname' value='".$pname."' style='width:200px;' maxlength='50' />
	<input type='hidden' name='old_pname' id='old_pname' value='".stripslashes($tmp['pname'])."' />
	<br />
	<strong>".$alang_ar['ala_pparent']."</strong>:<br />".$pparent_list."<br />
	<span class='req'>* <strong>".$alang_ar['ala_ptemplate']."</strong>:</span><br /><input type='text' name='ptemplate' value='".$ptemplate."' style='width:200px;' maxlength='100' /><br />
	<span class='req'>* <strong>".$alang_ar['ala_ptype']."</strong>:</span><br />".$p_type."<br />
	<strong>".$alang_ar['ala_phelp']."</strong>:<br /><input type='text' name='phelp' value='".$phelp."' style='width:200px;' maxlength='100' /><br /><br />
	<strong>Редактор:</strong> ".$bed."<br />
	</td>
			<td width='20'>&nbsp;</td>
	<td valign='top'>
	<input type='checkbox' name='siteshow' id='siteshow' value='y'".$ss." /> ".$alang_ar['ainf_show']."<br />
	<input type='checkbox' name='menushow1' id='menushow1' value='y'".$ms1." /> ".$alang_ar['ainf_menu']." 1<br />
	<input type='checkbox' name='menushow2' id='menushow2' value='y'".$ms2." /> ".$alang_ar['ainf_menu']." 2<br />
	<input type='checkbox' name='menushow3' id='menushow3' value='y'".$ms3." /> ".$alang_ar['ainf_menu']." 3<br />
	<strong>".$alang_ar['ainf_link_pos']."</strong>:<br /><input type=text name=\"linkpos\" id=\"linkpos\" size=10 maxlenght=10 value=\"".$linkpos."\"><br />
	* <strong>".$alang_ar['ala_pgroup']."</strong>:<br />".$g_check."
	</td>
			<td width='20'>&nbsp;</td>	
	<td valign='top'>
	<strong>".$alang_ar['ala_pblock']."</strong>:<br />".$b_check."
	</td>
	</tr>
	</table>

	<strong>".$lang_ar['asys_ptype'].":</strong><br />
	<input type='radio' name='psource' id='ps1' value='file' onclick='SwitchPField(this)'".$ps1." /> ".$lang_ar['asys_ps1']."<br />
		<div id='PSF' style='display:".$psf.";'>
		<strong>".$alang_ar['ala_pfile']."</strong>:<br /><input type='text' name='pfile' id='pfile' value='".$pfile."' size='50' maxlength='100' />
		</div>
	<input type='radio' name='psource' id='ps3' value='combi' onclick='SwitchPField(this)'".$ps3." /> ".$lang_ar['asys_ps3']."<br />
	<input type='radio' name='psource' id='ps4' value='link' onclick='SwitchPField(this)' ".$ps4." /> ".$lang_ar['asys_ps4']."<br />
		<div id='PSL' style='display:".$psdl.";'>
		<strong>".$alang_ar['asys_pala_plink']."</strong>:<br /><input type='text' name='plink' id='plink' value='".$pfile."' size='50' maxlength='100' />
		</div>
	<input type='radio' name='psource' id='ps2' value='base' onclick='SwitchPField(this)'".$ps2." /> ".$lang_ar['asys_ps2']."<br /><br />
	<strong>".$lang_ar['asys_ppar'].":</strong><br />
	<input type='text' name='ppar' value='".$ppar."' size='50' maxlength='100' />
	</div><!-- psetdiv -->";
	
	initializeEditor($editor);
	echo '<table border="0" cellspacing="10"><tr><td valign="top">';
	echo '<br /><div id="tabs"><ul>';
		reset($fl); $i=1;
		while(list($k,$v)=each($fl)){
			echo '<li><a href="#tabs-'.$i.'" rel="formtab'.$i.'">'.strtoupper($k).'</a></li>';
			$i++;
		}
	echo '</ul>';
	reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
		$lkn[$k] = isset($_REQUEST['linkname_'.$k]) ? htmlspecialchars(stripslashes($_REQUEST['linkname_'.$k])) : htmlspecialchars(stripslashes($tmp['linkname_'.$k]));
		$lkt[$k] = isset($_REQUEST['linktitle_'.$k]) ? htmlspecialchars(stripslashes($_REQUEST['linktitle_'.$k])) : htmlspecialchars(stripslashes($tmp['linktitle_'.$k]));
		$lkpt[$k] = isset($_REQUEST['p_title_'.$k]) ? htmlspecialchars(stripslashes($_REQUEST['p_title_'.$k])) : htmlspecialchars(stripslashes($tmp['p_title_'.$k]));
		$lkk[$k] = isset($_REQUEST['p_keywords_'.$k]) ? htmlspecialchars(stripslashes($_REQUEST['p_keywords_'.$k])) : htmlspecialchars(stripslashes($tmp['p_keywords_'.$k]));
		$lkd[$k] = isset($_REQUEST['p_description_'.$k]) ? htmlspecialchars(stripslashes($_REQUEST['p_description_'.$k])) : htmlspecialchars(stripslashes($tmp['p_description_'.$k]));
		$lkc[$k] = isset($_REQUEST['content_'.$k]) ? stripslashes($_REQUEST['content_'.$k]) : stripslashes($tmp['content_'.$k]);
	
		echo '<div id="tabs-'.$i.'">';

		echo "<strong>".$alang_ar['ainf_linkname'].":</strong><br />
		<input type='text' name='linkname_".$k."' id='linkname_".$k."' size='50' maxlenght='150' value=\"".$lkn[$k]."\"><br />
		<strong>".$lang_ar['asys_linktitle'].":</strong><br />
		<input type='text' name='linktitle_".$k."' id='linktitle_".$k."' size='100' maxlength='255' value=\"".$lkt[$k]."\"><br />
		<span class='req'>* <strong>".$alang_ar['ainf_p_title'].":</strong></span><br />
		<input type='text' name='p_title_".$k."' id='p_title_".$k."' size='100' value=\"".$lkpt[$k]."\"><br />
		<strong>".$alang_ar['ainf_p_keywords'].":</strong><br />
		<input type='text' name='p_keywords_".$k."' id='p_keywords_".$k."' size='100' value=\"".$lkk[$k]."\"><br />
		<strong>".$alang_ar['ainf_p_desc'].":</strong><br />
		<textarea name='p_description_".$k."' id='p_description_".$k."' style='width:600px;height:50px;'>".$lkd[$k]."</textarea><br /><br />
		<div id='PSC_".$k."' class='tinyarea' style='display:".$psc.";'>
		<strong>".$alang_ar['ainf_content']."</strong><br />";
		$cfield = 'content_'.$k;
		if($editor == "no" || $editor == "") $lkc[$k] = htmlspecialchars($lkc[$k]);
		if($editor == "tiny"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$lkc[$k].'</textarea><br />';
			addTinyToField($cfield);
		}elseif($editor == "fck"){
			addFCKToField($cfield, $lkc[$k], 'Default', '900', '600');
		}elseif($editor == "ck"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$lkc[$k].'</textarea><br />';
			addCKToField($cfield, 'Default', '900', '600');
		}elseif($editor == "earea"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$lkc[$k].'</textarea><br />';
			addEditAreaToField($cfield);
		}else{
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$lkc[$k].'</textarea><br />';
		}
		echo '</div>';
		echo '</div>';

		$i++;
	}

	echo '</div>';
	
	echo '</td><td valign="middle">';
	echo $link_list;
	echo $forms;
	echo '</td></tr></table>';
	
	$HEADER .= '
	<script type="text/javascript" src="js/jquery/ui/jquery.ui.tabs.js"></script>
	<script type="text/javascript">
	$(function() { $("#tabs").tabs(); });
	</script>
	';
	echo "	<br />
	<input type='submit' value='".$alang_ar['save']."' style='width:200px;' />
	</div>
	</form></div>";
	
		if($tmp['ptype']=="front"){
			echo '<table border="0"><tr><td valign="top" width="50%">';
			PagePhotoForm("page", stripslashes($tmp['pname']));
			echo '</td><td valign="top" width="50%">';
			PageVideoForm("page", stripslashes($tmp['pname']));
			echo '</td></tr></table>';
		} // if enable add photo gallery
	} // if this record exists
// unset($_REQUEST['act']);
}

//================ДОБАВЛЕНИЕ НОВОЙ СТРАНИЦЫ==========================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="add"){
	$er = 0;
	$rs = $db->Execute("SELECT pid FROM ".$_conf['prefix']."page WHERE pname='".mysql_real_escape_string($_REQUEST['pname'])."'");
	if($rs->RecordCount() > 0){
		echo msg_box($alang_ar['ala_pexists']);
		$er = 1;
	}
	if(trim($_REQUEST['pname'])==""){
		echo msg_box($lang_ar['asys_pempty']);
		$er = 1;
	}
	if(trim($_REQUEST['ptemplate'])==""){
		echo msg_box($lang_ar['asys_ptempty']);
		$er = 1;
	}
	if(!isset($_REQUEST['pgroups'])){
		echo msg_box($lang_ar['asys_pgempty']);
		$er = 1;
	}
	if($er==0){
		$fl = GetLangField();
		if(trim($_REQUEST['pparent'])!=''){
			$pparent=$_REQUEST['pparent'];
			$plevel=1;
		}else{
			$pparent='';
			$plevel=0;
		}
		$pgroups = isset($_REQUEST['pgroups']) ? implode(",",$_REQUEST['pgroups']) : "";
		$page_blocks = isset($_REQUEST['page_blocks']) ? implode(",",$_REQUEST['page_blocks']) : "";
		$ss = isset($_REQUEST['siteshow']) ? "y" : "n";
		$ms1 = isset($_REQUEST['menushow1']) ? "y" : "n";
		$ms2 = isset($_REQUEST['menushow2']) ? "y" : "n";
		$ms3 = isset($_REQUEST['menushow3']) ? "y" : "n";

		reset($fl); $keys = $vals = '';
		while(list($k1, $v1)=each($fl)){		 
			$keys .= ',content_'.$v1.',p_title_'.$v1.',p_keywords_'.$v1.',p_description_'.$v1.',linkname_'.$v1.',linktitle_'.$v1;
			$vals .= ", '".mysql_real_escape_string(stripslashes($_REQUEST['content_'.$v1]))."'"; 
			$vals .= ", '".mysql_real_escape_string(stripslashes($_REQUEST['p_title_'.$v1]))."'"; 
			$vals .= ", '".mysql_real_escape_string(stripslashes($_REQUEST['p_keywords_'.$v1]))."'"; 
			$vals .= ", '".mysql_real_escape_string(stripslashes($_REQUEST['p_description_'.$v1]))."'"; 
			$vals .= ", '".mysql_real_escape_string(stripslashes($_REQUEST['linkname_'.$v1]))."'"; 
			$vals .= ", '".mysql_real_escape_string(stripslashes($_REQUEST['linktitle_'.$v1]))."'"; 
		}
		$pfile = $_REQUEST['psource']=="link" ? $_REQUEST['plink'] : $_REQUEST['pfile'];
		$q="INSERT INTO ".$_conf['prefix']."page
		(pname,pparent,ptitle,ppar,plevel,pfile,pgroups,ptemplate,phelp,page_blocks,ptype,linkpos,siteshow,menushow1, menushow2,menushow3,added,whoedit,beditor".$keys.")	VALUES ('".mysql_real_escape_string(stripslashes($_REQUEST['pname']))."','".mysql_real_escape_string(stripslashes($_REQUEST['pparent']))."','".mysql_real_escape_string(stripslashes($_REQUEST['psource']))."','".mysql_real_escape_string(stripslashes($_REQUEST['ppar']))."','".$plevel."','".mysql_real_escape_string(stripslashes($pfile))."','".$pgroups."','".mysql_real_escape_string(stripslashes($_REQUEST['ptemplate']))."','".mysql_real_escape_string(stripslashes($_REQUEST['phelp']))."','".$page_blocks."', '".mysql_real_escape_string(stripslashes($_REQUEST['ptype']))."','".mysql_real_escape_string(stripslashes($_REQUEST['linkpos']))."','".$ss."','".$ms1."','".$ms2."','".$ms3."','".time()."','".$_SESSION['USER_IDU']."','".mysql_real_escape_string(stripslashes($_REQUEST['beditor']))."'".$vals.")";
//echo $q;
		$ms = $db -> Execute($q);
		add_to_log($q,"fortrans");
		echo msg_box($alang_ar['saved']);
	}
	if($er==1){
		$_REQUEST['act'] = "addForm";
	}else{
		unset($_REQUEST['act']);
	}
}
/**
* Вывод формы добавления новой страницы
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="addForm"){
	$fl = GetLangField();

	$rform = $db -> Execute("select * from ".$_conf['prefix']."form");
	$forms = '';
	if($rform->RecordCount()>0){
		$forms .= '<br /><br /><div><strong>'.$lang_ar['ala_formlist'].':</strong><br />
		<small>'.$lang_ar['ala_formlist_h'].'</small><br />
		<select name="FormList" id="FormList" style="width:200px;" onchange="if(this.value!=\'\') $(\'#FCOPY\').val(\'{FORM-\'+this.value+\'-FORM}\');">
		<option value=""></option>';
		while(!$rform->EOF){
			$tform = $rform -> GetRowAssoc(false);
			$forms .= '<option value="'.$tform['idf'].'">'.stripslashes($tform['name']).'</option>';
			$rform -> MoveNext();
		}
		$forms .= '</select><br />';
		$forms .= '<input type="text" id="FCOPY" name="FCOPY" size="20" onfocus="select()" /></div>';
	}
	
	$pname = isset($_REQUEST['pname']) ? htmlspecialchars(stripslashes($_REQUEST['pname'])) : '';
	$pparent = isset($_REQUEST['pparent']) ? htmlspecialchars(stripslashes($_REQUEST['pparent'])) : '';
	$ptemplate = isset($_REQUEST['ptemplate']) ? htmlspecialchars(stripslashes($_REQUEST['ptemplate'])) : 'index.tpl';
	$ptype = isset($_REQUEST['ptype']) ? htmlspecialchars(stripslashes($_REQUEST['ptype'])) : '';
	$phelp = isset($_REQUEST['phelp']) ? htmlspecialchars(stripslashes($_REQUEST['phelp'])) : '';
	$pgroups = isset($_REQUEST['pgroups']) ? $_REQUEST['pgroups'] : array();
	$pfile = isset($_REQUEST['pfile']) ? $_REQUEST['pfile'] : '';
	$linkpos = isset($_REQUEST['linkpos']) ? $_REQUEST['linkpos'] : '';
	$ppar = isset($_REQUEST['ppar']) ? $_REQUEST['ppar'] : '';
	$page_blocks = isset($_REQUEST['page_blocks']) ? $_REQUEST['page_blocks'] : array();
	$ps1 = isset($_REQUEST['psource'])&&$_REQUEST['psource']=="file" ? ' checked="checked" ' : '';
	$ps2 = isset($_REQUEST['psource'])&&$_REQUEST['psource']=="combi" ? ' checked="checked" ' : '';
	$ps3 = !isset($_REQUEST['psource'])||$_REQUEST['psource']=="base" ? ' checked="checked" ' : '';
	$ps4 = !isset($_REQUEST['psource'])||$_REQUEST['psource']=="link" ? ' checked="checked" ' : '';
	$psd = isset($_REQUEST['psource'])&&$_REQUEST['psource']=="file" ? 'block' : 'none';
	$psdl = isset($_REQUEST['psource'])&&$_REQUEST['psource']=="link" ? 'block' : 'none';
	$psdd = isset($_REQUEST['psource'])&&($_REQUEST['psource']=="file"||$_REQUEST['psource']=="link") ? 'none' : 'block';
	$siteshow = isset($_REQUEST['siteshow']) ? ' checked="checked" ' : '';
	$msh1 = isset($_REQUEST['menushow1']) ? ' checked="checked" ' : '';
	$msh2 = isset($_REQUEST['menushow2']) ? ' checked="checked" ' : '';
	$msh3 = isset($_REQUEST['menushow3']) ? ' checked="checked" ' : '';
	$beditor = isset($_REQUEST['beditor']) ? $_REQUEST['beditor'] : 'tiny';

	$q="SELECT * FROM ".$_conf['prefix']."page ORDER BY linkpos";
	$r = $db -> Execute($q);
	$all = $r -> GetAll();

	$pparent_list = "<select name='pparent' id='pparent' style='width:200px;'><option value=''> - ".$alang_ar['ala_newoption']." - </option>".SecList($all,'',0,$pparent)."</select>";

	$g_check = create_check($glist,$pgroups,"pgroups","");

	$b_check = create_check($blist,$page_blocks,"page_blocks","");

	$p_type = create_select($page_type, $ptype, "ptype", "");
		
	$bed = create_select($bed_array, $_conf['peditor'], "beditor", "");

		/* получаем список страниц сайта для формирования ссылок */
		$ql="SELECT pid, pname, pparent, ptitle, plevel, pfile, pgroups, ptemplate, ptype, linkpos, siteshow, menushow1, menushow2, menushow3, added, lastedit, whoedit, p_title_".$_SESSION['admin_lang']." FROM ".$_conf['prefix']."page WHERE ptype='front' AND siteshow='y' ORDER BY linkpos";
		$rl = $db -> Execute($ql);
		$alll = $rl -> GetAll();
		$link_list = '<small>'.$lang_ar['ala_getlink'].'</small><br />
		<select name="links" id="links" style="width:150px;" onchange="document.getElementById(\'copylink\').value=\'?p=\'+this.value"><option value=""></option>'.SecList($alll,'',0,'').'</select><br />
		<input type="text" name="copylink" id="copylink" value="" style="width:150px;" onfocus="select()" />';
		/* конец секции*/
		
	echo "<h2>".$alang_ar['ala_padd']."</h2>";
	echo "<div class='block'>
	<span id='pset' onclick='SwitchShow(\"psetdiv\");' style='display:block; color:brown; font-size:14px; cursor:pointer; font-weight:bold; text-decoration:underline;'>Настройки страницы</span>
	<form action='admin.php?p=".$p."&act=add' method='post' enctype='multipart/form-data' id='APF'>
	<div id='addpageform'>
	<div id='psetdiv'>
	<table border='0' cellspacing='0' cellpadding='0'>
	<tr>
	
	<td valign='top'>
	<span class='req'>* <strong>".$alang_ar['ainf_pagename']."</strong>:</span><br /><input type='text' name='pname' value='".$pname."' style='width:200px;' maxlength='50' /><br />
	<strong>".$alang_ar['ala_pparent']."</strong>:<br />".$pparent_list."<br />
	<span class='req'>* <strong>".$alang_ar['ala_ptemplate']."</strong>:</span><br /><input type='text' name='ptemplate' value='".$ptemplate."' style='width:200px;' maxlength='100' /><br />
	<span class='req'>* <strong>".$alang_ar['ala_ptype']."</strong>:</span><br />".$p_type."<br />
	<strong>".$alang_ar['ala_phelp']."</strong>:<br /><input type='text' name='phelp' value='".$phelp."' style='width:200px;' maxlength='100' /><br /><br />
	<strong>Редактор:</strong> ".$bed."<br />
	</td>
			<td width='20'>&nbsp;</td>
	<td valign='top'>
	<input type='checkbox' name='siteshow' id='siteshow' value='y' ".$siteshow." /> ".$alang_ar['ainf_show']."<br />
	<input type='checkbox' name='menushow1' id='menushow1' value='y' ".$msh1." /> ".$alang_ar['ainf_menu']." 1<br />
	<input type='checkbox' name='menushow2' id='menushow2' value='y' ".$msh2." /> ".$alang_ar['ainf_menu']." 2<br />
	<input type='checkbox' name='menushow3' id='menushow3' value='y' ".$msh3." /> ".$alang_ar['ainf_menu']." 3<br />
	<strong>".$alang_ar['ainf_link_pos']."</strong>:<br /><input type=text name=\"linkpos\" id=\"linkpos\" size='10' maxlenght='10' value=\"".$linkpos."\"><br />
	<span class='req'>* <strong>".$alang_ar['ala_pgroup']."</strong>:</span><br />".$g_check."
	</td>
			<td width='20'>&nbsp;</td>	
	<td valign='top'>
	<strong>".$alang_ar['ala_pblock']."</strong>:<br />".$b_check."
	</td>
	</tr>
	</table>

	<strong>".$lang_ar['asys_ptype'].":</strong><br />
	<input type='radio' name='psource' id='ps1' value='file' onclick='SwitchPField(this)' ".$ps1." /> ".$lang_ar['asys_ps1']."<br />
		<div id='PSF' style='display:".$psd.";'>
		<strong>".$alang_ar['ala_pfile']."</strong>:<br /><input type='text' name='pfile' value='".$pfile."' size='50' maxlength='100' />
		</div>
	<input type='radio' name='psource' id='ps3' value='combi' onclick='SwitchPField(this)' ".$ps2." /> ".$lang_ar['asys_ps3']."<br />
	<input type='radio' name='psource' id='ps4' value='link' onclick='SwitchPField(this)' ".$ps4." /> ".$lang_ar['asys_ps4']."<br />
		<div id='PSL' style='display:".$psdl.";'>
		<strong>".$alang_ar['asys_pala_plink']."</strong>:<br /><input type='text' name='plink' id='plink' value='".$pfile."' size='50' maxlength='100' />
		</div>
	<input type='radio' name='psource' id='ps2' value='base' ".$ps3." onclick='SwitchPField(this)' /> ".$lang_ar['asys_ps2']."<br /><br />
	
	<strong>".$lang_ar['asys_ppar'].":</strong><br />
	<input type='text' name='ppar' value='".$ppar."' size='50' maxlength='100' />
	</div><!-- psetdiv -->";
		
		initializeEditor($_conf['peditor']);
	
	echo '<table border="0" cellspacing="10"><tr><td valign="top">';
	echo '<br /><div id="tabs"><ul>';
		reset($fl); $i=1;
		while(list($k,$v)=each($fl)){
			echo '<li><a href="#tabs-'.$i.'">'.strtoupper($k).'</a></li>';
			$i++;
		}
	echo '</ul>';
	reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
		$lkn[$k] = isset($_REQUEST['linkname_'.$k]) ? htmlspecialchars(stripslashes($_REQUEST['linkname_'.$k])) : '';
		$lkt[$k] = isset($_REQUEST['linktitle_'.$k]) ? htmlspecialchars(stripslashes($_REQUEST['linktitle_'.$k])) : '';
		$lkpt[$k] = isset($_REQUEST['p_title_'.$k]) ? htmlspecialchars(stripslashes($_REQUEST['p_title_'.$k])) : '';
		$lkk[$k] = isset($_REQUEST['p_keywords_'.$k]) ? htmlspecialchars(stripslashes($_REQUEST['p_keywords_'.$k])) : '';
		$lkd[$k] = isset($_REQUEST['p_description_'.$k]) ? htmlspecialchars(stripslashes($_REQUEST['p_description_'.$k])) : '';
		$lkc[$k] = isset($_REQUEST['content_'.$k]) ? stripslashes($_REQUEST['content_'.$k]) : '';
		echo '<div id="tabs-'.$i.'">';

		echo "<strong>".$alang_ar['ainf_linkname'].":</strong><br />
		<input type='text' name='linkname_".$k."' id='linkname_".$k."' size='50' maxlenght='150' value=\"".$lkn[$k]."\"><br />
		<strong>".$lang_ar['asys_linktitle'].":</strong><br />
		<input type='text' name='linktitle_".$k."' id='linktitle_".$k."' size='100' maxlength='255' value=\"".$lkt[$k]."\"><br />
		<span class='req'>* <strong>".$alang_ar['ainf_p_title'].":</strong></span><br />
		<input type='text' name='p_title_".$k."' id='p_title_".$k."' size='100' value=\"".$lkpt[$k]."\"><br />
		<strong>".$alang_ar['ainf_p_keywords'].":</strong><br />
		<input type='text' name='p_keywords_".$k."' id='p_keywords_".$k."' size='100' value=\"".$lkk[$k]."\"><br />
		<strong>".$alang_ar['ainf_p_desc'].":</strong><br />
		<textarea name='p_description_".$k."' id='p_description_".$k."' style='width:600px;height:50px;'>".$lkd[$k]."</textarea><br /><br />
		<div id='PSC_".$k."' class='tinyarea' style='display:".$psdd.";'>
		<strong>".$alang_ar['ainf_content']."</strong><br />";
		$cfield = 'content_'.$k;
		if($_conf['peditor'] == "no" || $_conf['peditor'] == "") $lkc[$k] = htmlspecialchars($lkc[$k]);
		if($_conf['peditor'] == "tiny"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$lkc[$k].'</textarea><br />';
			addTinyToField($cfield);
		}elseif($_conf['peditor'] == "fck"){
			addFCKToField($cfield, $lkc[$k], 'Default', '900', '600');
		}elseif($_conf['peditor'] == "ck"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$lkc[$k].'</textarea><br />';
			addCKToField($cfield, 'Default', '900', '600');
		}elseif($_conf['peditor'] == "earea"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$lkc[$k].'</textarea><br />';
			addEditAreaToField($cfield);
		}else{
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$lkc[$k].'</textarea><br />';
		}

		echo '</div></div>';

		$i++;
	}

	echo '</div>';
	
	echo '</td><td valign="middle">';
	
	echo $link_list;
	echo $forms;
	
	echo '</td></tr></table>';
	
	$HEADER .= '
	<script type="text/javascript" src="js/jquery/ui/jquery.ui.tabs.js"></script>
	<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
	</script>
	';
	echo "	<br />
	<input type='submit' value='".$alang_ar['save']."' style='width:200px;' />
	</div>
	</form></div>";
}
//===============УДАЛЕНИЕ СТРАНИЦЫ================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="delete"){
	if($_REQUEST['type']=="0"){
		$q="DELETE FROM ".$_conf['prefix']."page WHERE pname='".stripslashes($_REQUEST['pname'])."' OR pparent='".stripslashes($_REQUEST['pname'])."'";
		$ms = $db->Execute($q);
	}else{
		$q="DELETE FROM ".$_conf['prefix']."page WHERE pname='".stripslashes($_REQUEST['pname'])."'";
		$ms = $db->Execute($q);
	}
	add_to_log($q,"fortrans");
		echo msg_box(sprintf($alang_ar['ala_pdel'], $_REQUEST['pname']));
	unset($_REQUEST['act']);
}


//--------------ВЫВОД СПИСКА СТРАНИЦ И ФОРМЫ ДОБАВЛЕНИЯ СТРАНИЦЫ-----------
if(!isset($_REQUEST['act'])){
	if($_SESSION['USER_GROUP']=="super"){
		$q="SELECT pid, pname, pparent, ptitle, plevel, pfile, pgroups, ptemplate, ptype, linkpos, siteshow, menushow1, menushow2, menushow3, added, lastedit, whoedit, p_title_".$_SESSION['admin_lang']." FROM ".$_conf['prefix']."page ORDER BY linkpos";
	}else{
		$q="SELECT pid, pname, pparent, ptitle, plevel, pfile, pgroups, ptemplate, ptype, linkpos, siteshow, menushow1, menushow2, menushow3, added, lastedit, whoedit, p_title_".$_SESSION['admin_lang']." FROM ".$_conf['prefix']."page WHERE FIND_IN_SET('".$_SESSION['USER_GROUP']."',pgroups) 
		AND pname!='cron' ORDER BY linkpos";
	}
  $r = $db -> Execute($q);
  $all = $r -> GetAll();

	echo "<div style='padding-left:20px;'>
	<form action='admin.php?p=".$p."&act=change_order' method='post'>
	<table border='0' width='100%' cellspacing='0' class='selrow' id='PageListTab'>";
	echo "<thead><tr>
	<th>".$alang_ar['ala_pname']."</th>
	<th>".$alang_ar['ainf_order']."</th>
	<th>".$alang_ar['ala_ptitle']."</th>
	<th>".$alang_ar['ainf_ss']."</th>
	<th>".$alang_ar['ainf_sm']." 1</th>
	<th>".$alang_ar['ainf_sm']." 2</th>
	<th>".$alang_ar['ainf_sm']." 3</th>
	<th>".$alang_ar['ala_pfile']."</th>
	<th>".$alang_ar['ala_ptemplate']."</th>
	<th>".$alang_ar['ala_pgroup']."</th>
	<th>".$alang_ar['ala_ptype']."</th>
	<th>&nbsp;</th>
	</tr></thdead><tbody>";
	
echo OutList($all, "", 0, null, $page_type);

echo "</tbody></table><input type=\"submit\" value=\"$alang_ar[save]\" /></form></div>";
}


/* **************************************************************** */
function SecList($all,$pparent, $level, $curent){
	global $db, $_conf;
	$sel = '';
	reset($all);
  $fill = str_repeat("-", $level*3);
  while(list($k,$v)=each($all)){
  	if($v['pparent']==$pparent){
      if($curent==$v['pname']) $sel.="<option  class='tbg".$level."' value='".$v['pname']."' selected='selected'> ".$fill." ".stripslashes($v['p_title_'.$_conf['def_lang']])."</option>";
      else $sel.="<option  class='tbg".$level."' value='".$v['pname']."'> ".$fill." ".stripslashes($v['p_title_'.$_SESSION['admin_lang']])."</option>";
	  $sel.=SecList($all,$v['pname'], $level+1, $curent);
	}
  }
	return $sel;		
}

/* ************************************************************** */
function OutList($all=array(), $pparent, $level, $node=null, $page_type){
	global $db, $_conf, $p, $lang_ar;
	$tab = '';
	$fill = str_repeat("&nbsp;", $level*6);
	reset($all);
  while(list($k,$v)=each($all)){
	  if($v['pparent']==$pparent){
		   $ss = $v['siteshow']=="y" ? $ss="checked='checked'" : '';
		   $ms1 = $v['menushow1']=="y" ? $ms1="checked='checked'" : '';
		   $ms2 = $v['menushow2']=="y" ? $ms2="checked='checked'" : '';
		   $ms3 = $v['menushow3']=="y" ? $ms3="checked='checked'" : '';
		if($v['pparent']=="") $pnode = "";
		else $pnode = $v['pparent']."-";
		$treetab = 'id="ex0-node-'.$pnode.$v['pname'].'" class="child-of-ex0-node-'.$node.'"';
		if($level==0){ $style = ' style="background:#eeeeee;"'; $pnst = ' style="font-weight:bold;"'; }
		//elseif($level==1) $style = ' style="background:#cbdd9e;"';
		//elseif($level==2) $style = ' style="background:#e5f0c8;"';
		else{ $style=''; $pnst = ''; }
		if($v['ptitle']=="base") $v['pfile'] = "db";
		if($v['ptitle']=="combi") $v['pfile'] = "db + ".$v['pfile'];
		if($v['ptitle']=="link") $v['pfile'] = "link: ".$v['pfile'];
		echo "<tr ".$treetab."".$style.">
		<td align='left' nowrap='nowrap'>".$fill." <a href='admin.php?p=".$p."&act=edit&pid=".$v['pid']."'><span".$pnst.">".$v['pname']."</span></a>&nbsp;
		<a href='javascript:void(null)' onClick=\"divwin=dhtmlwindow.open('CopyPageBox', 'inline', '', '".$lang_ar['create_copy']."', 'width=400px,height=250px,left=250px,top=70px,resize=1,scrolling=1'); getdata('','get','?p=".$p."&act=CopyPageForm&source_pid=".$v['pid']."','CopyPageBox_inner'); return false; \" title='".$lang_ar['create_copy']."'><img src='".$_conf['admin_tpl_dir']."img/btncopy.gif' width='20' height='20' alt='".$lang_ar['create_copy']."' border='0' /></a>&nbsp;
		<a href='admin.php?p=".$p."&act=addForm&pparent=".$v['pname']."' title='".$lang_ar['create_inner']."'><img src='".$_conf['admin_tpl_dir']."img/ins.gif' width='10' height='10' alt='".$lang_ar['create_inner']."' border='0' /></a>
		</td>
		<td><input type=\"text\" id=\"pid[".$v['pid']."]\" name=\"pid[".$v['pid']."]\" value=\"".$v['linkpos']."\" size=\"3\" /></td>
		<td><a href='admin.php?p=".$p."&act=edit&pid=".$v['pid']."'>".$v['p_title_'.$_SESSION['admin_lang']]."</a></td>
		<td align='center'><input type='checkbox' name='siteshow[".$v['pid']."]' id='siteshow[".$v['pid']."]' value='y' ".$ss." /></td>";
		if($v['ptype']=="front") echo "<td align='center'><input type='checkbox' name='menushow1[".$v['pid']."]' id='menushow1[".$v['pid']."]' value='y' ".$ms1." /></td>";
		else echo "<td>&nbsp;</td>";

		if($v['ptype']=="front") echo "<td align='center'><input type='checkbox' name='menushow2[".$v['pid']."]' id='menushow2[".$v['pid']."]' value='y' ".$ms2." /></td>";
		else echo "<td>&nbsp;</td>";

		if($v['ptype']=="front") echo "<td align='center'><input type='checkbox' name='menushow3[".$v['pid']."]' id='menushow3[".$v['pid']."]' value='y' ".$ms3." /></td>";
		else echo "<td>&nbsp;</td>";

		if($v['ptype']=="front" || $v['ptype']=="fronthid") $ptst = ' style="color:green;font-weight:bold;"';
		elseif($v['ptype']=="back" || $v['ptype']=="backhid") $ptst = ' style="color:red;"';
		else $ptst = '';
		echo "
		<td><small>".$v['pfile']."</small></td>
		<td><small>".$v['ptemplate']."</small></td>
		<td><small>".str_replace(",",", ",$v['pgroups'])."</small></td>
		<td><span".$ptst."><small>".$page_type[$v['ptype']]."</small></span></td>
		<td><a href='".$_SERVER['PHP_SELF']."?p=".$p."&act=delete&type=1&pname=".$v['pname']."' onclick=\"if(!confirm('Удалить страницу?')||!confirm('Вы точно уверены? После удаления восстановить раздел будет невозможно!')) return false\" title='".$lang_ar['delete']."'><img src='".$_conf['admin_tpl_dir']."img/delit.png' width='16' height='16' alt='".$lang_ar['delete']."' border='0' /></a></td>
		</tr>";
		 $tab .= OutList($all, $v['pname'], $level+1, $pnode.$v['pname'], $page_type);
	  }
  }
  return $tab;		
}

/* ************************************************************************ */
if(isset($_REQUEST['act']) && $_REQUEST['act'] == "UploadPhoto"){
	$js['state'] = "OK";
	$js['msg'] = '';//print_r($_REQUEST,1).print_r($_FILES,1);
	$out = "";
	$fl = GetLangField();
	$pid = time();
	$photo_type = stripslashes($_REQUEST['photo_type']);
	$type_id = stripslashes($_REQUEST['type_id']);
	include("include/uploader.php");
	$upl = new uploader;
	$dir1 = $_conf['upldir'].'/'.$photo_type;
	if(!is_dir($dir1)) $upl -> MakeDir($dir1);
	$dir = $_conf['upldir'].'/'.$photo_type.'/'.$type_id;
	if(!is_dir($dir)) $upl -> MakeDir($dir);
	
	include("include/imager.php");
	$img = new imager;
	$width = array($_REQUEST['pp_w'], $_conf['pgal_w'], 10000);
	$height = array($_REQUEST['pp_h'], $_conf['pgal_h'], 10000);
	$name = array($dir.'/'.$pid."_s.jpg", $dir.'/'.$pid.".jpg", $dir.'/'.$pid."_orig.jpg");
	$img -> width = $width;
	$img -> height = $height;
	$img -> fname = $name;
	$img -> desttype = array("thumb","photo","original");
	if(isset($_REQUEST['crop']) && $_REQUEST['crop']=="yes") $img -> crop = array("yes","","");
	else $img -> crop = array("","","");
	if(isset($_REQUEST['whatcrop'])) $img -> whatcrop = array($_REQUEST['whatcrop'],"","");
	else $img -> whatcrop = array("","","");
	$img -> resizetype = $_REQUEST['resizetype'];
	$res = $img -> ResizeImage($_FILES['file']);
	if($res == 1){
		reset($fl); $vals = '';
		while(list($k,$v)=each($fl)) $vals .= ",photosign_".$k."='".mysql_real_escape_string(stripslashes($_REQUEST['photosign_'.$k]))."'";
		$q="INSERT INTO ".$_conf['prefix']."page_gal SET photo_id='".$pid."', photo_type='".mysql_real_escape_string($photo_type)."', type_id='".mysql_real_escape_string($type_id)."', photo_group='".mysql_real_escape_string($_REQUEST['photo_group'])."'".$vals." ";
		$rs = $db -> Execute($q);
		$js['msg'] = '<font color="green">Фото успешно загружено на сервер!</font>';
		$js['thumb'] = $dir.'/'.$pid."_s.jpg";
		$js['thumb_w'] = $_conf['pgal_thumb_w'];
		$js['bigphoto'] = $dir.'/'.$pid.".jpg";
		$js['photo_id'] = $pid;
		$js['photo_group'] = stripslashes($_REQUEST['photo_group']);
		$js['psign'] = stripslashes($_REQUEST['photosign_'.$_SESSION['admin_lang']]);
	}else{
		$js['state'] = "ERROR";
		$js['msg'] = '<font color="green">'.$res.'</font>';
	}
	$GLOBALS['_RESULT'] = $js;
}
/* ************************************************************************ */
if(isset($_REQUEST['act']) && $_REQUEST['act'] == "DeletePhoto"){
	echo DelPagePhoto($_REQUEST['photo_id']);
}


$HEADER .= <<<EOT
	<link href="$_conf[www_patch]/$_conf[admin_tpl_dir]css/jquery.acts_as_tree_table.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="$_conf[www_patch]/js/jquery/external/jquery.acts_as_tree_table.js"></script> 
	<script type="text/javascript">
		$(document).ready(function(){
			$("#PageListTab").acts_as_tree_table({
				default_state: 'collapsed',
				indent: 20
			});
		} ); 
		function SwitchPField(obj){
			if(obj.id=='ps1' && obj.checked==true){
				document.getElementById('PSF').style.display = 'block';
				document.getElementById('PSL').style.display = 'none';
				var ob = getElementsByClass("tinyarea",null,'div');
				for(i=0;i<ob.length;i++){
					document.getElementById(ob[i].id).style.display = 'none';
				}	
			}
			if(obj.id=='ps3' && obj.checked==true){
				document.getElementById('PSF').style.display = 'block';
				document.getElementById('PSL').style.display = 'none';
				var ob = getElementsByClass("tinyarea",null,'div');
				for(i=0;i<ob.length;i++){
					document.getElementById(ob[i].id).style.display = 'block';
				}	
			}
			if(obj.id=='ps2' && obj.checked==true){
				document.getElementById('PSF').style.display = 'none';
				document.getElementById('PSL').style.display = 'none';
				var ob = getElementsByClass("tinyarea",null,'div');
				for(i=0;i<ob.length;i++){
					document.getElementById(ob[i].id).style.display = 'block';
				}	
			}
			if(obj.id=='ps4' && obj.checked==true){
				document.getElementById('PSL').style.display = 'block';
				document.getElementById('PSF').style.display = 'none';
				var ob = getElementsByClass("tinyarea",null,'div');
				for(i=0;i<ob.length;i++){
					document.getElementById(ob[i].id).style.display = 'none';
				}	
			}
		}	
    </script>
EOT;

?>
