<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 18:27:39
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/catalog/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20671569325193a96b7a6aa7-04216378%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '42f199cd43ff95d94098d76644b0d75a1437bb63' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/catalog/main.tpl',
      1 => 1368626856,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20671569325193a96b7a6aa7-04216378',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'subCategories' => 0,
    'lastLetter' => 0,
    'category' => 0,
    'num' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5193a96b8180a4_83995702',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5193a96b8180a4_83995702')) {function content_5193a96b8180a4_83995702($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include '/home/s/spluso/diplom5plus.ru/public_html/include/smarty/plugins/modifier.truncate.php';
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