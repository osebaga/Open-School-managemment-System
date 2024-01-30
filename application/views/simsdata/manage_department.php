<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}

?>
<div class="ibox float-e-margins">
    <div class="ibox-title clearfix">
        <h5><?php
            if (is_null($id) && !isset($action)) {
                echo 'Add New Department';
            } else if (!is_null($id) && isset($action)) {
                echo 'Edit Department Information';
            }
            ?></h5>
    </div>
    <div class="ibox-content">


        <?php


            echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>

            <div class="form-group"><label class="col-lg-3 control-label">College/School : <span class="required">*</span></label>

                <div class="col-lg-8">
                    <select name="school_id" class="select2_search1 form-control " >
                        <option value=""></option>
                        <?php
                        $sel = (isset($departmentinfo) ? $departmentinfo->school_id : set_value('school_id'));
                        foreach($school_list as $key=>$value){ ?>
                            <option <?php echo ($sel == $value->id ? 'selected="selected"':''); ?> value="<?php echo $value->id; ?>"><?php echo $value->name ?></option>
                        <?php }
                        ?>
                    </select>
                    <?php echo form_error('school_id'); ?>
                </div>
            </div>

            <div class="form-group"><label class="col-lg-3 control-label">Name : <span class="required">*</span></label>

                <div class="col-lg-8">
                    <input type="text" name="name"
                           value="<?php echo(isset($departmentinfo) ? $departmentinfo->Name : set_value('name')) ?>"
                           class="form-control"/>
                    <?php echo form_error('name'); ?>
                </div>
            </div>


            <div class="form-group">
                <div class="col-lg-offset-3 col-lg-8">
                    <input class="btn btn-sm btn-success" type="submit" value="Save Information"/>
                </div>
            </div>
            <?php echo form_close();
     ?>

    </div>
</div>

<script>
    $(function(){


        $(".select2_search1").select2({
            theme: "bootstrap",
            placeholder: " [ Select College/School ] ",
            allowClear: true
        });

    })
</script>