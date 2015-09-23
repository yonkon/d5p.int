<?
$PAGE = "";

if(isset($_REQUEST['act']) && $_REQUEST['act'] == "AddRecord"){
	$er = 0;
	if($_REQUEST['check_code'] != $_SESSION['check_code']){
		$PAGE .= msg_box($lang_ar['g_er1']."<br />");
		$er = 1;
	}
	if(trim($_REQUEST['g_who']) == ""){
		$PAGE .= msg_box($lang_ar['g_er2']."<br />");
		$er = 1;
	}
	if(trim($_REQUEST['g_text']) == ""){
		$PAGE .= msg_box($lang_ar['g_er3']."<br />");
		$er = 1;
	}
	if($er == 0){
		//print_r($_REQUEST);
		$q = "INSERT INTO ".$_conf['prefix']."guestbook (
		`g_date`, `g_who`, `g_text`, `g_state`, `g_show`, `g_email`
		) VALUES (
		'".time()."', 
		'".mysql_real_escape_string(strip_tags(stripslashes($_REQUEST['g_who'])))."', 
		'".mysql_real_escape_string(strip_tags(stripslashes($_REQUEST['g_text'])))."', 
		'new', 
		'".$_conf['gmcheck']."', 
		'".mysql_real_escape_string(strip_tags(stripslashes($_REQUEST['g_email'])))."'
		)";
		
		$r = $db -> Execute($q);
		$mailtosend = trim($_conf['gb_mail'] != "") ? $_conf['gb_mail'] : $_conf['sup_email'];
		if($_conf['gb_sendmail']=="y"){
			require("./include/phpmailer/class.phpmailer.php");
			$mail = new PHPMailer();
			$mail->CharSet = "WINDOWS-1251";                      // set mail encoding
			$mail->IsMail();                                      // set mailer to use Sendmail
			$mail->From = $_conf['sup_email'];
			$mail->FromName = $_conf['site_name'];
			$mail->AddAddress($mailtosend, "Гостевая книга");
			$mail->WordWrap = 50;            // set word wrap to 50 characters
			$mail->IsHTML(true);                                  // set email format to HTML
			$mail->Subject = "Новое сообщение в гостевой книге на сайте ".$_conf['site_name'];
				$message = "<strong>Новое сообщение в гостевой книге</strong><br /><strong>Автор:</strong> ".stripslashes($_REQUEST['g_who'])."<br /><strong>E-mail:</strong> ".stripslashes($_REQUEST['g_email'])."<br /><strong>Сообщение:</strong><br />".stripslashes($_REQUEST['g_text']);
				$message = str_replace("\r","",$message);
				$message = nl2br($message);
			$mail->Body = $message;
			$mail->Send();
		}
				
		if($_conf['gmcheck'] == "y") $PAGE .= msg_box($lang_ar['g_success1']);
		else $PAGE .= msg_box($lang_ar['g_success2']);
		
		unset($_REQUEST['g_who']);
		unset($_REQUEST['g_email']);
		unset($_REQUEST['g_text']);
	}
}

// ------------------------------------------------------------------------------------------

$smarty -> assign("g_who", isset($_REQUEST['g_who']) ? stripslashes(htmlspecialchars($_REQUEST['g_who'])) : "");
$smarty -> assign("g_email", isset($_REQUEST['g_email']) ? stripslashes(htmlspecialchars($_REQUEST['g_email'])) : "");
$smarty -> assign("g_text", isset($_REQUEST['g_text']) ? stripslashes(htmlspecialchars($_REQUEST['g_text'])) : "");



$gb_array=array();
$gb_items=0;
$interval=20;
if(!isset($_REQUEST['start'])) $start=0;
else $start=$_REQUEST['start'];
   $qn1="SELECT count(*) FROM ".$_conf['prefix']."guestbook WHERE g_show='y'";
   $qn="SELECT * FROM ".$_conf['prefix']."guestbook WHERE g_show='y' ORDER BY g_date DESC LIMIT $start,$interval";

	$ms1 = $db->Execute($qn1);
	$r1 = $ms1 -> GetRowAssoc(false);
	$all = $r1['count(*)'];

	$ms = $db->Execute($qn);

	$list_page=GetPaging($all,$interval,$start,"index.php?p=guestbook&start=%start1%");

	while (!$ms->EOF) { 
		$tmpm=$ms->GetRowAssoc(false);
		$gb_array[$gb_items]=array(
			'g_idn'=>$tmpm['g_id'],
			'g_date'=>$tmpm['g_date'],
			'g_who'=>htmlspecialchars(stripslashes($tmpm['g_who'])),
			'g_text'=>htmlspecialchars(stripslashes($tmpm['g_text']))
		);
		$gb_items++;
		$ms->MoveNext(); 
	}
	
	$_SESSION['check_code']=rand(1000, 9999);

		$smarty -> assign("paging",$list_page);
		$smarty -> assign("listpage",$smarty -> fetch("db:paging.tpl"));
		$smarty -> assign("act","list");
		$smarty->assign("gb",$gb_array);
//print_r($gb_array);

$PAGE .= $smarty->fetch("guestbook/guestbook.tpl");

$CURPATCH = $TITLE = $KEYWORDS = $lang_ar['guestbook'];
?>