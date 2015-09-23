<?php /* Smarty version Smarty-3.1.8, created on 2015-09-22 23:52:18
         compiled from "Z:/home/d5p.int/www/tmpl/lite\menu\menu2.tpl" */ ?>
<?php /*%%SmartyHeaderCode:92035601bf82be5725-06913130%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7e5cdedc2c8c71f952b12b99713ec9623d7937c7' => 
    array (
      0 => 'Z:/home/d5p.int/www/tmpl/lite\\menu\\menu2.tpl',
      1 => 1442940029,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '92035601bf82be5725-06913130',
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
  'unifunc' => 'content_5601bf82ca26c0_48278497',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5601bf82ca26c0_48278497')) {function content_5601bf82ca26c0_48278497($_smarty_tpl) {?><ul class="footer_navigation">
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