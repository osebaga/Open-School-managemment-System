<?php
/**
 * Created by PhpStorm.
 * User: miltone
 * Date: 5/13/17
 * Time: 9:04 AM
 */


/**
 * Get callback URL
 *
 * @return bool
 */
function get_callback()
{
    if (isset($_GET['callback'])) {
        return $_GET['callback'];
    }

    return FALSE;
}

function application_campus($val = null)
{
    $array = array(
        '1' => 'Dar es Salaam',
        '2' => 'Mwanza (Luchelele)',
        '3' => 'Morogoro (Wamo) '
       
    );
    if (!is_null($val)) {
        return $array[$val];
       
        }
   
    return $array;
}


/**
 * Check if callback URL is set
 *
 * @return bool|string
 */
function is_callback_set()
{
    if (isset($_GET['callback'])) {
        return '?callback=' . $_GET['callback'];
    }

    return FALSE;
}


/**
 * Encode table ID to large string of numbers
 *
 * @param $id
 * @return string
 */
function encode_id($id)
{
    $string = "ABCDEFGHIJKLMNOPQRSTUVXWZ";
    $rand = str_split($string);
    $left = array_rand($rand, 1);
    $right = array_rand($rand, 1);

    $build_query = $left . '_' . $id . '_' . $right;
    $strt_arry = str_split($build_query);
    $arry = array();
    foreach ($strt_arry as $kx => $vx) {
        $re = unpack('C*', $vx);
        if (strlen($re[1]) === 3) {
            $arry[] = $re[1];
        } else {
            $arry[] = '0' . $re[1];
        }
    }

    return $parameter = implode('', $arry);
}


/**
 * Decode string to normal table ID
 *
 * @param $string
 * @return null
 */
function decode_id($string)
{
    $str = join(array_map('chr', str_split($string, 3)));
    $exp = explode('_', $str);
    if (count($exp) == 3) {
        return $exp[1];
    } else {
        return NULL;
    }
}

 

/**
 * @author  Kevin van Zonneveld <kevin@vanzonneveld.net>
 * @author  Simon Franz
 * @author  Deadfish
 * @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
 * @version   SVN: Release: $Id: alphaID.inc.php 344 2009-06-10 17:43:59Z kevin $
 * @link      http://kevin.vanzonneveld.net/
 *
 * @param mixed $in String or long input to translate
 * @param boolean $to_num Reverses translation when true
 * @param mixed $pad_up Number or boolean padds the result up to a specified length
 * @param string $passKey Supplying a password makes it harder to calculate the original ID
 *
 * @return mixed string or long
 */
function alphaID($in, $to_num = false, $pad_up = false, $passKey = null)
{

    $index = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    if ($passKey !== null) {

        for ($n = 0; $n < strlen($index); $n++) {
            $i[] = substr($index, $n, 1);
        }

        $passhash = hash('sha256', $passKey);
        $passhash = (strlen($passhash) < strlen($index)) ? hash('sha512', $passKey) : $passhash;

        for ($n = 0; $n < strlen($index); $n++) {
            $p[] = substr($passhash, $n, 1);
        }

        array_multisort($p, SORT_DESC, $i);
        $index = implode($i);
    }

    $base = strlen($index);

    if ($to_num) {
        // Digital number  <<--  alphabet letter code
        $in = strrev($in);
        $out = 0;
        $len = strlen($in) - 1;
        for ($t = 0; $t <= $len; $t++) {
            $bcpow = bcpow($base, $len - $t);
            $out = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
        }

        if (is_numeric($pad_up)) {
            $pad_up--;
            if ($pad_up > 0) {
                $out -= pow($base, $pad_up);
            }
        }
        $out = sprintf('%F', $out);
        $out = substr($out, 0, strpos($out, '.'));
    } else {
        // Digital number  -->>  alphabet letter code
        if (is_numeric($pad_up)) {
            $pad_up--;
            if ($pad_up > 0) {
                $in += pow($base, $pad_up);
            }
        }

        $out = "";
        for ($t = floor(log($in, $base)); $t >= 0; $t--) {
            $bcp = bcpow($base, $t);
            $a = floor($in / $bcp) % $base;
            $out = $out . substr($index, $a, 1);
            $in = $in - ($a * $bcp);
        }
        $out = strrev($out); // reverse
    }

    return $out;
}


