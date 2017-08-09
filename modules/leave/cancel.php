<?php
session_start();
// List of events
require("../../core/config.core.php");
require("../../core/connect.core.php");
require("../../core/functions.core.php");
$getDatabase = new clear_db();
$connect = $getDatabase->my_sql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
$getDatabase->my_sql_set_utf8();
$getDatabase->my_sql_update("leave_paper","status=3","code='".addslashes($_GET['mkey'])."' ");
if(addslashes($_GET['before'])=="1"){
  // del checkin
  $explode_c = explode("-",$_GET['s']);
  $i = intval($explode_c[0]);
  $j = intval($explode_c[1]);
  $k = intval($explode_c[2]);
  $explode_e = explode("-",$_GET['e']);
  $ke = intval($explode_e[2]);

  $ukey = addslashes($_GET['u']);
  while($k<=$ke){
    $d = $i."-".$j."-".$k;
    $getDatabase->my_sql_delete("checkin","user_key='".$ukey."' AND date='".$d."' AND status='LEAVE'");
    $k++;
  }
}
$getDatabase->my_sql_close();
?>