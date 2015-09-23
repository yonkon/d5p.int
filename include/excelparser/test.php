<?
include_once ("include/excelparser/excelfunc.php");
include_once ("include/excelparser/excel.php");

if (!isset($_POST['step'])) $_POST['step'] = 0;

if ($_POST['step'] == 0){
?>
<h3>�������� ���� ��� ��������</h3>
<form name="exc_upload" method="post" action="admin.php?p=test" enctype="multipart/form-data">
<table border="0">
<tr><td>Excel ����:</td><td><input type="file" size=30 name="excel_file"></td></tr>
<!--<tr><td>������������ ������ ������ ��� ����� �����:</td><td><input type="checkbox" name="useheaders"></td></tr>-->
<tr><td colspan="2" align="right">
<input type="hidden" name="step" value="1">
<input type="button" value="������" onClick="
javascript: if( (document.exc_upload.excel_file.value.length==0))
{ alert('������� �� ������ ���������� ��� �����'); return; }; submit();"></td></tr>
</table>
</form>
<?
}
// ��������� excel ����� (��� 1)

if ($_POST['step'] == 1) {
	echo "<br>";
	// �������� �����
	$excel_file = $_FILES['excel_file'];
	if( $excel_file ) $excel_file = $_FILES['excel_file']['tmp_name'];
	if( $excel_file == '' ) fatal("��� ����� ��� ��������");
	move_uploaded_file( $excel_file, 'tmp/' . $_FILES['excel_file']['name']);	
	$excel_file = 'tmp/' . $_FILES['excel_file']['name'];
	$fh = @fopen ($excel_file,'rb');
	if( !$fh ) fatal("��� ����� ��� ��������");
	if( filesize($excel_file)==0 ) fatal("��� ����� ��� ��������");
	$fc = fread( $fh, filesize($excel_file) );
	@fclose($fh);
	if( strlen($fc) < filesize($excel_file) ) fatal("���������� ������� ����");	
	// �������� excel �����
	$exc = new ExcelFileParser ();
	$res = $exc->ParseFromString($fc);
	switch ($res) {
		case 0: break;
		case 1: fatal("���������� ������� ����");
		case 2: fatal("����, ������� ��������� ����� ���� ������ Excel");
		case 3: fatal("������ ������ ��������� �����");
		case 4: fatal("������ ������ �����");
		case 5: fatal("��� - �� ���� Excel ��� ����, ����������� � Excel < 5.0");
		case 6: fatal("����� ����");
		case 7: fatal("��������� ������ � Excel  �����");
		case 8: fatal("���������������� ������ �����");
		default:
			fatal("����������� ������");
	}
	// ���������� �������� �����
	$ws_number = count($exc->worksheet['name']);
	if( $ws_number < 1 ) fatal("�� ������ ������� ���� � Excel �����.");
	$ws_number = 1; // ���������, ����� ���������� ������ ������ ������� ����
	for ($ws_n = 0; $ws_n < $ws_number; $ws_n++) {
		$ws = $exc -> worksheet['data'][$ws_n]; // ��������� ������ �� �������� �����
		if ( !$exc->worksheet['unicode'][$ws_n] )
			$db_table = $ws_name = $exc -> worksheet['name'][$ws_n];
		else 	{
			$ws_name = uc2html( $exc -> worksheet['name'][$ws_n] );
			$db_table = convertUnicodeString ( $exc -> worksheet['name'][$ws_n] );
			}
		echo "<div align=\"center\">������� ����: <b>$ws_name</b>.<br />
		�������� ��� ������� ������� ����� ��������������� ���� ���� ������ �� ���������� �������.<br />
		������� ������� � ��� �����, ������� �� ����� ������������� � ����.<br />
		����� ����� ������� ������ \"�������������\".</div><br />";
		$max_row = $ws['max_row'];
		$max_col = $ws['max_col'];
		if ( $max_row > 0 && $max_col > 0 ) getTableData ( &$ws, &$exc, $excel_file ); // ��������� ��������� � ������ �������� �����
		else fatal("������ ������� ����");
		
	}
	
}

if ( $_POST['step'] == 2 ) { // ������� ������ � mysql (��� 2)
/*
echo "<pre>";
print_r($_REQUEST);
echo "</pre>";
exit;
*/
	echo "<br />";
	extract ($_POST);
	if ( !isset ($fieldcheck) ) fatal("��� ��������� �����.");
	if ( !is_array ($fieldcheck) ) fatal("��� ��������� �����.");
	$fh = @fopen ($excel_file,'rb');
	if( !$fh ) fatal("���������� ��������� ����");
	if( filesize($excel_file)==0 ) fatal("���������� ��������� ����");
	$fc = fread( $fh, filesize($excel_file) );
	@fclose($fh);
	if( strlen($fc) < filesize($excel_file) ) fatal("���������� ������� ����");		
	$exc = new ExcelFileParser;
	$res = $exc->ParseFromString($fc);
	switch ($res) {
		case 0: break;
		case 1: fatal("���������� ������� ����");
		case 2: fatal("����, ������� ��������� ����� ���� ������ Excel");
		case 3: fatal("������ ������ ��������� �����");
		case 4: fatal("������ ������ �����");
		case 5: fatal("��� - �� ���� Excel ��� ����, ����������� � Excel < 5.0");
		case 6: fatal("����� ����");
		case 7: fatal("�� ������� ������ � Excel �����");
		case 8: fatal("���������������� ������ �����");
		default:
			fatal("����������� ������");
	}
	// ���������� �������� �����
	$ws_number = count($exc->worksheet['name']);
	if( $ws_number < 1 ) fatal("��� �������� ����� � Excel �����.");
	$ws_number = 1; // �����������, ����� ���������� ������ ������ ������� ����
	for ($ws_n = 0; $ws_n < $ws_number; $ws_n++) {
		$ws = $exc -> worksheet['data'][$ws_n]; // ��������� ������ �������� �����
		$max_row = $ws['max_row'];
		$max_col = $ws['max_col'];
		if ( $max_row > 0 && $max_col > 0 )
			$res = prepareTableData ( &$exc, &$ws, $fieldcheck, $fieldname );
		else fatal("������ ������� ����");
	}
	// �������� ������ � ���� ������
	if ( empty ($err) ) {
		echo <<<SUCC
		<br><br>
		<div align="center">
		<b>�������� ������, ����������� �������.</b><br /><br />
		$nmb �����(�), ���������� � ������� "$db_table"<br />
		</div>
SUCC;
	}
	else 	echo "<br><br><font color=\"red\">$err</font><br /><br />";
	@unlink ($excel_file);
}		
		
?>