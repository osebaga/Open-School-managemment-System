<div style="margin-left: 10px;">
<?php
echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"');
?>

    <style>
        .select2-container .select2-selection--single{
            height: 34px !important;
        }
    </style>
<div class="form-group clearfix">
    <label class="col-md-4 control-label" style="width: 30%; float: left;">Entry Mode : </label>
    <div class="" style="float: left; width: 60%;">
        <select name="entry" id="entry_type" class="form-control">
            <option value="">[ Select Entry Category ]</option>
            <?php
            $sel = (isset($_GET) && isset($_GET['entry'])) ? $_GET['entry'] : '';
            foreach (entry_type() as $key => $value) {
                if($programme_info->type == 0){
                    if(in_array($key,array(1,1.5))){
                        ?>
                        <option <?php echo($key == $sel ? 'selected="selected"' : ''); ?>
                                value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } }else if($programme_info->type == 1){
                    if(in_array($key,array(1,1.5,2,3))){
                ?>
                <option <?php echo($key == $sel ? 'selected="selected"' : ''); ?>
                        value="<?php echo $key; ?>"><?php echo $value; ?></option>
            <?php } }else if($programme_info->type == 2){
                if(in_array($key,array(2,4))){
                ?>
                <option <?php echo($key == $sel ? 'selected="selected"' : ''); ?>
                        value="<?php echo $key; ?>"><?php echo $value; ?></option>
            <?php }
            }else if($programme_info->type == 3){
                    if($key > 4){
                        ?>
                        <option <?php echo($key == $sel ? 'selected="selected"' : ''); ?>
                                value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php }
                }
                }
            ?>
        </select>

    </div>
    <div style="clear: both;"></div>
</div>

