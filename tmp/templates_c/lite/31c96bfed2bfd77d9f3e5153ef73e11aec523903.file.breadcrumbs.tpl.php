<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 18:27:39
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/menu/breadcrumbs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14026582745193a96b6bd3f6-34436930%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '31c96bfed2bfd77d9f3e5153ef73e11aec523903' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/menu/breadcrumbs.tpl',
      1 => 1368626970,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14026582745193a96b6bd3f6-34436930',
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
  'unifunc' => 'content_5193a96b762c16_41165929',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5193a96b762c16_41165929')) {function content_5193a96b762c16_41165929($_smarty_tpl) {?><div id="breadcrumbs">

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