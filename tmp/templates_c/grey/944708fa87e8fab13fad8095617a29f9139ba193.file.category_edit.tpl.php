<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 18:57:57
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/backend/grey/catalog/category_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2380920595193b08515baa2-51794093%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '944708fa87e8fab13fad8095617a29f9139ba193' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/backend/grey/catalog/category_edit.tpl',
      1 => 1368627200,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2380920595193b08515baa2-51794093',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'messageOut' => 0,
    'currentCategory' => 0,
    'categoriesList' => 0,
    'idc' => 0,
    'catName' => 0,
    'act' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5193b0851ac500_95900086',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5193b0851ac500_95900086')) {function content_5193b0851ac500_95900086($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['messageOut']->value)){?>
	<strong><?php echo $_smarty_tpl->tpl_vars['messageOut']->value;?>
</strong>
<?php }?>
</script>
<form action="admin.php?p=category_edit" method="post" id="info_form">

	<table border="0" cellspacing="0" class="selrow" width="100%" id="ItemTab">
		<tbody>
			<tr class="editSection-trHeight">
				<td class="editSection-tdName">Название:</td>
				<td><input type='text' name='name' size='50' maxlenght='150' value="<?php echo $_smarty_tpl->tpl_vars['currentCategory']->value['name'];?>
" /></td>
			</tr>
			<tr class="editSection-trHeight">
				<td class="editSection-tdName">Родительский раздел:</td>
				<td>
					<select name="parent_idc" style="width:200px;">
					<?php  $_smarty_tpl->tpl_vars['catName'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['catName']->_loop = false;
 $_smarty_tpl->tpl_vars['idc'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['categoriesList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['catName']->key => $_smarty_tpl->tpl_vars['catName']->value){
$_smarty_tpl->tpl_vars['catName']->_loop = true;
 $_smarty_tpl->tpl_vars['idc']->value = $_smarty_tpl->tpl_vars['catName']->key;
?>
						<option <?php if ($_smarty_tpl->tpl_vars['currentCategory']->value['parentCat']==$_smarty_tpl->tpl_vars['idc']->value){?>selected="selected"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['idc']->value;?>
"> <?php echo $_smarty_tpl->tpl_vars['catName']->value;?>
 </option>
					<?php } ?>
					</select>
				</td>
			</tr>
			<tr class="editSection-trHeight">
				<td class="editSection-tdName">Порядок сортировки:</td>
				<td><input type="text" name="sort_order" value="<?php echo $_smarty_tpl->tpl_vars['currentCategory']->value['sort'];?>
" size="3"></td>
			</tr>
			<tr class="editSection-trHeight">
				<td class="editSection-tdName">Включить показ на сайте:</td>
				<td><input type="checkbox" name="show" id="show" value="y" <?php if ($_smarty_tpl->tpl_vars['currentCategory']->value['show']==1){?>checked="checked" <?php }?>/></td>
			</tr>
		</tbody>
	</table>

	<input type="hidden" name="act" value="<?php echo $_smarty_tpl->tpl_vars['act']->value;?>
" />
	<input type="hidden" name="idc" value="<?php echo $_smarty_tpl->tpl_vars['currentCategory']->value['idc'];?>
" />
	<p><input type="submit" value="Сохранить" /></p>
</form><?php }} ?>