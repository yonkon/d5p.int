<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 18:40:27
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/backend/grey/admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5059981425193ac6b8c5082-27753995%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7a8e67fd5f9b3cae50876f4e697dcb5c2dfac3b9' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/backend/grey/admin.tpl',
      1 => 1368626845,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5059981425193ac6b8c5082-27753995',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'wwwadres' => 0,
    'conf' => 0,
    'TITLE' => 0,
    'HEADER' => 0,
    'fly_menu' => 0,
    'alang' => 0,
    'NewMessage' => 0,
    'langs' => 0,
    'lw' => 0,
    'item' => 0,
    'tpldir' => 0,
    'modSet' => 0,
    'PAGETITLE' => 0,
    'PAGE' => 0,
    'debug' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5193ac6ba621c3_87389327',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5193ac6ba621c3_87389327')) {function content_5193ac6ba621c3_87389327($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/s/spluso/diplom5plus.ru/public_html/include/smarty/plugins/modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<base href="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/" /><!--[if IE]></base><![endif]-->
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Cash-Control" content="no-cash, must-revalidate" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_smarty_tpl->tpl_vars['conf']->value['encoding'];?>
" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Author" content="Volodymyr Demchuk, http://shiftcms.net" />
	<meta name="Copyleft" content="ShiftCMS" />
	<link rel="icon" href="favicon.ico" type="ico" />
	<link rel="StyleSheet" href="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['conf']->value['admin_tpl_dir'];?>
css/bw.css" type="text/css" />
	<link type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/js/jquery/themes/ui-lightness/jquery.ui.all.css" rel="stylesheet" />
	
	<script src="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/js/admin_func.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/js/jquery/jquery-1.4.3.min.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/js/jquery/jquery-ui-1.8.5.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/js/jquery/ui/minified/jquery.ui.core.min.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/js/jquery/ui/minified/jquery.ui.widget.min.js"></script>

	<script type="text/javascript">
		var timerID = null
		var timerRunning = false
		function stopclock(){
		   if(timerRunning)
		      clearInterval(timerID)
			timerRunning = false
		}
		function startclock(){
	   		timerID = setInterval("Informer()",30000)
		    timerRunning = true
		}
		function Informer(){
			getdata('','get','?p=site_server&act=Informer','Informer')
		}
	</script>

<title><?php echo $_smarty_tpl->tpl_vars['TITLE']->value;?>
</title>
<?php echo $_smarty_tpl->tpl_vars['HEADER']->value;?>

</head>
<body onLoad="startclock();">
<div id="Header">
<ul id="nav">
	<?php echo $_smarty_tpl->tpl_vars['fly_menu']->value;?>

</ul>
	<div id="Menu">
		<table border='0' cellspacing='0' cellpadding='0' width='100%'><tr>
        <td align="left">
        	<h3 style="display:inline;"><?php echo $_SESSION['USER_LOGIN'];?>
:</h3> &nbsp;&nbsp;&nbsp;
          <a href="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/logout.php"><img src="<?php echo $_smarty_tpl->tpl_vars['conf']->value['admin_tpl_dir'];?>
img/logout.png" style="vertical-align:middle;" alt="Выход" /></a>&nbsp;
          <a href="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/logout.php"><?php echo $_smarty_tpl->tpl_vars['alang']->value['logout'];?>
</a> <small>(<i><?php echo $_smarty_tpl->tpl_vars['alang']->value['last_visit'];?>
: <?php echo smarty_modifier_date_format($_SESSION['USER_LAST_ACCES'],"%d.%m.%Y %H:%M");?>
</i>)</small></td>
		<td align="center" width="30" style="padding-left:20px;">
    	<div id="Informer" style='float:left;display:inline;text-align:center;'>
          <?php if ($_smarty_tpl->tpl_vars['NewMessage']->value!=''){?>
			<div id="somediv" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['NewMessage']->value;?>
</div>
			<a href="#" onClick="divwin=dhtmlwindow.open('divbox', 'div', 'somediv', '<?php echo $_smarty_tpl->tpl_vars['alang']->value['informer'];?>
', 
            'width=450px,height=400px,left=50px,top=50px,resize=1,scrolling=1'); return false" style="padding:0px;margin:0px;"><img src='<?php echo $_smarty_tpl->tpl_vars['conf']->value['admin_tpl_dir'];?>
img/alert.gif' width='16' height='16' alt='<?php echo $_smarty_tpl->tpl_vars['alang']->value['informer'];?>
' style="border:0px;vertical-align:middle;" /></a>
          <?php }?>
        </div>
        </td>
        <td>&nbsp;</td>
	    <td width="30" align="center">
				<a title='Главная страница' href='admin.php'><img src='<?php echo $_smarty_tpl->tpl_vars['conf']->value['admin_tpl_dir'];?>
img/menu/main.png' width='16' height='16' alt='Главная страница' /></a>            
        </td>
	    <td width="30" align="center">
				<a title='Почта' href='javascript:void(null)' onClick="calwin = dhtmlwindow.open('OutlookBox', 'inline', '', 'Почта', 'width=790px, height=580px, left=150px, top=91px, resize=1, scrolling=1'); getdata('', 'get', '?p=outlook', 'OutlookBox_inner'); return false;"><img src='<?php echo $_smarty_tpl->tpl_vars['conf']->value['admin_tpl_dir'];?>
img/mail_icon1.gif' width='16' height='16' alt='Почта' /></a>            
        </td>
	    <td width="30" align="center">
				<a title='Календарь' href='javascript:void(null)' onClick="calwin=dhtmlwindow.open('CalendarBox', 'inline', '', 'Календарь', 'width=790px, height=580px, left=150px, top=91px, resize=1, scrolling=1'); getdata('', 'get', '?p=calendar', 'CalendarBox_inner'); return false; "><img src='<?php echo $_smarty_tpl->tpl_vars['conf']->value['admin_tpl_dir'];?>
img/calendar.gif' width='16' height='16' alt='Календарь' /></a>            
        </td>
        <td width="100">&nbsp;</td>
        <?php if (isset($_smarty_tpl->tpl_vars['langs']->value)){?>
        <td align="center" width="<?php echo $_smarty_tpl->tpl_vars['lw']->value;?>
">
        	<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['langs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
				<a href="admin.php?admin_lang=<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['wwwadres']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['tpldir']->value;?>
flags/<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
.gif" style="vertical-align:middle;" /></a>&nbsp;
    		<?php } ?>
        </td>
        <?php }?>

        
		</tr></table>
	</div>
    <div id="PageTitle">
    	<table border="0" cellspacing="0" cellpadding="0"><tr>
        <td><?php if (isset($_smarty_tpl->tpl_vars['modSet']->value)){?><a title='Конфигурация модуля' href='javascript:void(null)' onClick="modSetwin=dhtmlwindow.open('ModSetBox', 'inline', '', 'Конфигурация модуля', 'width=500px, height=500px, left=0px, top=91px, resize=1, scrolling=1'); getdata('', 'get', '?p=admin_config&amp;act=modlist&amp;mod=<?php echo $_smarty_tpl->tpl_vars['modSet']->value;?>
', 'ModSetBox_inner'); return false; "><img src='<?php echo $_smarty_tpl->tpl_vars['conf']->value['admin_tpl_dir'];?>
img/setting_icon.gif' width='19' height='19' alt='Конфигурация модуля' /></a><?php }?></td>
        <td width="10">&nbsp;</td>
    	<td><div id="aptitle"><?php echo $_smarty_tpl->tpl_vars['PAGETITLE']->value;?>
</div></td>
        </tr></table>
        <div id="ARC">
        	<div id="ART"><a href="javascript:void(null)" onclick="CloseInfo();"><strong><?php echo $_smarty_tpl->tpl_vars['alang']->value['close'];?>
</strong></a></div>
            <div id="ActionRes"></div>
        </div>
    </div>
</div>
<div id="mainContentAdmin">
	<div id="result">
		<?php echo $_smarty_tpl->tpl_vars['PAGE']->value;?>

	</div>
</div>
<br />
<?php if ($_smarty_tpl->tpl_vars['debug']->value==true){?>
<hr />
<strong>DEBUG INFO:</strong>
<div id="debug" style='border:solid 1px red; padding:3px; background:#F8F1DE;'></div>
<?php }?>
</body>
</html><?php }} ?>