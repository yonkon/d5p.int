<?php
/**
 * Вывод блогов сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2011
 * @link http://shiftcms.net
 * @version 1.00
 */
if(isset($_REQUEST['b_act']) && $_REQUEST['b_act']=="delBlog" && $_SESSION['USER_GROUP']=="super"){
	$r = $db -> Execute("select * from ".$_conf['prefix']."page_gal where photo_type='blog' AND type_id='".mysql_real_escape_string(stripslashes($_REQUEST['b_id']))."'");
	while(!$r->EOF){
		$t = $r -> GetRowAssoc(false);
		DelPagePhoto($t['photo_id']);
		$r -> MoveNext();
	}
	$r = $db -> Execute("delete from ".$_conf['prefix']."blog where b_id='".mysql_real_escape_string(stripslashes($_REQUEST['b_id']))."'");
	$smarty -> assign("outmsg","deleted");
}

if(isset($_REQUEST['b_link'])){
	$q = "select SQL_CALC_FOUND_ROWS * from ".$_conf['prefix']."blog 
	left join ".$_conf['prefix']."blog_rub using(b_rub)
	left join ".$_conf['prefix']."users on ".$_conf['prefix']."users.idu=".$_conf['prefix']."blog.b_idu
	where b_link='".mysql_real_escape_string(stripslashes($_REQUEST['b_link']))."'";
	$r = $db -> Execute($q);
	if($r -> RecordCount() == 0){
		$smarty -> assign("outblogs", "blognotfound");
		$PAGE = $smarty->fetch("blog/blog.tpl");
	}else{
		$t = $r -> GetRowAssoc(false);
		$blogs = array(
			'b_id'=>$t['b_id'],
			'b_link'=>stripslashes($t['b_link']),
			'b_rub'=>stripslashes($t['b_rubname_'.$_SESSION['lang']]),
			'b_idu'=>$t['b_idu'],
			'b_login'=>$t['login'],
			'b_date'=>$t['b_date'],
			'b_key'=>stripslashes($t['b_key']),
			'b_title'=>stripslashes($t['b_title']),
			'b_text'=>parseContent(stripslashes($t['b_text']), "blog", $t['b_id']),
			'u_avatar'=>file_exists("files/avatars/".$t['idu'].".jpg") ? "files/avatars/".$t['idu'].".jpg" : '',
			'u_login'=>stripslashes($t['login'])
		);
		$smarty -> assign("item", $blogs);
		$smarty -> assign("outblogs", "single");
		$PAGE = $smarty->fetch("blog/blog.tpl");

		$b_text_wr = wordwrap(stripslashes($t['b_title']), 400, '|||||');
		$b_text_ar = explode("|||||",$b_text_wr);
		
		$KEYWORDS = stripslashes($t['b_key']);
		$TITLE = stripslashes($t['b_title']);
		$DESCRIPTION = htmlspecialchars($b_text_ar[0]);
	}
}else{
	$interval = 10;
	$start = isset($_REQUEST['start']) ? (int)$_REQUEST['start'] : 0;
	if($start < 0) $start = 0;
	$addpar = '';
	$addq = '';
	if(isset($_REQUEST['act']) && $_REQUEST['act']=="myblog"){
		$addpar .= '&act=myblog';
		$addq .= " WHERE b_idu='".$_SESSION['USER_IDU']."' ";
	}
	$q = "select SQL_CALC_FOUND_ROWS * from ".$_conf['prefix']."blog 
	left join ".$_conf['prefix']."blog_rub using(b_rub)
	left join ".$_conf['prefix']."users on ".$_conf['prefix']."users.idu=".$_conf['prefix']."blog.b_idu
	".$addq."
	order by b_date desc limit ".$start.", ".$interval;
	$r = $db -> Execute($q);
	$r1 = $db -> Execute("select found_rows()");
	$t1 = $r1 -> GetRowAssoc(false);
	if($t1['found_rows()']>$interval){
		$list_page = GetPaging($t1['found_rows()'],$interval,$start,$_conf['www_patch']."/?p=blog&start=%start1%".$addpar);
		$smarty -> assign("paging",$list_page);
		$smarty -> assign("list_page",$smarty -> fetch("db:paging.tpl"));
	}
	$blogs = array();
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		$b_text_wr = wordwrap(stripslashes($t['b_text']), 800, '|||||');
		$b_text_ar = explode("|||||",$b_text_wr);
		$blogs[] = array(
			'b_id'=>$t['b_id'],
			'b_link'=>stripslashes($t['b_link']),
			'b_rub'=>stripslashes($t['b_rubname_'.$_SESSION['lang']]),
			'b_idu'=>$t['b_idu'],
			'b_login'=>$t['login'],
			'b_date'=>$t['b_date'],
			'b_key'=>stripslashes($t['b_key']),
			'b_title'=>stripslashes($t['b_title']),
			'b_text'=>parseContent($b_text_ar[0], "blog", $t['b_id'])
		);
		$r -> MoveNext();
	}
	$smarty -> assign("blogs", $blogs);
	$smarty -> assign("outblogs", "list");
	$PAGE = $smarty->fetch("blog/blog.tpl");
}
?>