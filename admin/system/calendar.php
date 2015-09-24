<?php
/**
* Календарь для пользователей системы
* @package ShiftCMS
* @version 1.00 06.05.2009
* @author Volodymyr Demchuk
* @link http://shiftcms.net
* Дополнительный файл: admin/cron/calendar_alert.php для выполнения через cron
*/

if((isset($_REQUEST['act']) && !isset($_SERVER['HTTP_REFERER'])) || !defined('SHIFTCMS')){
	exit;
}
define('smsalert', false);

/**
* Устанавливаем тип (период) вывода записей в календаре
*/
if(!isset($_SESSION['calendarOutType']) && !isset($_REQUEST['type'])) $_SESSION['calendarOutType'] = "DAY";
if(isset($_REQUEST['type'])) $_SESSION['calendarOutType'] = $_REQUEST['type'];
/**
* Загрузка основного содержимого календаря
*/
if(!isset($_REQUEST['act'])){
	echo "<table border='0' cellspacing='0' width='100%'><tr><td valign='top' width='200'>";
	echo CreateCalendar();
	echo "<p style='color:#666666; padding:10px; font-size:10px;'>Чтобы добавить запись - <br />щелкните дважды по нужной ячейке.</p>";
	echo OutLastTask();
	echo "</td><td valign='top' width='5'>";
	echo "&nbsp;";
	echo "</td><td valign='top'>";
	echo calendarOutContent();
	echo "</td></tr></table>";
}

