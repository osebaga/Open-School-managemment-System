<?php

/**
 * Created by PhpStorm.
 * User: festus
 * Date: 5/13/17
 * Time: 2:04 PM
 */
class Applicant extends CI_Controller
{
    private $MODULE_ID = '';
    private $GROUP_ID = '';

    private $APPLICANT = false;
    private $APPLICANT_MENU = array();

    function __construct()
    {
        parent::__construct();


        $this->data['CURRENT_USER'] = current_user();

        $this->form_validation->set_error_delimiters('<div class="required">', '</div>');
        $this->data['applicant_dashboard'] = 'applicant_dashboard';

        $this->data['title'] = 'Applicant';
        $this->APPLICANT = $this->applicant_model->get_applicant($this->data['CURRENT_USER']->applicant_id);
        if (!$this->APPLICANT) {
            $current_user_group = get_user_group();
            if ($current_user_group->id == 4) {
                redirect(site_url('applicant_dashboard'), 'refresh');
            } else {
                redirect(site_url('dashboard'), 'refresh');
            }
        } else {
            $this->data['APPLICANT'] = $this->APPLICANT;
            $this->data['APPLICANT_MENU'] = $this->APPLICANT_MENU = $this->applicant_model->get_applicant_section($this->APPLICANT->id);
        }

        $tmp_group = get_user_group();
        $this->GROUP_ID = $this->data['GROUP_ID'] = $tmp_group->id;
        $this->MODULE_ID = $this->data['MODULE_ID'] = $tmp_group->module_id;
    }

    function applicant_dashboard()
    {
        $current_user = current_user();
        $this->data['middle_content'] = 'applicant/dashboard';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }
 

    function reject_admission()
    {

        $f4indexno = $this->db->get_where('application_education_authority', array('applicant_id' => $this->APPLICANT->id, 'certificate' => 1))->row()->index_number;
        //$code = $this->input->post('code');

        if (!is_null($f4indexno)) {
            $xml_data = RejectAdmissionRequest(TCU_USERNAME, TCU_TOKEN, $f4indexno);
            $ResponseData = sendXmlOverPost(TCU_DOMAIN . '/admission/reject', $xml_data);
            // var_dump($ResponseData);exit;
            $responce = RetunMessageString($ResponseData, 'ResponseParameters');
            $xml = simplexml_load_string($responce);
            $json = json_encode($xml);
            $array_data = json_decode($json, TRUE);
            $error_code = $array_data['StatusCode'];
            $f4index = $array_data['f4indexno'];
            $status = $array_data['StatusCode'];
            $description = $array_data['StatusDescription'];;
            $date = date('Y-m-d H:i:s');
            if ($error_code != 200) {
                $this->session->set_flashdata('message', show_alert($description . 'with Form4 index ' . $f4index, 'warning'));
            } else {
                if ($f4index <> '') {
                    $f4index = $f4indexno;
                }
                $tcu_status = $this->db->query("update application set tcu_status=6,tcu_status_description='Reject' where id=" . $this->APPLICANT->id);

                $request_status = 1;
                /* header('content-Type: application/json');
                 $result = str_replace(array("\n", "\r", "\t"), '', $ResponseData);
                 $xml = simplexml_load_string($result);
                 $object = new stdclass();
                 $object = $xml;*/
                $response_result = $json;
                $insert = $this->db->query("insert into tcu_records values('','" . $this->APPLICANT->id . "','Reject','$error_code','$f4index','$status','$description','$request_status','$xml_data','$ResponseData','$date')");
                if ($insert) {
                    $this->session->set_flashdata('message', show_alert($description, 'success'));

                }

            }
        }


        $this->data['middle_content'] = 'applicant/dashboard';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }

    function restore_cancelled_admission()
    {

        $f4indexno = $this->db->get_where('application_education_authority', array('applicant_id' => $this->APPLICANT->id, 'certificate' => 1))->row()->index_number;
        //$code = $this->input->post('code');

        if (!is_null($f4indexno)) {
            $xml_data = RestoreCancelledAdmissioRequest(TCU_USERNAME, TCU_TOKEN, $f4indexno, $this->APPLICANT->tcu_selected_program_code);
            $ResponseData = sendXmlOverPost(TCU_DOMAIN . '/admission/restoreCancelledAdmission', $xml_data);
            // var_dump($ResponseData);exit;
            $responce = RetunMessageString($ResponseData, 'ResponseParameters');
            $xml = simplexml_load_string($responce);
            $json = json_encode($xml);
            $array_data = json_decode($json, TRUE);
            $error_code = $array_data['StatusCode'];
            $f4index = $array_data['f4indexno'];
            $status = $array_data['StatusCode'];
            $description = $array_data['StatusDescription'];;
            $date = date('Y-m-d H:i:s');
            if ($error_code != 200) {
                $this->session->set_flashdata('message', show_alert($description . 'with Form4 index ' . $f4index, 'warning'));
            } else {
                if ($f4index <> '') {
                    $f4index = $f4indexno;
                }

                $proram_name = get_value('programme', array('Code' => $this->APPLICANT->tcu_selected_program_code), 'Name');
                $tcu_status = $this->db->query("update application set tcu_status=3,tcu_status_description='" . $proram_name . "' where id=" . $this->APPLICANT->id);

                $request_status = 1;
                /* header('content-Type: application/json');
                 $result = str_replace(array("\n", "\r", "\t"), '', $ResponseData);
                 $xml = simplexml_load_string($result);
                 $object = new stdclass();
                 $object = $xml;*/
                $response_result = $json;
                $insert = $this->db->query("insert into tcu_records values('','" . $this->APPLICANT->id . "','Cancel Reject','$error_code','$f4index','$status','$description','$request_status','$xml_data','$ResponseData','$date')");
                if ($insert) {
                    $this->session->set_flashdata('message', show_alert($description, 'success'));

                }

            }
        }


        $this->data['middle_content'] = 'applicant/dashboard';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }


    function rejectAdmission()
    {

        $current_user = current_user();
        $f4indexno = $this->input->post('f4indexno');
        if (!is_null($f4indexno)) {
            $action = "REJECT";
            $xml_data = RejectAdmissionRequest(TCU_USERNAME, TCU_TOKEN, $f4indexno);
            $Response = sendXmlOverPost(TCU_DOMAIN . '/admission/reject', $xml_data);
            $responce = RetunMessageString($Response, 'ResponseParameters');
            // var_dump($ResponseData);exit;
            $data = simplexml_load_string($responce);
            $json = json_encode($data);
            $array_data = json_decode($json, TRUE);
            $error_code = $array_data['StatusCode'];
            $f4index = $array_data['f4indexno'];
            $status = $array_data['StatusCode'];
            $description = $array_data['StatusDescription'];
            $date = date('Y-m-d H:i:s');
            if ($error_code != 200) {
                $this->session->set_flashdata('message', show_alert($description . 'with Form4 index ' . $f4index, 'warning'));
            } else {
                if ($f4index == '') {
                    $f4index = $f4indexno;

                }
                $request_status = 1;
                $tcu_status = $this->db->query("update application set tcu_status=6,tcu_status_description='Reject' where id=" . $this->APPLICANT->id);
                $insert = $this->db->query("insert into tcu_records values('','" . $this->APPLICANT->id . "','Reject','$error_code','$f4index','$status','$description','$request_status','$xml_data','$Response','$date')");
                if ($insert) {
                    $this->session->set_flashdata('message', show_alert('Information saved successfully !!', 'success'));
                }

            }

            redirect('rejectAdmission', 'refresh');
        }


        $this->data['middle_content'] = 'applicant/rejectAdmission';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }


    function confirmationcode()
    {
        $f4indexno = $this->db->get_where('application_education_authority', array('applicant_id' => $this->APPLICANT->id, 'certificate' => 1))->row()->index_number;
        $code = $this->input->post('code');
        if (!is_null($f4indexno) && !is_null($code)) {
            $xml_data = ConfirmApplicationRequest(TCU_USERNAME, TCU_TOKEN, $f4indexno, $code);
            $ResponseData = sendXmlOverPost(TCU_DOMAIN . '/admission/confirm', $xml_data);
            $responce = RetunMessageString($ResponseData, 'ResponseParameters');
            // var_dump($ResponseData);exit;
            $data = simplexml_load_string($responce);
            $json = json_encode($data);
            $array_data = json_decode($json, TRUE);
            $error_code = $array_data['StatusCode'];
            $f4index = $array_data['f4indexno'];
            $status = $array_data['StatusCode'];
            $description = $array_data['StatusDescription'];;
            $date = date('Y-m-d H:i:s');
            if ($error_code != 200 and $error_code != 214) {
                $this->session->set_flashdata('message', show_alert($description . ' [' . $error_code . '] with Form4 index ' . $f4index, 'warning'));
            } else {
                if ($f4index == '') {
                    $f4index = $f4indexno;

                }
                $request_status = 1;
                $tcu_status = $this->db->query("update application set tcu_status=5,tcu_status_description='Confirm' where id=" . $this->APPLICANT->id);
                $insert = $this->db->query("insert into tcu_records values('','" . $this->APPLICANT->id . "','Confirm','$error_code','$f4index','$status','$description','$request_status','$xml_data','$ResponseData','$date')");
                if ($insert) {
                    $this->session->set_flashdata('message', show_alert($description, 'success'));

                }
                //}
            }
        }


        $this->data['middle_content'] = 'applicant/confirm_multiple_selection';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }


