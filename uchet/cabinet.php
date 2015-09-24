<?php
$pages = Array('order', 'ordercreated', 'orderlist', 'orderinfo', 'owninfo', 'registeravtor', 'sregisteravtor', 'download', 'refprogram', 'news', 'onlinepayment', 'logout', 'recover', 'main');
if(isset($_REQUEST['page']) && in_array($_REQUEST['page'], $pages)) {
	include(dirname(__FILE__).'/'.$_REQUEST['page'].'.php');
} else {
	include(dirname(__FILE__).'/main.php');
}