<?php
/*
* Класс для обработки запросов с чужих серверов
*
* @author alexby
*/
class UCore extends UchetController
{	
	private static $code = 2;
	
	private static $returnText;
	
	/*
	* Пустой приватный конструктор
	*
	* @return void
	*/
	private function __construct() {}

	/*
	* Инициализация приложения
	*
	* @return void
	*/
	public static function init()
	{
		register_shutdown_function('UCore::shutdownFunction');
		ob_start();		
	}
	
	/*
	* Запуск приложения
	*
	* @return bool
	*/
	public static function run()
	{
		self::init();

		ULog::writeSeparate('external-answer', $_REQUEST);
		
		$rk = new Robokassa();
		if($rk->applyRecievedData(self::prepareRequest())) {
			self::$code = 0;
		} else {
			self::$code = 1;
		}
		self::$returnText = $rk->getReturnText();
	}
	
	/*
	* Функция для возврата данных на удалённый сервер. Вызывается при завершении приложения.
	*
	* @return string ответ
	*/
	public static function shutdownFunction()
	{
		$ob_variable = ob_get_clean();
		
		$result['answer'] = self::$returnText;
		$result['debugOut'] = UDebug::getVars();
		$result['errors'] = UError::getErrorCodes();
		$result['textOut'] = $ob_variable;
		$result['code'] = self::$code;
		
		ULog::writeSeparate('external-answer', $result);
		
		echo $result['answer'];
		//здесь возвращается ответ в нужном виде
	}
}