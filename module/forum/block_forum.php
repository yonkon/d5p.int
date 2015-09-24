<?php
//SelectLimit($sql,$numrows=-1,$offset=-1,$inputarr=false)
$f_array=array();
$f_items=0;
$ms1 = $db -> SelectLimit("
SELECT max(mdate) as maxdate FROM ".$_conf['prefix']."forum_msg 
LEFT JOIN ".$_conf['prefix']."forum_theme USING(idt) 
GROUP BY ".$_conf['prefix']."forum_msg.idt 
ORDER BY maxdate DESC
", 5);
if($ms1 -> RecordCount()>0){
while (!$ms1->EOF) { 
	$t1 = $ms1 -> GetRowAssoc(false);
	$ms = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum_msg 
	LEFT JOIN ".$_conf['prefix']."forum_theme USING(idt) 
	WHERE mdate='".$t1['maxdate']."'
	");
	$t = $ms -> GetRowAssoc(false);
	
	$f_array[$f_items]=array(
		'T'=>$t['idt'],
		'F'=>$t['idf'],
		'TNAME'=>htmlentities(stripslashes($t['tname']),ENT_QUOTES, $_conf['encoding']),
		'MDATE'=>$t['mdate'],
	);
	$f_items++;
	$ms1->MoveNext(); 
}


$smarty->assign("f",$f_array);

$block_forum = $smarty->fetch("forum/block_forum.tpl");
} else $block_forum = '';
?>