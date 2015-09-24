<?php
/**
 * Вывод информации о системе
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.01
 */
if(!defined("SHIFTCMS")) exit;

$smarty -> assign("PAGETITLE","<h2>".$alang_ar['asi_title']."</h2>");
ob_start();
	phpinfo();
	$contents = ob_get_contents();
ob_end_clean();
	$contents = str_replace("'",'"',$contents);
	$contents = str_replace("\n",'',$contents);

echo '<iframe id="IPHPI" name="IPHPI" style="width:100%" onload="changeStyle()" frameborder="0"></iframe>';

		echo '
			<script type="text/javascript">
				var bh = $("body").height();
				var ch = bh-120;
				document.getElementById("IPHPI").style.height = ch+"px";
			</script>
		';
echo '
<script type="text/javascript">
function changeStyle(){
	var x=document.getElementById("IPHPI");
	var y=(x.contentWindow || x.contentDocument);
	if (y.document)y=y.document;
	y.body.innerHTML = \''.$contents.'\';
}
</script>
';
?>