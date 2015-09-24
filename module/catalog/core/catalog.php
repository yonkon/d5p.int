<?php
/**
 * Родительский класс для всего каталога
 *
 * @author alexby <mail.alex.by@gmail.com>
 */
class Catalog
{
	/**
	 * Язык возвращаемых и записываемых данных.
	 * По дефолту русский.
	 *
	 * @var string двухбуквенное обозначение языка
	 */
	protected $language = 'ru';

	/**
	 * Экземпляр объекта для работы с бд
	 *
	 * @var object
	 */
	protected $db;

	/**
	 * Абсолютный путь к папке с файлами.
	 * Папка уже должна существовать.
	 *
	 * @var string
	 */
	protected static $pathToFilesDir;
	
	/**
	 * Устанавливаем переменные по дефолту
	 *
	 * @return null
	 */
	public function __construct()
	{
	}
	
	/**
	 * Устанавливает язык для каталога
	 *
	 * @param string $language двухбуквенное обозначение языка
	 * @return null
	 */
	public function setLanguage($language)
	{
		$this->language = $language;
	}
	
	/**
	 * Ищет в продуктах и категориях заданный текст
	 *
	 * @return array[{id} => ['name' => {название категории/продукта}, 'text' => {текст, где встречается искомое слово}, 'url' => {ссылка на страницу, где встречается}]] 
	 * @todo разнести поиск по классам продукта и категории
	 * @todo выводить сокращенный текст найденной строки
	 * @todo рефакторинг
	 */
	public function find($needle)
	{
		if(!isset($db)) {
			global $db;
			$this->db = $db;
		}
		$needle = strtolower($needle);

		$result = array();
		
		if(trim($needle) == '') {
			return $result;
		}
		
		/**
		 * Ищем в категориях
		 */
		$resultCategories = array();
		$findCategory = $this->db->execute(
			'
				SELECT `cat_category`.`idc`
				FROM `cat_category_lang`
				INNER JOIN `cat_category` 
					ON (
						`cat_category`.`idc` = `cat_category_lang`.`idc`
						AND `cat_category`.`switch` = 1)
				WHERE
					LOWER(`cat_category_lang`.`name`) LIKE ?
					OR LOWER(`cat_category_lang`.`description`) LIKE ?',
			array('%'.$needle.'%', '%'.$needle.'%'));
		
		include_once(dirname(__FILE__).'/category.php');
		
		if($findCategory->recordCount()) {
			while(!$findCategory->EOF) {
				$t = $findCategory->getRowAssoc(false);
				$foundCategory = new CatalogCategory();
				$foundCategory->init($t['idc']);
				$result[] = array(
					'name' => $foundCategory->getName(),
					'text' => '',
					'url' => $foundCategory->getUrl(),
				);
				$findCategory->moveNext();
			}
		}
		
		/**
		 * Ищем в продуктах
		 */		
		$resultProducts = array();
		$findProductInLangTable = $this->db->execute(
			'
				SELECT `cat_product`.`idp`
				FROM `cat_product_lang`
				INNER JOIN `cat_product` 
					ON (
						`cat_product`.`idp` = `cat_product_lang`.`idp`
						AND `cat_product`.`switch` = 1)
				WHERE
					LOWER(`cat_product_lang`.`name`) LIKE ?
					OR LOWER(`cat_product_lang`.`description`) LIKE ?',
			array('%'.$needle.'%', '%'.$needle.'%'));
		$findProductInAddinfoTable = $this->db->execute(
			'
				SELECT `cat_product`.`idp`
				FROM `cat_product_addinfo`
				INNER JOIN `cat_product` 
					ON (
						`cat_product`.`idp` = `cat_product_addinfo`.`idp`
						AND `cat_product`.`switch` = 1)
				WHERE LOWER(`cat_product_addinfo`.`value`) LIKE ?',
			array('%'.$needle.'%'));
			
		include_once(dirname(__FILE__).'/product.php');
		if($findProductInLangTable->recordCount()) {
			while(!$findProductInLangTable->EOF) {
				$t = $findProductInLangTable->getRowAssoc(false);
				$foundProduct = new CatalogProduct();
				$foundProduct->init($t['idp']);
				$resultProducts[$t['idp']] = array(
					'name' => $foundProduct->getName(),
					'text' => '',
					'url' => $foundProduct->getUrl(),
				);
				$findProductInLangTable->moveNext();
			}
		}
		if($findProductInAddinfoTable->recordCount()) {
			while(!$findProductInAddinfoTable->EOF) {
				$t = $findProductInAddinfoTable->getRowAssoc(false);
				$foundProduct = new CatalogProduct();
				$foundProduct->init($t['idp']);
				$resultProducts[$t['idp']] = array(
					'name' => $foundProduct->getName(),
					'text' => '',
					'url' => $foundProduct->getUrl(),
				);
				$findProductInAddinfoTable->moveNext();
			}
		}
		
		if(count($resultProducts)) {
			foreach($resultProducts as $product) {
				$result[] = $product;
			}
		}
		if(count($resultCategories)) {
			foreach($resultCategories as $category) {
				$result[] = $category;
			}
		}
		return $result;
	}
	
	/**
	 * Устанавливаем опции, характерные для движка, куда устанавливается каталог
	 *
	 * @param string $option название опции
	 * @param mixed $value значение опции
	 * @return bool удачно ли
	 */
	public static function setOption($option, $value)
	{
		if(in_array(
			$option, 
			array('pathToFilesDir'))
		) {
			self::$$option = $value;
			return true;
		}
		return false;
	}
}

/**
 * Устанавливаем опции каталога
 */
include dirname(__FILE__).'/options.php';