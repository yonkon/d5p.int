<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 18:55:42
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/backend/grey/catalog/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18122201595193affe4505d6-66699513%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1dafabb22e8086e383d89890645f41b782383229' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/backend/grey/catalog/main.tpl',
      1 => 1368627200,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18122201595193affe4505d6-66699513',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'messageOut' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5193affe46a5d8_12517273',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5193affe46a5d8_12517273')) {function content_5193affe46a5d8_12517273($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['messageOut']->value)){?>
	<strong><?php echo $_smarty_tpl->tpl_vars['messageOut']->value;?>
</strong><br /><br />
<?php }?>
<a href="/admin.php?p=categories_list">Список категорий</a><br />
<a href="/admin.php?p=category_edit&act=add">Добавить категорию</a><br />
<a href="/admin.php?p=items_list">Список работ</a><br />
<a href="/admin.php?p=item_edit&act=add">Добавить работу</a><br /><?php }} ?>