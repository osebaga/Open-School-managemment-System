
<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">
            <h5>Education Level</h5>

            <?php
            if ($APPLICANT->status == 0) {
                if (!isset($_GET['action'])) {
                    ?>

                    <a class="pull-right btn btn-warning btn-small btn-sm" style="margin-top: -10px;"
                       href="<?php echo site_url('center_education'); ?>/?action=new">Add Teaching and Learning Materials</a>
                    <?php
                } else {
                    ?>
                    <a class="pull-right btn btn-warning btn-small btn-sm" style="margin-top: -10px;"
                       href="<?php echo site_url('center_education'); ?>">Cancel Changes</a>
                    <?php
                }
            }

            ?>
        </div>
    </div>

    <div class="ibox-content">
        <?php
        if (!$this->uri->segment(2) && !isset($action)) {
            echo 'Use button  at the top right side to add education background. Make sure you add all certificate you have';
        }
        ?>
        <style>
            #mytable thead tr th {
                background-color: transparent;
                font-weight: bold;
            }

            .mytable2_educatiobbg {
                margin-left: 20px;
            }

            .mytable2_educatiobbg tr th, .mytable2_educatiobbg tr td {
                padding: 4px;;
            }
        </style>

        <?php
        if (isset($action)) {
            echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid myform"') ?>
            <div style=" color: brown; font-weight: bold; border-bottom: 1px solid brown; margin-bottom: 10px;">
                PLEASE FILL FORM BELOW
            </div>
            <div class="form-group"><label class="col-lg-4 control-label">Administrator of the Open School : <span
                            class="required">*</span></label>
                <div class="col-lg-8">
                    <select name="certificate" id="certificate" class="form-control">
                        <option value=""> [ Select Item ]</option>
                        <?php
                        $sel = set_value('certificate', (isset($education_info_disable) ? $education_info_disable->certificate : ''));
                        foreach (administrator() as $key => $value) {
                            ?>
                            <option <?php echo($sel == $key ? 'selected="selected"' : ''); ?>
                                    value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <?php echo form_error('certificate'); ?>
                </div>
            </div>

            <div class="school">

                <div class="form-group"><label class="col-lg-4 control-label">Name : <span
                                class="required">*</span></label>

                    <div class="col-lg-8">
                        <input type="text"
                               value="<?php echo set_value('exam_authority1', (isset($education_bg) ? $education_info_disable->exam_authority : '')); ?>"
                               class="form-control" name="exam_authority1" >
                        <?php echo form_error('exam_authority1'); ?>
                    </div>
                </div>

                <div class="form-group"><label class="col-lg-4 control-label">Phone Number : <span
                                class="required">*</span></label>

                    <div class="col-lg-8">
                        <input type="text"
                               value="<?php echo set_value('division1', (isset($education_info_disable) ? $education_info_disable->division : '')); ?>"
                               class="form-control" name="division1" onKeyPress="return numbersonly(event,this.value)" maxlength="10" placeholder="0...">
                        <?php echo form_error('division1'); ?>
                    </div>
                </div>
                <div class="form-group"><label class="col-lg-4 control-label">Education Level : <span
                                class="required">*</span></label>

                    <div class="col-lg-8">
                        <input type="text"
                               value="<?php echo set_value('school1', (isset($education_info_disable) ? $education_info_disable->school : '')); ?>"
                               class="form-control" name="school1">
                        <?php echo form_error('school1'); ?>
                    </div>
                </div>

            </div>


            <!-- <div class="session">
            <div class="form-group"><label class="col-lg-4 control-label">Teaching and Learning Session : <span
                            class="required">*</span></label>

                <div class="col-lg-8">
                    <select name="country1" id="country1" class="form-control select50 ">
                        <option value=""> [ Select Session ]</option>
                        <?php
                        $sel = set_value('country1', (isset($education_info_disable) ? $education_info_disable->country : ''));
                        foreach (learning_session() as $key => $value) {
                            ?>
                            <option <?php echo($sel == $key ? 'selected="selected"' : ''); ?>
                                    value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php
                        }
                        ?>
                    </select>

                    <?php echo form_error('country1'); ?>
                </div>
            </div>
            </div> -->

            <div id="subject_list_div">

                <br/>

                <?php
                echo form_error('subject[]');
                echo form_error('grade[]');
                echo form_error('year[]');
                ?>
                <div style="margin-bottom: 15px; color: green; font-weight: bold;">
                    Please add all Courses/Skills Offered Under Integrated Post-Primary Education Programme- IPPE. Click <span
                            style="color: red;">+Add Row</span> to add more rows and <span style="color: red;">--Delete Row</span>
                    to remove row. <br/>
                    (Name of Course or Subject Under the following Learning Components)

                </div>
                <table class="table table-bordered" id="mytable">
                    <thead>
                    <th style="width: 50px;">#</th>
                    <th style="width: 200px; text-align: center;">Pre-vocational Courses</th>
                    <th style="width: 200px; text-align: center;">Academic Subjects</th>
                    <th style="width: 150px; text-align: center;">Generic Skills</th>
                    <?php if ($APPLICANT->status == 0 && isset($_GET) && isset($_GET['id'])) { ?>
                        <th style="width: 80px;">Action</th>
                    <?php } ?>
                    </thead>
                    <tbody>
                    <?php
                    $sno = 1;
                    if (isset($_GET) && isset($_GET['id'])) {
                        $subject_saved = $this->applicant_model->get_education_subject($education_info_disable->applicant_id, $education_info_disable->id);
                        foreach ($subject_saved as $k => $v) {
                            ?>
                           <tr>
                                <td style="vertical-align: middle; text-align: center"><?php echo($k + 1); ?></td>
                                <td style="text-align: center"><?php echo $v->grade; ?></td>

                                <td><?php echo get_value('secondary_subject', $v->subject, 'name'); ?></td>
                                <td style="text-align: center"><?php echo $v->year; ?></td>
                                <?php if ($APPLICANT->status == 0) { ?>
                                    <td>
                                        <a href="<?php echo site_url('center_education/' . encode_id($APPLICANT->id)); ?>/?row_id=<?php echo encode_id($v->id); ?>"
                                           class="remove_delete"><i class="fa fa-remove"></i> Remove</a></td>
                                <?php } ?>
                            </tr>
                            <?php $sno++;
                        }
                    }
                    if ($sno == 1) {
                        ?>
                 <tr id="addr0">
                            <td style="vertical-align: middle; text-align: center;"><?php echo $sno; ?></td>
                            <td><input type="text" name="grade[]" class="form-control"/></td>

                            <td>
                                <select name="subject[]" style="width: 300px;" class="form-control select34">
                                    <option value=""></option>
                                    <?php foreach ($subject_list as $subkey => $subvalue) { ?>
                                        <option value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name . ' [ ' . $subvalue->shortname . ' ]' ?></option>
                                    <?php } ?>
                                </select></td>

                            <td><input type="text" name="year[]" class="form-control"/></td>
                        </tr>
                    <?php } ?>
                    <tr id="addr1"></tr>
                    </tbody>
                </table>
                <div class="clearfix">
                    <a id='delete_row' class="pull-left" style="font-weight: bold;"> <i class="fa fa-minus"></i>
                        Delete Row</a> <a id="add_row" class="pull-right" style="font-weight: bold;"> <i class="fa
                        fa-plus"></i> Add Row</a>
                </div>

            </div>

            <script>
                $(document).ready(function () {
                    $("#certificate").change(function () {
                        var certificate = $("#certificate").val();
                        if (certificate == 4) {
                            $(".session").hide();
                            $("#subject_list_div").show();
                            $(".school").hide();

                        } else{
                            $("#subject_list_div").hide();
                            $(".session").show();
                            $(".school").show();

                        }
                   
                    });

                });
            </script>

            <div style=" color: brown; font-weight: bold; border-bottom: 1px solid brown; margin-bottom: 5px;">
                &nbsp;
            </div>

            <div class="form-group">
                <div class="col-lg-10 clearfix">
                    <?php if ($APPLICANT->status == 0) { ?>
                        <input class="btn  btn-success pull-right" type="submit"
                               value="Save Information"/>
                    <?php } ?>
                </div>
            </div>

            <?php echo form_close();
        }


        foreach ($education_bg as $rowkey => $rowvalue) {
            ?>

            <div class="center_education_bg" style="margin-bottom: 50px;">

                <div style="font-size: 14px; border-bottom: 1px solid brown; color: brown; font-weight: bold;"><?php echo administrator($rowvalue->certificate); ?></div>

                <div class="education_div_data" id="divNo<?php echo $rowvalue->id; ?>"
                     RID="<?php echo $rowvalue->id; ?>" WAIT="<?php echo $rowvalue->hide; ?>">
                   <?php if($rowvalue->certificate != 4){ ?>
                     <table class="mytable2_educatiobbg">

                        <tr>
                            <th>Name :</th>
                            <td><?php echo $rowvalue->exam_authority; ?></td>
                        </tr>
                
                        <tr>
                            <th> Phone Number :</th>
                            <td><?php echo $rowvalue->division; ?></td>
                        </tr>
                        <tr>
                            <th>Education Level :</th>
                            <td><?php echo $rowvalue->school; ?></td>
                        </tr>
                        <!-- <tr>
                            <th>Teaching and Learning Session :</th>
                            <td><?php echo learning_session($rowvalue->country); ?></td>
                        </tr> -->

       
                    </table>
                    <?php } ?>
                    <br/>
                <?php

                    if ($rowvalue->certificate == 4) {
                        ?>
                        <strong>SOME OF SUBJECT PERFORMED</strong>
                        <br/>
                        <table cellpadding="0" cellspacing="0" class="table table-bordered"
                               id="mytable" style="width: ">
                            <thead>
                            <tr>
                                <th style="width: 70px;">S/No.</th>
                                <th style="width: 200px; text-align: center;">Pre-vocational Courses</th>
                                <th style="width: 200px; text-align: center;">Academic Subjects</th>
                                <th style="width: 150px; text-align: center;">Generic Skills</th>
                            </tr>

                            </thead>
                            <tbody>
                            <?php
                            $sno = 1;
                            $subject_saved = $this->db->where(array('applicant_id' => $rowvalue->applicant_id, 'authority_id' => $rowvalue->id))->get("application_education_subject")->result();
                            foreach ($subject_saved as $k => $v) {
                                ?>
                                <tr>
                                    <td style="vertical-align: middle; text-align: center"><?php echo($k + 1); ?></td>
                                    <td style="text-align: center"><?php echo $v->grade; ?></td>

                                    <td><?php echo get_value('secondary_subject', $v->subject, 'name'); ?></td>
                                    <td style="text-align: center"><?php echo $v->year; ?></td>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php
                    }
                    ?>
                    <div id="dv_message_<?php echo $rowvalue->id; ?>"></div>

                </div>
                <!-- <?php

                if ($APPLICANT->status == 0 && $rowvalue->api_status != 1) { ?>
                    <div class="clearfix" id="edit<?php echo $rowvalue->id; ?>">
                        <a class="pull-right" style="text-decoration: underline; font-weight: bold;"
                           href="<?php echo site_url('center_education/' . encode_id($APPLICANT->id)); ?>/?action=edit&id=<?php echo encode_id($rowvalue->id); ?>">Edit Information</a>
                    </div>
                <?php } ?> -->

            </div>
        <?php } ?>

        <?php if(is_section_used('EDUCATION',$APPLICANT_MENU)){ ?>
            <div style="text-align: right; margin-right: 30px;"><a href="<?php echo site_url('center_submission') ?>" class="btn btn-sm btn-success"><i class="fa fa-angle-double-right"></i> Next Step</a></div>
        <?php } ?>

    </div>

</div>


<script>
    $(document).ready(function () {
        setInterval(function () {
            $(".education_div_data").each(function () {
                var please_wait = $(this).attr('WAIT');
                var RID = $(this).attr('RID');
                if (please_wait == 1) {
                    $("#dv_message_" + RID).html('<div class="alert alert-danger"><img src="<?php echo base_url(); ?>/icon/loader.gif" style="width: 16px;"/> Please wait...</div>');
                    $.ajax({
                        url: '<?php echo site_url('popup/education_view/') ?>',
                        dataType: 'json',
                        type: 'POST',
                        data: {RID: RID},
                        success: function (data) {
                            $("#divNo" + RID).html(data.content);
                            if (data.hide == 0) {
                                $("#divNo" + RID).attr('WAIT', 0);
                                $("#edit" + RID).hide();
                            }
                        }
                    });
                }
            });
        }, 5000);


        $(".select34").select2({
            theme: 'bootstrap',
            placeholder: '[ Select Subject ]',
            allowClear: true
        });
        $(".select50").select2({
            theme: 'bootstrap',
            placeholder: '[ Select Country ]',
            allowClear: true
        });

        $("body .remove_delete").confirm({
            title: "Confirm Deletion",
            content: "Are you sure you want to remove selected data ? ",
            confirmButton: 'YES',
            cancelButton: 'NO',
            confirmButtonClass: 'btn-success',
            cancelButtonClass: 'btn-success'
        });


        var i = 1;
        var xp = <?php echo((isset($_GET['action']) && $_GET['action'] == 'new') ? 1 : (isset($sno) ? $sno - 1 : 1)); ?>;

        var row_value = '<td style="vertical-align: middle; text-align: center;">1</td>' +
        '<td><input type="text" name="grade[]" class="form-control"/></td>'+

        '<td><select name="subject[]" style="width: 300px;" class="form-control select34"><option value=""></option>';
        <?php foreach ($subject_list as $subkey=>$subvalue){ ?>
        row_value += '<option value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name . ' [ ' . $subvalue->shortname . ' ]' ?></option>';
        <?php } ?>
        row_value += '</select></td>' +
   
            '<td><input type="text" name="year[]" class="form-control"/></td>';
        $("#add_row").click(function () {
            $('#addr' + i).html(row_value);
            $('#addr' + i).find("td:first").html((i + xp));
            $('#mytable').append('<tr id="addr' + (i + 1) + '"></tr>');
            i++;
            $(".select34").select2({
                theme: 'bootstrap',
                placeholder: '[ Select Subject ]',
                allowClear: true
            });
        });
        $("#delete_row").click(function () {
            if (i > 1) {
                $("#addr" + (i - 1)).html('');
                i--;
            }
        });
    });

</script>