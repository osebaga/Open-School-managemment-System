<li class="<?php echo (isset($active_menu) ? ($active_menu == 'dashboard' ? 'active':''):''); ?>">
    <a href="<?php echo site_url('dashboard'); ?>">
        <i class="fa fa-dashboard"></i> <span class="nav-label">Dashboard</span></a>
</li>
<!-- <li class="<?php echo (isset($active_menu) ? ($active_menu == 'verification_code' ? 'active':''):''); ?>">
    <a href="<?php echo site_url('verification_code'); ?>">
    <i class="fa fa-fast-forward" aria-hidden="true"></i> <span class="nav-label">activation Code</span></a>
</li> -->
<?php
/**
 * Created by PhpStorm.
 * User: festus
 * Date: 5/13/17
 * Time: 2:25 PM
 */
if(has_section_role($MODULE_ID,$GROUP_ID,'DATA_FROM_SIMS')){ ?>

    <li class="<?php echo (isset($active_menu) ? ($active_menu == 'sims_data' ? 'active':''):''); ?>">
        <a href="<?php echo site_url('dashboard'); ?>">
            <i class="fa fa-cog"></i> <span class="nav-label">Data Source</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <?php if(has_role($MODULE_ID,$GROUP_ID,'DATA_FROM_SIMS','school_list')){ ?>
                <!-- <li ><a href="<?php echo site_url('school_list'); ?>"><i class="fa fa-angle-right"></i> College/School List</a></li> -->
            <?php } if(has_role($MODULE_ID,$GROUP_ID,'DATA_FROM_SIMS','department_list')){ ?>
                <!-- <li><a href="<?php echo site_url('department_list') ?>"><i class="fa fa-angle-right"></i> Department List</a></li> -->
                <!-- <li><a href="<?php echo site_url('campus_list') ?>"><i class="fa fa-angle-right"></i> Campus List</a></li> -->
                <li ><a href="<?php echo site_url('fee_structure_list') ?>"><i class="fa fa-angle-right"></i> Fee Structure List</a></li>
                <!-- <li><a href="<?php echo site_url('gepg_category_list') ?>"><i class="fa fa-angle-right"></i> GePG category List</a></li> -->

                <!-- <li><a href="<?php echo site_url('vituo') ?>"><i class="fa fa-angle-right"></i> IPOSA Vituo</a></li> -->

            <?php }if(has_role($MODULE_ID,$GROUP_ID,'DATA_FROM_SIMS','programme_list')){ ?>
                <li ><a href="<?php echo site_url('programme_list'); ?>"><i class="fa fa-angle-right"></i> Programme List</a></li>
            <?php } ?>
            <!-- <li ><a href="<?php echo site_url('center_list'); ?>"><i class="fa fa-angle-right"></i> Center List</a></li> -->
            <li ><a href="<?php echo site_url('teacher_list'); ?>"><i class="fa fa-angle-right"></i> Teacher List</a></li>
            <li ><a href="<?php echo site_url('current_semester'); ?>"><i class="fa fa-angle-right"></i> Academic Year</a></li>
                <li ><a href="<?php echo site_url('current_account_year'); ?>"><i class="fa fa-angle-right"></i>Account Year</a></li>
        </ul>
    </li>
<?php } if(has_section_role($MODULE_ID,$GROUP_ID,'SETTINGS')){ ?>

    <!-- <li class="<?php echo (isset($active_menu) ? ($active_menu == 'settings' ? 'active':''):''); ?>">
        <a href="<?php echo site_url('dashboard'); ?>">
            <i class="fa fa-tasks"></i> <span class="nav-label">Settings</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <?php if(has_role($MODULE_ID,$GROUP_ID,'SETTINGS','manage_subject')){ ?> -->
                <!-- <li ><a href="<?php echo site_url('manage_subject'); ?>"><i class="fa fa-angle-right"></i> Secondary Subject</a></li> -->
            <!-- <?php }if(has_role($MODULE_ID,$GROUP_ID,'SETTINGS','current_semester')){ ?>
                <li ><a href="<?php echo site_url('current_semester'); ?>"><i class="fa fa-angle-right"></i> Academic Year</a></li>
                <li ><a href="<?php echo site_url('current_account_year'); ?>"><i class="fa fa-angle-right"></i>Account Year</a></li> -->
            <!-- <?php }if(has_role($MODULE_ID,$GROUP_ID,'SETTINGS','application_deadline')){ ?> -->
                <!-- <li ><a href="<?php echo site_url('application_deadline'); ?>"><i class="fa fa-angle-right"></i> Application Deadline</a></li> -->
            <!-- <?php }  if(has_role($MODULE_ID,$GROUP_ID,'SETTINGS','application_round')){ ?> -->
                <!-- <li ><a href="<?php echo site_url('application_round'); ?>"><i class="fa fa-angle-right"></i> Application Round</a></li> -->
            <!-- <?php }  ?>
        </ul>
    </li> -->
<!-- <?php }if (has_section_role($MODULE_ID, $GROUP_ID, 'CRITERIA')) { ?>
    <li class="<?php echo(isset($active_menu) ? ($active_menu == 'manage_criteria' ? 'active' : '') : 'active'); ?> ">
        <a href="<?php echo site_url('dashboard'); ?>">
            <i class="fa fa-cogs"></i> <span class="nav-label">Criteria</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <?php if(has_role($MODULE_ID,$GROUP_ID,'CRITERIA','manage_criteria')){ ?>
                <li > <a href="<?php echo site_url('manage_criteria'); ?>"> <i class="fa fa-angle-right"></i> <span class="nav-label">Eligibility</span></a></li>
                <?php }if(has_role($MODULE_ID,$GROUP_ID,'CRITERIA','selection_criteria')){ ?>
                <li > <a href="<?php echo site_url('selection_criteria'); ?>"> <i class="fa fa-angle-right"></i> <span class="nav-label">Selection</span></a></li>
            <?php } ?>
        </ul>
    </li> -->
<?php }if (has_section_role($MODULE_ID, $GROUP_ID, 'APPLICANT')) { ?>
    <li class="<?php echo(isset($active_menu) ? ($active_menu == 'applicant_list' ? 'active' : '') : 'active'); ?> ">
        <a href="<?php echo site_url('dashboard'); ?>">
            <i class="fa fa-desktop"></i> <span class="nav-label">Applicant</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <?php if(has_role($MODULE_ID,$GROUP_ID,'APPLICANT','applicant_list')){ ?>
                <li ><a href="<?php echo site_url('applicant_list'); ?>"><i class="fa fa-angle-right"></i> Applicant List</a></li>
                <li ><a href="<?php echo site_url('centers_list'); ?>"><i class="fa fa-angle-right"></i> Applied Center List</a></li>

                <!-- <li ><a href="<?php echo site_url('applicant_list_iposa'); ?>"><i class="fa fa-angle-right"></i> IPOSA List</a></li>

            <?php } if(has_role($MODULE_ID,$GROUP_ID,'APPLICANT','short_listed')){ ?>
                <li><a href="<?php echo site_url('short_listed') ?>"><i class="fa fa-angle-right"></i>Applicant Short Listed</a></li>
            <?php }if(has_role($MODULE_ID,$GROUP_ID,'APPLICANT','applicant_selection')){ ?>
                <li><a href="<?php echo  site_url('applicant_selection') ?>"><i class="fa fa-angle-right"></i>Applicant Selection</a></li>
            <?php } ?>
            <li><a href="<?php echo  site_url('import') ?>"><i class="fa fa-angle-right"></i>Import candidates</a></li> -->
            <!-- <li><a href="<?php echo  site_url('Nacte_Institutional_programmes') ?>"><i class="fa fa-angle-right"></i>NACTE Institutional programmes</a></li> -->
            <!-- <li><a href="<?php echo  site_url('nacte_payment_balance') ?>"><i class="fa fa-angle-right"></i>NACTE Payment balance</a></li> -->
            <!-- <li><a href="<?php echo  site_url('import_nacte') ?>"><i class="fa fa-angle-right"></i>Import candidates(NACTE)</a></li> -->
            <!-- <li><a href="<?php echo  site_url('current_nacte_submitted_list') ?>"><i class="fa fa-angle-right"></i> Current NACTE  List</a></li> -->
            <!-- <li><a href="<?php echo  site_url('import_nacte_verification') ?>"><i class="fa fa-angle-right"></i>Import verifications(NACTE)</a></li> -->
            <!-- <li><a href="<?php echo  site_url('current_nacte_verification_list') ?>"><i class="fa fa-angle-right"></i> Current NACTE Verification List</a></li> -->
            <!-- <li><a href="<?php echo  site_url('nacte_particular_NTA_result') ?>"><i class="fa fa-angle-right"></i>NACTE NTA Result</a></li> -->
            <!-- <li><a href="<?php echo  site_url('applicant_reports_nacte') ?>"><i class="fa fa-angle-right"></i>NACTE Reports</a></li> -->
            <!-- <li><a href="<?php echo  site_url('nacte_enrollment') ?>"><i class="fa fa-angle-right"></i>NACTE Enrollment</a></li>
            <li><a href="<?php echo  site_url('nacte_enrolled_list') ?>"><i class="fa fa-angle-right"></i>NACTE Enrolled List</a></li> -->
            <!-- <li><a href="<?php echo  site_url('populate_dashboard') ?>"><i class="fa fa-angle-right"></i>Import  Submited Summary</a></li>
            <li><a href="<?php echo  site_url('applicant_reports') ?>"><i class="fa fa-angle-right"></i>TCU Reports</a></li>
            <li><a href="<?php echo  site_url('applicant_transfers') ?>"><i class="fa fa-angle-right"></i>TCU Transfers</a></li>
            <li><a href="<?php echo  site_url('SubmitEnrolledStudents') ?>"><i class="fa fa-angle-right"></i>Students' Enrollment</a></li>
            <li><a href="<?php echo  site_url('current_enrolled_list') ?>"><i class="fa fa-angle-right"></i> Current Enrollment List</a></li> -->
        </ul>
    </li>
<?php } ?>
<!-- <li class="<?php echo(isset($active_menu) ? ($active_menu == 'SubmitGraduates' ? 'active' : '') : 'active'); ?> ">
    <a href="<?php echo site_url('dashboard'); ?>">
        <i class="fa fa-graduation-cap"></i> <span class="nav-label">GRADUATES</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li ><a href="<?php echo site_url('SubmitGraduates'); ?>"><i class="fa fa-angle-right"></i> Submit Graduates to TCU</a></li>
        <li ><a href="<?php echo site_url('current_graduate_list'); ?>"><i class="fa fa-angle-right"></i> Current Graduates list</a></li>
    </ul>
