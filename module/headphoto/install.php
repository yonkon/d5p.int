<?php

$inst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."headphoto`",
'1'=>"CREATE TABLE IF NOT EXISTS `".$_conf['prefix']."headphoto` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `file` varchar(100) NOT NULL,
  `pages` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pages` (`pages`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",
'2'=>"INSERT INTO ".$_conf['prefix']."page(`pname`, `pparent`, `ptitle`, `ppar`, `plevel`, `pfile`, `pgroups`, `ptemplate`, `phelp`, `page_blocks`, `ptype`, `linkpos`, `siteshow`, `menushow1`, `menushow2`, `menushow3`, `added`, `lastedit`, `whoedit`, `beditor`, `content_ru`, `p_title_ru`, `p_keywords_ru`, `p_description_ru`, `linkname_ru`, `linktitle_ru`, `content_ua`, `p_title_ua`, `p_keywords_ua`, `p_description_ua`, `linkname_ua`, `linktitle_ua`, `content_en`, `p_title_en`, `p_keywords_en`, `p_description_en`, `linkname_en`, `linktitle_en`)VALUES('hp_manage', 'admin_list_module', 'file', '', 1,'module/headphoto/hp_manage.php', 'administrator,super', 'admin.tpl', '', '', 'back', 25, 'y', 'n', 'n', 'n', 1328557477, 1328557556, 2, 'no', '', 'Фото для шапки сайта', 'Фото для шапки сайта', 'Фото для шапки сайта', 'Фото для шапки сайта', 'Фото для шапки сайта', '', 'Фото для шапки сайту', 'Фото для шапки сайту', 'Фото для шапки сайту', 'Фото для шапки сайту', 'Фото для шапки сайту', '', 'Photo for the header of the site', 'Photo for the header of the site', 'Photo for the header of the site', 'Photo for the header of the site', 'Photo for the header of the site')",
'3'=>"INSERT INTO ".$_conf['prefix']."admin_menu(punkt_parent,punkt_order,punkt_link,punkt_groups,punkt_ico,punkt_name_ru,punkt_name_ua,punkt_name_en) VALUES(20, 700, 'admin.php?p=hp_manage', 'administrator,super', 'headphoto.png', 'Фото в шапке сайта', 'Фото в шапці сайту', 'Photos in the header')",
'4'=>"INSERT INTO ".$_conf['prefix']."blocks(`block_name`, `block_file`, `block_description`, `btype`, `beditor`, `content_ru`, `content_ua`, `content_en`) VALUES('hp_block', 'module/headphoto/hp_block.php', 'Блок для вывода фото в шапке сайта', 'file', 'no', '', '', '')",
'5'=>"INSERT INTO `".$_conf['prefix']."site_config` (`name`, `val`, `com`, `grp`, `ctype`, `cvalue`) VALUES
('hp_path', 'hp', 'Путь для хранения фото шапки сайта', 'headphoto', 'v', '')"
);

$uninst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."headphoto`",
'4'=>"DELETE FROM ".$_conf['prefix']."page WHERE pname='hp_manage'",
'5'=>"DELETE FROM ".$_conf['prefix']."admin_menu WHERE punkt_link='admin.php?p=hp_manage'",
'6'=>"DELETE FROM ".$_conf['prefix']."blocks WHERE block_name='hp_block'",
'7'=>"DELETE FROM ".$_conf['prefix']."site_config WHERE grp='headphoto'"
);

$inst_info = '<strong>Модуль загрузки фото для шапки сайта установлен!</strong><br />
Перейдите в раздел меню: "Модули - Блоки на странице" и для блока hp_block настройте страницы на которых будут выводится фото.<br />
';

$uninst_info = '<strong>Модуль загрузки фото для шапки сайта удален из сайта!</strong><br />Удалите из базового шаблона код блока. <br />';

$inst_relation = '';

$uninst_relation = '';

$inst_css = '';

?>