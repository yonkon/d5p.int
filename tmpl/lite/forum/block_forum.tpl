<h2>{$lang.forum}</h2>
    <div class="enterblock">
  {section name=f_loop loop=$f}
    <span class="newsdate">{$f[f_loop].MDATE|date_format:"%d.%m.%Y"}</span> &nbsp;
   	<a href="?p=forum&show=msg&t={$f[f_loop].T}&f={$f[f_loop].F}"><h4 style="display:inline;">{$f[f_loop].TNAME}</h4></a>
    <br /><br />
  {/section}
<p>&raquo;&raquo; <a href="?p=forum" class="red">{$lang.forum}</a></p>
</div>  