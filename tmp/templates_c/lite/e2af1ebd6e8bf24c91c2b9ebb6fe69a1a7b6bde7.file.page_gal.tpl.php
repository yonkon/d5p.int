<?php /* Smarty version Smarty-3.1.8, created on 2013-05-16 09:38:31
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/page_gal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:163000733651947ee709d021-36992599%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e2af1ebd6e8bf24c91c2b9ebb6fe69a1a7b6bde7' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/page_gal.tpl',
      1 => 1368626834,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '163000733651947ee709d021-36992599',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pgal' => 0,
    'item' => 0,
    'conf' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_51947ee70f2da4_77334463',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51947ee70f2da4_77334463')) {function content_51947ee70f2da4_77334463($_smarty_tpl) {?>    <div class="highslide-gallery">
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['pgal']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['photo'];?>
" class="highslide" onclick="return hs.expand(this)"><img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['thumb'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['conf']->value['pgal_thumb_h'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['item']->value['sign'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['sign'];?>
" /></a>
		<div class="highslide-caption"><?php echo $_smarty_tpl->tpl_vars['item']->value['sign'];?>
</div>    
    <?php } ?>
    </div><?php }} ?>