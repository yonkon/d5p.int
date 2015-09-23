<?php /* Smarty version Smarty-3.1.8, created on 2013-05-02 18:14:37
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/menu/menu2.tpl" */ ?>
<?php /*%%SmartyHeaderCode:510678506518282dda51486-17176844%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c14006cfc07941c712428cd6b56f762adf18c521' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/menu/menu2.tpl',
      1 => 1367507315,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '510678506518282dda51486-17176844',
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
  'unifunc' => 'content_518282dda63237_24310671',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_518282dda63237_24310671')) {function content_518282dda63237_24310671($_smarty_tpl) {?><ul class="footer_navigation">
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