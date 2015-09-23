<?php
/**
 * Класс для работы со списком параметров продукции
 *
 * @version 0.1
 * @author alexby <mail.alex.by@gmail.com>
 * @todo инициализировать один раз и хранить в памяти список
 */
include_once dirname(__FILE__).'/catalog.php';
 
class CatalogParameters extends Catalog
{
	/**
	 * Пустые приватные методы.
	 * Делаем класс статическим.
	 */
	public function __construct($language = 'ru')
	{
		parent::__construct($language);
	}
	
	/**
	 * Получаем список параметров.
	 *
	 * @return array[int => array[string => string]] ключ - id параметра, значение - массив, где:
	 * ключ - название, значение - значение. блин. как-то так. :)
	 * формат: array[{id параметра} => array['name' => {название параметра, которое показывается людям}]]
	 * Пример возвращаемых данных:
	 * array(
	 *		1 => 'Местоположение',
	 *		2 => 'Общая площадь',
	 *		3 => 'Количество спален',
	 *	)
	 */
	public function getList()
	{
		global $db;
		$result = array();
		$resultQuery = $db->execute(
			'
				SELECT `idpa`, `name`
				FROM `cat_product_parameters`
				WHERE `language` = ?',
			array($this->language));
		if($resultQuery->recordCount()) {
			while(!$resultQuery->EOF) {
				$row = $resultQuery->getRowAssoc(false);
				$result[$row['idpa']] = $row['name'];
				$resultQuery->moveNext();
			}
		}
		return $result;
	}
}