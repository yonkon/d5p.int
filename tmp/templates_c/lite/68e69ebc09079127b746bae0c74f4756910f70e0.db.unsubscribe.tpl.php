<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 21:01:57
         compiled from "db:unsubscribe.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8692560695193cd950bde10-97758182%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '68e69ebc09079127b746bae0c74f4756910f70e0' => 
    array (
      0 => 'db:unsubscribe.tpl',
      1 => '1294575724',
      2 => 'db',
    ),
  ),
  'nocache_hash' => '8692560695193cd950bde10-97758182',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'replymsg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5193cd950e1020_01171937',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5193cd950e1020_01171937')) {function content_5193cd950e1020_01171937($_smarty_tpl) {?><br />
<?php if (isset($_smarty_tpl->tpl_vars['replymsg']->value)){?><?php echo $_smarty_tpl->tpl_vars['replymsg']->value;?>
<?php }?>
<div>
<p>Если Вы не хотите больше получать наши рассылки, введите Ваш e-mail и нажмите кнопку "Отписаться".</p><br />
<form method="post" action="index.php?p=unsubscribe">
Ваш e-mail: <input type='text' name='email' value='' size='30' maxlength='50' />
<input type=submit value='Отписаться' name='news_unsubscribe' />
</form>
</div><?php }} ?>