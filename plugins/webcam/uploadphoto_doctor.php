<?php

/* JPEGCam Test Script */
/* Receives JPEG webcam submission and saves to local file. */
/* Make sure your directory has permission to write files as your web server user! */
require("../../core/functions.core.php");
$filename = addslashes($_GET['file_name']). '.jpg';
$result = file_put_contents( $filename, file_get_contents('php://input') );
if (!$result) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}
$dstfile = '../../resource/customers/'.addslashes($_GET['clinic_key']).'/doctor/'.$filename;
copy($filename, $dstfile);
unlink($filename);
ResizeThumbDoctor($filename,addslashes($_GET['clinic_key']));
//$url = '../resource/customers/'.addslashes($_GET['clinic_key']).'/patients/'.$filename;

?>
