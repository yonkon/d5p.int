<?php
/**
 * Срипт для генерации защитного кода
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.02 01.07.2009
 */
error_reporting(E_ALL);
session_start();
//echo $_SESSION['check_code'];
header("Content-Type: image/png");
	$_SESSION['check_code']=rand(1000, 9999);
    get_checkcode_picture($_SESSION['check_code']);
    die;

function get_checkcode_picture($code){
	//putenv('GDFONTPATH=' . realpath('.'));
	$img=imagecreatetruecolor(60, 30);
	$bg = imagecolorallocate($img, 204, 204, 204);
	imagefill ($img,0,0, $bg);
	imagecolortransparent ($img,$bg);
	$grey = imagecolorallocate($img, 191, 146, 123);
	$black = imagecolorallocate($img, 234, 78, 0);
	$font = $_SERVER['DOCUMENT_ROOT'].'/arial.ttf';
	imagefttext($img, 16, -14, 1, 15, $grey, $font, $code);
	imagefttext($img, 16, 12, 1, 27, $black, $font, $code);

	imagepng($img);
	imagedestroy($img);
}

/** код для вставки в ХТМЛ-шаблон
        <strong>{$lang.reg_code}: *</strong> <input type="text" name="check_code" id="check_code" value="" style="width:50px;" /> <img src="check_code.php" border="0" vspace="1" hspace="1" id="ChkCodeImg" style="vertical-align:middle;"/>
        <a href="javascript:void(null)" onclick="document.getElementById('ChkCodeImg').src = 'check_code.php?'+Math.random();">update image</a>

*/


?>
