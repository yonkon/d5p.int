<?
/**
* ����� ������ ������� �� ����
* @package ShiftCMS
* @subpackage ORDER
* @version 1.00 01.08.2009
* @author Volodymyr Demchuk
* @link http://shiftcms.net
*/

/**
* �� ������, ���� �������� ������
*/
if(!defined('SHIFTCMS')){exit;}

$st = array('1'=>'������ �� ������','2'=>'��������� ������','3'=>'������ �� ����������','4'=>'������ �� ���������','5'=>'����������� ������');

$ido = isset($_REQUEST['ido']) ? $_REQUEST['ido'] : "";
$o_thema = isset($_REQUEST['o_thema']) ? htmlspecialchars(stripslashes($_REQUEST['o_thema'])) : "";
$o_state = isset($_REQUEST['o_state'])&&$_REQUEST['o_state']!='-' ? htmlspecialchars(stripslashes($_REQUEST['o_state'])) : "";
reset($st); 
$section = '<select name="o_state" id="o_state" style="width:240px;"><option value="-"></option>';
while(list($key,$val)=each($st)){
	if($o_state==$key) $section .= '<option value="'.$key.'" selected="selected">'.$val.'</option>';
	else $section .= '<option value="'.$key.'">'.$val.'</option>';
}
$section .= '</select>';
$addpar = "ido=$ido&o_thema=$o_thema&o_state=$o_state";
$PAGE .= '<div class="block"><form method="post" action="'.$_conf['base_url'].'/?p=a_searchres" enctype="multipart/form-data" id="SOForm">
<table border="0" cellpadding="2">
	<tr><td>����� ������:<br /><input type="text" name="ido" id="ido" value="'.$ido.'" style="width:50px;" /></td></tr>
	<tr><td colspan="2">���� ������:<br /><input type="text" name="o_thema" id="o_thema" value="'.$o_thema.'" style="width:240px;" /></td></tr>
	<tr><td colspan="2">������:<br />'.$section.'</td></tr>
	<tr><td>&nbsp;<br /><input type="submit" name="poisk" id="poisk" value="�����" /></td></tr>
</table>
</form></div>';

?>