function GetStudentAccoountBalance($regno)
{
    $CI = &get_instance();
    $ayear = $CI->common_model->get_account_year()->row()->AYear;
    $debt = $CI->db->query("select   sum(amount) as total from student_invoice where regno='$regno' and ayear='$ayear' and side='DR' ")->row()->total;
    $credit = $CI->db->query("select   sum(amount) as total from student_invoice where regno='$regno' and ayear='$ayear' and side='CR' ")->row()->total;
    $credit_payment_current_ayear = $CI->db->query("select   sum(paid_amount) as total from payment where student_id='$regno' and a_year='$ayear' and  (fee_category=2 or  	fee_category=1 or  	fee_category=3)  ")->row()->total;
    $credit_payment_current_ayear_sponsored = $CI->db->query("select   sum(spoonsored_students_invoice.amount) as total from spoonsored_students_invoice inner join invoices on invoices.id=spoonsored_students_invoice.invoice_number where regno='$regno' and status=2 and a_year='$ayear'   ")->row()->total;
    $credit_payment_current_ayear += $credit_payment_current_ayear_sponsored;


    $debt_back = $CI->db->query("select   sum(amount) as total from student_invoice where regno='$regno' and ayear<'$ayear' and side='DR' ")->row()->total;
    $credit_back = $CI->db->query("select   sum(amount) as total from student_invoice where regno='$regno' and ayear<'$ayear' and side='CR' ")->row()->total;

    $credit_payment_back_ayear = $CI->db->query("select   sum(paid_amount) as total from payment where student_id='$regno' and a_year<'$ayear' and a_year > '2020/2021'  and  (fee_category=2 or  	fee_category=1 or  	fee_category=3)")->row()->total;
    $credit_payment_back_ayear_sponsored = $CI->db->query("select   sum(spoonsored_students_invoice.amount) as total from spoonsored_students_invoice inner join invoices on invoices.id=spoonsored_students_invoice.invoice_number where regno='$regno' and status=2 and a_year<'$ayear'  and a_year > '2020/2021'")->row()->total;
    $credit_payment_back_ayear += $credit_payment_back_ayear_sponsored;

    $credit_back += $credit_payment_back_ayear;
    $total_current_debt = 0;
    $total_current_credit = 0;
    $total_back_debit = 0;
    $total_back_credit = 0;
    if ($debt_back > $credit_back) {
        $total_back_debit = ($debt_back - $credit_back);
    } elseif ($credit_back > $debt_back) {
        $total_back_credit = ($credit_back - $debt_back);
    }


    $total_current_debt = ($debt + $total_back_debit);
    $total_current_credit = ($credit + $total_back_credit + $credit_payment_current_ayear);

    return $total_current_debt . "_" . $total_current_credit;


}


function get_user_group($id = null)
{
    $CI = &get_instance();

    $id || $id = $CI->session->userdata('sims_online_user_id');

    $groupinfo = $CI->ion_auth_model->get_users_groups($id)->row();

    if ($groupinfo) {
        return $groupinfo;
    }

    return false;
}


/**
 * Update Users Access Level
 *
 * @param $user_id
 * @param $module_id
 * @param $link
 * @param $action
 * @return bool
 */
function update_access($group_id, $module_id, $section, $role, $action)
{

    $CI = &get_instance();
    if ($action == 'ADD') {
        if (!has_role($module_id, $group_id, $section, $role)) {

            $CI->db->where("group_id", $group_id);
            $CI->db->where("module_id", $module_id);
            $CI->db->where("section", $section);
            $row = $CI->db->get("module_group_role")->row();

            if ($row) {
                $json = json_decode($row->role, true);

                if (is_array($json) && !in_array($role, $json)) {

                    array_push($json, $role);
                    $array = array('role' => json_encode(array_values($json)));
                    return $CI->db->update("module_group_role", $array, array('group_id' => $group_id, 'module_id' => $module_id, 'section' => $section));
                }
                return true;
            } else {
                $array = array(
                    'group_id' => $group_id,
                    'module_id' => $module_id,
                    'section' => $section,
                    'role' => json_encode(array($role))
                );

                return $CI->db->insert("module_group_role", $array);
            }
        }
    } else if ($action == 'DELETE') {
        if (has_role($module_id, $group_id, $section, $role)) {
            $CI->db->where("group_id", $group_id);
            $CI->db->where("module_id", $module_id);
            $CI->db->where("section", $section);
            $row = $CI->db->get("module_group_role")->row();
            if ($row) {
                $json = json_decode($row->role, true);
                if (is_array($json) && in_array($role, $json)) {
                    if (($key = array_search($role, $json)) !== false) {
                        unset($json[$key]);
                    }

                    $array = array('role' => json_encode(array_values($json)));
                    if (count($json) == 0) {
                        return $CI->db->update("module_group_role", $array, array('group_id' => $group_id, 'module_id' => $module_id, 'section' => $section));
                    } else {
                        return $CI->db->update("module_group_role", $array, array('group_id' => $group_id, 'module_id' => $module_id, 'section' => $section));
                    }

                }
                return false;
            }
        }
    }


}


