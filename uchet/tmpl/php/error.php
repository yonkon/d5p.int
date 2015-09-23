<?php
foreach ($errorCodes as $key => $item) {
	if (isset($lang['errors'][$item])) {
		echo $lang['errors'][$item].'<br />';
	} else {
		echo 'Ошибка № '.$item.'<br />';
	}
}