<?php
/**
 * Создан6ие новой темы к форуму
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00	13.10.2009
 */
if(!defined("SHIFTCMS")) exit;
//	print_r($lang_ar);
$tname = isset($_REQUEST['tname']) ? htmlspecialchars(stripslashes($_REQUEST['tname'])) : "";
$smarty -> assign("tname",$tname);
$ttext = isset($_REQUEST['ttext']) ? stripslashes($_REQUEST['ttext']) : "";

/**
* Предварительный просмотр создаваемой темы
*/
if(isset($_REQUEST['fact']) && $_REQUEST['fact']=="addTheme" && isset($_SESSION['USER_IDU']) && isset($_REQUEST['preview'])){
  $q = "select count(*) from ".$_conf['prefix']."forum_msg where mavtor = '".$_SESSION['USER_IDU']."'";
  $q1 = "select count(*) from ".$_conf['prefix']."forum_theme where tavtor = '".$_SESSION['USER_IDU']."'";
  $r = $db -> Execute($q);
  $t = $r -> GetRowAssoc(false);
  $r1 = $db -> Execute($q1);
  $t1 = $r1 -> GetRowAssoc(false);
	$smarty -> assign("tdate", "Сегодня в ".date("H:i", time()));
	$smarty -> assign("tavtor_idu", stripslashes($_SESSION['USER_IDU']));
	$smarty -> assign("tavtor_login", stripslashes($_SESSION['USER_LOGIN']));
	$smarty -> assign("tavtor_msg", $t['count(*)']+$t1['count(*)']);
	if(file_exists("files/avatars/".$_SESSION['USER_IDU'].".jpg")) $smarty -> assign("tavtor_avatar","files/avatars/".$_SESSION['USER_IDU'].".jpg");
	if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=""){
		include("include/uploader.php");
		$upl = new uploader;
		$d1 = "files/forum"; $d2 = "/".$_REQUEST['f']; $d3 = "/".$_REQUEST['folder'];
		if(!is_dir($d1)) $upl -> MakeDir($d1);
		if(!is_dir($d1.$d2)) $upl -> MakeDir($d1.$d2);
		if(!is_dir($d1.$d2.$d3)) $upl -> MakeDir($d1.$d2.$d3);
		$cres = $upl -> CheckFile($_FILES['file'], $d1.$d2.$d3."/".$_FILES['file']['name']);
		if($cres!=1){
			$infer .= msg_box($cres); $er = 1;
		}else{
			$mres = $upl -> MoveFile($_FILES['file']['tmp_name'], $d1.$d2.$d3."/".$_FILES['file']['name']);
			if($mres != 1){
				$infer .= msg_box($mres); $er = 1;
			}else{
				$file = $d1.$d2.$d3."/".$_FILES['file']['name'];
			}
		}
	}elseif($_REQUEST['pfile']!=""){
		$file = stripslashes($_REQUEST['pfile']);
	}else{
		$file = "";
	}
		$smarty -> assign("pfile", $file);
	$fapp = $lapp = "";
	if($file!="" && file_exists($file)){
		$pp = pathinfo($file);
		if($pp['extension']=="gif" || $pp['extension']=="png" || $pp['extension']=="jpg" || $pp['extension']=="jpeg"){
			if($_conf['forum_editor'] == "bbcode"){
				$fapp = "[img]".stripslashes($file)."[/img]\n";
			}else{
				$fapp = '<img src="'.stripslashes($file).'" /><br />';
			}
		}else{
			if($_conf['forum_editor'] == "bbcode"){
				$lapp = "\n[url]".stripslashes($file)."[/url]";
			}else{
				$lapp = '<br /><a href="'.stripslashes($file).'">'.$pp['basename'].'</a>';
			}
		}
	}

			if($_conf['forum_editor'] == "bbcode"){
				$bb = new bbcode($ttext);
				$smarty -> assign("ttext",$bb->get_html());
				$ffapp = new bbcode($fapp);
				$smarty -> assign("fapp",$ffapp->get_html());
				$llapp = new bbcode($lapp);
				$smarty -> assign("lapp",$llapp->get_html());
			}else{
				$smarty -> assign("ttext", $ttext);
				$smarty -> assign("fapp", "");
				$smarty -> assign("lapp", "");
			}
		$smarty -> assign("preview", "preview");
}

