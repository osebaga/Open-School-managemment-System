<?php
$this->load->library('excel');

$row_title = array(
    'S/No', 'First Name', 'Middle Name', 'Last Name', 'Sex', 'Date of Birth', 'Disability', 'Nationality',
    'Marital Status', 'Mobile 1', 'Mobile 2', 'Email', 'Entry Mode','Campus', 'Choice No.',
    'Form IV Index', 'Form VI Index/AVN', 'Grade A/NTA Level 4 index', 'O-Level Results', 'A-Level Results', 'Round'
);
$max_column = PHPExcel_Cell::stringFromColumnIndex(count($row_title));


$this->excel->startExcel(11, $max_column);
$sheet = $this->excel->get_sheet_instance();
$sheet->setTitle("APPLICANT LIST");
$sheet->setCellValue('B3', 'APPLICANT LIST ' . $ayear . ' - ' . strtoupper($application_type) . ' ');

$department_color = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '006BFF'),
        'size' => 15
    ));

$set_borders = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_HAIR
        ))
);

$department_list = $this->db->query("SELECT DISTINCT Departmentid as department_id FROM programme WHERE type='$type'")->result();

$current_round = $this->db->query("select * from application_round where application_type=" . $type)->row();
if ($current_round) {
    $round = $current_round->round;
} else {
    $round = 1;
}
$rows = 6;
foreach ($department_list as $dept => $department) {
    $department_name = get_value('department', $department->department_id, 'Name');
    $sheet->mergeCells('B' . $rows . ':' . $max_column . $rows);
    $sheet->setCellValue('B' . $rows, 'Department : ' . $department_name);
    $sheet->getStyle('B' . $rows)->applyFromArray($department_color);
    $sheet->getRowDimension($rows)->setRowHeight(20);
    $programme_list = $this->db->query("SELECT * FROM programme WHERE   `type`='$type' AND Departmentid='$department->department_id' ")->result();
    $rows++;

    $where = ' WHERE 1=1 ';

    if (isset($from) && $from != '') {
        $where .= " AND DATE(ap.createdon)>='" . $from . "' ";
    }

    if (isset($to) && $to != '') {
        $where .= " AND DATE(ap.createdon)<='" . $to . "' ";
    }


    foreach ($programme_list as $prog_key => $programme) {
        $sheet->mergeCells('B' . $rows . ':' . $max_column . $rows);
        $sheet->setCellValue('B' . $rows, 'Programme : ' . $programme->Name);
        $sheet->getStyle('B' . $rows)->getFont()->setSize(14);
        $sheet->getRowDimension($rows)->setRowHeight(18);
        $rows++;
        $initial_row = $rows;
        $sheet->fromArray($row_title, null, 'B' . $rows);
        $sheet->getRowDimension($rows)->setRowHeight(18);
        $rows++;
        $applicant = $this->db->query("SELECT ap.*,pc.applicant_id,pc.choice1,pc.choice2, pc.choice3, pc.choice4, pc.choice5 FROM application as ap  
INNER JOIN application_programme_choice as pc ON (ap.id=pc.applicant_id) $where AND pc.round='$round'  AND ap.AYear='$ayear' AND
 (pc.choice1='$programme->Code' OR pc.choice2='$programme->Code' OR pc.choice3='$programme->Code'  OR pc.choice4='$programme->Code'  OR pc.choice5='$programme->Code') ")->result();

        $sn = 1;
        foreach ($applicant as $key => $value) {
            $choice = 0;
            //Get Choice Number
            if ($value->choice1 == $programme->Code) {
                $choice = 1;
            } else if ($value->choice2 == $programme->Code) {
                $choice = 2;
            } else if ($value->choice3 == $programme->Code) {
                $choice = 3;
            } else if ($value->choice4 == $programme->Code) {
                $choice = 4;
            } else if ($value->choice5 == $programme->Code) {
                $choice = 5;
            }

            //Form IV subject Result
            $form4_result = $this->db->query("SELECT aes.*,ss.shortname, ss.name as subject_name,ss.code as subject_code FROM application_education_subject as aes
                       INNER JOIN secondary_subject as ss ON (aes.subject=ss.id) WHERE aes.applicant_id ='$value->applicant_id' AND aes.certificate=1")->result();
            $form4_result_data = '';
            foreach ($form4_result as $form4_key => $form4_value) {
                if (($form4_key % 4) == 0) {
                    $form4_result_data .= "\n";
                }
                $form4_result_data .= $form4_value->shortname . '-' . $form4_value->grade . ',';
            }


            //Form VI subject Result
            $form6_result = $this->db->query("SELECT aes.*,ss.shortname, ss.name as subject_name,ss.code as subject_code FROM application_education_subject as aes
                       INNER JOIN secondary_subject as ss ON (aes.subject=ss.id) WHERE aes.applicant_id ='$value->applicant_id' AND aes.certificate=2")->result();
            $form6_result_data = '';
            foreach ($form6_result as $form6_key => $form6_value) {
                if (($form6_key % 4) == 0) {
                    $form6_result_data .= "\n";
                }
                $form6_result_data .= $form6_value->shortname . '-' . $form6_value->grade . ',';
            }

            $applicant_row = array(
                $sn, //S.No
                $value->FirstName,
                $value->MiddleName,
                $value->LastName,
                $value->Gender,
                format_date($value->dob, false),
                get_value('disability', $value->Disability, 'name'),
                get_value('nationality', $value->Nationality, 'Name'),
                get_value('maritalstatus', $value->marital_status, 'name'),
                $value->Mobile1,
                ($value->Mobile2 == '255') ? '' : $value->Mobile2,
                $value->Email,
                entry_type($value->entry_category),
                $value->application_campus,
                $choice,
                get_index_number($value->applicant_id, 1),
                get_index_number($value->applicant_id, 2),
                get_index_number($value->applicant_id, 3),
                rtrim($form4_result_data, ', '),
                rtrim($form6_result_data, ', '),
                $round,


            );

            

            $sheet->fromArray($applicant_row, null, 'B' . $rows);
            $sheet->getRowDimension($rows)->setRowHeight(30);
            $rows++;
            $sn++;
        }


        // $wrapp_text = PHPExcel_Cell::stringFromColumnIndex(count($row_title)-2);
        //$sheet->getStyle($wrapp_text.($initial_row+1).':'.$wrapp_text.($rows-1))->getAlignment()->setWrapText(true);

        //$wrapp_text = PHPExcel_Cell::stringFromColumnIndex(count($row_title)-1);
        //$sheet->getStyle($wrapp_text.($initial_row+1).':'.$wrapp_text.($rows-1))->getAlignment()->setWrapText(true);

        $sheet->getStyle('B' . $initial_row . ':' . $max_column . ($rows - 1))->applyFromArray($set_borders);
        $rows++;
        $rows++;
    }
}


$sheet->removeColumn('A');

$this->excel->Output($application_type);
exit;
?>
