<?php /* Smarty version Smarty-3.1.8, created on 2013-05-24 13:19:28
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/backend/grey/free.tpl" */ ?>
<?php /*%%SmartyHeaderCode:906727220519f3eb0c60e66-59312171%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00a147e610c6d6706c94600fb911b655af9bd434' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/backend/grey/free.tpl',
      1 => 1368626846,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '906727220519f3eb0c60e66-59312171',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'wwwadres' => 0,
    'conf' => 0,
    'TITLE' => 0,
    'HEADER' => 0,
    'PAGE' => 0,
    'debug' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_519f3eb0cdc885_45511621',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_519f3eb0cdc885_45511621')) {function content_519f3eb0cdc885_45511621($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<base href="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/admin.php" /><!--[if IE]></base><![endif]-->
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Cash-Control" content="no-cash, must-revalidate" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_smarty_tpl->tpl_vars['conf']->value['encoding'];?>
" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Author" content="Volodymyr Demchuk, http://shiftcms.net" />
	<meta name="Copyleft" content="ShiftCMS" />
	<link rel="icon" href="favicon.ico" type="ico" />

	<link rel="StyleSheet" href="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['conf']->value['admin_tpl_dir'];?>
css/bw.css" type="text/css" />
	<link type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/js/jquery/themes/ui-lightness/jquery.ui.all.css" rel="stylesheet" />
	<script src="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/js/admin_func.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/js/jquery/jquery-1.4.3.min.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/js/jquery/jquery-ui-1.8.5.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/js/jquery/ui/minified/jquery.ui.core.min.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/js/jquery/ui/minified/jquery.ui.widget.min.js"></script>
    
	<title><?php echo $_smarty_tpl->tpl_vars['TITLE']->value;?>
</title>
	<?php echo $_smarty_tpl->tpl_vars['HEADER']->value;?>


</head>

<body>
<div id="mainContentAdmin_free">
	<div id="result">
		<?php echo $_smarty_tpl->tpl_vars['PAGE']->value;?>

	</div>
</div>

<br />
<?php if ($_smarty_tpl->tpl_vars['debug']->value==true){?>
<hr />
<strong>DEBUG INFO:</strong>
<div id="debug" style='border:solid 1px red; padding:3px; background:#F8F1DE;'></div>
<?php }?>
</body>
</html><?php }} ?>