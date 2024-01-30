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
        'index','requirement','contact','faq','registration_start','application_start','registration_start1',
        'registration_bachelor','recommendation'
    ),

    'dashboard' => array(
        'dashboard'
    ),

    'auth' => array(
        'login', 'logout', 'change_password', 'login_history', 'activate', 'deactivate',
        'forgot_password', 'reset_password'
    ),

    'admin' => array(
        'add_group','group_list','grant_access','create_user','user_list','manage_database','reset_pass'
    ),

    'simsdata' => array(
        'school_list','department_list','programme_list','add_programme','manage_school','manage_department',
        'delete_programme'
    ),

    'setting' => array(
        'manage_subject','add_sec_subject','current_semester','application_deadline'
    ),

    'applicant'=> array(
        'applicant_dashboard','applicant_basic','applicant_contact','applicant_profile',
        'applicant_next_kin','applicant_payment','is_applicant_pay','applicant_education','applicant_attachment',
        'applicant_choose_programme','applicant_submission','applicant_experience','applicant_referee','applicant_sponsor',
        'applicant_activate'
    ),

    'panel' => array(
        'applicant_list','popup_applicant_info','manage_criteria','short_listed','programme_list_panel','programme_setting_panel',
        'change_status','short_listed','run_eligibility','run_eligibility_active','collection','applicant_selection',
        'run_selection','run_selection_active','selection_criteria','programme_setting_selection',
        'receive_payments'
    ),

    'report'=> array(
        'print_application'
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
