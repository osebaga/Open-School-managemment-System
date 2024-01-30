<?php
include VIEWPATH.'include/pbscrum.php';
?>

<div class="col-lg-12 text-center">
    <div class="navy-line"></div>
    <h3 style="margin-top: 10px; color: brown;">Welcome : </h3>
   <marquee behavior="scroll" direction="left" style="margin: 0px 300px 0px 300px">
     <div style="font-weight: bold; font-size: 12px; margin-bottom: 10px;">Online support : <?php echo ONLINE_SUPPORT; ?> </div>
</marquee>
     <!--    <div style="font-weight: bold; font-size: 12px; margin-bottom: 10px;"><a href="--><?php //echo GATEWAY_ONLINE_SUPPORT; ?><!--">CLick Here</a>  To Download Online Payment Gateway User Manual </div>-->

    <?php
    if (isset($message)) {
        echo $message;
    } else if ($this->session->flashdata('message') != '') {
        echo $this->session->flashdata('message');
    }
    ?>
</div>

<div class="row gray-bg">
    <div class="container">
        <div class="col-lg-2 no-padding no-margins">
            <div class="ibox float-e-margins">
                <br/><br/>
                <div class="ibox-title">
                    <h5>Main Menu</h5>
                </div>
                <div class="ibox-content no-padding">
                    <ul class="folder-list m-b-md" style="padding: 0">
                        <li style="padding: 5px 20px; font-size: 15px;"><a href="<?php echo site_url('student_dashboard') ?>"> <i class="fa fa-star "></i> Dashboard </a></li>
                        <li style="padding: 5px 20px; font-size: 15px;"><a href="<?php echo site_url('student_invoices') ?>"> <i class="fa fa-star "></i> Pending Bills </a></li>
                        <li style="padding: 5px 20px; font-size: 15px;"><a href="<?php echo site_url('student_create_invoice') ?>"> <i class="fa fa-star "></i> Create Bills </a></li>
                    </ul>

                </div>
            </div>
        </div>
        <div class="col-lg-8" style="padding-right: 0px;">
            <div class="progress progress-striped active">
                <div style="width: <?php echo number_format(@$count_progress/9*100); ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" role="progressbar" class="progress-bar progress-bar-success">
                </div>
            </div>
            <?php
            if (isset($middle_content) && isset($data)) {
                $this->load->view($middle_content, $data);
            } else {
                $this->load->view($middle_content);
            }
            ?>

        </div>
    </div>
</div>

