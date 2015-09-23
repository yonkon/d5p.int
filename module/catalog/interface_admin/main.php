<?php
$smarty -> assign('messageOut', $_SESSION['catalog']['messageOut']);
unset($_SESSION['catalog']['messageOut']);
$PAGE = $smarty->display($_conf['disk_patch'].$_conf['admin_tpl_dir'].'catalog/main.tpl');