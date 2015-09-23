<?php /* Smarty version Smarty-3.1.8, created on 2013-05-19 16:42:29
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/register.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19962033205198d6c58de057-15903656%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dbe8b6795fae9a8549d872d732132c8e7873fe60' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/tmpl/lite/register.tpl',
      1 => 1368626834,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19962033205198d6c58de057-15903656',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5198d6c5933890_95433839',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5198d6c5933890_95433839')) {function content_5198d6c5933890_95433839($_smarty_tpl) {?><h1><?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_title'];?>
</h1><br />

	<div id="RegisterArea">
        <form method="post" action="javascript:void(null)" enctype="multipart/form-data" id="RegisterForm">

   	<table border="0" width="100%" cellspacing="0" class="OF"> 
        <tr>
        <td class="t01"><strong><?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_login'];?>
: <span class="req">*</span></strong></td>
        <td class="t02"><input type="text" name="login" id="login" style="width:250px;" onblur="getdata('','post','?fb_act=CheckLogin&p=register&login='+this.value,'CLA')" value="" /> <span id="CLA"></span></td>
        </tr>

        <tr>
        <td class="t01"><strong><?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_pass'];?>
: <span class="req">*</span></strong></td>
        <td class="t02"><input type="password" name="pass" id="pass" value="" style="width:250px;" /></td>
        </tr>

        <tr>
        <td class="t01"><strong><?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_repass'];?>
: <span class="req">*</span></strong></td>
        <td class="t02"><input type="password" name="pass1" id="pass1" value="" style="width:250px;" /></td>
        </tr>

        <tr>
        <td class="t01"><strong><?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_email'];?>
: <span class="req">*</span></strong></td>
        <td class="t02"><input type="text" name="email" id="email" onblur="getdata('','post','?fb_act=CheckEmail&p=register&email='+this.value,'CLE')" value="" style="width:250px;" /> <span id="CLE"></span></td>
        </tr>

        <tr>
        <td class="t01"><strong><?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_mphone'];?>
: <span class="req">*</span></strong></td>
        <td class="t02"><input type="text" name="mphone" id="mphone" value="" style="width:250px;" /><br />
        <small><?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_mphonehint'];?>
</small></td>
        </tr>

        <tr>
        <td class="t01"><strong><?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_fio'];?>
: <span class="req">*</span></strong></td>
        <td class="t02"><input type="text" name="fio" id="fio" value="" style="width:250px;" /></td>
        </tr>

        <tr>
        <td class="t01"><?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_company'];?>
:</td>
        <td class="t02"><input type="text" name="company" id="company" value="" style="width:250px;" /></td>
        </tr>

        <tr>
        <td class="t01"><?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_adres'];?>
:</td>
        <td class="t02"><textarea name="contact" id="contact" style="height:80px;width:250px;"></textarea></td>
        </tr>

        <tr>
        <td class="t01"><?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_avatar'];?>
:</td>
		<td class="t02"><input type="file" name="avatar" size="28" /><br /><small><?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_avatarhint'];?>
</small></td>
        </tr>

        <tr>
        <td class="t01"><strong><?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_code'];?>
: <span class="req">*</span></strong></td>
        <td class="t02"><input type="text" name="check_code" id="check_code" value="" style="width:50px;" /> <img src="check_code.php" border="0" vspace="1" hspace="1" id="ChkCodeImg" style="vertical-align:middle;"/>
        <small><a href="javascript:void(null)" onclick="document.getElementById('ChkCodeImg').src = 'check_code.php?'+Math.random();"><?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_updcode'];?>
</a></small></td>
        </tr>
        
    </table>
    <center>
	    <div id="debug1"></div>

        <input type="button" style="height:40px; width:160px;" onclick="doLoadRegData('RegisterForm','RegisterArea');" name="Send" id="Send" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['reg_regbuton'];?>
" /><br />
    </center>
        </form>
	</div><?php }} ?>