/**
* Загрузка данных календаря на выбранный день
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="LoadAlert"){
	echo "<table border='0' cellspacing='0' width='100%'><tr><td valign='top' width='200'>";
	echo CreateCalendar($_REQUEST['month'], $_REQUEST['year']);
	echo "<p style='color:#666666; padding:10px; font-size:10px;'>Чтобы добавить запись - <br />щелкните дважды по нужной ячейке.</p>";
	echo OutLastTask();
	echo "</td><td valign='top' width='5'>";
	echo "&nbsp;";
	echo "</td><td valign='top'>";
	echo calendarOutContent($_REQUEST['day'], $_REQUEST['week'], $_REQUEST['month'], $_REQUEST['year']);
	echo "</td></tr></table>";
	unset($_REQUEST['act']);
}

/**
* Вывод формы добавления новой записи
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="AddRecordForm"){
	echo AddRecordForm($_REQUEST['retdiv'], $_REQUEST['start'], $_REQUEST['end']);
	unset($_REQUEST['act']);
}

/**
* Вывод формы редактирования записи
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="OutRecordInfo"){
	echo OutRecordInfo($_REQUEST['retdiv'], $_REQUEST['idc'], $_REQUEST['start'], $_REQUEST['end']);
	unset($_REQUEST['act']);
}

/**
* Вывод записи для просмотра
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="ShowRecordInfo"){
	echo ShowRecordInfo($_REQUEST['idc']);
	unset($_REQUEST['act']);
}

/**
* Сохранение новой запсии
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="SaveNewRecord"){
	echo SaveNewRecord($_REQUEST);
	unset($_REQUEST['act']);
}

/**
* Сохранение существующей запсии
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="SaveRecord"){
	echo SaveRecord($_REQUEST);
	unset($_REQUEST['act']);
}

/**
* Удаление запсии
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="DeleteRecord"){
	echo DeleteRecord($_REQUEST);
	unset($_REQUEST['act']);
}

/**
* Загрузка календаря
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="LoadCalendar"){
	echo CreateCalendar($_REQUEST['month'], $_REQUEST['year']);
	unset($_REQUEST['act']);
}

/**
* Загрузка данных календаря на выбранный день
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="LoadContent"){
	echo calendarOutContent($_REQUEST['day'], $_REQUEST['week'], $_REQUEST['month'], $_REQUEST['year']);
	unset($_REQUEST['act']);
}


/**
* Функция для создания календаря на месяц
* @param $month месяц
* @param $year год
*/
function CreateCalendar($month = 0, $year = 0){
	global $_conf;
	$out = "";
	$current_year = date("Y",time());
	$current_month = date("n",time());
	$current_day = date("j",time());
	
	if($month == 0) $month = date("n", time());
	if($year == 0) $year = date("Y", time());
	$start_month = strtotime("01.".$month.".".$year)+3600;
	$first_week_day = date("w",$start_month);
	if($first_week_day == 0) $first_week_day = 7;
	$day_in_month = date("t",$start_month);

	if($month==1) {$p_month = 12; $p_year = $year - 1; }
	else { $p_month = $month - 1; $p_year = $year; }
	$p_day_in_month = date("t", strtotime("01.".$p_month.".".$p_year)+3600);
	if($month==12) {$n_month = 1; $n_year = $year + 1; }
	else { $n_month = $month + 1; $n_year = $year; }
	
	if($current_year == $year && $current_month == $month) $sel_day = $current_day;
	else $sel_day = -1;
	
	$start_w = 0;
	$out .= "<div id='CALENDAR'>";
	$out .= "<table border='0' cellspacing='0' class='cld'>";
	$out .= "<tr><td colspan='7' style='text-align:center;font-weight:bold;'>";
	$out .= "<a href='javascript:void(null)' onclick=\"getdata('','post','?p=calendar&act=LoadCalendar&month=$p_month&year=$p_year','CALENDAR'); getdata('','post','?p=calendar&act=LoadContent&day=$current_day&week=$p_week&month=$p_month&year=$p_year','CalendarContent');\">&laquo;&laquo;</a>";
	$out .= "&nbsp;&nbsp;".$_conf['month_list'][$month]." ".$year."&nbsp;&nbsp;";
	$out .= "<a href='javascript:void(null)' onclick=\"getdata('','post','?p=calendar&act=LoadCalendar&month=$n_month&year=$n_year','CALENDAR'); getdata('','post','?p=calendar&act=LoadContent&day=$current_day&week=$n_week&month=$n_month&year=$n_year','CalendarContent');\">&raquo;&raquo;</a>";
	$out .= "</td></tr>";
	$out .= "<tr><th>ПН</th><th>ВТ</th><th>СР</th><th>ЧТ</th><th>ПТ</th><th>СБ</th><th>ВС</th></tr>";
	$out .= "<tr>";
	for($i = 1; $i <= $first_week_day-1; $i++){
		$start_w++;
		$pd = $p_day_in_month - $first_week_day + $i + 1;
		$p_week = date("w", strtotime($pd.".".$p_month.".".$p_year));
			if($p_week == 0) $p_week = 7;
		$out .= "<td><a href='javascript:void(null)' onclick=\"getdata('','post','?p=calendar&act=LoadContent&day=$pd&week=$p_week&month=$p_month&year=$p_year','CalendarContent');\" class='hid'>".$pd."</a></td>";
	}
		if($start_w == 7){
			$out .= "</tr>";
			$start_w = 0;
		}
	for($i = 1; $i <= $day_in_month; $i++){
		$week = date("w", strtotime($i.".".$month.".".$year));
			if($week == 0) $week = 7;
		if($start_w == 0) $out .= "<tr>";
		$start_w++;
		$out .= "<td><a href='javascript:void(null)' onclick=\"getdata('','post','?p=calendar&act=LoadContent&day=$i&week=$week&month=$month&year=$year','CalendarContent'); ChangeSelDate(this);\" ";
		if($i == $sel_day) $out .= "class='seld'>";
		else $out .= "class='cur'>";
		$out .= $i."</a></td>";
		if($start_w == 7){
			$out .= "</tr>";
			$start_w = 0;
		}
	}
	if($start_w < 8 && $start_w != 0){
		for($i = $start_w; $i < 7; $i++){
			$nd = $i - $start_w + 1;
			$n_week = date("w", strtotime($nd.".".$n_month.".".$n_year));
				if($n_week == 0) $n_week = 7;
			$out .= "<td><a href='javascript:void(null)' onclick=\"getdata('','post','?p=calendar&act=LoadContent&day=$nd&week=$n_week&month=$n_month&year=$n_year','CalendarContent');\" class='hid'>".$nd."</a></td>";
		}
		$out .= "</tr>";
	}
	$out .= "<tr><td colspan='7' style='text-align:center;'>";
	$out .= "<a href='javascript:void(null)' onclick=\"getdata('','post','?p=calendar&type=DAY','CalendarBox_inner');\">День</a>";
	$out .= "&nbsp;&nbsp;&nbsp;&nbsp;";
	$out .= "<a href='javascript:void(null)' onclick=\"getdata('','post','?p=calendar&type=WEEK','CalendarBox_inner');\">Неделя</a>";
	$out .= "&nbsp;&nbsp;&nbsp;&nbsp;";
	$out .= "<a href='javascript:void(null)' onclick=\"getdata('','post','?p=calendar&type=MONTH','CalendarBox_inner');\">Месяц</a>";
	$out .= "</td></tr>";
	$out .= "</table></div>";
	return $out;
}


