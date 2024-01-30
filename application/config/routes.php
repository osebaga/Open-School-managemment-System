<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route_structure = array(

    'home'=>array(
        'index','requirement','git_pull','contact','faq','registration_start','center_registration','application_start','registration_start1','center_application',
        'registration_bachelor','recommendation','loadEducationData','student_dashboard','student_invoices','student_create_invoice',
        'print_student_receipt','print_student_invoice','print_student_transfer','print_student_statement','loadDistrict','loadVituo','LoadFeeBYNTALevel','GetFeeByCategory','LoadStudentDetailsByID','LoadStudentDetailsByID1','loadCampus','AddApplicantTCU'
    ),

    'dashboard' => array(
        'dashboard','load_graph','load_nta_graph','dashboard_analytics'
    ),

    'auth' => array(
        'login', 'logout', 'change_password', 'login_history', 'activate', 'deactivate',
        'forgot_password', 'reset_password'
    ),

    'admin' => array(
        'add_group','group_list','grant_access','create_user','user_list','manage_database','reset_pass','verification_code','git_pull_saris'
    ),

    'simsdata' => array(
        'school_list','department_list','campus_list','manage_campus','programme_list','add_programme','manage_school','manage_department','fee_structure_list','manage_fee_structure','vituo','manage_vituo','delete_fee_structure','gepg_category_list','manage_gepg_category','delete_gepg_category','manage_center','manage_teacher','center_list','teacher_list','student_invoice_list','add_student_invoice'
    ),

    'setting' => array(
        'manage_subject','add_sec_subject','current_semester','application_deadline','application_round','current_account_year'
    ),

    'applicant'=> array(
        'applicant_dashboard','applicant_basic','center_basic','applicant_contact','center_contact','applicant_profile',
        'applicant_next_kin','applicant_payment','center_registration_fee','is_applicant_pay','applicant_education','center_education','applicant_attachment',
        'applicant_choose_programme','applicant_submission','center_submission','applicant_experience','applicant_referee','applicant_sponsor',
        'applicant_activate','rejectAdmission','confirmationcode','unconfirmationcode','tcu_resubmit','loadAjaxData','GetComfirmationCode','reject_admission','restore_cancelled_admission'
    ),

    'panel' => array(
        'applicant_list','centers_list','popup_applicant_info','popup_center_info','popup_iposa_info','manage_criteria','short_listed','programme_list_panel','programme_setting_panel',
        'change_status','short_listed','run_eligibility','run_eligibility_active','collection','applicant_selection',
        'run_selection','run_selection_active','selection_criteria','programme_setting_selection','import',
        'receive_payments','applicant_reports','populate_dashboard','invoice_list','payment_list','applicant_transfers',
        'SubmitEnrolledStudents','current_enrolled_list','applicant_list_iposa','SubmitGraduates','current_graduate_list',
        'current_staffs_list','SubmitStaffs','current_student_dropout_list','SubmitStudentDropOut','SubmitStudentPostPoned','saris_student','approved_center_list',
        'current_student_postponed_list','current_student_non_degree_programme_list','SubmitStudentNonDegreeProgramme','student_account_statement','import_payment',
        'import_nacte','current_nacte_submitted_list','import_nacte_verification','current_nacte_verification_list','applicant_reports_nacte',
        'Nacte_Institutional_programmes','nacte_payment_balance','nacte_particular_NTA_result','nacte_enrollment','nacte_enrolled_list','enroll_nacte'
    ),

    'report'=> array(
        'print_application','center_print_application', 'print_balance', 'print_invoice','print_invoice2','print_receipt','print_transfer','print_transfer2','print_application_iposa'
    )
);




foreach ($route_structure as $controller => $functions) {
    foreach ($functions as $key => $func) {
        $route[$func] = $controller . "/" . $func;
        $route[$func . '/(:any)'] = $controller . "/" . $func . '/$1';
        $route[$func . '/(:any)/(:any)'] = $controller . "/" . $func . '/$1/$2';
        $route[$func . '/(:any)/(:any)/(:any)'] = $controller . "/" . $func . '/$1/$2/$3';
    }
}
