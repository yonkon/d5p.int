<?php

if(!isset($_SESSION['USER_IDU'])){
	include("module/main/enter.php");
}else{
	$enter_block = $smarty -> fetch("usermenu.tpl");
}

?>