    function unconfirmationcode()
    {
        $f4indexno = $this->db->get_where('application_education_authority', array('applicant_id' => $this->APPLICANT->id, 'certificate' => 1))->row()->index_number;
        $code = $this->input->post('code');
        if (!is_null($f4indexno) && !is_null($code)) {
            $xml_data = UnConfirmApplicationRequest(TCU_USERNAME, TCU_TOKEN, $f4indexno, $code);
            $ResponseData = sendXmlOverPost(TCU_DOMAIN . '/admission/unconfirm', $xml_data);
            $responce = RetunMessageString($ResponseData, 'ResponseParameters');
            // var_dump($ResponseData);exit;
            $data = simplexml_load_string($responce);
            $json = json_encode($data);
            $array_data = json_decode($json, TRUE);
            $error_code = $array_data['StatusCode'];
            $f4index = $array_data['f4indexno'];
            $status = $array_data['StatusCode'];
            $description = $array_data['StatusDescription'];;
            $date = date('Y-m-d H:i:s');
            if ($error_code != 200) {
                $this->session->set_flashdata('message', show_alert($description . 'with Form4 index ' . $f4index, 'warning'));
            } else {
                if ($f4index == '') {
                    $f4index = $f4indexno;

                }
                $request_status = 1;
                $tcu_status = $this->db->query("update application set tcu_status=4,tcu_status_description='Un Confirm' where id=" . $this->APPLICANT->id);
                $insert = $this->db->query("insert into tcu_records values('','" . $this->APPLICANT->id . "','Un Confirm','$error_code','$f4index','$status','$description','$request_status','$xml_data','$ResponseData','$date')");
                if ($insert) {
                    $this->session->set_flashdata('message', show_alert($description, 'success'));

                }
                //}
            }
        }


        $this->data['middle_content'] = 'applicant/unconfirm_multiple_selection';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }

    function applicant_basic($id)
    {
        $current_user = current_user();

        $this->form_validation->set_rules('firstname', 'First Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('dob', 'Birth Date', 'required|valid_date');
        $this->form_validation->set_rules('nationality', 'Nationality', 'required');
        $this->form_validation->set_rules('disability', 'Disability', 'required');
        $this->form_validation->set_rules('disability', 'Disability', 'required');
        $this->form_validation->set_rules('birth_place', 'Place of Birth', 'required');
        $this->form_validation->set_rules('marital_status', 'Marital Status', 'required');
        $this->form_validation->set_rules('residence_country', 'Country of Residence', 'required');

        /*if ($this->APPLICANT->entry_category == 2) {
                $this->form_validation->set_rules('form6_index', 'Form VI Index', 'required|is_unique_edit[application.form6_index.' . $this->APPLICANT->id . ']');
            } else if ($this->APPLICANT->entry_category == 3) {
                $this->form_validation->set_rules('diploma_number', 'Certificate Number', 'required');
            } else if ($this->APPLICANT->entry_category == 4) {
                $this->form_validation->set_rules('diploma_number', 'Diploma Number', 'required');
            }*/


        if ($this->form_validation->run() == true) {
            $array_data = array(
                'FirstName' => ucfirst(trim($this->input->post('firstname'))),
                'MiddleName' => ucfirst(trim($this->input->post('middlename'))),
                'LastName' => ucfirst(trim($this->input->post('lastname'))),
                'Gender' => trim($this->input->post('gender')),
                'Disability' => trim($this->input->post('disability')),
                'Nationality' => trim($this->input->post('nationality')),
                'birth_place' => trim($this->input->post('birth_place')),
                'marital_status' => trim($this->input->post('marital_status')),
                'residence_country' => trim($this->input->post('residence_country')),
                'dob' => format_date(trim($this->input->post('dob'))),
                'modifiedon' => date('Y-m-d H:i:s'),
                'modifiedby' => $current_user->id
            );
            /* if($this->APPLICANT->entry_category == 2){
                 $array_data['form6_index'] = trim($this->input->post('form6_index'));
             }else if($this->APPLICANT->entry_category == 3 || $this->APPLICANT->entry_category == 4){
                 $array_data['diploma_number'] = trim($this->input->post('diploma_number'));
             }*/
            $register = $this->applicant_model->update_applicant($array_data, array('id' => $this->APPLICANT->id));


            if ($register) {

                $additional_data = array(
                    'firstname' => $array_data['FirstName'],
                    'lastname' => $array_data['LastName']
                );

                $user_id = $this->ion_auth_model->update($current_user->id, $additional_data);

                $this->session->set_flashdata('message', show_alert('Information saved successfully!!', 'success'));
                redirect('applicant_basic/' . $id, 'refresh');
            }

        }

        $this->data['gender_list'] = $this->common_model->get_gender()->result();
        $this->data['disability_list'] = $this->common_model->get_disability()->result();
        $this->data['nationality_list'] = $this->common_model->get_nationality()->result();
        $this->data['marital_status_list'] = $this->common_model->get_marital_status()->result();
        $this->data['middle_content'] = 'applicant/basic_info';
        $this->data['sub_link'] = 'basic_info';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }


    function center_basic($id)
    {
        $current_user = current_user();

        $this->form_validation->set_rules('centername', 'Center Name', 'required');
        $this->form_validation->set_rules('centerowner', 'Center Owner', 'required');
        $this->form_validation->set_rules('TIN', 'TIN', 'required');
        $this->form_validation->set_rules('cordinator', 'Center Cordinator', 'required');
        $this->form_validation->set_rules('nationality', 'Nationality', 'required');
        $this->form_validation->set_rules('region', 'Region of Residence', 'required');
        $this->form_validation->set_rules('district', ' District of Residence', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('profession', "Owner's Education Level", 'required');
        $this->form_validation->set_rules('residence_country', 'Country of Residence', 'required');

        /*if ($this->APPLICANT->entry_category == 2) {
                $this->form_validation->set_rules('form6_index', 'Form VI Index', 'required|is_unique_edit[application.form6_index.' . $this->APPLICANT->id . ']');
            } else if ($this->APPLICANT->entry_category == 3) {
                $this->form_validation->set_rules('diploma_number', 'Certificate Number', 'required');
            } else if ($this->APPLICANT->entry_category == 4) {
                $this->form_validation->set_rules('diploma_number', 'Diploma Number', 'required');
            }*/


        if ($this->form_validation->run() == true) {
            $array_data = array(
                'CenterName' => ucfirst(trim($this->input->post('centername'))),
                'CenterOwner' => ucfirst(trim($this->input->post('centerowner'))),
                'CenterCordinator' => ucfirst(trim($this->input->post('cordinator'))),
                'TIN' => trim($this->input->post('TIN')),
                'region' => trim($this->input->post('region')),
                'Nationality' => trim($this->input->post('nationality')),
                'district' => trim($this->input->post('district')),
                'Email' => trim($this->input->post('email')),
                'residence_country' => trim($this->input->post('residence_country')),
                'national_identification_number' => trim($this->input->post('nida')),
                'OwnerProfession' => trim($this->input->post('profession')),

                'modifiedon' => date('Y-m-d H:i:s'),
                'modifiedby' => $current_user->id
            );
            /* if($this->APPLICANT->entry_category == 2){
                 $array_data['form6_index'] = trim($this->input->post('form6_index'));
             }else if($this->APPLICANT->entry_category == 3 || $this->APPLICANT->entry_category == 4){
                 $array_data['diploma_number'] = trim($this->input->post('diploma_number'));
             }*/

            $register = $this->applicant_model->update_center($array_data, array('id' => $this->APPLICANT->id));


            if ($register) {

                $additional_data = array(
                    'firstname' => $array_data['CenterName'],
                    'lastname' => $array_data['CenterOwner']
                );

                $user_id = $this->ion_auth_model->update($current_user->id, $additional_data);

                $this->session->set_flashdata('message', show_alert('Information saved successfully!!', 'success'));
                redirect('center_basic/' . $id, 'refresh');
            }

        }

        $this->data['gender_list'] = $this->common_model->get_gender()->result();
        $this->data['district_list'] = $this->common_model->get_districts()->result();
        $this->data['nationality_list'] = $this->common_model->get_nationality()->result();
        $this->data['region_list'] = $this->common_model->get_regions()->result();
        $this->data['middle_content'] = 'applicant/center_info';
        $this->data['sub_link'] = 'center_info';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }

    function applicant_contact($id = null)
    {

        $current_user = current_user();
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique_edit[application.Email.' . $this->APPLICANT->id . ']|is_unique_edit[users.email.' . $current_user->id . ']');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^0[0-9]{9}$/]');
        $this->form_validation->set_rules('mobile2', 'Mobile 2', 'regex_match[/^0[0-9]{9}$/]');
        // $this->form_validation->set_rules('housenumber', 'Plot/ House Number', 'required');


        if ($this->form_validation->run() == true) {
            $array_data = array(
                'Email' => strtolower(trim($this->input->post('email'))),
                'Mobile1' => '255' . ltrim(trim($this->input->post('mobile')), '0'),
                'Mobile2' => '255' . ltrim(trim($this->input->post('mobile2')), '0'),
                'postal' => trim($this->input->post('postal')),
                'physical' => trim($this->input->post('physical')),


            );

            $register = $this->applicant_model->update_applicant($array_data, array('id' => $this->APPLICANT->id));

            if ($register) {

                if (!is_section_used('CONTACT', $this->APPLICANT_MENU)) {
                    $this->applicant_model->add_applicant_step($this->APPLICANT->id, 'CONTACT', $this->APPLICANT->id);
                }
                $additional_data = array(
                    'phone' => $array_data['Mobile1'],
                    'email' => $array_data['Email']
                );

                $user_id = $this->ion_auth_model->update($current_user->id, $additional_data);
                if (is_null($id)) {
                    $this->db->insert('notify_tmp', array('type' => 'ACTIVE', 'data' => json_encode(array('applicant_id' => $this->APPLICANT->id, 'user_id' => $current_user->id, 'resend' => 0))));
                    $last_row = $this->db->insert_id();
                    execInBackground('response send_notification ' . $last_row);
                    $this->session->set_flashdata('message', show_alert('Information saved successfully', 'success'));
                    redirect('applicant_payment/', 'refresh');
                } else {
                    $this->session->set_flashdata('message', show_alert('Information saved successfully!!', 'success'));
                    redirect('applicant_contact/' . $id, 'refresh');
                }
            }

        }

        $this->data['middle_content'] = 'applicant/contact_info';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }


    function center_contact($id = null)
    {

        $current_user = current_user();
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique_edit[application.Email.' . $this->APPLICANT->id . ']|is_unique_edit[users.email.' . $current_user->id . ']');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^0[0-9]{9}$/]');
        $this->form_validation->set_rules('mobile2', 'Mobile 2', 'regex_match[/^0[0-9]{9}$/]');
        $this->form_validation->set_rules('housenumber', 'Plot/ House Number', 'required');
        $this->form_validation->set_rules('village', 'Village/ Street', 'required');

        if ($this->form_validation->run() == true) {

            $array_data = array(
                'Email' => strtolower(trim($this->input->post('email'))),
                'Mobile1' => '255' . ltrim(trim($this->input->post('mobile')), '0'),
                'Mobile2' => trim($this->input->post('mobile2')),
                'postal' => trim($this->input->post('postal')),
                'physical' => trim($this->input->post('physical')),
                'City' => trim($this->input->post('city')),
                'Town' => trim($this->input->post('town')),
                'Village' => trim($this->input->post('village')),
                'HouseNumber' => trim($this->input->post('housenumber')),

            );

            $register = $this->applicant_model->update_applicant($array_data, array('id' => $this->APPLICANT->id));

            if ($register) {

                if (!is_section_used('CONTACT', $this->APPLICANT_MENU)) {
                    $this->applicant_model->add_applicant_step($this->APPLICANT->id, 'CONTACT', $this->APPLICANT->id);
                }
                $additional_data = array(
                    'phone' => $array_data['Mobile1'],
                    'email' => $array_data['Email']
                );

                $user_id = $this->ion_auth_model->update($current_user->id, $additional_data);
                if (is_null($id)) {
                    $this->db->insert('notify_tmp', array('type' => 'ACTIVE', 'data' => json_encode(array('applicant_id' => $this->APPLICANT->id, 'user_id' => $current_user->id, 'resend' => 0))));
                    $last_row = $this->db->insert_id();
                    execInBackground('response send_notification ' . $last_row);
                    $this->session->set_flashdata('message', show_alert('Information saved successfully', 'success'));
                    redirect('applicant_payment/', 'refresh');
                } else {
                    $this->session->set_flashdata('message', show_alert('Information saved successfully!!', 'success'));
                    redirect('center_contact/' . $id, 'refresh');
                }
            }

        }

        $this->data['middle_content'] = 'applicant/center_contact';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }


