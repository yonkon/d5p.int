<?php
/**
 * Написание и редактирование блогов
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2011
 * @link http://shiftcms.net
 * @version 1.00
 */
error_reporting(E_ALL);
if(isset($_REQUEST['b_act']) && $_REQUEST['b_act']=="saveBlog" && isset($_SESSION['USER_IDU'])){
	$q = "select * from ".$_conf['prefix']."blog 
	left join ".$_conf['prefix']."blog_rub using(b_rub)
	where b_id='".mysql_real_escape_string(stripslashes($_REQUEST['b_id']))."'";
	$r = $db -> Execute($q);
	if($_REQUEST['b_q']=='old' && $r->RecordCount()==0) exit;
	$t = $r -> GetRowAssoc(false);
	if($t['b_idu']!=$_SESSION['USER_IDU'] && $_SESSION['USER_GROUP']!="super") exit;
	$b_link = strtolower(transurl(stripslashes($_REQUEST['b_title'])));
	$b_title = strip_tags(stripslashes($_REQUEST['b_title']));
	$b_key = strip_tags(stripslashes($_REQUEST['b_key']));
	$b_text = strip_tags(stripslashes($_REQUEST['b_text']),'<p><b><strong><i><em><li><ol><ul><font><span><br><sup><sub>');
	if($_REQUEST['b_q']=='new'){
		$q = "insert into `".$_conf['prefix']."blog` set
		`b_id`='".mysql_real_escape_string($_REQUEST['b_id'])."',
		`b_link`='".mysql_real_escape_string($b_link)."',
		`b_rub`='',
		`b_idu`='".$_SESSION['USER_IDU']."',
		`b_date`='".time()."',
		`b_key`='".mysql_real_escape_string($b_key)."',
		`b_title`='".mysql_real_escape_string($b_title)."',
		`b_text`='".mysql_real_escape_string($b_text)."'
		";
	}else{
		$q = "update `".$_conf['prefix']."blog` set
		`b_link`='".mysql_real_escape_string($b_link)."',
		`b_rub`='',
		`b_key`='".mysql_real_escape_string($b_key)."',
		`b_title`='".mysql_real_escape_string($b_title)."',
		`b_text`='".mysql_real_escape_string($b_text)."'
		where `b_id`='".mysql_real_escape_string(stripslashes($_REQUEST['b_id']))."'
		";
	}
	$r = $db -> Execute($q);
	if($_REQUEST['b_id']==0){
		header("location:".$_conf['www_patch']."/blog/");
		exit;		
	}
	$smarty -> assign("outmsg","saved");
}

if(isset($_REQUEST['b_id'])){
	$q = "select SQL_CALC_FOUND_ROWS * from ".$_conf['prefix']."blog 
	left join ".$_conf['prefix']."blog_rub using(b_rub)
	where b_id='".mysql_real_escape_string(stripslashes($_REQUEST['b_id']))."'";
	$r = $db -> Execute($q);
	$t = $r -> GetRowAssoc(false);
	if($r -> RecordCount() == 0){
		$smarty -> assign("outblogs", "blognotfound");
		$PAGE = $smarty->fetch("blog/blog.tpl");
	}elseif($t['b_idu']!=$_SESSION['USER_IDU'] && $_SESSION['USER_GROUP']!="super"){
		$smarty -> assign("outblogs", "blognotfound");
		$PAGE = $smarty->fetch("blog/blog.tpl");
	}else{
		$blog = array(
			'b_id'=>$t['b_id'],
			'b_link'=>stripslashes($t['b_link']),
			'b_rub'=>$t['b_rub'],
			'b_rubname'=>stripslashes($t['b_rubname_'.$_SESSION['lang']]),
			'b_idu'=>$t['b_idu'],
			'b_date'=>$t['b_date'],
			'b_key'=>htmlspecialchars(stripslashes($t['b_key'])),
			'b_title'=>htmlspecialchars(stripslashes($t['b_title'])),
			'b_text'=>stripslashes($t['b_text']),
			'b_q'=>'old'
		);
		$photos = GetUserPagePhotoList("blog", $t['b_id']);
		$videos = GetUserPageVideoList("blog", $t['b_id']);
		$smarty -> assign("videos", $videos);
		$smarty -> assign("photos", $photos);
		$smarty -> assign("blog", $blog);
		$smarty -> assign("outblogs", "writeform");
		$PAGE = $smarty->fetch("blog/writeblog.tpl");
	}
}else{
		$blog = array(
			'b_id'=>time(),
			'b_link'=>'',
			'b_rub'=>0,
			'b_rubname'=>'',
			'b_idu'=>$_SESSION['USER_IDU'],
			'b_date'=>0,
			'b_key'=>'',
			'b_title'=>'',
			'b_text'=>'',
			'b_q'=>'new'
		);
	
		$smarty -> assign("videos", array());
		$smarty -> assign("photos", array());
		$smarty -> assign("blog", $blog);
		$smarty -> assign("outblogs", "writeform");
		$PAGE = $smarty->fetch("blog/writeblog.tpl");
}
?>