/**
 * Check if user has role in a certain link
 * @param $module_id
 * @param $link
 * @return bool
 */

function has_role($module_id, $group_id, $section, $role)
{

    $CI = &get_instance();
    $CI->db->where("group_id", $group_id);
    $CI->db->where("module_id", $module_id);
    $CI->db->where("section", $section);
    $row = $CI->db->get("module_group_role")->row();

    if ($row) {

        $json = json_decode($row->role, true);
        if (is_array($json) && in_array($role, $json)) {
            return true;
        }
        return false;

    }
    return FALSE;

}

/**
 * User has role in section
 * @param $module_id
 * @param $group_id
 * @param $section_id
 * @return bool
 */
function has_section_role($module_id, $group_id, $section)
{
    $CI = &get_instance();
    $CI->db->where("group_id", $group_id);
    $CI->db->where("module_id", $module_id);
    $CI->db->where("section", $section);
    $row = $CI->db->get("module_group_role")->row();
    if ($row) {
        $json = json_decode($row->role, true);
        if (count($json) > 0) {
            return true;
        }
        return false;

    }
    return FALSE;

}

function sims_syncronise($datatype)
{
    $CI = &get_instance();

    $send_data = array(
        'datatype' => $datatype,
        'key' => SIMS_API_KEY
    );

    $send_json_string = json_encode($send_data);

    $CI->curl->create(SIMS_API_URL);
    $CI->curl->options(
        array(
            CURLOPT_HTTPHEADER => array('Content-Type: application/xml'),
            CURLOPT_POSTFIELDS => $send_json_string,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1
        )
    );
    $response = $CI->curl->execute();
    $response = json_decode($response);

    if (json_last_error() === JSON_ERROR_NONE) {
        return $response;
    } else {
        return false;
    }


}

function get_nta_levelname($level, $years_4 = null)
{
    if ($years_4 == '4YPR') {
        return 'UQF : 6';
    } else {
        if ($level == 4) {
            return 'NTA LEVEL : 4';
        } else if ($level == 5) {
            return 'NTA LEVEL : 5';
        } else if ($level == 6) {
            return 'NTA LEVEL  : 6';
        } else if ($level == 7) {
            return 'NTA LEVEL : 7';
        } else if ($level == 8) {
            return 'NTA LEVEL  : 8';
        } else {
            return 'NTA LEVEL : ' . $level;
        }
    }
}

function get_application_deadline()
{
    $CI = &get_instance();
    $row = $CI->common_model->get_application_deadline()->row();
    if ($row) {
        return $row->deadline;
    } else {
        return date('Y-m-d', strtotime('2020-01-01'));
    }
}

function entry_type($val = null)
{
    $array = array(
        '1' => 'Form IV',
//       // '1.5'=>'VETA Level III',
        '2' => 'Form VI',
        '3' => 'NTA Level 4 / Technician',
        '4' => 'Diploma',
//        '7' => 'Degree',
//        '8' => 'Masters'
    );
    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}

function addition_certificate($val = null,$application_type=null)
{
    $array = array(
        100 => 'Birth Certificate',
        101 => 'Others',
        102 => ' Internship Certificate',
        103 => 'Professional Registration',
        104 => 'Curriculum  Vitae (CV)',
    );
    if($application_type < 3){
        unset($array[102]);
        unset($array[103]);
        unset($array[104]);
    }

    if (!is_null($val)) {
        if (!array_key_exists($val, $array)) {
            return $array[$val];
        }
    }

    return $array;


}

function entry_type_certificate($val = null)
{
    $array = array(
        '1' => 'O-Level Certificate',
//        '1.5'=>'VETA Level III',
        '2' => 'A-Level Certificate',
        '3' => 'NTA Level 4 Certificate/Teachers Certificate',
        '4' => 'Diploma Certificate / Transcript',
//        '7' => 'Degree Certificate / Transcript',
//        '8' => 'Masters'
    );

    if (!is_null($val)) {
        if($val > 101) {
            $array = $array + addition_certificate(null,3);
        }else{
            $array = $array + addition_certificate();
        }


        /*if(!array_key_exists($val,$array)){
           switch ($val){
               case 100:
                   return '';
                   break;
               case 101:
                   return 'Others';
                   break;
               case 102:
                   return 'Birth Certificate';
                   break;
           }
        }else {*/
        return $array[$val];
        // }
    }
    return $array;
}

