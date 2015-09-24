<?

$gb = array();
$interval = $_conf['gb_inblock'];

$qn="SELECT * FROM ".$_conf['prefix']."guestbook WHERE g_show='y' ORDER BY g_date DESC LIMIT 0,$interval";

$ms = $db->Execute($qn);

	while (!$ms->EOF) { 
		$t = $ms->GetRowAssoc(false);
		$gb[]=array(
			'g_idn'=>$t['g_id'],
			'g_date'=>$t['g_date'],
			'g_who'=>htmlspecialchars(stripslashes($t['g_who'])),
			'g_text'=>htmlspecialchars(stripslashes($t['g_text']))
		);
		$ms->MoveNext(); 
	}
$smarty->assign("gb",$gb);

$gb_block = $smarty->fetch("guestbook/gb_block.tpl");

?>