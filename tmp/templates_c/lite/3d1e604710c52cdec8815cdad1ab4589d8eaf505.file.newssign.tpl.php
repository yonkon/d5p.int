<?php /* Smarty version Smarty-3.1.8, created on 2013-05-02 15:36:32
         compiled from "Z:/home/5plus.off/www/tmpl/lite\newssign.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3080851825dd052fe87-80572312%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3d1e604710c52cdec8815cdad1ab4589d8eaf505' => 
    array (
      0 => 'Z:/home/5plus.off/www/tmpl/lite\\newssign.tpl',
      1 => 1338370208,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3080851825dd052fe87-80572312',
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
  'unifunc' => 'content_51825dd0586874_72482913',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51825dd0586874_72482913')) {function content_51825dd0586874_72482913($_smarty_tpl) {?><div class="rblock">
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