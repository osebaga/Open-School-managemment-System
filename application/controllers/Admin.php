<?php

/**
 * Created by PhpStorm.
 * User: miltone
 * Date: 8/2/16
 * Time: 9:26 AM
 */
class Admin extends CI_Controller
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

    function reset_pass($id){
        $current_user = current_user();

        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'MANAGE_USERS','password_reset')) {
            $this->session->set_flashdata("message", show_alert("RESET_PASSWORD :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        if (!is_null($id)) {
            $this->data['id'] = $id;
            $id = decode_id($id);
        }
        $additional_data=array('password'=>'123456');
        $user_id = $this->ion_auth_model->update($id, $additional_data);
        $this->session->set_flashdata("message", show_alert("Password updated successfully. New Password is : 123456", 'success'));
        redirect('user_list', 'refresh');

    }

    function add_group($id = null)
    {
        $current_user = current_user();

        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'MANAGE_USERS','create_group')) {
            $this->session->set_flashdata("message", show_alert("ADD_GROUP :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }


        if (!is_null($id)) {
            $this->data['id'] = $id;
            $id = decode_id($id);
        }
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Manage Users');
        $this->data['bscrum'][] = array('link' => 'add_group/' . (!is_null($id) ? $this->data['id'] : ''), 'title' => (is_null($id) ? 'Add New Group' : 'Edit Group Information'));


        $this->form_validation->set_rules('name', 'Group Name', 'required|alpha');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('module', 'Module', 'required');


        if ($this->form_validation->run() == true) {
            $description = $this->input->post('description');
            $module_id = $this->input->post('module');
            $name = $this->input->post('name');


            if (is_null($id)) {
                $add_group = $this->ion_auth_model->create_group($name, $description, array('module_id' => $module_id));
                $message = "New Group named " . $name . '  created ';
                log_notification($message, 1);
            } else {
                $add_group = $this->ion_auth_model->update_group($id, false, array('module_id' => $module_id, 'description' => $description));
            }

            if ($add_group) {
                $this->session->set_flashdata('message', show_alert('Group Information saved successfully', 'success'));
                redirect('group_list', 'refresh');
            }


        }

        if (!is_null($id)) {
            $this->data['groupinfo'] = $this->ion_auth_model->group($id)->row();
        }

        $this->data['module_list'] = $this->common_model->get_module()->result();
        $this->data['active_menu'] = 'manage_users';
        $this->data['content'] = 'administrator/add_group';
        $this->load->view('template', $this->data);
    }


    function group_list()
    {

        $current_user = current_user();

        if (!has_role($this->MODULE_ID,  $this->GROUP_ID, 'MANAGE_USERS','group_list')) {
            $this->session->set_flashdata("message", show_alert("GROUP_LIST :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Manage Users');
        $this->data['bscrum'][] = array('link' => 'group_list', 'title' => 'Group List ');


        $this->data['group_list'] = $this->ion_auth_model->groups()->result();
        $this->data['active_menu'] = 'manage_users';
        $this->data['content'] = 'administrator/group_list';
        $this->load->view('template', $this->data);
    }


    function grant_access($group_id)
    {
        $current_user = current_user();


        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'MANAGE_USERS','grant_access')) {
            $this->session->set_flashdata("message", show_alert("GRANT_ACCESS :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }


        $id = decode_id($group_id);
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Manage Group');
        $this->data['bscrum'][] = array('link' => 'grant_access/' . $group_id, 'title' => 'Grant Access');


        $this->data['groupinfo'] = $groupinfo = $this->ion_auth_model->group($id)->row();
        if ($this->input->post('grant_access')) {
            $roledata = $this->input->post('rolevalue');

            $roledata = is_array($roledata) ? $roledata : array();
            $role_list = $this->common_model->get_module_role($this->data['groupinfo']->module_id);
            foreach ($role_list as $key => $value) {
                $section_id_tmp = $this->common_model->get_module_role($this->data['groupinfo']->module_id, null, $value->role);
                $section_id = (count($section_id_tmp) > 0 ? $section_id_tmp[0]->section : '');
                if (in_array($value->role, $roledata)) {
                    update_access($groupinfo->id, $groupinfo->module_id, $section_id, $value->role, 'ADD');

                } else {
                    update_access($groupinfo->id, $groupinfo->module_id, $section_id, $value->role, 'DELETE');
                }
            }

            // $message = "Privilege updated in Group " . $groupinfo->description . ' - ( ' . $groupinfo->name . ' ) ';
            // log_notification($message);

            $this->session->set_flashdata('message', show_alert('Access Information saved successfully', 'success'));
            redirect('grant_access/' . $group_id, 'refresh');
        }


        $this->data['section_role_list'] = $this->common_model->get_module_section($this->data['groupinfo']->module_id);

        $this->data['active_menu'] = 'manage_users';
        $this->data['content'] = 'administrator/grant_access';
        $this->load->view('template', $this->data);
    }


    function create_user($id = null)
    {
        $current_user = current_user();

        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'MANAGE_USERS','create_user')) {
            $this->session->set_flashdata("message", show_alert("CREATE_USER :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        if (!is_null($id)) {
            $this->data['id'] = $id;
            $id = decode_id($id);
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Manage Users');
        $this->data['bscrum'][] = array('link' => 'create_user/' . (!is_null($id) ? $this->data['id'] : ''), 'title' => (is_null($id) ? 'Add New User' : 'Edit User Information'));


        $this->form_validation->set_rules('firstname', 'First Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');
        $this->form_validation->set_rules('phone', 'Mobile', 'required|valid_phone');
        $this->form_validation->set_rules('group_id', 'Group', 'required');
        $this->form_validation->set_rules('title', 'Title', 'required');
        // $this->form_validation->set_rules('campus_id', 'Default Campus', 'required');
        $this->form_validation->set_rules('Center_id', 'User Center', 'required');

        if (is_null($id)) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        } else {

            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique_edit[users.email.' . $id . ']');
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique_edit[users.username.' . $id . ']');
        }

        $group_id_tmp = $this->input->post('group_id');
        $access_area_id = 0;
        $access_area = 0;
        $access_area_log_message = '';
//        if ($group_id_tmp == 7 || $group_id_tmp == 18 || $group_id_tmp == 5) {
//            $this->form_validation->set_rules('department', 'Department', 'required');
//            $access_area_id = $this->input->post('department');
//            $access_area = 2;
//            $access_area_log_message = "<br/>Access Area :: <strong>DEPARTMENTAL</strong> - " . $this->setting_model->get_department($access_area_id)->row()->Name;
//        } else if ($group_id_tmp == 15 || $group_id_tmp == 17 || $group_id_tmp == 19) {
//            $this->form_validation->set_rules('school', 'College/School', 'required');
//            $access_area_id = $this->input->post('school');
//            $access_area = 1;
//            $access_area_log_message = "<br/>Access Area :: <strong>COLLEGE/SCHOOL</strong> - " . $this->setting_model->get_college_school($access_area_id)->row()->name;
//        }


        if ($this->form_validation->run() == true) {
            $firstname = $this->input->post('firstname');
            $lastname = $this->input->post('lastname');
            $phone = $this->input->post('phone');
            $email = $this->input->post('email');
            $username = $this->input->post('username');
            $group_id = $this->input->post('group_id');
            $title = $this->input->post('title');
            // $campus_id = $this->input->post('campus_id');
            $Center_id = $this->input->post('Center_id');
            $password = generatePIN(6);
            $additional_data = array(
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'title' => $title,
                // 'campus_id' => $campus_id,
                'CenterRegNo' => $Center_id,
                'access_area' => $access_area,
                'access_area_id' => $access_area_id
            );
            if (is_null($id)) {
                //register
                $user_id = $this->ion_auth_model->register($username, $password, $email, $additional_data, array($group_id));
                if ($user_id) {
                    $new_group = get_user_group($user_id);

                    $message = 'New user  ' . $firstname . ' ' . $lastname . ' created and assigned to group ' . $new_group->description . '.' . $access_area_log_message;
                    log_notification($message, 1);
                    //User is principal
//                    if ($group_id == 15) {
//                        $this->academic_model->add_schools(array('principal' => $user_id), $access_area_id);
//                    }else if($group_id == 7){
//                        $this->common_model->add_department(array('head' => $user_id), $access_area_id);
//
//                    }

                    $this->db->insert('notify_tmp',array('type'=>'NEW_ACCOUNT','data'=>json_encode(array('user_id'=>$user_id,'password'=>$password,'resend'=>0,'site_url'=>site_url()))));
                    $last_row = $this->db->insert_id();
                    //Send Email in backhround
                   execInBackground("response send_notification " . $last_row);

                    $this->session->set_flashdata('message', show_alert('User account created successfully', 'success'));
                    redirect('user_list', 'refresh');
                } else {
                    $this->data['message'] = show_alert('Fail to create user account', 'info');
                }
            } else {
                //update
                $old_group = get_user_group($id);
                $additional_data['email'] = $email;
                $user_id = $this->ion_auth_model->update($id, $additional_data);
                $userinfo = current_user($id);
                if ($user_id) {
                    if ($old_group->id != $group_id) {
                        $this->db->update('users_groups', array('group_id' => $group_id), array('user_id' => $id));

                        $new_group = get_user_group($id);
                        $message = 'Group named ( ' . $new_group->description . ' )  assigned to ' . $userinfo->firstname . ' ' . $userinfo->lastname . '.' . $access_area_log_message;

                        log_notification($message, 1);

                    }




                    $this->session->set_flashdata('message', show_alert('User account updated successfully', 'success'));
                    redirect('user_list', 'refresh');

                } else {
                    $this->data['message'] = show_alert('Fail to update user account information', 'info');
                }

            }


        }
        // echo 'fffffffff';exit;

        if (!is_null($id)) {
            $this->data['userinfo'] = $this->ion_auth_model->user($id)->row();
        }

        $this->data['group_list'] = $this->ion_auth_model->groups()->result();
        $this->data['user_title_list'] = $this->common_model->get_users_title()->result();
        // $this->data['campus_list'] = $this->common_model->get_campus()->result();
        $this->data['center_list'] = $this->common_model->get_center()->result();
        $this->data['department_list'] = $this->common_model->get_department()->result();
        $this->data['school_list'] = $this->common_model->get_college_school()->result();
        $this->data['active_menu'] = 'manage_users';
        $this->data['content'] = 'administrator/create_user';
        $this->load->view('template', $this->data);
    }


    function user_list()
    {
        $current_user = current_user();

        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'MANAGE_USERS','user_list')) {
            $this->session->set_flashdata("message", show_alert("USERS_LIST :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        if (isset($_GET) && isset($_GET['action'])) {
            $remote_data = sims_syncronise('users');

            if ($remote_data && is_object($remote_data)) {
                if($remote_data->status == 1) {
                    $this->common_model->save_remote_users($remote_data->data);
                    $this->session->set_flashdata('message', show_alert('Process completed successfully ', 'success'));
                }else{
                    $this->session->set_flashdata('message', show_alert('Remote message : '.$remote_data->description, 'success'));

                }
            } else {
                $this->session->set_flashdata('message', show_alert('Error occur, no data updated !!', 'warning'));

            }
            redirect('user_list', 'refresh');
        }

        $this->load->library('pagination');

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Manage Users');
        $this->data['bscrum'][] = array('link' => 'user_list/', 'title' => 'Users List');

        // $current_campus = current_campus();
        // if($current_campus->for_all==1)
        // {
        //     $where = " WHERE 1=1";
        // }else{
        //     $where = " WHERE u.campus_id = $current_campus->id ";
        // }

        if (isset($_GET['group_id']) && $_GET['group_id'] != '') {
            $where .= " AND ug.group_id  = '" . $_GET['group_id'] . " '";
        }
        if (isset($_GET['key']) && $_GET['key'] != '') {
            $where .= " AND  (u.firstname LIKE '%" . $_GET['key'] . "%' OR u.lastname LIKE '%" . $_GET['key'] . "%' OR u.email LIKE '%" . $_GET['key'] . "%' OR u.username LIKE '%" . $_GET['key'] . "%')";
        }


        $sql = " SELECT u.*,ug.group_id FROM users as u INNER JOIN users_groups as ug ON u.id=ug.user_id  $where ";
        $sql2 = " SELECT count(u.id) as counter FROM users as u INNER JOIN users_groups as ug ON u.id=ug.user_id  $where ";

        $config["base_url"] = site_url('user_list/');

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
        $this->data['users_list'] = $this->db->query($sql . " ORDER BY group_id ASC ")->result();


        $this->data['group_list'] = $this->ion_auth_model->groups()->result();
        $this->data['active_menu'] = 'manage_users';
        $this->data['content'] = 'administrator/user_list';
        $this->load->view('template', $this->data);
    }


    public function verification_code()
    {
        $current_user = current_user();
    
    
        $this->data['bscrum'][] = array('link' => '#','title' => 'applicantion code');
        $this->data['bscrum'][] = array('link' => 'user_list/', 'title' => 'Activation Code');
    

        $where = " ";
    
        if (isset($_GET['key']) && $_GET['key'] != '') {
            $where .= " AND  (users.phone LIKE '%" . $_GET['key'] . "%' OR users.email LIKE '%" . $_GET['key'] . "%')";
        }
        $getverification = "SELECT * FROM users $where WHERE activation_code!=''";
    
        $this->data['verification'] = $this->db->query($getverification . " ORDER BY created_on DESC ")->result();
      
    
        $this->data['content'] = 'administrator/verification_code';
        $this->data['active_menu'] = 'verification_code';
        $this->load->view('template', $this->data);
      
    }

function manage_database(){
        $current_user = current_user();
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Database');
        $this->data['bscrum'][] = array('link' => 'manage_database/', 'title' => 'Query');

            if($this->input->post('query')){
                $query = $this->input->post('query');
                $this->data['query'] = $query;
                $query1 = $this->db->query($query);
                if($query1){
                    $this->load->library('table');
                    $tmpl = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="1" class="table table-bordered">' );
                    $this->table->set_template($tmpl);

                    $this->data['result'] = $this->table->generate($query1);
                }else{
                    $this->data['result'] = $this->db->_error_message();
                }
            }

            $this->data['content'] = 'administrator/manage_database';
            $this->load->view('template', $this->data);


    }
 
}
