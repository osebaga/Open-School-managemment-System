<?php
$this->load->library('excel');
$max_column = 'L';
$this->excel->startExcel(12, $max_column);
$sheet = $this->excel->get_sheet_instance();
$sheet->setTitle("SELECTED APPLICANT LIST");
$sheet->setCellValue('B3', 'SELECTED APPLICANT LIST REPORT - ' . $ayear);
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
$sheet->setCellValue($column . $rows, 'Sex');
$column++;
$sheet->setCellValue($column . $rows, 'Mobile');
$column++;
$sheet->setCellValue($column . $rows, 'Entry Type');
$column++;
$sheet->setCellValue($column . $rows, 'Choice#');
$column++;
$sheet->setCellValue($column . $rows, 'Point');
$column++;
$sheet->setCellValue($column . $rows, 'Selected');
$column++;
$sheet->setCellValue($column . $rows, 'F6 Indexno');
$column++;
$sheet->setCellValue($column . $rows, 'Form VI Results');
$column++;

$sheet->setCellValue($column . $rows, 'F4 Indexno');
$column++;
$sheet->setCellValue($column . $rows, 'Form IV Results');
$column++;
$sheet->setCellValue($column . $rows, 'GPA');
$column++;
$sheet->setCellValue($column . $rows, 'Registration Number/AVN');
$column++;
$sheet->setCellValue($column . $rows, 'Degree/Diploma/Certificate Information');

$rows++;

foreach ($applicant_list as $key => $value) {
    $f4_index_no=$this->db->query("select * from application_education_authority where applicant_id='".$value->id."' and certificate=1")->row()->index_number;
    $f6_index_no=$this->db->query("select * from application_education_authority where applicant_id='".$value->id."' and certificate=2")->row()->index_number;
    $diploma_avn=$this->db->query("select * from application_education_authority where applicant_id='".$value->id."' and certificate=4")->row()->avn;

    $current_round=$this->db->query("select * from application_round where application_type=".$value->application_type)->row();
    if($current_round)
    {
        $round=$current_round->round;
    }else{
        $round=1;
    }

    if($round != $value->round)
    {
        continue;
    }

    //$where=array('choice1'=>$value->ProgrammeCode,'applicant_id'=>$value->id);
    //$category_id=get_value('application_programme_choice',$where,'category1');
    //$where=array('code'=>$category_id);
    //$category_id. $category_name=get_value('programme_category',$category_id);
    //$camp_name=get_value('campus',$value->Campus);
    //$ayear = $this->common_model->get_academic_year()->row()->AYear;
    $where_array=array('applicant_id'=> $value->id,'AYear'=>$ayear);
    $appliction_fee = $this->db->where('student_id',$value->id,'status')->get('invoices')->row();
    $appliction_fee=$this->db->query("select * from  invoices where student_id='$value->id' and status=2")->row();
    $column = 'A';
    $sheet->setCellValue($column . $rows, ($key + 1));
    $column++;
    $sheet->setCellValue($column . $rows, $value->FirstName . ' ' . $value->MiddleName . ' ' . $value->LastName);
    $column++;
    $sheet->setCellValue($column . $rows, $value->Gender);
    $column++;
    $sheet->setCellValue($column . $rows, str_replace(' ', '', $value->Mobile1));
    $column++;
    $sheet->setCellValue($column . $rows, entry_type_human($value->entry_category));
    $column++;
    $sheet->setCellValue($column . $rows, $value->choice);
    $column++;
    $sheet->setCellValue($column . $rows, $value->point);
    $column++;
    $sheet->setCellValue($column . $rows, ($value->selected == 1 ? 'Yes' : 'No'));
    $column++;


    $form6_json = json_decode($value->form6_subject);
    $form6_label = '';
    foreach ($form6_json as $pkp=>$pkv){
        $form6_label.= $pkp.' : '.json_encode($pkv)."\n";
    }
    $pkp=($form6_label!='')?$pkp:'';
    $sheet->setCellValue($column . $rows, $pkp);
    $column++;
    $sheet->setCellValue($column . $rows, rtrim($form6_label,"\n"));
    $column++;

    $form4_json = json_decode($value->form4_subject);
    $form4_label = '';
    foreach ($form4_json as $pkp=>$pkv){
        $form4_label.= $pkp.' : '.json_encode($pkv)."\n";
    }
    $pkp=($form4_label!='')?$pkp:'';
    $sheet->setCellValue($column . $rows, $pkp);
    $column++;
    $sheet->setCellValue($column . $rows, rtrim($form4_label,"\n"));
    $column++;

    $sheet->setCellValue($column . $rows, trim($value->gpa));
    $column++;

    $diploma_json = json_decode($value->diploma_info);
    $diploma_label = '';
    foreach ($diploma_json as $pkp=>$pkv){
        $diploma_label.= $pkp.' : '.json_encode($pkv)."\n";
    }

    $pkp=($diploma_label!='')?$pkp:'';
    $sheet->setCellValue($column . $rows, $pkp);
    $column++;
    $sheet->setCellValue($column . $rows, rtrim($diploma_label,"\n"));

    $rows++;
}
$max_column = $column;
$sheet->getStyle('J')->getAlignment()->setWrapText(true);
$sheet->getStyle('A6:' . $max_column . ($rows - 1))->applyFromArray($set_borders);
$this->excel->Output("SELECTED APPLICANT LIST");
exit;
?>