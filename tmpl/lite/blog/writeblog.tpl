{* Форма для написания и редактирования блогов *}
{if $smarty.session.USER_IDU}
	<div style="padding:3px; border:solid 1px #ccc;margin:3px;">
    <a href="{$conf.www_patch}/?p=blog&act=myblog">Мої блоги</a> | <a href="{$conf.www_patch}?p=writeblog">Написати в блог</a>
    </div>
{/if}

{if $outblogs=="blognotfound"}
	<p>Блог не знайдено!</p>
{/if}

{if $outmsg && $outmsg=="saved"}
	<p>Ваш запис успішно збережено!</p>
{/if}

{if $outblogs=="writeform"}
	<script type="text/javascript" src="{$conf.www_patch}/js/nicedit/nicEdit.js"></script>
    <script type="text/javascript">
	{literal}
	//<![CDATA[
	bkLib.onDomLoaded(function() {
		new nicEditor({buttonList : ['fontFamily','bold','italic','underline','strikeThrough','subscript','superscript','ol','ul','forecolor','bgcolor']}).panelInstance('b_text');
		});
	//]]>
	{/literal}
	</script>
	<h2>Написати / Редагувати блог</h2>
	<form method="post" action="" id="WrBlogForm" enctype="multipart/form-data">
    <strong>Заголовок:</strong><br />
	<input type="text" name="b_title" id="b_title" value="{$blog.b_title}" maxlength="250" style="width:600px;" /><br />
	<strong>Текст:</strong><br />
	<textarea name="b_text" id="b_text" style="width:600px; height:400px;">{$blog.b_text}</textarea><br />
    <strong>Мітки:</strong><br />
	<input type="text" name="b_key" id="b_key" value="{$blog.b_key}" maxlength="250" style="width:600px;" /><br /><br />
    <input type="hidden" name="b_id" id="b_id" value="{$blog.b_id}" />
    <input type="hidden" name="b_q" id="b_q" value="{$blog.b_q}" />
    <input type="hidden" name="b_act" id="b_act" value="saveBlog" />
    <input type="submit" value="Сохранить" style="width:300px;" />
    </form>

	<br /><div style="padding:2px; border:solid 1px #ccc;">
	<h3>Завантажити фото до блогу</h3>
	<form method='post' action='javascript:void(null)' enctype='multipart/form-data' id='PagePhotoForm'>
	<input type='hidden' name='photo_type' value='blog' id='photo_type' />
	<input type='hidden' name='type_id' value='{$blog.b_id}' id='type_id' />
    <strong>Вибрати зображення</strong> (.jpg, .png, .gif)<br />
	<input type='file' name='file' id='file' size='40' /><br />
	<strong>Підпис до фото:</strong><br />
	<input type="text" name="photosign" id="photosign" style="width:270px;" value="" maxlength="255" /><br />
	<strong>Порядковий номер галереї:</strong> <input type='text' name='photo_group' id='photo_group' value='1' size='3' /> <small>число від 1 до 99</small><br />
	<br /><input type='button' value='Загрузить фото' onclick="doLoadUserPagePhoto('PagePhotoForm','PhotoMsg')" />
	</form><br />
	<div style="background:#FFC; padding:3px; border:solid 1px #FC6;"><small>Для вставки галереї в текст сторінки, вставте в потрібному місці в тексті наступний код: <input type='text' value='{literal}{GAL-1-GAL}{/literal}' size='14' style='text-align:center' onfocus="select()" /><br />Якщо вам потрібно вставити кілька галерей окремо, то в коді замість <strong>1</strong>, поставте інший номер галереї.</small></div>
	<div id='PhotoMsg'></div>
	<div id='PhotoList'>
	{foreach key=key item=item from=$photos}
		<div style="float:left; padding:2px; margin:2px;text-align:center;" id="PID{$item.photo_id}">Група:{$item.photo_group}<br />{$item.photosign}<br /><a href="{$item.subdir}{$item.photo_id}.jpg" target="_bigphoto"><img src="{$item.subdir}{$item.photo_id}_s.jpg" height="60" /></a><br /><a href="javascript:void(null)" onclick="getdata('','post','?p=site_server&act=DeleteUserPhoto&photo_id={$item.photo_id}','PhotoMsg'); delelem('PID{$item.photo_id}');">Видалити</a></div>
    {/foreach}
	</div>
	<br style="clear:both;" />
	</div><br />

	<br /><div style="padding:2px; border:solid 1px #ccc;">
	<h3>Додати відео до блогу</h3>
	<form method='post' action='javascript:void(null)' enctype='multipart/form-data' id='PageVideoForm'>
	<input type='hidden' name='video_type' value='blog' id='video_type' />
	<input type='hidden' name='type_id' value='{$blog.b_id}' id='type_id' />
	<strong>Код вставки відео:</strong><br />
	<textarea name="video_code" id="video_code" style="width:400px;height:100px;"></textarea><br />
	<strong>Підпис до відео:</strong><br />
	<input type="text" name="vsign" id="vsign" style="width:270px;" value="" maxlength="255" /><br />
	<strong>Порядковий номер відео:</strong> <input type='text' name='video_group' id='video_group' value='1' size='3' /> <small>число від 1 до 99</small><br />
	<br /><input type='button' value='Сохранить' onclick="doLoadUserPageVideo('PageVideoForm','VideoMsg')" />
	</form><br />
	<div style="background:#FFC; padding:3px; border:solid 1px #FC6;"><small>Для вставки відео в текст сторінки, вставте в потрібному місці в тексті наступний код: <input type='text' value='{literal}{VIDEO-1-VIDEO}{/literal}' size='24' style='text-align:center' onfocus="select()" /><br />Якщо вам потрібно вставити кілька відеороликів, то в коді замість <strong>1</strong>, поставте інший номер відео.</small></div>
	<div id='VideoMsg'></div>
	<div id='VideoList'>
	{foreach key=key item=item from=$videos}
		<div style="padding:2px;" id="VID{$item.video_id}">Відео:{$item.video_group}. <a href="javascript:void(null)" onclick="getdata('','post','?p=site_server&act=EditUserVideo&video_id={$item.video_id}','EDV{$item.video_id}');">{$item.video_id}: {$item.vsign}</a> | <a href="javascript:void(null)" onclick="getdata('','post','?p=site_server&act=DeleteUserVideo&video_id={$item.video_id}','VideoMsg'); delelem('VID{$item.video_id}');">Видаити</a> <div id="EDV{$item.video_id}"></div></div>
    {/foreach}
	</div>
	<br style="clear:both;" />
	</div><br />

{/if}