/**
* Добавление новой темы
*/
if(isset($_REQUEST['fact']) && $_REQUEST['fact']=="addTheme" && isset($_SESSION['USER_IDU']) && !isset($_REQUEST['preview'])){
	$er = 0; $infer = "";
	if(trim($_REQUEST['ttext'])==""){
		$infer .= msg_box($lang_ar['forum_er1']); $er = 1;
	}
	if(trim($_REQUEST['tname'])==""){
		$infer .= msg_box($lang_ar['forum_er2']); $er = 1;
	}
	if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=""){
		include("include/uploader.php");
		$upl = new uploader;
		$d1 = "files/forum"; $d2 = "/".$_REQUEST['f']; $d3 = "/".$_REQUEST['folder'];
		if(!is_dir($d1)) $upl -> MakeDir($d1);
		if(!is_dir($d1.$d2)) $upl -> MakeDir($d1.$d2);
		if(!is_dir($d1.$d2.$d3)) $upl -> MakeDir($d1.$d2.$d3);
		$cres = $upl -> CheckFile($_FILES['file'], $d1.$d2.$d3."/".$_FILES['file']['name']);
		if($cres!=1){
			$infer .= msg_box($cres); $er = 1;
		}else{
			$mres = $upl -> MoveFile($_FILES['file']['tmp_name'], $d1.$d2.$d3."/".$_FILES['file']['name']);
			if($mres != 1){
				$infer .= msg_box($mres); $er = 1;
			}else{
				$file = $d1.$d2.$d3."/".$_FILES['file']['name'];
			}
		}
	}elseif($_REQUEST['pfile']!=""){
		$file = stripslashes($_REQUEST['pfile']);
	}else{
		$file = "";
	}
	if($er == 0){
		$talert = isset($_REQUEST['alert']) ? $_SESSION['USER_IDU'] : "";
		$r = $db -> Execute("INSERT INTO ".$_conf['prefix']."forum_theme(idf, tname, ttext, tavtor, tview, tdate, talert, tfile)VALUES
		('".$_REQUEST['f']."', '".mysql_real_escape_string($_REQUEST['tname'])."', 
		'".mysql_real_escape_string($_REQUEST['ttext'])."', 
		'".$_SESSION['USER_IDU']."', '0', '".time()."', '$talert', '".mysql_real_escape_string($file)."')");
		$id_msg = $db -> Insert_ID();
		$smarty -> assign("infmsg", msg_box($lang_ar['forum_ok1']));
		//if($_conf['url_type']==1) $rurl = '/forum/show/msg/f/'.$_REQUEST['f'].'/t/'.$id_msg;
		//if($_conf['url_type']==1) $rurl = '/'.$_SESSION['lang'].'/forum.htm?show=msg&f='.$_REQUEST['f'].'&t='.$id_msg;
		$url_ar[2] = "?p=forum&show=msg&f=".$_REQUEST['f']."&t=".$id_msg;
		$rurl = $_conf['url_type']==1 ? _rewrite_url($url_ar, false) : $url_ar[2];
		header("location:".$rurl); exit;
	}else{
		$smarty -> assign("infmsg", $infer);
	}

}
/**
* Вывод основного содержимого страницы
*/
$user_idu = isset($_SESSION['USER_IDU']) ? $_SESSION['USER_IDU'] : -1;
  $q = "SELECT *  FROM ".$_conf['prefix']."forum 
  WHERE idf=".$_REQUEST['f']." AND ((ftype='o' OR ftype='c') 
   OR (ftype='s' AND FIND_IN_SET(".$user_idu.",fuser)))";
  $r = $db -> Execute($q);
  
  if($r -> RecordCount() > 0){
  	$s = $r -> GetRowAssoc(false);
	if($s['parent_idf']!='0'){
		$rp = $db -> Execute("select * from ".$_conf['prefix']."forum where idf=".$s['parent_idf']);
		$tp = $rp -> GetRowAssoc(false);
		$tp['fname'] = stripslashes($tp['fname_'.$_SESSION['lang']]);
		$smarty -> assign("parent",$tp);
	}
	$smarty -> assign("section", stripslashes($s['fname_'.$_SESSION['lang']]));
	if($s['ftype']=="o" || (($s['ftype']=="c" || $s['ftype']=="s") && in_array($_SESSION['USER_IDU'],explode(",",$s['fuser'])))){
		$smarty -> assign("showform","showform");
	}else{
		header("location:/");exit;
	}

	if(isset($_SESSION['USER_IDU'])){
		if($_conf['forum_editor'] == "fckeditor"){
				include($_conf['disk_patch']."include/FCKeditor/fckeditor.php") ;
				$oFCKeditor = new FCKeditor('ttext') ;
				$oFCKeditor->ToolbarSet = 'Forum' ;
				$sBasePath = $_conf['www_patch']."/include/FCKeditor/" ;
				$oFCKeditor->Width  = '90%';
				$oFCKeditor->Height = '300';
				$oFCKeditor_ua->Config['EditorAreaCSS'] = $_conf['www_patch']."/".$_conf['tpl_dir']."css/style.css" ;
				$oFCKeditor->Value = $ttext ;
				$FORMAREA = $oFCKeditor->Create() ;
				$smarty -> assign("FORMAREA",$FORMAREA);
		}else{
			$smarty -> assign("FORMAREA",$ttext);
		}
	}
	isset($_REQUEST['alert']) ? $smarty -> assign("alert", 'checked="checked"') : $smarty -> assign("alert", '');

if(isset($_REQUEST['folder'])) $smarty -> assign("folder",$_REQUEST['folder']);
else $smarty -> assign("folder",time());
if(!isset($file)) $smarty -> assign("pfile", "");
$smarty -> assign("idf", $_REQUEST['f']);
//$smarty -> assign("sel", $select);
$PAGE = $smarty -> fetch("forum/forum_create.tpl");
  }else{
	  header("location:/");exit;
  }

?>