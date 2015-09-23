<?php /* Smarty version Smarty-3.1.8, created on 2015-01-08 21:34:35
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:201246153354aecdbb12ee93-26400867%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a0bfca23c9f0af068e42c1063a27b2bc6caddb86' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/main.tpl',
      1 => 1368627505,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '201246153354aecdbb12ee93-26400867',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'authorized' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_54aecdbb16b193_33250214',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54aecdbb16b193_33250214')) {function content_54aecdbb16b193_33250214($_smarty_tpl) {?><?php if ((!$_smarty_tpl->tpl_vars['authorized']->value)){?>
	<p><strong>Для входа в личный кабинет необходимо пройти авторизацию</strong></p>
	<div class="login">
	<p class="warning"><?php echo $_smarty_tpl->getSubTemplate ('error.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</p>
	<form id="dform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['url']->value['userblock'];?>
">
		<input type="hidden" name="u_method" id="du_method" value="authorize" />
		<input class="input required" name="u_login" id="du_login" value="" type="text" size="26" minlength="1" placeholder="Логин..."><br />
		<input class="input required" name="u_pass" id="du_pass" type="password" size="26" minlength="1" placeholder="Пароль..."><br />
		<input class="checkbox" type="checkbox" name="u_long" id="du_long" value="yes">
		<label for="remember-me" class="checkbox-text">Запомнить меня</label><br />
		<input class="submit" id="dAUTH" name="AUTH" type="submit" value="Войти"><br /><br />
		<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['recover'];?>
">Я забыл пароль</a>
		</fieldset>
	</form>
	</div>
<?php }else{ ?>
	<p><strong><?php echo $_SESSION['U_FIO'];?>
</strong></p>
    <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['news'];?>
">Новости компании</a><br>
	<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['orderlist'];?>
">Мои заказы</a><br>
	<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['owninfo'];?>
">Личные данные</a><br>   
	<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['logout'];?>
">Выход</a><br>
<?php }?><?php }} ?>