<script src="../js/ui/jquery.ui.widget.js"></script>
<script src="../js/ui/jquery.ui.mouse.js"></script>
<script src="../js/ui/jquery.ui.sortable.js"></script>
<script src="../js/ui/jquery.ui.tabs.js"></script>
<script src="../js/ui/jquery.ui.menu.js"></script>
<script src="../js/ui/jquery.ui.autocomplete.js"></script>
<script src="../js/ui/jquery.ui.position.js"></script>
<script src="../js/ui/jquery.ui.datepicker.js"></script>
<script src="../js/ui/i18n/jquery.ui.datepicker-th.js"></script>
<script language="javascript">
function deleteCard(mkey){
	if(confirm("คุณต้องการลบข้อมูลนี้ไช่หรือไม่ ?")){
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	 	xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
  		if (xmlhttp.readyState==4 && xmlhttp.status==200){
		document.getElementById(mkey).innerHTML = '';
  		}
	}
	xmlhttp.open("GET","../modules/members/delete.php?mkey="+mkey+"&ttype=delete_card",true);
	xmlhttp.send();
	}
}
</script>
<script type="text/javascript">
$(document).ready(function(){
    $("#slidingDiv").hide();
	$("#show_hide").show();
	
	$('#show_hide').click(function(){
	$("#slidingDiv").slideToggle();
	});
	
		$( "#date_start" ).datepicker({
			dateFormat:"yy-mm-dd",
			changeMonth: true,
			numberOfMonths: 2,
			onClose: function( selectedDate ) {
				$( "#date_exp" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#date_exp" ).datepicker({
			defaultDate: "+1m",
			dateFormat:"yy-mm-dd",
			changeMonth: false,
			numberOfMonths: 2,
			onClose: function( selectedDate ) {
				$( "#date_start" ).datepicker( "option", "maxDate", selectedDate );
			}
		});

});
</script>
<?php
if(isset($_POST['save'])){
	if(addslashes($_POST['subject_name']) != NULL && addslashes($_POST['subject_price']) != NULL){
		$getdata->my_sql_set_utf8();
		$getdata->my_sql_update("subjects","subject_name='".addslashes($_POST['subject_name'])."',subject_code='".addslashes($_POST['subject_code'])."',subject_description='".addslashes($_POST['subject_description'])."',subject_tutor='".addslashes($_POST['subject_tutor'])."',subject_start='".addslashes($_POST['subject_start'])."',subject_end='".addslashes($_POST['subject_end'])."',subject_total_hour='".addslashes($_POST['subject_hour'])."',subject_price='".addslashes($_POST['subject_price'])."',learn_mon='".addslashes($_POST['mon'])."',learn_tue='".addslashes($_POST['tue'])."',learn_wed='".addslashes($_POST['wed'])."',learn_thu='".addslashes($_POST['thu'])."',learn_fri='".addslashes($_POST['fri'])."',learn_sat='".addslashes($_POST['sat'])."',learn_sun='".addslashes($_POST['sun'])."',subject_time_learn='".addslashes($_POST['time_learn'])."',subject_status='".addslashes($_REQUEST['subject_status'])."'","subject_key='".addslashes($_GET['key'])."'");
		$display_alert = '<div class="alert_box green"><img src="../media/icons/set/color/right1.png" width="32" height="32">แก้ไขรายวิชา สำเร็จ!</div>';
		
		
	}else{
		$display_alert = '<div class="alert_box red"><img src="../media/icons/set/white/alert2.png" width="32" height="32">คุณกรอกข้อมูลไม่ถูกต้อง กรุณาตรวจสอบข้อมูลอีกครั้ง</div>';
	}
	
}
$subject_detail = $getdata->my_sql_query(NULL,"subjects","subject_key='".addslashes($_GET['key'])."'");
?>
<div class="aqua_hbar"><img src="../media/icons/nav/book_2.png" width="32" height="32">แก้ไขข้อมูลวิชาที่เปิดสอน</div>
<div class="field_invisible">
<?php
echo @$display_alert;
?>
<fieldset class="field_std3" ><legend>ข้อมูลวิชาที่เปิดสอน</legend>
<form id="form1" name="form1" method="post">
    <table width="100%" border="0">
      <tr>
        <td width="40%" align="right">ชื่อวิชา :</td>
        <td width="60%">
          <input type="text" name="subject_name" id="aqua_textfield" value="<?php echo @$subject_detail->subject_name;?>"></td>
      </tr>
      <tr>
        <td align="right">รหัสวิชา :</td>
        <td>
          <input type="text" name="subject_code" id="aqua_textfield" value="<?php echo @$subject_detail->subject_code;?>"></td>
      </tr>
      <tr>
        <td align="right">รายละเอียด :</td>
        <td>
          <textarea name="subject_description" id="aqua_textarea"><?php echo @$subject_detail->subject_description;?></textarea></td>
      </tr>
      <tr>
        <td align="right">อาจารย์ผู้สอน :</td>
        <td>
          <input type="text" name="subject_tutor" id="aqua_textfield" value="<?php echo @$subject_detail->subject_tutor;?>"></td>
      </tr>
      <tr>
        <td align="right">เปิดสอนตั้งแต่วันที่ :</td>
        <td>
          <input type="text" name="subject_start" id="date_start" class="aqua_textfield" value="<?php echo @$subject_detail->subject_start;?>"></td>
      </tr>
      <tr>
        <td align="right">ถึงวันที่ :</td>
        <td>
          <input type="text" name="subject_end" id="date_exp" class="aqua_textfield" value="<?php echo @$subject_detail->subject_end;?>"></td>
      </tr>
      <tr>
        <td align="right">จำนวนชั่วโมงเรียน :</td>
        <td>
          <input type="text" name="subject_hour" id="aqua_textfield" value="<?php echo @$subject_detail->subject_total_hour;?>"></td>
      </tr>
      <tr>
        <td align="right">วันที่เรียน :</td>
        <td><input name="mon" type="checkbox" id="mon" value="1" <?php echo ($subject_detail->learn_mon == 1 ? 'checked':'');?>>
          <label for="mon">จันทร์</label>
            <input name="tue" type="checkbox" id="tue" value="1" <?php echo ($subject_detail->learn_tue == 1 ? 'checked':'');?>>
          <label for="tue">อังคาร</label>
          <input name="wed" type="checkbox" id="wed" value="1" <?php echo ($subject_detail->learn_wed == 1 ? 'checked':'');?>>
          <label for="wed">พุธ </label>
          <input name="thu" type="checkbox" id="thu" value="1" <?php echo ($subject_detail->learn_thu == 1 ? 'checked':'');?>>
          <label for="thu">พฤหัสบดี </label>
          <input name="fri" type="checkbox" id="fri" value="1" <?php echo ($subject_detail->learn_fri == 1 ? 'checked':'');?>>
          <label for="fri">ศุกร์ </label>
          <input name="sat" type="checkbox" id="sat" value="1" <?php echo ($subject_detail->learn_sat == 1 ? 'checked':'');?>>
          <label for="sat">เสาร์ </label>
          <input name="sun" type="checkbox" id="sun" value="1" <?php echo ($subject_detail->learn_sun == 1 ? 'checked':'');?>>
          <label for="sun">อาทิตย์</label> </td>
      </tr>
      <tr>
        <td align="right">เวลาเรียน :</td>
        <td>
          <input type="text" name="time_learn" id="aqua_textfield" value="<?php echo @$subject_detail->subject_time_learn;?>"></td>
      </tr>
      <tr>
        <td align="right">ค่าลงทะเบียนเรียน :</td>
        <td>
          <input type="text" name="subject_price" id="aqua_textfield" value="<?php echo @$subject_detail->subject_price;?>"></td>
      </tr>
      <tr>
        <td align="right">สถานะวิชา :</td>
        <td>
          <select name="subject_status" id="subject_status">
          <?php
		  if($subject_detail->subject_status == 1){
			  $s = 'selected="selected"';
			  $t='';
		  }else{
			  $s='';
			  $t = 'selected="selected"';
		  }
		  ?>
            <option value="0" <?php echo $t;?>>ไม่อนุญาติให้ลงทะเบียน</option>
            <option value="1" <?php echo $s;?>>อนุญาติให้ลงทะเบียน</option>
          </select></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="save" value="บันทึก" class="button green"></td>
      </tr>
    </table>
  </form>
</fieldset>
</div>