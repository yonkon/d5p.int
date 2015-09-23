<?php
$mod_version = '1.00.00';
$inst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."faq`",
'1'=>"CREATE TABLE IF NOT EXISTS `".$_conf['prefix']."faq` (
  `q_id` bigint(16) unsigned NOT NULL AUTO_INCREMENT,
  `q_state` enum('n','o','y') NOT NULL,
  `q_date` bigint(16) NOT NULL,
  `q_date1` bigint(16) unsigned NOT NULL,
  `q_who` bigint(16) unsigned NOT NULL,
  `q_group` varchar(150) NOT NULL,
  `q_name` varchar(255) NOT NULL,
  `q_email` varchar(150) NOT NULL,
  `q_quest_ru` text NOT NULL,
  `q_quest_ua` text NOT NULL,
  `q_quest_en` text NOT NULL,
  `q_reply_ru` text NOT NULL,
  `q_reply_ua` text NOT NULL,
  `q_reply_en` text NOT NULL,
  PRIMARY KEY (`q_id`),
  KEY `q_date` (`q_date`),
  KEY `q_group` (`q_group`),
  KEY `q_who` (`q_who`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",
'2'=>"INSERT INTO ".$_conf['prefix']."page(pname,pparent,ptitle,plevel,pfile,pgroups,ptemplate,phelp,page_blocks,ptype,linkpos,siteshow,menushow1,added,lastedit,whoedit,p_title_ru,p_keywords_ru,p_description_ru,linkname_ru,linktitle_ru,p_title_ua,p_keywords_ua,p_description_ua,linkname_ua,linktitle_ua,p_title_en,p_keywords_en,p_description_en,linkname_en,linktitle_en)VALUES('admin_faq','admin_list_module','file','1','module/faq/admin_faq.php','manager,super,administrator',	'admin.tpl','','','back','20','y','n',0,0,1,'Модуль ответов на вопросы (ЧаВо)','Модуль ответов на вопросы (ЧаВо)','Модуль ответов на вопросы (ЧаВо)','','','Модуль відповідей на питання (ЧаПи)','Модуль відповідей на питання (ЧаПи)','Модуль відповідей на питання (ЧаПи)','','','The module replies to the questions (FAQ)','The module replies to the questions (FAQ)','The module replies to the questions (FAQ)','','')",
'3'=>"INSERT INTO ".$_conf['prefix']."page(pname,pparent,ptitle,plevel,pfile,pgroups,ptemplate,phelp,page_blocks,ptype,linkpos,siteshow,menushow1,added,lastedit,whoedit,p_title_ru,p_keywords_ru,p_description_ru,linkname_ru,linktitle_ru,p_title_ua,p_keywords_ua,p_description_ua,linkname_ua,linktitle_ua,p_title_en,p_keywords_en,p_description_en,linkname_en,linktitle_en)VALUES('faq','','file','0','module/faq/faq.php','client,guest,manager,super,administrator','index.tpl','','','front','50','y','y',0,0,1,'Вопрос-Ответ','Вопрос-Ответ','Вопрос-Ответ','Вопрос-Ответ','Вопрос-Ответ','Питання-Відповідь','Питання-Відповідь','Питання-Відповідь','Питання-Відповідь','Питання-Відповідь','FAQ','FAQ','FAQ','FAQ','FAQ')",
'4'=>"INSERT INTO ".$_conf['prefix']."admin_menu(mid,punkt_parent,punkt_order,punkt_link,punkt_groups,punkt_ico,punkt_name_ru,punkt_name_ua,punkt_name_en) VALUES('','20','50','admin.php?p=admin_faq','manager,super,administrator','faq.png','Вопрос-Ответ','Питання-Відповідь','FAQ')",
'5'=>"INSERT INTO `".$_conf['prefix']."site_config` (`name`, `val`, `com`, `grp`, `ctype`, `cvalue`) VALUES
('faq_addquest', 'y', 'Разрешить отправку вопросов посетителями', 'faq', 's', 'y:Включить,n:Отключить'),
('faq_uname', 'n', 'Спрашивать имя человека задающего вопрос', 'faq', 's', 'y:Включить,n:Отключить'),
('faq_uemail', 'n', 'Спрашивать e-amil человека задающего вопрос', 'faq', 's', 'y:Включить,n:Отключить'),
('faq_count', '10', 'Количество вопросов выводимых на одной странице', 'faq', 'i', ''),
('faq_editor', 'ck', 'Редактор ответов', 'faq', 's', 'ck:CKEditor,fck:FCKeditor,earea:EditArea,no:не использовать редактор')",
'6'=>"INSERT INTO `".$_conf['prefix']."translate` (`pkey`, `sections`, `ru`, `ua`, `en`) VALUES
('a_faq', 'admin_faq', 'Вопрос-Ответ', 'Питання-відповідь', 'Q & A'),
('a_faqlist', 'admin_faq', 'Список вопросов', 'Список питань', 'A list of questions'),
('a_faq_new', 'admin_faq', 'Новый', 'Новий', 'New'),
('a_faq_freeze', 'admin_faq', 'Отложен или без ответа', 'Відкладений або без відповіді', 'Delayed or no response'),
('a_faq_show', 'admin_faq', 'Показывается', 'Показується', 'It is shown'),
('a_faq_ok1', 'admin_faq', 'Информация обновлена!', 'Інформація оновлена', 'Updated'),
('a_faq_ok2', 'admin_faq', 'Вопрос удален из базы данных!', 'Питання видалено з бази даних', 'The question is deleted from the database'),
('a_faq_adddate', 'admin_faq', 'Дата добавления вопроса', 'Додано питання', 'Date issue'),
('a_faq_datereply', 'admin_faq', 'Дата написания ответа', 'Дата написання відповіді', 'Date of written response'),
('a_faq_switch', 'admin_faq', 'Включить показ вопроса на сайте', 'Включити показ питання на сайті', 'Include screening questions on the site'),
('a_faq_question', 'admin_faq', 'Вопрос', 'Питання', 'Question'),
('a_faq_answer', 'admin_faq', 'Ответ', 'Відповідь', 'Answer'),
('a_faq_state', 'admin_faq', 'Состояние', 'Стан', 'State'),
('a_faq_issue', 'admin_faq', 'Дата вопроса', 'Дата питання', 'Date of issue'),
('a_faq_reply', 'admin_faq', 'Дата ответа', 'Дата відповіді', 'Date of reply'),
('s_faq', 'faq', 'Вопрос-Ответ', 'Питання-відповідь', 'Q & A'),
('s_faq_reply_date', 'faq', 'Ответ на вопрос от', 'Відповідь на питання від', 'The answer to the question of'),
('s_faq_allquest', 'faq', 'Все вопросы', 'Всі питання', 'All issues'),
('s_faq_add', 'faq', 'Задать свой вопрос', 'Поставити своє питання', 'Ask your question'),
('s_faq_name', 'faq', 'Ваше имя', 'Ваше ім''я', 'Your Name'),
('s_faq_email', 'faq', 'Ваш e-mail', 'Ваш e-mail', 'Your e-mail'),
('s_faq_code', 'faq', 'Введите текст', 'Введіть текст', 'Enter the text'),
('s_faq_send', 'faq', 'Отправить', 'Відправити', 'Send'),
('s_faq_er1', 'faq', 'Ошибка! Пожалуйста, укажите Ваше имя!', 'Помилка! Будь ласка, вкажіть Ваше ім''я!', 'Error! Please include your name!'),
('s_faq_er2', 'faq', 'Ошибка! Пожалуйста, укажите Ваш e-mail!', 'Помилка! Будь ласка, вкажіть Ваш e-mail!', 'Error! Please enter your e-mail!'),
('s_faq_er3', 'faq', 'Ошибка! Пожалуйста, введите код из рисунка!', 'Помилка! Будь ласка, введіть код з малюнка!', 'Error! Please enter the code from the picture!'),
('s_faq_ok1', 'faq', 'Ваш вопрос успешно отправлен администрации сайта!', 'Ваше питання успішно надіслано адміністрації сайту!', 'Your question has been successfully sent from the site!')"
);