function calendarOutContent($day = 0, $week = 0, $month = 0, $year = 0){
	global $_conf, $db;
	include("include/lang/admin/".$_SESSION['admin_lang'].".php");

	$out = "";
	if($day == 0) $day = date("j", time());
	if($week == 0) $week = date("w", time());
		if($week == 0) $week = 7;
	if($month == 0) $month = date("n", time());
	if($year == 0) $year = date("Y", time());
	$period = $_SESSION['calendarOutType'];
	if($period == "DAY") $title = $day." ".$_conf['month_list1'][$month]." ".$year.", ".$_conf['week_list'][$week];
	if($period == "WEEK"){
		$day_in_month = date("t",strtotime($day.".".$month.".".$year));
		$start_week = $day - $week + 1;
		$end_week = $start_week + 6;
			if($start_week < 1){
				if($month == 1){ $p_month = 12; $p_year = $year - 1; }
				else { $p_month = $month - 1; $p_year = $year; }
				$p_day_in_month = date("t",strtotime("01.".$p_month.".".$p_year));
				$start_week = $p_day_in_month + $start_week;
			}else{
				$p_month = $month; $p_year = $year;
			}
			if($end_week > $day_in_month){
				if($month == 12){ $n_month = 1; $n_year = $year + 1; }
				else { $n_month = $month + 1; $n_year = $year; }
				$end_week = $end_week - $day_in_month;
			}else{
				$n_month = $month; $n_year = $year;
			}
				$p_timestamp = strtotime($start_week.".".$p_month.".".$p_year);
				$p_dname = date("w", $p_timestamp);
				if($p_dname == 0) $p_dname = 7;
				$n_timestamp = strtotime($end_week.".".$n_month.".".$n_year);
				$n_dname = date("w", $n_timestamp);
				if($n_dname == 0) $n_dname = 7;

				$title = $_conf['week_list'][$p_dname].", ".$start_week." ".$_conf['month_list1'][$p_month]." ".$p_year." - ".$_conf['week_list'][$n_dname].", ".$end_week." ".$_conf['month_list1'][$n_month]." ".$n_year;
	}
	if($period == "MONTH") $title = $_conf['month_list'][$month]." ".$year;
	
	$out .= "<div id='CalendarContent'>";
	$out .= "<table border='0' cellspacing='0' width='100%' class='cld'>";
	$out .= "<tr><th style='font-size:14px;'>$title</th></tr>";
	$out .= "</table>";
	$out .= "<div style='height:530px;overflow-y:scroll;'>";
	$out .= "<table border='0' cellspacing='0' width='100%' class='selrow'>";
	/**
	* Вывод содержимого календаря за день
	*/
	if($period == "DAY"){
		for($i = 0; $i <= 23; $i++){
			$info = "&nbsp;";
			$start = strtotime($day.".".$month.".".$year." ".$i.":00");
			$end = strtotime($day.".".$month.".".$year." ".$i.":59");
			//$info = date("d.m.Y H:i",$start)." - ".date("d.m.Y H:i",$end);
			if($end < time()) $bg = "class='oldtime'";
			else $bg = '';
			$info = GetCalendarRecords($_SESSION['USER_IDU'], $start, $end);
			$out .= "<tr><td $bg style='border-right:solid 1px #cccccc;width:30px;'>$i<sup>00</sup></td>
			<td $bg ondblclick=\"addwin=dhtmlwindow.open('AddRecordBox', 'inline', '', 'Добавить новую запись', 'width=650px,height=350px,left=100px,top=100px,resize=1,scrolling=1'); addwin.moveTo('middle','middle'); getdata('','get','?p=calendar&act=AddRecordForm&retdiv=r_$start&start=".$start."&end=".$end."','AddRecordBox_inner'); return false; \"><div id='r_$start'>".$info."</div></td></tr>";
		}
	}
	/**
	* Вывод содержимого календаря за неделю
	*/
	if($period == "WEEK"){
		$out .= "<tr><th>&nbsp;</th>";
		$dd = $p_timestamp;
		for($j=1; $j<=7; $j++){
			$data = date("j",$dd);//$start_week + $j -1;
			$out .= "<th>$data, ".$_conf['week_list'][$j]."</th>";
			$dd = $dd + 24*3600;
		}
		$out .= "</tr>";
			$start = $p_timestamp;
		for($j=0;$j<=23;$j++){
			$info = "";
			$out .= "<tr><td style='border-right:solid 1px #cccccc;width:30px;'>$j<sup>00</sup></td>";
			for($i = 1; $i <= 7; $i++){
				$start1 = $start + ($i-1)*24*3600;
				$end1 = $start1 + 3600;
				//$info = date("d.m.Y H:i",$start1)." - ".date("d.m.Y H:i",$end1);
				$info = GetCalendarRecords($_SESSION['USER_IDU'], $start1, $end1);
				$instime = $start1 + 1800;
				if($end1 < time()) $bg = "class='oldtime'";
				else $bg = '';
				$out .= "<td $bg style='border-right:solid 1px #cccccc;' ondblclick=\"addwin=dhtmlwindow.open('AddRecordBox', 'inline', '', 'Добавить новую запись', 'width=650px,height=350px,left=100px,top=100px,resize=1,scrolling=1'); addwin.moveTo('middle','middle'); getdata('','get','?p=calendar&act=AddRecordForm&retdiv=r_".$start1."&start=".$start1."&end=".$end1."','AddRecordBox_inner'); return false; \"><div id='r_$start1'>".$info."</div></td>";
			}
			$start = $start + 3600;
			$out .= "</tr>";
		}
	}
	/**
	* Вывод содержимого календаря за месяц
	*/
	if($period == "MONTH"){
		$day_in_month = date("t",strtotime($day.".".$month.".".$year));
		for($i = 1; $i <= $day_in_month; $i++){
			$info = "";
			$start = strtotime($i.".".$month.".".$year." 00:00");
			$end = strtotime($i.".".$month.".".$year." 23:59");
			if($week == 0) $week = date("w", time());
				if($week == 0) $week = 7;
				//$info = date("d.m.Y H:i",$start)." - ".date("d.m.Y H:i",$end);
			$info = GetCalendarRecords($_SESSION['USER_IDU'], $start, $end);
			$instime = $start + 9*3600 + 1800;
				if($end < time()) $bg = "class='oldtime'";
				else $bg = '';
			$out .= "<tr><td $bg style='border-right:solid 1px #cccccc;width:20px;'>$i</td><td $bg ondblclick=\"addwin=dhtmlwindow.open('AddRecordBox', 'inline', '', 'Добавить новую запись', 'width=650px,height=350px,left=100px,top=100px,resize=1,scrolling=1'); addwin.moveTo('middle','middle'); getdata('','get','?p=calendar&act=AddRecordForm&retdiv=r_".$start."&start=".$start."&end=".$end."','AddRecordBox_inner'); return false; \"><div id='r_$start'>".$info."</div></td></tr>";
		}
	}
	$out .= "</table>";
	$out .= "</div>";
	
	$out .= "</div>";
	return $out;
}


