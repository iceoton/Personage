<?php
date_default_timezone_set('Asia/Bangkok');
ini_set('display_errors', 'on');

$photofilename = md5(time("now"));
if (isset($_POST['save'])) {
    $user_key = md5(addslashes($_POST['name']) . addslashes($_POST['lastname']) . time("now"));
    if (!defined('UPLOADDIR')) define('UPLOADDIR', '../resource/signing/images/');
    if (is_uploaded_file($_FILES["photo"]["tmp_name"])) {
        $File_name = $_FILES["photo"]["name"];
        $File_tmpname = $_FILES["photo"]["tmp_name"];
        $fn = md5(date("Ymd") . time("now")) . ".jpg";
        if ($_FILES["photo"]["type"] == "image/jpeg") {
            if (move_uploaded_file($File_tmpname, (UPLOADDIR . "/" . $fn))) ;
        } else {
            echo '<script>alert("Please select JPG image only !")</script>';
        }
    }
    $checkuser = $getdata->my_sql_show_rows("user", "username='" . addslashes($_POST['username']) . "'");
    if ($checkuser == 0) {
        if (addslashes($_POST['password']) == addslashes($_POST['renew_password']) && addslashes($_POST['password']) != NULL) {
            $password = md5(addslashes($_POST['password']));
            if ($File_name != NULL) {
                resizeUserThumb($fn);
                $getdata->my_sql_insert("user", "user_key='" . $user_key . "',name='" . addslashes($_POST['name']) . "',lastname='" . addslashes($_POST['lastname']) . "',username='" . addslashes($_POST['username']) . "',password='" . $password . "',email='" . addslashes($_POST['email']) . "',tel='" . addslashes($_POST['tel']) . "',position='" . addslashes($_POST['position']) . "',department='" . addslashes($_POST['department']) . "',photo='" . $fn . "',user_class='" . addslashes($_REQUEST['user_class']) . "',user_status='" . addslashes($_REQUEST['user_status']) . "'");
            } else if (addslashes($_POST['h_user_photo']) != NULL) {
                $photo = addslashes($_POST['h_user_photo']) . ".jpg";
                resizeUserThumb($photo);
                $getdata->my_sql_insert("user", "user_key='" . $user_key . "',name='" . addslashes($_POST['name']) . "',lastname='" . addslashes($_POST['lastname']) . "',username='" . addslashes($_POST['username']) . "',password='" . $password . "',email='" . addslashes($_POST['email']) . "',tel='" . addslashes($_POST['tel']) . "',position='" . addslashes($_POST['position']) . "',department='" . addslashes($_POST['department']) . "',photo='" . $photo . "',user_class='" . addslashes($_REQUEST['user_class']) . "',user_status='" . addslashes($_REQUEST['user_status']) . "'");
            } else {
                $getdata->my_sql_insert("user", "user_key='" . $user_key . "',name='" . addslashes($_POST['name']) . "',lastname='" . addslashes($_POST['lastname']) . "',username='" . addslashes($_POST['username']) . "',password='" . $password . "',email='" . addslashes($_POST['email']) . "',tel='" . addslashes($_POST['tel']) . "',position='" . addslashes($_POST['position']) . "',department='" . addslashes($_POST['department']) . "',user_class='" . addslashes($_REQUEST['user_class']) . "',user_status='" . addslashes($_REQUEST['user_status']) . "'");
            }
        } else {
            //password
            $display_alert = '<div class="alert_box red"><img src="../media/icons/set/white/alert2.png" width="32" height="32">รหัสผ่านไม่ตรงกัน !</div>';
        }

    } else {
        //nouser
        $display_alert = '<div class="alert_box red"><img src="../media/icons/set/white/alert2.png" width="32" height="32">ชื่อผู้ใช้งานนี้ไม่พร้อมใช้งาน !</div>';
    }
}
?>
<script type="text/javascript" src="../plugins/webcam/webcam.js"></script>
<!-- Configure a few settings -->
<script language="JavaScript">
    webcam.set_api_url('../plugins/webcam/uploadphoto_timestamp.php?file_name=<?php echo $photofilename;?>');
    webcam.set_quality(100); // JPEG quality (1 - 100)
    webcam.set_shutter_sound(true); // play shutter click sound
</script>
<div class="aqua_hbar"><img src="../media/icons/icons/payaqua.png" width="32" height="32">ลงชื่อเข้างาน</div>
<fieldset class="field_std">
    <legend>ถ่ายรูปเข้างาน/ออกงาน</legend>
    <form action="" method="post" enctype="multipart/form-data" name="form1">
        <table width="100%" border="0">
            <tr>
                <td colspan="2" align="center">
                    <script language="JavaScript">
                        document.write(webcam.get_html(250, 188, 250, 188));
                    </script>
                    <!-- Code to handle the server response (see test.php) -->
                    <script language="JavaScript">
                        webcam.set_hook('onComplete', 'my_completion_handler');

                        function take_snapshot() {
                            // take snapshot and upload to server
                            document.getElementById('h_user_photo').value = '<?php echo $photofilename;?>';
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
                    </script>
                    <div id="upload_results" style="background-color:#eee;width:220px;"></div>
                    <input type="hidden" name="h_user_photo" id="h_user_photo">
                </td>
            </tr>
            <tr >
                <td colspan="2" align="center">
                    <button type="button" name="take_photo" class="button green" onClick="take_snapshot()">
                        <img src="../media/icons/set/white/camera.png" width="20" height="20">ถ่ายรูป
                    </button>
                    <input type="submit" name="save" class="button green" value="บันทึก">
                </td>
            </tr>
        </table>

    </form>
</fieldset>