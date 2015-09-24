<?php
/**
 * Класс для работы с файлами в каталоге
 *
 * @author alexby <mail.alex.by@gmail.com>
 */

namespace Catalog
{
	class File
	{
		private $extension;
		
		private $name;
		
		public function __construct()
		{
		
		}
		
		/**
		 * Возвращает список файлов, соответствующих данному продукту
		 *
		 * @param int $idp идентификатор продукта
		 * @return array[{} => {idf - идентификатор файла}] массив с идентификаторами файлов, где значение - идентификатор
		 * @todo вынести из класса
		 */
		public static function getFilesList($idp)
		{
		
		}
		
		/**
		 * Возвращает имя файла
		 *
		 * @return string
		 */
		public function getFileName()
		{
		
		}
		
		/**
		 * Возвращает содержимое файла
		 *
		 * @return string
		 */
		public function getFileContents()
		{
		
		}
		
		/**
		 * Добавляет файл к данному продукту
		 *
		 * @param int $idp иднентификатор продукта
		 * @param string $fileTempPath абсолютный путь к файлу во временной папке
		 * @param string $name название файла
		 * @param string $comment комментарии к файлу
		 * @return idf идентификатор файла
		 */
		public static function addFile($idp, $fileTempPath, $name, $comment)
		{
		
		}

		/**
		 * Возвращает mime type в зависимости от расширения файла
		 *
		 * @return string
		 */
		private function getMimeType()
		{
			$mt = Array(
				'bmp' => 'image/bmp',
				'gif' => 'image/gif',
				'jpeg' => 'image/jpeg',
				'jpg' => 'image/jpeg',
				'jpe' => 'image/jpeg',
				'png' => 'image/png',
				'tiff' => 'image/tiff',
				'tif' => 'image/tiff',
				'au' => 'audio/basic',
				'snd' => 'audio/basic',
				'mid' => 'audio/midi',
				'midi' => 'audio/midi',
				'kar' => 'audio/midi',
				'mpga' => 'audio/mpeg',
				'mp2' => 'audio/mpeg',
				'mp3' => 'audio/mpeg',
				'ram' => 'audio/x-pn-realaudio',
				'rm' => 'audio/x-pn-realaudio',
				'rpm' => 'audio/x-pn-realaudio-plugin',
				'ra' => 'audio/x-realaudio',
				'wav' => 'audio/x-wav',
				'mpeg' => 'video/mpeg',
				'mpg' => 'video/mpeg',
				'mpe' => 'video/mpeg',
				'qt' => 'video/quicktime',
				'mov' => 'video/quicktime',
				'avi' => 'video/x-msvideo',
				'movie' => 'video/x-sgi-movie',
				'wrl' => 'model/vrml',
				'vrml' => 'model/vrml',
				'css' => 'text/css',
				'html' => 'text/html',
				'htm' => 'text/html',
				'asc' => 'text/plain',
				'txt' => 'text/plain',
				'rtx' => 'text/richtext',
				'rtf' => 'text/rtf',
				'sgml' => 'text/sgml',
				'sgm' => 'text/sgml',
				'xml' => 'text/xml',
				'gtar' => 'application/x-gtar',
				'tar' => 'application/x-tar',
				'zip' => 'application/zip',
				'rar' => 'application/x-rar-compressed',
				'doc' => 'application/msword',
				'docx' => 'application/msword',
				'xls' => 'application/vnd.ms-excel',
				'xlsx' => 'application/vnd.ms-excel',
				'ppt' => 'application/vnd.ms-powerpoint',
				'wbxml' => 'application/vnd.wap.wbxml',
				'wmlc' => 'application/vnd.wap.wmlc',
				'wmlsc' => 'application/vnd.wap.wmlscriptc',
				'wbmp' => 'image/vnd.wap.wbmp',
				'wml' => 'text/vnd.wap.wml',
				'wmls' => 'text/vnd.wap.wmlscript',
				'bin' => 'application/octet-stream',
				'dms' => 'application/octet-stream',
				'lha' => 'application/octet-stream',
				'exe' => 'application/octet-stream',
				'class' => 'application/octet-stream',
				'pdf' => 'application/pdf',
				'ai' => 'application/postscript',
				'eps' => 'application/postscript',
				'ps' => 'application/postscript',
				'swf' => 'application/x-shockwave-flash',);                 

			if(isset($mt[$this->extension])) {
				return $mt[$this->extension];
			}
			return 'application/zip';
		}
		
		private function sendHeadersToOutputFile()
		{
			header('Pragma: public');
			header('Content-Transfer-Encoding: none');

			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
			header('Cache-Control: no-store, no-cache, must-revalidate'); 
			header('Cache-Control: post-check=0, pre-check=0', FALSE); 
			header("Content-Type: octet-stream");
			
			header("Content-Type:".$this->getMimeType."; name=\"".$this->name."\"");
			header("Content-Disposition:attachment; filename=\"".self::$file['name']."\"");
			header("Content-Length:".self::$file['fsize']);
			echo self::$file['fcont'];

		}


	}
}