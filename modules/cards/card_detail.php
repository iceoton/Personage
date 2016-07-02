<script src="../js/ui/jquery.ui.widget.js"></script>
<script src="../js/ui/jquery.ui.mouse.js"></script>
<script src="../js/ui/jquery.ui.sortable.js"></script>
<script src="../js/ui/jquery.ui.tabs.js"></script>
<script src="../js/ui/jquery.ui.menu.js"></script>
<script src="../js/ui/jquery.ui.autocomplete.js"></script>
<script src="../js/ui/jquery.ui.position.js"></script>
<script src="../js/ui/jquery.ui.datepicker.js"></script>
<script src="../js/ui/i18n/jquery.ui.datepicker-th.js"></script>

<script type="text/javascript">
$(document).ready(function(){
		$( "#date_start" ).datepicker({
			dateFormat:"yy-mm-dd",
			changeMonth: true,
			numberOfMonths: 2,
			onClose: function( selectedDate ) {
				$( "#search_app_exp" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#date_exp" ).datepicker({
			defaultDate: "+1m",
			dateFormat:"yy-mm-dd",
			changeMonth: false,
			numberOfMonths: 2,
			onClose: function( selectedDate ) {
				$( "#search_app_start" ).datepicker( "option", "maxDate", selectedDate );
			}
		});

});
</script>
<?php
$getcard_detail = $getdata->my_sql_query(NULL,"card,member","card.card_key='".addslashes($_GET['key'])."' AND card.member_key=member.member_key");
if(isset($_POST['save'])){
	if(addslashes($_POST['count_limit'])!= NULL && addslashes($_POST['card_start'])!= NULL && addslashes($_POST['card_exp'])!= NULL){
		$getdata->my_sql_update("card","aqua_count='".addslashes($_POST['count_limit'])."',use_date='".addslashes($_POST['card_start'])."',exp_date='".addslashes($_POST['card_exp'])."',card_status='".addslashes($_REQUEST['card_status'])."'","card_key='".addslashes($_GET['key'])."'");
		echo '<script>window.location="?p=cards"</script>';
	}
}
?>
<div class="aqua_hbar"><img src="../media/icons/nav/card_2.png" width="32" height="32">แก้ไขข้อมูลบัตรสมาชิก</div>
<div class="field_invisible">
<fieldset class="field_std3" ><legend>ข้อมูลบัตรสมาชิก</legend>
<form id="form1" name="form1" method="post">
    <table width="100%" border="0">
      <tr>
        <td width="20%" rowspan="4" align="center" valign="top"><img src="../resource/members/images/<?php echo @$getcard_detail->member_photo;?>" width="100"  alt="" id="photo_border"/></td>
        <td width="13%" align="right">รหัสบัตรสมาชิก</td>
        <td width="22%"><input name="textfield" type="text" id="aqua_textfield" readonly value="<?php echo $getcard_detail->card_number;?>"></td>
        <td width="13%" align="right">ช่ือสมาชิก</td>
        <td width="32%"><input name="member_code"  type="text" class="aqua_textfield" readonly value="<?php echo @$getcard_detail->member_prefix.$getcard_detail->member_name.'&nbsp;&nbsp;&nbsp;'.$getcard_detail->member_lastname;?>"></td>
      </tr>
      <tr>
        <td align="right">ประเภทบัตร</td>
        <td><select name="card_type" disabled id="card_type">
        <?php
		if($getcard_detail->card_type == 1){
			echo '<option value="1" selected>แบบจำกัดจำนวนครั้ง</option>
          <option value="2">แบบรายเดือน</option>';
		}else{
			echo '<option value="1">แบบจำกัดจำนวนครั้ง</option>
          <option value="2" selected>แบบรายเดือน</option>';
		}
		?>
          
          </select></td>
        <td align="right">จำกัดการรับน้ำ</td>
        <td><input type="text" name="count_limit" id="aqua_textfield" value="<?php echo @$getcard_detail->aqua_count;?>" autofocus>
          หน่วย</td>
      </tr>
      <tr>
        <td align="right">วันเริ่มใช้บัตร</td>
        <td><input type="text" name="card_start" id="date_start" class="aqua_textfield" value="<?php echo @$getcard_detail->use_date;?>"></td>
        <td align="right">วันหมดอายุ</td>
        <td><input type="text" name="card_exp" id="date_exp" class="aqua_textfield" value="<?php echo @$getcard_detail->exp_date;?>"></td>
      </tr>
      <tr>
        <td align="right">สถานะบัตร</td>
        <td><select name="card_status" id="card_status">
          <option value="1" selected="selected">สามารถใช้งานได้</option>
          <option value="0">ไม่สามารถใช้งานได้</option>
        </select></td>
        <td align="right">พนักงานผู้ออกบัตร</td>
        <td><input name="card_staff" type="text" id="aqua_textfield" readonly value="<?php $getstaff = $getdata->my_sql_query(NULL,"user","user_key='".$getcard_detail->user_key."'");echo $getstaff->name."&nbsp;&nbsp;&nbsp;".$getstaff->lastname;?>"></td>
      </tr>
      <tr>
        <td colspan="5" align="center"><input type="submit" name="save" id="button" value="บันทึก" class="button green"></td>
        </tr>
    </table>
  </form>
</fieldset>
</div>