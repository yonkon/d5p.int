<?php
/**
* Выполнение заданий по расписанию - новая версия
* @package ShiftCMS
* @version 1.00 16.10.2011
* @author Volodymyr Demchuk
* @link http://shiftcms.net
* в cron прописать это задание с интервалом выполнения в 5 минут, а если есть задания, что выполняются чаще, то с меньшим интервалом
* /usr/bin/php /home/mdiplom/public_html/cron_init.php > /dev/null
* Все остальные задания записывать в текстовый файл init_cron.txt
* записи начинающиеся с # - комментарии
*/
set_time_limit(120);

include(dirname(__FILE__).'/include/config/set.inc.php');

$cron_log = "/tmp/log/cron.log"; // путь к файлу для записи логов
if(file_exists(dirname(__FILE__).$cron_log) && filesize(dirname(__FILE__).$cron_log) > 204800) $fp = fopen(dirname(__FILE__).$cron_log,"w");
else $fp = fopen(dirname(__FILE__).$cron_log,"a");

$host = $_conf['www_patch']."/";

$cur = time();
$cur_min = (int)date("i",$cur);

$interval = 5;  //интервал запуска скрипта установленный в cron на сервере

/**
* определяем интервал минут в которые должна попасть минута выполнения задания
*/
$left = $right = 0;
for($i=0; $i < 60; $i = $i+$interval){
	if($cur_min >= $i && $cur_min < $i+$interval){
		$left = $i; $right = $i + $interval;
	}
}

fwrite($fp, "===========START TASKS==".date("d.m.Y H:i",time())."===========\n");
$task=file(dirname(__FILE__)."/tmp/init_cron.txt");
for($i=0;$i<count($task);$i++){
	$tr = parse_task(trim($task[$i]), $cur, $left, $right);
	if($tr != false){
		$taskreply  = file_get_contents($host.$tr);
		fwrite($fp, $host.$tr."\n".trim($taskreply)."\n");
	}
}
fwrite($fp, "===========END TASKS==".date("d.m.Y H:i",time())."===========\n\n");
fclose($fp);

//exit;


/**
* Function for cron task parse
*/
function parse_task($task, $cur, $left, $right){
	if($task{0}=="#") return 0;

		$cur_min = (int)date("i",$cur);
		$cur_hour = date("G",$cur);
		$cur_day = date("j",$cur);
		$cur_month = date("n",$cur);
		$cur_dayweek = date("w",$cur);
	
	$task_ar = explode("|",$task);
	//print_r($task_ar);
	$mins = CheckMinuts(trim($task_ar[1]), $left, $right);
	if($mins == 0) return false;

	$hour = CheckVals(trim($task_ar[2]), $cur_hour);
	if($hour == 0) return false;

	$day = CheckVals(trim($task_ar[3]), $cur_day);
	if($day == 0) return false;

	$month = CheckVals(trim($task_ar[4]), $cur_month);
	if($month == 0) return false;

	$dayweek = CheckVals(trim($task_ar[5]), $cur_dayweek);
	if($dayweek == 0) return false;

	$url = trim($task_ar[0]);
	return $url;
}

function CheckMinuts($vals, $left, $right){
	if($vals == "*") return true;
	$ar = explode(",",$vals);
	while(list($k,$v)=each($ar)){
		if(trim($v) >= $left && trim($v) < $right) return true;
	}
	return false;
}

function CheckVals($vals, $curvals){
	if($vals == "*") return true;
	$ar = explode(",",$vals);
	while(list($k,$v)=each($ar)){
		if(trim($v) == $curvals) return true;
	}
	return false;
}



?>