<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">
            <h5>Sponsor & Current Employer Information</h5></div>
    </div>

    <div class="ibox-content">


        <?php echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>

        <div style=" color: brown; font-weight: bold; border-bottom: 1px solid brown; margin-bottom: 10px;">
            Sponsor Information
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Sponsor Name: <span
                    class="required disabledata">*</span> </label>

            <div class="col-lg-8">
                <input type="text" value="<?php echo (isset($sponsor_info) ? $sponsor_info->name:set_value('name')); ?>" class="form-control" name="name">
                <?php echo form_error('name'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Mobile Number1 : <span
                    class="required disabledata">*</span> </label>

            <div class="col-lg-8">
                <input type="text" placeholder="Eg. 0xxxxxxxxx" value="<?php echo (isset($sponsor_info) ? $sponsor_info->mobile1:set_value('mobile1')); ?>" class="form-control" name="mobile1">
                <?php echo form_error('mobile1'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Mobile Number2 :  </label>

            <div class="col-lg-8">
                <input type="text" placeholder="Eg. 0xxxxxxxxx" value="<?php echo (isset($sponsor_info) ? $sponsor_info->mobile2:set_value('mobile2')); ?>" class="form-control" name="mobile2">
                <?php echo form_error('mobile2'); ?>
            </div>
        </div>


        <div class="form-group"><label class="col-lg-3 control-label">Email :<span
                    class="required disabledata">*</span>  </label>

            <div class="col-lg-8">
                <input type="text" value="<?php echo (isset($sponsor_info) ? $sponsor_info->email:set_value('email')); ?>" class="form-control" name="email">
                <?php echo form_error('email'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Address : <span
                    class="required disabledata">*</span></label>

            <div class="col-lg-8">
                <textarea class="form-control" name="address"><?php echo (isset($sponsor_info) ? $sponsor_info->address:set_value('address')); ?></textarea>
                <?php echo form_error('address'); ?>
            </div>
        </div>



        <div style=" color: brown; font-weight: bold; border-bottom: 1px solid brown; margin-bottom: 10px;">
           Current Employer Information
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Employer Name: <span
                    class="required disabledata">*</span> </label>

            <div class="col-lg-8">
                <input type="text" value="<?php echo (isset($employer_info) ? $employer_info->name:set_value('name2')); ?>" class="form-control" name="name2">
                <?php echo form_error('name2'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Mobile Number1 :<span
                    class="required disabledata">*</span>  </label>

            <div class="col-lg-8">
                <input type="text" placeholder="Eg. 255xxxxxxxxx" value="<?php echo (isset($employer_info) ? $employer_info->mobile1:set_value('mobile21')); ?>" class="form-control" name="mobile21">
                <?php echo form_error('mobile21'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Mobile Number2 :  </label>

            <div class="col-lg-8">
                <input type="text" placeholder="Eg. 255xxxxxxxxx" value="<?php echo (isset($employer_info) ? $employer_info->mobile2:set_value('mobile22')); ?>" class="form-control" name="mobile22">
                <?php echo form_error('mobile22'); ?>
            </div>
        </div>


        <div class="form-group"><label class="col-lg-3 control-label">Email : <span
                    class="required disabledata">*</span> </label>

            <div class="col-lg-8">
                <input type="text" value="<?php echo (isset($employer_info) ? $employer_info->email:set_value('email2')); ?>" class="form-control" name="email2">
                <?php echo form_error('email2'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Address : <span
                    class="required disabledata">*</span></label>

            <div class="col-lg-8">
                <textarea class="form-control" name="address2"><?php echo (isset($employer_info) ? $employer_info->address:set_value('address2')); ?></textarea>
                <?php echo form_error('address2'); ?>
            </div>
        </div>


        <?php if($APPLICANT->status == 0){ ?>

            <div class="form-group" style="margin-top: 10px;">
                <div class="col-lg-offset-4 col-lg-6">
                    <input class="btn btn-sm btn-success" type="submit" value="<?php echo (!is_section_used('SPONSOR',$APPLICANT_MENU) ? 'Save ' :'Edit '); ?>Information"/>
                </div>
            </div>

        <?php }else{ ?>
            <script>
                disable_edit();
            </script>
        <?php } ?>



        <?php echo form_close(); ?>




    </div>

</div>