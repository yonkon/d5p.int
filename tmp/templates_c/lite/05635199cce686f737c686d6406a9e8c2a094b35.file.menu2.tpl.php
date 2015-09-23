<?php /* Smarty version Smarty-3.1.8, created on 2013-05-02 16:19:25
         compiled from "Z:/home/5plus.off/www/tmpl/lite\menu\menu2.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2693951825dd04bd9d7-53537114%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '05635199cce686f737c686d6406a9e8c2a094b35' => 
    array (
      0 => 'Z:/home/5plus.off/www/tmpl/lite\\menu\\menu2.tpl',
      1 => 1367500762,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2693951825dd04bd9d7-53537114',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_51825dd04fcbf8_80852054',
  'variables' => 
  array (
    'menu2' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51825dd04fcbf8_80852054')) {function content_51825dd04fcbf8_80852054($_smarty_tpl) {?><ul class="footer_navigation">
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