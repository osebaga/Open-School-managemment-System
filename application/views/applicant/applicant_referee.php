<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">
            <h5>Academic Referee Information</h5></div>
    </div>

    <div class="ibox-content">
        <div style="margin-bottom: 15px; color: green; font-weight: bold;">Please provide valid and active email for referees. Email will be sent to referees for recommendations.</div>


        <?php echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>

        <div style=" color: brown; font-weight: bold; border-bottom: 1px solid brown; margin-bottom: 10px;">
           ACADEMIC REFEREE 1
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Name: <span
                    class="required disabledata">*</span> </label>

            <div class="col-lg-8">
                <input type="text" value="<?php echo (isset($next_kin) ? $next_kin[0]->name:set_value('name')); ?>" class="form-control" name="name">
                <?php echo form_error('name'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Mobile Number1 : <span
                    class="required disabledata">*</span> </label>

            <div class="col-lg-8">
                <input type="text" placeholder="Eg. 0xxxxxxxxx" value="<?php echo (isset($next_kin) ? $next_kin[0]->mobile1:set_value('mobile1')); ?>" class="form-control" name="mobile1" onKeyPress="return numbersonly(event,this.value)" maxlength="10">
                <?php echo form_error('mobile1'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Mobile Number2 :  </label>

            <div class="col-lg-8">
                <input type="text" placeholder="Eg. 0xxxxxxxxx" value="<?php echo (isset($next_kin) ? $next_kin[0]->mobile2:set_value('mobile2')); ?>" class="form-control" name="mobile2" onKeyPress="return numbersonly(event,this.value)" maxlength="10">
                <?php echo form_error('mobile2'); ?>
            </div>
        </div>


        <div class="form-group"><label class="col-lg-3 control-label">Email :<span
                    class="required disabledata">*</span>  </label>

            <div class="col-lg-8">
                <input type="text" value="<?php echo (isset($next_kin) ? $next_kin[0]->email:set_value('email')); ?>" class="form-control" name="email">
                <?php echo form_error('email'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Organization : <span
                        class="required disabledata">*</span></label>

            <div class="col-lg-8">
                <input class="form-control" name="organization" value="<?php echo (isset($next_kin) ? $next_kin[0]->organization:set_value('organization')); ?>"/>
                <?php echo form_error('organization'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Position : <span
                        class="required disabledata">*</span></label>

            <div class="col-lg-8">
                <input class="form-control" name="position" value="<?php echo (isset($next_kin) ? $next_kin[0]->position:set_value('position')); ?>"/>
                <?php echo form_error('position'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Address : <span
                    class="required disabledata">*</span></label>

            <div class="col-lg-8">
                <textarea class="form-control" name="address"><?php echo (isset($next_kin) ? $next_kin[0]->address:set_value('address')); ?></textarea>
                <?php if(isset($next_kin) && $APPLICANT->status == 0 && $next_kin[0]->rec_code <> '' && !is_null($next_kin[0]->rec_code) ){?>
                    <div style="text-align: right; "><a style="font-size: 11px; font-weight: bold; text-decoration: underline;" href="<?php echo site_url('applicant_referee/?resend=1&id='.$next_kin[0]->id); ?>">Resend Email ?</a></div>
                <?php } ?>
                <?php echo form_error('address'); ?>
            </div>
        </div>



        <div style=" color: brown; font-weight: bold; border-bottom: 1px solid brown; margin-bottom: 10px;">
            ACADEMIC REFEREE 2
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Name: <span
                    class="required disabledata">*</span> </label>

            <div class="col-lg-8">
                <input type="text" value="<?php echo (isset($next_kin) ? $next_kin[1]->name:set_value('name2')); ?>" class="form-control" name="name2">
                <?php echo form_error('name2'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Mobile Number1 :<span
                    class="required disabledata">*</span>  </label>

            <div class="col-lg-8">
                <input type="text" placeholder="Eg. 0xxxxxxxxx" value="<?php echo (isset($next_kin) ? $next_kin[1]->mobile1:set_value('mobile21')); ?>" class="form-control" name="mobile21" onKeyPress="return numbersonly(event,this.value)" maxlength="10">
                <?php echo form_error('mobile21'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Mobile Number2 :  </label>

            <div class="col-lg-8">
                <input type="text" placeholder="Eg. 0xxxxxxxxx" value="<?php echo (isset($next_kin) ? $next_kin[1]->mobile2:set_value('mobile22')); ?>" class="form-control" name="mobile22" onKeyPress="return numbersonly(event,this.value)" maxlength="10">
                <?php echo form_error('mobile22'); ?>
            </div>
        </div>


        <div class="form-group"><label class="col-lg-3 control-label">Email : <span
                    class="required disabledata">*</span> </label>

            <div class="col-lg-8">
                <input type="text" value="<?php echo (isset($next_kin) ? $next_kin[1]->email:set_value('email2')); ?>" class="form-control" name="email2">
                <?php echo form_error('email2'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Organization : <span
                        class="required disabledata">*</span></label>

            <div class="col-lg-8">
                <input class="form-control" name="organization2" value="<?php echo (isset($next_kin) ? $next_kin[1]->organization:set_value('organization2')); ?>"/>
                <?php echo form_error('organization2'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Position : <span
                        class="required disabledata">*</span></label>

            <div class="col-lg-8">
                <input class="form-control" name="position2" value="<?php echo (isset($next_kin) ? $next_kin[1]->position:set_value('position2')); ?>"/>
                <?php echo form_error('position2'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Address : <span
                    class="required disabledata">*</span></label>

            <div class="col-lg-8">
                <textarea class="form-control" name="address2"><?php echo (isset($next_kin) ? $next_kin[1]->address:set_value('address2')); ?></textarea>
                <?php if(isset($next_kin) && $APPLICANT->status == 0 && $next_kin[1]->rec_code <> '' && !is_null($next_kin[1]->rec_code) ){?>
                    <div style="text-align: right; "><a style="font-size: 11px; font-weight: bold; text-decoration: underline;" href="<?php echo site_url('applicant_referee/?resend=1&id='.$next_kin[1]->id); ?>">Resend Email ?</a></div>
                <?php } ?>
                <?php echo form_error('address2'); ?>
            </div>
        </div>



        <?php if($APPLICANT->status == 0){ ?>

            <div class="form-group" style="margin-top: 10px;">
                <div class="col-lg-offset-4 col-lg-6">
                    <input class="btn btn-sm btn-success" type="submit" value="<?php echo (!is_section_used('REFEREE',$APPLICANT_MENU) ? 'Save ' :'Edit '); ?>Information"/>
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