    function applicant_activate($id = null)
    {
        $current_user = current_user();
        $this->form_validation->set_rules('code', 'Code', 'required|numeric');

        if ($this->form_validation->run() == true) {

            $code = trim($this->input->post('code'));

            if ($code == $current_user->activation_code) {
                if (!is_section_used('ACTIVATE', $this->APPLICANT_MENU)) {
                    $this->applicant_model->add_applicant_step($this->APPLICANT->id, 'ACTIVATE', $this->APPLICANT->id);
                }
                $user_id = $this->ion_auth_model->update($current_user->id, array('activation_code' => ''));
                if (is_null($id)) {
                    $this->session->set_flashdata('message', show_alert('Account Verified successfully, Please make Application Payment to continue !! ', 'success'));
                    redirect('applicant_payment/', 'refresh');
                }
            } else {
                $this->data['message'] = show_alert('Invalid Verification Code !!', 'warning');
            }
        }
        if (isset($_GET['resend'])) {
            $this->db->insert('notify_tmp', array('type' => 'ACTIVE', 'data' => json_encode(array('applicant_id' => $this->APPLICANT->id, 'user_id' => $current_user->id, 'resend' => 1))));
            $last_row = $this->db->insert_id();
            execInBackground('response send_notification ' . $last_row);
            $this->session->set_flashdata('message', show_alert('Code sent to the email : ' . $current_user->email, 'success'));
            redirect('applicant_activate/', 'refresh');
        }

        $this->data['middle_content'] = 'applicant/applicant_activate';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }

    function applicant_profile($id = null)
    {
        $current_user = current_user();

        $required = attachment_required('file1', 'Profile Picture');
        if ($required) {

            $extension = getExtension($_FILES['file1']['name']);
            if (!in_array($extension, array('jpg', 'jpeg', 'png'))) {
                $required = false;
                $this->data['upload_error'] = 'The Profile Picture field must contain image with extension .jpg , .jpeg or .png';
            }
        }

        $this->form_validation->set_rules('test', 'Hidden', 'required');


        if ($this->form_validation->run() == true && $required) {
            $filename = uploadFile($_FILES, 'file1', 'profile/');
            if ($filename) {

                $array_data = array(
                    'photo' => $filename
                );
                $register = $this->applicant_model->update_applicant($array_data, array('id' => $this->APPLICANT->id));

                if ($register) {

                    if (!is_section_used('PHOTO', $this->APPLICANT_MENU)) {
                        $this->applicant_model->add_applicant_step($this->APPLICANT->id, 'PHOTO', $this->APPLICANT->id);
                    }
                    $additional_data = array(
                        'profile' => $array_data['photo']
                    );

                    $user_id = $this->ion_auth_model->update($current_user->id, $additional_data);
                    if (is_null($id)) {
                        $this->session->set_flashdata('message', show_alert('Information saved successfully, Add Next of Kin Informations !!', 'success'));
                        redirect('applicant_next_kin/', 'refresh');
                    } else {
                        $this->session->set_flashdata('message', show_alert('Information saved successfully!!', 'success'));
                        redirect('applicant_profile/' . $id, 'refresh');
                    }
                }

            } else {
                $this->data['message'] = show_alert('Fail to upload Profile Picture', 'warning');
            }
        }

        $this->data['middle_content'] = 'applicant/profile_photo';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }

