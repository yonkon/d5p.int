<?php
/**
 * Набор разнообразных функций используемых в различных скриптах сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.03.11
 * 12.06.2010 - пределаны функции обработки урлов для ЧПУ
 * 08.12.2010 - добавлены функции инициализации и подключения визуальных редакторов
 */
if(!defined("SHIFTCMS")) exit;

//----------------------------------------------------------------------
function add_to_log($str,$type){
   $file="tmp/log/".$type.".log";
   $fz = file_exists($file) ? filesize($file) :0;
   if($fz>1024000) @unlink($file);
   $fp=fopen($file,"a");
   $str="-- ".date("d.m.Y H:i",time())."\r\n".$str.";\r\n";
   fwrite($fp,$str);
   fclose($fp);
}
//----------------------------------------------------------------------
function load_conf_var(){
	global $_conf, $db, $smarty;
	$lang_ar = array();
	if($_SERVER['PHP_SELF']=="/index.php"){
		if(!isset($_SESSION['lang'])) $_SESSION['lang'] = $_conf['def_lang'];
		$sellang = $_SESSION['lang'];
	}elseif($_SERVER['PHP_SELF']=="/auth.php"){
		if(!isset($_SESSION['lang'])) $_SESSION['lang'] = $_conf['def_lang'];
		$sellang = $_SESSION['lang'];
	}elseif($_SERVER['PHP_SELF']=="/admin.php"){
		if(!isset($_SESSION['admin_lang'])) $_SESSION['admin_lang'] = $_conf['def_admin_lang'];
		$sellang = $_SESSION['admin_lang'];
	}elseif($_SERVER['PHP_SELF']=="/loader.php"){
		if(strstr($_SERVER['HTTP_REFERER'], 'admin.php')){
			if(!isset($_SESSION['admin_lang'])) $_SESSION['admin_lang'] = $_conf['def_admin_lang'];
			$sellang = $_SESSION['admin_lang'];
		}elseif(strstr($_SERVER['HTTP_REFERER'], 'index.php')){
			if(!isset($_SESSION['lang'])) $_SESSION['lang'] = $_conf['def_lang'];
			$sellang = $_SESSION['lang'];
		}else{
			$_SESSION['admin_lang'] = $_conf['def_admin_lang'];
			$_SESSION['lang'] = $_conf['def_lang'];
			$sellang = $_SESSION['lang'];
		}
	}else{
		$_SESSION['admin_lang'] = $_conf['def_admin_lang'];
		$_SESSION['lang'] = $_conf['def_lang'];
		$sellang = $_SESSION['lang'];
	}
	$ms = $db -> Execute("SELECT name, val, grp FROM ".$_conf['prefix']."site_config");
	$cf = $ms -> GetArray();
	while (list($k,$v)=each($cf)) $_conf[$v['name']] = stripslashes($v['val']);
	if($sellang==$_conf['def_lang']){
		$ms = $db->Execute("SELECT pkey, ".$sellang." FROM ".$_conf['prefix']."translate");
		$tr = $ms -> GetArray();
		while (list($k,$v)=each($tr)) $lang_ar[$v['pkey']] = stripslashes($v[$sellang]);
	}else{
		$ms = $db->Execute("SELECT pkey, ".$sellang.", ".$_conf['def_lang']." as def FROM ".$_conf['prefix']."translate");
		$tr = $ms -> GetArray();
		while (list($k,$v)=each($tr)) $lang_ar[$v['pkey']] = trim(stripslashes($v[$sellang]))!="" ? stripslashes($v[$sellang]) : stripslashes($v['def']);
	}
	return $lang_ar;
}
//---------------------------------------------
function get_include_contents($filename,$_conf) {
global $p,$group,$TITLE,$CURPATCH,$KEYWORDS,$DESCRIPTION,$db,$smarty, $HEADER, $lang_ar, $alang_ar;
    if (is_file($filename)) {
        ob_start();
        include $filename;
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
       return false;
}
//------------------------------------------------------------------------
function msg_box($mes){
	global $smarty, $db, $_conf;
	$smarty->assign("conf",$_conf);
	$smarty->assign("info_message",$mes);
	$mb = $smarty->fetch("db:messeg.tpl");
    return $mb;
}
//======================================================
function create_select($list, $value, $val_name, $add_par=null, $showfree = true){
	$sel_str="<select name='".$val_name."' id='".$val_name."' ".$add_par.">";
	if($showfree==true) $sel_str .= "<option></option>";
	while (list($key, $name) = each($list)){
		if($key == $value) $sel_str .= "<option selected='selected' value='".$key."'>".$name."</option>";
		else $sel_str .= "<option value='".$key."'>".$name."</option>";
	}
	$sel_str.="</select>";
	return $sel_str;
}
//-----------------------------------------------
function create_check($list,$value,$val_name,$add_par){
$sel_str="";
	while (list($key, $name) = each($list)){
		$comp=0;
		for($i=0;$i<count($value);$i++){
			if(isset($value[$i])&&$key==$value[$i]&&$comp==0) {
				$sel_str.="<div><input type='checkbox' name='$val_name"."[]' value='$key' checked='checked' $add_par />&nbsp;$name</div>";
				$comp=1;
			}
		}
		if($comp==0) {
			$sel_str.="<div><input type='checkbox' name='$val_name"."[]' value='$key' $add_par />&nbsp;$name</div>";
		}
	}
return $sel_str;
}

function create_radio($list,$value,$val_name,$add_par="",$sep=' &nbsp; '){
	$sel_str=""; $i = 0;
	while (list($k, $v) = each($list)){
		if($value==$k) $sel_str .= '<input type="radio" name="'.$val_name.'" id="'.$val_name.$i.'" value="'.$k.'" '.$add_par.' checked="checked" /> '.$v.$sep;
		else $sel_str .= '<input type="radio" name="'.$val_name.'" id="'.$val_name.$i.'" value="'.$k.'" '.$add_par.' /> '.$v.$sep;
		$i++;
	}
return $sel_str;
}

//----Форматирование размера файла----------
function get_filesize ($dsize) {
            if (strlen($dsize) <= 9 && strlen($dsize) >= 7) {
                $dsize = number_format($dsize / 1048576,2);
                return "$dsize MB";
            } elseif (strlen($dsize) >= 10) {
                $dsize = number_format($dsize / 1073741824,2);
                return "$dsize GB";
            } else {
                $dsize = number_format($dsize / 1024,2);
                return "$dsize KB";
            }
}
/* ======Разбивка на страницы с интервалами страниц============ */
function Paging($all,$interval,$start,$link,$add_parametr){
$list_page="";
if($all<=$interval) $list_page="";
if($all>$interval){
    $count_page=ceil($all/$interval);
	if($count_page<20){
		for($i=0;$i<$count_page;$i++){
			$page=$i+1;
			$start1=$interval*$i;
			$add_parametr1=str_replace("%start1%",$start1,$add_parametr);
			if($start==$start1) $list_page=$list_page."<span class=\"current\">$page</span>&nbsp;";
			else $list_page=$list_page."<a href=\"".str_replace("%start1%",$start1,$link)."\" ".$add_parametr1.">$page</a>&nbsp;";
		}
	}else{ /* если страниц больше 20 - создаем интервалы страниц */
$cur_page_number=$start/$interval+1;

if(($cur_page_number<=8) || ($cur_page_number>$count_page-8)){
		for($i=0;$i<10;$i++){
				$page=$i+1;
				$start1=$interval*$i;
				$add_parametr1=str_replace("%start1%",$start1,$add_parametr);
				if($start==$start1) $list_page=$list_page."<span class=\"current\">$page</span>&nbsp;";
				else $list_page=$list_page."<a href=\"".str_replace("%start1%",$start1,$link)."\" ".$add_parametr1.">$page</a>&nbsp;";
		}
			$list_page.=" ... &nbsp;";
		for($i=$count_page-10;$i<$count_page;$i++){
			$page=$i+1;
			$start1=$interval*$i;
			$add_parametr1=str_replace("%start1%",$start1,$add_parametr);
			if($start==$start1) $list_page=$list_page."<span class=\"current\">$page</span>&nbsp;";
			else $list_page=$list_page."<a href=\"".str_replace("%start1%",$start1,$link)."\" ".$add_parametr1.">$page</a>&nbsp;";
		}
}else{
		$add_parametr1=str_replace("%start1%",0,$add_parametr);
		$list_page=$list_page."<a href=\"".str_replace("%start1%",0,$link)."\" ".$add_parametr1.">1</a>&nbsp;";
			$list_page.=" ... &nbsp;";
		for($i=$cur_page_number-8;$i<$cur_page_number+7;$i++){
			$page=$i+1;
			$start1=$interval*$i;
			$add_parametr1=str_replace("%start1%",$start1,$add_parametr);
			if($start==$start1) $list_page=$list_page."<span class=\"current\">$page</span>&nbsp;";
			else $list_page=$list_page."<a class=\"list_pas\" href=\"".str_replace("%start1%",$start1,$link)."\" ".$add_parametr1.">$page</a>&nbsp;";
		}
			$list_page.=" ... &nbsp;";
		$add_parametr1=str_replace("%start1%",$count_page*$interval,$add_parametr);
		$list_page=$list_page."<a href=\"".str_replace("%start1%",$count_page*$interval,$link)."\" ".$add_parametr1.">$count_page</a>&nbsp;";
}

	}
	 $ppr=$start-$interval;
	 $add_parametr1=str_replace("%start1%",$ppr,$add_parametr);
	 if($start>0) $prev="<a class=\"\" href=\"".str_replace("%start1%",$ppr,$link)."\" ".$add_parametr1.">&laquo;&laquo;</a>&nbsp;";
	 else $prev="";
	 $pnx=$start+$interval;
	 $add_parametr1=str_replace("%start1%",$pnx,$add_parametr);
	 if($pnx<$all)  $pnext="<a href=\"".str_replace("%start1%",$pnx,$link)."\" ".$add_parametr1.">&raquo;&raquo;</a>&nbsp;";
	 else $pnext="";
	 $list_page=$prev.$list_page.$pnext;
	 $list_page="<div class=\"navigation\">".$list_page."</div>";
}
return $list_page;
}

function GetPaging($all, $interval, $start, $link){
$list_page = array();
if($all <= $interval) return $list_page;
if($all > $interval){
    $ppr = $start - $interval;
    if($start > 0) $list_page['prev'] = str_replace("%start1%", $ppr, $link);
    $count_page = ceil($all / $interval);
    if($count_page < 15){
    	for($i = 0; $i < $count_page; $i++){
            $page = $i + 1;
            $start1 = $interval * $i;
            if($start == $start1) $list_page['current'] = $page;
            else $list_page[$page] = str_replace("%start1%", $start1, $link);
		}
    }else{ /* если страниц больше 15 - создаем интервалы страниц */
        $cur_page_number = $start / $interval + 1;
        if(($cur_page_number <= 6) || ($cur_page_number > $count_page-6)){
            for($i=0; $i < 8; $i++){
            	$page = $i + 1;
				$start1 = $interval*$i;
				if($start == $start1) $list_page['current'] = $page;
				else $list_page[$page] = str_replace("%start1%", $start1, $link);
            }
            $list_page['dot']=" ... ";
            for($i = $count_page - 8; $i < $count_page; $i++){
            	$page = $i + 1;
				$start1 = $interval * $i;
				if($start == $start1) $list_page['current'] = $page;
				else $list_page[$page] = str_replace("%start1%", $start1, $link);
            }
        }else{
            $list_page[1] = str_replace("%start1%", 0, $link);
            $list_page['dot']=" ... ";
            for($i = $cur_page_number - 6; $i < $cur_page_number + 5; $i++){
                $page=$i+1;
                $start1=$interval * $i;
				if($start==$start1) $list_page['current']=$page;
				else $list_page[$page] = str_replace("%start1%", $start1, $link);
            }
            $list_page['dot']=" ... ";
            $list_page[$count_page] = str_replace("%start1%", $count_page*$interval, $link);
        }
    }
    $pnx=$start+$interval;
    if($pnx<$all)  $list_page['pnext']=str_replace("%start1%",$pnx,$link);
}
return $list_page;
}
//=======================================================
function create_mselect($list,$value,$val_name){
global $p,$_POST,$_SESSION;
$sel_interes="<select name=\"$val_name\" multiple=\"multiple\" size=\"10\">";
//$value=split(",",$value);
reset ($list);
while (list($key, $name) = each($list)){
  for($i=0;$i<count($value);$i++){
   if($value=="") $value[$i]="";
   $comp=0;
     if($key==$value[$i]) {
        $sel_interes.="<option selected=\"selected\" value=\"$key\">$name</option>";
        $comp=1;
     }
     if($comp==1) break;
  }
  if($comp==0) $sel_interes.="<option value=\"$key\">$name</option>";
}
$sel_interes.="</select>";
return $sel_interes;
}
/*=================================================================*/
/*Перезапись адресов*/
function rewrite_url($tpl,$_conf){
	global $_conf;
	$tpl=preg_replace_callback("|(href=\')(.*?)(\')|", "_rewrite_url", $tpl);
	$tpl=preg_replace_callback("|(href=\")(.*?)(\")|", "_rewrite_url", $tpl);

	$tpl=preg_replace_callback("|(action=\')(.*?)(\')|", "_rewrite_action", $tpl);
	$tpl=preg_replace_callback("|(action=\")(.*?)(\")|", "_rewrite_action", $tpl);

	return $tpl;
}
function _rewrite_url($mat, $href=true){
	global $_conf;
	$newurl = '';
	$ln = isset($_SESSION['lang']) ? $_SESSION['lang'] : $_conf['def_lang'];
	$mat[2] = str_replace("&amp;", "&", $mat[2]);
	if(strstr($mat[2],"lang=")) return 'href="'.$mat[2].'"';

	$url = parse_url($mat[2]);
	//if($url['fragment']) print_r($url);
	if(isset($url['host']) && $url['host'] == "liveinternet.ru") return "href='".$mat[2]."'";
	if(isset($url['host']) && $url['host'] == "www.liveinternet.ru") return "href='".$mat[2]."'";
	if(isset($url['host']) && $url['host'] != $_SERVER['HTTP_HOST']) return 'href="'.$mat[2].'"';
	if(isset($url['scheme']) && $url['scheme'] == "skype") return 'href="'.$mat[2].'"';
	if(isset($url['scheme']) && $url['scheme'] == "mailto") return 'href="'.$mat[2].'"';
	if(isset($url['scheme']) && $url['scheme'] == "javascript") return 'href="'.$mat[2].'"';
	
	//print_r($url);
	if(isset($url['query'])) parse_str($url['query'], $query);
	else{ return 'href="'.$mat[2].'"'; }
	
	if(isset($url['scheme'])) $newurl = $url['scheme']."://";
	else $newurl = "http://";
	if(isset($url['host'])) $newurl .= $url['host'];
	else $newurl .= $_SERVER['HTTP_HOST'];
	if(isset($url['port'])) $newurl .= ':'.$url['port'];
	$newurl .= $_conf['www_dir'];

	if(count($query)>0){
		reset($query); $pps = 'notset';
		while(list($k,$v)=each($query)){
			if($k=="p"){
				if($v=="main"){
					$newurl .= '/';
					$pps = 'set';
				}else{
					if($_SESSION['lang']==$_conf['def_lang']) $newurl .= '/'.$v.'/';
					else $newurl .= '/'.$ln.'/'.$v.'/';
					$pps = 'set';
				}
			}
			//if($k == "lang"){ $newurl .= '/?lang='.$v; break; }
		}
		if($pps == 'notset') $newurl .= '/';
		reset($query); $i=0;
		while(list($k,$v) = each($query)){
			//if($k!="p") $newurl .= $k.'/'.$v.'/';
			if($k!="p"){
				if($i==0){
					if($v=="") $newurl .= $k.'/'; 
					else $newurl .= $k.'/'.$v.'/'; 
					if(count($query)>2) $newurl .= '?';
				}
				else{ 
					if(is_array($v)){
						reset($v); while(list($vk,$vv)=each($v)) $newurl .= "&".$k.'[]='.$vv; 
					}else{if($i>1) $newurl .= '&'; $newurl .= $k.'='.$v; }
				}
				$i++;
			}
		}
	}
	if(isset($url['fragment'])) $newurl .= "#".$url['fragment'];
	
	if($href==true) return 'href="'.$newurl.'"';
	else return $newurl;
}
function _rewrite_action($mat){
	global $_conf;
	$newurl = '';
	$ln = isset($_SESSION['lang']) ? $_SESSION['lang'] : $_conf['def_lang'];
	$mat[2] = str_replace("&amp;", "&", $mat[2]);

	$url = parse_url($mat[2]);
	if(isset($url['host']) && $url['host']!=$_SERVER['HTTP_HOST']) return 'action="'.$mat[2].'"';
	if(isset($url['query'])) parse_str($url['query'], $query);
	else{ return 'action="'.$mat[2].'"'; }
	
	if(isset($url['scheme'])) $newurl = $url['scheme']."://";
	else $newurl = "http://";
	if(isset($url['host'])) $newurl .= $url['host'];
	else $newurl .= $_SERVER['HTTP_HOST'];
	if(isset($url['port'])) $newurl .= ':'.$url['port'];
	$newurl .= $_conf['www_dir'];

	if($_SESSION['lang'] == $_conf['def_lang']) $newurl .= '/';
	else $newurl .= '/'.$ln.'/';
	if(count($query)>0){
		reset($query); $pps = 'notset';
		while(list($k,$v) = each($query)){
			if($k == "p"){
				$newurl .= $v.'/';
				$pps = 'set';
			}
		}
		if($pps == 'notset') $newurl .= 'main/';
		reset($query); $i = 0;
		while(list($k,$v)=each($query)){
			if($k!="p"){
				if($i==0){
					if($v=="") $newurl .= $k.'/'; 
					else $newurl .= $k.'/'.$v.'/'; 
					if(count($query)>2) $newurl .= '?';
				}
				else{ 
					if(is_array($v)){
						reset($v); while(list($vk,$vv)=each($v)) $newurl .= "&".$k.'[]='.$vv; 
					}else{if($i>1) $newurl .= '&'; $newurl .= $k.'='.$v; }
				}
				$i++;
			}
		}
	}
	if(isset($url['fragment'])) $newurl .= "#".$url['fragment'];
	return 'action="'.$newurl.'"';
}
function rewrite_img_url($tpl,$_conf){
	global $_conf;
	$tpl = preg_replace_callback("|(src=\")(.*?)(\")|", "_rewrite_img_url", $tpl);
	$tpl = preg_replace_callback("|(src=')(.*?)(')|", "_rewrite_img_url", $tpl);
	return $tpl;
}
function _rewrite_img_url($mat){
	global $_conf;
	$newurl = '';
	$mat[2] = str_replace("&amp;", "&", $mat[2]);
	$url = parse_url($mat[2]);
	if(isset($url['host']) && $url['host'] != $_SERVER['HTTP_HOST']) return 'src="'.$mat[2].'"';
	if(isset($url['scheme'])) $newurl = $url['scheme']."://";
	else $newurl = "http://";
	if(isset($url['host'])) $newurl .= $url['host'];
	else $newurl .= $_SERVER['HTTP_HOST'];
	$newurl .= $_conf['www_dir'];
	if($url['path']{0} != "/") $newurl .= "/";
	$newurl .= $url['path'];
	return 'src="'.$newurl.'"';
}
/* загрузка конфигурационных данных */
function LoadINI($inifile){
	if(file_exists($inifile)) return parse_ini_file($inifile);
}
/* запись конфигурационных данных */
function SaveINI($inifile,$data){
	$fp=fopen($inifile,"w");
	while(list($key,$val)=each($data)){
		fwrite($fp,$key." = ".$val."\n");
	}
	fclose($fp);
}

/* прослешимо вхідні дані */
function SecureRequest($data){
	reset($data);
	while(list($key,$val)=each($data)){
		if(!is_array($val)) $data[$key]=mysql_real_escape_string(trim($val));
	}
	return $data;
}
function ClearSleshes($data){
	reset($data);
	while(list($key,$val)=each($data)){
		if(!is_array($val)) $data[$key]=stripslashes(trim($val));
	}
	return $data;
}
function translit($simvol){
	$transar=array("й"=>"j","ц"=>"ts","у"=>"u","к"=>"k","е"=>"e","ё"=>"e","н"=>"n","г"=>"g","ш"=>"sh","щ"=>"sch",
		"з"=>"z","х"=>"h","ъ"=>"","ф"=>"f","ы"=>"y","в"=>"v","а"=>"a","п"=>"p","р"=>"r","о"=>"o",
		"л"=>"l","д"=>"d","ж"=>"zh","э"=>"e","я"=>"ya","ч"=>"ch","с"=>"s","м"=>"m","и"=>"i","т"=>"t",
		"ь"=>"","б"=>"b","ю"=>"yu"," "=>"_","-"=>"-","("=>"",")"=>"",
		"Й"=>"J","Ц"=>"Ts","У"=>"U","К"=>"K","Е"=>"E","Ё"=>"E","Н"=>"N","Г"=>"G","Ш"=>"Sh","Щ"=>"Sch",
		"З"=>"Z","Х"=>"H","Ъ"=>"","Ф"=>"F","Ы"=>"Y","В"=>"V","А"=>"A","П"=>"P","Р"=>"R","О"=>"O",
		"Л"=>"L","Д"=>"D","Ж"=>"Zh","Э"=>"E","Я"=>"Ya","Ч"=>"Ch","С"=>"S","М"=>"M","И"=>"I","Т"=>"T",
		"Ь"=>"","Б"=>"B","Ю"=>"Yu", "і"=>"i", "І"=>"I", "є"=>"je", "Є"=>"Je", "ї"=>"ji", "ї"=>"Ji");
	if(isset($transar[$simvol])) return $transar[$simvol];
	else return $simvol;
}
function transwords($phrase){
	$out = "";
	for($i = 0; $i < mb_strlen($phrase, "UTF-8"); $i++){
		$letter = mb_substr($phrase, $i, 1, "UTF-8");
		$out .= translit($letter);
	}
	return($out);
}
function translit1($simvol){
	$transar=array("й"=>"j","ц"=>"ts","у"=>"u","к"=>"k","е"=>"e","ё"=>"e","н"=>"n","г"=>"g","ш"=>"sh","щ"=>"sch",
		"з"=>"z","х"=>"h","ъ"=>"","ф"=>"f","ы"=>"y","в"=>"v","а"=>"a","п"=>"p","р"=>"r","о"=>"o",
		"л"=>"l","д"=>"d","ж"=>"zh","э"=>"e","я"=>"ya","ч"=>"ch","с"=>"s","м"=>"m","и"=>"i","т"=>"t",
		"ь"=>"","б"=>"b","ю"=>"yu"," "=>"-","-"=>"-","_"=>"_","("=>"",")"=>"","."=>".",
		"Й"=>"J","Ц"=>"Ts","У"=>"U","К"=>"K","Е"=>"E","Ё"=>"E","Н"=>"N","Г"=>"G","Ш"=>"Sh","Щ"=>"Sch",
		"З"=>"Z","Х"=>"H","Ъ"=>"","Ф"=>"F","Ы"=>"Y","В"=>"V","А"=>"A","П"=>"P","Р"=>"R","О"=>"O",
		"Л"=>"L","Д"=>"D","Ж"=>"Zh","Э"=>"E","Я"=>"Ya","Ч"=>"Ch","С"=>"S","М"=>"M","И"=>"I","Т"=>"T",
		"Ь"=>"","Б"=>"B","Ю"=>"Yu",
		"q"=>"q","w"=>"w","e"=>"e","r"=>"r","t"=>"t","y"=>"y","u"=>"u","i"=>"i","o"=>"o","p"=>"p","a"=>"a",
		"s"=>"s","d"=>"d","f"=>"f","g"=>"g","h"=>"h","j"=>"j","k"=>"k","l"=>"l","z"=>"z","x"=>"x","c"=>"c","v"=>"v",
		"b"=>"b","n"=>"n","m"=>"m","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9",
		"0"=>"0","Q"=>"Q","W"=>"W","E"=>"E","R"=>"R","T"=>"T","Y"=>"Y","U"=>"U","I"=>"I","O"=>"O","P"=>"P","A"=>"A",
		"S"=>"S","D"=>"D","F"=>"F","G"=>"G","H"=>"H","J"=>"J","K"=>"K","L"=>"L","Z"=>"Z","X"=>"X","C"=>"C",
		"V"=>"V","B"=>"B","N"=>"N","M"=>"M", "і"=>"i", "І"=>"I", "є"=>"je", "Є"=>"Je", "ї"=>"ji", "ї"=>"Ji");
	if(isset($transar[$simvol])) return $transar[$simvol];
	else return "";
}
function transurl($phrase){
	$out = "";
	for($i = 0; $i < mb_strlen($phrase, "UTF-8"); $i++){
		$letter = mb_substr($phrase, $i, 1, "UTF-8");
		$out .= translit1($letter);
	}
	return($out);
}


/**
*  Отправка сообщений пользователям системы с записью в базу данных для просмотра внутри системы
$attach = array(
'fullPath/name'=>'name',
)
*/
function SendEmail($from_idu, $from_email, $from_name, $to_idu, $to_email, $to_name, $subject, $message, $account = 0, $ido = 0, $flag = '', $attach = array(), $addtosender = true){
	global $_conf, $db;
	if($attach != null && count($attach)==0) $attach = null;
			if(!class_exists("PHPMailer")){
				include(dirname(__FILE__)."/phpmailer/class.phpmailer.php");
			}
			$smail = new PHPMailer();
			$smail->CharSet = $_conf['encoding'];//"WINDOWS-1251";
			$smail->IsMail();
			$smail->From = $from_email;
			$smail->FromName = $from_name;
			$smail->AddAddress($to_email, $to_name);
			if($attach!=null){
				reset($attach);
				while(list($k,$v)=each($attach)) $smail->AddAttachment($k, $v);
			}
			$smail->WordWrap = 50;
			$smail->IsHTML(true);
			$smail->Subject = $subject;
			$smail->Body  = $message;
			if($smail->Send()){
				/* запись в базу для получателя */
					$accepter = GetMailAccount($to_idu, $to_email);
				if($to_idu!=0){
					$r1 = $db -> Execute("INSERT INTO ".$_conf['prefix']."user_mail (idu, account, folder, ido, from_idu, from_email, from_name, to_idu, to_email, to_name, subject, message, mdate, mflag, mstate) VALUES ('$to_idu', '".$accepter['idma']."', 'inbox', '$ido', '$from_idu', '$from_email', '".mysql_real_escape_string($from_name)."', '$to_idu', '$to_email', '".mysql_real_escape_string($to_name)."', '".mysql_real_escape_string($subject)."', '".mysql_real_escape_string($message)."', '".time()."', '$flag', 'new')");
					$idm1 = $db -> Insert_ID();
				}
				/* запись в базу для отправителя */
				if($addtosender == true){
				$r2 = $db -> Execute("INSERT INTO ".$_conf['prefix']."user_mail (idu, account, folder, ido, from_idu, from_email, from_name, to_idu, to_email, to_name, subject, message, mdate, mflag, mstate) VALUES ('$from_idu', '$account', 'outbox', '$ido', '$from_idu', '$from_email', '".mysql_real_escape_string($from_name)."', '$to_idu', '$to_email', '".mysql_real_escape_string($to_name)."', '".mysql_real_escape_string($subject)."', '".mysql_real_escape_string($message)."', '".time()."', '$flag', 'read')");
				$idm2 = $db -> Insert_ID();
				}
				if($attach!=null){
					reset($attach);
					if(!class_exists("uploader")){
						require_once("include/uploader.php");
					}
					$aupl = new uploader;
					$aupl -> rewrite = 1;
					while(list($k,$v)=each($attach)){
						if($to_idu!=0){
							$dir1 = GetAttachDir($idm1);
							$res1 = $aupl -> CopyFile($k, $dir1."/".$v);
							if($res1==true) $ra1 = $db -> Execute("INSERT INTO ".$_conf['prefix']."user_mail_attach(idm,fpath,fname)VALUES('$idm1','".mysql_real_escape_string($dir1."/".$v)."','".mysql_real_escape_string($v)."')");
						}
						if($addtosender == true){
							$dir2 = GetAttachDir($idm2);
							$res2 = $aupl -> MoveFile($k, $dir2."/".$v);
							if($res2==true) $ra2 = $db -> Execute("INSERT INTO ".$_conf['prefix']."user_mail_attach(idm,fpath,fname)VALUES('$idm2','".mysql_real_escape_string($dir2."/".$v)."','".mysql_real_escape_string($v)."')");
						}
					}
				}
				return true;
			}
			else return false;
}
/**
* Возвращает путь к каталогу для хранения аттачментов к письмам
*/
function GetAttachDir($idm){
	if(!class_exists("uploader")){
		require_once("include/uploader.php");
	}
	$mupl = new uploader;
	if(!is_dir("files/attach")) $mupl -> MakeDir("files/attach");
	$subdir = $idm+99-(($idm-1)%100);
	$adir = "files/attach/".$subdir;
	if(!is_dir($adir)) $mupl -> MakeDir($adir);
	$dir = $adir."/".$idm;
	if(!is_dir($dir)) $mupl -> MakeDir($dir);
	unset($mupl);
	return $dir;
}

function SendParameters($ppar){
	if(strlen(trim($ppar))=="") return;
	$cpar = explode("&",$ppar);
	reset($cpar);
	while(list($k,$v)=each($cpar)){
		$ipar = explode("=",$v);
		$_REQUEST[$ipar[0]] = $ipar[1];
	}
}

function initializeEditor($editor){
	if($editor == "fck") initializeFCK();
	if($editor == "earea") initializeEditArea();
	if($editor == "ck") initializeCK();
}
function initializeFCK(){
	include("include/FCKeditor/fckeditor.php");
}
function addFCKToField($field, $val, $toolbar='Default', $width='100%', $height='300'){
	global $_conf;
	$oFCKeditor = new FCKeditor($field) ;
	$oFCKeditor -> ToolbarSet = $toolbar;
	$sBasePath = "./include/FCKeditor/";
	$oFCKeditor -> Width  = $width;
	$oFCKeditor -> Height = $height;
	$oFCKeditor -> Config['EditorAreaCSS'] = $_conf['www_patch']."/".$_conf['tpl_dir']."css/style.css" ;
	$oFCKeditor -> BasePath	= $sBasePath ;
	$oFCKeditor -> Value = stripslashes($val);
	$editorarea = $oFCKeditor -> Create();
	echo $editorarea;
}
function initializeCK(){
	global $_conf,$HEADER;
	//include("include/ckeditor/ckeditor.php");
	$HEADER .= '<script type="text/javascript" src="'.$_conf['www_patch'].'/include/ckeditor/ckeditor.js"></script>';
}
function addCKToField($field, $toolbar='Default', $width='100%', $height='300'){
	global $_conf;
	$editorarea = '
	<script type="text/javascript">
	CKEDITOR.replace("'.$field.'",{
		width : \''.$width.'\',height : \''.$height.'\',
        filebrowserBrowseUrl : \''.$_conf['www_patch'].'/admin.php?p=admin_fck_upload\',
        filebrowserImageBrowseUrl : \''.$_conf['www_patch'].'/admin.php?p=admin_fck_upload\',
        filebrowserFlashBrowseUrl : \''.$_conf['www_patch'].'/admin.php?p=admin_fck_upload\'
	});
	</script>
	';
	echo $editorarea;
}
function initializeEditArea(){
	global $_conf;
	echo '
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/editarea/edit_area_full.js"></script>
	';
}
function addEditAreaToField($field){
	global $_conf;
	echo '
	<script type="text/javascript">
		editAreaLoader.init({
			id: "'.$field.'",
			min_width: 500,
			min_height: 300,
			start_highlight: true,
			allow_toggle: true,
			allow_resize: "both",
			language: "ru",
			syntax: "html",
			word_wrap: true,
			show_line_colors: true,
			syntax_selection_allow: "css,html,js,php,python,vb,xml,c,cpp,sql,basic,pas,brainfuck",
			toolbar: "search, go_to_line, |, undo, redo, |, select_font, |, syntax_selection, |, change_smooth_selection, highlight, word_wrap, reset_highlight, |, help, fullscreen"
		});
	</script>
	';
}

function templateSubdir(){
	global $_conf;
	$sd = str_replace("/","",str_replace("tmpl/","",$_conf['tpl_dir']));
	if(!is_dir($_conf['disk_patch']."tmp/templates_c/".$sd)){
		mkdir($_conf['disk_patch']."tmp/templates_c/".$sd);
		chmod($_conf['disk_patch']."tmp/templates_c/".$sd, 0777);
	}
	return "/".$sd;
}
function atemplateSubdir(){
	global $_conf;
	$sd = str_replace("/","",str_replace("tmpl/backend/","",$_conf['admin_tpl_dir']));
	if(!is_dir($_conf['disk_patch']."tmp/templates_c/".$sd)){
		mkdir($_conf['disk_patch']."tmp/templates_c/".$sd);
		chmod($_conf['disk_patch']."tmp/templates_c/".$sd, 0777);
	}
	return "/".$sd;
}

function parseContent($text, $photo_type, $type_id){
	global $_conf, $db, $smarty;
	$pretext = '';
	if (preg_match("/{GAL-/", $text, $regs)) {
		$pretext = $smarty -> fetch("page_gal_header.tpl");
	}
	preg_match_all("{GAL-([0-9]{1,2})-GAL}", $text, $reg);
	if(count($reg)>0){
	while(list($k,$v)=each($reg[1])){
		$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."page_gal WHERE photo_type='".$photo_type."' AND type_id='".$type_id."' AND photo_group='".$v."' ORDER BY photo_id");
		$pgal = array();
		while(!$r -> EOF){
			$t = $r -> GetRowAssoc(false);
			$subdir = $_conf['upldir'].'/'.stripslashes($photo_type).'/'.stripslashes($type_id).'/';
			$pgal[] = array(
				'thumb' => $subdir.$t['photo_id'].'_s.jpg',
				'photo' => $subdir.$t['photo_id'].'.jpg',
				'sign' => stripslashes($t['photosign_'.$_SESSION['lang']])
			);
			$r -> MoveNext();
		}
		$smarty -> assign("pgal", $pgal);
		$gal = $smarty -> fetch("page_gal.tpl");
		$text = str_replace("<p>{GAL-".$v."-GAL}</p>",$gal,$text);
		$text = str_replace("{GAL-".$v."-GAL}",$gal,$text);
	}
	}
	preg_match_all("{VIDEO-([0-9]{1,2})-VIDEO}", $text, $reg);
	if(count($reg)>0){
	while(list($k,$v)=each($reg[1])){
		$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."page_video WHERE video_type='".$photo_type."' AND type_id='".$type_id."' AND video_group='".$v."' ORDER BY video_group");
		$vgal = array();
		while(!$r -> EOF){
			$t = $r -> GetRowAssoc(false);
			$vgal[] = array(
				'code' => stripslashes($t['video_code']),
				'sign' => stripslashes($t['vsign_'.$_SESSION['lang']])
			);
			$r -> MoveNext();
		}
		$smarty -> assign("vgal", $vgal);
		$val = $smarty -> fetch("page_video.tpl");
		$text = str_replace("<p>{VIDEO-".$v."-VIDEO}</p>",$val,$text);
		$text = str_replace("{VIDEO-".$v."-VIDEO}",$val,$text);
	}
	}
	preg_match_all("{FORM-([0-9]{1,2})-FORM}", $text, $reg);
	if(count($reg)>0){
		while(list($k,$v)=each($reg[1])){
			$val = buildForm($v);
			$text = str_replace("<p>{FORM-".$v."-FORM}</p>",$val,$text);
			$text = str_replace("{FORM-".$v."-FORM}",$val,$text);
		}
	}
	return $pretext.$text;	
}

