<?php
if (isset($_POST['pdf'])) {
    require('fpdf181/fpdf.php');
    function utf8($txt)
    {
        return $text = iconv('UTF-8', 'TIS-620', $txt);
    }

    $thai_day_arr = array("อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์");
    $thai_month_arr = array(
        "0" => "",
        "1" => "มกราคม",
        "2" => "กุมภาพันธ์",
        "3" => "มีนาคม",
        "4" => "เมษายน",
        "5" => "พฤษภาคม",
        "6" => "มิถุนายน",
        "7" => "กรกฎาคม",
        "8" => "สิงหาคม",
        "9" => "กันยายน",
        "10" => "ตุลาคม",
        "11" => "พฤศจิกายน",
        "12" => "ธันวาคม"
    );

    function thai_date($time)
    {
        global $thai_day_arr, $thai_month_arr;
        //$thai_date_return="วัน".$thai_day_arr[date("w",$time)];
        $thai_date_return = "วันที่ " . date("j", $time);
        $thai_date_return .= " เดือน " . $thai_month_arr[date("n", $time)];
        $thai_date_return .= " พ.ศ. " . (date("Yํ", $time) + 543);
        //$thai_date_return.= "  ".date("H:i",$time)." น.";
        return $thai_date_return;
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

    $pdf = new FPDF('P', 'cm', 'A4');
    $pdf->AddPage();
    $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');//ธรรมดา
    $pdf->SetFont('THSarabunNew', '', 16);
    //$text = utf8("แบบใบ".$type);
    $title = utf8("แบบใบลาป่วย ลาคลอดบุตร ลากิจส่วนตัว");
    $pdf->Ln();
    $pdf->Cell(19, 1, $title, 0, 1, 'C');
    // width, height, text, border(0 no, 1 frame),1 [0 to the right, 1 to the begin next ln, 2 below], C = center

    $pdf->SetFont('THSarabunNew', '', 16);

    $pdf->Ln();
    $pdf->Cell(9.5, 1, utf8(""), 0, 0, 'C');
    $pdf->Cell(9.5, 1, utf8("วันที่  " . thai_date(time())), 0, 1, 'C');

    $pdf->Ln();
    $text = utf8("เรื่อง ขออนุญาต" . $type);
    // $pdf->Ln();
    $pdf->Cell(19, 1, $text, 0, 1, 'L');

    $pdf->Cell(19, 1, utf8("เรียน .............................................."), 0, 1, 'L');
    $pdf->Ln();
    $pdf->MultiCell(19, 1, utf8("                ข้าพเจ้า  " . $name . "     ตำแหน่ง  " . $position . "    สังกัด " . $department), 0);
    if(empty($note)) {
        $note = "............................................................................................................";
    }
    $pdf->Cell(19, 1, utf8(" ขออนุญาต " . $type . " เนื่องจาก " . $note));
    $pdf->Ln();
    $pdf->Cell(19, 1, utf8("  ตั้งแต่วันที่  " . $start . "  ถึงวันที่  " . $end . "  โดยมีกำหนด  " . $amount . "  วัน"));

    $pdf->Ln();
    $pdf->Ln();
    $pdf->Cell(9.5, 1, utf8(""), 0, 0, 'C');
    $pdf->Cell(9.5, 1, utf8("ขอแสดงความนับถือ"), 0, 1, 'C');

    $pdf->Cell(9.5, 1, utf8(""), 0, 0, 'C');
    $pdf->Cell(9.5, 1, utf8("ลงชื่อ .............................................."), 0, 1, 'C');

    $pdf->Cell(9.5, 1, utf8(""), 0, 0, 'C');
    $pdf->Cell(9.5, 1, utf8("( " . $name . " )"), 0, 1, 'C');

    $pdf->Ln();
    $pdf->Cell(9.5, 1, utf8(""), 0, 0, 'C');
    $pdf->SetFont('', 'U'); //Where "U" means underline.
    $pdf->Cell(9.5, 1, utf8("ความเห็นของผู้บังคับบัญชา"), 0, 1, 'C');
    $pdf->SetFont('', ''); //Clear underline text
    $pdf->Cell(9.5, 1, utf8(""), 0, 0, 'C');
    $pdf->Cell(9.5, 1, utf8("ความเห็นของหัวหน้าสาขาวิชา/หัวหน้าสำนักงาน"), 0, 1, 'C');
    $pdf->Cell(9.5, 1, utf8(""), 0, 0, 'C');
    $pdf->Cell(9.5, 1, utf8("................................................................................"), 0, 1, 'C');
    $pdf->Cell(9.5, 1, utf8(""), 0, 0, 'C');
    $pdf->Cell(9.5, 1, utf8("[  ] อนุญาต        [  ] ไม่อนุญาต"), 0, 1, 'C');
    $pdf->Ln();
    $pdf->Cell(9.5, 1, utf8(""), 0, 0, 'C');
    $pdf->Cell(9.5, 1, utf8("ลงชื่อ ........................................................................"), 0, 1, 'C');
    $pdf->Cell(9.5, 1, utf8(""), 0, 0, 'C');
    $pdf->Cell(9.5, 1, utf8("(................................................................................)"), 0, 1, 'C');
    $pdf->Cell(9.5, 1, utf8(""), 0, 0, 'C');
    $pdf->Cell(9.5, 1, utf8("วันที่  ........ / ........ / ........"), 0, 1, 'C');

    $pdf->Output("download_leave.pdf", "I");
}
?>