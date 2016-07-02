<?php
session_start();
require("../../core/config.core.php");
require("../../core/connect.core.php");
$getdata = new clear_db();
$connect = $getdata->my_sql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
$getdata->my_sql_set_utf8();
$term = $_REQUEST['term'];
//$query = "SELECT * FROM patient_informations WHERE (pat_cn LIKE '%$term%' OR pat_name LIKE '%$term%' OR pat_lastname LIKE '%$term%') LIMIT 7";
$result = $getdata->my_sql_select(NULL,"member","(member_code LIKE '%$term%' OR member_name LIKE '%$term%' OR member_lastname LIKE '%$term%') LIMIT 7");
//$result = mysql_query($query);

$array = array();


while ($data = mysql_fetch_array($result))
{
	$row_array['value'] = $data['member_code'];
	$row_array['name'] = $data['member_name']."    ".$data['member_lastname'];
	$row_array['code'] = $data['member_code'];
	$row_array['image'] = $data['member_photo'];
	array_push($array, $row_array);
}
echo json_encode($array);
?>
