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
   var tabs = $( "#tabs" ).tabs();
		tabs.find( ".ui-tabs-nav" ).sortable({
			axis: "x",
			stop: function() {
				tabs.tabs( "refresh" );
			}
		});

});
</script>
<div class="aqua_hbar"><img src="../media/icons/nav/money_2.png" width="32" height="32">การจ่ายเงิน</div>
<form id="form1" name="form1" method="post">
<div class="field_invisible">
<div id="tabs">
      <ul>
        <li><a href="#payment">รายชื่อผู้ค้างชำระ</a></li>
        <li><a href="#payment_done">รายชื่อผู้ชำระแล้ว</a></li>
      </ul>
      <div id="payment"><table width="100%" border="0">
  <tr class="aqua_treatment_text_header">
    <td width="4%">ลำดับ</td>
    <td width="29%">ชื่อ-สกุล</td>
    <td width="16%">รหัสวิชา</td>
    <td width="20%">ชื่อวิชา</td>
    <td width="18%">จำนวนเงินที่ต้องชำระ</td>
    <td width="13%">ชำระเงิน</td>
  </tr>
  <?php
  $i=0;
  $getfinance = $getdata->my_sql_select(NULL,"subject_register,subjects,member","subject_register.payment_status='0' AND subject_register.subject_key=subjects.subject_key AND subject_register.member_key=member.member_key ORDER BY subject_register.regis_date");
  while($showfinance = mysql_fetch_object($getfinance)){
	  $i++;
  ?>
  <tr class="aqua_treatment_text">
    <td align="center"><?php echo @$i;?></td>
    <td>&nbsp;<?php echo @$showfinance->member_prefix.$showfinance->member_name."&nbsp;&nbsp;&nbsp;&nbsp;".$showfinance->member_lastname;?></td>
    <td align="center"><?php echo @$showfinance->subject_code;?></td>
    <td align="center"><?php echo @$showfinance->subject_name;?></td>
    <td align="center"><?php echo @number_format($showfinance->regis_price);?>&nbsp;</td>
    <td align="center"><a href="?p=money_pay&key=<?php echo @$showfinance->regis_key;?>"><div class="button_symbol green"><img src="../media/icons/set/white/money.png" width="25" height="25"  alt="" title="ชำระเงิน"/></div></a></td>
  </tr>
  <?php
  }
  ?>
</table>
</div>
      <div id="payment_done"><table width="100%" border="0">
  <tr class="aqua_treatment_text_header">
    <td width="4%">ลำดับ</td>
    <td width="23%">ชื่อ-สกุล</td>
    <td width="9%">รหัสวิชา</td>
    <td width="15%">ชื่อวิชา</td>
    <td width="14%">จำนวนเงินที่ชำระ</td>
    <td width="18%">วันที่ชำระเงิน</td>
    <td width="17%">ผู้รับเงิน</td>
    </tr>
  <?php
  $i=0;
  $getfinance = $getdata->my_sql_select(NULL,"subject_register,subjects,member","subject_register.payment_status='1' AND subject_register.subject_key=subjects.subject_key AND subject_register.member_key=member.member_key ORDER BY subject_register.regis_date");
  while($showfinance = mysql_fetch_object($getfinance)){
	  $i++;
	  $getpaydone = $getdata->my_sql_query(NULL,"payment","regis_key='".$showfinance->regis_key."'");
  ?>
  <tr class="aqua_treatment_text" style="height:36px;">
    <td align="center"><?php echo @$i;?></td>
    <td>&nbsp;<?php echo @$showfinance->member_prefix.$showfinance->member_name."&nbsp;&nbsp;&nbsp;&nbsp;".$showfinance->member_lastname;?></td>
    <td align="center"><?php echo @$showfinance->subject_code;?></td>
    <td align="center"><?php echo @$showfinance->subject_name;?></td>
    <td align="center"><?php echo @number_format($getpaydone->pay_amount);?>&nbsp;</td>
    <td align="center"><?php echo @dateTimeConvertor($getpaydone->pay_date);?></td>
    <td align="center"><?php $getuserx = $getdata->my_sql_query("name,lastname","user","user_key='".$getpaydone->user_key."'");echo $getuserx->name."&nbsp;&nbsp;&nbsp;".$getuserx->lastname;?></td>
    </tr>
  <?php
  }
  ?>
</table></div>
    </div>
</div>
</form>
