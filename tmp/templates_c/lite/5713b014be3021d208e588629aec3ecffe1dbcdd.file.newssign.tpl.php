<?php /* Smarty version Smarty-3.1.8, created on 2013-05-02 18:14:37
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/newssign.tpl" */ ?>
<?php /*%%SmartyHeaderCode:595313388518282dda66840-92880226%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5713b014be3021d208e588629aec3ecffe1dbcdd' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/newssign.tpl',
      1 => 1367507256,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '595313388518282dda66840-92880226',
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
  'unifunc' => 'content_518282dda87382_77536994',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_518282dda87382_77536994')) {function content_518282dda87382_77536994($_smarty_tpl) {?><div class="rblock">
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