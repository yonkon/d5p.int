<?php /* Smarty version Smarty-3.1.8, created on 2015-01-08 17:56:47
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/error.tpl" */ ?>
<?php /*%%SmartyHeaderCode:186169377054ae9aaf25fce6-46669377%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f9324be3ef96e9feed58795ef35cf364071ca3f8' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/error.tpl',
      1 => 1368627502,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '186169377054ae9aaf25fce6-46669377',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'errorCodes' => 0,
    'k' => 0,
    'lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_54ae9aaf2b4f49_35247781',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54ae9aaf2b4f49_35247781')) {function content_54ae9aaf2b4f49_35247781($_smarty_tpl) {?><?php if (count($_smarty_tpl->tpl_vars['errorCodes']->value)){?><div style="border:dashed 1px red;padding:3px;color:red;"><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['errorCodes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?><?php if (isset($_smarty_tpl->tpl_vars['lang']->value['errors'][$_smarty_tpl->tpl_vars['k']->value])){?><?php if ($_smarty_tpl->tpl_vars['lang']->value['errors'][$_smarty_tpl->tpl_vars['k']->value]!='default'){?><?php $_template = new Smarty_Internal_Template('eval:'.$_smarty_tpl->tpl_vars['lang']->value['errors'][$_smarty_tpl->tpl_vars['k']->value], $_smarty_tpl->smarty, $_smarty_tpl);echo $_template->fetch(); ?><br /><?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['lang']->value['errors']['default'];?>
(<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
)<?php }?><?php }else{ ?>Ошибка № <?php echo $_smarty_tpl->tpl_vars['k']->value;?>
<br /><?php }?><?php } ?></div><?php }?><?php }} ?>