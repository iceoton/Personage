<script type="text/javascript" src="../plugins/webcam/webcam.js"></script>
<!-- Configure a few settings -->
<script language="JavaScript">
    webcam.set_api_url('../plugins/webcam/uploadphoto_user.php?file_name=<?php echo $photofilename;?>');
    webcam.set_quality(100); // JPEG quality (1 - 100)
    webcam.set_shutter_sound(true); // play shutter click sound
</script>
<div class="aqua_hbar"><img src="../media/icons/nav/member_2.png" width="32" height="32">รายละเอียดผู้ใช้งาน</div>

<?php
if (isset($_POST['save_edit'])) {
    $user_key = addslashes($_POST['user_key']);
    if (addslashes($_POST['name']) != NULL && addslashes($_POST['lastname']) != NULL) {
        if (addslashes($_POST['h_user_photo']) != NULL) {
            resizeMemberThumb($fn);
            $getdata->my_sql_update("user", "name='" . addslashes($_POST['name']) . "',lastname='" . addslashes($_POST['lastname']) . "',username='" . addslashes($_POST['username']) . "',email='" . addslashes($_POST['email']) . "',tel='" . addslashes($_POST['tel']) . "',position='" . addslashes($_POST['position']) . "',department='" . addslashes($_POST['department']) . "',photo='" . $fn . "',user_class='" . addslashes($_REQUEST['user_class']) . "',user_status='" . addslashes($_REQUEST['user_status']) . "'", "user_key='$user_key'");
        } else {
            $getdata->my_sql_update("user", "name='" . addslashes($_POST['name']) . "',lastname='" . addslashes($_POST['lastname']) . "',username='" . addslashes($_POST['username']) . "',email='" . addslashes($_POST['email']) . "',tel='" . addslashes($_POST['tel']) . "',position='" . addslashes($_POST['position']) . "',department='" . addslashes($_POST['department']) . "',user_class='" . addslashes($_REQUEST['user_class']) . "',user_status='" . addslashes($_REQUEST['user_status']) . "'", "user_key='" . $user_key . "'");
        }
        //echo '<script>window.location="?p=users";</script>';
        echo '<div id="success_alert"><img src="../media/icons/set/white/info.png" width="16" height="16"> บันทึกข้อมูลเรียบร้อยแล้ว</div>';
    }
}
?>
<?php
$getUserDetail = $getdata->my_sql_query(NULL, "user", "user_key='" . addslashes($_GET['key']) . "'");
?>
<div class="field_invisible">
    <fieldset class="field_std3">
        <legend>ข้อมูลผู้ใช้งาน</legend>
        <form action="" method="post" enctype="multipart/form-data" name="form1">
            <table width="100%" border="0">
                <tr>
                    <td width="20%" align="right">ชื่อ</td>
                    <td width="27%">
                        <input type="text" name="name" id="aqua_textfield" value="<?php echo $getUserDetail->name; ?>">
                    </td>
                    <td width="18%">นามสกุล</td>
                    <td width="35%"><input type="text" name="lastname" id="aqua_textfield"
                                           value="<?php echo $getUserDetail->lastname; ?>"></td>
                </tr>
                <tr>
                    <td align="right">ชื่อผู้ใช้งาน</td>
                    <td>
                        <input type="text" name="username" id="aqua_textfield" readonly
                               value="<?php echo $getUserDetail->username; ?>"></td>
                    <td align="right">&nbsp;</td>
                    <td rowspan="6">
                        <img src="../resource/users/images/<?php echo $getUserDetail->photo ?>" width="200" alt=""
                             id="photo_border"/>
                    </td>
                </tr>
                <tr>
                    <td align="right">อีเมล์</td>
                    <td>
                        <input type="email" name="email" id="aqua_textfield"
                               value="<?php echo $getUserDetail->email; ?>"></td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">หมายเลขโทรศัพท์</td>
                    <td>
                        <input type="text" name="tel" id="aqua_textfield" value="<?php echo $getUserDetail->tel; ?>">
                    </td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">ตำแหน่ง</td>
                    <td>
                        <input type="text" name="position" id="aqua_textfield"
                               value="<?php echo $getUserDetail->position; ?>"></td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">แผนกงาน</td>
                    <td>
                        <input type="text" name="department" id="aqua_textfield"
                               value="<?php echo $getUserDetail->department; ?>"></td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">กลุ่มผู้ใช้งาน</td>
                    <td>
                        <select name="user_class" id="user_class">
                            <option value="1" <?php if ($getUserDetail->user_class == 1) {
                                echo "selected=\"selected\"";
                            } ?>>บุคลากร
                            </option>
                            <option value="0" <?php if ($getUserDetail->user_class == 0) {
                                echo "selected=\"selected\"";
                            } ?>>ผู้บริหาร
                            </option>
                            <option value="2" <?php if ($getUserDetail->user_class == 2) {
                                echo "selected=\"selected\"";
                            } ?>>ผู้ดูแลระบบ
                            </option>
                        </select></td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">สถานะผู้ใช้งาน</td>
                    <td>
                        <select name="user_status" id="user_status">
                            <option value="0" <?php if ($getUserDetail->user_status == 0) {
                                echo "selected=\"selected\"";
                            } ?>>
                                ไม่สามารถใช้งานได้
                            </option>
                            <option value="1" <?php if ($getUserDetail->user_status == 1) {
                                echo "selected=\"selected\"";
                            } ?>>
                                สามารถใช้งานได้
                            </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <input type="hidden" name="user_key" id="user_key" value="<?php echo @addslashes($_GET['key']); ?>">
                    <td colspan="4" align="center">
                        <input type="button" name="button" id="button" value="กลับ" class="button orenge"
                               onClick="window.location.href='?p=users'">
                        <input type="submit" name="save_edit" class="button green" value="บันทึก">
                    </td>
                </tr>
            </table>

        </form>
    </fieldset>
</div>