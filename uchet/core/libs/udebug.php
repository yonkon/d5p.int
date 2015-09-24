<?php

class UDebug
{
	private static $vars = null;
	
	private function __construct()
	{}
	
	private function init() {}
	
	public static function addVariable($var, $name = '')
	{
		self::add($var, $name);
	}
	
	public static function add($var, $name = '')
	{
		if(UCONFIG::$debug) {
			self::$vars[] = Array('name' => $name, 'var' => $var);
		}
	}
	
	public static function getVars()
	{
		return self::$vars;
	}
	
	public static function writeToLog()
	{
		if(count(self::$vars)) {
			ULog::writeSeparate('debug', self::$vars);
		}
	}
	
	public static function clear()
	{
		self::$vars = Array();
	}

}