</li> -->

<!-- <li class="<?php echo(isset($active_menu) ? ($active_menu == 'SubmitStaffs' ? 'active' : '') : 'active'); ?> ">
    <a href="<?php echo site_url('dashboard'); ?>">
        <i class="fa fa-user"></i> <span class="nav-label">STAFFS</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li ><a href="<?php echo site_url('SubmitStaffs'); ?>"><i class="fa fa-angle-right"></i> Submit Staffs to TCU</a></li>
        <li ><a href="<?php echo site_url('current_staffs_list'); ?>"><i class="fa fa-angle-right"></i> Current Staffs list</a></li>
    </ul>
</li> -->

<li class="<?php echo(isset($active_menu) ? ($active_menu == 'report' ? 'active' : '') : 'active'); ?> ">
    <a href="<?php echo site_url('dashboard'); ?>"> 
        <i class="fa fa-file-excel-o" aria-hidden="true"></i><span class="nav-label">  REPORTS</span><span class="fa arrow">
    </a>
    <ul class="nav nav-second-level collapse">
        <li><a href="<?php echo site_url('saris_student'); ?>"><i class="fa fa-angle-right"></i> Student List</a></li>
    </ul>
    <ul class="nav nav-second-level collapse">
        <li><a href="<?php echo site_url('approved_center_list'); ?>"><i class="fa fa-angle-right"></i>Approved Center List</a></li>
    </ul>

    <!-- <ul class="nav nav-second-level collapse">
        <li><a href="<?php echo site_url('student_account_statement'); ?>"><i class="fa fa-angle-right"></i> Debtor's Report</a></li>

    </ul> -->