/**
* ПОлучение записей из календаря для пользователя за указанный период и вывод в виде строки
*/
function GetCalendarRecords($idu, $start_time, $end_time){
	global $_conf, $db;
	$out = "";
	$q = "SELECT * FROM ".$_conf['prefix']."calendar WHERE instime BETWEEN '".$start_time."' AND '".$end_time."' AND idu='".$idu."' ORDER BY instime";
	$r = $db -> Execute($q);
	if($r -> RecordCount() > 0){
		while(!$r -> EOF){	
			$t = $r -> GetRowAssoc(false);
			$out .= "<a title='Просмотр записи' href='javascript:void(null)' onClick=\"cinfowin=dhtmlwindow.open('CalInfoBox', 'inline', '', 'Просмотр записи', 'width=650px, height=350px, left=50px, top=70px, resize=1, scrolling=1'); cinfowin.moveTo('middle', 'middle'); getdata('', 'get', '?p=calendar&act=OutRecordInfo&idc=$t[idc]&retdiv=r_$start_time&start=$start_time&end=$end_time', 'CalInfoBox_inner'); return false; \">".stripslashes($t['rtitle'])."</a><br />";
			$r -> MoveNext();
		}
	}
	
	return $out;
}

/**
*  Вывод формы для создания новой записи
*/
function AddRecordForm($retdiv, $start, $end){
	global $_conf, $db;
	$out = "";
	$half = $end-$start;
	$instime = $start + round($half/2, 0);
	$infoalert = $instime < time() ? "Событие уже прошло" : "Событие еще не наступило";
	$out .= "<form action='javascript:void(null)' method='post' enctype='multipart/form-data' id='AddRecordForm'>";
	$out .= "<input type='hidden' name='act' id='act' value='SaveNewRecord' />";
	$out .= "<input type='hidden' name='p' id='p' value='calendar' />";
	$out .= "<input type='hidden' name='start' id='start' value='$start' />";
	$out .= "<input type='hidden' name='end' id='end' value='$end' />";
	$out .= "<strong>Дата события:</strong><br /><input type='text' name='instime' id='instime' value='".date("d.m.Y H:i",$instime)."' /> <font color='red'>($infoalert)</font><br />";
	//$out .= "<font color='red'><strong>Дата события: ".date("d.m.Y H:i",$instime)."</strong> ($infoalert)</font><br />";
	$out .= "<strong>Заглавие:</strong><br /><input type='text' name='rtitle' id='rtitle' value='' style='width:500px;' /><br />";
	$out .= "<strong>Описание:</strong><br /><textarea name='record' id='record' style='height:100px;width:500px;'></textarea><br />";
	$out .= "<strong>Оповещение о событии:</strong><br />";
	$out .= "Начать оповещение за <input type='text' name='period' id='period' value='24' style='width:30px;' /> часов до начала события<br />";
	$out .= "<input type='checkbox' name='alert_mail' id='alert_mail' value='y' /> Оповещать по e-mail<br />";
	if(smsalert == true) $out .= "<input type='checkbox' name='alert_sms' id='alert_sms' value='y' /> Оповещать по SMS<br />";
	$out .= "<input type='checkbox' name='alert_informer' id='alert_informer' value='y' /> Выводить сообщение в информере<br />";
	$out .= "<input type='button' name='SaveRecord' id='SaveRecord' value='Сохранить' onClick=\"doLoad('AddRecordForm','$retdiv'); document.getElementById('AddRecordBox').style.display = 'none';\" /><br />";
	$out .= "</form>";
	return $out;
}


