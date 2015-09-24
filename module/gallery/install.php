<?php

$inst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."galleries`",
'1'=>"CREATE TABLE IF NOT EXISTS `".$_conf['prefix']."galleries` (
  `ids` int(6) unsigned NOT NULL auto_increment,
  `date` bigint(16) unsigned NOT NULL,
  `idi` int(4) unsigned NOT NULL,
  `name_ru` varchar(250) NOT NULL,
  `opis_ru` text NOT NULL,
  `name_ua` varchar(250) NOT NULL,
  `opis_ua` text NOT NULL,
  `name_en` varchar(250) NOT NULL,
  `opis_en` text NOT NULL,
  PRIMARY KEY  (`ids`),
  KEY `idi` (`idi`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1",
'2'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."gal_photos`",
'3'=>"CREATE TABLE IF NOT EXISTS `".$_conf['prefix']."gal_photos` (
  `idp` bigint(16) unsigned NOT NULL auto_increment,
  `ids` int(6) unsigned NOT NULL,
  `date` bigint(16) unsigned NOT NULL,
  `g_order` int(6) unsigned NOT NULL,
  `comments_ru` text NOT NULL,
  `comments_ua` text NOT NULL,
  `comments_en` text NOT NULL,
  PRIMARY KEY  (`idp`),
  KEY `ids` (`ids`),
  KEY `g_order` (`g_order`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1",
'4'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."gal_queue`",
'5'=>"CREATE TABLE IF NOT EXISTS `".$_conf['prefix']."gal_queue` (
  `id` bigint(16) unsigned NOT NULL auto_increment,
  `ids` int(6) unsigned NOT NULL,
  `folder` varchar(250) NOT NULL,
  `file` varchar(250) NOT NULL,
  `state` enum('n','y') NOT NULL default 'n',
  `sdate1` bigint(16) unsigned NOT NULL,
  `sdate2` bigint(16) unsigned NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `ids` (`ids`),
  KEY `state` (`state`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1",
'6'=>"CREATE TABLE IF NOT EXISTS `".$_conf['prefix']."comments` (
  `id` bigint(16) unsigned NOT NULL auto_increment,
  `idu` bigint(16) unsigned NOT NULL,
  `service` varchar(20) NOT NULL,
  `id_item` bigint(16) unsigned NOT NULL,
  `date` bigint(16) unsigned NOT NULL,
  `comtext` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idu` (`idu`),
  KEY `service` (`service`),
  KEY `id_item` (`id_item`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",
'7'=>"INSERT INTO `".$_conf['prefix']."page` (`pname`, `pparent`, `ptitle`, `ppar`, `plevel`, `pfile`, `pgroups`, `ptemplate`, `phelp`, `page_blocks`, `ptype`, `linkpos`, `siteshow`, `menushow1`, `menushow2`, `menushow3`, `added`, `lastedit`, `whoedit`, `content_ru`, `p_title_ru`, `p_keywords_ru`, `p_description_ru`, `linkname_ru`, `linktitle_ru`, `content_ua`, `p_title_ua`, `p_keywords_ua`, `p_description_ua`, `linkname_ua`, `linktitle_ua`, `content_en`, `p_title_en`, `p_keywords_en`, `p_description_en`, `linkname_en`, `linktitle_en`) VALUES
('gallery_manage', 'admin_list_module', 'file', '', 1, 'module/gallery/gallery_manage.php', 'super', 'admin.tpl', '', '', 'back', 40, 'y', '', 'n', 'n', 0, 1280940842, 1, '', 'Управление фотогалереей', '', '', 'Управление фотогалереей', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('gallery_act', 'admin_list_module', 'file', '', 1, 'module/gallery/gallery_act.php', 'super', 'admin.tpl', '', '', 'backhid', 50, 'y', '', 'n', 'n', 0, 1280940858, 1, '', 'Действия для управления галереей', '', '', 'Действия для управления галереей', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('gallery', '', 'file', '', 1, 'module/gallery/gallery.php', 'client,guest,manager,super', 'index.tpl', '', '', 'front', 60, 'y', '', 'n', 'n', 1280925844, 1280954952, 1, '', 'Галерея', 'Галерея', 'Галерея', 'Галерея', 'Галерея', '', 'Галерея', 'Галерея', 'Галерея', 'Галерея', 'Галерея', '', 'Gallery', 'Gallery', 'Gallery', 'Gallery', 'Gallery'),
('gal_browse', 'gallery', 'file', '', 1, 'module/gallery/gal_browse.php', 'client,guest,manager,super', 'index.tpl', '', 'fadres,fcopy', 'front', 0, 'y', '', 'n', 'n', 0, 1280940775, 1, '', 'Посмотр фото', 'Посмотр фото', 'Посмотр фото', 'Посмотр фото', 'Посмотр фото', '', 'Перегляд фото', 'Перегляд фото', 'Перегляд фото', 'Перегляд фото', 'Перегляд фото', '', 'View photo', 'View photo', 'View photo', 'View photo', 'View photo'),
('galphoto_packet', 'gallery_act', 'file', '', 1, 'module/gallery/galphoto_packet.php', 'manager,super', 'admin.tpl', '', '', 'back', 0, 'y', '', 'n', 'n', 0, 1280940913, 1, '', 'Пакетная обработка фото', '', '', 'Пакетная обработка фото', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('gal_cron', 'gallery_act', 'file', '', 1, 'module/gallery/gal_cron.php', 'client,guest,manager,super', 'asimple.tpl', '', '', 'back', 0, 'y', '', 'n', 'n', 0, 1280940941, 1, '', 'Обратботка фото по расписанию', '', '', 'Обратботка фото по расписанию', '', '', '', '', '', '', '', '', '', '', '', '', '')",
'8'=>"INSERT INTO `".$_conf['prefix']."site_config` (`name`, `val`, `com`, `grp`, `ctype`, `cvalue`) VALUES
('gal_thumb_h', '100', 'Высота превью фото в случае обрезки', 'gallery', 'i', ''),
('gal_thumb_patch', 'files/gal_thumb', 'Путь для хранения маленьких фото', 'gallery', 'v', ''),
('gal_photo_patch', 'files/gal_photo', 'Путь для хранения больших фото', 'gallery', 'v', ''),
('gal_thumb_w', '100', 'Ширина маленькой фотографии', 'gallery', 'i', ''),
('gal_photo_w', '600', 'Ширина большой фотографии', 'gallery', 'i', ''),
('thumb_col', '10', 'Количество столбцов в таблице', 'gallery', 'i', ''),
('thumb_row', '10', 'Количество строк в таблице', 'gallery', 'i', ''),
('gal_photo_h', '600', 'Высота фото (максимальная)', 'gallery', 'i', '')",
'9'=>"INSERT INTO `".$_conf['prefix']."admin_menu` (`punkt_parent`, `punkt_order`, `punkt_link`, `punkt_groups`, `punkt_ico`, `punkt_name_ru`, `punkt_name_ua`, `punkt_name_en`) VALUES (20, 38, 'admin.php?p=gallery_manage', 'super', 'gallery.png', 'Фотогалерея', 'Фотогалерея', '')",
'10'=>"INSERT INTO `".$_conf['prefix']."blocks` (`block_name`, `block_file`, `block_description`, `btype`, `content_ru`, `content_ua`, `content_en`) VALUES ('gal_block', 'module/gallery/gal_block.php', 'Блок для вывода фото на страницах из фотогалереи', '', '', '', '')",
'11'=>"INSERT INTO `".$_conf['prefix']."translate` (`pkey`, `sections`, `ru`, `ua`, `en`) VALUES
('gal_title', 'gallery', 'Фото', 'Фото', 'Photo'),
('gal_view', 'gallery', 'Просмотр', 'Перегляд', 'Browsing'),
('gal_showbig', 'gallery', 'Щелкните, чтобы просмотреть увеличенное изображение', 'Клацніть для перегляду збільшеного фото', 'Click to view larger image'),
('gal_comm', 'gallery', 'Комментарии', 'Коментарі', 'Comments'),
('gal_writecomm', 'gallery', 'Написать комментарий', 'Написати коментар', 'Leave comment'),
('gal_back', 'gallery', 'Вернуться к галерее', 'Повернутися до галереї', 'Back to gallery'),
('gal_gotogal', 'gallery', 'Щелкните для перехода в фотогалерею', 'Клацніть для ереходу до фотогалереї', 'Click to go to photo gallery'),
('gal_morephoto', 'gallery', 'ещё фото', 'ще фото', 'more photos'),
('gal_error1', 'gallery', 'Вы не ввели текст сообщения!', 'Ви не ввели текст повідомлення!', 'You have not entered the message text!'),
('gal_ok1', 'gallery', 'Ваш комментарий успешно сохранен!', 'Ваш коментар успішно збережено!', 'Your comment has been saved!'),
('agal_date', 'gallery', 'Дата', 'Дата', 'Date'),
('agal_name', 'gallery', 'Название', 'Назва', 'Name'),
('agal_desc', 'gallery', 'Описание', 'Опис', 'Description'),
('agal_added', 'gallery', 'Новая галлерея добавлена к базе данных!', 'Нова галерея додана до бази даних!', 'New gallery added to the database!'),
('agal_updated', 'gallery', 'Информация обновлена!', 'Інформація оновлена!', 'Updated!'),
('agal_galdeleted', 'gallery', 'Галлерея и все фотографии удалены!', 'Галерея та всі фото видалені!', 'Gallery and all photos removed!'),
('agal_uplphoto', 'gallery', 'Загрузить фото', 'Завантажити фото', 'Upload photos'),
('agal_crophint', 'gallery', 'Обрезать превью фото к размеру', 'Обрізати превью фото до розміру', 'Crop the photo to the size of thumbs'),
('agal_crop', 'gallery', 'Обрезать фото', 'Обрізати фото', 'Crop photos'),
('agal_topcrop', 'gallery', 'сверху/слева', 'зверху/зліва', 'top / left'),
('agal_centrcrop', 'gallery', 'от центра', 'від центру', 'cut from the center'),
('agal_botcrop', 'gallery', 'снизу/справа', 'знизу/справа', 'bottom / right'),
('agal_comment', 'gallery', 'Комментарий (описание)', 'Коментар (опис)', 'Comment (description)'),
('agal_uploaded', 'gallery', 'Фотография успешно загружена на сервер!', 'Фото успішно завантажене на сервер!', 'Photo successfully uploaded to the server!'),
('agal_photodeleted', 'gallery', 'Фотография удалена!', 'Фото видалено!', 'Photo deleted!'),
('agal_gallist', 'gallery', 'Список галерей', 'Список галерей', 'List galleries'),
('agal_galedit', 'gallery', 'Редактировать галерею', 'Редагувати галерею', 'Edit gallery'),
('agal_editphoto', 'gallery', 'Редактировать фото', 'Редагувати фото', 'Edit Photos'),
('agal_galcreate', 'gallery', 'Создать галлерею', 'Створити галерею', 'Create Gallery'),
('agal_galdel', 'gallery', 'Удалить галлерею', 'Видалити галерею', 'Delete Gallery'),
('agal_packet', 'gallery', 'Пакетная загрузка фото', 'Пакетне завантаження фото', 'Batch upload photos'),
('agal_commdeleted', 'gallery', 'Комментарий удален!', 'Коментар видалений!', 'Comment deleted!'),
('agal_warn1', 'gallery', 'Сначала выделите участок фото для обработки!', 'Спочатку виділіть ділянку фото для обробки!', 'First, highlight the photo processing!'),
('agal_back', 'gallery', 'Назад', 'Назад', 'Back'),
('agal_warn2', 'gallery', 'Выделите участок фото для создания превью фото.', 'Виділіть ділянку фото для створення превью.', 'Scroll to the photo section to create a preview photo.'),
('agal_saved', 'gallery', 'Данные сохранены!', 'Дані збережено!', 'Data saved!'),
('agal_viewedit', 'gallery', 'Просмотр и редактирование фото', 'Перегляд та редагування фото', 'Viewing and editing photos'),
('agal_comtitle', 'gallery', 'Комментариев', 'Коментарів', 'Comments'),
('agal_tasknotfound', 'gallery', 'Указанное задание не найдено в базе данных!', 'Вказане завдання не знайдено в базі даних!', 'The specified task is not found in database!'),
('agal_onlyzip', 'gallery', 'Для обработки принимаются только архивы ZIP!', 'Для обробки приймаються лише ZIP архіви!', 'For processing only accept files ZIP!'),
('agal_taskadded', 'gallery', 'Файлы из архива поставлены в очередь на обработку!', 'Файли з архіву поставлені в чергу на обробку!', 'Files from the archive queued for processing!'),
('agal_error2', 'gallery', 'Вы не указали название каталога содержащего фото для обработки!', 'Ви не вказали назву каталога, що містить фото для обробки!', 'You have not specified the name of the directory containing the photo processing!'),
('agal_error3', 'gallery', 'Указанный вами каталог не существует или вы создали его за пределами каталога <strong>%s/tmp/</strong>!', 'Вказаний Вами каталог не існує або и створили його за межами каталога <strong>%s/tmp/</strong>!', 'The directory you specified does not exist or you created it outside of the directory <strong>%s/tmp/</ strong>!'),
('agal_error4', 'gallery', 'Выставьте права на запись для каталога и всех файлов внутри каталога - chmod 0777!', 'Виставте права на запис для каталога і всіх файлів в каталозі - chmod 0777!', 'Set write permissions for the directory and all files within the directory - chmod 0777!'),
('agal_ok2', 'gallery', 'Файлы из каталога %s поставлены в очередь на обработку!', 'Файли з каталога %s поставлені в чергу на обробку!', 'Files in the directory %s queued for processing!'),
('agal_var1', 'gallery', 'Вариант 1. Загрузка фото в архиве.', 'Варіант 1. Завантаження фото в архіві.', 'Option 1. Upload your photos in the archive.'),
('agal_var1hint', 'gallery', 'Принимаются только ZIP-архивы с обычным сжатием. Максимальный размер загружаемого файла', 'Приймаються лише ZIP-архіви зі стандартним стисканням. Максимальний розмір завантажуваного файла', 'We accept only the ZIP-archives with normal compression. Maximum upload size'),
('agal_selgal', 'gallery', 'Выберите галерею', 'Виберіть галерею', 'Select gallery'),
('agal_selzip', 'gallery', 'Выберите zip-файл', 'Виберіть zip-файл', 'Choose zip-file'),
('agal_var2', 'gallery', 'Вариант 2. Загрузка фото по ФТП.', 'Варіант 2. Завантаження фото по ФТП.', 'Option 2. Upload your photos to FTP.'),
('agal_var2hint1', 'gallery', 'Войдите на сайт по ФТП. Перейдите в каталог', 'Ввійдіть на сапйт по ФТП. Перейдіть в каталог', 'Log on to the FTP site. Navigate to the directory'),
('agal_var2hint2', 'gallery', 'Содайте новый каталог (напр.:', 'Створіть новий каталог (напр.:', 'Creates a new directory (eg:'),
('agal_var2hint3', 'gallery', 'загрузите в него ваши фото', 'завантажте в нього ваші фото', 'download it and your photo'),
('agal_var2hint4', 'gallery', 'Установите на созданный каталог и все загруженные файлы права на запись (CHMOD 0777)', 'Встановіть на створений каталог і всі завантажені файли права на запис (CHMOD 0777)', 'Install the new directory and all downloaded files writable (CHMOD 0777)'),
('agal_var2hint5', 'gallery', 'Выберите в полях ниже галерею к которой будут прикреплены фото и укажите название каталога в который вы загрузили фото (напр.: myphoto).', 'Виберіть в полях нижче галерею до якої будут додані фото і вкажіть назву каталога в який ви завантажили фото (напр.: myphoto).', 'Select the fields below the gallery which will be attached to the photo and specify the directory where you downloaded the photo (eg: myphoto).'),
('agal_catname', 'gallery', 'Имя каталога с фото', 'Назва теки з фото', 'The directory name with photo'),
('agal_photointask', 'gallery', 'Фото в очереди на обработку', 'Фото в черзі на обробку', 'Photos in the queue'),
('agal_nophotointask', 'gallery', 'В очереди нет фото!', 'У черзі немає фото!', 'In the queue there is no picture!'),
('agal_th_photo', 'gallery', 'Фото', 'Фото', 'Photos'),
('agal_th_gal', 'gallery', 'Галерея', 'Галерея', 'Gallery'),
('agal_th_dadd', 'gallery', 'Дата постановки', 'Дата постановки', 'Date statement'),
('agal_th_comm', 'gallery', 'Комментарий', 'Коментар', 'Comment')"
);

$uninst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."galleries`",
'1'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."gal_photos`",
'2'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."gal_queue`",
'3'=>"DELETE FROM ".$_conf['prefix']."page WHERE pname='gallery_manage' OR pname='gallery_act' OR pname='gallery' OR pname='gal_browse' OR pname='galphoto_packet' OR pname='gal_cron'",
'4'=>"DELETE FROM ".$_conf['prefix']."admin_menu WHERE punkt_link='admin.php?p=gallery_manage'",
'5'=>"DELETE FROM ".$_conf['prefix']."blocks WHERE block_name='gal_block'",
'6'=>"DELETE FROM ".$_conf['prefix']."site_config WHERE grp='gallery'",
'7'=>"DELETE FROM ".$_conf['prefix']."translate WHERE sections='gallery'"
);

$inst_info = '<strong>Модуль управления фотогалереей на сайте установлен!</strong><br />
Перейдите в раздел меню: "Модули - Блоки на странице" и для блока block_news настройте страницы на которых будут выводится анонсы новостей.<br />
Перейдите в раздел меню: "Модули - Страницы" и откройте для редактирования страницу: news. Настройте блоки, что будут выводится на этой странице.<br />
Для пакетной обработки фото по расписанию, необходимо добавить в файл /tmp/init_cron.txt строку:<br />
<code>index.php?p=gal_cron|2,7,12,17,22,27,32,37,42,47,52,57|*|*|*|*</code><br />
В файл .htaccess добавить строки:<br />
<code>
php_value upload_max_filesize 50M
php_value post_max_size 64M
php_value max_input_time 240
</code>';

$uninst_info = '<strong>Модуль фотогалереи удален из сайта!</strong>';

$inst_relation = 'Зависит от библиотеки include/imager.php, include/uploader.php, include/zip/*';

$uninst_relation = '';

$inst_css = '/* Galery */
.galcover{display:block; float:left;}
.galcover .coverimg{display:block; float:left; width:116px; height:116px; background:url(../images/gbg.jpg) left top no-repeat; padding-left:6px; padding-top:4px;}
.galcover .coverimg img{border-radius:3px; -moz-border-radius:3px; -webkit-border-radius:3px; border:solid 1px #ccc;}
.galcover .covertxt{display:block; float:left; width:180px; padding:10px;}
.galcover .covertxt a{color:#535353; text-decoration:underline; font-size:16px;}
.galcover .covertxt a:hover{text-decoration:none;}
.galcover .covertxt span{color:#9b0c06;}
.gopis{margin-bottom:10px;}';

?>