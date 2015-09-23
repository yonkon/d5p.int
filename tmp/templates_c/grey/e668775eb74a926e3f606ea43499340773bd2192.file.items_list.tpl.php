<?php /* Smarty version Smarty-3.1.8, created on 2013-05-11 19:47:06
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/backend/grey/catalog/items_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2016386802518e65186ebd49-23270922%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e668775eb74a926e3f606ea43499340773bd2192' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/backend/grey/catalog/items_list.tpl',
      1 => 1368290825,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2016386802518e65186ebd49-23270922',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_518e6518730062_69256571',
  'variables' => 
  array (
    'messageOut' => 0,
    'products' => 0,
    'product' => 0,
    'idp' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_518e6518730062_69256571')) {function content_518e6518730062_69256571($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['messageOut']->value)){?>
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