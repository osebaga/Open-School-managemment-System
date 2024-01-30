<?php
$this->load->library('excel');
$max_column = 'L';
$this->excel->startExcel(12, $max_column);
$sheet = $this->excel->get_sheet_instance();
$sheet->setTitle("SELECTED APPLICANT LIST");
$sheet->setCellValue('B3', 'FEED BACK ERROR TO CORRECT REPORT - ' . $this->common_model->get_academic_year()->row()->AYear);
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
$sheet->setCellValue($column . $rows, 'STUDENT VERIFICATION ID');
$column++;
$sheet->setCellValue($column . $rows, 'PROGRAMME ID');
$column++;
$sheet->setCellValue($column . $rows, 'FIRSTNAME');
$column++;
$sheet->setCellValue($column . $rows, 'SECONDNAME');
$column++;
$sheet->setCellValue($column . $rows, 'SURNAME');
$column++;
$sheet->setCellValue($column . $rows, 'MOBILE NUMBER');
$column++;
$sheet->setCellValue($column . $rows, 'EMAIL');
$column++;
$sheet->setCellValue($column . $rows, 'F4_INDEX');
$column++;
$sheet->setCellValue($column . $rows, 'F4_YEAR');
$column++;
$sheet->setCellValue($column . $rows, 'F6_INDEX');
$column++;
$sheet->setCellValue($column . $rows, 'F6_YEAR');
$column++;
$sheet->setCellValue($column . $rows, 'NTA4_reg');
$column++;
$sheet->setCellValue($column . $rows, 'NTA4_grad_year');
$column++;
$sheet->setCellValue($column . $rows, 'NTA5_reg');
$column++;
$sheet->setCellValue($column . $rows, 'NTA5_grad_year');
$column++;
$sheet->setCellValue($column . $rows, 'REMARKS');
$column++;

$rows++;

for($i=0;$i<count($applicants);$i++) {
    $column = 'A';
    $sheet->setCellValue($column . $rows, ($i + 1));
    $column++;
    $sheet->setCellValue($column . $rows,  $applicants[$i]['student_verification_id']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['programme_id']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['firstname']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['secondname']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['surname']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['mobile_number']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['email_address']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['form_four_indexnumber']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['form_four_year']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['form_six_indexnumber']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['form_six_year']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['NTA4_reg']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['NTA4_grad_year']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['NTA5_reg']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['NTA5_grad_year']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['remarks']);
    $column++;

    $rows++;
}
$max_column = $column;
$sheet->getStyle('J')->getAlignment()->setWrapText(true);
$sheet->getStyle('A6:' . $max_column . ($rows - 1))->applyFromArray($set_borders);
$this->excel->Output("FEED BACK ERROR TO CORRECT  LIST");
exit;
?>
