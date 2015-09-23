<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 18:52:46
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/messeg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12973311815193af4e1c8443-12023359%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '69eb69ce119a54371209fbf9c8d93dca63ef2712' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/messeg.tpl',
      1 => 1368626833,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12973311815193af4e1c8443-12023359',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'info_message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5193af4e1ded62_95232757',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5193af4e1ded62_95232757')) {function content_5193af4e1ded62_95232757($_smarty_tpl) {?><div id="MsgBoxInformer">
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