function entry_type_human($val = null)
{
    $array = array(
        '1' => 'O-Level',
        '1.5'=>'VETA Level III',
        '2' => 'A-Level',
        '3' => 'NTA Level 4',
        '4' => 'Diploma',
        '7' => 'Degree',
        '8' => 'Masters'
    );
    if (!is_null($val)) {
        if (!array_key_exists($val, $array)) {
            return '';
        } else {
            return $array[$val];
        }
    }
    return $array;
}

function certificate_by_entry_type($type)
{
    $return = entry_type_certificate();
    switch ($type) {
        case 1:
            // unset($return[2]);
            unset($return['1.5']);
            unset($return[3]);
            unset($return[4]);
            unset($return[7]);
            unset($return[8]);
            break;
        case 1.5:
            unset($return[2]);
            unset($return[1]);
            unset($return[3]);
            unset($return[4]);
            unset($return[7]);
            unset($return[8]);
            break;
        case 2:
            unset($return[3]);
            unset($return['1.5']);
            unset($return[4]);
            unset($return[7]);
            unset($return[8]);
            break;
        case 3:
            unset($return[2]);
            unset($return['1.5']);
            unset($return[4]);
            unset($return[7]);
            unset($return[8]);
            break;
        case 4:
            unset($return[3]);
            unset($return[7]);
            unset($return[8]);
            break;
        case 7:
            unset($return[8]);
            break;
    }
    return $return;
}

function center_premises_attachment($premises)
{
    $return = center_owner_attachment();
    switch ($premises) {
        case 1:
            unset($return[2]);
            unset($return[3]);
            break;

        case 2:
            unset($return[1]);
            unset($return[3]);
            break;

        case 3:
            unset($return[1]);
            unset($return[2]);
            break;
    }
    return $return;
}

function check_deadline()
{
    $CI = &get_instance();
    $row = $CI->common_model->get_application_deadline()->row();
    if ($row) {
        return $row;
    } else {
        return date('Y-m-d', strtotime('2015-01-01'));
    }
}
function iposa_eduction_type($val = null)
{
    $array = array(
        '1' => 'Sijasoma',
        '2' => 'Kudondoka Msingi',
        '3' => 'Darasa la Saba',
        '4' => 'Kudondoka Sekondari',
        '5' => 'Nimefeli Sekondari',
        '6' => 'Memkwa'
    );
    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}

function iposa_job_type($val = null)
{
    $array = array(
        '1' => 'Sina Kazi',
        '2' => 'Biashara',
        '3' => 'Mkulima ',
        '4' => 'Mfugaji',
        '5' => 'Nyinginezo',
    );
    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}
function iposa_disability_type($val = null)
{
    $array = array(
        '1' => 'Sio mlemavu',
        '2' => 'Kuona',
        '3' => 'Kusikia ',
        '4' => 'Viungo Vya mwili',
        '5' => 'Ngozi',
        '6' => 'Akili'
    );
    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}


function application_type($val = null)
{
    $array = array(
        '1' => 'Holder of Certificate in Primary Education',
        '2' => 'CSEE Resisters',
        '3' => 'ACSEE Resisters',
        '4' => 'Secondary Education Dropout',
        '5' => 'Holder of CSEE who want to sit for ACSEE',

    );

    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}

function entry_qualification($val = null)
{
    $array = array(
        '1' => 'Holder of Certificate in Primary Education',
        '2' => 'CSEE Resisters',
        '3' => 'ACSEE Resisters',
        '4' => 'Secondary Education Dropout',
        '5' => 'Holder of CSEE who want to sit for ACSEE',

    );

   
    if (!is_null($val)) {
        if ($val==1) {
            unset($array['1']);
            unset($array['2']);
            unset($array['3']);
            unset($array['4']);
            unset($array['5']);

        }elseif($val==2) {
            unset($array['2']);
            unset($array['3']);
            unset($array['4']);
            unset($array['5']);
        }elseif ($val==3) {

        }
        
    }
    return $array;
}

