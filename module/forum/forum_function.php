<?php
/**
 * Набор функций для работы форума
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00	13.10.2009
 */
if(!defined("SHIFTCMS")) exit;

function GetPagingForum($all, $interval, $start, $link, $items){
$list_page = array();
$left = floor($items/2);
if($all <= $interval) return $list_page;
if($all > $interval){

    $count_page = ceil($all / $interval);
	
    if($count_page <= $items){
    	for($i = 0; $i < $count_page; $i++){
            $page = $i + 1;
            $start1 = $interval * $i;
            $list_page[$page] = str_replace("%start1%", $start1, $link);
		}
    }else{ /* если страниц больше $items - создаем интервалы страниц */
            for($i=0; $i < $left; $i++){
            	$page = $i + 1;
				$start1 = $interval*$i;
				$list_page[$page] = str_replace("%start1%", $start1, $link);
			}
            $list_page['dot']=" ... ";
            for($i = $count_page - $left; $i < $count_page; $i++){
            	$page = $i + 1;
				$start1 = $interval * $i;
				$list_page[$page] = str_replace("%start1%", $start1, $link);
            }
    }
}
return $list_page;
}


function highlight_words($node, $phrase)
{
	$patterns = array();
	$replacements = array();
	$i = 1;
			$patterns[0] = "/".$phrase."/i";
			$replacements[0] = "<span class=found>".$phrase."</span>";
	$word = explode(" ", $phrase);
	while(list($k,$v)=each($word)){
		if(strlen($v) >= 3){
			$patterns[$i] = "/".$v."/i";
			$replacements[$i] = "<span class=found>".$v."</span>";
			$i++;
		}
	}

	return preg_replace($patterns, $replacements, $node);

}

function DeleteMsg($idm){
	global $db, $_conf, $smarty;
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_msg WHERE idm='".$idm."'");
	$t = $r -> GetRowAssoc(false);
	if($t['mfile']!="" && file_exists(stripslashes($t['mfile']))){ 
		@unlink(stripslashes($t['mfile'])); 
		DeleteAttachFolder(stripslashes($t['mfile']), "msg");
	}
	$r = $db -> Execute("DELETE FROM ".$_conf['prefix']."forum_msg WHERE idm='".$idm."'");
	return true;
}

function DeleteTheme($idt){
	global $db, $_conf, $smarty;
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_theme WHERE idt='".$idt."'");
	$t = $r -> GetRowAssoc(false);
	if($t['tfile']!="" && file_exists(stripslashes($t['tfile']))){ 
		@unlink(stripslashes($t['tfile']));
		DeleteAttachFolder(stripslashes($t['tfile']), "theme");
	}
	$r = $db -> Execute("SELECT idm FROM ".$_conf['prefix']."forum_msg WHERE idt='".$idt."'");
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		DeleteMsg($t['idm']);
		$r -> MoveNext();
	}
	$r = $db -> Execute("DELETE FROM ".$_conf['prefix']."forum_theme WHERE idt='".$idt."'");
	return true;
}
function DeleteSection($idf){
	global $db, $_conf, $smarty;
	$r = $db -> Execute("SELECT idt FROM ".$_conf['prefix']."forum_theme WHERE idf='".$idf."'");
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		DeleteTheme($t['idt']);
		$r -> MoveNext();
	}
	$r = $db -> Execute("DELETE FROM ".$_conf['prefix']."forum WHERE idf='".$idf."'");
	@unlink("files/forum/".$idf);
	return true;
}

function DeleteAttachFolder($file, $type){
	$pp = pathinfo($file);
	if($type=="msg") @rmdir($pp['dirname']);
	if($type=="theme"){
		$dirs = explode("/",$pp['dirname']);
		@rmdir($pp['dirname']);
		@rmdir(str_replace("/".$dirs[count($dirs)-1],"",$pp['dirname']));
	}
}

