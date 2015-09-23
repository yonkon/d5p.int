<?php /* Smarty version Smarty-3.1.8, created on 2015-01-09 13:14:06
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/checklist.tpl" */ ?>
<?php /*%%SmartyHeaderCode:97402457354afa9ee8122c9-35523176%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ec13228de00f429febda9c22160b2a823955a7c1' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/checklist.tpl',
      1 => 1368627503,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '97402457354afa9ee8122c9-35523176',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'listName' => 0,
    'list' => 0,
    'fields' => 0,
    'k' => 0,
    'fieldsValues' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_54afa9ee8386c7_35752674',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54afa9ee8386c7_35752674')) {function content_54afa9ee8386c7_35752674($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->tpl_vars['listName']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
	<div>
		<input type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value[$_smarty_tpl->tpl_vars['listName']->value];?>
[]" value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"<?php if (in_array($_smarty_tpl->tpl_vars['k']->value,$_smarty_tpl->tpl_vars['fieldsValues']->value['course'])){?> checked="checked"<?php }?> />
		&nbsp;<span><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</span>
	</div>
<?php } ?><?php }} ?>