<?php
/**
* Класс для работы с отзывами клиентов
*
* @author alexby
*/

class UModelResponses extends UchetModel
{
	/**
	* Пустой конструктор
	*/
	public function __construct()
	{}
	
	/**
	* Запуск модели
	*/
	public function run()
	{
		include(UCONFIG::$phpDir.'responses.php');
		$resp = new PhpResponses();
		if($this->request['operation'] == 'add') {
			if($resp->add($this->request)) {
				UCore::$code = 0;
			} else {
				UCore::$code = 1;
			}
		}
	}
	
	
}