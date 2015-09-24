<?php

$inst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."akcii`",
'1'=>"CREATE TABLE IF NOT EXISTS `".$_conf['prefix']."akcii` (
  `id` int(6) unsigned NOT NULL auto_increment,
  `date` bigint(16) unsigned NOT NULL default '0',
  `aphoto` varchar(255) NOT NULL default '',
  `title_ru` varchar(250) NOT NULL default '',
  `anons_ru` tinytext NOT NULL,
  `text_ru` text NOT NULL,
  `title_ua` varchar(250) NOT NULL default '',
  `anons_ua` tinytext NOT NULL,
  `text_ua` text NOT NULL,
  `title_en` varchar(250) NOT NULL default '',
  `anons_en` tinytext NOT NULL,
  `text_en` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",
'2'=>"INSERT INTO ".$_conf['prefix']."page(pname,pparent,ptitle,plevel,pfile,pgroups,ptemplate,phelp,page_blocks,ptype,linkpos,siteshow,menushow1,added,lastedit,whoedit,p_title_ru,p_keywords_ru,p_description_ru,linkname_ru,linktitle_ru,p_title_ua,p_keywords_ua,p_description_ua,linkname_ua,linktitle_ua,p_title_en,p_keywords_en,p_description_en,linkname_en,linktitle_en)VALUES('admin_akcii','admin_list_module','file','1','module/akcii/admin_akcii.php','manager,super',	'admin.tpl','','','back','20','y','n',0,0,1,'Управление акциями на сайте','Управление акциями на сайте','Управление акциями на сайте','','','Керування акціями на сайті','Керування акціями на сайті','Керування акціями на сайті','','','Stock manage','Stock manage','Stock manage','','')",
'3'=>"INSERT INTO ".$_conf['prefix']."page(pname,pparent,ptitle,plevel,pfile,pgroups,ptemplate,phelp,page_blocks,ptype,linkpos,siteshow,menushow1,added,lastedit,whoedit,p_title_ru,p_keywords_ru,p_description_ru,linkname_ru,linktitle_ru,p_title_ua,p_keywords_ua,p_description_ua,linkname_ua,linktitle_ua,p_title_en,p_keywords_en,p_description_en,linkname_en,linktitle_en)VALUES('akcii','','file','0','module/akcii/akcii.php','client,guest,manager,super','index.tpl','','','front','50','y','y',0,0,1,'Акции','Акции','Акции','Акции','Акции','Акції','Акції','Акції','Акції','Акції','Stock','Stock','Stock','Stock','Stock')",
'4'=>"INSERT INTO ".$_conf['prefix']."admin_menu(mid,punkt_parent,punkt_order,punkt_link,punkt_groups,punkt_ico,punkt_name_ru,punkt_name_ua,punkt_name_en) VALUES('','20','50','admin.php?p=admin_akcii','manager,super','news.png','Акции','Акції','Stock')",
'5'=>"INSERT INTO ".$_conf['prefix']."blocks(block_name,block_file,block_description,btype) VALUES ('block_akcii','module/akcii/block_akcii.php','Блок для вывода анонса акций на страницах сайта','file')",
'6'=>"INSERT INTO `".$_conf['prefix']."site_config` (`name`, `val`, `com`, `grp`, `ctype`, `cvalue`) VALUES
('athumb_w', '100', 'Ширина превью фото в анонсе акций', 'akcii', 'i', ''),
('athumb_h', '100', 'Высота превью фото в анонсе акций', 'akcii', 'i', ''),
('a_count', '2', 'К-во акций выводимых в анонсах', 'akcii', 'i', ''),
('a_count1', '20', 'К-во акций выводимых на странице новостей', 'akcii', 'i', ''),
('neditor', 'ck', 'Редактор акций', 'akcii', 's', 'ck:CKEditor,fck:FCKeditor,earea:EditArea,no:не использовать редактор')"
);

$uninst_queries = array(
'0'=>"DROP TABLE IF EXISTS `".$_conf['prefix']."akcii`",
'1'=>"DELETE FROM ".$_conf['prefix']."page WHERE pname='admin_akcii' OR pname='akcii'",
'2'=>"DELETE FROM ".$_conf['prefix']."admin_menu WHERE punkt_link='admin.php?p=admin_akcii'",
'3'=>"DELETE FROM ".$_conf['prefix']."blocks WHERE block_name='block_akcii'",
'4'=>"DELETE FROM ".$_conf['prefix']."site_config WHERE grp='akcii'"
);

$inst_info = '<strong>Модуль управления акциями на сайте установлен!</strong><br />
Перейдите в раздел меню: "Модули - Блоки на странице" и для блока block_akcii настройте страницы на которых будут выводится анонсы акций.<br />
Перейдите в раздел меню: "Модули - Страницы" и откройте для редактирования страницу: akcii. Настройте блоки, что будут выводится на этой странице.<br />
В базовом шаблоне(ах) пропишите код для вывода блока с анонсом акций: <code>{if isset($block_akcii) && $block_akcii!=""}{$block_akcii}{/if}</code><br />
';

$uninst_info = '<strong>Модуль акций удален из сайта!</strong><br />';

$inst_relation = '';

$uninst_relation = '';

$inst_css = '/* akcii */
.bakcii .bitem{margin-bottom:10px;}
.bakcii .bitem .btitle{font:bold 14px/18px Arial, Helvetica, sans-serif; display:block;}
.bakcii .bitem .bdate{font:bold 11px/14px Arial, Helvetica, sans-serif; display:block;margin-bottom:3px;}
.bakcii .bitem .bimg{margin-right:5px;}
.bakcii .bitem .btxt{font:12px/15px Arial, Helvetica, sans-serif;}

.akcii .item{margin-bottom:10px;}
.akcii .item .title{font:bold 14px/18px Arial, Helvetica, sans-serif; display:block;}
.akcii .item .date{font:bold 11px/14px Arial, Helvetica, sans-serif; display:block;margin-bottom:3px;}
.akcii .item .img{margin-right:5px;float:left;}
.akcii .item .txt{font:12px/15px Arial, Helvetica, sans-serif;}';

?>