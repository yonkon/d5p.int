<?php
/**
 * Страница со списком всех категорий.
 */ 
if(!defined("SHIFTCMS")) {
	exit();
}

include_once dirname(dirname(__FILE__)).'/core/category.php';
include_once dirname(dirname(__FILE__)).'/core/category_admin.php';

$categoriesList = array();
$mainCategory = new CatalogCategory();
$mainCategory->init(1);
foreach($mainCategory->getSubCategoriesList('name') as $subCategoryIdc) {
	$subCategory = new CatalogCategory();
	$subCategory->init($subCategoryIdc);
	$categoriesList[$subCategoryIdc] = array(
		'name' => $subCategory->getName(),
		'url' => $subCategory->getUrl(),
	);
	$subSubCategoriesList = $subCategory->getSubCategoriesList();
	if(count($subSubCategoriesList)) {
		foreach($subSubCategoriesList as $subSubCategoryIdc) {
			$subSubCategory = new CatalogCategory();
			$subSubCategory->init($subSubCategoryIdc);
			$categoriesList[$subSubCategoryIdc] = array(
				'name' => ' - '.$subSubCategory->getName(),
				'url' => $subSubCategory->getUrl(),
			);
		}
	}
}

$smarty -> assign('messageOut', $_SESSION['catalog']['messageOut']);
unset($_SESSION['catalog']['messageOut']);
$smarty -> assign('categoriesList', $categoriesList);
$smarty -> assign('PAGETITLE', '
	<h2>
		<strong>Список категорий</strong>
		: <a href="admin.php?p=category_edit&act=add">Добавить категорию</a>
		&nbsp; &nbsp; &nbsp; <a href="admin.php?p=items_list">Список работ</a>
		: <a href="admin.php?p=item_edit&act=add">Добавить работу</a>
	</h2>');
$PAGE = $smarty->display($_conf['disk_patch'].$_conf['admin_tpl_dir'].'catalog/categories_list.tpl');