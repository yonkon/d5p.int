<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 18:13:17
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/menu/menu_block.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18468624475193a60d0e9e68-66568288%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f10cfd0163e5af744420615b90100a5cec7e2aa2' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/menu/menu_block.tpl',
      1 => 1368626967,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18468624475193a60d0e9e68-66568288',
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
  'unifunc' => 'content_5193a60d11f202_90180287',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5193a60d11f202_90180287')) {function content_5193a60d11f202_90180287($_smarty_tpl) {?><ul>
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