function MakeEditFormMsg($idm){
	global $db, $_conf, $smarty, $lang_ar;
	$out = "";
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_msg WHERE idm='".$idm."'");
	$t = $r -> GetRowAssoc(false);
	/*
	if($_conf['forum_editor'] == "bbcode"){
		$out .= '
			<link href="'.$_conf['www_patch'].'/include/bbcode/style.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript" src="'.$_conf['www_patch'].'/include/bbcode/xbb.js.php"></script>';
		$out .= '
			<script type="text/javascript">
			XBB.path = "/include/bbcode";
			XBB.textarea_id = "mtext1";
			XBB.area_width = "700px";
			XBB.area_height = "300px";
			XBB.state = "plain";
			XBB.lang = "ru_utf8";
			</script>
		';
	}
	*/
	$out .= '<form method="post" action="javascript:void(null)" id="EMF" enctype="multipart/form-data">';
		if($_conf['forum_editor'] == "fckeditor"){
				include($_conf['disk_patch']."include/FCKeditor/fckeditor.php") ;
				$oFCKeditor = new FCKeditor('mtext1') ;
				$oFCKeditor->ToolbarSet = 'Forum' ;
				$sBasePath = $_conf['www_patch']."/include/FCKeditor/" ;
				$oFCKeditor->Width  = '96%';
				$oFCKeditor->Height = '300';
				$oFCKeditor_ua->Config['EditorAreaCSS'] = $_conf['www_patch']."/".$_conf['tpl_dir']."css/style.css" ;
				$oFCKeditor->Value = stripslashes($t['mtext']);
				$FORMAREA = $oFCKeditor->Create() ;
				$out .= $FORMAREA;
		}else{
			$out .= '<textarea name="mtext1" id="mtext1" style="width:500px;height:300px">'.stripslashes($t['mtext']).'</textarea><br />';
		}
	$out .= '<input type="button" name="updateMsg" id="updateMsg" value="'.$lang_ar['save'].'" onclick="SaveMsg(\'EMF\','.$idm.')" />';
	$out .= '<input type="button" name="cancelEditMsg" id="cancelEditMsg" value="'.$lang_ar['cancel'].'" onclick="StopEditMsg('.$idm.')" />';
	$out .= '</form>';
	if($_conf['forum_editor'] == "bbcode"){
		/*$out .= '<script type="text/javascript">XBB.init();</script>';*/
	}
	return $out;
}

function cancelEditMsg($idm){
	global $db, $_conf, $smarty;
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_msg WHERE idm='".$idm."'");
	$t = $r -> GetRowAssoc(false);
	if($t['mfile']!="" && file_exists(stripslashes($t['mfile']))){
		$pp = pathinfo(stripslashes($t['mfile']));
		if($pp['extension']=="gif" || $pp['extension']=="png" || $pp['extension']=="jpg" || $pp['extension']=="jpeg"){
			if($_conf['forum_editor'] == "bbcode"){
				$fapp = "[img]".stripslashes($t['mfile'])."[/img]\n";
			}else{
				$fapp = '<img src="'.stripslashes($t['mfile']).'" /><br />';
			}
			$t['mtext'] = $fapp.$t['mtext'];
		}else{
			if($_conf['forum_editor'] == "bbcode"){
				$fapp = "\n[url]".stripslashes($t['mfile'])."[/url]";
			}else{
				$fapp = '<br /><a href="'.stripslashes($t['mfile']).'">'.$pp['basename'].'</a>';
			}
			$t['mtext'] = $t['mtext'].$fapp;
		}
	}
			if($_conf['forum_editor'] == "bbcode"){
				require_once("include/bbcode/bbcode.lib.php");
				$bb = new bbcode(stripslashes($t['mtext']));
				$mtext = $bb->get_html();
			}else{
				$mtext = stripslashes($t['mtext']);
			}
	$GLOBALS['_RESULT']['out'] = $mtext;
}
function SaveMsg($idm){
	global $db, $_conf, $smarty;
	$r = $db -> Execute("UPDATE ".$_conf['prefix']."forum_msg SET mtext='".mysql_real_escape_string($_REQUEST['mtext1'])."' WHERE idm='$idm'");
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_msg WHERE idm='$idm'");
	$t = $r -> GetRowAssoc(false);
	if($t['mfile']!="" && file_exists(stripslashes($t['mfile']))){
		$pp = pathinfo(stripslashes($t['mfile']));
		if($pp['extension']=="gif" || $pp['extension']=="png" || $pp['extension']=="jpg" || $pp['extension']=="jpeg"){
			if($_conf['forum_editor'] == "bbcode"){
				$fapp = "[img]".stripslashes($t['mfile'])."[/img]\n";
			}else{
				$fapp = '<img src="'.stripslashes($t['mfile']).'" /><br />';
			}
			$t['mtext'] = $fapp.$t['mtext'];
		}else{
			if($_conf['forum_editor'] == "bbcode"){
				$fapp = "\n[url]".stripslashes($t['mfile'])."[/url]";
			}else{
				$fapp = '<br /><a href="'.stripslashes($t['mfile']).'">'.$pp['basename'].'</a>';
			}
			$t['mtext'] = $t['mtext'].$fapp;
		}
	}
			if($_conf['forum_editor'] == "bbcode"){
				require_once("include/bbcode/bbcode.lib.php");
				$bb = new bbcode(stripslashes($t['mtext']));
				$mtext = $bb->get_html();
			}else{
				$mtext = stripslashes($t['mtext']);
			}
	$GLOBALS['_RESULT']['out'] = $mtext;
}

