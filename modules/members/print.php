<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Student - ออกบัตรสมาชิก</title>
</head>
<?php
session_start();
require("../../core/config.core.php");
require("../../core/connect.core.php");
require("../../core/functions.core.php");
$getdata = new clear_db();
$connect = $getdata->my_sql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
$getdata->my_sql_set_utf8();
$card_detail = $getdata->my_sql_query(NULL,"member","member_key='".addslashes($_GET['key'])."'");
?>
<style type="text/css">
.card_box{
	border:2px solid #999;
	padding:5px;	
	font-family:Helvetica, Arial, sans-serif;
	font-size:12px;
	font-weight:bold;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}
#card_photo{
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}
.box_border{
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	padding:3px;
	border:1px solid #666;
	background:#CCC;
}
.text_staff{
	font-size:10px;
	color:#999;
}
</style>
<body onLoad="javascript:window.print();">
<table width="380" border="0" align="center" class="card_box">
  <tr>
    <td width="94" rowspan="5" align="center" valign="top"><img src="../../resource/members/images/<?php echo $card_detail->member_photo;?>" height="90" id="card_photo"  alt=""/></td>
    <td height="26" colspan="2" align="right"><span class="box_border">รหัสสมาชิก&nbsp;:&nbsp;<?php echo @$card_detail->member_code;?>&nbsp;</span></td>
  </tr>
  <tr>
    <td width="97" align="right">ชื่อ&nbsp;:</td>
    <td width="171" align="left">&nbsp;<?php echo @$card_detail->member_prefix.$card_detail->member_name;?></td>
  </tr>
  <tr>
    <td align="right">นามสกุล&nbsp;:</td>
    <td align="left">&nbsp;<?php echo @$card_detail->member_lastname;?></td>
  </tr>
  <tr>
    <td align="right">โทร.&nbsp;:</td>
    <td align="left">&nbsp;<?php echo @$card_detail->member_tel; ?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="94" align="center" valign="top">&nbsp;</td>
    <td height="52" colspan="2" rowspan="3" align="right"><iframe width="180" height="50" align="right" frameborder="0" scrolling="no" src="../../plugins/barcode/barcode.php?codetype=Code128&size=40&text=<?php echo @$card_detail->member_code;?>"></iframe></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>