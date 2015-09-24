<?php
/**
 * Класс для работы администратором с продуктами каталога
 *
 * @author alexby <mail.alex.by@gmail.com>
 */
include_once dirname(__FILE__).'/catalog.php';
 
class CatalogProductAdmin extends Catalog
{
	/**
	 * Id текущего продукта
	 *
	 * @var int
	 */
	private $idp;
	
	/**
	 * Инициализируем
	 *
	 * @param int/пусто $idp id текущго продукта
	 */
	public function __construct()
	{		
		global $db;
		$this->db = $db;
	}

	/**
	 * @todo writedown comments
	 */
	public function init($idp)
	{
		$this->idp = $idp;	
	}
	
	/**
	 * Включает-выключает показ текущего продукта на сайте
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
				UPDATE `cat_product`
				SET `switch` = ?
				WHERE `idp` = ?',
			array($switch, $this->idp));
	}
	
	/**
	 * Удаляет текущий продукт
	 *
	 * @return null
	 */
	public function deleteProduct()
	{
		$this->db->execute(
			'
				DELETE
				FROM `cat_product` 
				WHERE `idp` = ?',
			array($this->idp));
		$this->db->execute(
			'
				DELETE
				FROM `cat_product_lang` 
				WHERE `idp` = ?',
			array($this->idp));
		$this->db->execute(
			'
				DELETE
				FROM `cat_product_addinfo`
				WHERE `idp` = ?',
			array($this->idp));
		$this->db->execute(
			'
				DELETE
				FROM `cat_product_images` 
				WHERE `idp` = ?',
			array($this->idp));
	}

	/**
	 * Добавляет новый продукт
	 * Текущий продукт объявляется с id этого нового продукта.
	 *
	 * @param int $parentIdc id родительской категории
	 * @param array[string => string] $names 
	 * Ключ - язык, значение - имя текущего продукта, выводимое пользователям
	 * @param array[string => string] $descriptions
	 * Ключ - язык, значение - описание продукта
	 * @param int $sortOrder порядок сортировки
	 * @return int id нового продукта
	 * @todo загружать изображения в этой функции
	 */
	public function createProduct($parentIdc, $names, $descriptions, $sortOrder)
	{
		$this->db->execute(
			'
				INSERT 
				INTO `cat_product` 
				(`parent_category`, `sort_order`)
				VALUES (?, ?)',
			array($parentIdc, $sortOrder));
		$this->idp = $this->db->insert_ID();
		foreach($names as $language => $name) {
			$this->db->execute(
				'
					INSERT 
					INTO `cat_product_lang` 
					(`idp`, `name`, `description`, `language`)
					VALUES (?, ?, ?, ?)',
				array($this->idp, $name, $descriptions[$language], $language));
		}
		return $this->idp;
	}

	/**
	 * Привязывает изображения к текущей категории.
	 *
	 * @param string $thumbImagePath путь от корня сайта к изображению thumbnail, если пустое - пропускается
	 * @return null
	 */
	public function setThumbImagesToProduct($thumbImagePath)
	{
		$this->db->execute(
			'
				UPDATE `cat_product` 
				SET `thumb_image` = ? 
				WHERE `idp` = ?',
			array($thumbImagePath, $this->idp));
	}
	
	/**
	 * Редактирование текущего продукта
	 *
	 * @param int $parentIdc id родительской категории
	 * @param array[string => string] $names 
	 * Ключ - язык, значение - имя текущего продукта, выводимое пользователям
	 * @param array[string => string] $descriptions
	 * Ключ - язык, значение - описание продукта
	 * @param int $sortOrder порядок сортировки
	 * @return null
	 */
	public function editProduct($parentIdc, $names, $descriptions, $sortOrder)
	{
		$this->db->execute(
			'
				UPDATE `cat_product` 
				SET 
					`parent_category` = ?,
					`sort_order` = ?
				WHERE `idp` = ?',
			array($parentIdc, $sortOrder, $this->idp));
		foreach($names as $language => $name) {
			$this->db->execute(
				'
					UPDATE `cat_product_lang`
					SET 
						`name` = ?,
						`description` = ?
					WHERE 
						`idp` = ?
						AND `language` = ?',
				array($name, $descriptions[$language], $this->idp, $language));		
		}
	}
	
	/**
	 * Добавляет/редактирует дополнительное изображение для продукта
	 *
	 * @param string $imagePath путь от корня сайта к изображению
	 * @param int/пусто $idi если установлен - заменяет изображение с указанным id, если нет - добавляет новое
	 * @return int/null id нового изображения если входящий параметр $idi был пустым
	 */
	public function setAddImageToProduct($imagePath, $idi = null)
	{
		if(!empty($idi)) {
			$this->db->execute(
				'
					UPDATE `cat_product_images`
					SET `image_path` = ?
					WHERE `idi` = ?',
				array($imagePath, $idi));
		} else {
			$this->db->execute(
				'
					INSERT INTO `cat_product_images` 
					(`idp`, `image_path`)
					VALUES (?, ?)',
				array($this->idp, $imagePath));
			return $this->db->insert_ID();
		}
	}
	
	/**
	 * Устанавливает дополнительный параметр для данного продукта.
	 * Используется как при создании продукта, так и при редактировании.
	 *
	 * @param int $idpar id параметра
	 * @param array $values todo написать формат
	 * Ключ - язык, значение - значение параметра
	 * @reuturn null
	 */
	public function setAddInfo($idpar, $values)
	{
		$resultQuery = $this->db->execute(
			'
				SELECT count(`idai`)
				FROM `cat_product_addinfo`
				WHERE 
					`idp` = ?
					AND `idpar` = ?',
			array($this->idp, $idpar));
		$row = $resultQuery->getRowAssoc(false);
		if($row['count(`idai`)']) {
			foreach($values as $language => $value) {
				$this->db->execute(
					'
						UPDATE `cat_product_addinfo`
						SET `value` = ?
						WHERE 
							`idp` = ?
							AND `idpar` = ?
							AND `language` = ?',
					array($value, $this->idp, $idpar, $language));
			}
		} else {
			foreach($values as $language => $value) {
				$this->db->execute(
					'
						INSERT INTO `cat_product_addinfo` 
						(`idp`, `idpar`, `value`, `language`)
						VALUES (?, ?, ?, ?)',
					array($this->idp, $idpar, $value, $language));
			}
		}
	}
}