function MakeEditFormTheme($idt){
	global $db, $_conf, $smarty, $lang_ar;
	$out = "";
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_theme WHERE idt='".$idt."'");
	$t = $r -> GetRowAssoc(false);
	/*
	if($_conf['forum_editor'] == "bbcode"){
		$out .= '
			<link href="'.$_conf['www_patch'].'/include/bbcode/style.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript" src="'.$_conf['www_patch'].'/include/bbcode/xbb.js.php"></script>';
		$out .= '
			<script type="text/javascript">
			XBB.path = "/include/bbcode";
			XBB.textarea_id = "ttext1";
			XBB.area_width = "700px";
			XBB.area_height = "300px";
			XBB.state = "plain";
			XBB.lang = "ru_utf8";
			</script>
		';
	}
	*/
	$out .= '<form method="post" action="javascript:void(null)" id="ETF" enctype="multipart/form-data">';
	$out .= '<input type="text" name="tname" style="width:400px;" id="tname" value="'.htmlspecialchars(stripslashes($t['tname'])).'" />';
		if($_conf['forum_editor'] == "fckeditor"){
				include($_conf['disk_patch']."include/FCKeditor/fckeditor.php") ;
				$oFCKeditor = new FCKeditor('ttext1') ;
				$oFCKeditor->ToolbarSet = 'Forum' ;
				$sBasePath = $_conf['www_patch']."/include/FCKeditor/" ;
				$oFCKeditor->Width  = '96%';
				$oFCKeditor->Height = '300';
				$oFCKeditor_ua->Config['EditorAreaCSS'] = $_conf['www_patch']."/".$_conf['tpl_dir']."css/style.css" ;
				$oFCKeditor->Value = stripslashes($t['ttext']);
				$FORMAREA = $oFCKeditor->Create() ;
				$out .= $FORMAREA;
		}else{
			$out .= '<textarea name="ttext1" id="ttext1" style="width:500px;height:300px">'.stripslashes($t['ttext']).'</textarea><br />';
		}
	$out .= '<input type="button" name="updateTheme" id="updateTheme" value="'.$lang_ar['save'].'" onclick="SaveTheme(\'ETF\','.$idt.')" />';
	$out .= '<input type="button" name="cancelEditTheme" id="cancelEditTheme" value="'.$lang_ar['cancel'].'" onclick="StopEditTheme('.$idt.')" />';
	$out .= '</form>';
	if($_conf['forum_editor'] == "bbcode"){
		/*$out .= '<script type="text/javascript">XBB.init();</script>';*/
	}
	return $out;
}

function cancelEditTheme($idt){
	global $db, $_conf, $smarty;
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_theme WHERE idt='$idt'");
	$t = $r -> GetRowAssoc(false);
	if($t['tfile']!="" && file_exists(stripslashes($t['tfile']))){
		$pp = pathinfo(stripslashes($t['tfile']));
		if($pp['extension']=="gif" || $pp['extension']=="png" || $pp['extension']=="jpg" || $pp['extension']=="jpeg"){
			if($_conf['forum_editor'] == "bbcode"){
				$fapp = "[img]".stripslashes($t['tfile'])."[/img]\n";
			}else{
				$fapp = '<img src="'.stripslashes($t['tfile']).'" /><br />';
			}
			$t['ttext'] = $fapp.$t['ttext'];
		}else{
			if($_conf['forum_editor'] == "bbcode"){
				$fapp = "\n[url]".stripslashes($t['tfile'])."[/url]";
			}else{
				$fapp = '<br /><a href="'.stripslashes($t['tfile']).'">'.$pp['basename'].'</a>';
			}
			$t['ttext'] = $t['ttext'].$fapp;
		}
	}
			if($_conf['forum_editor'] == "bbcode"){
				require_once("include/bbcode/bbcode.lib.php");
				$bb = new bbcode(stripslashes($t['ttext']));
				$ttext = $bb->get_html();
			}else{
				$ttext = stripslashes($t['ttext']);
			}
	$GLOBALS['_RESULT']['out'] = $ttext;
}

function SaveTheme($idt){
	global $db, $_conf, $smarty;
	$r = $db -> Execute("UPDATE ".$_conf['prefix']."forum_theme SET tname='".mysql_real_escape_string($_REQUEST['tname'])."', ttext='".mysql_real_escape_string($_REQUEST['ttext1'])."' WHERE idt='".$idt."'");
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_theme WHERE idt='".$idt."'");
	$t = $r -> GetRowAssoc(false);
	if($t['tfile']!="" && file_exists(stripslashes($t['tfile']))){
		$pp = pathinfo(stripslashes($t['tfile']));
		if($pp['extension']=="gif" || $pp['extension']=="png" || $pp['extension']=="jpg" || $pp['extension']=="jpeg"){
			if($_conf['forum_editor'] == "bbcode"){
				$fapp = "[img]".stripslashes($t['tfile'])."[/img]\n";
			}else{
				$fapp = '<img src="'.stripslashes($t['tfile']).'" /><br />';
			}
			$t['ttext'] = $fapp.$t['ttext'];
		}else{
			if($_conf['forum_editor'] == "bbcode"){
				$fapp = "\n[url]".stripslashes($t['tfile'])."[/url]";
			}else{
				$fapp = '<br /><a href="'.stripslashes($t['tfile']).'">'.$pp['basename'].'</a>';
			}
			$t['ttext'] = $t['ttext'].$fapp;
		}
	}
			if($_conf['forum_editor'] == "bbcode"){
				require_once("include/bbcode/bbcode.lib.php");
				$bb = new bbcode(stripslashes($t['ttext']));
				$ttext = $bb->get_html();
			}else{
				$ttext = stripslashes($t['ttext']);
			}
	$GLOBALS['_RESULT']['out'] = $ttext;
	$GLOBALS['_RESULT']['head'] = stripslashes($t['tname']);
}

