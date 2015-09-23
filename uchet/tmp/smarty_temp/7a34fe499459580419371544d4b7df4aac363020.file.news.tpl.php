<?php /* Smarty version Smarty-3.1.8, created on 2015-01-20 10:32:29
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/news.tpl" */ ?>
<?php /*%%SmartyHeaderCode:36208518354be048d164796-67187896%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7a34fe499459580419371544d4b7df4aac363020' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/news.tpl',
      1 => 1368627504,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '36208518354be048d164796-67187896',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'res' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_54be048d1fa588_87578284',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54be048d1fa588_87578284')) {function content_54be048d1fa588_87578284($_smarty_tpl) {?><h2 class="tarrow">Новости компании</h2><br />
<table border="0" cellspacing="0" cellpadding="o" class="rTab">
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['res_i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['name'] = 'res_i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['res']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['res_i']['total']);
?>
	<tr><td>
	<h4><?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['res_i']['index']]['ntitle'];?>
</h4>
    <small><?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['res_i']['index']]['date'];?>
</small><br />
    <div style="padding-bottom:10px; margin-bottom:10px; border-bottom:solid 1px #cccccc;"><?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['res_i']['index']]['ntext'];?>
</div>
	</td></tr>
<?php endfor; endif; ?>
</table><?php }} ?>