<?php
session_start();
// List of events
require("../../core/config.core.php");
require("../../core/connect.core.php");
require("../../core/functions.core.php");
$getvoting = new clear_db();
$connect = $getvoting->my_sql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
$getvoting->my_sql_set_utf8();

switch(mysql_real_escape_string($_GET['ttype'])){
	case "delete_member" : $getcard = $getvoting->my_sql_select("card_key","card","member_key='".addslashes($_GET['mkey'])."'");
							while($showcard = mysql_fetch_object($getcard)){
								$gettransfer = $getvoting->my_sql_select(NULL,"aqua_transfer","card_key='".$showcard->card_key."'");
								while($showtransfer = mysql_fetch_object($gettransfer)){
										$getvoting->my_sql_delete("aqua_agent","transfer_key='".$showtransfer->transfer_key."'");
										$getvoting->my_sql_delete("aqua_transfer","transfer_key='".$showtransfer->transfer_key."'");
									
								}
								$getvoting->my_sql_delete("card","card_key='".$showcard->card_key."'");
							}
							$getvoting->my_sql_delete("member","member_key='".addslashes($_GET['mkey'])."'");
	break;
	case "delete_subject" : $getvoting->my_sql_delete("subjects","subject_key='".addslashes($_GET['mkey'])."'");
	break;
	case "delete_logs" : $getvoting->my_sql_delete("logs","log_key='".addslashes($_GET['mkey'])."'");
	break;
	case "delete_subject_use" : $getvoting->my_sql_delete("subject_use","use_key='".addslashes($_GET['mkey'])."'");
	break;
	case "delete_subject_register" : $getvoting->my_sql_delete("subject_register","regis_key='".addslashes($_GET['mkey'])."'");
										$getvoting->my_sql_delete("subject_use","regis_key='".addslashes($_GET['mkey'])."'");
										$getvoting->my_sql_delete("payment","regis_key='".addslashes($_GET['mkey'])."'");
	break;
	
}
$getvoting->my_sql_close();
?> 