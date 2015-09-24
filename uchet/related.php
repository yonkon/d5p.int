<?php
/*
*
* Точка входа в кабинет клиента - как модуль
*
*/

$oldErrorReporting = error_reporting();
$oldDisplayErrors = ini_get('display_errors');
error_reporting(E_ALL);
ini_set('display_errors','On');

include dirname(__FILE__).'/core/loader.php';
include_once UCONFIG::$coreDir.'controllers/related.php';

if((session_id() == '') && (headers_sent($file, $line))) {
	UError::newErrorMessage('4.2', Array(
		'fname' => 'none',
		'file' => $file, 
		'line' => $line,
	));
	echo 'Ooops. Some error. Please contact administrator.<br />Внимание! Непредвиденная ошибка! Сообщите администратору.';
} else {
	if(session_id() == '') {
		session_start();
	}
	if(!empty($uchetPage)) {
		UCore::run($uchetPage);
		$uchetResult = UCore::$output;
		if($uchetPage != 'userblock') {
			$PAGE = $uchetResult;
		}
	} else {
		echo 'Ooops. Some error. Please contact administrator.<br />Внимание! Непредвиденная ошибка! Сообщите администратору.';
	}
}

error_reporting($oldErrorReporting);
ini_set('display_errors',$oldDisplayErrors);
spl_autoload_unregister('uAutoloader');