/**
*  Сохранение новой записи
*/
function SaveNewRecord($data){
	global $_conf, $db;
	$out = "";
	if(trim($data['rtitle'])==""){
		$out .= msg_box("Укажите заглавие события!");
	}else{
		$instime = strtotime($data['instime']);
		$starttime = $instime - $data['period']*3600;
		$alert_mail = isset($data['alert_mail']) ? 'y' : 'n';
		$alert_sms = isset($data['alert_sms']) ? 'y' : 'n';
		$alert_informer = isset($data['alert_informer']) ? 'y' : 'n';
		$r = $db -> Execute("INSERT INTO ".$_conf['prefix']."calendar (idu, instime, rtitle, record, starttime, stoptime, alert_mail, alert_sms, alert_informer) VALUES ('$_SESSION[USER_IDU]', '$instime', '".mysql_real_escape_string($data['rtitle'])."', '".mysql_real_escape_string($data['record'])."', '$starttime', '', '$alert_mail', '$alert_sms', '$alert_informer')");
	}
	$out .= GetCalendarRecords($_SESSION['USER_IDU'], $data['start'], $data['end']);
	return $out;
}


/**
*  Вывод формы для создания новой записи
*/
function OutRecordInfo($retdiv, $idc, $start, $end){
	global $_conf, $db;
	$out = "";
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."calendar WHERE idc='$idc'");
	$t = $r -> GetRowAssoc(false);
	$period = ($t['instime']-$t['starttime'])/3600;
	$am = $t['alert_mail']=='y' ? "checked='checked'" : "";
	$as = $t['alert_sms']=='y' ? "checked='checked'" : "";
	$ai = $t['alert_informer']=='y' ? "checked='checked'" : "";
	$infoalert = $t['instime'] < time() ? "Событие уже прошло" : "Событие еще не наступило";
	$dellink = "<a href='javascript:void(null)' onclick=\"getdata('','post','?p=calendar&act=DeleteRecord&start=$start&end=$end&idc=$idc','$retdiv'); document.getElementById('CalInfoBox').style.display = 'none';\">Удалить запись</a>";
	$out .= "<form action='javascript:void(null)' method='post' enctype='multipart/form-data' id='SaveRecordForm'>";
	$out .= "<input type='hidden' name='act' id='act' value='SaveRecord' />";
	$out .= "<input type='hidden' name='idc' id='idc' value='$idc' />";
	$out .= "<input type='hidden' name='p' id='p' value='calendar' />";
	$out .= "<input type='hidden' name='instime' id='instime' value='$t[instime]' />";
	$out .= "<input type='hidden' name='start' id='start' value='$start' />";
	$out .= "<input type='hidden' name='end' id='end' value='$end' />";
	//$out .= "<font color='red'><strong>Дата события: ".date("d.m.Y H:i",$t['instime'])."</strong> ($infoalert)</font> ($dellink)<br />";
	$out .= "<strong>Дата события:</strong><br /><input type='text' name='instime' id='instime' value='".date("d.m.Y H:i",$t['instime'])."' /> <font color='red'>($infoalert)</font> ($dellink)<br />";
	$out .= "<strong>Заглавие:</strong><br /><input type='text' name='rtitle' id='rtitle' value='".htmlspecialchars(stripslashes($t['rtitle']))."' style='width:500px;' /><br />";
	$out .= "<strong>Описание:</strong><br /><textarea name='record' id='record' style='height:100px;width:500px;'>".htmlspecialchars(stripslashes($t['record']))."</textarea><br />";
	$out .= "<strong>Оповещение о событии:</strong><br />";
	$out .= "Начать оповещение за <input type='text' name='period' id='period' value='$period' style='width:30px;' /> часов до начала события<br />";
	$out .= "<input type='checkbox' name='alert_mail' id='alert_mail' value='y' $am /> Оповещать по e-mail (2 раза в сутки, в 9.00 и 20.00)<br />";
	if(smsalert == true) $out .= "<input type='checkbox' name='alert_sms' id='alert_sms' value='y' $as /> Оповещать по SMS (1 раз в сутки, в 10.00)<br />";
	$out .= "<input type='checkbox' name='alert_informer' id='alert_informer' value='y' $ai /> Выводить сообщение в информере<br />";
	$out .= "<input type='button' name='SaveRecord' id='SaveRecord' value='Сохранить' onClick=\"doLoad('SaveRecordForm','$retdiv'); document.getElementById('CalInfoBox').style.display = 'none';\" /><br />";
	$out .= "</form>";
	return $out;
}


