<?php
$getinfo = $getdata->my_sql_query(NULL,"user","user_key='".addslashes($_SESSION['ukey'])."'");
if(isset($_POST['save_detail'])){
	if (!defined('UPLOADDIR')) define('UPLOADDIR','../resource/users/images/');
				if (is_uploaded_file($_FILES["photo"]["tmp_name"])) {	
				$File_name = $_FILES["photo"]["name"];
				$File_tmpname = $_FILES["photo"]["tmp_name"];
				$fn=md5(date("Ymd").time("now")).".jpg";
						if ($_FILES["photo"]["type"] == "image/jpeg"){
							if (move_uploaded_file($File_tmpname, (UPLOADDIR . "/" .$fn)));
						}else{
							echo '<script>alert("Please select JPG image only !")</script>';
						}
				}
				if($File_name != NULL){
					resizeUserThumb($fn);
					$getdata->my_sql_update("user","name='".addslashes($_POST['name'])."',lastname='".addslashes($_POST['lastname'])."',email='".addslashes($_POST['email'])."',tel='".addslashes($_POST['tel'])."',photo='".$fn."'","user_key='".$getinfo->user_key."'");
				}else{
					$getdata->my_sql_update("user","name='".addslashes($_POST['name'])."',lastname='".addslashes($_POST['lastname'])."',email='".addslashes($_POST['email'])."',tel='".addslashes($_POST['tel'])."'","user_key='".$getinfo->user_key."'");
				}
				echo '<script>alert("บันทึกข้อมูล สำเร็จ !");window.location="?p=main"</script>';
}
if(isset($_POST['password_save'])){
	if($getinfo->password != md5(addslashes($_POST['old_password']))){
			$display_alert = '<div class="alert_box red"><img src="../media/icons/set/white/alert2.png" width="32" height="32">รหัสผ่านเดิมไม่ถูกต้อง !</div>';
		}else{
			if(md5(addslashes($_POST['new_password'])) != md5(addslashes($_POST['re_new_password']))){
				$display_alert = '<div class="alert_box red"><img src="../media/icons/set/white/alert2.png" width="32" height="32">รหัสผ่านไม่ตรงกัน กรุณาตรวจสอบใหม่ !</div>';
			}else{
				if(addslashes($_POST['new_password']) != NULL && addslashes($_POST['re_new_password']) != NULL){
					$getdata->my_sql_update("user","password='".md5(addslashes($_POST['new_password']))."'","user_key='".$_SESSION['ukey']."'");
					echo '<script>alert("เปลี่ยนรหัสผ่าน สำเร็จ !");window.location="../core/logout.core.php"</script>';
				}else{
					$display_alert = '<div class="alert_box red"><img src="../media/icons/set/white/alert2.png" width="32" height="32">คุณกรอกข้อมูลไม่ถูกต้องกรุณาตรวจสอบใหม่ !</div>';
				}
			}
		}
}
?>
<div class="aqua_hbar"><img src="../media/icons/icons/user_info.png" width="32" height="32">ข้อมูลส่วนตัว</div>
<div class="field_invisible">
<?php
echo @$display_alert;
?>
  <form method="post" enctype="multipart/form-data" name="form1" id="form1">
  <fieldset class="field_std3" ><legend>แก้ไขข้อมูลส่วนตัว</legend>
    <table width="100%" border="0">
      <tr>
        <td width="13%" rowspan="5" align="center"><img src="../resource/users/images/<?php echo $getinfo->photo;?>" width="100" id="photo_border" alt=""/></td>
        <td width="16%" align="right">ชื่อผู้ใช้งาน :</td>
        <td width="26%">
          <input name="username" type="text" id="aqua_textfield" readonly value="<?php echo @$getinfo->username;?>"></td>
        <td width="12%">&nbsp;</td>
        <td width="33%">&nbsp;</td>
      </tr>
      <tr>
        <td align="right">ชื่อ :</td>
        <td>
          <input type="text" name="name" id="aqua_textfield" value="<?php echo $getinfo->name;?>"></td>
        <td align="right">นามสกุล :</td>
        <td>
          <input type="text" name="lastname" id="aqua_textfield" value="<?php echo $getinfo->lastname;?>"></td>
      </tr>
      <tr>
        <td align="right">อีเมล์ :</td>
        <td>
          <input type="email" name="email" id="aqua_textfield" value="<?php echo $getinfo->email;?>"></td>
        <td align="right">โทร :</td>
        <td>
          <input type="text" name="tel" id="aqua_textfield" value="<?php echo $getinfo->tel;?>"></td>
      </tr>
      <tr>
        <td align="right">รูปถ่าย :</td>
        <td>
          <input type="file" name="photo" id="photo"></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" align="center"><input type="submit" name="save_detail" class="button green" value="บันทึก" id="save_detail"></td>
        </tr>
    </table>
  </fieldset>
<fieldset class="field_std3" ><legend>แก้ไขรหัสผ่าน</legend>
  <table width="100%" border="0">
    <tr>
      <td width="46%" align="right">รหัสผ่านเดิม :</td>
      <td width="54%">
        <input type="password" name="old_password" id="aqua_textfield"></td>
    </tr>
    <tr>
      <td align="right">รหัสผ่านใหม่ :</td>
      <td>
        <input type="password" name="new_password" id="aqua_textfield"></td>
    </tr>
    <tr>
      <td align="right">ยืนยันรหัสผ่านใหม่ อีกครั้ง :</td>
      <td>
        <input type="password" name="re_new_password" id="aqua_textfield"></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="password_save" class="button green" value="บันทึก"></td>
      </tr>
  </table>
</fieldset>
  </form>
</div>