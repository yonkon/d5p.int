<?php
/**
 * Главной страница каталога
 * Файл-интерфейс между ядром каталога и шаблоном.
 */
 
if(!defined("SHIFTCMS")) {
	exit;
};

include_once dirname(dirname(__FILE__)).'/core/category.php';

$category = new CatalogCategory();
$category->init(1);

$pageTitle = $category->getName();

$categoryList = $category->getSubCategoriesList('name');
$subCategories = array();
if(count($categoryList)) {
	foreach($categoryList as $idc) {
		$subCategory = new CatalogCategory();
		$subCategory->init($idc);
		$subCategories[$idc] = array(
			'url' => (($_SESSION['lang'] == 'ru') ? '' : $_SESSION['lang'].'/').$subCategory->getUrl(),
			'name' => $subCategory->getName(),
		);
	}
}
$smarty->assign('pageTitle', $pageTitle);
$smarty->assign('subCategories', $subCategories);
$PAGE = $smarty->fetch('main.tpl');
$smarty->assign('pageType', 'catalogIndex');
$catalogIndex = $smarty->fetch('catalog/main.tpl');
$smarty->assign('catalogIndex', $catalogIndex);