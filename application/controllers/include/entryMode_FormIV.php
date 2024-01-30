<?php
$o_level_status = 0;
$o_level_pass = 0;
$o_level_sitting_no = 0;
$o_level_point = 0;
$o_level_general_point = 0;
$is_eligible = 0;
$o_level_subject_pass = $setting_info->form4_pass <> '' ? $setting_info->form4_pass : 0;
$remark = '';
$O_LEVEL_SUBJECT_HOLD = array();
$O_LEVEL_SUBJECT_HOLD_FOUR = array();
//Get Form IV exclusive subjects
$exclusive_subject4 = explode(',', $setting_info->form4_exclusive);

//Get Inclusive Subject
$inclusive_subject4 = json_decode($setting_info->form4_inclusive, true);
if ($o_level_subject_pass > 0) {
    //Get all Form IV Certificates
    $O_LEVEL_CERTIFICATE_LIST = $this->db->where(array('certificate' => 1, 'applicant_id' => $applicant_id))->get('application_education_authority')->result();
    $o_level_sitting_no = count($O_LEVEL_CERTIFICATE_LIST); // count number of sitting
    $DETECT_REPEAT = array();
    //Start looping O-Level Certificate
    foreach ($O_LEVEL_CERTIFICATE_LIST as $OK => $OV) {
        $completed_year = (int)trim($OV->completed_year);// hold completed Year
        //Get O-Level Subject based on O-Level Certificate
        $O_LEVEL_SUBJECT_LIST = $this->db->where(array('certificate' => 1, 'applicant_id' => $applicant_id, 'authority_id' => $OV->id))->order_by('grade', 'ASC')->get('application_education_subject')->result();
        foreach ($O_LEVEL_SUBJECT_LIST as $SUB_KEY => $SUB_VALUE) {
            $grade = strtoupper(trim($SUB_VALUE->grade));
            $subject = trim($SUB_VALUE->subject);
            $O_LEVEL_SUBJECT_HOLD[$subject] = array('grade' => $grade, 'year' => $completed_year, 'principal' => 0, 'principal_pass' => 0);
            $O_LEVEL_SUBJECT_HOLD_FOUR[$OV->index_number][] = get_value('secondary_subject',$subject,'shortname').'='.$grade;

            //Skip excluded Subject
            if (!in_array($subject, $exclusive_subject4)) {
                //Working with only required subject
                //Working with only required subject
                if(!array_key_exists($subject,$DETECT_REPEAT)) {
                    switch ($grade) {
                        case "A":
                           // if (array_key_exists($subject, $inclusive_subject4)) {
                                $o_level_point += 5;
                                $O_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                           // }
                            $o_level_general_point += 5;
                            $o_level_pass += 1;
                            $O_LEVEL_SUBJECT_HOLD[$subject]['principal_pass'] = 1;
                            break;
                        case "B":
                        case "B+":
                           // if (($completed_year == 2014 || $completed_year == 2015) && array_key_exists($subject, $inclusive_subject4)) {
                        if ($completed_year == 2014){
                            if ($grade == 'B+') {
                                    $o_level_point += 4;
                                    $o_level_general_point += 4;
                                } else {
                                    $o_level_point += 3;
                                    $o_level_general_point += 3;
                                }
                                $O_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                            } else { //if (array_key_exists($subject, $inclusive_subject4)) {
                                $o_level_point += 4;
                                $o_level_general_point += 4;
                                $O_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                            }
                            $o_level_pass += 1;
                            $O_LEVEL_SUBJECT_HOLD[$subject]['principal_pass'] = 1;
                            break;
                        case "C":
                            //if (($completed_year == 2014 || $completed_year == 2015) && array_key_exists($subject, $inclusive_subject4)) {
                            if ($completed_year == 2014){
                                $o_level_point += 2;
                                $o_level_general_point += 2;
                                $O_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                            } else{ // if (array_key_exists($subject, $inclusive_subject4)) {
                                $o_level_point += 3;
                                $o_level_general_point += 3;
                                $O_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                            }
                            $o_level_pass += 1;
                            $O_LEVEL_SUBJECT_HOLD[$subject]['principal_pass'] = 1;
                            break;
                        case "D":
                           // if (($completed_year == 2014 || $completed_year == 2015) && array_key_exists($subject, $inclusive_subject4)) {
                            if ($completed_year == 2014){
                                $o_level_point += 1;
                                $o_level_general_point += 1;
                            } else{ //if (array_key_exists($subject, $inclusive_subject4)) {
                                $o_level_point += 2;
                                $o_level_general_point += 2;
                                $O_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;


                            }
                            if ($completed_year != 2014) {
                                $o_level_pass += 1;
                                $O_LEVEL_SUBJECT_HOLD[$subject]['principal_pass'] = 1;
                            }

                            break;
                        case "E":
                           // if (($completed_year == 2014 || $completed_year == 2015) && array_key_exists($subject, $inclusive_subject4)) {
                            if ($completed_year == 2014){
                                $o_level_point += 0;
                                $o_level_general_point += 0;
                            } else if (array_key_exists($subject, $inclusive_subject4)) {
                                $o_level_point += 1;
                                $o_level_general_point += 1;
                            }
                            break;
                        default:
                            break;
                    }
                }
            }
            $DETECT_REPEAT[$subject] = $subject;
        }

    }


    if(($o_level_subject_pass <= $o_level_pass) or ($o_level_min_point <= $o_level_point)){
        $is_eligible = 1;
        $remark = "Eligible";
    }else{
        $is_eligible = 0;
        $remark = "Minimum  pass of $o_level_subject_pass form IV subject(s) required";
    }

    if($is_eligible) {
       if($o_level_min_point > 0){
          if($o_level_min_point <= $o_level_point){
              $is_eligible = 1;
              $remark = "Eligible";
          }else{
              $is_eligible = 0;
              $remark = "Form IV Minimum  point of $o_level_min_point is required";
          }
       }else{
           $is_eligible = 1;
           $remark = "Eligible";
       }

        if ($is_eligible) {
            // check if required subject has valid grades
            $required_not_found = 0;
            $required_check_fail = 0;
            foreach ($inclusive_subject4 as $req_K => $req_V) {
                if (array_key_exists($req_K, $O_LEVEL_SUBJECT_HOLD)) {
                    if ($O_LEVEL_SUBJECT_HOLD[$req_K]['year'] == 2014 || $O_LEVEL_SUBJECT_HOLD[$req_K]['year'] == 2015) {
                        if (is_grade_greater_equal($O_LEVEL_SUBJECT_HOLD[$req_K]['grade'], 'D')) {
                            if (!is_grade_greater_equal($O_LEVEL_SUBJECT_HOLD[$req_K]['grade'], $req_V)) {
                                $required_check_fail++;
                            }
                        } else {
                            $required_check_fail++;
                        }
                    } else {
                        if (!is_grade_greater_equal($O_LEVEL_SUBJECT_HOLD[$req_K]['grade'], $req_V)) {
                            $required_check_fail++;
                        }
                    }
                } else {
                    $required_not_found++;
                }
            }

            if ($required_check_fail == 0 && $required_not_found == 0) {
                $is_eligible = 1;
                $remark = 'Eligible';
            } else {
                $is_eligible = 0;
                $remark = "Do not Pass required subjects of Form IV ->> AND CONDITION ";
            }
            //Now Check OR condition
            if ($is_eligible) {

                // check if required subject has valid grades == USING OR
                //Get  Subject by OR condition
                $inclusive_subject4_OR = json_decode($setting_info->form4_or_subject, true);
                $is_or_condition_passed = 0;
                $is_or_condition_passed_required = 0;
                if (count($inclusive_subject4_OR) > 0) {
                    $get_key_in_array = array_keys($inclusive_subject4_OR);
                    $get_subject_in_array = $inclusive_subject4_OR[$get_key_in_array[0]];
                    $tmp = explode('|', $get_key_in_array[0]);
                    $get_key_in_array_grade = $tmp[0];
                    $is_or_condition_passed_required = $tmp[1];
                    $total_subject_required_in_or = count($get_subject_in_array);
                    foreach ($get_subject_in_array as $p => $vp) {
                        if (array_key_exists($vp, $O_LEVEL_SUBJECT_HOLD)) {
                            if ($O_LEVEL_SUBJECT_HOLD[$req_K]['year'] == 2014 || $O_LEVEL_SUBJECT_HOLD[$req_K]['year'] == 2015) {
                                if (is_grade_greater_equal($O_LEVEL_SUBJECT_HOLD[$req_K]['grade'], 'D')) {
                                    if (is_grade_greater_equal($O_LEVEL_SUBJECT_HOLD[$vp]['grade'], $get_key_in_array_grade)) {
                                        $is_or_condition_passed++;
                                    }
                                }
                            } else {
                                if (is_grade_greater_equal($O_LEVEL_SUBJECT_HOLD[$vp]['grade'], $get_key_in_array_grade)) {
                                    $is_or_condition_passed++;
                                }
                            }
                        }
                    }

                }

                if ($is_or_condition_passed >= $is_or_condition_passed_required) {
                    $is_eligible = 1;
                    $remark = 'Eligible';
                } else {
                    $is_eligible = 0;
                    $remark = "Do not Pass  $is_or_condition_passed_required subject(s) required under OR CONDITION Form IV ";
                }

                //Check number of passes


            }
        }
    }


} else {
    $is_eligible = 0;
    $remark = "Setting of subjects No. to pass Form IV not found";
}


if($is_eligible){
    $o_level_status = 1;
}

$o_level_remark = $remark;
