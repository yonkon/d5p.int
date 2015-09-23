<?php /* Smarty version Smarty-3.1.8, created on 2013-05-02 18:14:37
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/menu/menu_block.tpl" */ ?>
<?php /*%%SmartyHeaderCode:340243510518282dda0c930-56693020%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '82a64ea223ed7f0b7379e67b0feb6c88927cc94b' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/menu/menu_block.tpl',
      1 => 1367507315,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '340243510518282dda0c930-56693020',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'menu1' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_518282dda4d3a4_07748917',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_518282dda4d3a4_07748917')) {function content_518282dda4d3a4_07748917($_smarty_tpl) {?><ul>
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