<div class="aqua_hbar"><img src="../media/icons/set/white/users.png" width="32" height="32">รายละเอียดผู้รับน้ำแทน</div>
<?php
$getagent_detail = $getdata->my_sql_query(NULL,"aqua_agent,aqua_transfer,card,member","aqua_transfer.transfer_key='".addslashes($_GET['key'])."' AND aqua_transfer.transfer_key=aqua_agent.transfer_key AND aqua_transfer.card_key=card.card_key AND card.member_key=member.member_key");
if($getagent_detail->card_type == 1){
				$m=1;$p=2;
				
			}else{
				$m=2;$p=1;
				
			}
?>
<div class="field_invisible">
<fieldset class="field_std3" ><legend>ข้อมูลเจ้าของบัตร</legend>
<table width="100%" border="0">
  <tr>
    <td width="9%" rowspan="5"><img src="../resource/members/images/<?php echo $getagent_detail->member_photo;?>" width="100" id="photo_border"  alt=""/></td>
    <td width="18%" align="right">หมายเลขบัตร :</td>
    <td width="29%">&nbsp;<?php echo @$getagent_detail->card_number;?></td>
    <td width="15%" align="right">ประเภทบัตร :</td>
    <td width="29%"><img src="../media/icons/cardtype/month_<?php echo $m;?>.png" width="75"  alt="แบบรายเดือน" title="แบบรายเดือน"/><img src="../media/icons/cardtype/paid_<?php echo $p;?>.png" width="75" alt="แบบจำกัดจำนวนครั้ง" title="แบบจำกัดจำนวนครั้ง"/></td>
  </tr>
  <tr>
    <td align="right">รหัสสมาชิก :</td>
    <td>&nbsp;<?php echo @$getagent_detail->member_code;?></td>
    <td align="right">ชื่อผู้ถือบัตร :</td>
    <td>&nbsp;<?php echo @$getagent_detail->member_name."&nbsp;&nbsp;&nbsp;".$getagent_detail->member_lastname;?></td>
  </tr>
  <tr>
    <td align="right">วันเริ่มใช้งาน :</td>
    <td>&nbsp;<?php echo @dateConvertor($getagent_detail->use_date);?></td>
    <td align="right">วันหมดอายุ :</td>
    <td>&nbsp;<?php echo @dateConvertor($getagent_detail->exp_date);?></td>
  </tr>
  <tr>
    <td align="right">วันรับบริการครั้งล่าสุด : </td>
    <td>&nbsp;<?php $getlast = $getdata->my_sql_query("regis_date","aqua_transfer","card_key='".$getagent_detail->card_key."' ORDER BY regis_date DESC"); echo @dateTimeConvertor($getlast->regis_date);?></td>
    <td align="right">ผู้ออกบัตร :</td>
    <td>&nbsp;<?php $staff = $getdata->my_sql_query(NULL,"user","user_key='".$getagent_detail->user_key."'"); echo @$staff->name."&nbsp;&nbsp;&nbsp;".$staff->lastname;?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</fieldset>
<fieldset class="field_std3" ><legend>ข้อมูลผู้รับน้ำแทน</legend>
<table width="100%" border="0">
  <tr>
    <td width="9%" rowspan="5"><img src="../resource/agents/images/<?php echo @$getagent_detail->agent_photo;?>" width="100" id="photo_border"  alt=""/></td>
    <td width="18%" align="right">ชื่อผู้รับน้ำแทน :</td>
    <td width="73%">&nbsp;<?php echo @$getagent_detail->agent_prefix.$getagent_detail->agent_name."&nbsp;&nbsp;&nbsp;".$getagent_detail->agent_lastname;?></td>
    </tr>
  <tr>
    <td align="right">ที่อยู่ :</td>
    <td>&nbsp;<?php echo @$getagent_detail->agent_address;?></td>
    </tr>
  <tr>
    <td align="right">หมายเลขโทรศัพท์ :</td>
    <td>&nbsp;<?php echo @$getagent_detail->agent_tel;?></td>
    </tr>
  <tr>
    <td align="right">เหตุผลที่รับน้ำแทน :</td>
    <td>&nbsp;<?php echo @$getagent_detail->agent_comment;?></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
</table>
</fieldset>
</div>