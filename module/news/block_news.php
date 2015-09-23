<?php
//SelectLimit($sql,$numrows=-1,$offset=-1,$inputarr=false)
$rss_array=array();
$rss_items=0;
$ms = $db->SelectLimit("SELECT * FROM ".$_conf['prefix']."news_".$_SESSION['lang']." ORDER BY date DESC",$_conf['news_count']);
if($ms -> RecordCount()>0){
while (!$ms->EOF) { 
	$tmpm=$ms->GetRowAssoc();
	if(file_exists("files/newsanons/".$tmpm['IDN'].".jpg")) $photo = "files/newsanons/".$tmpm['IDN'].".jpg";
	else $photo = "no";
	$rss_array[$rss_items]=array(
		'IDN'=>$tmpm['IDN'],
		'DATE'=>$tmpm['DATE'],
		'NTITLE'=>htmlentities(stripslashes($tmpm['NTITLE']),ENT_QUOTES, $_conf['encoding']),
		'NANONS'=>stripslashes($tmpm['NANONS']),
		'NTEXT'=>stripslashes($tmpm['NTEXT']),
		'PHOTO'=>stripslashes($photo),
		'NLINK'=>stripslashes($tmpm['NLINK'])
	);
	$rss_items++;
	$ms->MoveNext(); 
}


	$smarty->assign("rss",$rss_array);
	$block_news = $smarty->fetch("news/block_news.tpl");

	if($_conf['news_calendar']=="y"){
	$HEADER .= '
		<link type="text/css" href="'.$_conf['www_patch'].'/js/jquery/themes/base/jquery.ui.all.css" rel="stylesheet" />
		<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/ui/minified/jquery.ui.datepicker.min.js"></script>
		<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/ui/i18n/jquery.ui.datepicker-ru.js"></script>
	<script>
	$(function() {
		$("#newsdate").datepicker({
			dateFormat: "yy-mm-dd",
			changeMonth: true,
			changeYear: true,
			onSelect: function(dateText, inst){ window.location="'.$_conf['www_patch'].'/news/date/"+dateText; }
		});
		$("#newsdate").datepicker($.datepicker.regional["ru"]);
	});
	</script>
	';
	}
} else $block_news = '';
?>