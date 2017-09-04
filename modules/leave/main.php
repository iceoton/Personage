<?php
function sql_todate($d){
    return (new DateTime($d))->format("d/m/Y");
}

?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#slidingDiv").hide();
        $("#show_hide").show();

        $('#show_hide').click(function () {
            $("#slidingDiv").slideToggle();
        });

        //
        $("#slidingSearch").hide();
        $("#search_leave").show();

        $('#search_leave').click(function () {
            $("#slidingSearch").slideToggle();
        });

    });
</script>
<script src="../js/ui/jquery.ui.datepicker.js"></script>
<script src="../js/ui/i18n/jquery.ui.datepicker-th.js"></script>
<script>
  $( function() {
    $( "#start_date" ).datepicker({
        dateFormat:"dd-mm-yy"
    });
    $( "#end_date").datepicker({
        dateFormat:"dd-mm-yy"
    });

    $( "#search_create_date").datepicker({
        dateFormat:"dd-mm-yy"
    });
    $( "#search_between_date").datepicker({
        dateFormat:"dd-mm-yy"
    });

    $('#label_file_doctor_approve, #input_file_doctor_approve').hide();

    // auto calculate amount day
    $('#start_date, #end_date').on("change", function(){
        if($('#start_date').val().length > 0 && $('#end_date').val().length > 0){
            var s = ($('#start_date').val()).split("-");
            var e = ($('#end_date').val()).split("-");
            console.log(s + ' ' + e);
            var date1 = new Date(parseInt(s[2]),parseInt(s[1]-1),parseInt(s[0]));
            var date2 = new Date(parseInt(e[2]),parseInt(e[1]-1),parseInt(e[0]));
            if(date2.getTime() - date1.getTime() >= 0){
                var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                console.log(diffDays);
                $('#amount_day_placeholder').val(diffDays);
                if(diffDays>=3){
                    $('#label_file_doctor_approve, #input_file_doctor_approve').show();
                }else {
                    $('#label_file_doctor_approve, #input_file_doctor_approve').hide();
                }
            }else {
                $('#start_date, #end_date, #amount_day_placeholder').val("");
            }
        }
    });
  } );
  </script>
<script language="javascript">
    function deleteLeave(mkey) {
        if (confirm("เมื่อคุณลบการลาแล้ว จะย้อนกลับไปแก้ไขไม่ได้ คุณต้องการจะลบไช่หรือไม่ ?")) {
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
            xmlhttp.open("GET", "../modules/leave/delete.php?mkey=" + mkey + "&ttype=delete_leave", true);
            xmlhttp.send();
        }
        window.location.href=window.location.href;
    }
    function cancelLeave(mkey, old_s, ukey,s,e){
        if(confirm("เมื่อคุณยกเลิกการลาแล้ว จะย้อนกลับไปแก้ไขไม่ได้ คุณต้องการจะยกเลิกไช่หรือไม่ ?")){
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
            xmlhttp.open("GET", "../modules/leave/cancel.php?mkey=" + mkey+"&before="+old_s+"&u="+ukey+"&s="+s+"&e="+e, true);
            xmlhttp.send();
        }
        window.location.href=window.location.href;
    }
</script>
<?php
function upload_file_pdf($fileUploaded){
    $target_dir = "../resource/leave/";
    $target_file = $target_dir . basename($fileUploaded["name"]);
    $uploadOk = 1;
    $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if file already exists
    if (file_exists($target_file)) {
        echo '<script>alert("มีการแนบไฟล์นี้ในระบบแล้ว กรุณาเปลี่ยนชื่อไฟล์ หรือเลือกไฟล์อื่น")</script>';
        $uploadOk = 0;
    }
    // Check file size
    if ($fileUploaded["size"] > 5000000) {
        echo '<script>alert("ขนาดไฟล์ใหญ่เกินไป")</script>';
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($fileType != "pdf" ) {
        echo '<script>alert("ไฟล์ต้องเป็นรูปแบบ pdf เท่านั้น")</script>';
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo '<script>alert("ระบบผิดพลาด ไม่สามารถอัพโหลดไฟล์")</script>';
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($fileUploaded["tmp_name"], $target_file)) {
            echo '<script>alert("ไฟล์ "'.basename( $fileUploaded["name"]).'" ถูกอัพโหลดแล้ว")</script>';
            $uploadOk=1;
        } else {
            echo '<script>alert("ไม่สามารถอัพโหลดไฟล์")</script>';
            $uploadOk=0;
        }
    }
    if($uploadOk==1){
        return $fileUploaded["name"];
    }else {
        return '';
    }
}

