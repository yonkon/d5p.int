<?php
/**
 * Вывод списка сообщений из выбранной темы
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00	12.10.2009
 */
if(!defined("SHIFTCMS")) exit;

/**
* Удаление темы
*/
if(isset($_REQUEST['fact']) && $_REQUEST['fact']=="delTheme" && $access=="full"){
		$res = DeleteTheme($_REQUEST['t']);
		$smarty -> assign("infmsg", msg_box($lang_ar['forum_themedel']));
		//if($_conf['url_type']==1) $rurl = '/forum/show/theme/f/'.$_REQUEST['f'].'/';
		//else $rurl = "index.php?p=forum&show=theme&f=$_REQUEST[f]";
		//$rurl = str_replace("&fact=delTheme","",$_SERVER['REQUEST_URI']);
		$url_ar[2] = "index.php?p=forum&show=theme&f=".$_REQUEST['f'];
		$rurl = $_conf['url_type']==1 ? _rewrite_url($url_ar, false) : $url_ar[2];
		header("location:".$rurl); exit;
}

/**
* Удаление сообщения
*/
if(isset($_REQUEST['fact']) && $_REQUEST['fact']=="delMsg" && $access=="full"){
		$res = DeleteMsg($_REQUEST['m']);
		$smarty -> assign("infmsg", msg_box($lang_ar['forum_msgdel']));
}

/**
* Удаление приложения
*/
if(isset($_REQUEST['fact']) && $_REQUEST['fact']=="delFile" && $access=="full"){
	if(isset($_REQUEST['m'])){
		$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_msg WHERE idm=".mysql_real_escape_string($_REQUEST['m']));
		$t = $r -> GetRowAssoc(false);
		DeleteAttachFolder($t['mfile'], "msg");
		$r = $db -> Execute("UPDATE ".$_conf['prefix']."forum_msg SET mfile='' WHERE idm=".mysql_real_escape_string($_REQUEST['m']));
	}else{
		$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_theme WHERE idt=".mysql_real_escape_string($_REQUEST['t']));
		$t = $r -> GetRowAssoc(false);
		DeleteAttachFolder($t['tfile'], "theme");
		$r = $db -> Execute("UPDATE ".$_conf['prefix']."forum_theme SET tfile='' WHERE idt=".mysql_real_escape_string($_REQUEST['t']));
	}
	$smarty -> assign("infmsg", msg_box($lang_ar['forum_attachdel']));
}

/**
* Добавление нового сообщения к теме
*/
if(isset($_REQUEST['fact']) && $_REQUEST['fact']=="addMsg" && isset($_SESSION['USER_IDU']) && !isset($_REQUEST['preview'])){
	$er = 0; $infer = "";
	if(trim($_REQUEST['mtext'])==""){
		$infer .= msg_box($lang_ar['forum_er1']); $er = 1;
	}
	if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=""){
		include("include/uploader.php");
		$upl = new uploader;
		$d1 = "files/forum"; $d2 = "/".$_REQUEST['f']; $d3 = "/".$_REQUEST['t']; $d4 = "/".$_REQUEST['folder'];
		if(!is_dir($d1)) $upl -> MakeDir($d1);
		if(!is_dir($d1.$d2)) $upl -> MakeDir($d1.$d2);
		if(!is_dir($d1.$d2.$d3)) $upl -> MakeDir($d1.$d2.$d3);
		if(!is_dir($d1.$d2.$d3.$d4)) $upl -> MakeDir($d1.$d2.$d3.$d4);
		$filename = transurl($_FILES['file']['name']);
		$cres = $upl -> CheckFile($_FILES['file'], $d1.$d2.$d3.$d4."/".$filename);
		if($cres!=1){
			$infer .= msg_box($cres); $er = 1;
		}else{
			$mres = $upl -> MoveFile($_FILES['file']['tmp_name'], $d1.$d2.$d3.$d4."/".$filename);
			if($mres != 1){
				$infer .= msg_box($mres); $er = 1;
			}else{
				$file = $d1.$d2.$d3.$d4."/".$filename;
			}
		}
	}elseif($_REQUEST['pfile']!=""){
		$file = stripslashes($_REQUEST['pfile']);
	}else{
		$file = "";
	}
	if($er == 0){
		$r = $db -> Execute("INSERT INTO ".$_conf['prefix']."forum_msg(idf, idt, mtext, mavtor, mdate, mfile)VALUES
		(".mysql_real_escape_string($_REQUEST['f']).", ".mysql_real_escape_string($_REQUEST['t']).", 
		'".mysql_real_escape_string(stripslashes($_REQUEST['mtext']))."', 
		".$_SESSION['USER_IDU'].", ".time().", '".mysql_real_escape_string($file)."')");
		if(isset($_REQUEST['alert']) && $_REQUEST['alert']=="1"){
			UpdateAlert($_REQUEST['t']);
		}
		SendAlert($_REQUEST['t'], $_REQUEST['mtext']);
		$smarty -> assign("infmsg", msg_box($lang_ar['forum_ok2']));
		unset($_REQUEST['mtext']);
	}else{
		$smarty -> assign("infmsg", $infer);
	}

}
/**
* Вывод основного содержимого страницы
*/
			$interval = 20;
			if(!isset($_REQUEST['start'])) $start=0;
			else $start=$_REQUEST['start'];
