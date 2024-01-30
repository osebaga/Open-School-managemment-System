<?php
include  'entryMode_FormIV.php';


$GPA = 0;
$gpa_required = $setting_info->gpa_pass;
$diploma_level_status = 0;
$DIPLOMA_LEVEL_HOLD = array();
if($gpa_required > 0) {

    //Get all Diploma Certificate
    $this->db->where(array('certificate' => 1.5, 'applicant_id' => $applicant_id));
    //if($setting_info->keyword1 <> '') {
    // $this->db->like('programme_title', $setting_info->keyword1);
    //}
    $this->db->order_by('division', 'DESC');
    $DIPLOMA_CERTIFICATE = $this->db->get('application_education_authority')->row();
    if ($DIPLOMA_CERTIFICATE) {
        $DIPLOMA_LEVEL_HOLD[$DIPLOMA_CERTIFICATE->avn][] = "Programme Tittle = ". $DIPLOMA_CERTIFICATE->programme_title;
        $DIPLOMA_LEVEL_HOLD[$DIPLOMA_CERTIFICATE->avn][] = "RegNo = ".$DIPLOMA_CERTIFICATE->index_number;
        $DIPLOMA_LEVEL_HOLD[$DIPLOMA_CERTIFICATE->avn][] = "Institution = ".$DIPLOMA_CERTIFICATE->school;


        if ($DIPLOMA_CERTIFICATE->division >= $gpa_required) {
            if($setting_info->keyword1 <> '') {
                $contain_keyword = 0;
                foreach (explode(',',$setting_info->keyword1) as $k_w=>$v_v) {
                    if (strpos(strtolower($DIPLOMA_CERTIFICATE->programme_title), strtolower($v_v)) !== false) {

                        $contain_keyword++;
                    }
                }
                if($contain_keyword > 0){
                    $GPA = $DIPLOMA_CERTIFICATE->division;
                    $is_eligible = $diploma_level_status = 1;
                    $remark = "Eligible";
                }else{
                    $is_eligible = 0;
                    $remark = "NVA III Certificate tittle do not contain any of".$setting_info->keyword1.' as keyword';
                }
            }else {
                $GPA = $DIPLOMA_CERTIFICATE->division;
                $is_eligible = $diploma_level_status = 1;
                $remark = "Eligible";
            }
        } else {
            $is_eligible = 0;
            $remark = "Minimum GPA of $gpa_required is required";
        }
    } else {
        $is_eligible = 0;
        $remark = "No NVA III Certificate Information found";
    }

}else{
    $is_eligible = 0;
    $remark = "Minimum setting of GPA not found";
}



if($o_level_status) {
    if ($is_eligible) {
        $diploma_level_status = 1;
    }

    $diploma_level_remark = $remark;
}else{
    $is_eligible = 0;
    $diploma_level_status = 0;
    $diploma_level_remark = $o_level_remark;
}





