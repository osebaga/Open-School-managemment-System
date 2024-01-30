<?php
$this->load->library('excel');
$max_column = 'E';
$this->excel->startExcel(12, $max_column);
$sheet = $this->excel->get_sheet_instance();
$sheet->setTitle("SELECTED APPLICANT LIST");
$sheet->setCellValue('B3', 'APPLICANT ADMISSION STATUS REPORT - ' . $this->common_model->get_academic_year()->row()->AYear);
$programmeinfo = get_value('programme', array('Code' => $programme), null);


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
$sheet->setCellValue($column . $rows, 'Applicant Name');
$column++;
$sheet->setCellValue($column . $rows, 'F4 INDEXNO');
$column++;
// $sheet->setCellValue($column . $rows, 'F6 INDEX NO');
// $column++;
$sheet->setCellValue($column . $rows, 'Mobile');
$column++;
// $sheet->setCellValue($column . $rows, 'Email');
// $column++;
$sheet->setCellValue($column . $rows, 'Admission Status');
// $column++;

// $rows++;

$i=0;
foreach ($applicants as $key => $value) {
// }($i=0;$i<count($applicants);$i++) {
  $applicant_id = $this->db->get_where('application_education_authority',array('index_number'=>$value['f4indexno']))->row()->applicant_id;
  $fullname = $this->db->get_where('application',array('id'=>$applicant_id))->row();

    $column = 'A';
    $sheet->setCellValue($column . $rows, ($i + 1));
    $column++;
    if(trim($fullname->MiddleName)!='')
    {
        $sheet->setCellValue($column . $rows, $fullname->FirstName.' '.$fullname->MiddleName.' '.$fullname->LastName);
    }else{
        $sheet->setCellValue($column . $rows, $fullname->FirstName.' '.$fullname->LastName);
    }
    $column++;
    $sheet->setCellValue($column . $rows, $value['f4indexno']);
    $column++;
    // $sheet->setCellValue($column . $rows, $apllicants[$i]['F6indexno']);
    // $column++;
    // $sheet->setCellValue($column . $rows, $apllicants[$i]['Mobilenumber']);
    // $column++;
    $sheet->setCellValue($column . $rows, $fullname->Mobile1);
    $column++;
    $sheet->setCellValue($column . $rows, $value['AdmissionStatus']);
    // $column++;

    $i++;

    $rows++;
}

$max_column = $column;
$sheet->getStyle('J')->getAlignment()->setWrapText(true);
$sheet->getStyle('A6:' . $max_column . ($rows - 2))->applyFromArray($set_borders);
$this->excel->Output("CONFIRMATION STATUS");
exit;
?>
