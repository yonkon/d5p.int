<?php

$inst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."advert`",
'1'=>"CREATE TABLE IF NOT EXISTS `".$_conf['prefix']."advert` (
  `ad_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `ad_place` varchar(25) NOT NULL DEFAULT '',
  `ad_link` varchar(250) NOT NULL DEFAULT '',
  `ad_type_show` enum('no','date','shows','clicks') NOT NULL DEFAULT 'date',
  `ad_dstart` bigint(16) NOT NULL DEFAULT '0',
  `ad_dstop` bigint(16) NOT NULL DEFAULT '0',
  `ad_shows` bigint(16) NOT NULL DEFAULT '0',
  `ad_clicks` bigint(16) NOT NULL DEFAULT '0',
  `ad_section` varchar(250) NOT NULL DEFAULT '',
  `ad_type` enum('free','paid') NOT NULL DEFAULT 'free',
  `shows` int(6) unsigned NOT NULL DEFAULT '0',
  `clicks` int(6) unsigned NOT NULL DEFAULT '0',
  `ad_switch` enum('y','n') NOT NULL,
  `ad_kode_ru` text NOT NULL,
  `ad_kode_ua` text NOT NULL,
  `ad_kode_en` text NOT NULL,
  PRIMARY KEY (`ad_id`),
  KEY `ad_place` (`ad_place`,`ad_type_show`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",
'2'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."ad_place`",
'3'=>"CREATE TABLE IF NOT EXISTS `".$_conf['prefix']."ad_place` (
  `id_adp` int(3) unsigned NOT NULL auto_increment,
  `kod` varchar(20) NOT NULL default '',
  `comment` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id_adp`),
  KEY `kod` (`kod`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",
'4'=>"INSERT INTO `".$_conf['prefix']."blocks` (`block_name`, `block_file`, `block_description`, `btype`, `content_ru`, `content_ua`, `content_en`) VALUES ('outbaner', 'module/baner/outbaner.php', 'Блок для вывода рекламы на страницах', 'file', '', '', '')",
'5'=>"INSERT INTO `".$_conf['prefix']."page` (`pname`, `pparent`, `ptitle`, `ppar`, `plevel`, `pfile`, `pgroups`, `ptemplate`, `phelp`, `page_blocks`, `ptype`, `linkpos`, `siteshow`, `menushow1`, `menushow2`, `menushow3`, `added`, `lastedit`, `whoedit`, `content_ru`, `p_title_ru`, `p_keywords_ru`, `p_description_ru`, `linkname_ru`, `linktitle_ru`, `content_ua`, `p_title_ua`, `p_keywords_ua`, `p_description_ua`, `linkname_ua`, `linktitle_ua`, `content_en`, `p_title_en`, `p_keywords_en`, `p_description_en`, `linkname_en`, `linktitle_en`) VALUES ('baner', 'admin_list_module', 'file', '', 1, 'module/baner/baner.php', 'administrator,super', 'admin.tpl', 'module/baner.htm', '', 'back', 0, 'y', 'n', 'n', 'n', 0, 1291296566, 2, '', 'Управление рекламой', 'Управление рекламой', 'Управление рекламой', 'Управление рекламой', 'Управление рекламой', '', 'Управління рекламою', 'Управління рекламою', 'Управління рекламою', 'Управління рекламою', 'Управління рекламою', '', 'Manage ads', 'Manage ads', 'Manage ads', 'Manage ads', 'Manage ads'), ('goto', 'baner', 'file', '', 1, 'goto.php', 'administrator,client,guest,manager,super', 'asimple.tpl', '', '', 'front', 0, 'y', 'n', 'n', 'n', 1291300685, 0, 2, '', 'Скрипт для перехода по рекламной ссылке', 'Скрипт для перехода по рекламной ссылке', 'Скрипт для перехода по рекламной ссылке', 'Скрипт для перехода по рекламной ссылке', 'Скрипт для перехода по рекламной ссылке', '', 'Скрипт для переходу по рекламному посиланню', 'Скрипт для переходу по рекламному посиланню', 'Скрипт для переходу по рекламному посиланню', 'Скрипт для переходу по рекламному посиланню', 'Скрипт для переходу по рекламному посиланню', '', 'Script to go on an advertising link', 'Script to go on an advertising link', 'Script to go on an advertising link', 'Script to go on an advertising link', 'Script to go on an advertising link')",
'6'=>"INSERT INTO `".$_conf['prefix']."admin_menu` (`punkt_parent`, `punkt_order`, `punkt_link`, `punkt_groups`, `punkt_ico`, `punkt_name_ru`, `punkt_name_ua`, `punkt_name_en`) VALUES (20, 140, 'admin.php?p=baner', 'administrator,manager,super', 'baner.png', 'Управление рекламой', 'Управління рекламою', 'Manage ads')",
'7'=>"INSERT INTO `".$_conf['prefix']."translate` (`pkey`, `sections`, `ru`, `ua`, `en`) VALUES
('ad_title', 'admin_advert', 'Управление рекламой', 'Управління рекламою', 'Management of advertising'),
('ad_add', 'admin_advert', 'Добавить рекламу', 'Додати рекламу', 'Add ads'),
('ad_list', 'admin_advert', 'Список рекламы', 'Список реклами', 'List of advertisements'),
('ad_ok1', 'admin_advert', 'Рекламное место добавлено!', 'Рекламне місце додано!', 'Advertising space is added!'),
('ad_list_place', 'admin_advert', 'Список рекламных мест', 'Список рекламних місць', 'List of advertising space'),
('ad_add_place', 'admin_advert', 'Добавить рекламное место', 'Додати рекламне місце', 'Add advertising space'),
('ad_ok2', 'admin_advert', 'Рекламное место сохранено!', 'Рекламне місце збережено!', 'Advertising space saved!'),
('ad_attention', 'admin_advert', 'Внимание!', 'Увага!', 'Attention!'),
('ad_explaine', 'admin_advert', 'Для того, чтобы реклама показывалась, в шаблоне в нужном месте необходимо вставить следующий код: <b>{".chr(36)."код_рекламного_места}</b>', 'Для того, щоб реклама показувалася, в шаблоні в потрібному місці необхідно вставити наступний код: <b> {".chr(36)."код_рекламного_місця} </ b>', 'In order for advertising to, in a pattern in the right place to insert the following code: <b> {".chr(36)."code_advertising_space} </ b>'),
('ad_code_place', 'admin_advert', 'Код рекламного места', 'Код рекламного місця', 'Code of advertising space'),
('ad_desc_place', 'admin_advert', 'Описание рекламного места', 'Опис рекламного місця', 'Description of advertising space'),
('ad_edit_place', 'admin_advert', 'Редактировать рекламное место', 'Редагувати рекламне місце', 'Edit ad space'),
('ad_ok3', 'admin_advert', 'Рекламное место удалено!', 'Рекламне місце видалено!', 'Advertising space is removed!'),
('ad_ok4', 'admin_advert', 'Реклама удалена!', 'Реклама видалена!', 'Advertising is removed!'),
('ad_ok5', 'admin_advert', 'Новая реклама добавлена!', 'Нова реклама додана!', 'The new advertising is added!'),
('ad_ok6', 'admin_advert', 'Изменения сохранены!', 'Зміни збережено!', 'Changes have been saved!'),
('ad_switch', 'admin_advert', 'Включить/Отключить показ', 'Ввімкнути/Вимкнути показ', 'Enable / Disable display'),
('ad_type', 'admin_advert', 'Тип рекламы', 'Тип реклами', 'Ad type'),
('ad_type1', 'admin_advert', 'Бесплатная - показывается, когда нет платной рекламы', 'Безкоштовна - показується, коли немає платної реклами', 'Free - is shown when there is no paid advertising'),
('ad_type2', 'admin_advert', 'Платная', 'Платна', 'Paid'),
('ad_link', 'admin_advert', 'Ссылка для перехода', 'Посилання для переходу', 'Link to go'),
('ad_link_explaine', 'admin_advert', 'Ссылку указывать не объязательно. Тогда нужно в коде рекламы прописать ссылку на нужную страницу. В этом случае не будет производится подсчет переходов по ссылке.', 'Посилання вказувати не обов''язково. Тоді треба в коді реклами прописати посилання на потрібну сторінку. У цьому випадку не буде проводиться підрахунок переходів по посиланню.', 'Link do not necessarily indicate. Then you need to register in the code of advertising a link to the page. In this case, will not be counted clicks on the link.'),
('ad_code', 'admin_advert', 'Код рекламы', 'Код реклами', 'Code of advertising'),
('ad_as_show', 'admin_advert', 'Принцип показа рекламы', 'Принцип показу реклами', 'The principle of displaying advertisements'),
('ad_as_show1', 'admin_advert', 'Неограниченное время показа', 'Необмежений час показу', 'Unlimited time display'),
('ad_as_show2', 'admin_advert', 'Ограничение по времени показа', 'Обмеження за часом показу', 'Time limit for display'),
('ad_as_show3', 'admin_advert', 'Ограничение по количеству показов', 'Обмеження за кількістю показів', 'Restriction on the number of hits'),
('ad_as_show4', 'admin_advert', 'Ограничение по количеству переходов', 'Обмеження за кількістю переходів', 'Restriction on the number of transitions'),
('ad_section', 'admin_advert', 'Разделы', 'Розділи', 'Sections'),
('ad_section1', 'admin_advert', 'Все (по всему сайту)', 'Все (по всьому сайту)', 'All (sitewide)'),
('ad_section2', 'admin_advert', 'Выбрать разделы', 'Вибрати розділи', 'Select sections'),
('ad_section3', 'admin_advert', 'Отметьте разделы сайта в которых будет показываться реклама', 'Позначте розділи сайту в яких буде показуватися реклама', 'Note the sections of the site which will show ads'),
('ad_section4', 'admin_advert', 'Максимальное количество показов', 'Максимальна кількість показів', 'Maximum number of hits'),
('ad_section5', 'admin_advert', 'Максимальное количество кликов (переходов)', 'Максимальна кількість кліків (переходів)', 'The maximum number of clicks'),
('ad_section6', 'admin_advert', 'Укажите период показа (Формат даты: ДД-ММ-ГГГГ)', 'Вкажіть період показу (Формат дати: ДД-ММ-РРРР)', 'Specify the period shown (date format: DD-MM-YYYY)'),
('ad_section7', 'admin_advert', 'начало', 'початок', 'start'),
('ad_section8', 'admin_advert', 'конец', 'кінець', 'end'),
('ad_edit', 'admin_advert', 'Редактирование рекламы', 'Редагування реклами', 'Editing ads'),
('ad_msg1', 'admin_advert', 'На данный момент нет ни одной рекламной компании!', 'На даний момент немає жодної рекламної компанії!', 'At the moment there is no advertising campaign!'),
('ad_msg2', 'admin_advert', 'На данный момент нет ни одного рекламного места', 'На даний момент немає жодного рекламного місця', 'At the moment there is no advertising space'),
('ad_on', 'admin_advert', 'включено', 'ввімкнено', 'enabled'),
('ad_off', 'admin_advert', 'отключено', 'вимкнено', 'desabled'),
('ad_place', 'admin_advert', 'Место положения', 'Місце положення', 'Location'),
('ad_show', 'admin_advert', 'Показ', 'Показ', 'Show'),
('ad_href', 'admin_advert', 'Ссылка', 'Посилання', 'Link'),
('ad_type_show1', 'admin_advert', 'Показ без ограничений по времени и количеству показов (переходов)', 'Показ без обмежень за часом і кількістю показів (переходів)', 'Showing no time limits and number of page views (hits)'),
('ad_type_show2', 'admin_advert', 'Показ в период с', 'Показ в період з', 'Show from'),
('ad_type_show2_1', 'admin_advert', 'по', 'до', 'to'),
('ad_type_show3', 'admin_advert', 'Ограничено количеством показов', 'Обмежено кількістю показів', 'Unlimited number of hits'),
('ad_type_show4', 'admin_advert', 'Ограничено количеством переходов (кликов)', 'Обмежено кількістю переходів (кліків)', 'Limited number of jumps (clicks)'),
('ad_show_sec1', 'admin_advert', 'Показывается по всем разделам сайта', 'Показується по всіх розділах сайту', 'It is shown by all sections of the site'),
('ad_show_sec2', 'admin_advert', 'Показывается в разделах сайта', 'Показується в розділах сайту', 'Shown in the sections of the site'),
('ad_shows', 'admin_advert', 'Показов', 'Показів', 'Hits'),
('ad_gos', 'admin_advert', 'Переходов', 'Переходів', 'Referrals')"
);

$uninst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."advert`",
'1'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."ad_place`",
'2'=>"DELETE FROM ".$_conf['prefix']."blocks WHERE block_name='outbaner'",
'3'=>"DELETE FROM ".$_conf['prefix']."admin_menu WHERE punkt_link='admin.php?p=baner'",
'4'=>"DELETE FROM ".$_conf['prefix']."page WHERE pname='baner' OR pname='goto'",
'5'=>"DELETE FROM ".$_conf['prefix']."translate WHERE sections='admin_advert'"
);

$inst_info = '<strong>Модуль управления рекламой на сайте установлен!</strong><br />
Перейдите в раздел меню: "Модули - Блоки на странице" и для блока outbaner настройте список страниц на которых будет выводится реклама.<br />
В разделе "МОДУЛИ - Управление рекламой" добавьте необходимые рекламные места.<br />
В шаблон вставляется код рекламного места, например, если код рекламного места называется: TopAdvert, то в шаблон в соответствующем месте надо вставить следующий код: {$TopAdvert}.';

$uninst_info = '<strong>Модуль рекламы удален из сайта!</strong><br />Удалите из базового шаблона коды рекламных мест.';

$inst_relation = '';

$uninst_relation = '';

$inst_css = '';

?>