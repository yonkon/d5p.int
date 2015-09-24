<?
include_once ("include/excelparser/excelfunc.php");
include_once ("include/excelparser/excel.php");

if (!isset($_POST['step'])) $_POST['step'] = 0;

if ($_POST['step'] == 0){
?>
<h3>Виберите файл для загрузки</h3>
<form name="exc_upload" method="post" action="admin.php?p=test" enctype="multipart/form-data">
<table border="0">
<tr><td>Excel файл:</td><td><input type="file" size=30 name="excel_file"></td></tr>
<!--<tr><td>Использовать первую строку как имена полей:</td><td><input type="checkbox" name="useheaders"></td></tr>-->
<tr><td colspan="2" align="right">
<input type="hidden" name="step" value="1">
<input type="button" value="Дальше" onClick="
javascript: if( (document.exc_upload.excel_file.value.length==0))
{ alert('Сначала Вы должны определить имя файла'); return; }; submit();"></td></tr>
</table>
</form>
<?
}
// Обработка excel файла (шаг 1)

if ($_POST['step'] == 1) {
	echo "<br>";
	// Загрузка файла
	$excel_file = $_FILES['excel_file'];
	if( $excel_file ) $excel_file = $_FILES['excel_file']['tmp_name'];
	if( $excel_file == '' ) fatal("Нет файла для загрузки");
	move_uploaded_file( $excel_file, 'tmp/' . $_FILES['excel_file']['name']);	
	$excel_file = 'tmp/' . $_FILES['excel_file']['name'];
	$fh = @fopen ($excel_file,'rb');
	if( !$fh ) fatal("Нет файла для загрузки");
	if( filesize($excel_file)==0 ) fatal("Нет файла для загрузки");
	$fc = fread( $fh, filesize($excel_file) );
	@fclose($fh);
	if( strlen($fc) < filesize($excel_file) ) fatal("Невозможно считать файл");	
	// Проверка excel файла
	$exc = new ExcelFileParser ();
	$res = $exc->ParseFromString($fc);
	switch ($res) {
		case 0: break;
		case 1: fatal("Невозможно открыть файл");
		case 2: fatal("Файл, слишком маленький чтобы быть файлом Excel");
		case 3: fatal("Ошибка чтения заголовка файла");
		case 4: fatal("Ошибка чтения файла");
		case 5: fatal("Это - не файл Excel или файл, сохраненный в Excel < 5.0");
		case 6: fatal("Битый файл");
		case 7: fatal("Ненайдены данные в Excel  файле");
		case 8: fatal("Нероддерживаемая версия файла");
		default:
			fatal("Неизвестная ошибка");
	}
	// Обрабортка рабочего листа
	$ws_number = count($exc->worksheet['name']);
	if( $ws_number < 1 ) fatal("Не найден рабочий лист в Excel файле.");
	$ws_number = 1; // Установка, чтобы обработать только первый рабочий лист
	for ($ws_n = 0; $ws_n < $ws_number; $ws_n++) {
		$ws = $exc -> worksheet['data'][$ws_n]; // Получение данных из рабочего листа
		if ( !$exc->worksheet['unicode'][$ws_n] )
			$db_table = $ws_name = $exc -> worksheet['name'][$ws_n];
		else 	{
			$ws_name = uc2html( $exc -> worksheet['name'][$ws_n] );
			$db_table = convertUnicodeString ( $exc -> worksheet['name'][$ws_n] );
			}
		echo "<div align=\"center\">Рабочий лист: <b>$ws_name</b>.<br />
		Выберите для каждого столбца листа соответствующее поле базы данных из выпадающих списков.<br />
		Снимите галочки с тех строк, которые не нужно импортировать в базу.<br />
		После этого нажмите кнопку \"Импортировать\".</div><br />";
		$max_row = $ws['max_row'];
		$max_col = $ws['max_col'];
		if ( $max_row > 0 && $max_col > 0 ) getTableData ( &$ws, &$exc, $excel_file ); // Получение структуры и данных рабочего листа
		else fatal("Пустой рабочий лист");
		
	}
	
}

if ( $_POST['step'] == 2 ) { // вставка данных в mysql (шаг 2)
/*
echo "<pre>";
print_r($_REQUEST);
echo "</pre>";
exit;
*/
	echo "<br />";
	extract ($_POST);
	if ( !isset ($fieldcheck) ) fatal("Нет выбранных полей.");
	if ( !is_array ($fieldcheck) ) fatal("Нет выбранных полей.");
	$fh = @fopen ($excel_file,'rb');
	if( !$fh ) fatal("Невозможно загрузить файл");
	if( filesize($excel_file)==0 ) fatal("Невозможно загрузить файл");
	$fc = fread( $fh, filesize($excel_file) );
	@fclose($fh);
	if( strlen($fc) < filesize($excel_file) ) fatal("Невозможно считать файл");		
	$exc = new ExcelFileParser;
	$res = $exc->ParseFromString($fc);
	switch ($res) {
		case 0: break;
		case 1: fatal("Невозможно открыть файл");
		case 2: fatal("Файл, слишком маленький чтобы быть файлом Excel");
		case 3: fatal("Ошибка чтения заголовка файла");
		case 4: fatal("Ошибка чтения файла");
		case 5: fatal("Это - не файл Excel или файл, сохраненный в Excel < 5.0");
		case 6: fatal("Битый файл");
		case 7: fatal("Не найдены данные в Excel файле");
		case 8: fatal("Неподдерживаемая версия файла");
		default:
			fatal("Неизвестная ошибка");
	}
	// Подготовка рабочего листа
	$ws_number = count($exc->worksheet['name']);
	if( $ws_number < 1 ) fatal("Нет рабочего листа в Excel файле.");
	$ws_number = 1; // Установлено, чтобы обработать только первый рабочий лист
	for ($ws_n = 0; $ws_n < $ws_number; $ws_n++) {
		$ws = $exc -> worksheet['data'][$ws_n]; // Получение данных рабочего листа
		$max_row = $ws['max_row'];
		$max_col = $ws['max_col'];
		if ( $max_row > 0 && $max_col > 0 )
			$res = prepareTableData ( &$exc, &$ws, $fieldcheck, $fieldname );
		else fatal("Пустой рабочий лист");
	}
	// Выходные данные в базу данных
	if ( empty ($err) ) {
		echo <<<SUCC
		<br><br>
		<div align="center">
		<b>Операции Вывода, обработанны успешно.</b><br /><br />
		$nmb строк(и), вставленны в таблицу "$db_table"<br />
		</div>
SUCC;
	}
	else 	echo "<br><br><font color=\"red\">$err</font><br /><br />";
	@unlink ($excel_file);
}		
		
?>