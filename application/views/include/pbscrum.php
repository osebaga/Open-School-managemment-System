<div class="row wrapper border-bottom white-bg page-heading navy-bg" style="margin-top: -20px; background-color: #3a849e">
    <?php if(!isset($CURRENT_USER)){ ?>
    <div class="col-md-12" >                
        <ul class="nav navbar-top-links navbar-right"  >
  
        <img src="<?php echo base_url() ?>images/logo_new.png" style=" margin: 0px 0px 0px -140%; width: 6%;  background-color: #FFFFFF;
        border-radius: 100%;"/>
        <?php
            $organisation_info = get_collage_info();  echo 'OPEN SCHOOL MANAGEMENT INFORRMATION SYSTEM';
        ?>
            <li class="border-right" style="margin-left: 150%" >
                <a href="<?php echo site_url(); ?>" style="color: #fff;">
                     HOME</a>
            </li>
            <!-- <li class="border-right"> -->
                <a href="<?php echo site_url('registration_start'); ?>" style="color: #fff;">
                    <i class="fa fa-file-text-o"></i> APPLICATION</a>
            <!-- </li> -->
        </ul>
 
    </div>
    <?php }else {?>

        <div class="col-md-12" >                
        <ul class="nav navbar-top-links navbar-right"  >
  
        <img src="<?php echo base_url() ?>images/logo_new.png" style=" margin: 0px 0px 0px -145%; width: 6%;  background-color: #FFFFFF;
        border-radius: 100%;"/>
        
        <?php
            $organisation_info = get_collage_info();  echo 'OPEN SCHOOL MANAGEMENT INFORRMATION SYSTEM';
        ?>
            <li class="border-right" style="margin-left: 155%" >
            <a href="<?php echo site_url('applicant_dashboard'); ?>" style="color: #fff;">
                    <i class="fa fa-home" style="margin-left: -80%" ></i> HOME</a>
                    
            </li>
            <!-- <li class="border-right"> -->
            <a href="<?php echo site_url('logout'); ?>" style="color: #fff;">
                    <i class="fa fa-sign-out"></i> LOGOUT</a>
            <!-- </li> -->
        </ul>
 
    </div>



    <!-- <div class="col-lg-6">
        <ul class="nav navbar-top-links navbar-right" >
            <li class="border-right">
                <a href="<?php echo site_url('applicant_dashboard'); ?>" style="color: #fff;">
                    <i class="fa fa-home"></i> HOME</a>
            </li>
            <li class="border-right">
                <a href="<?php echo site_url('logout'); ?>" style="color: #fff;">
                    <i class="fa fa-sign-out"></i> LOGOUT</a>
            </li>
        </ul>

    </div> -->
    <?php } 
    ?>

</div>