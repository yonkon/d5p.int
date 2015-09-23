<?php /* Smarty version Smarty-3.1.8, created on 2013-05-13 22:45:07
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/catalog/category.tpl" */ ?>
<?php /*%%SmartyHeaderCode:30857648518282fd8c8dd7-49554906%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5fe121cc531efb65491681576ee4fe9d72734f26' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/catalog/category.tpl',
      1 => 1368474305,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '30857648518282fd8c8dd7-49554906',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_518282fd8eae97_71818499',
  'variables' => 
  array (
    'subCategories' => 0,
    'category' => 0,
    'product' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_518282fd8eae97_71818499')) {function content_518282fd8eae97_71818499($_smarty_tpl) {?><article>
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