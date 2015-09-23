<?php /* Smarty version Smarty-3.1.8, created on 2015-09-22 23:52:19
         compiled from "Z:/home/d5p.int/www/tmpl/lite\feedback.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8095601bf837081f2-48507985%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4781508715e3952b73b98fe51a0dbd741730e29e' => 
    array (
      0 => 'Z:/home/d5p.int/www/tmpl/lite\\feedback.tpl',
      1 => 1442940004,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8095601bf837081f2-48507985',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'feedbackError' => 0,
    'feedback' => 0,
    'feedbackData' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5601bf83870113_22855979',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5601bf83870113_22855979')) {function content_5601bf83870113_22855979($_smarty_tpl) {?><h3>Форма обратной связи</h3>
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