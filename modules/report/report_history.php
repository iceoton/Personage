<script src="../js/ui/jquery.ui.widget.js"></script>
<script src="../js/ui/jquery.ui.mouse.js"></script>
<script src="../js/ui/jquery.ui.sortable.js"></script>
<script src="../js/ui/jquery.ui.menu.js"></script>
<script src="../js/ui/jquery.ui.autocomplete.js"></script>
<script src="../js/ui/jquery.ui.position.js"></script>
<script src="../js/ui/jquery.ui.accordion.js"></script>
<script src="../js/ui/jquery.ui.datepicker.js"></script>
<script src="../js/ui/i18n/jquery.ui.datepicker-th.js"></script>
<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			 dateFormat: 'yy-mm-dd'});
	});
	</script>
    <script language="javascript">
function deleteLogs(mkey){
	
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
	xmlhttp.open("GET","../modules/members/delete.php?mkey="+mkey+"&ttype=delete_logs",true);
	xmlhttp.send();
	
}
</script>
<div class="aqua_hbar"><img src="../media/icons/icons/history.png" width="32" height="32">รายงานการใช้งานระบบ</div>
<form id="form1" name="form1" method="post">
<fieldset class="field_bar" >&nbsp;เลือกวันที่ : <input type="text" name="logs_date"  class="aqua_textfield" id="datepicker">
  <input type="submit" name="submit" class="button green" value="แสดงข้อมูล">
</fieldset>
</form>
<div class="field_invisible">
  <table width="100%" border="0">
    <tr class="aqua_treatment_text_header">
      <td width="4%">ลำดับ</td>
      <td width="15%">วันที่</td>
      <td width="16%">IP Address</td>
      <td width="28%">รายละเอียด</td>
      <td width="28%">ผู้ใช้งาน</td>
      <td width="9%">เพิ่มเติม</td>
    </tr>
    <?php
	$i=0;
	$gethistory = $getdata->my_sql_select(NULL,"logs,user","user.user_key=logs.log_user AND logs.log_date LIKE '".addslashes($_POST['logs_date'])."%' ORDER BY logs.log_date DESC");
	while($showhistory = mysql_fetch_object($gethistory)){
		$i++;
	?>
    <tr class="aqua_treatment_text" id="<?php echo $showhistory->log_key;?>">
      <td align="center" style="height:35px;"><?php echo @$i;?></td>
      <td align="center">&nbsp;<?php echo @dateTimeConvertor($showhistory->log_date);?></td>
      <td align="center">&nbsp;<?php echo @$showhistory->log_ipaddress;?></td>
      <td>&nbsp;<?php echo @$showhistory->log_text;?></td>
      <td align="center"><?php echo @$showhistory->name."&nbsp;&nbsp;&nbsp;".$showhistory->lastname;?></td>
      <td align="center"><div class="button_symbol red" onClick="javascript:deleteLogs('<?php echo @$showhistory->log_key;?>');"><img src="../media/icons/set/white/delete1.png" width="25" height="25"  alt="" title="ลบ"/></div></td>
    </tr>
    <?php
	}
	?>
  </table>
</div>