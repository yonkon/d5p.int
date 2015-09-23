<?php
/**
 * Вывод истории пользователя
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00.01
 */
if(!defined("SHIFTCMS")) exit;

$ui= GetUserName($_REQUEST['idu']);

echo "<h2>".sprintf($alang_ar['ah_title'], $ui['FIO'], $ui['LOGIN'], $_REQUEST['idu'])."</h2>";

	$interval = 200;
	if(!isset($_REQUEST['start'])) $start=0;
	else $start=$_REQUEST['start'];

	$qn1="SELECT * FROM ".$_conf['prefix']."enterlog WHERE idu='".$_REQUEST['idu']."' ORDER BY date DESC ";
	$qn=$qn1." LIMIT $start,$interval";

	$ms = $db -> Execute($qn);

	echo "<br /><table border=0 cellspacing='1' cellpadding='1' class='selrow'><thead>
	<tr><th>".$alang_ar['ah_date']."</th><th style='padding-left:10px;'>".$alang_ar['ah_act']."</th><th style='padding-left:10px;'>IP</th>
	<!--
	<th style='padding-left:10px;'>".$alang_ar['ah_country']."</th>
	<th style='padding-left:10px;'>".$alang_ar['ah_region']."</th>
	<th style='padding-left:10px;'>".$alang_ar['ah_city']."</th>
	-->
	</tr></thead><tbody>";
	
	$i = 1;
	while (!$ms -> EOF) { 
		$tmp = $ms -> GetRowAssoc();
    		echo "<tr>
            <td>".date("d.m.Y H:i",$tmp['DATE'])."</td>
            <td style='padding-left:10px;'>".$tmp['ACTION']."</td>
            <td style='padding-left:10px;'>".$tmp['IP']."</td>
			<!--
            <td style='padding-left:10px;'>$tmp[COUNTRY]</td>
            <td style='padding-left:10px;'>$tmp[REGION]</td>
            <td style='padding-left:10px;'>$tmp[CITY]</td>
			-->
            </tr>";
		$ms -> MoveNext(); 
		$i++;
	}
	echo "</tbody></table>";

?>
