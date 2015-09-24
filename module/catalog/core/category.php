<?php
/**
 * Класс для работы с категориями каталога
 *
 * @version 0.1
 * @author alexby <mail.alex.by@gmail.com>
 * @todo сделать флаг инициализирована ли категория.
 * @todo оптимизация. разбить инициализацию на две части по требуемым данным.
 * @todo работать с дополнительными параметрами категории
 */
include_once dirname(__FILE__).'/catalog.php';
 
class CatalogCategory extends Catalog
{
	/**
	 * Показывать все категории или только не скрытые
	 *
	 * @var bool
	 */
	private $fullAccess = false;
	
	/**
	 * id категории
	 *
	 * @var int
	 */
	private $idc;

	/**
	 * Id родительского каталога
	 *
	 * @var int
	 */
	private $parentIdc;
	
	/**
	 * Имя категории, выводимое пользователю
	 *
	 * @var string
	 * Пример: 'Эксклюзивные предложения'
	 */
	private $name;

	/**
	 * Список продуктов в категории
	 *
	 * @var array[int => int] значение - id продукта
	 * Пример: array(3, 8, 12)
	 */	
	private $productList;
	
	/**
	 * Список подчиненных категорий.
	 *
	 * @var string
	 * Пример: array(1, 5, 10)
	 */
	private $subCategoriesList;
	
	/**
	 * Изображение на ссылку на категорию
	 *
	 * @var string
	 * Пример: 'images/thumb_category.jpg'
	 */
	private $thumbImagePath;
	
	/**
	 * Включен-выключен показ.
	 *
	 * @var bool
	 */
	private $switchStatus;
	
	/**
	 * Конструктор категории. Инициализация.
	 *
	 * @param int/пусто $idc id категории, если не установлен - без инициализации
	 * @param bool/пусто $full если установлен в true - загружать отключенные работы
	 */
	public function __construct()
	{
		global $db;
		$this->db = $db;
	}
	
	/**
	 * Возвращает статус включен-выключен показ данной категории
	 *
	 * @return bool
	 */
	public function getSwitchStatus()
	{
		$resultQuery = $this->db->execute(
			'
				SELECT `switch`
				FROM `cat_category`
				WHERE `idc` = ?',
			$this->idc);
		$row = $resultQuery->getRowAssoc(false);
		return ($row['switch']) ? true : false;
	}
	
	/**
	 * Получаем путь к thumb-изображению категории 
	 *
	 * @return string путь к изображению от корня сайта без слеша вначале
	 * Пример возвращаемых данных:
	 * 'images/thumb_category.jpg'
	 */
	public function getThumb()
	{
		return $this->thumbImagePath;
	}
	
	/**
	 * Получаем список продуктов в категории
	 *
	 * @param string $orderBy сортировка по полю
	 * @return array[int => int] значение - id продукта
	 * Пример возвращаемых данных:
	 * array(3, 8, 12)
	 */
	public function getProductsList($orderBy = null)
	{
		$this->initProductsList($orderBy);
		return $this->productList;
	}
	
	/**
	 * Получаем список подчиненных категорий
	 * 
	 * @param string $orderBy сортировка по полю
	 * @return array[int => int] значение - id категории
	 * Пример возвращаемых данных:
	 * array(1, 5, 10)
	 */
	public function getSubCategoriesList($orderBy = null)
	{
		$this->initSubCategoriesList($orderBy);
		return $this->subCategoriesList;
	}


	/**
	 * Возвращает урл категории.
	 *
	 * @return string url начиная с корня сайта
	 * Пример возвращаемых данных:
	 * 'sub-category/sub-sub-category.php?idc=97'
	 */
	public function getUrl()
	{
		return 'category/idc/'.$this->idc.'/';
	}
	
