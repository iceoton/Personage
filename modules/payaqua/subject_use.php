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
	xmlhttp.open("GET","../modules/members/delete.php?mkey="+mkey+"&ttype=delete_subject_use",true);
	xmlhttp.send();
	}
}
</script>
<?php
if(isset($_POST['save'])){
	$use_key=md5(addslashes($_POST['hour_use']).time("now"));
	$getdata->my_sql_insert("subject_use","use_key='".$use_key."',regis_key='".addslashes($_GET['key'])."',use_hour='".addslashes($_REQUEST['hour_use'])."',user_key='".$_SESSION['ukey']."'");
	$display_alert='<div class="alert_box green"><img src="../media/icons/set/color/right1.png" width="32" height="32">บันทึกข้อมูล สำเร็จ!</div>';
}
$showsubject = $getdata->my_sql_query(NULL,"subject_register,subjects","subject_register.regis_key='".addslashes($_GET['key'])."' AND subject_register.subject_key=subjects.subject_key");
$getuse = $getdata->my_sql_query("SUM(use_hour) as use_hour","subject_use","regis_key='".$showsubject->regis_key."'");
$showuse = $showsubject->regis_hour-$getuse->use_hour;

?>
<div class="aqua_hbar"><img src="../media/icons/nav/payaqua_2.png" width="32" height="32">ข้อมูลการเรียน วิชา <?php echo @$showsubject->subject_name;?></div>
<?php echo @$display_alert;?>
<div class="field_invisible">
<form name="form1" method="post" action="">
  <table width="100%" border="0" align="center">
    <tr class="aqua_treatment_text_header">
      <td width="4%">ลำดับ</td>
      <td width="24%">จำนวนชั่วโมงที่เหลือ</td>
      <td width="22%">จำนวนชั่วโมงที่เรียน</td>
      <td width="22%">วันที่บันทึก</td>
      <td width="24%">ผู้บันทึก</td>
      <td width="4%">ลบ</td>
    </tr>
    <tr class="aqua_treatment_text_header2">
      <td align="center">*</td>
      <td align="center"><?php echo @number_format($showuse);?>/<?php echo @number_format($showsubject->regis_hour);?>&nbsp;ชั่วโมง&nbsp;</td>
      <td align="center">
        <select name="hour_use" id="hour_use">
                  <?php
				  for($u=1;$u<=$showuse;$u++){
					  echo '<option value="'.$u.'">'.$u.'</option>';
				  }
				  ?>
          </select>
        <input type="submit" name="save" class="button green" value="บันทึก"></td>
      <td align="center"><?php echo dateTimeConvertor(date("Y-m-d H:i:s"));?></td>
      <td align="center"><?php $getuser = $getdata->my_sql_query("name,lastname","user","user_key='".$_SESSION['ukey']."'");echo $getuser->name."&nbsp;&nbsp;&nbsp;".$getuser->lastname;?></td>
      <td align="center">&nbsp;</td>
    </tr>
    <?php
	$i=0;
	$getsubject_use = $getdata->my_sql_select(NULL,"subject_use","regis_key='".addslashes($_GET['key'])."'");
	while($showsubject_use = mysql_fetch_object($getsubject_use)){
		$i++;
	?>
    <tr class="aqua_treatment_text" id="<?php echo @$showsubject_use->use_key;?>">
      <td align="center"><?php echo $i;?></td>
      <td>&nbsp;<?php $showmember = $getdata->my_sql_query("member_prefix,member_name,member_lastname","member","member_key='".$showsubject->member_key."'");echo $showmember->member_prefix.$showmember->member_name."&nbsp;&nbsp;&nbsp;".$showmember->member_lastname;?>&nbsp;ใช้ไป</td>
      <td align="right"><?php echo @$showsubject_use->use_hour;?>&nbsp;ชั่วโมง</td>
      <td align="center">&nbsp;<?php echo @dateTimeConvertor($showsubject_use->use_date);?></td>
      <td align="center"><?php $getuser = $getdata->my_sql_query("name,lastname","user","user_key='".$showsubject_use->user_key."'");echo $getuser->name."&nbsp;&nbsp;&nbsp;".$getuser->lastname;?></td>
      <td align="center"><div class="button_symbol red" onClick="javascript:deleteCard('<?php echo @$showsubject_use->use_key;?>');"><img src="../media/icons/set/white/delete1.png" width="25" height="25"  alt="" title="ลบรายการนี้"/></div></td>
    </tr>
    <?php
	}
	?>
  </table>
</form>
</div>