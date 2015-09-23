<?php /* Smarty version Smarty-3.1.8, created on 2015-01-08 17:05:52
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/hrefparam.tpl" */ ?>
<?php /*%%SmartyHeaderCode:176536767754ae8df7689bb1-62455516%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '25e0e44d684476663337904039c8e1ab2f9d3311' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/hrefparam.tpl',
      1 => 1420725951,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '176536767754ae8df7689bb1-62455516',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_54ae8df76a7c49_26343178',
  'variables' => 
  array (
    'url' => 0,
    'hrefParam' => 0,
    'hrefVal' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54ae8df76a7c49_26343178')) {function content_54ae8df76a7c49_26343178($_smarty_tpl) {?><?php if ((substr($_smarty_tpl->tpl_vars['url']->value['orderinfo'],-1,1)=="/")){?><?php echo $_smarty_tpl->tpl_vars['hrefParam']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['hrefVal']->value;?>
/<?php }else{ ?>&<?php echo $_smarty_tpl->tpl_vars['hrefParam']->value;?>
=<?php echo $_smarty_tpl->tpl_vars['hrefVal']->value;?>
<?php }?><?php }} ?>