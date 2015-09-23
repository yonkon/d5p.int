<?php /* Smarty version Smarty-3.1.8, created on 2015-01-17 14:03:04
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/ordercreated.tpl" */ ?>
<?php /*%%SmartyHeaderCode:29669966354ba4168e10d43-17768185%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4a8d2ba692c4edda17c10f4fa44ff6193b11c6ac' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/ordercreated.tpl',
      1 => 1368627505,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29669966354ba4168e10d43-17768185',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'orderInfo' => 0,
    'clientInfo' => 0,
    'lang' => 0,
    'list' => 0,
    'filesInfo' => 0,
    'key' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_54ba41690a8500_16537858',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54ba41690a8500_16537858')) {function content_54ba41690a8500_16537858($_smarty_tpl) {?><center>
	<strong>Заказ успешно оформлен!</strong><br /><br />
	<h3>Номер заказа: <?php echo $_smarty_tpl->tpl_vars['orderInfo']->value['ido'];?>
</h3>
</center>
<p>Пожалуйста, во время переписки с менеджерами, указывайте номер заказа в теме письма<br />
В ближайшее время мы свяжемся с Вами для согласования всех деталей работы.</p>

<?php if (isset($_smarty_tpl->tpl_vars['clientInfo']->value)){?>
	<p>
		<strong>Ваши данные для входа в аккаунт:</strong><br />
		Логин: <strong><?php echo $_smarty_tpl->tpl_vars['clientInfo']->value['login'];?>
</strong><br />
		Пароль: <strong><?php echo $_smarty_tpl->tpl_vars['clientInfo']->value['password'];?>
</strong>
	</p>
	<p>
		<strong>Контактная информация:</strong><br />
		<?php echo $_smarty_tpl->tpl_vars['lang']->value['fio'];?>
: <?php echo $_smarty_tpl->tpl_vars['clientInfo']->value['fio'];?>
<br />
		<?php echo $_smarty_tpl->tpl_vars['lang']->value['email'];?>
: <?php echo $_smarty_tpl->tpl_vars['clientInfo']->value['email'];?>
<br />
		<?php echo $_smarty_tpl->tpl_vars['lang']->value['mphone'];?>
: +<?php echo $_smarty_tpl->tpl_vars['clientInfo']->value['mphone'];?>
<br />
		<?php echo $_smarty_tpl->tpl_vars['lang']->value['sphone'];?>
: +<?php echo $_smarty_tpl->tpl_vars['clientInfo']->value['sphone'];?>
<br />
		<?php echo $_smarty_tpl->tpl_vars['lang']->value['icq'];?>
: <?php echo $_smarty_tpl->tpl_vars['clientInfo']->value['icq'];?>
<br />
		<?php echo $_smarty_tpl->tpl_vars['lang']->value['contact'];?>
: <?php echo $_smarty_tpl->tpl_vars['clientInfo']->value['contact'];?>
<br />
	</p>
<?php }?>
<p>
	<strong>Информация по вашему заказу:</strong><br />
	<?php echo $_smarty_tpl->tpl_vars['lang']->value['thema'];?>
: <?php echo $_smarty_tpl->tpl_vars['orderInfo']->value['thema'];?>
<br />
	<?php echo $_smarty_tpl->tpl_vars['lang']->value['course'];?>
: <?php if (($_smarty_tpl->tpl_vars['orderInfo']->value['course']!=0)){?><?php echo $_smarty_tpl->tpl_vars['list']->value['course'][$_smarty_tpl->tpl_vars['orderInfo']->value['course']];?>
<?php }?><br />
	<?php echo $_smarty_tpl->tpl_vars['lang']->value['worktype'];?>
: <?php if (($_smarty_tpl->tpl_vars['orderInfo']->value['worktype']!=0)){?><?php echo $_smarty_tpl->tpl_vars['list']->value['worktype'][$_smarty_tpl->tpl_vars['orderInfo']->value['worktype']];?>
<?php }?><br />
	<?php echo $_smarty_tpl->tpl_vars['lang']->value['client_srok'];?>
: <?php echo $_smarty_tpl->tpl_vars['orderInfo']->value['client_srok'];?>
<br />
	<?php echo $_smarty_tpl->tpl_vars['lang']->value['schooltype'];?>
: <?php if (($_smarty_tpl->tpl_vars['orderInfo']->value['schooltype']!=0)){?><?php echo $_smarty_tpl->tpl_vars['list']->value['schooltype'][$_smarty_tpl->tpl_vars['orderInfo']->value['schooltype']];?>
<?php }?><br />
	<?php echo $_smarty_tpl->tpl_vars['lang']->value['cnc'];?>
: <?php if (!empty($_smarty_tpl->tpl_vars['orderInfo']->value['country'])){?><?php echo $_smarty_tpl->tpl_vars['list']->value['country'][$_smarty_tpl->tpl_vars['orderInfo']->value['country']];?>
, <?php }?><?php echo $_smarty_tpl->tpl_vars['orderInfo']->value['city'];?>
<br />
	<?php echo $_smarty_tpl->tpl_vars['lang']->value['vuz'];?>
: <?php echo $_smarty_tpl->tpl_vars['orderInfo']->value['vuz'];?>
<br />
	<?php echo $_smarty_tpl->tpl_vars['lang']->value['volume'];?>
: <?php echo $_smarty_tpl->tpl_vars['orderInfo']->value['volume'];?>
<br />
	<?php echo $_smarty_tpl->tpl_vars['lang']->value['gost'];?>
: <?php if (($_smarty_tpl->tpl_vars['orderInfo']->value['gost']!=0)){?><?php echo $_smarty_tpl->tpl_vars['list']->value['gost'][$_smarty_tpl->tpl_vars['orderInfo']->value['gost']];?>
<?php }?><br />
	<?php echo $_smarty_tpl->tpl_vars['lang']->value['font'];?>
: <?php echo $_smarty_tpl->tpl_vars['orderInfo']->value['font'];?>
<br />
	<?php echo $_smarty_tpl->tpl_vars['lang']->value['interval'];?>
: <?php echo $_smarty_tpl->tpl_vars['orderInfo']->value['interval'];?>
<br />
	<?php echo $_smarty_tpl->tpl_vars['lang']->value['listsource'];?>
: <?php echo $_smarty_tpl->tpl_vars['orderInfo']->value['listsource'];?>
<br />
	<?php echo $_smarty_tpl->tpl_vars['lang']->value['addinfo'];?>
: <?php echo $_smarty_tpl->tpl_vars['orderInfo']->value['addinfo'];?>
<br />
	<?php echo $_smarty_tpl->tpl_vars['lang']->value['precost'];?>
: <?php echo $_smarty_tpl->tpl_vars['orderInfo']->value['precost'];?>
 <?php echo $_smarty_tpl->tpl_vars['lang']->value['currency'];?>
<br />
</p>
<p>
	<?php if (count($_smarty_tpl->tpl_vars['filesInfo']->value['files'])!=0){?>
		<strong>Прикреплённые файлы</strong><?php if (isset($_smarty_tpl->tpl_vars['filesInfo']->value['file_part'])&&$_smarty_tpl->tpl_vars['filesInfo']->value['file_part']!=''){?>(<?php echo $_smarty_tpl->tpl_vars['lang']->value['file_part'];?>
: <?php echo $_smarty_tpl->tpl_vars['list']->value['file_part'][$_smarty_tpl->tpl_vars['filesInfo']->value['file_part']];?>
)<?php }?>:<br />
		<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['filesInfo']->value['files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
			<?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
: <?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>

			<?php if ($_smarty_tpl->tpl_vars['item']->value['status']=='none'){?>
				- <?php echo $_smarty_tpl->tpl_vars['lang']->value['fileUploadingError1'];?>

			<?php }elseif($_smarty_tpl->tpl_vars['item']->value['status']=='mismatch'){?>
				- <?php echo $_smarty_tpl->tpl_vars['lang']->value['fileUploadingError2'];?>

			<?php }?>
			<br />
		<?php } ?>
		<?php if (isset($_smarty_tpl->tpl_vars['filesInfo']->value['f_comment'])&&$_smarty_tpl->tpl_vars['filesInfo']->value['f_comment']!=''){?>
			<?php echo $_smarty_tpl->tpl_vars['lang']->value['file_comment'];?>
 <?php echo $_smarty_tpl->tpl_vars['filesInfo']->value['f_comment'];?>
<br />
		<?php }?>		
	<?php }else{ ?>
		<strong>Прикреплённых файлов нет.</strong><br />
	<?php }?>	
</p>
<p>Вы всегда можете войти в свой аккаунт для просмотра состояния заказа, переписки с менеджерами, загрузки файлов по выполненным заказам.<br /></p>
<p>С уважением, администрация сайта!</p><?php }} ?>