<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}

$has_access = has_role($MODULE_ID,'create_department',$GROUP_ID,'SETTINGS');
?>
<div class="ibox float-e-margins">
    <div class="ibox-title clearfix">
        <h5><?php
             if (is_null($id)) {
                echo 'Add New Subject';
            } else if (!is_null($id)) {
                echo 'Edit Subject Information';
            }
            ?></h5>
    </div>
    <div class="ibox-content">


        <?php


            echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>

           <!-- <div class="form-group"><label class="col-lg-3 control-label">Category : <span class="required">*</span></label>

                <div class="col-lg-8">
                    <select name="category" class="select2_search1 form-control " >
                        <option value="">[ Category ]</option>
                        <?php
/*                        $sel = (isset($subject_info) ? $subject_info->category : set_value('category'));
                        foreach($category_list as $key=>$value){ */?>
                            <option <?php /*echo ($sel == $value->id ? 'selected="selected"':''); */?> value="<?php /*echo $value->id; */?>"><?php /*echo $value->name */?></option>
                        <?php /*}
                        */?>
                    </select>
                    <?php /*echo form_error('category'); */?>
                </div>
            </div>-->



            <div class="form-group"><label class="col-lg-3 control-label">Subject Name : <span class="required">*</span></label>

                <div class="col-lg-8">
                    <input type="text" name="name"
                           value="<?php echo(isset($subject_info) ? $subject_info->name : set_value('name')) ?>"
                           class="form-control"/>
                    <?php echo form_error('name'); ?>
                </div>
            </div>

    <div class="form-group"><label class="col-lg-3 control-label">Short Name : <span class="required">*</span></label>

        <div class="col-lg-8">
            <input type="text" name="shortname"
                   value="<?php echo(isset($subject_info) ? $subject_info->shortname : set_value('shortname')) ?>"
                   class="form-control"/>
            <?php echo form_error('shortname'); ?>
        </div>
    </div>

        <div class="form-group"><label class="col-lg-3 control-label">Status : <span
                    class="required">*</span></label>

            <div class="col-lg-8">
                <?php $sel = (isset($subject_info) ?  $subject_info->status:-1); ?>
                <label class="radio-inline"><input type="radio" <?php echo ($sel == 1 ? 'checked="checked"':($sel == -1 ? 'checked="checked"':'')); ?> name="status" class="radio-inline" value="1"/> Active</label>
                <label class="radio-inline"><input type="radio" <?php echo ($sel === 0 ? 'checked="checked"':''); ?> name="status" class="radio-inline" value="0"/> Inactive</label>
                <?php echo form_error('status'); ?>
            </div>
        </div>


            <div class="form-group">
                <div class="col-lg-offset-3 col-lg-8">
                    <input class="btn btn-sm btn-success" type="submit" value="Save Information"/>
                </div>
            </div>
            <?php echo form_close(); ?>


    </div>
</div>
