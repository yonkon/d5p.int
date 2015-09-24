<?php
/**
* Класс для управления частью View в MVC
*
* @author alexby <mail.alex.by@gmail.com>
*/

class UchetView
{
	/**
	* Переменные, которые передаются для отображения
	*/
	public static $vars = Array();
	
	/**
	* Массив переменных с установленными индивидуально словами-фразами на сверке
	*/
	public static $lang;
	
	/**
	* Названия полей в форме заказа
	*/
	public static $fields;
	
	/**
	* Если на вывод должен идти файл - информация о файле и содержимое его.
	*/
	private static $file;

	/**
	*
	*/
	private function __construct() 
	{}
	
	/**
	* Заполняет переменные для отображения
	*
	* @param array of mixed $variables ассоциативный массив с переменными, где ключ - название переменной, значение - значение ее
	* @return null
	*/
	public static function setVars($variables)
	{
		self::$vars = $variables;
	}
	
	/**
	* Выводит массив в удобочитаемом виде в html
	*
	* @param array of mixed $arr
	* @return null
	*/
	public static function printArray($arr)
	{
		echo str_replace(
			Array(1=>'    ',2=>"\t"),
			'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			str_replace(
				"\n",
				'<br />',
				htmlspecialchars(print_r($arr,true))
			)
		);
	}
	
	/**
	* Сборщик мусора. Необходим при неоднократном инклюде скриптов кабинета клиента.
	*
	* @return null
	*/
	public static function clear()
	{
		$vars = Array();
		$fields = null;
	}
	
	/**
	* Посылает на вывод файл
	*
	* @param $file
	* @return null
	*/
	public static function outputFile($file)
	{
		self::$file = $file;
		
		if(ini_get('zlib.output_compression')) {
			@ini_set('zlib.output_compression', 'Off');
		}
		
		$obStatus = ob_get_status();
		while(!empty($obStatus['level'])) {
			ob_end_clean();
			$obStatus = ob_get_status();
		}
		self::writeOutFile();
	}
	
	/**
	* Выдает файл пользователю с диалогом
	*
	* @return null
	*/
	private static function writeOutFile()
	{
		// Mime типы
		$mt = Array(
			'bmp'=>'image/bmp',
			'gif'=>'image/gif',
			'jpeg'=>'image/jpeg',
			'jpg'=>'image/jpeg',
			'jpe'=>'image/jpeg',
			'png'=>'image/png',
			'tiff'=>'image/tiff',
			'tif'=>'image/tiff',
			'au'=>'audio/basic',
			'snd'=>'audio/basic',
			'mid'=>'audio/midi',
			'midi'=>'audio/midi',
			'kar'=>'audio/midi',
			'mpga'=>'audio/mpeg',
			'mp2'=>'audio/mpeg',
			'mp3'=>'audio/mpeg',
			'ram'=>'audio/x-pn-realaudio',
			'rm'=>'audio/x-pn-realaudio',
			'rpm'=>'audio/x-pn-realaudio-plugin',
			'ra'=>'audio/x-realaudio',
			'wav'=>'audio/x-wav',
			'mpeg'=>'video/mpeg',
			'mpg'=>'video/mpeg',
			'mpe'=>'video/mpeg',
			'qt'=>'video/quicktime',
			'mov'=>'video/quicktime',
			'avi'=>'video/x-msvideo',
			'movie'=>'video/x-sgi-movie',
			'wrl'=>'model/vrml',
			'vrml'=>'model/vrml',
			'css'=>'text/css',
			'html'=>'text/html',
			'htm'=>'text/html',
			'asc'=>'text/plain',
			'txt'=>'text/plain',
			'rtx'=>'text/richtext',
			'rtf'=>'text/rtf',
			'sgml'=>'text/sgml',
			'sgm'=>'text/sgml',
			'xml'=>'text/xml',
			'gtar'=>'application/x-gtar',
			'tar'=>'application/x-tar',
			'zip'=>'application/zip',
			'rar'=>'application/x-rar-compressed',
			'doc'=>'application/msword',
			'docx'=>'application/msword',
			'xls'=>'application/vnd.ms-excel',
			'xlsx'=>'application/vnd.ms-excel',
			'ppt'=>'application/vnd.ms-powerpoint',
			'wbxml'=>'application/vnd.wap.wbxml',
			'wmlc'=>'application/vnd.wap.wmlc',
			'wmlsc'=>'application/vnd.wap.wmlscriptc',
			'wbmp'=>'image/vnd.wap.wbmp',
			'wml'=>'text/vnd.wap.wml',
			'wmls'=>'text/vnd.wap.wmlscript',
			'bin'=>'application/octet-stream',
			'dms'=>'application/octet-stream',
			'lha'=>'application/octet-stream',
			'exe'=>'application/octet-stream',
			'class'=>'application/octet-stream',
			'pdf'=>'application/pdf',
			'ai'=>'application/postscript',
			'eps'=>'application/postscript',
			'ps'=>'application/postscript',
			'swf'=>'application/x-shockwave-flash'
		);                 

		if(isset($mt[self::$file['ext']])) {
			$mime = $mt[self::$file['ext']];
		} else {
			$mime="application/zip";
		}

		header('Pragma: public');
		header('Content-Transfer-Encoding: none');

		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
		header('Cache-Control: no-store, no-cache, must-revalidate'); 
		header('Cache-Control: post-check=0, pre-check=0', FALSE); 
		header("Content-Type: octet-stream");
		
		header("Content-Type:".$mime."; name=\"".self::$file['name']."\"");
		header("Content-Disposition:attachment; filename=\"".self::$file['name']."\"");
		header("Content-Length:".self::$file['fsize']);
		echo self::$file['fcont'];
	}
}