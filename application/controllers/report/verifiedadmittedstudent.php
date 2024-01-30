<?php
$this->load->library('excel');
$max_column = 'L';
$this->excel->startExcel(12, $max_column);
$sheet = $this->excel->get_sheet_instance();
$sheet->setTitle("SELECTED APPLICANT LIST");
$sheet->setCellValue('B3', 'VERIFIED ADMITTED STUDENTS REPORT - ' . $this->common_model->get_academic_year()->row()->AYear);
$programmeinfo = get_value('programme', array('programme_id' => $programme), null);


//Heading Main
$sheet->mergeCells('B4:' . $max_column . '4');
$sheet->setCellValue('B4', 'Programme : ' . $programmeinfo->Name);
$sheet->getStyle('B4')->getFont()->setSize(13);


$set_borders = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_HAIR
        ))
);


$rows = 6;
$column = 'A';
$sheet->setCellValue($column . $rows, 'S/No');
$column++;
$sheet->setCellValue($column . $rows, 'USER NAME');
$column++;
$sheet->setCellValue($column . $rows, 'USER ID');
$column++;
$sheet->setCellValue($column . $rows, 'VERIFICATION STATUS');
$column++;
$sheet->setCellValue($column . $rows, 'MULTIPLE SELECTION');
$column++;
$sheet->setCellValue($column . $rows, 'ACADEMIC YEAR');
$column++;
$sheet->setCellValue($column . $rows, 'INTAKE');
$column++;
$sheet->setCellValue($column . $rows, 'ELIGIBILITY');
$column++;
$sheet->setCellValue($column . $rows, 'REMARKS');
$column++;

$rows++;

for($i=0;$i<count($applicants);$i++) {
    $column = 'A';
    $num  = $i + 1;
    $sheet->setCellValue($column . $rows, ((string)$num));
    $column++;
    $sheet->setCellValue($column . $rows,  $applicants[$i]['username']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['user_id']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['verification_status']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['multiple_selection']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['academic_year']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['intake']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['eligibility']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['remarks']);
    $column++;

    $rows++;
}
$max_column = $column;
$sheet->getStyle('J')->getAlignment()->setWrapText(true);
$sheet->getStyle('A6:' . $max_column . ($rows - 1))->applyFromArray($set_borders);
$this->excel->Output("VERIFIED ADMITTED STUDENTS LIST");
exit;
?>
