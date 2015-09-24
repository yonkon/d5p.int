<?php

/**
* Набор функций для работы системы
* @package ShiftCMS
* @subpackage Remote
* @author Volodymyr Demchuk http://shiftcms.net
* @version 1.00 16.02.2011
*/
if(!defined('SHIFTCMS') || !isset($_SESSION['A_USER_IDU'])){
	exit;
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="EditOwnData" && isset($_SESSION['A_USER_IDU'])) $PAGE = EditOwnData();
if(isset($_REQUEST['act']) && $_REQUEST['act']=="SaveOwnData" && isset($_SESSION['A_USER_IDU'])) $PAGE = SaveOwnData();
if(isset($_REQUEST['act']) && $_REQUEST['act']=="EstimateOrder" && isset($_SESSION['A_USER_IDU'])) $PAGE = EstimateOrder($_REQUEST['ido']);
if(isset($_REQUEST['act']) && $_REQUEST['act']=="InfoEstimateOrder" && isset($_SESSION['A_USER_IDU'])) $PAGE = InfoEstimateOrder($_REQUEST['ido']);
if(isset($_REQUEST['act']) && $_REQUEST['act']=="SaveOrderContent" && isset($_SESSION['A_USER_IDU'])) $PAGE = SaveOrderContent();
if(isset($_REQUEST['act']) && $_REQUEST['act']=="DelSingleFile" && isset($_SESSION['A_USER_IDU'])) $PAGE = DelSingleFile($_REQUEST['idf'], $_REQUEST['ido']);




?> 