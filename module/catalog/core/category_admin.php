<?php
/**
 * Класс для работы администратором с категориями в каталоге
 *
 * @author alexby <mail.alex.by@gmail.com>
 */
include_once dirname(__FILE__).'/catalog.php';

class CatalogCategoryAdmin extends Catalog
{
	/**
	 * Id текущей категории
	 *
	 * @var int
	 */
	private $idc;
	
	/**
	 * Инициализируем
	 *
	 * @param int/пусто $idc id текущей категории
	 */
	public function __construct()
	{
		global $db;
		$this->db = $db;
	}
	
	/**
	 * Включает-выключает показ текущей категории на сайте
	 *
	 * @param bool $switch в какое положение устанавливается показ
	 * @return null
	 */
	public function turnSwitcher($switch)
	{
		if($switch) {
			$switch = 1;
		} else {
			$switch = 0;
		}
		$this->db->execute(
			'
				UPDATE `cat_category`
				SET `switch` = ?
				WHERE `idc` = ?',
			array($switch, $this->idc));
	}
	
	/**
	 * Удаляет текущую категорию
	 *
	 * @return bool удалось ли удалить каталог
	 * Возвращает false если категория не является листом дерева(есть продукты или подкатегории подчиненные)
	 * @todo удалять рекурсивно все листья категории(?)
	 */
	public function deleteCategory()
	{
		$resultQuery = $this->db->execute(
			'
				SELECT count(`idp`)
				FROM `cat_product`
				WHERE `parent_category` = ?',
			array($this->idc));
		$resultQuery1 = $this->db->execute(
			'
				SELECT count(`idc`)
				FROM `cat_category`
				WHERE `parent_category` = ?',
			array($this->idc));
		$row = $resultQuery->getRowAssoc(false);
		$row1 = $resultQuery1->getRowAssoc(false);
		if($row['count(`idp`)'] || $row1['count(`idc`)']) {
			return false;
		}
		$this->db->execute(
			'
				DELETE
				FROM `cat_category` 
				WHERE `idc` = ?',
			array($this->idc));
		$this->db->execute(
			'
				DELETE
				FROM `cat_category_lang` 
				WHERE `idc` = ?',
			array($this->idc));
		return true;
	}
	
	/**
	 * Добавляет новую категорию на сайт. 	 
	 * Текущая категория объявляется с id этой новой категории.
	 *
	 * @param int $parentIdc id родительской категории
	 * @param array[string => string] $names 
	 * Ключ - язык, значение - имя текущей категории, выводимое пользователям
	 * @param int $sortOrder порядок сортировки
	 * @return int id новой категории
	 * @todo загружать изображения в этой функции
	 */
	public function createCategory($parentIdc, $names, $sortOrder)
	{
		$this->db->execute(
			'
				INSERT 
				INTO `cat_category` 
				(`parent_category`, `sort_order`)
				VALUES (?, ?)',
			array($parentIdc, $sortOrder));
		$this->idc = $this->db->insert_ID();
		foreach($names as $language => $name) {
			$this->db->execute(
				'
					INSERT 
					INTO `cat_category_lang` 
					(`idc`, `name`, `language`)
					VALUES (?, ?, ?)',
				array($this->idc, $name, $language));
		}
		return $this->idc;
	}
	
	/**
	 * Привязывает изображения к текущей категории.
	 *
	 * @param string $thumbImagePath путь от корня сайта к изображению thumbnail, если пустое - пропускается
	 * @return null
	 */
	public function setThumbToCategory($thumbImagePath)
	{
		if(!empty($thumbImagePath)) {
			$this->db->execute(
				'
					UPDATE `cat_category` 
					SET `thumb_image` = ? 
					WHERE `idc` = ?',
				array($thumbImagePath, $this->idc));
		}
	}
	
	/**
	 * Редактирование текущей категории
	 *
	 * @param int $parentIdc id родительской категории
	 * @param array[string => string] $names 
	 * Ключ - язык, значение - имя текущей категории, выводимое пользователям
	 * @param int $sortOrder порядок сортировки
	 * @return null
	 */
	public function editCategory($parentIdc, $names, $sortOrder)
	{
		$this->db->execute(
			'
				UPDATE `cat_category`
				SET 
					`parent_category` = ?,
					`sort_order` = ?
				WHERE `idc` = ?',
			array($parentIdc, $sortOrder, $this->idc));
		foreach($names as $language => $name) {
			$this->db->execute(
				'
					UPDATE `cat_category_lang`
					SET `name` = ?
					WHERE 
						`idc` = ?
						AND `language` = ?',
				array($name, $this->idc, $language));
		}
	}
	
	/**
	 * @todo writedown comments
	 */
	public function init($idc)
	{
		$this->idc = $idc;
	}
}