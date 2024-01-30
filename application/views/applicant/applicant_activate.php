<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">
            <h5>Account Verification</h5>
        </div>
    </div>

    <div class="ibox-content">

        <div style="margin-bottom: 15px; color: green; font-weight: bold;">Enter 6 digit you have received in  SMS or Email. </div>

        <?php
        if(!is_section_used('ACTIVATE', $APPLICANT_MENU)) {
            echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>

            <div class="form-group"><label class="col-lg-3 control-label">Code : <span class="required">*</span></label>

                <div class="col-lg-8">
                    <input type="text" value="<?php echo set_value('code'); ?>" class="form-control" name="code">
                    <div style="text-align: right;"><a style="font-size: 11px; text-decoration: underline;" href="<?php echo site_url('applicant_activate/?resend=1'); ?>">Resend Code by Email</a></div>

                    <?php echo form_error('code'); ?>
                </div>
            </div>


        <?php if ($APPLICANT->status == 0){ ?>
            <div class="form-group" style="margin-top: 10px;">
                <div class="col-lg-offset-4 col-lg-6">
                    <input class="btn btn-sm btn-success" type="submit"
                           value="<?php echo(!is_section_used('ACTIVATE', $APPLICANT_MENU) ? 'Verify ' : 'Verify '); ?>Account"/>
                </div>
            </div>
        <?php }else{ ?>
            <script>
                disable_edit();
            </script>
        <?php } ?>

            <?php echo form_close();

        }else {
echo show_alert('Account Verified !!','info');

        }?>


<div style="text-align: right; margin-right: 30px;"><a href="<?php echo site_url('applicant_payment') ?>" class="btn btn-sm btn-success">Click to continue</i></a></div>


    </div>
</div>