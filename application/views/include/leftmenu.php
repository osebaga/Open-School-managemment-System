<ul class="nav metismenu" id="side-menu">

    <?php
    $get_group = get_user_group($CURRENT_USER->id);

    // $tmp_current_campus = current_campus();
    ?>
    <li class="nav-header"><div class="logo-element">OSMIS</div></li>


    <?php
// var_dump($get_group);exit;
    if ($get_group->module_id == 1) {
        //admission Module
        include 'panel_menu.php';
    } else if ($get_group->module_id == 2) {
        //Academic  Module
        include 'applicant_menu.php';
    } else if ($get_group->module_id == 3) {
        //accountant interface
        include 'finance_menu.php';
    }
    elseif($get_group->module_id == 4){
        //center applicant interface
        include 'center_menu.php';
    }
    ?>

</ul>

