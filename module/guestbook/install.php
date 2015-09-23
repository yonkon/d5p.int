<?

$inst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."guestbook`",
'1'=>"CREATE TABLE `".$_conf['prefix']."guestbook` (
`g_id` BIGINT( 16 ) UNSIGNED NOT NULL auto_increment,
`g_date` BIGINT( 16 ) UNSIGNED NOT NULL ,
`g_who` VARCHAR( 250 ) NOT NULL ,
`g_text` TEXT NOT NULL ,
`g_state` ENUM( 'new', 'read' ) NOT NULL ,
`g_show` ENUM( 'n', 'y' ) NOT NULL ,
`g_email` VARCHAR( 250 ) NOT NULL ,
PRIMARY KEY ( `g_id` ) ,
INDEX ( `g_date` , `g_state` , `g_show` ) 
) ENGINE = MYISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",
'2'=>"INSERT INTO ".$_conf['prefix']."site_config(`name`, `val`, `com`, `grp`, `ctype`, `cvalue`)VALUES
('gmcheck','n','Разрешить вывод сообщений без предварительной проверки','guestbook','s','y:Разрешить вывод сообщений без предварительной проверки,n:необходима проверка'),
('gb_sendmail','n','Отправлять эмейл о новом сообщении','guestbook','s','y:Да,n:Нет'),
('gb_mail','','Электронный адрес на который будет отправлятся сообщение о новой записи в гостевой книге','guestbook','v',''),
('gb_inblock', '3', 'К-во запией выводимых в анонсах', 'guestbook', 'i', '')",
'3'=>"INSERT INTO ".$_conf['prefix']."page(pname,pparent,ptitle,plevel,pfile,pgroups,ptemplate,phelp,page_blocks,ptype,linkpos,siteshow,menushow1,added,lastedit,whoedit,p_title_ru,p_keywords_ru,p_description_ru,linkname_ru,linktitle_ru,p_title_ua,p_keywords_ua,p_description_ua,linkname_ua,linktitle_ua,p_title_en,p_keywords_en,p_description_en,linkname_en,linktitle_en)VALUES
('admin_guestbook','admin_list_module','file','1','module/guestbook/admin_guestbook.php','manager,super',	'admin.tpl','','','back','20','y','n',0,0,1,'Управление гостевой книгой сайта','Управление гостевой книгой сайта','Управление гостевой книгой сайта','','','Управління гостьовою книгою сайту','Управління гостьовою книгою сайту','Управління гостьовою книгою сайту','','','Manage guest book','Manage guest book','Manage guest book','',''),
('guestbook','','file','0','module/guestbook/guestbook.php','client,guest,manager,super','index.tpl','','','front','50','y','y',0,0,1,'Гостевая книга сайта', 'Гостевая книга сайта', 'Гостевая книга сайта', 'Гостевая книга сайта', 'Гостевая книга сайта', 'Гостьова книга сайту', 'Гостьова книга сайту', 'Гостьова книга сайту', 'Гостьова книга сайту', 'Гостьова книга сайту', 'Guestbook Site','Guestbook Site','Guestbook Site','Guestbook Site','Guestbook Site')",
'4'=>"INSERT INTO ".$_conf['prefix']."admin_menu(mid,punkt_parent,punkt_order,punkt_link,punkt_groups,punkt_ico,punkt_name_ru,punkt_name_ua,punkt_name_en)VALUES('','20','60','admin.php?p=admin_guestbook','manager,super','guestbook.png','Гостевая книга','Гостьва книга','Guestbook')",
'5'=>"INSERT INTO `".$_conf['prefix']."translate` (`pkey`, `sections`, `ru`, `ua`, `en`) VALUES
('guestbook', 'guestbook', 'Гостевая книга', 'Гостьова книга','Guestbook'),
('g_send', 'guestbook', 'Отправить', 'Відправити','Send'),
('g_name', 'guestbook', 'Имя', 'Ім\'я','Name'),
('g_email', 'guestbook', 'E-mail', 'E-mail','E-mail'),
('g_text', 'guestbook', 'Текст сообщения', 'Текст повідомлення','Text messages'),
('g_checkcode', 'guestbook', 'Код с картинки', 'Код з картинки','Code from the picture'),
('g_er1', 'guestbook', 'Вы указали неправильный код с картинки!', 'Ви вказали не правильний код з картинки!','You have entered a wrong code from the picture!'),
('g_er2', 'guestbook', 'Пожалуйста, введите Ваше имя!', 'Будь-ласка, вкажіть Ваше ім\'я!','Please enter your name!'),
('g_er3', 'guestbook', 'Пожалуйста, введите текст сообщения!', 'Будь-ласка, напишіть текст повідомлення!','Please enter the text messages!'),
('g_success1', 'guestbook', 'Ваше сообщение успешно записано!', 'Ваше повідомлення успішно збережено!','Your message has been successfully recorded!'),
('g_success2', 'guestbook', 'Ваше сообщение успешно записано и будет доступно после проверки модератором!', 'Ваше повідомлення успішно збережено і буде доступне після перевірки модератором!','Your message has been recorded and will be available after being moderated!'),
('g_formtitle', 'guestbook', 'Оставить отзыв', 'Залашити відгук','Leave a comment'),
('g_all', 'guestbook', 'Все записи', 'Всі записи','All records')",
'6'=>"INSERT INTO ".$_conf['prefix']."blocks(block_name,block_file,block_description,btype) VALUES ('gb_block','module/guestbook/gb_block.php','Блок для вывода последних записей из гостевой книги','file')"
);

$uninst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."guestbook`",
'3'=>"DELETE FROM ".$_conf['prefix']."page WHERE pname='admin_guestbook' OR pname='guestbook'",
'4'=>"DELETE FROM ".$_conf['prefix']."admin_menu WHERE punkt_link='admin.php?p=admin_guestbook'",
'6'=>"DELETE FROM ".$_conf['prefix']."site_config WHERE grp='guestbook'",
'7'=>"DELETE FROM ".$_conf['prefix']."translate WHERE sections='guestbook'"
);

$inst_info = '<strong>Гостевая книга для сайта.</strong><br />
В разделе АДМИН - Конфигурация сайта - guestbook настройте основные параметры гостевой книги: модерация и отправка сообщения на мейл.';

$uninst_info = '<strong>Модуль гостевой книги удален из сайта!</strong>';

$inst_relation = '';

$uninst_relation = '';

$inst_css = '/* guestbook */
.gb_block{clear:both;}
.gb_block .gbb_item{margin-bottom:15px; clear:both;}
.gb_block .gbb_item p{text-indent:0px !important;}
.gb_block .gbb_item .gbb_name{font-weight:bold; font-size:13px; line-height:16px; display:block; margin-bottom:3px;}
.gb_block .gbb_item .gbb_date{font-weight::bold; font-size:11px; line-height:14px; display:block;margin-bottom:3px;}
.gb_block .gbb_item .gbb_txt{font:12px/15px Arial, Helvetica, sans-serif; font-style:italic;}

.gb_page{clear:both;}
.gb_page .gb_item{margin-bottom:15px; clear:both;}
.gb_page .gb_item p{text-indent:0px !important;}
.gb_page .gb_item .gb_name{font-weight:bold; font-size:13px; line-height:16px; display:block; margin-bottom:3px;}
.gb_page .gb_item .gb_date{font-weight::bold; font-size:11px; line-height:14px; display:block;margin-bottom:3px;}
.gb_page .gb_item .gb_txt{font:12px/15px Arial, Helvetica, sans-serif; font-style:italic;}';

?>