function application_programme($val = null)
{
    $array = array(
        '1' => 'IPOSA',
        '2' => 'IPPE',
        '3'=>  'ASEPLC',

    );

    if(check_deadline()->diploma==0)
    {
        unset($array['1']);
        unset($array['2']);
    }
    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}

function learning_session($val = null)
{
    $array = array(
        '1' => 'Morning Only',
        '2' => 'Evening Only',
        '3' => 'Morning to Afternoon',
        
    );

    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}

function administrator($val = null)
{
    $array = array(
        '1' => 'Manager/Supervisor',
        '2' => 'Academic Coordinator',
        '3' => "Student's Counsellor",
        '4' => "Courses/Skills Offered Under IPPE",
    );

    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}

function center_application($val = null)
{
    $array = array(
        '1' => 'NEW CENTER',
        '2' => 'RENEW CENTER',

    );

    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}

function center_premises($val = null)
{
    $array = array(
        '1' => 'Rented',
        '2' => 'Personal property',
        '3' => 'Government/CBOs',
    );

    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}

function center_owner_attachment($val = null)
{
    $array = array(
        '1' => 'Certified Copy of Contract (at least three years)',
        '2' => 'Copy of Title Deed',
        '3' => 'Memorandum of Understanding (MoU) ',
        '4' => 'Non-formal Secondary Education Programme',
        '5' => 'Physical Infrastructure and Facilities',
        '6' => 'Teaching and Learning Materials', 
        '7' => 'Teachers/Facilitators and their respective Qualification', 

    );

    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}

function Rounds($val = null)
{
    $array = array(
        '1' => 'First Round',
        '2' => 'Second Round',
        '3' => 'Third Round',
        '4' => 'Fourth Round'
    );

    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}

function center_status($val = null)
{
    $array = array(
        '1' => 'Active',
        '2' => 'Expired',
        '3' => 'Re-Newed',
     
    );
    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}

function student_status($val = null)
{
    $array = array(
        '1' => 'Active',
        '2' => 'Inactive',
     
    );
    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}

function center_category($val = null)
{
    $array = array(
        '1' => 'IAE',
        '2' => 'PRIVATE',
     
    );
    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}

function application_type_search($val = null)
{
    $array = array(
        '1' => 'Certificate/Diploma',
        '2' => 'Bachelor',
//        '3' => 'Post Graduate'
    );

    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}


function attachment_required($inputname, $label = null)
{
    $CI = &get_instance();

    if (isset($_FILES[$inputname]['name']) && !empty($_FILES[$inputname]['name'])) {
        return true;
    }
    $CI->form_validation->set_rules($inputname, (!is_null($label) ? $label : $inputname), 'required');
    return false;

}

function grade_list()
{
    return array('A', 'B+', 'B', 'C', 'D', 'E', 'F', 'S');
}

function is_grade_greater_equal($grade1, $grade2)
{
    $grades = grade_list();
    $index_grade1 = array_search($grade1, $grades);
    $index_grade2 = array_search($grade2, $grades);
    if ($index_grade1 <= $index_grade2) {
        return true;
    }

    return false;
}

function grade_point($grade)
{
    array('A' => 10, 'B+' => 9, 'B' => 8, 'C' => 7, 'D' => 6, 'E' => 5, 'S' => 4, 'F' => 3);
}

function get_file_mimetype($filename)
{
    $CI = &get_instance();
    $CI->load->library("FileMimeType");
    return $CI->filemimetype->get_mime_type($filename);
}

function application_status($id = null)
{
    $array = array(
        '0' => 'Incomplete',
        '1' => 'Submitted',
        '2' => 'Rejected',
        '3' => 'Approved',
        '4' => 'In Progress',
        '5' => 'Verified',
       

    );

    if (!is_null($id)) {
        if (!array_key_exists($id, $array)) {
            return '';
        } else {
            return $array[$id];
        }
    }
    return $array;
}

function programme_duration($application_type, $entry)
{
    if ($application_type == 2) {
        return 3;
    } else {
        $d = 3;
        switch ($entry) {
            CASE 1 :
                $d = 3;
                break;
            case 2:
                $d = 2;
                break;
            case 3:
                $d = 2;
                break;
            default:
                $d = 3;
                break;
        }

        return $d;
    }
}

function experience($id = null)
{
    $array = array(
        '1' => 'Internship',
        '2' => 'Professional Training',
        '3' => 'Work Experience'
    );

    if (!is_null($id)) {
        return $array[$id];
    }
    return $array;
}

