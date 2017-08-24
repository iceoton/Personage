<div class="aqua_hbar"><img src="../media/icons/icons/users.png" width="32" height="32">รายงานข้อมูลผู้ใช้งานระบบ</div>
<div class="field_invisible">
<table width="100%" border="0" >
  <tr class="aqua_treatment_text_header">
    <td width="7%">ลำดับ</td>
    <td width="10%">รูปถ่าย</td>
    <td width="16%">ชื่อผู้ใช้งาน</td>
    <td width="30%">ชื่อ-สกุล</td>
    <td width="19%">กลุ่มผู้ใช้งาน</td>
    <td width="18%">รายละเอียด</td>
  </tr>
  <?php
  $i=0;
  $getdata->my_sql_set_utf8();
  $getmember = $getdata->my_sql_select(NULL,"user",NULL);
  while($showmember = mysql_fetch_object($getmember)){
	  $i++;
	  if($showmember->user_status != 1){
		  $bg = 'bgcolor="#CCCCCC"';
	  }else{
		  $bg = 'bgcolor="#8DC2FF"';
	  }
  ?>
  <tr class="aqua_treatment_text" id="<?php echo @$showmember->user_key;?>">
    <td align="center" <?php echo @$bg;?>><?php echo @$i;?></td>
    <td align="center" <?php echo @$bg;?>><img src="../resource/users/thumbs/<?php echo @$showmember->photo;?>" width="50"  alt="" id="photo_border"/></td>
    <td align="center" <?php echo @$bg;?>><?php echo @$showmember->username;?></td>
    <td <?php echo @$bg;?>>&nbsp;<?php echo $showmember->name."&nbsp;&nbsp;&nbsp;&nbsp;".$showmember->lastname;?></td>
    <td align="center" <?php echo @$bg;?>><?php  if(@$showmember->user_class == 1){
		echo 'ผู้ใช้งานระบบ';
	}else{
		echo 'ผู้ดูแลระบบ';
	}?></td>
    <td align="center" <?php echo @$bg;?>><a href="?p=user_detail&key=<?php echo @$showmember->user_key;?>"><div class="button_symbol green"><img src="../media/icons/set/white/detail.png" width="25" height="25"  alt="" title="รายละเอียด"/></div></a>
      </td>
  </tr>
  <?php
  }
  ?>
</table>
</div>