<?php
session_start();
header('Content-Type: application/json');
require("../../../core/config.core.php");
require("../../../core/connect.core.php");
$getdata = new clear_db();
$connect = $getdata->my_sql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
$getdata->my_sql_set_utf8();
$array = array();
$unset = $getdata->my_sql_show_rows("card","card_type='1'");
	$row_array['label'] ='รายครั้ง';
	$row_array['y'] = intval($unset);
	array_push($array, $row_array);
$male = $getdata->my_sql_show_rows("card","card_type='2'");
	$row_array['label'] ='รายเดือน';
	$row_array['y'] = intval($male);
	array_push($array, $row_array);

echo json_encode($array);
?>