function ManagePagePhoto($photo_type, $type_id){
	global $db, $_conf, $alang_ar;
	$out = "<div id='PhotoMsg'></div>";
	$out .= "<div id='PhotoList'>";
	$out .= PagePhotoList($photo_type, $type_id);
	$out .= "</div>";
	return $out;
}

function PagePhotoList($photo_type, $type_id){
	global $db, $_conf, $alang_ar, $lang_ar;
	$out = ""; $i = 0;

	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."page_gal WHERE photo_type='".$photo_type."' AND type_id='".$type_id."' ORDER BY photo_group");
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		$subdir = $_conf['upldir'].'/'.stripslashes($t['photo_type']).'/'.stripslashes($t['type_id']).'/';
		$dw = $_conf['pgal_thumb_w']+4;
		$dh = $_conf['pgal_thumb_h']+40;
		$out .= "<div style='float:left; padding:2px; margin:2px;text-align:center;' id='PID".$t['photo_id']."'><small>Галерея:</small>".$t['photo_group']."<br />".$t['photosign_'.$_SESSION['admin_lang']]."<br /><a href='".$subdir.$t['photo_id'].".jpg' target='_bigphoto'><img src='".$subdir.$t['photo_id']."_s.jpg' height='50' /></a><br /><a href='javascript:void(null)' onclick=\"getdata('','post','?p=admin_list_action&act=DeletePhoto&photo_id=".$t['photo_id']."','PhotoMsg'); delelem('PID".$t['photo_id']."')\">".$alang_ar['delete']."</a></div>";
		$i++;
		if($i == 3){
			$i = 0; echo "<br style='clear:both' />";
		}
		$r -> MoveNext();
	}
	return $out;
}

