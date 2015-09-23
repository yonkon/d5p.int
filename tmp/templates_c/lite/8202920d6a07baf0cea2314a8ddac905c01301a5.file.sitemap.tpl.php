<?php /* Smarty version Smarty-3.1.8, created on 2013-05-13 09:37:19
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/sitemap.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15512685851908a1ff20663-94246694%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8202920d6a07baf0cea2314a8ddac905c01301a5' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/sitemap.tpl',
      1 => 1367507257,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15512685851908a1ff20663-94246694',
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
  'unifunc' => 'content_51908a201470d9_45551920',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51908a201470d9_45551920')) {function content_51908a201470d9_45551920($_smarty_tpl) {?><h1><?php echo $_smarty_tpl->tpl_vars['lang']->value['sitemap'];?>
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