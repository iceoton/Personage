<?php
session_start();
// List of events
require("../../core/config.core.php");
require("../../core/connect.core.php");
require("../../core/functions.core.php");
$getDatabase = new clear_db();
$connect = $getDatabase->my_sql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
$getDatabase->my_sql_set_utf8();

switch(mysql_real_escape_string($_GET['ttype'])){
	case "delete_user" : $getDatabase->my_sql_delete("user","user_key='".addslashes($_GET['mkey'])."'");
	break;
	case "delete_subject" : $getDatabase->my_sql_delete("subjects","subject_key='".addslashes($_GET['mkey'])."'");
	break;
	case "delete_logs" : $getDatabase->my_sql_delete("logs","log_key='".addslashes($_GET['mkey'])."'");
	break;
	case "delete_subject_use" : $getDatabase->my_sql_delete("subject_use","use_key='".addslashes($_GET['mkey'])."'");
	break;
	case "delete_subject_register" : $getDatabase->my_sql_delete("subject_register","regis_key='".addslashes($_GET['mkey'])."'");
										$getDatabase->my_sql_delete("subject_use","regis_key='".addslashes($_GET['mkey'])."'");
										$getDatabase->my_sql_delete("payment","regis_key='".addslashes($_GET['mkey'])."'");
	break;
	
}
$getDatabase->my_sql_close();
?> 