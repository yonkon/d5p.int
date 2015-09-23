<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 18:13:17
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/newssign.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7774207175193a60d14a015-49220664%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd09f7ecba51fc720012e455e7516eeaabb440e25' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/newssign.tpl',
      1 => 1368626833,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7774207175193a60d14a015-49220664',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'er' => 0,
    'login_error' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5193a60d176403_41404834',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5193a60d176403_41404834')) {function content_5193a60d176403_41404834($_smarty_tpl) {?><div class="rblock">
<h3><?php echo $_smarty_tpl->tpl_vars['lang']->value['ns_hint'];?>
</h3>
<?php if (isset($_smarty_tpl->tpl_vars['er']->value)&&$_smarty_tpl->tpl_vars['er']->value=="error"){?>
	<p style="color:red;"><?php echo $_smarty_tpl->tpl_vars['login_error']->value;?>
</p>
<?php }?>
<div id="SignRes"></div>
	<form method="post" action="javascript:void(null)" id="NSForm" class="sf" enctype="multipart/form-data"> 
	<p><label for="ns_name"><?php echo $_smarty_tpl->tpl_vars['lang']->value['ns_name'];?>
</label><br /><input name="ns_name" id="ns_name" class="einp" placeholder="<?php echo $_smarty_tpl->tpl_vars['lang']->value['ns_name'];?>
" value="" type="text"></p>
	<p><label for="ns_email"><?php echo $_smarty_tpl->tpl_vars['lang']->value['ns_email'];?>
</label><br /><input name="ns_email" id="ns_email" class="einp" placeholder="<?php echo $_smarty_tpl->tpl_vars['lang']->value['ns_email'];?>
" value="" type="text"></p>
	<p><input id="NSS" name="NSS" class="einp" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['ns_sign'];?>
" onclick="SignToNewsletter('NSForm','SignRes');" type="button"></p>
	</form>
</div><?php }} ?>