<?php /* Smarty version Smarty-3.1.8, created on 2013-05-13 22:32:09
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/catalog/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:228303270519136d30a8823-77546175%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '73c5850c657525b9b5fa38185ada1f1fc81c8d83' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/catalog/main.tpl',
      1 => 1368473462,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '228303270519136d30a8823-77546175',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_519136d30d0a11_45918396',
  'variables' => 
  array (
    'subCategories' => 0,
    'lastLetter' => 0,
    'category' => 0,
    'num' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_519136d30d0a11_45918396')) {function content_519136d30d0a11_45918396($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include '/var/www/vhosts/data/www/test1.2foo.ru/include/smarty/plugins/modifier.truncate.php';
?><article>
	<h1>Банк готовых работ:</h1>
	<?php if (count($_smarty_tpl->tpl_vars['subCategories']->value)){?>
		<?php $_smarty_tpl->tpl_vars['num'] = new Smarty_variable(0, null, 0);?>
		<?php $_smarty_tpl->tpl_vars['lastLetter'] = new Smarty_variable('', null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_smarty_tpl->tpl_vars['idc'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['subCategories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['category']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
 $_smarty_tpl->tpl_vars['idc']->value = $_smarty_tpl->tpl_vars['category']->key;
 $_smarty_tpl->tpl_vars['category']->index++;
 $_smarty_tpl->tpl_vars['category']->first = $_smarty_tpl->tpl_vars['category']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['subCategories']['first'] = $_smarty_tpl->tpl_vars['category']->first;
?>
			<?php if ($_smarty_tpl->tpl_vars['lastLetter']->value!=smarty_modifier_truncate($_smarty_tpl->tpl_vars['category']->value['name'],1,'')){?>
				<?php $_smarty_tpl->tpl_vars['num'] = new Smarty_variable($_smarty_tpl->tpl_vars['num']->value+1, null, 0);?>
				<?php $_smarty_tpl->tpl_vars['lastLetter'] = new Smarty_variable(smarty_modifier_truncate($_smarty_tpl->tpl_vars['category']->value['name'],1,''), null, 0);?>
				<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['subCategories']['first']){?>
		</ul>
	</div>
				<?php }?>
	<div class="bank_item <?php if ($_smarty_tpl->tpl_vars['num']->value%4==0){?>first<?php }?>">
		<p><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['category']->value['name'],1,'');?>
</p>
		<ul>
			<?php }?>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['category']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['category']->value['name'];?>
</a></li>					
		<?php } ?>
		</ul>
	</div>
	<?php }?>

</article>

</div><?php }} ?>