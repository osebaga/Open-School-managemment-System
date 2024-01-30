<?php

/**
 * Created by PhpStorm.
 * User: miltone
 * Date: 5/16/17
 * Time: 5:21 AM
 */
class Report extends CI_Controller
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


    function print_balance($id){
        if(isset($_GET['regno']))
        {
            $id=$_GET['regno'];
        }else{
            $id = decode_id($id);
        }
        $ayear = $this->common_model->get_account_year()->row()->AYear;
        $invoice=$this->db->query("select * from student_invoice where regno='$id' order by amount DESC")->row();
        $user=current_user();
        // echo $APPLICANT->user_id;exit;
        if($invoice) {
            include_once 'report/print_balance.php';
        }else{
            $this->session->set_flashdata('message',show_alert('This request did not pass our security checks.','info'));
            $current_user_group = get_user_group();
            if($current_user_group->id == 4){
                redirect(site_url('applicant_dashboard'), 'refresh');
            }else {
                redirect(site_url('dashboard'), 'refresh');
            }
        }
    }


    function print_receipt($id)
    {
        $id = decode_id($id);
       
        $payment = $this->db->query("SELECT payment.*,student_name,type,name, fee_name FROM payment LEFT JOIN invoices ON invoices.control_number=payment.control_number LEFT JOIN fee_structure ON fee_structure.id=invoices.fee_id  WHERE payment.id='" . $id . "'")->row();

        
        // $payment = $this->db->query("select * from payment where id=" . $id)->row();
//        if($payment)
//            $invoice=$this->db->query("select * from invoices where control_number=".$payment->control_number)->row();
        $user = current_user();

        // echo $APPLICANT->user_id;exit;
        if ($payment) {
            include_once 'report/print_receipt.php';
        } else {
            $this->session->set_flashdata('message', show_alert('This request did not pass our security checks.', 'info'));
            $current_user_group = get_user_group();
            if ($current_user_group->id == 4) {
                redirect(site_url('dashboard'), 'refresh');
            } else {
                redirect(site_url('dashboard'), 'refresh');
            }
        }
    }

    function print_invoice($id)
    {
        $id = decode_id($id);

        // $invoice = $this->db->query("select * from invoices where id='" . $id."'")->row();
        $invoice = $this->db->query("SELECT invoices.*,name FROM invoices LEFT JOIN fee_structure ON fee_structure.id=invoices.fee_id where invoices.id='" . $id . "'")->row();
        $ega_auth = $this->db->query("select * from ega_auth")->row();
        $user = current_user();

        $payer = $this->db->query("select * from application where id='" . $invoice->student_id."'")->row();
        // echo $APPLICANT->user_id;exit;
        if ($invoice) {
            include_once 'report/print_invoice2.php';
        } else {
            $this->session->set_flashdata('message', show_alert('This request did not pass our security checks.', 'info'));
            $current_user_group = get_user_group();
            if ($current_user_group->id == 4) {
                redirect(site_url('applicant_dashboard'), 'refresh');
            } else {
                redirect(site_url('dashboard'), 'refresh');
            }
        }
    }

    function print_invoice2($id)
    {
        $id = decode_id($id);
     
        $invoice = $this->db->query("SELECT invoices.*,name FROM invoices LEFT JOIN fee_structure ON fee_structure.id=invoices.fee_id where invoices.id='" . $id . "'")->row();

        // $invoice = $this->db->query("select * from invoices where id='" . $id."'")->row();
        $user = current_user();

        $payer = $this->db->query("select * from students where id='" . $invoice->student_id."'")->row();
        // echo $APPLICANT->user_id;exit;
        if ($invoice) {


            include_once 'report/print_invoice2.php';
        } else {
            $this->session->set_flashdata('message', show_alert('This request did not pass our security checks.', 'info'));
            $current_user_group = get_user_group();
            if ($current_user_group->id == 4) {
                redirect(site_url('applicant_dashboard'), 'refresh');
            } else {
                redirect(site_url('dashboard'), 'refresh');
            }
        }
    }

    function print_transfer($id)
    {
        $id = decode_id($id);
        $invoice = $this->db->query("select * from invoices where id='" . $id."'")->row();
        $ega_auth = $this->db->query("select * from ega_auth")->row();
        $user = current_user();

        $payer = $this->db->query("select * from application where id='" . $invoice->student_id."'")->row();
        // echo $APPLICANT->user_id;exit;
        if ($invoice) {
            include_once 'report/print_transfer2.php';
        } else {
            $this->session->set_flashdata('message', show_alert('This request did not pass our security checks.', 'info'));
            $current_user_group = get_user_group();
            if ($current_user_group->id == 4) {
                redirect(site_url('applicant_dashboard'), 'refresh');
            } else {
                redirect(site_url('dashboard'), 'refresh');
            }
        }
    }

    function print_transfer2($id)
    {
        $id = decode_id($id);
        $invoice = $this->db->query("select * from invoices where id='" . $id."'")->row();
        $user = current_user();

        $payer = $this->db->query("select * from students where id='" . $invoice->student_id."'")->row();
        // echo $APPLICANT->user_id;exit;
        if ($invoice) {
            include_once 'report/print_transfer2.php';
        } else {
            $this->session->set_flashdata('message', show_alert('This request did not pass our security checks.', 'info'));
            $current_user_group = get_user_group();
            if ($current_user_group->id == 4) {
                redirect(site_url('applicant_dashboard'), 'refresh');
            } else {
                redirect(site_url('dashboard'), 'refresh');
            }
        }
    }


    function print_application_iposa($id)
    {
        $id = decode_id($id);
        $APPLICANT = $this->applicant_model->get_applicant_iposa($id);
        if ($APPLICANT) {
            $next_kin1 = $this->applicant_model->get_nextkin_info($APPLICANT->id)->result();
            if (count($next_kin1) > 0) {
                $next_kin = $next_kin1;
            }

            $referee = $this->applicant_model->get_applicant_referee($APPLICANT->id)->result();
            if (count($referee) > 0) {
                $academic_referee = $referee;
            }

            $sponsor = $this->applicant_model->get_applicant_sponsor($APPLICANT->id)->row();
            if ($sponsor) {
                $sponsor_info = $sponsor;
            }

            $employer = $this->applicant_model->get_applicant_employer($APPLICANT->id)->row();
            if ($employer) {
                $employer_info = $employer;
            }

            $education_bg = $this->applicant_model->get_education_bg(null, $APPLICANT->id);
            $attachment_list = $this->applicant_model->get_attachment($APPLICANT->id);
            $mychoice1 = $this->applicant_model->get_programme_choice($APPLICANT->id);
            if ($mychoice1) {
                $mycoice = $mychoice1;
            }


            include_once 'report/print_application_iposa.php';
        } else {
            $this->session->set_flashdata('message', show_alert('This request did not pass our security checks.', 'info'));
            $current_user_group = get_user_group();
            if ($current_user_group->id == 4) {
                redirect(site_url('applicant_dashboard'), 'refresh');
            } else {
                redirect(site_url('dashboard'), 'refresh');
            }
        }
    }

    function print_application($id)
    {
        $id = decode_id($id);
        $APPLICANT = $this->applicant_model->get_applicant($id);
        if ($APPLICANT) {
            $next_kin1 = $this->applicant_model->get_nextkin_info($APPLICANT->id)->result();
            if (count($next_kin1) > 0) {
                $next_kin = $next_kin1;
            }

            $referee = $this->applicant_model->get_applicant_referee($APPLICANT->id)->result();
            if (count($referee) > 0) {
                $academic_referee = $referee;
            }

            $sponsor = $this->applicant_model->get_applicant_sponsor($APPLICANT->id)->row();
            if ($sponsor) {
                $sponsor_info = $sponsor;
            }

            $employer = $this->applicant_model->get_applicant_employer($APPLICANT->id)->row();
            if ($employer) {
                $employer_info = $employer;
            }

            $education_bg = $this->applicant_model->get_education_bg(null, $APPLICANT->id);
            $attachment_list = $this->applicant_model->get_attachment($APPLICANT->id);
            $mychoice1 = $this->applicant_model->get_programme_choice($APPLICANT->id);
            if ($mychoice1) {
                $mycoice = $mychoice1;
            }


            include_once 'report/print_application.php';
        } else {
            $this->session->set_flashdata('message', show_alert('This request did not pass our security checks.', 'info'));
            $current_user_group = get_user_group();
            if ($current_user_group->id == 4) {
                redirect(site_url('applicant_dashboard'), 'refresh');
            } else {
                redirect(site_url('dashboard'), 'refresh');
            }
        }
    }


    function center_print_application($id)
    {
        $id = decode_id($id);
        $APPLICANT = $this->applicant_model->get_applicant($id);
        if ($APPLICANT) {
            $next_kin1 = $this->applicant_model->get_nextkin_info($APPLICANT->id)->result();
            if (count($next_kin1) > 0) {
                $next_kin = $next_kin1;
            }

            $referee = $this->applicant_model->get_applicant_referee($APPLICANT->id)->result();
            if (count($referee) > 0) {
                $academic_referee = $referee;
            }

            $sponsor = $this->applicant_model->get_applicant_sponsor($APPLICANT->id)->row();
            if ($sponsor) {
                $sponsor_info = $sponsor;
            }

            $employer = $this->applicant_model->get_applicant_employer($APPLICANT->id)->row();
            if ($employer) {
                $employer_info = $employer;
            }

            $education_bg = $this->applicant_model->get_education_bg(null, $APPLICANT->id);
            $attachment_list = $this->applicant_model->get_attachment($APPLICANT->id);
            $mychoice1 = $this->applicant_model->get_programme_choice($APPLICANT->id);
            if ($mychoice1) {
                $mycoice = $mychoice1;
            }


            include_once 'report/center_print_application.php';
        } else {
            $this->session->set_flashdata('message', show_alert('This request did not pass our security checks.', 'info'));
            $current_user_group = get_user_group();
            if ($current_user_group->id == 4) {
                redirect(site_url('applicant_dashboard'), 'refresh');
            } else {
                redirect(site_url('dashboard'), 'refresh');
            }
        }
    }

    function applicant_byProgramme()
    {
        // $date = "2018-10-12";
        // AND DATE(ap.submitedon) >= '$date'
        $programme = (isset($_GET) && isset($_GET['programme'])) ? $_GET['programme'] : null;
        $application_type = (isset($_GET) && isset($_GET['type'])) ? $_GET['type'] : null;
        $row_year = $this->common_model->get_academic_year(null, 1, 1)->row();
        $ayear = $row_year->AYear;

        $current_round = $this->db->query("select * from application_round where application_type=" . $application_type)->row();

        if ($current_round) {
            $round = $current_round->round;
        } else {
            $round = 1;
        }

        $applicant_list = $this->db->query("SELECT ap.*,pc.choice,pc.status as eligible,pc.comment,pc.point,pc.form6_subject,pc.form4_subject,pc.gpa,pc.diploma_info,pc.round FROM application as ap  INNER JOIN application_elegibility as pc ON (ap.id=pc.applicant_id) WHERE 1=1
                      AND pc.ProgrammeCode='$programme' and ap.AYear='$ayear' and pc.round='$round'  ORDER BY pc.status DESC,pc.point DESC  ")->result();
        include 'report/applicant_byProgramme.php';


    }

    function export_applicant()
    {
        $ayear = $this->common_model->get_academic_year(null, 1, 1)->row()->AYear;
        $key = $type = $entry = null;


        if (isset($_GET) && isset($_GET['type']) && isset($_GET['entry'])) {

            //$key = $_GET['key'];
            $type = $_GET['type'];
            $entry = $_GET['entry'];
        }
        if (isset($_GET['from']) && $_GET['from'] != '') {
            $f = $_GET['from'];
            $from = format_date($f, true);
        }

        if (isset($_GET['to']) && $_GET['to'] != '') {
            $t = $_GET['to'];
            $to = format_date($t, true);
        }

        if (!is_null($type) && $type <> '') {
            //single type of application - one Worksheet
            $application_type = application_type_search($type);
            include_once 'report/applicant_single_sheet.php';
            exit;
        } else {
            //all application Type - 3 worksheet in excel
            //For time being force to select Application Type First
            $this->session->set_flashdata('message', show_alert('Please select type of Application before click export button', 'info'));
            redirect('applicant_list', 'refresh');
        }


    }

    function applicant_byProgramme_selected()
    {
        $programme = (isset($_GET) && isset($_GET['programme'])) ? $_GET['programme'] : null;
        $application_type = (isset($_GET) && isset($_GET['type'])) ? $_GET['type'] : null;
        $applicant_list = $this->db->query("SELECT ap.*,pc.choice,pc.status as eligible,pc.selected,pc.comment,pc.point,pc.form6_subject,pc.form4_subject,pc.gpa,pc.diploma_info,pc.round FROM application as ap  INNER JOIN application_elegibility as pc ON (ap.id=pc.applicant_id) WHERE 1=1
                      AND pc.ProgrammeCode='$programme' AND pc.selected=1 ORDER BY selected_counter  ASC  ")->result();
        $row_year = $this->common_model->get_academic_year(null, 1, 1)->row();
        $ayear = $row_year->AYear;

        include 'report/applicant_byProgramme_selected.php';


    }

    function export_applicant_selected()
    {
        $ayear = $this->common_model->get_academic_year(null, 1, 1)->row()->AYear;
        $key = $type = $entry = null;
        if (isset($_GET) && isset($_GET['key']) && isset($_GET['type']) && isset($_GET['entry'])) {
            $key = $_GET['key'];
            $type = $_GET['type'];
            $entry = $_GET['entry'];
        }

        if (!is_null($type) && $type <> '') {
            //single type of application - one Worksheet
            $application_type = application_type($type);
            include_once 'report/applicant_single_sheet_selected.php';
            exit;
        } else {
            //all application Type - 3 worksheet in excel
            //For time being force to select Application Type First
            $this->session->set_flashdata('message', show_alert('Please select type of Application before click export button', 'info'));
            redirect('applicant_list', 'refresh');
        }


    }


    function export_collection()
    {
        $ayear = $this->common_model->get_academic_year(null, 1, 1)->row()->AYear;
        $key = $from = $to = $ayear = null;
        if (isset($_GET) && isset($_GET['key']) && isset($_GET['from']) && isset($_GET['to']) && isset($_GET['ayear'])) {
            $key = $_GET['key'];
            $to = $_GET['to'];
            $from = $_GET['from'];
            $acyear = $_GET['ayear'];
        }

        include_once 'report/applicant_collection.php';
        exit;

    }


}
