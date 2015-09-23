<?php

$inst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."forum`",
'1'=>"CREATE TABLE IF NOT EXISTS `su_forum` (
  `idf` bigint(16) unsigned NOT NULL AUTO_INCREMENT,
  `parent_idf` bigint(16) unsigned NOT NULL,
  `forder` int(6) unsigned NOT NULL,
  `ftype` char(1) NOT NULL DEFAULT 'o',
  `fgroup` text NOT NULL,
  `fuser` text NOT NULL,
  `fname_ru` varchar(250) NOT NULL,
  `fdesc_ru` text NOT NULL,
  `fname_ua` varchar(250) NOT NULL,
  `fdesc_ua` text NOT NULL,
  `fname_en` varchar(250) NOT NULL,
  `fdesc_en` text NOT NULL,
  PRIMARY KEY (`idf`),
  KEY `parent_idf` (`parent_idf`),
  KEY `forder` (`forder`),
  KEY `ftype` (`ftype`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",
'2'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."forum_msg`",
'3'=>"CREATE TABLE IF NOT EXISTS `su_forum_msg` (
  `idm` bigint(16) unsigned NOT NULL auto_increment,
  `idf` bigint(16) unsigned NOT NULL,
  `idt` bigint(16) unsigned NOT NULL,
  `mtext` text NOT NULL,
  `mavtor` bigint(16) unsigned NOT NULL,
  `mdate` bigint(16) unsigned NOT NULL,
  `mfile` varchar(250) NOT NULL,
  PRIMARY KEY  (`idm`),
  KEY `idt` (`idt`),
  KEY `mavtor` (`mavtor`),
  KEY `mdate` (`mdate`),
  KEY `idf` (`idf`),
  FULLTEXT KEY `mtext` (`mtext`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",
'4'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."forum_theme`",
'5'=>"CREATE TABLE IF NOT EXISTS `su_forum_theme` (
  `idt` bigint(16) unsigned NOT NULL auto_increment,
  `idf` bigint(16) unsigned NOT NULL,
  `tname` varchar(250) NOT NULL,
  `ttext` text NOT NULL,
  `tavtor` bigint(16) unsigned NOT NULL,
  `tview` bigint(16) unsigned NOT NULL,
  `tdate` bigint(16) unsigned NOT NULL,
  `talert` text NOT NULL,
  `tfile` varchar(250) NOT NULL,
  PRIMARY KEY  (`idt`),
  KEY `idf` (`idf`),
  KEY `tavtor` (`tavtor`),
  KEY `tdate` (`tdate`),
  FULLTEXT KEY `tname` (`tname`),
  FULLTEXT KEY `ttext` (`ttext`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",
'6'=>"INSERT INTO su_page (pname,pparent,ptitle,ppar,plevel,pfile,pgroups,ptemplate,phelp,page_blocks,ptype,linkpos,siteshow,menushow1, menushow2,menushow3,added,whoedit,content_ru,p_title_ru,p_keywords_ru,p_description_ru,linkname_ru,linktitle_ru,content_ua,p_title_ua,p_keywords_ua,p_description_ua,linkname_ua,linktitle_ua,content_en,p_title_en,p_keywords_en,p_description_en,linkname_en,linktitle_en)	VALUES ('forum','','file','','0','module/forum/forum.php','client,guest,manager,super','index.tpl','','menu_block,catalog_block,block_news', 'front','150','y','y','n','n','1281537724','1', '', 'Форум', 'Форум', 'Форум', 'Форум', 'Форум', '', 'Форум', 'Форум', 'Форум', 'Форум', 'Форум', '', 'Forum', 'Forum', 'Forum', 'Forum', 'Forum')",
'7'=>"INSERT INTO su_page (pname,pparent,ptitle,ppar,plevel,pfile,pgroups,ptemplate,phelp,page_blocks,ptype,linkpos,siteshow,menushow1, menushow2,menushow3,added,whoedit,content_ru,p_title_ru,p_keywords_ru,p_description_ru,linkname_ru,linktitle_ru,content_ua,p_title_ua,p_keywords_ua,p_description_ua,linkname_ua,linktitle_ua,content_en,p_title_en,p_keywords_en,p_description_en,linkname_en,linktitle_en)	VALUES ('forum_manage','admin_list_module','file','','1','module/forum/forum_manage.php','manager,super','admin.tpl','','', 'back','80','y','n','n','n','1281537790','1', '', 'Управление форумом', 'Управление форумом', 'Управление форумом', 'Управление форумом', 'Управление форумом', '', 'Управління форумом', 'Управління форумом', 'Управління форумом', 'Управління форумом', 'Управління форумом', '', 'Management forum', 'Management forum', 'Management forum', 'Management forum', 'Management forum')",
'8'=>"INSERT INTO su_page (pname,pparent,ptitle,ppar,plevel,pfile,pgroups,ptemplate,phelp,page_blocks,ptype,linkpos,siteshow,menushow1, menushow2,menushow3,added,whoedit,content_ru,p_title_ru,p_keywords_ru,p_description_ru,linkname_ru,linktitle_ru,content_ua,p_title_ua,p_keywords_ua,p_description_ua,linkname_ua,linktitle_ua,content_en,p_title_en,p_keywords_en,p_description_en,linkname_en,linktitle_en)	VALUES ('forum_action','forum_manage','file','','1','module/forum/forum_action.php','manager,super','asimple.tpl','','', 'backhid','1','y','n','n','n','1281537845','1', '', 'Набор действий для форума', 'Набор действий для форума', 'Набор действий для форума', 'Набор действий для форума', 'Набор действий для форума', '', 'Набір дій для форуму', 'Набір дій для форуму', 'Набір дій для форуму', 'Набір дій для форуму', 'Набір дій для форуму', '', 'A set of actions to the forum', 'A set of actions to the forum', 'A set of actions to the forum', 'A set of actions to the forum', 'A set of actions to the forum')",
'9'=>"INSERT INTO su_admin_menu(mid,punkt_parent,punkt_order,punkt_link,punkt_groups, punkt_ico, punkt_name_ru, punkt_name_ua, punkt_name_en) VALUES('','20','100','admin.php?p=forum_manage','manager,super', 'forum.png', 'Форум', 'Форум', 'Forum')",
'10'=>"INSERT INTO `su_site_config` (`name`, `val`, `com`, `grp`, `ctype`, `cvalue`) VALUES
('forum_editor', 'bbcode', 'Какой редактор использовать для написания сообщений на форуме:', 'forum', 's', 'bbcode:Редактор ВВ-кодов,fckeditor:Визуальный редактор FCKEditor')",
'11'=>"INSERT INTO `su_translate` (`pkey`, `sections`, `ru`, `ua`, `en`) VALUES
('forum', 'forum', 'Форум', 'Форум', 'Forum'),
('forum_search', 'forum', 'Поиск', 'Пошук', 'Search'),
('forum_themes', 'forum', 'Темы', 'Теми', 'Topics'),
('forum_msgs', 'forum', 'Сообщения', 'Повідомлення', 'Messages'),
('forum_lastmsg', 'forum', 'Последнее сообщение', 'Останні повідомлення', 'Last post'),
('forum_newtheme', 'forum', 'Новая тема', 'Нова тема', 'New topic'),
('forum_createthe', 'forum', 'Создать тему', 'Створити тему', 'Create a theme'),
('forum_author', 'forum', 'Автор', 'Автор', 'Author'),
('forum_msg', 'forum', 'Сообщение', 'Повідомлення', 'Message'),
('forum_makenewth', 'forum', 'Создать новую тему', 'Створити нову тему', 'Create a new topic'),
('forum_themename', 'forum', 'Название', 'Назва', 'Name'),
('forum_attach', 'forum', 'Приложение', 'Додаток', 'Attachment'),
('forum_getmail', 'forum', 'Получать уведомления о новых сообщениях', 'Отримувати оповіщення про нові повідомлення', 'Receive notifications about new posts'),
('forum_preview', 'forum', 'Предварительный просмотр', 'Попередній перегляд', 'Preview'),
('forum_needauth', 'forum', 'Чтобы оставить свое сообщение, Вам необходимо авторизоваться на сайте или зарегистрироваться.', 'Щоб написати повідомлення, Вам потрібно авторизуватися на сайті або зареєструватися.', 'To leave a message, you need to login or register.'),
('forum_find', 'forum', 'Найти сообщения', 'Знайти повідомлення', 'Find posts'),
('forum_findnew', 'forum', 'Новые', 'Нові', 'New'),
('forum_findmy', 'forum', 'Мои', 'Мої', 'My'),
('forum_findday', 'forum', 'За сутки', 'За добу', 'During the day'),
('forum_findnorep', 'forum', 'Без ответов', 'Без відповіді', 'Unanswered'),
('forum_reply', 'forum', 'Ответить', 'Відповісти', 'Reply'),
('forum_cit', 'forum', 'Цитировать', 'Цитувати', 'Quote'),
('forum_edit', 'forum', 'Редактировать', 'Редагувати', 'Edit'),
('forum_deltheme', 'forum', 'Удалить тему', 'Видалити тему', 'Delete topic'),
('forum_delattach', 'forum', 'Удалить приложение', 'Видалити додаток', 'Remove attachment'),
('forum_delmsg', 'forum', 'Удалить сообщение', 'Видалити повідомлення', 'Delete Message'),
('forum_sendmsg', 'forum', 'Отправить новое сообщение', 'Відправити нове повідомлення', 'Post a new message'),
('forum_keyword', 'forum', 'Ключевые слова', 'Ключові слова', 'Keywords'),
('forum_listtheme', 'forum', 'Список тем', 'Список тем', 'List of topics'),
('forum_repview', 'forum', 'Отв./Просм.', 'Відп./Перегл.', 'Replies/Views'),
('forum_today_in', 'forum', 'Сегодня в', 'Сьогодні в', 'Today, the'),
('forum_yestoday_in', 'forum', 'Вчера в', 'Вчора в', 'Yesterday in'),
('forum_er1', 'forum', 'Вы не ввели текст сообщения!', 'Ви не ввели текст повідомлення!', 'You have not entered the message text!'),
('forum_er2', 'forum', 'Вы не ввели название темы!', 'Ви не ввели назву теми!', 'You have not entered the name of the topic!'),
('forum_ok1', 'forum', 'Тема успешно создана!', 'Тема успішно створена!', 'Topic was created!'),
('forum_mail1', 'forum', 'Данное сообщение является автоматическим уведомлением.', 'Дане повідомлення є автоматичним сповіщенням.', 'This message is automatically notified.'),
('forum_mail2', 'forum', 'Для обратной связи, пожалуйста, используйте форму на странице', 'Для зворотнього зв''язку використовуйте форму на сторінці', 'For feedback, please use the form on the page'),
('forum_mail3', 'forum', 'С уважением, команда', 'З повагою, команда', 'Sincerely, Team'),
('forum_mail4', 'forum', 'Новое сообщение в форуме', 'Нове повідомлення на форумі', 'New post in a forum'),
('forum_themedel', 'forum', 'Тема удалена!', 'Тема видалена!', 'Topic deleted!'),
('forum_msgdel', 'forum', 'Сообщение удалено!', 'Повідомлення видалено!', 'Message has been deleted!'),
('forum_attachdel', 'forum', 'Приложение удалено!', 'Додаток видалено!', 'Attachment deleted!'),
('forum_ok2', 'forum', 'Сообщение успешно отправлено!', 'Повідомлення успішно відправлено!', 'Your message was successfully sent!'),
('forum_a_title', 'forum', 'Управление разделами форума', 'Керування розділами форума', 'Partition Management Forum'),
('forum_a_deleted', 'forum', 'Раздел, подразделы, темы и сообщения удалены!', 'Розділ, підрозділи, теми і повідомлення видалені!', 'Section, subsection, themes and messages are deleted!'),
('forum_a_er1', 'forum', 'Укажите название нового раздела!', 'Вкажіть назву нового розділу!', 'Specify the name of the new section!'),
('forum_a_ok1', 'forum', 'Новый раздел добавлен!', 'Новий розділ створено!', 'New section added!'),
('forum_a_ok2', 'forum', 'Данные сохранены!', 'Дані збережено!', 'The data have been saved!'),
('forum_a_firstsec', 'forum', 'Главная категория', 'Головна категорія', 'Main category'),
('forum_a_order', 'forum', 'Порядок разделов', 'Порядок розділів', 'The order of sections'),
('forum_a_section', 'forum', 'Раздел', 'Розділ', 'Section'),
('forum_a_themes', 'forum', 'Тем', 'Тем', 'Topics'),
('forum_a_msgs', 'forum', 'Сообщений', 'Повідомлень', 'Messages'),
('forum_a_editsec', 'forum', 'Редактировать раздел', 'Редагувати розділ', 'Edit section'),
('forum_a_selsec', 'forum', 'Выберите категорию для создания раздела или создайте новую категорию', 'Виберіть категорію для створення розділу або створіть нову категорію', 'Select a category to create a partition or create a new category'),
('forum_a_secname', 'forum', 'Название раздела', 'Назва розділу', 'Section title'),
('forum_a_secdesc', 'forum', 'Описание раздела', 'Опис розділу', 'Section description'),
('forum_a_seccreate', 'forum', 'Создать раздел', 'Створити розділ', 'Create section'),
('forum_a_alert', 'forum', 'Внимание! Во время удаления раздела, удаляются все темы и сообщения входящие в этот раздел.', 'Увага! Під час видалення розділа, видаляються всі теми і повідомлення, що входять в цей розділ.', 'Attention! During the removal of the partition will delete all incoming messages and themes in this section.'),
('forum_ftype', 'forum', 'Тип раздела', 'Тип розділу', 'Type section'),
('forum_ftype_o', 'forum', 'все посетители могут читать, а пользователи писать', 'всі відвідувачі можуть читати, а користувачі писати', 'All visitors can read and write users'),
('forum_ftype_c', 'forum', 'все посетители могут читать, только избранные пользователи писать', 'всі відвідувачі можуть читати, лише вибрані користувачі писати', 'All visitors can read only selected users to write'),
('forum_ftype_s', 'forum', 'читать и писать могут только избранные пользователи', 'читати і писати можуть лише вибрані користувачі', 'read and write can only selected users'),
('forum_ftype_sel', 'forum', 'Укажите пользователей, которые будут иметь доступ к данному разделу.<br />Найти пользователей по Айди, логина, ФИО, e-mail', 'Вкажіть користувачів, які будуть мати доступ до даного розділу.<br />Знайти користувачів по айді, логіну, ФІО, e-mail', 'Specify the users who will have access to this section.<br />Search Users by aydi, login, Full name, e-mail'),
('forum_ftype_selected', 'forum', 'Выбранные пользователи', 'Вибрані користувачі', 'Selected Users')"
);

$uninst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."forum`",
'1'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."forum_msg`",
'2'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."forum_theme`",
'3'=>"DELETE FROM ".$_conf['prefix']."page WHERE pname='forum' OR pname='forum_manage' OR pname='forum_action'",
'4'=>"DELETE FROM ".$_conf['prefix']."admin_menu WHERE punkt_link='admin.php?p=forum_manage'",
'5'=>"DELETE FROM ".$_conf['prefix']."site_config WHERE grp='forum'",
'6'=>"DELETE FROM ".$_conf['prefix']."translate WHERE sections='forum'"
);

$inst_info = '<strong>Модуль управления форумом на сайте установлен!</strong><br />
Перейдите в раздел меню: "Модули - Форум" и создайте разделы форума.<br />
';

$uninst_info = '<strong>Модуль форума удален из сайта!</strong><br />';

$inst_relation = '';

$uninst_relation = '';

$inst_css = '/* forum */
.forumtab{empty-cells:show;}
.forumtab th{padding:3px;empty-cells:show;border-collapse:collapse;border-top:solid 1px #ccdaec;border-bottom:solid 1px #ccdaec;background:#e8eff7;color:#666666;text-align:left;font-size:11px;}
.forumtab td{padding:5px;empty-cells:show;font-size:12px;border-collapse:collapse;border-bottom:solid 2px #ccdaec;}
.bgg{background:#ecf1f8;}
.avtortd{border-right:solid 2px #ccdaec;width:100px;}
.forumtab th a:link, .forumtab th a:active, .forumtab th a:visited {color: #666666;outline: none;text-decoration: none;	font-size:14px;}
.forumtab th a:hover {text-decoration: underline;color:#000000;}
.forumtab td a:link, .forumtab td a:active, .forumtab td a:visited {outline: none;text-decoration: none;font-size:12px;}
.forumtab td a:hover {text-decoration: underline;}
.forumtab th span{font-weight:normal;font-size:10px;}
.red{color:#a9422a;}
.fdate{border-bottom:solid 1px #e2eaf5;}
.fdate1{border-top:solid 1px #e2eaf5;}
.quote{margin-left:20px;border:solid 1px #cccccc;background:#ecf1f8;padding:5px;}
.found{background:#CCFF33;}';

?>