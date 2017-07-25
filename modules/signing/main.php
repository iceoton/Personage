<?php
date_default_timezone_set('Asia/Bangkok');
ini_set('display_errors', 'on');

$photofilename = md5(time("now"));
?>
<script type="text/javascript" src="../plugins/webcam/webcam.js"></script>
<!-- Configure a few settings -->
<script language="JavaScript">
    webcam.set_api_url('../plugins/webcam/uploadphoto_user.php?file_name=<?php echo $photofilename;?>');
    webcam.set_quality(100); // JPEG quality (1 - 100)
    webcam.set_shutter_sound(true); // play shutter click sound
</script>
<div class="aqua_hbar"><img src="../media/icons/icons/payaqua.png" width="32" height="32">ลงชื่อเข้างาน</div>
<fieldset class="field_std">
    <legend>ถ่ายรูปเพื่อลงชื่อเข้าใช้งาน</legend>
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
                </td>
            </tr>
            <tr >
                <td colspan="2" align="center">
                    <button type="button" name="take_photo" class="button green" onClick="take_snapshot()"><img
                                src="../media/icons/set/white/camera.png" width="20" height="20">ถ่ายรูป
                    </button>
                    <input type="submit" name="save" class="button green" value="บันทึก">
                </td>
            </tr>
        </table>

    </form>
</fieldset>