if (isset($_POST['save'])) {


    $start_d = explode("-",$_POST['start_date']);
    $end_d = explode("-",$_POST['end_date']);
    $now = explode("-",date("d-m-Y"));

    $s = gmmktime(0, 0, 0,$start_d[1],$start_d[0],$start_d[2]);
    $e = gmmktime(0, 0, 0,$end_d[1],$end_d[0],$end_d[2]);
    $n = gmmktime(0, 0, 0,$now[1],$now[0],$now[2]);

    if($s > $e){
        echo '<script>alert("วันเริ่มลาต้องไม่มากกว่าวันสุดท้ายที่ลา");</script>';
    }else if($n > $s || $n > $e){
        echo '<script>alert("ไม่สามารถลาย้อนหลังได้");</script>';
    }else {
        $type = addslashes($_POST['type']);
        $note = addslashes($_POST['note']);
        $start = date("Y-m-d", $s);
        $end = date("Y-m-d", $e);
        $amount = addslashes($_POST['amount_day']);
        // $getdata->my_sql_insert("leave_paper"
        //     ,"code='".addslashes(md5(time("now")))."'"
        //     .",user_key='".addslashes($_SESSION['ukey'])."'"
        //     .",type='".$type."'"
        //     .",note='".$note."'"
        //     .",start_date='".$start."'"
        //     .",end_date='".$end."'"
        //     .",amount_day=".$amount.""
        //     .",status='0'");



        // upload doctor approve file
        if(strlen($_FILES['file_doctor_approve']['name'])<=0 && intval($amount) >= 3 ){
            echo '<script>alert("เพิ่มการลาผิดพลาด เนื่องจากไม่พบไฟล์ที่อัพโหลด");</script>';
        }
        else if($_FILES['file_doctor_approve']['name'] && intval($amount) >= 3 ) {
            $upres = upload_file_pdf($_FILES['file_doctor_approve']);
            if(strlen($upres) > 0){
                $strq = "INSERT INTO `leave_paper` (`code`, `user_key`, `type`, `note`, `start_date`, `end_date`, `amount_day`, `status`, `create_date`, `file_doctor_approve`) VALUES (".
                "'".(md5(time("now")))."'"
                .",'".($_SESSION['ukey'])."'"
                .",'".$type."'"
                .",'".$note."'"
                .",'".$start."'"
                .",'".$end."'"
                .",'".$amount."'"
                .",'0'"
                .",'".date("Y-m-d H:i:s")."'"
                .",'".$upres."')";
                $res = mysql_query($strq);
                if($res){
                        echo '<script>alert("เพิ่มการลาสำเร็จ");</script>';
                }else {
                    echo '<script>alert("เพิ่มการลาผิดพลาด");</script>';
                }
            }else{
                echo '<script>alert("เพิ่มการลาผิดพลาด เนื่องจากอัพโหลดไฟล์ไม่สำเร็จ");</script>';
            }
        }else{
            $strq = "INSERT INTO `leave_paper` (`code`, `user_key`, `type`, `note`, `start_date`, `end_date`, `amount_day`, `status`, `create_date`) VALUES (".
            "'".(md5(time("now")))."'"
            .",'".($_SESSION['ukey'])."'"
            .",'".$type."'"
            .",'".$note."'"
            .",'".$start."'"
            .",'".$end."'"
            .",'".$amount."'"
            .",'0'"
            .",'".date("Y-m-d H:i:s")."')";
            $res = mysql_query($strq);
            if($res){
                    echo '<script>alert("เพิ่มการลาสำเร็จ");</script>';
            }else {
                echo '<script>alert("เพิ่มการลาผิดพลาด");</script>';
            }
        }



    }
    // echo $strq;
    echo '<script>window.location.href=window.location.href;</script>';
}
?>


<div class="aqua_hbar"><img src="../media/icons/icons/users.png" width="32" height="32">การลา</div>
<?php
echo @$display_alert;
?>
<fieldset class="field_bar">
    <button class="button green" id="show_hide" type="button" style="height: 35px;">
        <img src="../media/icons/set/white/plus1.png" width="20" height="20">เพิ่มการลา
    </button>
    <button class="button green" id="search_leave" type="button" style="height: 35px;">
        <img src="../media/icons/set/white/search.png" width="20" height="20">ค้นหาการลา
    </button>