</li>

<!-- 
<li class="<?php echo(isset($active_menu) ? ($active_menu == 'SubmitStudentDropOut' ? 'active' : '') : 'active'); ?> ">
    <a href="<?php echo site_url('dashboard'); ?>">
    <i class="fa fa-user" aria-hidden="true"></i><span class="nav-label">STUDENTS</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li ><a href="<?php echo site_url('SubmitStudentDropOut'); ?>"><i class="fa fa-angle-right"></i> Submit Student Drop-out to TCU</a></li>
        <li ><a href="<?php echo site_url('current_student_dropout_list'); ?>"><i class="fa fa-angle-right"></i> Current Student Drop-out list</a></li>
        <li ><a href="<?php echo site_url('SubmitStudentPostPoned'); ?>"><i class="fa fa-angle-right"></i> Submit Student PostPoned to TCU</a></li>
        <li ><a href="<?php echo site_url('current_student_postponed_list'); ?>"><i class="fa fa-angle-right"></i> Current PostPonement list</a></li>
        <li ><a href="<?php echo site_url('SubmitStudentNonDegreeProgramme'); ?>"><i class="fa fa-angle-right"></i> Submit Non Degree Students to TCU</a></li>
        <li ><a href="<?php echo site_url('current_student_non_degree_programme_list'); ?>"><i class="fa fa-angle-right"></i> Current Non Degree list</a></li>

    </ul>
