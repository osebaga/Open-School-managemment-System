<?php
/**
 * Created by PhpStorm.
 * User: miltone
 * Date: 8/22/17
 * Time: 8:17 AM
 */
$where_update = array(
    'AYear'=>$ayear,
    'ProgrammeCode' => $programme,
    'choice'=>$choice,
    'status'=>1
);
   $this->db->update('application_elegibility',array('selected'=>0),$where_update);

    $column = "ap.*";

$where = " WHERE ap.AYear='$ayear' AND ap.ProgrammeCode ='$programme' AND ap.choice=$choice AND ap.status=1  AND ap.selected=0 ";
$programme_info = get_value('programme',array('Code'=>$programme),null);
switch ($programme_info->type){
    case 1:
        if($category == 1){
            $where .=" AND (ap.entry_category = 1 OR ap.entry_category = 2) ";
            $direct_count_increment = $this->db->query("SELECT COUNT(id) as counter FROM application_elegibility WHERE selected=1 AND ProgrammeCode='$programme' AND entry_category=1")->row()->counter;
        }else{
            $where .=" AND (ap.entry_category = 1.5 OR ap.entry_category = 3) ";
            $equivalent_count_increment = $this->db->query("SELECT COUNT(id) as counter FROM application_elegibility WHERE selected=1 AND ProgrammeCode='$programme' AND entry_category !=1")->row()->counter;
        }
        break;
    case 2:
        if($category == 1){
            $where .=" AND ap.entry_category = 2 ";
            $direct_count_increment = $this->db->query("SELECT COUNT(id) as counter FROM application_elegibility WHERE selected=1 AND ProgrammeCode='$programme'  AND entry_category=2")->row()->counter;

        }else{
            $where .=" AND ap.entry_category = 4  ";
            $equivalent_count_increment = $this->db->query("SELECT COUNT(id) as counter FROM application_elegibility WHERE selected=1 AND ProgrammeCode='$programme' AND entry_category !=2")->row()->counter;
        }
        break;
}

$order_by = "";

$capacity_data = $this->db->where('code',$programme)->get('application_selection_criteria')->row();

   $order_data = $this->db->query("SELECT f.*,apsc.capacity,apsc.direct FROM application_selection_criteria_filter as f INNER JOIN application_selection_criteria as apsc ON f.selection_id= apsc.id 
  WHERE f.code='$programme' AND f.category=$category ORDER BY f.order_number ASC")->result();


   $table_used = array();
   $where_last = 'WHERE 1=1 ';

    foreach ($order_data as $order_key=>$order_data){
        switch ($order_data->filter_type){
            case "FORM_VI":
                $column.= ",( SELECT grade FROM application_education_subject WHERE  certificate=2 AND subject='$order_data->filter_item' AND applicant_id=ap.applicant_id ORDER BY grade ASC LIMIT 1) as p".$order_data->filter_item;
                $order_by.=" p".$order_data->filter_item.' ASC, ';

                break;
            case "FORM_IV":
                $column.= ",( SELECT grade FROM application_education_subject WHERE  certificate=1 AND subject='$order_data->filter_item' AND applicant_id=ap.applicant_id ORDER BY grade ASC LIMIT 1) as p".$order_data->filter_item;
                $order_by.=" p".$order_data->filter_item.' ASC, ';
                break;
            case "GENDER":
                $column.= ",( SELECT (CASE Gender WHEN Gender='$order_data->filter_item' THEN 1 ELSE 0 END ) as gender FROM application WHERE  id=ap.applicant_id  LIMIT 1) as p".$order_data->filter_item;
                $order_by.=" p".$order_data->filter_item.' DESC, ';
                break;
            case "POINT":
                if($category == 1){
                    $column .= ",ap.point as p" . $order_data->filter_item;
                    $order_by.=" p".$order_data->filter_item.' DESC, ';
                }else {
                    $column .= ", ap.gpa as p" . $order_data->filter_item;
                    $order_by.=" p".$order_data->filter_item.' DESC, ';
                }
                break;

            case "FIFO":
                    $column .= ",ap.applicant_id as p" . $order_data->filter_item;
                    $order_by.=" p".$order_data->filter_item.' DESC, ';

                break;
        }
    }

    if($order_by <> ''){
       $order_by = " ORDER BY ".rtrim($order_by,', ');
    }




$sql = "SELECT  $column  FROM application_elegibility as ap";

$data_information = $this->db->query("SELECT * FROM ($sql $where) as PK $order_by")->result();

/*
$query1 = $data_information;
if($query1){
    $this->load->library('table');
    $tmpl = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="1" class="table table-bordered">' );
    $this->table->set_template($tmpl);

   echo $this->table->generate($query1);
}else{
   echo $this->db->_error_message();
} exit;
*/

$capacity = $capacity_data->capacity;
$direct_counter = round((($capacity_data->direct/100)*$capacity));
$equivalent_counter = $capacity - $direct_counter;

foreach ($data_information as $selected_key=>$selected_value){
        if($category == 1) {
            $direct_count_increment++;
            if ($direct_count_increment <= $direct_counter) {
                $this->db->update('application_elegibility', array('selected' => 1, 'selected_comment' => 'Selected', 'selected_counter' => ($direct_count_increment)), array('id' => $selected_value->id));
               $this->db->query("UPDATE application_elegibility set selected =-1,selected_comment='Selected in $selected_value->choice choice' WHERE applicant_id=$selected_value->applicant_id AND selected=0 ");

            }
        }else{
            $equivalent_count_increment++;
            if ($equivalent_count_increment <= $equivalent_counter) {
                $this->db->update('application_elegibility', array('selected' => 1, 'selected_comment' => 'Selected', 'selected_counter' => ($equivalent_count_increment)), array('id' => $selected_value->id));
                $this->db->query("UPDATE application_elegibility set selected =-1,selected_comment='Selected in $selected_value->choice choice' WHERE applicant_id=$selected_value->applicant_id AND selected=0 ");

            }
        }

}

