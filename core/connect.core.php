<?php
class clear_db{
	function my_sql_connect($host,$username,$password,$dbname){
		$connect= mysql_connect($host, $username, $password,true) or die(mysql_error());
     	$db=mysql_select_db($dbname,$connect) or die(mysql_error());
		return $db;
	}
	function my_sql_query($field,$table,$event){
		if($field == NULL && $event == NULL){
			$objQuery=mysql_query("SELECT * FROM ".$table);
		}else if($field == NULL){
			$objQuery=mysql_query("SELECT * FROM ".$table." WHERE ".$event);
		}else if($event == NULL){
			$objQuery=mysql_query("SELECT ".$field." FROM ".$table);
		}else {
			$objQuery=mysql_query("SELECT ".$field." FROM ".$table." WHERE ".$event);
		}
		$objShow=mysql_fetch_object($objQuery);
		return $objShow;
	}
	function my_sql_select($field,$table,$event){
		if($field == NULL && $event == NULL){
			$objQuery=mysql_query("SELECT * FROM ".$table);
		}else if($field == NULL){
			$objQuery=mysql_query("SELECT * FROM ".$table." WHERE ".$event);
		}else if($event == NULL){
			$objQuery=mysql_query("SELECT ".$field." FROM ".$table);
		}else {
			$objQuery=mysql_query("SELECT ".$field." FROM ".$table." WHERE ".$event);
		}
		return $objQuery;
	}
	function my_sql_show_rows($table,$event){
		if($event != NULL){
			$objQuery=mysql_query("SELECT * FROM ".$table." WHERE ".$event);
		}else{
			$objQuery=mysql_query("SELECT * FROM ".$table);
		}
		$objShow=mysql_num_rows($objQuery);
		return $objShow;
	}
	function my_sql_show_field($table,$event){
		if($event != NULL){
			$objQuery=mysql_query("SELECT * FROM ".$table." WHERE ".$event);
		}else{
			$objQuery=mysql_query("SELECT * FROM ".$table);
		}
		$objShow=mysql_num_field($objQuery);
		return $objShow;
	}
	function my_sql_update($table,$set,$event){
		if($event != NULL){
			return mysql_query("UPDATE ".$table." SET ".$set." WHERE ".$event);
		}else{
			return mysql_query("UPDATE ".$table." SET ".$set);
		}
	}
	function my_sql_insert($table,$set){
			return mysql_query("INSERT INTO ".$table." SET ".$set);
	}
	function my_sql_delete($table,$event){
		if($event != NULL){
			return mysql_query("DELETE FROM ".$table." WHERE ".$event);
		}else{
			return mysql_query("DELETE FROM ".$table);
		}
	}
	function my_sql_string($string){
		return mysql_query($string);
	}
	function my_sql_set_utf8(){
		$cs1 = "SET character_set_results=utf8";
		mysql_query($cs1) or die('Error query: ' . mysql_error());
		$cs2 = "SET character_set_client = utf8";
		mysql_query($cs2) or die('Error query: ' . mysql_error());
		$cs3 = "SET character_set_connection = utf8";
		mysql_query($cs3) or die('Error query: ' . mysql_error());

		mysql_query("SET NAMES utf8");
		mysql_query("SET CHARACTER SET utf8");
		mysql_query("SET collation_connection='utf8_unicode_ci'");
		mysql_query("SET character_set_results=utf8");
		mysql_query("SET character_set_client='utf8'");
		mysql_query("SET character_set_connection='utf8'");
		mysql_query("collation_connection = utf8_unicode_ci");
		mysql_query("collation_database = utf8_unicode_ci");
		mysql_query("collation_server = utf8_unicode_ci");
	}
	function my_sql_set_tis620(){
		$cs1 = "SET character_set_results=tis620";
		mysql_query($cs1) or die('Error query: ' . mysql_error());
		$cs2 = "SET character_set_client = tis620";
		mysql_query($cs2) or die('Error query: ' . mysql_error());
		$cs3 = "SET character_set_connection = tis620";
		mysql_query($cs3) or die('Error query: ' . mysql_error());

		mysql_query("SET NAMES tis620");
		mysql_query("SET CHARACTER SET tis620");
		mysql_query("SET collation_connection='tis620_thai_ci'");
		mysql_query("SET character_set_results=tis620");
		mysql_query("SET character_set_client='tis620'");
		mysql_query("SET character_set_connection='tis620'");
		mysql_query("collation_connection = tis620_thai_ci");
		mysql_query("collation_database = tis620_thai_ci");
		mysql_query("collation_server = tis620_thai_ci");
	}
	function my_sql_close(){
		return mysql_close();
	}
	function my_sql_check_date_missing($ukey,$d,$m,$y){
		$today = date("Y-m-d", gmmktime(0, 0, 0, $m, $d, $y));
		$startDay = date("Y-m-d", gmmktime(0, 0, 0, $m, '1', $y));
		$queryAllofThisUser = mysql_query("SELECT * FROM checkin WHERE user_key='".$ukey."' AND date<'".$today."' AND date>='".$startDay."' AND status<>'LEAVE' ORDER BY date ") ;

		$checkedDayArray = array();
		while($checkin = mysql_fetch_object($queryAllofThisUser)){
			$checkedDayArray[$checkin->date]= true;
		}

		$missing = array();
		$day_itr = 1;
		while($day_itr < intval($d)){
			$dateLoop = date("Y-m-d", gmmktime(0, 0, 0, $m, $day_itr, $y));
			if(!$checkedDayArray[$dateLoop]){
				// missing date
				$missing[$dateLoop] = true;
				mysql_query("INSERT INTO checkin SET user_key='".$ukey."', date='".$dateLoop."', status='ABSENCE'");
			}
			$day_itr++;
		}
		// echo '<script>alert("'.$ukey.' '.$today.' '.$startDay.'");</script>';
	}
	function my_sql_check_date_missing_all($d,$m,$y){
		$q = mysql_query("SELECT * FROM user");
		while($u = mysql_fetch_object($q)){
			$ukey=$u->user_key;
			$today = date("Y-m-d", gmmktime(0, 0, 0, $m, $d, $y));
			$startDay = date("Y-m-d", gmmktime(0, 0, 0, $m, '1', $y));
			$queryAllofThisUser = mysql_query("SELECT * FROM checkin WHERE user_key='".$ukey."' AND date<'".$today."' AND date>='".$startDay."' AND status<>'LEAVE' ORDER BY date ") ;

			$checkedDayArray = array();
			while($checkin = mysql_fetch_object($queryAllofThisUser)){
				$checkedDayArray[$checkin->date]= true;
			}

			$missing = array();
			$day_itr = 1;
			while($day_itr < intval($d)){
				$dateLoop = date("Y-m-d", gmmktime(0, 0, 0, $m, $day_itr, $y));
				if(!$checkedDayArray[$dateLoop]){
					// missing date
					$missing[$dateLoop] = true;
					mysql_query("INSERT INTO checkin SET user_key='".$ukey."', date='".$dateLoop."', status='ABSENCE'");
				}
				$day_itr++;
			}
		}
		// echo '<script>alert("'.$ukey.' '.$today.' '.$startDay.'");</script>';
	}
}
?>