function GetUserPagePhotoList($photo_type, $type_id){
	global $db, $_conf, $alang_ar, $lang_ar;
	$out = array();
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."page_gal WHERE photo_type='".$photo_type."' AND type_id='".$type_id."' ORDER BY photo_group");
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		$subdir = $_conf['upldir'].'/'.stripslashes($t['photo_type']).'/'.stripslashes($t['type_id']).'/';
		$out[] = array(
			'photo_id'=>$t['photo_id'],
			'photo_group'=>$t['photo_group'],
			'photosign'=>stripslashes($t['photosign_'.$_SESSION['lang']]),
			'subdir'=>$subdir
		);
		$r -> MoveNext();
	}
	return $out;
}

function GetUserPageVideoList($video_type, $type_id){
	global $db, $_conf, $alang_ar, $lang_ar;
	$out = array();
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."page_video WHERE video_type='".$video_type."' AND type_id='".$type_id."' ORDER BY video_group");
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		$out[] = array(
			'video_id'=>$t['video_id'],
			'video_group'=>$t['video_group'],
			'vsign'=>stripslashes($t['vsign_'.$_SESSION['lang']]),
			'video_code'=>$t['video_code']
		);
		$r -> MoveNext();
	}
	return $out;
}
function DelPagePhoto($photo_id){
	global $db, $_conf;
	$out = "";
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."page_gal WHERE photo_id='".$photo_id."'");
	$t = $r -> GetRowAssoc(false);
	$pdir = $_conf['upldir'].'/'.stripslashes($t['photo_type']).'/'.stripslashes($t['type_id'])."/";
	$photo1 = $pdir.$t['photo_id'].".jpg";
	$photo2 = $pdir.$t['photo_id']."_s.jpg";
	$photo3 = $pdir.$t['photo_id']."_orig.jpg";
	@unlink($photo1);
	@unlink($photo2);
	@unlink($photo3);
	@rmdir($pdir);
	$rd = $db -> Execute("DELETE FROM ".$_conf['prefix']."page_gal WHERE photo_id='".$photo_id."'");
}

