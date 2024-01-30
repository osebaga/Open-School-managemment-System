<?php
include VIEWPATH.'include/pbscrum.php';
?>

<div class="col-lg-12 text-center">
    <?php if($_GET['type'] != 4 ) { ?>
    <h1>Registration Process step 1</h1>
    <!-- <marquee style="margin: 0px 400px 0px 400px" behavoir="scroll" direction="left">
        <p>Application Deadline Date : <?php echo date('F d, Y', strtotime(get_application_deadline())); ?> </p>
    </marquee> -->
    <?php
    }else{
        echo "<h1></h1>";
    }
    if (isset($message)) {
        echo $message;
    } else if ($this->session->flashdata('message') != '') {
        echo $this->session->flashdata('message');
    }
    ?>
</div>


<div class="row gray-bg">
    <div class="container">
        <div class="col-lg-4">
            <div class="ibox">
                <div class="ibox-heading">
                
                    <div class="ibox-title">
                        <h5 style="color: brown;"> IMPORTANT NOTE</h5>
                    </div>
                   
                </div>
                <div class="ibox-content">
                    <table class="table">
                        <?php if($_GET['type'] == 2 ){ ?>
                        <tr>
                            <td class="no-borders"> 1. Your name must be the same as in
                                <?php echo ($_GET['entry'] > 6 ? 'your Academic' : 'Form IV') ?> Certificate</td>
                        </tr>
                        <tr>
                            <td> 2. Date of Birth must be the same as in Birth Certificate</td>
                        </tr>
                        <tr>
                            <?php if($_GET['entry'] > 6 ){ ?>
                            <td> 3. Index Number must be the same as in Entry Mode Certificate</td>
                            <?php }else{ ?>
                            <td> 3. Form IV index Number must be the same as in Form IV Certificate</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td> 4. <strong>Failure to any of the above, Your application will be disqualified </strong>
                            </td>
                        </tr>
                        <tr>
                         
                            <td> 5. Make sure <b>Application Entry Mode</b> and <b>Center</b> are correct before submit
                                form in the right side because you will not be able to start any new application</td>
                       
                            </tr>
                        <tr>
                            <td> 6. Once <?php echo ($_GET['entry'] > 6 ? '' : 'Form IV' ); ?> Index Number Registered,
                                you will not be able to change it.</td>
                        </tr>
                        <tr>
                            <td> 7. <strong>Application fee must be paid within four (4) days from the first day of
                                    filling an application, otherwise your account will be deleted permanent.</strong>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td> 8. <strong>Make sure you read Admission requirement before selecting/Choose
                                    programmes.</strong></td>
                        </tr> -->
                        <tr>
                            <td> 8. Online support : <?php echo ONLINE_SUPPORT; ?> </td>
                        </tr>
                        <?php }elseif($_GET['type'] ==1){ ?>
                            <tr>
                         
                         <td> 1. Make sure <b>Application Entry Mode</b> and <b>Center</b> are correct before submit
                             form in the right side because you will not be able to start any new application</td>
                    
                         </tr>
                         <tr>
                            <td> 2. <strong>Application fee must be paid within four (4) days from the first day of
                                    filling an application, otherwise your account will be deleted permanent.</strong>
                            </td>
                        </tr>  
                         <tr>
                            <td> 3. Online support : <?php echo ONLINE_SUPPORT; ?> </td>
                        </tr>
                        <?php }else{?>
                        <tr>
                            <td> 1. Unaweza kuwasiliana nasi kwa namba zifuatazo :
                                <br /><?php echo ONLINE_SUPPORT_SW; ?> </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="ibox">
                <div class="ibox-heading">

                    <div class="ibox-title">
                        <h5>Preliminary Information</h5>
                    </div>
                </div>

                <div class="ibox-content">

                    <?php  echo form_open_multipart(current_full_url(), 'class="form-horizontal ng-pristine ng-valid"') ?>

                        <div class="form-group"><label class="col-lg-3 control-label">Application Type : <span
                                        class="required">*</span></label>
                            <div class="col-lg-7">
                                <input type="hidden" value="<?php echo $_GET['type'] ?>" name="centreid"  />
                                <input type="text" value="<?php echo center_application($_GET['type']); ?>" class="form-control"
                                       disabled="disabled" />
                            </div>
                            <?php echo form_error('centreid'); ?>

                        </div>

                        <!-- programme being provided -->
                        <!-- <div class="form-group"><label class="col-lg-3 control-label">Programme Name : <span
                                        class="required">*</span></label>
                            <div class="col-lg-7">
                            <select class="form-control" id="type">
                                <option value="">[ Select Programme ]</option>
                                <?php
                                // $sel = (isset($_GET['type']) ? $_GET['type'] : '');
                                foreach (application_programme() as $key=>$value){
                                    echo '<option '.($sel==$key ? 'selected="selected"':'').' value="'.$key.'">'.$value.'</option>';
                                }
                                ?>
                            </select>
                            </div>
                            <?php echo form_error('centreid'); ?>

                        </div> -->

                        <div class="form-group"><label class="col-lg-3 control-label">Center Premises: <span
                                class="required">*</span></label>

                        <div class="col-lg-7">
                            <input type="hidden" value="<?php echo $_GET['premises']; ?>" name="premises"  />
                            <input type="text" value="<?php echo center_premises($_GET['premises']); ?>" class="form-control"
                                disabled="disabled" />
                        </div>
                            <?php echo form_error('premises'); ?>
                        </div>

                        <div class="form-group"><label class="col-lg-3 control-label">Center Name : <span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input type="text" name="centername"
                                    value="<?php echo(isset($centerinfo) ? $centerinfo->CenterName : set_value('centername')) ?>"
                                    class="form-control"/>
                                <?php echo form_error('centername'); ?>
                            </div>
                        </div>
                     
                        <div class="form-group"><label class="col-lg-3 control-label">Center Owner : <span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input type="text" name="centerowner"
                                    value="<?php echo(isset($centerinfo) ? $centerinfo->CenterName : set_value('centerowner')) ?>"
                                    class="form-control"/>
                                <?php echo form_error('centerowner'); ?>
                            </div>
                        </div>
               
                        <div class="form-group"><label class="col-lg-3 control-label">Owner's Education Level : <span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input type="text" name="education_level"
                                    value="<?php echo(isset($centerinfo) ? $centerinfo->OwnerProfession : set_value('education_level')) ?>"
                                    class="form-control"/>
                                <?php echo form_error('education_level'); ?>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-3 control-label">Center Cordinator : <span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input type="text" name="cordinator"
                                    value="<?php echo(isset($centerinfo) ? $centerinfo->CenterCordinator : set_value('cordinator')) ?>"
                                    class="form-control"/>
                                <?php echo form_error('cordinator'); ?>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-3 control-label">TIN : <span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input type="text" name="TIN" onKeyPress="return numbersonly(event,this.value)" maxlength="9"
                                    value="<?php echo(isset($centerinfo) ? $centerinfo->CenterName : set_value('TIN')) ?>"
                                    class="form-control"/>
                                <?php echo form_error('TIN'); ?>
                            </div>
                        </div>
               
                    <div class="form-group"><label class="col-lg-3 control-label" style="font-size: 13px;">Country of
                            Residence : <span class="required ">*</span></label>

                        <div class="col-lg-7">
                            <select name="residence_country" class="form-control select50">
                                <option value=""> [ Select Country ]</option>
                                <?php
                                $sel =  set_value('residence_country',(isset($_GET['NT']) ?  220 :''));
                                foreach ($nationality_list as $key => $value) {
                                    ?>
                                <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                    value="<?php echo $value->id; ?>"><?php echo $value->Country; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <?php echo form_error('residence_country'); ?>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-lg-3 control-label"> Region of Residence: <span
                                class="required ">*</span></label>

                        <div class="col-lg-7">
                            <select name="region" id="region" class="form-control"
                                onchange="loadDistrict (this.value,'populate_districts','populate_districts','populate_district');">
                                <option value=""> [ Select Region]</option>
                                <?php
                                    $sel =  set_value('region');
                                    foreach ($regions as $key => $value) {
                                        ?>
                                <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                    value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                <?php
                                    }
                                    ?>
                            </select>
                            <?php echo form_error('region'); ?>
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-3 control-label"> District of Residence: <span
                                class="required ">*</span></label>

                        <div class="col-lg-7">
                            <div id="populate_districts">
                                <select name="district" class="form-control  ">
                                    <option value=""> [ Select District ]</option>
                                    <?php
                                        $sel =  set_value('district');
                                        foreach ($districts as $key => $value) {
                                            ?>
                                    <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                        value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                    <?php
                                        }
                                        ?>
                                </select>
                            </div>
                            <?php echo form_error('district'); ?>
                        </div>
                    </div>


                    <div class="form-group"><label class="col-lg-3 control-label">Nationality : <span
                                class="required ">*</span></label>

                        <div class="col-lg-7">
                            <select name="nationality" class="form-control select51 ">
                                <option value=""> [ Select Nationality ]</option>
                                <?php
                                $sel =  set_value('nationality',(isset($_GET['NT']) ? 220 :''));
                                foreach ($nationality_list as $key => $value) {
                                    ?>
                                <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                    value="<?php echo $value->id; ?>"><?php echo $value->Name; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <?php echo form_error('nationality'); ?>
                        </div>
                    </div>
                 

                    <div class="form-group"><label class="col-lg-3 control-label">Email : <span
                                class="required ">*</span> </label>

                        <div class="col-lg-7">
                            <input type="text" value="<?php echo set_value('email'); ?>" class="form-control"
                                name="email" id="email">
                            <?php echo form_error('email'); ?>
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-3 control-label">National Identification Number :<span
                                class="required ">*</span> 
                        </label>

                        <div class="col-lg-7">
                            <input type="text" value="<?php echo set_value('idnumber'); ?>" onKeyPress="return numbersonly(event,this.value)" maxlength="20" class="form-control"
                                name="idnumber" id="idnumber">
                            <?php echo form_error('idnumber'); ?>
                        </div>
                    </div>

                
                    <div
                        style="color: brown; font-weight: bold; margin-bottom: 15px; margin-top: 10px;  border-bottom: 1px solid brown; font-size: 15px;">
                        Login Credentials</div>

                    <div class="form-group"><label class="col-lg-3 control-label">Username : <span
                                class="required ">*</span> </label>

                        <div class="col-lg-7">
                            <input type="text" name="username" id="username"
                                value="<?php echo set_value('username'); ?>" class="form-control" readonly>
                            <div style="font-size: 11px;">N.B Username is your valid email address</div>
                            <?php echo form_error('username'); ?>
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-3 control-label">Password : <span
                                class="required ">*</span> </label>

                        <div class="col-lg-7">
                            <input type="password" value="" class="form-control" name="password">
                            <?php echo form_error('password'); ?>
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-3 control-label">Confirm Password : <span
                                class="required ">*</span> </label>

                        <div class="col-lg-7">
                            <input type="password" value="" class="form-control" name="conf_password">
                            <?php echo form_error('conf_password'); ?>
                        </div>
                    </div>
                    <div
                        style="color: brown; font-weight: bold; margin-bottom: 15px; margin-top: 10px;  border-bottom: 1px solid brown; font-size: 15px;">
                        <THIBITISHA></THIBITISHA>
                    </div>
                    <div class="form-group"><label
                            class="col-lg-4 control-label">Are you a human :<span
                                class="required ">*</span> </label>

                        <div class="col-lg-7">
                            <img src="<?php echo site_url('home/capture/'.$captcha_num); ?>" />
                            <input type="text" value=""
                                placeholder="<?php echo($_GET['type'] == 4)?'Andika tarakimu 6 unazoziona hapo juu':'Type six digit code as shown above'?>"
                                class="form-control" autocomplete="off" name="capture">
                            <?php echo form_error('capture'); ?>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 10px;">
                        <div class="col-lg-offset-5 col-lg-6">
                            <input class="btn btn-sm btn-success" type="submit" value="Save Information" />
                        </div>
                    </div>
                </div>


                <?php echo form_close(); ?>



            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {


        $("#cert_type").change(function () {
            var type_selected = $(this).children("option:selected").text();
            var value = $(this).val();
            if (value != 0) {
                $("#program_title").val(type_selected)
                $("#program_title").prop("readonly", true);
                $("#ntlevel_index").prop("placeholder", "E0125/0000/2005");
                $("#exam_authority1").val('NECTA');
                $("#exam_authority1").prop("readonly", true );
                $("#school1").prop("readonly", true );
                $("#completed_year1").prop("readonly", true );
                $("#gpa").prop("readonly", true );
                $("#ntlevel_index").val('');

                $("#sample_ntindex").show();
            } else {
                $("#exam_authority1").val('')
                $("#country1").val('220')
                $("#country1").val("").change();

                $("#exam_authority1").prop("readonly", false);
                $("#school1").prop("readonly", false );
                $("#completed_year1").prop("readonly", false );
                $("#gpa").prop("readonly", false );

                $("#gpa").val('');
                $("#completed_year1").val('');
                $("#school1").val('');
                $("#gpa").val('');
                $("#ntlevel_index").val('');

                $("#program_title").val('')
                $("#program_title").prop("readonly", false);
                $("#sample_ntindex").css('display', 'none');
                $("#ntlevel_index").prop("placeholder", "");

            }
 

        });

        $('.mydate_input').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            // endDate: "30-12-2007"
        });
        $('.mydate_input1').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",

        });


        $(".select50").select2({
            theme: 'bootstrap',
            placeholder: '[ Select Country ]',
            allowClear: true
        });
        $(".select51").select2({
            theme: 'bootstrap',
            placeholder: '[ Select Nationality ]',
            allowClear: true
        });
        $("#email").blur(function () {
            $('input[name="username"]').val(this.value);
            $("#username").prop("readonly", true);
        });


    })

    function checkYear(value_year, indexno, level) {

        if (value_year != "") {

            // alert(value_year + indexno + level);

            //alert("nipooo" + value_year + indexno);
            loadAjaxData(indexno, value_year, '', level);




        }

    }

    function loadAjaxData(value, target_field, get_focused_field, action) {
        if ($.trim(value) == '') {
            exit;
        }


        $.ajax({
            type: "post",
            url: "<?php echo site_url('loadEducationData') ?>",
            data: {
                target: target_field,
                id: value,
                ffocus: get_focused_field,
                action: action
            },
            datatype: "text",
            success: function (data) {
                var my_data_array;
                my_data_array = data.split("_");
                if (my_data_array.length == 1 && data.trim() != '') {
                    alert(data)
                }
                if (action == 'o-level') {

                    //alert(data);


                    if (my_data_array[0] == "EQ") {

                        $("#o_completed_year").prop("readonly", false);
                    } else {
                        $("#o_completed_year").prop("readonly", true);
                    }
                    if (my_data_array.length > 1) {
                        $("#firstname").val(my_data_array[0]);
                        $("#lastname").val(my_data_array[1]);
                        $("#middlename").val(my_data_array[2]);
                        $("#o_completed_year").val(my_data_array[3]);
                        $("#olevel_name").val(my_data_array[4]);
                        //alert($("#olevel_name").val())
                    }



                }
                if (action == 'a-level') {


                    if (my_data_array[0] == "EQ") {

                        $("#a_completed_year").prop("readonly", false);
                    } else {
                        $("#a_completed_year").prop("readonly", true);

                    }
                    if (data != "" && data != 'EQ') {
                        $("#school").val(my_data_array[0]);
                        $("#alevel_name").val(my_data_array[1]);
                        $("#a_completed_year").val(my_data_array[2]);
                        // alert($("#alevel_name").val())
                    }
                }



                if (action == 'avn') {


                    $("#institution").val(my_data_array[0]);
                    $("#alevel_name").val(my_data_array[1]);
                    //alert($("#alevel_name").val())

                }
                if (action == 'nt') {
                    $("#school1").val(my_data_array[0])
                    $("#completed_year1").val(my_data_array[2])
                    $("#gpa").val(my_data_array[1])
                }
            }
        });

    }


    function loadDistrict(value, target_field, get_focused_field, action) {
        $.ajax({
            type: "post",
            url: "<?php echo site_url('loadDistrict') ?>",
            data: {
                target: target_field,
                id: value,
                ffocus: get_focused_field,
                action: action
            },
            datatype: "text",
            success: function (data) {
                $("#" + target_field).html(data);
            }
        });

    }

    function loadVituo(value, target_field, get_focused_field, action) {

        $.ajax({
            type: "post",
            url: "<?php echo site_url('loadVituo') ?>",
            data: {
                target: target_field,
                id: value,
                ffocus: get_focused_field,
                action: action
            },
            datatype: "text",
            success: function (data) {

                $("#" + target_field).html(data);
            }
        });

    }
</script>