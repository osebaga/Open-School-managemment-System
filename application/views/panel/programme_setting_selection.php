<link href="<?php echo base_url(); ?>media/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>media/css/style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>media/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>media/css/select2-bootstrap.css" rel="stylesheet">

<link href="<?php echo base_url(); ?>media/css/plugins/select2/select2.min.css" rel="stylesheet">


<script src="<?php echo base_url(); ?>media/js/jquery-2.1.1.js"></script>
<script src="<?php echo base_url(); ?>media/js/plugins/select2/select2.full.min.js"></script>

<script src="<?php echo base_url(); ?>media/js/bootstrap.min.js"></script>
<style>
    body {
        background: #ffffff;
    }
</style>
<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
?>
<div class="ibox-content" style="padding: 0px;margin-right: 5px; border: 0px; font-size: 15px;">
    <div style=" margin-bottom: 20px;"><span
                style="color: darkgreen; font-weight: bold;">SELECTED PROGRAMME :</span> <?php echo $programme_info->Name; ?>
    </div>

    <?php echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"');
    ?>
    <div style="margin-left: 10px;">

        <table style="width: 100%; font-size: 12px;">
            <tr>
                <td style="width: 40%;"><label class="control-label">Capacity :<span class="required">*</span> </label>
                </td>
                <td><input type="text"
                           value="<?php echo set_value('capacity', (isset($setting_info) ? $setting_info->capacity : '')); ?>"
                           placeholder="Capacity"
                           class="form-control" name="capacity">
                    <?php echo form_error('capacity'); ?>
                    <br/>
                </td>
            </tr>
            <tr>
                <td style="width: 40%;"><label class="control-label">Direct Applicant % :<span class="required">*</span>
                    </label></td>
                <td><input type="text"
                           value="<?php echo set_value('direct', (isset($setting_info) ? $setting_info->direct : '')); ?>"
                           placeholder="Percentage of the Capacity, remaining will be treated as Equivalent"
                           class="form-control" name="direct">
                    <div style="font-size: 10px; color: blue;">Percentage of the Capacity, remaining will be treated as
                        Equivalent
                    </div>
                    <?php echo form_error('direct'); ?>
                    <br/>
                </td>
            </tr>
            <?php
            if (isset($setting_info)) {
                $sel = isset($CATEGORY) ? $CATEGORY : ''; ?>
                <tr>
                    <td><label class="control-label">Category </label></td>
                    <td>
                        <select name="applicant_category" class="form-control" id="applicant_category">
                            <option value="">--Select--</option>
                            <option <?php echo($sel == 1 ? 'selected="selected"' : ''); ?> value="1">Direct</option>
                            <option <?php echo($sel == 2 ? 'selected="selected"' : ''); ?> value="2">Equivalent</option>
                        </select>
                    </td>
                </tr>
            <?php } ?>

        </table>

        <?php if (isset($setting_info) && isset($CATEGORY)) {
            $formIV = $this->db->where(array('selection_id' => $setting_info->id, 'category' => $CATEGORY, 'filter_type' => 'FORM_IV'))->get('application_selection_criteria_filter')->result();
            $formVI = $this->db->where(array('selection_id' => $setting_info->id, 'category' => $CATEGORY, 'filter_type' => 'FORM_VI'))->get('application_selection_criteria_filter')->result();
            $highest_point = $this->db->where(array('selection_id' => $setting_info->id, 'category' => $CATEGORY, 'filter_type' => 'POINT'))->get('application_selection_criteria_filter')->row();
            $gender_priority = $this->db->where(array('selection_id' => $setting_info->id, 'category' => $CATEGORY, 'filter_type' => 'GENDER'))->get('application_selection_criteria_filter')->row();
            $fifo_priority = $this->db->where(array('selection_id' => $setting_info->id, 'category' => $CATEGORY, 'filter_type' => 'FIFO'))->get('application_selection_criteria_filter')->row();
            ?>

            <div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
                General Filtering
            </div>
        <table style="width: 95%; font-size: 12px;" class="table">
            <thead>
            <tr>
                <th colspan="2" style="text-align: left;">FILTER ITEM</th>
                <th>ORDER</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <?php if($CATEGORY == 1){ ?>
                <td style="width: 30%;">POINT :</td>
                <td  style="width: 50%;">Highest Point  Priority</td>
            <?php }else{ ?>
                <td style="width: 30%;">GPA :</td>
                <td  style="width: 50%;"><label class="control-label">Highest GPA Priority</label>
                </td>
            <?php } ?>
            <td>
                <input name="point" class="form-control" value="<?php echo ($highest_point ? $highest_point->order_number:''); ?>" type="text"/>
            </td>
            </tr>
            <tr>
                <td style="width: 30%;">Gender Priority :</td>
                    <td style="width: 50%;">
                        <select name="gender" class="form-control">
                            <option value="">--Select--</option>
                            <option <?php echo ($gender_priority ? ($gender_priority->filter_item == 'M' ? 'selected="selected"':'' ):''); ?> value="M">Male</option>
                            <option <?php echo ($gender_priority ? ($gender_priority->filter_item == 'F' ? 'selected="selected"':'' ) :''); ?> value="F">Female</option>
                        </select>
                    </td>
                <td>
                    <input name="gender_order" class="form-control" value="<?php echo ($gender_priority ? $gender_priority->order_number:''); ?>" type="text" />
                </td>
            </tr>
            <tr>

                    <td style="width: 30%;">FIFO :</td>
                    <td  style="width: 50%;">First In First Out</td>

                <td>
                    <input name="fifo" class="form-control" value="<?php echo ($fifo_priority ? $fifo_priority->order_number:''); ?>" type="text"/>
                </td>
            </tr>
            </tbody>
            </tbody>
        </table>

            <div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
                Form IV Criteria
            </div>
            <table class="table" id="mytableIV" style="font-size: 12px;">
                <thead>
                <tr>
                    <th colspan="2" style="text-align: center;">FILTER ITEM</th>
                    <th>ORDER</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $sn = 0;
                foreach ($formIV as $k_VI => $v_VI) {
                    $sn++;
                    ?>
                    <tr>
                        <td style="width: 30%;">Highest Grade in :</td>
                        <td style="width: 50%;">
                            <select name="subjectIV[]" class="form-control select34">
                                <option value=""></option>
                                <?php foreach ($subject_listIV as $subkey => $subvalue) { ?>
                                    <option <?php echo($subvalue->id == $v_VI->filter_item ? 'selected="selected"' : '') ?>
                                            value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td style="width: 20%;">
                            <input name="gradeIV[]" class="form-control" value="<?php echo $v_VI->order_number; ?>"
                                   type="text"/>
                        </td>
                        <td style="vertical-align: middle; font-size: 15px; width: 5%;" title="Delete"><a
                                    class="delete_row" href="<?php echo current_full_url('sub_id=' . $v_VI->id) ?>"><i
                                        class="fa fa-remove"></i></a></td>
                    </tr>

                <?php }
                if ($sn == 0) { ?>
                    <tr id="addrIV0">
                        <td style="width: 30%;">Highest Grade in :</td>
                        <td style="width: 50%;">
                            <select name="subjectIV[]" class="form-control select34">
                                <option value=""></option>
                                <?php foreach ($subject_listIV as $subkey => $subvalue) { ?>
                                    <option value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td style="width: 20%;">
                            <input name="gradeIV[]" class="form-control" type="text"/>
                        </td>
                        <td style="width: 5%;"></td>
                    </tr>
                <?php } ?>
                <tr></tr>
                </tbody>
            </table>

            <div class="clearfix" style="margin-right: 50px;">

                <a type="IV" class="pull-right add_row" style="font-weight: bold;"> <i class="fa
                        fa-plus"></i> Add Row</a>
            </div>


            <div style="font-weight: bold; font-size: 15px; margin-top: 20px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
                Form VI Criteria
            </div>


            <table class="table" id="mytableVI" style="font-size: 12px;">
                <thead>
                <tr>
                    <th colspan="2" style="text-align: center;">FILTER ITEM</th>
                    <th>ORDER</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sn = 0;
                foreach ($formVI as $k_VI => $v_VI) {
                    $sn++;
                    ?>
                    <tr>
                        <td style="width: 30%;">Highest Grade in :</td>
                        <td style="width: 50%;">
                            <select name="subjectVI[]" class="form-control select34">
                                <option value=""></option>
                                <?php foreach ($subject_listVI as $subkey => $subvalue) { ?>
                                    <option <?php echo($subvalue->id == $v_VI->filter_item ? 'selected="selected"' : '') ?>
                                            value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td style="width: 20%;">
                            <input name="gradeVI[]" class="form-control" value="<?php echo $v_VI->order_number; ?>"
                                   type="text"/>

                        </td>
                        <td style="vertical-align: middle; font-size: 15px; width: 5%;" title="Delete"><a
                                    class="delete_row" href="<?php echo current_full_url('sub_id=' . $v_VI->id) ?>"><i
                                        class="fa fa-remove"></i></a></td>
                    </tr>

                <?php }
                if ($sn == 0) { ?>
                    <tr id="addrIV0">
                        <td style="width: 30%;">Highest Grade in :</td>
                        <td style="width: 50%;">
                            <select name="subjectVI[]" class="form-control select34">
                                <option value=""></option>
                                <?php foreach ($subject_listVI as $subkey => $subvalue) { ?>
                                    <option value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td style="width: 20%;">
                            <input name="gradeVI[]" class="form-control" type="text"/>
                        </td>
                        <td style="width: 5%;"></td>
                    </tr>
                <?php } ?>
                <tr></tr>
                </tbody>
            </table>

            <div class="clearfix" style="margin-right: 50px;">

                <a type="VI" class="pull-right add_row" style="font-weight: bold;"> <i class="fa
                        fa-plus"></i> Add Row</a>
            </div>

        <?php } ?>

    </div>
    <div class="form-group" style="margin-top: 20px;">
        <div class="col-lg-6" style="text-align: right;">
            <input class="btn btn-sm btn-success" type="submit" value="Save Information"/>
        </div>
    </div>


    <?php echo form_close(); ?>


</div>

<script>
    function setHeight(val) {
        var FRAME_HEIGHT = document.body.scrollHeight;
        $('iframe', window.parent.document.body).height((FRAME_HEIGHT - val) + 'px');
    }
    $(document).ready(function () {
        $(".select34").select2({
            theme: 'bootstrap',
            placeholder: '[ Select Subject ]',
            allowClear: true
        });

        $("#applicant_category").change(function () {
            var applicant_category = $(this).val();
            if (applicant_category != '') {
                window.location.href = '<?php echo site_url('programme_setting_selection/' . $CODE) ?>/?category=' + applicant_category;
            } else {

                window.location.href = '<?php echo site_url('programme_setting_selection/' . $CODE) ?>'
            }
        });


        var row_value = '<td>Highest Grade in : </td><td><select name="subjectIV[]" class="form-control select34"><option value=""></option>';
        <?php foreach ($subject_listIV as $subkey=>$subvalue){ ?>
        row_value += '<option value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name; ?></option>';
        <?php } ?>
        row_value += '</select></td>' +
            '<td><input name="gradeIV[]" class="form-control" type="text"/>';
        row_value += '</select></td><td style="vertical-align: middle; font-size: 15px;" title="Delete"><a class="delete_row"  href="javascript:void(0);"><i class="fa fa-remove"></i></a></td>';

        var row_value2 = '<td>Highest Grade in : </td><td><select name="subjectVI[]" class="form-control select34"><option value=""></option>';
        <?php foreach ($subject_listVI as $subkey=>$subvalue){ ?>
        row_value2 += '<option value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name; ?></option>';
        <?php } ?>
        row_value2 += '</select></td>' +
            '<td><input name="gradeVI[]" class="form-control" type="text"/>';
        row_value2 += '</select></td><td style="vertical-align: middle; font-size: 15px;" title="Delete"><a class="delete_row"  href="javascript:void(0);"><i class="fa fa-remove"></i></a></td>';


        $(".add_row").click(function () {

            var Type = $(this).attr('type');
            if (Type == 'IV') {
                $('#mytable' + Type + " tbody tr:last").html(row_value);
            } else if (Type == 'VI') {
                $('#mytable' + Type + " tbody tr:last").html(row_value2);
            }
            $('#mytable' + Type + " tbody").append('<tr></tr>');
            $(".select34").select2({
                theme: 'bootstrap',
                placeholder: '[ Select Subject ]',
                allowClear: true
            });
            setHeight(0);
        });

        $("body").on("click", ".delete_row", function () {
            var row = $(this).parent().parent();
            row.remove();
            setHeight(51);
        });


    });
</script>