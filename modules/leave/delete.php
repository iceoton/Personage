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
	case "delete_leave" : $getDatabase->my_sql_delete("leave_paper","code='".addslashes($_GET['mkey'])."'");
	break;
	
}
$getDatabase->my_sql_close();
?> 