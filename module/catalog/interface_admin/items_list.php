<?php
/**
 * Страница со списком всех продуктов
 */ 
if(!defined("SHIFTCMS")) {exit;}

include_once dirname(dirname(__FILE__)).'/core/category.php';
include_once dirname(dirname(__FILE__)).'/core/product.php';
include_once dirname(dirname(__FILE__)).'/core/product_admin.php';

$mainCategory = new CatalogCategory();
$mainCategory->setFullAccess(true);
$mainCategory->init(1);

$productsList = array();
$subCategoriesList = $mainCategory->getSubCategoriesList();
if(count($subCategoriesList)) {
	foreach($subCategoriesList as $subIdc) {
		$subcategory = new CatalogCategory();
		$subcategory->setFullAccess(true);
		$subcategory->init($subIdc);
		$parentName = $subcategory->getName();

		$subSubCategoryList = $subcategory->getSubCategoriesList();
		if(count($subSubCategoryList)) {
			foreach($subSubCategoryList as $subSubIdc) {
				$subSubCategory = new CatalogCategory();
				$subSubCategory->setFullAccess(true);
				$subSubCategory->init($subSubIdc);
				$parentFullName = $parentName.' / '.$subSubCategory->getName();
				
				$products = $subSubCategory->getProductsList();
				
				foreach($products as $idp) {
					$product = new CatalogProduct();
					$product->setFullAccess(true);
					$product->init($idp);
					
					$productsList[$idp] = array(
						'name' => $product->getName(),
						'url' => $product->getUrl(),
						'parentName' => $parentFullName,
					);
				}
			}
		}
	}
}

$smarty -> assign('messageOut', $_SESSION['catalog']['messageOut']);
unset($_SESSION['catalog']['messageOut']);
$smarty -> assign('products', $productsList);
$smarty -> assign('PAGETITLE', '
	<h2>
		<a href="admin.php?p=categories_list">Список категорий</a>
		: <a href="admin.php?p=category_edit&act=add">Добавить категорию</a>
		&nbsp; &nbsp; &nbsp; <strong>Список работ</strong>
		: <a href="admin.php?p=item_edit&act=add">Добавить работу</a>
	</h2>');			
$PAGE = $smarty->display($_conf['disk_patch'].$_conf['admin_tpl_dir'].'catalog/items_list.tpl');