function DelPageVideo($video_id){
	global $db, $_conf;
	$rd = $db -> Execute("DELETE FROM ".$_conf['prefix']."page_video WHERE video_id='".$video_id."'");
}

function PagePhotoForm($photo_type, $type_id){
	global $_conf;
	$fl = GetLangField();
	echo '<div style="padding:2px; border:solid 1px #ccc; background:#eee;">
	<h3>Загрузить фото к странице</h3>';
	echo "<form method='post' action='javascript:void(null)' enctype='multipart/form-data' id='PagePhotoForm'>
	<input type='hidden' name='photo_type' value='".$photo_type."' id='photo_type' />
	<input type='hidden' name='type_id' value='".$type_id."' id='type_id' />
	<table border='0'><tr><td valign='top'>
	<input type='file' name='file' id='file' size='40' /><br />
	<input type='checkbox' name='crop' value='yes' checked='checked' onclick=\"if(this.checked==false) {document.getElementById('CropSelect').style.display='none';document.getElementById('AlignMethod').style.display='block';} else {document.getElementById('CropSelect').style.display='block';document.getElementById('AlignMethod').style.display='none';}\" /> Обрезать превью фото к размеру: 
	<input type='text' name='pp_w' id='pp_w' value='".$_conf['pgal_thumb_w']."' size='4' style='text-align:center;' />
	x 
	<input type='text' name='pp_h' id='pp_h' value='".$_conf['pgal_thumb_h']."' size='4' style='text-align:center;' />
	<br />
	<div id='AlignMethod' style='display:none;'>
	Выравнивать превью по:
	<input type='radio' name='resizetype' id='rs1' value='fix_w' /> ширине
	<input type='radio' name='resizetype' id='rs2' value='fix_h' checked='checked' /> высоте
	</div>
	<div id='CropSelect' style='display:block;'>
	Вариант обрезки фото:
	<input type='radio' name='whatcrop' value='top' /> слева/сверху
	<input type='radio' name='whatcrop' value='center' checked='checked' /> от центра
	<input type='radio' name='whatcrop' value='bottom' /> справа/снизу
	</div>
	<strong>Номер группы фото:</strong> <input type='text' name='photo_group' id='photo_group' value='1' size='3' /> <small>число от 1 до 99</small><br />";
	echo "<strong>Подпись к фото</strong><br />";
		reset($fl);
		while(list($k,$v)=each($fl)){
		echo '<input type="text" name="photosign_'.$v.'" id="photosign_'.$v.'" style="width:200px;" value="" maxlength="255" /> <img src="'.$_conf['admin_tpl_dir'].'flags/'.$v.'.gif" /> '.strtoupper($v).'<br />';
		}
	echo "<br /><input type='button' value='Загрузить фото' onclick=\"doLoadPagePhoto('PagePhotoForm','ActionRes')\" />
	</td></tr></table>
	</form><br />
	<div style='background:#FFC; padding:3px; border:solid 1px #FC6;'><small>Для вставки галереи в текст страницы, вставьте в нужном месте в тексте следующий код: <input type='text' value='{GAL-1-GAL}' size='14' style='text-align:center' onfocus='select()' /><br />Если вам необходимо вставить несколько галерей отдельно, то в коде вместо <strong>1</strong>, поставьте другой номер группы фото.</small></div>";
	echo ManagePagePhoto($photo_type, $type_id);
	echo '<br style="clear:both;" />';
	echo '</div>';
}
function PageVideoForm($video_type, $type_id){
	global $_conf;
	$fl = GetLangField();
	echo '<div style="padding:2px; border:solid 1px #ccc; background:#eee;">
	<h3>Добавить видео</h3>
	<form method="post" action="javascript:void(null)" enctype="multipart/form-data" id="PageVideoForm">
	<input type="hidden" name="video_type" value="'.$video_type.'" id="video_type" />
	<input type="hidden" name="type_id" value="'.$type_id.'" id="type_id" />
	<strong>Код вставки видео:</strong><br />
	<textarea name="video_code" id="video_code" style="width:400px;height:100px;"></textarea><br />
	<strong>Подпись к видео:</strong><br />';
		reset($fl);
		while(list($k,$v)=each($fl)){
		echo '<input type="text" name="vsign_'.$v.'" id="vsign_'.$v.'" style="width:200px;" value="" maxlength="255" /> <img src="'.$_conf['admin_tpl_dir'].'flags/'.$v.'.gif" /> '.strtoupper($v).'<br />';
		}
	echo '<strong>Порядковый номер видео:</strong> <input type="text" name="video_group" id="video_group" value="1" size="3" /> <small>число от 1 до 99</small><br />
	<br /><input type="button" value="Сохранить" onclick="doLoadUserPageVideo(\'PageVideoForm\',\'VideoMsg\')" />
	</form><br />
	<div style="background:#FFC; padding:3px; border:solid 1px #FC6;"><small>Для вставки видео в текст страницы, вставьте в нужном месте в тексте следующий код: <input type="text" value="{VIDEO-1-VIDEO}" size="24" style="text-align:center" onfocus="select()" /><br />Если вам необходимо вставить несколько видеороликов, то в коде вместо <strong>1</strong>, поставьте другой номер видео.</small></div>
	<div id="VideoMsg"></div>
	<div id="VideoList">';
	$videos = GetUserPageVideoList($video_type, $type_id);
	while(list($k,$v)=each($videos)){
		echo '<div style="padding:2px;" id="VID'.$v['video_id'].'">Видео:'.$v['video_group'].'. <a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=site_server&act=EditUserVideo&video_id='.$v['video_id'].'\', \'EDV'.$v['video_id'].'\');">'.$v['video_id'].': '.$v['vsign'].'</a> | <a href="javascript:void(null)" onclick="getdata(\'\',\'post\', \'?p=site_server&act=DeleteUserVideo&video_id='.$v['video_id'].'\',\'VideoMsg\'); delelem(\'VID'.$v['video_id'].'\');">Удалить</a> <div id="EDV'.$v['video_id'].'"></div></div>';
    }
	echo '</div>
	</div><br />';
}

