<?php /* Smarty version Smarty-3.1.8, created on 2013-05-02 16:16:30
         compiled from "Z:/home/5plus.off/www/tmpl/lite\enter.tpl" */ ?>
<?php /*%%SmartyHeaderCode:118685182672e8abf38-40745438%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '92fb81dc7a83dee7412cda8d605fe77059a3cc99' => 
    array (
      0 => 'Z:/home/5plus.off/www/tmpl/lite\\enter.tpl',
      1 => 1338370232,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '118685182672e8abf38-40745438',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'er' => 0,
    'login_error' => 0,
    'conf' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5182672e967803_05407783',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5182672e967803_05407783')) {function content_5182672e967803_05407783($_smarty_tpl) {?><h1><?php echo $_smarty_tpl->tpl_vars['lang']->value['enter_title'];?>
</h1>
<div class="enterblock">
			<?php if (isset($_smarty_tpl->tpl_vars['er']->value)&&$_smarty_tpl->tpl_vars['er']->value=="error"){?>
				<font style="color:red;"><?php echo $_smarty_tpl->tpl_vars['login_error']->value;?>
</font>
			<?php }?>
          <form method="post" action="auth.php" id="LogForm"  class='sf'> 
          	<table border="0">
            <tr>
             		<td><label for="login"><?php echo $_smarty_tpl->tpl_vars['lang']->value['enter_login'];?>
:</label></td>
                	<td><input type="text" name="login" id="login" class="einp" value="" /></td>
             </tr><tr>
                	<td><label for="password"><?php echo $_smarty_tpl->tpl_vars['lang']->value['enter_pass'];?>
:</label></td>
                	<td><input type="password" name="password" id="password" class="einp"  value="" /></td>
             </tr><tr>
             		<td>&nbsp;</td>
					<td><input type="checkbox" name="authperiod" id="authperiod" value="yes" />	<label for="authperiod"><?php echo $_smarty_tpl->tpl_vars['lang']->value['enter_save'];?>
</label> </td>
             </tr><tr>
             		<td>&nbsp;</td>
                    <td><input type="submit" id="AUTH"  name="AUTH" class="einp" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['enter_button'];?>
"  /></td>
             </tr><tr>
	          		<td colspan="2"><a href="?p=remember" id="forgotpsswd"><?php echo $_smarty_tpl->tpl_vars['lang']->value['enter_restore'];?>
</a><?php if ($_smarty_tpl->tpl_vars['conf']->value['enable_reg']=="y"){?><br /><a href="?p=register" id="register"><?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_regbuton'];?>
</a><?php }?></td>
              </tr></table>
          </form>
</div><br /><?php }} ?>