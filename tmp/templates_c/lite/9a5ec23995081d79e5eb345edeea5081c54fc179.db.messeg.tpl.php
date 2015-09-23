<?php /* Smarty version Smarty-3.1.8, created on 2013-05-06 11:19:39
         compiled from "db:messeg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16790192985187679bce98c0-49574438%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a5ec23995081d79e5eb345edeea5081c54fc179' => 
    array (
      0 => 'db:messeg.tpl',
      1 => '1334211582',
      2 => 'db',
    ),
  ),
  'nocache_hash' => '16790192985187679bce98c0-49574438',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'info_message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5187679bd11747_19583613',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5187679bd11747_19583613')) {function content_5187679bd11747_19583613($_smarty_tpl) {?><div id="MsgBoxInformer">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
    	<td style="padding:2px;border:dotted 1px #0047a2;color:green;background:#eeeeee;">
        	<img src="/tmpl/lite/img/info.gif" height="16" width="16" hspace="5" vspace="5" align="left" />
              <?php echo $_smarty_tpl->tpl_vars['info_message']->value;?>

        </td>
    </tr>
</table>
</div>
<?php }} ?>