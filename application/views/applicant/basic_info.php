<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">
            <h5>Person Particular</h5></div>
    </div>

    <div class="ibox-content">

        <?php  echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>


        <div class="form-group"><label class="col-lg-3 control-label">Application Programme  : <span class="required">*</span></label>

            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo application_programme($APPLICANT->application_type); ?>"
                       class="form-control" disabled="disabled"/>
            </div>
        </div>

        
        <div class="form-group"><label class="col-lg-3 control-label">Entry Qualification  : <span class="required">*</span></label>

            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo application_type($APPLICANT->entry_category); ?>"
                       class="form-control" disabled="disabled"/>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">First Name : <span
                    class="required">*</span></label>

            <div class="col-lg-7">
                <input type="text" value="<?php echo set_value('firstname',$APPLICANT->FirstName); ?>"
                       class="form-control" name="firstname">
                <?php echo form_error('firstname'); ?>
            </div>
        </div>


        <div class="form-group"><label class="col-lg-3 control-label">Last Name : <span
                    class="required ">*</span></label>

            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo set_value('lastname',$APPLICANT->LastName); ?>"
                       class="form-control " name="lastname">
                <?php echo form_error('lastname'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Other Names : </label>

            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo set_value('middlename',$APPLICANT->MiddleName); ?>"
                       class="form-control " name="middlename">
                <?php echo form_error('middlename'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Gender : <span
                    class="required">*</span></label>

            <div class="col-lg-7">
                <select name="gender" class="form-control">
                    <option value=""> [ Select Gender ]</option>
                    <?php
                    $sel =  set_value('gender',$APPLICANT->Gender);
                    foreach ($gender_list as $key => $value) {
                        ?>
                        <option <?php echo($sel == $value->code ? 'selected="selected"' : ''); ?>
                            value="<?php echo $value->code; ?>"><?php echo $value->name; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php echo form_error('gender'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Birth Date : <span
                    class="required ">*</span></label>

            <div class="col-lg-7">
                <input type="text" placeholder="DD-MM-YYYY"
                       value="<?php echo  set_value('dob',format_date($APPLICANT->dob,false)); ?>"
                       class="form-control  mydate_input" name="dob">
                <?php echo form_error('dob'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Place of Birth : <span
                        class="required ">*</span> </label>

            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo set_value('birth_place',$APPLICANT->birth_place); ?>"
                       class="form-control" name="birth_place">
                <?php echo form_error('birth_place'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Marital Status : <span
                        class="required ">*</span></label>

            <div class="col-lg-7">
                <select name="marital_status" class="form-control ">
                    <option value=""> [ Select Marital Status ]</option>
                    <?php
                    $sel =  set_value('nationality',$APPLICANT->marital_status);
                    foreach ($marital_status_list as $key => $value) {
                        ?>
                        <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php echo form_error('marital_status'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Country of Residence : <span
                        class="required ">*</span></label>

            <div class="col-lg-7">
                <select name="residence_country" class="form-control select50">
                    <option value=""> [ Select Country ]</option>
                    <?php
                    $sel =  set_value('residence_country',$APPLICANT->residence_country);
                    foreach ($nationality_list as $key => $value) {
                        ?>
                        <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                value="<?php echo $value->id; ?>"><?php echo $value->Country; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php echo form_error('residence_country'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Nationality : <span
                    class="required ">*</span></label>

            <div class="col-lg-7">
                <select name="nationality" class="form-control select51 ">
                    <option value=""> [ Select Nationality ]</option>
                    <?php
                    $sel =  set_value('nationality',$APPLICANT->Nationality);
                    foreach ($nationality_list as $key => $value) {
                        ?>
                        <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                            value="<?php echo $value->id; ?>"><?php echo $value->Name; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php echo form_error('nationality'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Disability : <span
                    class="required ">*</span></label>

            <div class="col-lg-7">
                <select name="disability" class="form-control ">
                    <option value=""> [ Select Disability ]</option>
                    <?php
                    $sel =  set_value('disability',$APPLICANT->Disability);
                    foreach ($disability_list as $key => $value) {
                        ?>
                        <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                            value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php echo form_error('disability'); ?>
            </div>
        </div>



 <?php if($APPLICANT->status == 0){ ?>
        <div class="form-group" style="margin-top: 10px;">
            <div class="col-lg-offset-4 col-lg-6">
                <input class="btn btn-sm btn-success" type="submit" value="Save Information"/>
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

<script>
    $(document).ready(function () {
        $(".select50").select2({
            theme:'bootstrap',
            placeholder:'[ Select Country ]',
            allowClear:true
        });
        $(".select51").select2({
            theme:'bootstrap',
            placeholder:'[ Select Nationality ]',
            allowClear:true
        });
    });
</script>