/**
*  Сохранение записи
*/
function SaveRecord($data){
	global $_conf, $db;
	$out = "";
	if(trim($data['rtitle'])==""){
		$out .= msg_box("Укажите заглавие события!");
	}else{
		$instime = strtotime($data['instime']);
		$starttime = $instime - $data['period']*3600;
		$alert_mail = isset($data['alert_mail']) ? 'y' : 'n';
		$alert_sms = isset($data['alert_sms']) ? 'y' : 'n';
		$alert_informer = isset($data['alert_informer']) ? 'y' : 'n';
		$r = $db -> Execute("UPDATE ".$_conf['prefix']."calendar SET 
		instime = '$instime',
		rtitle='".mysql_real_escape_string($data['rtitle'])."', 
		record='".mysql_real_escape_string($data['record'])."', 
		alert_mail='$alert_mail', alert_sms='$alert_sms', alert_informer='$alert_informer'
		WHERE idc='$data[idc]'");
	}
	$out .= GetCalendarRecords($_SESSION['USER_IDU'], $data['start'], $data['end']);
	return $out;
}


/**
*  Удаление записи
*/
function DeleteRecord($data){
	global $_conf, $db;
	$out = "";
		$r = $db -> Execute("DELETE FROM ".$_conf['prefix']."calendar 
		WHERE idc='$data[idc]'");
	$out .= GetCalendarRecords($_SESSION['USER_IDU'], $data['start'], $data['end']);
	return $out;
}


/**
*  Вывод ближайших событий
*/
function OutLastTask(){
	global $db, $_conf;
	$out = "<strong>Ближайшие события</strong><br />";
	$q = "SELECT * FROM ".$_conf['prefix']."calendar WHERE idu='$_SESSION[USER_IDU]' AND instime > ".time()." ORDER BY instime ASC LIMIT 0,5";
	$r = $db -> Execute($q);
	if($r -> RecordCount() > 0){
		while(!$r -> EOF){	
			$t = $r -> GetRowAssoc(false);
			$out .= "<small>".date("d.m.Y H:i",$t['instime'])." - <a title='Просмотр записи' href='javascript:void(null)' onClick=\"showinfowin=dhtmlwindow.open('ShowInfoBox', 'inline', '', 'Просмотр записи', 'width=650px, height=350px, left=50px, top=70px, resize=1, scrolling=1'); showinfowin.moveTo('middle', 'middle'); getdata('', 'get', '?p=calendar&act=ShowRecordInfo&idc=$t[idc]', 'ShowInfoBox_inner'); return false; \">".stripslashes($t['rtitle'])."</a></small><br />";
			$r -> MoveNext();
		}
	}else $out .= "Нет ни одного запланированного события!";
	return $out;
}


/**
*  Вывод информации о записи
*/
function ShowRecordInfo($idc){
	global $_conf, $db;
	$out = "";
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."calendar WHERE idc='$idc'");
	$t = $r -> GetRowAssoc(false);
	$period = ($t['instime']-$t['starttime'])/3600;
	$am = $t['alert_mail']=='y' ? "Оповещать по e-mail<br />" : "";
	$as = $t['alert_sms']=='y' ? "Оповещать по SMS<br />" : "";
	$ai = $t['alert_informer']=='y' ? "Выводить информацию в информере<br />" : "";
	$out .= "<strong>Дата события:</strong> ".date("d.m.Y H:i",$t['instime'])."<br /><br />";
	$out .= "<strong>Заглавие:</strong><br />".htmlspecialchars(stripslashes($t['rtitle']))."<br /><br />";
	$out .= "<strong>Описание:</strong><br />".htmlspecialchars(stripslashes($t['record']))."<br /><br />";
	$out .= "<strong>Оповещение о событии:</strong><br />";
	$out .= "Начать оповещение за $period часов до начала события<br /><br />";
	$out .= $am;
	if(smsalert == true) $out .= $as;
	$out .= $ai;
	return $out;
}
?>