<?php
if(!function_exists('uAutoloader')) {
	function uAutoloader($class)
	{
		if(is_file(dirname(__FILE__).'/libs/'.strtolower($class).'.php')) {
			include dirname(__FILE__).'/libs/'.strtolower($class).'.php';
		}
	}
	if(function_exists('__autoload')) {
		spl_autoload_register('__autoload');
	}

	include dirname(dirname(__FILE__)).'/config.php';
	include dirname(__FILE__).'/models/model.php';
	include dirname(__FILE__).'/views/related.php';
	include dirname(__FILE__).'/controllers/controller.php';
}
spl_autoload_register('uAutoloader');