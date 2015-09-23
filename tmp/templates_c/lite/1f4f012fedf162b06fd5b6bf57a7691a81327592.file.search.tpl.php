<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 13:18:39
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/search.tpl" */ ?>
<?php /*%%SmartyHeaderCode:176727620519360ff764173-32958577%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f4f012fedf162b06fd5b6bf57a7691a81327592' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/search.tpl',
      1 => 1367507257,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '176727620519360ff764173-32958577',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'warn' => 0,
    'pagelist' => 0,
    'found' => 0,
    'key' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_519360ff884e31_18264933',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_519360ff884e31_18264933')) {function content_519360ff884e31_18264933($_smarty_tpl) {?>

<div id="search">
	<?php if (isset($_smarty_tpl->tpl_vars['warn']->value)){?><strong>По Вашему запросту ничего найти не удалось. Попробуйте изменить параметры поиска</strong><?php }?>
	
    <?php if (isset($_smarty_tpl->tpl_vars['pagelist']->value)&&count($_smarty_tpl->tpl_vars['pagelist']->value)>0){?>
    <div class="catpagelist">
	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['name'] = 'pl_loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['pagelist']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['total']);
?>
	    <?php if ($_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['type']=="number"){?><a href="<?php echo $_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['number'];?>
</a><?php }?>
	    <?php if ($_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['type']=="back"){?><a href="<?php echo $_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['link'];?>
">&laquo;</a><?php }?>
	    <?php if ($_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['type']=="forward"){?><a href="<?php echo $_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['link'];?>
">&raquo;</a><?php }?>
	    <?php if ($_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['type']=="current"){?><span><?php echo $_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['number'];?>
</span><?php }?>
	<?php endfor; endif; ?>
    </div>
    <?php }?>
    
    <?php if (isset($_smarty_tpl->tpl_vars['found']->value)&&count($_smarty_tpl->tpl_vars['found']->value)>0){?>
    <table border="0" cellspacing="3">
	<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['found']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
        <tr>
        <td valign="top"><?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
.</td>
        <td valign="top"><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['slink'];?>
"><strong><?php echo $_smarty_tpl->tpl_vars['item']->value['stitle'];?>
</strong></a><br /><small><?php echo $_smarty_tpl->tpl_vars['item']->value['stext'];?>
</small></td>
        </tr>
    <?php } ?>
	</table>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['pagelist']->value)&&count($_smarty_tpl->tpl_vars['pagelist']->value)>0){?>
    <div class="catpagelist">
	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['name'] = 'pl_loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['pagelist']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pl_loop']['total']);
?>
	    <?php if ($_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['type']=="number"){?><a href="<?php echo $_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['number'];?>
</a><?php }?>
	    <?php if ($_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['type']=="back"){?><a href="<?php echo $_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['link'];?>
">&laquo;</a><?php }?>
	    <?php if ($_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['type']=="forward"){?><a href="<?php echo $_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['link'];?>
">&raquo;</a><?php }?>
	    <?php if ($_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['type']=="current"){?><span><?php echo $_smarty_tpl->tpl_vars['pagelist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pl_loop']['index']]['number'];?>
</span><?php }?>
	<?php endfor; endif; ?>
    </div>
    <?php }?>

</div><?php }} ?>