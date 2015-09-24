<?php

$inst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."articles`",
'1'=>"CREATE TABLE IF NOT EXISTS `".$_conf['prefix']."articles` (
  `r_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `r_dadd` bigint(16) unsigned NOT NULL,
  `r_dedit` bigint(16) unsigned NOT NULL,
  `r_wadd` bigint(16) unsigned NOT NULL,
  `r_wedit` bigint(16) unsigned NOT NULL,
  `r_source` varchar(255) NOT NULL,
  `r_title` varchar(255) NOT NULL,
  `r_avtor` varchar(255) NOT NULL,
  `r_abstract` text NOT NULL,
  `r_content` longtext NOT NULL,
  PRIMARY KEY (`r_id`),
  FULLTEXT KEY `r_title` (`r_title`),
  FULLTEXT KEY `r_abstract` (`r_abstract`),
  FULLTEXT KEY `r_content` (`r_content`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",
'2'=>"INSERT INTO ".$_conf['prefix']."page(`pname`, `pparent`, `ptitle`, `ppar`, `plevel`, `pfile`, `pgroups`, `ptemplate`, `phelp`, `page_blocks`, `ptype`, `linkpos`, `siteshow`, `menushow1`, `menushow2`, `menushow3`, `added`, `lastedit`, `whoedit`, `beditor`, `content_ru`, `p_title_ru`, `p_keywords_ru`, `p_description_ru`, `linkname_ru`, `linktitle_ru`, `content_ua`, `p_title_ua`, `p_keywords_ua`, `p_description_ua`, `linkname_ua`, `linktitle_ua`, `content_en`, `p_title_en`, `p_keywords_en`, `p_description_en`, `linkname_en`, `linktitle_en`)VALUES('articles_manage', 'admin_list_module', 'file', '', 1, 'module/articles/articles_manage.php', 'administrator,manager,super', 'admin.tpl', '', '', 'back', 50, 'y', 'n', 'n', 'n', 1329758641, 0, 1, 'no', '', 'Управление каталогом статей', 'Управление каталогом статей', 'Управление каталогом статей', 'Управление каталогом статей', 'Управление каталогом статей', '', 'Управління каталогом статей', 'Управління каталогом статей', 'Управління каталогом статей', 'Управління каталогом статей', 'Управління каталогом статей', '', 'Managing the Directory Articles', 'Managing the Directory Articles', 'Managing the Directory Articles', 'Managing the Directory Articles', 'Managing the Directory Articles'),('articles', '', 'file', '', 0, 'module/articles/articles.php', 'administrator,client,guest,manager,super', 'index.tpl', '', 'menu_block,breadcrumbs,newssign', 'front', 50, 'y', 'y', 'n', 'n', 1329762612, 0, 1, 'no', '', 'Статьи', 'Статьи', 'Статьи', 'Статьи', 'Статьи', '', 'Статті', 'Статті', 'Статті', 'Статті', 'Статті', '', 'Articles', 'Articles', 'Articles', 'Articles', 'Articles')",
'3'=>"INSERT INTO ".$_conf['prefix']."admin_menu(punkt_parent,punkt_order,punkt_link,punkt_groups,punkt_ico,punkt_name_ru,punkt_name_ua,punkt_name_en) VALUES(20, 100, 'admin.php?p=articles_manage', 'administrator,manager,super', 'articles.png', 'Статьи', 'Статті', 'Articles')",
'4'=>"INSERT INTO ".$_conf['prefix']."blocks(block_name,block_file,block_description,btype,beditor,content_ru,content_ua,content_en) VALUES ('articles_block', 'module/articles/articles_block.php', 'Блок для вывода новых статей', 'file', 'no', '', '', '')",
'5'=>"INSERT INTO `".$_conf['prefix']."site_config` (`name`, `val`, `com`, `grp`, `ctype`, `cvalue`) VALUES
('arteditor', 'ck', 'Редактор статей', 'articles', 's', 'ck:CKEditor,fck:FCKeditor,earea:EditArea,no:не использовать редактор')",
'6'=>"INSERT INTO `".$_conf['prefix']."translate` (`pkey`, `sections`, `ru`, `ua`, `en`) VALUES
('art_title', 'articles', 'Статьи', 'Статті', 'Articles'),
('art_er1', 'articles', 'Ошибка! Пожалуйста, укажите название статьи!', 'Помилка! Будь ласка, вкажіть назву статті!', 'Error! Please specify the title of the article!'),
('art_ok1', 'articles', 'Новая статья добавлена в базу данных!', 'Нова стаття додана в базу даних!', 'A new article is added to the database!'),
('art_add', 'articles', 'Добавить статью', 'Додати статтю', 'Submit an article'),
('art_tit', 'articles', 'Заглавие', 'Заголовок', 'Title'),
('art_avtor', 'articles', 'Автор', 'Автор', 'Author'),
('art_anons', 'articles', 'Анонс', 'Анонс', 'Announcement'),
('art_txt', 'articles', 'Текст статьи', 'Текст статті', 'The text of article'),
('art_src', 'articles', 'Источник', 'Джерело', 'Source'),
('art_date', 'articles', 'Дата', 'Дата', 'Date'),
('art_ok2', 'articles', 'Данные успешно обновлены!', 'Дані успішно оновлені!', 'Data successfully updated!'),
('art_ok3', 'articles', 'Статья удалена из базы данных!', 'Стаття вилучена з бази даних!', 'The article is removed from the database!'),
('art_edit', 'articles', 'Редактировать статью', 'Редагувати статтю', 'Edit the article'),
('art_allart', 'articles', 'Все статьи', 'Всі статті', 'All articles')"
);

$uninst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."articles`",
'4'=>"DELETE FROM ".$_conf['prefix']."page WHERE pname='articles' OR pname='articles_manage'",
'5'=>"DELETE FROM ".$_conf['prefix']."admin_menu WHERE punkt_link='admin.php?p=articles_manage'",
'6'=>"DELETE FROM ".$_conf['prefix']."blocks WHERE block_name='articles_block'",
'7'=>"DELETE FROM ".$_conf['prefix']."site_config WHERE grp='articles'",
'8'=>"DELETE FROM ".$_conf['prefix']."translate WHERE sections='articles'"
);

$inst_info = '<strong>Модуль управления каталогом статей на сайте установлен!</strong><br />
Перейдите в раздел меню: "Модули - Блоки на странице" и для блока articles_block настройте страницы на которых будут выводится анонсы статей.<br />
Перейдите в раздел меню: "Модули - Страницы" и откройте для редактирования страницу: articles. Настройте блоки, что будут выводится на этой странице.<br />
В базовом шаблоне(ах) пропишите код для вывода блока с анонсом статей: <code>{if isset($articles_block) && $articles_block!=""}{$articles_block}{/if}</code><br />
';

$uninst_info = '<strong>Модуль каталога статей удален из сайта!</strong><br />';

$inst_relation = '';

$uninst_relation = '';

$inst_css = '/* articles */
.artarea{}
.artitem{clear:both;}
.artitem h1{}
.artitem .artdate{}
.artitem .artavtor{}
.artitem .artanons{text-align:right;margin-left:100px;font-style:italic;}
.artitem .arttxt{}
.artitem .artsrc{}
.artitem .artall{text-align:right;clear:both;}

.artlist{}
.artlist li{}
.artlist li a{}
.artlist li span.artdate{}
.artlist li span.artavtor{}
.artlist li span.artanons{}

.art_block{}
.artblist{}
artblist li{}
artblist li a{}
.art_block .artball{text-align:right;}
';

?>