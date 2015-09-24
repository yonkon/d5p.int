<?php
if(!defined("SHIFTCMS")) exit;

          $q="SELECT * FROM ".$_conf['prefix']."advert WHERE ad_id='".mysql_real_escape_string($_REQUEST['id'])."'";
		  $r = $db -> Execute($q);
          if($r -> RecordCount() == 0){
             header("Location: /");
			 exit;
          }else{
			 $t = $r -> GetRowAssoc(false);
             $u_q="UPDATE ".$_conf['prefix']."advert SET clicks=clicks+1 WHERE ad_id='".mysql_real_escape_string($_REQUEST['id'])."'";
			 $u_r = $db -> Execute($u_q);
             header("Location:".$t['ad_link']."");
			 exit;
          }
?>
