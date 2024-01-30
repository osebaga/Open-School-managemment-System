<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Record Bank Transaction</h5>
    </div>
    <div class="ibox-content">

        <?php echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>


        <div class="form-group"><label class="col-lg-3 control-label">Receipt : <span
                    class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text"  value="<?php echo set_value('receipt'); ?>" class="form-control" name="receipt">
                <?php echo form_error('receipt'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Reference No : <span
                    class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text"  value="<?php echo set_value('reference'); ?>" class="form-control" name="reference">
                <?php echo form_error('reference'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Amount : <span
                    class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text"  value="<?php echo set_value('amount'); ?>" class="form-control" name="amount">
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