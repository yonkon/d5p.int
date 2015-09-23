<?php /* Smarty version Smarty-3.1.8, created on 2015-01-08 17:02:30
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/userblock.tpl" */ ?>
<?php /*%%SmartyHeaderCode:179326552554ae8df6c5b466-37069850%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f441379738ecffb869fac4eb789c4a897378db74' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/userblock.tpl',
      1 => 1369038809,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '179326552554ae8df6c5b466-37069850',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'url' => 0,
    'imgPath' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_54ae8df6c977f4_64656047',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54ae8df6c977f4_64656047')) {function content_54ae8df6c977f4_64656047($_smarty_tpl) {?><?php if (!isset($_SESSION['U_USER_IDU'])){?>
	<div class="enter_block">
		<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['url']->value['userblock'];?>
" id="U_LoginForm">
			<input type="hidden" name="u_method" id="u_method" value="authorize">
			<table border="0" cellspacing="0" class="FormTab">
				<tr>
					<td  colspan="2">
						<label for="u_login"><strong>Логин</strong></label>
					</td>
				</tr><tr>
					<td  colspan="2">
						<input type="text" name="u_login" id="u_login" value="">
					</td>
				</tr>
				<tr>
					<td  colspan="2">
						<label for="password"><strong>Пароль</strong></label>
					</td>
				</tr><tr>
					<td  colspan="2">
						<input type="password" name="u_pass" id="u_pass" value="">
					</td>
				</tr>
				<tr>
					<td  class="padded">
						<input type="checkbox" name="u_long" id="u_long" value="yes">
						<label for="u_long" class="black_label">Запомнить</label>
						
					</td>
					<td>
						<input type="image" id="AUTH" name="AUTH" src="<?php echo $_smarty_tpl->tpl_vars['imgPath']->value;?>
userbutton.png">
					</td>	
				</tr>
				<tr>
					<td colspan="2" class="padded">
						
							<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['recover'];?>
"  class="black_label">Забыли пароль?</a>
					</td>
				</tr>
				<tr>	
				
					<td colspan="2" class="padded"> 
						
						<a href="/work/" class="avtors">Вход для авторов</a>
					</td>
				</tr>
			</table>
		</form>
		<?php echo $_smarty_tpl->getSubTemplate ('error.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		<div class="clearall"></div>
	</div>
	<p><a href="#enter" class="enter_block_call">Вход</a>&nbsp;|&nbsp;<a href="/registeravtor/">Регистрация</a> </p>
<?php }else{ ?>
<div class="personal_room">
	<h3>Личный кабинет</h3>
	<p><em><strong>Здравствуйте, <?php echo $_SESSION['U_FIO'];?>
!</strong></em></p><br />
	<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['news'];?>
">Новости компании</a><br />
	<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['orderlist'];?>
">Мои заказы</a><br />
	<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['owninfo'];?>
">Личные данные</a><br />
	<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['logout'];?>
">Выход</a>
</div>
<?php }?><?php }} ?>