<?php /* Smarty version Smarty-3.1.8, created on 2013-05-03 13:18:56
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/messeg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:109834391051838f1015d277-10686611%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '335ca38479adacbdd373d55d6c66c84b89a3d688' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/messeg.tpl',
      1 => 1367507256,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '109834391051838f1015d277-10686611',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'info_message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_51838f1017f5f7_29442743',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51838f1017f5f7_29442743')) {function content_51838f1017f5f7_29442743($_smarty_tpl) {?><div id="MsgBoxInformer">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
    	<td style="padding:2px;border:dotted 1px #0047a2;color:green;background:#eeeeee;">
        	<img src="/tmpl/lite/img/info.gif" height="16" width="16" hspace="5" vspace="5" align="left" />
            &nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['info_message']->value;?>

        </td>
    </tr>
</table>
</div>
<?php }} ?>