<?php
/**
 * Страница для отдельного товара.
 * Файл-интерфейс между ядром каталога и шаблоном.
 */

if(!defined("SHIFTCMS")) {
	exit;
};

include_once dirname(dirname(__FILE__)).'/core/product.php';
include_once dirname(dirname(__FILE__)).'/core/parameters.php';
//include_once dirname(dirname(__FILE__)).'/feedback.php';

$idp = $_REQUEST['idp'];

$product = new CatalogProduct();
$product->init($idp);

$pageTitle = $product->getName();
$description = $product->getDescription();

$productAddInfo = $product->getAddInfo();

$parametersObject = new CatalogParameters($_SESSION['lang']);
$parameters = $parametersObject->getList();

$parentIdc = $product->getParent();

$TITLE = $pageTitle;

$smarty->assign('description', $description);
$smarty->assign('idp', $idp);
$smarty->assign('pageTitle', $pageTitle);
$smarty->assign('productAddInfo', $productAddInfo);
$smarty->assign('parameters', $parameters);

$smarty->assign('addInfoLeft', array(1, 5, 6, 7, 8, 9, 10, 11));
$smarty->assign('addInfoRight', array(2, 3, 4));
//print_r($productAddInfo);


$PAGE = $smarty->fetch('main.tpl');
$smarty->assign('pageType', 'catalogItem');
$catalogItem = $smarty->fetch('catalog/item.tpl');
$smarty->assign('catalogItem', $catalogItem);