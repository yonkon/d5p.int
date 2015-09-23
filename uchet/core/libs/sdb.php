<?php
/**
 * Класс для работы с базой данных движка, на который ставится кабинет
 *
 * @author alexby <mail.alex.by@gmail.com>
 * @todo вернуть SET NAMES который был в движке
 */
class SDB
{
	/**
	 * Экземпляр объекта для соединения с базой данных
	 *
	 * @var object
	 */
	private static $db;
	
	/**
	 * Пустой приватный конструктор
	 */
	private function __construct() 
	{}
	
	/**
	 * Выполнить sql запрос к базе данных на сервере
	 *
	 * @param string $query sql запрос
	 * @param array of string/int $params параметры в параметризированные запросы
	 * @return bool удалось ли выполнить запрос
	 */
	public static function execute($query, $params = null)
	{
		if(empty(self::$db)) {
			if(!class_exists('NewADOConnection')) {
				include(UCONFIG::$includeDir.'adodb5/adodb.inc.php');
			}
			
			self::$db = NewADOConnection('mysql');
			if(!self::$db->connect(UCONFIG::$db['server'], UCONFIG::$db['user'], UCONFIG::$db['pass'], UCONFIG::$db['dbName'])) {
				UError::newErrorMessage('7.1');
				return false;
			}
			
			self::$db->execute('SET NAMES '.UCONFIG::$db['charset']);
		}
		if(self::$db->execute($query, $params)) {
			return true;
		}
		return false;
	}

}