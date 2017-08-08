<div class="aqua_hbar"><img src="../media/icons/nav/member_2.png" width="32" height="32">รายละเอียดการลา</div>

<?php
function sql_todate($d){
    return (new DateTime($d))->format("d/m/Y");
}

if (isset($_POST['save_edit'])) {
    // $user_key = addslashes($_POST['user_key']);
 
        $getdata->my_sql_update("leave_paper","status='" . ($_POST['status']) . "',approve_by='" . $_SESSION['ukey'] . "'", "code='".$_POST['code']."'");
        
        //echo '<script>window.location="?p=users";</script>';
        echo '<div id="success_alert"><img src="../media/icons/set/white/info.png" width="16" height="16"> บันทึกข้อมูลเรียบร้อยแล้ว</div>';
    
}
?>
<?php
$getLeaveDetail = $getdata->my_sql_query(NULL, "leave_paper", "code='" . addslashes($_GET['key']) . "'");
?>
<div class="field_invisible">
    <fieldset class="field_std3">
        <legend>ข้อมูลการลา</legend>
        <form action="" method="post" enctype="multipart/form-data" name="form1">
            <input type="text" name="code"  value="<?php echo $getLeaveDetail->code; ?>" hidden />
            <table width="100%" border="0">
                <tr>
                    <td align="right">ผู้ลา</td>
                    <td>
                        <?php $getU = $getdata->my_sql_query(NULL, "user", "user_key='" . addslashes($getLeaveDetail->user_key) . "'"); ?>
                        <input type="text" name="fullname" class="aqua_textfield" value="<?php echo ($getU->name).' '.($getU->lastname); ?>" disabled>
                    </td>
                </tr>
                <tr>
                    <td align="right">ประเภทการลา</td>
                    <td>
                        <select disabled=""><option>
                        <?php 
                        if($getLeaveDetail->type=='0'){
                            echo 'ลาป่วย';
                        }
                        else if($getLeaveDetail->type=='1'){
                            echo 'ลากิจ';
                        }
                        else if($getLeaveDetail->type=='2'){
                            echo 'ลาคลอด';
                        }?>
                        </option></select>
                    </td>
                </tr>
                <tr>
                    <td align="right">จำนวนวัน</td>
                    <td>
                        <input type="number" name="amount_day" class="aqua_textfield" value="<?php echo $getLeaveDetail->amount_day; ?>" disabled>
                    </td>
                </tr>
                <tr>
                    <td align="right">เริ่มลาวันที่</td>
                    <td>
                        <input type="text" id="start_date" name="start_date" class="aqua_textfield" value="<?php echo sql_todate($getLeaveDetail->start_date); ?>" disabled>
                    </td>
                </tr>
                <tr>
                    <td align="right">ถึงวันที่</td>
                    <td>
                        <input type="text" id="end_date" name="end_date" class="aqua_textfield" value="<?php echo sql_todate($getLeaveDetail->end_date); ?>" disabled>
                    </td>
                </tr>
                <tr>
                    <td align="right">หมายเหตุ</td>
                    <td colspan="4">
                        <textarea name="note" class="aqua_textfield" disabled><?php echo $getLeaveDetail->note; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td align="right">วันที่เขียนใบลา</td>
                    <td>
                        <input type="text" name="create_date" class="aqua_textfield" value="<?php echo sql_todate($getLeaveDetail->create_date); ?>" disabled>
                    </td>
                </tr>
                <tr>
                    <td align="right">สถานะ</td>
                    <td>

                        <select name="status"> 
                            <option value="0" <?php 
                                if($getLeaveDetail->status == '0'){
                                    echo 'selected';
                                }
                                ?> >รอการอนุมัติ</option>
                            <option value="1"
                                <?php 
                                if($getLeaveDetail->status == '1'){
                                    echo 'selected';
                                }
                                ?> >อนุมัติแล้ว</option>
                            <option value="2"
                            <?php 
                                if($getLeaveDetail->status == '2'){
                                    echo 'selected';
                                }
                                ?> >ไม่อนุมัติ</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right">ผู้อนุมัติ</td>
                    <td>
                        <?php 
                        $getApprover = $getdata->my_sql_query(NULL, "user", "user_key='" . addslashes($getLeaveDetail->approve_by) . "'");
                        ?>
                        <input type="text" name="approve_by" class="aqua_textfield" value="<?php echo ($getApprover->name).' '.($getApprover->lastname); ?>" disabled>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="center"><input type="submit" name="save_edit" class="button green" value="บันทึกการแก้ไข">
                    </td>
                </tr>
            </table>

        </form>
    </fieldset>
</div>