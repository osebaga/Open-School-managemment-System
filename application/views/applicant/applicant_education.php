
<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">
            <h5>Education Background</h5>

            <?php
            if ($APPLICANT->status == 0) {
                if (!isset($_GET['action'])) {
                    ?>

                    <a class="pull-right btn btn-warning btn-small btn-sm" style="margin-top: -10px;"
                       href="<?php echo site_url('applicant_education'); ?>/?action=new">Add Certificate
                        Information</a>
                    <?php
                } else {
                    ?>
                    <a class="pull-right btn btn-warning btn-small btn-sm" style="margin-top: -10px;"
                       href="<?php echo site_url('applicant_education'); ?>">Cancel Changes</a>
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
            <div class="form-group"><label class="col-lg-3 control-label">Certificate : <span
                            class="required">*</span></label>
                <div class="col-lg-8">
                    <select name="certificate" id="certificate" class="form-control">
                        <option value=""> [ Select Certificate ]</option>
                        <?php
                        $sel = set_value('certificate', (isset($education_info) ? $education_info->certificate : ''));
                        foreach ($certificate_list as $key => $value) {
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

                <div class="form-group"><label class="col-lg-3 control-label">Examination Authority : <span
                                class="required">*</span></label>

                    <div class="col-lg-8">
                        <input type="text"
                               value="<?php echo set_value('exam_authority1', (isset($education_info) ? $education_info->exam_authority : '')); ?>"
                               class="form-control" name="exam_authority1" placeholder="Eg: NECTA">
                        <?php echo form_error('exam_authority1'); ?>
                    </div>
                </div>

                <div class="form-group"><label class="col-lg-3 control-label">Division/Grade : <span
                                class="required">*</span></label>

                    <div class="col-lg-8">
                        <input type="text"
                               value="<?php echo set_value('division1', (isset($education_info) ? $education_info->division : '')); ?>"
                               class="form-control" name="division1">
                        <?php echo form_error('division1'); ?>
                    </div>
                </div>
                <div class="form-group"><label class="col-lg-3 control-label">Centre/School : <span
                                class="required">*</span></label>

                    <div class="col-lg-8">
                        <input type="text"
                               value="<?php echo set_value('school1', (isset($education_info) ? $education_info->school : '')); ?>"
                               class="form-control" name="school1">
                        <?php echo form_error('school1'); ?>
                    </div>
                </div>


            </div>

            <div id="college">
                <!-- *********************************COLLEGE **************************** -->
                <div class="form-group"><label class="col-lg-3 control-label">Examination Authority : <span
                                class="required">*</span></label>

                    <div class="col-lg-8">
                        <input type="text"
                               value="<?php echo set_value('exam_authority', (isset($education_info) ? $education_info->exam_authority : '')); ?>"
                               class="form-control" name="exam_authority" placeholder="Eg: NACTE">
                        <?php echo form_error('exam_authority'); ?>
                    </div>
                </div>



                <div class="form-group"><label class="col-lg-3 control-label">Programme Title : <span
                                class="required">*</span></label>

                    <div class="col-lg-8">
                        <input type="text"
                               value="<?php echo set_value('programme_title', (isset($education_info) ? $education_info->programme_title : '')); ?>"
                               class="form-control" name="programme_title">
                        <?php echo form_error('programme_title'); ?>
                    </div>
                </div>

                <div class="form-group"><label
                            class="col-lg-3 control-label">GPA<?php echo($APPLICANT->application_type == 3 ? ' / Degree Class' : '') ?>
                        : <span
                                class="required">*</span></label>

                    <div class="col-lg-8">
                        <input type="text"
                               value="<?php echo set_value('division', (isset($education_info) ? $education_info->division : '')); ?>"
                               class="form-control" name="division">
                        <?php echo form_error('division'); ?>
                    </div>
                </div>
                <div class="form-group"><label class="col-lg-3 control-label">College /
                        Institution <?php echo($APPLICANT->application_type == 3 ? '/ University' : '') ?> : <span
                                class="required">*</span></label>

                    <div class="col-lg-8">
                        <input type="text"
                               value="<?php echo set_value('school', (isset($education_info) ? $education_info->school : '')); ?>"
                               class="form-control" name="school">
                        <?php echo form_error('school'); ?>
                    </div>
                </div>


            </div>

            <div class="form-group"><label class="col-lg-3 control-label">Country : <span
                            class="required">*</span></label>

                <div class="col-lg-8">
                    <select name="country1" id="country1" class="form-control select50 ">
                        <option value=""> [ Select Country ]</option>
                        <?php
                        $sel = set_value('country1', (isset($education_info) ? $education_info->country : ''));
                        foreach ($nationality_list as $key => $value) {
                            ?>
                            <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                    value="<?php echo $value->id; ?>"><?php echo $value->Country; ?></option>
                            <?php
                        }
                        ?>
                    </select>

                    <?php echo form_error('country1'); ?>
                </div>
            </div>
            <div class="form-group"><label class="col-lg-3 control-label">Index<span id="registration_no"
                                                                                     style="display: none;">/Registration</span>
                    Number : <span
                            class="required">*</span></label>
                <div class="col-lg-8">
                    <input type="text"
                           value="<?php echo set_value('index_number', (isset($education_info) ? $education_info->index_number : '')); ?>"
                           class="form-control" name="index_number">
                    <div id="sample_index" style="display: none;">Eg S0125/0000/2005 or P0125/0000/2005</div>

                    <?php echo form_error('index_number'); ?>
                </div>
            </div>

            <div class="form-group" style="display: none;" id="tanzania_diploma"><label class="col-lg-3 control-label">NACTE
                    Award Verification Number : <span
                            class="required">*</span></label>
                <div class="col-lg-8">
                    <input type="text"
                           value="<?php echo set_value('avn', (isset($education_info) ? $education_info->avn : '')); ?>"
                           class="form-control" name="avn">
                    <div>This number must be obtained from NACTE</div>

                    <?php echo form_error('avn'); ?>
                </div>
            </div>
            <div class="form-group"><label class="col-lg-3 control-label">Year Completed : <span
                            class="required">*</span></label>
                <div class="col-lg-8">
                    <input type="text" placeholder="Eg: 2015"
                           value="<?php echo set_value('completed_year', (isset($education_info) ? $education_info->completed_year : '')); ?>"
                           class="form-control" name="completed_year">
                    <?php echo form_error('completed_year'); ?>
                </div>
            </div>

            <div class="school" id="subject_list_div">

                <br/>

                <?php
                echo form_error('subject[]');
                echo form_error('grade[]');
                echo form_error('year[]');
                ?>
                <div style="margin-bottom: 15px; color: green; font-weight: bold;">
                    Please add all subject the same as in your certificate. Click <span
                            style="color: red;">+Add Row</span> to add more rows and <span style="color: red;">--Delete Row</span>
                    to remove row. <br/>
                    If your certificate show 7 subjects make sure this section also has 7 rows with the same subject as
                    in your certificate.Failure to that, your application will be rejected

                </div>
                <table class="table table-bordered" id="mytable">
                    <thead>
                    <th style="width: 50px;">#</th>
                    <th>SUBJECT</th>
                    <th style="width: 200px; text-align: center;">GRADE</th>
                    <th style="width: 150px; text-align: center;">YEAR</th>
                    <?php if ($APPLICANT->status == 0 && isset($_GET) && isset($_GET['id'])) { ?>
                        <th style="width: 80px;">Action</th>
                    <?php } ?>
                    </thead>
                    <tbody>
                    <?php
                    $sno = 1;
                    if (isset($_GET) && isset($_GET['id'])) {
                        $subject_saved = $this->applicant_model->get_education_subject($education_info->applicant_id, $education_info->id);
                        foreach ($subject_saved as $k => $v) {
                            ?>
                            <tr>
                                <td style="vertical-align: middle; text-align: center"><?php echo($k + 1); ?></td>
                                <td><?php echo get_value('secondary_subject', $v->subject, 'name'); ?></td>
                                <td style="text-align: center"><?php echo $v->grade; ?></td>
                                <td style="text-align: center"><?php echo $v->year; ?></td>
                                <?php if ($APPLICANT->status == 0) { ?>
                                    <td>
                                        <a href="<?php echo site_url('applicant_education/' . encode_id($APPLICANT->id)); ?>/?row_id=<?php echo encode_id($v->id); ?>"
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
                            <td>
                                <select name="subject[]" class="form-control select34">
                                    <option value=""></option>
                                    <?php foreach ($subject_list as $subkey => $subvalue) { ?>
                                        <option value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name . ' [ ' . $subvalue->shortname . ' ]' ?></option>
                                    <?php } ?>
                                </select></td>
                            <td><select name="grade[]" class="form-control">
                                    <option value="">[ Select Grade ]</option>
                                    <?php foreach (grade_list() as $gkey => $gvalue) { ?>
                                        <option value="<?php echo $gvalue ?>"><?php echo $gvalue ?></option>
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
                    var certificate = $("#certificate").val();
                    var country1 = $("#country1").val();
                    if (certificate < 3 && certificate != 1.5) {
                        if (country1 == 220 && (certificate == 1 || certificate == 2)) {
                            $(".school").show();
                            $("#subject_list_div").hide();
                            $("#college").hide();
                        } else {
                            $(".school").show();
                            $("#college").hide();
                        }
                    } else {
                        $(".school").hide();
                        $("#college").show();
                    }

                    if (certificate == 3) {
                        $("#technician_type").show();
                    } else {
                        $("#technician_type").hide();
                    }

                    $("#certificate,#country1").change(function () {
                        var certificate = $("#certificate").val();
                        var country1 = $("#country1").val();
                        if (certificate < 3 && certificate != 1.5) {
                            if (country1 == 220 && (certificate == 1 || certificate == 2)) {
                                $(".school").show();
                                $("#subject_list_div").hide();
                                $("#college").hide();
                            } else {
                                $(".school").show();
                                $("#college").hide();
                            }
                        } else {
                            $(".school").hide();
                            $("#college").show();
                        }
                        if (certificate == 3) {
                            $("#technician_type").show();
                        } else {
                            $("#technician_type").hide();
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

            <div class="applicant_education_bg" style="margin-bottom: 50px;">

                <div style="font-size: 14px; border-bottom: 1px solid brown; color: brown; font-weight: bold;"><?php echo entry_type_certificate($rowvalue->certificate); ?></div>

                <div class="education_div_data" id="divNo<?php echo $rowvalue->id; ?>"
                     RID="<?php echo $rowvalue->id; ?>" WAIT="<?php echo $rowvalue->hide; ?>">
                    <table class="mytable2_educatiobbg">

                        <tr>
                            <th>Examination Authority :</th>
                            <td><?php echo $rowvalue->exam_authority; ?></td>
                        </tr>
                        <?php
                        if ($rowvalue->technician_type > 0) {
                            ?>
                            <tr>
                                <th> Category :</th>
                                <td><?php echo get_value('technician_type', $rowvalue->technician_type, 'name'); ?></td>
                            </tr>
                        <?php }
                        if ($rowvalue->programme_title <> '') { ?>
                            <tr>
                                <th> Programme Title :</th>
                                <td><?php echo $rowvalue->programme_title; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th> <?php echo($rowvalue->certificate < 3 ? 'Division' : 'G.P.A') ?> :</th>
                            <td><?php echo $rowvalue->division; ?></td>
                        </tr>
                        <tr>
                            <th> <?php echo($rowvalue->certificate < 3 ? 'Centre/School' : 'College/Institution') ?> :
                            </th>
                            <td><?php echo $rowvalue->school; ?></td>
                        </tr>
                        <tr>
                            <th>Country :</th>
                            <td><?php echo get_country($rowvalue->country); ?></td>
                        </tr>

                        <tr>
                            <th>Index Number :</th>
                            <td><?php echo $rowvalue->index_number; ?></td>
                        </tr>

                        <tr>
                            <th>Completed Year:</th>
                            <td><?php echo $rowvalue->completed_year; ?></td>
                        </tr>
                    </table>

                    <br/>
                    <?php if ($rowvalue->certificate <= 3 && $rowvalue->certificate != 1.5) { ?>
                        <strong>SUBJECT LIST</strong>
                        <br/>
                        <table cellpadding="0" cellspacing="0" class="table table-bordered"
                               id="mytable" style="width: ">
                            <thead>
                            <tr>
                                <th style="width: 70px;">S/No.</th>
                                <th>SUBJECT</th>
                                <th style="width: 150px; text-align: center;">GRADE</th>
                                <th style="width: 150px; text-align: center;">YEAR</th>
                                <?php if ($APPLICANT->status == 0 && $rowvalue->api_status != 1) { ?>
                                    <th style="width: 100px;">Action</th>
                                <?php } ?>
                            </tr>

                            </thead>
                            <tbody>
                            <?php
                            $sno = 1;
                            $subject_saved = $this->applicant_model->get_education_subject($rowvalue->applicant_id, $rowvalue->id);
                            foreach ($subject_saved as $k => $v) {
                                ?>
                                <tr>
                                    <td style="vertical-align: middle; text-align: center"><?php echo($k + 1); ?></td>
                                    <td><?php echo get_value('secondary_subject', $v->subject, 'name'); ?></td>
                                    <td style="text-align: center"><?php echo $v->grade; ?></td>
                                    <td style="text-align: center"><?php echo $v->year; ?></td>
                                    <?php if ($APPLICANT->status == 0 && $rowvalue->api_status != 1) { ?>
                                        <td>
                                            <a href="<?php echo site_url('applicant_education/' . encode_id($APPLICANT->id)); ?>/?row_id=<?php echo encode_id($v->id); ?>"
                                               class="remove_delete"><i class="fa fa-remove"></i> Remove</a></td>
                                    <?php } ?>
                                </tr>
                                <?php $sno++;
                            } ?>
                            </tbody>
                        </table>
                    <?php }

                    if ($rowvalue->certificate == 4) {
                        ?>
                        <strong>SOME OF SUBJECT PERFORMED</strong>
                        <br/>
                        <table cellpadding="0" cellspacing="0" class="table table-bordered"
                               id="mytable" style="width: ">
                            <thead>
                            <tr>
                                <th style="width: 70px;">S/No.</th>
                                <th>SUBJECT</th>
                                <th style="width: 150px; text-align: center;">GRADE</th>

                            </tr>

                            </thead>
                            <tbody>
                            <?php
                            $sno = 1;
                            $subject_saved = $this->db->where(array('applicant_id' => $rowvalue->applicant_id, 'authority_id' => $rowvalue->id))->get("application_diploma_nacteresult")->result();
                            foreach ($subject_saved as $k => $v) {
                                ?>
                                <tr>
                                    <td style="vertical-align: middle; text-align: center"><?php echo($k + 1); ?></td>
                                    <td><?php echo $v->subject; ?></td>
                                    <td style="text-align: center"><?php echo $v->grade; ?></td>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php
                    }
                    ?>
                    <div id="dv_message_<?php echo $rowvalue->id; ?>"></div>

                </div>
                <?php
                if ($rowvalue->api_status == -1) {
                    //  echo  show_alert($rowvalue->comment,'info');
                }

                if ($APPLICANT->status == 0 && $rowvalue->api_status != 1) { ?>
                    <div class="clearfix" id="edit<?php echo $rowvalue->id; ?>">
                        <a class="pull-right" style="text-decoration: underline; font-weight: bold;"
                           href="<?php echo site_url('applicant_education/' . encode_id($APPLICANT->id)); ?>/?action=edit&id=<?php echo encode_id($rowvalue->id); ?>">Edit
                            Information</a>
                    </div>
                <?php } ?>

            </div>
        <?php } ?>

        <?php if(is_section_used('EDUCATION',$APPLICANT_MENU)){ ?>
            <div style="text-align: right; margin-right: 30px;"><a href="<?php echo site_url('applicant_attachment') ?>" class="btn btn-sm btn-success"><i class="fa fa-angle-double-right"></i> Next Step</a></div>
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


        var country1 = $("#country1").val();
        var certificate = $("#certificate").val();
        if ((certificate == 1 || certificate == 2) && country1 == 220) {
            $("#sample_index").show();
        } else {
            $("#sample_index").hide();
        }

        if (certificate != 1 && certificate != 2) {
            $("#registration_no").show();
        } else {
            $("#registration_no").hide();
        }

        if (certificate == 4) {
            $("#tanzania_diploma").show();
        } else {
            $("#tanzania_diploma").hide();
        }

        $("#country1, #certificate").change(function () {
            var country1 = $("#country1").val();
            var certificate = $("#certificate").val();
            if ((certificate == 1 || certificate == 2) && country1 == 220) {
                $("#sample_index").show();
            } else {
                $("#sample_index").hide();
            }
            if (certificate != 1 && certificate != 2) {
                $("#registration_no").show();
            } else {
                $("#registration_no").hide();
            }
            if (certificate == 4) {
                $("#tanzania_diploma").show();
            } else {
                $("#tanzania_diploma").hide();
            }


        });
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
            '<td><select name="subject[]" class="form-control select34"><option value=""></option>';
        <?php foreach ($subject_list as $subkey=>$subvalue){ ?>
        row_value += '<option value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name . ' [ ' . $subvalue->shortname . ' ]' ?></option>';
        <?php } ?>
        row_value += '</select></td>' +
            '<td><select name="grade[]" class="form-control"><option value="">[ Select Grade ]</option>';
        <?php foreach (grade_list() as $gkey=>$gvalue){ ?>
        row_value += '<option value="<?php echo $gvalue ?>"><?php echo $gvalue ?></option>';
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