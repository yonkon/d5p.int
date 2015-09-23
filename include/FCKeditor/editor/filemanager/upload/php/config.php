<?php 
session_start();

global $Config ;

// SECURITY: You must explicitelly enable this "uploader". 
$Config['Enabled'] = true ;

// Path to uploaded files relative to the document root.
$Config['UserFilesPath'] = $_SESSION['conf']['fck_dir'];

$Config['AllowedExtensions']['File']	= array() ;
$Config['DeniedExtensions']['File']		= array('php','php3','php5','phtml','asp','aspx','ascx','jsp','cfm','cfc','pl','bat','exe','dll','reg','cgi') ;

$Config['AllowedExtensions']['Image']	= array('jpg','gif','jpeg','png') ;
$Config['DeniedExtensions']['Image']	= array('tiff','psd') ;

$Config['AllowedExtensions']['Flash']	= array('swf','fla') ;
$Config['DeniedExtensions']['Flash']	= array() ;

?>