/* Включение дополнительных блоков в шаблон страницы */
function IncludePageBlocks($p_blocks){
	global $CMS,$_conf, $db, $smarty, $p, $lang_ar, $alang_ar, $HEADER;
	if(count($p_blocks)==0 && trim($p_blocks[0])=="") return;
	if(count($p_blocks)==1){
		$q="select * from `".$_conf['prefix']."blocks` where `block_name`='".$p_blocks[0]."'";
	}else{
		reset($p_blocks); while(list($k,$v)=each($p_blocks)) $p_blocks[$k] = "'".$v."'";
		$q="select * from `".$_conf['prefix']."blocks` where (`block_name`=".implode(" OR `block_name`=",$p_blocks).")";
	}
	$r = $db -> _Execute($q);
	$all = $r->GetArray();
	if(is_array($all) && count($all) > 0){
		foreach($all as $t_block_data) {
		   if(trim($t_block_data['content_'.$_SESSION['lang']])=="" && $_SESSION['lang']!=$_conf['def_lang'])
				$t_block_data['content_'.$_SESSION['lang']] = $t_block_data['content_'.$_conf['def_lang']];
			if($t_block_data['btype']=="base"){
				$smarty->assign($t_block_data['block_name'],stripslashes($t_block_data['content_'.$_SESSION['lang']]));
			}else{
				$smarty->assign($t_block_data['block_name']."_".$t_block_data['block_name'],stripslashes($t_block_data['content_'.$_SESSION['lang']]));
				include $_conf['disk_patch'].$t_block_data['block_file'];
				$smarty -> assign($t_block_data['block_name'], $$t_block_data['block_name']);
			}
		}
	}
}