<?php
if (isset($_GET) && isset($_GET['entry']) && $_GET['entry'] <> '') {
    $entry_type = $_GET['entry'];
    ?>

    <div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
        Form IV Criteria
    </div>
    <table style="width: 100%; font-size: 12px;">
        <tr>
            <td style="width: 40%;"><label class="control-label">Form IV Pass No. (At least) : </label></td>
            <td><input type="text"
                       value="<?php echo set_value('form4_pass', (isset($setting_info) ? $setting_info->form4_pass : '')); ?>"
                       placeholder="At least how many pass ?"
                       class="form-control" name="form4_pass">
                <div style="color: green;">System use A to D as PASS</div>
                <?php echo form_error('form4_pass'); ?>
                <br/>
            </td>
        </tr>

        <?php if($entry_type  == 1){ ?>
            <tr>
                <td style="width: 40%;"><label class="control-label">Minimum Point : </label></td>
                <td><input type="text"
                           value="<?php echo set_value('min_point', (isset($setting_info) ? $setting_info->min_point : '')); ?>"
                           placeholder="Minimum Point"
                           class="form-control" name="min_point">
                    <br/>
                </td>
            </tr>
        <?php } ?>

        <tr>
            <td><label class="control-label">Exclusive Subject : </label></td>
            <td>

                <select name="subject4_exclusive[]" multiple="multiple" class="form-control select34">
                    <option value=""></option>
                    <?php
                    $sel = (isset($setting_info) ? explode(',', $setting_info->form4_exclusive) : array());

                    foreach ($subject_listIV as $subkey => $subvalue) { ?>
                        <option <?php echo(in_array($subvalue->id, $sel) ? 'selected="selected"' : ''); ?>
                                value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name ?></option>
                    <?php } ?>
                </select>
                <div style="height: 25px;"></div>
            </td>
        </tr>

        <tr>
            <td colspan="2"><label class="control-label" style="color: green;">Inclusive Subject By using OR : </label></td>
        </tr>

        <tr>
            <td colspan="2">
                <table class="table"  style="font-size: 12px;">
                    <thead>
                    <th>Subject</th> <th>At least Grade</th><th>#of Subject</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="width: 50%;">
                            <?php
                            $sel_subjectIVOR = (isset($setting_info) ? json_decode($setting_info->form4_or_subject,true) : array());
                            $sel_subjectIVOR_grade = '';
                            $sel_subjectIVOR_subject_no='';
                            $sel_subjectIVOR_subject=array();
                            if(count($sel_subjectIVOR) > 0){
                                $keys = array_keys($sel_subjectIVOR);
                                $tmp = explode('|',$keys[0]);
                                $sel_subjectIVOR_grade = $tmp[0];
                                $sel_subjectIVOR_subject_no =$tmp[1];
                                $sel_subjectIVOR_subject = (is_array($sel_subjectIVOR[$keys[0]]) ? $sel_subjectIVOR[$keys[0]]: array() );
                            }
                            ?>
                            <select name="subjectIVOR[]" class="form-control select34" multiple="multiple">
                                <option value=""></option>
                                <?php foreach ($subject_listIV as $subkey=>$subvalue){ ?>
                                    <option <?php echo (in_array($subvalue->id,$sel_subjectIVOR_subject) ? 'selected="selected"':''); ?> value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name  ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td style="width: 30%;">
                            <select name="gradeIVOR" class="form-control"><option value="">[ Grade ]</option>
                                <?php foreach (grade_list() as $gkey=>$gvalue){ ?>
                                    <option <?php echo ($sel_subjectIVOR_grade == $gvalue ? 'selected="selected"':'') ?> value="<?php echo $gvalue ?>"><?php echo $gvalue ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td style="width: 20%;">
                            <select name="gradeIVORNO" class="form-control"><option value="0">[ #Subject ]</option>
                                <?php foreach (array(1,2,3,4,5,6) as $gkey=>$gvalue){ ?>
                                    <option <?php echo ($sel_subjectIVOR_subject_no == $gvalue ? 'selected="selected"':'') ?> value="<?php echo $gvalue ?>"><?php echo $gvalue ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tbody>
                </table>

                    </td>
        </tr>


        <tr>
            <td colspan="2"><label class="control-label" style="color: green;">Inclusive Subject By using AND : </label></td>
        </tr>
        <tr>
            <td colspan="2">
<table class="table" id="mytableIV" style="font-size: 12px;">
    <thead>
    <th>Subject</th> <th>At least</th><th></th>
    </thead>
    <tbody>

    <?php
    $sel_subjectIV = (isset($setting_info) ? json_decode($setting_info->form4_inclusive) : array());
    $sn=0;
    foreach ($sel_subjectIV as $k_VI=>$v_VI){
        $sn++;
        ?>
        <tr >
            <td style="width: 60%;">
                <select name="subjectIV[]" class="form-control select34">
                    <option value=""></option>
                    <?php foreach ($subject_listIV as $subkey=>$subvalue){ ?>
                        <option <?php echo ( $subvalue->id == $k_VI ? 'selected="selected"':'') ?> value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name  ?></option>
                    <?php } ?>
                </select>
            </td>
            <td style="width: 35%;">
                <select name="gradeIV[]" class="form-control"><option value="">[ Select Grade ]</option>
                    <?php foreach (grade_list() as $gkey=>$gvalue){ ?>
                        <option <?php echo ( $gvalue == $v_VI ? 'selected="selected"':'') ?> value="<?php echo $gvalue ?>"><?php echo $gvalue ?></option>
                    <?php } ?>
                </select>
            </td>
            <td style="vertical-align: middle; font-size: 15px; width: 5%;" title="Delete"><a class="delete_row"  href="<?php echo  current_full_url('sub_id='.$k_VI.'&cat=IV&row_id='.$setting_info->id) ?>"><i class="fa fa-remove"></i></a></td>
        </tr>

    <?php } if($sn == 0){ ?>
    <tr id="addrIV0">
        <td style="width: 60%;">
            <select name="subjectIV[]" class="form-control select34">
                <option value=""></option>
                <?php foreach ($subject_listIV as $subkey=>$subvalue){ ?>
                    <option value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name  ?></option>
                <?php } ?>
            </select>
        </td>
        <td style="width: 35%;">
            <select name="gradeIV[]" class="form-control"><option value="">[ Select Grade ]</option>
                <?php foreach (grade_list() as $gkey=>$gvalue){ ?>
                    <option value="<?php echo $gvalue ?>"><?php echo $gvalue ?></option>
                <?php } ?>
            </select>
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



            </td>
        </tr>




    </table>

    <?php if (in_array($entry_type, array(2, 4))) { ?>
        <div style="font-weight: bold; font-size: 15px; margin-top: 20px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            Form VI Criteria
        </div>
        <table style="width: 100%; font-size: 12px;">
            <tr>
                <td style="width: 40%;"><label class="control-label">Form VI Pass No. (At least) : </label></td>
                <td><input type="text"
                           value="<?php echo set_value('form6_pass', (isset($setting_info) ? $setting_info->form6_pass : '')); ?>"
                           placeholder="At least how many pass ?"
                           class="form-control" name="form6_pass">
                    <div style="color: green;">System use A to E as PASS</div>
                    <br/>
                </td>
            </tr>
            <?php if($entry_type  == 2){ ?>
            <tr>
                <td style="width: 40%;"><label class="control-label">Minimum Point : </label></td>
                <td><input type="text"
                           value="<?php echo set_value('min_point', (isset($setting_info) ? $setting_info->min_point : '')); ?>"
                           placeholder="Minimum Point"
                           class="form-control" name="min_point">
                    <br/>
                </td>
            </tr>
  <?php } ?>
            <tr>
                <td><label class="control-label">Exclusive Subject : </label></td>
                <td>

                    <select name="subject6_exclusive[]" multiple="multiple" class="form-control select34">
                        <option value=""></option>
                        <?php
                        $sel = (isset($setting_info) ? explode(',', $setting_info->form6_exclusive) : array());

                        foreach ($subject_listVI as $subkey => $subvalue) { ?>
                            <option <?php echo(in_array($subvalue->id, $sel) ? 'selected="selected"' : ''); ?>
                                    value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name ?></option>
                        <?php } ?>
                    </select>
                    <div style="height: 25px;"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2"><label class="control-label" style="color: green;">Inclusive Subject By using OR : </label></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="table"  style="font-size: 12px;">
                        <thead>
                        <th>Subject</th> <th>At least Grade</th><th>#of subject</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="width: 50%;">
                                <?php
                                $sel_subjectVIOR = (isset($setting_info) ? json_decode($setting_info->form6_or_subject,true) : array());
                                $sel_subjectVIOR_grade = '';
                                $sel_subjectVIOR_subject_no = '';
                                $sel_subjectVIOR_subject=array();
                                if(count($sel_subjectVIOR) > 0){
                                    $keys = array_keys($sel_subjectVIOR);
                                    $tmp = explode('|',$keys[0]);
                                    $sel_subjectVIOR_grade = $tmp[0];
                                    $sel_subjectVIOR_subject_no =$tmp[1];
                                    $sel_subjectVIOR_subject = (is_array($sel_subjectVIOR[$keys[0]]) ? $sel_subjectVIOR[$keys[0]]: array() );
                                }
                                ?>
                                <select name="subjectVIOR[]" class="form-control select34" multiple="multiple">
                                    <option value=""></option>
                                    <?php foreach ($subject_listVI as $subkey=>$subvalue){ ?>
                                        <option <?php echo (in_array($subvalue->id,$sel_subjectVIOR_subject) ? 'selected="selected"':''); ?> value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name  ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td style="width: 30%;">
                                <select name="gradeVIOR" class="form-control"><option value="">[ Grade ]</option>
                                    <?php foreach (grade_list() as $gkey=>$gvalue){ ?>
                                        <option <?php echo ($sel_subjectVIOR_grade == $gvalue ? 'selected="selected"':'') ?> value="<?php echo $gvalue ?>"><?php echo $gvalue ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td style="width: 20%;">
                                <select name="gradeVIORNO" class="form-control"><option value="0">[ #Subject ]</option>
                                    <?php foreach (array(1,2,3,4,5,6) as $gkey=>$gvalue){ ?>
                                        <option <?php echo ($sel_subjectVIOR_subject_no == $gvalue ? 'selected="selected"':'') ?> value="<?php echo $gvalue ?>"><?php echo $gvalue ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tbody>
                    </table>

                </td>
            </tr>



            <tr>
                <td colspan="2"><label class="control-label" style="color: green;">Inclusive Subject By using AND : </label></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="table" id="mytableVI" style="font-size: 12px;">
                        <thead>
                        <th>Subject</th> <th>At least</th><th></th>
                        </thead>
                        <tbody>
                        <?php
                        $sel_subjectVI = (isset($setting_info) ? json_decode($setting_info->form6_inclusive,true) : array());
                        $sn=0;
                        foreach ($sel_subjectVI as $k_VI=>$v_VI){
                            $sn++;
                            ?>
                            <tr >
                                <td style="width: 60%;">
                                    <select name="subjectVI[]" class="form-control select34">
                                        <option value=""></option>
                                        <?php foreach ($subject_listVI as $subkey=>$subvalue){ ?>
                                            <option <?php echo ( $subvalue->id == $k_VI ? 'selected="selected"':'') ?> value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name  ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td style="width: 35%;">
                                    <select name="gradeVI[]" class="form-control"><option value="">[ Select Grade ]</option>
                                        <?php foreach (grade_list() as $gkey=>$gvalue){ ?>
                                            <option <?php echo ( $gvalue == $v_VI ? 'selected="selected"':'') ?> value="<?php echo $gvalue ?>"><?php echo $gvalue ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td style="vertical-align: middle; font-size: 15px; width: 5%;" title="Delete"><a class="delete_row"  href="<?php echo  current_full_url('sub_id='.$k_VI.'&cat=VI&row_id='.$setting_info->id) ?>"><i class="fa fa-remove"></i></a></td>
                            </tr>

                        <?php } if($sn == 0){ ?>
                        <tr id="addrIV0">
                            <td style="width: 60%;">
                                <select name="subjectVI[]" class="form-control select34">
                                    <option value=""></option>
                                    <?php foreach ($subject_listVI as $subkey=>$subvalue){ ?>
                                        <option value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name  ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td style="width: 35%;">
                                <select name="gradeVI[]" class="form-control"><option value="">[ Select Grade ]</option>
                                    <?php foreach (grade_list() as $gkey=>$gvalue){ ?>
                                        <option value="<?php echo $gvalue ?>"><?php echo $gvalue ?></option>
                                    <?php } ?>
                                </select>
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



                </td>
            </tr>

        </table>
    <?php }
    if (in_array($entry_type, array(1.5, 3, 4))) { ?>
        <div style="font-weight: bold; font-size: 15px; margin-top: 20px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            Certificate / Diploma GPA
        </div>
        <table style="width: 100%; font-size: 12px;">
            <tr>
                <td style="width: 40%;"><label class="control-label">At least GPA : </label></td>
                <td><input type="text"
                           value="<?php echo set_value('gpa_pass', (isset($setting_info) ? $setting_info->gpa_pass : '')); ?>"
                           class="form-control" name="gpa_pass">
                    <?php echo form_error('gpa_pass'); ?>
                    <br/>
                </td>
            </tr>
            <tr>
                <td style="width: 40%;"><label class="control-label">Key Word : </label></td>
                <td><input type="text"
                           value="<?php echo set_value('keyword1', (isset($setting_info) ? $setting_info->keyword1 : '')); ?>"
                           class="form-control" name="keyword1">
                    <?php echo form_error('keyword1'); ?>
                    <br/>
                </td>
            </tr>
        </table>
    <?php } ?>

    <input type="hidden" value="1" name="save_data"/>

    <div class="form-group" style="margin-top: 20px;">
        <div class="col-lg-6" style="text-align: right;">
            <input class="btn btn-sm btn-success" type="submit" value="Save Information"/>
        </div>
    </div>
<?php } ?>
<?php echo form_close(); ?>

<script>
    function setHeight(val) {
        var FRAME_HEIGHT = document.body.scrollHeight;
        $('iframe',window.parent.document.body).height((FRAME_HEIGHT-val)+'px');
    }
    $(document).ready(function () {

        $("#entry_type").change(function () {
            var entry_type = $(this).val();
            if (entry_type != '') {
                window.location.href = '<?php echo site_url('programme_setting_panel/' . $CODE) ?>/?entry=' + entry_type;
            } else {

                window.location.href = '<?php echo site_url('programme_setting_panel/' . $CODE) ?>'
            }
        });



        var row_value =  '<td><select name="subjectIV[]" class="form-control select34"><option value=""></option>';
        <?php foreach ($subject_listIV as $subkey=>$subvalue){ ?>
        row_value +='<option value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name; ?></option>';
        <?php } ?>
        row_value += '</select></td>' +
            '<td><select name="gradeIV[]" class="form-control"><option value="">[ Select Grade ]</option>';
        <?php foreach (grade_list() as $gkey=>$gvalue){ ?>
        row_value +='<option value="<?php echo $gvalue ?>"><?php echo $gvalue ?></option>';
        <?php } ?>
        row_value += '</select></td><td style="vertical-align: middle; font-size: 15px;" title="Delete"><a class="delete_row"  href="javascript:void(0);"><i class="fa fa-remove"></i></a></td>';

        var row_value2 =  '<td><select name="subjectVI[]" class="form-control select34"><option value=""></option>';
        <?php foreach ($subject_listVI as $subkey=>$subvalue){ ?>
        row_value2 +='<option value="<?php echo $subvalue->id ?>"><?php echo $subvalue->name; ?></option>';
        <?php } ?>
        row_value2 += '</select></td>' +
            '<td><select name="gradeVI[]" class="form-control"><option value="">[ Select Grade ]</option>';
        <?php foreach (grade_list() as $gkey=>$gvalue){ ?>
        row_value2 +='<option value="<?php echo $gvalue ?>"><?php echo $gvalue ?></option>';
        <?php } ?>
        row_value2 += '</select></td><td style="vertical-align: middle; font-size: 15px;" title="Delete"><a class="delete_row"  href="javascript:void(0);"><i class="fa fa-remove"></i></a></td>';


        $(".add_row").click(function () {

            var Type = $(this).attr('type');
            if(Type == 'IV') {
                $('#mytable' + Type + " tbody tr:last").html(row_value);
            }else  if(Type == 'VI') {
                $('#mytable' + Type + " tbody tr:last").html(row_value2);
            }
            $('#mytable'+Type+" tbody").append('<tr></tr>');
            $(".select34").select2({
                theme:'bootstrap',
                placeholder:'[ Select Subject ]',
                allowClear:true
            });
            setHeight(0);
        });

        $("body").on("click",".delete_row",function () {
           var row = $(this).parent().parent();
           row.remove();
            setHeight(51);
        });



    });
</script>

</div>
