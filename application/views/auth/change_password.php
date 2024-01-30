<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Change Password</h5>
    </div>
    <div class="ibox-content">

        <?php echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>
        <div class="form-group"><label class="col-lg-3 control-label">Old Password : <span
                    class="required">*</span></label>

            <div class="col-lg-8">
                <input type="password" class="form-control" name="old">
                <?php echo form_error('old'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">New Password : <span
                    class="required">*</span></label>

            <div class="col-lg-8">
                <input type="password" class="form-control" name="new">
                <?php echo form_error('new'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Confirm Password : <span class="required">*</span></label>

            <div class="col-lg-8">
                <input type="password" class="form-control" name="new_confirm">
                <?php echo form_error('new_confirm'); ?>
            </div>
        </div>


        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-8">
                <input class="btn btn-sm btn-success" type="submit" value="Change Password"/>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>