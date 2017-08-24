<?php
$getmember_detail = $getdata->my_sql_query(NULL,"member","member_key='".addslashes($_GET['key'])."'");
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
			$getdata->my_sql_update("member","member_prefix='".addslashes($_REQUEST['member_prefix'])."',member_name='".addslashes($_POST['member_name'])."',member_lastname='".addslashes($_POST['member_lastname'])."',member_address='".addslashes($_POST['member_address'])."',member_subdistrict='".addslashes($_POST['member_subdistrict'])."',member_district='".addslashes($_POST['member_district'])."',member_province='".addslashes($_POST['member_province'])."',member_tel='".addslashes($_POST['member_phone'])."',pr_member_name='".addslashes($_POST['pr_name'])."',pr_member_tel='".addslashes($_POST['pr_phone'])."',member_photo='".$fn."',member_status='".addslashes($_REQUEST['member_status'])."'","member_key='".addslashes($_GET['key'])."'");
		}else{
			$getdata->my_sql_update("member","member_prefix='".addslashes($_REQUEST['member_prefix'])."',member_name='".addslashes($_POST['member_name'])."',member_lastname='".addslashes($_POST['member_lastname'])."',member_address='".addslashes($_POST['member_address'])."',member_subdistrict='".addslashes($_POST['member_subdistrict'])."',member_district='".addslashes($_POST['member_district'])."',member_province='".addslashes($_POST['member_province'])."',member_tel='".addslashes($_POST['member_phone'])."',pr_member_name='".addslashes($_POST['pr_name'])."',pr_member_tel='".addslashes($_POST['pr_phone'])."',member_status='".addslashes($_REQUEST['member_status'])."'","member_key='".addslashes($_GET['key'])."'");
		}
		echo '<script>window.location="?p=members";</script>';
	}
}
?>
<div class="aqua_hbar"><img src="../media/icons/nav/member_2.png" width="32" height="32">รายละเอียดนักเรียน</div>
<div class="field_invisible">
<fieldset class="field_std3" >
<legend>แก้ไขข้อมูลนักเรียน</legend>
<form action="" method="post" enctype="multipart/form-data" name="form1">
  <table width="100%" border="0">
    <tr>
      <td width="25%" rowspan="7" align="center"><img src="../resource/members/images/<?php echo @$getmember_detail->member_photo;?>" width="200"  alt="" id="photo_border"/></td>
      <td width="13%" align="right">รหัสสมาชิก</td>
      <td width="25%">
        <input name="member_code" type="text" id="aqua_textfield" readonly value="<?php echo $getmember_detail->member_code;?>"></td>
      <td width="12%" align="right">&nbsp;</td>
      <td width="25%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">ชื่อ</td>
      <td>
        <select name="member_prefix" id="member_prefix">
        <?php
		$prefix = array("","เด็กชาย","เด็กหญิง","นาย","นาง","นางสาว");
		for($x=0;$x<6;$x++){
			if($getmember_detail->member_prefix == $prefix[$x]){
				echo '<option value="'.$prefix[$x].'" selected>'.$prefix[$x].'</option>';
			}else{
				echo '<option value="'.$prefix[$x].'">'.$prefix[$x].'</option>';
			}
		}
		?>
      
      </select>
        <input name="member_name" type="text" autofocus id="aqua_textfield" value="<?php echo $getmember_detail->member_name;?>"></td>
      <td align="right">สกุล</td>
      <td>
        <input type="text" name="member_lastname" id="aqua_textfield" value="<?php echo @$getmember_detail->member_lastname;?>"></td>
    </tr>
    <tr>
      <td align="right">ที่อยู่</td>
      <td>
        <textarea name="member_address" id="aqua_textarea" cols="30" rows="3"><?php echo @$getmember_detail->member_address;?></textarea></td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">ตำบล</td>
      <td>
        <input type="text" name="member_subdistrict" id="aqua_textfield" value="<?php echo @$getmember_detail->member_subdistrict;?>"></td>
      <td align="right">อำเภอ</td>
      <td>
        <input type="text" name="member_district" id="aqua_textfield" value="<?php echo @$getmember_detail->member_district;?>"></td>
    </tr>
    <tr>
      <td align="right">จังหวัด</td>
      <td>
        <input type="text" name="member_province" id="aqua_textfield" value="<?php echo @$getmember_detail->member_province;?>"></td>
      <td align="right">หมายเลขโทรศัพท์</td>
      <td>
        <input type="text" name="member_phone" id="aqua_textfield" value="<?php echo @$getmember_detail->member_tel;?>"></td>
    </tr>
    <tr>
      <td height="20" align="right">ชื่อ-สกุลผู้ปกครอง</td>
      <td>
        <input type="text" name="pr_name" id="aqua_textfield" value="<?php echo @$getmember_detail->pr_member_name;?>"></td>
      <td align="right">หมายเลขโทรศัพท์</td>
      <td>
        <input type="text" name="pr_phone" id="aqua_textfield" value="<?php echo @$getmember_detail->pr_member_tel;?>"></td>
    </tr>
    <tr>
      <td height="20" align="right">การใช้งาน</td>
      <td>
        <select name="member_status" id="member_status">
        <?php
		if($getmember_detail->member_status == 1){
			echo '<option value="0">ยกเลิกใช้งาน</option>
          <option value="1" selected="selected">เปิดใช้งาน</option>';
		}else{
			echo '<option value="0" selected="selected">ยกเลิกใช้งาน</option>
          <option value="1" >เปิดใช้งาน</option>';
		}
		?>
          
        </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
        <input type="file" name="member_photo" id="member_photo"></td>
      <td colspan="3" align="center">
          <input type="button" name="button" id="button" value="กลับ" class="button brown" onClick="window.location.href='?p=members'">
          <input type="submit" name="save" class="button green" value="บันทึก"></td>
      <td align="right">&nbsp;</td>
      </tr>
  </table>
</form>
</fieldset>
</div>