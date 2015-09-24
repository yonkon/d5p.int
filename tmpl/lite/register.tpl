<h1>{$lang.reg_title}</h1><br />

	<div id="RegisterArea">
        <form method="post" action="javascript:void(null)" enctype="multipart/form-data" id="RegisterForm">

   	<table border="0" width="100%" cellspacing="0" class="OF"> 
        <tr>
        <td class="t01"><strong>{$lang.reg_login}: <span class="req">*</span></strong></td>
        <td class="t02"><input type="text" name="login" id="login" style="width:250px;" onblur="getdata('','post','?fb_act=CheckLogin&p=register&login='+this.value,'CLA')" value="" /> <span id="CLA"></span></td>
        </tr>

        <tr>
        <td class="t01"><strong>{$lang.reg_pass}: <span class="req">*</span></strong></td>
        <td class="t02"><input type="password" name="pass" id="pass" value="" style="width:250px;" /></td>
        </tr>

        <tr>
        <td class="t01"><strong>{$lang.reg_repass}: <span class="req">*</span></strong></td>
        <td class="t02"><input type="password" name="pass1" id="pass1" value="" style="width:250px;" /></td>
        </tr>

        <tr>
        <td class="t01"><strong>{$lang.reg_email}: <span class="req">*</span></strong></td>
        <td class="t02"><input type="text" name="email" id="email" onblur="getdata('','post','?fb_act=CheckEmail&p=register&email='+this.value,'CLE')" value="" style="width:250px;" /> <span id="CLE"></span></td>
        </tr>

        <tr>
        <td class="t01"><strong>{$lang.reg_mphone}: <span class="req">*</span></strong></td>
        <td class="t02"><input type="text" name="mphone" id="mphone" value="" style="width:250px;" /><br />
        <small>{$lang.reg_mphonehint}</small></td>
        </tr>

        <tr>
        <td class="t01"><strong>{$lang.reg_fio}: <span class="req">*</span></strong></td>
        <td class="t02"><input type="text" name="fio" id="fio" value="" style="width:250px;" /></td>
        </tr>

        <tr>
        <td class="t01">{$lang.reg_company}:</td>
        <td class="t02"><input type="text" name="company" id="company" value="" style="width:250px;" /></td>
        </tr>

        <tr>
        <td class="t01">{$lang.reg_adres}:</td>
        <td class="t02"><textarea name="contact" id="contact" style="height:80px;width:250px;"></textarea></td>
        </tr>

        <tr>
        <td class="t01">{$lang.reg_avatar}:</td>
		<td class="t02"><input type="file" name="avatar" size="28" /><br /><small>{$lang.reg_avatarhint}</small></td>
        </tr>

        <tr>
        <td class="t01"><strong>{$lang.reg_code}: <span class="req">*</span></strong></td>
        <td class="t02"><input type="text" name="check_code" id="check_code" value="" style="width:50px;" /> <img src="check_code.php" border="0" vspace="1" hspace="1" id="ChkCodeImg" style="vertical-align:middle;"/>
        <small><a href="javascript:void(null)" onclick="document.getElementById('ChkCodeImg').src = 'check_code.php?'+Math.random();">{$lang.reg_updcode}</a></small></td>
        </tr>
        
    </table>
    <center>
	    <div id="debug1"></div>

        <input type="button" style="height:40px; width:160px;" onclick="doLoadRegData('RegisterForm','RegisterArea');" name="Send" id="Send" value="{$lang.reg_regbuton}" /><br />
    </center>
        </form>
	</div>