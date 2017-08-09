<?php
date_default_timezone_set('Asia/Bangkok');
ini_set('display_errors', 'on');
function sql_todate($d){
    return (new DateTime($d))->format("d/m/Y");
}
function php_toSqlDate($d){
    return (new DateTime($d))->format("Y-m-d");
}
$photofilename = md5(time("now"));
// $startDay = date("Y-m-")."01";
$getdata->my_sql_check_date_missing($_SESSION['ukey'], date('d'), date('m'), date('Y'));
if (isset($_POST['save'])) {
    $hphoto = $_POST['h_user_photo'];
    //echo '<script>alert($("#haveSnap").val());</script>';
    date_default_timezone_set('Asia/Bangkok');

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
    $fixed_time = date("08:00:00");
    $start_time = date("05:00:00");
    $current_date = date('Y-m-d');
    $current_time = date('H:i:s');
    if($current_time <= $fixed_time && $current_time >= $start_time){
        $status = 'NORMAL';
    }else{
        $status = 'LATE';
    }
    //upload
    if ($File_name != NULL) {
        resizeUserThumb($fn);
        $getdata->my_sql_insert("checkin","time='".$current_time."', date='".$current_date."', user_key='".$_SESSION['ukey']."', status='".$status."', photo='".$fn."'");
    }else if(addslashes($hphoto) != NULL){
        $photo = addslashes($hphoto) . ".jpg";
        resizeUserThumb($photo);
        $getdata->my_sql_insert("checkin","time='".$current_time."', date='".$current_date."', user_key='".$_SESSION['ukey']."', status='".$status."', photo='".$photo."'");
    }else{
        //$getdata->my_sql_insert("checkin","time='".$current_time."', date='".$current_date."', user_key='".$_SESSION['ukey']."', status='".$status."'");\
        echo '<script>alert("กรุณาถ่ายรูปก่อน!");</script>';
    }
    
header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
exit;
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
    <!-- <div id="local"></div> -->
    <div id="server" style="text-align: center;"></div>
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
                    <?php $haveCheckAlready = $getdata->my_sql_show_rows("checkin","user_key='".$_SESSION['ukey']."' AND date='".(date('Y-m-d'))."'");  
                        echo $haveCheckAlready>0? 'วันนี้คุณได้ทำการลงชื่อเข้างานเรียบร้อยแล้ว<br/>':'';
                    ?>
                    <button type="button" name="take_photo" class="button green" onClick="take_snapshot();" 
                    <?php echo $haveCheckAlready>0? 'disabled':''; ?>>
                        <img src="../media/icons/set/white/camera.png" width="20" height="20">ถ่ายรูป
                    </button>
                    <input type="submit" name="save" class="button green" value="บันทึก"
                    <?php echo $haveCheckAlready>0? 'disabled':''; ?>>
                </td>
            </tr>
        </table>

    </form>
</fieldset>
<script type="text/javascript">

var xmlHttp;
function srvTime(){
    try {
        //FF, Opera, Safari, Chrome
        xmlHttp = new XMLHttpRequest();
    }
    catch (err1) {
        //IE
        try {
            xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
        }
        catch (err2) {
            try {
                xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
            }
            catch (eerr3) {
                //AJAX not supported, use CPU time.
                alert("AJAX not supported");
            }
        }
    }
    xmlHttp.open('HEAD',window.location.href.toString(),false);
    xmlHttp.setRequestHeader("Content-Type", "text/html");
    xmlHttp.send('');
    return xmlHttp.getResponseHeader("Date");
}
function timenow(){
    var now= new Date(srvTime()),
    ampm= 'am',
    h= now.getHours(),
    m= now.getMinutes(),
    s= now.getSeconds();
    if(h>= 12){
        if(h>12) h -= 12;
        ampm= 'pm';
    }

    if(m<10) m= '0'+m;
    if(s<10) s= '0'+s;
    return now.toLocaleDateString()+ ' ' + h + ':' + m + ' ' + ampm;
}

function timenow_refDb(){
    var now= new Date(srvTime()),
    h= now.getHours(),
    m= now.getMinutes(),
    s= now.getSeconds();

    if(m<10) m= '0'+m;
    if(s<10) s= '0'+s;
    return h + ':' + m + ':' + s;
}

function Datenow_refDb(){
    var now= new Date(srvTime()),
    day= now.getDate(),
    month=now.getMonth()+1,
    year=now.getFullYear();
    return  year+'-'+month+'-'+day;
}

$(document).ready(function(){
    $('#server').html("ขณะนี้เวลา  " + timenow(srvTime()));
    setInterval(function(){
        // var localTime = new Date();
        //   $('#local').html("Local machine time is: " + localTime + "<br>");
          $('#server').html("ขณะนี้เวลา  " + timenow(srvTime()));
    }, 6000);
});
</script>

<div class="field_bar">
<table width="100%" border="0">
  <tr class="aqua_treatment_text_header">
    <td width="6%">ลำดับ</td>
    <td width="9%">รูปถ่าย</td>
    <td width="15%">เวลา</td>
    <td width="24%">วันที่</td>
    <td width="17%">สถานะ</td>
  </tr>
  <?php
  $i=0;
  $getdata->my_sql_set_utf8();
  $this_m = date("Y-m", gmmktime(0, 0, 0, date('m'), date('d'), date('Y')));
  $getcheckin_thisuser = mysql_query("SELECT u.user_key AS ukey, ck.photo AS photo, ck.time AS time, ck.date AS date, ck.status AS status ".
    "FROM checkin AS ck, user AS u WHERE ck.user_key=u.user_key AND u.user_key='".$_SESSION['ukey']."' AND date like '".$this_m."%' ORDER BY date DESC");
  while($show_checkin = mysql_fetch_object($getcheckin_thisuser)){
        $i++;
        // $bg = 'bgcolor="#CCCCCC"';
        // $bg = 'bgcolor="#8DC2FF"';
  ?>
  <tr class="aqua_treatment_text" id="<?php echo @$show_checkin->ukey;?>">
    <td align="center" bgcolor="#9be2ff"><?php echo @$i;?></td>
    <td align="center" bgcolor="#9be2ff"><img src="../resource/signing/images/<?php echo @$show_checkin->photo <> ''? @$show_checkin->photo:'noimg.jpg' ;?>" width="50"  alt="" id="photo_border"/></td>
    <td align="center" bgcolor="#9be2ff"><?php echo @$show_checkin->time;?></td>
    <td align="center" bgcolor="#9be2ff"><?php echo sql_todate(@$show_checkin->date); ?></td>
    <td align="center" bgcolor="#9be2ff"><?php echo @$show_checkin->status;?></td>
  </tr>
  <?php
    }
  ?>
</table>
</div>
<!-- <button id="btnExport" onclick="exportData();"> EXPORT </button>
<script type="text/javascript" src="../js/table-export.js"></script>
<script type="text/javascript" charset="utf-8">
function exportData(){
    $.fn.tableExport.xls = {
        defaultClass: "xls",
        buttonContent: "Export to xls",
        separator: "\t",
        mimeType: "application/vnd.ms-excel;charset=utf-8",
        fileExtension: ".xls"
    };
    $.fn.tableExport.charset = "charset=utf-8";
    var blob = $("#headerTable").tableExport({formats:['xls']});
}
</script> -->