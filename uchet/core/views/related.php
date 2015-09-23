<?php

include_once dirname(__FILE__).'/view.php';

class UView extends UchetView
{
	public static $dicts = null;

	private function __construct()
	{}
	
	public static function init()
	{}


	public static function render($file)
	{
		$file = strtolower($file);
		
		if (isset(UCONFIG::$viewMode[$file]) && UCONFIG::$viewMode[$file] == 'smarty') {
			$result = self::renderSmarty($file);
		} else {
			$result = self::renderPhp($file);
		}
		
		//UDebug::add(self::$vars, 'view vars');
		self::$vars = null;
		
		return $result;
	}

	public static function renderSmarty($file)
	{
		if(!class_exists('Smarty')) {
			include_once UCONFIG::$includeDir.'smarty/Smarty.class.php';
		}
		$sm = new Smarty();
		self::smartyInit($sm);
		
		if(count(self::$vars)) {
			foreach(self::$vars as $key => $val) {
				$sm->assign($key, $val);
			}
		}
	
		return $sm->fetch($file.'.tpl');
	}
	
	public static function renderPhp($file)
	{
		ob_start();
		
		extract(self::$vars);

		$dicts = self::$dicts;
		
		if(is_file(UCONFIG::$tmplDir.$file.'.php')) {
			include UCONFIG::$tmplDir.$file.'.php';	
		} else {
			UError::newErrorMessage('6.2', Array('file' => UCONFIG::$tmplDir.$file.'.php'));
			return false;
		}
		
		return ob_get_clean();
	}
	
	public static function smartyInit(&$smarty)
	{
		if(method_exists($smarty, 'setTemplateDir')) {
			$smarty->setTemplateDir(UCONFIG::$tmplDir.'smarty/');
			$smarty->setCompileDir(UCONFIG::$tmpDirG.'smarty_temp/');
			$smarty->setConfigDir(UCONFIG::$configDir.'smarty/');
			$smarty->setCacheDir(UCONFIG::$tmpDirG.'smarty_cache/');
		} else {
			$smarty->template_dir = UCONFIG::$tmplDir.'smarty/';
			$smarty->compile_dir = UCONFIG::$tmpDirG.'smarty_temp/';
			$smarty->config_dir = UCONFIG::$configDir.'smarty/';
			$smarty->cache_dir = UCONFIG::$tmpDirG.'smarty_cache/';
		}
		$smarty->debugging = UCONFIG::$debug;
		$smarty->caching = UCONFIG::$smarty['caching'];
		$smarty->cache_lifetime = UCONFIG::$smarty['cache_lifetime'];
	}
	
}