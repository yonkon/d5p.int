<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

include dirname(__FILE__).'/core/loader.php';
include_once UCONFIG::$coreDir.'controllers/server.php';

UCore::run();