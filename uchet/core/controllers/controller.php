<?php

class UchetController
{
	public static $model = null;
	public static $output = '';
	public static $wrongOutput = '';
	
	private function __construct() {}
	
	public static function loadModel($model) 
	{
		$className = 'UModel'.ucfirst(strtolower($model));
		if(!class_exists($className)) {
			$classPath = UCONFIG::$modelsDir.strtolower($model).'.php';
			if (!is_file($classPath)) {
				self::$model = false;
				return false;
			}
			include $classPath;
		}
		self::$model = new $className;
		return true;
	}

	public static function prepareRequest() 
	{
		return self::prepareValue($_REQUEST);
	}
	
	public static function addIpToDebug($ip)
	{
		if($_SERVER['REMOTE_ADDR'] == $ip) {
			UCOFIG::$debug = true;
		}
	}

	public static function addUserToDebug($idu)
	{
		if(UUser::$idu == $idu) {
			UCOFIG::$debug = true;
		}
	}
	
	private static function prepareValue($value) 
	{
		if (get_magic_quotes_gpc()) {
			if (is_array($value)) {
				$arr = Array();
				foreach($value as $key => $val) {
					$arr[$key] = self::prepareValue($val);
				}
				return $arr;
			}
			return stripslashes($value);
		}		
		return $value;
	}
}