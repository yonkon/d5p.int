<?php
/**
 * Просмотр базы данных и выполнение запросов к базе, архивирование и восстановление
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2011
 * @link http://shiftcms.net
 * @version 1.00.02
 */
if(!defined("SHIFTCMS")) exit;

$smarty -> assign("PAGETITLE","<h2>".$alang_ar['asql_title']."</h2>");

//*************************************************************************
printf ("MySQL server version: %s", mysql_get_server_info());
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
printf ("MySQL client info: %s", mysql_get_client_info());
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
printf ("MySQL host info: %s\n", mysql_get_host_info());

echo "<br /><br />
<div id='SQLRes' style='border:solid 1px #cccccc; background:#eeeeee;padding:3px;'></div>
<table border=0>
<tr>
<td>".$alang_ar['asql_query']."</td>
<td>".$alang_ar['asql_tables']."</td>
<td>".$alang_ar['asql_struct']."</td>
</tr>
<tr><td valign=\"top\">
<div id='SQLFormArea' style='width:340px;height:500px;border:solid 1px #cccccc;'>
<form action='javascript:void(null)' id='SQLForm' method='post' enctype='multipart/form-data'>
 <input type='hidden' name='p' value='admin_server'>
 <input type='hidden' name='act' value='SendSQL'>
<textarea name='sql' style='width:330px;height:450px;'></textarea><br>
<input type=submit name=send value='".$alang_ar['send']."' onclick=\"doLoad('SQLForm','SQLRes')\">
</form>
</div>
</td>";

echo "</td><td>";	

	require "include/config/set.inc.php";
	$q = "SHOW TABLES FROM `$base`";
	$result = mysql_query($q);
	
    if (!$result) {
        print "DB Error, could not list tables<br>";
        print 'MySQL Error: ' . mysql_error();
        exit;
    }
	echo "<div id='DBTableList' style='width:150px;height:500px;border:solid 1px #cccccc; overflow-y:scroll;'>";
    while ($row = mysql_fetch_row($result)) {
		print "<a href='javascript:void(null)' onclick=\"getdata('','get','?p=admin_server&act=ShowDBTableInfo&tb=$row[0]','DBTableInfo')\">$row[0]</a><br>";
    }
	echo "</div>";
	
    mysql_free_result($result);

echo "</td><td valign=top>";

echo "<div id='DBTableInfo' style='width:400px;height:500px;border:solid 1px #cccccc;overflow:scroll;'></div>";

echo "</td></tr></table>";


echo "<div class='block'>
<h3>".$alang_ar['asql_status']."</h3>";
$status = explode('  ', mysql_stat());
while(list($k, $v)=each($status)){
	echo $v."<br />";
}
echo "</div>";

echo "<div class='block'>
<h3>".$alang_ar['asql_process']."</h3><table border='0' class='selrow' cellspacing='0'>";
$result = mysql_list_processes();
while ($row = mysql_fetch_assoc($result)){
    echo "<tr><td>", $row["Id"], "</td><td>", $row["User"], "</td><td>", $row["Host"], "</td><td>", $row["db"], "</td><td>",
       $row["Command"], "</td><td>", $row["Time"], "</td><td>", $row["State"], "</td><td>", $row["Info"], "</td></tr>";
}
mysql_free_result ($result);
echo "</table></div><br />";

/* форма для создания дампа базы и список дампов для скачивания */
$sqldir = 'tmp/sql';
if(!is_dir($sqldir)){
	include("include/uploader.php");
	$upl = new uploader;
	$upl -> MakeDir($sqldir);
	$fp = fopen($sqldir.'/.htaccess',"w");
	fwrite($fp,'deny from all');
	fclose($fp);
}
include("admin/system/admin_server.php");
$fileout = getDBdumpFile($sqldir);
echo '<div class="block"><a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=admin_server&act=makeDBdump\',\'DBDUMPLIST\')"><strong>Создать дамп базы</strong></a><br /><br /><div id="DBDUMPLIST">'.$fileout.'</div></div>';

?>
