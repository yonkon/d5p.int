<?php /* Smarty version Smarty-3.1.8, created on 2015-01-08 17:09:10
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/orderinfo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:196694002754ae8df7281a07-14245813%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c67faf92990aa85f18dac567e6303cf9c6226719' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/orderinfo.tpl',
      1 => 1420726148,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '196694002754ae8df7281a07-14245813',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_54ae8df7679be1_35866043',
  'variables' => 
  array (
    'errorCodes' => 0,
    'url' => 0,
    'res' => 0,
    'infomsg' => 0,
    'lang' => 0,
    'plan' => 0,
    'payments' => 0,
    'files' => 0,
    'onlinePay' => 0,
    'errormsg' => 0,
    'paysysRegions' => 0,
    'region' => 0,
    'paysys' => 0,
    'paymentMethod' => 0,
    'item' => 0,
    'sendmsg' => 0,
    'mail' => 0,
    'readMail' => 0,
    'rm_idm' => 0,
    'rm_subject' => 0,
    'attach' => 0,
    'rm_message' => 0,
    'writeMail' => 0,
    'idm' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54ae8df7679be1_35866043')) {function content_54ae8df7679be1_35866043($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/s/spluso/diplom5plus.ru/public_html/include/smarty/plugins/modifier.date_format.php';
?><?php if (count($_smarty_tpl->tpl_vars['errorCodes']->value)){?>
    <?php echo $_smarty_tpl->getSubTemplate ('error.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
	<p><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['orderlist'];?>
">&laquo;&laquo; Назад к списку заказов</a></p><br />

	<?php if (isset($_smarty_tpl->tpl_vars['res']->value['ballMSG'])){?>
		<p style="border:dotted 1px red; padding:2px;"><?php echo $_smarty_tpl->tpl_vars['res']->value['ballMSG'];?>
</p>
	<?php }?>

	<?php if (isset($_smarty_tpl->tpl_vars['infomsg']->value)){?>
		<div style="border:dotted 1px green; color:green; padding:4px; margin:4px;"><?php echo $_smarty_tpl->tpl_vars['infomsg']->value;?>
</div>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['res']->value['enablecomm']=="y"){?>
		<h3>Ваш отзыв о работе</h3>
		<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['url']->value['orderinfo'];?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"ido",'hrefVal'=>$_smarty_tpl->tpl_vars['res']->value['ido']), 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"act",'hrefVal'=>"sendBall"), 0);?>
" id="rForm" enctype="multipart/form-data">
		<strong>Ваша оценка работы:</strong><br />
		<input type="radio" name="ball" id="ball1" value="1" /> 1 &nbsp;&nbsp;
		<input type="radio" name="ball" id="ball2" value="2" /> 2 &nbsp;&nbsp;
		<input type="radio" name="ball" id="ball3" value="3" /> 3 &nbsp;&nbsp;
		<input type="radio" name="ball" id="ball4" value="4" /> 4 &nbsp;&nbsp;
		<input type="radio" name="ball" id="ball5" value="5" /> 5
		<br />
		<strong>Комментарий:</strong><br />
		<textarea name="wcomm" id="wcomm" style="width:400px; height:100px;"><?php if (isset($_smarty_tpl->tpl_vars['res']->value['wcomm'])){?><?php echo $_smarty_tpl->tpl_vars['res']->value['wcomm'];?>
<?php }?></textarea><br />
		<input type="submit" value="Отправить" />
		</form>
		<hr /><br />
	<?php }?>
       			
	<table border="0" cellspacing="0" cellpadding="0" class="dataTab">
		<tr><td>№</td><td><strong><?php echo $_smarty_tpl->tpl_vars['res']->value['ido'];?>
</strong> <small>(<?php echo $_smarty_tpl->tpl_vars['res']->value['o_state'];?>
)</small></td></tr>
		<tr><td>Дата оформления:</td><td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['res']->value['o_date'],"%d.%m.%Y");?>
</td></tr>
		<tr><td>Тема:</td><td><strong><?php echo $_smarty_tpl->tpl_vars['res']->value['o_thema'];?>
</strong></td></tr>
		<tr><td>Предмет работы:</td><td><?php echo $_smarty_tpl->tpl_vars['res']->value['o_worktype'];?>
</td></tr>
		<tr><td>Тип работы:</td><td><?php echo $_smarty_tpl->tpl_vars['res']->value['o_course'];?>
</td></tr>
		<tr><td>Объем:</td><td><?php if (!empty($_smarty_tpl->tpl_vars['res']->value['o_volume'])){?><?php echo $_smarty_tpl->tpl_vars['res']->value['o_volume'];?>
<?php }else{ ?>-<?php }?></td></tr>
		<tr><td>ГОСТ:</td><td><?php if (!empty($_smarty_tpl->tpl_vars['res']->value['gost'])){?><?php echo $_smarty_tpl->tpl_vars['res']->value['gost'];?>
<?php }else{ ?>-<?php }?></td></tr>
		<tr><td>Шрифт:</td><td><?php if (!empty($_smarty_tpl->tpl_vars['res']->value['o_font'])){?><?php echo $_smarty_tpl->tpl_vars['res']->value['o_font'];?>
<?php }else{ ?>-<?php }?></td></tr>
		<tr><td>Интервал:</td><td><?php if (!empty($_smarty_tpl->tpl_vars['res']->value['o_interval'])){?><?php echo $_smarty_tpl->tpl_vars['res']->value['o_interval'];?>
<?php }else{ ?>-<?php }?></td></tr>
		<tr><td>К-во используемых источников:</td><td><?php if (!empty($_smarty_tpl->tpl_vars['res']->value['o_listsource'])){?><?php echo $_smarty_tpl->tpl_vars['res']->value['o_listsource'];?>
<?php }else{ ?>-<?php }?></td></tr>
		<tr><td>Дополнительная информация:</td><td><?php if (!empty($_smarty_tpl->tpl_vars['res']->value['o_addinfo'])){?><?php echo $_smarty_tpl->tpl_vars['res']->value['o_addinfo'];?>
<?php }else{ ?>-<?php }?></td></tr>
		<tr><td style="border-bottom: 1px solid black">Срок выполнения:</td><td style="border-bottom: 1px solid black"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['res']->value['o_client_srok'],"%d.%m.%Y");?>
</td></tr>
		<tr><td>Стоимость:</td><td><strong><?php echo $_smarty_tpl->tpl_vars['res']->value['o_cost'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['lang']->value['currency'];?>
</strong></td></tr>
	</table>
	<br /><br /><br />

	<h4>План выполнения работы</h4>
	<table border="0" cellspacing="0" cellpadding="0" class="dataTab" style="width: 100%">
		<tr><th>Этап</th><th>Срок сдачи</th><th>Состояние</th><th>Оплата</th></tr>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['name'] = 'p_loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['plan']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['total']);
?>
			<tr>
				<td><?php echo $_smarty_tpl->tpl_vars['plan']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p_loop']['index']]['workpart'];?>
</td>
				<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['plan']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p_loop']['index']]['srok'],"%d.%m.%Y");?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['plan']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p_loop']['index']]['sfile'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['plan']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p_loop']['index']]['spay'];?>
</td>
			</tr>
		<?php endfor; endif; ?>
	</table>
	<br /><br /><br />
	
	<h4>Ваши платежи</h4>
	<table border="0" cellspacing="0" cellpadding="0" class="dataTab" style="width: 100%">
		<tr><th>Сумма</th><th>Способ</th><th>Дата</th><th>Комментарий</th></tr>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['name'] = 'p_loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['payments']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['p_loop']['total']);
?>
			<tr>
				<td><?php echo $_smarty_tpl->tpl_vars['payments']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p_loop']['index']]['pamount'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['lang']->value['currency'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['payments']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p_loop']['index']]['paysys'];?>
</td>
				<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['payments']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p_loop']['index']]['pdate'],"%d.%m.%Y");?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['payments']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p_loop']['index']]['pcomment'];?>
</td>
			</tr>
		<?php endfor; endif; ?>
	</table>
	<p><small>Чтобы отправить квитанцию об оплате, напишите письмо менеджеру (ниже) и прикрепите отсканированную копию квитанции.</small></p>
	<br /><br />
	
	<h4>Файлы</h4>
	<table border="0" cellspacing="0" cellpadding="0" class="dataTab" style="width: 100%">
		<tr><th>Файл</th><th>Тип</th><th>Дата</th></tr>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['name'] = 'f_loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['files']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['f_loop']['total']);
?>
			<tr>
				<td>
					<img src="<?php echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['f_loop']['index']]['ficon'];?>
" />
					<?php if ($_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['f_loop']['index']]['upload']=="y"){?>
						<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['download'];?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"idf",'hrefVal'=>$_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['f_loop']['index']]['idf']), 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"ido",'hrefVal'=>$_smarty_tpl->tpl_vars['res']->value['ido']), 0);?>
"><?php echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['f_loop']['index']]['fname'];?>
</a> 
						<small>(<?php echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['f_loop']['index']]['fsize'];?>
)</small>
					<?php }else{ ?>
						<?php echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['f_loop']['index']]['fname'];?>
 <small>(<?php echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['f_loop']['index']]['fsize'];?>
)</small>
					<?php }?>
				</td>
				<td><?php echo $_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['f_loop']['index']]['fpart'];?>
</td>
				<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['files']->value[$_smarty_tpl->getVariable('smarty')->value['section']['f_loop']['index']]['fdate'],"%d.%m.%Y");?>
</td>
			</tr>
		<?php endfor; endif; ?>
	</table>
	<br /><br /><br />

    
    <?php if (($_smarty_tpl->tpl_vars['onlinePay']->value)){?>
    <h3>Оплата заказа №<?php echo $_smarty_tpl->tpl_vars['res']->value['ido'];?>
</h3>
        <?php if (isset($_smarty_tpl->tpl_vars['errormsg']->value)){?><div style="border:dotted 1px red; color:red; padding:4px; margin:4px;"><?php echo $_smarty_tpl->tpl_vars['errormsg']->value;?>
</div><?php }?>
        <br />
        <h4>Выберите способ оплаты</h4>
		<?php  $_smarty_tpl->tpl_vars['region'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['region']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['paysysRegions']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['region']->key => $_smarty_tpl->tpl_vars['region']->value){
$_smarty_tpl->tpl_vars['region']->_loop = true;
?>
			<h3><?php echo $_smarty_tpl->tpl_vars['region']->value['text'];?>
</h3>
			<?php  $_smarty_tpl->tpl_vars['paysys'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['paysys']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['region']->value['payments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['paysys']->key => $_smarty_tpl->tpl_vars['paysys']->value){
$_smarty_tpl->tpl_vars['paysys']->_loop = true;
?>
				<?php $_smarty_tpl->tpl_vars["item"] = new Smarty_variable($_smarty_tpl->tpl_vars['paymentMethod']->value[$_smarty_tpl->tpl_vars['paysys']->value], null, 0);?>
				<?php if ($_smarty_tpl->tpl_vars['item']->value['switch']){?>
					<div style="border:dotted 1px #ccc; padding:4px;margin:2px;">
						<h4><?php echo $_smarty_tpl->tpl_vars['item']->value['fullname'];?>
</h4>
						<?php if ($_smarty_tpl->tpl_vars['paysys']->value=='easypayby'){?>
							<?php if (isset($_smarty_tpl->tpl_vars['item']->value['info'])){?><?php echo $_smarty_tpl->tpl_vars['item']->value['info'];?>
<?php }?>
							<?php if (!empty($_smarty_tpl->tpl_vars['item']->value['login'])){?>
								<form action="<?php echo $_smarty_tpl->tpl_vars['url']->value['onlinepayment'];?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"ido",'hrefVal'=>$_smarty_tpl->tpl_vars['res']->value['ido']), 0);?>
" method="post" target="_top" >
									<table> 
									<tr>
										<td><input type="text" name="sum" value="<?php echo $_smarty_tpl->tpl_vars['res']->value['topay'];?>
" />&nbsp;<?php echo $_smarty_tpl->tpl_vars['lang']->value['currency'];?>
</td>
										<td><input type="submit" value="Оплатить" /></td>
									</tr>
									</table>
									<input type="hidden" name="prepare_paysys" value="esaypay" />
								</form>
							<?php }?>
						<?php }elseif($_smarty_tpl->tpl_vars['paysys']->value=='interkassa'){?>
							<form name="payment" action="<?php echo $_smarty_tpl->tpl_vars['item']->value['server'];?>
" method="post" target="_top">
								<input type="hidden" name="ik_shop_id" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['ik_shop_id'];?>
">
								<input type="text" name="ik_payment_amount" value="<?php echo $_smarty_tpl->tpl_vars['res']->value['topay'];?>
">&nbsp;<?php echo $_smarty_tpl->tpl_vars['lang']->value['currency'];?>

								<input type="hidden" name="ik_payment_id" value="<?php echo $_smarty_tpl->tpl_vars['res']->value['ik_payment_id'];?>
">
								<input type="hidden" name="ik_payment_desc" value="<?php echo $_smarty_tpl->tpl_vars['res']->value['ido'];?>
">
								<input type="hidden" name="ik_paysystem_alias" value="">
								<input type="hidden" name="ik_fail_url" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['url']['fail'];?>
&ido=<?php echo $_smarty_tpl->tpl_vars['res']->value['ido'];?>
">
								<input type="hidden" name="ik_success_url" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['url']['success'];?>
&ido=<?php echo $_smarty_tpl->tpl_vars['res']->value['ido'];?>
">
								<input type="submit" name="process" value="Оплатить">
							</form>
						<?php }elseif($_smarty_tpl->tpl_vars['paysys']->value=='privat24'){?>
							<form action="<?php echo $_smarty_tpl->tpl_vars['item']->value['server'];?>
" method="POST">
								<input type="text" name="amt" value="<?php echo $_smarty_tpl->tpl_vars['res']->value['topay'];?>
"/>&nbsp;<?php echo $_smarty_tpl->tpl_vars['lang']->value['currency'];?>

								<input type="hidden" name="ccy" value="UAH" />
								<input type="hidden" name="merchant" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['mid'];?>
" />
								<input type="hidden" name="order" value="<?php echo $_smarty_tpl->tpl_vars['res']->value['p24_payment_id'];?>
" />
								<input type="hidden" name="details" value="<?php echo $_smarty_tpl->tpl_vars['res']->value['ido'];?>
" />
								<input type="hidden" name="ext_details" value="" />
								<input type="hidden" name="pay_way" value="privat24" />
								<input type="hidden" name="return_url" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['url']['client'];?>
&ido=<?php echo $_smarty_tpl->tpl_vars['res']->value['ido'];?>
" />
								<input type="hidden" name="server_url" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['url']['server'];?>
" />
								<input type="submit" value="Оплатить" />
							</form>
						<?php }elseif($_smarty_tpl->tpl_vars['paysys']->value=='qiwi'){?> 
							<form  action="<?php echo $_smarty_tpl->tpl_vars['item']->value['server'];?>
" method="get">
								<input name="from" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['qiwi_shop_id'];?>
" type="hidden" /> 
								<input name="txn_id" value="<?php echo $_smarty_tpl->tpl_vars['res']->value['qw_payment_id'];?>
" type="hidden" /> 
								<input name="com" value="<?php echo $_smarty_tpl->tpl_vars['res']->value['o_worktype'];?>
,<?php echo $_smarty_tpl->tpl_vars['res']->value['o_course'];?>
 на тему: <?php echo $_smarty_tpl->tpl_vars['res']->value['o_thema'];?>
" type="hidden" />
								<table>
									<tr><td> Номер телефона (счет qiwi):</td><td colspan="2"><input name="to" value="" /> </td> </tr>
									<tr><td> Сумма(руб.):</td><td><input name="summ" value="<?php echo $_smarty_tpl->tpl_vars['res']->value['topay'];?>
" /> </td> </tr> 
									<tr><td></td><td><input type="submit" value="Оплатить" /></td></tr>
								</table>
							</form>
						<?php }elseif($_smarty_tpl->tpl_vars['paysys']->value=='robokassa'){?>
							<form action="<?php echo $_smarty_tpl->tpl_vars['url']->value['onlinepayment'];?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"ido",'hrefVal'=>$_smarty_tpl->tpl_vars['res']->value['ido']), 0);?>
" method="post" target="_top" >
								<table> 
								<tr>
									<td><input type="text" name="sum" value="<?php echo $_smarty_tpl->tpl_vars['res']->value['topay'];?>
" />&nbsp;<?php echo $_smarty_tpl->tpl_vars['lang']->value['currency'];?>
</td>
									<td><input type="submit" value="Оплатить" /></td>
								</tr>
								</table>
								<input type="hidden" name="prepare_paysys" value="robokassa" />
							</form>
						<?php }elseif($_smarty_tpl->tpl_vars['paysys']->value=='cash1'||$_smarty_tpl->tpl_vars['paysys']->value=='cash2'||$_smarty_tpl->tpl_vars['paysys']->value=='cash3'||$_smarty_tpl->tpl_vars['paysys']->value=='cash4'){?>
							<?php echo $_smarty_tpl->tpl_vars['item']->value['info'];?>

						<?php }elseif($_smarty_tpl->tpl_vars['paysys']->value=='bank1'||$_smarty_tpl->tpl_vars['paysys']->value=='bank2'||$_smarty_tpl->tpl_vars['paysys']->value=='bank3'||$_smarty_tpl->tpl_vars['paysys']->value=='bank4'){?>
							<?php echo $_smarty_tpl->tpl_vars['item']->value['info'];?>
<br />
							Платежку можно скачать <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['file'];?>
">тут</a>						
						<?php }?>
					</div>
				<?php }?>
			<?php } ?>
		<?php } ?>
    <?php }?>
    
    
        
    <h3 style="border-top:solid 1px #cccccc;">Почта по заказу №<?php echo $_smarty_tpl->tpl_vars['res']->value['ido'];?>
</h3><a name="mailpoint"></a>

    <?php if (isset($_smarty_tpl->tpl_vars['sendmsg']->value)){?>
        <p style="padding:3px; color:red; border:dashed 1px blue;"><?php echo $_smarty_tpl->tpl_vars['sendmsg']->value;?>
</p>
    <?php }?>

    <p><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['orderinfo'];?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"ido",'hrefVal'=>$_smarty_tpl->tpl_vars['res']->value['ido']), 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"act",'hrefVal'=>"writeMail"), 0);?>
#mailpoint">Написать письмо менеджеру</a></p>

    <?php if (!empty($_smarty_tpl->tpl_vars['mail']->value)){?>
        <table border="0" cellspacing="0" cellpadding="0" class="dataTab">
            <tr>
                <td valign="top" width="50%">
                    <table border="0" cellspacing="0" cellpadding="0" class="dataTab">
                        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['mail']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                            <tr>
                                <td><small><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['mdate'],"%d.%m.%Y %H:%M");?>
</small></td>
                                <td><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['orderinfo'];?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"ido",'hrefVal'=>$_smarty_tpl->tpl_vars['res']->value['ido']), 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"act",'hrefVal'=>"readMail"), 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"idm",'hrefVal'=>$_smarty_tpl->tpl_vars['item']->value['idm']), 0);?>
#mailpoint"><?php if ($_smarty_tpl->tpl_vars['item']->value['mstate']=="new"){?><strong><?php }?><?php echo $_smarty_tpl->tpl_vars['item']->value['subject'];?>
<?php if ($_smarty_tpl->tpl_vars['item']->value['mstate']=="new"){?></strong><?php }?></a></td>
                            </tr>
                        <?php } ?>
                    </table>
                
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <?php if (!empty($_smarty_tpl->tpl_vars['readMail']->value)){?>
                        <br /><br />
                        <p style="padding-bottom:5px; border-bottom:solid 1px #cccccc;"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['orderinfo'];?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"ido",'hrefVal'=>$_smarty_tpl->tpl_vars['res']->value['ido']), 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"act",'hrefVal'=>"writeMail"), 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"idm",'hrefVal'=>$_smarty_tpl->tpl_vars['rm_idm']->value), 0);?>
#mailpoint">Ответить</a> | <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['orderinfo'];?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"ido",'hrefVal'=>$_smarty_tpl->tpl_vars['res']->value['ido']), 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"act",'hrefVal'=>"deleteMail"), 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"idm",'hrefVal'=>$_smarty_tpl->tpl_vars['rm_idm']->value), 0);?>
#mailpoint">Удалить</a></p>
                        <p><strong><?php echo $_smarty_tpl->tpl_vars['rm_subject']->value;?>
</strong></p>
                        <?php if (!empty($_smarty_tpl->tpl_vars['attach']->value)){?>
                        <div style="border:solid 1px #cccccc;padding:3px;margin:3px;">
                            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['attach']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                             <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['download'];?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"ida",'hrefVal'=>$_smarty_tpl->tpl_vars['item']->value['ida']), 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"idm",'hrefVal'=>$_smarty_tpl->tpl_vars['rm_idm']->value), 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"ido",'hrefVal'=>$_smarty_tpl->tpl_vars['res']->value['ido']), 0);?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['fname'];?>
 <small>(<?php echo $_smarty_tpl->tpl_vars['item']->value['fsize'];?>
)</small></a> &nbsp;&nbsp;&nbsp;
                            <?php } ?>        
                        </div>
                        <?php }?>
                        <div style="border:solid 1px #cccccc; padding:3px;"><?php echo $_smarty_tpl->tpl_vars['rm_message']->value;?>
</div>
                    <?php }?>
                    <?php if (empty($_smarty_tpl->tpl_vars['writeMail']->value)){?> 
                        </td></tr></table>
                    <?php }?>
    <?php }?>
    <?php if (!empty($_smarty_tpl->tpl_vars['writeMail']->value)){?>
        <div style="border:solid 1px #cccccc; padding:3px;">
            <p><strong>Информация по заказу № <?php echo $_smarty_tpl->tpl_vars['res']->value['ido'];?>
</strong></p>
            <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['url']->value['orderinfo'];?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"ido",'hrefVal'=>$_smarty_tpl->tpl_vars['res']->value['ido']), 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("hrefparam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('hrefParam'=>"act",'hrefVal'=>"sendMail"), 0);?>
#mailpoint" enctype="multipart/form-data">
                <?php if (!empty($_smarty_tpl->tpl_vars['idm']->value)){?>
                    <input type="hidden" name="idm" id="idm" value="<?php echo $_smarty_tpl->tpl_vars['idm']->value;?>
" />
                <?php }?>
                Текст сообщения:<br />
                <textarea name="m_message" id="m_message" style="width:350px;height:200px;"></textarea><br />
                Прикрепить файл:<br />
                <input type="file" name="attach" id="attach" size="30" /><br /><br />
                <input type="submit" value="Отправить" style="width:100px;height:26px;" />
            </form>
        </div>
        <?php if (!empty($_smarty_tpl->tpl_vars['mail']->value)){?>
            </td></tr></table>
        <?php }?>
    <?php }?>

    
<?php }?><?php }} ?>