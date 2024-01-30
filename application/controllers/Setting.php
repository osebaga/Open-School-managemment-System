<?php

/**
 * Created by PhpStorm.
 * User: miltone
 * Date: 5/13/17
 * Time: 6:01 PM
 */
class Setting extends CI_Controller
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


    function manage_subject(){
        $current_user = current_user();
        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'SETTINGS', 'manage_subject')) {
            $this->session->set_flashdata("message", show_alert("MANAGE_SUBJECT :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }


        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Settings');
        $this->data['bscrum'][] = array('link' => 'manage_subject/', 'title' => 'Secondary Subject');


        $this->data['sec_subject'] = $this->setting_model->get_sec_subject()->result();
        $this->data['active_menu'] = 'settings';
        $this->data['content'] = 'setting/manage_subject';
        $this->load->view('template', $this->data);
    }

    function add_sec_subject($id=null){
        $current_user = current_user();
        $this->data['id'] = $id;
        if(!is_null($id)){
            $id = decode_id($id);
        }

        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'SETTINGS', 'manage_subject')) {
            $this->session->set_flashdata("message", show_alert("MANAGE_SUBJECT :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }


        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Settings');
        $this->data['bscrum'][] = array('link' => 'add_sec_subject/'.$this->data['id'], 'title' => (is_null($id) ? 'Add New Subject':'Edit Subject'));

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('shortname', 'Short Name', 'required');
        // $this->form_validation->set_rules('category', 'Category', 'required');


        if ($this->form_validation->run() == true) {
            $array_data = array(
                // 'category'=> trim($this->input->post('category')),
                'name'=> trim($this->input->post('name')),
                'shortname'=> trim($this->input->post('shortname')),
                'status'=> trim($this->input->post('status')),
            );

            $add = $this->setting_model->add_sec_subject($array_data,$id);
            if($add){
                $this->session->set_flashdata('message',show_alert('Information saved successfully','success'));
                redirect('manage_subject','refresh');
            }else{
                $this->data['message'] = show_alert('Fail to save Information','warning');
            }

        }


        if(!is_null($id)){
            $this->data['subject_info'] = $this->setting_model->get_sec_subject($id)->row();
        }
        //$this->data['category_list'] = $this->setting_model->get_sec_category()->result();
        $this->data['active_menu'] = 'settings';
        $this->data['content'] = 'setting/add_sec_subject';
        $this->load->view('template', $this->data);
    }

    function application_round($id = null)
    {
        $current_user = current_user();

        $this->data['id'] = $id;
        if (!is_null($id)) {
            $id = decode_id($id);
        }

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'SETTINGS','application_round')) {
            $this->session->set_flashdata("message", show_alert("APPLICATION_ROUND :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Settings');
        $this->data['bscrum'][] = array('link' => 'application_round/', 'title' => 'Application Round');

        $this->form_validation->set_rules('type', 'Application Type', 'required');
        $this->form_validation->set_rules('round', 'Round', 'required');

        if ($this->form_validation->run() == true) {
            $array = array(
                'application_type' => trim($this->input->post('type')),
                'round' => trim($this->input->post('round')),

            );

            $this->setting_model->add_round($array);
            $this->session->set_flashdata('message', show_alert('Information saved ', 'success'));
            redirect('application_round/', 'refresh');
        }


        if (!is_null($id)) {
            $roundinfo = $this->db->get_where('application_round', array('id' => $id))->row();
            if ($roundinfo) {
                $this->data['roundinfo'] = $roundinfo;
            }
        }

        $this->data['application_rounds'] = $this->common_model->get_application_rounds()->result();


        $this->data['active_menu'] = 'settings';
        $this->data['content'] = 'setting/application_round';
        $this->load->view('template', $this->data);
    }


    function current_semester($id = null)
    {
        $current_user = current_user();

        $this->data['id'] = $id;
        if (!is_null($id)) {
            $id = decode_id($id);
        }

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'SETTINGS','current_semester')) {
            $this->session->set_flashdata("message", show_alert("CURRENT_SEMESTER :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Settings');
        $this->data['bscrum'][] = array('link' => 'current_semester/', 'title' => 'Current Semester');

        $this->form_validation->set_rules('semester', 'Semester', 'required');
        $this->form_validation->set_rules('ayear', 'Academic Year', 'required');

        if ($this->form_validation->run() == true) {
            $array = array(
                'AYear' => trim($this->input->post('ayear')),
                'semester' => trim($this->input->post('semester')),
                'Status' => ($this->input->post('status') ? $this->input->post('status') : 0),
            );

            $this->setting_model->add_ayear($array);
            $this->session->set_flashdata('message', show_alert('Information saved ', 'success'));
            redirect('current_semester/', 'refresh');
        }

        if (!is_null($id)) {
            $yearinfo = $this->db->get_where('ayear', array('id' => $id))->row();
            if ($yearinfo) {
                $this->data['yearinfo'] = $yearinfo;
            }
        }

        $this->data['academic_year'] = $this->common_model->get_academic_year(null, null)->result();

        $this->data['semester_list'] = $this->common_model->get_semester(2);

        $this->data['active_menu'] = 'settings';
        $this->data['content'] = 'setting/current_semester';
        $this->load->view('template', $this->data);
    }



    function current_account_year($id = null)
    {

        $current_user = current_user();

        $this->data['id'] = $id;
        if (!is_null($id)) {
            $id = decode_id($id);
        }

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'SETTINGS','current_semester')) {
            $this->session->set_flashdata("message", show_alert("CURRENT_SEMESTER :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Settings');
        $this->data['bscrum'][] = array('link' => 'current_account_year/', 'title' => 'Current Accounting Year');

        $this->form_validation->set_rules('ayear', 'Account Year', 'required');

        if ($this->form_validation->run() == true) {
            $array = array(
                'AYear' => trim($this->input->post('ayear')),
                'Status' => ($this->input->post('status') ? $this->input->post('status') : 0),
            );

            $this->setting_model->add_account_ayear($array);
            $this->session->set_flashdata('message', show_alert('Information saved ', 'success'));
            redirect('current_account_year/', 'refresh');
        }

        if (!is_null($id)) {
            $yearinfo = $this->db->get_where('account_year', array('id' => $id))->row();
            if ($yearinfo) {
                $this->data['yearinfo'] = $yearinfo;
            }
        }


        $this->data['account_year'] = $this->common_model->get_account_year(null, null)->result();

        $this->data['active_menu'] = 'settings';
        $this->data['content'] = 'setting/current_accounting_year';
        $this->load->view('template', $this->data);
    }
    function application_deadline()
    {
        $current_user = current_user();

        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'SETTINGS','application_deadline')) {
            $this->session->set_flashdata("message", show_alert("APPLICATION_DEADLINE :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Settings');
        $this->data['bscrum'][] = array('link' => 'application_deadline/', 'title' => 'Application Deadline');

        $this->form_validation->set_rules('deadline', 'Deadline', 'required|valid_date');

        if ($this->form_validation->run() == true) {
            $array = array(
                'deadline' => format_date($this->input->post('deadline')),
                'post_graduate'=>$this->input->post('post_graduate'),
                'degree'=>$this->input->post('graduate'),
                'diploma'=>$this->input->post('diploma')

            );


            $this->db->update('application_deadline', $array);
            $this->session->set_flashdata('message', show_alert('Information saved !!', 'success'));
            redirect('application_deadline', 'refresh');
        }

        $this->data['deadline'] = $this->common_model->get_application_deadline()->row();
        $this->data['active_menu'] = 'settings';
        $this->data['content'] = 'setting/application_deadline';
        $this->load->view('template', $this->data);
    }

}