<script src="../js/ui/jquery.ui.widget.js"></script>
<script src="../js/ui/jquery.ui.mouse.js"></script>
<script src="../js/ui/jquery.ui.sortable.js"></script>
<script src="../js/ui/jquery.ui.menu.js"></script>
<script src="../js/ui/jquery.ui.autocomplete.js"></script>
<script src="../js/ui/jquery.ui.position.js"></script>
<script src="../js/ui/jquery.ui.accordion.js"></script>
<script src="../js/ui/jquery.ui.datepicker.js"></script>
<script src="../js/ui/i18n/jquery.ui.datepicker-th.js"></script>
<script type="text/javascript">
			
			$(function(){
				
		$('#aqua_date_start').datepicker({
			 dateFormat: 'yy-mm-dd',
    onClose: function(dateText, inst) {
        var endDateTextBox = $('#aqua_date_end');
        if (endDateTextBox.val() != '') {
            var testStartDate = new Date(dateText);
            var testEndDate = new Date(endDateTextBox.val());
            if (testStartDate > testEndDate)
                endDateTextBox.val(dateText);
        }
        else {
            endDateTextBox.val(dateText);
        }
    },
    onSelect: function (selectedDateTime){
        var start = $(this).datetimepicker('getDate');
        $('#aqua_date_end').datetimepicker('option', 'minDate', new Date(start.getTime()));
    }
});
$('#aqua_date_end').datepicker({
	dateFormat: 'yy-mm-dd',
    onClose: function(dateText, inst) {
        var startDateTextBox = $('#aqua_date_start');
        if (startDateTextBox.val() != '') {
            var testStartDate = new Date(startDateTextBox.val());
            var testEndDate = new Date(dateText);
            if (testStartDate > testEndDate)
                startDateTextBox.val(dateText);
        }
        else {
            startDateTextBox.val(dateText);
        }
    },
    onSelect: function (selectedDateTime){
        var end = $(this).datetimepicker('getDate');
        $('#aqua_date_start').datetimepicker('option', 'maxDate', new Date(end.getTime()) );
    }
});
			
			});
</script>
<div class="aqua_hbar"><img src="../media/icons/icons/aqua_out.png" width="32" height="32">รายงานการจ่ายน้ำ</div>
<form id="form1" name="form1" method="post">
<fieldset class="field_bar" >เลือกวันที่จ่ายน้ำ : <input type="text" name="report_start"  class="aqua_textfield" id="aqua_date_start">ถึง<input type="text" name="report_end"  class="aqua_textfield" id="aqua_date_end">
  <input type="submit" name="submit" class="button green" value="แสดงรายงาน">
</fieldset>
</form>
<div class="field_invisible">
<table width="100%" border="0">
  <tr class="aqua_treatment_text_header">
    <td width="4%">ลำดับ</td>
    <td width="18%">หมายเลขบัตร</td>
    <td width="36%">ชื่อผู้รับน้ำ</td>
    <td width="13%">จำนวนที่จ่าย (หน่วย)</td>
    <td width="16%">ผู้จ่ายน้ำ</td>
    <td width="13%">เพิ่มเติม</td>
    </tr>
    <?php
	$datestart = @addslashes($_POST['report_start']);
  	$dateend = @addslashes($_POST['report_end']);
  	while (strtotime($datestart) <= strtotime($dateend)) {
	  $show = $getdata->my_sql_show_rows("aqua_transfer","(regis_date BETWEEN '".$datestart." 00:00:00' AND '".$datestart." 23:59:59')");
	  if($show != 0){
	?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><div class="aqua_report_date_box">วันที่&nbsp;:&nbsp;<?php echo dateConvertor($datestart);?></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <?php
	  }
	$i=0;
	$getpayaqua = $getdata->my_sql_select(NULL,"aqua_transfer,member,card,user","(aqua_transfer.regis_date BETWEEN '".$datestart." 00:00:00' AND '".$datestart." 23:59:59') AND aqua_transfer.card_key=card.card_key AND card.member_key=member.member_key AND aqua_transfer.user_key = user.user_key ORDER BY aqua_transfer.regis_date");
	while($showaqua = mysql_fetch_object($getpayaqua)){
		$i++;
	?>
  <tr class="aqua_treatment_text">
    <td align="center"><?php echo $i;?></td>
    <td align="center"><?php echo $showaqua->card_number;?></td>
    <td>&nbsp;<?php echo $showaqua->member_prefix.$showaqua->member_name."&nbsp;&nbsp;&nbsp;".$showaqua->member_lastname;?><br/><div class="aqua_drugs_how_to"><?php echo $showaqua->transfer_comment;?>&nbsp;</div></td>
    <td align="center"><?php echo $showaqua->transfer_count;?></td>
    <td align="center"><?php echo $showaqua->name."&nbsp;&nbsp;&nbsp;".$showaqua->lastname;?></td>
    <td align="center" style="height:36px;"><?php
    if(@$showaqua->transfer_status == 2){
		echo '<a href="?p=payaqua_agent&key='.$showaqua->transfer_key.'"><div class="button_symbol green"><img src="../media/icons/set/white/users.png" width="25" height="25"  alt="" title="ข้อมูลผู้รับน้ำแทน"/></div></a>';
	}?></td>
  </tr>
  <?php
	}
  		$datestart = date ("Y-m-d", strtotime("+1 day", strtotime($datestart)));
  }
  ?>
</table>
</div>
