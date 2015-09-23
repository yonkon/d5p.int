<?php
/**
 * Скрипт для просмотра лог-файлов
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.01
 */
if(!defined("SHIFTCMS")) exit;

$smarty -> assign("PAGETITLE","<h2>".$alang_ar['alog_title']."</h2>");

$dir = "tmp/log";

// Открыть заведомо существующий каталог и начать считывать его содержимое
echo "<div class='block'>";
echo "== ";
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
			if($file!="." && $file!=".." && is_file($dir."/".$file)){
            	echo "<a href='admin.php?p=$p&act=open&file=$file'>$file</a> == ";
			}
        }
        closedir($dh);
    }
}
echo "</div><br />";

if(isset($_REQUEST['act']) && $_REQUEST['act']=="open"){
	if(isset($_REQUEST['file']) && file_exists($dir."/".$_REQUEST['file'])){
		$data = file($dir."/".$_REQUEST['file']);
		//$data = array_reverse($data);
		$log = '';
		while(list($key,$val)=each($data)){
			$log .= $val;
		}
		echo '<textarea id="logCont" name="logCont" style="width:100%;height:100%">'.$log.'</textarea>';
		echo '
			<script type="text/javascript">
				var bh = $("body").height();
				var ch = bh-160;
				document.getElementById("logCont").style.height = ch+"px";
			</script>
		';
	}else{
		echo "<strong>".sprintf($alang_ar['alog_msg1'], $_REQUEST['file'])."</strong>";
	}
}

?>