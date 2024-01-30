<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">
            <h5>Create Bill</h5>
            <div class=" pull-right"> <?php echo ' ' . form_error('amount'); ?></div>
            <font color="blue">
                <div id="payment-footer" align="center" style="font-size:25px; color:#006"></div>
            </font>
        </div>
    </div>

    <div class="ibox-content">

        <?php echo form_open_multipart(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>
        <input type="hidden" id="txtGrandTotal" name="amount"/>
        <input type="hidden" id="actual_amount" name="actual_amount"/>
        <input type="hidden" id="is_fixed" name="is_fixed" value="1"/>
        <div class="form-group" id="invoice_type_check"><label class="col-lg-4 control-label">Invoice Type : <span
                        class="required">*</span></label>
            <?php $sel = set_value('invoice_type'); ?>

            <?php
            $regno = @$_GET['regno'];
            $name = @$_GET['name'];
            if (isset($regno) and $regno != '') {

                ?>
                <div class="col-lg-7">
                    <select class="form-control select2_search1" style="width: 100%;" name="invoice_type"
                            id="invoice_type">
                        <option value="">Select Payer Category</option>
                        <option value="1" <?php echo ($sel == 1) ? "selected" : '' ?> >Student</option>
                    </select>
                    <?php echo form_error('invoice_type'); ?>
                </div>

                <?php
            } else {

                ?>
                <?php $sel = ($student_id) ? 1 : set_value('invoice_type');

                ?>
                <div class="col-lg-7"  >
                    <select class="form-control select2_search1" style="width: 100%;" name="invoice_type"
                            id="invoice_type"  >
                        <option value="">Select Payer Category</option>
                        <option value="1" <?php echo ($sel == 1) ? "selected" : '' ?> >Student</option>
<!--                        <option value="2" --><?php //echo ($sel == 2) ? "selected" : '' ?><!-->Individual</option>-->
                        <option value="3" <?php echo ($sel == 3) ? "selected" : '' ?>>Center</option>
<!--                        <option value="4" --><?php //echo ($sel == 4) ? "selected" : '' ?><!-->Sponsor</option>-->
                    </select>
                    <?php echo form_error('invoice_type'); ?>
                </div>
                <?php
            }
            ?>

        </div>

        <div id="reg_number" style="display: none" class="form-group"><label class="col-lg-4 control-label">Registration
                Number : <span class="required">*</span></label>
            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo ($student_id) ? $student_id : set_value('regno'); ?>"
                       class="form-control" name="regno" id="regno"
                       onblur="LoadStudentByRegNo(this.value)" <?php echo ($student_id) ? 'readonly' : '' ?> />
                <?php echo form_error('regno'); ?>


            </div>
        </div>


        <div id="sponsor">
            <div class="form-group"><label class="col-lg-4 control-label">Sponsor: <span
                            class="required">*</span></label>
                <?php $sel = set_value('sponsor_code'); ?>

                <div class="col-lg-7">
                    <select class="form-control select2_search1" style="width: 100%;" name="sponsor_code"
                            id="sponsor_code">
                        <option value="" selected>Select Sponsor</option>
                        <?php

                        $sponsor_list = $this->db->query("select * from sponsors ")->result();
                        foreach ($sponsor_list as $key => $value) {
                            echo '<option ' . ($sel == $value->code ? 'selected="selected"' : '') . ' value="' . $value->code . '">' . $value->name . '</option>';
                        }
                        ?>
                    </select>
                    <?php echo form_error('sponsor_code'); ?>

                </div>
            </div>
            <div class="form-group" id="specify_name" style="display: none"><label class="col-lg-4 control-label">Batch
                    Number : <span class="required">*</span></label>
                <div class="col-lg-7">
                    <input type="text"
                           value="<?php echo set_value('batch_number'); ?>"
                           class="form-control" name="batch_number" id="batch_number"/>
                    <?php echo form_error('batch_number'); ?>
                </div>
            </div>


            <div class="form-group">
                <div class="col-lg-5 col-lg-offset-4">
                    <a href="oas.iae.ac.tz/uploads/docs/Import_Sponsored_Student.xlsx">Download Template</a>
                </div>
            </div>

            <div class="form-group"><label class="col-lg-4 control-label">Students sponsored Sheet : </label>

                <div class="col-lg-7">
                    <input type="file" value="" class="form-control" name="studentfile">
                    <?php echo isset($upload_error) ? $upload_error : ''; ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-7 col-lg-offset-4">

                    <input class="btn btn-sm btn-warning pull-right" type="submit" value="Load Sponsored sheet"
                           name="loadsheet"/>

                </div>
            </div>
            <div style="color: brown; font-weight: bold; margin-bottom: 15px; margin-top: 10px;  border-bottom: 1px solid brown; font-size: 15px;">
                Sponsored Students
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <!--Dynamic table start here-->
                    <input type="hidden" id="txtGrandTotal" name="txtGrandTotal"/>
                    <div id="payment-footer" align="center" style="font-size:25px; color:#006"></div>
                    <table class="table table-bordered table-hover" id="tab_logic">
                        <thead>
                        <tr>
                            <th class="text-center">
                                #
                            </th>

                            <th class="text-center">
                                Regno
                                <?php echo form_error('pregno[]'); ?>

                            </th>
                            <th class="text-center">
                                Name
                                <?php echo form_error('name[]'); ?>

                            </th>

                            <th class="text-center">
                                Email
                            </th>
                            <th class="text-center">
                                Amount
                                <?php echo form_error('pamount[]'); ?>

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <input type="hidden" value="<?php echo count($students_sponsored)?>" name="no_of_rows">

                        <?php
                        $_SESSION['data']=$students_sponsored;
                        if (@$students_sponsored) {

                            $i = 0;
                            foreach ($students_sponsored as $key => $students) {
                                ?>

                                <input type="hidden" id="f4_index" name="f4_index[]" value="<?php echo $students['f4_index']; ?>">

                                <tr id='addr<?php echo $i ?>'>
                                    <td>

                                        <?php echo $i + 1; ?>
                                    </td>
                                    <td>

                                        <input type="text"
                                               value="<?php echo $students['regno'] ?>"
                                               class="form-control " id="regno_<?php echo $i; ?>" name="pregno[]"
                                               onblur="CheckRegNumber(this.value,this.id)" readonly/>

                                    </td>
                                    <td>
                                        <input type="text"
                                               value="<?php echo $students['name'] ?>"
                                               class="form-control " id="name_<?php echo $i; ?>" name="name[]"
                                               required="required" readonly/>

                                    </td>
                                    <td>

                                        <input type="text"
                                               value="<?php echo $students['email'] ?>"
                                               class="form-control " id="pemail_<?php echo $i; ?>" name="pemail[]"
                                               readonly/>

                                    </td>

                                    <td>

                                        <input type="text"
                                               value="<?php echo $students['amount'] ?>"
                                               class="form-control payment" id="pamount_<?php echo $i; ?>"
                                               name="pamount[]" onblur="GranTotal()"
                                               onKeyPress="return numbersonly(event,this.value)" readonly/>

                                    </td>


                                </tr>
                                <?php
                                $i = $i + 1;
                                $i_row = $i;
                            } ?>
                            <tr id='addr<?php echo $i; ?>'></tr>

                            <?php

                        } else {
                            ?>
                            <tr id='addr0'>


                                <td>
                                    1
                                </td>

                                <td>

                                    <input type="text"
                                           value=""
                                           class="form-control " id="regno_0" name="pregno[]"
                                           onblur="CheckRegNumber(this.value,this.id)"/>

                                </td>

                                <td>
                                    <input type="text"
                                           value=""
                                           class="form-control " id="name_0" name="name[]" required="required"
                                           readonly/>

                                </td>


                                <td>

                                    <input type="text"
                                           value=""
                                           class="form-control " id="pemail_0" name="pemail[]"/>

                                </td>
                                <td>

                                    <input type="text"
                                           value=""
                                           class="form-control payment" id="pamount_0" name="pamount[]"
                                           onblur="GranTotal()" onKeyPress="return numbersonly(event,this.value)"/>

                                </td>


                            </tr>
                            <tr id='addr1'></tr>
                        <?php } ?>
                        </tbody>
                    </table>

                <?php  if (!@$students_sponsored) {?>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="Content"></label>
                        <div class="col-sm-8 ">
                            <a id="add_row_openstock" class="btn btn-default pull-left">Add ++ Student</a><a
                                    id='delete_row_openstock' class="pull-right btn btn-default">Delete -- Student </a>
                        </div>
                    </div>

                <?php }?>
                    <!--Dynamic table end here-->

                </div>
            </div>




        </div>


        <div id="non_sponsor">

            <div id="fee_category_check" style="display: none" class="form-group" >
                <label class="col-lg-4 control-label">Fee Category : <span class="required">*</span></label>
                <?php $sel = set_value('fee_category'); ?>

                <div class="col-lg-7">
                    <select class="form-control select2_search1" style="width: 100%;display: " name="fee_category"
                            id="fee_category" onchange="GetFeeByCategory(this.value)">
                        <option value="" selected>Select Fee Category</option>
                        <?php

                        foreach (NTA_Fee_Categories() as $key => $value) {
                            echo '<option ' . ($sel == $key ? 'selected="selected"' : '') . ' value="' . $key . '">' . $value . '</option>';
                        }

                        ?>
                    </select>
                    <?php echo form_error('fee_category'); ?>
                </div>
            </div>
            <div id="txtFeeName_check" class="form-group"><label class="col-lg-4 control-label">Select Fee : <span
                            class="required">*</span></label>
                <div class="col-lg-7">
                    <div id="fee_by_category">
                        <select class=" form-control select2_search1" style="width: 100%;" name="txtFeeName"
                                id="txtFeeName" onchange="ShowAmount(this.value,'txtGrandTotal')">
                            <option value="">Select Fee</option>
                            <?php
                            $sel = set_value('txtFeeName');
                            $fee_list = $this->db->query("select * from fee_structure where fee_category=0 and hidden=0")->result();
                            if ($fee_structure) {
                                $fee_list = $fee_structure;
                            }

                            foreach ($fee_list as $key => $value) { ?>
                                <option <?php echo($sel == $value->id . '_' . $value->amount . '_' . $value->percentage . '_' . $value->fixed . '_' . $value->name . '_' . $value->parcentage_value ? 'selected="selected"' : ''); ?>
                                        value="<?php echo $value->id . '_' . $value->amount . '_' . $value->percentage . '_' . $value->fixed . '_' . $value->name . '_' . $value->parcentage_value; ?>"><?php echo $value->name; ?></option>
                                <?php

                            }
                            ?>
                        </select>
                    </div>
                    <?php echo form_error('txtFeeName'); ?>
                </div>
            </div>
            <div id="nta_level_check" style="display: none" class="form-group"><label class="col-lg-4 control-label">Center
                    : <span class="required">*</span></label>
                <?php $sel = set_value('nta_level'); ?>

                <div class="col-lg-7">
                    <select class="form-control select2_search1" style="width: 100%;" name="nta_level" id="nta_level"
                            onchange="LoadFeeBYNTALevel(document.getElementById('fee_category').value,this.value,'txtGrandTotal')"
                    >
                        <option value="" selected>Select Center</option>

                        <?php
                        $centers = $this->db->query("select * from Center")->result();

                        foreach ($centers as $key => $value) {
//                    foreach ($program as $key=>$value ){
                            echo '<option ' . ($sel == $value->CenterRegNo ? 'selected="selected"' : '') . ' value="' .  $value->CenterRegNo . '">' .  $value->CenterName . '</option>';
                        }
                        ?>
                    </select>
                    <?php echo form_error('nta_level'); ?>
                </div>
            </div>
            <div id="show_percentage" style="display:none">
                <div class="form-group"><label class="col-lg-4 control-label">Percentage to Pay : <span
                                class="required">*</span></label>
                    <div class="col-lg-7">
                        <select name="percentage" id="percentage" class="form-control  "
                                onchange="CalculatePercentage(this.value)">
                            <option value="" selected>Select percentage</option>
                            <option value="100">100%</option>

                        </select>

                    </div>
                </div>
            </div>
            <div class="form-group" id="specify_name" style="display: none"><label class="col-lg-4 control-label">Fee
                    Name : <span class="required">*</span></label>
                <div class="col-lg-7">
                    <input type="text"
                           value="<?php echo set_value('specify_name'); ?>"
                           class="form-control" name="specify_name" id="fee_name"/>
                    <?php echo form_error('specify_name'); ?>
                </div>
            </div>
            <div class="form-group" id="specify_amount" style="display: none">
                <label class="col-lg-4 control-label">Fee Amount : <span class="required">*</span></label>
                <div class="col-lg-7">
                    <input type="text"
                           value="<?php echo set_value('specify_amount'); ?>"
                           class="form-control" name="specify_amount" id="fee_amount"
                           onKeyPress="return numbersonly(event,this.value)" onblur="currentfeeamount(this.value)"/>
                    <?php echo form_error('specify_amount'); ?>
                </div>
            </div>
            <?php
            if ($regno) { ?>
                <div id="reg_number" style="display: none" class="form-group"><label class="col-lg-4 control-label">Registration
                        Number : <span class="required">*</span></label>
                    <div class="col-lg-7">
                        <input type="text"
                               value="<?php echo $regno; ?>"
                               class="form-control" name="regno" onblur="LoadStudentByRegNo(this.value)"/>
                        <?php echo form_error('regno'); ?>
                    </div>

                </div>
            <?php } else { ?>



            <?php } ?>
            <div id="institution_name" style="display: none" class="form-group"><label class="col-lg-4 control-label">Center
                    Name : <span class="required">*</span></label>
                <div class="col-lg-7">
                    <select name="institutionname" id="institutionname" class="form-control">
                        <option value="" selected>Select Center</option>
                        <?php
                        $sel = set_value('institutionname');
                        // $program = $this->db->query("select * from Center")->result();
                        $program =  $this->db->query("select * from application where application_category='Center' and submitted='3' or submitted='5'")->result();
                        foreach ($program as $key => $value) {
                            echo '<option ' . ($sel == $value->CenterRegNo ? 'selected="selected"' : '') . ' value="' . $value->CenterRegNo . '">' . $value->CenterName . '</option>';
                        }
                        ?>
                    </select>
                    <?php echo form_error('institutionname'); ?>
                </div>
            </div>
            <?php
            //if(!$regno){
            ?>
            <div id="first_name" style="display: none" class="form-group"><label class="col-lg-4 control-label">Fist
                    Name : <span class="required">*</span></label>


                <div class="col-lg-7">
                    <input type="text"
                           value="<?php
                           echo ($f_name) ? $f_name : set_value('firstname');
                           ?>"
                           class="form-control" name="firstname" id="firstname"/>
                    <?php echo form_error('firstname'); ?>
                </div>
            </div>


            <div id="other_name" style="display: none" class="form-group"><label class="col-lg-4 control-label">Other
                    Name : <span class="required"></span></label>
                <div class="col-lg-7">
                    <input type="text"
                           value="<?php echo ($m_name) ? $m_name : set_value('othername'); ?>"
                           class="form-control" name="othername" id="othername"/>
                    <?php echo form_error('othername'); ?>
                </div>
            </div>

            <div id="sur_name" style="display: none" class="form-group"><label class="col-lg-4 control-label">Surname :
                    <span class="required"></span></label>


                <div class="col-lg-7">
                    <input type="text"
                           value="<?php echo ($s_name) ? $s_name : set_value('surname'); ?>"
                           class="form-control" name="surname" id="surname"/>
                    <?php echo form_error('surname'); ?>
                </div>
            </div>

            <?php //} ?>

            <div class="form-group"><label class="col-lg-4 control-label">Email : <span class="required"></span></label>
                <div class="col-lg-7">
                    <input type="text"
                           value="<?php echo ($Email) ? $Email : set_value('email'); ?>"
                           class="form-control" name="email" id="email"/>
                    <?php echo form_error('email'); ?>
                </div>
            </div>

            <div class="form-group"><label class="col-lg-4 control-label">Mobile : <span
                            class="required">*</span></label>
                <div class="col-lg-7">
                    <input type="text"
                           value="<?php echo ($Phone) ? $Phone : set_value('mobile'); ?>"
                           class="form-control" name="mobile" id="mobile" placeholder="Eg. 0xxxxxxxxx"
                           onKeyPress="return numbersonly(event,this.value)" maxlength="10"/>
                    <?php echo form_error('mobile'); ?>
                </div>
            </div>

            <div class="form-group"><label class="col-lg-4 control-label">Address : <span
                            class="required"></span></label>
                <div class="col-lg-7">
                    <input type="text"
                           value="<?php echo set_value('address'); ?>"
                           class="form-control" name="address"/>
                    <?php echo form_error('address'); ?>
                </div>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-4 control-label">Description : <span
                        class="required"></span></label>
            <div class="col-lg-7">
                <textarea name="description" rows="3" cols="87"
                          class="form-control"><?php echo set_value('description'); ?></textarea>
                <?php echo form_error('description'); ?>
            </div>
        </div>


        <div class="form-group" id="sponsor_amount_chek" style="display: none"><label class="col-lg-4 control-label">
                Sponsor Amount : </label>
            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo set_value('sponsor_amount'); ?>"
                       class="form-control" name="sponsor_amount" id="sponsor_amount" readonly/>
                <?php echo form_error('sponsor_amount'); ?>
            </div>
        </div>

        <div class="form-group" style="margin-top: 10px;">
            <div class=" col-lg-12">
                <!-- add a back button -->
                <input class="btn btn-sm btn-success pull-left" onclick="goBack()" value="Cancel & Go Back"/>
                <!-- add a Get Control button -->
                <input class="btn btn-sm btn-success pull-right" type="submit" value="Get Control Number"/>
            </div>
        </div>

        <!-- add a back button -->
        <script>
            function goBack() {
                window.history.back();
            }
        </script>


        <?php echo form_close(); ?>


        <br/>

        <br/><br/>
        <br/><br/>
    </div>
</div>

<script>

    function LoadStudentByRegNo(regno) {

        $.ajax({
            type: "post",
            url: "<?php echo site_url('LoadStudentDetailsByID') ?>",
            data: {
                regno: regno,
            },
            datatype: "text",
            success: function (data) {
//alert(data)

                my_data_array = data.split("_");
                if (my_data_array[0] == 0 && my_data_array.length > 1) {
                    $("#regno").val('');
                    $("#firstname").val('');
                    $("#othername").val('');
                    $("#surname").val('');
                    $("#regno").focus();

                } else {

                    var fullname = my_data_array[1].split(", ");

                    var first_name_midle_name = fullname[1].split(" ")

                    // alert(first_name_midle_name[0])

                    $("#firstname").val(first_name_midle_name[0]);
                    $("#othername").val(first_name_midle_name[1]);
                    $("#surname").val(fullname[0]);
                    $("#mobile").val(my_data_array[2]);
                    $("#email").val(my_data_array[3]);
                    var sponsored_amount = my_data_array[4];
                    $("#sponsor_amount").val(sponsored_amount);
                    window.location.replace(' <?php  echo site_url('student_create_invoice') ?>/' + my_data_array[6] );
                    //alert($("#txtGrandTotal").val());
                    var invoice_amount = ($("#txtGrandTotal").val() - sponsored_amount);
                    $("#txtGrandTotal").val(invoice_amount.toFixed(0));
                    $("#fee_amount").val(invoice_amount);
                    $("#payment-footer").html("Bill Amount=" + addCommas(invoice_amount.toFixed(0)));
                }


            }
        });

    }

    $(document).ready(function () {
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
    });


    var i = 1;

    var i = $('table#tab_logic tr:last').index();
    $("#add_row_openstock").click(function () {

        $('table#tab_logic tr:last').index()
        var currenttable;

        currenttable = "<td>" +
            '<input type="text" class="form-control" id="regno_' + i + '" name="pregno[]"      onblur="CheckRegNumber(this.value,this.id)" />'
            + "</td>"

        currenttable += "<td>" +
            '<input type="text" class="form-control" id="name_' + i + '" name="name[]"   required="required" readonly />'


        currenttable += "<td>" +
            '<input type="text" class="form-control" id="pemail_' + i + '" name="pemail[]"     />'
            + "</td>"

        currenttable += "<td>" +
            '<input type="text" class="form-control payment" id="pamount_' + i + '" name="pamount[]"   onKeyPress="return numbersonly(event,this.value)" onblur="GranTotal()"    />'
            + "</td>"


        $('#addr' + i).html("<td>" + (i + 1) + "</td>" + currenttable);


        $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
        i++;


    });
    $("#delete_row_openstock").click(function () {
        if (i > 1) {
            $("#addr" + (i - 1)).html('');
            i--;
        }
        GranTotal()
    });


    $("#add_row_openstock1").click(function () {

        $('table#tab_logic1 tr:last').index()
        var currenttable;


        currenttable = "<td>" +
            '<select  name="txtFeeName[]"  id="txtFeeName_' + i + '" class="form-control select2" style="width: 100%;" onchange=\'ShowAmount(this.value,"txtAmount_' + i + '")\' required></select>'

        currenttable += "<td>" +
            '<input type="text" class="form-control payment" id="txtAmount_' + i + '" name="txtAmount[]"  onblur=\'loadAjaxData(this.value,"txtUnit_' + i + '","txtItemName_' + i + '","oppenitemid","txtQuantity_' + i + '")\'  required="required" readonly/>'
            + "</td>"


        $('#addr' + i).html("<td>" + (i + 1) + "</td>" + currenttable);

        var $options = $("#txtFeeName_0 > option").clone();
        $('#txtFeeName_' + i).append($options);


        $('#tab_logic1').append('<tr id="addr' + (i + 1) + '"></tr>');
        i++;
        $('.select2').select2();

    });
    $("#delete_row_openstock1").click(function () {
        if (i > 1) {
            $("#addr" + (i - 1)).html('');
            i--;
        }
        GranTotal();
    });

    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }


    function CalculatePercentage(percentage) {

        if (!isNaN(percentage)) {
            amount = parseFloat($("#actual_amount").val());
            percentage = parseFloat(percentage);
            amount = parseFloat((amount * percentage) / 100);
            $("#payment-footer").html("Total Amount=" + addCommas(amount.toFixed(0)));

            $("#txtGrandTotal").val(amount.toFixed(0));
        }
    }

    function GranTotal(amount) {

        var sum = 0;
        //Loop through all the textboxes of datatable and make sum of the values of it.
        $(".payment").each(function () {
            sum = sum + parseFloat($(this).val());
        });
        //Replace the latest sum.
        if (!isNaN(sum)) {
            $("#payment-footer").html("Total Amount=" + addCommas(sum.toFixed(0)));

            $("#txtGrandTotal").val(sum.toFixed(0));
        }

        // alert(amount)
        if (!isNaN(amount)) {
            amount = parseFloat(amount)
            $("#payment-footer").html("Bill Amount=" + addCommas(amount.toFixed(0)));
            $("#txtGrandTotal").val(amount.toFixed(0));
        }
        // alert($("#txtGrandTotal").val());
    }


    function ShowAmount(data, amount_field) {
        var my_data_array;
        my_data_array = data.split("_");
        my_array_field = amount_field.split("_");
        var already;
        var i;
        already = 0;
        if (my_array_field[1] >= 1) {

            for (i = 0; i < my_array_field[1]; i++) {

                if ($("#txtFeeName_" + i).val() == data) {

                    already = 1;
                    break;
                }

            }


            if (already == 0) {
                $("#" + amount_field).val(my_data_array[1]);
            } else {
                already = 0;
            }

        } else {
            $("#" + amount_field).val(my_data_array[1]);
        }

        if (my_data_array[2] == 1) {
            $('#show_percentage').show();
        } else {
            $('#show_percentage').css('display', 'none');
        }


        $("#actual_amount").val(my_data_array[1]);
        $("#fee_amount").val(my_data_array[1]);

        GranTotal(my_data_array[1]);

        if (my_data_array[3] != 1) {
            $('#specify_amount').show();
            $('#specify_name').show();
            $('#is_fixed').val(0);

            $('#fee_name').val(my_data_array[4]);

        } else {
            $('#specify_amount').css('display', 'none');
            $('#is_fixed').val(1);
            $('#specify_name').val('');
            $('#specify_name').css('display', 'none');

            //added to accomodate 2020 payments
            $('#specify_amount').show();

        }
    }


    $(document).ready(function () {


        $("#invoice_type").change(function () {


            var invoice_type = $(this).val();

            if (invoice_type == 4) {
                $('#sponsor').show();
                $('#non_sponsor').css('display', 'none');
            } else {
                $('#non_sponsor').show();
                $('#sponsor').css('display', 'none');
            }

            if (invoice_type == 1) {
                $('#firstname').prop("readonly", true);
                $('#othername').prop("readonly", true);
                $('#surname').prop("readonly", true);

            } else {
                $('#firstname').prop("readonly", false);
                $('#othername').prop("readonly", false);
                $('#surname').prop("readonly", false);

            }


            if (invoice_type == 3) {
                $('#institution_name').show();
                $('#first_name').css('display', 'none');

                $('#other_name').css('display', 'none');
                $('#sur_name').css('display', 'none');
                $('#reg_number').css('display', 'none');
                $('#fee_category_check').css('display', 'none');
                $('#nta_level_check').css('display', 'none');
                GetFeeByCategory(0);
            } else if (invoice_type == 1 || invoice_type == 2) {

                $('#institution_name').css('display', 'none');
                $('#first_name').show();
                $('#other_name').show();
                $('#sur_name').show();
                $('#sponsor_amount_chek').show();
                $('#reg_number').show();
                ;
                $('#fee_category_check').show();
                $('#nta_level_check').show();
                $('#fee_category').val("");


                if (invoice_type == 2) {

                    $('#reg_number').css('display', 'none');
                    $('#fee_category_check').css('display', 'none');
                    $('#nta_level_check').css('display', 'none');
                    $('#sponsor_amount_chek').css('display', 'none');
                    GetFeeByCategory(0);

                } else {
                    GetFeeByCategory('');

                }

            }


        })

        $("#fee_category").change(function () {
            var value = $(this).val();
            if (value == 0) {
                $('#nta_level_check').css('display', 'none');
                $("#nta_level").val("");
                $("#txtFeeName_check").show();
                $('#specify_name').show();
                $('#specify_amount').show();


            } else {
                $('#nta_level_check').show();
                $('#txtFeeName_check').css('display', 'none');
                $('#specify_name').css('display', 'none');
                $('#specify_amount').css('display', 'none');

                //added to accomodate 2020-payment
                $('#specify_amount').show();



                $('#is_fixed').val(1);
                $('#specify_name').val('');


            }
            $("#percentage").val("");
            $("#nta_level").val("");

        })


        $("#txtFeeName").change(function () {


            var value = $(this).val();
            var my_data_array;
            my_data_array = value.split("_");
            if (my_data_array[3] != 1) {
                $('#specify_amount').show();
                $('#specify_name').show();
                $('#is_fixed').val(0);

                $('#fee_name').val(my_data_array[4]);

            } else {
                $('#specify_amount').css('display', 'none');
                //added to accomodate 2020/2021 payment
                $('#specify_amount').show();

                $('#is_fixed').val(1);
                $('#specify_name').val('');
                $('#specify_name').css('display', 'none');

            }

        })


        var value = $("#txtFeeName").val();
        var my_data_array;
        my_data_array = value.split("_");

        if (my_data_array[3] != 1) {
            $('#specify_amount').show();
            $('#specify_name').show();
            $('#is_fixed').val(0);

            $('#fee_name').val(my_data_array[4]);

        } else {
            $('#specify_amount').css('display', 'none');
            //added to accomodate 2020/2021 payment
            $('#specify_amount').show();
            $('#is_fixed').val(1);
            $('#specify_name').val('');
            $('#specify_name').css('display', 'none');

        }

        var invoice_type = $("#invoice_type").val();


        if (invoice_type == 1) {
            $('#firstname').prop("readonly", true);
            $('#othername').prop("readonly", true);
            $('#surname').prop("readonly", true);

        } else {
            $('#firstname').prop("readonly", false);
            $('#othername').prop("readonly", false);
            $('#surname').prop("readonly", false);

        }

        if (invoice_type == 3) {

            $('#institution_name').show();
            $('#first_name').css('display', 'none');
            $('#other_name').css('display', 'none');
            $('#sur_name').css('display', 'none');
            $('#reg_number').css('display', 'none');

        } else if (invoice_type == 1 || invoice_type == 2) {
            $('#institution_name').css('display', 'none');
            $('#first_name').show();
            $('#other_name').show();
            $('#sur_name').show();
            $('#reg_number').show();
            <?php
            if(!$fee_structure){ ?>
            $('#fee_category_check').show();

            <?php }else{
                ?>
            $('#invoice_type_check').css('display', 'none');

        <?php
        } ?>
            $('#nta_level_check').show();


            if (invoice_type == 2) {
                $('#fee_category_check').css('display', 'none');
                $('#nta_level_check').css('display', 'none');
                <?php
                if($regno){ ?>
                $('#reg_number').prop("readonly", true);
                <?php }else{ ?>
                $('#reg_number').css('display', 'none');
                <?php } ?>


            }

        }


        if (invoice_type == 4) {

            $('#sponsor').show();
            $('#non_sponsor').css('display', 'none');
        } else {

            $('#non_sponsor').show();
            $('#sponsor').css('display', 'none');
        }

        var categoryvalue = $("#fee_category").val();
        if (categoryvalue == 0) {

            $('#nta_level_check').css('display', 'none');
            $("#nta_level").val("");
            $('#txtFeeName_check').show();
            $('#specify_name').show();
            $('#specify_amount').show();

        } else {
            $('#nta_level_check').show();
            $('#txtFeeName_check').css('display', 'none');
            $('#specify_name').css('display', 'none');
            $('#specify_amount').css('display', 'none');
            //added to accomodate 2020 payment
            $('#specify_amount').show();

            $('#is_fixed').val(1);

        }


        //id="txtFeeName"  onchange="ShowAmount(this.value,'txtGrandTotal')
        //var invoice_type = $("#invoice_type").val();
        var invoice_amount = $("#txtFeeName").val();
        if (invoice_amount != '')
            ShowAmount(invoice_amount, 'txtGrandTotal')


    });

    function currentfeeamount(amount) {
        amount = $.trim(amount)
        if (!isNaN(amount)) {

            amount = parseFloat(Number(amount))
            $("#txtGrandTotal").val(amount.toFixed(0));
            $("#payment-footer").html("Bill Amount=" + addCommas(amount.toFixed(0)));


        }
    }


    function GetFeeByCategory(value) {

        $.ajax({
            type: "post",
            url: "<?php echo site_url('GetFeeByCategory') ?>",
            data: {
                category: value,
            },
            datatype: "text",
            success: function (data) {

                $("#fee_by_category").html(data);


            }
        });

    }


    function LoadFeeBYNTALevel(category, ntlevel, amount_field) {

        $.ajax({
            type: "post",
            url: "<?php echo site_url('LoadFeeBYNTALevel') ?>",
            data: {
                category: category,
                ntlevel: ntlevel
            },
            datatype: "text",
            success: function (data) {


                if (category != 0) {

                    var data_array = data.split("_");
                    if (category == 4) {
                        $("#txtGrandTotal").val((parseFloat(data_array[0]) + parseFloat(data_array[3])));
                        $("#actual_amount").val((parseFloat(data_array[0]) + parseFloat(data_array[3])));
                        GranTotal((parseFloat(data_array[0]) + parseFloat(data_array[3])));

                    } else {
                        $("#txtGrandTotal").val(data_array[0]);
                        $("#actual_amount").val(data_array[0]);
                        GranTotal(data_array[0]);

                    }
                    if (data_array[1] == 1) {
                        $("#percentage").empty();
                        var passentage_array = data_array[2].split(",");
                        $('#percentage').append($("<option />").val(100).text("100%"));

                        for (i = 0; i < passentage_array.length; i++) {
                            $('#percentage').append($("<option />").val(passentage_array[i]).text(passentage_array[i] + "%"));

                        }
                        $('#show_percentage').show();

                    } else {
                        $('#show_percentage').css('display', 'none');

                    }

                }


            }
        });

    }


    function CheckRegNumber(value, pid) {
        $.ajax({
            type: "post",
            url: "<?php echo site_url('LoadStudentDetailsByID') ?>",
            data: {

                regno: value

            },
            datatpidype: "text",
            success: function (data) {
                my_data_array = pid.split("_");
                array_result = data.split("_");

                if (array_result[0] != 0) {
                    $("#name_" + my_data_array[1]).val(array_result[1]);
                    $("#pemail_" + my_data_array[1]).val(array_result[3]);
                } else {
                    $("#regno_" + my_data_array[1]).val('');
                    $("#name_" + my_data_array[1]).val('');
                    $("#pemail_" + my_data_array[1]).val('');
                }


            }


        });

    }


    '<?php
        if($students_sponsored)
        {?>'

    GranTotal();
    ' <?php    }
        ?>'
</script>


