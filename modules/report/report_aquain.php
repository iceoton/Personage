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
	$("#slidingDiv").hide();
	$("#show_hide").show();
	
	$('#show_hide').click(function(){
	$("#slidingDiv").slideToggle();
	});
   var tabs = $( "#tabs" ).tabs();
		tabs.find( ".ui-tabs-nav" ).sortable({
			axis: "x",
			stop: function() {
				tabs.tabs( "refresh" );
			}
		});
	$( "#showmember" ).autocomplete({
			minLength: 1,
			source: "../modules/payaqua/card_result.php",
			focus: function( event, ui ) {
				$( "#showmember" ).val( ui.item.label );
				return false;
			},
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li>" )
				.append('<a><div class="list_item_container" title="'+item.name+'"><img src="../resource/members/thumbs/' + item.image + '" id="photo_search" border="0" title="'+item.name+'"><span class="label">' + item.code + '</span></div></a>')
				.appendTo( ul );
		};

});
</script>
<?php
function number_pad($number) {
return str_pad((int) $number,2,"0",STR_PAD_LEFT);
}
 $card_detail = $getdata->my_sql_query(NULL,"card,member","card.card_number='".addslashes($_POST['card_code'])."' AND card.member_key=member.member_key");
?>
<div class="aqua_hbar"><img src="../media/icons/nav/payaqua_2.png" width="32" height="32">การจ่ายน้ำ</div>

<form method="post" enctype="multipart/form-data" name="form1" id="form1">
<fieldset class="field_bar" ><input type="hidden" name="p" id="p" value="payaqua"><label for="member_code">ชื่อหรือรหัสสมาชิก :</label>
        <input type="text" name="card_code" class="aqua_textfield12" id="showmember" autofocus autocomplete="off" value="<?php echo @addslashes($_POST['card_code']);?>">
       <button type="submit" class="button green" >ค้นหา</button>
      </fieldset>
      <?php
	  if($_POST['card_code'] != NULL){
	  ?>
      <div class="field_invisible">
      <div id="tabs">
	<ul>
    <?php
	$getmonth = $getdata->my_sql_select("YEAR(`regis_date`) AS Y, MONTH(`regis_date`) AS M,COUNT(1) AS C","aqua_transfer","card_key='".$card_detail->card_key."' GROUP BY YEAR(`regis_date`), MONTH(`regis_date`) ORDER BY YEAR(`regis_date`), MONTH(`regis_date`)");
	while($showmonth = mysql_fetch_object($getmonth)){
		echo '<li><a href="#'.$showmonth->M.$showmonth->Y.'">'.$showmonth->M."/".($showmonth->Y+543).'('.$showmonth->C.')</a></li>';
	}
?></ul>
	<?php
	$getmonth2 = $getdata->my_sql_select("YEAR(`regis_date`) AS Y, MONTH(`regis_date`) AS M,COUNT(1) AS C","aqua_transfer","card_key='".$card_detail->card_key."' GROUP BY YEAR(`regis_date`), MONTH(`regis_date`) ORDER BY YEAR(`regis_date`), MONTH(`regis_date`)");
    while($showmonth2 = mysql_fetch_object($getmonth2)){
    ?>
    <div id="<?php echo $showmonth2->M.$showmonth2->Y;?>"><table width="100%" border="0">
  <tr class="aqua_treatment_text_header">
    <td width="5%" bgcolor="#00709f" style="color:#FFFFFF">ลำดับ</td>
    <td width="18%">จำนวนที่จ่ายน้ำ (หน่วย)</td>
    <td width="26%">หมายเหตุ</td>
    <td width="17%">ผู้จ่ายน้ำ</td>
    <td width="21%">วันที่จ่ายน้ำ</td>
    <td width="13%">เพิ่มเติม</td>
  </tr>
  <?php
  $i=0;
  $gethistory = $getdata->my_sql_select("aqua_transfer.*,member.member_name,member.member_lastname,user.name,user.lastname","aqua_transfer,member,card,user","aqua_transfer.card_key='".$card_detail->card_key."' AND aqua_transfer.card_key=card.card_key AND card.member_key=member.member_key AND aqua_transfer.user_key=user.user_key AND aqua_transfer.regis_date LIKE '%".$showmonth2->Y."-".number_pad($showmonth2->M)."%' ORDER BY aqua_transfer.regis_date");
  while($showhistory = mysql_fetch_object($gethistory)){
	  $i++;
  ?>
  <tr class="aqua_treatment_text">
    <td align="center" bgcolor="#00709f" style="color:#FFFFFF; height:36px;"><?php echo @$i;?></td>
    <td align="center"><?php echo @number_format($showhistory->transfer_count);?></td>
    <td>&nbsp;<?php echo @$showhistory->transfer_comment;?></td>
    <td align="center"><?php echo $showhistory->name."&nbsp;&nbsp;&nbsp;".$showhistory->lastname;?></td>
    <td align="center"><?php echo @dateTimeConvertor($showhistory->regis_date);?>&nbsp;</td>
    <td align="right"><?php
    if(@$showhistory->transfer_status == 2){
		echo '<a href="?p=payaqua_agent&key='.$showhistory->transfer_key.'"><div class="button_symbol green"><img src="../media/icons/set/white/users.png" width="25" height="25"  alt="" title="ข้อมูลผู้รับน้ำแทน"/></div></a>';
	}?></td>
  </tr>
  <?php
  }
  ?>
  
</table></div>
    <?php
    }
    ?>

</div></div>
<?php
	  }
?>
</form>
