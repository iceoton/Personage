<?php
session_start();
date_default_timezone_set('Asia/Bangkok');
ini_set('display_errors', 'off');
require("config.core.php");
require("connect.core.php");
require("functions.core.php");
require("logs.core.php");
$loginclass = new clear_db();
$connect = $loginclass->my_sql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
	$check=$loginclass->my_sql_show_rows('user','username="'.addslashes($_POST['username']).'" AND user_status="1"');
	if($check == 0){
		echo "<script>window.location=\"../index.php?c=nouser\"</script>";
	}else{
		$info=$loginclass->my_sql_select(NULL,'user','username="'.addslashes($_POST['username']).'"');
		while($getinfo=mysql_fetch_object($info)){
			$getpassword = md5(addslashes($_POST['password']));
			if($getinfo->password != $getpassword){
				echo "<script>window.location=\"../index.php?c=nouser\"</script>";
			}else{
				$_SESSION['uname'] = $getinfo->username;
				$_SESSION['thumb'] = $getinfo->photo;
				$_SESSION['ukey'] = $getinfo->user_key;
				$_SESSION['uclass'] = $getinfo->user_class;
				insertLogs($getinfo->username." เข้าสู่ระบบ.",$_SERVER['REMOTE_ADDR'],$getinfo->user_key);
				if($getinfo->user_status==1){
					echo "<script>window.location=\"../panel/\"</script>";
				}
			}
		}
	}
$loginclass->my_sql_close();
?>
