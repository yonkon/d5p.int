<?php
/**
 * Восстановление пароля пользователями системы
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00
 */
if(!defined("SHIFTCMS")) exit;

  if (isset($_REQUEST['act'])&&$_REQUEST['act']=='remember'){
     $info_message='';
	 $add_error=0; 
    if ($_SESSION['check_code']!=$_REQUEST['check_code']){
	    $add_error=1;
	    $info_message = $lang_ar['rmb_er1']; 
	}else{ 
	     if (isset($_REQUEST['email'])&&trim($_REQUEST['email'])==''&&ereg(".+@.+\..+",$_REQUEST['email'])==false){
             $add_error=1;
			 $info_message .= $lang_ar['rmb_er2'].'<br/>';
         }else{
             $email=trim($_REQUEST['email']);
             $rs=$db->Execute("SELECT email,login,password FROM ".$_conf['prefix']."users WHERE email='$email'");
			 $ts = $rs -> GetRowAssoc(false);
             if ($rs->RecordCount()==0){
                 $info_message = $lang_ar['rmb_er3'];
             }else{
                 $title = $_conf['site_name'].' - '.$lang_ar['rmb_title'];
                 $mess = $lang_ar['rmb_msg1'].' <br />'.date("d.m.Y (H:i)").'<br />
	             <br /><b>Login:</b> '.$ts['login'].'
	             <br /><b>Password:</b> '.$ts['password']."<br /><br />";
                 SendEmail(0, $_conf['sup_email'], $_conf['site_name'], 0, $ts['email'], $ts['login'], $title, $mess);                 
				 //SendEmail($from_idu, $from_email, $from_name, $to_idu, $to_email, $to_name, $subject, $message)
		 		$info_message = $lang_ar['rmb_msg2']; 
             }
        }
	}
	$smarty->assign('info_message',$info_message);
	$smarty->assign("message",$smarty->fetch("messeg.tpl"));	 	    
  }

  if (!isset($_REQUEST['act'])||isset($_REQUEST['act'])&&$add_error==1){
     $_SESSION['check_code']=rand(1000, 9999);
     $smarty->assign('form','form');
  }

  $smarty->assign('ttitle',array('rem_email'=>$lang_ar['rmb_email'],'kod'=>$lang_ar['rmb_code'],'remember_submit'=>$lang_ar['rmb_send']));
  $PAGE = $smarty->fetch('remember.tpl');
  $CURPATCH = $TITLE = $lang_ar['rmb_title'];
?>