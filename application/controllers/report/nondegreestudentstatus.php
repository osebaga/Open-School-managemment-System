<?php
$this->load->library('excel');
$max_column = 'L';
$this->excel->startExcel(12, $max_column);
$sheet = $this->excel->get_sheet_instance();
$sheet->setTitle("NON DEGREE STUDENTS  LIST");
$sheet->setCellValue('B3', 'NON DEGREE STUDENTS ADMISSION STATUS REPORT - ' . $this->common_model->get_academic_year()->row()->AYear);
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
$sheet->setCellValue($column . $rows, 'Verification Status');
$column++;
$rows++;

for($i=0;$i<count($applicants);$i++) {
  $applicant_id = $this->db->get_where('application_education_authority',array('index_number'=>$applicants[$i]['f4indexno']))->row()->applicant_id;
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
    $sheet->setCellValue($column . $rows, $applicants[$i]['f4indexno']);
    $column++;
    // $sheet->setCellValue($column . $rows, $apllicants[$i]['F6indexno']);
    // $column++;
    // $sheet->setCellValue($column . $rows, $apllicants[$i]['Mobilenumber']);
    // $column++;
    // $sheet->setCellValue($column . $rows, $apllicants[$i]['Emailaddress']);
    // $column++;
    $sheet->setCellValue($column . $rows, $applicants[$i]['VerificationStatus']);
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
$this->excel->Output("NON DEGREE STUDENTS ADMITTED  STATUS");
exit;
?>
