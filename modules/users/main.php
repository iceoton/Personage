<?php
if ($_SESSION['uclass'] != 2) {
    // ถ้าไม่ใช่ admin
    echo '<script>window.location="?p=settings"</script>';
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#slidingDiv").hide();
        $("#show_hide").show();

        $('#show_hide').click(function () {
            $("#slidingDiv").slideToggle();
        });

    });
</script>
<script language="javascript">
    function deleteUser(mkey) {
        if (confirm("เมื่อคุณลบผู้ใช้งานแล้ว บันทึกทั้งหมดจะถูกลบไปด้วย คุณต้องการจะลบไช่หรือไม่ ?")) {
            if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {// code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById(mkey).innerHTML = '';
                }
            }
            xmlhttp.open("GET", "../modules/users/delete.php?mkey=" + mkey + "&ttype=delete_user", true);
            xmlhttp.send();
        }
    }
</script>
<?php
$photofilename = md5(time("now"));
if (isset($_POST['save'])) {
    $user_key = md5(addslashes($_POST['name']) . addslashes($_POST['lastname']) . time("now"));
    if (!defined('UPLOADDIR')) define('UPLOADDIR', '../resource/users/images/');
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
    webcam.set_api_url('../plugins/webcam/uploadphoto_user.php?file_name=<?php echo $photofilename;?>');
    webcam.set_quality(100); // JPEG quality (1 - 100)
    webcam.set_shutter_sound(true); // play shutter click sound
</script>

<div class="aqua_hbar"><img src="../media/icons/icons/users.png" width="32" height="32">รายชื่อผู้ใช้งาน</div>
<?php
echo @$display_alert;
?>
<fieldset class="field_bar">
    <button class="button green" id="show_hide" type="button">
        <img src="../media/icons/set/white/plus1.png" width="20" height="20">เพิ่มผู้ใช้งานระบบ
    </button>
</fieldset>
<div id="slidingDiv">
    <fieldset class="field_std3">
        <legend>ข้อมูลผู้ใช้งาน</legend>
        <form action="" method="post" enctype="multipart/form-data" name="form1">
            <table width="100%" border="0">
                <tr>
                    <td width="20%" align="right">ชื่อ</td>
                    <td width="27%">
                        <input type="text" name="name" id="aqua_textfield"></td>
                    <td width="18%">นามสกุล</td>
                    <td width="35%"><input type="text" name="lastname" id="aqua_textfield"></td>
                </tr>
                <tr>
                    <td align="right">ชื่อผู้ใช้งาน</td>
                    <td>
                        <input type="text" name="username" id="aqua_textfield"></td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">รหัสผ่าน</td>
                    <td>
                        <input type="password" name="password" id="aqua_textfield"></td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">ยืนยันรหัสผ่าน</td>
                    <td>
                        <input type="password" name="renew_password" id="aqua_textfield"></td>
                    <td align="right">&nbsp;</td>
                    <td rowspan="6">
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
                    </td>
                </tr>
                <tr>
                    <td align="right">อีเมล์</td>
                    <td>
                        <input type="email" name="email" id="aqua_textfield"></td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">หมายเลขโทรศัพท์</td>
                    <td>
                        <input type="text" name="tel" id="aqua_textfield"></td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">ตำแหน่ง</td>
                    <td>
                        <input type="text" name="position" id="aqua_textfield"></td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">แผนกงาน</td>
                    <td>
                        <input type="text" name="department" id="aqua_textfield"></td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">กลุ่มผู้ใช้งาน</td>
                    <td>
                        <select name="user_class" id="user_class">
                            <option value="1" selected="selected">บุคลากร</option>
                            <option value="0">ผู้บริหาร</option>
                            <option value="2">ผู้ดูแลระบบ</option>
                        </select></td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">สถานะผู้ใช้งาน</td>
                    <td>
                        <select name="user_status" id="user_status">
                            <option value="0">ไม่สามารถใช้งานได้</option>
                            <option value="1" selected="selected">สามารถใช้งานได้</option>
                        </select></td>
                    <td align="right">รูปถ่าย</td>
                    <td><label for="photo"></label>
                        <input type="file" name="photo" id="photo">
                        <input type="hidden" name="h_user_photo" id="h_user_photo"></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td>&nbsp;</td>
                    <td>
                        <button type="button" name="take_photo" class="button green" onClick="take_snapshot()"><img
                                src="../media/icons/set/white/camera.png" width="20" height="20">ถ่ายรูป
                        </button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="center"><input type="submit" name="save" class="button green" value="บันทึก">
                    </td>
                </tr>
            </table>

        </form>
    </fieldset>
</div>

<div class="field_bar">
    <table width="100%" border="0">
        <tr class="aqua_treatment_text_header">
            <td width="7%">ลำดับ</td>
            <td width="10%">รูปถ่าย</td>
            <td width="16%">ชื่อผู้ใช้งาน</td>
            <td width="30%" align="left">ชื่อ-สกุล</td>
            <td width="19%">กลุ่มผู้ใช้งาน</td>
            <td width="18%">จัดการ</td>
        </tr>
        <?php
        $i = 0;
        $getdata->my_sql_set_utf8();
        $getUser = $getdata->my_sql_select(NULL, "user", NULL);
        while ($showUser = mysql_fetch_object($getUser)) {
            $i++;
            if ($showUser->user_status != 1) {
                $bg = 'bgcolor="#CCCCCC"';
            } else {
                $bg = 'bgcolor="#9be2ff"';
            }
            ?>
            <tr class="aqua_treatment_text" id="<?php echo @$showUser->user_key; ?>">
                <td align="center" <?php echo @$bg; ?>><?php echo @$i; ?></td>
                <td align="center" <?php echo @$bg; ?>><img
                        src="../resource/users/thumbs/<?php echo @$showUser->photo; ?>" width="50" alt=""
                        id="photo_border"/></td>
                <td align="center" <?php echo @$bg; ?>><?php echo @$showUser->username; ?></td>
                <td <?php echo @$bg; ?>>
                    &nbsp;<?php echo $showUser->name . "&nbsp;&nbsp;&nbsp;&nbsp;" . $showUser->lastname; ?></td>
                <td align="center" <?php echo @$bg; ?>>
                    <?php
                    if (@$showUser->user_class == 0) {
                        echo 'ผู้บริหาร';
                    } else if (@$showUser->user_class == 2) {
                        echo 'ผู้ดูแลระบบ';
                    } else {
                        echo 'บุคลากร';
                    }
                    ?>
                </td>
                <td align="center" <?php echo @$bg; ?>>
                    <a href="?p=user_detail&key=<?php echo @$showUser->user_key; ?>">
                        <div class="button_symbol green">
                            <img src="../media/icons/set/white/detail.png" width="25" height="25" alt=""
                                 title="รายละเอียด"/>
                        </div>
                    </a>
                    <a onClick="javascript:deleteUser('<?php echo @$showUser->user_key; ?>');">
                        <div class="button_symbol green">
                            <img src="../media/icons/set/white/delete1.png" width="25" height="25" alt=""
                                 title="ลบข้อมูล"/>
                        </div>
                    </a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>