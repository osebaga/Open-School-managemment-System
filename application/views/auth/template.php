<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>HIMS | Login</title>
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="<?php echo base_url(); ?>media/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>media/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>media/css/login.css" rel="stylesheet">


</head>
<div class="header-div">
    <div class="container" >
        <div class="row">

            <div style="background: transparent; height: 80px; margin-left: 10px; overflow: hidden;" >
                <div style="float: left; width: 150px; height: 80px; margin: 0px 0px 0px 20px;  border: 0px solid red;">
                    <img src="<?php echo base_url() ?>logo.png"
                         style="width: 150px; margin: 0px 0px 0px 0px; height: 80px;"/>

                </div>
                <div style="float: left; margin: 0px 0px 0px 10px;">
                    <div style="color: #666666; font-size: 30px; margin: 0px 0px 0px 10px; font-weight: bold;"><?php

                        echo company_info()->name;
                        ?></div>
                    <div style="color: #666666; font-size: 25px;   margin: 0px 0px 0px 10px;">HOSPITAL INFORMATION MANAGEMENT SYSTEM { HIMS }
                    </div>
                </div>
                <div style="clear: both;"></div>

            </div>
        </div>
    </div>
</div>


<div class="block white">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h3>Welcome to HIMS</h3>
                <hr/>
                <ul>
                    <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</li><br/>
                    <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</li><br/>
                    <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.  </li>
                   </ul>
            </div>
            <div class="col-md-offset-1 col-md-6">
            <?php
            $this->load->view($content);
            ?>
            </div>
        </div>
        <div style="border-top : 2px solid #e7eaec; text-align: center; margin-top: 20px; padding-top: 10px;">
            <div id="copyright">© <?php echo date('Y'); ?>&nbsp; &nbsp; MICO SINZA HOSPITAL . All right reserved</div>
            <div>
                <span> Designed and Developed by :</span>
                <a href="http://ictsolutionsdesign.com" target="_blank"> ICT SOLUTIONS DESIGN</a>
            </div>
        </div>
    </div>
</div>



</body>
</html>