$uninst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."faq`",
'1'=>"DELETE FROM ".$_conf['prefix']."page WHERE pname='admin_faq' OR pname='faq'",
'2'=>"DELETE FROM ".$_conf['prefix']."admin_menu WHERE punkt_link='admin.php?p=admin_faq'",
'3'=>"DELETE FROM ".$_conf['prefix']."site_config WHERE grp='faq'",
'4'=>"DELETE FROM ".$_conf['prefix']."translate WHERE sections='faq' OR sections='admin_faq'"
);

$inst_info = '<strong>Модуль управления вопросами и ответами (ЧаВо) на сайте установлен!</strong><br />
Перейдите в раздел меню: "Модули - Страницы" и откройте для редактирования страницу: faq. Настройте блоки, что будут выводится на этой странице.<br />
';

$uninst_info = '<strong>Модуль управления вопросами и ответами (ЧаВо) удален из сайта!</strong><br />';

$inst_relation = '';

$uninst_relation = '';

$inst_css = '/* faq module */
.faqH3{cursor:pointer;}
#QFA label{display:block;}
#QFA input[type="text"], #QFA input[type~="text"]{width:170px;}
#QFA textarea{width:270px; height:150px; margin-right:10px;}
.faq_item{margin-bottom:15px;}
.faq_item .faq_date{display:block;}
.faq_item .faq_title{cursor:pointer; text-decoration:underline; display:block;}
.faq_opened{color:red; text-decoration:none !important;}
.faq_item .faq_reply{padding-left:20px;}
.faqoneitem .faq_date{display:block;}
.faqoneitem .faq_title{cursor:pointer; text-decoration:underline; display:block;}
.faqoneitem .faq_reply{padding-left:20px;}
.s_faq_area{margin-bottom:10px;}
';

?>