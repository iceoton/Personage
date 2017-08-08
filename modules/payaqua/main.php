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
				.append('<a><div class="list_item_container" title="'+item.name+'"><img src="../resource/members/thumbs/' + item.image + '" id="photo_search" border="0" title="'+item.name+'"><span class="label">' + item.name + '</span></div></a>')
				.appendTo( ul );
		};

});
</script>
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
	xmlhttp.open("GET","../modules/members/delete.php?mkey="+mkey+"&ttype=delete_subject_register",true);
	xmlhttp.send();
	}
}
</script>
<?php
$photofilename=md5(time("now"));
?>
<script type="text/javascript" src="../plugins/webcam/webcam.js"></script>
<!-- Configure a few settings -->
	<script language="JavaScript">
		webcam.set_api_url( '../plugins/webcam/uploadphoto_agent.php?file_name=<?php echo $photofilename;?>' );
		webcam.set_quality( 100 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound( true ); // play shutter click sound
	</script>
<div class="aqua_hbar"><img src="../media/icons/nav/payaqua_2.png" width="32" height="32">ข้อมูลการเรียน</div>
<form id="form1" name="form1" method="get">
  <?php

if(isset($_POST['delete_transfer'])){
	echo '<script>alert("hello");</script>';
}
?>
  <fieldset class="field_bar" >
    <input type="hidden" name="p" id="p" value="payaqua">
    <label for="member_code">ชื่อหรือรหัสสมาชิก :</label>
    <input type="text" name="member_code" class="aqua_textfield12" id="showmember" autofocus autocomplete="off" value="<?php echo @addslashes($_GET['member_code']);?>">
    <button type="submit" class="button green" >ค้นหา</button>
  </fieldset>
  <div class="field_invisible">
    <?php
	  echo @$display_alert2;
	  $iscard = $getdata->my_sql_show_rows("member","member_code='".addslashes($_GET['member_code'])."'");
	  if($iscard != 0){
		  $member_detail = $getdata->my_sql_query(NULL,"member","member_code='".addslashes($_GET['member_code'])."'");
			if($member_detail->card_type == 1){
				$m=1;$p=2;
				$text = 'หน่วย';
				$getalluse = $getdata->my_sql_string("SELECT SUM( transfer_count ) AS stfc , DATE_FORMAT( regis_date,  '%Y-%m' ) AS created_month FROM aqua_transfer WHERE card_key='".$member_detail->card_key."'");
				$showalluse = mysql_fetch_object($getalluse);
			}else{
				$m=2;$p=1;
				$text = 'หน่วย/เดือน';
				$getalluse = $getdata->my_sql_string("SELECT SUM( transfer_count ) AS stfc , DATE_FORMAT( regis_date,  '%Y-%m' ) AS created_month FROM aqua_transfer WHERE regis_date LIKE ('".date("Y-m")."%') AND card_key='".$member_detail->card_key."'");
				$showalluse = mysql_fetch_object($getalluse);
			}
		/*	$showbalance = $member_detail->aqua_count-$showalluse->stfc;
			$twtps = (($member_detail->aqua_count*20)/100);
			$tenps = (($member_detail->aqua_count*10)/100);
			if($showbalance > $twtps){
				$bbcolor = 'green';
			}else if($showbalance <= $twtps && $showbalance > $tenps){
				$bbcolor = 'yellow';
			}else if($showbalance <= $tenps){
				$bbcolor = 'red';
			}else{
				$bbcolor = 'gray';
			}
			$isuse = 1;
			if($member_detail->member_status != 1){
				$display_alert = '<div class="alert_box red"><img src="../media/icons/set/white/alert2.png" width="32" height="32">ผู้ใช้งานนี้ ถูกยกเลิกการใช้งานไปแล้ว กรุณาตรวจสอบอีกครั้ง !</div>';
				$isuse = 0;
			}
			if($member_detail->card_status != 1){
				$display_alert = '<div class="alert_box red"><img src="../media/icons/set/white/alert2.png" width="32" height="32">บัตรนี้ถูกยกเลิกการใช้งานแล้ว กรุณาตรวจสอบอีกครั้ง !</div>';
				$isuse = 0;
			}
			if($showbalance <= 0){
				$display_alert = '<div class="alert_box red"><img src="../media/icons/set/white/alert2.png" width="32" height="32">ไม่สามารถใช้งานบัตรนี้ได้ เนื่องจากจำนวนที่สามารถรับน้ำครบแล้ว !</div>';
				$isuse = 0;
				$bbcolor = 'gray';
			}
			if($member_detail->use_date > date("Y-m-d") && $member_detail->exp_date > date("Y-m-d")){
				$display_alert = '<div class="alert_box red"><img src="../media/icons/set/white/alert2.png" width="32" height="32">ไม่สามารถใช้งานบัตรนี้ได้ เนื่องจากยังไม่ถึงวันใช้งาน !</div>';
				$isuse = 0;
			}
			if($member_detail->exp_date < date("Y-m-d")){
				$display_alert = '<div class="alert_box red"><img src="../media/icons/set/white/alert2.png" width="32" height="32">ไม่สามารถใช้งานบัตรนี้ได้ เนื่องจากบัตรหมดอายุ !</div>';
				$isuse = 0;
			}*/
		  ?>
    <div id="tabs">
      <ul>
        <li><a href="#pay_aqua">ข้อมูลบัตร</a></li>
        
      </ul>
      <div id="pay_aqua">
        <table width="100%" border="0">
          <tr>
            <td><?php echo @$display_alert;?></td>
          </tr>
          <tr>
            <td><fieldset class="field_std3" >
              <legend>ข้อมูลบัตร</legend>
              <table width="100%" border="0">
                <tr>
                  <td width="11%" rowspan="5" align="center" valign="top"><img src="../resource/members/images/<?php echo @$member_detail->member_photo;?>" width="120" alt="" id="photo_border"/></td>
                  <td width="14%" align="right">รหัสสมาชิก&nbsp;:</td>
                  <td width="36%">&nbsp;<?php echo $member_detail->member_code;?></td>
                  <td width="14%" align="right">&nbsp;</td>
                  <td width="25%">&nbsp;</td>
                </tr>
                <tr>
                  <td align="right">ชื่อผู้ถือบัตร&nbsp;:</td>
                  <td colspan="2">&nbsp;<?php echo $member_detail->member_prefix.$member_detail->member_name."&nbsp;&nbsp;&nbsp;".$member_detail->member_lastname;?></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="right">ที่อยู่ :</td>
                  <td>&nbsp;<?php echo @$member_detail->member_address."&nbsp;&nbsp;".$member_detail->member_subdistrict."&nbsp;&nbsp;".$member_detail->member_district."&nbsp;&nbsp;".$member_detail->member_province;?></td>
                  <td align="right">หมายเลขโทรศัพท์ :</td>
                  <td>&nbsp;<?php echo @$member_detail->member_tel;?></td>
                </tr>
                <tr>
                  <td align="right">ชื่อ-สกุล ผู้ปกครอง :</td>
                  <td>&nbsp;<?php echo @$member_detail->pr_member_name;?></td>
                  <td align="right">หมายเลขโทรศัพท์ :</td>
                  <td>&nbsp;<?php echo @$member_detail->pr_member_tel;?></td>
                </tr>
                <tr>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </fieldset></td>
          </tr>
          <tr>
            <td><button class="button green" type="button" onClick="window.location.href='?p=register_subjects&key=<?php echo @$member_detail->member_key;?>';"><img src="../media/icons/set/white/plus1.png" width="20" height="20">ลงทะเบียนเรียน</button></td>
          </tr>
          <tr>
            <td></td>
          </tr><tr>
            <td><table width="100%" border="0">
              <tr class="aqua_treatment_text_header">
                <td width="6%">ลำดับ</td>
                <td width="22%">ชื่อวิชา</td>
                <td width="16%">จำนวนชั่วโมงที่เหลือ</td>
                <td width="19%">เวลาเรียน</td>
                <td width="17%">การจ่ายเงิน</td>
                <td width="20%">เพิ่มเติม</td>
              </tr>
              <?php
			  $i=0;
			  $getsubject = $getdata->my_sql_select(NULL,"subjects,subject_register,member","member.member_key='".$member_detail->member_key."' AND subject_register.member_key=member.member_key AND subject_register.subject_key=subjects.subject_key ORDER BY subject_register.regis_date DESC");
			  while($showsubject = mysql_fetch_object($getsubject)){
				  $i++;
				  $getuse = $getdata->my_sql_query("SUM(use_hour) as use_hour","subject_use","regis_key='".$showsubject->regis_key."'");
				  $showuse = $showsubject->regis_hour-$getuse->use_hour;
				  if($showsubject->payment_status == 1){
					  $paytext = 'ชำระแล้ว';
					  $bgcolor = '#91FE6D';
				  }else if($showsubject->payment_status == 2){
					  $paytext = 'ชำระบางส่วน';
					  $bgcolor = '#FFE06F';
				  }else{
					  $paytext = 'ยังไม่ได้ชำระ';
					  $bgcolor = '#FF6D74';
				  }
			  ?>
              <tr class="aqua_treatment_text" id="<?php echo @$showsubject->regis_key;?>">
                <td align="center"><?php echo @$i;?></td>
                <td>&nbsp;<?php echo @$showsubject->subject_name;?></td>
                <td align="center"><?php echo @number_format($showuse);?>/<?php echo @number_format($showsubject->regis_hour);?>&nbsp;ชั่วโมง</td>
                <td align="center"><table width="100%" border="0">
                  <tr>
                    <?php echo ($showsubject->learn_mon == 1 ? '<td align="center" bgcolor="#FED906" ><img src="../media/icons/set/white/right2.png"  height="16" alt=""/></td>' : '');?>
                    <?php echo ($showsubject->learn_tue == 1 ? '<td align="center" bgcolor="#FF33FF" ><img src="../media/icons/set/white/right2.png"  height="16" alt=""/></td>' : '');?>
                    <?php echo ($showsubject->learn_wed == 1 ? '<td align="center" bgcolor="#00CC00" ><img src="../media/icons/set/white/right2.png"  height="16" alt=""/></td>' : '');?>
                    <?php echo ($showsubject->learn_thu == 1 ? '<td align="center" bgcolor="#FF9900" ><img src="../media/icons/set/white/right2.png"  height="16" alt=""/></td>' : '');?>
                    <?php echo ($showsubject->learn_fri == 1 ? '<td align="center" bgcolor="#0066FF" ><img src="../media/icons/set/white/right2.png"  height="16" alt=""/></td>' : '');?>
                    <?php echo ($showsubject->learn_sat == 1 ? '<td align="center" bgcolor="#9933FF" ><img src="../media/icons/set/white/right2.png"  height="16" alt=""/></td>' : '');?>
                    <?php echo ($showsubject->learn_sun == 1 ? '<td align="center" bgcolor="#FF3333" ><img src="../media/icons/set/white/right2.png"  height="16" alt=""/></td>' : '');?>
                    </tr>
                </table><?php echo @$showsubject->subject_time_learn;?></td>
                <td align="center" bgcolor="<?php echo $bgcolor;?>" style="color:#111111;"><?php echo @$paytext;?></td>
                <td align="center"><a href="?p=subject_use&key=<?php echo @$showsubject->regis_key;?>"><div class="button_symbol green"><img src="../media/icons/set/white/now.png" width="25" height="25"  alt="" title="แสดงรายละเอียดการเรียน"/></div></a><div class="button_symbol red" onClick="javascript:deleteCard('<?php echo @$showsubject->regis_key;?>');"><img src="../media/icons/set/white/delete1.png" width="25" height="25"  alt="" title="ลบข้อมูลการเรียน"/></div></a></td>
              </tr>
              <?php
			  }
			  ?>
            </table></td>
          </tr>
        </table>
      </div>
      
    </div>
    <?php
	  }
  ?>
  </div>
</form>
	<!--
    <select name="hour_use" id="hour_use">
                  <?php
				 // for($u=1;$u<=$showuse;$u++){
					//  echo '<option value="'.$u.'">'.$u.'</option>';
				  //}
				  ?>
                  </select>
    -->