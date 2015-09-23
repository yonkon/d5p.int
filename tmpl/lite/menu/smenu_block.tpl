<table border="0" cellspacing="0" class="smenu"><tr>
{section name=smenu loop=$subInfo}
   <td class="{if $subInfo[smenu].sel=="y"}tdsel{/if}{if $subInfo[smenu].sel=="y" && !$smarty.section.smenu.last} sel-right{/if}{if $subInfo[smenu].sel!="y" && !$smarty.section.smenu.last && $subInfo[smenu.index_next].sel!="y"} td-next{/if}{if $subInfo[smenu].sel!="y" && !$smarty.section.smenu.last && $subInfo[smenu.index_next].sel=="y"} tdsel-next{/if}">
   <a href="{$subInfo[smenu].link}" title="{$subInfo[smenu].linktitle}"{if $subInfo[smenu].sel=="y"} class="msel"{/if}>
   {$subInfo[smenu].linkname}
   </a>
   </td>
{/section}
</tr></table>

{*
<table border="0" cellspacing="0" class="smenu"><tr>
{foreach key=key item=item from=$subInfo name=smenu}
   <td class="{if $item.sel=="y"}tdsel{/if}{if $item.sel=="y" && !$smarty.foreach.smenu.last} sel-right{/if}{if $item.sel!="y" && !$smarty.foreach.smenu.last} td-next{/if}">
   <a href="{$item.link}" title="{$item.linktitle}"{if $item.sel=="y"} class="msel"{/if}>{$item.linkname}</a>
   </td>
{/foreach}
</tr></table>
*}