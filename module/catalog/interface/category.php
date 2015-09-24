<?php
/**
 * Страница для работы с категориями в каталоге
 * Файл-интерфейс между ядром каталога и шаблоном.
 */

if(!defined("SHIFTCMS")) {
	exit;
};

include_once dirname(dirname(__FILE__)).'/core/category.php';
include_once dirname(dirname(__FILE__)).'/core/product.php';
include_once dirname(dirname(__FILE__)).'/core/parameters.php';

$idc = $_REQUEST['idc'];

$category = new CatalogCategory();
$category->init($idc);

$pageTitle = $category->getName();

$subCategories = array();
$categoryList = $category->getSubCategoriesList();
if(count($categoryList)) {
	foreach($categoryList as $subCategoryIdc) {
		$subCategory = new CatalogCategory();
		$subCategory->init($subCategoryIdc);
		
		$products = array();
		$productsList = $subCategory->getProductsList('name');
		if(count($productsList)) {
			foreach($productsList as $idp) {
				$product = new CatalogProduct();
				$product->init($idp);
				
				$products[$idp] = array(
					'url' => $product->getUrl(),
					'name' => $product->getName(),
				);
			}
		}
		
		$subCategories[$subCategoryIdc] = array(
			'name' => $subCategory->getName(),
			'productsList' => $products,
		);
	}
}

$TITLE = $pageTitle;

$smarty->assign('pageTitle', $pageTitle);
$smarty->assign('subCategories', $subCategories);

$PAGE = $smarty->fetch('main.tpl');
$smarty->assign('pageType', 'catalogCategory');
$catalogCategory = $smarty->fetch('catalog/category.tpl');
$smarty->assign('catalogCategory', $catalogCategory);