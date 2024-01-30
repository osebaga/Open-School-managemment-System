<html>
<head>
    <title>Student Information Management System</title>
    <link type="text/css" href="<?php echo base_url(); ?>media/css/login.css" rel="stylesheet" media="all"
          rel="stylesheet"/>
    <link type="text/css" href="<?php echo base_url(); ?>media/css/jtip.css" rel="stylesheet" media="all"
          rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo base_url(); ?>media/js/jquery-2.1.1.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>media/js/jtip.js"></script>
    <style type="text/css">
        .error {
            color: red;
        }
    </style>
</head>
<body>
<div id="home">
    <div id="head">
        <div style="float: left; width: 200px; height: 90px; margin: 0px 0px 0px 30px;  border: 0px solid red;">
            <img src="<?php echo base_url() ?>images/logo.jpg"
                 style="width: 200px; margin: 10px 0px 0px 0px; height: 90px;"/>

        </div>
        <div style="float: left; margin: 30px 0px 0px 10px;">
            <div style="color: white; font-size: 30px; font-weight: bold;">          <?php

                echo get_collage_info()->Name;
                ?></div>
            <div style="color: white; font-size: 25px;   margin: 30px 0px 0px 10px;">STUDENT INFORMATION MANAGEMENT
                SYSTEM { SIMS }
            </div>
        </div>
        <div style="clear: both;"></div>


    </div>
    <div class="login_line">
    </div>
    <div id="head2">

        <div
            style="float: left; color: #000000; font-weight: bold; font-size: 15px; margin: 15px 0px 0px 50px; width: 300px;">
            Academic Year : <?php echo get_active_year()->AYear; ?></div>
        <div
            style="float:right; color: #000000; font-weight: bold; font-size: 15px; margin: 15px 0px 0px 0px; width: 300px;"><?php echo date('F j, Y'); ?></div>
        <div style="clear: both;"></div>
    </div>
    <div style="width: 1000px; border: 0px solid red; margin: auto;padding-bottom: 50px;overflow: auto; ">
        <div style="float: left; width: 400px; border: 0px; margin: 0px 0px 0px 10px; font-size: 12px;">

            <p><b> Welcome to SIMS </b><br/>
                <span style="margin-left: 15px; display: block; ">The Student Information Management System (SIMS) holds all the information relating to students.</span>
            </p>

            <p><b style="display: block;">Students</b></label>
                <span style="display: block; text-indent: 15px;"><b>*</b> Register for Courses online</span>
                <span style="display: block; text-indent: 15px;"><b>*</b> View Course Progress and Results</span>
                <span style="display: block; text-indent: 15px;"><b>*</b>  Forums</span>


            </p>

            <p>
                <b style="display: block;">Teaching Staff</b>
                <span style="display: block; text-indent: 15px;"><b>*</b> View list of Students per Course</span>
                <span style="display: block; text-indent: 15px;"><b>*</b> Publish Course Results</span>
                <span style="display: block; text-indent: 15px;"><b>*</b> Track Students Progress/Reports</span>
            </p>

            <p>
                <b style="display: block;">Other</b>
                <span style="display: block; text-indent: 15px;"><b>*</b> Payment Management</span>
                <span style="display: block; text-indent: 15px;"><b>*</b> Configuration</span>

            </p>




        </div>


        <div style="float: left; height: 350px; border: 1px solid #494949; width: 0px; margin: 20px 0px 0px 0px;"></div>
        <div style="float: left; width: 500px; border: 0px; margin: 20px 0px 0px 20px;">

            <div class="signin" style="font-size: 20px; padding-bottom: 5px; margin: 0px;">UPGRADE YOUR ACCOUNT</div>

            <div style="color: red; font-size: 12px;">
                <?php if (isset($message)) {
                    echo $message;
                } else if ($this->session->flashdata('message') != '') {
                    echo $this->session->flashdata('message');
                }
                ?>
            </div>

            <?php echo form_open(current_full_url()); ?>

            <p>
                <label style=" color: #000;">Please enter valid information below.</label><br/>
            </p>

            <p>
                <label for="password" style=" color: #000;">Enter Username</label><br/>
                <input style="font-size: 14px; height: 30px;" type="text" name="identity" value="<?php echo set_value('identity'); ?>" id="identity" placeholder="Username">
                <?php
                echo form_error('identity');
                ?>
            </p>
            <p>
                <label for="password" style=" color: #000;">Enter  Password</label><br/>
                <input style="font-size: 14px; height: 30px;" type="password" name="password" value="" id="identity" placeholder="Password">
                <?php
                echo form_error('password');
                ?>
            </p>
            <p>
                <label for="password" style=" color: #000;">Enter valid Email</label><br/>
                <input style="font-size: 14px; height: 30px;" type="text" name="email" value="<?php echo set_value('email') ?>" id="identity" placeholder="Email">
                <?php
                echo form_error('email');
                ?>
            </p>
            <p>
                <label for="password" style=" color: #000;">Enter valid Mobile #</label><br/>
                <input style="font-size: 14px; height: 30px;" type="text" name="phone" value="<?php echo set_value('phone'); ?>" id="identity" placeholder="255XXXXXXXXX">
                <?php
                echo form_error('phone');
                ?>
            </p>



            <p style=" width: 350px;">
                <a href="<?php echo site_url('login'); ?>"  style=" padding-bottom: 10px !important;" title="Login">
                    << Back to Login
                </a>
                <?php echo form_submit('submit', 'UPGRADE', 'class="submit" style="font-size:13px;"'); ?></p>


            <?php echo form_close(); ?>


        </div>
        <div style="clear: both;"></div>
    </div>
</div>
<div id="footer">
    <div class="login_line">
    </div>
    <p id="copyright" style="float: left; font-weight: bold;">&copy; <?php echo date('Y'); ?> <a
            href="http://mist.ac.tz" target="_blank">MBEYA UNIVERSITY OF SCIENCE AND TECHNOLOGY</a></p>

    <p id="developers"><span> Designed and Developed by :</span> <a href="http://www.ictsolutionsdesign.com"
                                                                    target="_blank"> ICT SOLUTIONS DESIGN</a></p>
</div>
</body>
</html>

