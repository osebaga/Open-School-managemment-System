<?php

/**
 * Created by PhpStorm.
 * User: miltone
 * Date: 5/13/17
 * Time: 3:22 PM
 */
class Simsdata extends CI_Controller
{

    private $MODULE_ID = '';
    private $GROUP_ID = '';

    function __construct()
    {
        parent::__construct();


        $this->data['CURRENT_USER'] = current_user();

        $this->form_validation->set_error_delimiters('<div class="required">', '</div>');

        $this->data['title'] = 'Administrator';

        $tmp_group = get_user_group();
        $this->GROUP_ID = $this->data['GROUP_ID'] = $tmp_group->id;
        $this->MODULE_ID = $this->data['MODULE_ID'] = $tmp_group->module_id;
    }


    function school_list()
    {
        $current_user = current_user();


        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }


        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'DATA_FROM_SIMS', 'school_list')) {
            $this->session->set_flashdata("message", show_alert("MANAGE_COLLEGE_SCHOOL :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }


        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Data Source');
        $this->data['bscrum'][] = array('link' => 'school_list/', 'title' => 'Colleges or Schools List');
        if (isset($_GET) && isset($_GET['action'])) {
            $remote_data = sims_syncronise('school');
            if ($remote_data && is_object($remote_data)) {
                if($remote_data->status == 1) {
                    $this->common_model->save_remote_school($remote_data->data);
                    $this->session->set_flashdata('message', show_alert('Process completed successfully ', 'success'));
                }else{
                    $this->session->set_flashdata('message', show_alert('Remote message : '.$remote_data->description, 'success'));

                }
            } else {
                $this->session->set_flashdata('message', show_alert('Error occur, no data updated !!', 'warning'));

            }
            redirect('school_list', 'refresh');
        }

        $this->data['school_list'] = $this->common_model->get_college_school()->result();
        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/school_list';
        $this->load->view('template', $this->data);
    }

    function manage_school($id = null)
    {
        $current_user = current_user();

        $this->data['id'] = $id;
        if (!is_null($id)) {
            $id = decode_id($id);
        }

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }


        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'DATA_FROM_SIMS', 'school_list')) {
            $this->session->set_flashdata("message", show_alert("MANAGE_COLLEGE_SCHOOL :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }


        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Data Source');
        $this->data['bscrum'][] = array('link' => 'manage_school/' . $this->data['id'], 'title' => 'Manage Colleges or Schools');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('type1', 'Type', 'required');


        if ($this->form_validation->run() == true) {
            $schoolinfo = array(
                'name' => trim($this->input->post('name')),
                'type1' => trim($this->input->post('type1')),
                'createdby' => $current_user->id,
                'modifiedon' => date('Y-m-d H:i:s')
            );
            $this->common_model->add_schools($schoolinfo, $id);
            $this->session->set_flashdata('message', show_alert('Information saved !!', 'success'));
            redirect('school_list', 'refresh');
        }

        if (!is_null($id)) {
            $schoolinfo = $this->common_model->get_college_school($id)->row();
            if ($schoolinfo) {
                $this->data['schoolinfo'] = $schoolinfo;
            }
        }


        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/manage_school';
        $this->load->view('template', $this->data);
    }

    function vituo()
    {
        $current_user = current_user();


        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }




        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Data Source');
        $this->data['bscrum'][] = array('link' => 'vituo/', 'title' => 'Vituo');
        if (isset($_GET) && isset($_GET['action'])) {
            $remote_data = sims_syncronise('iposa_vituo');
            if ($remote_data && is_object($remote_data)) {
                if($remote_data->status == 1) {
                    $this->common_model->save_remote_vituo($remote_data->data);
                    $this->session->set_flashdata('message', show_alert('Process completed successfully ', 'success'));
                }else{
                    $this->session->set_flashdata('message', show_alert('Remote message : '.$remote_data->description, 'success'));

                }
            } else {
                $this->session->set_flashdata('message', show_alert('Error occur, no data updated !!', 'warning'));

            }
            redirect('vituo', 'refresh');
        }

        $this->data['vituo'] = $this->common_model->get_vituo()->result();
        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/vituo';
        $this->load->view('template', $this->data);
    }

    function department_list()
    {
        $current_user = current_user();


        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }


        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'DATA_FROM_SIMS', 'department_list')) {
            $this->session->set_flashdata("message", show_alert("MANAGE_DEPARTMENT :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }


        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Data Source');
        $this->data['bscrum'][] = array('link' => 'department_list/', 'title' => 'Department List');
        if (isset($_GET) && isset($_GET['action'])) {
            $remote_data = sims_syncronise('department');
            if ($remote_data && is_object($remote_data)) {
                if($remote_data->status == 1) {
                    $this->common_model->save_remote_department($remote_data->data);
                    $this->session->set_flashdata('message', show_alert('Process completed successfully ', 'success'));
                }else{
                    $this->session->set_flashdata('message', show_alert('Remote message : '.$remote_data->description, 'success'));

                }
            } else {
                $this->session->set_flashdata('message', show_alert('Error occur, no data updated !!', 'warning'));

            }
            redirect('department_list', 'refresh');
        }

        $this->data['department_list'] = $this->common_model->get_department()->result();
        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/department_list';
        $this->load->view('template', $this->data);
    }

    function manage_department($id = null)
    {
        $current_user = current_user();

        $this->data['id'] = $id;
        if (!is_null($id)) {
            $id = decode_id($id);
        }

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }


        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'DATA_FROM_SIMS', 'department_list')) {
            $this->session->set_flashdata("message", show_alert("MANAGE_DEPARTMENT :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }


        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Data Source');
        $this->data['bscrum'][] = array('link' => 'manage_department/', 'title' => 'Manage Department');
        //$this->form_validation->set_rules('head', 'Head', 'required');
        $this->form_validation->set_rules('school_id', 'College/School', 'required');
        if (is_null($id)) {
            $this->form_validation->set_rules('name', 'Name', 'required|is_unique[department.Name]');
        } else {
            $this->form_validation->set_rules('name', 'Name', 'required|is_unique_edit[department.Name.' . $id . ']');
        }
        if ($this->form_validation->run() == true) {
            $departmentinfo = array(
                'Name' => trim($this->input->post('name')),
                'school_id' => trim($this->input->post('school_id')),
            );
            $this->common_model->add_department($departmentinfo, $id);
            $this->session->set_flashdata('message', show_alert('Information saved !!', 'success'));
            redirect('department_list', 'refresh');
        }

        if (!is_null($id)) {
            $departmentinfo = $this->common_model->get_department($id)->row();
            if ($departmentinfo) {
                $this->data['departmentinfo'] = $departmentinfo;
            }
        }


        $this->data['school_list'] = $this->common_model->get_college_school()->result();

        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/manage_department';
        $this->load->view('template', $this->data);
    }



    function campus_list()
    {
        $current_user = current_user();


        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }


        // if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'DATA_FROM_SIMS', 'campus_list')) {
        //     $this->session->set_flashdata("message", show_alert("MANAGE_CAMPUS :: Access denied !!", 'info'));
        //     redirect(site_url('dashboard'), 'refresh');
        // }


        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Data Source');
        $this->data['bscrum'][] = array('link' => 'campua_list/', 'title' => 'Campus List');
        if (isset($_GET) && isset($_GET['action'])) {
            $remote_data = sims_syncronise('campus');
            if ($remote_data && is_object($remote_data)) {
                if($remote_data->status == 1) {
                    $this->common_model->save_remote_campus($remote_data->data);
                    $this->session->set_flashdata('message', show_alert('Process completed successfully ', 'success'));
                }else{
                    $this->session->set_flashdata('message', show_alert('Remote message : '.$remote_data->description, 'success'));

                }
            } else {
                $this->session->set_flashdata('message', show_alert('Error occur, no data updated !!', 'warning'));

            }
            redirect('campus_list', 'refresh');
        }

        $this->data['campus_list'] = $this->common_model->get_campuses()->result();
        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/campus_list';
        $this->load->view('template', $this->data);
    }


    function manage_campus($id = null)
    {
        $current_user = current_user();

        $this->data['id'] = $id;
        if (!is_null($id)) {
            $id = decode_id($id);
        }

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }


        // if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'DATA_FROM_SIMS', 'campus_list')) {
        //     $this->session->set_flashdata("message", show_alert("MANAGE_CAMPUS :: Access denied !!", 'info'));
        //     redirect(site_url('dashboard'), 'refresh');
        // }


        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Data Source');
        $this->data['bscrum'][] = array('link' => 'manage_campus/', 'title' => 'Manage Campus');
        //$this->form_validation->set_rules('head', 'Head', 'required');
        $this->form_validation->set_rules('name', 'campus name', 'required');
        $this->form_validation->set_rules('location', 'campus location', 'required');

        if ($this->form_validation->run() == true) {
            $campusinfo = array(
                'Name' => trim($this->input->post('name')),
                'location' => trim($this->input->post('location')),
            );
            $this->common_model->add_campus($campusinfo, $id);
            $this->session->set_flashdata('message', show_alert('Information saved !!', 'success'));
            redirect('campus_list', 'refresh');
        }

        if (!is_null($id)) {
            $campusinfo = $this->common_model->get_campuses($id)->row();
            if ($campusinfo) {
                $this->data['campusinfo'] = $campusinfo;
            }
        }


        $this->data['regions_list'] = $this->common_model->get_regions()->result();

        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/manage_campus';
        $this->load->view('template', $this->data);
    }



