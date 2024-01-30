<?php
$this->load->library('excel');
$max_column = 'L';
$this->excel->startExcel(12, $max_column);
$sheet = $this->excel->get_sheet_instance();
$sheet->setTitle("SELECTED APPLICANT LIST");
$sheet->setCellValue('B3', 'APPLICANTADMISSION STATUS REPORT - ' . $this->common_model->get_academic_year()->row()->AYear);
// $programmeinfo = get_value('programme', array('Code' => $programme), null);


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
/*$sheet->setCellValue($column . $rows, 'F4 INDEX NO');
$column++;*/
// $sheet->setCellValue($column . $rows, 'F6 INDEX NO');
// $column++;
// $sheet->setCellValue($column . $rows, 'Mobile');
// $column++;
// $sheet->setCellValue($column . $rows, 'Email');
// $column++;
$sheet->setCellValue($column . $rows, 'Programme');
$column++;
$sheet->setCellValue($column . $rows, 'Number of applicants');
$column++;
// $sheet->setCellValue($column . $rows, 'GPA');
// $column++;
// $sheet->setCellValue($column . $rows, 'Degree/Diploma/Certificate Information');

$rows++;

for($i=0;$i<count($applicants);$i++) {
    $column = 'A';
    $sheet->setCellValue($column . $rows, ($i + 1));
    $column++;
    /*$sheet->setCellValue($column . $rows, $applicants[$i]['F4INDEXNO']);
    $column++;*/
    // $sheet->setCellValue($column . $rows, $apllicants[$i]['F6indexno']);
    // $column++;
    // $sheet->setCellValue($column . $rows, $apllicants[$i]['Mobilenumber']);
    // $column++;
    // $sheet->setCellValue($column . $rows, $apllicants[$i]['Emailaddress']);
    // $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['ProgrammeCode']);
    $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['NumberOfApplicant']);
    $column++;
    // $sheet->setCellValue($column . $rows, $value->point);
    // $column++;
    // $sheet->setCellValue($column . $rows, ($value->selected == 1 ? 'Yes' : 'No'));
    // $column++;


    // $form6_json = json_decode($value->form6_subject);
    // $form6_label = '';
    // foreach ($form6_json as $pkp=>$pkv){
    //     $form6_label.= $pkp.' : '.json_encode($pkv)."\n";
    // }
    // $sheet->setCellValue($column . $rows, rtrim($form6_label,"\n"));
    // $column++;

    // $form4_json = json_decode($value->form4_subject);
    // $form4_label = '';
    // foreach ($form4_json as $pkp=>$pkv){
    //     $form4_label.= $pkp.' : '.json_encode($pkv)."\n";
    // }
    // $sheet->setCellValue($column . $rows, rtrim($form4_label,"\n"));
    // $column++;

    // $sheet->setCellValue($column . $rows, trim($value->gpa));
    // $column++;

    // $diploma_json = json_decode($value->diploma_info);
    // $diploma_label = '';
    // foreach ($diploma_json as $pkp=>$pkv){
    //     $diploma_label.= $pkp.' : '.json_encode($pkv)."\n";
    // }
    // $sheet->setCellValue($column . $rows, rtrim($diploma_label,"\n"));
    //
    $rows++;
}
$max_column = $column;
$sheet->getStyle('J')->getAlignment()->setWrapText(true);
$sheet->getStyle('A6:' . $max_column . ($rows - 1))->applyFromArray($set_borders);
$this->excel->Output("PROGRAMMES WITH ADMITTED CANDIDATES");
exit;
?>
