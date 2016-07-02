<script type="text/javascript">
$(document).ready(function(){
    $("#slidingDiv").hide();
	$("#show_hide").show();
	
	$('#show_hide').click(function(){
	$("#slidingDiv").slideToggle();
	});

});
</script>
<script language="javascript">
function deleteMember(mkey){
	if(confirm("เมื่อคุณลบข้อมูลสมาชิกแล้ว บัตรสมาชิกจะถูกลบข้อมูลไปด้วย คุณต้องการจะลบสมาชิกคนนี้ไช่หรือไม่ ?")){
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	 	xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
  		if (xmlhttp.readyState==4 && xmlhttp.status==200){
		document.getElementById(mkey).innerHTML = '';
  		}
	}
	xmlhttp.open("GET","../modules/members/delete.php?mkey="+mkey+"&ttype=delete_member",true);
	xmlhttp.send();
	}
}
</script>
<?php
$photofilename=md5(time("now"));
if(isset($_POST['save'])){
	$member_key = md5(addslashes($_POST['member_code']).time("now"));
	if (!defined('UPLOADDIR')) define('UPLOADDIR','../resource/members/images/');
				if (is_uploaded_file($_FILES["member_photo"]["tmp_name"])) {	
				$File_name = $_FILES["member_photo"]["name"];
				$File_tmpname = $_FILES["member_photo"]["tmp_name"];
				$fn=md5(date("Ymd").time("now")).".jpg";
						if ($_FILES["member_photo"]["type"] == "image/jpeg"){
							if (move_uploaded_file($File_tmpname, (UPLOADDIR . "/" .$fn)));
						}else{
							echo '<script>alert("Please select JPG image only !")</script>';
				}
	}
	if(addslashes($_POST['member_name']) != NULL && addslashes($_POST['member_lastname']) != NULL){
		if($File_name != NULL){
			resizeMemberThumb($fn);
			$getdata->my_sql_insert("member","member_key='".$member_key."',member_code='".addslashes($_POST['member_code'])."',member_prefix='".addslashes($_REQUEST['member_prefix'])."',member_name='".addslashes($_POST['member_name'])."',member_lastname='".addslashes($_POST['member_lastname'])."',member_address='".addslashes($_POST['member_address'])."',member_subdistrict='".addslashes($_POST['member_subdistrict'])."',member_district='".addslashes($_POST['member_district'])."',member_province='".addslashes($_POST['member_province'])."',member_tel='".addslashes($_POST['member_phone'])."',pr_member_name='".addslashes($_POST['pr_name'])."',pr_member_tel='".addslashes($_POST['pr_phone'])."',member_photo='".$fn."',member_status='1'");
		}else if(addslashes($_POST['h_member_photo']) != NULL){
			$photo = addslashes($_POST['h_member_photo']).".jpg";
			resizeMemberThumb($photo);
			$getdata->my_sql_insert("member","member_key='".$member_key."',member_code='".addslashes($_POST['member_code'])."',member_prefix='".addslashes($_REQUEST['member_prefix'])."',member_name='".addslashes($_POST['member_name'])."',member_lastname='".addslashes($_POST['member_lastname'])."',member_address='".addslashes($_POST['member_address'])."',member_subdistrict='".addslashes($_POST['member_subdistrict'])."',member_district='".addslashes($_POST['member_district'])."',member_province='".addslashes($_POST['member_province'])."',member_tel='".addslashes($_POST['member_phone'])."',pr_member_name='".addslashes($_POST['pr_name'])."',pr_member_tel='".addslashes($_POST['pr_phone'])."',member_photo='".$photo."',member_status='1'");
		}else{
			$getdata->my_sql_insert("member","member_key='".$member_key."',member_code='".addslashes($_POST['member_code'])."',member_prefix='".addslashes($_REQUEST['member_prefix'])."',member_name='".addslashes($_POST['member_name'])."',member_lastname='".addslashes($_POST['member_lastname'])."',member_address='".addslashes($_POST['member_address'])."',member_subdistrict='".addslashes($_POST['member_subdistrict'])."',member_district='".addslashes($_POST['member_district'])."',member_province='".addslashes($_POST['member_province'])."',member_tel='".addslashes($_POST['member_phone'])."',pr_member_name='".addslashes($_POST['pr_name'])."',pr_member_tel='".addslashes($_POST['pr_phone'])."',member_status='1'");
		}
		memberNumberUpdate();
	}
}
?>
<script type="text/javascript" src="../plugins/webcam/webcam.js"></script>
<!-- Configure a few settings -->
	<script language="JavaScript">
		webcam.set_api_url( '../plugins/webcam/uploadphoto.php?file_name=<?php echo $photofilename;?>' );
		webcam.set_quality( 100 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound( true ); // play shutter click sound
	</script>

<div class="aqua_hbar"><img src="../media/icons/nav/member_2.png" width="32" height="32">ข้อมูลนักเรียน</div>
<fieldset class="field_bar" ><button class="button green"  id="show_hide" type="button"><img src="../media/icons/set/white/plus1.png" width="20" height="20">เพิ่มนักเรียน</button></fieldset>
<div id="slidingDiv">
<fieldset class="field_std3" ><legend>ข้อมูลนักเรียน</legend>
<form action="" method="post" enctype="multipart/form-data" name="form1">
<table width="100%" border="0">
  <tr>
    <td width="13%" align="right">รหัสสมาชิก</td>
    <td width="25%"><label for="member_code"></label>
      <input name="member_code" type="text" id="aqua_textfield" readonly value="<?php echo 'ST'.@getMemberNumber();?>"></td>
    <td width="13%">&nbsp;</td>
    <td width="24%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">ชื่อ</td>
    <td><label for="member_prefix"></label>
      <select name="member_prefix" autofocus id="member_prefix">
      <option value="" selected></option>
       <option value="เด็กชาย" >เด็กชาย</option>
        <option value="เด็กหญิง" >เด็กหญิง</option>
        <option value="นาย" >นาย</option>
        <option value="นาง">นาง</option>
        <option value="นางสาว">นางสาว</option>
      </select>
      <label for="member_name"></label>
      <input type="text" name="member_name" id="aqua_textfield"></td>
    <td align="right">นามสกุล</td>
    <td><input type="text" name="member_lastname" id="aqua_textfield"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">ที่อยู่</td>
    <td><label for="member_lastname">
      <textarea name="member_address" id="aqua_textarea" cols="30" rows="3"></textarea>
    </label></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td rowspan="6"><script language="JavaScript">
		document.write( webcam.get_html(250,188,250,188) );
	</script>
    <!-- Code to handle the server response (see test.php) -->
	<script language="JavaScript">
		webcam.set_hook( 'onComplete', 'my_completion_handler' );
		
		function take_snapshot() {
			// take snapshot and upload to server
			document.getElementById('h_member_photo').value = '<?php echo $photofilename;?>';
			webcam.snap();
		}
		
		function my_completion_handler(msg) {
			// extract URL out of PHP output
			if (msg.match(/(http\:\/\/\S+)/)) {
				var image_url = RegExp.$1;
				// show JPEG image in page
				document.getElementById('upload_results').innerHTML = 
					'<h1>Upload Successful!</h1>' + 
					'<h3>JPEG URL: ' + image_url + '</h3>' + 
					'<img src="' + image_url + '" width="220">';
				
				// reset camera for another shot
				webcam.reset();
			}
			//else alert("PHP Error: " + msg);
		}
	</script><div id="upload_results" style="background-color:#eee;width:220px;"></div></td>
  </tr>
  <tr>
    <td align="right">ตำบล</td>
    <td><label for="member_address">
      <input type="text" name="member_subdistrict" id="aqua_textfield">
    </label></td>
    <td align="right">อำเภอ</td>
    <td><input type="text" name="member_district" id="aqua_textfield"></td>
    </tr>
  <tr>
    <td align="right">จังหวัด</td>
    <td><input type="text" name="member_province" id="aqua_textfield"></td>
    <td align="right">หมายเลขโทรศัพท์</td>
    <td><input type="text" name="member_phone" id="aqua_textfield"></td>
    </tr>
  <tr>
    <td align="right">ชื่อ-สกุลผู้ปกครอง</td>
    <td>
      <input type="text" name="pr_name" id="aqua_textfield"></td>
    <td align="right">หมายเลขโทรศัพท์</td>
    <td>
      <input name="pr_phone" type="text" id="aqua_textfield"></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    </tr>
  <tr>
    <td align="right"></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">รูปถ่าย</td>
    <td><label for="member_photo"></label>
      <input type="file" name="member_photo" id="member_photo">
      <input type="hidden" name="h_member_photo" id="h_member_photo"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><button type="button" name="take_photo" class="button green" onClick="take_snapshot()"><img src="../media/icons/set/white/camera.png" width="20" height="20">ถ่ายรูป</button></td>
  </tr>
  <tr>
    <td colspan="5" align="center"><input type="submit" name="save" class="button green" value="บันทึก"></td>
    </tr>
</table>

</form>
</fieldset>
</div>
<div class="field_invisible">
<table width="100%" border="0" >
  <tr class="aqua_treatment_text_header">
    <td width="6%">ลำดับ</td>
    <td width="9%">รูปถ่าย</td>
    <td width="15%">รหัสสมาชิก</td>
    <td width="24%">ชื่อ-สกุล</td>
    <td width="17%">วิชาที่ลงทะเบียนเรียน</td>
    <td width="17%">รายละเอียด</td>
  </tr>
  <?php
  $i=0;
  $getdata->my_sql_set_utf8();
  $getmember = $getdata->my_sql_select(NULL,"member",NULL);
  while($showmember = mysql_fetch_object($getmember)){
	  $i++;
	  if($showmember->member_status != 1){
		  $bg = 'bgcolor="#CCCCCC"';
	  }else{
		  $bg = 'bgcolor="#8DC2FF"';
	  }
  ?>
  <tr class="aqua_treatment_text" id="<?php echo @$showmember->member_key;?>">
    <td align="center" <?php echo @$bg;?>><?php echo @$i;?></td>
    <td align="center" <?php echo @$bg;?>><img src="../resource/members/thumbs/<?php echo @$showmember->member_photo;?>" width="50"  alt="" id="photo_border"/></td>
    <td align="center" <?php echo @$bg;?>><?php echo @$showmember->member_code;?></td>
    <td <?php echo @$bg;?>>&nbsp;<?php echo $showmember->member_prefix.$showmember->member_name."&nbsp;&nbsp;&nbsp;&nbsp;".$showmember->member_lastname;?></td>
    <td align="center" <?php echo @$bg;?>><?php $getcard = $getdata->my_sql_show_rows("subject_register","member_key='".$showmember->member_key."'");echo $getcard;?></td>
    <td align="center" <?php echo @$bg;?>><a href="?p=payaqua&member_code=<?php echo @$showmember->member_code;?>"><div class="button_symbol green"><img src="../media/icons/set/white/right2.png" width="25" height="25"  alt="" title="ข้อมูลการเรียน"/></div></a><a href="?p=register_subjects&key=<?php echo @$showmember->member_key;?>"><div class="button_symbol brown"><img src="../media/icons/set/white/treatment.png" width="25" height="25"  alt="" title="ลงทะเบียนเรียน"/></div></a><a href="../modules/members/print.php?key=<?php echo $showmember->member_key;?>" target="_blank"><div class="button_symbol yellow"><img src="../media/icons/set/white/print.png" width="25" height="25"  alt="" title="พิมพ์บัตรสมาชิก"/></div></a><a href="?p=member_detail&key=<?php echo @$showmember->member_key;?>"><div class="button_symbol green"><img src="../media/icons/set/white/detail.png" width="25" height="25"  alt="" title="รายละเอียด"/></div></a>
    <div class="button_symbol red" onClick="javascript:deleteMember('<?php echo @$showmember->member_key;?>');"><img src="../media/icons/set/white/delete1.png" width="25" height="25"  alt="" title="ลบ"/></div></td>
  </tr>
  <?php
  }
  ?>
</table>
</div>