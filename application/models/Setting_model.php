<?php

/**
 * Created by PhpStorm.
 * User: miltone
 * Date: 5/13/17
 * Time: 6:15 PM
 */
class Setting_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_sec_category($id=null){
        if(!is_null($id)){
            $this->db->where('id',$id);
        }

        return $this->db->get("secondary_category");
    }

    function get_sec_subject($id=null,$status=null,$category=null){
        $where = "WHERE 1=1 ";
        if(!is_null($id)){
            $where.= " AND s.id='$id' ";
        }

        if(!is_null($status)){
            $where .=" AND s.status = '$status' ";
        }

        if(!is_null($category)){
            $where .=" AND s.category = '$category' ";
        }

        $sql = " SELECT s.*  FROM secondary_subject as s   $where ORDER BY name ASC ";
        return $this->db->query($sql);
    }

    function add_sec_subject($data,$id=null){
        if(array_key_exists('code',$data)) {
            $row = $this->db->where('code', $data['code'])->get('secondary_subject')->row();
            if ($row) {
                return $this->db->update("secondary_subject", $data, array('id' => $row->id));
            } else {
                return $this->db->insert("secondary_subject", $data);
            }
        }else if(!is_null($id)){
            return $this->db->update("secondary_subject", $data, array('id' => $id));
        }
    }


    function add_account_ayear($data){


        if($data['Status']==1)
        {
             $this->db->query("update account_year set Status=0");

        }
        $this->db->where('AYear',$data['AYear']);
        $check = $this->db->get('account_year')->row();
        if($check){

            return $this->db->update('account_year',$data,array('id'=>$check->id));
        }else{
            $this->db->insert('account_year',$data);
        }
    }


    function add_round($data){
        $this->db->where('application_type',$data['application_type']);
        $check = $this->db->get('application_round')->row();
        if($check){
            return $this->db->update('application_round',$data,array('id'=>$check->id));
        }else{
            $this->db->insert('application_round',$data);
        }
    }
    /**
     * Add New Academic or Semester
     *
     * @param $data
     * @return mixed
     */
    function add_ayear($data){
        $this->db->where('AYear',$data['AYear']);
        $check = $this->db->get('ayear')->row();
        if($check){
            return $this->db->update('ayear',$data,array('id'=>$check->id));
        }else{
            $this->db->insert('ayear',$data);
        }
    }

    function programme_setting_criteria($data){
        $row = $this->db->where(array('ProgrammeCode'=>$data['ProgrammeCode'],'AYear'=>$data['AYear'],'entry'=>$data['entry']))->get('application_criteria_setting')->row();
        if($row){
            $data['modifiedby'] = $data['createdby'];
            unset($data['createdby']);
            $data['modifiedon'] = $data['createdon'];
            unset($data['createdon']);
            return $this->db->update("application_criteria_setting",$data,array('id'=>$row->id));
        }else{
            return $this->db->insert("application_criteria_setting",$data);
        }
    }

    function get_selection_criteria($programme,$ayear,$entry){
       $this->db->where(array('ProgrammeCode'=>$programme,'AYear'=>$ayear,'entry'=>$entry));
       return $this->db->get("application_criteria_setting")->row();
    }

}