$user_idu = isset($_SESSION['USER_IDU']) ? $_SESSION['USER_IDU'] : -1;
  $q = "SELECT *  FROM ".$_conf['prefix']."forum WHERE idf=".mysql_real_escape_string($_REQUEST['f'])." AND ((ftype='o' OR ftype='c') OR (ftype='s' AND FIND_IN_SET(".$user_idu.",fuser)))";
  $r = $db -> Execute($q);
  
  if($r -> RecordCount() > 0){
	  
  $s = $r -> GetRowAssoc(false);
	$smarty -> assign("section", stripslashes($s['fname_'.$_SESSION['lang']]));

	if($s['parent_idf']!='0'){
		$rp = $db -> Execute("select * from ".$_conf['prefix']."forum where idf=".$s['parent_idf']);
		$tp = $rp -> GetRowAssoc(false);
		$tp['fname'] = stripslashes($tp['fname_'.$_SESSION['lang']]);
		$smarty -> assign("parent",$tp);
	}

  $q = "SELECT *,
  (select count(*) from ".$_conf['prefix']."forum_msg where mavtor = tavtor) as tavtor_msg,  
  (select count(*) from ".$_conf['prefix']."forum_theme ctheme where ctheme.tavtor = ".$_conf['prefix']."forum_theme.tavtor) as tavtor_msg1  
  FROM ".$_conf['prefix']."forum_theme
  LEFT JOIN ".$_conf['prefix']."users ON ".$_conf['prefix']."forum_theme.tavtor=".$_conf['prefix']."users.idu
   WHERE idt=".mysql_real_escape_string($_REQUEST['t']);
  $r = $db -> Execute($q);
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
				$fapp = "\n".'[url href="'.stripslashes($t['tfile']).'"]'.$pp['basename']."[/url]";
			}else{
				$fapp = '<br /><a href="'.stripslashes($t['tfile']).'">'.$pp['basename'].'</a>';
			}
			$t['ttext'] = $t['ttext'].$fapp;
		}
	}
			if($_conf['forum_editor'] == "bbcode"){
				$bb = new bbcode(stripslashes($t['ttext']));
				$t['ttext'] = $bb->get_html();
			}
	$smarty -> assign("tname", stripslashes($t['tname']));
	$smarty -> assign("ttext", stripslashes($t['ttext']));
		if(date("d.m.Y", $t['tdate']) == date("d.m.Y", time())) $smarty -> assign("tdate", $lang_ar['forum_today_in']." ".date("H:i", $t['tdate']));
		elseif(date("d.m.Y", $t['tdate']) == date("d.m.Y", time()-24*3600)) $smarty -> assign("tdate", $lang_ar['forum_yestoday_in']." ".date("H:i", $t['tdate']));
		else $smarty -> assign("tdate", date("d.m.Y H:i",$t['tdate']));
	$smarty -> assign("tavtor_idu", stripslashes($t['tavtor']));
	$smarty -> assign("tavtor_login", stripslashes($t['login']));
	$smarty -> assign("tavtor_msg", $t['tavtor_msg']+$t['tavtor_msg1']);
	$smarty -> assign("tfile", stripslashes($t['tfile']));
	if(file_exists("files/avatars/".$t['tavtor'].".jpg")) $smarty -> assign("tavtor_avatar","files/avatars/".$t['tavtor'].".jpg");

	$TITLE = $KEYWORDS = stripslashes($t['tname']);
	$DESCRIPTION = strip_tags(stripslashes($t['ttext']));


	
	$ru = $db -> Execute("UPDATE ".$_conf['prefix']."forum_theme SET tview = `tview`+1 WHERE idt=".mysql_real_escape_string($_REQUEST['t']));

	$q1 = "SELECT *, 
  (select count(*) from ".$_conf['prefix']."forum_msg cmsg where cmsg.mavtor = ".$_conf['prefix']."forum_msg.mavtor) as count_mavtor_msg,  
  (select count(*) from ".$_conf['prefix']."forum_theme where ".$_conf['prefix']."forum_theme.tavtor = ".$_conf['prefix']."forum_msg.mavtor) as count_mavtor_msg1 ";
  	$q2 = "SELECT count(*) ";	
  $q = "
   FROM ".$_conf['prefix']."forum_msg
   LEFT JOIN ".$_conf['prefix']."users ON ".$_conf['prefix']."forum_msg.mavtor=".$_conf['prefix']."users.idu
   WHERE idt = ".mysql_real_escape_string($_REQUEST['t'])."
   ORDER BY mdate ASC";
  $r = $db -> Execute($q1.$q." LIMIT ".$start.",".$interval);
  $fs = $r -> GetAll();
  $r1 = $db -> Execute($q2.$q);
  $t1 = $r1 -> GetRowAssoc(false);
  $list_page=GetPaging($t1['count(*)'],$interval,$start,"index.php?p=forum&show=msg&start=%start1%&f=".$_REQUEST['f']."&t=".$_REQUEST['t']);
  $newfs = array();
  $j = 0;
  while(list($k, $v)=each($fs)){
  //print_r($v);
		if(file_exists("files/avatars/".$v['mavtor'].".jpg")) $v['mavtor_avatar'] = "files/avatars/".$v['mavtor'].".jpg";
		$v['mavtor_msg'] = $v['count_mavtor_msg'] + $v['count_mavtor_msg1'];
		if(date("d.m.Y", $v['mdate']) == date("d.m.Y", time())) $v['mdate'] = $lang_ar['forum_today_in']." ".date("H:i", $v['mdate']);
		elseif(date("d.m.Y", $v['mdate']) == date("d.m.Y", time()-24*3600)) $v['mdate'] = $lang_ar['forum_yestoday_in']." ".date("H:i", $v['mdate']);
		else $v['mdate'] = date("d.m.Y H:i",$v['mdate']);
		$v['mtext'] = stripslashes($v['mtext']);
	if($v['mfile']!="" && file_exists(stripslashes($v['mfile']))){
		$pp = pathinfo(stripslashes($v['mfile']));
		if($pp['extension']=="gif" || $pp['extension']=="png" || $pp['extension']=="jpg" || $pp['extension']=="jpeg"){
			if($_conf['forum_editor'] == "bbcode"){
				$fapp = "[img]".stripslashes($v['mfile'])."[/img]\n";
			}else{
				$fapp = '<img src="'.stripslashes($v['mfile']).'" /><br />';
			}
			$v['mtext'] = $fapp.$v['mtext'];
		}else{
			if($_conf['forum_editor'] == "bbcode"){
				//$fapp = "\n[url]".stripslashes($v['mfile'])."[/url]";
				$fapp = "\n".'[url href="'.stripslashes($v['mfile']).'"]'.$pp['basename']."[/url]";
			}else{
				$fapp = '<br /><a href="'.stripslashes($v['mfile']).'">'.$pp['basename'].'</a>';
			}
			$v['mtext'] = $v['mtext'].$fapp;
		}
	}
			if($_conf['forum_editor'] == "bbcode"){
				$bb = new bbcode($v['mtext']);
				$v['mtext'] = $bb->get_html();
			}
		if(isset($_REQUEST['stext'])) $v['mtext'] = highlight_words($v['mtext'], stripslashes($_REQUEST['stext']));
		$newfs[$j] = $v;
		$j++;
  }

	//echo "<pre>";
	//print_r($newfs);
	//echo "</pre>";
	if(isset($_SESSION['USER_IDU'])){
		$mtext = isset($_REQUEST['mtext']) ? stripslashes($_REQUEST['mtext']) : "";
		/**
		* Предварительный просмотр создаваемой темы
		*/
		if(isset($_REQUEST['fact']) && $_REQUEST['fact']=="addMsg" && isset($_SESSION['USER_IDU']) && isset($_REQUEST['preview'])){
		  $q = "select count(*) from ".$_conf['prefix']."forum_msg where mavtor = '".$_SESSION['USER_IDU']."'";
		  $q1 = "select count(*) from ".$_conf['prefix']."forum_theme where tavtor = '".$_SESSION['USER_IDU']."'";
		  $r = $db -> Execute($q);
		  $t = $r -> GetRowAssoc(false);
		  $r1 = $db -> Execute($q1);
		  $t1 = $r1 -> GetRowAssoc(false);
			$smarty -> assign("mdate", "Сегодня в ".date("H:i", time()));
			$smarty -> assign("mavtor_idu", stripslashes($_SESSION['USER_IDU']));
			$smarty -> assign("mavtor_login", stripslashes($_SESSION['USER_LOGIN']));
			$smarty -> assign("mavtor_msg", $t['count(*)']+$t1['count(*)']);
			if(file_exists("files/avatars/".$_SESSION['USER_IDU'].".jpg")) $smarty -> assign("mavtor_avatar","files/avatars/".$_SESSION['USER_IDU'].".jpg");
	if(file_exists("files/avatars/".$_SESSION['USER_IDU'].".jpg")) $smarty -> assign("tavtor_avatar","files/avatars/".$_SESSION['USER_IDU'].".jpg");
	if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=""){
		include("include/uploader.php");
		$upl = new uploader;
		$d1 = "files/forum"; $d2 = "/".$_REQUEST['f']; $d3 = "/".$_REQUEST['folder'];
		if(!is_dir($d1)) $upl -> MakeDir($d1);
		if(!is_dir($d1.$d2)) $upl -> MakeDir($d1.$d2);
		if(!is_dir($d1.$d2.$d3)) $upl -> MakeDir($d1.$d2.$d3);
		$filename = transurl($_FILES['file']['name']);
		$cres = $upl -> CheckFile($_FILES['file'], $d1.$d2.$d3."/".$filename);
		if($cres!=1){
			$infer .= msg_box($cres); $er = 1;
		}else{
			$mres = $upl -> MoveFile($_FILES['file']['tmp_name'], $d1.$d2.$d3."/".$filename);
			if($mres != 1){
				$infer .= msg_box($mres); $er = 1;
				$smarty -> assign("infmsg",$infer);
			}else{
				$file = $d1.$d2.$d3."/".$filename;
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
				$bb = new bbcode($mtext);
				$smarty -> assign("mtext",$bb->get_html());
				$ffapp = new bbcode($fapp);
				$smarty -> assign("fapp",$ffapp->get_html());
				$llapp = new bbcode($lapp);
				$smarty -> assign("lapp",$llapp->get_html());
			}else{
				$smarty -> assign("mtext", $mtext);
				$smarty -> assign("fapp", "");
				$smarty -> assign("lapp", "");
			}
			$smarty -> assign("preview", "preview");
		}
			if(isset($_REQUEST['fact']) && $_REQUEST['fact']=="reply"){
				if(!isset($_REQUEST['m'])){
					$rr = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_theme LEFT JOIN ".$_conf['prefix']."users ON ".$_conf['prefix']."users.idu=".$_conf['prefix']."forum_theme.tavtor WHERE idt=".mysql_real_escape_string($_REQUEST['t']));
					$tt = $rr -> GetRowAssoc(false);
				}else{
					$rr = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_msg LEFT JOIN ".$_conf['prefix']."users ON ".$_conf['prefix']."users.idu=".$_conf['prefix']."forum_msg.mavtor WHERE idm=".mysql_real_escape_string($_REQUEST['m']));
					$tt = $rr -> GetRowAssoc(false);
				}
				if($_conf['forum_editor'] == "bbcode"){
					$mtext = '[b]'.stripslashes($tt['login']).',[/b] ';
				}else{
					$mtext = '<strong>'.stripslashes($tt['login']).',</strong>&nbsp;';
				}
			}
			if(isset($_REQUEST['fact']) && $_REQUEST['fact']=="cit"){
				if(isset($_REQUEST['m'])){
					$rr = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_msg LEFT JOIN ".$_conf['prefix']."users ON ".$_conf['prefix']."users.idu=".$_conf['prefix']."forum_msg.mavtor WHERE idm=".mysql_real_escape_string($_REQUEST['m']));
					$tt = $rr -> GetRowAssoc(false);
					if($_conf['forum_editor'] == "bbcode"){
						$mtext = '[quote="'.$tt['login'].'"]'.stripslashes($tt['mtext']).'[/quote]';
					}else{
						$mtext = 'Цитата '.$tt['login'].':<div class="quote">'.stripslashes($tt['mtext']).'</div>';
					}
				}else{
					$rr = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_theme LEFT JOIN ".$_conf['prefix']."users ON ".$_conf['prefix']."users.idu=".$_conf['prefix']."forum_theme.tavtor WHERE idt=".mysql_real_escape_string($_REQUEST['t']));
					$tt = $rr -> GetRowAssoc(false);
					if($_conf['forum_editor'] == "bbcode"){
						$mtext = '[quote="'.$tt['login'].'"]'.stripslashes($tt['ttext']).'[/quote]';
					}else{
						$mtext = 'Цитата '.$tt['login'].':<div class="quote">'.stripslashes($tt['ttext']).'</div>';
					}
				}
			}
			if($_conf['forum_editor'] == "fckeditor"){
				include($_conf['disk_patch']."include/FCKeditor/fckeditor.php") ;
				$oFCKeditor = new FCKeditor('mtext') ;
				$oFCKeditor->ToolbarSet = 'Forum' ;
				$sBasePath = $_conf['www_patch']."/include/FCKeditor/" ;
				$oFCKeditor->Width  = '90%';
				$oFCKeditor->Height = '300';
				$oFCKeditor_ua->Config['EditorAreaCSS'] = $_conf['www_patch']."/".$_conf['tpl_dir']."css/style.css" ;
				$oFCKeditor->Value = $mtext;
				$FORMAREA = $oFCKeditor->Create() ;
				$smarty -> assign("FORMAREA",$FORMAREA);
			}else{
				$smarty -> assign("FORMAREA",$mtext);
			}
	}
			isset($_REQUEST['alert']) ? $smarty -> assign("alert", 'checked="checked"') : $smarty -> assign("alert", '');
			$smarty -> assign("start",$start);
			$smarty -> assign("paging",$list_page);
			$smarty -> assign("listpage",$smarty -> fetch("db:paging.tpl"));

if(isset($_REQUEST['folder'])) $smarty -> assign("folder",$_REQUEST['folder']);
else $smarty -> assign("folder",time());
	
if(!isset($file)) $smarty -> assign("pfile", "");
$smarty -> assign("f", $newfs);
$smarty -> assign("idf", $_REQUEST['f']);
$smarty -> assign("idt", $_REQUEST['t']);
	if($s['ftype']=="o" || (($s['ftype']=="c" || $s['ftype']=="s") && in_array($_SESSION['USER_IDU'],explode(",",$s['fuser'])))){
		$smarty -> assign("showform","showform");
	}
}
//$smarty -> assign("sel", $select);
$PAGE = $smarty -> fetch("forum/forum_msg.tpl");

?>