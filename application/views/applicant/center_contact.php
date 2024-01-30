<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">
            <h5>Contact Information</h5></div>
    </div>

    <div class="ibox-content">

        <div style="margin-bottom: 15px; color: green; font-weight: bold;">Make sure the contact you provide here is valid and active.</div>

        <?php echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>

        <div class="form-group"><label class="col-lg-3 control-label">Mobile Number : <span class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" placeholder="Eg. 0xxxxxxxxx" value="<?php echo  set_value('mobile',str_replace('255','0',$APPLICANT->Mobile1)); ?>" class="form-control" name="mobile" onKeyPress="return numbersonly(event,this.value)" maxlength="10" >
                <?php echo form_error('mobile'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Mobile Number 2: </label>

            <div class="col-lg-8">
                <input type="text" placeholder="Eg. 0xxxxxxxxx" value="<?php echo  set_value('mobile2',str_replace('255','0',$APPLICANT->Mobile2)); ?>" class="form-control" name="mobile2" onKeyPress="return numbersonly(event,this.value)" maxlength="10">
                <?php echo form_error('mobile2'); ?>
            </div>
        </div>


        <div class="form-group"><label class="col-lg-3 control-label">Email :  <span class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" value="<?php echo  set_value('email',$APPLICANT->Email); ?>" class="form-control" name="email">
                <?php echo form_error('email'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">City :</label>
    <div class="col-lg-8">
        <input type="text" value="<?php echo  set_value('city',$APPLICANT->City); ?>" class="form-control" name="city">
        <?php echo form_error('city'); ?>
    </div>
    </div>

    <div class="form-group"><label class="col-lg-3 control-label">Town :</label>
    <div class="col-lg-8">
        <input type="text" value="<?php echo  set_value('town',$APPLICANT->Town); ?>" class="form-control" name="town">
        <?php echo form_error('town'); ?>
    </div>
    </div>

    <div class="form-group"><label class="col-lg-3 control-label">Village/Street :  <span class="required">*</span></label>
    <div class="col-lg-8">
        <input type="text" value="<?php echo  set_value('village',$APPLICANT->Village); ?>" class="form-control" name="village">
        <?php echo form_error('village'); ?>
    </div>
    </div>

    <div class="form-group"><label class="col-lg-3 control-label">Plot/House Number :  <span class="required">*</span></label>
    <div class="col-lg-8">
        <input type="text" value="<?php echo  set_value('housenumber',$APPLICANT->HouseNumber); ?>" class="form-control" name="housenumber">
        <?php echo form_error('housenumber'); ?>
    </div>
    </div>
        <div class="form-group"><label class="col-lg-3 control-label">Postal Address : </label>

            <div class="col-lg-8">
                <textarea class="form-control" name="postal"><?php echo  set_value('postal',$APPLICANT->postal); ?></textarea>
                <?php echo form_error('postal'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Physical Address : </label>

            <div class="col-lg-8">
                <textarea class="form-control" name="physical"><?php echo  set_value('physical',$APPLICANT->physical); ?></textarea>
                <?php echo form_error('physical'); ?>
            </div>
        </div>
        <?php if($APPLICANT->status == 0){ ?>
        <div class="form-group" style="margin-top: 10px;">
            <div class="col-lg-offset-4 col-lg-6">
                <input class="btn btn-sm btn-success" type="submit" value="<?php echo (!is_section_used('CONTACT',$APPLICANT_MENU) ? 'Save ' :'Edit '); ?>Information"/>
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