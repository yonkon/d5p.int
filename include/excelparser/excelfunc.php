<?php

function print_error( $msg ){
		print <<<END
		<tr>
			<td colspan=5><font color=red><b>Ошибка: </b></font>$msg</td>
			<td><font color=red><b>Отклоненный</b></font></td>
		</tr>

END;
}

function getHeader( $exc, $data ){
		// строка
		$ind = $data['data'];
		if( $exc->sst[unicode][$ind] ) return convertUnicodeString ($exc->sst['data'][$ind]);
		else return $exc->sst['data'][$ind];
}


function convertUnicodeString( $str ){
	for( $i=0; $i<strlen($str)/2; $i++ )	{
		$no = $i*2;
		$hi = ord( $str[$no+1] );
		$lo = $str[$no];
		
		if( $hi != 0 ) continue;
		elseif( ! ctype_alnum( $lo ) ) continue;
		else $result .= $lo;
	}
	return $result;
}

function uc2html($str) {
	$ret = '';
	for( $i=0; $i<strlen($str)/2; $i++ ) {
		$charcode = ord($str[$i*2])+256*ord($str[$i*2+1]);
		$ret .= '&#'.$charcode;
	}
	return $ret;
}

function get( $exc, $data ){
	switch( $data['type'] )	{
	case 0:
		$ind = $data['data'];
		if( $exc->sst[unicode][$ind] ) return uc2html($exc->sst['data'][$ind]);
		else return $exc->sst['data'][$ind];
		// целое
	case 1:
		return (integer) $data['data'];
		// вещественное число
	case 2:
		return (float) $data['data'];
        case 3:
		return gmdate("m-d-Y",$exc->xls2tstamp($data[data]));
	default:
		return '';
	}
}

function fatal($msg = '') {
	echo '[Фатальная ошибка]';
	if( strlen($msg) > 0 ) echo ": $msg";
	echo "<br>\nВыполнение скрипта остановлено<br>\n";
	if( $f_opened) @fclose($fh);
	exit();
}


function getTableData ( $ws, $exc, $excel_file) {
	//global $excel_file;
	$enabled_fields = array(
		'0'=>' - не імпортувати - ',
		'artikul'=>'Артикул',
		'shtrihkod'=>'Штрих код',
		'name'=>'Назва',
		'dimension'=>'Одиниці виміру',
		'volume'=>'Кількість',
		'cost'=>'Ціна',
		'parametr'=>'Параметри'
	);
	reset($enabled_fields);
	$fopt = "";
	while(list($k,$v)=each($enabled_fields)){
		$fopt .= "<option value='$k'>$v</option>";
	}
	$data = $ws['cell'];
echo <<<FORM
	<form action="admin.php?p=test" method="POST" name="db_export">
	<center><input type="submit" name="submit" value="Импортировать"></center><br />
	<table border="0" cellspacing="0" class="selrow" align="center" bgcolor="#666666">
	<tr bgcolor="#f1f1f1"><td>&nbsp;</td>
FORM;
// Форма имена полей
	for ( $j = 0; $j <= $ws['max_col']; $j++ ) {
		$field = "field" . $j;
		echo <<<HEADER
		<td>
		<select name="fieldname[$j]" id="fieldname[$j]" style="width:80px;">$fopt</option>
		</td>
HEADER;
	}
	echo "</tr>";
	foreach( $data as $i => $row ) { // Выходные данные и подготовка команд SQL
		if ( $i == 0 && $_POST['useheaders'] ) continue;
		echo "<tr bgcolor=\"#ffffff\">
		<td><input type=\"checkbox\" name=\"fieldcheck[$i]\" id=\"fieldcheck[$i]\" value=\"1\" checked=\"checked\"></td>";
		for ( $j = 0; $j <= $ws['max_col']; $j++ ) {
			$cell = get ( $exc, $row[$j] );
			echo "<td>$cell</td>";
		}
		echo "</tr>";
		$i++;
	}
echo <<<FORM2
	</table><br>
	<table align="center" width="100%">
	<tr><td></td><td><input type="hidden" name="excel_file" value="$excel_file">
	<input type="hidden" name="step" value="2">
	<center><input type="submit" name="submit" value="Импортировать">
	</center></td></tr>
	</form>
	</table>
FORM2;
} 



function prepareTableData ( $exc, $ws, $fieldcheck, $fieldname ) {
	$data = $ws['cell'];
	/*
	echo "<pre>";
	print_r($fieldname);
	echo "</pre>";
	echo "<pre>";
	print_r($fieldcheck);
	echo "</pre>";
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	*/
	foreach( $data as $i => $row ) { //  Выходные данные и подготовка команд SQL
		$SQL[$i] = "";
	   if ( isset($fieldcheck[$i]) ) {
		   for ( $j = 0; $j <= $ws['max_col']; $j++ ) {
				if($fieldname[$j] != '0') 
					$SQL[$i] .= $fieldname[$j]." = ".get ($exc, $row[$j])."  ";
			}
		}
		$SQL[$i] = rtrim($SQL[$i], ',');
				echo $SQL[$i]."<br />";
		$i++;
	}
	return $SQL;	
} 

?>