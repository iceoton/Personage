<?php
if(isset($_POST['pdf'])){
	require('fpdf181/fpdf.php');
	function utf8($txt){
		return $text = iconv('UTF-8','TIS-620', $txt);
	}
	// $leave_paper_code = $_REQUEST['code'];

	$type = $_POST['type'];
	$name = $_POST['name'];
	$date = $_POST['create_date'];
	$note = $_POST['note'];
	$position = $_POST['position'];
	$department = $_POST['department'];
	$start = $_POST['start_date'];
	$end = $_POST['end_date'];
	$amount = $_POST['amount_day'];

	$pdf = new FPDF('P','cm','A4');
	$pdf->AddPage();
	$pdf->AddFont('THSarabunNew','','THSarabunNew.php');//ธรรมดา
	$pdf->SetFont('THSarabunNew','',22);
	$text = utf8("แบบใบ".$type);
	$pdf->Ln();
	$pdf->Cell(19,1,$text,0,1,'C'); 
	// width, height, text, border(0 no, 1 frame),1 [0 to the right, 1 to the begin next ln, 2 below], C = center
	$pdf->SetFont('THSarabunNew','',16);
	$pdf->Ln();
	$text = utf8("เรื่อง ขออนุญาต".$type);
	// $pdf->Ln();
	$pdf->Cell(19,1,$text,0,1,'L');

	$pdf->Cell(19,1,utf8("เรียน ................................."),0,1,'L');
	$pdf->Ln();
	$pdf->MultiCell(19,1,utf8("        ข้าพเจ้า ".$name."  ตำแหน่ง  ".$position." แผนก ".$department." ขออนุญาต".$type." เนื่องจาก".$note."  ตั้งแต่วันที่  ".$start."  ถึงวันที่  ".$end."  โดยมีกำหนด  ".$amount."  วัน" ),0);

	$pdf->Ln();

	$pdf->Cell(9.5,1,utf8(""),0,0,'C');
	$pdf->Cell(9.5,1,utf8("ขอแสดงความนับถือ"),0,1,'C');

	$pdf->Cell(9.5,1,utf8(""),0,0,'C');
	$pdf->Cell(9.5,1,utf8("ลงชื่อ .............................................."),0,1,'C');

	$pdf->Cell(9.5,1,utf8(""),0,0,'C');
	$pdf->Cell(9.5,1,utf8("( ".$name." )"),0,1,'C');

	$pdf->Cell(9.5,1,utf8(""),0,0,'C');
	$pdf->Cell(9.5,1,utf8("วันที่  ".$date),0,1,'C');


	$pdf->Ln();
	$pdf->Cell(9.5,1,utf8(""),0,0,'C');
	$pdf->Cell(9.5,1,utf8("ความเห็นของผู้บังคับบัญชาขั้นต้น"),0,1,'C');
	$pdf->Cell(9.5,1,utf8(""),0,0,'C');
	$pdf->Cell(9.5,1,utf8("[  ] อนุญาต        [  ] ไม่อนุญาต"),0,1,'C');
	$pdf->Ln();
	$pdf->Cell(9.5,1,utf8(""),0,0,'C');
	$pdf->Cell(9.5,1,utf8("ลงชื่อ ........................................................................"),0,1,'C');
	$pdf->Cell(9.5,1,utf8(""),0,0,'C');
	$pdf->Cell(9.5,1,utf8("(................................................................................)"),0,1,'C');
	$pdf->Cell(9.5,1,utf8(""),0,0,'C');
	$pdf->Cell(9.5,1,utf8("วันที่  ........ / ........ / ........"),0,1,'C');

	$pdf->Ln();
	$pdf->Cell(9.5,1,utf8(""),0,0,'C');
	$pdf->Cell(9.5,1,utf8("ความเห็นของผู้บังคับบัญชาสูงสุด"),0,1,'C');
	$pdf->Cell(9.5,1,utf8(""),0,0,'C');
	$pdf->Cell(9.5,1,utf8("[  ] อนุญาต        [  ]  ไม่อนุญาต"),0,1,'C');
	$pdf->Ln();
	$pdf->Cell(9.5,1,utf8(""),0,0,'C');
	$pdf->Cell(9.5,1,utf8("ลงชื่อ ........................................................................"),0,1,'C');
	$pdf->Cell(9.5,1,utf8(""),0,0,'C');
	$pdf->Cell(9.5,1,utf8("(................................................................................)"),0,1,'C');
	$pdf->Cell(9.5,1,utf8(""),0,0,'C');
	$pdf->Cell(9.5,1,utf8("วันที่  ........ / ........ / ........"),0,1,'C');

	$pdf->Output("download_leave.pdf","I");
}
?>