<div class="col-lg-12 text-center">

    <?php
    if (isset($message)) {
        echo $message;
    } else if ($this->session->flashdata('message') != '') {
        echo $this->session->flashdata('message');
    }
    ?>
</div>

<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title"><h5>Reject application admission</h5></div>
    </div>
    <div class="ibox-content">

        <?php echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>
        <div class="form-group"><label class="col-lg-3 control-label">Form 4 index number : </label>

            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo set_value('regno'); ?>"
                       class="form-control " name="f4indexno">
                <?php echo form_error('f4indexno'); ?>
            </div>
        </div>

        <hr>

        <div class="form-group" style="margin-top: 10px;">
            <div class="col-lg-offset-4 col-lg-6">
                <input class="btn btn-sm btn-success" type="submit" value="Click to Confirm"/>
            </div>
        </div>
        <?php echo form_close(); ?>

    </div>
</div>


