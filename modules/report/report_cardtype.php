<script src="../js/canvasjs.js"></script>
<script src="../js/ui/jquery.ui.widget.js"></script>
<script src="../js/ui/jquery.ui.mouse.js"></script>
<script src="../js/ui/jquery.ui.sortable.js"></script>
<script src="../js/ui/jquery.ui.tabs.js"></script>
<script src="../js/ui/jquery.ui.menu.js"></script>
<script src="../js/ui/jquery.ui.autocomplete.js"></script>
<script src="../js/ui/jquery.ui.position.js"></script>
<script src="../js/ui/jquery.ui.accordion.js"></script>
<script src="../js/ui/jquery.ui.datepicker.js"></script>
<script src="../js/ui/jquery.ui.slider.js"></script>
<script>
	$(function() {
		var tabs = $( "#tabsx" ).tabs();
		tabs.find( ".ui-tabs-nav" ).sortable({
			axis: "x",
			stop: function() {
				tabs.tabs( "refresh" );
			}
		});
	});
	</script>
<script type="text/javascript">
        $(document).ready(function () {

            $.getJSON("../modules/report/data/card_type.php", function (result) {

                var chart = new CanvasJS.Chart("chartContainer", {
					 theme: "theme2",//theme2
				//	  title:{
            //      text: "สวัสดี"              
           //  },
                    data: [
                        {
							// Change type to "bar", "splineArea", "area", "spline", "pie","column","line"etc.
							 type: "pie",
       						//name: "First Quarter",
       					//	showInLegend: true,
                            dataPoints: result
						}
                    ]
                });
				 chart.render();
              
            });
           
        });
    </script>
<div class="aqua_hbar"><img src="../media/icons/icons/cardtype.png" width="32" height="32">รายงานประเภทบัตร</div>
<div class="field_invisible">
  <div id="chartContainer" style="width:100%; height: 380px;"></div>
  <div id="tabsx">
	<ul>
		<li><a href="#report_paid">แบบจำกัดจำนวนครั้ง</a></li>
        <li><a href="#report_month">แบบรายเดือน</a></li>
    </ul>
      <div id="report_paid"><table width="100%" border="0">
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
  $getcard = $getdata->my_sql_select(NULL,"card,member","card.member_key=member.member_key AND card.card_type='1' ORDER BY card.regis_date DESC");
  while($showcard = mysql_fetch_object($getcard)){
	  $i++;
	  if($showcard->card_status != 1){
		  $bg = 'bgcolor="#CCCCCC"';
	  }else{
		  $bg = 'bgcolor="#9be2ff"';
	  }
  ?>
  <tr class="aqua_treatment_text">
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
    <td align="center" <?php echo $bg;?>><a href="../modules/cards/print.php?key=<?php echo $showcard->card_key;?>" target="_blank"><div class="button_symbol yellow"><img src="../media/icons/set/white/print.png" width="25" height="25"  alt="" title="พิมพ์บัตรสมาชิก"/></div></a><a href="#"><div class="button_symbol green"><img src="../media/icons/set/white/detail.png" width="25" height="25"  alt="" title="รายละเอียด"/></div></a></td>
  </tr>
  <?php
  }
  ?>
</table></div>
      <div id="report_month"><table width="100%" border="0">
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
  $getcard = $getdata->my_sql_select(NULL,"card,member","card.member_key=member.member_key AND card.card_type='2' ORDER BY card.regis_date DESC");
  while($showcard = mysql_fetch_object($getcard)){
	  $i++;
	  if($showcard->card_status != 1){
		  $bg = 'bgcolor="#CCCCCC"';
	  }else{
		  $bg = 'bgcolor="#9be2ff"';
	  }
  ?>
  <tr class="aqua_treatment_text">
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
    <td align="center" <?php echo $bg;?>><a href="../modules/cards/print.php?key=<?php echo $showcard->card_key;?>" target="_blank"><div class="button_symbol yellow"><img src="../media/icons/set/white/print.png" width="25" height="25"  alt="" title="พิมพ์บัตรสมาชิก"/></div></a><a href="#"><div class="button_symbol green"><img src="../media/icons/set/white/detail.png" width="25" height="25"  alt="" title="รายละเอียด"/></div></a></td>
  </tr>
  <?php
  }
  ?>
</table></div>
  </div>
</div>