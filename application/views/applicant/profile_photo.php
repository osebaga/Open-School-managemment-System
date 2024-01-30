<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">
            <h5>Profile Picture</h5></div>
    </div>

    <div class="ibox-content">
        <div style="margin-bottom: 15px; color: green; font-weight: bold;">Uploaded Photo should be Passport size with blue background otherwise your application will be rejected</div>


        <?php echo form_open_multipart(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>


        <div class="form-group"><label class="col-lg-3 control-label">&nbsp;</label>

            <div class="col-lg-8">
                <img style="height: 130px; width: 130px;" src="<?php echo HTTP_PROFILE_IMG.$APPLICANT->photo;  ?>" >

            </div>
        </div>

        <?php if($APPLICANT->status == 0){ ?>

        <div class="form-group"><label class="col-lg-3 control-label">Change Photo <span class="required">*</span> : </label>

            <div class="col-lg-8">
                <input type="file" name="file1" class="form-control"/>
                <?php echo (form_error('file1') ? form_error('file1'):(isset($upload_error) ? '<div class="required">'.$upload_error.'</div>':''));

                ?>
            </div>
        </div>
       <input type="hidden" name="test" value="1"/>

        <div class="form-group" style="margin-top: 10px;">
            <div class="col-lg-offset-4 col-lg-6">
                <input class="btn btn-sm btn-success" type="submit" value="<?php echo (!is_section_used('PHOTO',$APPLICANT_MENU) ? 'Upload ' :'Edit '); ?> Picture"/>
            </div>
        </div>
        <?php if(is_section_used('EDUCATION',$APPLICANT_MENU)){ ?>
            <div style="text-align: right; margin-right: 30px;"><a href="<?php echo site_url('applicant_next_kin') ?>" class="btn btn-sm btn-success"><i class="fa fa-angle-double-right"></i> Next Step</a></div>
        <?php } ?>
        <?php }else{ ?>
            <script>
                disable_edit();
            </script>
        <?php } ?>
        <?php echo form_close();

        ?>



    </div>
</div>