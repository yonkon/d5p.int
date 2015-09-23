<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 18:55:45
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/backend/grey/catalog/items_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14432164955193b001617a84-53775695%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5c7367e29f3b8f60c7be96563a61238be0a1ef11' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/backend/grey/catalog/items_list.tpl',
      1 => 1368627200,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14432164955193b001617a84-53775695',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'messageOut' => 0,
    'products' => 0,
    'product' => 0,
    'idp' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5193b001657ed8_87661748',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5193b001657ed8_87661748')) {function content_5193b001657ed8_87661748($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['messageOut']->value)){?>
	<strong><?php echo $_smarty_tpl->tpl_vars['messageOut']->value;?>
</strong>
<?php }?>
<form action="admin.php?p=" method="post">
	<table border="0" cellspacing="0" class="selrow" width="100%" id="ItemTab">
		<thead>
			<tr>
				<th>ID (просмотр<br />на сайте)</th>
				<th>Раздел</th>
				<th>Название (редактирование продукта)</th>

				<th class="cat-tdMin">Удалить</th>
			</tr>
		</thead>
		<tbody>
			<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_smarty_tpl->tpl_vars['idp'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['idp']->value = $_smarty_tpl->tpl_vars['product']->key;
?>
			<tr>
				<td><a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['idp']->value;?>
</a></td>
				<td><?php echo $_smarty_tpl->tpl_vars['product']->value['parentName'];?>
</td>
				<td><a href="/admin.php?p=item_edit&act=edit&idp=<?php echo $_smarty_tpl->tpl_vars['idp']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
</a></td>	

				<td class="cat-tdMin"><a href="/admin.php?p=item_edit&act=delete&idp=<?php echo $_smarty_tpl->tpl_vars['idp']->value;?>
" onclick="if(!confirm('Удалить объект?')||!confirm('Вы точно уверены? После удаления восстановить объект будет невозможно!')) return false" title="Удалить"><img src="tmpl/backend/grey/img/delit.png" width="16" height="16" alt="Удалить" border="0"></a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</form><?php }} ?>