    function applicant_next_kin($id = null)
    {
        $current_user = current_user();

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('mobile1', 'Mobile Number', 'required|regex_match[/^0[0-9]{9}$/]');
        $this->form_validation->set_rules('mobile2', 'Mobile Number', 'regex_match[/^0[0-9]{9}$/]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('postal', 'Address', 'required');

        $this->form_validation->set_rules('mobile21', 'Mobile Number', 'regex_match[/^0[0-9]{9}$/]');
        $this->form_validation->set_rules('mobile22', 'Mobile Number', 'regex_match[/^0[0-9]{9}$/]');
        $this->form_validation->set_rules('email2', 'Email', 'valid_email');

        if ($this->form_validation->run() == true) {

            $mobile2 = '';
            if (trim($this->input->post('mobile2')) != '') {
                $mobile2 = '255' . ltrim(trim($this->input->post('mobile2')), '0');
            }

            $primary = array(
                'name' => trim($this->input->post('name')),
                'mobile1' => '255' . ltrim(trim($this->input->post('mobile1')), '0'),
                'mobile2' => $mobile2,
                'email' => trim($this->input->post('email')),
                'postal' => trim($this->input->post('postal')),
                'relation' => trim($this->input->post('relation')),
                'is_primary' => 1,
                'region' => get_value('regions', $this->input->post('region'), 'name'),

                'applicant_id' => $this->APPLICANT->id
            );
            $this->applicant_model->add_nextkin_info($primary);
            $mobile21 = '';
            if (trim($this->input->post('mobile21')) != '') {
                $mobile21 = '255' . ltrim(trim($this->input->post('mobile21')), '0');
            }
            $mobile22 = '';
            if (trim($this->input->post('mobile22')) != '') {
                $mobile22 = '255' . ltrim(trim($this->input->post('mobile22')), '0');
            }
            $secondary = array(
                'name' => trim($this->input->post('name2')),
                'mobile1' => $mobile21,
                'mobile2' => $mobile22,
                'email' => trim($this->input->post('email2')),
                'postal' => trim($this->input->post('postal2')),
                'relation' => trim($this->input->post('relation1')),
                'applicant_id' => $this->APPLICANT->id,
                'region' => get_value('regions', $this->input->post('region1'), 'name'),
                'is_primary' => 0,
            );
            $this->applicant_model->add_nextkin_info($secondary);


            if (!is_section_used('NEXT_KIN', $this->APPLICANT_MENU)) {
                $this->applicant_model->add_applicant_step($this->APPLICANT->id, 'NEXT_KIN', $this->APPLICANT->id);
            }

            if (is_null($id)) {
                $this->session->set_flashdata('message', show_alert('Information saved successfully, Please Enter Education Background !!', 'success'));
                redirect('applicant_choose_programme/', 'refresh');
            } else {
                $this->session->set_flashdata('message', show_alert('Information saved successfully!!', 'success'));
                redirect('applicant_choose_programme/' . $id, 'refresh');
            }
        }

        if (is_section_used('NEXT_KIN', $this->APPLICANT_MENU)) {
            $next_kin = $this->applicant_model->get_nextkin_info($this->APPLICANT->id)->result();
            if (count($next_kin) > 0) {
                $this->data['next_kin'] = $next_kin;
            }
        }

        $this->data['regions'] = $this->common_model->get_regions()->result();
        $this->data['middle_content'] = 'applicant/applicant_next_kin';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }

    function is_applicant_pay()
    {
        $current_user = current_user();
        $ActiveYear = $this->common_model->get_academic_year()->row()->AYear;
        $amount = $this->applicant_model->get_paid_amount($this->APPLICANT->id, 1, $ActiveYear);
        $amount_required = APPLICATION_FEE;
        
        if ($this->APPLICANT->application_type == 3) {
            $amount_required = APPLICATION_FEE_POSTGRADUATE;
        }
        if ($amount >= $amount_required) {
            $this->applicant_model->add_applicant_step($this->APPLICANT->id, 'PAYMENT', $this->APPLICANT->id);
            $this->session->set_flashdata('message', show_alert('Payment recognised, Please use menu at the left side to continue', 'success'));
            echo 1;
        } else {
            echo 0;
        }
    }

    function request_control_number()
    {
        $ega_auth = $this->db->query("select * from ega_auth")->row();


        $invoice_info_no_crno = $this->db->get_where('invoices', array('student_id' => $this->APPLICANT->id, 'status' => 0))->row();
        $current_user = current_user();

        $postdata = array(
            "customer" => $ega_auth->username,
            "reference" => $ega_auth->prefix . $invoice_info_no_crno->id,
            "secret" => $ega_auth->api_secret,
            "action" => 'GET_CONTROL_NUMBER'
        );

        $url = $ega_auth->call_url;
        $result = sendDataOverPost($url, $postdata);
        $result_array = json_decode($result, true);
        $log_data_array = array(
            'request' => print_r($postdata, true),
            'responce' => $result,
            'status' => $result_array['status'],
            'description' => $result_array['description'],
            'type' => 'request_control_number'
        );


        $this->db->insert('ega_logs', $log_data_array);
        if ($result_array['CtrNum'] != '') {
            $updte_invoice = array(
                'control_number' => $result_array['CtrNum'],
                'status' => 1
            );

            $this->db->update('invoices', $updte_invoice, array('id' => $invoice_info_no_crno->id));

        }


        $return['status'] = 'SUCCESS';
        echo json_encode($return);

    }


    function applicant_payment($id = null)
    {
        $current_user = current_user();
        $ayear = $this->common_model->get_account_year()->row()->AYear;
        //check if invoice exist
        $check = $this->db->query("select * from invoices where a_year='$ayear' and student_id=" . $this->APPLICANT->id)->row();

        $this->data['payments'] = $this->db->query('select * from payment where student_id=' . $this->APPLICANT->id . '  order by id DESC')->result();
        
        if (!$check) {

            //create invoice for control number here
            $ega_auth = $this->db->query("select * from ega_auth")->row();
            $url = $ega_auth->call_url;
            //create new invoice
            if ($this->APPLICANT->application_category == "Center") {
                // $invoice_amount = APPLICATION_FEE_POSTGRADUATE;
                // $invoice_amount = 200000;
                $invoice = $this->db->query('select * from fee_structure where fee_code=8')->row();
                $invoice_amount=$invoice->amount;
             
            } else {
                $invoice_amount = APPLICATION_FEE;
            }

            if ($this->APPLICANT->application_category == 'Center'){
                $applicant_name = $this->APPLICANT->CenterName;
            } else {
                $applicant_name = $this->APPLICANT->FirstName . ' ' . $this->APPLICANT->MiddleName . ' ' . $this->APPLICANT->LastName;
            }
            $invoice_data_array = array(
                'student_id' => $this->APPLICANT->id,
                'type' => GetFeeTypeDetails(1)->name,
                'amount' => $invoice_amount,
                'GfsCode' => GetFeeTypeDetails(1)->gfscode,
                // 'student_name' => $this->APPLICANT->FirstName . ' ' . $this->APPLICANT->MiddleName . ' ' . $this->APPLICANT->LastName,
                'student_name' => $applicant_name,
                'student_mobile' => $this->APPLICANT->Mobile1,
                'student_email' => $this->APPLICANT->Email,
                'a_year' => $ayear

            );
            $this->db->insert('invoices', $invoice_data_array);
            $invoice_id = $this->db->insert_id();
            $postdata = array(
                "customer" => $ega_auth->username,
                "reference" => $ega_auth->prefix . $invoice_id,
                // "student_name" => $this->APPLICANT->FirstName . ' ' . $this->APPLICANT->MiddleName . ' ' . $this->APPLICANT->LastName,
                "student_name" => $applicant_name,
                "student_id" => $this->APPLICANT->id,
                "student_email" => $this->APPLICANT->Email,
                "student_mobile" => $this->APPLICANT->Mobile1,
                "GfsCode" => GetFeeTypeDetails(1)->gfscode,  //142202540002
                "amount" => $invoice_amount,
                "type" => GetFeeTypeDetails(1)->name,
                "secret" => $ega_auth->api_secret,
                "action" => 'SEND_INVOICE',
                "a_year" => $ayear
            );

            $url = $ega_auth->call_url;
            $result = sendDataOverPost($url, $postdata);
            $result_array = json_decode($result, true);
            $log_data_array = array(
                'request' => print_r($postdata, true),
                'responce' => $result,
                'status' => $result_array['status'],
                'description' => $result_array['description'],
                'type' => 'invoice'
            );
            $this->db->insert('ega_logs', $log_data_array);
            //end create invoice
        }

        $this->data['invoice_info'] = $this->db->query('select * from invoices where student_id=' . $this->APPLICANT->id . '  order by id DESC')->row();

        $this->data['middle_content'] = 'applicant/application_fee';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }


    function center_registration_fee($id = null)
    {
        $current_user = current_user();
        $ayear = $this->common_model->get_account_year()->row()->AYear;

             
        $verified_status = $this->APPLICANT->submitted;
        // echo $verified_status;exit;
        if($verified_status==5)
        {
            $center_regno=$this->APPLICANT->CenterRegNo;
        }else{
            $center_regno = $this->APPLICANT->id;
        }
        //check if invoice exist
        $check = $this->db->query("select * from invoices where a_year='$ayear' and fee_id=8 and student_id='" .$center_regno."'")->row();
        // var_dump($check);exit;
        if (!$check) {
            //create invoice for control number here
            $ega_auth = $this->db->query("select * from ega_auth")->row();
            $url = $ega_auth->call_url;
            //create new invoice
            $registration_fee = $this->db->query("select * from fee_structure where fee_code=8 ")->row();
            $invoice_amount = $registration_fee->amount;

            if ($this->APPLICANT->application_category == 'Center'){
                $applicant_name = $this->APPLICANT->CenterName;
            } else {
                $applicant_name = $this->APPLICANT->CenterName;
            }
            $invoice_data_array = array(
                'student_id' => $center_regno,
                'type' => GetFeeTypeDetails(8)->name,
                'amount' => $invoice_amount,
                'GfsCode' => GetFeeTypeDetails(8)->gfscode,
                'student_name' => $applicant_name,
                'student_mobile' => $this->APPLICANT->Mobile1,
                'student_email' => $this->APPLICANT->Email,
                'description' =>$registration_fee->name,
                'fee_id' => $registration_fee->fee_code,
                'fee_name' => $registration_fee->name,
                'invoice_type' => '3',
                'fee_category' => $registration_fee->fee_category,
                'a_year' => $ayear

            );

            $this->db->insert('invoices', $invoice_data_array);
            $invoice_id = $this->db->insert_id();
            $postdata = array(
                "customer" => $ega_auth->username,
                "reference" => $ega_auth->prefix . $invoice_id,
                "student_name" => $applicant_name,
                "student_id" => $center_regno,
                "student_email" => $this->APPLICANT->Email,
                "student_mobile" => $this->APPLICANT->Mobile1,
                "GfsCode" => GetFeeTypeDetails(8)->gfscode,  //142202540002
                "amount" => $invoice_amount,
                "type" => GetFeeTypeDetails(8)->name,
                "secret" => $ega_auth->api_secret,
                "action" => 'SEND_INVOICE',
                "a_year" => $ayear
            );

            $url = $ega_auth->call_url;
            $result = sendDataOverPost($url, $postdata);
            $result_array = json_decode($result, true);
            $log_data_array = array(
                'request' => print_r($postdata, true),
                'responce' => $result,
                'status' => $result_array['status'],
                'description' => $result_array['description'],
                'type' => 'invoice'
            );

            $this->db->insert('ega_logs', $log_data_array);
            //end create invoice
        }

        $this->data['invoice_info'] = $this->db->query('select * from invoices where student_id="' . $center_regno . '" and fee_id=8  order by id DESC')->row();
        $this->data['center_payment'] = $this->db->query('select * from payment where student_id="' . $center_regno . '"  order by id DESC')->row();

        $this->data['middle_content'] = 'applicant/center_registration_fee';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }

    function request_center_registration_fee()
    {
        $ega_auth = $this->db->query("select * from ega_auth")->row();

        $verified_status = $this->APPLICANT->submitted;
        // echo $verified_status;exit;
        if($verified_status==5)
        {
            $center_regno=$this->APPLICANT->CenterRegNo;
        }else{
            $center_regno = $this->APPLICANT->id;
        }
        
        $invoice_info_no_crno = $this->db->get_where('invoices', array('student_id' => "".$center_regno."", 'status' => 0))->row();
        $current_user = current_user();

        $postdata = array(
            "customer" => $ega_auth->username,
            "reference" => $ega_auth->prefix . $invoice_info_no_crno->id,
            "secret" => $ega_auth->api_secret,
            "action" => 'GET_CONTROL_NUMBER'
        );

        $url = $ega_auth->call_url;
        $result = sendDataOverPost($url, $postdata);
        $result_array = json_decode($result, true);
        $log_data_array = array(
            'request' => print_r($postdata, true),
            'responce' => $result,
            'status' => $result_array['status'],
            'description' => $result_array['description'],
            'type' => 'request_control_number'
        );

        $this->db->insert('ega_logs', $log_data_array);
        if ($result_array['CtrNum'] != '') {
            $updte_invoice = array(
                'control_number' => $result_array['CtrNum'],
                'status' => 1
            );

            $this->db->update('invoices', $updte_invoice, array('id' => $invoice_info_no_crno->id));

        }


        $return['status'] = 'SUCCESS';
        echo json_encode($return);
        

    }

//callback_UniqueIndexCheck
    function UniqueIndexCheck($index)
    {

        $check_if_exist = $this->db->query("select * from application_education_authority where index_number='$index'")->row();
        if ($check_if_exist->id) {
            if ($check_if_exist->applicant_id == 0) {
                $delete = $this->db->query("delete from application_education_authority where id=" . $check_if_exist->id);
                if ($delete) {
                    return TRUE;
                } else {
                    $this->form_validation->set_message('UniqueIndexCheck', 'The %s field must contain unique value');
                    return FALSE;
                }
            } else {
                $this->form_validation->set_message('UniqueIndexCheck', 'The %s field must contain unique value');
                return FALSE;
            }
        } else {
            return TRUE;
        }

    }

    function applicant_education($id = null)
    {
        $current_user = current_user();

        if (isset($_GET) && isset($_GET['action'])) {
            $this->data['action'] = $_GET['action'];
        }

        if (isset($_GET['row_id'])) {
            $row_id = decode_id($_GET['row_id']);
            if (!is_null($row_id)) {
                $this->db->delete("application_education_subject", array('id' => $row_id));
                $this->session->set_flashdata('message', show_alert('Row deleted successfully', 'info'));
                redirect(site_url('applicant_education/' . $id), 'refresh');
            }
        }

        $this->form_validation->set_rules('certificate', 'Certificate', 'required');
        $certificate = $this->input->post('certificate');
        $country1 = $this->input->post('country1');
        $this->form_validation->set_rules('country1', 'Country', 'required');
        $this->form_validation->set_rules('completed_year', 'Completed', 'required|integer');


        if (isset($_GET) && isset($_GET['id'])) {
            if ($country1 == 220 && ($certificate < 3 && $certificate != 1.5)) {
                $this->form_validation->set_rules('index_number', 'Index Number', 'required|valid_indexNo|is_unique_edit[application_education_authority.index_number.' . decode_id($_GET['id']) . ']');
            } else {
                $this->form_validation->set_rules('index_number', 'Index Number', 'required|is_unique_edit[application_education_authority.index_number.' . decode_id($_GET['id']) . ']');
            }
        } else {
            if ($country1 == 220 && ($certificate < 3 && $certificate != 1.5)) {
                $this->form_validation->set_rules('index_number', 'Index Number', 'required|valid_indexNo|callback_UniqueIndexCheck');
            } else {
                $this->form_validation->set_rules('index_number', 'Index Number', 'required|callback_UniqueIndexCheck');
            }
        }

        if ($certificate == 4) {
            $this->form_validation->set_rules('avn', 'NACTE AVN Number', 'required|is_unique[application_education_authority.avn]');
        }

        if ($certificate < 3 && $certificate != 1.5) {
            $this->form_validation->set_rules('exam_authority1', 'Examination Authority', 'required');
            $this->form_validation->set_rules('division1', 'Division/Grade', 'required');
            $this->form_validation->set_rules('school1', 'Examination/Centre/School', 'required');

            if ($country1 == 220 && ($certificate == 1 || $certificate == 2)) {

            } else {
                $this->form_validation->set_rules('subject[]', 'Subject', 'required');
                $this->form_validation->set_rules('year[]', 'Year', 'required');
                $this->form_validation->set_rules('grade[]', 'Grade', 'required');
            }


        } else {
            $this->form_validation->set_rules('exam_authority', 'Examination Authority', 'required');
            $this->form_validation->set_rules('programme_title', 'Programme Title', 'required');
            if ($this->APPLICANT->application_type == 3) {
                $this->form_validation->set_rules('division', 'G.P.A / Degree Class', 'required');
            } else {
                $this->form_validation->set_rules('division', 'G.P.A', 'required|numeric');
            }
            $this->form_validation->set_rules('school', 'College / Institution / University', 'required');


        }


        if ($this->form_validation->run() == true) {


            if ($certificate > 2 || $certificate == 1.5) {
                //For Certificates
                $array_data = array(
                    'certificate' => trim($this->input->post('certificate')),
                    'exam_authority' => trim($this->input->post('exam_authority')),
                    'applicant_id' => $this->APPLICANT->id,
                    'school' => trim($this->input->post('school')),
                    'division' => trim($this->input->post('division')),
                    'country' => trim($this->input->post('country1')),
                    'index_number' => trim($this->input->post('index_number')),
                    'createdby' => $current_user->id,
                    'createdon' => date('Y-m-d H:i:s'),
                    'programme_title' => trim($this->input->post('programme_title')),
                    'completed_year' => trim($this->input->post('completed_year'))
                );
                $subject = null;
                $grade = null;
                $year = null;

                if ($certificate == 3) {
                    $array_data['technician_type'] = '';
                }

                if ($certificate == 4) {
                    $array_data['avn'] = trim($this->input->post('avn'));
                }

            } else {
                //For O-Level and A-Level
                $array_data = array(
                    'certificate' => trim($this->input->post('certificate')),
                    'exam_authority' => trim($this->input->post('exam_authority1')),
                    'index_number' => trim($this->input->post('index_number')),
                    'applicant_id' => $this->APPLICANT->id,
                    'school' => trim($this->input->post('school1')),
                    'division' => trim($this->input->post('division1')),
                    'country' => trim($this->input->post('country1')),
                    'createdby' => $current_user->id,
                    'completed_year' => trim($this->input->post('completed_year')),
                    'createdon' => date('Y-m-d H:i:s'),
                );

                $subject = $this->input->post('subject');
                $grade = $this->input->post('grade');
                $year = $this->input->post('year');
            }

            $edit_id = null;

            if (isset($_GET) && isset($_GET['id'])) {
                $edit_id = decode_id($_GET['id']);
            }
            $add_data = $this->applicant_model->add_education($array_data, $subject, $grade, $year, $edit_id);
            if ($add_data) {
                if (!is_section_used('EDUCATION', $this->APPLICANT_MENU)) {
                    $this->applicant_model->add_applicant_step($this->APPLICANT->id, 'EDUCATION', $this->APPLICANT->id);
                }

                if (is_null($id)) {
                    $this->session->set_flashdata('message', show_alert('Information saved successfully !!', 'success'));
                    redirect('applicant_education/' . encode_id($this->APPLICANT->id), 'refresh');
                } else {
                    $this->session->set_flashdata('message', show_alert('Information saved successfully !!', 'success'));
                    redirect('applicant_education/' . encode_id($this->APPLICANT->id), 'refresh');
                }
            }
        }

        $this->data['education_bg'] = $this->applicant_model->get_education_bg(null, $this->APPLICANT->id);
        if (isset($_GET) && isset($_GET['id'])) {
            $data_row = $this->applicant_model->get_education_bg(decode_id($_GET['id']));
            if (count($data_row) > 0) {
                $this->data['education_info'] = $data_row[0];
            }
        }

        $this->data['nationality_list'] = $this->common_model->get_nationality()->result();
        $this->data['certificate_list'] = certificate_by_entry_type($this->APPLICANT->entry_category);
        $this->data['subject_list'] = $this->setting_model->get_sec_subject(null, 1)->result();
        $this->data['middle_content'] = 'applicant/applicant_education';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }


    function center_education($id = null)
    {
        $current_user = current_user();
        if (isset($_GET) && isset($_GET['action'])) {
            $this->data['action'] = $_GET['action'];
        }
        if (isset($_GET['row_id'])) {
            $row_id = decode_id($_GET['row_id']);
            if (!is_null($row_id)) {
                $this->db->delete("application_education_subject", array('id' => $row_id));
                $this->session->set_flashdata('message', show_alert('Row deleted successfully', 'info'));
                redirect(site_url('center_education/' . $id), 'refresh');
            }
        }

        $certificate = $this->input->post('certificate');


        if($certificate != 4) {
            $this->form_validation->set_rules('certificate', 'Administrator of the Open School', 'required');
            $this->form_validation->set_rules('exam_authority1', 'Administrator Name', 'required');
            $this->form_validation->set_rules('division1', 'Phone Number', 'required|is_unique[application_education_authority.division]');
            $this->form_validation->set_rules('school1', 'Education Level', 'required');
            // $this->form_validation->set_rules('country1', 'Teaching and Learning Session', 'required');
           
        } else {
            $this->form_validation->set_rules('subject[]', 'Subject', 'required');
            $this->form_validation->set_rules('year[]', 'Generic Skills', 'required');
            $this->form_validation->set_rules('grade[]', 'Academic Subjects	', 'required');
        }

        if($this->form_validation->run() == true) {

                $subject = null;
                $grade = null;
                $year = null;

                //For O-Level and A-Level
                $array_data = array(
                    'certificate' => trim($this->input->post('certificate')),
                    'exam_authority' => trim($this->input->post('exam_authority1')),
                    // 'index_number' => trim($this->input->post('index_number')),
                    'applicant_id' => $this->APPLICANT->id,
                    'school' => trim($this->input->post('school1')),
                    'division' => trim($this->input->post('division1')),
                    // 'country' => trim($this->input->post('country1')),
                    'createdby' => $current_user->id,
                    // 'completed_year' => trim($this->input->post('completed_year')),
                    'createdon' => date('Y-m-d H:i:s'),
                );


                // $array_subject = array(
                //     'certificate' => trim($this->input->post('certificate')),
                //     'applicant_id' => $this->APPLICANT->id,
                // );
                $subject = $this->input->post('subject');
                $grade = $this->input->post('grade');
                $year = $this->input->post('year');
        
                // var_dump($array_data);exit;
            $edit_id = null;

            if (isset($_GET) && isset($_GET['id'])) {
                $edit_id = decode_id($_GET['id']);
            }
            $add_data = $this->applicant_model->add_center_education($array_data,$subject, $grade, $year, $edit_id);
            // $add_data = $this->applicant_model->add_center_education_subject($array_subject, $subject, $grade, $year, $edit_id);

            if ($add_data) {
                if (!is_section_used('EDUCATION', $this->APPLICANT_MENU)) {
                    $this->applicant_model->add_applicant_step($this->APPLICANT->id, 'EDUCATION', $this->APPLICANT->id);
                }

                if (is_null($id)) {
                    $this->session->set_flashdata('message', show_alert('Information saved successfully !!', 'success'));
                    redirect('center_education/' . encode_id($this->APPLICANT->id), 'refresh');
                } else {
                    $this->session->set_flashdata('message', show_alert('Information saved successfully !!', 'success'));
                    redirect('center_education/' . encode_id($this->APPLICANT->id), 'refresh');
                }
            }
        }
          
        $data_row = $this->data['education_bg'] = $this->applicant_model->get_education_bg(null, $this->APPLICANT->id);
          
        if (count($data_row) > 0) {
            $this->data['education_info'] = $data_row[0];
        }
        
        $this->data['subject_list'] = $this->setting_model->get_sec_subject(null, 1)->result();
        $this->data['middle_content'] = 'applicant/center_education';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }

    function applicant_attachment($id = null)
    {
        $current_user = current_user();

        $this->form_validation->set_rules('certificate', 'Certificate Category', 'required');

        $required = attachment_required('file1', 'Attachment');

        if ($required) {

            $extension = getExtension($_FILES['file1']['name']);
            if (!in_array($extension, array('pdf', 'jpg', 'jpeg', 'png'))) {
                $required = false;
                $this->data['upload_error'] = 'The Attachment field must contain file with extension .pdf , .jpg , .jpeg or .png';

            }
        }

        if ($this->form_validation->run() == true && $required == TRUE) {

            $filename = uploadFile($_FILES, 'file1', 'attachment/');
            if ($filename) {

                $array = array(
                    'certificate' => $this->input->post('certificate'),
                    'comment' => $this->input->post('comment'),
                    'attachment' => $filename,
                    'filename' => $_FILES['file1']['name'],
                    'applicant_id' => $this->APPLICANT->id,
                    'createdby' => $current_user->id,
                    'createdon' => date('Y-m-d H:i:s')
                );

                $add = $this->applicant_model->add_attachment($array);
                if (!is_section_used('ATTACHMENT', $this->APPLICANT_MENU)) {
                    $this->applicant_model->add_applicant_step($this->APPLICANT->id, 'ATTACHMENT', $this->APPLICANT->id);
                }

                if (is_null($id)) {
                    $this->session->set_flashdata('message', show_alert('Information saved successfully !!', 'success'));
                    redirect('applicant_choose_programme/' . encode_id($this->APPLICANT->id), 'refresh');
                } else {
                    $this->session->set_flashdata('message', show_alert('Information saved successfully!!', 'success'));
                    redirect('applicant_choose_programme/' . $id, 'refresh');
                }

            } else {
                $this->data['message'] = show_alert('Fail to upload attachment', 'warning');
            }
        }

        if (isset($_GET) && isset($_GET['rmv'])) {
            $delete = $this->db->delete("application_attachment", array('id' => $_GET['rmv']));
            if ($delete) {
                $this->session->set_flashdata("message", show_alert('Attachment deleted  successfully !!', 'success'));
                redirect('applicant_attachment/' . $id, 'refresh');
            } else {
                $this->session->set_flashdata("message", show_alert('This action did not pass our security checks. !!', 'info'));
                redirect('applicant_attachment/' . $id, 'refresh');
            }
        }
        if($this->APPLICANT->application_category=='Center'){
            $this->data['certificate_list'] = center_premises_attachment($this->APPLICANT->Premises);
            $this->data['attachment_list'] = $this->applicant_model->get_attachment($this->APPLICANT->id);

        }else{
            $this->data['attachment_list'] = $this->applicant_model->get_attachment($this->APPLICANT->id);

            $this->data['certificate_list'] = certificate_by_entry_type($this->APPLICANT->entry_category);
            $this->data['certificate_list'] = $this->data['certificate_list'] + addition_certificate(null, $this->APPLICANT->application_type);    
        }
        
        //$this->data['certificate_list'][100] = 'Birth Certificate';
        //$this->data['certificate_list'][101] = 'Others';
        $this->data['middle_content'] = 'applicant/applicant_attachment';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);

    }

