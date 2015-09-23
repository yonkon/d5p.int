<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 18:58:35
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/backend/grey/catalog/categories_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11123109735193b0abcbc8b9-31807686%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8ce045abf801c01aee71dc25b819d8fe54735f6' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/backend/grey/catalog/categories_list.tpl',
      1 => 1368627200,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11123109735193b0abcbc8b9-31807686',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'messageOut' => 0,
    'categoriesList' => 0,
    'category' => 0,
    'idc' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5193b0abd4fdd9_90828631',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5193b0abd4fdd9_90828631')) {function content_5193b0abd4fdd9_90828631($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['messageOut']->value)){?>
	<strong><?php echo $_smarty_tpl->tpl_vars['messageOut']->value;?>
</strong>
<?php }?>
<table border="0" cellspacing="0" class="selrow" width="100%" id="ItemTab">
	<thead>
		<tr>
			<th>ID (просмотр<br />категории)</th>
			<th>Название (редактирование категории)</th>
				
			<th class="cat-tdMin">Удалить</th>
		</tr>
	</thead>
	<tbody>
		<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_smarty_tpl->tpl_vars['idc'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['categoriesList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
 $_smarty_tpl->tpl_vars['idc']->value = $_smarty_tpl->tpl_vars['category']->key;
?>
		<tr>
			<td><a href="<?php echo $_smarty_tpl->tpl_vars['category']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['idc']->value;?>
</a></td>
			<td><a href="/admin.php?p=category_edit&act=edit&idc=<?php echo $_smarty_tpl->tpl_vars['idc']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['category']->value['name'];?>
</a></td>

			<td class="cat-tdMin"><a href="/admin.php?p=category_edit&act=delete&idc=<?php echo $_smarty_tpl->tpl_vars['idc']->value;?>
" onclick="if(!confirm('Удалить раздел?')||!confirm('Вы точно уверены? После удаления восстановить раздел будет невозможно!')) return false" title="Удалить"><img src="tmpl/backend/grey/img/delit.png" width="16" height="16" alt="Удалить" border="0"></a></td>
		</tr>
		<?php } ?>
	</tbody>
</table><?php }} ?>