/**
* Отримуємо список мов сайту
* Повертає масив наступного вигляду
* array(
*	'ru'=>'ru',
*	'ua'=>'ua'
* )
*/
function GetLangField(){
	global $_conf, $db;
	$lf = array();
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."countries WHERE switchon='1'");
	while(!$r->EOF){
		$t = $r -> GetRowAssoc(false);
			$lf[$t['domain']] = $t['domain'];
		$r -> MoveNext();
	}

	$lang_field = array();
	$r = $db -> SelectLimit("SELECT * FROM ".$_conf['prefix']."translate",0,1);
	$t = $r -> GetRowAssoc(false);
	while(list($k, $v)=each($t)){
		if($k!="id" && $k!="pkey" && $k!="sections" && in_array($k,$lf)) {
			$lang_field[$k] = $k;
		}
	}
	return $lang_field;
}



/**
* Функция для вывода списка позиций из справочников для вставки в тег <select>
* @param string $dict тип справочника
* @param int $val текущее (выбранное) значение в списке
* @return string строка содержащая список позиций из справочника для вставки в тег <select>
*/
function GetListFromDict($dict, $val = null){
	global $db, $_conf;
	$out = "";
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."dict_".$dict." ORDER BY ".$_SESSION['lang']);
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		if($t[$_SESSION['lang']]=="" && $_SESSION['lang']!=$_conf['def_lang']) $t[$_SESSION['lang']] = $t[$_conf['def_lang']];
		if($t['id'] == $val) $out .= "<option value='".$t['id']."' selected='selected'>".stripslashes($t[$_SESSION['lang']])."</option>";
		else $out .= "<option value='".$t['id']."'>".stripslashes($t[$_SESSION['lang']])."</option>";
		$r -> MoveNext();
	}
	return $out;
}
/**
* Функция для вывода списка позиций из справочников для вставки в тег <select>
* @param string $dict тип справочника
* @param int $val текущее (выбранное) значение в списке
* @return string строка содержащая список позиций из справочника для вставки в тег <select>
*/
function GetArrayFromDict($dict){
	global $db, $_conf;
	$out = array();
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."dict_".$dict." ORDER BY ".$_conf['def_lang']);
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		if($t[$_SESSION['lang']]=="" && $_SESSION['lang']!=$_conf['def_lang']) $t[$_SESSION['lang']] = $t[$_conf['def_lang']];
		$out[$t['id']] = $t;
		$r -> MoveNext();
	}
	return $out;
}
function GetArrayFromDictLang($dict){
	global $db, $_conf;
	$out = array();
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."dict_".$dict." ORDER BY ".$_SESSION['lang']);
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		if($t[$_SESSION['lang']]=="" && $_SESSION['lang']!=$_conf['def_lang']) $t[$_SESSION['lang']] = $t[$_conf['def_lang']];
		$out[$t['id']] = $t;
		$r -> MoveNext();
	}
	return $out;
}

/**
* Получение имени позиции из справочника по айди
* @param int $id айди позиции в справочнике
* @param string $dict тип справочника - часть имени талицы в базе данных
* @return string Имя позиции в справочнике
*/
function GetItemNameFromDict($id, $dict){
	global $db, $_conf;
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."dict_".$dict." WHERE id='$id'");
	$t = $r -> GetRowAssoc(false);
	if($t[$_SESSION['lang']]=="" && $_SESSION['lang']!=$_conf['def_lang']) $t[$_SESSION['lang']] = $t[$_conf['def_lang']];
	return stripslashes($t[$_SESSION['lang']]);
}