function manage_vituo($id = null)
{
$current_user = current_user();

$this->data['id'] = $id;
if (!is_null($id)) {
$id = decode_id($id);
}

if (isset($_GET['action']) && $_GET['action'] <> '') {
    $this->data['action'] = $_GET['action'];
}

if (isset($_GET['action']) && $_GET['action'] <> '') {
    $this->data['action'] = $_GET['action'];
}




$this->data['bscrum'][] = array('link' => '#', 'title' => 'Data Source');
$this->data['bscrum'][] = array('link' => 'manage_vituo/', 'title' => 'Manage Vituo');
$this->form_validation->set_rules('name', 'Name', 'required|is_unique[iposa_vituo.name]');

    if (is_null($id)) {
        $this->form_validation->set_rules('name', 'Name', 'required|is_unique[iposa_vituo.name]');
    } else {
        $this->form_validation->set_rules('name', 'Name', 'required|is_unique_edit[iposa_vituo.name.' . $id . ']');
    }
$this->form_validation->set_rules('anuani', 'Address', 'required');
$this->form_validation->set_rules('mkuukituo', 'Mkuu wa kituo', 'required');
$this->form_validation->set_rules('mkuukituonumber', 'Mkuu Mobile', 'required');
$this->form_validation->set_rules('district', 'District', 'required');


if ($this->form_validation->run() == true) {
    $vituoinfo = array(
        'name' => trim($this->input->post('name')),
        'anuani' => trim($this->input->post('anuani')),
        'jinalamkuu' => trim($this->input->post('mkuukituo')),
        'simuyamkuu' => trim($this->input->post('mkuukituonumber')),
        'district ' => $this->input->post('district')
    );
    $this->common_model->add_vituo($vituoinfo, $id);
    $this->session->set_flashdata('message', show_alert('Information saved !!', 'success'));
    redirect('vituo', 'refresh');
}

if (!is_null($id)) {
    $vituoinfo = $this->common_model->get_vituo($id)->row();
    if ($vituoinfo) {
        $this->data['vituoinfo'] = $vituoinfo;
    }
}

    $this->data['regions'] = $this->common_model->get_regions()->result();
    $this->data['districts'] = $this->common_model->get_districts()->result();

$this->data['active_menu'] = 'sims_data';
$this->data['content'] = 'simsdata/manage_vituo';
$this->load->view('template', $this->data);
}


    function programme_list(){
        $current_user = current_user();

        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'DATA_FROM_SIMS','programme_list')) {
            $this->session->set_flashdata("message", show_alert("MANAGE_PROGRAMME :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        if (isset($_GET) && isset($_GET['action'])) {
            $remote_data = sims_syncronise('programme');
            if ($remote_data && is_object($remote_data)) {
                if($remote_data->status == 1) {
                    $this->common_model->save_remote_programme($remote_data->data);
                    $this->session->set_flashdata('message', show_alert('Process completed successfully ', 'success'));
                }else{
                    $this->session->set_flashdata('message', show_alert('Remote message : '.$remote_data->description, 'success'));

                }
            } else {
                $this->session->set_flashdata('message', show_alert('Error occur, no data updated !!', 'warning'));

            }
            redirect('programme_list', 'refresh');
        }


        $this->load->library('pagination');

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Setting');
        $this->data['bscrum'][] = array('link' => 'programme_list/', 'title' => 'Programme List');

        $department_list = get_user_department($current_user);

        $where = " WHERE 1=1";

        if (!is_null($department_list)) {
            if (!is_array($department_list)) {
                $department_list = array($department_list);
            }

            $where .= " AND Departmentid IN ( " . implode(',', $department_list) . " ) ";
        }


        if (isset($_GET['key']) && $_GET['key'] != '') {
            $where .= " AND  Name LIKE '%" . $_GET['key'] . "%'";
        }

        if (isset($_GET['type']) && $_GET['type'] != '') {
            $where .= " AND  type = ". $_GET['type'];
        }

        $sql = " SELECT * FROM programme  $where ";

        $sql2 = " SELECT count(id) as counter FROM programme  $where ";

        $config["base_url"] = site_url('programme_list/');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
        if (count($_GET) > 0)
            $config['suffix'] = '?' . http_build_query($_GET, '', "&");

        $config["total_rows"] = $this->db->query($sql2)->row()->counter;
        $config["per_page"] = 20;
        $config["uri_segment"] = 2;

        include 'include/config_pagination.php';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2) ? $this->uri->segment(2) : 0);
        $this->data['pagination_links'] = $this->pagination->create_links();

        $this->data['programme_list'] = $this->db->query($sql . " ORDER BY Name ASC LIMIT $page," . $config["per_page"])->result();


        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/programme_list';
        $this->load->view('template', $this->data);
    }
    function student_invoice_list(){
        $current_user = current_user();

        if (isset($_GET) && isset($_GET['action'])) {
            $remote_data = sims_syncronise('student_invoice');
            if ($remote_data && is_object($remote_data)) {
                if($remote_data->status == 1) {
                    $this->common_model->save_remote_student_invoice($remote_data->data);
                    $this->session->set_flashdata('message', show_alert('Process completed successfully ', 'success'));
                }else{
                    $this->session->set_flashdata('message', show_alert('Remote message : '.$remote_data->description, 'success'));

                }
            } else {
                $this->session->set_flashdata('message', show_alert('Error occur, no data updated !!', 'warning'));

            }
            redirect('student_invoice_list', 'refresh');
        }


        $this->load->library('pagination');

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Setting');
        $this->data['bscrum'][] = array('link' => 'student_invoice_list/', 'title' => 'Student Balance List');


        $where = " WHERE 1=1";

//        if (!is_null($department_list)) {
//            if (!is_array($department_list)) {
//                $department_list = array($department_list);
//            }
//
//            $where .= " AND Departmentid IN ( " . implode(',', $department_list) . " ) ";
//        }


        if (isset($_GET['key']) && $_GET['key'] != '') {
            $where .= " AND  (Name LIKE '%" . $_GET['key'] . "%' or regno LIKE '%" . $_GET['key'] . "%' or ayear LIKE '%" . $_GET['key'] . "%' or side LIKE '%" . $_GET['key'] . "%' or amount LIKE '%" . $_GET['key'] . "%' or note LIKE '%" . $_GET['key'] . "%' or type LIKE '%" . $_GET['key'] . "%' )";
        }

        if (isset($_GET['side']) && $_GET['side'] != '') {
            $where .= " AND  side = '". $_GET['side']."'";
        }

        $sql = " SELECT * FROM student_invoice  $where ";

        $sql2 = " SELECT count(id) as counter FROM student_invoice  $where ";

        $config["base_url"] = site_url('student_invoice_list/');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
        if (count($_GET) > 0)
            $config['suffix'] = '?' . http_build_query($_GET, '', "&");

        $config["uri_segment"] = 2;


        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2) ? $this->uri->segment(2) : 0);
        $this->data['pagination_links'] = $this->pagination->create_links();

        $this->data['student_invoice_list'] = $this->db->query($sql . " ORDER BY id DESC ")->result();


        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/student_invoice_list';
        $this->load->view('template', $this->data);
    }
    function add_student_invoice($id=null){
        $otherdb = $this->load->database('saris', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $current_user = current_user();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Setting');
        $this->data['bscrum'][] = array('link' => 'add_student_invoice/'.$id, 'title' => 'Student Invoice');

        $this->form_validation->set_rules('ayear', 'Academic Year', 'required');
        $this->form_validation->set_rules('regno', 'Registration', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required');
        $this->form_validation->set_rules('side', 'Entry Side', 'required');
        $this->form_validation->set_rules('note', 'Naration', 'required');
        $this->form_validation->set_rules('name', 'Student name', 'required');
        $this->form_validation->set_rules('campus', 'Campus', 'required');
        $this->form_validation->set_rules('intake', 'Intake', 'required');






        if ($this->form_validation->run() == true) {

            $regno=trim($this->input->post('regno'));
            $ayear=trim($this->input->post('ayear'));
            $fee_structure=$this->db->query("select * from fee_structure where id='".trim($this->input->post('type'))."'")->row();
            $check_if_exist=$this->db->query("select * from student_invoice where regno='$regno' and ayear='$ayear'and type='".$fee_structure->name."' and amount='".trim($this->input->post('amount'))."' and side='".trim($this->input->post('side'))."'")->result();

            if($check_if_exist and is_null($id))
            {
                $this->data['message'] = show_alert('Student balance exist','warning');

            }else{

                $results_student= $otherdb->query("select student.RegNo,student.Name,NTALevel,programme.Title as programme,Campus,class.Intake  from ((programme inner join class on programme.programmecode = class.programme) inner join student on student.RegNo=class.RegNo) where class.Ayear='".$ayear."' and student.RegNo='".$regno."'")->row();

                $array_data = array(
                    'regno' => trim($this->input->post('regno')),
                    'ayear' => trim($this->input->post('ayear')),
                    'side' =>trim($this->input->post('side')),
                    'amount' =>trim($this->input->post('amount')),
                    'note' =>trim($this->input->post('note')),
                    'name' =>trim($this->input->post('name')),
                    'type'=>$fee_structure->name,
                    "programme"=>$results_student->programme,
                    "nta_level"=>$fee_structure->ntlevel_value,
                    "campus"=>trim($this->input->post('campus')),
                    "intake"=>trim($this->input->post('intake')),
                    'fee_category'=>$fee_structure->fee_category
                );




                $add = $this->common_model->add_student_invoice($array_data,$id);

                $array_data['username']=$current_user->username;
                $array_data['userid']=$current_user->id;
                $array_data['fullname']=$current_user->firstname. ' '.$current_user->lastname;

                $this->common_model->add_student_invoice_audit($array_data);


                if($add){
                    $this->session->set_flashdata('message',show_alert('Information saved successfully','success'));
                    redirect('student_invoice_list','refresh');
                }else{
                    $this->data['message'] = show_alert('Fail to save Information','info');
                }



            }

        }
        if(!is_null($id)){
            $check = $this->common_model->get_student_ivoice($id)->row();
            if($check){
                $this->data['student_invoice_info'] = $check;
            }
        }
        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/add_student_invoice';
        $this->load->view('template', $this->data);
    }



    function add_programme($id=null){
        $current_user = current_user();
        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'DATA_FROM_SIMS','programme_list')) {
            $this->session->set_flashdata("message", show_alert("MANAGE_PROGRAMME :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Setting');
        $this->data['bscrum'][] = array('link' => 'add_programme/'.$id, 'title' => 'Programme');


        if(is_null($id)) {
            $this->form_validation->set_rules('code', 'Code', 'required|is_unique[programme.Code]');
        }

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('department', 'Department', 'required');
        $this->form_validation->set_rules('cat', 'Category', 'required');
        if ($this->form_validation->run() == true) {
          
        $array_data = array(
            'Code' => trim($this->input->post('code')),
            'Name' => trim($this->input->post('name')),
            'Departmentid' => trim($this->input->post('department')),
            'type' =>trim($this->input->post('cat')),
            'campus_id' =>json_encode($this->input->post('campus')),
            'active' =>trim($this->input->post('active')),
            'duration' =>trim($this->input->post('duration'))

        );
        // var_dump($array_data);exit;
        $add = $this->common_model->add_programme($array_data,$id);
        if($add){
            $this->session->set_flashdata('message',show_alert('Information saved successfully','success'));
            redirect('programme_list','refresh');
        }else{
            $this->data['message'] = show_alert('Fail to save Information','info');
        }

        // if ($this->form_validation->run() == true) {
        //     $array_data = array(
        //         'Code' => trim($this->input->post('Code')),
        //         'Name' => trim($this->input->post('name')),
        //         'Departmentid' => trim($this->input->post('department')),
        //         'type' =>trim($this->input->post('cat')),
        //         'campus_id' =>json_encode($this->input->post('campus')),
        //         'active' =>trim($this->input->post('active')),
        //         'duration' =>trim($this->input->post('duration'))

        //     );
        //     // var_dump(json_encode($this->input->post('campus')));
        //     // exit;
        //     // if(is_null($id)){
        //     //     $array_data['Code'] = trim($this->input->post('code'));
        //     // }

        //     $add = $this->common_model->add_programme($array_data,$id);
        //     if($add){
        //         $this->session->set_flashdata('message',show_alert('Information saved successfully','success'));
        //         redirect('programme_list','refresh');
        //     }else{
        //         $this->data['message'] = show_alert('Fail to save Information','info');
        //     }


        // }
        if(!is_null($id)){
            $check = $this->common_model->get_programme($id)->row();
            if($check){
                $this->data['programme_info'] = $check;
            }
        }
    }
        // $this->data['campuses'] = $this->common_model->get_campus()->result();
        $this->data['campuses'] = $this->db->query('select * from application where submitted=3')->result();
        $this->data['department_list'] =$this->common_model->get_department()->result();
        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/add_programme';
        $this->load->view('template', $this->data);
    }
    function fee_structure_list()
    {

        $current_user = current_user();


        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Data Source');
        $this->data['bscrum'][] = array('link' => 'fee_structure_list/', 'title' => 'Fee structure List');
        $this->data['fee_structure_list'] = $this->db->query("select * from fee_structure")->result();
        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/fee_structure_list';
        $this->load->view('template', $this->data);

    }


    function gepg_category_list()
    {
        $current_user = current_user();


        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }



        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Data Source');
        $this->data['bscrum'][] = array('link' => 'gepg_category_list/', 'title' => 'GePG category List');

        $this->data['gepg_category_list'] = $this->db->query("select * from fee_type where deleted=0")->result();
        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/gepg_category_list';
        $this->load->view('template', $this->data);
    }

    function manage_gepg_category($id = null)
    {
        $current_user = current_user();

        $this->data['id'] = $id;
        if (!is_null($id)) {
            $id = decode_id($id);
        }

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }


        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Data Source');
        $this->data['bscrum'][] = array('link' => 'manage_gepg_category/', 'title' => 'Manage Gepg Category');
        $this->form_validation->set_rules('name', 'Category  Name', 'required');
        $this->form_validation->set_rules('gfscode', 'GFS code ', 'required');




        //$this->form_validation->set_rules('head', 'Head', 'required');
        //$this->form_validation->set_rules('school_id', 'College/School', 'required');
//        if (is_null($id)) {
//            $this->form_validation->set_rules('name', 'Name', 'required|is_unique[department.Name]');
//        } else {
//            $this->form_validation->set_rules('name', 'Name', 'required|is_unique_edit[department.Name.' . $id . ']');
//        }
        if ($this->form_validation->run() == true) {
            //echo "nipooo=".$this->input->post('percentage');
            //exit;

            $gepginfo = array(
                'name' => trim($this->input->post('name')),
                'gfscode' => trim($this->input->post('gfscode')),
            );

            $this->common_model->add_gepg_category($gepginfo, $id);
            $this->session->set_flashdata('message', show_alert('Information saved !!', 'success'));
            redirect('gepg_category_list', 'refresh');
        }

        if (!is_null($id)) {
            $gepgcategoryinfo = $this->db->query("select * from fee_type where id=".$id)->row();
            if ($gepgcategoryinfo) {
                $this->data['gepgcategoryinfo'] = $gepgcategoryinfo;
            }
        }

        $this->data['ayear_list'] = $this->db->query("select * from ayear")->result();


        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/manage_gepg_category';
        $this->load->view('template', $this->data);
    }

    function delete_fee_structure($id = null)
    {
        $current_user = current_user();

        $this->data['id'] = $id;
        if (!is_null($id)) {
            $id = decode_id($id);
            $delete=$this->db->query("update  fee_structure set deleted=1 where id=". $id);
                if($delete)
                {
                    $this->session->set_flashdata('message', show_alert('Selected Fee structure successfully deleted', 'warning'));

                }
            }
        redirect('fee_structure_list', 'refresh');
    }
    function delete_gepg_category($id = null)
    {
        $current_user = current_user();

        $this->data['id'] = $id;
        if (!is_null($id)) {
            $id = decode_id($id);
            $delete=$this->db->query("update fee_type set deleted=1  where id=". $id);
            if($delete)
            {
                $this->session->set_flashdata('message', show_alert('Selected GePG Category successfully deleted', 'warning'));

            }
        }
        redirect('gepg_category_list', 'refresh');
    }

    function manage_fee_structure($id = null)
    {
        $current_user = current_user();

        if (get_user_group()->id!=1 and get_user_group()->id!=7) {
            $this->session->set_flashdata("message", show_alert("MANAGE_DEPARTMENT :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        $this->data['id'] = $id;
        if (!is_null($id)) {
            $id = decode_id($id);
        }

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }


        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Data Source');
        $this->data['bscrum'][] = array('link' => 'manage_department/', 'title' => 'Manage Fee Structure');
        $this->form_validation->set_rules('name', 'Fee  Name', 'required');
        $this->form_validation->set_rules('gepg_category_code', 'GEPG Category', 'required');
        $this->form_validation->set_rules('fixed', 'Specify fee type', 'required');
        $this->form_validation->set_rules('fee_category', 'Specify fee Category', 'required');
        $this->form_validation->set_rules('pay_option', 'Bill Option', 'required');
        $this->form_validation->set_rules('exp_days', 'Bill Expire Days', 'required');


        if($this->input->post('fixed')==1)
        {
            $this->form_validation->set_rules('amount', 'Fee  Amount', 'required');
            $this->form_validation->set_rules('percentage', 'Percentage Option', 'required');
            $this->form_validation->set_rules('ntlevel', 'NTA levels Option', 'required');
            $this->form_validation->set_rules('carryover', 'Carry Over Option', 'required');

        }
        if($this->input->post('percentage')==1) {
            $this->form_validation->set_rules('percentage_value', 'Percentage Value', 'required');
        }

        if($this->input->post('ntlevel')==1) {
            $this->form_validation->set_rules('ntlevel_value', 'NTA levels Value', 'required');
        }

        if($this->input->post('carryover')==1) {
            $this->form_validation->set_rules('carryover_quality_assurance_value', 'Quality Assurance', 'required');
        }





        //$this->form_validation->set_rules('head', 'Head', 'required');
        //$this->form_validation->set_rules('school_id', 'College/School', 'required');
//        if (is_null($id)) {
//            $this->form_validation->set_rules('name', 'Name', 'required|is_unique[department.Name]');
//        } else {
//            $this->form_validation->set_rules('name', 'Name', 'required|is_unique_edit[department.Name.' . $id . ']');
//        }
        if ($this->form_validation->run() == true) {
            //echo "nipooo=".$this->input->post('percentage');
            //exit;
            if($this->input->post('fixed')==1) {
                $feestructureinfo = array(
                    'name' => trim($this->input->post('name')),
                    'percentage' => trim($this->input->post('percentage')),
                    'amount' => trim($this->input->post('amount')),
                    'fee_code' => trim($this->input->post('gepg_category_code')),
                    'fixed'=>$this->input->post('fixed'),
                    'ntlevel'=>$this->input->post('ntlevel'),
                    'carryover'=>$this->input->post('carryover'),
                    'parcentage_value' => trim($this->input->post('percentage_value')),
                    'ntlevel_value' => trim($this->input->post('ntlevel_value')),
                    'carryover_quality_assurance_value' => trim($this->input->post('carryover_quality_assurance_value')),
                    'fee_category'=>$this->input->post('fee_category'),
                    'pay_option'=>$this->input->post('pay_option'),
                    'exp_days'=>$this->input->post('exp_days'),
                    'hidden'=>$this->input->post('hidden'),
                    'ref_prefix'=>$this->input->post('reference_prefix'),
                    'for_student'=>$this->input->post('for_student')

                );
            }else{
                $feestructureinfo = array(
                    'name' => trim($this->input->post('name')),
                    'percentage' => trim($this->input->post('percentage')),
                    'ntlevel'=>$this->input->post('ntlevel'),
                    'carryover'=>$this->input->post('carryover'),
                    'amount' => 0,
                    'fee_code' => trim($this->input->post('gepg_category_code')),
                    'fixed'=>$this->input->post('fixed'),
                    'fee_category'=>$this->input->post('fee_category'),
                    'pay_option'=>$this->input->post('pay_option'),
                    'exp_days'=>$this->input->post('exp_days'),
                    'hidden'=>$this->input->post('hidden'),
                    'ref_prefix'=>$this->input->post('reference_prefix'),
                    'for_student'=>$this->input->post('for_student')

                );
            }
            $this->common_model->add_fee_structure($feestructureinfo, $id);
            $this->session->set_flashdata('message', show_alert('Information saved !!', 'success'));
            redirect('fee_structure_list', 'refresh');
        }

        if (!is_null($id)) {
            $feestructureinfo = $this->db->query("select * from fee_structure where id=".$id)->row();
            if ($feestructureinfo) {
                $this->data['feestructureinfo'] = $feestructureinfo;
            }
        }

        $this->data['ayear_list'] = $this->db->query("select * from ayear")->result();


        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/manage_fee_structure';
        $this->load->view('template', $this->data);
    }


    function manage_center($id = null)
    {
        

        $current_user = current_user();

        $this->data['id'] = $id;
        if (!is_null($id)) {
            $id = decode_id($id);
        }

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }


        if (get_user_group()->id!=1 and get_user_group()->id!=7) {
            $this->session->set_flashdata("message", show_alert("MANAGE_DEPARTMENT :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Data Source');
        $this->data['bscrum'][] = array('link' => 'manage_department/', 'title' => 'Manage Department');
        if (is_null($id)) {

            $this->form_validation->set_rules('CenterRegNo', 'Center Reg.Number', 'required|is_unique[Center.CenterRegNo]');
            $this->form_validation->set_rules('CenterName', 'Center Name', 'required');
            $this->form_validation->set_rules('CenterCost', 'Center Cost', 'required');
            $this->form_validation->set_rules('Region', 'Region', 'required');
            $this->form_validation->set_rules('District', 'District', 'required');   
            $this->form_validation->set_rules('YearOfReg', 'Year Of Registration', 'required');
            $this->form_validation->set_rules('ExpireYear', 'Expiring Year', 'required');
            $this->form_validation->set_rules('CenterOwner', 'Center Owner', 'required');
            $this->form_validation->set_rules('CenterCordnator', 'Center Cordinator', 'required');
            $this->form_validation->set_rules('CenterCategory', 'Center Category', 'required');
            $this->form_validation->set_rules('Status', 'Status', 'required');  
 
        } else {
            $this->form_validation->set_rules('CenterRegNo', 'Center Reg.Number', 'required|is_unique_edit[Center.CenterRegNo.' . $id . ']');
            $this->form_validation->set_rules('CenterName', 'Center Name', 'required');
            $this->form_validation->set_rules('CenterCost', 'Center Cost', 'required');
             $this->form_validation->set_rules('Region', 'Region', 'required');
            $this->form_validation->set_rules('District', 'District', 'required');   
            $this->form_validation->set_rules('YearOfReg', 'Year Of Registration', 'required');
            $this->form_validation->set_rules('ExpireYear', 'Expiring Year', 'required');
            $this->form_validation->set_rules('CenterOwner', 'Center Owner', 'required');
            $this->form_validation->set_rules('CenterCordnator', 'Center Cordinator', 'required');
            $this->form_validation->set_rules('CenterCategory', 'Center Category', 'required');
            $this->form_validation->set_rules('Status', 'Status', 'required');  
        }

        if ($this->form_validation->run() == true) {
            $centerinfo = array(
                'CenterRegNo' => trim($this->input->post('CenterRegNo')),
                'CenterName' => trim($this->input->post('CenterName')),
                'CenterCost' => trim($this->input->post('CenterCost')),
                // 'RegionCode' => trim($this->input->post('RegionCode')),
                'Region' => trim($this->input->post('Region')),
                'District' => trim($this->input->post('District')),
                'YearOfReg' => trim($this->input->post('YearOfReg')),
                'ExpireYear' => trim($this->input->post('ExpireYear')),
                'CenterOwner' => trim($this->input->post('CenterOwner')),
                'CenterCordnator' => trim($this->input->post('CenterCordnator')),
                'CenterCategory' => trim($this->input->post('CenterCategory')),
                'Status' => trim($this->input->post('Status')),
            );
            $this->common_model->add_center($centerinfo, $id);
            $this->session->set_flashdata('message', show_alert('Information saved !!', 'success'));
            redirect('center_list', 'refresh');
        }

        if (!is_null($id)) {
            $centerinfo = $this->common_model->get_center($id)->row();
            if ($centerinfo) {
                $this->data['centerinfo'] = $centerinfo;
            }
        }

        $this->data['regions'] = $this->common_model->get_regions()->result();
        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/manage_center';
        $this->load->view('template', $this->data);
    }

    function center_list()
    {
        $current_user = current_user();

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Data Source');
        $this->data['bscrum'][] = array('link' => 'center_list/', 'title' => 'Center List');
        if (isset($_GET) && isset($_GET['action'])) {
            $remote_data = sims_syncronise('sponsors');
            if ($remote_data && is_object($remote_data)) {
                if($remote_data->status == 1) {
                    $this->common_model->save_remote_sponsor($remote_data->data);
                    $this->session->set_flashdata('message', show_alert('Process completed successfully ', 'success'));
                }else{
                    $this->session->set_flashdata('message', show_alert('Remote message : '.$remote_data->description, 'success'));

                }
            } else {
                $this->session->set_flashdata('message', show_alert('Error occur, no data updated !!', 'warning'));

            }
            redirect('center_list', 'refresh');
        }

        $this->data['center_list'] = $this->common_model->get_center()->result();
        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/center_list';
        $this->load->view('template', $this->data);
    }


    function manage_teacher($id = null)
    {
        $current_user = current_user();

        $this->data['id'] = $id;
        if (!is_null($id)) {
            $id = decode_id($id);
        }

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Data Source');
        $this->data['bscrum'][] = array('link' => 'manage_teacher/', 'title' => 'Manage Teacher');
        if (is_null($id)) {
            $this->form_validation->set_rules('RegNo', 'Registration Number', 'required|is_unique[CenterTeacher.RegNo]');
            $this->form_validation->set_rules('CenterRegNo', 'Center Registration', 'required');
            $this->form_validation->set_rules('FirstName', 'FirstName', 'required');
             $this->form_validation->set_rules('MiddleName', 'MiddleName', 'required');
            $this->form_validation->set_rules('SurName', 'SurName', 'required');   
            $this->form_validation->set_rules('Email', 'Email', 'required|is_unique[CenterTeacher.Email]');
            $this->form_validation->set_rules('Phone', 'Phone', 'required|is_unique[CenterTeacher.Phone]');
            $this->form_validation->set_rules('Qualification', 'Qualification', 'required');
            $this->form_validation->set_rules('Status', 'Status', 'required');
            $this->form_validation->set_rules('BasicSalary', 'Basic Salary', 'required');
 
        } else {
            $this->form_validation->set_rules('RegNo', 'Registration Number', 'required|is_unique_edit[CenterTeacher.RegNo.' . $id . ']');
            $this->form_validation->set_rules('CenterRegNo', 'Center Registration', 'required');
            $this->form_validation->set_rules('FirstName', 'FirstName', 'required');
            $this->form_validation->set_rules('MiddleName', 'MiddleName', 'required');
            $this->form_validation->set_rules('SurName', 'SurName', 'required');   
            $this->form_validation->set_rules('Email', 'Email', 'required');
            $this->form_validation->set_rules('Phone', 'Phone', 'required');
            $this->form_validation->set_rules('Qualification', 'Qualification', 'required');
            $this->form_validation->set_rules('Status', 'Status', 'required');
            $this->form_validation->set_rules('BasicSalary', 'Basic Salary', 'required');
        }

        if ($this->form_validation->run() == true) {
            $teacherinfo = array(
                'RegNo' => trim($this->input->post('RegNo')),
                'CenterRegNo' => trim($this->input->post('CenterRegNo')),
                'FirstName' => trim($this->input->post('FirstName')),
                'MiddleName' => trim($this->input->post('MiddleName')),
                'SurName' => trim($this->input->post('SurName')),
                'Email' => trim($this->input->post('Email')),
                'Phone' => trim($this->input->post('Phone')),
                'Qualification' => trim($this->input->post('Qualification')),
                'Status' => trim($this->input->post('Status')),
                'BasicSalary' => trim($this->input->post('BasicSalary')),
            );
            $this->common_model->add_teacher($teacherinfo, $id);
            $this->session->set_flashdata('message', show_alert('Information saved !!', 'success'));
            redirect('teacher_list', 'refresh');
        }

        if (!is_null($id)) {
            $teacherinfo = $this->common_model->get_teacher($id)->row();
            if ($teacherinfo) {
                $this->data['teacherinfo'] = $teacherinfo;
            }
        }

        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/manage_teacher';
        $this->load->view('template', $this->data);
    }


    function teacher_list()
    {
        $current_user = current_user();
        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Data Source');
        $this->data['bscrum'][] = array('link' => 'teacher_list/', 'title' => 'Teacher List');
        if (isset($_GET) && isset($_GET['action'])) {
            $remote_data = sims_syncronise('sponsors');
            if ($remote_data && is_object($remote_data)) {
                if($remote_data->status == 1) {
                    $this->common_model->save_remote_sponsor($remote_data->data);
                    $this->session->set_flashdata('message', show_alert('Process completed successfully ', 'success'));
                }else{
                    $this->session->set_flashdata('message', show_alert('Remote message : '.$remote_data->description, 'success'));
                }
            } else {
                $this->session->set_flashdata('message', show_alert('Error occur, no data updated !!', 'warning'));
            }
            redirect('teacher_list', 'refresh');
        }
        $this->data['teacher_list'] = $this->common_model->get_teacher()->result();
        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'simsdata/teacher_list';
        $this->load->view('template', $this->data);
    }
}