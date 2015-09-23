<?php /* Smarty version Smarty-3.1.8, created on 2015-01-09 13:14:06
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/errorlabel.tpl" */ ?>
<?php /*%%SmartyHeaderCode:206642033954afa9ee7cb165-02835600%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '14eef7e976a6aaeb02b865f4b727723df0703115' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/errorlabel.tpl',
      1 => 1368627503,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '206642033954afa9ee7cb165-02835600',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fieldName' => 0,
    'param' => 0,
    'style' => 0,
    'lang_name' => 0,
    'lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_54afa9ee80a700_39846108',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54afa9ee80a700_39846108')) {function content_54afa9ee80a700_39846108($_smarty_tpl) {?><span id="span_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
<?php if (isset($_smarty_tpl->tpl_vars['param']->value)){?>_<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
<?php }?>" style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_red'];?>
 display: none;">
	<?php $_smarty_tpl->tpl_vars["lang_name"] = new Smarty_variable(('error_').($_smarty_tpl->tpl_vars['fieldName']->value), null, 0);?>
	<?php if (isset($_smarty_tpl->tpl_vars['param']->value)){?>
		<?php $_smarty_tpl->tpl_vars["lang_name"] = new Smarty_variable((($_smarty_tpl->tpl_vars['lang_name']->value).('_')).($_smarty_tpl->tpl_vars['param']->value), null, 0);?>
	<?php }?>
	<?php echo $_smarty_tpl->tpl_vars['lang']->value[$_smarty_tpl->tpl_vars['lang_name']->value];?>

</span><?php }} ?>