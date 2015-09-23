<?php /* Smarty version Smarty-3.1.8, created on 2015-09-23 00:52:24
         compiled from "Z:\home\d5p.int\www\uchet/tmpl/smarty\error.tpl" */ ?>
<?php /*%%SmartyHeaderCode:31515601bf880f2c44-73157358%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4b1e9e478c19a8a26a47f79200fd15ec6f725497' => 
    array (
      0 => 'Z:\\home\\d5p.int\\www\\uchet/tmpl/smarty\\error.tpl',
      1 => 1442940364,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31515601bf880f2c44-73157358',
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
  'unifunc' => 'content_5601bf8839ea15_43330841',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5601bf8839ea15_43330841')) {function content_5601bf8839ea15_43330841($_smarty_tpl) {?><?php if (count($_smarty_tpl->tpl_vars['errorCodes']->value)){?><div style="border:dashed 1px red;padding:3px;color:red;"><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['errorCodes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?><?php if (isset($_smarty_tpl->tpl_vars['lang']->value['errors'][$_smarty_tpl->tpl_vars['k']->value])){?><?php if ($_smarty_tpl->tpl_vars['lang']->value['errors'][$_smarty_tpl->tpl_vars['k']->value]!='default'){?><?php $_template = new Smarty_Internal_Template('eval:'.$_smarty_tpl->tpl_vars['lang']->value['errors'][$_smarty_tpl->tpl_vars['k']->value], $_smarty_tpl->smarty, $_smarty_tpl);echo $_template->fetch(); ?><br /><?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['lang']->value['errors']['default'];?>
(<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
)<?php }?><?php }else{ ?>Ошибка № <?php echo $_smarty_tpl->tpl_vars['k']->value;?>
<br /><?php }?><?php } ?></div><?php }?><?php }} ?>