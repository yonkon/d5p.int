<?php
/**
 * Обработка урлов и преобразование из ЧПУ в нормальный вид
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00.04
 */
if(!defined("SHIFTCMS")) exit;

$rqu = str_replace($_conf['www_dir'],"",$_SERVER['REQUEST_URI']);

if (preg_match("/index.php/", $rqu, $regs)) {
	$redir_url = str_replace("index.php","",$rqu);
	header("HTTP/1.0 301"); header("Status: 301");
	header("location:".$redir_url);
	exit;
}

$path = explode("?", $rqu);
$path[0] = str_replace($_conf['www_dir'],"",$path[0]); // убираем имя каталога в котором размещен сайт
//echo $path[0];exit;
$rp = strrev($path[0]);
if($rp{0}!="/"){ // добавляем завершающий слеш к урлам
	$redir_url = $_conf['www_patch'].$path[0]."/";
	if(trim($path[1])!="") $redir_url .= "?".$path[1];
	header("HTTP/1.0 301"); header("Status: 301");
	header("location:".$redir_url);
	exit;
}

if($rp{0}=="/" && (isset($rp{1}) && $rp{1}=="/")){
	$redir_url = $_conf['www_patch'].str_replace("//////","/",$path[0]);
	$redir_url = $_conf['www_patch'].str_replace("/////","/",$path[0]);
	$redir_url = $_conf['www_patch'].str_replace("////","/",$path[0]);
	$redir_url = $_conf['www_patch'].str_replace("///","/",$path[0]);
	$redir_url = $_conf['www_patch'].str_replace("//","/",$path[0]);
	header("HTTP/1.0 301"); header("Status: 301");
	header("location:".$redir_url);
	exit;
}

$para = explode("/", $path[0]);
if(count($para)==3 && (isset($path[1]) && trim($path[1])!="")){// если есть параметры в урле, а каталог только один - добавляем еще один каталог, а количество параметров уменьшаем
	$p2 = explode("&",$path[1]);
	//print_r($p2);
	if(count($p2)>1) $path[1] = str_replace($p2[0]."&","",$path[1]);
	else $path[1] = "";
	$path[0] .= str_replace("=","/",$p2[0]);
	$redir_url = $_conf['www_patch'].$path[0]."/";
	if(trim($path[1])!="") $redir_url .= "?".$path[1];
	header("HTTP/1.0 301"); header("Status: 301");
	header("location:".$redir_url);
	exit;
}

if(isset($para[1]) && strlen($para[1]) > 2){ // проверяем на запрещенные каталоги
	if($para[1]=="admin") {$para[1] = "404";}
	if($para[1]=="docs") {$para[1] = "404";}
	if($para[1]=="files") {$para[1] = "404";}
	if($para[1]=="include") {$para[1] = "404";}
	if($para[1]=="js") {$para[1] = "404";}
	if($para[1]=="module") {$para[1] = "404";}
	if($para[1]=="tmp") {$para[1] = "404";}
	if($para[1]=="tmpl") {$para[1] = "404";}
	if($para[1]=="blog" && isset($para[2]) && $para[2]!="" && (!isset($para[3]) || $para[3]=="")) {$para[3] = $para[2]; $para[2] = "b_link";}
}

if($_SESSION['lang']==$_conf['def_lang']){
	
	if(count($para)>0){
		$par = 0;
		for($i=0; $i<count($para); $i++){
			if($para[$i]==''){
				continue;
			}else{ // дополнительные переменные отправляемые скрипту
				if($i==1){
					$_REQUEST['p'] = $para[1];
				}elseif(!isset($para[$i+1]) || $para[$i+1]==""){ //если для переменной не установлено значение
					$_REQUEST['p'] = "404";  $i++;	$par++;
				}else{
					$_REQUEST[$para[$i]] = $para[$i+1]; $i++;	$par++; // для переменной присваеиваем значение
				}
			}
		}
	}

}else{ // if lang != def_lang

	if(count($para)>0){
		$par = 0;
		for($i=0; $i<count($para); $i++){
			if($para[$i]==''){
				continue;
			}else if($par==0 && strlen($para[$i]) == 2){ // язык
				if($para[$i]!="ru" && $para[$i]!="ua" && $para[$i]!="en") $para[$i] = $_conf['def_lang'];
				$_REQUEST['lang'] = $para[$i]; $par++;
			}else if($par==1){ // страница - переменная $р
				$_REQUEST['p'] = $para[$i]; $par++;
			}else{ // дополнительные переменные отправляемые скрипту
				if(!isset($para[$i+1]) || $para[$i+1]==""){ //если для переменной не установлено значение
					$_REQUEST['p'] = "404";  $i++;	$par++;
				}else{
					$_REQUEST[$para[$i]] = $para[$i+1]; $i++;	$par++; // для переменной присваеиваем значение
				}
			}
		}
	}

}

?>