function duration($id = null)
{
    $array = array(
        '' => '',
        '' => '',
        '' => '',
    );
}
function yes_no($id=null){
    $array=array(
        '1'=>'Yes',
        '0'=>'No'
    );
    if(!is_null($id)){
        return $array[$id];
    }

    return $array;
}

function CSEE_type($id=null){
    $array=array(
        '1'=>'Arusha',         
        '2'=>'Dar es Salaam',   
        '3'=>'Dodoma',          
        '4'=>'Geita',          
        '5'=>'Iringa',          
        '6'=>'Kagera',          
        '7'=>'Katavi',          
        '8'=>'Kigoma',          
        '9'=>'Kilimanjaro',     
        '10'=>'Singida',    
        '11'=>'Tanga',   
        '12'=>'Lindi',           
        '13'=>'Manyara',         
        '14'=>'Mara',            
        '15'=>'Mbeya',           
        '16'=>'Songwe', 
        '17'=>'Morogoro',        
        '18'=>'Mtwara',         
        '19'=>'Mwanza',          
        '20'=>'Njombe',         
        '21'=>'Pwani',          
        '22'=>'Rukwa',          
        '23'=>'Ruvuma',          
        '24'=>'Shinyanga',       
        '25'=>'Simiyu',          
        '26'=>'Tabora'          
        
    );
    if(!is_null($id)){
        return $array[$id];
    }

    return $array;
}

function get_country($id,$column='Country'){
    $CI = &get_instance();
    $row = get_value('nationality',$id,null);
    if($row){
        return $row->{$column};
    }
    return '';
}

function GetNumberOfDaysBetweenDates($from,$to='')
{
    $from=date('Y-m-d',strtotime($from));
    if($to=='')
    {
        $to=date('Y-m-d');

    }
    $earlier = new DateTime($from);
    $later = new DateTime($to);

    $diff = $later->diff($earlier)->format("%a");
    return $diff;
}

function remoteFileExists($url) {
    $curl = curl_init($url);

    //don't fetch the actual page, you only want to check the connection is ok
    curl_setopt($curl, CURLOPT_NOBODY, true);

    //do request
    $result = curl_exec($curl);

    $ret = false;

    //if request did not fail
    if ($result !== false) {
        //if request was ok, check response code
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($statusCode == 200) {
            $ret = true;
        }
    }

    curl_close($curl);

    return $ret;
}


function sendDataOverPost($url,$postdata)
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output=curl_exec($ch);
    curl_close($ch);
    return $output;

}



function sendJsonlOverPost($url, $postdata)
{


    $headers = array(
        "Content-type: application/json"
    , "Content-length: " . strlen($postdata)
    , "Connection: close"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;

}

function recommendation_rate($id=null){
    $array= array(
        '5'=>'Excellent',
        '4'=>'Very Good',
        '3'=>'Good',
        '2'=>'Average',
        '1'=>'Low',
    );

    if(!is_null($id)){
        return $array[$id];
    }

    return $array;
}
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}


function recommendation_overall($id=null){
    $array= array(
        '4'=>'Highly Recommended',
        '3'=>'Recommended',
        '2'=>'Recommended with some reservations',
        '1'=>'Not Recommended',
    );

    if(!is_null($id)){
        return $array[$id];
    }

    return $array;
}

function  GetFeeTypeDetails($code=null){
    $CI = &get_instance();
    if(!is_null($code))
    {
        $CI->db->where(array('code'=>$code,'hidden'=>0));
        return $CI->db->get('fee_type')->row();
    }else
    {
        $CI->db->where(array('hidden'=>0));
        return $CI->db->get('fee_type')->result();
    }

}

function NTA_Fee_Categories($val = null)
{
    $array=array(
        '1'=>'Direct Cost',
        '2'=>'Tuition Fee',
        '3'=>'Accommodation',
        '4'=>'Carry over subject(s)',
        "0"=>"Others"
    );
    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}
