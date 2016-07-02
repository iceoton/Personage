<?php
date_default_timezone_set('Asia/Bangkok');
//------------ in use -------------
function getMemberNumber(){
	$getdata = new clear_db();
	$getdata->my_sql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
	$number = $getdata->my_sql_query("year,member_number","autonumber",NULL);
	return $number->year.$number->member_number;
}
function updateDateNow(){
	$getdata = new clear_db();
	$getdata->my_sql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
	$getdata->my_sql_update("autonumber","year='".date("Y")."',month='".date("m")."',day='".date("d")."'",NULL);
}
function getPaidNumber(){
	$getdata = new clear_db();
	$getdata->my_sql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
	$number = $getdata->my_sql_query(NULL,"autonumber",NULL);
	return substr($number->year,2,2).$number->month.$number->day.$number->card_paid_number;
}
function getMonthNumber(){
	$getdata = new clear_db();
	$getdata->my_sql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
	$number = $getdata->my_sql_query(NULL,"autonumber",NULL);
	return $number->year.$number->month.$number->card_month_number;
}
function memberNumberUpdate(){
	$getdata = new clear_db();
	$getdata->my_sql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
	$getdata->my_sql_update("autonumber","`member_number`=`member_number`+1","1");
}
function paidNumberUpdate(){
	$getdata = new clear_db();
	$getdata->my_sql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
	$getdata->my_sql_update("autonumber","`card_paid_number`=`card_paid_number`+1","1");
}
function monthNumberUpdate(){
	$getdata = new clear_db();
	$getdata->my_sql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
	$getdata->my_sql_update("autonumber","`card_month_number`=`card_month_number`+1","1");
}

function resizeMemberThumb($imgname){
	$images = "../resource/members/images/".$imgname;
	$new_images = "../resource/members/thumbs/".$imgname;

		$width=100; //*** Fix Width & Heigh (Auto caculate) ***//
		$size=GetimageSize($images);
		$height=round($width*$size[1]/$size[0]);
		$images_orig = ImageCreateFromJPEG($images);
		$photoX = ImagesX($images_orig);
		$photoY = ImagesY($images_orig);
		$images_fin = ImageCreateTrueColor($width, $height);
  		ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
		ImageJPEG($images_fin,$new_images);
		ImageDestroy($images_fin);
}
function resizeAgentThumb($imgname){
	$images = "../resource/agents/images/".$imgname;
	$new_images = "../resource/agents/thumbs/".$imgname;

		$width=100; //*** Fix Width & Heigh (Auto caculate) ***//
		$size=GetimageSize($images);
		$height=round($width*$size[1]/$size[0]);
		$images_orig = ImageCreateFromJPEG($images);
		$photoX = ImagesX($images_orig);
		$photoY = ImagesY($images_orig);
		$images_fin = ImageCreateTrueColor($width, $height);
  		ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
		ImageJPEG($images_fin,$new_images);
		ImageDestroy($images_fin);
}
function resizeUserThumb($imgname){
	$images = "../resource/users/images/".$imgname;
	$new_images = "../resource/users/thumbs/".$imgname;

		$width=100; //*** Fix Width & Heigh (Auto caculate) ***//
		$size=GetimageSize($images);
		$height=round($width*$size[1]/$size[0]);
		$images_orig = ImageCreateFromJPEG($images);
		$photoX = ImagesX($images_orig);
		$photoY = ImagesY($images_orig);
		$images_fin = ImageCreateTrueColor($width, $height);
  		ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
		ImageJPEG($images_fin,$new_images);
		ImageDestroy($images_fin);
}
function dateConvertor($date){
	$epd = explode("-",$date);
		$Y=$epd[0]+543;
		return $epd[2]."/".$epd[1]."/".$Y;
	
}
function dateTimeConvertor($datetime){
	$epd = explode(" ",$datetime);
	$date = new DateTime($epd[0]);
	$exptime = explode(":",$epd[1]);
	$date->setTime($exptime[0],$exptime[1],$exptime[2]);
	$Y=$epd[0]+543;
	return $date->format("d/m/$Y H:i:s");
}
?>