</li> -->

<!-- <li class="<?php echo(isset($active_menu) ? ($active_menu == 'logs' ? 'active' : '') : 'active'); ?> ">
    <a href="<?php echo site_url('dashboard'); ?>">
        <i class="fa fa-spinner"></i> <span class="nav-label">NACTE & NECTA API</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li ><a href="<?php echo site_url('logs/api_issues'); ?>"><i class="fa fa-angle-right"></i> API Issues</a></li>
        <li ><a href="<?php echo site_url('logs/tcu_issues'); ?>"><i class="fa fa-angle-right"></i> TCU Issues</a></li>
    </ul>
</li> -->
<!-- 
<li class="<?php echo(isset($active_menu) ? ($active_menu == 'nacte' ? 'active' : '') : 'active'); ?> ">
    <a href="<?php echo site_url('dashboard'); ?>">
        <i class="fa fa-spinner"></i> <span class="nav-label">NACTE API</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
    <li><a href="<?php echo  site_url('Nacte_Institutional_programmes') ?>"><i class="fa fa-angle-right"></i>NACTE Institutional programmes</a></li>
    <li><a href="<?php echo  site_url('import_nacte') ?>"><i class="fa fa-angle-right"></i>Import candidates(NACTE)</a></li>
        <li><a href="<?php echo  site_url('applicant_reports_nacte') ?>"><i class="fa fa-angle-right"></i>NACTE Reports</a></li>
        <li><a href="<?php echo  site_url('import_nacte_verification') ?>"><i class="fa fa-angle-right"></i>Import verifications(NACTE)</a></li>
        <li><a href="<?php echo  site_url('nacte_particular_NTA_result') ?>"><i class="fa fa-angle-right"></i>NACTE NTA Result</a></li>
        <li><a href="<?php echo  site_url('nacte_payment_balance') ?>"><i class="fa fa-angle-right"></i>NACTE Payment balance</a></li>
        <li><a href="<?php echo  site_url('nacte_enrollment') ?>"><i class="fa fa-angle-right"></i>NACTE Enrollment</a></li>
            <li><a href="<?php echo  site_url('nacte_enrolled_list') ?>"><i class="fa fa-angle-right"></i>NACTE Enrolled List</a></li>
        
    </ul>
