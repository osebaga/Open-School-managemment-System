<?php

/**
 * Created by PhpStorm.
 * User: miltone
 * Date: 5/13/17add_student_invoice_audit
 * Time: 2:23 PM
 */
class Common_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Add Schools and College
     * @param $data
     * @param null $id
     * @return mixed
     */
    function add_student_invoice_audit($data){

        return $this->db->insert('student_invoice_audit',$data);

    }

    function add_schools($data, $id = null)
    {
        if (!is_null($id)) {
            return $this->db->update('college_schools', $data, array('id' => $id));
        } else {
            $this->db->insert('college_schools', $data);
            $last = $this->db->insert_id();
            return $last;
        }
    }

    function add_center($data, $id = null)
    {
        if (!is_null($id)) {
            return $this->db->update('Center', $data, array('id' => $id));
        } else {

            $this->db->insert('Center', $data);
            $last = $this->db->insert_id();
            return $last;
        }
    }

    function add_teacher($data, $id = null)
    {
        if (!is_null($id)) {
            return $this->db->update('CenterTeacher', $data, array('id' => $id));
        } else {
            $this->db->insert('CenterTeacher', $data);
            $last = $this->db->insert_id();
            return $last;
        }
    }

    function save_remote_school($data){
        foreach ($data as $key=>$value){
            $row = $this->db->where('id',$value->id)->get('college_schools')->row();
            if($row){
                unset($value->id);
                $this->db->update('college_schools',$value,array('id'=>$row->id));
            }else{
                $this->db->insert('college_schools',$value);
            }
        }
    }

    function save_remote_department($data){
        foreach ($data as $key=>$value){
            $row = $this->db->where('id',$value->id)->get('department')->row();
            if($row){
                unset($value->id);
                $this->db->update('department',$value,array('id'=>$row->id));
            }else{
                $this->db->insert('department',$value);
            }
        }
    }


    function save_remote_campus($data){
        foreach ($data as $key=>$value){
            $row = $this->db->where('id',$value->id)->get('campus')->row();
            if($row){
                unset($value->id);
                $this->db->update('campus',$value,array('id'=>$row->id));
            }else{
                $this->db->insert('campus',$value);
            }
        }
    }

    function save_remote_vituo($data){
        foreach ($data as $key=>$value){
            $row = $this->db->where('id',$value->id)->get('iposa_vituo')->row();
            if($row){
                unset($value->id);
                $this->db->update('iposa_vituo',$value,array('id'=>$row->id));
            }else{
                $this->db->insert('iposa_vituo',$value);
            }
        }
    }

    function save_remote_programme($data){
        foreach ($data as $key=>$value){
            $row = $this->db->where('id',$value->id)->get('programme')->row();
            if($row){
                unset($value->id);
                $this->db->update('programme',$value,array('id'=>$row->id));
            }else{
                $this->db->insert('programme',$value);
            }
        }
    }

    function save_remote_users($data){
        foreach ($data as $key=>$value){
            unset($value->v2_allowed);
            unset($value->default_pass);
            $value->sims_map = $value->id;
            $row = $this->db->where('sims_map',$value->id)->get('users')->row();
            if($row){

                unset($value->id);
                unset($value->password);
                unset($value->last_login);
                $this->db->update('users',$value,array('sims_map'=>$row->id));
            }else{
                unset($value->id);
                $this->db->insert('users',$value);
                $last_id = $this->db->insert_id();
                    $this->db->insert("users_groups",array('user_id'=>$last_id,'group_id'=>6));
            }
        }
    }

    /**
     * Get Campus
     * @param null $id
     * @return mixed
     */
    // function get_campus($id = null)
    // {
    //     $this->db->order_by('for_all DESC');
    //     if (!is_null($id)) {
    //         $this->db->where('id', $id);
    //     }

    //     return $this->db->get('campus');
    // }

    function get_account_year($name=null,$status=1,$limit=null){

        $date=date("Y-m-d");

        $check_year=$this->db->query("select * from account_year where fromdate<='$date' and todate>='$date' ")->row();
        if(!$check_year->id)
        {

            $current_month=date('m');
            if($current_month > '06' and $current_month<='12')
            {
                $current_accademic=date('Y').'/'.((int)(date('Y')) +1);
                $from_date=date('Y').'-07-01';
                $to_date=((int)(date('Y')) +1).'-06-30';
            }else{
                $current_accademic=((int)(date('Y')) - 1).'/'.date('Y');
                $from_date=((int)(date('Y')) - 1).'-07-01';
                $to_date=date('Y').'-06-30';
            }

            $this->db->query("update account_year set Status=0");
            $array = array(
                'AYear' => $current_accademic,
                'fromdate' => $from_date,
                'todate' => $to_date,
                'Status' =>1,
            );
            $this->setting_model->add_account_ayear($array);
        }

        if(!is_null($name)){
            $this->db->where('account_year',$name);
        }
        if(!is_null($status)){
            $this->db->where('Status',$status);
        }
        $this->db->order_by('AYear','DESC');

        if(!is_null($limit)){
            $this->db->limit($limit);
        }
        return $this->db->get('account_year');
//        return $this->db->query('select * from account_year where fromdate<="'.$date.'" and todate>="'.$date.'" ');
    }

    /**
     * Get Academic Years
     * @param null $campus
     * @param null $name
     * @param null $status
     * @return mixed
     */
    
    function get_academic_year($name=null,$status=1,$limit=null){

        if(!is_null($name)){
            $this->db->where('AYear',$name);
        }

        if(!is_null($status)){
            $this->db->where('Status',$status);
        }
        $this->db->order_by('AYear','DESC');

        if(!is_null($limit)){
            $this->db->limit($limit);
        }

        return $this->db->get('ayear');
    }

    /**
     * Get Module List
     * @param null $id
     * @return mixed
     */
    function get_module($id = null)
    {
        if (!is_null($id)) {
            $this->db->where('id', $id);
        }
        return $this->db->get('module');
    }

    /**
     * Get Module Roles
     * @param $module_id
     * @return mixed
     */
    function get_module_section($module_id)
    {


        $this->db->where('module_id', $module_id);
        return $this->db->get('module_section')->result();
    }

    /**
     * Get Module Roles
     * @param $module_id
     * @return mixed
     */
    function get_module_role($module_id, $section = null, $role = null)
    {
        $current_user_group = get_user_group();
        if ($current_user_group->id != 13) {
            $this->db->where('only_developer', 0);
        }

        if (!is_null($section)) {
            $this->db->where('section', $section);
        }

        if (!is_null($role)) {
            $this->db->where('role', $role);
        }

        $this->db->where('module_id', $module_id);
        return $this->db->get('module_role')->result();
    }


    /**
     * Get User Title (Mr, Mrs etc)
     * @param null $id
     * @return mixed
     */
    function get_users_title($id = null)
    {
        if (!is_null($id)) {
            $this->db->where('id', $id);
        }
        return $this->db->get('user_title');
    }


    /**
     * Get Disability List
     * @param null $id
     * @return mixed
     */
    function get_disability($id = null)
    {
        if (!is_null($id)) {
            $this->db->where('id', $id);
        }
        return $this->db->get('disability');
    }

    /**
     * Get Entry Category List
     * @param null $id
     * @return mixed
     */


    function get_entrycategory($id = null)
    {
        if (!is_null($id)) {
            $this->db->where('id', $id);
        }
        return $this->db->get('enttrycategory');
    }

    /**
     * Get Nationality List
     * @param null $id
     * @return mixed
     */
    function get_nationality($id = null)
    {
        if (!is_null($id)) {
            $this->db->where('id', $id);
        }
        return $this->db->get('nationality');
    }

    /**
     * Get Gender List
     * @param null $id
     * @return mixed
     */
    function get_gender($code = null, $id = null)
    {
        if (!is_null($id)) {
            $this->db->where('id', $id);
        }
        if (!is_null($code)) {
            $this->db->where('code', $code);
        }
        return $this->db->get('gender');
    }

    /**
     * Get Schools or Colleges
     * @param null $id
     * @return mixed
     */
    function get_college_school($id=null){
        if(!is_null($id)){
            $this->db->where('id',$id);
        }
        $this->db->order_by('type1','ASC');
        $this->db->order_by('name','ASC');
        return $this->db->get('college_schools');
    }

    /**
     * Get department List
     * @param null $id
     * @return mixed
     */

    function get_vituo($id=null) {
        if (!is_null($id)) {
            if(is_array($id)){
                $this->db->where_in('id', $id);
            }else {
                $this->db->where('id', $id);
            }
        }


        return $this->db->get('iposa_vituo');
    }

    function get_department($id=null,$school_id=null) {
        if (!is_null($id)) {
            if(is_array($id)){
                $this->db->where_in('id', $id);
            }else {
                $this->db->where('id', $id);
            }
        }
        if (!is_null($school_id)) {
            if(is_array($school_id)){
                $this->db->where_in('school_id', $school_id);
            }else{
                $this->db->where('school_id', $school_id);
            }
        }

        return $this->db->get('department');
    }

    function get_campuses($id=null) {
        if (!is_null($id)) {
            if(is_array($id)){
                $this->db->where_in('id', $id);
            }else {
                $this->db->where('id', $id);
            }
        }
        return $this->db->get('campus');
    }
    

    function get_all_campus()
    {
        $camp = $this->db->query('select name from campus')->result();
        return $camp;
        

    }

    
    function get_application_rounds(){


        $this->db->order_by('application_type','DESC');



        return $this->db->get('application_round');
    }

    /**
     * Get Semester List
     * @param null $limit
     * @return mixed
     */
    function get_semester($limit=null){
        if(!is_null($limit)){
            $this->db->limit($limit);
        }
        return $this->db->get("semester")->result();
    }


    function get_application_deadline(){
        return $this->db->get("application_deadline");
    }

    function add_programme($data,$id=null){
        if(!is_null($id)){
            return $this->db->update('programme',$data,array('id'=>$id));
        }else{
            return $this->db->insert('programme',$data);
        }
    }

    function  get_programme($id=null,$type=null,$cam=null,$active=1){
        if(!is_null($id)){
            $this->db->where('id',$id);
        }

        if(!is_null($type)){
            $this->db->where('type',$type);
            
        }
       
        if(!is_null($cam)){
            $this->db->where('campus_id',$cam);
        }
        $this->db->where('active',$active);

        $this->db->order_by("type",'ASC');

        return $this->db->get('programme');
    }

    function get_marital_status($id=null){
        if(!is_null($id)){
            $this->db->where('id',$id);
        }

        return $this->db->get("maritalstatus");
    }

    function get_regions($id = null)
    {
        if (!is_null($id)) {
            $this->db->where('id', $id);
        }
        return $this->db->get('regions');
    }


    function get_districts($id = null)
    {
        if (!is_null($id)) {
            $this->db->where('id', $id);
        }
        return $this->db->get('districts');
    }
    function get_recommendation_area($id=null){
        if(!is_null($id)){
            $this->db->where('id',$id);
        }

        return $this->db->get('recommandation_area');
    }

    /**
     * Add Department
     * @param $data
     * @param null $id
     * @return mixed
     */
    function add_vituo($data, $id = null)
    {
        if (!is_null($id)) {
            return $this->db->update('iposa_vituo', $data, array('id' => $id));
        } else {
            $this->db->insert('iposa_vituo', $data);
            $last = $this->db->insert_id();
            return $last;
        }
    }
    function add_department($data, $id = null)
    {
        if (!is_null($id)) {
            return $this->db->update('department', $data, array('id' => $id));
        } else {
            $this->db->insert('department', $data);
            $last = $this->db->insert_id();
            return $last;
        }
    }

    function add_campus($data, $id = null)
    {
        if (!is_null($id)) {
            return $this->db->update('campus', $data, array('id' => $id));
        } else {
            $this->db->insert('campus', $data);
            $last = $this->db->insert_id();
            return $last;
        }
    }
    function import_selection($data_to_import)
    {
      return $this->db->insert('tcu_admitted', $data_to_import);

    }

    function add_fee_structure($data, $id = null)
    {
        if (!is_null($id)) {
            return $this->db->update('fee_structure', $data, array('id' => $id));
        } else {
            $this->db->insert('fee_structure', $data);
            $last = $this->db->insert_id();
            return $last;
        }
    }

    function add_gepg_category($data, $id = null)
    {
        if (!is_null($id)) {
            return $this->db->update('fee_type', $data, array('id' => $id));
        } else {
            $this->db->insert('fee_type', $data);
            $last = $this->db->insert_id();
            return $last;
        }
    }

    function get_center($id=null,$category='Center') {
        // if (!is_null($id)) {

        //     $this->db->where('', $id);

        // }

        if (!is_null($category)) {

           $center =  $this->db->query("select * from application where application_category='$category' and submitted='3' or submitted='5'");

            // $this->db->where('application_category', $category);
            // $this->db->where('submitted', $status);
        }

        // return $this->db->get('application');
        return $center;

    }


    function get_teacher($id=null) {
        if (!is_null($id)) {

            $this->db->where('id', $id);

        }

        return $this->db->get('CenterTeacher');
    }

}
