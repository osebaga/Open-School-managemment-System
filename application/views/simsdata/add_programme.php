<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><?php echo (isset($id) ? 'Edit User Information':'Add New Programme'); ?></h5>
    </div>
    <div class="ibox-content">

        <?php echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>


        <div class="form-group" id="department"><label class="col-lg-3 control-label">Department : <span
                    class="required">*</span></label>

            <div class="col-lg-8">
                <select name="department" class="form-control">
                    <option value=""> [ Select Department ]</option>
                    <?php
                    $sel = (isset($programme_info) ? $programme_info->Departmentid: set_value('department'));
                    foreach($department_list as $key=>$value){
                        ?>
                    <option <?php echo ($sel == $value->id ? 'selected="selected"':''); ?>
                        value="<?php echo $value->id; ?>"><?php echo $value->Name; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <?php
                echo form_error('department');
                ?>

            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Code : <span class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" <?php echo (isset($programme_info) ? 'disabled="disabled"':'');?>
                    value="<?php echo (isset($programme_info) ? $programme_info->Code:set_value('code')); ?>"
                    class="form-control" name="code">
                <?php echo form_error('code'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Name : <span class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text"
                    value="<?php echo (isset($programme_info) ? $programme_info->Name:set_value('name')); ?>"
                    class="form-control" name="name">
                <?php echo form_error('name'); ?>
            </div>
        </div>
        <div class="form-group" id="department"><label class="col-lg-3 control-label">Category : <span
                    class="required">*</span></label>

            <div class="col-lg-8">
                <select name="cat" class="form-control">
                    <option value=""> [ Select Category ]</option>
                    <?php
                    $sel = (isset($programme_info) ? $programme_info->type: set_value('cat'));
                    foreach(application_type() as $key=>$value){
                        ?>
                    <option <?php echo ($sel == $key ? 'selected="selected"':''); ?> value="<?php echo $key; ?>">
                        <?php echo $value; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <?php
                echo form_error('cat');
                ?>

            </div>
        </div>
        <?php  $campus=json_decode($programme_info->campus_id,true); ?>
        <div class="form-group" id="campus"><label class="col-lg-3 control-label">Center : <span
                    class="required">*</span></label>
            <div class="col-lg-8">
                <select name="campus[]" id="cam" multiple class="form-control campus">
                    <option value=""> [ Center ]</option>
                    <?php
                    
        foreach($campuses as $key=>$value){
            ?>
                    <option <?php echo (in_array($value->CenterName,$campus) ? 'selected="selected"':''); ?>
                        value="<?php echo $value->CenterRegNo; ?>"><?php echo $value->CenterName; ?></option>
                    <?php
        }
        ?>
                </select>
                <?php
    echo form_error('campus');
    ?>

            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Active ? : <span class="required">*</span></label>
            <?php
            $sel = (isset($programme_info) ? $programme_info->active: set_value('active',1));
            ?>
            <div class="col-lg-8">
                <input class="radio-inline" type="radio" <?php echo ($sel == 1 ? 'checked="checked"':''); ?>
                    name="active" value="1">Yes
                <input class="radio-inline" type="radio" <?php echo ($sel == 0 ? 'checked="checked"':''); ?>
                    name="active" value="0"> No
                <?php
                echo form_error('active');
                ?>

            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-8">
                <input class="btn btn-sm btn-success" type="submit" value="Save Information" />
            </div>
        </div>
        <?php echo form_close(); ?>

    </div>
</div>
<script>
    $(document).ready(function () {
        $(".select34").select2({
            theme: 'bootstrap',
            placeholder: '[ Select Subject ]',
            allowClear: true
        });

        $(".campus").select2({
            theme: 'bootstrap',
            placeholder: '[ Select Center ]',
            allowClear: true
        });
    })
</script>