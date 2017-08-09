<?php 

$getdata->my_sql_check_date_missing($_SESSION['ukey'], date('d'), date('m'), date('Y'));

?>
<div class="aqua_hbar"><img src="../media/icons/nav/report_2.png" width="32" height="32">รายงานการขาดลา</div>

<!-- <fieldset class="field_std" ><legend>รายการการขาดลา</legend> -->
<div class="field_bar" style="text-align: center;">
<table width="100%" border="0" id="table_export">
  <tr class="aqua_treatment_text_header" >
    <td width="6%">ลำดับ</td>
    <td width="9%">ชื่อ</td>
    <td width="15%">มางาน</td>
    <td width="24%">มาสาย</td>
    <td width="17%">ขาดงาน</td>
  </tr>
  <?php 
  
  $qstr;
  $this_m = date("Y-m", gmmktime(0, 0, 0, date('m'), date('d'), date('Y')));
  if($_SESSION['uclass']==1){
  	// gerneral
  	$qstr = "SELECT SUM(normal) AS normal, SUM(late) as late, SUM(absence) as absence, ukey, uname, ulast FROM ((SELECT 0 AS normal, COUNT(status) AS late, 0 AS absence , user.user_key AS ukey, user.name AS uname, user.lastname AS ulast FROM user LEFT JOIN checkin ON user.user_key = checkin.user_key WHERE checkin.status='LATE' AND date like '".$this_m."-%' AND user.user_key='".$_SESSION['ukey']."' GROUP BY user.user_key) union (SELECT COUNT(status) AS normal ,0 AS late,0 AS absence  , user.user_key AS ukey, user.name AS uname, user.lastname AS ulast FROM user LEFT JOIN checkin ON user.user_key = checkin.user_key WHERE checkin.status='NORMAL' AND date like '".$this_m."-%' AND user.user_key='".$_SESSION['ukey']."' GROUP BY user.user_key) union (SELECT 0 AS normal,0 AS late,COUNT(status) AS absence   , user.user_key AS ukey, user.name AS uname, user.lastname AS ulast FROM user LEFT JOIN checkin ON user.user_key = checkin.user_key WHERE checkin.status='ABSENCE' AND date like '".$this_m."-%' AND user.user_key='".$_SESSION['ukey']."' GROUP BY user.user_key)) AS sums GROUP BY ukey, uname, ulast";
  }else{
  	// super
  	$qstr = "SELECT SUM(normal) AS normal, SUM(late) as late, SUM(absence) as absence, ukey , uname, ulast FROM ((SELECT 0 AS normal, COUNT(status) AS late, 0 AS absence , user.user_key AS ukey, user.name AS uname, user.lastname AS ulast FROM user LEFT JOIN checkin ON user.user_key = checkin.user_key WHERE checkin.status='LATE' AND date like '".$this_m."-%' GROUP BY user.user_key) union (SELECT COUNT(status) AS normal ,0 AS late,0 AS absence  , user.user_key AS ukey, user.name AS uname, user.lastname AS ulast FROM user LEFT JOIN checkin ON user.user_key = checkin.user_key WHERE checkin.status='NORMAL' AND date like '".$this_m."-%' GROUP BY user.user_key) union (SELECT 0 AS normal,0 AS late,COUNT(status) AS absence   , user.user_key AS ukey, user.name AS uname, user.lastname AS ulast FROM user LEFT JOIN checkin ON user.user_key = checkin.user_key WHERE checkin.status='ABSENCE' AND date like '".$this_m."-%' GROUP BY user.user_key)) AS sums GROUP BY ukey, uname, ulast";
  }
  $getdata->my_sql_set_utf8();
  $q = mysql_query($qstr);
  $i=0;
  while($item = mysql_fetch_object($q)){
        $i++; ?>
  <tr class="aqua_treatment_text" id="<?php echo $item->ukey;?>">
    <td align="center" bgcolor="#9be2ff"><?php echo $i; ?></td>
    <td align="center" bgcolor="#9be2ff"><?php echo ($item->uname)." ".($item->ulast); ?></td>
    <td align="center" bgcolor="#9be2ff"><?php echo $item->normal;?></td>
    <td align="center" bgcolor="#9be2ff"><?php echo $item->late; ?></td>
    <td align="center" bgcolor="#9be2ff"><?php echo $item->absence;?></td>
  </tr>
  <?php
    }
  ?>
</table>
<button id="export-buttons-table" class="button green" style="display: none;"  onclick="exportData()"> พิมพ์รายงานการขาดลาของเดือนนี้ </button>
</div>
<!-- </fieldset> -->

<script type="text/javascript" src="../js/xls.core.js"></script>
<script type="text/javascript" src="../js/xlsx.core.js"></script>
<script type="text/javascript" src="../js/Blob.js"></script>
<script type="text/javascript" src="../js/file-saver.js"></script>
<script type="text/javascript" src="../js/table-export.js"></script>
<script type="text/javascript" src="../js/jquery.base64.js"></script>

<script type="text/javascript" charset="utf-8">
function exportData(){
    // var blob = $("#table_export").tableExport({type:'xlsx',escape:'true',formats:['xlsx'],exportButtons: false});
    // blob.getExportData();
    var ExportButtons = document.getElementById('table_export');

	var instance = new TableExport(ExportButtons, {
	    formats: ['xlsx'],
	    exportButtons: false
	});

	//                                        // "id" of selector    // format
	var exportData = instance.getExportData()['table_export']['xlsx'];

	// var XLSbutton = document.getElementById('export-buttons-table');

	// XLSbutton.addEventListener('click', function (e) {
	//     //                   // data          // mime              // name              // extension
	    instance.export2file(exportData.data, exportData.mimeType, exportData.filename, exportData.fileExtension);
	// });

}
$(document).ready(function(){
	$('#export-buttons-table').css("display","unset");
});	

</script>