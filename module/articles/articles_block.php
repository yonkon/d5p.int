<?php
//SelectLimit($sql,$numrows=-1,$offset=-1,$inputarr=false)
$rb_array=array();
$rb_items=0;
$r = $db -> SelectLimit("SELECT * FROM ".$_conf['prefix']."articles ORDER BY r_dadd DESC",5);
if($r -> RecordCount()>0){
while(!$r->EOF) { 
	$t = $r -> GetRowAssoc(false);
	$rb_array[$rb_items]=array(
		'r_id'=>$t['r_id'],
		'r_dadd'=>$t['r_dadd'],
		'r_title'=>stripslashes($t['r_title']),
		'r_avtor'=>stripslashes($t['r_avtor']),
		'r_abstract'=>stripslashes($t['r_abstract']),
	);
	$rb_items++;
	$r->MoveNext(); 
}


$smarty->assign("rb",$rb_array);

$articles_block = $smarty->fetch("articles/articles_block.tpl");
} else $articles_block = '';
?>