<?php
//SelectLimit($sql,$numrows=-1,$offset=-1,$inputarr=false)
$akcii=array();
$ms = $db->SelectLimit("SELECT * FROM ".$_conf['prefix']."akcii ORDER BY date DESC",$_conf['a_count']);
if($ms -> RecordCount()>0){
while (!$ms->EOF) { 
	$tmpm = $ms->GetRowAssoc(false);
	if(file_exists($tmpm['aphoto'])) $photo = stripslashes($tmpm['aphoto']);
	else $photo = "no";
	$akcii[]=array(
		'id'=>$tmpm['id'],
		'date'=>$tmpm['date'],
		'title'=>htmlentities(stripslashes($tmpm['title_'.$_SESSION['lang']]),ENT_QUOTES, $_conf['encoding']),
		'anons'=>stripslashes($tmpm['anons_'.$_SESSION['lang']]),
		'text'=>stripslashes($tmpm['text_'.$_SESSION['lang']]),
		'photo'=>stripslashes($photo)
	);
	$ms->MoveNext(); 
}
	$smarty->assign("akcii",$akcii);
	$block_akcii = $smarty->fetch("akcii/block_akcii.tpl");

} else $block_akcii = '';
?>