<?php
/**
 * Класс для работы с продуктами каталога
 *
 * @version 0.1
 * @author alexby <mail.alex.by@gmail.com>
 */
include_once dirname(__FILE__).'/catalog.php';
 
class CatalogProduct extends Catalog
{
	/**
	 * Показывать все продукты или только не скрытые
	 *
	 * @var bool
	 */
	private $fullAccess = false;

	/**
	 * Id родительского каталога
	 *
	 * @var int
	 */
	private $parentIdc;
	
	/**
	 * id товара
	 *
	 * @var int
	 */
	private $idp;

	/**
	 * Имя товара, выводимое пользователю
	 *
	 * @var string
	 * Пример: 'Дом из будущего'
	 */
	private $name;
	
	/**
	 * Описание товара
	 *
	 * @var string
	 */
	private $description;
	
	/**
	 * Изображение на ссылку на товар
	 *
	 * @var string
	 * Пример: 'images/thumb_product.jpg'
	 */
	private $thumbImagePath;
	
	/**
	 * Дополнительную информацию о продукте.
	 *
	 * @var array[int => string] ключ - id параметра, значение - значение параметра
	 * Пример:
	 * array(
	 *		1 => 'о. Сардиния',
	 *		2 => '150',
	 *		3 => '8',
	 *	)
	 */
	private $addInfo;

	/**
	 * Список изображений продукта
	 *
	 * @var array[int => array[string => string]] ключ - id изображения, значение - массив, где:
	 * ключ - название, значение - значение. блин. как-то так. :)
	 * формат: array[{id изображения} => array['path' => {путь от корня сайта к изображению}]]
	 * Пример возвращаемых даных:
	 * array(
	 *		3 => 'images/product1.jpg',
	 *		5 => 'images/product17.jpg',
	 *		33 => 'images/product28.jpg',
	 *		99 => 'images/product26.jpg',
	 * )
	 */
	private $imagesList;
	
	/**
	 * Конструктор продукта. Инициализация.
	 *
	 * @param int/пусто $idp id продукта, если не установлен - без инициализации
	 */
	public function __construct()
	{
		global $db;
		$this->db = $db;
	}
	
	/**
	 * Возвращает статус включен-выключен показ данного товара
	 *
	 * @return bool
	 * @todo перенести в инициализацию
	 */
	public function getSwitchStatus()
	{
		$resultQuery = $this->db->execute(
			'
				SELECT `switch`
				FROM `cat_product`
				WHERE `idp` = ?',
			array($this->idp));
		$row = $resultQuery->getRowAssoc(false);
		return ($row['switch']) ? true : false;
	}
	
	/**
	 * Получаем путь к thumb-изображению товара
	 *
	 * @return string путь к изображению от корня сайта
	 * Пример возвращаемых данных:
	 * 'images/thumb_product.jpg'
	 */
	public function getThumb()
	{
		return $this->thumbImagePath;
	}
	
	/**
	 * Получаем основную информацию о товаре
	 *
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}	
	
	/**
	 * Получаем дополнительную информацию о продукте.
	 *
	 * @return array[int => string] ключ - id параметра, значение - значение параметра
	 * Пример возвращаемых данных:
	 * array(
	 *		1 => 'о. Сардиния',
	 *		2 => '150',
	 *		3 => '8',
	 *	)
	 */
	public function getAddInfo()
	{
		return $this->addInfo;
	}
	
	/**
	 * Возвращает урл продукта
	 *
	 * @return string url начиная с корня сайта
	 * Пример возвращаемых данных:
	 * 'sub-category/sub-sub-sub-category.php?idp=10'
	 */
	public function getUrl()
	{
		return '/item/idp/'.$this->idp.'/';
	}
	
