<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_
 *
 * @author miltone
 */
class MY_Form_validation extends CI_Form_validation {

    public function __construct() {
        parent::__construct();
    }




    function valid_phones($str) {
        $true = 0;
        if ($str != "") {

            $data = explode(',', $str);
            foreach ($data as $key => $value) {
                $value = str_replace(' ', '', trim($value));
                if (preg_match("/^[0-9]{12}$/", $value)) {
                    $true++;
                } else {
                    return FALSE;
                    break;
                }
            }
            if ($true == count($data)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    function valid_phone($str) {
        if ($str != "") {
            $str = str_replace(' ', '', trim($str));
            if (preg_match("/^[0-9]{12}$/", $str)) {
                return TRUE;
            } else {

                return FALSE;
            }
        }
    }

    function valid_indexNo($str) {
        $str = trim($str);
        if ($str != "") {
            if(strlen($str) == 15) {
                if (preg_match("/(S|P)[0-9]{4}\/[0-9]{4}\/[0-9]{4}$/", $str)) {
                    return TRUE;
                } else {

                    return FALSE;
                }
            }else{
                return false;
           }
        }
    }



    /*
     * @author Miltone Urassa
     * validate date. the date format should be YYYY-mm-dd
     * eg 2013-07-28
     */

    function valid_date($date) {
        if ($date != "") {
            if (preg_match("/^[0-9]{1,2}-[0-9]{1,2}-[0-9]{4}$/", $date)) {
                $date_array = explode("-", $date);
                if (checkdate($date_array[1], $date_array[0], $date_array[2])) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {

                return FALSE;
            }
        }
    }

    public function is_unique_edit($str, $field) {
        $CI2 = &get_instance();

        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
        $get = $CI2->db->query("SELECT * FROM $table WHERE $field='$str' AND $field !=''")->result();
        if (count($get) == 1) {
            if ($get[0]->id == $id) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else if (count($get) == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    function valid_multiselect($str,$field) {
       $CI = &get_instance();
        return false;
        $data = $CI->input->post($field);
        print_r($data); exit;
        if(is_array($data) && count($data) > 0){
            return true;
        }
        return false;
    }



}

?>
