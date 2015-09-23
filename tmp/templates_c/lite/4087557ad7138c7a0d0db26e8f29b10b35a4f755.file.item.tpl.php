<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 09:59:07
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/catalog/item.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14545631175183666d054d33-99661812%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4087557ad7138c7a0d0db26e8f29b10b35a4f755' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/catalog/item.tpl',
      1 => 1368601144,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14545631175183666d054d33-99661812',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5183666d080a46_14683473',
  'variables' => 
  array (
    'pageTitle' => 0,
    'addInfoLeft' => 0,
    'idpar' => 0,
    'productAddInfo' => 0,
    'parameters' => 0,
    'addInfoRight' => 0,
    'orderform' => 0,
    'orderformPattern' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5183666d080a46_14683473')) {function content_5183666d080a46_14683473($_smarty_tpl) {?><article>
	<h1><?php echo $_smarty_tpl->tpl_vars['pageTitle']->value;?>
</h1>
	<div class="work_contents">
		<?php  $_smarty_tpl->tpl_vars['idpar'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['idpar']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['addInfoLeft']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['idpar']->key => $_smarty_tpl->tpl_vars['idpar']->value){
$_smarty_tpl->tpl_vars['idpar']->_loop = true;
?>
			<?php if ($_smarty_tpl->tpl_vars['productAddInfo']->value[$_smarty_tpl->tpl_vars['idpar']->value]!=''){?>
			<h2><?php echo $_smarty_tpl->tpl_vars['parameters']->value[$_smarty_tpl->tpl_vars['idpar']->value];?>
:</h2>
			<p class="dotted_line">&nbsp;</p>
			<div class="pre">
				<?php echo $_smarty_tpl->tpl_vars['productAddInfo']->value[$_smarty_tpl->tpl_vars['idpar']->value];?>

			</div>
			<br />
				<?php }?>
		<?php } ?>

		<div class="item_params">
			<?php  $_smarty_tpl->tpl_vars['idpar'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['idpar']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['addInfoRight']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['idpar']->key => $_smarty_tpl->tpl_vars['idpar']->value){
$_smarty_tpl->tpl_vars['idpar']->_loop = true;
?>
				<?php if ($_smarty_tpl->tpl_vars['productAddInfo']->value[$_smarty_tpl->tpl_vars['idpar']->value]!=''){?>
					<p><?php echo $_smarty_tpl->tpl_vars['parameters']->value[$_smarty_tpl->tpl_vars['idpar']->value];?>
:<span><?php echo $_smarty_tpl->tpl_vars['productAddInfo']->value[$_smarty_tpl->tpl_vars['idpar']->value];?>
</span></p>
				<?php }?>
			<?php } ?>
		</div>
		<p class="dotted_line">&nbsp;</p>
	</div>

	<?php if (isset($_smarty_tpl->tpl_vars['orderform']->value)&&$_smarty_tpl->tpl_vars['orderform']->value!=''){?><?php echo $_smarty_tpl->tpl_vars['orderformPattern']->value;?>
<?php }?>

</article>

</div><?php }} ?>