function NTA_Levels($val = null)
{
    $array=array(
        '4'=>'Basic certificate (NTA level 4)',
        '5'=>'Technician certificate (NTA Level 5)',
        '6'=>'Diploma (NTA level 6)',
        '7'=>'Bachelor Degree First Year(NTA level 7)',
        '7.2'=>'Bachelor Degree Second Year (NTA level 7)',
        '8'=>'Bachelor Degree 3 Third Year (NTA level 8)',
        'BAODL'=>"Basic Technician Certificate in Distance Education",
        "TODL" =>"Technician Certificate in Distance Education",
        'ODL1'=>'Ordinary Diploma  (First Year) ',
        'ODL2'=>'Ordinary Diploma  (Second Year) ',
        'ODL3'=>'Ordinary Diploma  (Third Year) ',
        'BODL1'=>'Bachelor  Degree ODL First Year(NTA level 7) ',
        'BODL2'=>'Bachelor Degree ODL Second Year(NTA level 7) ',
        'BODL3'=>'Bachelor Degree  ODL Third Year(NTA level 8) '

    );
    if (!is_null($val)) {
        return $array[$val];
    }
    return $array;
}

 
function CreateUploadJson($firstname, $secondname, $surname, $DOB, $gender, $impairement, $form_four_indexnumber,
                          $form_four_year, $form_six_indexnumber, $form_six_year, $NTA4_reg, $NTA4_grad_year, $NTA5_reg, $NTA5_grad_year,
                          $email_address, $mobile_number, $address, $region, $district, $next_kin_name,
                          $next_kin_phone, $next_kin_address, $next_kin_email_address, $next_kin_relation, $next_kin_region, $nationality,
                          $programme_id, $payment_reference_number, $application_year, $intake, $level)
{

    $authorization = "1afeaba8fb287facbb701f3c32aee296401cf780";
    $array = array(
        array(
            "heading" => array(
                "authorization" => $authorization,
                "intake" => $intake,
                "programme_id" => $programme_id,
                'application_year' => $application_year,
                'level' => $level,
                'payment_reference_number' => $payment_reference_number
            ),
            "students" => array(array(
                "particulars" => array(
                    'firstname' => $firstname,
                    'secondname' => (trim($secondname) == '') ? '' : $secondname,
                    'surname' => $surname,
                    'DOB' => $DOB,
                    'gender' => $gender,
                    'impairement' => $impairement,
                    'form_four_indexnumber' => $form_four_indexnumber,
                    'form_four_year' => $form_four_year,
                    'form_six_indexnumber' => (trim($form_six_indexnumber) == '') ? '' : $form_six_indexnumber,
                    'form_six_year' => (trim($form_six_year) == '') ? '' : $form_six_year,
                    'NTA4_reg' => (trim($NTA4_reg) == '') ? '' : $NTA4_reg,
                    'NTA4_grad_year' => (trim($NTA4_grad_year) == '') ? '' : $NTA4_grad_year,
                    'NTA5_reg' => (trim($NTA5_reg) == '') ? '' : $NTA5_reg,
                    'NTA5_grad_year' => (trim($NTA5_grad_year) == '') ? '' : $NTA5_grad_year,
                    'email_address' => (trim($email_address) == '') ? '' : $email_address,
                    'mobile_number' => (trim($mobile_number) == '') ? '' : $mobile_number,
                    'address' => (trim($address) == '') ? '' : $address,
                    'region' => (trim($region) == '') ? '' : $region,
                    'district' => (trim($district) == '') ? '' : $district,
                    'nationality' => (trim($nationality) == '') ? '' : $nationality,
                    'next_kin_name' => (trim($next_kin_name) == '') ? '' : $next_kin_name,
                    'next_kin_address' => (trim($next_kin_address) == '') ? '' : $next_kin_address,
                    'next_kin_email_address' => (trim($next_kin_email_address) == '') ? '' : $next_kin_email_address,
                    'next_kin_phone' => (trim($next_kin_phone) == '') ? '' : $next_kin_phone,
                    'next_kin_region' => (trim($next_kin_region) == '') ? '' : $next_kin_region,
                    'next_kin_relation' => (trim($next_kin_relation) == '') ? '' : $next_kin_relation
                )
            )
            )
        )
    );


//    $response='<request>
//                 <params>
//                    <authorization>'.$authorization.'</authorization>
//                    <firstname>'.$firstname.'</firstname>
//                    <secondname>'.$secondname.'</secondname>
//                    <surname>'.$surname.'</surname>
//                    <DOB>'.$DOB.'</DOB>
//                    <gender>'.$gender.'</gender>
//                    <impairement>'.$impairement.'</impairement>
//                    <form_four_indexnumber>'.$form_four_indexnumber.'</form_four_indexnumber>
//                    <form_four_year>'.$form_four_year.'</form_four_year>
//                    <form_six_indexnumber>'.$form_six_indexnumber.'</form_six_indexnumber>
//                    <form_six_year>'.$form_six_year.'</form_six_year>
//                    <NTA4_reg>'.$NTA4_reg.'</NTA4_reg>
//                    <NTA4_grad_year>'.$NTA4_grad_year.'</NTA4_grad_year>
//                    <NTA5_reg>'.$NTA5_reg.'</NTA5_reg>
//                    <NTA5_grad_year>'.$NTA5_grad_year.'</NTA5_grad_year>
//                    <email_address>'.$email_address.'</email_address>
//                    <mobile_number>'.$mobile_number.'</mobile_number>
//                    <address>'.$address.'</address>
//                    <region>'.$region.'</region>
//                    <district>'.$district.'</district>
//                    <next_kin_name>'.$next_kin_name.'</next_kin_name>
//                    <next_kin_phone>'.$next_kin_phone.'</next_kin_phone>
//                    <next_kin_address>'.$next_kin_address.'</next_kin_address>
//                    <next_kin_relation>'.$next_kin_relation.'</next_kin_relation>
//                    <next_kin_region>'.$next_kin_region.'</next_kin_region>
//                    <nationality>'.$nationality.'</nationality>
//                     <programme_id>'.$programme_id.'</programme_id>
//                     <payment_reference_number>'.$payment_reference_number.'</payment_reference_number>
//                     <application_year>'.$application_year.'</application_year>
//                      <intake>'.$intake.'</intake>
//                </params>
//              </request>';
//
//    $xmlObject = simplexml_load_string($response);
    return json_encode($array, JSON_PRETTY_PRINT);

}

