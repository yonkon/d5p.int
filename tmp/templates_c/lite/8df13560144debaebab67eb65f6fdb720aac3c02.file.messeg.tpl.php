<?php /* Smarty version Smarty-3.1.8, created on 2013-05-02 16:45:59
         compiled from "Z:/home/5plus.off/www/tmpl/lite\messeg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1423651826e170d7591-04707543%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8df13560144debaebab67eb65f6fdb720aac3c02' => 
    array (
      0 => 'Z:/home/5plus.off/www/tmpl/lite\\messeg.tpl',
      1 => 1338370214,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1423651826e170d7591-04707543',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'info_message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_51826e17128d76_04021857',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51826e17128d76_04021857')) {function content_51826e17128d76_04021857($_smarty_tpl) {?><div id="MsgBoxInformer">
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