<?php
/**
* Добавление и редактирование раздела.
*	act ==	add - форма добавления нового раздела, минимальный вывод данных.
*		 	edit (редактировать)
*			saveEdited (перезаписать)
*			saveNew (сохранить новый раздел)
*/
if(!defined("SHIFTCMS")) {
	exit();
}

include_once dirname(dirname(__FILE__)).'/core/category.php';
include_once dirname(dirname(__FILE__)).'/core/category_admin.php';

$mainCategory = new CatalogCategory();
$mainCategory->setFullAccess(true);
$mainCategory->init(1);

/**
 * Формируем список всех категорий
 */
$categoriesList[1] = $mainCategory->getName();
foreach($mainCategory->getSubCategoriesList('name') as $subCategoryIdc) {
	$subCategory = new CatalogCategory();
	$subCategory->setFullAccess(true);
	$subCategory->init($subCategoryIdc);
	$categoriesList[$subCategoryIdc] = '-'.$subCategory->getName();
}

if(!empty($_REQUEST['act'])) {
	if($_REQUEST['act'] == 'delete') {
		/**
		 * Удаление категории.
		 */ 

		if(!empty($_REQUEST['idc'])) {
			$categoryToDelete = new CatalogCategoryAdmin();
			$categoryToDelete->init($_REQUEST['idc']);
			if($categoryToDelete->deleteCategory()) {
				$_SESSION['catalog']['messageOut'] .= 'Раздел успешно удален!';
			} else {
				$_SESSION['catalog']['messageOut'] .= 'Ошибка при удалении раздела!';
			}
		}
	} elseif($_REQUEST['act'] == 'add') {
		/**
		 * Форма добавления нового раздела.
		 */

		$currentCategoryInfo = array(
			'idc' => '',
			'name' => '',
			'show' => 1,
			'parentCat' => '',
			'sort' => '',
		);
		$act = 'saveNew';
	} elseif($_REQUEST['act'] == 'edit' && !empty($_REQUEST['idc'])) {
		/**
		 * Редактирование раздела. Вывод данных раздела.
		*/
		
		$idc = $_REQUEST['idc'];
		
		$currentCategory = new CatalogCategory();
		$currentCategory->setFullAccess(true);
		$currentCategory->init($idc);
		
		$currentCategoryInfo = array(
			'idc' => $idc,
			'name' => $currentCategory->getName(),
			'show' => $currentCategory->getSwitchStatus(),
			'parentCat' => $currentCategory->getParent(),
			'sort' => $currentCategory->getSortOrder(),
		);
		$act = 'saveEdited';
	} elseif($_REQUEST['act'] == 'saveEdited' && !empty($_REQUEST['idc'])) {
		/**
		 * Перезаписываем раздел.
		 */

		$idc = $_REQUEST['idc'];
		$categoryEdited = new CatalogCategoryAdmin();
		$categoryEdited->init($idc);
		$categoryEdited->editCategory($_REQUEST['parent_idc'], array('ru' => $_REQUEST['name']), $_REQUEST['sort_order']);
		if(!empty($_REQUEST['show'])) {
			$categoryEdited->turnSwitcher(true);
		} else {
			$categoryEdited->turnSwitcher(false);
		}
		$_SESSION['catalog']['messageOut'] .= 'Категория отредактирована';
		header('location: /admin.php?p=admin_catalog'); 
		exit();
	} else if($_REQUEST['act'] == 'saveNew') {
		/**
		 * Сохраняем новый раздел.
		 */ 

		$categoryNew = new CatalogCategoryAdmin();
		$categoryNew->createCategory($_REQUEST['parent_idc'], array('ru' => $_REQUEST['name']), $_REQUEST['sort_order']);
		if(!empty($_REQUEST['show'])) {
			$categoryNew->turnSwitcher(true);
		}
		$_SESSION['catalog']['messageOut'] .= 'Категория создана!';
		header('location: /admin.php?p=admin_catalog'); 
		exit();
	}
}

$smarty->assign('messageOut', $_SESSION['catalog']['messageOut']);
unset($_SESSION['catalog']['messageOut']);
$smarty->assign('categoriesList', $categoriesList);
$smarty->assign('currentCategory', $currentCategoryInfo);
$smarty->assign('act', $act);
$smarty -> assign('PAGETITLE', '
	<h2>
		<a href="admin.php?p=categories_list">Список категорий</a>
		: <strong>Добавить (редактировать) категорию</strong>
		&nbsp; &nbsp; &nbsp; <a href="admin.php?p=items_list">Список работ</a>
		: <a href="admin.php?p=item_edit&act=add">Добавить работу</a>
	</h2>');
$PAGE = $smarty->display($_conf['disk_patch'].$_conf['admin_tpl_dir'].'catalog/category_edit.tpl');