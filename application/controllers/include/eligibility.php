<?php
$date = "2018-10-12";
$applicant = $this->db->query("SELECT ap.*,pc.choice1,pc.choice2, pc.choice3, pc.choice4, pc.choice5 FROM application as ap
INNER JOIN application_programme_choice as pc ON (ap.id=pc.applicant_id) WHERE ap.AYear='$ayear' AND  pc.round='$eligibility_roud' AND DATE(ap.submitedon) >= '$date' AND
 (pc.choice1='$programme' OR pc.choice2='$programme' OR pc.choice3='$programme' OR pc.choice4='$programme' OR pc.choice5='$programme') ")->result();
foreach ($applicant as $key=>$value){
    $applicant_id = $value->id;
    $application_type = $value->application_type;
    $f4_index_number=$value->form4_index;
    $f6_index_number=$value->form6_index;
    $diploma_number=$value->diploma_number;
    $choice = 0;
    //Get Choice Number
    if($value->choice1 == $programme){
        $choice = 1;
    }else if($value->choice2 == $programme){
        $choice = 2;
    }else if($value->choice3 == $programme){
        $choice = 3;
    }else if($value->choice4 == $programme){
        $choice = 4;
    }else if($value->choice5 == $programme){
        $choice = 5;
    }

    //If choice found
    if($choice > 0){
        //Create default array with Not eligible status
        $applicant_data=array(
            'applicant_id'=>$value->id,
            'ProgrammeCode'=>$programme,
            'entry_category'=>$value->entry_category,
            'choice'=>$choice,
            'AYear'=>$ayear,
            'round'=>$eligibility_roud,
            'status'=>0,
            'comment'=>'',
            'point'=>0,

        );
        $point = 0;
        $pass = 0;
        $status = 0;
        $remark = '';
        //Switch to Entry Type
       switch ($value->entry_category){
           case 1:
               $setting_info = $this->setting_model->get_selection_criteria($programme,$ayear,1); // get selection criteria
               $o_level_min_point = $setting_info->min_point <> '' ? $setting_info->min_point : 0;
               $a_level_point = 0;
               $A_LEVEL_SUBJECT_HOLD = array();
               $A_LEVEL_SUBJECT_HOLD_SIX = array();
               $O_LEVEL_SUBJECT_HOLD = array();
               $O_LEVEL_SUBJECT_HOLD_FOUR = array();
               //Form IV Entry Qualification
                 include 'entryMode_FormIV.php';
               $applicant_data['status'] = $o_level_status;
               $applicant_data['comment'] = $o_level_remark;
               $applicant_data['point'] = $o_level_point;
               $applicant_data['form6_subject'] = '';
               $applicant_data['form4_subject'] = json_encode($O_LEVEL_SUBJECT_HOLD_FOUR);
               $applicant_data['sitting_no'] = $o_level_sitting_no;
               break;
           case 1.5:
               //VETA NVL III Entry Qualification
               $setting_info = $this->setting_model->get_selection_criteria($programme,$ayear,1.5);
               $o_level_min_point = 0;
               $a_level_min_point = 0;
               $a_level_point = 0;
               $A_LEVEL_SUBJECT_HOLD = array();
               $A_LEVEL_SUBJECT_HOLD_SIX = array();
               $O_LEVEL_SUBJECT_HOLD = array();
               $O_LEVEL_SUBJECT_HOLD_FOUR = array();
               //Form VI Entry Qualification
               include 'entryMode_VETA.php.php';
               $applicant_data['status'] = $diploma_level_status;
               $applicant_data['comment'] = $diploma_level_remark;
               $applicant_data['point'] = $o_level_point;
               $applicant_data['form6_subject'] =json_encode($A_LEVEL_SUBJECT_HOLD_SIX);
               $applicant_data['form4_subject'] = json_encode($O_LEVEL_SUBJECT_HOLD_FOUR);
               $applicant_data['diploma_info'] = json_encode($DIPLOMA_LEVEL_HOLD);
               $applicant_data['sitting_no'] = $o_level_sitting_no;
               $applicant_data['gpa'] = $GPA;
               break;

           case 2:
               $setting_info = $this->setting_model->get_selection_criteria($programme,$ayear,2);
               $o_level_min_point = 0;
               $a_level_min_point = $setting_info->min_point <> '' ? $setting_info->min_point : 0;
               $a_level_point = 0;
               $A_LEVEL_SUBJECT_HOLD = array();
               $A_LEVEL_SUBJECT_HOLD_SIX = array();
               $O_LEVEL_SUBJECT_HOLD = array();
               $O_LEVEL_SUBJECT_HOLD_FOUR = array();

               //Form VI Entry Qualification
               include 'entryMode_FormVI.php';
               $applicant_data['status'] = $a_level_status;
               $applicant_data['comment'] = $a_level_remark;
               $applicant_data['point'] = $a_level_point;
               $applicant_data['form6_subject'] =json_encode($A_LEVEL_SUBJECT_HOLD_SIX);
               $applicant_data['form4_subject'] = json_encode($O_LEVEL_SUBJECT_HOLD_FOUR);
               $applicant_data['sitting_no'] = $a_level_sitting_no;


               break;

           case 3:
               //NTA Level 4 Entry Qualification
               $setting_info = $this->setting_model->get_selection_criteria($programme,$ayear,3);
               $o_level_min_point = 0;
               $a_level_min_point = 0;
               $a_level_point = 0;
               $A_LEVEL_SUBJECT_HOLD = array();
               $A_LEVEL_SUBJECT_HOLD_SIX = array();
               $O_LEVEL_SUBJECT_HOLD = array();
               $O_LEVEL_SUBJECT_HOLD_FOUR = array();
               //Form VI Entry Qualification
               include 'entryMode_NTAL4.php';
               $applicant_data['status'] = $diploma_level_status;
               $applicant_data['comment'] = $diploma_level_remark;
               $applicant_data['point'] = $o_level_point;
               $applicant_data['form6_subject'] =json_encode($A_LEVEL_SUBJECT_HOLD_SIX);
               $applicant_data['form4_subject'] = json_encode($O_LEVEL_SUBJECT_HOLD_FOUR);
               $applicant_data['diploma_info'] = json_encode($DIPLOMA_LEVEL_HOLD);
               $applicant_data['sitting_no'] = $o_level_sitting_no;
               $applicant_data['gpa'] = $GPA;
               break;
           case 4: case 7:
               //Diploma Entry Qualification
               $setting_info = $this->setting_model->get_selection_criteria($programme,$ayear,4);
               $o_level_min_point = 0;
               $a_level_min_point = 0;
               $a_level_point = 0;
               $A_LEVEL_SUBJECT_HOLD = array();
               $A_LEVEL_SUBJECT_HOLD_SIX = array();
               $O_LEVEL_SUBJECT_HOLD = array();
               $O_LEVEL_SUBJECT_HOLD_FOUR = array();
                   //Form VI Entry Qualification
               include 'entryMode_Diploma.php';
               $applicant_data['status'] = $diploma_level_status;
               $applicant_data['comment'] = $diploma_level_remark;
               $applicant_data['point'] = $a_level_point;
               $applicant_data['form6_subject'] =json_encode($A_LEVEL_SUBJECT_HOLD_SIX);
               $applicant_data['form4_subject'] = json_encode($O_LEVEL_SUBJECT_HOLD_FOUR);
               $applicant_data['diploma_info'] = json_encode($DIPLOMA_LEVEL_HOLD);
               $applicant_data['sitting_no'] = $o_level_sitting_no;
               $applicant_data['gpa'] = $GPA;
               break;
           default:


               break;
       }



       $where1 = array(
           'applicant_id'=>$value->id,
           'ProgrammeCode'=>$programme,
           'choice'=>$choice
       );

       $already_exist = $this->db->where($where1)->get('application_elegibility')->row();
        if($already_exist){
            $this->db->update('application_elegibility', $applicant_data,array('id'=>$already_exist->id));
        }else {
        $this->db->insert('application_elegibility', $applicant_data);

       }


    }






 }

 ?>
