<li class="<?php echo (isset($active_menu) ? ($active_menu == 'dashboard' ? 'active':''):''); ?>">
    <a href="<?php echo site_url('dashboard'); ?>">
        <i class="fa fa-dashboard"></i> <span class="nav-label">Dashboard</span></a>
</li>

<?php
/**
 * Created by PhpStorm.
 * User: festus
 * Date: 5/13/17
 * Time: 2:25 PM
 */

?>

    <li class="<?php echo (isset($active_menu) ? ($active_menu == 'sims_data' ? 'active':''):''); ?>">
        <a href="<?php echo site_url('dashboard'); ?>">
            <i class="fa fa-cog"></i> <span class="nav-label">Data Source</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
                <li><a href="<?php echo site_url('fee_structure_list') ?>"><i class="fa fa-angle-right"></i> Fee Structure List</a></li>
                <li><a href="<?php echo site_url('student_invoice_list') ?>"><i class="fa fa-angle-right"></i> Student Balance List</a></li>
                <!-- <li ><a href="<?php echo site_url('sponsor_list'); ?>"><i class="fa fa-angle-right"></i> Sponsors List</a></li> -->
                <!-- <li><a href="<?php echo  site_url('import_payment') ?>"><i class="fa fa-angle-right"></i>Import Student  Payment</a></li> -->

        </ul>
    </li>


    <li class="<?php echo (isset($active_menu) ? ($active_menu == 'settings' ? 'active':''):''); ?>">
        <a href="<?php echo site_url('dashboard'); ?>">
            <i class="fa fa-tasks"></i> <span class="nav-label">Settings</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li ><a href="<?php echo site_url('current_rate'); ?>"><i class="fa fa-angle-right"></i> Exchange Rate</a></li>
            <li ><a href="<?php echo site_url('current_account_year'); ?>"><i class="fa fa-angle-right"></i>Account Year</a></li>

        </ul>
    </li>



<li class="<?php echo (isset($active_menu) ? ($active_menu == 'invoice_list' ? 'active':''):''); ?>">
    <a href="">
        <i class="fa fa-list-alt"></i> <span class="nav-label">Invoices</span><span class="fa arrow"></span></a>

    <ul class="nav nav-second-level collapse">
        <li><a href="<?php echo site_url('student_create_invoice'); ?>"><i class="fa fa-angle-right"></i> Create Bill</a></li>

    </ul>

    <ul class="nav nav-second-level collapse">
        <li><a href="<?php echo site_url('invoice_list'); ?>"><i class="fa fa-angle-right"></i> Bills List</a></li>
    </ul>
</li>

<li class="<?php echo(isset($active_menu) ? ($active_menu == 'report' ? 'active' : '') : 'active'); ?> ">
    <a href="<?php echo site_url('dashboard'); ?>">
        <i class="fa fa-file-excel-o" aria-hidden="true"></i><span class="nav-label">  REPORTS</span><span class="fa arrow">
    </a>
    <ul class="nav nav-second-level collapse">
        <!-- <li><a href="<?php echo site_url('saris_student'); ?>"><i class="fa fa-angle-right"></i> saris students</a></li> -->
    </ul>
    <ul class="nav nav-second-level collapse">
        <li><a href="<?php echo site_url('payment_list'); ?>"><i class="fa fa-angle-right"></i> Collection Summary</a></li>
    </ul>

    <ul class="nav nav-second-level collapse">
        <li><a href="<?php echo site_url('student_account_statement'); ?>"><i class="fa fa-angle-right"></i> Debtor's Report</a></li>

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


<li class="<?php echo(isset($active_menu) ? ($active_menu == 'security' ? 'active' : '') : ''); ?>">
    <a href="<?php echo site_url(); ?>">
        <i class="fa fa-lock"></i> <span class="nav-label">Security</span> <span
                class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="<?php echo site_url('login_history'); ?>"><i class="fa fa-angle-right"></i>Login History</a></li>
        <li><a href="<?php echo site_url('change_password'); ?>"><i class="fa fa-angle-right"></i>Change Password</a></li>
