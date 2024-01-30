<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><?php echo (isset($id) ? 'Edit User Information':'Receive application payments'); ?></h5>
        <!-- <a class="btn btn-sm btn-small btn-warning pull-right"
           href="<?php// echo site_url('view_recorded_data') ?>">
            <strong>View Recorded informations</strong>
        </a> -->
    </div>
    <div class="ibox-content">

        <?php echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>
        <div class="form-group"><label class="col-lg-3 control-label">Reference No : <span
                    class="required">*</span></label>

            <div class="col-lg-4">
                <input type="text" class="form-control" name="reference">
                <?php echo form_error('reference'); ?>
            </div>
        </div>

        <!-- <div class="form-group"><label class="col-lg-3 control-label">Payment Type : <span class="required">*</span></label>
            <div class="col-lg-4">
                <select class="form-control" name="payment_type">
                    <option value=""> [ Select Centre ]</option>
                    <option value="Cash">Cash</option>
                </select>
                <?php// echo form_error('payment_type'); ?>
            </div>
        </div> -->


        <div class="form-group"><label class="col-lg-3 control-label">Amount : <span
                    class="required">*</span></label>

            <div class="col-lg-4">
                <input type="text" class="form-control" name="amount">
                <?php echo form_error('amount'); ?>
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
