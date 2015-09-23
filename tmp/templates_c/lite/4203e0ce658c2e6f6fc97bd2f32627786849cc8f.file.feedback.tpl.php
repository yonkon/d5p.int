<?php /* Smarty version Smarty-3.1.8, created on 2013-05-14 12:04:12
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/feedback.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19204298485183916b5035f9-30504023%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4203e0ce658c2e6f6fc97bd2f32627786849cc8f' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/feedback.tpl',
      1 => 1368522244,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19204298485183916b5035f9-30504023',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5183916b520e68_42375225',
  'variables' => 
  array (
    'feedbackError' => 0,
    'feedback' => 0,
    'feedbackData' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5183916b520e68_42375225')) {function content_5183916b520e68_42375225($_smarty_tpl) {?><h3>Форма обратной связи</h3>
<?php if ($_smarty_tpl->tpl_vars['feedbackError']->value!='noError'){?>
	<div class="block_body feedback">
		<form id="form_feedback" action="<?php echo $_smarty_tpl->tpl_vars['feedback']->value;?>
" method="post">
		<table>
		<tr>
			<td>
				<label for="fio">Ф.И.О</label>
			</td>
			<td>
				<input type="text" id="fio" name="fio" value="<?php echo $_smarty_tpl->tpl_vars['feedbackData']->value['fio'];?>
">
			</td>
		</tr>
		<tr>
			<td>
				<label for="phone">Телефон</label>
			</td>
			<td>
				<input type="text" id="phone" name="phone" value="<?php echo $_smarty_tpl->tpl_vars['feedbackData']->value['phone'];?>
">
			</td>
		</tr>
		<tr>
			<td>
				<label for="email">E-mail</label>
			</td>
			<td>
				<input type="text" id="email" name="email" value="<?php echo $_smarty_tpl->tpl_vars['feedbackData']->value['email'];?>
">
			</td>
		</tr>
		<tr>
			<td>
				<label for="coment">Комментарий</label>
			</td>
			<td>
				<textarea id="coment" name="coment"><?php echo $_smarty_tpl->tpl_vars['feedbackData']->value['coment'];?>
</textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="">
			</td>
		</tr>
		</table>
		<input type="hidden" name="act" value="feedback" />
		</form>
	</div>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['feedbackError']->value=='noError'){?>
	<p class="feedback_success">Спасибо за проявленный интерес, мы свяжемся с вами в кратчайшие сроки.</p>
<?php }elseif($_smarty_tpl->tpl_vars['feedbackError']->value=='notAllData'){?>
	<p class="feedback_error">Вы ввели не все данные, попробуйте снова.</p>
<?php }?><?php }} ?>