</fieldset>
<div id="slidingSearch" class="slidingDiv">
    <fieldset class="field_std3">
        <legend>ค้นหาการลา</legend>
        <form action="" method="post" enctype="multipart/form-data" name="form2">
            <table width="100%" border="0">
                <tr>
                    <td>วันที่เขียนใบลา</td>
                    <td><input type="text" id="search_create_date"  name="create_date" class="aqua_textfield"/></td>
                </tr>
                <tr>
                    <td>วันที่ลา</td>
                    <td><input type="text" id="search_between_date" name="between_date" class="aqua_textfield" /></td>
                </tr>
                <tr>
                    <td>สถานะใบลา</td>
                    <td>
                        <select name="status" class="aqua_textfield">
                            <option value disabled selected ></option>
                            <option value="0">รอการอนุมัติ</option>
                            <option value="1">อนุมัติแล้ว</option>
                            <option value="2">ไม่อนุมัติ</option>
                            <option value="3">ยกเลิกการลา</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="search" value="ค้นหา" class="button green"/></td>
                </tr>
            </table>
            <!-- create start-end bet status -->
        </form>
    </fieldset>
</div>
<div id="slidingDiv">
    <fieldset class="field_std3">
        <legend>ข้อมูลการลา</legend>
        <form action="" method="post" enctype="multipart/form-data" name="form1">
            <table width="100%" border="0">
                <!-- <tr>
                    <td width="20%" align="right">ชื่อ</td>
                    <td width="27%">
                        <input type="text" name="name" id="aqua_textfield"></td>
                    <td width="18%">นามสกุล</td>
                    <td width="35%"><input type="text" name="lastname" id="aqua_textfield"></td>
                </tr> -->
                <tr>
                    <td align="right">ประเภทการลา</td>
                    <td>
                        <select name="type" class="aqua_textfield">
                            <option value="" disabled>โปรดเลือก</option>
                            <option value="0">ลาป่วย</option>
                            <option value="1">ลากิจ</option>
                            <option value="2">ลาคลอด</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right">จำนวนวัน</td>
                    <td>
                        <input type="text" name="amount_day" class="aqua_textfield" readonly="" id="amount_day_placeholder">
                    </td>
                </tr>
                <tr>
                    <td align="right">เริ่มลาวันที่</td>
                    <td>
                        <input type="text" id="start_date" name="start_date" class="aqua_textfield">
                    </td>
                </tr>
                <tr>
                    <td align="right">ถึงวันที่</td>
                    <td>
                        <input type="text" id="end_date" name="end_date" class="aqua_textfield">
                    </td>
                </tr>
                <tr>
                    <td align="right">หมายเหตุ</td>
                    <td colspan="4">
                        <textarea name="note" class="aqua_textfield"></textarea>
                    </td>
                </tr>
                <tr id="label_file_doctor_approve">
                    <td></td>
                    <td align="left" colspan="2">แนบใบรับรองแพทย์ (กรณีลาป่วย 3 วันขึ้นไป)</td>
                </tr>
                <tr id="input_file_doctor_approve">
                    <td></td>
                    <td colspan="4">
                        <input type="file" name="file_doctor_approve" class="aqua_textfield"  />
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="center"><input type="submit" name="save" id="save_btn" class="button green" value="บันทึก">
                    </td>
                </tr>
            </table>

        </form>
    </fieldset>
</div>
<?php