    function applicant_choose_programme($id = null)
    {
        $current_user = current_user();
        $ayear = $this->common_model->get_academic_year()->row()->AYear;
        $this->form_validation->set_rules('choice1', 'First Choice', 'required');

//        $this->form_validation->set_rules('choice2', 'Second Choice', 'required');
//        $this->form_validation->set_rules('choice3', 'Third Choice', 'required');
//        if($this->APPLICANT->application_type < 3) {
//            $this->form_validation->set_rules('choice4', 'Fourth Choice', 'required');
//            $this->form_validation->set_rules('choice5', 'Fifth Choice', 'required');
//        }
        if ($this->form_validation->run() == true) {
            $array1 = array();
            $choice1 = trim($this->input->post('choice1'));
            $array1[$choice1] = $choice1;
            $choice2 = trim($this->input->post('choice2'));
            $array1[$choice2] = $choice2;
            $choice3 = trim($this->input->post('choice3'));
            $array1[$choice3] = $choice3;
            $counter_data = 3;
            if ($this->APPLICANT->application_type < 3) {
                $choice4 = trim($this->input->post('choice4'));
                $array1[$choice4] = $choice4;
                $choice5 = trim($this->input->post('choice5'));
                $array1[$choice5] = $choice5;
                $counter_data = 5;
            }

            if (count($array1) >= 1) {
                $current_round = $this->db->query("select * from application_round where application_type=" . $this->APPLICANT->application_type)->row();
                if ($current_round) {
                    $round = $current_round->round;
                } else {
                    $round = 1;
                }
                $choicecode = $this->input->post('choice1');
                $prname = $this->db->query("select Name from programme where Code='$choicecode'")->row();
                $pname = $prname->Name;
                // echo $pname;exit;
                $array_data = array(
                    'choice1' => trim($this->input->post('choice1')),
                    'choice2' => trim($this->input->post('choice2')),
                    'choice3' => trim($this->input->post('choice3')),
                    'round' => $round,
                    'pname' => $pname,
                    'createdby' => $current_user->id,
                    'createdon' => date('Y-m-d H:i:s'),
                    'applicant_id' => $this->APPLICANT->id,
                    'AYear' => $ayear
                );
                // var_dump($array_data);exit;
                if ($this->APPLICANT->application_type < 3) {

                    $array_data['choice4'] = trim($this->input->post('choice4'));
                    $array_data['choice5'] = trim($this->input->post('choice5'));
                }

                $add = $this->applicant_model->add_programme_choice($array_data);
                if ($add) {
                    if (!is_section_used('PROGRAMME', $this->APPLICANT_MENU)) {
                        $this->applicant_model->add_applicant_step($this->APPLICANT->id, 'PROGRAMME', $this->APPLICANT->id);
                    }

                    if (is_null($id)) {
                        if ($this->APPLICANT->application_type != 3) {
                            $this->session->set_flashdata('message', show_alert('Information saved successfully, Review your Application and Submit', 'success'));
                            redirect('applicant_submission/', 'refresh');
                        } else {
                            $this->session->set_flashdata('message', show_alert('Information saved successfully, Add Professional Experience !!', 'success'));
                            redirect('applicant_experience/', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('message', show_alert('Information saved successfully', 'success'));
                        redirect('applicant_choose_programme/' . $id, 'refresh');
                    }

                } else {
                    $this->data['message'] = show_alert('Fail to save Information !!', 'warning');
                }
            } else {
                $this->data['message'] = show_alert('Selection of the programme must be unique !, Please correct it and save information again', 'warning');
            }
        }
        $mychoice = $this->applicant_model->get_programme_choice($this->APPLICANT->id);
        if ($mychoice) {
            $this->data['mycoice'] = $mychoice;
        }

        $this->data['department'] = $this->common_model->get_department()->result();
        $this->data['programme'] = $this->applicant_model->get_programme_for_choice($this->APPLICANT->application_type);
        $this->data['course'] = $this->db->query("select * from programme order by Name")->result();

        $this->data['middle_content'] = 'applicant/choose_programme';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }

    function applicant_submission($id = null)
    {
        $current_user = current_user();


        $this->form_validation->set_rules('submit_app', 'Submit Application', 'required');

        if ($this->form_validation->run() == true) {
            $submission = array(
                'submitted' => 1,
                'submitedon' => date('Y-m-d H:i:s')
            );

            $validate = $this->applicant_model->allow_submission($this->APPLICANT->id);
            if ($validate) {
                $register = $this->applicant_model->update_applicant($submission, array('id' => $this->APPLICANT->id));

                if (!is_section_used('SUBMIT', $this->APPLICANT_MENU)) {
                    $this->applicant_model->add_applicant_step($this->APPLICANT->id, 'SUBMIT', $this->APPLICANT->id);
                }

                if ($this->APPLICANT->application_type == 2) {
                    $entry = $this->APPLICANT->entry_category;
                    if ($entry == 2) {
                        $f4indexno = $this->db->get_where('application_education_authority', array('applicant_id' => $this->APPLICANT->id, 'certificate' => 1))->row()->index_number;
                        $f6indexno = $this->db->get_where('application_education_authority', array('applicant_id' => $this->APPLICANT->id, 'certificate' => 2))->row()->index_number;
                        $entry_category = "A";
                    } else if ($entry == 4) {
                        $f4indexno = $this->db->get_where('application_education_authority', array('applicant_id' => $this->APPLICANT->id, 'certificate' => 1))->row()->index_number;
                        $f6indexno = $this->db->get_where('application_education_authority', array('applicant_id' => $this->APPLICANT->id, 'certificate' => 4))->row()->avn;
                        $entry_category = "D";
                    }
                    $xml_data = AddApplicantRequest(TCU_USERNAME, TCU_TOKEN, $f4indexno, $f6indexno, $entry_category, '', '');
                    $Response = sendXmlOverPost('http://api.tcu.go.tz/applicants/add', $xml_data);
                    $Response_orign = $Response;
                    $Response = RetunMessageString($Response, 'ResponseParameters');
                    $data = simplexml_load_string($Response);
                    $json = json_encode($data);
                    $json2 = json_encode(simplexml_load_string($Response_orign));
                    $array = json_decode($json, TRUE);
                    $error_code = $array['StatusCode'];
                    $f4index = $f4indexno;
                    $status = $array['StatusCode'];
                    $description = $array['StatusDescription'];
                    $date = date('Y-m-d H:i:s');
                    if ($status == 200 || $status == 208) {
                        $request_status = 1;
                        $tcu_status = $this->db->query("update application set tcu_status=1,tcu_status_description='Registered' where id=" . $this->APPLICANT->id);
                    } else {
                        $request_status = 0;
                    }

                    //$response_result = json_encode($object);

                    $insert = $this->db->query("insert into tcu_records values('','" . $this->APPLICANT->id . "','Add','$error_code','$f4index','$status','$description','$request_status','$xml_data','$json2','$date')");
                    if ($insert) {
                        $datatoupdate = array(
                            'response' => 1,
                        );
                        $this->db->where('id', $this->APPLICANT->id);
                        $this->db->update('application', $datatoupdate);
                        $this->session->set_flashdata('message', show_alert('Your application is submitted successfully !!', 'success'));
                        redirect('applicant_submission/' . encode_id($this->APPLICANT->id), 'refresh');
                    } else {
                        $this->session->set_flashdata('message', show_alert('Failed to save response !!', 'warning'));
                        redirect('applicant_submission/' . encode_id($this->APPLICANT->id), 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('message', show_alert('Your application is submitted successfully !!', 'success'));
                    redirect('applicant_submission/' . encode_id($this->APPLICANT->id), 'refresh');
                }
            } else {

                $this->session->set_flashdata('message', show_alert(implode('<br/>', $validate), 'warning'));
                redirect('applicant_submission/', 'refresh');
            }
        }

        $next_kin = $this->applicant_model->get_nextkin_info($this->APPLICANT->id)->result();
        if (count($next_kin) > 0) {
            $this->data['next_kin'] = $next_kin;
        }

        $referee = $this->applicant_model->get_applicant_referee($this->APPLICANT->id)->result();
        if (count($referee) > 0) {
            $this->data['academic_referee'] = $referee;
        }

        $this->data['education_bg'] = $this->applicant_model->get_education_bg(null, $this->APPLICANT->id);
        $this->data['attachment_list'] = $this->applicant_model->get_attachment($this->APPLICANT->id);
        $mychoice = $this->applicant_model->get_programme_choice($this->APPLICANT->id);
        if ($mychoice) {
            $this->data['mycoice'] = $mychoice;
        }

        $sponsor = $this->applicant_model->get_applicant_sponsor($this->APPLICANT->id)->row();
        if ($sponsor) {
            $this->data['sponsor_info'] = $sponsor;
        }

        $employer = $this->applicant_model->get_applicant_employer($this->APPLICANT->id)->row();
        if ($employer) {
            $this->data['employer_info'] = $employer;
        }


        $this->data['middle_content'] = 'applicant/applicant_submission';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }


    function center_submission($id = null)
    {
        $current_user = current_user();


        $this->form_validation->set_rules('submit_app', 'Submit Application', 'required');

        if ($this->form_validation->run() == true) {
            $submission = array(
                'submitted' => 1,
                'submitedon' => date('Y-m-d H:i:s')
            );

            $validate = $this->applicant_model->allow_submission($this->APPLICANT->id);
            if ($validate) {
                $register = $this->applicant_model->update_applicant($submission, array('id' => $this->APPLICANT->id));

                if (!is_section_used('SUBMIT', $this->APPLICANT_MENU)) {
                    $this->applicant_model->add_applicant_step($this->APPLICANT->id, 'SUBMIT', $this->APPLICANT->id);
                }

                // if ($this->APPLICANT->application_type == 2) {
                //     $entry = $this->APPLICANT->entry_category;
                //     if ($entry == 2) {
                //         $f4indexno = $this->db->get_where('application_education_authority', array('applicant_id' => $this->APPLICANT->id, 'certificate' => 1))->row()->index_number;
                //         $f6indexno = $this->db->get_where('application_education_authority', array('applicant_id' => $this->APPLICANT->id, 'certificate' => 2))->row()->index_number;
                //         $entry_category = "A";
                //     } else if ($entry == 4) {
                //         $f4indexno = $this->db->get_where('application_education_authority', array('applicant_id' => $this->APPLICANT->id, 'certificate' => 1))->row()->index_number;
                //         $f6indexno = $this->db->get_where('application_education_authority', array('applicant_id' => $this->APPLICANT->id, 'certificate' => 4))->row()->avn;
                //         $entry_category = "D";
                //     }
                //     $xml_data = AddApplicantRequest(TCU_USERNAME, TCU_TOKEN, $f4indexno, $f6indexno, $entry_category, '', '');
                //     $Response = sendXmlOverPost('http://api.tcu.go.tz/applicants/add', $xml_data);
                //     $Response_orign = $Response;
                //     $Response = RetunMessageString($Response, 'ResponseParameters');
                //     $data = simplexml_load_string($Response);
                //     $json = json_encode($data);
                //     $json2 = json_encode(simplexml_load_string($Response_orign));
                //     $array = json_decode($json, TRUE);
                //     $error_code = $array['StatusCode'];
                //     $f4index = $f4indexno;
                //     $status = $array['StatusCode'];
                //     $description = $array['StatusDescription'];
                //     $date = date('Y-m-d H:i:s');
                //     if ($status == 200 || $status == 208) {
                //         $request_status = 1;
                //         $tcu_status = $this->db->query("update application set tcu_status=1,tcu_status_description='Registered' where id=" . $this->APPLICANT->id);
                //     } else {
                //         $request_status = 0;
                //     }

                //     //$response_result = json_encode($object);

                //     $insert = $this->db->query("insert into tcu_records values('','" . $this->APPLICANT->id . "','Add','$error_code','$f4index','$status','$description','$request_status','$xml_data','$json2','$date')");
                //     if ($insert) {
                //         $datatoupdate = array(
                //             'response' => 1,
                //         );
                //         $this->db->where('id', $this->APPLICANT->id);
                //         $this->db->update('application', $datatoupdate);
                //         $this->session->set_flashdata('message', show_alert('Your application is submitted successfully !!', 'success'));
                //         redirect('center_submission/' . encode_id($this->APPLICANT->id), 'refresh');
                //     } else {
                //         $this->session->set_flashdata('message', show_alert('Failed to save response !!', 'warning'));
                //         redirect('center_submission/' . encode_id($this->APPLICANT->id), 'refresh');
                //     }
                // } else {
                    $this->session->set_flashdata('message', show_alert('Your application is submitted successfully !!', 'success'));
                    redirect('center_submission/' . encode_id($this->APPLICANT->id), 'refresh');
                // }
            } else {

                $this->session->set_flashdata('message', show_alert(implode('<br/>', $validate), 'warning'));
                redirect('center_submission/', 'refresh');
            }
        }

        $next_kin = $this->applicant_model->get_nextkin_info($this->APPLICANT->id)->result();
        if (count($next_kin) > 0) {
            $this->data['next_kin'] = $next_kin;
        }

        $referee = $this->applicant_model->get_applicant_referee($this->APPLICANT->id)->result();
        if (count($referee) > 0) {
            $this->data['academic_referee'] = $referee;
        }

        $this->data['education_bg'] = $this->applicant_model->get_education_bg(null, $this->APPLICANT->id);
        $this->data['attachment_list'] = $this->applicant_model->get_attachment($this->APPLICANT->id);
        $mychoice = $this->applicant_model->get_programme_choice($this->APPLICANT->id);
        if ($mychoice) {
            $this->data['mycoice'] = $mychoice;
        }

        $sponsor = $this->applicant_model->get_applicant_sponsor($this->APPLICANT->id)->row();
        if ($sponsor) {
            $this->data['sponsor_info'] = $sponsor;
        }

        $employer = $this->applicant_model->get_applicant_employer($this->APPLICANT->id)->row();
        if ($employer) {
            $this->data['employer_info'] = $employer;
        }


        $this->data['middle_content'] = 'applicant/center_submission';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }

    function applicant_experience($id = null)
    {
        $current_user = current_user();
        if (!is_section_used('EXPERIENCE', $this->APPLICANT_MENU)) {
            $this->applicant_model->add_applicant_step($this->APPLICANT->id, 'EXPERIENCE', $this->APPLICANT->id);
        }
        if (isset($_GET) && isset($_GET['rmid'])) {
            $this->db->delete('application_experience', array('id' => $_GET['rmid']));
            $this->session->set_flashdata('message', show_alert('Professional Experience Information deleted !!', 'info'));
            redirect('applicant_experience/', 'refresh');
        }
        $category = $this->input->post('catv');
        if ($category) {

            $this->form_validation->set_rules('name', ($category == 1 ? 'Hospital/Institute' : ($category == 2 ? 'Name of Institution' : 'Post Held')), 'required');
            $this->form_validation->set_rules('column1', ($category == 1 ? 'Address' : ($category == 2 ? 'Award Given' : 'Employer')), 'required');
            if ($category > 1) {
                $this->form_validation->set_rules('column2', ($category == 2 ? 'Year of Completion' : 'When (Month/Year)'), 'required');

            }

            if ($this->form_validation->run() == true) {
                $array = array(
                    'type' => $category,
                    'applicant_id' => $this->APPLICANT->id,
                    'name' => trim($this->input->post('name')),
                    'column1' => trim($this->input->post('column1')),
                    'column2' => trim($this->input->post('column2')),
                );
                $row_id = (isset($_GET['id']) ? $_GET['id'] : null);
                if (is_null($row_id)) {
                    $array['createdby'] = $current_user->id;
                    $array['createdon'] = date('Y-m-d H:i:s');
                } else {
                    $array['modifiedby'] = $current_user->id;
                    $array['modifiedon'] = date('Y-m-d H:i:s');
                }
                $add = $this->applicant_model->add_experience($array, $row_id);
                if ($add) {
                    if (is_null($row_id)) {
                        $this->session->set_flashdata('message', show_alert('Professional Experience Information saved !!', 'info'));
                    } else {
                        $this->session->set_flashdata('message', show_alert('Professional Experience Information updated !!', 'info'));

                    }
                    redirect('applicant_experience/', 'refresh');
                }

            }

        }

        if (isset($_GET) && isset($_GET['id'])) {
            $row = $this->applicant_model->get_experience($this->APPLICANT->id, $_GET['id'])->row();
            if ($row) {
                $this->data['experience_info'] = $row;
            }
        }

        $this->data['middle_content'] = 'applicant/applicant_experience';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }


    function applicant_referee($id = null)
    {
        $current_user = current_user();

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('mobile1', 'Mobile Number', 'required|regex_match[/^0[0-9]{9}$/]');
        $this->form_validation->set_rules('mobile2', 'Mobile Number', 'regex_match[/^0[0-9]{9}$/]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('position', 'Position', 'required');
        $this->form_validation->set_rules('organization', 'Organization', 'required');

        $this->form_validation->set_rules('name2', 'Name', 'required');
        $this->form_validation->set_rules('mobile21', 'Mobile Number', 'required|regex_match[/^0[0-9]{9}$/]');
        $this->form_validation->set_rules('mobile22', 'Mobile Number', 'regex_match[/^0[0-9]{9}$/]');
        $this->form_validation->set_rules('email2', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('address2', 'Address', 'required');
        $this->form_validation->set_rules('position2', 'Position', 'required');
        $this->form_validation->set_rules('organization2', 'Organization', 'required');

        if ($this->form_validation->run() == true) {

            $primary = array(
                'name' => trim($this->input->post('name')),
                'mobile1' => '255' . ltrim(trim($this->input->post('mobile1')), '0'),
                'mobile2' => '255' . ltrim(trim($this->input->post('mobile2')), '0'),
                'email' => trim($this->input->post('email')),
                'address' => trim($this->input->post('address')),
                'position' => trim($this->input->post('position')),
                'organization' => trim($this->input->post('organization')),
                'is_primary' => 1,
                'rec_code' => generatePIN(8),
                'applicant_id' => $this->APPLICANT->id
            );
            $this->applicant_model->add_applicant_referee($primary);
            $secondary = array(
                'name' => trim($this->input->post('name2')),
                'mobile1' => '255' . ltrim(trim($this->input->post('mobile21')), '0'),
                'mobile2' => '255' . ltrim(trim($this->input->post('mobile22')), '0'),
                'position' => trim($this->input->post('position2')),
                'organization' => trim($this->input->post('organization2')),
                'email' => trim($this->input->post('email2')),
                'address' => trim($this->input->post('address2')),
                'applicant_id' => $this->APPLICANT->id,
                'is_primary' => 0,
                'rec_code' => generatePIN(8),
            );
            $this->applicant_model->add_applicant_referee($secondary);


            if (!is_section_used('REFEREE', $this->APPLICANT_MENU)) {
                $this->applicant_model->add_applicant_step($this->APPLICANT->id, 'REFEREE', $this->APPLICANT->id);
            }

            if (is_null($id)) {
                $referee = $this->applicant_model->get_applicant_referee($this->APPLICANT->id)->result();
                if (count($referee) > 0) {
                    foreach ($referee as $rk => $rv) {
                        $this->db->insert('notify_tmp', array('type' => 'REFEREE', 'data' => json_encode(array('applicant_id' => $this->APPLICANT->id, 'referee_id' => $rv->id, 'SITE_URL' => site_url()))));
                        $last_row = $this->db->insert_id();
                        execInBackground('response send_notification ' . $last_row);
                    }
                }
                $this->session->set_flashdata('message', show_alert('Information saved successfully and Email sent to referees, Please add Sponsor Information !!', 'success'));
                redirect('applicant_sponsor/', 'refresh');
            } else {
                $this->session->set_flashdata('message', show_alert('Information saved successfully!!', 'success'));
                redirect('applicant_referee/' . $id, 'refresh');
            }
        }

        if (is_section_used('REFEREE', $this->APPLICANT_MENU)) {
            $next_kin = $this->applicant_model->get_applicant_referee($this->APPLICANT->id)->result();
            if (count($next_kin) > 0) {
                $this->data['next_kin'] = $next_kin;
            }


        }

        if (isset($_GET) && isset($_GET['resend']) && isset($_GET['id'])) {
            $this->db->insert('notify_tmp', array('type' => 'REFEREE', 'data' => json_encode(array('applicant_id' => $this->APPLICANT->id, 'referee_id' => $_GET['id'], 'SITE_URL' => site_url()))));
            $last_row = $this->db->insert_id();
            execInBackground('response send_notification ' . $last_row);
            $this->session->set_flashdata('message', show_alert('Email Sent successfully !!', 'success'));
            redirect('applicant_referee/' . $id, 'refresh');
        }


        $this->data['middle_content'] = 'applicant/applicant_referee';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }

    function applicant_sponsor($id = null)
    {
        $current_user = current_user();

        $this->form_validation->set_rules('name', 'Sponsor Name', 'required');
        $this->form_validation->set_rules('mobile1', 'Mobile Number', 'required|regex_match[/^0[0-9]{9}$/]');
        $this->form_validation->set_rules('mobile2', 'Mobile Number', 'regex_match[/^0[0-9]{9}$/]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('address', 'Address', 'required');

        $this->form_validation->set_rules('name2', 'Employer Name', 'required');
        $this->form_validation->set_rules('mobile21', 'Mobile Number', 'required|regex_match[/^0[0-9]{9}$/]');
        $this->form_validation->set_rules('mobile22', 'Mobile Number', 'regex_match[/^0[0-9]{9}$/]');
        $this->form_validation->set_rules('email2', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('address2', 'Address', 'required');


        if ($this->form_validation->run() == true) {

            $sponsor = array(
                'name' => trim($this->input->post('name')),
                'mobile1' => '255' . ltrim(trim($this->input->post('mobile1')), '0'),
                'mobile2' => '255' . ltrim(trim($this->input->post('mobile2')), '0'),
                'email' => trim($this->input->post('email')),
                'address' => trim($this->input->post('address')),
                'applicant_id' => $this->APPLICANT->id
            );
            $this->applicant_model->add_applicant_sponsor($sponsor);

            $employer = array(
                'name' => trim($this->input->post('name2')),
                'mobile1' => '255' . ltrim(trim($this->input->post('mobile21')), '0'),
                'mobile2' => '255' . ltrim(trim($this->input->post('mobile22')), '0'),
                'email' => trim($this->input->post('email2')),
                'address' => trim($this->input->post('address2')),
                'applicant_id' => $this->APPLICANT->id
            );
            $this->applicant_model->add_applicant_employer($employer);


            if (!is_section_used('SPONSOR', $this->APPLICANT_MENU)) {
                $this->applicant_model->add_applicant_step($this->APPLICANT->id, 'SPONSOR', $this->APPLICANT->id);
            }

            if (is_null($id)) {
                $this->session->set_flashdata('message', show_alert('Information saved successfully, Review your Application and Submit', 'success'));
                redirect('applicant_submission/', 'refresh');
            } else {
                $this->session->set_flashdata('message', show_alert('Information saved successfully!!', 'success'));
                redirect('applicant_sponsor/' . $id, 'refresh');
            }
        }

        if (is_section_used('SPONSOR', $this->APPLICANT_MENU)) {
            $sponsor = $this->applicant_model->get_applicant_sponsor($this->APPLICANT->id)->row();
            if ($sponsor) {
                $this->data['sponsor_info'] = $sponsor;
            }

            $employer = $this->applicant_model->get_applicant_employer($this->APPLICANT->id)->row();
            if ($employer) {
                $this->data['employer_info'] = $employer;
            }
        }


        $this->data['middle_content'] = 'applicant/applicant_sponsor';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }


    function GetComfirmationCode($applicant_id)
    {

        $applicant_info = $this->db->query("select * from application where id=" . $applicant_id)->row();
        $mobile = $applicant_info->Mobile1;
        if (substr($mobile, 0, 3) == '255') {
            $mobile = str_replace('255', '0', $mobile);
        }

        $this->data['mobile'] = $mobile;
        $this->data['email'] = $this->APPLICANT->Email;

        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|regex_match[/^0[0-9]{9}$/]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == true) {
            $email = $this->input->post('email');
            $mobile = $this->input->post('mobile');
            $xml = GetApplicantComfirmationCodeRequest(TCU_USERNAME, TCU_TOKEN, $applicant_info->form4_index, $mobile, $email);
            $url = TCU_DOMAIN . "/admission/requestConfirmationCode";
            $responce = sendXmlOverPost($url, $xml);
            $responce = RetunMessageString($responce, 'ResponseParameters');
            $xml = simplexml_load_string($responce);
            $json = json_encode($xml);
            $array = json_decode($json, TRUE);
            $this->session->set_flashdata('message', show_alert($array['StatusDescription'], 'success'));
            $this->data['middle_content'] = 'applicant/dashboard';
            $this->data['content'] = 'applicant/home';
            $this->load->view('public_template', $this->data);
        }
        $this->data['middle_content'] = 'applicant/GetComfirmationCode';
        $this->data['content'] = 'applicant/home';
        $this->load->view('public_template', $this->data);
    }

    function fakepay()
    {
        $amount_required = APPLICATION_FEE;
        if ($this->APPLICANT->application_type == 3) {
            $amount_required = APPLICATION_FEE_POSTGRADUATE;
        }
        $array = array(
            'msisdn' => '255742523460',
            'reference' => REFERENCE_START . $this->APPLICANT->id,
            'applicant_id' => $this->APPLICANT->id,
            'timestamp' => date('Y-m-d H:i:s'),
            'receipt' => generatePIN(8) . $this->APPLICANT->id,
            'amount' => $amount_required - 1000,
            'charges' => 1000,
            'createdon' => date('Y-m-d H:i:s')
        );

        $this->db->insert('application_payment', $array);
    }


//    function tcu_resubmit()
//    {
//        $var = 1;
//        if ($var === 1){
//            echo 1;
//        }else{
//            echo 0;
//        }
//
//        $xml_data = AddApplicantRequest(TCU_USERNAME, TCU_TOKEN, INSTITUTION_CODE, $f4indexno, $f6indexno, $entry_category, '', '');
//        $Response = sendXmlOverPost('http://api.tcu.go.tz/applicants/add', $xml_data);
//        header('content-Type: application/json');
//        $result = str_replace(array("\n", "\r", "\t"), '', $Response);
//        $xml = simplexml_load_string($result);
//        $object = new stdclass();
//        $object = $xml;
//        $response_result = json_encode($object);
//        $insert = $this->db->query("insert into tcu_records values('','" . $this->APPLICANT->id . "','Add','','','','','','$xml_data','$response_result','')");
//        if ($insert) {
//            $data = simplexml_load_string($Response);
//            $error_code = $data->RESPONSE->RESPONSEPARAMETERS->ERROR_CODE;
//            $f4index = $data->RESPONSE->RESPONSEPARAMETERS->F4INDEXNO;
//            $status = $data->RESPONSE->RESPONSEPARAMETERS->STATUS;
//            $description = $data->RESPONSE->RESPONSEPARAMETERS->STATUS_DESCRIPTION;
//            $date = date('Y-m-d H:i:s');
//            if ($status == "SUCCESS") {
//                $request_status = 1;
//            } else {
//                $request_status = 0;
//            }
//            $this->db->query("update application set response='$request_status' where id='" . $this->APPLICANT->id . "' ");
//            $update = $this->db->query("update tcu_records set error_code='$error_code', f4indexno='$f4index', status='$status', description='$description', request_status='$request_status', date='$date' where applicant_id='" . $this->APPLICANT->id . "' ");
//
//
//        }
//    }


    function loadAjaxData()
    {


        $action = trim($this->input->post('action'));
        if ($action == 'o-level') {
            $index_number = trim($this->input->post('id'));
            $this->curl->create(NECTA_API . 'auth/' . NECTA_KEY);
            $response_token = $this->curl->execute();
            if ($response_token) {
                $index_number_tmp = explode('/', $index_number);
                $index_number = $index_number_tmp[0] . '-' . $index_number_tmp[1];
                $responsedata_key = json_decode($response_token);
                $this->curl->create(NECTA_API . 'results/' . $index_number . '/1/' . $index_number_tmp[2] . '/' . $responsedata_key->token);
                $response = $this->curl->execute();
                if ($response) {
                    $responsedata = json_decode($response);
                    if ($responsedata->status->code == 1) {
                        echo $responsedata->results->division->division . '_' . $responsedata->particulars->center_name . '_' . $index_number_tmp[2];
                    }
                }
            }
        } else {
            $certificate = trim($this->input->post('id'));
            if ($certificate == '1' || $certificate == '2' || $certificate == '7' || $certificate == '8') {
                echo "NECTA";

            } else {
                echo "NACTE";
            }
        }


    }


}
