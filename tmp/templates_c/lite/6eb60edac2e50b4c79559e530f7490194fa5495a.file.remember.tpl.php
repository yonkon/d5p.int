<?php /* Smarty version Smarty-3.1.8, created on 2013-05-19 16:42:29
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/remember.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7820371295198d6c529f5e2-06086011%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6eb60edac2e50b4c79559e530f7490194fa5495a' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/remember.tpl',
      1 => 1368626838,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7820371295198d6c529f5e2-06086011',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'message' => 0,
    'form' => 0,
    'ttitle' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5198d6c52d6646_18823520',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5198d6c52d6646_18823520')) {function content_5198d6c52d6646_18823520($_smarty_tpl) {?><div class="whitepage">

<h1><?php echo $_smarty_tpl->tpl_vars['lang']->value['rmb_title'];?>
</h1>
<?php if (isset($_smarty_tpl->tpl_vars['message']->value)){?><p><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</p><?php }?>

<?php if ($_smarty_tpl->tpl_vars['form']->value){?>
<form action="" method="post">
   <input type="hidden" name="act" value="remember"/>
   <dl>
   <dt><?php echo $_smarty_tpl->tpl_vars['ttitle']->value['rem_email'];?>
:</dt>
   <dd><input type="text" name="email" size="32" /></dd>
   
   <dt></dt>
   <dd><img src="check_code.php" border="0" vspace="1" hspace="1" id="ChkCodeImg" style="vertical-align:middle;"/>
        <small><a href="javascript:void(null)" onclick="document.getElementById('ChkCodeImg').src = 'check_code.php?'+Math.random();"><?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_updcode'];?>
</a></small></dd>
   
   <dt><?php echo $_smarty_tpl->tpl_vars['ttitle']->value['kod'];?>
:</dt>
   <dd><input type="text" name="check_code" /></dd>
   
   <dt></dt>
   <dd><input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['ttitle']->value['remember_submit'];?>
"/></dd>  
   </dl>
</form>
<?php }?>

</div><?php }} ?>