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
	$( "#showmember" ).autocomplete({
			minLength: 1,
			source: "../modules/cards/card_result.php",
			focus: function( event, ui ) {
				$( "#showmember" ).val( ui.item.label );
				return false;
			},
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li>" )
				.append('<a><div class="list_item_container"><img src="../resource/members/thumbs/' + item.image + '" id="photo_search" border="0"><span class="label">' + item.name + '</span></div></a>')
				.appendTo( ul );
		};
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
updateDateNow();
if(isset($_POST['save'])){
	if(addslashes($_POST['member_code']) != NULL){
		$getmember_code = $getdata->my_sql_query("member_key","member","member_code='".addslashes($_POST['member_code'])."'");
		$ck = md5(addslashes($_POST['member_code']).time("now"));
		if(addslashes($_REQUEST['card_type']) == 1){
			$cn = getPaidNumber();
			$up = "1";
		}else{
			$cn = getMonthNumber();
			$up = "2";
		}
		if($getmember_code->member_key != NULL){
			$getdata->my_sql_insert("card","card_key='".$ck."',card_number='".$cn."',card_type='".addslashes($_REQUEST['card_type'])."',use_date='".addslashes($_POST['card_start'])."',exp_date='".addslashes($_POST['card_exp'])."',aqua_count='".addslashes($_POST['count_limit'])."',member_key='".$getmember_code->member_key."',user_key='".$_SESSION['ukey']."',card_status='".addslashes($_REQUEST['card_status'])."'");
		if($up == "1"){
			paidNumberUpdate();
		}else{
			monthNumberUpdate();
		}
		$display_alert = '<div class="alert_box green"><img src="../media/icons/set/color/right1.png" width="32" height="32">เพิ่มบัตรสมาชิก สำเร็จ!</div>';
		}
		
	}else{
		$display_alert = '<div class="alert_box red"><img src="../media/icons/set/white/alert2.png" width="32" height="32">คุณกรอกข้อมูลไม่ถูกต้อง กรุณาตรวจสอบข้อมูลอีกครั้ง</div>';
	}
	
}
?>
<div class="aqua_hbar"><img src="../media/icons/nav/card_2.png" width="32" height="32">ออกบัตรสมาชิก</div>
<fieldset class="field_bar" ><button class="button green"  id="show_hide" type="button"><img src="../media/icons/set/white/plus1.png" width="20" height="20">เพิ่มบัตรสมาชิก</button></fieldset>
<?php echo @$display_alert;?>
<div id="slidingDiv">
<fieldset class="field_std3" ><legend>ข้อมูลบัตรสมาชิก</legend>
  <form id="form1" name="form1" method="post">
    <table width="100%" border="0">
      <tr>
        <td width="41%" align="right">ช่ือหรือรหัสสมาชิก</td>
        <td width="59%">
          <input  type="text" name="member_code" class="aqua_textfield" id="showmember" autofocus autocomplete="off"></td>
      </tr>
      <tr>
        <td align="right">ประเภทบัตร</td>
        <td>
          <select name="card_type" id="card_type">
            <option value="1">แบบจำกัดจำนวนครั้ง</option>
            <option value="2">แบบรายเดือน</option>
          </select></td>
      </tr>
      <tr>
        <td align="right">จำกัดการรับน้ำ</td>
        <td><input type="text" name="count_limit" id="aqua_textfield">
          หน่วย</td>
      </tr>
      <tr>
        <td align="right">วันเริ่มใช้บัตร</td>
        <td>
          <input type="text" name="card_start" id="date_start" class="aqua_textfield"></td>
      </tr>
      <tr>
        <td align="right">วันหมดอายุ</td>
        <td>
          <input type="text" name="card_exp" id="date_exp" class="aqua_textfield"></td>
      </tr>
      <tr>
        <td align="right">สถานะบัตร</td>
        <td><select name="card_status" id="card_status">
          <option value="1" selected="selected">สามารถใช้งานได้</option>
            <option value="0">ไม่สามารถใช้งานได้</option>
        </select></td>
      </tr>
      <tr>
        <td align="right">พนักงานผู้ออกบัตร</td>
        <td><input name="card_staff" type="text" id="aqua_textfield" readonly value="<?php $getuser = $getdata->my_sql_query(NULL,"user","user_key='".$_SESSION['ukey']."'");echo $getuser->name."&nbsp;&nbsp;&nbsp;".$getuser->lastname;?>"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="save" id="button" value="ออกบัตรสมาชิก" class="button green"></td>
      </tr>
    </table>
  </form>
</fieldset>

</div>
<div class="field_invisible">
<table width="100%" border="0">
  <tr class="aqua_treatment_text_header">
    <td width="6%">ลำดับ</td>
    <td width="12%">หมายเลขบัตร</td>
    <td width="20%">เจ้าของบัตร</td>
    <td width="16%">ประเภทบัตร</td>
    <td width="13%">วันเริ่มใช้งาน</td>
    <td width="14%">วันหมดอายุ</td>
    <td width="19%">รายละเอียด</td>
  </tr>
  <?php
  $i=0;
  $getdata->my_sql_set_utf8();
  $getcard = $getdata->my_sql_select(NULL,"card,member","card.member_key=member.member_key ORDER BY card.regis_date DESC");
  while($showcard = mysql_fetch_object($getcard)){
	  $i++;
	  if($showcard->card_status != 1){
		  $bg = 'bgcolor="#CCCCCC"';
	  }else{
		  $bg = 'bgcolor="#9be2ff"';
	  }
  ?>
  <tr class="aqua_treatment_text" id="<?php echo $showcard->card_key;?>">
    <td align="center" <?php echo $bg;?>><?php echo @$i;?></td>
    <td align="center" <?php echo $bg;?>><?php echo @$showcard->card_number;?></td>
    <td <?php echo $bg;?>>&nbsp;<?php echo @$showcard->member_prefix.$showcard->member_name."&nbsp;&nbsp;&nbsp;".$showcard->member_lastname;?></td>
    <td align="center" <?php echo $bg;?>>
    <?php 
	if($showcard->card_type == 1){
		$m=1;$p=2;
	}else{
		$m=2;$p=1;
	}
	?>
    <img src="../media/icons/cardtype/month_<?php echo $m;?>.png" width="75"  alt="แบบรายเดือน" title="แบบรายเดือน"/><img src="../media/icons/cardtype/paid_<?php echo $p;?>.png" width="75" alt="แบบจำกัดจำนวนครั้ง" title="แบบจำกัดจำนวนครั้ง"/></td>
    <td align="center" <?php echo $bg;?>><?php echo @dateConvertor($showcard->use_date);?></td>
    <td align="center" <?php echo $bg;?>><?php echo @dateConvertor($showcard->exp_date);?></td>
    <td align="center" <?php echo $bg;?>><a href="../modules/cards/print.php?key=<?php echo $showcard->card_key;?>" target="_blank"><div class="button_symbol yellow"><img src="../media/icons/set/white/print.png" width="25" height="25"  alt="" title="พิมพ์บัตรสมาชิก"/></div></a><a href="?p=card_detail&key=<?php echo @$showcard->card_key;?>"><div class="button_symbol green"><img src="../media/icons/set/white/detail.png" width="25" height="25"  alt="" title="รายละเอียด"/></div></a><div class="button_symbol red" onClick="javascript:deleteCard('<?php echo @$showcard->card_key;?>');"><img src="../media/icons/set/white/delete1.png" width="25" height="25"  alt="" title="ลบ"/></div></td>
  </tr>
  <?php
  }
  ?>
</table>
</div>
