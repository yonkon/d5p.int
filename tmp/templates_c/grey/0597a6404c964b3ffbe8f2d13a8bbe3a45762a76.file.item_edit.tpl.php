<?php /* Smarty version Smarty-3.1.8, created on 2013-05-14 16:25:00
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/backend/grey/catalog/item_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1297795368518e65c22ddaa3-35570609%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0597a6404c964b3ffbe8f2d13a8bbe3a45762a76' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/backend/grey/catalog/item_edit.tpl',
      1 => 1368537593,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1297795368518e65c22ddaa3-35570609',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_518e65c23a7317_27357200',
  'variables' => 
  array (
    'messageOut' => 0,
    'categoriesList' => 0,
    'product' => 0,
    'idc' => 0,
    'item' => 0,
    'parameters' => 0,
    'id_additionalInfo' => 0,
    'listIdParameters' => 0,
    'act' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_518e65c23a7317_27357200')) {function content_518e65c23a7317_27357200($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['messageOut']->value)){?>
	<strong><?php echo $_smarty_tpl->tpl_vars['messageOut']->value;?>
</strong>
<?php }?>
<form action="admin.php?p=item_edit" method="post" enctype="multipart/form-data">
	<table border="0" cellspacing="0" class="selrow" width="100%" id="ItemTab">
		<tbody>
			<tr class="editSection-trHeight">
				<td class="editSection-tdName">Раздел:</td>
				<td>
					<select name="parent_idc" id="categoryParent" style="width:200px;">
					<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['idc'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['categoriesList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['idc']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
						<option <?php if ($_smarty_tpl->tpl_vars['product']->value['parent']==$_smarty_tpl->tpl_vars['idc']->value){?>selected="selected"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['idc']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
					<?php } ?>
					</select>
				</td>
			</tr>
			<tr class="editSection-trHeight">
				<td class="editSection-tdName">Включить показ на сайте:</td>
				<td><input type="checkbox" name="show" id="itemShow" <?php if ($_smarty_tpl->tpl_vars['product']->value['show']==1){?>checked="checked"<?php }?> /></td>
			</tr>
			<tr class="editSection-trHeight">
				<td class="editSection-tdName">Порядок сортировки:</td>
				<td><input type="text" name="sort_order" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['sortOrder'];?>
" size="3"></td>
			</tr>			
		</tbody>
	</table>
	
	<strong>Название:</strong><br />
	<input type='text' name='name' size='50' maxlenght='150' value="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
" /><br />

	<?php  $_smarty_tpl->tpl_vars['current_additionalInfo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['current_additionalInfo']->_loop = false;
 $_smarty_tpl->tpl_vars['id_additionalInfo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['parameters']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['current_additionalInfo']->key => $_smarty_tpl->tpl_vars['current_additionalInfo']->value){
$_smarty_tpl->tpl_vars['current_additionalInfo']->_loop = true;
 $_smarty_tpl->tpl_vars['id_additionalInfo']->value = $_smarty_tpl->tpl_vars['current_additionalInfo']->key;
?>
		<?php if (in_array($_smarty_tpl->tpl_vars['id_additionalInfo']->value,$_smarty_tpl->tpl_vars['listIdParameters']->value['input'])){?>
			<strong><?php echo $_smarty_tpl->tpl_vars['parameters']->value[$_smarty_tpl->tpl_vars['id_additionalInfo']->value];?>
:</strong><br />
			<input type='text' name='addInfo[<?php echo $_smarty_tpl->tpl_vars['id_additionalInfo']->value;?>
]' size='50' maxlenght='150' value="<?php echo $_smarty_tpl->tpl_vars['product']->value['addInfo'][$_smarty_tpl->tpl_vars['id_additionalInfo']->value];?>
" /><br />
		<?php }?>

		<?php if (in_array($_smarty_tpl->tpl_vars['id_additionalInfo']->value,$_smarty_tpl->tpl_vars['listIdParameters']->value['textarea'])){?>
			<strong><?php echo $_smarty_tpl->tpl_vars['parameters']->value[$_smarty_tpl->tpl_vars['id_additionalInfo']->value];?>
:</strong><br />
			<textarea name="addInfo[<?php echo $_smarty_tpl->tpl_vars['id_additionalInfo']->value;?>
]" rows="5" cols="120"><?php echo $_smarty_tpl->tpl_vars['product']->value['addInfo'][$_smarty_tpl->tpl_vars['id_additionalInfo']->value];?>
</textarea><br />
		<?php }?>		
	<?php } ?>

	<input type="hidden" name="act" value="<?php echo $_smarty_tpl->tpl_vars['act']->value;?>
" />
	<input type="hidden" name="idp" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['idp'];?>
" />
	<p><input type="submit" value="Сохранить" /></p>
</form><?php }} ?>