function SendAlert($idt, $mtext){
	global $db, $_conf, $smarty, $lang_ar;
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_theme WHERE idt='".$idt."'");
	$t = $r -> GetRowAssoc(false);
	$signed = explode(",",$t['talert']);
	if($_conf['forum_editor']=="bbcode"){
		$bb = new bbcode(stripslashes($mtext));
		$mtext = $bb->get_html();
	}else{
		$mtext = stripslashes($mtext);
	}
	reset($signed);
	//print_r($signed);
	while(list($k,$v)=each($signed)){
		if($v != $_SESSION['USER_IDU'] && $v != ""){
		$ru = $db -> Execute("SELECT * FROM ".$_conf['prefix']."users LEFT JOIN ".$_conf['prefix']."users_add USING(idu) WHERE idu='".$v."'");
		$tu = $ru -> GetRowAssoc(false);
		$message = "<strong>Здравствуйте, ".stripslashes($tu['fio'])."</strong><br />
		<p>Тема: ".stripslashes($t['tname'])."</p>
		".$_SESSION['USER_LOGIN'].":<br />-------------------------------------------<br />
		<p>".$mtext."</p>-------------------------------------------<br />
		<p><a href='".$_conf['www_patch']."/?p=forum&show=msg&t=".$idt."&f=".$t['idf']."'>".$_conf['www_patch']."/?p=forum&show=msg&t=".$idt."&f=".$t['idf']."</a></p>
		-------------------------------------------<br />
		<p>".$lang_ar['forum_mail1']."<br />
		".$lang_ar['forum_mail2']." ".$_conf['www_patch']."/contact.htm<br />
		".$lang_ar['forum_mail3']." ".$_conf['site_name']."<br /><br />
		<a href='".$_conf['www_patch']."'>".$_conf['www_patch']."</a></p>
		";
		SendEmail(0, $_conf['sup_email'], $_conf['site_name'], $v, stripslashes($tu['email']), stripslashes($tu['fio']), $lang_ar['forum_mail4'], $message);
		}
	}
}

function UpdateAlert($idt){
	global $db, $_conf, $smarty;
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_theme WHERE idt='".$idt."'");
	$t = $r -> GetRowAssoc(false);
	$newsigned = explode(",",$t['talert']);
	if(!in_array($_SESSION['USER_IDU'], $newsigned)){
		$newsigned[] = $_SESSION['USER_IDU'];
		$talert = implode(",", $newsigned);
		$rs = $db -> Execute("UPDATE ".$_conf['prefix']."forum_theme SET talert='".$talert."' WHERE idt='".$idt."'");
	}
}

function SearchUsers($sText){
	global $db, $_conf, $smarty;
	$sText = mysql_real_escape_string($sText);
	$r = $db -> Execute("select * from ".$_conf['prefix']."users left join ".$_conf['prefix']."users_add using(idu)
	where idu='".$sText."' OR login LIKE '%".$sText."%' OR email LIKE '%".$sText."%' OR fio LIKE '%".$sText."%'");
	$out = '';
	while(!$r->EOF){
		$t = $r -> GetRowAssoc(false);
		$out .= '<a href="javascript:void(null)" title="Додати користувача" onclick="addUserToSection(\''.$t['idu'].'\', \'<strong>'.stripslashes($t['fio']).'</strong> (login: '.stripslashes($t['login']).', idu: '.$t['idu'].')\')"><img alt="Додати користувача" src="'.$_conf['admin_tpl_dir'].'img/save.gif" /></a> <strong>'.stripslashes($t['fio']).'</strong> (login: '.stripslashes($t['login']).', idu: '.$t['idu'].')<br />';
		$r -> MoveNext();
	}
	return $out;
}

function prepareUserForMainSection($fuser,$idus){
	$fu = explode(",",$fuser);
	reset($idus);
	while(list($k,$v)=each($idus)){
		if(!in_array($v,$fu)) $fu[] = $v;
	}
	return implode(",",$fu);
}

?>