<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 21:01:38
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/sitemap.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20034727785193cd82cf3dc6-73092644%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ff532e6780bae63f0dc63be09fcd9dbd8ef77435' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/sitemap.tpl',
      1 => 1368626835,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20034727785193cd82cf3dc6-73092644',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'smaps' => 0,
    'item' => 0,
    'item1' => 0,
    'item2' => 0,
    'item3' => 0,
    'item4' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5193cd82e32234_01087851',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5193cd82e32234_01087851')) {function content_5193cd82e32234_01087851($_smarty_tpl) {?><h1><?php echo $_smarty_tpl->tpl_vars['lang']->value['sitemap'];?>
</h1>
<div class="sitemap">
<ul>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['smaps']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
<?php if ($_smarty_tpl->tpl_vars['item']->value['type']=="html"){?><li><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
"><strong><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</strong></a><?php if ($_smarty_tpl->tpl_vars['item']->value['sub']!=''){?>
	<ul>
	<?php  $_smarty_tpl->tpl_vars['item1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item1']->_loop = false;
 $_smarty_tpl->tpl_vars['key1'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item1']->key => $_smarty_tpl->tpl_vars['item1']->value){
$_smarty_tpl->tpl_vars['item1']->_loop = true;
 $_smarty_tpl->tpl_vars['key1']->value = $_smarty_tpl->tpl_vars['item1']->key;
?>
	<?php if ($_smarty_tpl->tpl_vars['item1']->value['type']=="html"){?><li><a href="<?php echo $_smarty_tpl->tpl_vars['item1']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item1']->value['title'];?>
"><?php echo $_smarty_tpl->tpl_vars['item1']->value['title'];?>
</a><?php if ($_smarty_tpl->tpl_vars['item1']->value['sub']!=''){?>
		<ul>
		<?php  $_smarty_tpl->tpl_vars['item2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item2']->_loop = false;
 $_smarty_tpl->tpl_vars['key2'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item1']->value['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item2']->key => $_smarty_tpl->tpl_vars['item2']->value){
$_smarty_tpl->tpl_vars['item2']->_loop = true;
 $_smarty_tpl->tpl_vars['key2']->value = $_smarty_tpl->tpl_vars['item2']->key;
?>
		<?php if ($_smarty_tpl->tpl_vars['item2']->value['type']=="html"){?><li><a href="<?php echo $_smarty_tpl->tpl_vars['item2']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item2']->value['title'];?>
"><?php echo $_smarty_tpl->tpl_vars['item2']->value['title'];?>
</a><?php if ($_smarty_tpl->tpl_vars['item2']->value['sub']!=''){?>
			<ul>
			<?php  $_smarty_tpl->tpl_vars['item3'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item3']->_loop = false;
 $_smarty_tpl->tpl_vars['key3'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item2']->value['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item3']->key => $_smarty_tpl->tpl_vars['item3']->value){
$_smarty_tpl->tpl_vars['item3']->_loop = true;
 $_smarty_tpl->tpl_vars['key3']->value = $_smarty_tpl->tpl_vars['item3']->key;
?>
			<?php if ($_smarty_tpl->tpl_vars['item3']->value['type']=="html"){?><li><a href="<?php echo $_smarty_tpl->tpl_vars['item3']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item3']->value['title'];?>
"><?php echo $_smarty_tpl->tpl_vars['item3']->value['title'];?>
</a><?php if ($_smarty_tpl->tpl_vars['item3']->value['sub']!=''){?>
				<ul>
				<?php  $_smarty_tpl->tpl_vars['item4'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item4']->_loop = false;
 $_smarty_tpl->tpl_vars['key4'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item3']->value['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item4']->key => $_smarty_tpl->tpl_vars['item4']->value){
$_smarty_tpl->tpl_vars['item4']->_loop = true;
 $_smarty_tpl->tpl_vars['key4']->value = $_smarty_tpl->tpl_vars['item4']->key;
?>
				<?php if ($_smarty_tpl->tpl_vars['item4']->value['type']=="html"){?><li><a href="<?php echo $_smarty_tpl->tpl_vars['item4']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item4']->value['title'];?>
"><?php echo $_smarty_tpl->tpl_vars['item4']->value['title'];?>
</a>
			
				</li><?php }?>
				<?php } ?>
				</ul>		
			<?php }?></li><?php }?>
			<?php } ?>
			</ul>	
		<?php }?></li><?php }?>
		<?php } ?>
		</ul>	
	<?php }?></li><?php }?>
	<?php } ?>
	</ul>
<?php }?></li><?php }?>
<?php } ?>
</ul>

</div><?php }} ?>