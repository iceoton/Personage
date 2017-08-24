<div class="aqua_hbar"><img src="../media/icons/nav/money_2.png" width="32" height="32">ชำระเงิน</div>
<?php
$paydetail = $getdata->my_sql_query(NULL,"subject_register,subjects,member","subject_register.regis_key='".addslashes($_GET['key'])."' AND subject_register.subject_key=subjects.subject_key AND subject_register.member_key=member.member_key");
if(isset($_POST['pay_money'])){
	if(addslashes($_POST['pay_amount']) != NULL){
		$pay_key=md5(addslashes($_POST['pay_amount']).time("now"));
		$getdata->my_sql_insert("payment","pay_key='".$pay_key."',regis_key='".addslashes($_GET['key'])."',pay_amount='".addslashes($_POST['pay_amount'])."',user_key='".$_SESSION['ukey']."'");
		$getdata->my_sql_update("subject_register","payment_status='".addslashes($_REQUEST['pay_status'])."'","regis_key='".addslashes($_GET['key'])."'");
		echo '<script>alert("การชำระเงินเสร็จสมบูรณ์ !");window.location="?p=money";</script>';
	}
}
?>
<div class="field_invisible">
  <form name="form1" method="post" action="">
    <table width="50%" border="0" align="center">
      <tr>
        <td><fieldset class="field_std3" >
          <legend>รายละเอียดการชำระเงิน</legend>
         <table width="100%" border="0">
  <tr>
    <td width="38%">ชื่อ-สกุล</td>
    <td width="62%">
      <input type="text" name="member_name" id="aqua_textfield" show_value value="<?php echo @$paydetail->member_prefix.$paydetail->member_name."&nbsp;&nbsp;&nbsp;&nbsp;".$paydetail->member_lastname;?>" ></td>
  </tr>
  <tr>
    <td>ชื่อวิชา</td>
    <td>
      <input type="text" name="subject_name" id="aqua_textfield" show_value value="<?php echo '['.$paydetail->subject_code.']&nbsp;'.@$paydetail->subject_name;?>"></td>
  </tr>
  <tr>
    <td>จำนวนที่ต้องชำระ</td>
    <td>
      <input type="text" name="pay_money" id="aqua_textfield" show_value value="<?php echo @number_format($paydetail->regis_price);?>">
      บาท</td>
  </tr>
  <tr>
    <td>วันที่ชำระเงิน</td>
    <td>
      <input type="text" name="date_pay" id="aqua_textfield" show_value value="<?php echo dateTimeConvertor(date('Y-m-d H:i:s'));?>"></td>
  </tr>
  <tr>
    <td>ผู้รับเงิน</td>
    <td>
      <input type="text" name="user_accept" id="aqua_textfield" show_value value="<?php $getuser = $getdata->my_sql_query("name,lastname","user","user_key='".$_SESSION['ukey']."'");echo $getuser->name."&nbsp;&nbsp;&nbsp;".$getuser->lastname;?>"></td>
  </tr>
  <tr>
    <td>ระบุจำนวนเงิน</td>
    <td>
      <input type="text" name="pay_amount" id="aqua_textfield" autofocus placeholder="ระบุจำนวนเงิน">
      บาท</td>
  </tr>
  <tr>
    <td>สถานะการชำระเงิน</td>
    <td>
      <select name="pay_status" id="pay_status">
        <option value="0">ยังไม่ได้ชำระเงิน</option>
        <option value="1" selected="selected">ชำระเงินแล้ว</option>
      </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="pay_money" value="ชำระเงิน" class="button green"></td>
  </tr>
         </table>
        </fieldset></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
</div>