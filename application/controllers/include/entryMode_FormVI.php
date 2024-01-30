<?php
include 'entryMode_FormIV.php';


$a_level_status = 0;
$a_level_pass = 0;
$a_level_sitting_no = 0;
$a_level_point = 0;
$a_level_general_point = 0;
$is_eligible = 0;
$a_level_subject_pass = $setting_info->form6_pass <> '' ? $setting_info->form6_pass : 0;
$remark = '';
$A_LEVEL_SUBJECT_HOLD = array();
$A_LEVEL_SUBJECT_HOLD_SIX = array();
//Get Form VI exclusive subjects
$exclusive_subject6 = explode(',', $setting_info->form6_exclusive);

//Get Inclusive Subject
$inclusive_subject6 = json_decode($setting_info->form6_inclusive, true);
if ($a_level_subject_pass >= 0) {
    //Get all Form VI Certificates
    $A_LEVEL_CERTIFICATE_LIST = $this->db->where(array('certificate' => 2, 'applicant_id' => $applicant_id))->get('application_education_authority')->result();
    if(!$A_LEVEL_CERTIFICATE_LIST or count($A_LEVEL_CERTIFICATE_LIST)==0)
    {
        $A_LEVEL_CERTIFICATE_LIST = $this->db->where(array('certificate' => 2, 'index_number' => $f6_index_number))->get('application_education_authority')->result();
    }
    $a_level_sitting_no = count($A_LEVEL_CERTIFICATE_LIST); // count number of sitting
    $DETECT_REPEAT = array();
    $DGRADE_COUNT=0;
    //Start looping A-Level Certificate
    foreach ($A_LEVEL_CERTIFICATE_LIST as $AK => $AV) {
        $completed_year = (int)trim($AV->completed_year);// hold completed Year
        //Get A-Level Subject based on A-Level Certificate
        $A_LEVEL_SUBJECT_LIST = $this->db->where(array('certificate' => 2, 'applicant_id' => $applicant_id, 'authority_id' => $AV->id))->order_by('grade', 'ASC')->get('application_education_subject')->result();
        foreach ($A_LEVEL_SUBJECT_LIST as $SUB_KEY => $SUB_VALUE) {
            $grade = strtoupper(trim($SUB_VALUE->grade));
            $subject = trim($SUB_VALUE->subject);
            $A_LEVEL_SUBJECT_HOLD[$subject] = array('grade' => $grade, 'year' => $completed_year, 'principal' => 0, 'principal_pass' => 0);
            $A_LEVEL_SUBJECT_HOLD_SIX[$AV->index_number][] = get_value('secondary_subject',$subject,'shortname').'='.$grade;

            //Skip excluded Subject
            if (!in_array($subject, $exclusive_subject6)) {

                //Working with only required subject
                if(!array_key_exists($subject,$DETECT_REPEAT)) {
                    if($application_type==1)
                    {
                        //For Diploma include S
                        switch ($grade) {
                            case "A":
                                // if (array_key_exists($subject, $inclusive_subject6)) {
                                $a_level_point += 5;
                                $A_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                                //}
                                $a_level_general_point += 5;
                                $a_level_pass += 1;
                                $A_LEVEL_SUBJECT_HOLD[$subject]['principal_pass'] = 1;
                                $DGRADE_COUNT+=1;
                                break;
                            case "B":
                            case "B+":
                                // if (($completed_year == 2014 || $completed_year == 2015) && array_key_exists($subject, $inclusive_subject6)) {
                                if ($completed_year == 2014 || $completed_year == 2015){
                                    if ($grade == 'B+') {
                                        $a_level_point += 4;
                                        $a_level_general_point += 4;
                                    } else {
                                        $a_level_point += 3;
                                        $a_level_general_point += 3;
                                    }
                                    $A_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                                } else{// if (array_key_exists($subject, $inclusive_subject6)) {
                                    $a_level_point += 4;
                                    $a_level_general_point += 4;
                                    $A_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                                }
                                $a_level_pass += 1;
                                $A_LEVEL_SUBJECT_HOLD[$subject]['principal_pass'] = 1;
                                $DGRADE_COUNT+=1;
                                break;
                            case "C":
                                //if (($completed_year == 2014 || $completed_year == 2015) && array_key_exists($subject, $inclusive_subject6)) {
                                if ($completed_year == 2014 || $completed_year == 2015){
                                    $a_level_point += 2;
                                    $a_level_general_point += 2;
                                    $A_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                                } else { //if (array_key_exists($subject, $inclusive_subject6)) {
                                    $a_level_point += 3;
                                    $a_level_general_point += 3;
                                    $A_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                                }
                                $a_level_pass += 1;
                                $A_LEVEL_SUBJECT_HOLD[$subject]['principal_pass'] = 1;
                                $DGRADE_COUNT+=1;
                                break;
                            case "D":
                                //if (($completed_year == 2014 || $completed_year == 2015) && array_key_exists($subject, $inclusive_subject6)) {
                                if ($completed_year == 2014 || $completed_year == 2015){
                                    $a_level_point += 1;
                                    $a_level_general_point += 1;
                                } else{ // if (array_key_exists($subject, $inclusive_subject6)) {
                                    $a_level_point += 2;
                                    $a_level_general_point += 2;
                                    //$A_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                                }
                                if ($completed_year != 2014 && $completed_year != 2015) {
                                    $DGRADE_COUNT+=1;
                                    $A_LEVEL_SUBJECT_HOLD[$subject]['principal_pass'] = 1;
                                }
                                $a_level_pass += 1;
                                break;
                            case "E":
                                // if (($completed_year == 2014 || $completed_year == 2015) && array_key_exists($subject, $inclusive_subject6)) {
                                if ($completed_year == 2014 || $completed_year == 2015){
                                    $a_level_point += 0.5;
                                    $a_level_general_point += 0.5;
                                } else{ // if (array_key_exists($subject, $inclusive_subject6)) {
                                    $a_level_point += 1;
                                    $a_level_general_point += 1;
                                }
                                $a_level_pass += 1;
                                //$A_LEVEL_SUBJECT_HOLD[$subject]['principal_pass'] = 1;
                                break;
                            case "S":
                                // if (($completed_year == 2014 || $completed_year == 2015) && array_key_exists($subject, $inclusive_subject6)) {
                                if ($completed_year == 2014 || $completed_year == 2015){
                                    $a_level_point += 0;
                                    $a_level_general_point += 0;
                                } else{ // if (array_key_exists($subject, $inclusive_subject6)) {
                                    $a_level_pass += 1;
                                    $a_level_point += 0.5;
                                    $a_level_general_point += 0.5;
                                    //$A_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                                }
                                break;
                            default:
                                break;
                        }


                    }else
                    {
                        switch ($grade) {
                            case "A":
                                // if (array_key_exists($subject, $inclusive_subject6)) {
                                $a_level_point += 5;
                                $A_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                                //}
                                $a_level_general_point += 5;
                                $a_level_pass += 1;
                                $A_LEVEL_SUBJECT_HOLD[$subject]['principal_pass'] = 1;
                                break;
                            case "B":
                            case "B+":
                                // if (($completed_year == 2014 || $completed_year == 2015) && array_key_exists($subject, $inclusive_subject6)) {
                                if ($completed_year == 2014 || $completed_year == 2015){
                                    if ($grade == 'B+') {
                                        $a_level_point += 4;
                                        $a_level_general_point += 4;
                                    } else {
                                        $a_level_point += 3;
                                        $a_level_general_point += 3;
                                    }
                                    $A_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                                } else{// if (array_key_exists($subject, $inclusive_subject6)) {
                                    $a_level_point += 4;
                                    $a_level_general_point += 4;
                                    $A_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                                }
                                $a_level_pass += 1;
                                $A_LEVEL_SUBJECT_HOLD[$subject]['principal_pass'] = 1;
                                break;
                            case "C":
                                //if (($completed_year == 2014 || $completed_year == 2015) && array_key_exists($subject, $inclusive_subject6)) {
                                if ($completed_year == 2014 || $completed_year == 2015){
                                    $a_level_point += 2;
                                    $a_level_general_point += 2;
                                    $A_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                                } else { //if (array_key_exists($subject, $inclusive_subject6)) {
                                    $a_level_point += 3;
                                    $a_level_general_point += 3;
                                    $A_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                                }
                                $a_level_pass += 1;
                                $A_LEVEL_SUBJECT_HOLD[$subject]['principal_pass'] = 1;
                                break;
                            case "D":
                                //if (($completed_year == 2014 || $completed_year == 2015) && array_key_exists($subject, $inclusive_subject6)) {
                                if ($completed_year == 2014 || $completed_year == 2015){
                                    $a_level_point += 1;
                                    $a_level_general_point += 1;
                                } else{ // if (array_key_exists($subject, $inclusive_subject6)) {
                                    $a_level_point += 2;
                                    $a_level_general_point += 2;
                                    $A_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                                }
                                if ($completed_year != 2014 && $completed_year != 2015) {
                                    $a_level_pass += 1;
                                    $A_LEVEL_SUBJECT_HOLD[$subject]['principal_pass'] = 1;
                                }

                                break;
                            case "E":
                                // if (($completed_year == 2014 || $completed_year == 2015) && array_key_exists($subject, $inclusive_subject6)) {
                                if ($completed_year == 2014 || $completed_year == 2015){
                                    $a_level_point += 0;
                                    $a_level_general_point += 0;
                                } else{ // if (array_key_exists($subject, $inclusive_subject6)) {
                                    $a_level_point += 1;
                                    $a_level_general_point += 1;
                                    $A_LEVEL_SUBJECT_HOLD[$subject]['principal'] = 1;
                                }
                                break;
                            default:
                                break;
                        }
                    }

                }
            }

            $DETECT_REPEAT[$subject] = $subject;
        }

    }


    if($a_level_subject_pass <= $a_level_pass){
        $is_eligible = 1;
        $remark = "Eligible";
    }else{
        $is_eligible = 0;
        $remark = "Minimum  pass of $a_level_subject_pass form VI subject(s) required";
    }

    if($is_eligible) {
        if($a_level_min_point > 0){
            if($a_level_min_point <= $a_level_point){
                $is_eligible = 1;
                $remark = "Eligible";
            }else{
                $is_eligible = 0;
                $remark = "Form VI Minimum  point of $a_level_min_point is required";
            }
        }else{
            $is_eligible = 1;
            $remark = "Eligible";
        }

        if ($is_eligible) {
            // check if required subject has valid grades
            $required_not_found = 0;
            $required_check_fail = 0;
            foreach ($inclusive_subject6 as $req_K => $req_V) {
                if (array_key_exists($req_K, $A_LEVEL_SUBJECT_HOLD)) {
                    if ($A_LEVEL_SUBJECT_HOLD[$req_K]['year'] == 2014 || $A_LEVEL_SUBJECT_HOLD[$req_K]['year'] == 2015) {
                        if (is_grade_greater_equal($A_LEVEL_SUBJECT_HOLD[$req_K]['grade'], 'D')) {
                            if (!is_grade_greater_equal($A_LEVEL_SUBJECT_HOLD[$req_K]['grade'], $req_V)) {
                                $required_check_fail++;
                            }
                        } else {
                            $required_check_fail++;
                        }
                    } else {
                        if (!is_grade_greater_equal($A_LEVEL_SUBJECT_HOLD[$req_K]['grade'], $req_V)) {
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
                $remark = "Do not Pass required subjects of Form VI ->> AND CONDITION ";
            }
            //Now Check OR condition
            if ($is_eligible) {
                // check if required subject has valid grades == USING OR
                //Get  Subject by OR condition
                $inclusive_subject6_OR = json_decode($setting_info->form6_or_subject, true);
                $is_or_condition_passed = 0;
                $is_or_condition_passed_required = 0;
                if (count($inclusive_subject6_OR) > 0) {
                    $get_key_in_array = array_keys($inclusive_subject6_OR);
                    $get_subject_in_array = $inclusive_subject6_OR[$get_key_in_array[0]];
                    $tmp = explode('|', $get_key_in_array[0]);
                    $get_key_in_array_grade = $tmp[0];
                    $is_or_condition_passed_required = $tmp[1];
                    $total_subject_required_in_or = count($get_subject_in_array);
                    foreach ($get_subject_in_array as $p => $vp) {
                        if (array_key_exists($vp, $A_LEVEL_SUBJECT_HOLD)) {
                            if ($A_LEVEL_SUBJECT_HOLD[$req_K]['year'] == 2014 || $A_LEVEL_SUBJECT_HOLD[$req_K]['year'] == 2015) {
                                if (is_grade_greater_equal($A_LEVEL_SUBJECT_HOLD[$req_K]['grade'], 'D')) {
                                    if (is_grade_greater_equal($A_LEVEL_SUBJECT_HOLD[$vp]['grade'], $get_key_in_array_grade)) {
                                        $is_or_condition_passed++;
                                    }
                                }
                            } else {
                                if (is_grade_greater_equal($A_LEVEL_SUBJECT_HOLD[$vp]['grade'], $get_key_in_array_grade)) {
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
                    $remark = "Do not Pass  $is_or_condition_passed_required subject(s) required under OR CONDITION Form VI ";
                }






            }
        }
    }


} else {
    $is_eligible = 0;
    $remark = "Setting of subjects No. to pass Form VI not found";
}

if($o_level_status) {
    if ($is_eligible) {
        $a_level_status = 1;
    }

    $a_level_remark = $remark;
}else{
    $is_eligible = 0;
    $a_level_status = 0;
    $a_level_remark = $o_level_remark;
}




?>