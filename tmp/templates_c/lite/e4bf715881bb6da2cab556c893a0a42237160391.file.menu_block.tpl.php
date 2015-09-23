<?php /* Smarty version Smarty-3.1.8, created on 2013-05-02 16:12:19
         compiled from "Z:/home/5plus.off/www/tmpl/lite\menu\menu_block.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2145051825dd02f0793-14363390%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4bf715881bb6da2cab556c893a0a42237160391' => 
    array (
      0 => 'Z:/home/5plus.off/www/tmpl/lite\\menu\\menu_block.tpl',
      1 => 1367500334,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2145051825dd02f0793-14363390',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_51825dd047b854_29054010',
  'variables' => 
  array (
    'menu1' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51825dd047b854_29054010')) {function content_51825dd047b854_29054010($_smarty_tpl) {?><ul>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['menu1']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['item']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['item']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
 $_smarty_tpl->tpl_vars['item']->iteration++;
 $_smarty_tpl->tpl_vars['item']->last = $_smarty_tpl->tpl_vars['item']->iteration === $_smarty_tpl->tpl_vars['item']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['tmenu']['last'] = $_smarty_tpl->tpl_vars['item']->last;
?>
	<li>
		<a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['linktitle'];?>
"<?php if ($_smarty_tpl->tpl_vars['item']->value['sel']=="y"){?> class="current"<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['linkname'];?>
</a>
		<span></span>
    </li>
    
<?php } ?>
</ul><?php }} ?>