?>
<div class="field_bar">
    <table width="100%" border="0">
        <tr class="aqua_treatment_text_header" style="text-align: left;">
            <!-- <td width="7%">ลำดับ</td>
            <td width="10%">รูปถ่าย</td>
            <td width="16%">ชื่อผู้ใช้งาน</td>
            <td width="30%" align="left">ชื่อ-สกุล</td>
            <td width="19%">กลุ่มผู้ใช้งาน</td>
            <td width="18%">จัดการ</td> -->
            <td>ลำดับ</td>
            <td>ผู้ลา</td>
            <td>ประเภท</td>
            <td>เริ่มลาวันที่</td>
            <td>ถึงวันที่</td>
            <td>จำนวนวัน</td>
            <td>สถานะ</td>
            <td>ผู้ตรวจสอบ</td>
            <td>วันที่เขียนใบลา</td>
            <td>หมายเหตุ</td>
            <td>เอกสารแนบ</td>
            <td>ดาวน์โหลด PDF</td>
            <td>จัดการ</td>
            <!-- <?php if($_SESSION['uclass']=='0' || $_SESSION['uclass']=='2') {
                    echo "<td>จัดการ</td>";
                }?> -->
        </tr>
        <?php
        $i = 0;
        $count_stat=0;
        $getdata->my_sql_set_utf8();
        if(isset($_POST['search'])) {
            $c = (new DateTime($_POST['create_date']))->format('Y-m-d');
            $cdate = explode('-', $c);
            $cp1 = (new DateTime($cdate[0]."-".$cdate[1]."-".(intval($cdate[2])+1)))->format('Y-m-d');

            $c = strlen($_POST['create_date'])>0? ("create_date>='".$c."' AND create_date<'".$cp1."'"):"";

            $b = (new DateTime($_POST['between_date']))->format('Y-m-d');
            // $bdate = explode('-', $b);
            // $bp1 = (new DateTime($bdate[0]."-".$bdate[1]."-".(intval($bdate[2])+1)))->format('Y-m-d');
            $b = strlen($_POST['between_date'])>0? ("start_date<='".$b."' AND end_date>='".$b."'"):"";
            if(strlen($c)>0 && strlen($b)>0){
                $b = " AND ". $b;
            }
            $s = isset($_POST['status'])? ("status='".$_POST['status']."'"):"";
            if(strlen($b)>0 && strlen($s)>0){
                $s = " AND ". $s;
            }
            $where = $c.$b.$s;

            if(strlen($where)>0 && $_SESSION['uclass']=='1'){
                $where = $where." AND user_key='".$_SESSION['ukey']."'";
            }else if($_SESSION['uclass']=='1'){
                $where = "user_key='".$_SESSION['ukey']."'";
            }
            // echo $where;
            // echo $_SESSION['uclass'];
            $getLeave = $getdata->my_sql_select(NULL, "leave_paper", $where);
        }else {
            if($_SESSION['uclass']=='1'){
                $where = "user_key='".$_SESSION['ukey']."'";
            }else{
                $where = "";
            }
            $getLeave = $getdata->my_sql_select(NULL, "leave_paper", $where);
        }
        while ($showLeave = mysql_fetch_object($getLeave)) {
            $i++;
            $bg = 'bgcolor="#9be2ff"';
            // if( $showLeave->user_key == $_SESSION['ukey'] ) {
                $count_stat++;
                $getUser = $getdata->my_sql_select(NULL, "user", "user.user_key='".$showLeave->user_key."'");
                $uname="";
                $ukey ="";
                if($u = mysql_fetch_object($getUser)){
                    $uname = $u->name ." ". $u->lastname;
                    $ukey = $u->user_key;
                }
            ?>
                <tr class="aqua_treatment_text" id="" >
                 <td <?php echo @$bg; ?>>
                     <?php echo $count_stat; ?>
                 </td>
                 <td <?php echo @$bg; ?>>
                     <?php
                        echo $uname;
                     ?>
                 </td>
                 <td <?php echo @$bg; ?>>
                     <?php
                     $t = $showLeave->type;
                    if($t == '0'){
                        echo 'ลาป่วย';
                    }
                    else if($t =='1'){
                        echo 'ลากิจ';
                    }
                    else if($t =='2'){
                        echo 'ลาคลอด';
                    }


                    ?>
                 </td>
                 <td <?php echo @$bg; ?>>
                     <?php echo sql_todate($showLeave->start_date); ?>
                 </td>
                 <td <?php echo @$bg; ?>>
                     <?php echo sql_todate($showLeave->end_date); ?>
                 </td>
                 <td <?php echo @$bg; ?>>
                     <?php echo $showLeave->amount_day; ?>
                 </td>
                 <td <?php echo @$bg; ?>>
                     <?php $s = $showLeave->status;

                     if($s =='0'){
                        echo 'รอการอนุมัติ';
                     }
                     else if($s =='1'){
                        echo 'อนุมัติแล้ว';
                     }
                     else if($s == '2'){
                        echo 'ไม่อนุมัติ';
                     }
                     else if($s == '3'){
                        echo 'ยกเลิกการลา';
                     }
                     ?>
                 </td>
                 <td <?php echo @$bg; ?>>
                     <?php
                        $getApprove = $getdata->my_sql_select(NULL, "user", "user.user_key='".$showLeave->approve_by."'");
                        if ($approver = mysql_fetch_object($getApprove)) {
                            echo $approver->name ." ". $approver->lastname;
                        }else{
                            echo "ยังไม่มี";
                        }

                     // echo $showLeave->approve_by;
                        ?>
                 </td>
                 <td <?php echo @$bg; ?>>
                     <?php echo sql_todate($showLeave->create_date); ?>
                 </td>
                 <td <?php echo @$bg; ?>>
                     <?php echo $showLeave->note; ?>
                 </td>
                 <td <?php echo @$bg; ?>>
                    <?php
                    if(strlen($showLeave->file_doctor_approve) > 0){
                        echo '<a href="../resource/leave/'.$showLeave->file_doctor_approve.'" target="_blank">ใบรับรองแพทย์</a>';
                    }
                    else {
                        echo "";
                    }
                    ?>
                 </td>
                 <td <?php echo @$bg; ?>>
                    <?php
                    if($showLeave->type=='0'){
                        $type = 'ลาป่วย';
                    }else if($showLeave->type=='1'){
                        $type = 'ลากิจ';
                    }else if($showLeave->type=='2'){
                        $type = 'ลาคลอด';
                    }else{
                        $type = 'ลา';
                    }

                    $start = sql_todate($showLeave->start_date);
                    $end = sql_todate($showLeave->end_date);
                    $date = sql_todate($showLeave->create_date);

                    $getUser =  $getdata->my_sql_select(NULL, "user", "(user_key='".($showLeave->user_key)."')");
                    if ($u = mysql_fetch_object($getUser)) {
                        $fullname = ($u->name) ." ". ($u->lastname);
                        $position = ($u->position);
                        $department = ($u->department);

                        ?>
                    <form action="pdf.php" method="POST">
                        <input type="text" name="type" value="<?php echo $type;?>" hidden />
                        <input type="text" name="name" value="<?php echo $fullname;?>" hidden />
                        <input type="text" name="note" value="<?php echo $showLeave->note;?>" hidden />
                        <input type="text" name="create_date" value="<?php echo $date;?>" hidden />
                        <input type="text" name="start_date"  id="t_start_date" value="<?php echo $start;?>" hidden />
                        <input type="text" name="end_date" id="t_end_date" value="<?php echo $end;?>" hidden />
                        <input type="text" name="amount_day" value="<?php echo $showLeave->amount_day;?>" hidden />
                        <input type="text" name="position" value="<?php echo $position;?>" hidden />
                        <input type="text" name="department" value="<?php echo $department;?>" hidden />
                        <input type="submit" name="pdf" value="download" class="button green"/>
                    </form>
                    <?php } ?>
                </td>
                <td align="left" <?php echo @$bg; ?> style="height: 40px;">
                    <?php
                        // if($_SESSION['uclass']=='0' && ($s==0 )) {
                        if($_SESSION['uclass']=='0' ) {
                        ?>
                    <a href="?p=leave_detail&key=<?php echo @$showLeave->code; ?>">
                        <div class="button_symbol green">
                            <img src="../media/icons/set/white/detail.png" width="25" height="25" alt=""
                                 title="แก้ไข"/>
                        </div>
                    </a>
                    <?php } else if($_SESSION['uclass']=='2'){ ?>
                    <a onClick="javascript:deleteLeave('<?php echo @$showLeave->code; ?>');">
                        <div class="button_symbol green">
                            <img src="../media/icons/set/white/delete1.png" width="25" height="25" alt=""
                                 title="ลบข้อมูล"/>
                        </div>
                    </a>
                    <?php } ?>
                    <?php if($_SESSION['ukey']==$ukey && ($s!=3)){ ?>
                    <a onClick="javascript:cancelLeave('<?php echo @$showLeave->code; ?>', <?php echo @$s; ?>, '<?php echo @$showLeave->user_key; ?>', '<?php echo @$showLeave->start_date; ?>', '<?php echo @$showLeave->end_date; ?>');">
                        <div class="button green">
                            ยกเลิกการลา
                        </div>
                    </a>
                    <?php } ?>
                </td>
             </tr>
            <?php

        }
        ?>
    </table>
</div>