</li> -->


<li class="<?php echo (isset($active_menu) ? ($active_menu == 'invoice_list' ? 'active':''):''); ?>">
    <a href="">
        <i class="fa fa-list-alt"></i> <span class="nav-label">Invoices</span><span class="fa arrow"></span></a>

    <ul class="nav nav-second-level collapse">
        <li><a href="<?php echo site_url('student_create_invoice'); ?>"><i class="fa fa-angle-right"></i> Create Invoices</a></li>

    </ul>
    <ul class="nav nav-second-level collapse">
        <li><a href="<?php echo site_url('invoice_list'); ?>"><i class="fa fa-angle-right"></i> invoices List</a></li>

    </ul>
    <ul class="nav nav-second-level collapse">
        <li><a href="<?php echo site_url('payment_list'); ?>"><i class="fa fa-angle-right"></i> Collection Summary</a></li>
    </ul>


</li>


<!-- <li class="<?php echo (isset($active_menu) ? ($active_menu == 'feesetup' ? 'active':''):''); ?>">
    <a href="<?php echo site_url('dashboard'); ?>">
        <i class="fa fa-cog"></i> <span class="nav-label">Receive payments</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li ><a href="<?php echo site_url('receive_payments'); ?>"><i class="fa fa-angle-right"></i> Application payments</a></li>
        <li><a href="<?php echo  site_url('import_payment') ?>"><i class="fa fa-angle-right"></i>Import Student  Payment</a></li>


    </ul>
</li> -->

<!-- <li class="<?php echo (isset($active_menu) ? ($active_menu == 'collection' ? 'active':''):''); ?>">
    <a href="<?php echo site_url('collection'); ?>">
        <i class="fa fa-cc-visa"></i> <span class="nav-label">Application Fee</span></a>
</li> -->

    <?php if(has_section_role($MODULE_ID,$GROUP_ID,'MANAGE_USERS')){ ?>

    <li class="<?php echo (isset($active_menu) ? ($active_menu == 'manage_users' ? 'active':''):''); ?>">
        <a href="<?php echo site_url('dashboard'); ?>">
            <i class="fa fa-users"></i> <span class="nav-label">Manage Users</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <?php if(has_role($MODULE_ID,$GROUP_ID,'MANAGE_USERS','create_group')){ ?>
                <li ><a href="<?php echo site_url('add_group'); ?>"><i class="fa fa-angle-right"></i> Add Users Group</a></li>
            <?php } if(has_role($MODULE_ID,$GROUP_ID,'MANAGE_USERS','group_list')){ ?>
                <li><a href="<?php echo site_url('group_list') ?>"><i class="fa fa-angle-right"></i> Users Group List</a></li>
            <?php }if(has_role($MODULE_ID,$GROUP_ID,"MANAGE_USERS",'user_list')){ ?>
                <li><a href="<?php echo site_url('create_user') ?>"><i class="fa fa-angle-right"></i> New User Account</a></li>
            <?php }if(has_role($MODULE_ID,$GROUP_ID,'MANAGE_USERS','user_list')){ ?>
                <li><a href="<?php echo site_url('user_list') ?>"><i class="fa fa-angle-right"></i> Users List</a></li>
            <?php } ?>
        </ul>

    </li>
<?php } ?>

<li class="<?php echo(isset($active_menu) ? ($active_menu == 'security' ? 'active' : '') : ''); ?>">
    <a href="<?php echo site_url(); ?>">
        <i class="fa fa-lock"></i> <span class="nav-label">Security</span> <span
                class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="<?php echo site_url('login_history'); ?>"><i class="fa fa-angle-right"></i>Login History</a></li>
        <li><a href="<?php echo site_url('change_password'); ?>"><i class="fa fa-angle-right"></i>Change Password</a></li>
