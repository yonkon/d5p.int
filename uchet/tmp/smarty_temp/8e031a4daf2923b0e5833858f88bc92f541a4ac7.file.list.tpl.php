<?php /* Smarty version Smarty-3.1.8, created on 2015-01-09 08:09:07
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:193296477454af62738ab9d8-74982265%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8e031a4daf2923b0e5833858f88bc92f541a4ac7' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/list.tpl',
      1 => 1368627504,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '193296477454af62738ab9d8-74982265',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'listName' => 0,
    'list' => 0,
    'k' => 0,
    'fieldsValues' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_54af62738d47f2_21305878',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54af62738d47f2_21305878')) {function content_54af62738d47f2_21305878($_smarty_tpl) {?><option value="0"><?php echo $_smarty_tpl->tpl_vars['lang']->value['choosefromlist'];?>
</option>
<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->tpl_vars['listName']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
	<option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"<?php if ($_smarty_tpl->tpl_vars['fieldsValues']->value[$_smarty_tpl->tpl_vars['listName']->value]==$_smarty_tpl->tpl_vars['k']->value){?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
<?php } ?><?php }} ?>