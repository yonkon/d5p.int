<?php /* Smarty version Smarty-3.1.8, created on 2013-05-11 19:56:23
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/backend/grey/catalog/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:267391822518e591f42b655-18579198%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fe442f6d7798b2bf54cd1a4d08250f873126be62' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/backend/grey/catalog/main.tpl',
      1 => 1368289260,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '267391822518e591f42b655-18579198',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_518e591f448d57_66661191',
  'variables' => 
  array (
    'messageOut' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_518e591f448d57_66661191')) {function content_518e591f448d57_66661191($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['messageOut']->value)){?>
	<strong><?php echo $_smarty_tpl->tpl_vars['messageOut']->value;?>
</strong><br /><br />
<?php }?>
<a href="/admin.php?p=categories_list">Список категорий</a><br />
<a href="/admin.php?p=category_edit&act=add">Добавить категорию</a><br />
<a href="/admin.php?p=items_list">Список работ</a><br />
<a href="/admin.php?p=item_edit&act=add">Добавить работу</a><br /><?php }} ?>