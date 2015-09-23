<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 18:13:17
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/menu/menu2.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3372446565193a60d1242d4-42656879%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5230e42ee11bb694ff54fb932d1071c0a1d0dab9' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/menu/menu2.tpl',
      1 => 1368626968,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3372446565193a60d1242d4-42656879',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'menu2' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5193a60d13c272_76931865',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5193a60d13c272_76931865')) {function content_5193a60d13c272_76931865($_smarty_tpl) {?><ul class="footer_navigation">
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['menu2']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
	<li><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['linktitle'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['linkname'];?>
</a></li>
<?php } ?>
</ul>
<?php }} ?>