	/**
	 * Возвращает имя продукта
	 *
	 * @return string
	 * Пример возвращаемых данных:
	 * 'Дом из будущего'
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Возвращает список изображений продукта
	 *
	 * @return array[int => array[string => string]] ключ - id изображения, значение - массив, где:
	 * ключ - название, значение - значение. блин. как-то так. :)
	 * формат: array[{id изображения} => array['path' => {путь от корня сайта к изображению}]]
	 * Пример возвращаемых даных:
	 * array(
	 *		3 => 'images/product1.jpg',
	 *		5 => 'images/product17.jpg',
	 *		33 => 'images/product28.jpg',
	 *		99 => 'images/product26.jpg',
	 * )
	 */
	public function getImagesList()
	{
		return $this->imagesList;
	}
	
	/**
	 * Возвращает порядок сортировки текущего продукта
	 *
	 * @return int
	 */	 
	public function getSortOrder() 
	{
		$resultQuery = $this->db->execute(
			'
				SELECT `sort_order`
				FROM `cat_product`
				WHERE `idp` = ?',
			array($this->idp));
		$row = $resultQuery->getRowAssoc(false);
		return $row['sort_order'];
	}
	
	/**
	 * Инициализация характеристик продукта
	 *
	 * @return null
	 * @todo написать
	 */
	public function init($idp)
	{
		$this->idp = $idp;

		$query = '
			SELECT 
				`cat_product`.`thumb_image`, `cat_product`.`parent_category`,
				`cat_product_lang`.`name`, `cat_product_lang`.`description`
			FROM `cat_product`
			LEFT JOIN `cat_product_lang` 
				ON (
					`cat_product`.`idp` = `cat_product_lang`.`idp`
					AND `cat_product_lang`.`language` = ?)
			WHERE 
				`cat_product`.`idp` = ?';
		$queryParams = array($this->language, $this->idp);
		if(!$this->fullAccess) {
			$query .= '
				AND `cat_product`.`switch` = ?';
			$queryParams[] = 1;
		}
		$resultQuery = $this->db->execute($query, $queryParams);
		if($resultQuery->recordCount()) {
			$row = $resultQuery->getRowAssoc(false);
			$this->name = $row['name'];
			$this->description = $row['description'];
			$this->thumbImagePath = $row['thumb_image'];
			$this->parentIdc = $row['parent_category'];
			$this->initAddInfo();
			$this->initImagesList();
			return true;
		}
		return false;
	}
	
	/**
	 * @todo writedown comments
	 */
	public function setFullAccess($isSetFullAccess)
	{
		$this->fullAccess = $isSetFullAccess;
	}
	
	/**
	 * Получаем id родителя текущего продукта
	 *
	 * @return int
	 */
	public function getParent()
	{
		return $this->parentIdc;
	}

	/**
	 * Инициализация дополнительной информации по продукту
	 *
	 * @return null
	 */
	private function initAddInfo()
	{
		$resultQuery = $this->db->execute(
			'
				SELECT `idpar`, `value`
				FROM `cat_product_addinfo`
				WHERE 
					`idp` = ?
					AND `language` = ?',
			array($this->idp, $this->language));
		$this->addInfo = array();
		if($resultQuery->recordCount()) {
			while(!$resultQuery->EOF) {
				$row = $resultQuery->getRowAssoc(false);
				$this->addInfo[$row['idpar']] = nl2br($row['value'], true);
				$resultQuery->moveNext();
			}
		}
	}

	/**
	 * Инициализация списка изображений продукта
	 *
	 * @return null
	 */
	private function initImagesList()
	{
		$resultQuery = $this->db->execute(
			'
				SELECT `idi`, `image_path`
				FROM `cat_product_images`
				WHERE `idp` = ?',
			array($this->idp));
		$this->imagesList = array();
		if($resultQuery->recordCount()) {
			while(!$resultQuery->EOF) {
				$row = $resultQuery->getRowAssoc(false);
				$this->imagesList[$row['idi']] = $row['image_path'];
				$resultQuery->moveNext();
			}
		}
	}
	
}