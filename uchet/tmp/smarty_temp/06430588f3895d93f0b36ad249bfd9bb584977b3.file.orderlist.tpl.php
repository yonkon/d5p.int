<?php /* Smarty version Smarty-3.1.8, created on 2015-01-08 21:03:36
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/orderlist.tpl" */ ?>
<?php /*%%SmartyHeaderCode:157463668254aec6787ad420-41961076%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '06430588f3895d93f0b36ad249bfd9bb584977b3' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/orderlist.tpl',
      1 => 1368627506,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '157463668254aec6787ad420-41961076',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'res' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_54aec67882e8a3_01760894',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54aec67882e8a3_01760894')) {function content_54aec67882e8a3_01760894($_smarty_tpl) {?><h2 class="tarrow">Мои заказы</h2>
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
	<tr>
		<td>
			<h4>Заказ №<?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['res_i']['index']]['ido'];?>
</h4>
			<?php if ($_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['res_i']['index']]['enablecomm']=='y'){?>
				<a style="color:red;" href="<?php echo $_smarty_tpl->tpl_vars['url']->value['orderinfo'];?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"ido",'hrefVal'=>$_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['res_i']['index']]['ido']), 0);?>
">Пожалуйста, выставьте оценку и напишите отзыв о работе</a>
			<?php }?>
			<br />
			<?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['res_i']['index']]['o_worktype'];?>
, <?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['res_i']['index']]['o_course'];?>
 от <?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['res_i']['index']]['o_date'];?>
<br />
			<strong>Тема:</strong> <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['orderinfo'];?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"ido",'hrefVal'=>$_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['res_i']['index']]['ido']), 0);?>
"><?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['res_i']['index']]['o_thema'];?>
</a><br />
			<small><strong>Состояние:</strong> <?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['res_i']['index']]['o_state'];?>
</small><br />
			<?php if ($_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['res_i']['index']]['mails']!='0'){?>
				<font color="red">Новая почта по заказу: <?php echo $_smarty_tpl->tpl_vars['res']->value[$_smarty_tpl->getVariable('smarty')->value['section']['res_i']['index']]['mails'];?>
</font><br />
			<?php }?>
			<br />
		</td>
	</tr>
<?php endfor; endif; ?>
</table><?php }} ?>