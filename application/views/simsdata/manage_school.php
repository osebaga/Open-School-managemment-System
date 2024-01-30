<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}

$has_access = has_role($MODULE_ID,'create_schools',$GROUP_ID,'SETTINGS');
?>
<div class="ibox float-e-margins">
    <div class="ibox-title clearfix">
        <h5><?php
            if (is_null($id) && !isset($action)) {
                echo 'Add New College/School';
            } else if (!is_null($id) && isset($action)) {
                echo 'Edit College/School Information';
            }
            ?></h5>
    </div>
    <div class="ibox-content">


        <?php

            echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>

            <div class="form-group"><label class="col-lg-3 control-label">Type : <span class="required">*</span></label>

                <div class="col-lg-8">
                    <?php $sel = (isset($schoolinfo) ? $schoolinfo->type1 : set_value('type1')); ?>
                    <select name="type1" class="form-control">
                        <option value=""> [ Select Type ] </option>
                        <option <?php echo ($sel == 'COLLEGE' ? 'selected="selected"':''); ?> value="COLLEGE"> COLLEGE </option>
                        <option <?php echo ($sel == 'SCHOOL' ? 'selected="selected"':''); ?> value="SCHOOL"> SCHOOL </option>
                    </select>
                    <?php echo form_error('type1'); ?>
                </div>
            </div>

            <div class="form-group"><label class="col-lg-3 control-label">Name : <span class="required">*</span></label>

                <div class="col-lg-8">
                    <input type="text" name="name"
                           value="<?php echo(isset($schoolinfo) ? $schoolinfo->name : set_value('name')) ?>"
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

