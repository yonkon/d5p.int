<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 18:27:41
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/catalog/category.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9918046995193a96d504834-31550474%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5dbab32d1241fd286c7d099bb7fcc276d283c4c5' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/catalog/category.tpl',
      1 => 1368626856,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9918046995193a96d504834-31550474',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'subCategories' => 0,
    'category' => 0,
    'product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5193a96d549098_28350761',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5193a96d549098_28350761')) {function content_5193a96d549098_28350761($_smarty_tpl) {?><article>
	<?php if (count($_smarty_tpl->tpl_vars['subCategories']->value)){?>
		<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_smarty_tpl->tpl_vars['idc'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['subCategories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
 $_smarty_tpl->tpl_vars['idc']->value = $_smarty_tpl->tpl_vars['category']->key;
?>
			<?php if (count($_smarty_tpl->tpl_vars['category']->value['productsList'])){?>
				<h2><?php echo $_smarty_tpl->tpl_vars['category']->value['name'];?>
</h2>
				<ul>
					<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_smarty_tpl->tpl_vars['idp'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['category']->value['productsList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['idp']->value = $_smarty_tpl->tpl_vars['product']->key;
?>
					<li><a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
</a></li>
					<?php } ?>
				</ul>
			<?php }?>
		<?php } ?>
	<?php }else{ ?>
		В данной категории нет работ!
	<?php }?>
</article>

</div><?php }} ?>