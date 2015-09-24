<?php

class UError
{
	private static $arrayOfMessages = Array();
	
	private static $important = Array('2.1', '2.4', '2.6', '2.7', '2.15', '2.16', '2.17', '2.18', '2.19', '2.26', '3', '4.2', '4.3', '5.1', '5.4', '5.5', '5.6', '6.1', '6.2');// Critical errors that must be logged
	private static $silent = Array();
	
	private function __construct() {}
	
	public static function newErrorMessage($code, $descr = Array())
	{
		if(self::isImportant($code)) {
			ULog::write('error', 'error by UError('.$code.') '.print_r($descr, true));
		}
		if(count($descr)) {
			foreach($descr as $key => $val) {
				if(isset($val)) {
					$descr[$key] = (is_string($val)) ? htmlspecialchars($val) : $val;
				}
			}
		}
		self::$arrayOfMessages[(string)$code] = $descr;
	}
	
	public static function getErrorCodes()
	{
		return self::$arrayOfMessages;
	}
	
	private static function isImportant($code)
	{
		$codeArr = explode('.', $code);
		$subCode = '';
		for ($i=0; $i<count($codeArr); $i++) {
			$subCode .= ((!empty($subCode)) ? '.' : '').$codeArr[$i];
			if(in_array($subCode, self::$important)) {
				return true;
			}
		}
		return false;
	}
	
	public static function clear()
	{
		self::$arrayOfMessages = Array();
	}
	
}