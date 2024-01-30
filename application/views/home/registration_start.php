<?php
include VIEWPATH.'include/pbscrum.php';
?>
    <?php
    $is_app_open = true;
    if(get_application_deadline() < date('Y-m-d')){
        $is_app_open =false;
    } ?>
<!-- <div class="row">
    <div class="col-md-12" style="text-align: center">
        <h2>Online support | Mobile number +255772685562/+255676585562 | Email : admission@sumait.ac.tz</h2>
        <hr>
    </div>

</div> -->
<div class="row">

<div class="container">
    <div class="col-md-6" style="border-right: 1px solid #c4e3f3;">
        <h2 style="text-align: center;">APPLICATION PROCEDURES</h2>

        <div class="row">
            <div class="col-lg-12">

                <ul class="procedure">
                    <li><span class="head_title">Step 1 :: Read Application Requirements</span>
                        <div class="procedure_content">
<!--                            <p>Please click the link to read <a href="javascript:void(0);" data-toggle="popover" role="button" title="" data-original-title="Admission Requirement <a style='float:right;' href='javascript:void(0);' class='close_popover'>X</a>" data-html="true" data-placement="bottom" data-content="1. <a target='_blank' href='--><?php //echo ADMISSION_REQUIREMENT_UNDERGRADUATE ?><!--'>Undergraduate Programmes</a><br/><br/>2. <a target='_blank' href='--><?php //echo ADMISSION_REQUIREMENT_POSTGRADUATE; ?><!--'>Postgraduate Programmes</a>" style=" font-weight: bold; text-decoration: underline;"> Admission Requirements</a> before starting application process</p>-->


                            <p>The following documents or attachments are required in order to complete your application: <br/>
                            <ul class="list_data">
                                <li>Recent Digital or Scanned Passport Size Photo with background blue</li>
                                <li>Scanned original Birth Certificate or affidavit</li>
                                <li>Applicant with O-Level Certificate (CSEE): Scanned original O-Level Education Certificate in PDF or Image</li>
                                <li>Applicant with A-Level Certificate (ACSEE): Scanned original O-Level and A-Level Education Certificate in PDF or Image</li>
                                <li>Applicant with VETA Certificate: Scanned original O-Level and VETA Certificate in PDF or Image</li>
                            </ul>

                        </div>
                    </li>
                    <li><span class="head_title">Step 2 :: START APPLICATION/BASIC INFORMATION</span>
                        <div class="procedure_content">
                            <p>
                            <ul class="list_data">
                                <li>Carefully select your correct Application Type and current education level at right side</li>
                                <li>Enter all the required information.</li>
                                <li>You will be automatically logged into the system based on the username and password.</li>
                                <li>The system automatically saves your information</li>
                                <li>You must provide a valid email address (Active email Address) and phone number for verifying your account.</li>
                                <li>Don’t forget your username and password</li>
                            </ul>
                            </p>
                        </div>
                    </li>
                    <li><span class="head_title">Step 3 :: Contact Information</span>
                        <div class="procedure_content">
                            <p >
                            <ul class="list_data">
                                <li>After Completing Registration Process Step 2, You will be automatically logged into the system based on the username and password entered in Step 2.</li>
                                <li>The system will redirect you to fill in your contacts details. </li>
                                <li>Please fill in all required field in this section</li>
                            </ul>
                            </p>
                        </div>
                    </li>
                    <li><span class="head_title">Step 4 :: Application Fee Payment</span>
                        <div class="procedure_content">
                            <p>
                            <ul class="list_data">
                                <li>The system allows Mobile Payment Process. You can pay application fee either by TIGO PESA, M-PESA or AIRTEL MONEY
                                    <ul>
                                        <li style="font-weight: bold;">APPLICATIONS FEES : TZS <?php echo number_format(APPLICATION_FEE,2); ?></li>
					<!-- <li style="font-weight: bold;">APPLICATION FEE POSTGRADUATE : TZS <?php /*echo number_format(APPLICATION_FEE_POSTGRADUATE,2); */?></li>-->                                    </ul>
                                </li>
                                <li>In this section you will get your Payment Reference Number.</li>
                                <li>Steps on how to pay will be display on the payment after selecting/clicking on your preferred payment Method. </li>
                                <li>After Making your Payment the system will recognise your payment and the page will be updated.</li>
                            </ul>
                            </p>
                        </div>
                    </li>
                    <li><span class="head_title">Step 5 :: Profile Picture</span>
                        <div class="procedure_content">
                            <p >In this section you are required to upload Scanned/Digital Passport Size Photo with background blue.</p>
                        </div>
                    </li>

                    <li><span class="head_title">Step 6 :: Next of Kin (Parents/Guardian)</span>
                        <div class="procedure_content">
                            <p >This section requires you to fill in your Parents/Guardians Information including Contacts Information (Name, Contacts e.t.c.)</p>
                        </div>
                    </li>

                    <li><span class="head_title">Step 7 :: Education Background</span>
                        <div class="procedure_content">
                            <p>
                            <ul class="list_data">
                                <li>This section requires an applicant to fill in his/her Educational Background.</li>
                                <li>The Information entered in this part must be the same as in your Certificates, Failure to that your application will be rejected.</li>
                            </ul>
                            </p>
                        </div>
                    </li>
                    <li><span class="head_title">Step 8 :: Attachment&nbsp;</span>
                        <div class="procedure_content">
                            <p >Upload all the required scanned original documents as listed in Step One. </p>
                        </div>
                    </li>
                    <li><span class="head_title">Step 9 :: Choose/Select Programme to Study</span>
                        <div class="procedure_content">
                            <p>
                            <ul class="list_data">
                                <li>Before Select/Choose Programmes, please make sure you have read our <a href="javascript:void(0);" data-toggle="popover" role="button" title="" data-original-title="Admission Requirement <a style='float:right;' href='javascript:void(0);' class='close_popover'>X</a>" data-html="true" data-placement="bottom" data-content="1. <a target='_blank' href='<?php echo ADMISSION_REQUIREMENT_UNDERGRADUATE ?>'>Undergraduate Programmes</a><br/><br/>2. <a target='_blank' href='<?php echo ADMISSION_REQUIREMENT_POSTGRADUATE; ?>'>Postgraduate Programmes</a>" style="font-weight: bold; text-decoration: underline;">Admission Requirements</a>.</li>
                                <li>You will be required to select/Choose five (5) Programmes from available list as First Choice, Second Choice, Third Choice, Fourth Choice and Fifth Choice.</li>
                            </ul>
                            </p>
                        </div>
                    </li>
                    <li><span class="head_title">Step 10 :: Review && Submit your Application&nbsp;</span>
                        <div class="procedure_content">
                            <p >Before you submit your application. You are required to review all of the Information for correctness. Edit to correct in case of any error. Remember after submission you will not be able to change any information. So be carefully to review and correct all information before submit. </p>
                        </div>
                    </li>
                </ul>

                <p><strong>NOTE :</strong>
                <ul class="list_data">
                    <li>You will be able to make changes in your application e.g. change Programme Choices before the application deadline </li>
                    <li>You will be able to see the status of your application in your account once verification process opened</li>
                    <li>Make sure you enter correct information</li>
                </ul>
                </p>



            </div>


        </div>




    </div>



    <div class="col-md-6" style="border-left: 1px solid #c4e3f3;">

        <h2 style="text-align: center;">START APPLICATION</h2>
        <div class="row">
            <div class="col-lg-12">
                <?php //if($is_app_open){ ?>
                <ul class="procedure">
                    <li><span class="head_title">Please select correct option below</span>
                    </li>
                </ul>
                    <?php  echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>
                    <div class="form-group"><label class="col-lg-6 control-label">Application Programme  : <span class="required">*</span></label>

                        <div class="col-lg-6">
                            <select class="form-control" id="type">
                                <option value="">[ Select Programme ]</option>
                                <?php
                                $sel = (isset($_GET['type']) ? $_GET['type'] : '');
                                foreach (application_programme() as $key=>$value){
                                    echo '<option '.($sel==$key ? 'selected="selected"':'').' value="'.$key.'">'.$value.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                  
                    <?php if(isset($_GET) && isset($_GET['type']) && $_GET['type'] <> ''){ 
                        ?>

                        <div class="form-group"><label class="col-lg-6 control-label">Entry Qualification  : <span class="required">*</span></label>

                            <div class="col-lg-6">
                                <select class="form-control" id="CSEE">
                                    <option value="">[ Select  ]</option>
                                    <?php
                                    $sel = (isset($_GET['CSEE']) ? $_GET['CSEE'] : -1);
                                    foreach (entry_qualification($_GET['type']) as $key=>$value){
                                            echo '<option '.($sel==$key ? 'selected="selected"':'').' value="' . $key . '">' . $value . '</option>';

                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if(isset($_GET) && isset($_GET['CSEE']) && $_GET['CSEE'] <> ''){ ?>
                        <div class="form-group"><label class="col-lg-6 control-label">Select Region  : <span class="required">*</span></label>

                            <div class="col-lg-6">
                                <select class="form-control" id="NT">
                                    <option value="">[ Select  ]</option>
                                    <?php
                                    $region = $this->db->query("select * from regions")->result();
                                    $sel = (isset($_GET['NT']) ? $_GET['NT'] : -1);
                                    foreach (CSEE_type() as $key=>$value){
                                        echo '<option '.($sel==$key ? 'selected="selected"':'').' value="' . $key . '">' . $value . '</option>';

                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    <?php }?>
             

                     <?php 

                     if(isset($_GET) && isset($_GET['CSEE']) && $_GET['CSEE'] <> '' && $_GET['CSEE'] == 0 &&  isset($_GET['VT'])){

                        echo show_alert('Sorry You do not have adequate qualification to proceed with this application. Please review your answers above and try again.','info');
                  }if(isset($_GET) && ((isset($_GET['NT']) && $_GET['NT'] <> '') )){ ?>
                    <div class="form-group"><label class="col-lg-6 control-label">Center  : <span class="required">*</span></label>

                        <div class="col-lg-6">
                            <select class="form-control" id="entry">
                                <option value="">[ Select Center ]</option>
                                <?php
                                 $regn = $_GET['NT'];
                                 $centers = $this->db->query("select * from application where submitted=3 and application_category='Center' and region='$regn'")->result();
             
                                foreach ($centers as $key){
                                   
                                 echo '<option value="' . $key->CenterRegNo . '">' . $key->CenterName . '</option>';
                      
                                }
                                ?>
                            </select>
                            <!-- <div style="font-size: 11px;">Please select highest level of Education you have</div> -->
                        </div>
                    </div>
                    <?php }
                // } 
                ?>
                    <?php echo form_close(); ?>

                <?php
               // }else{
                    // echo show_alert('Application Closed !!','info');
                //} ?>
            </div>

        </div>

    </div>

</div>

</div>

    <script>
        $(document).ready(function () {
            $("#type").change(function () {
                var type = $(this).val();
                if(type==4)
                {
                
                    window.location.href = "<?php echo site_url('application_start/?type=') ?>4&CSEE=0&NT=0&entry=0";
                }else{
                    window.location.href = "<?php echo site_url('registration_start/?type=') ?>"+type;
                }

            });

            $.urlParam = function(name){
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                if (results==null){
                    return null;
                }
                else{
                    return decodeURI(results[1]) || 0;
                }
            }

            $("#CSEE").change(function () {
                var CSEE = $(this).val();
                if(CSEE!= '') {
                    window.location.href = "<?php echo site_url('registration_start/?type=') ?>"+$.urlParam('type')+"&CSEE="+CSEE;
                }
            });

            $("#NT").change(function () {
                var NT = $(this).val();
                if(NT!= '') {
                    window.location.href = "<?php echo site_url('registration_start/?type=') ?>"+$.urlParam('type')+"&CSEE="+$.urlParam('CSEE')+"&NT="+NT;
                }
            });

            $("#VT").change(function () {
                var VT = $(this).val();
                if(VT!= '') {
                    window.location.href = "<?php echo site_url('registration_start/?type=') ?>"+$.urlParam('type')+"&CSEE="+$.urlParam('CSEE')+"&VT="+VT;
                }
            });

            $("#entry").change(function () {
                var entry = $(this).val();
                // alert(entry);
                if(entry!= '') {
                   window.location.href = "<?php echo site_url('application_start/?type=') ?>"+$.urlParam('type')+"&CSEE="+$.urlParam('CSEE')+"&NT="+$.urlParam('NT')+"&entry="+entry;
                }
            });

            
        })
    </script>
