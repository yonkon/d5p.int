<?php /* Smarty version Smarty-3.1.8, created on 2013-05-03 14:24:28
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/menu/breadcrumbs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:106316566751839e6c38a1d4-65845461%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0d1b2a42b1f47834485944d1c96a6fdefc0fa868' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/menu/breadcrumbs.tpl',
      1 => 1367507315,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '106316566751839e6c38a1d4-65845461',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'breadcrumbs_ar' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_51839e6c3c4481_93413382',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51839e6c3c4481_93413382')) {function content_51839e6c3c4481_93413382($_smarty_tpl) {?><div id="breadcrumbs">

<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['breadcrumbs_ar']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['item']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['item']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
 $_smarty_tpl->tpl_vars['item']->iteration++;
 $_smarty_tpl->tpl_vars['item']->last = $_smarty_tpl->tpl_vars['item']->iteration === $_smarty_tpl->tpl_vars['item']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['brc']['last'] = $_smarty_tpl->tpl_vars['item']->last;
?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['linktitle'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['linkname'];?>
</a>
        <?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['brc']['last']){?>&nbsp;&raquo;&raquo;&nbsp;<?php }?>
<?php } ?>

</div><?php }} ?>