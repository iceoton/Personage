<div class="aqua_hbar"><img src="../media/icons/icons/members.png" width="32" height="32">รายงานข้อมูลนักเรียน</div>
<div class="field_invisible">
<table width="100%" border="0" >
  <tr class="aqua_treatment_text_header">
    <td width="6%">ลำดับ</td>
    <td width="9%">รูปถ่าย</td>
    <td width="15%">รหัสสมาชิก</td>
    <td width="24%">ชื่อ-สกุล</td>
    <td width="17%">วิชาที่ลงทะเบียนเรียน</td>
    <td width="17%">รายละเอียด</td>
  </tr>
  <?php
  $i=0;
  $getdata->my_sql_set_utf8();
  $getmember = $getdata->my_sql_select(NULL,"member",NULL);
  while($showmember = mysql_fetch_object($getmember)){
	  $i++;
	  if($showmember->member_status != 1){
		  $bg = 'bgcolor="#CCCCCC"';
	  }else{
		  $bg = 'bgcolor="#8DC2FF"';
	  }
  ?>
  <tr class="aqua_treatment_text" id="<?php echo @$showmember->member_key;?>">
    <td align="center" <?php echo @$bg;?>><?php echo @$i;?></td>
    <td align="center" <?php echo @$bg;?>><img src="../resource/members/thumbs/<?php echo @$showmember->member_photo;?>" width="50"  alt="" id="photo_border"/></td>
    <td align="center" <?php echo @$bg;?>><?php echo @$showmember->member_code;?></td>
    <td <?php echo @$bg;?>>&nbsp;<?php echo $showmember->member_prefix.$showmember->member_name."&nbsp;&nbsp;&nbsp;&nbsp;".$showmember->member_lastname;?></td>
    <td align="center" <?php echo @$bg;?>><?php $getcard = $getdata->my_sql_show_rows("subject_register","member_key='".$showmember->member_key."'");echo $getcard;?></td>
    <td align="center" <?php echo @$bg;?>><a href="?p=member_detail&key=<?php echo @$showmember->member_key;?>"><div class="button_symbol green"><img src="../media/icons/set/white/detail.png" width="25" height="25"  alt="" title="รายละเอียด"/></div></a>
    </td>
  </tr>
  <?php
  }
  ?>
</table>
</div>