<?php
/*
* Статический класс для логирования
*
* @author alexby <mail.alex.by@gmail.com>
*/
class ULog
{
	/**
	 * Время первой записи лога в процессе выполнения скрипта
	 *
	 * @var string время и дата формата 'y.m.d_H-i-s'
	 */
	private static $dateFirstRun;
	
	/**
	 * Флаг включения экономии места на диске в логах
	 *
	 * @var bool
	 */
	private static $sizeEconomy = true;
	
	/**
	 * Максимальная длина строки в логе
	 *
	 * @var int
	 */
	private static $maxLineSize = 5000;
	
	/*
	 * Пустой приватный конструктор
	 */
	private function __construct() 
	{}
	
	/*
	 * Записать/дописать в лог информацию
	 *
	 * @param string $logName название лога, в который записать информацию
	 * @param mixed $content информация для записи
	 * @return bool результат записи
	 */
	public static function write($logName, $content)
	{
		$logFile = fopen(UCONFIG::$logDir.$logName.'.txt', 'a');
		fwrite($logFile, date("d.m.y H:i:s")."\r\n\t".print_r($content,true)."\r\n");
		fclose($logFile);
		return true;
	}
	
	/**
	 * Устанавливает флаг экономии места на диске
	 *
	 * @param bool $status
	 */
	public static function setSizeEconomy($status)
	{
		self::$sizeEconomy = $status;
	}
	
	/*
	 * Записать в отдельный лог информацию
	 *
	 * @param string $logName название лога-папки, в который записать информацию
	 * @param mixed $content информация для записи
	 * @return null
	 */	
	public static function writeSeparate($logName, $content) 
	{
		if(!isset(self::$dateFirstRun)) {
			self::$dateFirstRun = date("y.m.d_H-i-s");
		}
		if(!is_dir(UCONFIG::$logDir.$logName.'/')) {
			if(!mkdir(UCONFIG::$logDir.$logName.'/', 0777, true)) {
				self::write('error', 'can\'t create folder '.UCONFIG::$logDir.$logName.'/');
			}
		}
		$countDirFiles = scandir(UCONFIG::$logDir.$logName.'/');
		while(count($countDirFiles)-3 > UCONFIG::$maxCountLogs) {
			unlink(UCONFIG::$logDir.$logName.'/'.$countDirFiles[2]);
			$countDirFiles = scandir(UCONFIG::$logDir.$logName.'/');
		}
		$logFile = fopen(UCONFIG::$logDir.$logName.'/'.self::$dateFirstRun.'.txt', 'a');
		if(self::$sizeEconomy) {
			$content = self::filterContentToEconomSize($content);
		}
		fwrite($logFile, print_r($content,true)."\r\n\r\n\r\n");
		fclose($logFile);
	}
	
	/**
	 * Отредактировать содержимое файла для экономии места на диске
	 *
	 * @param mixed $content информация для редактирования
	 * @return mixed резльтат обработки
	 * @todo работать с $content по ссылке, не создавать копию
	 * @todo обрезать также и элементы объектов, а не только массивов
	 */
	private static function filterContentToEconomSize($content)
	{
		if(is_array($content)) {
			foreach($content as $key => $val) {
				$content[$key] = self::filterContentToEconomSize($val);
			}
		} elseif(is_string($content)) {
			$lineLength = strlen($content);
			if($lineLength > self::$maxLineSize) {
				$content = substr($content, 0, self::$maxLineSize)
					.'... [cutted: line is too big][original line length: '.$lineLength.']';
			}
		}
		return $content;
	}
	
}