<?php /* Smarty version Smarty-3.1.8, created on 2015-01-09 08:09:06
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/recover.tpl" */ ?>
<?php /*%%SmartyHeaderCode:26312013054af62729553e4-05311683%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '773f4326b7b9396a9ad239d27268eeba31358cf0' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/recover.tpl',
      1 => 1368627510,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26312013054af62729553e4-05311683',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sended' => 0,
    'url' => 0,
    'lang' => 0,
    'includePath' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_54af62729fd932_65333035',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54af62729fd932_65333035')) {function content_54af62729fd932_65333035($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('error.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php if (isset($_smarty_tpl->tpl_vars['sended']->value)){?>
	<?php if ($_smarty_tpl->tpl_vars['sended']->value==1){?>
		Пароль успешно выслан
	<?php }else{ ?>
		Пароль не выслан
	<?php }?>
	<br /><br />
<?php }?>
<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['url']->value['recover'];?>
">
	Введите e-mail:<br />
	<input type="text" name="email" value="" /><br />
	или логин:<br />
	<input type="text" name="login" value="" /><br />
	<?php echo $_smarty_tpl->tpl_vars['lang']->value['captcha'];?>
:<br >
	<input type="text" name="captcha" maxlength="6" />
	<a href="#" onclick="document.getElementById('img_captcha').src = '<?php echo $_smarty_tpl->tpl_vars['includePath']->value;?>
securimage/securimage_show.php?' + Math.random(); return false"><?php echo $_smarty_tpl->tpl_vars['lang']->value['changecaptcha'];?>
</a><br />
	<img id="img_captcha" src="<?php echo $_smarty_tpl->tpl_vars['includePath']->value;?>
securimage/securimage_show.php" alt="CAPTCHA Image" /><br />
	<input type="hidden" name="act" value="client" /><br />
	<input type="submit" value="Выслать" />
</form>
<?php }} ?>