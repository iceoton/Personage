<?php
session_start();
// List of events
require("../../core/config.core.php");
require("../../core/connect.core.php");
require("../../core/functions.core.php");
$getDatabase = new clear_db();
$connect = $getDatabase->my_sql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
$getDatabase->my_sql_set_utf8();
$getDatabase->my_sql_update("leave_paper","status=3","user_key='".addslashes($_GET['mkey'])."' ");
$getDatabase->my_sql_close();
?> 