function get_ip()
{
global $REMOTE_ADDR;
global $HTTP_X_FORWARDED_FOR, $HTTP_X_FORWARDED, $HTTP_FORWARDED_FOR, $HTTP_FORWARDED;
global $HTTP_VIA, $HTTP_X_COMING_FROM, $HTTP_COMING_FROM;
global $HTTP_SERVER_VARS, $HTTP_ENV_VARS;
// Get some server/environment variables values
if(empty($REMOTE_ADDR)){
    if(!empty($_SERVER)&&isset($_SERVER['REMOTE_ADDR'])){
        $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
    }elseif(!empty($_ENV)&&isset($_ENV['REMOTE_ADDR'])){
        $REMOTE_ADDR = $_ENV['REMOTE_ADDR'];
    }elseif(!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['REMOTE_ADDR'])){
        $REMOTE_ADDR = $HTTP_SERVER_VARS['REMOTE_ADDR'];
    }elseif(!empty($HTTP_ENV_VARS)&&isset($HTTP_ENV_VARS['REMOTE_ADDR'])){
        $REMOTE_ADDR = $HTTP_ENV_VARS['REMOTE_ADDR'];
    }elseif(@getenv('REMOTE_ADDR')){
        $REMOTE_ADDR = getenv('REMOTE_ADDR');
    }
} // end if
if(empty($HTTP_X_FORWARDED_FOR)){
    if(!empty($_SERVER) && isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $HTTP_X_FORWARDED_FOR = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }elseif(!empty($_ENV) && isset($_ENV['HTTP_X_FORWARDED_FOR'])){
        $HTTP_X_FORWARDED_FOR = $_ENV['HTTP_X_FORWARDED_FOR'];
    }elseif(!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'])){
        $HTTP_X_FORWARDED_FOR = $HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'];
    }elseif(!empty($HTTP_ENV_VARS) && isset($HTTP_ENV_VARS['HTTP_X_FORWARDED_FOR'])){
        $HTTP_X_FORWARDED_FOR = $HTTP_ENV_VARS['HTTP_X_FORWARDED_FOR'];
    }elseif(@getenv('HTTP_X_FORWARDED_FOR')){
        $HTTP_X_FORWARDED_FOR = getenv('HTTP_X_FORWARDED_FOR');
    }
} // end if
if(empty($HTTP_X_FORWARDED)){
    if(!empty($_SERVER) && isset($_SERVER['HTTP_X_FORWARDED'])){
        $HTTP_X_FORWARDED = $_SERVER['HTTP_X_FORWARDED'];
    }elseif(!empty($_ENV) && isset($_ENV['HTTP_X_FORWARDED'])){
        $HTTP_X_FORWARDED = $_ENV['HTTP_X_FORWARDED'];
    }elseif(!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED'])){
        $HTTP_X_FORWARDED = $HTTP_SERVER_VARS['HTTP_X_FORWARDED'];
    }elseif(!empty($HTTP_ENV_VARS) && isset($HTTP_ENV_VARS['HTTP_X_FORWARDED'])){
        $HTTP_X_FORWARDED = $HTTP_ENV_VARS['HTTP_X_FORWARDED'];
    }elseif(@getenv('HTTP_X_FORWARDED')){
        $HTTP_X_FORWARDED = getenv('HTTP_X_FORWARDED');
    }
} // end if
if(empty($HTTP_FORWARDED_FOR)){
    if(!empty($_SERVER) && isset($_SERVER['HTTP_FORWARDED_FOR'])){
        $HTTP_FORWARDED_FOR = $_SERVER['HTTP_FORWARDED_FOR'];
    }elseif(!empty($_ENV) && isset($_ENV['HTTP_FORWARDED_FOR'])){
        $HTTP_FORWARDED_FOR = $_ENV['HTTP_FORWARDED_FOR'];
    }elseif(!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_FORWARDED_FOR'])){
        $HTTP_FORWARDED_FOR = $HTTP_SERVER_VARS['HTTP_FORWARDED_FOR'];
    }elseif(!empty($HTTP_ENV_VARS) && isset($HTTP_ENV_VARS['HTTP_FORWARDED_FOR'])){
        $HTTP_FORWARDED_FOR = $HTTP_ENV_VARS['HTTP_FORWARDED_FOR'];
    }elseif(@getenv('HTTP_FORWARDED_FOR')){
        $HTTP_FORWARDED_FOR = getenv('HTTP_FORWARDED_FOR');
    }
} // end if
if(empty($HTTP_FORWARDED)){
    if(!empty($_SERVER) && isset($_SERVER['HTTP_FORWARDED'])){
        $HTTP_FORWARDED = $_SERVER['HTTP_FORWARDED'];
    }elseif(!empty($_ENV) && isset($_ENV['HTTP_FORWARDED'])){
        $HTTP_FORWARDED = $_ENV['HTTP_FORWARDED'];
    }elseif(!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_FORWARDED'])){
        $HTTP_FORWARDED = $HTTP_SERVER_VARS['HTTP_FORWARDED'];
    }elseif(!empty($HTTP_ENV_VARS) && isset($HTTP_ENV_VARS['HTTP_FORWARDED'])){
        $HTTP_FORWARDED = $HTTP_ENV_VARS['HTTP_FORWARDED'];
    }elseif(@getenv('HTTP_FORWARDED')){
        $HTTP_FORWARDED = getenv('HTTP_FORWARDED');
    }
} // end if
if(empty($HTTP_VIA)){
    if(!empty($_SERVER) && isset($_SERVER['HTTP_VIA'])){
        $HTTP_VIA = $_SERVER['HTTP_VIA'];
    }elseif(!empty($_ENV) && isset($_ENV['HTTP_VIA'])){
        $HTTP_VIA = $_ENV['HTTP_VIA'];
    }elseif(!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_VIA'])){
        $HTTP_VIA = $HTTP_SERVER_VARS['HTTP_VIA'];
    }elseif(!empty($HTTP_ENV_VARS) && isset($HTTP_ENV_VARS['HTTP_VIA'])){
        $HTTP_VIA = $HTTP_ENV_VARS['HTTP_VIA'];
    }elseif(@getenv('HTTP_VIA')){
        $HTTP_VIA = getenv('HTTP_VIA');
    }
} // end if
if(empty($HTTP_X_COMING_FROM)){
    if(!empty($_SERVER) && isset($_SERVER['HTTP_X_COMING_FROM'])){
        $HTTP_X_COMING_FROM = $_SERVER['HTTP_X_COMING_FROM'];
    }elseif(!empty($_ENV) && isset($_ENV['HTTP_X_COMING_FROM'])){
        $HTTP_X_COMING_FROM = $_ENV['HTTP_X_COMING_FROM'];
    }elseif(!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_X_COMING_FROM'])){
        $HTTP_X_COMING_FROM = $HTTP_SERVER_VARS['HTTP_X_COMING_FROM'];
    }elseif(!empty($HTTP_ENV_VARS) && isset($HTTP_ENV_VARS['HTTP_X_COMING_FROM'])){
        $HTTP_X_COMING_FROM = $HTTP_ENV_VARS['HTTP_X_COMING_FROM'];
    }elseif(@getenv('HTTP_X_COMING_FROM')){
        $HTTP_X_COMING_FROM = getenv('HTTP_X_COMING_FROM');
    }
} // end if
if(empty($HTTP_COMING_FROM)){
    if(!empty($_SERVER) && isset($_SERVER['HTTP_COMING_FROM'])){
        $HTTP_COMING_FROM = $_SERVER['HTTP_COMING_FROM'];
    }elseif(!empty($_ENV) && isset($_ENV['HTTP_COMING_FROM'])){
        $HTTP_COMING_FROM = $_ENV['HTTP_COMING_FROM'];
    }elseif(!empty($HTTP_COMING_FROM) && isset($HTTP_SERVER_VARS['HTTP_COMING_FROM'])){
        $HTTP_COMING_FROM = $HTTP_SERVER_VARS['HTTP_COMING_FROM'];
    }elseif(!empty($HTTP_ENV_VARS) && isset($HTTP_ENV_VARS['HTTP_COMING_FROM'])){
        $HTTP_COMING_FROM = $HTTP_ENV_VARS['HTTP_COMING_FROM'];
    }elseif(@getenv('HTTP_COMING_FROM')){
        $HTTP_COMING_FROM = getenv('HTTP_COMING_FROM');
    }
} // end if
// Gets the default ip sent by the user
if(!empty($REMOTE_ADDR)){
    $direct_ip = $REMOTE_ADDR;
}
// Gets the proxy ip sent by the user
$proxy_ip='';
if(!empty($HTTP_X_FORWARDED_FOR))$proxy_ip = $HTTP_X_FORWARDED_FOR;
elseif(!empty($HTTP_X_FORWARDED))$proxy_ip = $HTTP_X_FORWARDED;
elseif(!empty($HTTP_FORWARDED_FOR))$proxy_ip = $HTTP_FORWARDED_FOR;
elseif(!empty($HTTP_FORWARDED))$proxy_ip = $HTTP_FORWARDED;
elseif(!empty($HTTP_VIA))$proxy_ip = $HTTP_VIA;
elseif(!empty($HTTP_X_COMING_FROM))$proxy_ip = $HTTP_X_COMING_FROM;
elseif(!empty($HTTP_COMING_FROM))$proxy_ip = $HTTP_COMING_FROM;
// Returns the true IP if it has been found, else FALSE
/*
if (empty($proxy_ip)){
    // True IP without proxy
    return $direct_ip;
}else{
    $is_ip = ereg('^([0-9]{1,3}\.){3,3}[0-9]{1,3}', $proxy_ip, $regs);
    if($is_ip && (count($regs) > 0)){
        // True IP behind a proxy
        return $regs[0];
    }else{
        // Can't define IP: there is a proxy but we don't have
        // information about the true IP
        return FALSE;
    }
} // end if... else...
*/
	$ret = $REMOTE_ADDR."|".$HTTP_X_FORWARDED_FOR."|".$HTTP_X_FORWARDED."|".$HTTP_FORWARDED_FOR."|".$HTTP_FORWARDED."|".$HTTP_VIA."|".$HTTP_X_COMING_FROM."|".$HTTP_COMING_FROM;
	$ret = str_replace(","," ",$ret);
	return $ret;
}

