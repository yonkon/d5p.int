<?php

$inst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."news_en`",
'1'=>"CREATE TABLE IF NOT EXISTS `".$_conf['prefix']."news_en` (
  `idn` int(6) unsigned NOT NULL auto_increment,
  `ntitle` varchar(250) NOT NULL default '',
  `nanons` tinytext NOT NULL,
  `ntext` text NOT NULL,
  `nlink` varchar(250) NOT NULL default '',
  `date` bigint(16) unsigned NOT NULL default '0',
  `id` int(6) unsigned NOT NULL,
  PRIMARY KEY  (`idn`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",
'2'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."news_ru`",
'3'=>"CREATE TABLE IF NOT EXISTS `".$_conf['prefix']."news_ru` (
  `idn` int(6) unsigned NOT NULL auto_increment,
  `ntitle` varchar(250) NOT NULL default '',
  `nanons` tinytext NOT NULL,
  `ntext` text NOT NULL,
  `nlink` varchar(250) NOT NULL default '',
  `date` bigint(16) unsigned NOT NULL default '0',
  `id` int(6) unsigned NOT NULL,
  PRIMARY KEY  (`idn`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",
'4'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."news_ua`",
'5'=>"CREATE TABLE IF NOT EXISTS `".$_conf['prefix']."news_ua` (
  `idn` int(6) unsigned NOT NULL auto_increment,
  `ntitle` varchar(250) NOT NULL default '',
  `nanons` tinytext NOT NULL,
  `ntext` text NOT NULL,
  `nlink` varchar(250) NOT NULL default '',
  `date` bigint(16) unsigned NOT NULL default '0',
  `id` int(6) unsigned NOT NULL,	
  PRIMARY KEY  (`idn`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",
'6'=>"CREATE TABLE IF NOT EXISTS `".$_conf['prefix']."news_category` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `ru` varchar(255) NOT NULL,
  `en` varchar(255) NOT NULL,
  `ua` varchar(255) NOT NULL,
  `ntrans` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ntrans` (`ntrans`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",
'7'=>"INSERT INTO ".$_conf['prefix']."page(pname,pparent,ptitle,plevel,pfile,pgroups,ptemplate,phelp,page_blocks,ptype,linkpos,siteshow,menushow1,added,lastedit,whoedit,p_title_ru,p_keywords_ru,p_description_ru,linkname_ru,linktitle_ru,p_title_ua,p_keywords_ua,p_description_ua,linkname_ua,linktitle_ua,p_title_en,p_keywords_en,p_description_en,linkname_en,linktitle_en)VALUES('admin_news','admin_list_module','file','1','module/news/admin_news.php','manager,super',	'admin.tpl','','','back','20','y','n',0,0,1,'Управление новостями сайта','Управление новостями сайта','Управление новостями сайта','','','Керування новинами сайту','Керування новинами сайту','Керування новинами сайту','','','News manage','News manage','News manage','','')",
'8'=>"INSERT INTO ".$_conf['prefix']."page(pname,pparent,ptitle,plevel,pfile,pgroups,ptemplate,phelp,page_blocks,ptype,linkpos,siteshow,menushow1,added,lastedit,whoedit,p_title_ru,p_keywords_ru,p_description_ru,linkname_ru,linktitle_ru,p_title_ua,p_keywords_ua,p_description_ua,linkname_ua,linktitle_ua,p_title_en,p_keywords_en,p_description_en,linkname_en,linktitle_en)VALUES('getphoto','admin_news','file','1','module/news/getphoto.php','manager,super','asimple.tpl','','','back','1','y','n',0,0,1,'Загрузка фото к анонсу новостей','Загрузка фото к анонсу новостей','Загрузка фото к анонсу новостей','','','Завантаження фото до анонсу новин','Завантаження фото до анонсу новин','Завантаження фото до анонсу новин','','','Загрузка фото к анонсу новостей','Загрузка фото к анонсу новостей','Загрузка фото к анонсу новостей','','')",
'9'=>"INSERT INTO ".$_conf['prefix']."page(pname,pparent,ptitle,plevel,pfile,pgroups,ptemplate,phelp,page_blocks,ptype,linkpos,siteshow,menushow1,added,lastedit,whoedit,p_title_ru,p_keywords_ru,p_description_ru,linkname_ru,linktitle_ru,p_title_ua,p_keywords_ua,p_description_ua,linkname_ua,linktitle_ua,p_title_en,p_keywords_en,p_description_en,linkname_en,linktitle_en)VALUES('news','','file','0','module/news/news.php','client,guest,manager,super','index.tpl','','','front','50','y','y',0,0,1,'Новости','Новости','Новости','Новости','Новости','Новини','Новини','Новини','Новини','Новини','News','News','News','News','News')",
'10'=>"INSERT INTO ".$_conf['prefix']."admin_menu(mid,punkt_parent,punkt_order,punkt_link,punkt_groups,punkt_ico,punkt_name_ru,punkt_name_ua,punkt_name_en) VALUES('','20','50','admin.php?p=admin_news','manager,super','news.png','Новости','Новини','News')",
'11'=>"INSERT INTO ".$_conf['prefix']."blocks(block_name,block_file,block_description,btype) VALUES ('block_news','module/news/block_news.php','Блок для вывода анонса новостей на страницах сайта','file')",
'12'=>"INSERT INTO `".$_conf['prefix']."site_config` (`name`, `val`, `com`, `grp`, `ctype`, `cvalue`) VALUES
('comments', 'n', 'Комментарии к новостям', 'news', 's', 'y:Включить добавлениt комментариев,n:отключить добавление комментариев'),
('nthumb_w', '100', 'Ширина превью фото в анонсе новостей', 'news', 'i', ''),
('nthumb_h', '100', 'Высота превью фото в анонсе новостей', 'news', 'i', ''),
('news_count', '3', 'К-во новостей выводимых в анонсах', 'news', 'i', ''),
('news_count1', '10', 'К-во новостей выводимых на странице новостей', 'news', 'i', ''),
('neditor', 'ck', 'Редактор новостей', 'news', 's', 'ck:CKEditor,fck:FCKeditor,earea:EditArea,no:не использовать редактор'),
('news_calendar', 'y', 'Выводить календарь в блоке новостей', 'news', 'r', 'y:Включить,n:Выключить')",
'13'=>"CREATE TABLE IF NOT EXISTS `".$_conf['prefix']."comments` (
  `id` bigint(16) unsigned NOT NULL auto_increment,
  `idu` bigint(16) unsigned NOT NULL,
  `uname` varchar(50) NOT NULL,
  `uemail` varchar(100) NOT NULL,
  `service` varchar(20) NOT NULL,
  `id_item` bigint(16) unsigned NOT NULL,
  `date` bigint(16) unsigned NOT NULL,
  `comtext` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idu` (`idu`),
  KEY `service` (`service`),
  KEY `id_item` (`id_item`),
  KEY `date` (`date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",
'14'=>"INSERT INTO `".$_conf['prefix']."translate` (`pkey`, `sections`, `ru`, `ua`, `en`) VALUES
('news', 'news', 'Новости', 'Новини', 'News'),
('allnews', 'news', 'Все новости', 'Всі новини', 'All news'),
('news_rss_title', 'news', 'Новости сайта', 'Новини сайту', 'Site news'),
('news_writecom', 'news', 'Написать комментарий', 'Написати коментар', 'Write comments'),
('news_com', 'news', 'Комментарии', 'Коментарі', 'Comments'),
('news_comsaved', 'news', 'Ваш комментарий успешно сохранен!', 'Ваш коментар успішно збережено!', 'Your comment has been saved!'),
('news_com_er1', 'news', 'Вы не ввели текст сообщения!', 'Ви не ввели текст повідомлення!', 'You have not entered the message text!'),
('anews_title', 'admin_news', 'Новости сайта', 'Новини сайту', 'Site News'),
('anews_add', 'admin_news', 'Добавить новость', 'Додати новину', 'Add news'),
('anews_list', 'admin_news', 'Список новостей', 'Список новин', 'List News'),
('anews_date', 'admin_news', 'Дата новости', 'Дата новини', 'Date of news'),
('anews_loadimg', 'admin_news', 'Загрузить изображение для отображения в анонсах новостей', 'Завантажити зображення для відображення в анонсах новин', 'Upload an image to display in news announcements'),
('anews_imgloaded', 'admin_news', 'Изображение успешно загружено на сервер!', 'Зображення успішно завантажено на сервер!', 'Images successfully uploaded to the server!'),
('anews_imgdeleted', 'admin_news', 'Фотография удалена!', 'Зображення видалено!', 'Photo deleted!'),
('anews_imgnotfound', 'admin_news', 'Файл не найден!', 'Файл не знайдено!', 'File not found!'),
('anews_ntitle', 'admin_news', 'Краткое заглавие (объязательно должно быть заполнено, длина до 250 символов)', 'Короткий заголовок (обов''язково заповнити, довжина до 250 символів)', 'Short title (obligatory to be filled, the length to 250 characters)'),
('anews_nlink', 'admin_news', 'Ссылка. Если новость, которую вы добавляете, это ссылка на другой сайт, введите в строке ниже полный адрес к этому сайту. В этом случае в нижнем окне ничего вводить не надо', 'Лінк. Якщо новина, яку ви додаєте, знаходиться на іншому сайті, введіть в полі нижче адресу до цього сайту. В цьому випадку у вікні з текстом новини нічого вводити не треба', 'Link. If the news that you add a link to another site, type in the box below the full address to this site. In this case, nothing in the lower window is not necessary.'),
('anews_ntext', 'admin_news', 'В окне ниже можете вводить любой текст и форматировать его, используя панель инструментов! После этого нужно нажать кнопку <b>Добавить</b>.', 'У вікні нижче можна вводити будь-який текст і форматувати його, використовуючи панель інструментів! Після цього натисніть кнопку <b>Додати</b>', 'In the window below you can enter any text and format it using the toolbar! You must then click <b> Add </ b>.'),
('anews_saved', 'admin_news', 'Новость добавлена в базу данных!', 'Новину додано до бази даних!', 'The news added to the database!'),
('anews_upadated', 'admin_news', 'Новость сохранена!', 'Новина збережена!', 'The news has been saved!'),
('anews_deleted', 'admin_news', 'Новость удалена!', 'Новина видалена!', 'News removed!'),
('anews_comdeleted', 'admin_news', 'Комментарий удален!', 'Коментар видалений!', 'Comment deleted!'),
('anews_edit', 'admin_news', 'Редактировать новость', 'Редагувати новину', 'Edit news'),
('anews_delphoto', 'admin_news', 'Удалить фото', 'Видалити фото', 'Delete photo'),
('anews_catwindow', 'admin_news', 'Категории новостей', 'Категорії новин', 'News categories'),
('anews_cat_er1', 'admin_news', 'Ошибка! Заполните все поля!', 'Помилка! Заповніть всі поля!', 'Error! Fill in all fields!'),
('anews_cat_ok1', 'admin_news', 'Новая категория добавлена!', 'Нова категорія добавлена​​!', 'The new category is added!'),
('anews_cat_ok2', 'admin_news', 'Данные успешно обновлены!', 'Дані успішно оновлені!', 'Data successfully updated!'),
('anews_category', 'admin_news', 'Категория', 'Категорія', 'Category'),
('anews_ltit', 'admin_news', 'Заглавие', 'Заголовок', 'Title')"
);

$uninst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."news_en`",
'1'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."news_ru`",
'2'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."news_ua`",
'3'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."news_category`",
'4'=>"DELETE FROM ".$_conf['prefix']."page WHERE pname='admin_news' OR pname='getphoto' OR pname='news'",
'5'=>"DELETE FROM ".$_conf['prefix']."admin_menu WHERE punkt_link='admin.php?p=admin_news'",
'6'=>"DELETE FROM ".$_conf['prefix']."blocks WHERE block_name='block_news'",
'7'=>"DELETE FROM ".$_conf['prefix']."site_config WHERE grp='news'",
'8'=>"DELETE FROM ".$_conf['prefix']."translate WHERE sections='news' OR sections='admin_news'"
);

$inst_info = '<strong>Модуль управления новостями на сайте установлен!</strong><br />
Перейдите в раздел меню: "Модули - Блоки на странице" и для блока block_news настройте страницы на которых будут выводится анонсы новостей.<br />
Перейдите в раздел меню: "Модули - Страницы" и откройте для редактирования страницу: news. Настройте блоки, что будут выводится на этой странице.<br />
В базовом шаблоне(ах) пропишите код для вывода блока с анонсом новостей: <code>{if isset($block_news) && $block_news!=""}{$block_news}{/if}</code><br />
В папке files/rss создается лента новостей для экспорта. Для подключения в базовом структурном шаблоне в заголовке прописать:<br />
<code>&lt;link rel="alternate" type="application/rss+xml" title="News RSS" href="{$conf.www_patch}/files/rss/news_{$smarty.session.lang}.rss" /&gt;</code><br />
';

$uninst_info = '<strong>Модуль новостей удален из сайта!</strong><br />Удалите из базового шаблона строку с ссылкой на ленту новостей: <br />
<code>&lt;link rel="alternate" type="application/rss+xml" title="News RSS" href="{$conf.www_patch}/files/rss/news_{$smarty.session.lang}.rss" /&gt;</code>';

$inst_relation = '';

$uninst_relation = '';

$inst_css = '/* news */
.bnews .bnitem{margin-bottom:10px;}
.bnews .bnitem .bntitle{font:bold 14px/18px Arial, Helvetica, sans-serif; display:block;}
.bnews .bnitem .bndate{font:bold 11px/14px Arial, Helvetica, sans-serif; display:block;margin-bottom:3px;}
.bnews .bnitem .bnimg{margin-right:5px;}
.bnews .bnitem .bntxt{font:12px/15px Arial, Helvetica, sans-serif;}

.news .nitem{margin-bottom:10px;}
.news .nitem .ntitle{font:bold 14px/18px Arial, Helvetica, sans-serif; display:block;}
.news .nitem .ndate{font:bold 11px/14px Arial, Helvetica, sans-serif; display:block;margin-bottom:3px;}
.news .nitem .nimg{margin-right:5px;float:left;}
.news .nitem .ntxt{font:12px/15px Arial, Helvetica, sans-serif;}
.news .nitem .news_category{margin-bottom:6px;}
.news .nitem .news_category a{margin-right:20px;}';

?>