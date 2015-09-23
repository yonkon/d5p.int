<?php /* Smarty version Smarty-3.1.8, created on 2015-09-22 23:52:17
         compiled from "Z:/home/d5p.int/www/tmpl/lite\menu\menu_block.tpl" */ ?>
<?php /*%%SmartyHeaderCode:262105601bf81cd9d84-61175751%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '62020d7532a2d7e94e4b9d64418e46b7a9d3a07a' => 
    array (
      0 => 'Z:/home/d5p.int/www/tmpl/lite\\menu\\menu_block.tpl',
      1 => 1442940029,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '262105601bf81cd9d84-61175751',
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
  'unifunc' => 'content_5601bf82ab3443_27833070',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5601bf82ab3443_27833070')) {function content_5601bf82ab3443_27833070($_smarty_tpl) {?><ul>
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