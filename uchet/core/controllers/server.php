<?php
/*
* Класс для обработки запросов с удалённого сервера
*
* @author alexby
*/
class UCore extends UchetController
{
	/**
	* Возвращаемый код: 0 - всё ок, 1 - ошибка, 2 - неизвестно
	*/
	public static $code = 2;
	
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

		ULog::writeSeparate('answer/'.(isset($_REQUEST['act']) ? $_REQUEST['act'] : 'unknown'), $_REQUEST);
		
		if(self::checkHost()) {
			if(self::loadModel($_REQUEST['act'])) {
				self::$model->setRequest(self::prepareRequest());
				self::$model->run();
			} else {
				return false;
			}
		}
	}
	
	/*
	* Авторизация удалённого хоста
	*
	* @return bool
	*/
	private static function checkHost()
	{
		if($_REQUEST['password'] != UCONFIG::$password) {
			return false;
		}
		return true;
	}
	
	/*
	* Функция для возврата данных на удалённый сервер. Вызывается при завершении приложения.
	*
	* @return string ответ
	*/
	public static function shutdownFunction()
	{
		$ob_variable = ob_get_clean();
		
		if(self::$model) {
			$answer['data'] = self::$model->getResultVars();
		} else {
			$answer['data'] = Array('model' => 'none');
		}
		$answer['debugOut'] = UDebug::getVars();
		$answer['errors'] = UError::getErrorCodes();
		$answer['code'] = self::$code;
		$answer['textOut'] = $ob_variable;
		
		ULog::writeSeparate('answer/'.(isset($_REQUEST['act']) ? $_REQUEST['act'] : 'unknown'), $answer);
		
		echo json_encode($answer);
	}
	
	/*
	* Декодирует данные с удалённого сервера
	* 
	* @return array of mixed данные
	*/
	public static function prepareRequest()
	{
		$request = parent::prepareRequest();
		return json_decode($request['data'], true);
	}
}