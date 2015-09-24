<?php
/**
* Добавление и редактирование продукта.
*	act ==	add - форма добавления нового продукта, минимальный вывод данных.
*		 	edit (редактировать)
*			saveEdited (перезаписать)
*			saveNew (сохранить новый раздел)
*/
include_once dirname(dirname(__FILE__)).'/core/category.php';
include_once dirname(dirname(__FILE__)).'/core/product.php';
include_once dirname(dirname(__FILE__)).'/core/parameters.php';
include_once dirname(dirname(__FILE__)).'/core/product_admin.php';

/**
 * Определяем список полей, которые будут textarea or input.
 */
$listIdParameters = array(
	'textarea' => array(4,5,6,7,8,9,10,11),
	'input' => array(2,3,1),
);


//У нас один язык... Он нам точно нужен?
initializeEditor($_conf['peditor']);

$product = array();

$mainCategory = new CatalogCategory();
$mainCategory->setFullAccess(true);
$mainCategory->init(1);

/**
 * Формируем список всех категорий
 */
$categoryList = array();
$categoryList[1] = $mainCategory->getName();
$subCategoriesList = $mainCategory->getSubCategoriesList();
if(count($subCategoriesList)) {
	foreach($subCategoriesList as $subIdc) {
		$subCategory = new CatalogCategory();
		$subCategory->setFullAccess(true);
		$subCategory->init($subIdc);
		$categoryList[$subIdc] = '-'.$subCategory->getName();
		$subSubCategoriesList = $subCategory->getSubCategoriesList();
		if(count($subSubCategoriesList)) {
			foreach($subSubCategoriesList as $subSubIdc) {
				$subSubCategory = new CatalogCategory();
				$subSubCategory->setFullAccess(true);
				$subSubCategory->init($subSubIdc);
				$categoryList[$subSubIdc] = '--'.$subSubCategory->getName();
			}
		}
	}
}

/**
 * Формируем список параметров
 */
$parametersObject = new CatalogParameters('ru');
$parameters = $parametersObject->getList();

/**
 * Возможно ли добавить к данной категории продукт
 *
 * @return bool
 */
function checkLevelToAddProduct($idc)
{
	$category = new CatalogCategory();
	$category->init($idc);
	if($category->getLevel() == 2) {
		return true;
	}
	return false;
}

/**
 * Обрабатываем действия
 */
if(!empty($_REQUEST['act'])) {
	if($_REQUEST['act'] == 'delete') {
		/**
		 * Удаление продукта из каталога.
		 */

		if(!empty($_REQUEST['idp'])) {
			$productToDelete = new CatalogProductAdmin();
			$productToDelete->init($_REQUEST['idp']);
			$productToDelete->deleteProduct();
			$_SESSION['catalog']['messageOut'] .= 'Объект успешно удален';
		}
	} elseif($_REQUEST['act'] == 'add') {
		/**
		 *	Добавляем новый продукт. Вывод данных.
		 */

		$product = array(
			'idp' => '',
			'sortOrder' => '',
			'name' => '',
			'show' => '0',
			'parentIdc' => '',
			'addInfo' => array(),
		);
		$act = 'saveNew';
	} elseif($_REQUEST['act'] == 'edit' && !empty($_REQUEST['idp'])) {
		/**
		 * Редактирование продукта. Вывод данных продукта.
		 */

		$idp = $_REQUEST['idp'];
		$productEdited = new CatalogProduct();
		$productEdited->setFullAccess(true);
		$productEdited->init($idp);
		$product = array(
			'idp' => $idp,
			'sortOrder' => $productEdited->getSortOrder(),
			'name' => $productEdited->getName(),
			'show' => $productEdited->getSwitchStatus(),
			'parent' => $productEdited->getParent(),
			'addInfo' => $productEdited->getAddInfo(),
		);
		$act = 'saveEdited';
	} elseif(!empty($_REQUEST['act']) && $_REQUEST['act'] == 'saveNew') {
		/**
		 * Сохраняем новый продукт.
		 */

		if(checkLevelToAddProduct($_REQUEST['parent_idc'])) {
			$productNew = new CatalogProductAdmin();
			$idp = $productNew->createProduct($_REQUEST['parent_idc'], array('ru' => $_REQUEST['name']), array('ru' => ''), $_REQUEST['sort_order']);
			foreach($_REQUEST['addInfo'] as $parameter => $value) {
				$productNew->setAddInfo($parameter, array('ru' => $value));
			}
			if(!empty($_REQUEST['show'])) {
				$productNew->turnSwitcher(true);
			}
			
			$_SESSION['catalog']['messageOut'] .= 'Объект создан!';
			
			header('location: /admin.php?p=admin_catalog'); 
			exit();
		}
		$_SESSION['catalog']['messageOut'] .= 'Невозможно добавить предмет к данной категории!';
	} elseif($_REQUEST['act'] == 'saveEdited' && !empty($_REQUEST['idp'])) {
		/**
		 * Редактируем продукт.
		 */

		if(checkLevelToAddProduct($_REQUEST['parent_idc'])) {
			$idp = $_REQUEST['idp'];
			$productEdited = new CatalogProductAdmin();
			$productEdited->init($idp);
			
			$productEdited->editProduct(
				$_REQUEST['parent_idc'], 
				array('ru' => $_REQUEST['name']),
				array('ru' => ''),
				$_REQUEST['sort_order']);
			if(!empty($_REQUEST['show'])) {
				$productEdited->turnSwitcher(true);
			} else {
				$productEdited->turnSwitcher(false);
			}
			foreach($_REQUEST['addInfo'] as $parameter => $value) {
				$productEdited->setAddInfo($parameter, array('ru' => $value));
			}

			$_SESSION['catalog']['messageOut'] .= 'Объект отредактирован!';

			header('location: /admin.php?p=admin_catalog'); 
			exit();
		}
		$_SESSION['catalog']['messageOut'] .= 'Невозможно добавить предмет к данной категории!';
	}
}

$smarty -> assign('messageOut', $_SESSION['catalog']['messageOut']);
unset($_SESSION['catalog']['messageOut']);
$smarty -> assign('product', $product);
$smarty -> assign('categoriesList', $categoryList);
$smarty -> assign('parameters', $parameters);
$smarty -> assign('listIdParameters', $listIdParameters);
$smarty -> assign('act', $act);
$smarty -> assign('PAGETITLE', '
	<h2>
		<a href="admin.php?p=categories_list">Список категорий</a>
		: <a href="admin.php?p=category_edit&act=add">Добавить категорию</a>
		&nbsp; &nbsp; &nbsp; <a href="admin.php?p=items_list">Список работ</a>
		: <strong>Добавить (редактировать) работу</strong>
	</h2>');
$PAGE = $smarty->display($_conf['disk_patch'].$_conf['admin_tpl_dir'].'catalog/item_edit.tpl');