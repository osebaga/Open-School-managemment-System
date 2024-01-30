<?php
$this->load->library('excel');

$row_title = array(
    'S/No','First Name','Middle Name','Last Name','Application Type','Reference Number','Mobile Used',
    'Operator Receipt','Date','Amount','Charge','Total Amount');
$max_column = PHPExcel_Cell::stringFromColumnIndex(count($row_title));

$this->excel->startExcel(11,$max_column);
$sheet = $this->excel->get_sheet_instance();
$where = " WHERE 1=1 AND coll.msisdn <> ''";
$title2 = '';
if(!is_null($key) && $key <> ''){
    $where .= " AND (a.FirstName LIKE '%$key%' OR a.MiddleName LIKE '%$key%' OR a.LastName LIKE '%$key%' )";
    $title2.= " Search Key : ".$key;
}

if(!is_null($from) && $from <> ''){
    $where .= " AND DATE(coll.createdon) >= '".format_date($from)."'";
    $title2.= "  FROM : ".$from;
}

if(!is_null($acyear) && $acyear <> ''){
    $where .= " AND coll.AYear ='" . $_GET['ayear'] . "' ";
    $title2.= "  AYear : ".$acyear;
}

if(!is_null($to) && $to <> ''){
    $where .= " AND DATE(coll.createdon) <= '".format_date($to)."'";
    $title2.= "  Until : ".$to;
}




$sheet->setTitle("APPLICANT COLLECTION  LIST");
$sheet->setCellValue('B3','APPLICANT COLLECTION LIST '.$title2);

$department_color = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '006BFF'),
        'size'  => 15
    ));

$set_borders = array(
    'borders' => array(
        'allborders' =>array(
            'style' => PHPExcel_Style_Border::BORDER_HAIR
        ))
);

$rows =$initial_row = 6;
$sheet->fromArray($row_title,null,'B'.$rows);
$sheet->getRowDimension($rows)->setRowHeight(18);

$rows++;
$get_collection = $this->db->query("SELECT coll.*, a.FirstName,a.MiddleName,a.LastName,a.application_type FROM application_payment as coll
INNER JOIN application as a ON (coll.applicant_id=a.id) $where ORDER BY coll.amount  DESC")->result();

$data_array = array();
$total_amount = 0;
$total_charge = 0;
$total_total = 0;
foreach ($get_collection as $kp=>$kv){
    $total_amount +=  $kv->amount;
    $total_charge += $kv->charges;
    $total_total += ($kv->charges+$kv->amount);
    $tmp = array(
        ($kp+1),
        $kv->FirstName,
        $kv->MiddleName,
        $kv->LastName,
        application_type($kv->application_type),
        $kv->reference,
        $kv->msisdn,
        $kv->receipt,
        $kv->createdon,
        $kv->amount,
        $kv->charges,
        ($kv->charges+$kv->amount),
    );
    $data_array[] =$tmp;
}

$sheet->fromArray($data_array,null,'B'.$rows);
$rows += count($data_array);
$sheet->mergeCells('B'.$rows.':J'.$rows);
$sheet->setCellValue('B'.$rows,"Total : ");
$sheet->setCellValue('K'.$rows,$total_amount);
$sheet->setCellValue('L'.$rows,$total_charge);
$sheet->setCellValue('M'.$rows,$total_total);
$sheet->getStyle('I7:I'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('B'.$initial_row.':'.$max_column.$rows)->applyFromArray($set_borders);
$sheet->getStyle('B'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle("J7:L".$rows)->getNumberFormat()->setFormatCode("#,##0.00");
//$sheet->getStyle("K")->getNumberFormat()->setFormatCode("#,##0.00");
//$sheet->getStyle("L")->getNumberFormat()->setFormatCode("#,##0.00");
//$sheet->getStyle("J")->getNumberFormat()->setFormatCode("#,##0.00");
//$sheet->getStyle('F:G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//$sheet->getStyle('F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$sheet->removeColumn('A');
$this->excel->Output('Collection List');
exit;
?>
