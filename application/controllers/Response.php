<?php

/**
 * Created by PhpStorm.
 * User: miltone
 * Date: 5/19/17
 * Time: 2:27 PM
 */
class Response extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function run_eligibility($row_id)
    {

        $row = $this->db->where('id', $row_id)->get("run_eligibility")->row();

        if ($row) {
            $row_year = $this->common_model->get_academic_year(null, 1, 1)->row();
            $ayear = $row_year->AYear;
            $programme = $row->ProgrammeCode;
            $eligibility_roud=$row->round;
            include_once 'include/eligibility.php';
        }

        $this->db->delete('run_eligibility', array('id' => $row_id));

    }

    function run_selection($row_id)
    {

        $row = $this->db->where('id', $row_id)->get("run_selection")->row();

        if ($row) {
            $row_year = $this->common_model->get_academic_year(null, 1, 1)->row();
            $ayear = $row_year->AYear;
            $programme = $row->ProgrammeCode;
            $choice = $row->choice;
            foreach (array(1,2) as $kp => $category) {
                //1 = Direct
                //2 = Equivalent
                include_once 'include/selection.php';
            }
        }
        $this->db->delete('run_selection', array('id' => $row_id));
    }

    function remove_unwanted()
    {
        $data = $this->db->query("select a.id,p.id as pid,DATEDIFF(now(),a.createdon) as days FROM application as a LEFT JOIN application_payment as p ON (a.id=p.applicant_id) WHERE  p.id IS NULL AND DATEDIFF(now(),a.createdon) > 4")->result();
        foreach ($data as $key => $val) {
            $application = $this->db->where('id', $val->id)->get("application")->row();
            $payment = $this->db->where('applicant_id', $application->id)->get("application_payment")->row();
            if (!$payment) {
                $this->db->delete('application', array('id' => $application->id));
                $this->db->delete('application_steps', array('applicant_id' => $application->id));
                $get_user = $this->db->where('username', $application->form4_index)->get("users")->row();
                $this->db->delete('users', array('username' => $application->form4_index));
                $this->db->delete('users_groups', array('user_id' => $get_user->id));
            }
        }
    }

    function send_control_number($control)
    {

        $invoice_info = $this->db->where('control_number',$control)->get('invoices')->row();
        if($invoice_info)
        {
            $sms = "Hello " . $invoice_info->student_name.',  ' . $invoice_info->control_number . ' is your Control Number with amount  '.number_format($invoice_info->amount,0).'  ';
            notify_by_sms($invoice_info->student_mobile, $sms, $invoice_info->id, $priority = 10);
            $email_data['title'] = ' Control Number';
            if($invoice_info->student_email)
            {
                if($invoice_info->student_email!='')
                {
                    $email_data['salutation'] = 'Dear ' . $invoice_info->student_name ;
                    $email_data['content'] = "Thank you .<br/><br/> Your control  number is :   " .$control." <br/> Amount : ".number_format($invoice_info->amount,0);
                    $email_message = $this->load->view('email_template/template', $email_data, true);
                    if (filter_var($invoice_info->student_email, FILTER_VALIDATE_EMAIL)) {
                        $send = $this->mail->send_email('CONTROL NUMBER', $email_message, array($invoice_info->student_email));
                    }
                }

            }

        }
    }


    function send_notification($row_id)
    {
        $row = $this->db->where('id', $row_id)->get("notify_tmp")->row();
        if ($row) {
            $data = json_decode($row->data);

            switch ($row->type) {
                case "ACTIVE":

                    $user_info = $this->db->where('id', $data->user_id)->get('users')->row();

                    if ($user_info->activation_code <> '' && !is_null($user_info->activation_code)) {
                        if ($data->resend == 0) {
                            $sms = "Hello " . $user_info->firstname . ',  ' . $user_info->activation_code . ' is your SARIS application account activation code.';
                            notify_by_sms($user_info->phone, $sms, $user_info->id, $priority = 10);
                        }
                        $email_data['title'] = 'Account Activation';
                        $email_data['salutation'] = 'Dear ' . $user_info->firstname . ' ' . $user_info->lastname;
                        $email_data['content'] = "Thank you for registering at SARIS Online Application System.<br/><br/> Your application account has been created. Use the activation code below to
activate your account. <br/> Username : " . $user_info->username . " <br/> Email : " . $user_info->email . "
 <br/> Mobile : " . $user_info->phone . " <br/><br/> Activation Code : " . $user_info->activation_code;
                        $email_message = $this->load->view('email_template/template', $email_data, true);
                        if (filter_var($user_info->email, FILTER_VALIDATE_EMAIL)) {
                            $send = $this->mail->send_email('ACTIVATE ACCOUNT', $email_message, array($user_info->email));
                        }

                    }

                    break;

                case "REFEREE":

                    $applicant_info = $this->db->where('id', $data->applicant_id)->get('application')->row();
                    $referee_info = $this->db->where('id', $data->referee_id)->get('application_referee')->row();
                    if ($referee_info->rec_code <> '' && !is_null($referee_info->rec_code)) {
                        $LINK = $data->SITE_URL . '/recommendation/?key=' . encode_id($applicant_info->id) . '&referee_id=' . encode_id($referee_info->id) . '&code=' . $referee_info->rec_code;
                        $applicant_name = $applicant_info->FirstName . ' ' . $applicant_info->MiddleName . ' ' . $applicant_info->LastName;
                        $email_data['title'] = 'Referee Recommendation';
                        $email_data['salutation'] = 'Dear ' . $referee_info->name . '.';
                        $email_data['content'] = " You have been nominated by $applicant_name who is applying for postgraduate degree programme at SARIS to be " . ($applicant_info->Gender == 'M' ? 'his ' : 'her ') . '
                  academic referee. Please log onto the link below, complete and submit your  confidential evaluation of the applicant';
                        $email_data['content'] .= '<br/><br/><div style="text-align: center;"> <a style="font-size: 16px;
    font-family: Helvetica,Arial,sans-serif;
    color: #ffffff;
    text-decoration: none;
    background: #00508f;
    text-decoration: none;
    border-radius: 3px;
    padding: 15px 25px;
    border: 1px solid #00508f;
    display: inline-block;" href="' . $LINK . '"> Recommendation Link </a> </div><br/><br/> Having trouble clicking on the link? Please copy and paste the following link in a new browser window:<br/>' . $LINK;
                        $email_message = $this->load->view('email_template/template', $email_data, true);
                        if (filter_var($referee_info->email, FILTER_VALIDATE_EMAIL)) {
                            $send = $this->mail->send_email('Academic Recommendation for ' . $applicant_name, $email_message, array($referee_info->email));
                        }
                    }
                    break;

                case "NEW_ACCOUNT":
                    $user_info = $this->db->where('id', $data->user_id)->get('users')->row();
                    $email_data['title'] = 'Account Credentials';
                    $email_data['salutation'] = 'Dear ' .$user_info->title.'. '. $user_info->firstname . ' ' . $user_info->lastname;
                    $email_data['content'] = "Your account has been created and below is your login credential, Please change your password once you login.<br/>
<br/>Username : " . $user_info->username . "
<br/>Password : " . $data->password . "
<br/>Email : " . $user_info->email . "
<br/>Mobile : " . $user_info->phone . "
<br/>URL  : ".'<a href="'.$data->site_url.'">'.$data->site_url.'</a>';
                    $email_message = $this->load->view('email_template/template', $email_data, true);
                    if (filter_var($user_info->email, FILTER_VALIDATE_EMAIL)) {
                        $send = $this->mail->send_email('ACCOUNT CREDENTIALS', $email_message, array($user_info->email));
                    }


            }
        }

        $this->db->delete('notify_tmp', array('id' => $row_id));
    }


    /**
     * Get Necta Subject List
     * @param $row_id
     */
    function get_necta_subject($row_id)
    {
        $row = $this->db->where('id', $row_id)->get('necta_check_subject')->row();
        if ($row) {
            if ($row->status == 0) {
                $this->curl->create(NECTA_API . 'subjects/' . $row->category . '/' . $row->year . '/' . NECTA_TOKEN);
                $response = $this->curl->execute();
                if ($response) {

                    $this->db->update('necta_check_subject', array('status' => 1, 'response' => $response), array('id' => $row->id));
                } else {
                    $response = $this->curl->error_string;
                    $this->db->update('necta_check_subject', array('response' => $response), array('id' => $row->id));
                }
            }
        }
    }

    /**
     * Get Necta Applicant Results
     * @param $row_id
     */
    function get_necta_results($row_id)
    {
            $row = $this->db->where('id', $row_id)->get('necta_tmp_result')->row();
        if ($row) {
            $authority_row = $this->db->where('id', $row->authority_id)->get('application_education_authority')->row();
            if ($row->route == 'NECTA') {

                if ($authority_row) {
                    $index_number_tmp = explode('/', $authority_row->index_number);
                    $index_number = $index_number_tmp[0] . '-' . $index_number_tmp[1];

                    $applicant_info = $this->applicant_model->get_applicant($authority_row->applicant_id);

                    $this->curl->create(NECTA_API . 'auth/' . NECTA_KEY);
                    $response_token = $this->curl->execute();

                    if ($response_token) {
                        $responsedata_key = json_decode($response_token);
                        $this->curl->create(NECTA_API . 'results/' . $index_number . '/' . $row->category . '/' . $authority_row->completed_year . '/' . $responsedata_key->token);
                        $response = $this->curl->execute();

                        if ($response) {
                            $responsedata = json_decode($response);

                            if ($responsedata->status->code == 1) {

                                if ((strtoupper(trim($applicant_info->FirstName)) == strtoupper(trim($responsedata->particulars->first_name)))
                                    && (strtoupper(trim($applicant_info->LastName)) == strtoupper(trim($responsedata->particulars->last_name)))

                                ) {

                                    $update_data = array(
                                        'exam_authority' => 'NECTA',
                                        'response' => $response,
                                        'center_number' => $responsedata->particulars->center_number,
                                        'school' => $responsedata->particulars->center_name,
                                        'division' => $responsedata->results->division->division,
                                        'division_point' => $responsedata->results->division->points,
                                        'api_status' => 1,
                                        'comment' => 'Success'
                                    );
                                    $this->db->update('application_education_authority', $update_data, array('id' => $row->authority_id));

                                    $subject_list = $responsedata->results->subjects;
                                    $all_result_saved = 1;
                                    foreach ($subject_list as $sub_key => $subject) {
                                        $subject_object = get_subject_object($subject->subject_code);
                                        if (!$subject_object) {

                                            $array_data = array(
                                                'name' => $subject->subject_name,
                                                'code' => $subject->subject_code,
                                                'category' => $authority_row->certificate,
                                                'shortname' => substr($subject->subject_name, 0, 4),
                                                'status' => 1,
                                            );

                                            $add = $this->setting_model->add_sec_subject($array_data);
                                            $subject_object = get_subject_object($subject->subject_code);
                                        }


                                        if ($subject_object) {
                                            $array_subject = array(
                                                'applicant_id' => $authority_row->applicant_id,
                                                'authority_id' => $authority_row->id,
                                                'certificate' => $authority_row->certificate,
                                                'subject' => $subject_object->id,
                                                'grade' => $subject->grade,
                                                'year' => $authority_row->completed_year
                                            );
                                        } else {
                                            $all_result_saved = 0;
                                        }

                                        $add_result = $this->applicant_model->necta_applicant_add_result($array_subject);
                                        if (!$add_result) {
                                            $all_result_saved = 0;
                                        }
                                    }

                                    if ($all_result_saved) {
                                        $this->db->update('application_education_authority', array('hide' => 0), array('id' => $row->authority_id));
                                        $this->db->delete('necta_tmp_result', array('id' => $row->id));
                                    }
                                } else {

                                    $update_data = array(
                                        'response' => $response,
                                        'api_status' => '-1',
                                        'comment' => 'Applicant Names does not Match NECTA Information. Index entered is for :' . $responsedata->particulars->first_name . '  as FirstName,  ' . $responsedata->particulars->last_name . ' as LastName. Please correct your name in Person Particular section and within 24 hrs your results will be updated',
                                    );
                                    $this->db->update('application_education_authority', $update_data, array('id' => $row->authority_id));

                                }
                            } else {
                                $update_data = array(
                                    'response' => $response,
                                    'api_status' => '-1',
                                    'comment' => 'Unauthorized Access::' . $responsedata->status->message,
                                );
                                $this->db->update('application_education_authority', $update_data, array('id' => $row->authority_id));
                            }
                        } else {
                            $response = $this->curl->error_string;
                            $this->db->update('application_education_authority', array('response' => $response), array('id' => $row->authority_id));
                        }

                    } else {
                        $response_token = $this->curl->error_string;
                        $this->db->update('application_education_authority', array('response' => $response_token, 'comment' => 'Invalid token request'), array('id' => $row->authority_id));

                    }


                }

            } else if ($row->route == 'NACTE') {

                if ($authority_row) {

                    $applicant_info = $this->applicant_model->get_applicant($authority_row->applicant_id);

                    $this->curl->create(NACTE_API . NACTE_API_KEY . '/' . NACTE_TOKEN . '/' . NACTE_API_EXTRA . '/' . $authority_row->avn);
                    $response = $this->curl->execute();

                    if ($response) {
                        $responsedata = json_decode($response);

                        if ($responsedata->status->code == 200) {
                            $update_data = array(
                                'response' => $response,
                                'center_number' => '',
                                'school' => $responsedata->params[0]->institution,
                                'diploma_code' => $responsedata->params[0]->diploma_code,
                                'index_number' => $responsedata->params[0]->registration_number,
                                'programme_title' => $responsedata->params[0]->programme,
                                'programme_category' => $responsedata->params[0]->diploma_category,
                                'division' => $responsedata->params[0]->diploma_gpa,
                                'division_point' => '',
                                'api_status' => 1,
                                'comment' => 'Success'
                            );
                            $this->db->update('application_education_authority', $update_data, array('id' => $row->authority_id));

                            $subject_list = $responsedata->params[0]->diploma_results;

                            $all_result_saved = 1;
                            foreach ($subject_list as $sub_key => $subject_value) {
                                $subject = $subject_value->subject;
                                $grade = $subject_value->grade;
                                if ($subject <> '') {
                                    $row_data = $this->db->where(array('applicant_id' => $authority_row->applicant_id, 'subject' => $subject))->get('application_diploma_nacteresult')->row();
                                    if ($row_data) {
                                        //update
                                        $array_data = array(
                                            'applicant_id' => $authority_row->applicant_id,
                                            'subject' => $subject,
                                            'grade' => $grade,
                                            'authority_id' => $authority_row->id,
                                            'combine' => $subject . ' - ' . $grade,
                                        );
                                        $this->db->update("application_diploma_nacteresult", $array_data, array('id' => $row_data->id));
                                    } else {
                                        //insert
                                        $array_data = array(
                                            'applicant_id' => $authority_row->applicant_id,
                                            'subject' => $subject,
                                            'grade' => $grade,
                                            'authority_id' => $authority_row->id,
                                            'combine' => $subject . ' - ' . $grade,
                                        );

                                        $this->db->insert("application_diploma_nacteresult", $array_data);
                                    }
                                }
                            }

                            if ($all_result_saved) {
                                $this->db->update('application_education_authority', array('hide' => 0), array('id' => $row->authority_id));
                                $this->db->delete('necta_tmp_result', array('id' => $row->id));
                            }


                        } else {
                            $update_data = array(
                                'response' => $response,
                                'api_status' => '-1',
                                'comment' => 'Unauthorized Access '
                            );
                            $this->db->update('application_education_authority', $update_data, array('id' => $row->authority_id));
                        }

                    } else {
                        $response = $this->curl->error_string;
                        $this->db->update('application_education_authority', array('response' => $response, 'comment' => 'Remote access issue'), array('id' => $row->authority_id));
                    }

                }

            }

        }
    }

    function retry_api()
    {
        $date2 = date('Y-m-d');
        $sql = "SELECT *,DATEDIFF('$date2',DATE(action_time)) as days FROM necta_tmp_result";

        $result = $this->db->query($sql)->result();

        foreach ($result as $key => $value) {

            $row = $this->db->where('id', $value->authority_id)->get("application_education_authority")->row();
            if ($row) {
                if ($row->api_status == 1) {
                    $this->db->delete('necta_tmp_result', array('id' => $value->id));
                } else {
                    //$this->get_necta_results($value->id);
                    execInBackground("response get_necta_results ".$value->id);
                }

            }
        }

    }


}