/* Вывод текстов на сайте. Модуль admin_text.xml */
function out_site_text($name){
global $_conf,$db,$smarty;
$rs = $db->Execute("SELECT * FROM ".$_conf['prefix']."page WHERE pname='".mysql_real_escape_string(stripslashes($name))."'");
  if($rs->RecordCount()!=0){
	  $ptmp=$rs->GetRowAssoc(false);
		if($ptmp['content_'.$_SESSION['lang']]=="" && $_SESSION['lang']!=$_conf['def_lang']) $ptmp['content_'.$_SESSION['lang']] = $ptmp['content_'.$_conf['def_lang']];
		return stripslashes($ptmp['content_'.$_SESSION['lang']]);
  }else{
  		return "";
  }
}

	/**
	* Загружаем в массив всю структуру сайта с которой в дальнейшем можно формировать меню, карту сайта, проверять страницы
	*/
	function loadSiteStructure(){
		global $CMS, $db, $_conf;
		$q = "SELECT 
		pid, pname, pparent, ptitle, plevel, linkpos, 
		siteshow, menushow1, menushow2, menushow3,
		linkname_".$_SESSION['lang']." as linkname, 
		linkname_".$_conf['def_lang']." as linkname_def, 
		linktitle_".$_SESSION['lang']." as linktitle,
		linktitle_".$_conf['def_lang']." as linktitle_def
		FROM ".$_conf['prefix']."page
		WHERE ptype='front' OR ptype='fronthid'
		AND FIND_IN_SET('".$_SESSION['USER_GROUP']."',pgroups)
		ORDER BY linkpos";
		$r = $db -> Execute($q);
		$ar = $r -> GetArray();
		$struct = _buildSiteStruct($ar, '', 0);
		$CMS['structure'] = $struct;
	}
	
	function _buildSiteStruct($ar, $parent, $level){
		global $p, $db, $CMS;
		reset($ar); $menu = array();
		while(list($k,$v)=each($ar)){
			$ownfunc = false;
			if(isset($v['pparent']) && $v['pparent']==$parent){
				if(isset($CMS['modules'][$v['pname']])){
					$mod_func = '_build'.$v['pname'].'Structure';
					if(function_exists($mod_func)) $ownfunc = true;
				}
				$menu[$v['pname']] = array(
					'pid'=>$v['pid'],
					'pname'=>stripslashes($v['pname']),
					'pparent'=>stripslashes($v['pparent']),
					'ptitle'=>stripslashes($v['ptitle']),
					'level'=>$level,
					'linkpos'=>$v['linkpos'],
					'link'=>"?p=".stripslashes($v['pname']),
					'linkname'=>trim($v['linkname'])!="" ? stripslashes($v['linkname']) : stripslashes($v['linkname_def']),
					'linktitle'=>trim($v['linktitle'])!="" ? stripslashes($v['linktitle']) : stripslashes($v['linktitle_def']),
					'siteshow'=>$v['siteshow'],
					'menushow1'=>$v['menushow1'],
					'menushow2'=>$v['menushow2'],
					'menushow3'=>$v['menushow3'],
					'sel'=>'n',
					'sub'=>$ownfunc==true ? call_user_func($mod_func, $ar, $v['pname'], $level+1, $v) : _buildSiteStruct($ar, $v['pname'], $level+1)
				);
				unset($ar[$k]);
			}
		}
		if(count($menu)>0) { return $menu;}
		else return '';
	}
	/**
	* построение массива на базе списка страниц для выбранного меню
	*/
	function getMenu($menu){
		global $CMS;
		$pages = $CMS['structure']; reset($pages);
		$pages = loadMenuInArray($menu, $pages);
		//punktIsSelected(&$pages);
		return $pages;
	}
	
	function loadMenuInArray($menu,$pages){
		global $CMS;
		$tmp = array_reverse($CMS['br']);
		while(list($k,$v)=each($pages)){
			if(isset($v[$menu]) && $v[$menu]!="y"){
				unset($pages[$k]);
			}else{
				if(in_array($k,$tmp)) $pages[$k]['sel'] = 'y';
				if(isset($v['sub']) && is_array($v['sub'])) $pages[$k]['sub'] = loadMenuInArray($menu,$v['sub']);
			}
		}
		if(count($pages)>0) return $pages;
		else return '';
	}
	function getCurrentPageInfo($menu1,$page){
		while(list($k,$v)=each($menu1)){
			if($k==$page) return $menu1[$k];
			if(is_array($v['sub'])){
				$tmp = getCurrentPageInfo($v['sub'],$page);
				if($tmp!="") return $tmp;
			}
		}
	}
	function getSubPage($menu1,$page){
		while(list($k,$v)=each($menu1)){
			if($k==$page) return $v['sub'];
			if(is_array($v['sub'])){
				$tmp = getSubPage($v['sub'],$page);
				if($tmp!="") return $tmp;
			}
		}
	}
	
	function loadBreadCrumbs(){
		global $CMS, $p;
		$CMS['br'] = array();
		$CMS['breadcrumbs'] = array();
		if(isset($CMS['modules'][$p])){
			$mod_func = '_build'.$p.'BreadCrumbs';
			if(function_exists($mod_func)){
				$res = call_user_func($mod_func);
				if($res!='') $CMS['breadcrumbs'] = $res;
			}
		}
		_buildBreadCrumbs($p,$CMS['structure'],0);
		$CMS['breadcrumbs'] = array_reverse($CMS['breadcrumbs']);
	}

	function _buildBreadCrumbs($pname, $pages, $level){
		global $CMS;
		reset($pages);
		while(list($k,$v)=each($pages)){
			if($k==$pname){
				$CMS['br'][$level] = $v['pname'];
				if(trim($v['pparent'])!='') $CMS['breadcrumbs'][$pname] = $v;
				else $CMS['breadcrumbs'][$pname] = $CMS['structure'][$k];
				//$CMS['structure'][$pname]['sel'] = 'y';
				unset($CMS['breadcrumbs'][$pname]['sub']);
				
				if(trim($v['pparent'])!='') _buildBreadCrumbs($v['pparent'], $CMS['structure'], $level+1);
			}
			if(isset($v['sub']) && is_array($v['sub'])) _buildBreadCrumbs($pname, $v['sub'], $level);
		}
	}

function scandir_($dir){
	$files = array();
	if (is_dir($dir)) {
	    if ($dh = opendir($dir)) {
	        while (($file = readdir($dh)) !== false) {
				if($file!="." && $file!=".." && is_file($dir."/".$file))
					$files[] = $file;
	        }
	        closedir($dh);
	    }
	}
	return $files;
}

function getInstalledModules(){
	global $_conf, $db, $CMS;
	$mod = array();
	$r = $db -> Execute("select * from ".$_conf['prefix']."modules where installed='y' and code!='core'");
	$ar = $r -> GetArray();
	while(list($k,$v)=each($ar)) $mod[$v['code']] = $v;
	$CMS['modules'] = $mod;
	return $mod;
}

function loadModuleFunction(){
	global $_conf, $db, $smarty, $HEADER;
	if(!isset($CMS['modules'])) $mod = getInstalledModules();
	else $mod = $CMS['modules'];
	while(list($k,$v)=each($mod)){
		$funcfile = 'module/'.$k.'/'.$k.'_function.php';
		if(file_exists($funcfile)) include($funcfile);
	}
}
function esc_str($str){
	return mysql_real_escape_string(stripslashes($str));
}

/* построение формы на основании данных конструктора форм */
function buildForm($idf){
	global $_conf,$db,$smarty,$lang_ar;
	$out = '<form method="post" action="javascript:void(null)" enctype="multipart/form-data" id="OWNFORM'.$idf.'">';
	$out .= '<input type="hidden" name="idf" id="idf" value="'.$idf.'" />';
	$r = $db -> Execute("select * from ".$_conf['prefix']."form where idf='".$idf."'");
	$t = $r -> GetRowAssoc(false);
	$rf = $db -> Execute("select * from ".$_conf['prefix']."form_field where idf='".$idf."' order by f_order");
	while(!$rf->EOF){
		$tf = $rf -> GetRowAssoc(false);
		$f_list = array();
		if($tf['f_list']!=""){
			$fl = explode(",",$tf['f_list']);
			while(list($k,$v)=each($fl)){
				$fl1 = explode(":",$v);
				$f_list[] = array('key'=>$fl1[0],'val'=>$fl1[1]);
			}
			reset($f_list);
		}
		$req = $tf['f_req']=="y" ? ' <span>*</span>' : '';
		$out .= '<p><label for="'.stripslashes($tf['f_name']).'">'.stripslashes($tf['f_label']).$req.'</label>';
		if($tf['f_type']=="text"){
			$out .= '<input type="text" name="'.stripslashes($tf['f_name']).'" id="'.stripslashes($tf['f_name']).'" value="'.htmlspecialchars(stripslashes($tf['f_init_val'])).'" />';
		}
		if($tf['f_type']=="textarea"){
			$out .= '<textarea name="'.stripslashes($tf['f_name']).'" id="'.stripslashes($tf['f_name']).'" />'.stripslashes($tf['f_init_val']).'</textarea>';
		}
		if($tf['f_type']=="radio"){
			while(list($k,$v)=each($f_list)){
				$chk = $k==$tf['f_init_val'] ? ' checked="checked"' : '';
				$out .= '<input type="radio" name="'.$tf['f_name'].'" id="'.$tf['f_name'].$k.'" value="'.$v['key'].'"'.$chk.' /> '.stripslashes($v['val']);
			}
		}
		if($tf['f_type']=="select"){
			$out .= '<select name="'.$tf['f_name'].'" id="'.$tf['f_name'].'">';
			while(list($k,$v)=each($f_list)){
				$sel = $v['key']==$tf['f_init_val'] ? ' selected="selected"' : '';
				$out .= '<option value="'.$v['key'].'"'.$sel.'> '.stripslashes($v['val']).'</option>';
			}
			$out .= '</select>';
		}
		if($tf['f_type']=="checkbox"){
			while(list($k,$v)=each($f_list)){
				$ar = explode(",",$tf['f_init_val']);
				$chk = in_array($v['key'],$ar) ? ' checked="checked"' : '';
				$out .= '<input type="checkbox" name="'.$tf['f_name'].'[]" id="'.$tf['f_name'].'[]" value="'.$v['key'].'"'.$chk.' /> '.stripslashes($v['val']);
			}
		}
		$out .= '</p>';
		$rf -> MoveNext();
	}
	$out .= '<p><input type="button" name="sendForm" id="sendForm" value="'.$lang_ar['send'].'" onclick="sendOwnForm(\'OWNFORM'.$idf.'\', \'FormFrame'.$idf.'\', \'FormLoad'.$idf.'\')" /> &nbsp; <span id="FormLoad'.$idf.'"></span></p>
	</form>';
	return '<div class="FormFrame" id="FormFrame'.$idf.'">'.$out.'</div>';
}
/*используется в responses_block*/
function stripSlashesSmart($value) {
    if (get_magic_quotes_gpc())
        return stripslashes($value);
	return $value;
}
?>