	/**
	 * Получаем title страницы.
	 * 
	 * @return string
	 * Пример возвращаемых данных:
	 * 'Эксклюзивные предложения'
	 */
	public function getName()
	{
		return $this->name;
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
				FROM `cat_category`
				WHERE `idc` = ?',
			array($this->idc));
		$row = $resultQuery->getRowAssoc(false);
		return $row['sort_order'];
	}
	
	/**
	 * Получаем id родительской категории
	 *
	 * @return int
	 */
	public function getParent()
	{
		return $this->parentIdc;
	}
	
	/**
	 * Возвращает уровень текущей категории
	 *
	 * @return int
	 * 1 уровень - сразу под корнем
	 */
	public function getLevel()
	{
		if(!isset($this->level)) {
			$this->initLevel();
		}
		return $this->level;
	}
	
	/**
	 * Инициализация всех данных категории
	 *
	 * @param int idc
	 * @return bool удалось ли
	 */
	public function init($idc)
	{
		$this->idc = $idc;
		
		$query = '
			SELECT 
				`cat_category`.`thumb_image`, `cat_category`.`parent_category`,
				`cat_category_lang`.`name`
			FROM `cat_category`
			LEFT JOIN `cat_category_lang` 
				ON (
					`cat_category`.`idc` = `cat_category_lang`.`idc` 
					AND `cat_category_lang`.`language` = ?)
			WHERE 
				`cat_category`.`idc` = ?';
		$queryParameters = array($this->language, $this->idc);
		if(!$this->fullAccess) {
			$query .= '
				AND `cat_category`.`switch` = ?';
			$queryParameters[] = 1;
		}
		$resultQuery = $this->db->execute($query, $queryParameters);
		if($resultQuery->recordCount()) {
			$row = $resultQuery->getRowAssoc(false);
			$this->name = $row['name'];
			$this->parentIdc = $row['parent_category'];
			$this->thumbImagePath = $row['thumb_image'];
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
	 * Вычисляем уровень текущей категории.
	 * Результат вычисления записывается в $this->level.
	 *
	 * @return null
	 */
	private function initLevel()
	{
		$level = 0;
		$currentCategory = $this->idc;
		do {
			$parent = $this->db->execute(
				'
					SELECT `parent_category`
					FROM `cat_category`
					WHERE `idc` = ?',
				array($currentCategory));
			$row = $parent->getRowAssoc(false);
			$currentCategory = $row['parent_category'];
			$level++;
		} while ($currentCategory);
		$this->level = $level-1;
	}

	/**
	 * Инициализируем список продуктов в данной категории.
	 *
	 * @param string $orderBy по какому полю сортировать, если не установлено - сортируется по полю "порядок сортировки"
	 * @return null
	 */
	private function initProductsList($orderBy = null)
	{
		/**
		 * Фильтруем по белому списку
		 */
		if($orderBy != 'name') {
			unset($orderBy);
		}

		$query = '
			SELECT `cat_product`.`idp`
			FROM `cat_product`
			LEFT JOIN `cat_product_lang` ON (
				`cat_product`.`idp` = `cat_product_lang`.`idp`
				AND `language` = ?
			)
			WHERE 
				`parent_category` = ?';
		$queryParameters = array($this->language, $this->idc);
		if(!$this->fullAccess) {
			$query .= '
				AND `switch` = ?';
			$queryParameters[] = 1;
		}
		$query .= '
			ORDER BY '.(isset($orderBy) ? '`'.$orderBy.'`, ' : '').' `sort_order`, `idp`';
		$resultQuery = $this->db->execute($query, $queryParameters);
		$this->productList = array();
		if($resultQuery->recordCount()) {
			while(!$resultQuery->EOF) {
				$row = $resultQuery->getRowAssoc(false);
				$this->productList[] = $row['idp'];
				$resultQuery->moveNext();
			}
		}	
	}
	
	/**
	 * Инициализируем список подкатегорий
	 *
	 * @param string $orderBy по какому полю сортировать, если не установлено - сортируется по полю "порядок сортировки"
	 * @return null
	 */
	private function initSubCategoriesList($orderBy = null)
	{
		/**
		 * Фильтруем по белому списку
		 */
		if($orderBy != 'name') {
			unset($orderBy);
		}

		$query = '
			SELECT `cat_category`.`idc`
			FROM `cat_category`
			LEFT JOIN `cat_category_lang` ON (
				`cat_category`.`idc` = `cat_category_lang`.`idc`
				AND `language` = ?
			)
			WHERE 
				`parent_category` = ?';
		$queryParameters = array($this->language, $this->idc);
		if(!$this->fullAccess) {
			$query .= '
				AND `switch` = ?';
			$queryParameters[] = 1;
		}
		$query .= '
			ORDER BY '.(isset($orderBy) ? '`'.$orderBy.'`, ' : '').'`sort_order`, `cat_category`.`idc`';
		$resultQuery = $this->db->execute($query, $queryParameters);
		$this->subCategoriesList = array();
		if($resultQuery->recordCount()) {
			while(!$resultQuery->EOF) {
				$row = $resultQuery->getRowAssoc(false);
				$this->subCategoriesList[] = $row['idc'];
				$resultQuery->moveNext();
			}
		}		
	}
}