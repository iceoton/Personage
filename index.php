<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Personage</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="shortcut icon" href="media/icons/favicon.ico"/>
</head>

<body>
<div class="aqua_main">
<?php
if(@addslashes($_GET['c'])== "nouser"){
	echo '<div class="login_alert"><img src="media/icons/set/white/error2.png" width="32" height="32">ชื่อผู้ใช้งาน หรือรหัสผ่านผิด !</div>';
}
?><div class="login">
  <form name="form1" method="post" action="core/takelogin.core.php">
    <table width="100%" border="0" >
      <tr>
        <td align="center"><img src="media/logos/logo_banner.png" alt="" width="300"></td>
      </tr>
      <tr>
        <td align="center">
        <input type="text" name="username" id="textlogins" autocomplete="off" autofocus placeholder="ชื่อผู้ใช้งาน"></td>
      </tr>
      <tr>
        <td align="center">
        <input type="password" name="password" id="textlogins" placeholder="รหัสผ่าน"></td>
      </tr>
      <tr>
        <td align="center"><input type="submit" name="logins"  class="button blue" value="เข้าสู่ระบบ">
          </td>
      </tr>
    </table>
  </form>
  </div>

</div>
</body>
</html>
