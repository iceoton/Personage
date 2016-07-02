<div class="aqua_hbar"><img src="../media/icons/nav/book_2.png" width="32" height="32">ลงทะเบียนเรียน</div>
<?php
$member_data=$getdata->my_sql_query(NULL,"member","member_key='".addslashes($_GET['key'])."'");
if(@addslashes($_POST['show_data'])){
	$subjectdata = $getdata->my_sql_query(NULL,"subjects","subject_key='".addslashes($_REQUEST['subject_on'])."'");
}
if(@addslashes($_POST['register_subject'])){
	if(addslashes($_POST['h_subject_key']) != NULL){
		$regis_key = md5(addslashes($_POST['h_subject_key']).time("now"));
		$getdata->my_sql_insert("subject_register","regis_key='".$regis_key."',subject_key='".addslashes($_POST['h_subject_key'])."',member_key='".$member_data->member_key."',regis_hour='".addslashes($_POST['subject_hour'])."',regis_price='".addslashes($_POST['subject_price'])."',payment_status='0'");
		$display_alert = '<div class="alert_box green"><img src="../media/icons/set/color/right1.png" width="32" height="32">ลงทะเบียนเรียน สำเร็จ!</div>';
	}else{
		$display_alert = '<div class="alert_box red"><img src="../media/icons/set/white/notification.png" width="32" height="32">ข้อมูลไม่ถูกต้อง กรุณาตรวจสอบใหม่อีกครั้ง !</div>';
	}
	
}
?>
<div class="field_invisible">
<?php echo @$display_alert;?>
<form id="form1" name="form1" method="post">
  <table width="100%" border="0">
    <tr>
      <td width="50%"><fieldset class="field_std3" ><legend>ข้อมูลนักเรียน</legend><table width="100%" border="0">
        <tr>
          <td width="11%" rowspan="2" align="center"><img src="../resource/members/thumbs/<?php echo @$member_data->member_photo;?>" height="50"  alt="" id="image_border"/></td>
          <td width="23%" align="right">รหัสสมาชิก :</td>
          <td width="66%">&nbsp;<?php echo @$member_data->member_code;?></td>
        </tr>
        <tr>
          <td align="right">ชื่อ-สกุล :</td>
          <td>&nbsp;<?php echo @$member_data->member_prefix.$member_data->member_name."&nbsp;&nbsp;&nbsp;".$member_data->member_lastname;?></td>
        </tr>
      </table></fieldset></td>
      <td width="50%"><fieldset class="field_std3" ><legend>วิชาที่สามารถลงทะเบียนเรียนได้</legend><table width="100%" border="0">
        <tr>
          <td align="center">
            <select name="subject_on" id="subject_on">
            <?php
			$getsubject = $getdata->my_sql_select(NULL,"subjects","subject_status='1' ORDER BY subject_name");
			while($showsubject = mysql_fetch_object($getsubject)){
				if(@addslashes($_REQUEST['subject_on']) == $showsubject->subject_key){
					echo '<option value="'.$showsubject->subject_key.'" selected>['.$showsubject->subject_code.']&nbsp;'.$showsubject->subject_name.'</option>';
				}else{
					echo '<option value="'.$showsubject->subject_key.'">['.$showsubject->subject_code.']&nbsp;'.$showsubject->subject_name.'</option>';
				}
			}
			?>
            </select>
            <input type="submit" name="show_data" class="button green" value="แสดงข้อมูล"></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          </tr>
      </table>
      </fieldset></td>
    </tr>
    <tr>
      <td colspan="2"><?php
	  if(@addslashes($_POST['show_data'])){
	  ?>
      <fieldset class="field_std3" ><legend>รายละเอียดวิชา</legend>
        <table width="100%" border="0">
          <tr>
            <td width="28%" align="right">รหัสวิชา </td>
            <td width="18%">
              <input type="text" name="textfield" id="aqua_textfield" show_value value="<?php echo @$subjectdata->subject_code;?>">
              <input type="hidden" name="h_subject_key" id="h_subject_key" value="<?php echo @$subjectdata->subject_key;?>"></td>
            <td width="15%" align="right">ชื่อวิชา</td>
            <td width="39%"><input type="text" name="textfield2" id="aqua_textfield" show_value value="<?php echo @$subjectdata->subject_name;?>"></td>
          </tr>
          <tr>
            <td align="right">รายละเอียด</td>
            <td colspan="3">
              <textarea name="textarea" id="aqua_textarea" show_value><?php echo @$subjectdata->subject_description;?></textarea></td>
          </tr>
          <tr>
            <td align="right">อาจารย์ผู้สอน</td>
            <td colspan="3">
              <input type="text" name="textfield3" id="aqua_textfield" show_value value="<?php echo @$subjectdata->subject_tutor;?>"></td>
          </tr>
          <tr>
            <td align="right">เปิดสอนตั้งแต่วันที่</td>
            <td colspan="3">
              <input type="text" name="textfield4" id="aqua_textfield" show_value value="<?php echo @dateConvertor($subjectdata->subject_start);?>">
              
              <input type="text" name="textfield5" id="aqua_textfield" show_value value="<?php echo @dateConvertor($subjectdata->subject_end);?>"></td>
          </tr>
          <tr>
            <td align="right">วันที่เรียน</td>
            <td colspan="3"><table width="490" border="0">
              <tr>
                <td width="70" align="center" bgcolor="#FED906">จันทร์</td>
                <td width="70" align="center" bgcolor="#FF33FF">อังคาร</td>
                <td width="70" align="center" bgcolor="#00CC00">พุธ</td>
                <td width="70" align="center" bgcolor="#FF9900">พฤหัสบดี</td>
                <td width="70" align="center" bgcolor="#0066FF">ศุกร์</td>
                <td width="70" align="center" bgcolor="#9933FF">เสาร์</td>
                <td width="70" align="center" bgcolor="#FF3333">อาทิตย์</td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FED906"><?php echo ($subjectdata->learn_mon == 1 ? '<img src="../media/icons/set/white/right1.png" width="20" height="20"  alt=""/>' : '');?></td>
                <td align="center" bgcolor="#FF33FF"><?php echo ($subjectdata->learn_tue == 1 ? '<img src="../media/icons/set/white/right1.png" width="20" height="20"  alt=""/>' : '');?></td>
                <td align="center" bgcolor="#00CC00"><?php echo ($subjectdata->learn_wed == 1 ? '<img src="../media/icons/set/white/right1.png" width="20" height="20"  alt=""/>' : '');?></td>
                <td align="center" bgcolor="#FF9900"><?php echo ($subjectdata->learn_thu == 1 ? '<img src="../media/icons/set/white/right1.png" width="20" height="20"  alt=""/>' : '');?></td>
                <td align="center" bgcolor="#0066FF"><?php echo ($subjectdata->learn_fri == 1 ? '<img src="../media/icons/set/white/right1.png" width="20" height="20"  alt=""/>' : '');?></td>
                <td align="center" bgcolor="#9933FF"><?php echo ($subjectdata->learn_sat == 1 ? '<img src="../media/icons/set/white/right1.png" width="20" height="20"  alt=""/>' : '');?></td>
                <td align="center" bgcolor="#FF3333"><?php echo ($subjectdata->learn_sun == 1 ? '<img src="../media/icons/set/white/right1.png" width="20" height="20"  alt=""/>' : '');?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="right">เวลาเรียน</td>
            <td colspan="3">
              <input type="text" name="learn_hour" id="aqua_textfield" show_value value="<?php echo @$subjectdata->subject_time_learn;?>"></td>
          </tr>
          <tr>
            <td align="right">จำนวนชั่วโมงเรียน</td>
            <td colspan="3">
              <input type="text" name="subject_hour" id="aqua_textfield" show_value value="<?php echo @$subjectdata->subject_total_hour;?>"></td>
          </tr>
          <tr>
            <td align="right">ค่าลงทะเบียนเรียน</td>
            <td colspan="3">
              <input type="text" name="subject_price" id="aqua_textfield" show_value value="<?php echo @$subjectdata->subject_price;?>"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3"><input type="submit" name="register_subject" class="button green" value="ลงทะเบียน"></td>
          </tr>
        </table>
      </fieldset><?php
	  }
      ?></td>
      </tr>
  </table>
</form>
</div>