function CreateVerificationJson($student_verification_id, $program_id, $firstname, $secondname, $surname, $mobile_number, $email_address, $form_four_indexnumber,
                                $form_four_year, $form_six_indexnumber, $form_six_year, $NTA4_reg, $NTA4_grad_year, $NTA5_reg, $NTA5_year, $intake, $year, $level)
{

    //1afeaba8fb287facbb701f3c32aee296401cf780
    $authorization = "1afeaba8fb287facbb701f3c32aee296401cf780";
    //$authorization='sdfsdfsf';

//    $array = array(
//
//            'heading' => array(
//                'authorization' => $authorization,
//                'intake'=>'SEPT',
//                'programme_id' => $program_id,
//                'academic_year' => $year,
//                'level' => $level
//            ),
//
//            "students" => array(
//
//                [
//                    "student" => array(
//                        "student_verification_id" => $student_verification_id,
//                        "firstname" => $firstname,
//                        "secondname" => $secondname,
//                        "surname" => $surname,
//                        "mobile_number" => $mobile_number,
//                        "email_address" => $email_address,
//                        "form_four_indexnumber" => $form_four_indexnumber,
//                        "form_four_year" => $form_four_year,
//                        "form_six_indexnumber" => $form_six_indexnumber,
//                        "form_six_year" => $form_six_year,
//                        "NTA4_reg" => $NTA4_reg,
//                        "NTA4_grad_year" => $NTA4_grad_year,
//                        "NTA5_reg" => $NTA5_reg,
//                        "NTA5_grad_year" => $NTA5_year
//                    )
//                ]
//
//
//
//        ));


    $data = array(
        'heading' => array(
            'authorization' =>$authorization,
            'intake' => 'SEPT',
            'programme_id' => $program_id,
            'academic_year' => $year,
            'level' => '4',
        ),
        'students' => array(
            ['student' => array(
                'student_verification_id' => $student_verification_id,
                'firstname' => $firstname,
                'secondname' => $secondname,
                'surname' => $surname,
                'email_address' => $email_address,
                'mobile_number' => $mobile_number,
                'form_four_indexnumber' => $form_four_indexnumber,
                'form_four_year' => $form_four_year,
                'form_six_indexnumber' => $form_six_indexnumber,
                'form_six_year' => $form_six_year,
                'NTA4_reg' => $NTA4_reg,
                'NTA4_grad_year' => $NTA4_grad_year,
                'NTA5_reg' => $NTA5_reg,
                'NTA5_grad_year' => $NTA5_year,
            )
            ]
        )
    );



    // return $json;
    $url = 'https://www.nacte.go.tz/nacteapi/index.php/api/addcorrection';

//create a new cURL resource
    $ch = curl_init($url);
    $json=json_encode($data);
    $payload = json_encode(array($data));

//attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

//set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

//return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute the POST request
    $result = curl_exec($ch);

//close cURL resource
    curl_close($ch);

//echo message
    echo $result;
    return $result;


}

 

