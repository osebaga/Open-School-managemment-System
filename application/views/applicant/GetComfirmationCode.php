<div class="col-lg-12 text-center">
<!--    <h1>Registration Process</h1>-->
    <?php
    // if (isset($message)) {
    //     echo $message;
    // } else if ($this->session->flashdata('message') != '') {
    //     echo $this->session->flashdata('message');
    // }
    ?>
</div>

<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title"><h5>Confirm application admission</h5></div>
    </div>
    <div class="ibox-content">

        <?php echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>
         <div class="form-group"><label class="col-lg-3 control-label">Mobile number : </label>

            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo($mobile)?$mobile: set_value('mobile'); ?>"
                       class="form-control " name="mobile" placeholder="Eg. 07xxxxxxxx">
                <?php echo form_error('mobile'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Email Address : </label>

            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo($email)? $email: set_value('email'); ?>"
                       class="form-control " name="email">
                <?php echo form_error('email'); ?>
            </div>
        </div>
        <hr>

        <div class="form-group" style="margin-top: 10px;">
            <div class="col-lg-offset-4 col-lg-6">
                <input class="btn btn-sm btn-success" type="submit" value="Confirm Admission"/>
            </div>
        </div>
        <?php echo form_close(); ?>

            </div>
        </div>
