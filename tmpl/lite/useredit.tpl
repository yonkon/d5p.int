            
				<h2>{$lang.uedit_title}</a></h2>

	<div id="EditArea">
        <form method="post" action="javascript:void(null)" enctype="multipart/form-data" id="EditUser">
        <strong>{$lang.reg_login}: *</strong><br />
        <input type="text" name="login" id="login" readonly="readonly" style="width:250px;" value="{$t.login}" /><br />
        <strong>{$lang.reg_pass}: *</strong><br />
        <input type="password" name="pass" id="pass" value="" style="width:250px;" /><br />
        <strong>{$lang.reg_repass}: *</strong><br />
        <input type="password" name="pass1" id="pass1" value="" style="width:250px;" /><br />
        <strong>{$lang.reg_email}: *</strong><br />
        <input type="hidden" name="email_old" id="email_old" value="{$t.email}" />
        <input type="text" name="email" id="email" value="{$t.email}" style="width:250px;" /><br />
        <strong>{$lang.reg_mphone}: *</strong><br />
        <input type="text" name="mphone" id="mphone" value="{$t.mphone}" style="width:250px;" /><br />
        <small>{$lang.reg_mphonehint}</small><br />
        <strong>{$lang.reg_fio}: *</strong><br />
        <input type="text" name="fio" id="fio" value="{$t.fio}" style="width:250px;" /><br />
        {$lang.reg_company}:<br />
        <input type="text" name="company" id="company" value="{$t.city}" style="width:250px;" /><br />
        {$lang.reg_adres}:<br />
        <textarea name="contact" id="contact" style="height:80px;width:250px;">{$t.contact}</textarea><br />
		
        {if isset($avatar)}
        <br /><img src="{$avatar}" width="{$conf.avatar_w}" alt="" /><br />
        {/if}
        <strong>{$lang.reg_avatar}:</strong><br />
		<input type="file" name="avatar" size="28" /><br /><small>{$lang.reg_avatarhint}</small><br />

	    <div id="debug1"></div>
        <input type="button" style="height:40px;width:120px;" onclick="doLoadEdData('EditUser','EditArea');" name="Send" id="Send" value="{$lang.save}" /><br />
        </form>
	</div>