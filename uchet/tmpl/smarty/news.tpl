<h2 class="tarrow">Новости компании</h2><br />
<table border="0" cellspacing="0" cellpadding="o" class="rTab">
{section name=res_i loop=$res}
	<tr><td>
	<h4>{$res[res_i].ntitle}</h4>
    <small>{$res[res_i].date}</small><br />
    <div style="padding-bottom:10px; margin-bottom:10px; border-bottom:solid 1px #cccccc;">{$res[res_i].ntext}</div>
	</td></tr>
{/section}
</table>