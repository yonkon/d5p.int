<?php
/*
технические требования
	php >= 5.2.0
	curl
	PECL json >= 1.2.0
последовательность действий:
	Настроить справочники на сайте sverka1.ru
	На директорию /tmp/, /core/configs/ и все вложенные файлы-папки необходимо выставить chmod 777.
	Переименовать папку /tmp/type-here/ и прописать новое название в /config.php UCONFIG::$tmpDirG
	Отредактировать /config.php
	Переименовать /tmpl/smarty/userblock1.tpl или /tmpl/smarty/userblock2.tpl в /tmpl/smarty/userblock.tpl или создать новый шаблон /tmpl/smarty/userblock.tpl, переименовать /tmpl/smarty/order1.tpl или /tmpl/smarty/order2.tpl в /tmpl/smarty/order.tpl или создать новый шаблон /tmpl/smarty/order.tpl
редактировать разрешено ТОЛЬКО следующе файлы:
	/tmpl/php/*.php
	/tmpl/smarty/*.tpl	/html/*
	/config.php
	/core/configs/db_automat.php
	/core/configs/db_manual.php
	Остальные файлы редактировать ЗАПРЕЩЕНО! Создавать свои файлы можно ТОЛЬКО в директориях /tmpl/smarty/ и /tmpl/php/
/config.php основные настройки
	$printout = false;// true - вывод на экран непосредственно в том месте, где инклюдится файл, false - запись файла в глобальную переменную $uchetResult
	$siteEncoding = 'UTF8'; // кодировка сайта
	$siteName = 'test1.ru'; // название сайта
	$password = '12345'; // пароль на кабинет, выданный на сайте sverka1.ru
	$ownderIDU = 123; // Id пользователя, владельца кабинета
	$url['*'] - страницы, где будут обрабатываться данные с введённых форм и/или находиться сами страницы
Для того, чтобы вывести какую-либо страницу кабинета, необходимо проинклюдить соответствующий файл с корня кабинета. И эта страница записывается в глобальную переменную $uchetResult или выводится на экран (опция устанавливается в /config.php переменной $printout). Или же можно проинклюдить /cabinet.php и передать параметр $_REQUEST['page'] с соответствующим названием страницы.
Точки входа в кабинет клиента эти и ТОЛЬКО эти: cabinet.php, checkeasypayby.php, download.php, logout.php, main.php, news.php, onlinepayment.php, order.php, ordercreated.php, orderinfo.php, owninfo.php, recovery.php, registeravtor.php, sregisteravtor.php, userblock.phpЕсли для userblock переименовывается userblock1.tpl, то в шаблон сайта необходимо вставить:
	<link rel="stylesheet" href="/uchet/html/js/nlsmenu/office-v.css" type="text/css" />
	<script type="text/javascript" src="/uchet/html/js/nlsmenu/nlsmenu.js"></script>
	<script type="text/javascript" src="/uchet/html/js/nlsmenu/nlsmenueffect.js"></script>
	, где /uchet/ - папка расположения кабинета
Если для order переименовывается order0.tpl, то в шаблон сайта необходимо вставить jQuery.
*/